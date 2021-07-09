<?php

defined('ABSPATH') || die();

if( !function_exists( 'maf_request_log' ) ) {
	/**
	 * Logs every request sent to forms in logs.txt
	 *
	 * @param $request
	 *
	 */
	function maf_request_log( $request ) {
		$file = plugin_dir_path( __FILE__ ).'/maf-logs.txt';
		$eol = "\r\n";
		$contents = serialize( $request ) . $eol;
		file_put_contents( $file, $contents, FILE_APPEND );
	}
}