<?php

/**
 * Create the section beneath the Shipping tab
 **/
add_filter( 'woocommerce_get_sections_shipping', 'maff_add_section' );
function maff_add_section( $sections ) {

	$sections['wc_maff'] = __( 'Maf Express', 'woocommerce' );

	return $sections;

}


/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_shipping', 'wc_maff_all_settings', 10, 2 );
function wc_maff_all_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section !== 'wc_maff' ) {
		return $settings;
	}

	$settings_maff = array();
	// Add Title to the Settings
	$settings_maff[] = array(
		'name' => __( 'WC Maf Express', 'woocommerce' ),
		'type' => 'title',
		'desc' => __( 'The following options are used to configure WC with Maf Express', 'woocommerce' ),
		'id'   => 'wc_maff'
	);

	// Add second text field option
	$settings_maff[] = array(
		'name'     => __( 'Maf API Key', 'text-domain' ),
		'desc_tip' => __( 'Enter maf API key here', 'woocommerce' ),
		'id'       => 'wc_maff_api',
		'type'     => 'text',
		'desc'     => __( 'Enter maf API key here', 'woocommerce' ),
	);

	// Add second text field option
	$settings_maff[] = array(
		'name'     => __( 'Client Code', 'text-domain' ),
		'desc_tip' => __( 'Enter client code here', 'woocommerce' ),
		'id'       => 'wc_maff_client_code',
		'type'     => 'text',
		'desc'     => __( 'Enter client code here', 'woocommerce' ),
	);

	$settings_maff[] = array( 'type' => 'sectionend', 'id' => 'wc_maff' );

	return $settings_maff;
}


/**
 * Returns Maf Express Client Code saved in settings
 *
 * @return false|mixed|void
 */
function get_maf_client_code() {
	return get_option( 'wc_maff_client_code' );
}

/**
 * Returns Maf Express API key saved in settings
 *
 * @return false|mixed|void
 */
function get_maf_API() {
	return get_option( 'wc_maff_api' );
}