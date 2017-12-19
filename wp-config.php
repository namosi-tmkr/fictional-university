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
define('DB_NAME', 'fictional-university');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'p>C_gZwZiVgbdd8};a]k?,SM6p/,VG8WWBZLU9y !|G8n=v9kL*BK9FeY&^z+461');
define('SECURE_AUTH_KEY',  'GrvNgpJw8I,-gR1u*pr]w3-;$|6bG8$!y^mC_mY&>hV/)EjV20K0~l67.#W[BrYY');
define('LOGGED_IN_KEY',    'Xw]z^H=Xq/jB6,2Xv8P/Kf&AQT3GH6A<Ao_AWifj<!B?QN<@|@/?Q8[N:c`0l6}^');
define('NONCE_KEY',        'tE=ia[3f&ydk;fQ^4n(8=qC7LqcJmBuG7Q/V?[|oDy~|*c@Ud)v$*OgOv_i:/pA>');
define('AUTH_SALT',        '<qt%^@$65[&*<d]&^S@59{K8CtKRpmy8h- w=#qyp<<*rjX:BX{;clR5{mmqh$*L');
define('SECURE_AUTH_SALT', 'h0T^zl|SATppI&&|fQ*vWH(~[1KPEK+iLnNf>P^5>6.igz%N{5JYsjFqhc2Z*@vT');
define('LOGGED_IN_SALT',   '`FmG}FNIolV[4UAeEGXaTC(cfEqYZwgmC9q/Vz66F_b4ROYh&VrL)~qi;mVqD[ne');
define('NONCE_SALT',       '{8Cbb)C1-~9EE*t^Qvk+U<+Vi>MAxq#{_pU+*XWN*vi#6pXPk{SE6Pr9Ae<z>dY*');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mywp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
