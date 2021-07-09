<?php

if ( ! function_exists( 'maff_request' ) ) {
	/**
	 *  Sends Request To Maff Express
	 */
	function maff_request( $request_data ) {
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => 'https://www.mafexpress.com/portal/API/CreateOrder.php',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'POST',
			CURLOPT_POSTFIELDS     => '{
"auth_key":"'. get_maf_API() .'",
"client_code": '. get_maf_client_code() .',
"service_type":"'. $request_data['service_type'] .'",
"origin":"lahore",
"destination":"'. $request_data['city'] .'",
"receiver_name":"'. $request_data['first_name'] . ' ' . $request_data['last_name']  .'",
"receiver_phone":"'. $request_data['phone'] .'",
"receiver_email":"'. $request_data['email'] .'",
"receiver_address":"'. $request_data['address_one'] . $request_data['address_two'] .'",
"pieces":"'. $request_data['pieces_count'] .'",
"weight":"'. $request_data['weight'] .'" ,
"collection_amount":"'. $request_data['collection_amount'] .'",
"special_instruction":"'. $request_data['notes'] .'"
}',
			CURLOPT_HTTPHEADER     => array(
				'Content-Type: application/json',
				'Cookie: PHPSESSID=b236c73e29f595946531d46c4ebf4fe4'
			),
		) );

		$response = curl_exec( $curl );

		curl_close( $curl );
		return $response;
	}
}