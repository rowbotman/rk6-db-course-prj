<?php
require_once ('static/public/models/model_user.php');

class Controller_Menu extends Controller {
    function action_index() {
        $hash = '';
        $user = new ModelUser($hash);
        if (isset($_COOKIE['hash'])) {
        }
        $user->validate_session($hash);
        $this->view->render('main_menu_view.php', 'base_view.php');
    }
}
