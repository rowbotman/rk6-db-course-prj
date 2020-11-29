<?php
require_once('models/model_oldreports.php');

class Controller_OldReports extends Controller {
    static private $limit = 10;

    /**
     * Controller_OldReports constructor.
     */
    public function __construct()
    {
        $this->model = new ModelOldreports(10, 0);
        $this->view = new View();
    }

    public function action_index ()
    {
        $data = $this->model->get_old_reports();
        $this->view->render('report_view.php', 'base_view.php', $data);
    }

    public function action_airport_rating()
    {
        $sql = 'SELECT COUNT(*) AS count FROM airport_rating r WHERE r.hash_group = ?';
        $data = [['' => 'Empty set']];
        $pages = array(array('count'=> array(0)));
        if ($_GET['var1'] && $_GET['var2']) {
            $sha_str = $_GET['var1'] . ' 00:00:00' . $_GET['var2'] . ' 00:00:00';
            $user_data = sha1($sha_str);
            $data = $this->model->get_airport_rating();
            $pages = DataBase::paramQuery($sql, $user_data);
            if (!$pages[0]['count']) {
                $pages[0]['count'] = 0;
            }
        }
        $this->view->render('new_report_view.php', 'base_view.php',
            ['pages' => ceil($pages[0]['count'] / self::$limit), 'data' => $data]);
    }
}
