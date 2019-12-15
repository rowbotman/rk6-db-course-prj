<?php

class ModelUser extends Model
{
    private static $user;
    private static $salt = 'salt';
    private static $hash = '';
    public function __construct($login = '', $pass = '')
    {
        self::$hash = sha1($login . self::$salt . $pass);
    }

    public function get_instance() {
        $sql_statement = 'SELECT firstName, role FROM profile WHERE pass = ? ;';
        $data = DataBase::getRow($sql_statement, self::$hash);
        if ($data) {
            self::$user = array(
                'name' => $data['name'],
                'role' => $data['role'],
                'hash' => sha1($data['hash']));
        } else {
            self::$user = null;
        }
        return self::$user;
    }

    public function login($login, $pass)
    {
        // TODO: check is user auth earlier
        $hash = sha1($login . self::$salt . $pass);
        $sql_statement = 'SELECT firstName, role FROM profile WHERE pass = ? ;';
        $data = DataBase::getRow($sql_statement, $hash);
        if ($data) {
            self::$user = array(
                'name' => $data['name'],
                'role' => $data['role'],
                'hash' => sha1($data['hash']));
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

    public static function security()
    {
        if ($_SESSION['security_check'] == 0) {
            $user_id = $_SESSION['user_id'];
            $sql_statement = 'SELECT COUNT(*) FROM sessions
                    WHERE uid = ? AND ip = ? AND user_agent = ? AND hash = ? ;';
            $user_data = [
                $user_id, $_SERVER['REMOTE_ADDR'],
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
    }
}
