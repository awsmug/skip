<?php

namespace Skip\WP;

/**
 * Abstract class Shortcode
 *
 * Extend this abstract class to create an own shortcode. If no name is set in child class, lowercase class name will
 * be taken. Use function 'excecute' to add shortcode functionality.
 *
 * @package Skip\WP
 *
 * @since 1.0.0
 */
abstract class Shortcode {
	private $name;

	/**
	 * Initializing Shortcode
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->init();
		add_action( 'plugins_loaded', array( $this, 'add_shortcode' ) );
	}

	/**
	 * Init data
	 *
	 * Initialize Shortcode values without ugly constructor overwriting and recall.
	 *
	 * @since 1.0.0
	 */
	private function init() {}

	/**
	 * Setting shortcode name
	 *
	 * @param $name
	 *
	 * @since 1.0.0
	 */
	protected function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Get shortcode name
	 *
	 * @return string Shortcode name
	 *
	 * @since 1.0.0
	 */
	protected function get_name() {
		if( empty( $this->name ) ) {
			$this->name = strtolower( get_called_class() );
		}

		return $this->name;
	}

	/**
	 * Adding Shortcode
	 *
	 * Adds shortcode on plugins_loaded hook. Lowercase class name is used if there was no name set.
	 *
	 * @since 1.0.0
	 */
	private function add_shortcode() {
		add_shortcode( $this->get_name(), array( $this, 'execute' ) );
	}

	/**
	 * Parse Attributes of shortcodes
	 *
	 * @param array $defaults Shortcode attributes
	 * @param array $atts Attributes given by shortcode call
	 *
	 * @return array Combined and filtered attribute list.
	 *
	 * @since 1.0.0
	 */
	protected function parse_atts( $defaults, $atts ) {
		return shortcode_atts( $defaults, $atts, $this->get_name() );
	}

	/**
	 * Execute shortcode
	 *
	 * @param array $attributes Shortcode attributes.
	 *
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	abstract protected function execute( $attributes );

	/**
	 * Hiding internal functions from IDE
	 *
	 * @param string $method Name of the called method
	 * @param array $arguments Arguments passed
	 *
	 * @since 1.0.0
	 */
	public function __call( $method, $arguments ) {
		switch( $method ) {
			case 'add_shortcode':
				$this->add_shortcode();
				break;
		}
	}
}
