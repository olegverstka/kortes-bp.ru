<?php
// Опции темы
include('functions/settings.php');
// Запрет на вход в админку
if (is_user_logged_in() && is_admin())
{
    global $current_user;
    get_currentuserinfo();
    $user_info = get_userdata($current_user->ID);
    if ( $user_info->user_level == 0 )
    {
        wp_redirect(get_bloginfo('home'), 301);;
    }
}
// Отключение админбара для всех пользователей кроме Администратора
if ( ! current_user_can( 'manage_options' ) ) {
	show_admin_bar( false );
}

// Убираем лишнее из секции head html документа
add_action('init', 'remove_else_link');

function remove_else_link() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head');
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'feed_links_extra', 3 ); 
}

/**
* Загружаемые скрипты и стили
*/
function load_style_script() {
	// Отключение wordpress библиотеки jQuery
	wp_enqueue_script('jquery');
	wp_deregister_script('jquery');
	
	// Подключение своей библиотеки jQuery и jQuery плагинов
	wp_register_script('vendor', get_template_directory_uri().'/js/vendor.js', array(), '1.0', true);
	wp_enqueue_script('vendor');

	// Подключение своих скриптов js и jQuery
	wp_register_script('main', get_template_directory_uri().'/js/main.js', array(), '1.0', true);
	wp_enqueue_script('main');

	// Подключение стилей к шаблону
	wp_enqueue_style('style', get_template_directory_uri().'/style.css');
}
/**
* Загружаем скрипты и стили
*/
add_action('wp_enqueue_scripts', 'load_style_script');
/**
* Поддержка меню
*/
register_nav_menus(array(
	'header_menu' => 'Меню в шапке',
	'footer_menu' => 'Меню в подвале'
));
/**
* Поддержка миниатюр
*/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(150, 150);
add_image_size('post-secondary-image-thumbnail', 300, 300);
/**
* Удаление атрибутов heigth и width у картинок
*/
add_filter('post_thumbnail_html', 'remove_width_attribute', 10);
add_filter('image_send_to_editor', 'remove_width_attribute', 10);
 
function remove_width_attribute($html) {
   $html = preg_replace('/(width|height)="\d*"\s/', "", $html);
   return $html;
}
/**
* Поддержка виджетов
*/
register_sidebar(array('name' => 'Слоган сайта', 
					   'id' => 'slogan_site', 
					   'class' => '', 
					   'before_widget' => '',
					   'after_widget'  => ''
					));
register_sidebar(array('name' => 'Телефон в шапке', 
					   'id' => 'contact_header', 
					   'before_widget' => '',
					   'after_widget'  => ''
					));
register_sidebar(array('name' => 'Язык сайта', 
					   'id' => 'lang',  
					   'before_widget' => '',
					   'after_widget'  => ''
					));
register_sidebar(array('name' => 'Меню в футтере', 
					   'id' => 'menu_foot', 
					   'before_widget' => '<div class="widget">',
					   'after_widget'  => '</div>', 
					   'before_title' => '<h3>', 
					   'after_title' => '</h3>'
					));
register_sidebar(array('name' => 'Текст в футтере', 
					   'id' => 'text_footer', 
					   'before_widget' => '<div class="widget">',
					   'after_widget'  => '</div>', 
					   'before_title' => '<h3>', 
					   'after_title' => '</h3>'
					));
register_sidebar(array('name' => 'Копирайты в футтере', 
					   'id' => 'copy_footer', 
					   'before_widget' => '<div class="widget">',
					   'after_widget'  => '</div>', 
					   'before_title' => '<h3>', 
					   'after_title' => '</h3>'
					));

/**
 * Обрезка текста (excerpt). Шоткоды вырезаются. Минимальное значение maxchar может быть 22.
 * version 2.2
 * 
 * @param  массив/строка $args аргументы. Смотирте переменную $default.
 * @return строка HTML
 */
