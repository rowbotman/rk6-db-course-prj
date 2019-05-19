<div class="report">
    <div class="report__header">
        <div class="report__title"><h1>Отчет</h1></div>
        <div class="report__header_icon">
            <span class="icon-bg icon_btn icon-bg_borderless icon-bg_size_xxlarge  menu__icon-bg">
                <i class="icon icon_color_black icon_type_cross icon_size_fit"></i>
            </span>
        </div>
    </div>
    <div class="report_main">
        <div class="report__items">
            <?php
            echo '<div class="report__row">';
            echo '<div class="report__elem report__elem_main">№</div>';
            foreach ($data[0] as $key => $row) {
                echo '<div class="report__elem report__elem_main">'.$key.'</div>';
            }
            echo '</div>';
            $i = 1;
            foreach ($data as $row) {
                echo '<div class="report__row">';
                echo '<div class="report__elem">'.$i.'</div>';
                foreach ($row as $key => $item) {
                    echo '<div class="report__elem">'.$item.'</div>';
                }
                ++$i;
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
