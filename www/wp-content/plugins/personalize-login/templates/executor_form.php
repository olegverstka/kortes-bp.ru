<?php
global $current_user, $wp_roles;
get_currentuserinfo();

if(isset($_POST['action'])){
	do_action( 'action_form_executor', $_POST );
}
?>
<p>Вы вошли как переводчик</p>
<form id="executorform" method="post" action="<?php the_permalink(); ?>" class="executor_form" enctype="multipart/form-data" name="executor_form">
    <p>
        <strong>Персональная информация</strong>
    </p>
	<p class="form-row">
		<label for="last-name"><?php _e( 'Фамилия', 'personalize-login' ); ?></label>
		<input type="text" name="last-name" id="last-name" value="<?php the_author_meta( 'user_lastname', $current_user->id ); ?>">
	</p>
	<p class="form-row">
		<label for="first_name"><?php _e( 'Имя', 'personalize-login' ); ?></label>
		<input type="text" name="first_name" id="first_name" value="<?php the_author_meta( 'user_firstname', $current_user->id ); ?>">
	</p>
	<p class="form-row">
		<label for="patronymic"><?php _e( 'Отчество', 'personalize-login' ); ?></label>
		<input type="text" name="patronymic" id="patronymic" value="<?php the_author_meta('patronymic', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="mobile_phone"><?php _e( 'Мобильный телефон', 'personalize-login' ); ?></label>
		<input type="text" name="mobile_phone" id="mobile_phone" value="<?php the_author_meta('mobile_phone', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="landline_phone"><?php _e( 'Стационарный телефон', 'personalize-login' ); ?></label>
		<input type="text" name="landline_phone" id="landline_phone" value="<?php the_author_meta('landline_phone', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="user_email"><?php _e( 'E-mail', 'personalize-login' ); ?></label>
		<input type="text" name="user_email" id="user_email" value="<?php the_author_meta( 'user_email', $current_user->id ); ?>">
	</p>
    <p class="form-row">
        <label for="date_birth">Дата рождения *<br>
        <input id="date_birth" class="input" type="text" name="date_birth" value="<?php the_author_meta( 'date_birth', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="citizenship">Гражданство<br>
        <input id="citizenship" class="input" type="text" name="citizenship" value="<?php the_author_meta( 'citizenship', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="residence_address">Адрес проживания<br>
        <input id="residence_address" class="input" type="text" name="residence_address" value="<?php the_author_meta( 'residence_address', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="photo">Фото<br>
        <div class="file_upload_2">
            <button class="button_2" type="button">Обзор</button>
            <div class="div_2">Загрузить файл</div>
            <?php wp_nonce_field( 'photo', 'fileup_nonce' ); ?>
            <input id="photo" class="input_2" type="file" name="photo">
        </div></label>
        <div class="upload_file_wrap">
            <a href="<?php the_author_meta( 'photo', $current_user->id ); ?>" class="fancy">
                <img src="<?php the_author_meta( 'photo', $current_user->id ); ?>" alt="">
            </a>
        </div>
    </p>
    <p>Образование</p>
    <p class="form-row">
        <label for="name_institution">Название учебного заведения *<br>
        <input id="name_institution" class="input" type="text" name="name_institution" value="<?php the_author_meta( 'name_institution', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="faculty">Факультет *<br>
        <input id="faculty" class="input" type="text" name="faculty" value="<?php the_author_meta( 'faculty', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="specialization">Специализация *<br>
        <input id="specialization" class="input" type="text" name="specialization" value="<?php the_author_meta( 'specialization', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="receipt_date">Дата поступления *<br>
        <input id="receipt_date" class="input" type="text" name="receipt_date" value="<?php the_author_meta( 'receipt_date', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="expiration_date">Дата окончания *<br>
        <input id="expiration_date" class="input" type="text" name="expiration_date" value="<?php the_author_meta( 'expiration_date', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="kopi">Копия диплома или студенческого билета *<br>
        <div class="file_upload_3">
            <button class="button_3" type="button">Обзор</button>
            <div class="div_3">Загрузить файл</div>
            <?php wp_nonce_field( 'copy_diploma', 'fileup_nonce_diplom' ); ?>
            <input id="kopi" class="input_3" type="file" name="copy_diploma">
        </div></label>
        <div class="upload_file_wrap">
            <a href="<?php the_author_meta( 'copy_diploma', $current_user->id ); ?>" class="fancy">
                <img src="<?php the_author_meta( 'copy_diploma', $current_user->id ); ?>" alt="">
            </a>
        </div>
    </p>
    <p class="form-row">
        <label for="professional_experience">Профессиональный опыт *<br>
        <select id="professional_experience" class="select" name="professional_experience">
            <?php $sel_prof_exper = get_the_author_meta('professional_experience', $current_user->id ); ?>
            <option value="0">Не выбрано</option>
            <option value="1" <?php selected( $sel_prof_exper, '1' )?> >Меньше года</option>
            <option value="2" <?php selected( $sel_prof_exper, '2' )?> >1-3 года</option>
            <option value="3" <?php selected( $sel_prof_exper, '3' )?> >4-10 лет</option>
            <option value="4" <?php selected( $sel_prof_exper, '4' )?> >Больше 10 лет</option>
        </select></label>
    </p>
    <p>
        <strong>Программы и навыки</strong>
    </p>
    <p class="form-row">
        <label class="form_label" for="software">Укажите каким программным обеспечением вы пользуетесь для перевода<br>
            <select class="multi_select" id="software" multiple="multiple" name="software[]">
                <?php
                    $software = array('Trados Studio', 'Google Translator Toolkit', 'CAT tools', 'Poedit', 'Другое');
                    foreach ($software as $key => $value) {
                    ?>
                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php
                    }
                ?>
            </select>
            <?php $sel_prof_exper = get_the_author_meta('software', $current_user->id ); ?>
            <?php if(is_array($sel_prof_exper)) : ?>
                <span class="result">
                    <strong>Были выбраны:</strong><br/> 
                    <?php 
                    $sel_prof_exper = get_the_author_meta('software', $current_user->id );
                    foreach ($sel_prof_exper as $key => $value_sel)
                        echo $value_sel . "<br/>";
                    ?>
                </span>
            <?php endif; ?>
        </label>
    </p>
    <p class="form-row">
        <label class="form_label" for="applications">Укажите какими стандартными приложениями вы пользуетесь при выполнении перевода<br>
        <select class="multi_select" id="applications" multiple="multiple" name="applications[]">
            <option value="Word">Word</option>
            <option value="Excel">Excel</option>
            <option value="OpenOffice">OpenOffice</option>
            <option value="Powerpoint">Powerpoint</option>
            <option value="Другое">Другое</option>
        </select>
        <?php $applications = get_the_author_meta('applications', $current_user->id ); ?>
            <?php if(is_array($sel_prof_exper)) : ?>
                <span class="result">
                    <strong>Были выбраны:</strong><br/> 
                    <?php 
                    $applications = get_the_author_meta('applications', $current_user->id );
                    foreach ($applications as $key => $value_app)
                        echo $value_app . "<br/>";
                    ?>
                </span>
            <?php endif; ?>
        </label>
    </p>
    <p class="form-row">
        <label class="form_label" for="graphic_applications">Укажите какими графическими приложениями вы пользуетесь<br>
        <select class="multi_select" id="graphic_applications" multiple="multiple" name="graphic_applications[]">
            <option value="Indesign">Indesign</option>
            <option value="Adobe Photoshop">Adobe Photoshop</option>
            <option value="Adobe Illustrator">Adobe Illustrator</option>
            <option value="Powerpoint">Powerpoint</option>
            <option value="Другое">Другое</option>
        </select>
         <?php $graphic_applications = get_the_author_meta('graphic_applications', $current_user->id ); ?>
            <?php if(is_array($graphic_applications)) : ?>
                <span class="result">
                    <strong>Были выбраны:</strong><br/> 
                    <?php 
                    $graphic_applications = get_the_author_meta('graphic_applications', $current_user->id );
                    foreach ($graphic_applications as $key => $value_grap)
                        echo $value_grap . "<br/>";
                    ?>
                </span>
            <?php endif; ?>
        </label>
    </p>
    <p class="form-row">
        <label for="choose_language">Укажите ваш родной язык *<br>
        <input id="choose_language" class="input" type="text" name="choose_language" value="<?php the_author_meta( 'choose_language', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="language_pair">Укажите вашу языковую пару или несколько пар для выполнения перевода (например, русский-английский, русский-немецкий) *<br>
        <input id="language_pair" class="input" type="text" name="language_pair" value="<?php the_author_meta( 'language_pair', $current_user->id ); ?>"></label>
    </p>
    <p class="form-row">
        <label for="native_language">Укажите возможность выполнения письменного перевода с родного на иностранный язык<br>
        <select id="native_language" class="select" name="native_language">
        <?php $native_language = get_the_author_meta('native_language', $current_user->id ); ?>
            <option value="0" <?php selected( $native_language, '0' )?> >Не выбрано</option>
            <option value="1" <?php selected( $native_language, '1' )?> >Да</option>
            <option value="2" <?php selected( $native_language, '2' )?> >Нет</option>
        </select></label>
    </p>
    <p class="form-row">
        <label for="field_translation">Укажите предпочитаемые сферы перевода (например, нефтегазовая отрасль или медицина…)<br>
        <input id="field_translation" class="input" type="text" name="field_translation" value="<?php the_author_meta( 'field_translation', $current_user->id ); ?>"></label>
    </p>
    <p>
        <strong>Оплата</strong>
    </p>
    <p class="form-row">
        <label for="receive_payment">Укажите наиболее удобный для Вас способ получения оплаты<br>
        <select id="receive_payment" class="select" name="receive_payment">
            <?php $receive_payment = get_the_author_meta('receive_payment', $current_user->id ); ?>
            <option value="0" <?php selected( $native_language, '0' )?> >Не выбрано</option>
            <option value="1" <?php selected( $native_language, '1' )?> >Visa&Master Card</option>
            <option value="2" <?php selected( $native_language, '2' )?> >PayPal</option>
            <option value="3" <?php selected( $native_language, '3' )?> >WebMoney</option>
            <option value="4" <?php selected( $native_language, '4' )?> >Yandex Деньги</option>
        </select></label>
    </p>
    <p>
        <strong>Дополнительные данные</strong>
    </p>
    <p class="form-row">
        <label for="business_trip">В случае соответствующего предложения, будет ли у вас возможность отправится в командировку<br>
        <select id="business_trip" class="select" name="business_trip">
            <?php $business_trip = get_the_author_meta('business_trip', $current_user->id ); ?>
            <option value="0" <?php selected( $business_trip, '0' )?> >Не выбрано</option>
            <option value="1" <?php selected( $business_trip, '1' )?> >Да</option>
            <option value="2" <?php selected( $business_trip, '2' )?> >Нет</option>
        </select></label>
    </p>
    <p>
        <strong>Резюме</strong>
    </p>
    <p class="form-row">
        <label for="summary">Если в дальнейшем вы хотите получать предложения от потенциальных работодателей, загрузите ваше резюме<br>
        <div class="file_upload_4">
            <button class="button_4" type="button">Обзор</button>
            <div class="div_4">Загрузить файл</div>
            <?php wp_nonce_field( 'summary', 'fileup_nonce_summary' ); ?>
            <input id="summary" class="input_4" type="file" name="summary">
        </div></label>
        <div class="upload_file_wrap">
            <a href="<?php the_author_meta( 'summary', $current_user->id ); ?>" class="fancy">
                <img src="<?php the_author_meta( 'summary', $current_user->id ); ?>" alt="">
            </a>
        </div>
    </p>
    <p>
        <a href="/usloviya-raboty-dlya-vneshtatnyh-perevodchikov/">Условия</a> (нажимая кнопку Сохранить вы подтверждаете ваше согласие с данными условиями)
    </p>
    <p class="signup-submit">
		<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e( 'Сохранить', 'personalize-login' ); ?>" />
		<?php wp_nonce_field( 'update-user' ) ?>
		<input name="action" type="hidden" id="action" value="true" />
		<input name="user_id" type="hidden" id="user_id" value="<?php echo $current_user->id; ?>" />
	</p>
</form>