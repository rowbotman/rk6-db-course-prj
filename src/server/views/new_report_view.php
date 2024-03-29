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
            <div class="report__row">
                <div class="report__elem report__elem_main">№</div>
                <?php
                    foreach ($data['data'][0] as $key => $row) {
                        echo '<div class="report__elem report__elem_main">'.$key.'</div>';
                    }
                ?>
            </div>
            <?php
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
$flag = true;
$page_num = $data['pages'];
if ($data['pages'] > 1) {
    echo '<button class="pagination__elem pagination__elem_extra" value="1">Начало</button>';
    echo '<button class="pagination__elem" value="-1">Назад</button>';
    echo '<button class="pagination__counter pagination__elem_current" value="1">1</button>';
    echo '<button class="pagination__elem" value="1">Вперед</button>';
    echo '<button class="pagination__elem pagination__elem_extra" value="' . $page_num . '">Конец</button>';
} else {
    echo '<button class="pagination__elem pagination__elem_current" value="1">1</button>';
}
echo '</div>';
?>
<script src="/js/pagination.js" type="module"></script>
<script src="/js/ajax.js" type="module"></script>