function kama_excerpt( $args = '' ){
	global $post;

	$default = array(
		'maxchar'     => 350, // количество символов.
		'text'        => '',  // какой текст обрезать (по умолчанию post_excerpt, если нет post_content.
							  // Если есть тег <!--more-->, то maxchar игнорируется и берется все до <!--more--> вместе с HTML
		'save_format' => false, // Сохранять перенос строк или нет. Если в параметр указать теги, то они НЕ будут вырезаться: пр. '<strong><a>'
		'more_text'   => 'Читать дальше...', // текст ссылки читать дальше
		'echo'        => true, // выводить на экран или возвращать (return) для обработки.
	);

	if( is_array($args) )
		$rgs = $args;
	else
		parse_str( $args, $rgs );

	$args = array_merge( $default, $rgs );

	extract( $args );

	if( ! $text ){
		$text = $post->post_excerpt ? $post->post_excerpt : $post->post_content;

		$text = preg_replace ('~\[[^\]]+\]~', '', $text ); // убираем шоткоды, например:[singlepic id=3]
		// $text = strip_shortcodes( $text ); // или можно так обрезать шоткоды, так будет вырезан шоткод и конструкция текста внутри него
		// и только те шоткоды которые зарегистрированы в WordPress. И эта операция быстрая, но она в десятки раз дольше предыдущей 
		// (хотя там очень маленькие цифры в пределах одной секунды на 50000 повторений)

		// для тега <!--more-->
		if( ! $post->post_excerpt && strpos( $post->post_content, '<!--more-->') ){
			preg_match ('~(.*)<!--more-->~s', $text, $match );
			$text = trim( $match[1] );
			$text = str_replace("\r", '', $text );
			$text = preg_replace( "~\n\n+~s", "</p><p>", $text );

			$more_text = $more_text ? '<a class="kexc_moretext" href="'. get_permalink( $post->ID ) .'#more-'. $post->ID .'">'. $more_text .'</a>' : '';

			$text = '<p>'. str_replace( "\n", '<br />', $text ) .' '. $more_text .'</p>';

			if( $echo )
				return print $text;

			return $text;
		}
		elseif( ! $post->post_excerpt )
			$text = strip_tags( $text, $save_format );
	}   

	// Обрезаем
	if ( mb_strlen( $text ) > $maxchar ){
		$text = mb_substr( $text, 0, $maxchar );
		$text = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $text ); // убираем последнее слово, оно 99% неполное
	}

	// Сохраняем переносы строк. Упрощенный аналог wpautop()
	if( $save_format ){
		$text = str_replace("\r", '', $text );
		$text = preg_replace("~\n\n+~", "</p><p>", $text );
		$text = "<p>". str_replace ("\n", "<br />", trim( $text ) ) ."</p>";
	}

	//$out = preg_replace('@\*[a-z0-9-_]{0,15}\*@', '', $out); // удалить *some_name-1* - фильтр сммайлов

	if( $echo ) return print $text;

	return $text;
}
/**
* Цены на переводы язык оригинала
*/
function price_posts_origin() {
	$labels = array(
		'name' => 'Цены язык оригинала', // Основное название типа записи
		'singular_name' => 'Цена язык оригинала', // отдельное название записи типа Book
		'add_new' => 'Добавить новую',
		'add_new_item' => 'Добавить новую цену',
		'edit_item' => 'Редактировать цену',
		'new_item' => 'Новая цена',
		'view_item' => 'Посмотреть цену',
		'search_items' => 'Найти цену',
		'not_found' =>  'Цены не найдены',
		'not_found_in_trash' => 'В корзине цен не найдено',
		'parent_item_colon' => '',
		'menu_name' => 'Цены язык оригинала'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title')
	);
	register_post_type('price_origin',$args);
}
add_action('init', 'price_posts_origin');
/**
* подключаем функцию активации мета блока (my_extra_fields)
*/ 
add_action('add_meta_boxes', 'my_extra_fields_origin', 1);

