<?php
class ModelReport extends Model
{
    public function action()
    {
        return array(
            'title' => 'Список доступных отчетов',
            'url' => 'report/',
            'rows' => array(
                array(
                    'action' => 'airport_rating',
                    'row' => 'Рейтинг аэропортов по популярности',
                    'data' =>  array('month', 'year', 'month', 'year'),
                    'data_get' => false,
                )),
        );
    }
    public function get_bonus_miles_hist() {

    }

    public function get_old_reports() {
        $sql = 'SELECT DISTINCT DATE_FORMAT(start_date, \'%Y-%m-%d\') as start_date,
                                DATE_FORMAT(end_date, \'%Y-%m-%d\') as end_date
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
}
