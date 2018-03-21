<?php

namespace Skip;

/**
 * Class Skip_Autoloader
 *
 * @package Skip
 */
trait Autoloader {
	use Singleton;

	/**
	 * Path to library
	 *
	 * @var string
	 */
	protected $dir;

	/**
	 * Initializing Variables
	 */
	protected function init() {
		$this->setup();
		spl_autoload_register( array( __CLASS__ , 'autoload' ) );
	}

	/**
	 * Skip Autoloader
	 *
	 * @param $class_name
	 *
	 * @return bool
	 */
	public function autoload( $class_name ) {
		$packages = explode( '\\', $class_name );
		$load_file = $this->dir;

		$possible_directories = array(
			'/', '/_abstracts/', '/_interfaces/', '/_traits/'
		);

		$filename = '';
		foreach( $packages AS $key => $package ) {
			if( 0 === $key ) { // Have to be "Skip"
				continue;
			}

			$package = strtolower( $package );

			if( count( $packages ) - 1 === $key ) {
				$package = str_replace( '_', '-', $package );
				$filename = $package . '.php';
			} else {
				$load_file .= '/' . $package;
			}
		}

		foreach( $possible_directories AS $directory ) {
			$possible_file = $load_file . $directory . $filename;



			if( file_exists( $possible_file ) && ! is_dir( $possible_file) ) {
				// echo $possible_file . '<br>';
				require_once ( $possible_file );
				return true;
			}
		}

		return false;
	}
}