function my_extra_fields_origin() {
	add_meta_box( 'extra_fields', 'Цены для разных пакетов', 'extra_fields_box_func_origin', 'price_origin', 'normal', 'high'  );
}
// код блока
function extra_fields_box_func_origin( $post ){
?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="">Цена для пакета "Стандартный":</label>
				</th>
				<td>
					<input id="" class="regular-text" type="text" value="<?php echo get_post_meta($post->ID, 'standart', 1); ?>" name="extra[standart]">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="">Цена для пакета "Профессиональный":</label>
				</th>
				<td>
					<input id="" class="regular-text" type="text" value="<?php echo get_post_meta($post->ID, 'professional', 1); ?>" name="extra[professional]">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="">Цена для пакета "Премиум":</label>
				</th>
				<td>
					<input id="" class="regular-text" type="text" value="<?php echo get_post_meta($post->ID, 'premium', 1); ?>" name="extra[premium]">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="">Установить языком по умолчанию</label>
				</th>
				<td>
					<select name="extra[select]" id="">
						<?php $sel_v = get_post_meta($post->ID, 'select', 1); ?>
						<option value="0">Нет</option>
						<option value="1" <?php selected( $sel_v, '1' )?> >Да</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'my_extra_fields_update_origin', 0);

/* Сохраняем данные, при сохранении поста */
function my_extra_fields_update_origin( $post_id ){
	if ( !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['extra']) ) return false;	

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['extra'] = array_map('trim', $_POST['extra']);
	foreach( $_POST['extra'] as $key=>$value ){
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
	}
	return $post_id;
}
/**
* Цены на переводы язык перевода
*/
function price_posts_translation() {
	$labels = array(
		'name' => 'Цены язык перевода', // Основное название типа записи
		'singular_name' => 'Цена язык перевода', // отдельное название записи типа Book
		'add_new' => 'Добавить новую',
		'add_new_item' => 'Добавить новую цену',
		'edit_item' => 'Редактировать цену',
		'new_item' => 'Новая цена',
		'view_item' => 'Посмотреть цену',
		'search_items' => 'Найти цену',
		'not_found' =>  'Цены не найдены',
		'not_found_in_trash' => 'В корзине цен не найдено',
		'parent_item_colon' => '',
		'menu_name' => 'Цены язык перевода'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title')
	);
	register_post_type('price_translation',$args);
}
add_action('init', 'price_posts_translation');
/**
* подключаем функцию активации мета блока (my_extra_fields)
*/ 
add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_extra_fields() {
	add_meta_box( 'extra_fields', 'Цены для разных пакетов', 'extra_fields_box_func', 'price_translation', 'normal', 'high'  );
}
// код блока
function extra_fields_box_func( $post ){
?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="">Цена для пакета "Стандартный":</label>
				</th>
				<td>
					<input id="" class="regular-text" type="text" value="<?php echo get_post_meta($post->ID, 'standart', 1); ?>" name="extra[standart]">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="">Цена для пакета "Профессиональный":</label>
				</th>
				<td>
					<input id="" class="regular-text" type="text" value="<?php echo get_post_meta($post->ID, 'professional', 1); ?>" name="extra[professional]">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="">Цена для пакета "Премиум":</label>
				</th>
				<td>
					<input id="" class="regular-text" type="text" value="<?php echo get_post_meta($post->ID, 'premium', 1); ?>" name="extra[premium]">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="">Установить языком по умолчанию</label>
				</th>
				<td>
					<select name="extra[select_too]" id="">
						<?php $sel_v_too = get_post_meta($post->ID, 'select_too', 1); ?>
						<option value="0">Нет</option>
						<option value="1" <?php selected( $sel_v_too, '1' )?> >Да</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'my_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function my_extra_fields_update( $post_id ){
	if ( !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['extra']) ) return false;	

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['extra'] = array_map('trim', $_POST['extra']);
	foreach( $_POST['extra'] as $key=>$value ){
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
	}
	return $post_id;
}
// Блокировка спамеров
function check_referrer() {
	if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == “”) {
		wp_die( __('Please enable referrers in your browser, or, if you\'re a spammer, bugger off!') );
	}
}

function save_profile_fields( $user_id ) {
	if (!current_user_can('edit_user', $user_id ))
		return false;
	update_usermeta( $user_id, 'citizenship', $_POST['citizenship'] );
	update_usermeta( $user_id, 'date_birth', $_POST['date_birth'] );
	update_usermeta( $user_id, 'number', $_POST['number'] );
	update_usermeta( $user_id, 'residence_address', $_POST['residence_address'] );
}
 
add_action( 'personal_options_update', 'save_profile_fields' );
add_action( 'edit_user_profile_update', 'save_profile_fields' );