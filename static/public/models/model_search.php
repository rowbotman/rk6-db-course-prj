<?php
class ModelSearch extends Model
{
    private static $limit;
    private static $page;

    public function __construct($limit = 10, $page_num = 1)
    {
        if ($page_num <= 0) {
            $page_num = 1;
        }
        self::$limit = $limit;
        self::$page = ($page_num - 1) * $limit;
    }

    public function get_search_list() {
        return array(
            'title' => 'Список доступных запросов',
            'url' => 'search/',
            'rows' => array(
                array(
                    'action' => 'rich_users',
                    'row' => 'Самые дорогие билеты на рейс',
                    'data' => array('id'),
                    'data_get' => false,
                ),
                array(
                    'action' => 'users_without_tickets',
                    'row' => 'Пассажиры, ни разу не покупавшие билеты',
                    'data' => false,
                    'data_get' => false,
                ),
                array(
                    'action' => 'without_tickets_in',
                    'row' => 'Пассажиры, не покупавшие билеты в месяце',
                    'data' => array('month', 'year'),
                    'data_get' => false,

                ),
                array(
                    'action' => 'often_bought_users_in',
                    'row' => 'Пассажиры, чаще всего покупавшие билеты период',
                    'data' => array('month', 'month', 'year'),
                    'data_get' => false,

                ),
                array(
                    'action' => 'bonus_miles_hist',
                    'row' => 'Начисление бонусных миль',
                    'data' => false,
                    'data_get' => false,
                ),
                array(
                    'action' => 'booking_from',
                    'row' => 'Продажа билетов на рейсы в году',
                    'data' => array('year'),
                    'data_get' => false,
                )),
        );
    }

    public function get_rich_users()
    {
        $user_data = $_GET['var1'];
        $sql = 'SELECT * FROM profile p 
JOIN ticket t ON (p.uid = t.user_id)
WHERE t.price =(SELECT max(price) FROM ticket WHERE flight_id = :flight_id)
  AND t.flight_id = :flight_id LIMIT '.self::$page.','.self::$limit.';';
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = DataBase::paramQueryWithBind($sql, [':flight_id', $user_data, PDO::PARAM_INT, 24]);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        return $data;
    }

    public function get_booking_from()
    { // TODO: add t.class in sql statement
        $user_data = [$_GET['var1']];
        $sql = 'SELECT f.uid AS flight, MONTH(f.dep_date) AS month, t.class, COUNT(t.uid) AS tickets_num FROM ticket t
JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(f.dep_date) = ?
GROUP BY flight, month, t.class ORDER BY tickets_num DESC LIMIT ' . self::$page . ',' . self::$limit . ';';
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        return $data;
    }

    public function get_bonus_miles_hist() {
        $sql = 'SELECT t.flight_id, f.dep_date, SUM(d.cur_value) AS sum FROM detail d
JOIN ticket t ON (t.uid = d.ticket_id) JOIN flight f ON (t.flight_id = f.uid)
GROUP BY t.flight_id, f.dep_date ORDER BY sum DESC LIMIT ' . self::$page . ',' . self::$limit . ';';
        $data = DataBase::query($sql);
        return $data;
    }

    public function get_often_bought_users_in() {
        $sql = '
        WITH spring_flight AS 
        ( 
          SELECT MAX(num) FROM (
              SELECT COUNT(*) AS num FROM ticket t
              JOIN flight f ON (f.uid = t.flight_id)
              WHERE YEAR(f.dep_date) = ? AND MONTH(f.dep_date) BETWEEN ? AND ? GROUP BY t.user_id
          ) tickets_num
        ) SELECT p.* FROM profile p JOIN ticket t ON (t.user_id = p.uid)
          JOIN flight f ON (f.uid = t.flight_id)	
          WHERE YEAR(f.dep_date) = ? AND MONTH(f.dep_date) BETWEEN ? AND ? 
          GROUP BY p.uid HAVING COUNT(*) = (SELECT * FROM spring_flight)
           LIMIT ' . self::$page . ',' . self::$limit . ';';
        $user_data = [$_GET['var3'], $_GET['var1'], $_GET['var2'],
            $_GET['var3'], $_GET['var1'], $_GET['var2']];
        $data = [['' => 'Empty set']];
        if ($_GET['var3'] && $_GET['var1'] && $_GET['var2']) {
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        return $data;
    }
}
