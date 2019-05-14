<?php
class ModelReport extends Model
{
    public function action()
    {
        return array(
            'url' => 'report/',
            'rows' => array(
                array(
                    'action' => 'bonus_miles_hist',
                    'title' => 'Начисление бонусных миль',
                    'data' => false,
                ),
                array(
                    'action' => 'booking_from',
                    'title' => 'Продажа билетов на рейс',
                    'data' => array('year'),
                )),
        );
    }
    public function get_bonus_miles_hist() {

    }
    public function get_search_list() {
        return array(
            'url' => 'search/',
            'rows' => array(
                array(
                    'action' => 'rich_users',
                    'title' => 'Самые дорогие билеты на рейс',
                    'data' => array('year'),
                ),
                array(
                    'action' => 'users_without_tickets',
                    'title' => 'Пассажиры, ни разу не покупавшие билеты',
                    'data' => false,
                ),
                array(
                    'action' => 'without_tickets_in',
                    'title' => 'Пассажиры, не покупавшие билеты в месяце',
                    'data' => array('month', 'year'),
                ),
                array(
                    'action' => 'often_bought_users_in',
                    'title' => 'Пассажиры, чаще всего покупавшие билеты период',
                    'data' => array('month', 'month', 'year'),
            )),

        );
    }
}
