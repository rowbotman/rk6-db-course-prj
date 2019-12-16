<?php
echo '<div class="pagination">';
$flag = true;
$page_num = $data['pages'];
if ($data['pages'] > 1) {
    echo '<button class="pagination__elem pagination__elem_extra" value="1">Начало</button>';
    echo '<button class="pagination__elem" value="-1">Назад</button>';
    echo '<button class="pagination__counter pagination__elem_current" value="1">1</button>';
//    echo '<button class="pagination__elem" value="3">...</button>';
//    echo '<button class="pagination__elem" value="'.($page_num - 1).'">'.($page_num - 1).'</button>';
    echo '<button class="pagination__elem" value="1">Вперед</button>';
    echo '<button class="pagination__elem pagination__elem_extra" value="' . $page_num . '">Конец</button>';
} else {
    echo '<button class="pagination__elem pagination__elem_current" value="1">1</button>';
}
//    echo '<button class="pagination__elem" value="1">Назад</button>';
//    echo '<button class="pagination__elem pagination__elem_current" value="1">1</button>';
//    for ($i = 1; $i < $data['pages']; ++$i) {
//        if ($i < 3 || ($i <= $data['pages'] && $i >= $data['pages'] - 1)) {
//            if ($i == 1) {
//                echo '<button class="pagination__elem pagination__elem_current" value="'.$i.'">' . $i . '</button>';
//            } else {
//                echo '<button class="pagination__elem" value="' . $i . '">' . $i . '</button>';
//            }
//        } else {
//            if ($flag) {
//                $flag = false;
//                echo '<button class="pagination__elem" value="' . $i . '">...</button>';
//            }
//        }
//    }
//    echo '<button class="pagination__elem" value="' . $i . '">Вперед</button>';
//}

echo '</div>';
?>