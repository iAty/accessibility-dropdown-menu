<?php
/*
Plugin Name: SZMJV: Akadálymentes lenyíló menü
Description: Attila hozzáférhetővé teszi a legördülő menüket. Az egyes legördülő menükhöz hozzáad egy gombot, amelyre egyszerűen kattintva megnyithatja az almenüt.
Version: 1.0.0
Author: Bodnár Attila
Author URI: https://attilabodnar.me
License: MTI
Text Domain: SZMJV


Copyright 2020 - 2020  Bodnár Attila  (email: info@attilabodnar.me)

*/

// Plugin Verzió
define('SZMJV_VER', '1.0.0');

/*
 * Definiciók
 */
define('SZMJV_FOLDER', plugin_basename(dirname(__FILE__)));
define('SZMJV_DIR', WP_PLUGIN_DIR . '/' . SZMJV_FOLDER);
define('SZMJV_URL', plugins_url( '/', __FILE__ ));


// Frontend funciók
include_once( SZMJV_DIR . '/szmjv-css.php' );
include_once( SZMJV_DIR . '/szmjv-nav-menu.php' );

// Backend funkciók
if ( is_admin() ) {
	include_once( SZMJV_DIR . '/szmjv-admin-settings.php' );
}
