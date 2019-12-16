<?php
require_once('static/public/models/model_user.php');

class Controller_Auth extends Controller
{
    public function __construct()
    {
        Controller::__construct();
        $this->view = new View();
    }

    public function action_index()
    {
        if (isset($_GET['logout'])) {
            session_destroy();
            ModelUser::destroy_session($_COOKIE['auth']);
            setcookie('auth', '', time() - 3600);
            header('Location: http://coursacheit.com');
            return;
        }
        $this->view->render('login_view.php', 'base_view.php');
    }

    public function action_login()
    {
        $user = null;
        if (isset($_POST['login']) and isset($_POST['pass'])) {
            $user_model = new ModelUser($_POST['login'], $_POST['pass']);
            $user = $user_model->get_instance();
            echo $user['name'];
        }
        if ($user == null) {
            $this->view->render('login_view.php', 'base_view.php', ['validate' => true]);
        } else {
            if (!isset($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60) {
                session_start();
                $_SESSION['last_access'] = time();
                $_SESSION['security_check'] = 1;
                $_SESSION['user_id'] = $user['uid'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                $hash = md5($user['hash'] . $_SERVER['HTTP_USER_AGENT']);
                setcookie('auth', $hash, time() + 2 * 24 * 60 * 60, '/');
                echo 'here';
                $sql_statement = 'INSERT INTO `sessions`(uid, user_agent, ip, hash, created) VALUES (?, ?, ?, ?, ?);';
                DataBase::insertQuery($sql_statement, [
                    $user['uid'],
                    html_escape($_SERVER['HTTP_USER_AGENT']),
                    ip2long($_SERVER['REMOTE_ADDR']),
                    $hash,
                    date("Y-m-d h:i:s")]);
                echo $user['uid'].' '.$_SERVER['HTTP_USER_AGENT'].' '.ip2long($_SERVER['REMOTE_ADDR']).' '.$hash.' '.date("Y-m-d h:i:s");
            }
            header('Location: http://coursacheit.com');
        }
    }
}
