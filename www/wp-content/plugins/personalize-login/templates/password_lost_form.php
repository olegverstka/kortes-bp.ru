<div id="password-lost-form" class="widecolumn">
    <?php if ( $attributes['show_title'] ) : ?>
        <h3><?php _e( 'Забыли Пароль?', 'personalize-login' ); ?></h3>
    <?php endif; ?>
 
    <p>
        <?php
        _e(
            "Введите адрес вашей электронной почты и мы вышлем вам ссылку, которую вы можете использовать, чтобы задать новый пароль.",
            'personalize_login'
        );
        ?>
    </p>

    <?php if ( $attributes['lost_password_sent'] ) : ?>
        <p class="login-info">
            <?php _e( 'Проверьте ссылку для сброса пароля в своей электронной почте.', 'personalize-login' ); ?>
        </p>
    <?php endif; ?>

    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
        <?php foreach ( $attributes['errors'] as $error ) : ?>
            <p>
                <?php echo $error; ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
 
    <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
        <p class="form-row">
            <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?>
                <input type="text" name="user_login" id="user_login">
        </p>
 
        <p class="lostpassword-submit">
            <input type="submit" name="submit" class="lostpassword-button"
                   value="<?php _e( 'Сбросить Пароль', 'personalize-login' ); ?>"/>
        </p>
    </form>
</div>