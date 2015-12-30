<?php
/**
 * Plugin Name:       Calculator translate
 * Description:       Плагин расчета стоимости перевода с отправкой данных на email администратору.
 * Version:           1.0.0
 * Author:            Балюк Олег
 * Plugin URI:        http://webfrontdev.ru/
 * License:           GPL-2.0+
 * Text Domain:       calcu-trans
 * Author URI:        http://webfrontdev.ru/
 */

class Calculator_translate_Plugin {
	/**
	 * Инициализирует плагин.
	 *
	 * Для быстрой инициализации в конструктор добавить
	 * необходимые фильтры и действия
	 */
	public function __construct() {
		add_shortcode( 'custom-calc-form', array( $this, 'render_calc_form' ) );
		add_action( 'action_calc_form', array( $this, 'send_calc_form' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'calc_scripts_styles' ) );
	}
	/**
	 * Хук активации плагина.
	 *
	 * Создает все страницы WordPress, необходимые плагину.
	 */
	public static function plugin_activated() {

	}

	 /**
	 * Хук деактивации плагина.
	 *
	 * Удаляет созданное плагином.
	 */
	public static function plugin_deactivated() {

	}

	/**
	 * Подключение скриптов и стилей.
	 */
	public static function calc_scripts_styles() {
		// Подключение своих скриптов js и jQuery
		wp_register_script('culc_translate', plugins_url('/js/culc_translate.js', __FILE__), array( 'vendor' ), '1.0', true);
		wp_enqueue_script('culc_translate');
	}

	 /**
	 * Шорткод для отображения формы калькулятора
	 *
	 * @param  array   $attributes  атрибуты шоткода.
	 * @param  string  $content     текстовое содержимое (не используется).
	 *
	 * @return string  
	 */
	public function render_calc_form( $attributes, $content = null ) {
		// разбор атрибутов
		$default_attributes = array( 'show_title' => false );
		$attributes = shortcode_atts( $default_attributes, $attributes );
		$show_title = $attributes['show_title'];
	 
		
		 
		// отобразить регистрационную форму, используя шаблон
		return $this->get_template_html( 'calc_form', $attributes );
	}

	 /**
	 * Выводит содержимое данного шаблона в строку и возвращает ее.
	 *
	 * @param string $template_name имя шаблона для отображения (без .php)
	 * @param array  $attributes    PHP переменные шаблона
	 *
	 * @return string               Содержимое шаблона
	 */
	private function get_template_html( $template_name, $attributes = null ) {
	    if ( ! $attributes ) {
	        $attributes = array();
	    }
	 
	    ob_start();
	 
	    do_action( 'personalize_login_before_' . $template_name );
	 
	    require( 'templates/' . $template_name . '.php');
	 
	    do_action( 'personalize_login_after_' . $template_name );
	 
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}

	 /**
	 *
	 * Отправляет форму на email администратора сайта.
	 *
	 */
	function send_calc_form( $post ) {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$pages = $_POST['pages'];
			$transfrom = $_POST['transfrom'];
			$transto = $_POST['transto'];
			if($_POST['notarial'] == 'on') {
				$notarial = 'Да';
			}
			if($_POST['verstka'] == 'on') {
				$verstka = 'Да';
			}
			$price = $_POST['price'];
			$first_name = $_POST['first_name'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$file = $_POST['file-upload'];
			$comment = $_POST['comment'];
			$admin_email = get_option('admin_email');
			if( wp_verify_nonce( $_POST['fileup_nonce'], 'upload_calc' ) ){
				if($_FILES['upload_calc']['error'] === UPLOAD_ERR_OK) {
					if ( ! function_exists( 'wp_handle_upload' ) ) 
						require_once( ABSPATH . 'wp-admin/includes/file.php' );

					$file = &$_FILES['upload_calc'];
					$overrides = array( 'test_form' => false );

					$movefile = wp_handle_upload( $file, $overrides );
				}
			}
			remove_all_filters( 'wp_mail_from' );
			remove_all_filters( 'wp_mail_from_name' );
			add_filter( 'wp_mail_from', 'vortal_wp_mail_from' );
			function vortal_wp_mail_from( $email_address ){
				return 'no-reply@kortes-bp.ru';
			}
			$attachments = $movefile['file'];
			$message = 'На сайте был произведен расчет стоимости перевода'. "\r\n";
			$message .= 'Имя клиента - ' . $first_name . "\r\n"; 
			$message .= 'Телефон клиента - ' . $phone . "\r\n";
			$message .= 'Email клиента - ' . $email . "\r\n";
			$message .= 'Комментарий клиента - ' . $comment . "\r\n";
			$message .= 'Количество страниц - ' . $pages . "\r\n";
			$message .= 'Язык оригинала - ' . $transfrom . "\r\n";
			$message .= 'Язык перевода - ' . $transto . "\r\n";
			$message .= 'Нотариальное заверение - ' . $notarial . "\r\n";
			$message .= 'Верстка - ' . $verstka . "\r\n";
			$message .= 'Цена подсчитаная калькулятором - ' . $price . "\r\n";
			$headers = 'From: Kortes <no-reply@kortes-bp.ru>' . "\r\n";
			/*** Загружаем WordPress ***/
			require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
			wp_mail($admin_email, 'Расчет стоимости перевода в калькуляторе',  $message, $headers, $attachments);

			$first_name = $_POST['first_name'];
			$email = $_POST['email'];
			$message = "Здравствуйте, ". $first_name ."!\r\nСпасибо за оставленую заявку мы с вами свяжемся для уточнения деталей!";
			wp_mail($email, 'Спасибо!', $message, $headers);
		}
	}
}

// Инициализация плагина
$personalize_login_pages_plugin = new Calculator_translate_Plugin();

// Создание пользовательских страниц при активации плагина
register_activation_hook( __FILE__, array( 'Calculator_translate_Plugin', 'plugin_activated' ) );
register_deactivation_hook( __FILE__, array( 'Calculator_translate_Plugin', 'plugin_deactivated' ) );