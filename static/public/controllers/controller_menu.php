<?php
require_once('static/public/models/model_user.php');

class Controller_Menu extends Controller
{
    function action_index()
    {
        ModelUser::security();
        $user = null;
        $auth = false;
        if (isset($_COOKIE['auth'])) {
            echo 'auth here';
            $user_model = new ModelUser($_COOKIE['auth']);
            $user = $user_model->user_by_session($_COOKIE['auth']);
            if ($user_model != null) {
                $auth = true;
            }

//            $user->validate_session($_COOKIE['auth']);
        }
        $this->view->render('main_menu_view.php', 'base_view.php', ['auth' => $auth, 'user' => $user]);
    }
}
