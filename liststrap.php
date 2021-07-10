<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://qubethemes.com/
 * @since             1.0.0
 * @package           Liststrap
 *
 * @wordpress-plugin
 * Plugin Name:       ListStrap
 * Plugin URI:        https://qubethemes.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            qubethemes
 * Author URI:        https://profiles.wordpress.org/qubethemes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       liststrap
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LISTSTRAP_VERSION', '1.0.0' );
define( 'LISTSTRAP_URL', plugin_dir_url( __FILE__ ) );
define( 'LISTSTRAP_DIR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-liststrap-activator.php
 */
function activate_liststrap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-liststrap-activator.php';
	Liststrap_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-liststrap-deactivator.php
 */
function deactivate_liststrap() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-liststrap-deactivator.php';
	Liststrap_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_liststrap' );
register_deactivation_hook( __FILE__, 'deactivate_liststrap' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-liststrap.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_liststrap() {

	$plugin = new Liststrap();
	$plugin->run();

}
run_liststrap();