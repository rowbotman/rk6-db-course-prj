<div class="container_width_420 container-wrapper login-container container-shadow container">
    <div class="title-container">
        <div class="title-font title-wrapper">Добавление перелета</div>
        <span class="icon icon-button icon-black close-big-icon icon-size-20 cross-icon_pos"
              onclick="window.history.back()"></span>
    </div>
    <form method="POST" action="/change/add" novalidate>
        <div class="input-container">
            <label for="validationLogin" class="info-font">ID билета</label>
            <div class="form-label-group required-area">
                <input type="number" class="input-form input-form_upd-size" id="validationLogin" name="ticket_id"
                       required>
            </div>
            <label for="validationLogin" class="info-font">Баллы за поездку</label>
            <div class="form-label-group required-area">
                <input type="number" class="input-form input-form_upd-size" id="validationLogin" name="value" required>
                <div class="note-block note-block_wrapper">
                    <span class="icon back-btn-icon icon-white icon-size-25 back-btn-icon_pos"></span>
                    <div class="attention-msg attention-pos">
                        <div class="attention-font">Укажите сумму баллов за поездку</div>
                        <div class="attention-comment-font">Можно изменить в будущем</div>
                    </div>
                </div>
            </div>
            <label for="validationLogin" class="info-font">ID пассажира</label>
            <div class="form-label-group required-area">
                <?php
                echo '<input type="number" readonly="readonly" class="input-form input-form_upd-size" id="validationLogin" name="user_id" value="' . $data['user_id'] . '">';
                ?>
            </div>
        </div>
        <hr class="top-line">
        <div class="submit-container">
            <div class="btn-block btn-block-wrapper">
                <button type="submit" class="btn btn-pink size_large btn-border">
                    <div class="btn-font color_white font_size-16 btn-font-pos">Обновить</div>
                </button>
                <button type="button" class="btn size_large btn-gray btn-border btn-shadow"
                        onclick="window.history.back()">
                    <div class="btn-font color_dark font_size-16 btn-font-pos">Отменить</div>
                </button>
            </div>
        </div>
    </form>

</div>
<script>
    let elem = document.getElementById('main');
    elem.style.backgroundColor = '#858585';
</script>