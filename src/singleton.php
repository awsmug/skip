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
	 * Skip_Singleton
	 *
	 * @since 1.0.0
	 */
	final private function __construct() {
		$this->init();
	}

	/**
	 * Put all class starting stuff here
	 *
	 * @since 1.0.0
	 */
	protected function init() {}

	/**
	 * Getting instance
	 *
	 * @return $instance
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