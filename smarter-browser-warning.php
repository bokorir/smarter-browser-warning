<?php

/**
 * @link              http://smarter.uk.com
 * @since             1.0.0
 * @package           Smarter_Browser_Warning
 *
 * @wordpress-plugin
 * Plugin Name:       Smarter Browser Warning
 * Plugin URI:        http://smarter.uk.com
 * Description:       Show warning popup for not supported browsers.
 * Version:           1.0.1
 * Author:            Robert Bokori
 * Author URI:        http://smarter.uk.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smarter-browser-warning
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smarter-browser-warning-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smarter-browser-warning-activator.php';
	Smarter_Browser_Warning_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smarter-browser-warning-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smarter-browser-warning-deactivator.php';
	Smarter_Browser_Warning_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-smarter-browser-warning.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Smarter_Browser_Warning();
	$plugin->run();

}
run_plugin_name();
