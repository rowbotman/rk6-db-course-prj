<?php
class Controller_Menu extends Controller {
    function action_index() {
        $this->view->render('menu_view.php', 'base_view.php');
    }
}
