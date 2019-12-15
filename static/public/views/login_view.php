<div class="container login-container">
    <div class="form-container">
        <span class="icon icon-size-25 close-icon icon-black icon-button close-button"></span>
        <form method="POST" action="/auth/login" novalidate>
            <h2 class="title-font login-title">Войти</h2>
            <div class="form-label-group">
                <label>
                    <?php
                    if (!isset($data['validate'])) {
                        echo '<input type="text" class="input-form" name="login" placeholder="Телефон или электронная почта">';
                    } else {
                        echo '<input type="text" class="input-form input-form_error" name="login" placeholder="Телефон или электронная почта">';
                    }
                    ?>
                </label>
            </div>
            <div class="form-label-group">
                <label>
                    <?php
                    if (!isset($data['validate'])) {
                        echo '<input type="password" class="input-form" name="pass" placeholder="Пароль">';
                    } else {
                        echo '<input type="password" class="input-form input-form_error" name="pass" placeholder="Пароль">';
                        echo '<span>Неверный логин или пароль</span>';
                    }
                    ?>
                </label>
            </div>
            <div class="form-label-group">
                <label class="tick-box">Запомнить пароль
                    <input type="checkbox" checked="checked" name="remember-me">
                    <span class="checkmark "></span>
                </label>
                <a href=# class="link-font">Забыли пароль?</a>
            </div>
            <div class="container-large">
                <button class="btn btn-box-small btn-color-red" type="submit" name="submit">
                    <div class="success-btn-font">Войти</div>
                </button>
                <p class="comment-text">или продолжить через</p>
                <div class="center-block">
                    <div class="com-container container-xsmall icon-gb icon-button">
                        <span class="icon vk-icon icon-white icon-size-16 social-pos"></span>
                    </div>
                    <div class="com-container container-xsmall icon-blue icon-button">
                        <span class="icon fb-icon icon-white icon-size-16 social-pos"></span>
                    </div>
                    <div class="com-container container-xsmall icon-orange icon-button">
                        <span class="icon ok-icon icon-white icon-size-16 social-pos"></span>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <hr class="dividing-line"/>
    <div class="center-block register-block">
        <a href="#" class="link-font">Зарегестрироваться</a>
    </div>
</div>
