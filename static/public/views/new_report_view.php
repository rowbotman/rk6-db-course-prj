<div class="report">
    <div class="report__header">
        <div class="report__title"><h1>Отчет</h1></div>
        <div class="report__header_icon">
            <span class="icon-bg icon_btn icon-bg_borderless icon-bg_size_xxlarge  menu__icon-bg">
                <a class="icon icon_color_black icon_type_cross icon_size_fit" href="<?php echo Router::$prev_url?>">
                </a>
            </span>
        </div>
    </div>
    <div class="report_main">
        <div class="report__items">
            <?php
            echo '<div class="report__row">';
            echo '<div class="report__elem report__elem_main">№</div>';
            foreach ($data['data'][0] as $key => $row) {
                echo '<div class="report__elem report__elem_main">'.$key.'</div>';
            }
            echo '</div>';
            $i = 1;
            foreach ($data['data'] as $row) {
                echo '<div class="report__row">';
                $num = $i;
                echo '<div class="report__elem">'.$num.'</div>';
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

<?php
echo '<div class="pagination">';
for ($i = 1; $i <= $data['pages']; ++$i) {
    if ($i == 1) {
        echo '<button class="pagination__elem pagination__elem_current" value="'.$i.'">'.$i.'</button>';
    } else {
        echo '<button class="pagination__elem" value="'.$i.'">'.$i.'</button>';
    }
}
echo '</div>';
?>
<script src="/static/public/js/pagination.js" type="module"></script>
<script src="/static/public/js/ajax.js" type="module"></script>