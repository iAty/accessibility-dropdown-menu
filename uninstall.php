<?php
/*
 * This file will be called when pressing 'Delete' on Dashboard > Plugins.
 */


// if uninstall.php is not called by WordPress, die.
if ( ! defined('WP_UNINSTALL_PLUGIN') ) {
    die();
}

$option_names = array(
		'szmjv_locations'
	);

foreach ( $option_names as $option_name ) {

	delete_option( $option_name );

	// for site options in Multisite
	delete_site_option( $option_name );

}
