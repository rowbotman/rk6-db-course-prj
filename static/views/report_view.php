<h1>Список доступных отчетов</h1>
<div class="report-list">
    <?php
    $is_light = true;
    foreach($data as $title)
    {
        echo '<div class="report-list__item">';
        if ($is_light) {
            echo '<div class="report-list__item-w">';
        } else {
            echo '<div class="report-list__item-d">';
        }
        echo '<a href="/report/'.$title['action'].'">'.$title['title'].'</a>';
        echo '</div>';
        $is_light = !$is_light;
    }
    ?>
</div>
