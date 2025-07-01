<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://helloeveryone.me/
 * @since             1.0.0
 * @package           Wc_Custom_Delivery_Slots
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Delivery Slots
 * Plugin URI:        https://github.com/nach94/wc-custom-delivery-slots.git
 * Description:       Add WooCommerce delivery time and date slots to your WooCommerce store's checkout.
 * Version:           1.0.0
 * Author:            HelloEveryone
 * Author URI:        https://helloeveryone.me//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-custom-delivery-slots
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
define( 'WC_CUSTOM_DELIVERY_SLOTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-custom-delivery-slots-activator.php
 */
function activate_wc_custom_delivery_slots() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-custom-delivery-slots-activator.php';
	Wc_Custom_Delivery_Slots_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-custom-delivery-slots-deactivator.php
 */
function deactivate_wc_custom_delivery_slots() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-custom-delivery-slots-deactivator.php';
	Wc_Custom_Delivery_Slots_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_custom_delivery_slots' );
register_deactivation_hook( __FILE__, 'deactivate_wc_custom_delivery_slots' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-custom-delivery-slots.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_custom_delivery_slots() {

	$plugin = new Wc_Custom_Delivery_Slots();
	$plugin->run();

}
run_wc_custom_delivery_slots();
