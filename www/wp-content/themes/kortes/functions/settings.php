<?php
class ControlPanel {
// Устанавливаем значения по умолчанию
var $default_settings = array(
 'phone' => '495 122-12-12',
 'email' => 'info@site.ru'
 );
 var $options;

 function ControlPanel() {
 add_action('admin_menu', array(&$this, 'add_menu'));
 if (!is_array(get_option('themadmin')))
 add_option('themadmin', $this->default_settings);
 $this->options = get_option('themadmin');
 }

 function add_menu() {
 add_theme_page('WP Theme Options', 'Опции темы', 8, "themadmin", array(&$this, 'optionsmenu'));
 }

 // Сохраняем значения формы с настройками 
 function optionsmenu() {
 if ($_POST['ss_action'] == 'save') {
 $this->options["phone"] = $_POST['cp_phone'];
 $this->options["email"] = $_POST['cp_email'];
 $this->options["skype"] = $_POST['cp_skype'];
 $this->options["vk"] = $_POST['cp_vk'];
 $this->options["fb"] = $_POST['cp_fb'];
 $this->options["tw"] = $_POST['cp_tw'];
 $this->options["ok"] = $_POST['cp_ok'];
 $this->options["gog"] = $_POST['cp_gog'];
 $this->options["metrika"] = $_POST['cp_metrika'];
 update_option('themadmin', $this->options);
 echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 400px; margin-left: 17px; margin-top: 17px;"><p>Ваши изменения <strong>сохранены</strong>.</p></div>';
 }
 // Создаем форму для настроек
 echo '<form action="" method="post" class="themeform">';
 echo '<input type="hidden" id="ss_action" name="ss_action" value="save">';

 print '<div class="cptab"><br />
 <b>Настройки темы</b>
 <br />
 <h3>Контакты</h3>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">
				<label for="cp_phone">Телефон</label>
			</th>
			<td>
				<input id="cp_phone" class="regular-text" type="text" value="'.$this->options["phone"].'" name="cp_phone" placeholder="Телефон">
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="cp_email">E-mail</label>
			</th>
			<td>
				<input id="cp_email" class="regular-text" type="text" value="'.$this->options["email"].'" name="cp_email" placeholder="Email">
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="cp_email">Skype</label>
			</th>
			<td>
				<input id="cp_skype" class="regular-text" type="text" value="'.$this->options["skype"].'" name="cp_skype" placeholder="skype">
			</td>
		</tr>
	</tbody>
</table>
 <h3>Социальные сети</h3>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">
				<label for="cp_vk">В контакте</label>
			</th>
			<td>
				<input id="cp_vk" class="regular-text" type="text" value="'.$this->options["vk"].'" name="cp_vk" placeholder="В контакте">
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="cp_tw">Twitter</label>
			</th>
			<td>
				<input id="cp_tw" class="regular-text" type="text" value="'.$this->options["tw"].'" name="cp_tw" placeholder="Twitter">
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="cp_fb">Facebook</label>
			</th>
			<td>
				<input id="cp_fb" class="regular-text" type="text" value="'.$this->options["fb"].'" name="cp_fb" placeholder="Facebook">
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="cp_ok">Одноклассники</label>
			</th>
			<td>
				<input id="cp_ok" class="regular-text" type="text" value="'.$this->options["ok"].'" name="cp_ok" placeholder="Одноклассники">
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="cp_gog">Google +</label>
			</th>
			<td>
				<input id="cp_gog" class="regular-text" type="text" value="'.$this->options["gog"].'" name="cp_gog" placeholder="Google +">
			</td>
		</tr>
	</tbody>
</table>

 <h3>Код в footer.php</h3>
 <p><textarea placeholder="Здесь можно прописать коды счетчиков или дополнительных скриптов" style="width:300px;" name="cp_metrika" id="cp_metrika">'.stripslashes($this->options["metrika"]).'</textarea><label> - здесь можно прописать коды счетчиков или дополнительных скриптов</label></p>

 </div><br />';
 echo '<input type="submit" value="Сохранить" name="cp_save" class="dochanges" />';
 echo '</form>';
 }
}
$cpanel = new ControlPanel();
$mytheme = get_option('themadmin');
?>