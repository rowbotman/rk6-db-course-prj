<?php
class ModelReport extends Model
{
    public function action()
    {
        return array(
            array(
                'action' => 'bonus_miles_hist',
                'title' => 'Начисление бонусных миль',
            ),
            array(
                'action' => 'booking_from',
                'title' => 'Продажа билетов на рейс',
            ),
        );
//        return array(
//
//            array(
//                'Year' => '2012',
//                'Site' => 'http://DunkelBeer.ru',
//                'Description' => 'Промо-сайт темного пива Dunkel от немецкого производителя Löwenbraü выпускаемого в России пивоваренной компанией "CАН ИнБев".'
//            ),
//            array(
//                'Year' => '2012',
//                'Site' => 'http://ZopoMobile.ru',
//                'Description' => 'Русскоязычный каталог китайских телефонов компании Zopo на базе Android OS и аксессуаров к ним.'
//            ),
//            // todo
//        );
    }
}
