<?php
require_once('models/model_search.php');

class Controller_Search extends Controller
{
    static private $limit = 10;
    function __construct()
    {
        $this->model = new ModelSearch(10, 0);
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_search_list();
        $this->view->render('report_view.php', 'base_view.php', $data);
    }

    function action_rich_users()
    {
        $user_data = $_GET['var1'];
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = $this->model->get_rich_users();
        }
        $sql = 'SELECT COUNT(*) as count FROM profile p
JOIN ticket t ON (p.uid = t.user_id)
WHERE t.price = (SELECT max(price) FROM ticket WHERE flight_id = :flight_id)
AND t.flight_id = :flight_id;';
        $pages = DataBase::paramQueryWithBind($sql, [':flight_id', $user_data, PDO::PARAM_INT, 24]);
        if (!$pages[0]['count']) {
            $pages[0]['count'][0] = 0;
        }
        $this->view->render('new_report_view.php', 'base_view.php',
            ['pages' => ceil($pages[0]['count'][0] / self::$limit), 'data' => $data]);
    }

    function action_booking_from() { // TODO: add t.class in sql statement
        $user_data = [$_GET['var1']];
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = $this->model->get_booking_from();
        }
        $sql = 'SELECT COUNT(*) FROM (SELECT f.uid AS flight, MONTH(f.dep_date) AS month, t.class, COUNT(t.uid) AS tickets_num FROM ticket t
JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(f.dep_date) = ?
GROUP BY flight, month, t.class) query';
        $pages = DataBase::getRow($sql, $user_data);
        if (!$pages) {
            $pages[0] = 0;
        }
        $this->view->render('new_report_view.php', 'base_view.php',
            ['pages' => ceil($pages[0] / self::$limit), 'data' => $data]);
    }

    function action_users_without_tickets()
    {
        $sql = 'SELECT COUNT(*) FROM profile p LEFT JOIN ticket t ON (t.user_id = p.uid) WHERE t.user_id IS NULL;';
        $pages = DataBase::getRow($sql);
        if (!$pages) {
            $pages[0] = 0;
        }
        $data = $this->model->get_users_without_tickets();
        $this->view->render('new_report_view.php', 'base_view.php',
            ['pages' => ceil($pages[0] / self::$limit), 'data' => $data]);
    }

    function action_without_tickets_in()
    {
        $sql = 'SELECT COUNT(*) AS count FROM (
    SELECT distinct p.uid, p.firstName, p.lastName, p.votes
    FROM profile p JOIN ticket t ON (p.uid = t.user_id) JOIN flight f ON (t.flight_id = f.uid)
    WHERE YEAR(f.dep_date) <> ? AND MONTH(f.dep_date) <> ?) without_tickets;';
        $data = [['' => 'Empty set']];
        $user_data = [$_GET['var2'], $_GET['var1']];
        if ($_GET['var1'] && $_GET['var2']) {
            $data = $this->model->get_without_tickets_in();
        }
        $pages = DataBase::paramQuery($sql, $user_data);
        if (!$pages[0]['count']) {
            $pages[0]['count'][0] = 0;
        }
        $this->view->render('new_report_view.php', 'base_view.php',
            ['pages' => ceil($pages[0]['count'][0] / self::$limit), 'data' => $data]);
    }

    function action_often_bought_users_in() {
        $sql = 'WITH spring_flight AS
(
  SELECT MAX(num) FROM (
  SELECT COUNT(*) AS num FROM ticket t
  JOIN flight f ON (f.uid = t.flight_id)
  WHERE YEAR(f.dep_date) = ? AND MONTH(f.dep_date) BETWEEN ? AND ? GROUP BY t.user_id) subquery
) SELECT COUNT(*) FROM (SELECT p.* FROM profile p JOIN ticket t ON (t.user_id = p.uid)
  JOIN flight f ON (f.uid = t.flight_id)
  WHERE YEAR(f.dep_date) = ? AND MONTH(f.dep_date) BETWEEN ? AND ?
  GROUP BY p.uid HAVING COUNT(*) = (SELECT * FROM spring_flight)) item_num;';
        $user_data = [$_GET['var3'], $_GET['var1'], $_GET['var2'],
                      $_GET['var3'], $_GET['var1'], $_GET['var2']];
        $pages = DataBase::getRow($sql, $user_data);
        if (!$pages) {
            $pages[0] = 0;
        }
        $data = $this->model->get_often_bought_users_in();
        $this->view->render('new_report_view.php', 'base_view.php',
            ['pages' => ceil($pages[0] / self::$limit), 'data' => $data]);
    }

    function action_bonus_miles_hist() {
        $sql = 'SELECT COUNT(*) FROM (SELECT t.flight_id, f.dep_date AS sum FROM detail d
JOIN ticket t ON (t.uid = d.ticket_id) JOIN flight f ON (t.flight_id = f.uid)
GROUP BY t.flight_id, f.dep_date) subquery;';
        $data = $this->model->get_bonus_miles_hist();
        $pages = DataBase::getRow($sql);
        if (!$pages) {
            $pages[0] = 0;
        }
        $this->view->render('new_report_view.php', 'base_view.php',
            ['pages' => ceil($pages[0] / self::$limit), 'data' => $data]);
    }
}
