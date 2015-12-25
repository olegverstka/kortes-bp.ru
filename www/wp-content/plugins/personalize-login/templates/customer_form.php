<?php
global $current_user, $wp_roles;
get_currentuserinfo();

if(isset($_POST['action'])){
	do_action( 'action_form', $_POST );
}
?>
<p>Вы вошли как заказчик</p>
<form method="post" action="<?php the_permalink(); ?>" class="form_customer">
	<p>Персональная информация</p>
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
		<label for="skype"><?php _e( 'Skype', 'personalize-login' ); ?></label>
		<input type="text" name="skype" id="skype" value="<?php the_author_meta('skype', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="organizations"><?php _e( 'Название организации', 'personalize-login' ); ?></label>
		<input type="text" name="organizations" id="organizations" value="<?php the_author_meta('organizations', $current_user->id);?>">
	</p>
	<p>Адрес</p>
	<p class="form-row">
		<label for="index"><?php _e( 'Почтовый индекс', 'personalize-login' ); ?></label>
		<input type="text" name="index" id="index" value="<?php the_author_meta('index', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="edge"><?php _e( 'Край', 'personalize-login' ); ?></label>
		<input type="text" name="edge" id="edge" value="<?php the_author_meta('edge', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="region"><?php _e( 'Область', 'personalize-login' ); ?></label>
		<input type="text" name="region" id="region" value="<?php the_author_meta('region', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="area"><?php _e( 'Район', 'personalize-login' ); ?></label>
		<input type="text" name="area" id="area" value="<?php the_author_meta('area', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="city"><?php _e( 'Город', 'personalize-login' ); ?></label>
		<input type="text" name="city" id="city" value="<?php the_author_meta('city', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="street"><?php _e( 'Улица', 'personalize-login' ); ?></label>
		<input type="text" name="street" id="street" value="<?php the_author_meta('street', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="house_number"><?php _e( 'Номер дома/строения', 'personalize-login' ); ?></label>
		<input type="text" name="house_number" id="house_number" value="<?php the_author_meta('house_number', $current_user->id);?>">
	</p>
	<p class="form-row">
		<label for="number_office"><?php _e( 'Номер офиса/квартиры', 'personalize-login' ); ?></label>
		<input type="text" name="number_office" id="number_office" value="<?php the_author_meta('number_office', $current_user->id);?>">
	</p>
	<p class="signup-submit">
		<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e( 'Сохранить', 'personalize-login' ); ?>" />
		<?php wp_nonce_field( 'update-user' ) ?>
		<input name="action" type="hidden" id="action" value="true" />
		<input name="user_id" type="hidden" id="user_id" value="<?php echo $current_user->id; ?>" />
	</p>
</form>

