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
define( 'DB_HOST', '127.0.0.1:10035' );

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
define( 'AUTH_KEY',          'I *cQnY[)!BDEf;G)9|/5su;O#2$Bf7}gJG_(F?dc[;u|%nN?tS^Tv};qzT]*#+9' );
define( 'SECURE_AUTH_KEY',   ' J91kC[t:M@.bP>uG-Cz`LcT$p]I[D$C6=jt^Ww[;Jh201n4rRAc*-:=A^0BfmNT' );
define( 'LOGGED_IN_KEY',     'NkP59,2X-vftT,gir8-M[&6C3y*`9!`1g=NKD>Af,C ((x!EZ6Pm&[fEK1U.?<+I' );
define( 'NONCE_KEY',         'r`5w~BY16_mp=n5{,>3aU}#z]DP0p5WfC+w3%=<|+2%SY;3]]%1rd.h9-NQ1guo<' );
define( 'AUTH_SALT',         '>d%P[~qt.Jmn@4T]z&8Ie(coV/&]Rj/SMEf0j]a)7)Th=Y@0Osa.:hrHf(6AfI`z' );
define( 'SECURE_AUTH_SALT',  '+AnoiD?#)d?m;=jw#lviNL*R9i+G%[7u=qjh1eg:`)hU-={oG9fxmMpGd!7MCX!|' );
define( 'LOGGED_IN_SALT',    '7CcDZ9}:8x1ed=a5ijSw8Lfo?>l!*0[IOtN~%j3P44~-&NCt>]utb;h!e>5V_a-8' );
define( 'NONCE_SALT',        'Rhy?%SI/QslsPu.)mm_^qSvt,1Ba?$0 RP)$H7^Rakxn~R&yPyd{HjP{MJhX)ns{' );
define( 'WP_CACHE_KEY_SALT', ']-u;L2PidS$YNToP+}n*eY)R.a<r ;~&%-_R6|AaBJhBJIXoU]_[iGcKb1!X<7t}' );


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
