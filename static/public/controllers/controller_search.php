<?php
require_once('static/public/models/model_report.php');

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
        $sql = 'SELECT * FROM profile p 
JOIN ticket t ON (p.uid = t.user_id)
WHERE t.price =
(
    SELECT max(price) FROM ticket WHERE flight_id = :flight_id
) AND t.flight_id = :flight_id';
        $user_data = $_GET['var1'];
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = DataBase::paramQueryWithBind($sql, [':flight_id', $user_data, PDO::PARAM_INT, 24]);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
    function action_booking_from() { // TODO: add t.class in sql statement
        $sql = 'SELECT f.uid AS flight, MONTH(f.dep_date) AS month, t.class, COUNT(t.uid) AS tickets_num FROM ticket t
JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(f.dep_date) = ?
GROUP BY flight, month, t.class ORDER BY tickets_num DESC;';
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
        $sql = 'SELECT p.* FROM profile p LEFT JOIN ticket t ON (t.user_id = p.uid) WHERE t.user_id IS NULL;';
        $data = DataBase::query($sql);
        if (!$data) {
            $data = [['' => 'Empty set']];
        }
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }

    function action_without_tickets_in()
    {
        $sql = 'SELECT distinct p.uid, p.firstName, p.lastName, p.votes 
FROM profile p JOIN ticket t ON (p.uid = t.user_id) JOIN flight f ON (t.flight_id = f.uid)
WHERE YEAR(f.dep_date) <> ? AND MONTH(f.dep_date) <> ?;';
        $data = [['' => 'Empty set']];
        $user_data = [$_GET['var2'], $_GET['var1']];
        if ($_GET['var1'] && $_GET['var2']) {
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }

    function action_often_bought_users_in() {
        $sql = 'WITH spring_flight AS 
( 
  SELECT MAX(num) FROM (
  SELECT COUNT(*) AS num FROM ticket t
  JOIN flight f ON (f.uid = t.flight_id)
  WHERE YEAR(f.dep_date) = ? AND MONTH(f.dep_date) BETWEEN ? AND ? GROUP BY t.user_id) subquery
) SELECT p.* FROM profile p JOIN ticket t ON (t.user_id = p.uid)
  JOIN flight f ON (f.uid = t.flight_id)	
  WHERE YEAR(f.dep_date) = ? AND MONTH(f.dep_date) BETWEEN ? AND ? 
  GROUP BY p.uid HAVING COUNT(*) = (SELECT * FROM spring_flight);';
        $user_data = [$_GET['var3'], $_GET['var1'], $_GET['var2'],
                      $_GET['var3'], $_GET['var1'], $_GET['var2']];
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
        $sql = 'SELECT t.flight_id, f.dep_date, SUM(d.cur_value) AS sum FROM detail d
JOIN ticket t ON (t.uid = d.ticket_id) JOIN flight f ON (t.flight_id = f.uid)
GROUP BY t.flight_id, f.dep_date ORDER BY sum;';
        $data = DataBase::query($sql);
        $this->view->render('new_report_view.php', 'base_view.php', $data);
    }
}
