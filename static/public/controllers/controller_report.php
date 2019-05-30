<?php
require_once('static/public/models/model_oldreports.php');

class Controller_Report extends Controller
{

    function __construct()
    {
        $this->model = new ModelOldreports();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_bonus_miles_hist();
        $this->view->render('report_view.php', 'base_view.php', $data);
    }

    function action()
    {
        parent::action(); // TODO: Change the autogenerated stub
    }

    function action_airport_rating() {
        $is_call = 'is_rating_exist'; // TODO add sql variables
        $data = -1;
        if (((int)$_GET['var1']) && ((int)$_GET['var3'])) {
            $sha_str = $_GET['var2'].'-'.$_GET['var1'].'-01 00:00:00'.$_GET['var4'].'-'.$_GET['var3'].'-01 00:00:00';
            $sha_res = sha1($sha_str);
            $check_sql = 'SELECT * FROM airport_rating WHERE hash_group=\''.$sha_res.'\';'; // TODO: исправить на переменные sql
            $user_data = [$_GET['var2'].'-'.$_GET['var1'].'-01 00:00:00',
                          $_GET['var4'].'-'.$_GET['var3'].'-01 00:00:00'];
            $sql = 'CALL get_airport_rating(?, ?)';
            $data = DataBase::procedureCallWithParam($sql, $check_sql, $user_data);
        }
        $this->view->render('status_view.php', 'base_view.php', $data);
    }
}
