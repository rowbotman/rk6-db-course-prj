<?php
require_once('static/public/models/model_user.php');

class Controller_Analytics extends Controller
{
    function action_index()
    {
        ModelUser::security();
        $this->view->render('menu_view.php', 'base_view.php');
    }

}