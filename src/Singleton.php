<?php

namespace Skip;

/**
 * Trait Skip|Singleton
 *
 * Should be used on all Skip Objects which are singleton;
 *
 * @since 1.0.0
 */
trait Singleton {
	/**
	 * Instance of object
	 *
	 * @var $instance
	 *
	 * @since 1.0.0
	 */
	protected static $instance;

	/**
	 * Skip Singleton
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	final private function __construct() {
		if( ! method_exists( get_called_class(), '_init' ) ) {
			throw new Skip_Exception( 'Skip\Singleton using classes must have _init method' );
		}
		$this->_init();
	}

	/**
	 * Getting instance
	 *
	 * @return self $instance
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	final public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static;
		}
		return static::$instance;
	}
}