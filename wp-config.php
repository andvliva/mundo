<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define( 'DB_NAME', 'mundo' );

/** Username của database */
define( 'DB_USER', 'root' );

/** Mật khẩu của database */
define( 'DB_PASSWORD', '' );

/** Hostname của database */
define( 'DB_HOST', 'localhost' );

/** Database charset sử dụng để tạo bảng database. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1~hjsG!|k|k#Y 7GRo7*;<J|!ApDu:w&vP6~Q_7LG1,_1=.,a8O?+bX(ltMRL>cU' );
define( 'SECURE_AUTH_KEY',  'O=~p?}E ZG~Cbg[yvRFZB)Qu;W-41fwQgj}RPH^[9$u.3W8;8k?Q@7HWp37v[:XQ' );
define( 'LOGGED_IN_KEY',    's{Jb[UuVc:WQZ`s_7;zz;T>QzAC@^Gci,_0{Y%q5aPBfqgjc6%H96=eA/-1,Eq4y' );
define( 'NONCE_KEY',        '~MVayMpNI/+liDO6zMPv`*F3UGg;~klq38p`@O[q}!nr}M:iyxC(0JNFMLA}Y9 3' );
define( 'AUTH_SALT',        '`kxi_5N^gS,d-,^D@DAnox6xDf?m)x*FAd1)rTh dl@+-9y>0Q~^>E8>]SJsG9&d' );
define( 'SECURE_AUTH_SALT', 'i!d^T`_M t3zO?cQqZdi<}lsYBiHubO,LUq^.V2ahbnXGVpouL6&2gT^&U/^;w}E' );
define( 'LOGGED_IN_SALT',   'X9)= +TzXIF-Ojiz<<-#DN%RB**F`RYJ=~z_mw=P4Kz0z<osJf7gm,I/fM1Pt4sI' );
define( 'NONCE_SALT',       'G0JK@.G5*pf{Q1lyVm[8Q.cwB RM@J@t3O##n19 8~b EVyK3=aSNPkK&*g?By03' );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'wp_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
