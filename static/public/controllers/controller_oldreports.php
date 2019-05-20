<?php
require_once('static/public/models/model_report.php');

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
        $sql = 'SELECT r.airport, r.tickets_out, r.tickets_in, r.tickets_out + r.tickets_in AS sum FROM airport_rating r
WHERE r.hash_group = ? ORDER BY sum DESC, r.tickets_in DESC, r.tickets_out DESC;';
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
