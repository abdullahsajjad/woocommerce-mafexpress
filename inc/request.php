<?php
/**
 * Files Responsible for getting and sending teh data to maf express
 *
 * @since 2.0.0
*/

add_action( 'woocommerce_order_status_processing', 'maff_send_request' );
add_action( 'woocommerce_order_status_completed', 'maff_send_request' );


/**
 * Send Data tO Maf Express On order status
 * - Processing
 * - Completed
 *
 * @param $order_id
 */
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
	} // endif

	$response = maff_request( $request_data );

	maf_request_log( $response );
}

/**
 * Calculates Total Weight of All items in the order
 *
 * @param $items
 *
 * @return float|int
 *
 * @since 2.0.0
 */
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


if ( ! function_exists( 'maff_request' ) ) {
	/**
	 *  Sends Request To Maff Express
	 */
	function maff_request( $request_data ) {
		$curl = curl_init();

		curl_setopt_array( $curl, [
			CURLOPT_URL            => 'https://www.mafexpress.com/portal/API/CreateOrder.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'POST',
			CURLOPT_POSTFIELDS     => '{
			"auth_key":"' . get_maf_API() . '",
			"client_code": ' . get_maf_client_code() . ',
			"service_type":"' . $request_data['service_type'] . '",
			"origin":"lahore",
			"destination":"' . $request_data['city'] . '",
			"receiver_name":"' . $request_data['first_name'] . ' ' . $request_data['last_name'] . '",
			"receiver_phone":"' . $request_data['phone'] . '",
			"receiver_email":"' . $request_data['email'] . '",
			"receiver_address":"' . $request_data['address_one'] . $request_data['address_two'] . '",
			"pieces":"' . $request_data['pieces_count'] . '",
			"weight":"' . $request_data['weight'] . '" ,
			"collection_amount":"' . $request_data['collection_amount'] . '",
			"special_instruction":"' . $request_data['notes'] . '"
			}',
			CURLOPT_HTTPHEADER     => [
				'Content-Type: application/json',
				'Cookie: PHPSESSID=b236c73e29f595946531d46c4ebf4fe4',
			],
		] );

		$response = curl_exec( $curl );

		curl_close( $curl );

		return $response;
	}
}