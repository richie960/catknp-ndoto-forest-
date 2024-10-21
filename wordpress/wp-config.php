<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ndotofor_wp_hfsxm' );

/** Database username */
define( 'DB_USER', 'ndotofor_wp_fiykz' );

/** Database password */
define( 'DB_PASSWORD', 'FF%n8zZ3NeC8$qgY' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define('AUTH_KEY', 'lrMrWet[1@U3t5tDdL6j6s8wP17%e(d89m0Oe)M5++Lfw|Eb[unZyUW5JH]12931');
define('SECURE_AUTH_KEY', 'cTJfzY9Y/@4wm9E[32(it9txP1g7UQ#PhDq+JpS)8E3/_G(&XO1I~Q5Y:Q4LVVe]');
define('LOGGED_IN_KEY', '8|aVeoX&ao+456v%TwU2dbOE@]8wEQc10SCm)aN!!]BV7xIW|Y549&irj54385Ij');
define('NONCE_KEY', '0//t(p247@~x3G6(Ri~1B&P4iMDH5K8#PB)yj;4]hm|SK5~;cr+#;de:0P]p1C*R');
define('AUTH_SALT', '-5:u+tperm]GHX%%|DnM&jrm8yv|!OA19JW*x1:~[T|q32[|q*1&tQ89hKaS+X&M');
define('SECURE_AUTH_SALT', '7V#Z6T-A~9Zn0*1ib1w]|X@d!%7yxLx1:I2fk8gsbfNJ]rRQ[6;BhurecU[hB6qT');
define('LOGGED_IN_SALT', 'oyEA9CO8o|N8~-*mEW&[ZO@Fo1|cf5A!65y_16X@]]_2J@-6d9+O74!9c8Qz@vR9');
define('NONCE_SALT', '(Q/sX+Z)GRW4m0~35((+sF_4f%]XZ_M1C0C)_+6+9sJzI4V~(8OU|yAo~]sB*X@@');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'QyK8h7_';


/* Add any custom values between this line and the "stop editing" line. */

define('WP_ALLOW_MULTISITE', true);
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
