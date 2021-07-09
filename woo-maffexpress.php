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
 * Description:       WooCommerce IIntegration with maff express
 * Version:           1.0.0
 * Requires at least: 5
 * Requires PHP:      7.1
 * Author:            Abdullah Sajjad
 * Author URI:        //abdulahsajjad.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) || die();

define( 'MAFF_VERSION', '1.0.0' );
define( 'MAFF_PATH', plugin_dir_path( __FILE__ ) );

require_once( MAFF_PATH . 'inc/helpers.php' );
require_once( MAFF_PATH . 'inc/settings.php' );
require_once( MAFF_PATH . 'inc/request.php' );

add_action( 'woocommerce_order_status_processing', 'maff_send_request' );
add_action( 'woocommerce_order_status_completed', 'maff_send_request' );


function maff_send_request( $order_id ) {
	$order                             = wc_get_order( $order_id );
	$request_data                      = [];
	$request_data['first_name']        = $order->get_shipping_first_name() ?? $order->get_billing_first_name();
	$request_data['last_name']         = $order->get_shipping_last_name() ?? $order->get_billing_last_name();
	$request_data['address_one']       = $order->get_shipping_address_1() ?? $order->get_billing_address_1();
	$request_data['address_two']       = $order->get_shipping_address_2() ?? $order->get_billing_address_2();
	$request_data['city']              = $order->get_shipping_city() ?? $order->get_billing_city();
	$request_data['company']           = $order->get_shipping_company() ?? $order->get_billing_company();
	$request_data['email']             = $order->get_billing_email();
	$request_data['phone']             = $order->get_billing_phone();
	$request_data['collection_amount'] = $order->get_shipping_total();
	$request_data['country']           = $order->get_shipping_country();
	$request_data['pieces_count']      = $order->get_item_count();
	$request_data['notes']             = $order->get_customer_note();
	$request_data['service_type']      = $order->get_payment_method();
	$request_data['weight']            = get_total_weight( $order->get_items() );

	if ( $request_data['service_type'] === 'cod' ) {
		$request_data['collection_amount'] += $order->get_total();
	}

	$response = maff_request( $request_data );

	maf_request_log( $response );
}

function get_total_weight( $items ) {
	$total_weight = 0;

	foreach ( $items as $item_id => $product_item ) {
		$quantity       = $product_item->get_quantity(); // get quantity
		$product        = $product_item->get_product(); // get the WC_Product object
		$product_weight = $product->get_weight(); // get the product weight
		// Add the line item weight to the total weight calculation
		$total_weight += floatval( $product_weight * $quantity );
	}

	return $total_weight;
}