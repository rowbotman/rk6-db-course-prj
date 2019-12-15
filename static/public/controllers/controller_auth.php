<?php
require_once ('static/public/models/model_user.php');

class Controller_Auth extends Controller
{
    public function __construct()
    {
        Controller::__construct();
        $this->view = new View();
    }
    public function action_index ()
    {
        $this->view->render('login_view.php', 'base_view.php');
    }

    public function action_login() {
        $user = null;
        if (isset($_POST['login']) and isset($_POST['pass'])) {
            $user_model = new ModelUser($_POST['login'], $_POST['pass']);
            $user = $user_model->get_instance();
        }
        if ($user == null) {
            $this->view->render('login_view.php', 'base_view.php', ['validate' => true]);
        } else {
            header('Location: http://coursacheit.com');
        }
    }
}
