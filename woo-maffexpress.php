<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              //abdullahsajjad.dev
 * @since             1.0.0
 * @package           woo_maff
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce with Maff Express
 * Plugin URI:        //github.com/abdullahsajjad/woo-maff-express
 * Description:       WooCommerce Integration with maff express
 * Version:           2.0.0
 * Requires at least: 5
 * Requires PHP:      7.1
 * Author:            Abdullah Sajjad
 * Author URI:        //abdulahsajjad.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) || die();

define( 'MAFF_VERSION', '2.0.0' );
define( 'MAFF_PATH', plugin_dir_path( __FILE__ ) );

require_once( MAFF_PATH . 'inc/helpers.php' );
require_once( MAFF_PATH . 'inc/settings.php' );
require_once( MAFF_PATH . 'inc/request.php' );
