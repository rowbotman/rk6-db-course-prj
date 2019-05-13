<div class="report report_main">
    <div class="report__header">
        <div class="report__title">Отчет</div>
    </div>
    <div class="report__items">
        <?php
        foreach ($data as $row) {
            echo '<div class="report__row">';
            foreach ($row as $item) {
                echo '<div class="report__elem">'.$item.'</div>';
            }
            echo '</div>';
        }
        ?>
    </div>
</div>
<?php
