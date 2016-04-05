<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/gcrahay
 * @since             1.0.0
 * @package           Wp_Cacher
 *
 * @wordpress-plugin
 * Plugin Name:       Wordpress Cacher
 * Plugin URI:        https://github.com/gcrahay/wp-cacher
 * Description:       Adds an HTML5 appcache manifest storing static assets and selected posts client-side.
 * Version:           1.0.0
 * Author:            Gaetan Crahay
 * Author URI:        https://github.com/gcrahay
 * License:           GPL-3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       wp-cacher
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require plugin_dir_path( __FILE__ ) . 'settings.php';
require plugin_dir_path( __FILE__ ) . 'posts.php';
require plugin_dir_path( __FILE__ ) . 'timestamp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_cacher() {

	wpc_settings_run();
	wpc_posts_run();
	wpc_timestamp_run();
	require plugin_dir_path( __FILE__ ) . 'appcachify.php';

}
run_wp_cacher();
