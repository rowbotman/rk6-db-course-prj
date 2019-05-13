<h1>Список доступных отчетов</h1>
<div class="report-list">
    <?php
    $is_light = true;
    $i = 1;
    foreach($data as $title)
    {
        echo '<div class="report-list__item">';
        if ($is_light) {
            echo '<div class="report-list__item-w">';
        } else {
            echo '<div class="report-list__item-d">';
        }
        if ($title['data']) {
            echo '<form action="/report/'.$title['action'].'" method="GET">';
            echo '<div class="report-list__num">'.$i.'.</div>';
            echo '<input type="submit" value="'.$title['title'].'" class="input__link">';
            echo '<div class="select"><select name="'.$title['action'].'" id="'.$i.'" class=" select__field">';
            for ($j = 2019; $j >= 1990; --$j) {
                echo '<option value="'.$j.'">'.$j.'</option>';
            }
            echo '</select></div>';
            echo '</form>';
        } else {
            echo '<div class="report-list__num">'.$i.'.</div>';
            echo '<a href="/report/'.$title['action'].'">'.$title['title'].'</a>';
        }

        echo '</div></div>';
        $is_light = !$is_light;
        ++$i;
    }
    ?>
</div>
