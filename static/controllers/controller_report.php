<?php
class Controller_Report extends Controller
{

    function __construct()
    {
        $this->model = new ModelReport();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->action();
        $this->view->render('report_view.php', 'base_view.php', $data);
    }
}
