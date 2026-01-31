<?php
define( 'WP_CACHE', true );

define('DISABLE_WP_CRON', true);

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** Database settings for local XAMPP */
// define('DB_NAME', 'pydrqhmy_stagingthegiftara');
// define('DB_USER', 'pydrqhmy_stagingthegiftara');
// define('DB_PASSWORD', 'EAgLdNk-}_YaJX7(');
// define('DB_HOST', '50.6.43.92');
// define('DB_CHARSET', 'utf8mb4');
// define('DB_COLLATE', '');
define('DB_NAME', 'pydrqhmy_thegiftara');
/** Database username */
define('DB_USER', 'pydrqhmy_doomshell_thegiftara');
/** Database password */
define('DB_PASSWORD', 'DoompCm5%5E@g5ncrn3/?Z');
/** Database hostname */
define('DB_HOST', '50.6.43.92');
/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('FS_METHOD', 'direct');

// define('WP_MEMORY_LIMIT', '256M');
// define('WP_MAX_MEMORY_LIMIT', '256M');


/* That's all, stop editing! Happy publishing. */


define( 'WP_HOME', 'https://thegiftara.com' );
define( 'WP_SITEURL', 'https://thegiftara.com' );
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Jfb</8}_E,~K~<ev&dV*+-@}]I8CcXd*QP+fYalzCz3PYX$k3s#W[/vV%D_3| aq');
define('SECURE_AUTH_KEY',  'jU:$1WUfR`5GFO=KbjZL16h_a_8x3U cM$a,7RnmHZ.0Ay 8[5OueSY)A%/Z>L+-');
define('LOGGED_IN_KEY',    '~C.Y,Fb/kZGzz(pj3T2ddrd.PGz-OVPR|Ik5?C.RRiZ9}!tp@1qFK]+2276B|].?');
define('NONCE_KEY',        'x|ET)S;bH,NLCqyNYTn5d+l;33J-`FQ[#S<{R~3)jYneXb[dRbZRD>0=Rxz[8Owg');
define('AUTH_SALT',        '8%,8#4h>!O6<O_EGu Q[}fxsc<h^^Ok/vwR$FS$5)0Y>AgzF1zZvFQ[kv$kI{X|M');
define('SECURE_AUTH_SALT', '?+nNLA|m6cvF^U5G^W30|BACI+oa<&_/AualBY}dL??{)1Mr;O/~*4gI5|NP@K<-');
define('LOGGED_IN_SALT',   'pRT9JMupcEU@Wx{Iw:_>>;-F$S6r@8):/*&BI1o2,.pVUHu0!l]!ao*k_!!{LCQ6');
define('NONCE_SALT',       'tmOe>8w&8f?GAW#I<e+1|pL@O<Q% ~kLo{I,Jw%D5| %,C u^{0ZiTzS{.k;h-? ');
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';
/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', false);
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';