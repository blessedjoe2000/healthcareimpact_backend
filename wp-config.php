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
define( 'AUTH_KEY',          'cvxsG.Y3p|6$9`d4j Ge*FtUew:hn&7W~[P]GCrvIAA/YT>qm=I8iO(![lO|0n+.' );
define( 'SECURE_AUTH_KEY',   ')U<Dztg&tHrtE Dru-^-;YcG6ljRudhmk#W#c&!1GCHotOzXNwEKl6{Z6l{Rn#|2' );
define( 'LOGGED_IN_KEY',     'EqNeV?T$-P$6?`iF0#^l`L04MD_!]F HbZ4!)c^aUqf>,bNWS4S7lClu>JzW[N S' );
define( 'NONCE_KEY',         '&vqg!~_Q.jD5*Egzt_)(_Jq3Yzr 36YQ-7@OedS)Ix31sveOj1%F@5pT7V.a&e+@' );
define( 'AUTH_SALT',         '9XxZc*U[K#2!Hk,Z/Igx&2X*Zi)lg)UH&U_s!W)96n|n0BwoL  ?NU4g5heWqFAC' );
define( 'SECURE_AUTH_SALT',  '{cW|*zbk1?E3{gR;vQj>Zm84Y;1QCJLxsemi|Z=D2zasgBdA?fc5%QdK35jr@v9m' );
define( 'LOGGED_IN_SALT',    ']P-<q8!-Avs!j6>s`k<D,{DaNxU$R]IBVqz&?^?=)}9m8{yo%0d9I!<6XQM[3nN#' );
define( 'NONCE_SALT',        'diY``my7FT|[8n-xKyc=:ysV;y3KvD~2O+:Ee?t!`TTye]`u4vi2b)CL8-A_n:X7' );
define( 'WP_CACHE_KEY_SALT', 'U?VymK|~n|&DNi2nx~UW{,#E9k:E0z;1?9}LzDF8Q1f<232?|@cq)3^UE-vL:HL:' );


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
