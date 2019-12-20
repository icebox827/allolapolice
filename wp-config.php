<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'allo' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'gb)V%21 47HwPQu|3ZfaiEW7(5)j^,=r|H#n@iNR@7V;{I)^ATJMec)wxxNljN8?' );
define( 'SECURE_AUTH_KEY',  'nk2><9WT?di.b}T/,L>O26@~C#_x($]=!X!<8QGWQtlz-|ZJGUi;ct.S-qzXw<x)' );
define( 'LOGGED_IN_KEY',    'B+q%ZBGdnGlE]f^nrv9+~2u<-/+m8s+w~L3RSdzh*k$Y&Eg!uX;7dBW6MyU[Zcw^' );
define( 'NONCE_KEY',        'Jo?HV<<?^)}3eZiS0c*/{I0OKalM%Gx|wb%S1{iN(U4VnP,33T8uQG1%h1qBhAax' );
define( 'AUTH_SALT',        '5OwuK]Rw7-P63UO+i){P}}ohPrpLDtQynp >.H:cX5P5pe.c=X=;!3tV-dBz~o>S' );
define( 'SECURE_AUTH_SALT', '~fXU[Xl2zYteB[hV6i,Qd2HwQ n/=H3!KH[ 9rfA+.e6A|!G9|?5:zf:z&0t[}Y=' );
define( 'LOGGED_IN_SALT',   '~H6ga)=2`M%q@RRXV$p<lC&I=UP4o4{[Rsx~(-gn92>5]dDqfWz`>B?WuDqk[+0a' );
define( 'NONCE_SALT',       'R&HiZBE&wXTjyn=WEVd>QeKh27@iNAf5u=aYkb|-Wz@a+%4-~yU-tg~lM2rvc~?G' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
