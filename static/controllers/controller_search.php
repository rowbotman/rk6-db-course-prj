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
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = DataBase::paramQueryWithBind($sql, [':flight_id', $user_data, PDO::PARAM_INT, 24]);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
//        $data = DataBase::paramQueryWithBind($sql,
//            array([1, $user_data, PDO::PARAM_INT, 24],
//                  [1, $user_data, PDO::PARAM_INT, 24]));
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
    function action_booking_from() { // TODO: add t.class in sql statement
        $sql = 'select f.dep_airport, t.departure, COUNT(*) as tickets_num from ticket t
join flight f on (t.flight_id = f.uid) where year(t.departure) = ?
group by f.dep_airport, t.departure order by tickets_num;';
        $user_data = [$_GET['var1']];
        if ($user_data) {
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }

    function action_users_without_tickets()
    {
        $sql = 'select * from profile p left join ticket t on (t.user_id = p.uid) where t.user_id IS NULL;';
        $data = DataBase::query($sql);
        if (!$data) {
            $data = [['' => 'Empty set']];
        }
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }

    function action_without_tickets_in()
    {
        $sql = 'select distinct p.uid, p.firstName, p.lastName, p.votes 
from profile p join ticket t on (p.uid = t.user_id)
where year(t.departure) <> ? and month(t.departure) <> ?;';
        $data = [['' => 'Empty set']];
        $user_data = [$_GET['var2'], $_GET['var1']];
        if ($_GET['var1'] && $_GET['var2']) {
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
//        $data = DataBase::paramQuery($sql, $user_data);
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }

    function action_often_bought_users_in() {
        $sql = 'with spring_flight as 
( 
    select t.user_id from ticket t 
    where year(t.departure) = ? and (
        month(t.departure) = ? or month(t.departure) = ?)
)select s.user_id, count(s.user_id) num from profile p
join spring_flight s on (s.user_id = p.uid) 
group by s.user_id 
order by count(s.user_id) desc
limit 1;';
        $user_data = [$_GET['var3'], $_GET['var1'], $_GET['var2']];
        $data = [['' => 'Empty set']];
        if ($_GET['var3'] && $_GET['var1'] && $_GET['var2']) {
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
    function action_bonus_miles_hist() {
        $sql = 'SELECT t.flight_id, t.departure, SUM(d.cur_value) AS sum FROM detail d
JOIN ticket t ON (t.uid = d.ticket_id) 
GROUP BY t.flight_id, t.departure ORDER BY sum;';
        $data = DataBase::query($sql);
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
}
