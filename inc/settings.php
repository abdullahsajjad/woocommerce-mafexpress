<?php


/**
 * Adds a section under Woocommerce->Settings->Shipping
 *
 * @param $sections
 *
 * @return mixed
 * @since 2.0.0
 */
function maff_add_section( $sections ) {
	$sections['wc_maff'] = __( 'Maf Express', 'woocommerce' );

	return $sections;
}

add_filter( 'woocommerce_get_sections_shipping', 'maff_add_section' );


/**
 * Add settings to the specific section we created before
 *
 * @param $settings
 * @param $current_section
 *
 * @return array|mixed
 * @since 2.0.0
 */
function wc_maff_all_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section !== 'wc_maff' ) {
		return $settings;
	}

	$settings_maff = [];
	// Add Title to the Settings
	$settings_maff[] = [
		'name' => __( 'WC Maf Express', 'woocommerce' ),
		'type' => 'title',
		'desc' => __( 'The following options are used to configure WC with Maf Express', 'woocommerce' ),
		'id'   => 'wc_maff',
	];

	// Add second text field option
	$settings_maff[] = [
		'name'     => __( 'Maf API Key', 'text-domain' ),
		'desc_tip' => __( 'Enter maf API key here', 'woocommerce' ),
		'id'       => 'wc_maff_api',
		'type'     => 'text',
		'desc'     => __( 'Enter maf API key here', 'woocommerce' ),
	];

	// Add second text field option
	$settings_maff[] = [
		'name'     => __( 'Client Code', 'text-domain' ),
		'desc_tip' => __( 'Enter client code here', 'woocommerce' ),
		'id'       => 'wc_maff_client_code',
		'type'     => 'text',
		'desc'     => __( 'Enter client code here', 'woocommerce' ),
	];

	$settings_maff[] = [ 'type' => 'sectionend', 'id' => 'wc_maff' ];

	return $settings_maff;
}

add_filter( 'woocommerce_get_settings_shipping', 'wc_maff_all_settings', 10, 2 );


/**
 * Returns Maf Express Client Code saved in settings
 *
 * @return false|mixed|void
 *
 * @since 2.0.0
 */
function get_maf_client_code() {
	return get_option( 'wc_maff_client_code' );
}

/**
 * Returns Maf Express API key saved in settings
 *
 * @return false|mixed|void
 *
 * @since 2.0.0
 */
function get_maf_API() {
	return get_option( 'wc_maff_api' );
}