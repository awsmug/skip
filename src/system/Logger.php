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
	 * Logfile destination
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $logfile;

	/**
	 * Standard logging function
	 *
	 * @param string $message
	 *
	 * @since 1.0.0
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
	 * @param \Exception $exception Exception to log
	 * @param int $depth Number previuos exceptions which should be logged
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
	 * @param string $filename Additional logging filename
	 *
	 * @since 1.0.0
	 */
	private function logger_set_logfile( $filename ) {
		$this->logfile = $filename;
	}
}