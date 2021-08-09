<?php
/**
 * Plugin Helper Functions
 *
 * @since 2.0.0
 */
defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'maf_request_log' ) ) {
	/**
	 * Logs every request sent to forms in logs.txt
	 *
	 * @param $request
	 *
	 * @since 2.0.0
	 */
	function maf_request_log( $request ) {
		$file     = MAFF_PATH . '/maf-logs.txt';
		$eol      = "\r\n";
		$contents = serialize( $request ) . $eol;
		file_put_contents( $file, $contents, FILE_APPEND );
	}
}