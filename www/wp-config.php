<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'kortes');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '/asu%]-yFHUsuf^:v*%|->#|hPrr$!uH!Dh[U!K|`)!)<9 3AU|8g>^LH+O_bjki');
define('SECURE_AUTH_KEY',  '0>c2f.;N159ge4_`(H7T=$p_2)Z.E/=ZMY8dftj)ph1]Y(7|Qg^N+j`hw28($(BO');
define('LOGGED_IN_KEY',    'Iih/V]xGP}W]`x|!y[b&]Bh.W/VPD&2d2.}^olq5uVubg.:8^4Mu+0>Jg)sLk)xD');
define('NONCE_KEY',        'R3lvXnAA7|$&Pzyy VS.NO(Is|Po#e;g{^b^-*FlB||,|-z@(<-5ydW|Trqxk*FW');
define('AUTH_SALT',        '=ssFvj,h-/Gi#CV>IXq]Zr%0t;,BRDn~Sn)q+4=<|Y{uh,Dno==l#sNaL=t+xiu=');
define('SECURE_AUTH_SALT', 'LOws-2gYu^MEFu<*g<N3}eW|L5>qzT<=R-9bu|^+=u/KRutDjj5v9oDC|r|kJ|7`');
define('LOGGED_IN_SALT',   '|-M>h[(%)cMtiVNxctQYqcFR%m6+eC9pH^f$ewkzP2I`y=J:EZLv&+qz9z|M.s:y');
define('NONCE_SALT',       '7_s|^#BL@cwj:c`^@![C*z1Z4c+H$&cLh!;!X#DMh~!o-v?4FLN~L[oWS$}$6e|x');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'kt_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
