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
	 * Logfile messages
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $log_msg;

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
	 *
	 * @since 1.0.0
	 */
	private function log_exception( $exception ) {
		$this->log_msg.= $exception->getMessage() . " in " . $exception->getFile() . PHP_EOL;

		if( ! empty( $exception->getPrevious() ) ) {
			$this->log_exception( $exception->getPrevious() );
		} else {
			$trace = $exception->getTraceAsString() . PHP_EOL;
			$this->log( $this->log_msg . $trace  );
			$this->log_msg = '';
		}
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