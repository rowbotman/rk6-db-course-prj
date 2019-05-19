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
        $data = $this->model->get_old_reports();
        $this->view->render('report_view.php', 'base_view.php', $data);
    }

    public function action_airport_rating()
    {
        $sql = 'select r.airport, r.tickets_out, r.tickets_in, r.tickets_out + r.tickets_in as sum from airport_rating r
where r.hash_group = ? order by sum desc, r.tickets_in desc, r.tickets_out desc;';
        $data = [['' => 'Empty set']];
        if ($_GET['var1'] && $_GET['var2']) {
            $sha_str = $_GET['var1'] . ' 00:00:00' . $_GET['var2'] . ' 00:00:00';
            $user_data = sha1($sha_str);
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
}
