<?php
require_once('static/models/model_report.php');
class Controller_Search extends Controller
{
    function __construct()
    {

        $this->model = new ModelReport();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_search_list();
        $this->view->render('report_view.php', 'base_view.php', $data);
    }

    function action_rich_users() {
        $sql = 'select * from profile p 
join ticket t on (p.uid = t.user_id)
where t.price =
(
    select max(price) from ticket where flight_id = :flight_id
) and t.flight_id = :flight_id';
        $user_data = $_GET['var1'];
        $data = DataBase::paramQueryWithBind($sql, [':flight_id', $user_data, PDO::PARAM_INT, 24]);
//        $data = DataBase::paramQueryWithBind($sql,
//            array([1, $user_data, PDO::PARAM_INT, 24],
//                  [1, $user_data, PDO::PARAM_INT, 24]));
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
    function action_booking_from() { // TODO: add t.class in sql statement
        $sql = 'select f.dep_airport, t.departure, COUNT(*) from ticket t
join flight f on (t.flight_id = f.uid) where year(t.departure) = ?
group by f.dep_airport, t.departure';
        $user_data = [$_GET['var1']];
        $data = DataBase::paramQuery($sql, $user_data);
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
}
