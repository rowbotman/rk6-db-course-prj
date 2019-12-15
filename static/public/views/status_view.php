<?php
switch ($data) {
    case -1: {
        echo '<h1>Данных за этот период нет</h1>';
        break;
    }
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
?>
<div class="report-list__item">
    <form class="input__btns">
        <button formaction="/oldreports" class="input__btns_btn report-list__item-d">Существующие отчеты</button>
        <button formaction="/report" class="input__btns_btn report-list__item-w">Назад</>
    </form>
</div>
