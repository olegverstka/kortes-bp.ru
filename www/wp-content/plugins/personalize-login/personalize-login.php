<?php
/**
 * Plugin Name:       Personalize Login
 * Description:       Плагин кастомизированой регистрации, авторизации, востановления пароля на сайте. И разграничения доступа к личному кабинету пользователя взависимости от того кто зашел на сайт Исполнитель или Заказчик.
 * Version:           1.0.0
 * Author:            Балюк Олег
 * Plugin URI:        http://webfrontdev.ru/
 * License:           GPL-2.0+
 * Text Domain:       personalize-login
 * Author URI:        http://webfrontdev.ru/
 */
 
class Personalize_Login_Plugin {
 
    /**
     * Инициализирует плагин.
     *
     * Для быстрой инициализации в конструктор добавить
     * необходимые фильтры и действия
     */
    public function __construct() {
    	add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );
 		add_shortcode( 'custom-login-form', array( $this, 'render_login_form' ) );
 		add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
 		add_action( 'wp_logout', array( $this, 'redirect_after_logout' ) );
 		add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );
 		add_shortcode( 'custom-register-form', array( $this, 'render_register_form' ) );
 		add_action( 'login_form_register', array( $this, 'redirect_to_custom_register' ) );
 		add_action( 'login_form_register', array( $this, 'do_register_user' ) );
 		add_filter( 'admin_init' , array( $this, 'register_settings_fields' ) );
 		add_action( 'wp_print_footer_scripts', array( $this, 'add_captcha_js_to_footer' ) );
 		add_shortcode( 'account-info', array( $this, 'render_account_form' ) );
 		add_action( 'action_form', array( $this, 'save_profile_fields' ) );
 		add_action( 'action_form_executor', array( $this, 'save_profile_executor_fields' ) );
 		add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );
 		add_shortcode( 'custom-password-lost-form', array( $this, 'render_password_lost_form' ) );
 		add_action( 'login_form_lostpassword', array( $this, 'do_password_lost' ) );
 		add_filter( 'retrieve_password_message', array( $this, 'replace_retrieve_password_message' ), 10, 4 );
 		add_action( 'login_form_rp', array( $this, 'redirect_to_custom_password_reset' ) );
		add_action( 'login_form_resetpass', array( $this, 'redirect_to_custom_password_reset' ) );
		add_shortcode( 'custom-password-reset-form', array( $this, 'render_password_reset_form' ) );
		add_action( 'login_form_rp', array( $this, 'do_password_reset' ) );
		add_action( 'login_form_resetpass', array( $this, 'do_password_reset' ) );
		add_action( 'show_user_profile', array( $this, 'show_profile_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'show_profile_fields' ) );
    }

     /**
	 * Хук активации плагина.
	 *
	 * Создает все страницы WordPress, необходимые плагину.
	 */
	public static function plugin_activated() {
		// Создание ролей пользователей сайта при активации плагина
		add_role('executor', 'Исполнитель', array( 'chance_executor' => true, 'level_0' => true ) );
		add_role('customer', 'Заказчик', array( 'chance_customer' => true, 'level_0' => true ) );
		// Добавление возможностей
		add_action('init', function(){
    		$role = get_role('executor');
    		$role->add_cap('chance_executor');
		});
		add_action('init', function(){
    		$role = get_role('customer');
    		$role->add_cap('chance_customer');
		});


		// Создание дополнительных полей в личном кабинете


	    // Информация, необходимая для создания страниц плагина
	    $page_definitions = array(
	        'member-login' => array(
	            'title' => __( 'Вход', 'personalize-login' ),
	            'content' => '[custom-login-form]'
	        ),
	        'member-account' => array(
	            'title' => __( 'Ваш аккаунт', 'personalize-login' ),
	            'content' => '[account-info]'
	        ),
	        'member-register' => array(
                'title' => __( 'Регистрация', 'personalize-login' ),
                'content' => '[custom-register-form]'
            ),
            'member-password-lost' => array(
                'title' => __( 'Забыли пароль?', 'personalize-login' ),
                'content' => '[custom-password-lost-form]'
            ),
            'member-password-reset' => array(
                'title' => __( 'Введите новый пароль', 'personalize-login' ),
                'content' => '[custom-password-reset-form]'
            )
	    );
	 
	    foreach ( $page_definitions as $slug => $page ) {
	        // Проверка, что страница ещё не существует
	        $query = new WP_Query( 'pagename=' . $slug );
	        if ( ! $query->have_posts() ) {
	            // Добавить страницу, используя данные из массива
	            wp_insert_post(
	                array(
	                    'post_content'   => $page['content'],
	                    'post_name'      => $slug,
	                    'post_title'     => $page['title'],
	                    'post_status'    => 'publish',
	                    'post_type'      => 'page',
	                    'ping_status'    => 'closed',
	                    'comment_status' => 'closed',
	                )
	            );
	        }
	    }
	}

	 /**
	 * Хук деактивации плагина.
	 *
	 * Удаляет созданное плагином.
	 */
	public static function plugin_deactivated() {
		// Удаление возможностей
		$role = get_role( 'executor' );
		$role->remove_cap( 'chance_executor' );
		
		$role = get_role( 'customer' );
		$role->remove_cap( 'chance_customer' );
		
		// Удаление ролей
		remove_role( 'executor' );
		remove_role( 'customer' );
	}
	
	 /**
	 * Щорткод для отображения формы авторизации
	 *
	 * @param  array   $attributes  атрибуты шоткода.
	 * @param  string  $content     текстовое содержимое (не используется).
	 *
	 * @return string  
	 */
	public function render_login_form( $attributes, $content = null ) {
	    // разбор атрибутов
	    $default_attributes = array( 'show_title' => false );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	    $show_title = $attributes['show_title'];
	 
	    if ( is_user_logged_in() ) {
	        return __( 'Вы уже авторизованы.', 'personalize-login' );
	    }
	     
	    $attributes['redirect'] = '';
	    if ( isset( $_REQUEST['redirect_to'] ) ) {
	        $attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
	    }

	     // сообщение об ошибке
		$errors = array();
		if ( isset( $_REQUEST['login'] ) ) {
		    $error_codes = explode( ',', $_REQUEST['login'] );
		 
		    foreach ( $error_codes as $code ) {
		        $errors []= $this->get_error_message( $code );
		    }
		}
		$attributes['errors'] = $errors;

		// Проверяем, пользователя на выход
        $attributes['logged_out'] = isset( $_REQUEST['logged_out'] ) && $_REQUEST['logged_out'] == true;

        // Проверка, что пользователь только что зарегистрировался
		$attributes['registered'] = isset( $_REQUEST['registered'] );

		//Проверка, если пользователь обновил пароль
		$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';
	     
	    // отобразить регистрационную форму, используя шаблон
	    return $this->get_template_html( 'login_form', $attributes );
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
	 * Перенаправление пользователя на пользовательскую страницу входа  вместо wp-login.php.
	 */
	function redirect_to_custom_login() {
	    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	        $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;
	     
	        //если пользователь авторизован
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user( $redirect_to );
	            exit;
	        }
	 
	        // Отальные перенаправить
	        $login_url = home_url( 'member-login' );
	        if ( ! empty( $redirect_to ) ) {
	            $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
	        }
	 
	        wp_redirect( $login_url );
	        exit;
	    }
	}
	
	 /**
	 * Перенаправляет пользователя на нужную страницу в зависимости от ли он / она
	 * Является администратором или нет.
	 *
	 * @param string $redirect_to   необязательный URL redirect_to для пользователей администратора
	 */
	 
	private function redirect_logged_in_user( $redirect_to = null ) {
	    $user = wp_get_current_user();
	    if ( user_can( $user, 'manage_options' ) ) {
	        if ( $redirect_to ) {
	            wp_safe_redirect( $redirect_to );
	        } else {
	            wp_redirect( admin_url() );
	        }
	    } else {
	        wp_redirect( home_url( 'member-account' ) );
	    }
	}
	
	/**
	 * Перенаправление пользователя после аутентификации, если есть какие-либо ошибки.
	 *
	 * @param Wp_User|Wp_Error  $user       Авторизованный пользователь, либо ошибки, которые имели место во время входа в систему.
	 * @param string            $username   Имя пользователя, используемое для входа.
	 * @param string            $password   Пароль используемый для входа.
	 *
	 * @return Wp_User|Wp_Error Вошедший в систему пользователь, или информацию об ошибках, если были ошибки.
	 */
	function maybe_redirect_at_authenticate( $user, $username, $password ) {
	    
	    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	        if ( is_wp_error( $user ) ) {
	            $error_codes = join( ',', $user->get_error_codes() );
	 
	            $login_url = home_url( 'member-login' );
	            $login_url = add_query_arg( 'login', $error_codes, $login_url );
	 
	            wp_redirect( $login_url );
	            exit;
	        }
	    }
	 
	    return $user;
	}
	
	 /**
	 * Находит и возвращает сообщение об ошибке совпадения для данного кода ошибки.
	 *
	 * @param string $error_code    Код ошибки.
	 *
	 * @return string              Cобщение об ошибке.
	 */
	private function get_error_message( $error_code ) {
        switch ( $error_code ) {

            //ошибки авторизации
            case 'empty_username':
                return __( 'У вас есть Имя пользователя, верно?', 'personalize-login' );

            case 'empty_password':
                return __( 'Вы должны ввести пароль для входа.', 'personalize-login' );

            case 'invalid_username':
                return __(
                    "Мы не нашли пользователя с таким Имнем пользователя почты. Может быть, вы использовали другой при регистрации?",
                    'personalize-login'
                );

            case 'incorrect_password':
                $err = __(
                    "Введенный пароль не верен.  <a href='%s'>Вы забыли свой ​​пароль?</a>",
                    'personalize-login'
                );
                return sprintf( $err, wp_lostpassword_url() );

            //ошибки регистрации
            case 'email':
                return __( 'Введите корректный адрес электронной почты.', 'personalize-login' );

            case 'email_exists':
                return __( 'Пользователь с таким адресом электронной почты уже существует.', 'personalize-login' );

            case 'closed':
                return __( 'Регистрация новых пользователей в данный момент закрыта.', 'personalize-login' );

            // Ошибки сброса пароля
			case 'empty_username':
			    return __( 'Вам нужно ввести ваш адрес электронной почты чтобы продолжить.', 'personalize-login' );
			 
			case 'invalid_email':
			case 'invalidcombo':
			    return __( 'Нет пользователей, зарегистрированных с таким адресом электронной почты.', 'personalize-login' );

			// Cмена пароля
			case 'expiredkey':
			case 'invalidkey':
			      return __( 'Ссылка сброса пароля, которую Вы использовали, не действительна.', 'personalize-login' );
			 
			case 'password_reset_mismatch':
			      return __( "К сожалению пароли не совпадают.", 'personalize-login' );
			 
			case 'password_reset_empty':
			      return __( "К сожалению, мы не принимаем пустые пароли.", 'personalize-login' );

            //ошибка капчи
            case 'captcha':
                return __( 'Проверка Google reCAPTCHA не удалась. Вы робот?', 'personalize-login' );

            default:
                break;
        }

        return __( 'Произошла неизвестная ошибка Пожалуйста, повторите попытку позже.', 'personalize-login' );
    }
	
	 /**
	 * Перенаправление на  страницу входа после того, как пользователь вышел.
	 */
	public function redirect_after_logout() {
	    $redirect_url = home_url( 'member-login?logged_out=true' );
	    wp_safe_redirect( $redirect_url );
	    exit;
	}

	 /**
	 * Возвращает URL, на который пользователь должен быть перенаправлен после успешной авторизации.
	 *
	 * @param string           $redirect_to           URL-адрес перенаправления.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User  если Логин прошла успешно, в противном случае объект  WP_Error.
	 *
	 * @return string Redirect URL
	 */
	public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {
	    $redirect_url = home_url();
	 
	    if ( ! isset( $user->ID ) ) {
	        return $redirect_url;
	    }
	 
	    if ( user_can( $user, 'manage_options' ) ) {
	        //  Используйте параметр redirect_to если он установлен, в противном случае перенаправления администратора приборной панели.
	        if ( $requested_redirect_to == '' ) {
	            $redirect_url = admin_url();
	        } else {
	            $redirect_url = $requested_redirect_to;
	        }
	    } else {
	        //Простым пользователям всегда идти к своей странице аккаунта после регистрации
	        $redirect_url = home_url( 'member-account' );
	    }
	 
	    return wp_validate_redirect( $redirect_url, home_url() );
	}

	/**
     * Шотткод для отображения формы регистрации пользователя.
     *
     * @param  array   $attributes  Атрибуты шорткода.
     * @param  string  $content     Текстовый контент шорткода. Не используется.
     *
     * @return string  Форма регистрации
     */
    public function render_register_form( $attributes, $content = null ) {
        // Разбор атрибутов
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );

        if ( is_user_logged_in() ) {
            return __( 'Вы уже авторизованы.', 'personalize-login' );
        } elseif ( ! get_option( 'users_can_register' ) ) {
            return __( 'Регистрация новых пользователей в настоящее время не производится.', 'personalize-login' );
        } else {
        	 // Получить возможные ошибки из запроса
			$attributes['errors'] = array();
			if ( isset( $_REQUEST['register-errors'] ) ) {
			    $error_codes = explode( ',', $_REQUEST['register-errors'] );
			 
			    foreach ( $error_codes as $error_code ) {
			        $attributes['errors'] []= $this->get_error_message( $error_code );
			    }
			}

			// капча
            $attributes['recaptcha_site_key'] = get_option( 'personalize-login-recaptcha-site-key', null );

            return $this->get_template_html( 'register_form', $attributes );
        }
    }

     /**
	 * Перенаправляет пользователя на кастомную страницу регистрации 
	 * вместо wp-login.php?action=register.
	 */
	public function redirect_to_custom_register() {
	    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user();
	        } else {
	            wp_redirect( home_url( 'member-register' ) );
	        }
	        exit;
	    }
	}

	 /**
	 * Проверяет и затем завершает процесс регистрации пользователя, если все прошло хорошо.
	 *
	 * @param string $email         электронная почта нового пользователя
	 * @param string $first_name    имя нового пользователя
	 * @param string $last_name     фамилия нового пользователя
	 *
	 * @return int|WP_Error         ID созданного пользователя, или код ошибки
	 */
	private function register_user( $email, $first_name, $last_name, $role, $patronymic, $mobile_phone, $landline_phone ) {
	    $errors = new WP_Error();
	 
	    // E-mail адрес используется и как имя пользователя и адрес электронной почты. Это также единственный
	    // Параметр, мы должны проверить
	    if ( ! is_email( $email ) ) {
	        $errors->add( 'email', $this->get_error_message( 'email' ) );
	        return $errors;
	    }
	 
	    if ( username_exists( $email ) || email_exists( $email ) ) {
	        $errors->add( 'email_exists', $this->get_error_message( 'email_exists') );
	        return $errors;
	    }
	 
	    // генерация пароля
	    $password = wp_generate_password( 12, false );
	 
	    $user_data = array(
	        'user_login'    => $email,
	        'user_email'    => $email,
	        'user_pass'     => $password,
	        'first_name'    => $first_name,
	        'last_name'     => $last_name,
	        'nickname'      => $first_name,
	        'role'          => $role,
	    );
	 
	    $user_id = wp_insert_user( $user_data );
	    if( ! is_wp_error( $user_id ) ) {
			update_user_meta($user_id, 'patronymic',$patronymic);
			update_user_meta($user_id, 'mobile_phone',$mobile_phone);
		}
	    wp_new_user_notification( $user_id, $password );
	 
	    return $user_id;
	}

	 /**
	 * Обработка регистрации нового пользователя.
	 *
	 * Подключается через хук "login_form_register" активируемый в  wp-login.php
	 *
	 */
	public function do_register_user() {
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
            $redirect_url = home_url( 'member-register' );

            if ( ! get_option( 'users_can_register' ) ) {
                // Регистрация ошибки, показать сообщение
                $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
            } elseif ( ! $this->verify_recaptcha() ) {
                // Recaptcha провалена, показ ошибки
                $redirect_url = add_query_arg( 'register-errors', 'captcha', $redirect_url );
            } else {
                $email = $_POST['email'];
                $first_name = sanitize_text_field( $_POST['first_name'] );
                $last_name = sanitize_text_field( $_POST['last_name'] );
                $patronymic = sanitize_text_field( $_POST['patronymic'] );
                $mobile_phone = sanitize_text_field( $_POST['mobile_phone'] );
                $landline_phone = sanitize_text_field( $_POST['landline_phone'] );
                $role = sanitize_text_field( $_POST['role'] );

                $result = $this->register_user( $email, $first_name, $last_name, $role, $patronymic, $mobile_phone, $landline_phone );

                if ( is_wp_error( $result ) ) {
                    /// Разбор ошибок
                    $errors = join( ',', $result->get_error_codes() );
                    $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
                } else {
                    // Удача редирект на авторизацию
                    $redirect_url = home_url( 'member-login' );
                    $redirect_url = add_query_arg( 'registered', $email, $redirect_url );
                }
            }

            wp_redirect( $redirect_url );
            exit;
        }
    }

	 /**
	 * Регистрация настроек для плагина.
	 */
	public function register_settings_fields() {
	    // Создание полей для вода настроек reCAPTCHA
	    register_setting( 'general', 'personalize-login-recaptcha-site-key' );
	    register_setting( 'general', 'personalize-login-recaptcha-secret-key' );
	 
	    add_settings_field(
	        'personalize-login-recaptcha-site-key',
	        '<label for="personalize-login-recaptcha-site-key">' . __( 'reCAPTCHA Ключ' , 'personalize-login' ) . '</label>',
	        array( $this, 'render_recaptcha_site_key_field' ),
	        'general'
	    );
	 
	    add_settings_field(
	        'personalize-login-recaptcha-secret-key',
	        '<label for="personalize-login-recaptcha-secret-key">' . __( 'reCAPTCHA Секретный ключ' , 'personalize-login' ) . '</label>',
	        array( $this, 'render_recaptcha_secret_key_field' ),
	        'general'
	    );
	}
	 
	public function render_recaptcha_site_key_field() {
	    $value = get_option( 'personalize-login-recaptcha-site-key', '' );
	    echo '<input type="text" id="personalize-login-recaptcha-site-key" name="personalize-login-recaptcha-site-key" value="' . esc_attr( $value ) . '" />';
	}
	 
	public function render_recaptcha_secret_key_field() {
	    $value = get_option( 'personalize-login-recaptcha-secret-key', '' );
	    echo '<input type="text" id="personalize-login-recaptcha-secret-key" name="personalize-login-recaptcha-secret-key" value="' . esc_attr( $value ) . '" />';
	}

	/**
     * Подключение скрипта капчи вниз страницы
     * at the end of the page.
     */
    public function add_captcha_js_to_footer() {
        echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
    }

     /**
	 * Проверяет reCAPTCHA 
	 * 
	 *
	 * @return bool True если CAPTCHA возвращает OK , иначе false.
	 */
	private function verify_recaptcha() {
	    // получение данных из капчи
	    if ( isset ( $_POST['g-recaptcha-response'] ) ) {
	        $captcha_response = $_POST['g-recaptcha-response'];
	    } else {
	        return false;
	    }
	 
	    // Получение ответа от гугл
	    $response = wp_remote_post(
	        'https://www.google.com/recaptcha/api/siteverify',
	        array(
	            'body' => array(
	                'secret' => get_option( 'personalize-login-recaptcha-secret-key' ),
	                'response' => $captcha_response
	            )
	        )
	    );
	 
	    $success = false;
	    if ( $response && is_array( $response ) ) {
	        $decoded_response = json_decode( $response['body'] );
	        $success = $decoded_response->success;
	    }
	 
	    return $success;
	}

	/**
     * Шотткод для отображения формы в личном кабинете пользователя.
     *
     * @param  array   $attributes  Атрибуты шорткода.
     * @param  string  $content     Текстовый контент шорткода. Не используется.
     *
     * @return string  Форма регистрации
     */
    public function render_account_form( $attributes, $content = null ) {
    	if ( is_user_logged_in() ) {
			global $user_ID;
			if( current_user_can( 'chance_executor' ) ){
				return $this->get_template_html( 'executor_form', $attributes );
			}
			if( current_user_can( 'chance_customer' ) ){
				return $this->get_template_html( 'customer_form', $attributes );
			}
		} else {
			echo 'Вы не авторизованы! Вам нужно <a class="link" href="/member-login/">войти</a> на сайт!';
		};
    }

    /**
     * обновление данных о пользователе с ролью заказчик в личном кабинете.
     *
     * @param  array   $attributes  Атрибуты шорткода.
     * @param  string  $content     Текстовый контент шорткода. Не используется.
     *
     * @return string  Форма регистрации
     */
	function save_profile_fields( $post ) {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$user_id = $_POST['user_id'];
			if (!current_user_can('edit_user', $user_id ))
			return false;
			update_usermeta( $user_id, 'last_name', $_POST['last-name'] );
			update_usermeta( $user_id, 'first_name', $_POST['first_name'] );
			update_usermeta( $user_id, 'patronymic', $_POST['patronymic'] );
			update_usermeta( $user_id, 'landline_phone', $_POST['landline_phone'] );
			update_usermeta( $user_id, 'mobile_phone', $_POST['mobile_phone'] );
			update_usermeta( $user_id, 'user_email', $_POST['user_email'] );
			update_usermeta( $user_id, 'skype', $_POST['skype'] );
			update_usermeta( $user_id, 'organizations', $_POST['organizations'] );
			update_usermeta( $user_id, 'index', $_POST['index'] );
			update_usermeta( $user_id, 'edge', $_POST['edge'] );
			update_usermeta( $user_id, 'region', $_POST['region'] );
			update_usermeta( $user_id, 'area', $_POST['area'] );
			update_usermeta( $user_id, 'city', $_POST['city'] );
			update_usermeta( $user_id, 'street', $_POST['street'] );
			update_usermeta( $user_id, 'house_number', $_POST['house_number'] );
			update_usermeta( $user_id, 'number_office', $_POST['number_office'] );
		}
	}

	/**
     * обновление данных о пользователе с ролью исполнитель в личном кабинете.
     *
     * @param  array   $attributes  Атрибуты шорткода.
     * @param  string  $content     Текстовый контент шорткода. Не используется.
     *
     * @return string  Форма регистрации
     */
	function save_profile_executor_fields( $post ) {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$user_id = $_POST['user_id'];
			if (!current_user_can('edit_user', $user_id ))
			return false;
			if( wp_verify_nonce( $_POST['fileup_nonce'], 'photo' ) ){
				if($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
					if ( ! function_exists( 'wp_handle_upload' ) ) 
					require_once( ABSPATH . 'wp-admin/includes/file.php' );

					$file = &$_FILES['photo'];
					$overrides = array( 'test_form' => false );
					$movefile = wp_handle_upload( $file, $overrides );
					update_usermeta($user_id, 'photo', $movefile['url']);
				}
			}
			if( wp_verify_nonce( $_POST['fileup_nonce_diplom'], 'copy_diploma' ) ){
				if($_FILES['copy_diploma']['error'] === UPLOAD_ERR_OK) {
					if ( ! function_exists( 'wp_handle_upload' ) ) 
						require_once( ABSPATH . 'wp-admin/includes/file.php' );

					$file = &$_FILES['copy_diploma'];
					$overrides = array( 'test_form' => false );

					$movefile = wp_handle_upload( $file, $overrides );
					update_usermeta($user_id, 'copy_diploma', $movefile['url']);
				}
			}
			if( wp_verify_nonce( $_POST['fileup_nonce_summary'], 'summary' ) ){
				if($_FILES['summary']['error'] === UPLOAD_ERR_OK) {
					if ( ! function_exists( 'wp_handle_upload' ) ) 
						require_once( ABSPATH . 'wp-admin/includes/file.php' );

					$file = &$_FILES['summary'];
					$overrides = array( 'test_form' => false );

					$movefile = wp_handle_upload( $file, $overrides );
					update_usermeta($user_id, 'summary', $movefile['url']);
				}
			}
			if($_POST['last-name'] != '') update_usermeta( $user_id, 'last_name', $_POST['last-name'] );
			if($_POST['first_name'] != '') update_usermeta( $user_id, 'first_name', $_POST['first_name'] );
			if($_POST['patronymic'] != '') update_usermeta( $user_id, 'patronymic', $_POST['patronymic'] );
			if($_POST['landline_phone'] != '') update_usermeta( $user_id, 'landline_phone', $_POST['landline_phone'] );
			if($_POST['mobile_phone'] != '') update_usermeta( $user_id, 'mobile_phone', $_POST['mobile_phone'] );
			if($_POST['user_email'] != '') update_usermeta( $user_id, 'user_email', $_POST['user_email'] );
			if($_POST['date_birth'] != '') update_usermeta( $user_id, 'date_birth', $_POST['date_birth'] );
			if($_POST['citizenship'] != '') update_usermeta( $user_id, 'citizenship', $_POST['citizenship'] );
			if($_POST['residence_address'] != '') update_usermeta( $user_id, 'residence_address', $_POST['residence_address'] );
			if($_POST['name_institution'] != '') update_usermeta( $user_id, 'name_institution', $_POST['name_institution'] );
			if($_POST['faculty'] != '') update_usermeta( $user_id, 'faculty', $_POST['faculty'] );
			if($_POST['specialization'] != '') update_usermeta( $user_id, 'specialization', $_POST['specialization'] );
			if($_POST['receipt_date'] != '') update_usermeta( $user_id, 'receipt_date', $_POST['receipt_date'] );
			if($_POST['expiration_date'] != '') update_usermeta( $user_id, 'expiration_date', $_POST['expiration_date'] );
			if($_POST['choose_language'] != '') update_usermeta( $user_id, 'choose_language', $_POST['choose_language'] );
			if($_POST['language_pair'] != '') update_usermeta( $user_id, 'language_pair', $_POST['language_pair'] );
			if($_POST['field_translation'] != '') update_usermeta( $user_id, 'field_translation', $_POST['field_translation'] );
			if($_POST['professional_experience'] != '') update_usermeta( $user_id, 'professional_experience', $_POST['professional_experience'] );
			if($_POST['software'] != '') update_usermeta( $user_id, 'software', $_POST['software'] );
			if($_POST['applications'] != '') update_usermeta( $user_id, 'applications', $_POST['applications'] );
			if($_POST['graphic_applications'] != '') update_usermeta( $user_id, 'graphic_applications', $_POST['graphic_applications'] );
			if($_POST['native_language'] != '') update_usermeta( $user_id, 'native_language', $_POST['native_language'] );
			if($_POST['receive_payment'] != '') update_usermeta( $user_id, 'receive_payment', $_POST['receive_payment'] );
			if($_POST['business_trip'] != '') update_usermeta( $user_id, 'business_trip', $_POST['business_trip'] );
		}
	}

	 /**
	 * Перенаправляет пользователя на пользоваетльскую страницу "Забыли пароль?"
	 * вместо страницы по умолчанию wp-login.php?action=lostpassword.
	 */
	public function redirect_to_custom_lostpassword() {
	    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user();
	            exit;
	        }
	 
	        wp_redirect( home_url( 'member-password-lost' ) );
	        exit;
	    }
	}

	 /**
	 * Шорткод для отображения пользовательской формы сброса пароля.
	 *
	 * @param  array   $attributes  Параметры Шорткода.
	 * @param  string  $content     Текстовый контент шорткода. Не используется.
	 *
	 * @return string  HTML код формы сброса пароля
	 */
	public function render_password_lost_form( $attributes, $content = null ) {
	    // Разбор параметров Шорткода
	    $default_attributes = array( 'show_title' => false );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 
	    if ( is_user_logged_in() ) {
	        return __( 'Вы уже вошли как.', 'personalize-login' );
	    } else {
	    	// Проверка, а не запросил ли пользователь новый пароль
			$attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';
	        
	        // Получение ошибок из параметров ответа
            $attributes['errors'] = array();
            if ( isset( $_REQUEST['errors'] ) ) {
                $error_codes = explode( ',', $_REQUEST['errors'] );
 
                foreach ( $error_codes as $error_code ) {
                    $attributes['errors'] []= $this->get_error_message( $error_code );
                }
            }
	        
	        return $this->get_template_html( 'password_lost_form', $attributes );
	    }
	}

	 /**
     * Инициирует сброс пароля.
     */
    public function do_password_lost() {
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
            $errors = retrieve_password();
            if ( is_wp_error( $errors ) ) {
                // Ошибки
                $redirect_url = home_url( 'member-password-lost' );
                $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
            } else {
                // Отправка письма
                $redirect_url = home_url( 'member-login' );
                $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
            }
 
            wp_redirect( $redirect_url );
            exit;
        }
    }

     /**
     * Возвращает тело сообщения для сброса пароля почты.
     * Вызывается через фильтр retrieve_password_message.
     *
     * @param string  $message    Сообщение отправляемое по умолчанию.
     * @param string  $key        Ключ активации.
     * @param string  $user_login Имя пользователя.
     * @param WP_User $user_data  WP_User объект.
     *
     * @return string   Отправка сообщения
     */
    public function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
        // Создание нового сообщения
        $msg  = __( 'Привет!', 'personalize-login' ) . "\r\n\r\n";
        $msg .= sprintf( __( 'Вы запросили сброс пароля для Вашей учетной записи, используя адрес электронной почты %s.', 'personalize-login' ), $user_login ) . "\r\n\r\n";
        $msg .= __( "Если это была ошибка, или Вы не запрашивали сброс пароля, просто проигнорируйте это письмо.", 'personalize-login' ) . "\r\n\r\n";
        $msg .= __( 'Чтобы сбросить Ваш пароль, перейдите по следующему адресу:', 'personalize-login' ) . "\r\n\r\n";
        $msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
        $msg .= __( 'Спасибо!', 'personalize-login' ) . "\r\n";
 
        return $msg;
    }

     /**
	 * Redirects to the custom password reset page, or the login page
	 * if there are errors.
	 */
	public function redirect_to_custom_password_reset() {
	    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
	        // Verify key / login combo
	        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
	        if ( ! $user || is_wp_error( $user ) ) {
	            if ( $user && $user->get_error_code() === 'expired_key' ) {
	                wp_redirect( home_url( 'member-login?login=expiredkey' ) );
	            } else {
	                wp_redirect( home_url( 'member-login?login=invalidkey' ) );
	            }
	            exit;
	        }
	 
	        $redirect_url = home_url( 'member-password-reset' );
	        $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
	        $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
	 
	        wp_redirect( $redirect_url );
	        exit;
	    }
	}

	 /**
     *  Шорткод для отображения пользовательской формы смены пароля.
     *
     * @param  array   $attributes  Параметры Шорткода.
     * @param  string  $content     Текстовый контент шорткода. Не используется.
     *
     * @return string  HTML код формы сбмены пароля
     */
    public function render_password_reset_form( $attributes, $content = null ) {
        // Разбор параметиров шорткода
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );
 
        if ( is_user_logged_in() ) {
            return __( 'Вы уже авторизованы.', 'personalize-login' );
        } else {
            if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
                $attributes['login'] = $_REQUEST['login'];
                $attributes['key'] = $_REQUEST['key'];
 
                // Сообщения об ошибках
                $errors = array();
                if ( isset( $_REQUEST['error'] ) ) {
                    $error_codes = explode( ',', $_REQUEST['error'] );
 
                    foreach ( $error_codes as $code ) {
                        $errors []= $this->get_error_message( $code );
                    }
                }
                $attributes['errors'] = $errors;
 
                return $this->get_template_html( 'password_reset_form', $attributes );
            } else {
                return __( 'Не действительная для смены пароля.', 'personalize-login' );
            }
        }
    }

    /**
     * Смена пароля пользователя если пароль был отправлен через форму
     */
    public function do_password_reset() {
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
            $rp_key = $_REQUEST['rp_key'];
            $rp_login = $_REQUEST['rp_login'];
 
            $user = check_password_reset_key( $rp_key, $rp_login );
 
            if ( ! $user || is_wp_error( $user ) ) {
                if ( $user && $user->get_error_code() === 'expired_key' ) {
                    wp_redirect( home_url( 'member-login?login=expiredkey' ) );
                } else {
                    wp_redirect( home_url( 'member-login?login=invalidkey' ) );
                }
                exit;
            }
 
            if ( isset( $_POST['pass1'] ) ) {
                if ( $_POST['pass1'] != $_POST['pass2'] ) {
                    // Пароли не совпадают
                    $redirect_url = home_url( 'member-password-reset' );
 
                    $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                    $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                    $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
 
                wp_redirect( $redirect_url );
                exit;
            }
 
                if ( empty( $_POST['pass1'] ) ) {
                    // Пароль пустой
                    $redirect_url = home_url( 'member-password-reset' );
 
                    $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                    $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                    $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
 
                    wp_redirect( $redirect_url );
                    exit;
                }
 
                // Проверка параметров ОК, сброс пароля
                reset_password( $user, $_POST['pass1'] );
                wp_redirect( home_url( 'member-login?password=changed' ) );
            } else {
                echo "Недопустимый запрос.";
            }
 
            exit;
        }
    }

    /**
     * Дополнительные поля в профиле пользователя в админке
     */
    function show_profile_fields( $user ) { ?>
		<h3>Поля для Переводчика</h3>
		<table class="form-table">
			<tr>
				<th><label for="patronymic">Отчество</label></th>
				<td><input class="regular-text" type="text" name="patronymic" id="patronymic" value="<?php echo esc_attr(get_the_author_meta('patronymic',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="mobile_phone">Мобильный телефон</label></th>
				<td><input class="regular-text" type="text" name="mobile_phone" id="mobile_phone" value="<?php echo esc_attr(get_the_author_meta('mobile_phone',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="landline_phone">Стационарный телефон</label></th>
				<td><input class="regular-text" type="text" name="landline_phone" id="landline_phone" value="<?php echo esc_attr(get_the_author_meta('landline_phone',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="date_birth">Дата рождения</label></th>
				<td><input class="regular-text" id="date_birth" class="input" type="text" name="date_birth" value="<?php echo esc_attr(get_the_author_meta('date_birth',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="citizenship">Гражданство</label></th>
				<td><input class="regular-text" id="citizenship" class="input" type="text" name="citizenship" value="<?php echo esc_attr(get_the_author_meta('citizenship',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="residence_address">Адрес проживания</label></th>
				<td><input class="regular-text" id="residence_address" class="input" type="text" name="residence_address" value="<?php echo esc_attr(get_the_author_meta('residence_address',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="">Фото</label></th>
				<td><img src="<?php echo esc_attr(get_the_author_meta('photo',$user->ID));?>" width="200" alt=""><br /></td>
			</tr>
			<tr>
				<th><label for="name_institution">Название учебного заведения</label></th>
				<td><input class="regular-text" id="name_institution" class="input" type="text" name="name_institution" value="<?php echo esc_attr(get_the_author_meta('name_institution',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="faculty">Факультет</label></th>
				<td><input class="regular-text" id="faculty" class="input" type="text" name="faculty" value="<?php echo esc_attr(get_the_author_meta('faculty',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="specialization">Специализация</label></th>
				<td><input class="regular-text" id="specialization" class="input" type="text" name="specialization" value="<?php echo esc_attr(get_the_author_meta('specialization',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="receipt_date">Дата поступления</label></th>
				<td><input class="regular-text" id="receipt_date" class="input" type="text" name="receipt_date" value="<?php echo esc_attr(get_the_author_meta('receipt_date',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="expiration_date">Дата окончания</label></th>
				<td><input class="regular-text" id="expiration_date" class="input" type="text" name="expiration_date" value="<?php echo esc_attr(get_the_author_meta('expiration_date',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="">Копия диплома или студенческого билета</label></th>
				<td><img src="<?php echo esc_attr(get_the_author_meta('copy_diploma',$user->ID));?>" width="200" alt=""><br /></td>
			</tr>
			<tr>
				<th><label for="">Профессиональный опыт</label></th>
				<td>
					<select id="professional_experience" class="select" name="professional_experience">
			            <?php $sel_prof_exper = get_the_author_meta('professional_experience', $user->ID ); ?>
			            <option value="0">Не выбрано</option>
			            <option value="1" <?php selected( $sel_prof_exper, '1' )?> >Меньше года</option>
			            <option value="2" <?php selected( $sel_prof_exper, '2' )?> >1-3 года</option>
			            <option value="3" <?php selected( $sel_prof_exper, '3' )?> >4-10 лет</option>
			            <option value="4" <?php selected( $sel_prof_exper, '4' )?> >Больше 10 лет</option>
			        </select><br />
			    </td>
			</tr>
			<tr>
				<th><label for="">Укажите каким программным обеспечением вы пользуетесь для перевода</label></th>
				<td><?php 
	                    $sel_prof_exper = get_the_author_meta('software', $user->ID );
	                    if($sel_prof_exper != 0) {
		                    foreach ($sel_prof_exper as $key => $value_sel)
		                        echo $value_sel . "<br/>";
	                    }
                    ?>
				<br /></td>
			</tr>
			<tr>
				<th><label for="">Укажите какими стандартными приложениями вы пользуетесь при выполнении перевода</label></th>
				<td><?php 
	                    $applications = get_the_author_meta('applications', $user->ID );
	                    if($applications != 0) {
		                    foreach ($applications as $key => $value_app)
		                        echo $value_app . "<br/>";
	                    }
                    ?><br />
                </td>
			</tr>
			<tr>
				<th><label for="">Укажите какими графическими приложениями вы пользуетесь</label></th>
				<td>
					<?php 
	                    $graphic_applications = get_the_author_meta('graphic_applications', $user->ID );
	                    if($graphic_applications != 0) {
	                    	foreach ($graphic_applications as $key => $value_grap)
	                        	echo $value_grap . "<br/>";
	                    }
                    ?><br />
                </td>
			</tr>
			<tr>
				<th><label for="choose_language">Укажите ваш родной язык</label></th>
				<td><input class="regular-text" id="choose_language" class="input" type="text" name="choose_language" value="<?php echo esc_attr(get_the_author_meta('choose_language',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="language_pair">Укажите вашу языковую пару или несколько пар для выполнения перевода</label></th>
				<td><input class="regular-text" id="language_pair" class="input" type="text" name="language_pair" value="<?php echo esc_attr(get_the_author_meta('language_pair',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="language_pair">Укажите возможность выполнения письменного перевода с родного на иностранный язык</label></th>
				<td>
					<select id="native_language" class="select" name="native_language">
			        	<?php $native_language = get_the_author_meta('native_language',$user->ID); ?>
			            <option value="0" <?php selected( $native_language, '0' )?> >Не выбрано</option>
			            <option value="1" <?php selected( $native_language, '1' )?> >Да</option>
			            <option value="2" <?php selected( $native_language, '2' )?> >Нет</option>
			        </select><br />
			    </td>
			</tr>
			<tr>
				<th><label for="field_translation">Укажите предпочитаемые сферы перевода</label></th>
				<td><input class="regular-text" id="field_translation" class="input" type="text" name="field_translation" value="<?php echo esc_attr(get_the_author_meta('field_translation',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="receive_payment">Укажите наиболее удобный для Вас способ получения оплаты</label></th>
				<td>
					<select id="receive_payment" class="select" name="receive_payment">
			            <?php $receive_payment = get_the_author_meta('receive_payment', $current_user->id ); ?>
			            <option value="0" <?php selected( $native_language, '0' )?> >Не выбрано</option>
			            <option value="1" <?php selected( $native_language, '1' )?> >Visa&Master Card</option>
			            <option value="2" <?php selected( $native_language, '2' )?> >PayPal</option>
			            <option value="3" <?php selected( $native_language, '3' )?> >WebMoney</option>
			            <option value="4" <?php selected( $native_language, '4' )?> >Yandex Деньги</option>
			        </select><br />
			    </td>
			</tr>
			<tr>
				<th><label for="business_trip">В случае соответствующего предложения, будет ли у вас возможность отправится в командировку</label></th>
				<td>
					<select id="business_trip" class="select" name="business_trip">
			            <?php $business_trip = get_the_author_meta('business_trip', $user->ID ); ?>
			            <option value="0" <?php selected( $business_trip, '0' )?> >Не выбрано</option>
			            <option value="1" <?php selected( $business_trip, '1' )?> >Да</option>
			            <option value="2" <?php selected( $business_trip, '2' )?> >Нет</option>
			        </select><br />
			    </td>
			</tr>
			<tr>
				<th><label for="summary">Если в дальнейшем вы хотите получать предложения от потенциальных работодателей, загрузите ваше резюме</label></th>
				<td><img src="<?php echo esc_attr(get_the_author_meta('summary',$user->ID));?>" width="200" alt=""><br /></td>
			</tr>
		</table>
		<h3>Поля для Заказчика</h3>
		<table class="form-table">
			<tr>
				<th><label for="patronymic">Отчество</label></th>
				<td><input class="regular-text" type="text" name="patronymic" id="patronymic" value="<?php echo esc_attr(get_the_author_meta('patronymic',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="mobile_phone">Мобильный телефон</label></th>
				<td><input class="regular-text" type="text" name="mobile_phone" id="mobile_phone" value="<?php echo esc_attr(get_the_author_meta('mobile_phone',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="landline_phone">Стационарный телефон</label></th>
				<td><input class="regular-text" type="text" name="landline_phone" id="landline_phone" value="<?php echo esc_attr(get_the_author_meta('landline_phone',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="skype">Skype</label></th>
				<td><input class="regular-text" type="text" name="skype" id="skype" value="<?php echo esc_attr(get_the_author_meta('skype',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="organizations">Название организации</label></th>
				<td><input class="regular-text" type="text" name="organizations" id="organizations" value="<?php echo esc_attr(get_the_author_meta('organizations',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="index">Почтовый индекс</label></th>
				<td><input class="regular-text" type="text" name="index" id="index" value="<?php echo esc_attr(get_the_author_meta('index',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="edge">Край</label></th>
				<td><input class="regular-text" type="text" name="edge" id="edge" value="<?php echo esc_attr(get_the_author_meta('edge',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="region">Область</label></th>
				<td><input class="regular-text" type="text" name="region" id="region" value="<?php echo esc_attr(get_the_author_meta('region',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="area">Район</label></th>
				<td><input class="regular-text" type="text" name="area" id="area" value="<?php echo esc_attr(get_the_author_meta('area',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="city">Город</label></th>
				<td><input class="regular-text" type="text" name="city" id="city" value="<?php echo esc_attr(get_the_author_meta('city',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="street">Улица</label></th>
				<td><input class="regular-text" type="text" name="street" id="street" value="<?php echo esc_attr(get_the_author_meta('street',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="house_number">Номер дома/строения</label></th>
				<td><input class="regular-text" type="text" name="house_number" id="house_number" value="<?php echo esc_attr(get_the_author_meta('house_number',$user->ID));?>"><br /></td>
			</tr>
			<tr>
				<th><label for="number_office">Номер офиса/квартиры</label></th>
				<td><input class="regular-text" type="text" name="number_office" id="number_office" value="<?php echo esc_attr(get_the_author_meta('number_office',$user->ID));?>"><br /></td>
			</tr>
<?php
	}
}
 
// Инициализация плагина
$personalize_login_pages_plugin = new Personalize_Login_Plugin();

// Создание пользовательских страниц при активации плагина
register_activation_hook( __FILE__, array( 'Personalize_Login_Plugin', 'plugin_activated' ) );
register_deactivation_hook( __FILE__, array( 'Personalize_Login_Plugin', 'plugin_deactivated' ) );