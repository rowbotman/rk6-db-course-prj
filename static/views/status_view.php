<?php
switch ($data) {
    case 1: {
        echo '<h1>Отчет успешно создан</h1>';
        break;
    }
    case 0: {
        echo '<h1>Отчет уже существует</h1>';
        break;
    }
    default: {
        echo '<h1 class="status_error">Введите диапазон</h1>';
    }
}
//if ($data) {
//    echo '<h1>Отчет успешно создан</h1>';
//} else {
//    echo '<h1>Отчет уже существует</h1>';
//}