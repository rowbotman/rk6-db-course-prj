<h1>Список доступных отчетов</h1>
<div class="report-list">
    <?php
    $months = [
        'Месяц', 'Январь', 'Февраль', 'Март', 'Апрель',
        'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
        'Октябрь', 'Ноябрь', 'Декабрь',
    ];
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
            $item_id = 1;
            foreach ($title['data'] as $item) {
                echo '<div class="select"><select name="'.$title['action'].$item_id.'" id="'.$item_id.'" class=" select__field">';
                switch ($item) {
                    case 'day':
                        for ($j = 1; $j <= 31; ++$j) {
                            echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                        break;
                    case 'month': {
                        for ($j = 0; $j < 13; ++$j) {
                            echo '<option value="'.$j.'">'.$months[$j].'</option>';
                        }
                        break;
                    }
                    case 'year': {
                        for ($j = 2019; $j >= 1990; --$j) {
                            echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                        break;
                    }
                    default:
                        for ($j = 1; $j <= 100; ++$j) {
                            echo '<option value="'.$j.'">'.$j.'</option>';
                        }
                }
                echo '</select></div>';
                ++$item_id;
            }
            foreach (['day', 'month', 'year'] as $item) {
                if (array_key_exists($item, $title['data'])) {
                    echo '<div class="select"><select name="'.$title['action'].$i.'" id="'.$i.'" class=" select__field">';
                    switch ($item) {
                        case 'day':
                            for ($j = 1; $j <= 31; ++$j) {
                                echo '<option value="'.$j.'">'.$j.'</option>';
                            }
                            break;
                        case 'month': {
                            for ($j = 0; $j < 13; ++$j) {
                                echo '<option value="'.$j.'">'.$months[$j].'</option>';
                            }
                            break;
                        }
                        case 'year': {
                            for ($j = 2019; $j >= 1990; --$j) {
                                echo '<option value="'.$j.'">'.$j.'</option>';
                            }
                            break;
                        }
                    }
                    echo '</select></div>';
                }
                echo '</form>';
            }

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
