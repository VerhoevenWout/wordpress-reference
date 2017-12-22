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
define( 'WPCACHEHOME', '/Users/kerim/sites/exclusivewellness/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('WP_CACHE', true); //Added by WP-Cache Manager
if( stristr( $_SERVER['SERVER_NAME'], "loc" ) || stristr( $_SERVER['SERVER_NAME'], "xip.io" ) ) {

	//locale environment
	define('DB_NAME', 'venues-online');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'root');
	define('DB_HOST', 'localhost');

} elseif(stristr( $_SERVER['SERVER_NAME'], "exclusivewellnessbe.webhosting.be" ) || stristr( $_SERVER['SERVER_NAME'], "staging.venues-online.be" ) ){

	//Production environment

	define('DB_NAME', 'ID123339_ewstag');

	/** MySQL database username */
	define('DB_USER', 'ID123339_ewstag');

	/** MySQL database password */
	define('DB_PASSWORD', 'l9QpvaDUQoAfZRr');

	/** MySQL hostname */
	define('DB_HOST', 'ID123339_ewstag.db.webhosting.be');

} else{

	//Production environment

	define('DB_NAME', 'ID123339_exwelln');

	/** MySQL database username */
	define('DB_USER', 'ID123339_exwelln');

	/** MySQL database password */
	define('DB_PASSWORD', 'l9QpvaDUQoAfZRr');

	/** MySQL hostname */
	define('DB_HOST', 'ID123339_exwelln.db.webhosting.be');

}


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
define('AUTH_KEY',         'utxG[wLfJ+LTgk2_K5<*d!#g6gO-S;zHS1ol0077Ofv*41~D-tUwNAh>IO*mCD5J');
define('SECURE_AUTH_KEY',  'tb%-GNe3=M=.4N@k 0z.^$lu~5hBUsTZ)%*/EmW7sR]`8}Fdu[AVQ  -/H&|!kjI');
define('LOGGED_IN_KEY',    ';jRR5D+`0Zy8iUoUWiaaq;q2iJn7Lr6XIQ.HsH|+^%A!b9rWr=l|Zh5!p}PEAoa|');
define('NONCE_KEY',        '+VaN^<[EAvq_Md?;!F8vW#Xy!{Zc1}|I#=9E{wrJHpi3VSrY&h !j4f16H+OmDEd');
define('AUTH_SALT',        'nE%~8z{tPHTeWL8g^E4OmWK]nTuq)GXLKNosD=gl<@Wu%1`tE6 dvJk,ph{n8,4z');
define('SECURE_AUTH_SALT', 'qG-Vzt$j9Y@>A^<Tyw}0FLA330Y8DItA!}$pd/[eF^<~t mJwYJuspT#js7Cath{');
define('LOGGED_IN_SALT',   '|NX(nOa|gKLL&np#hNwVsv4YEz+yt1SB3n7hZ(!FNd$Ol[$v]8%KQ>ml=9q:+.YF');
define('NONCE_SALT',       'j{6-Qjw`7]/CZ~R$GR{:?U:%V_:Gguslzgb#KddN{c_{O~3Eoc{{AVsGU6H#8eof');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

define('WP_MEMORY_LIMIT', '64M');

// define('FORCE_SSL_ADMIN', true);

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');