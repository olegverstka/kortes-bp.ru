<div class="login-form-container">
    <?php if ( $attributes['show_title'] ) : ?>
        <h2><?php _e( 'Вход', 'personalize-login' ); ?></h2>
    <?php endif; ?>

    <?php if ( $attributes['registered'] ) : ?>
        <p class="login-info">
            <?php
            printf(
                __( 'Вы успешно зарегистрированы на сайте <strong>%s</strong>. Мы послали на указаный вами адрес электронной почты пароль для входа.', 'personalize-login' ),
                get_bloginfo( 'name' )
            );
            ?>
        </p>
    <?php endif; ?>
    
    <!-- Показать сообщения об ошибках если таковые имеются -->
	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
	    <?php foreach ( $attributes['errors'] as $error ) : ?>
	        <p class="login-error">
	            <?php echo $error; ?>
	        </p>
	    <?php endforeach; ?>
	<?php endif; ?>
	
    <!-- Показать ошибки, если  таковые имеются -->
	<?php if ( $attributes['logged_out'] ) : ?>
	    <p class="login-info">
	        <?php _e( 'Вы вышли из Аккаунта не желаете авторизоваться снова.?', 'personalize-login' ); ?>
	    </p>
	<?php endif; ?>

    <?php if ( $attributes['password_updated'] ) : ?>
        <p class="login-info">
            <?php _e( 'Ваш пароль был изменен. Вы можете авторизоваться.', 'personalize-login' ); ?>
        </p>
    <?php endif; ?>
    
    <?php
        wp_login_form(
            array(
                'label_username' => __( 'Ваш E-mail', 'personalize-login' ),
                'label_log_in' => __( 'Вход', 'personalize-login' ),
                'redirect' => $attributes['redirect'],
            )
        );
    ?>
     
    <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
        <?php _e( 'Потеряли пароль?', 'personalize-login' ); ?>
    </a>
</div>