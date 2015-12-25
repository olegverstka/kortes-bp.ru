<div id="register-form" class="widecolumn">
    <?php if ( $attributes['show_title'] ) : ?>
        <h3><?php _e( 'Регистрация', 'personalize-login' ); ?></h3>
    <?php endif; ?>
    
    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
        <?php foreach ( $attributes['errors'] as $error ) : ?>
            <p>
                <?php echo $error; ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post">
        <p class="form-row">
            <label for="email"><?php _e( 'Email', 'personalize-login' ); ?> <strong>*</strong></label>
            <input type="text" name="email" id="email">
        </p>
        <p class="form-row">
            <label for="first_name"><?php _e( 'Имя', 'personalize-login' ); ?></label>
            <input type="text" name="first_name" id="first-name">
        </p>
        <p class="form-row">
            <label for="last_name"><?php _e( 'Фамилия', 'personalize-login' ); ?></label>
            <input type="text" name="last_name" id="last-name">
        </p>
        <p class="form-row">
            <label for="patronymic"><?php _e( 'Отчество', 'personalize-login' ); ?></label>
            <input type="text" name="patronymic" id="patronymic">
        </p>
        <p class="form-row">
            <label for="mobile_phone"><?php _e( 'Мобильный телефон', 'personalize-login' ); ?></label>
            <input type="text" name="mobile_phone" id="mobile_phone">
        </p>
        <p class="form-row">
            <label for="role_user"><?php _e( 'Выберите свою роль', 'personalize-login' ); ?></label>
            <select class="select" name="role" id="role_user">
                <option>Не выбрано</option>
                <option value="executor">Переводчик</option>
                <option value="customer">Заказчик</option>
            </select>
        </p>
        <p class="form-row">
            <?php _e( 'Внимание: Ваш пароль будет сгенерирован автоматически и отправлен на указаный Вами адрес электронной почты.', 'personalize-login' ); ?>
        </p>
        <?php if ( $attributes['recaptcha_site_key'] ) : ?>
            <div class="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="<?php echo $attributes['recaptcha_site_key']; ?>"></div>
            </div>
        <?php endif; ?>
        <p class="signup-submit">
            <input type="submit" name="submit" class="register-button"
                   value="<?php _e( 'Зарегистрироваться', 'personalize-login' ); ?>"/>
        </p>
    </form>
</div>