<?php
class ModelSearch extends Model
{
    private static $limit;
    private static $limit_h;
    private static $limit_l;

    public function __construct($limit = 10, $page_num = 1)
    {
        if ($page_num < 0) {
            $page_num = 1;
        }
        self::$limit = $limit;
        self::$limit_h = $limit * $page_num;
        self::$limit_l = ($page_num - 1) * $limit;
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

    public function get_rich_users($user_data)
    {
        $sql = 'SELECT * FROM profile p 
JOIN ticket t ON (p.uid = t.user_id)
WHERE t.price =
(
    SELECT max(price) FROM ticket WHERE flight_id = :flight_id
) AND t.flight_id = :flight_id LIMIT '.self::$limit_l.','.self::$limit_h.';';
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = DataBase::paramQueryWithBind($sql, [':flight_id', $user_data, PDO::PARAM_INT, 24]);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }

        $sql = 'SELECT COUNT(*) FROM profile p 
JOIN ticket t ON (p.uid = t.user_id)
WHERE t.price =
(
    SELECT max(price) FROM ticket WHERE flight_id = :flight_id
) AND t.flight_id = :flight_id;';
        if ($user_data) {
            $pages = DataBase::paramQueryWithBind($sql, [':flight_id', $user_data, PDO::PARAM_INT, 24]);
            if (!$pages) {
                $pages = 0;
            }
        }

        return ['pages' => ceil($pages[0] / self::$limit), 'data' => $data];
    }

    public function get_booking_from($user_data)
    { // TODO: add t.class in sql statement
        $sql = 'SELECT f.uid AS flight, MONTH(f.dep_date) AS month, t.class, COUNT(t.uid) AS tickets_num FROM ticket t
JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(f.dep_date) = ?
GROUP BY flight, month, t.class ORDER BY tickets_num DESC LIMIT ' . self::$limit_l . ',' . self::$limit_h . ';';
        $data = [['' => 'Empty set']];
        if ($user_data) {
            $data = DataBase::paramQuery($sql, $user_data);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        $sql = 'SELECT COUNT(*) FROM (SELECT f.uid AS flight, MONTH(f.dep_date) AS month, t.class, COUNT(t.uid) AS tickets_num FROM ticket t
JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(f.dep_date) = ?
GROUP BY flight, month, t.class) query';
        $pages = DataBase::getRow($sql, $user_data);
        if (!$pages) {
            $pages[0] = 0;
        }
        return ['pages' => ceil($pages[0] / self::$limit), 'data' => $data];
    }
}
