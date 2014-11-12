<?php
namespace myFOSSIL\Plugin\Resources;

/**
 * myFOSSIL Resources
 *
 * This file is read by WordPress to generate the plugin information in the
 * plugin Dashboard. This file also includes all of the dependencies used by
 * the plugin, registers the activation and deactivation functions, and defines
 * a function that starts the plugin.
 *
 * @link              http://github.com/myfossil
 * @since             0.0.1
 * @package           myFOSSIL_Resources
 *
 * @wordpress-plugin
 * Plugin Name:       myFOSSIL Resources
 * Plugin URI:        https://github.com/myfossil
 * Description:       Adds Places and Events to WordPress.
 * Version:           0.0.1
 * Author:            AtmoApps
 * Author URI:        http://atmoapps.com
 * License:           BSD
 * Text Domain:       myfossil-resources
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The code that runs during plugin activation.
 */
require_once( plugin_dir_path( __FILE__ ) .
        'includes/class-myfossil-resources-activator.php' );

/**
 * The code that runs during plugin deactivation.
 */
require_once( plugin_dir_path( __FILE__ ) .
        'includes/class-myfossil-resources-deactivator.php' );

/* 
 * This action is documented in includes/class-myfossil-resources-activator.php
 */
register_activation_hook( __FILE__, array(
            'myFOSSIL\Plugin\Resources\myFOSSIL_Resources_Activator',
            'activate' ) );

/* 
 * This action is documented in
 * includes/class-myfossil-resources-deactivator.php 
 */
register_deactivation_hook( __FILE__, array(
            'myFOSSIL\Plugin\Resources\myFOSSIL_Resources_Deactivator',
            'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once( plugin_dir_path( __FILE__ ) .
        'includes/class-myfossil-resources.php' );

function myfossil_enqueue_scripts() {
    wp_enqueue_script( 'myfossil-resources-public-docs', 
            plugin_dir_url( __FILE__ ) .  'static/js/public-docs.min.js',
            array( 'jquery' ) );
    wp_enqueue_script( 'myfossil-resources-public-events', 
            plugin_dir_url( __FILE__ ) .  'static/js/public-events.min.js',
            array( 'jquery' ) );
    wp_enqueue_script( 'myfossil-resources-public-places', 
            plugin_dir_url( __FILE__ ) .  'static/js/public-places.min.js',
            array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', __namespace__ . '\myfossil_enqueue_scripts' );

function myfossil_admin_enqueue_scripts() {
    wp_enqueue_script( 'myfossil-resources-admin', 
            plugin_dir_url( __FILE__ ) .  'static/js/admin.min.js',
            array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', __namespace__ . '\myfossil_admin_enqueue_scripts' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off
 * the plugin from this point in the file does not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_plugin_name()
{

    $plugin = new myFOSSIL_Resources();
    $plugin->run();

}
run_plugin_name();
