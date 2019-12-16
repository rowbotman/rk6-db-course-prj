<div class="container_width_420 container-wrapper container-pos">
    <form method="POST" action="/change/update" novalidate>
        <div class="title-block">
            <h1 class="title-font title-wrapper">Поиск</h1>
        </div>
        <hr class="top-line">
        <div class="input-container">
            <p class="input-container__comment">Для поиска данных пассажира на ресурсе укажите информацию его
                персональные данные</p>
            <div class="form-label-group required-area">
                <label>
                    <input type="text" class="input-form input-form_size" name="firstName" placeholder="Имя" required>
                </label>
                <?php
                // todo: rewrite it
                if (isset($data['validate'])) {
                    echo '<div class="invalid-input">Заполните обязательное поле</div>';
                }
                ?>
            </div>
            <div class="form-label-group required-area">
                <label>
                    <input type="text" class="input-form input-form_size" name="lastName" placeholder="Фамилия"
                           required>
                </label>
                <?php
                if (isset($data['validate'])) {
                    echo '<div class="invalid-input">Заполните обязательное поле</div>';
                }
                ?>
            </div>
        </div>
        <hr class="top-line">
        <div class="input-container">
            <div class="btn-block btn-block-wrapper">
                <button type="submit" class="btn size_xlarge btn-red btn-border">
                    <div class="btn-font color_white font_size-16 btn-font-pos">Поиск</div>
                </button>
                <button type="reset" value="None" class="btn size_large btn-gray btn-border" onclick="window.history.back()">
                    <div class="btn-font color_dark font_size-16 btn-font-pos">Отменить</div>
                </button>
            </div>
            <?php
            if (isset($data['validate'])) {
                echo '<span>Пассажир не найден</span>';
            }
            ?>
        </div>
    </form>
</div>
