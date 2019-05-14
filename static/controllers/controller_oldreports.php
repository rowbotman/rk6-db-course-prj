<?php
require_once('static/models/model_report.php');
class Controller_OldReports extends Controller {
    public function __construct()
    {
        $this->model = new ModelReport();
        $this->view = new View();
    }

    public function action_index ()
    {
        $data = $this->model->get_data();
        $this->view->render('old_reports_view.php', 'base_view.php', $data);
    }

}
