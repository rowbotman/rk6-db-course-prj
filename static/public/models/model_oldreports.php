<?php
class ModelOldreports extends Model
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

    public function action()
    {
        return array(
            'title' => 'Not Found',
            'url' => 'report/',
            'rows' => array(
                array(
                    'action' => '',
                    'row' => '',
                    'data' => false,
                    'data_get' => false,
                )),
        );
    }
    public function get_bonus_miles_hist() {
        return array(
            'title' => 'Список доступных отчетов',
            'url' => 'report/',
            'rows' => array(
                array(
                    'action' => 'airport_rating',
                    'row' => 'Рейтинг аэропортов по популярности',
                    'data' =>  array('month', 'year'),
                    'data_get' => false,
                )),
        );

    }

    public function get_old_reports() {
        $sql = 'SELECT DISTINCT DATE_FORMAT(start_date, \'%Y-%m-%d\') AS start_date,
                                DATE_FORMAT(end_date, \'%Y-%m-%d\') AS end_date
FROM airport_rating ORDER BY start_date, end_date;';
        $data = DataBase::query($sql);
        $report_list = array(
            'title' => 'Список созданных отчетов',
            'url' => 'oldreports/',
            'rows' => array()
        );
        foreach ($data as $item) {
            array_push(
                $report_list['rows'], array(
                'action' => 'airport_rating',
                'row' => 'Рейтинг аэропортов по популярности',
                'data' => false,
                'data_get' =>  array($item['start_date'], $item['end_date'])
            ));
        }
        return $report_list;
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

    public function get_airport_rating()
    {
        $sql = 'SELECT r.airport, r.tickets_out, r.tickets_in,
        r.tickets_out + r.tickets_in AS sum FROM airport_rating r
        WHERE r.hash_group = ? ORDER BY sum DESC, r.tickets_in DESC, r.tickets_out DESC
        LIMIT ' . self::$page . ',' . self::$limit . ';';
        $data = [['' => 'Empty set']];
        if ($_GET['var1'] && $_GET['var2']) {
            $sha_str = $_GET['var1'] . ' 00:00:00' . $_GET['var2'] . ' 00:00:00';
            $sha_data = sha1($sha_str);
            $data = DataBase::paramQuery($sql, [$sha_data]);
            if (!$data) {
                $data = [['' => 'Empty set']];
            }
        }
        return $data;
    }
}
