<?php

namespace Skip\System;

/**
 * Trait Logger
 *
 * @package Skip\System
 *
 * @todo Needs to be PSR Logger
 *
 * @since 1.0.0
 */
trait Logger {
	/**
	 * @var Logfile destination
	 */
	private $logfile;

	/**
	 * Logging function
	 *
	 * @param $message
	 */
	private function log( $message ) {
		if( ! empty( $this->logfile ) ) {
			$file = fopen( $this->logfile, 'a' );
			fwrite( $file, $message . chr(30 ) );
			fclose( $file );
		}

		error_log( $message );
	}

	/**
	 * Logging an exception
	 *
	 * @param Exception $exception
	 * @param int $depth
	 *
	 * @since 1.0.0
	 */
	private function log_exception( $exception, $depth = 0 ) {
		$message = '';

		$trace = $exception->getTraceAsString();

		for( $act_depth = 0; $act_depth <= $depth; $act_depth++ ) {
			if( $act_depth !== 0 ) {
				$exception = $exception->getPrevious();
			}

			if( ! empty( $exception ) ) {
				$message .= $exception->getMessage() . " in " . $exception->getFile() . PHP_EOL;
			}
		}

		$message .= $trace;

		$this->log( $message );
	}

	/**
	 * Setting Logfile destination
	 *
	 * @param $filename
	 *
	 * @since 1.0.0
	 */
	private function logger_set_logfile( $filename ) {
		$this->logfile = $filename;
	}
}