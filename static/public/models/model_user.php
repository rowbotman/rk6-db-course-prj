<?php
require_once ('static/public/security.php');

class ModelUser extends Model
{
    private static $user;
    private static $salt = 'salt';
    private static $hash = '';

    public function __construct($login = '', $pass = '')
    {
        if ($pass == '') {
            self::$hash = $login;
        } else {
            echo $login . self::$salt . $pass;
            self::$hash = sha1($login . self::$salt . $pass);
            echo self::$hash;
        }
    }

    public function get_instance()
    {
        $sql_statement = 'SELECT uid, firstName, role, pass FROM profile WHERE pass = ? ;';
        echo $sql_statement . self::$hash;
        $data = DataBase::getRow($sql_statement, self::$hash);
        if ($data) {
            self::$user = array(
                'name' => $data['firstName'],
                'role' => $data['role'],
                'uid' => $data['uid'],
                'hash' => $data['pass']);
        } else {
            self::$user = null;
        }
        return self::$user;
    }

    public function login($login, $pass)
    {
        // TODO: check is user auth earlier
        $hash = sha1($login . self::$salt . $pass);
        $sql_statement = 'SELECT firstName, role, pass FROM profile WHERE pass = ? ;';
        $data = DataBase::getRow($sql_statement, $hash);
        if ($data) {
            self::$user = array(
                'name' => $data['firstName'],
                'role' => $data['role'],
                'hash' => $data['pass']);
        }
    }

    private function __html_escape($html_escape)
    {
        $html_escape = htmlspecialchars($html_escape, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return $html_escape;
    }

    public function validate_session($hash)
    {
        $sql_statement = 'SELECT firstName, role FROM profile WHERE pass = ? ;';
        $data = DataBase::getRow($sql_statement, $hash);
    }

    public function user_by_session($session_hash)
    {
        $sql_statement = 'SELECT uid FROM sessions WHERE hash = ? ;';
        echo $sql_statement . $session_hash;
        $data = DataBase::getRow($sql_statement, $session_hash);
        if ($data) {
            $sql_statement = 'SELECT uid, firstName, role, pass FROM profile WHERE uid = ? ;';
            $data = DataBase::getRow($sql_statement, $data['uid']);
            self::$user = array(
                'name' => $data['firstName'],
                'role' => $data['role'],
                'uid' => $data['uid'],
                'hash' => $data['pass']);
        } else {
            self::$user = null;
        }
        return self::$user;
    }

    public static function destroy_session($session_hash)
    {
        DataBase::insertQuery('DELETE FROM sessions WHERE hash = ?', [$session_hash]);
    }

    public static function security()
    {
        if (isset($_SESSION['security_check'])) {
            if ($_SESSION['security_check'] == 0) {
                $user_id = $_SESSION['user_id'];
                $sql_statement = 'SELECT COUNT(*) FROM sessions
                    WHERE uid = ? AND ip = ? AND user_agent = ? AND hash = ? ;';
                $user_data = [
                    $user_id, ip2long($_SERVER['REMOTE_ADDR']),
                    html_escape($_SERVER['HTTP_USER_AGENT']),
                    preg_replace('/[^0-9a-f]/', '', $_COOKIE['auth'])
                ];

                // TODO: check it
                $n = (int)DataBase::getRow($sql_statement, $user_data);

                if ($n == 0) {
                    header("Location: /auth/login?act=logout");
                    exit();
                } else {
                    $_SESSION['security_check'] = 1;
                }
            }
        } else {
            header("Location: /auth?login=true");
            exit();
        }
    }
}
