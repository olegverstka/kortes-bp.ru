<?php global $mytheme; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name');?></title>
        <?php wp_head(); ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- modal -->
        <div id="order" class="modal">
            <div id="wpcf7-f74-p20-o1" class="wpcf7" lang="ru-RU" dir="ltr" role="form">
                <div class="screen-reader-response"></div>
                <form id="feedback2" class="wpcf7-form" novalidate="novalidate" enctype="multipart/form-data" method="post" action="">
                    <div style="display: none;">
                        <input type="hidden" value="74" name="_wpcf7">
                        <input type="hidden" value="4.3.1" name="_wpcf7_version">
                        <input type="hidden" value="ru_RU" name="_wpcf7_locale">
                        <input type="hidden" value="wpcf7-f74-p20-o1" name="_wpcf7_unit_tag">
                        <input type="hidden" value="5163eb3c09" name="_wpnonce">
                    </div>
                    <div class="application">
                        <h2>Оставьте заявку на индивидуальный расчет стоимости Вашего перевода</h2>
                        <p>
                            <span class="wpcf7-form-control-wrap first_name">
                                <input id="fistName3" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" type="text" placeholder="Введите Ваше имя" aria-invalid="false" aria-required="true" size="40" value="" name="first_name">
                            </span>
                            <span class="wpcf7-form-control-wrap phone">
                                <input id="phone3" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" type="text" placeholder="Введите Ваш телефон" aria-invalid="false" aria-required="true" size="40" value="" name="phone">
                            </span>
                            <span class="wpcf7-form-control-wrap email">
                                <input id="email3" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-email" type="email" placeholder="Введите Ваше e-mail" aria-invalid="false" size="40" value="" name="email">
                            </span>
                        </p>
                        <div class="file_upload_1">
                            <button class="button_1" type="button">Обзор</button>
                            <div class="div_1">Загрузить файл</div>
                            <input class="wpcf7-form-control wpcf7-file input_1" type="file" aria-invalid="false" size="40" name="file-569">
                        </div>
                        <p>
                            <a id="add_comm_1" href="#">Добавить комментарий</a>
                        </p>
                        <div class="wrap-comment_1">
                            <span class="wpcf7-form-control-wrap comment">
                                <textarea id="t_comm" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false" rows="10" cols="40" name="comment"></textarea>
                            </span>
                        </div>
                        <p>
                            <input id="send3" class="wpcf7-form-control wpcf7-submit" type="submit" value="Отправить">
                        </p>
                    </div>
                    <div class="wpcf7-response-output wpcf7-display-none"></div>
                </form>
            </div>
        </div>
        <!-- end modal -->
        <a href="#order" class="order-red">Заказать перевод</a>
        <header class="header">
        	<nav class="navigation">
        		<div class="container">
        			<div class="row">
                        <div class="col-md-10">
                            <div class="main_menu">
                                <?php wp_nav_menu(array(
                                    'theme_location'  => 'header_menu'
                                    )); ?>
                            </div><!-- .main_menu -->
                            <button class="toggle_mnu">
                                <span class="sandwich">
                                    <span class="sw-topper"></span>
                                    <span class="sw-bottom"></span>
                                    <span class="sw-footer"></span>
                                </span>
                            </button>
                        </div>
                        <div class="col-md-2 col-xs-8">
                            <a href="#order" class="order">Заказать перевод</a>
                        </div>
        			</div>
        		</div>
        	</nav><!-- .navigation -->
        	<div class="container">
        		<div class="row">
        			<div class="col-md-6 col-xs-6 logo">
                        <a href="/">
                            <img src="<?php bloginfo('template_url');?>/img/logo.png" alt="Логотип сайта">
                        </a>
                    </div><!-- .logo -->
                    <div class="col-md-6 col-xs-6 links-head">
                        <?php
                        global $post;
                        $pagename=$post->post_name;
                        switch ($pagename) {
                            case "member-account":
                                if ( is_user_logged_in() ) {
                                    $loginoutlink = wp_loginout('index.php', false);
                        ?>
                                    <a href="/member-account/">Личный аккаунт</a>
                                    <?php echo $loginoutlink; ?>
                        <?php } else { ?>
                                    <a href="/member-register/">Регистрация</a>
                                    <a href="/member-account/">Личный аккаунт</a>
                        <?php }
                            break;
                            default: ?>
                                <a href="/member-register/">Регистрация</a>
                                <a href="/member-account/">Личный аккаунт</a>
                        <?php break; } ?>
                    </div><!-- .links-head -->
                    <div class="col-md-12 zag">
                        <h1>Профессиональные переводы любого формата<br /> <span>в течение 24 часов</span></h1>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-5 application-wrap">
                        <div id="wpcf7-f4-p20-o1" class="wpcf7" lang="ru-RU" dir="ltr" role="form">
                            <div class="screen-reader-response"></div>
                                <form id="feedback" class="wpcf7-form" novalidate="novalidate" enctype="multipart/form-data" method="post" action="">
                                    <div style="display: none;">
                                        <input type="hidden" value="4" name="_wpcf7">
                                        <input type="hidden" value="4.3.1" name="_wpcf7_version">
                                        <input type="hidden" value="ru_RU" name="_wpcf7_locale">
                                        <input type="hidden" value="wpcf7-f4-p20-o1" name="_wpcf7_unit_tag">
                                        <input type="hidden" value="bd0fdc9d5c" name="_wpnonce">
                                    </div>
                                    <div class="application">
                                        <h2>Оставьте заявку на индивидуальный расчет стоимости Вашего перевода</h2>
                                        <p>
                                            <span class="wpcf7-form-control-wrap first_name">
                                                <input id="fistName2" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" type="text" placeholder="Введите Ваше имя" aria-invalid="false" aria-required="true" size="40" value="" name="first_name">
                                            </span>
                                            <span class="wpcf7-form-control-wrap phone">
                                                <input id="phone2" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" type="text" placeholder="Введите Ваш телефон" aria-invalid="false" aria-required="true" size="40" value="" name="phone">
                                            </span>
                                            <span class="wpcf7-form-control-wrap email">
                                                <input id="email2" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-email" type="email" placeholder="Введите Ваше e-mail" aria-invalid="false" size="40" value="" name="email">
                                            </span>
                                        </p>
                                        <div class="file_upload_2">
                                            <button class="button_2" type="button">Обзор</button>
                                            <div class="div_2">Загрузить файл</div>
                                            <input class="wpcf7-form-control wpcf7-file input_2" type="file" aria-invalid="false" size="40" name="file-upload">
                                        </div>
                                        <p>
                                            <a id="add_comm_2" href="#">Добавить комментарий</a>
                                        </p>
                                        <div class="wrap-comment_2">
                                            <span class="wpcf7-form-control-wrap comment">
                                                <textarea id="t_comm" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false" rows="10" cols="40" name="comment"></textarea>
                                            </span>
                                        </div>
                                        <p>
                                            <input id="send2" class="wpcf7-form-control wpcf7-submit" type="submit" value="Отправить">
                                        </p>
                                    </div>
                                <div class="wpcf7-response-output wpcf7-display-none"></div>
                            </form>
                        </div>
                    </div><!-- .application-wrap -->
        		</div>
        	</div>
        </header>