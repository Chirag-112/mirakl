<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.crestinfosystems.com
 * @since             1.0.0
 * @package           Skins_Mirakl_Api
 *
 * @wordpress-plugin
 * Plugin Name:       Skins Mirakl API
 * Plugin URI:        https://www.crestinfosystems.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Crest Infosystem Pvt Ltd
 * Author URI:        https://www.crestinfosystems.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       skins-mirakl-api
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
define( 'SKINS_MIRAKL_API_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-skins-mirakl-api-activator.php
 */
function activate_skins_mirakl_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-skins-mirakl-api-activator.php';
	Skins_Mirakl_Api_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-skins-mirakl-api-deactivator.php
 */
function deactivate_skins_mirakl_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-skins-mirakl-api-deactivator.php';
	Skins_Mirakl_Api_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_skins_mirakl_api' );
register_deactivation_hook( __FILE__, 'deactivate_skins_mirakl_api' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-skins-mirakl-api.php';

/**
 * The utils that is used for common helper features. 
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path( __FILE__ ) . 'includes/utils_skins_mirakl_api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_skins_mirakl_api() {

	$plugin = new Skins_Mirakl_Api();
	$plugin->run();

}
run_skins_mirakl_api();
