<div class="report-list">
    <div class="menu__header">
        <h1><?php echo $data['title'] ?></h1>
    </div>
    <div class="report__items">
        <?php
        if (isset($data['has'])) {
            echo '<div class="report__row">';
            echo '<div class="report__elem report__elem_main">№</div>';
            foreach ($data['data'][0] as $key => $row) {
                if ($key === 'uid') {
                    continue;
                }
                echo '<div class="report__elem report__elem_main">' . $key . '</div>';
            }
            echo '</div>';
            $i = 1;
            foreach ($data['data'] as $row) {
                $num = $i;
                echo '<div id="' . $row['uid'] . '" class="report__row">';
                unset($row['uid']);
                echo '<div class="report__elem">' . $num . '</div>';
                foreach ($row as $key => $item) {
                    echo '<div class="report__elem">' . $item . '</div>';
                }
                echo '<div class="report__elem">
                        <span class="icon icon-size-16 user-edit-icon icon-black icon-button"></span>
                      </div>
                      <div class="report__elem">
                        <span class="icon icon-size-16 delete-icon icon-black icon-button"></span>
                      </div>';
                ++$i;
                echo '</div>';
            }
        } else {
            echo '<h3>У пользователя нет перелетов</h3>';
        }
        echo '</div>';
        ?>
        <hr class="update__line">
        <div class="submit-container">
            <form action="/change/add" method="GET">
                <div class="btn-block btn-block-wrapper">
                    <button name="user_id" type="submit" class="btn size_xlarge btn-red btn-border"
                            value="<?php echo $data['user_id'] ?>">
                        <div class="btn-font color_white font_size-16 btn-font-pos">Добавить перелет</div>
                    </button>
                    <button type="button" class="btn size_large btn-gray btn-border" onclick="window.history.back()">
                        <div class="btn-font color_dark font_size-16 btn-font-pos">Отменить</div>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<script src="/static/public/js/update.js" type="module"></script>