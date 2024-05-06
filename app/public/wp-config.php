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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          '#|eRRiA~-d{@R9X[=/6830[uUrK!b lc1N71w~!rz~C$Yc]^IjXlkC<88oP ANHZ' );
define( 'SECURE_AUTH_KEY',   '9@Z#UV!588>V6G-7A3#?MR:$#YKW4V@=D;:<}yR*v?,AW)IJyi=1+`bZ&CBi[%0U' );
define( 'LOGGED_IN_KEY',     '+MN^^km`,JKb4MSVhF({Gp=TGcMNar,p!Pg=BBK;w9.CVR-&bF Q:t1V+RHMhET`' );
define( 'NONCE_KEY',         'M/vGdMxe<5<y^_ZZ[+?>&/gSU(E=?_^QS1fe&2}S);Jp@uY&/|3]w`c&?=,v|~0n' );
define( 'AUTH_SALT',         'Bp,Ud/iXJ]r,2>JLZ)KXND7PKTXGbV%PW+jK|/?37blgO8gOn^VWwL612J7.!}T ' );
define( 'SECURE_AUTH_SALT',  '0^kavXZ;?sZ#6YSbXQ2yx^sR~FF`DCozB =?9C9IObc39M;@=^l|OoH?xrC,R`CJ' );
define( 'LOGGED_IN_SALT',    '%g|1Z;tnS>Hpj>7)XNRJ7)}.fE>&%6bkjB.Q%)P(>w5n:eJ,M(fA:69c .mJFE9H' );
define( 'NONCE_SALT',        'SHk)&Du+EH~?RKazFW8WF+e1!R@*WaXhx@PW9VbJ@lgXRffAekPR$`1BFdjM[vPg' );
define( 'WP_CACHE_KEY_SALT', 'Uus{CK/6@]&d]vidq,;W3=#@<J ]eov0~L2~qA&9GI(~#a_Nt=FrA;_u6.=a8#F5' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
