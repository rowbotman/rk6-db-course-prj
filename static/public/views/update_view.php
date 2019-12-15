<div class="report-list">
    <div class="menu__header">
        <h1><?php echo $data['title']?></h1>
    </div>
    <?php
    $months = [
        'Месяц', 'Январь', 'Февраль', 'Март', 'Апрель',
        'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
        'Октябрь', 'Ноябрь', 'Декабрь',
    ];
    $is_light = true;
    $i = 1;
    foreach($data['rows'] as $row)
    {
        echo '<div class="report-list__item">';
        if ($is_light) {
            echo '<div class="report-list__item-w">';
        } else {
            echo '<div class="report-list__item-d">';
        }
        if ($row['data']) {
            echo '<form action="/'.$data['url'].$row['action'].'" method="GET">';
            echo '<div class="report-list__num">'.$i.'.</div>';
            echo '<input type="submit" value="'.$row['row'].'" class="input__link">';
            $item_id = 1;
            foreach ($row['data'] as $item) {
                echo '<div class="select"><select name="var'.$item_id.'" id="'.$item_id.'" class=" select__field">';
                switch ($item) {
                    case 'day':{
                        for ($j = 1; $j <= 31; ++$j) {
                            $val = sprintf('%02d', $j);
                            echo '<option value="' . $val . '">' . $j . '</option>';
                        }
                        break;
                    }
                    case 'month': {
                        for ($j = 0; $j < 13; ++$j) {
                            $val = sprintf('%02d', $j);
                            echo '<option value="'.$val.'">'.$months[$j].'</option>';
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
            echo '</form>';
        } elseif ($row['data_get']) {
            echo '<div class="report-list__num">'.$i.'.</div>';
            $k = 1;
            $link = '/'.$data['url'].$row['action'].'?';
            $local_data = '';
            foreach ($row['data_get'] as $item) {
                $link = $link.'var'.$k.'='.$item.'&';
                $local_data = $local_data.' - '.$item;
                ++$k;
            }
            echo '<a href="'.$link.'">'.$row['row'].' в период '.$local_data.'</a>';
        } else {
            echo '<div class="report-list__num">'.$i.'.</div>';
            echo '<a href="/'.$data['url'].$row['action'].'">'.$row['row'].'</a>';
        }

        echo '</div></div>';
        $is_light = !$is_light;
        ++$i;
    }
    ?>
</div>