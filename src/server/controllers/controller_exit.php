<?php
class Controller_Exit extends Controller
{
    function __construct()
    {
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->render('exit_view.php', 'base_view.php', null);
    }
}
