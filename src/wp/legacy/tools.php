<?php

namespace Skip;

/**
 * Class Skip_Tools
 */
class Tools {
	use Singleton;

	/**
	 * For debugging
	 *
	 * @param mixed $var Content to debug
	 *
	 * @return mixed
	 */
	public function debug( $var )
	{
		if ( class_exists( 'FB' ) && method_exists( 'FB', 'log' )  ) {
			FB::log( $var );
	    } else {
			$content  = '<pre>';
			$content .= print_r( $var, TRUE );
			$content .= '</pre>';

			echo $content;
		}
	}

	/**
	 * Adding logentry
	 *
	 * @param $message
	 * @param string $slug
	 */
	public function log( $message, $slug = 'general' ) {
		$upload_dir = wp_upload_dir();
		$log_dir = $upload_dir[ 'path' ] . '/logs';

		if( ! file_exists( $log_dir ) && !is_dir( $log_dir ) ) {
			mkdir( $log_dir );
		}

		$log_file_name = 'log.log';
		if(  ! empty( $slug ) ) {
			$log_file_name = sanitize_file_name( $slug ) . '-' . $log_file_name;
		}
		$log_file = $log_dir . '/' . $log_file_name;

		$date_time = date( 'Y-m-d - H:i:s', time() );
		$message = $date_time . ' - ' . trim(  $message ) . chr( 13 );

		$file = fopen( $log_file, 'a' );
		fputs( $file, $message );
		fclose( $file );
	}

	/**
	 * Delete logfile
	 *
	 * @param string $slug
	 *
	 * @return bool
	 */
	public function delete_log( $slug = 'general' ) {
		$upload_dir = wp_upload_dir();
		$log_dir = $upload_dir[ 'path' ] . '/logs';

		$log_file_name = 'log.log';
		if(  ! empty( $slug ) ) {
			$log_file_name = sanitize_file_name( $slug ) . '-' . $log_file_name;
		}

		$log_file = $log_dir . '/' . $log_file_name;

		if( ! file_exists( $log_file )  ) {
			return false;
		}

		return unlink( $log_file );
	}
}