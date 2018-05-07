<?php

namespace Skip\WP;
use Skip\Exception;
use Skip\Singleton;

/**
 * Trait WP_Enqueue_Scripts
 */
abstract class WP_Post_Type {
	use Singleton;

	/**
	 * Initializing Class
	 */
	protected function init() {
		add_action( 'plugins_loaded', array( $this, 'load' ) );
	}

	/**
	 * Loading
	 *
	 * @throws Exception
	 */
	public function load() {
		if ( ! class_exists( 'WPPTD\General' ) ) {
			return;
			// throw new Exception( 'Post Types Definetly Plugin not activated.' );
		}

		add_action( 'wpptd', array( $this, 'register' ) );
	}

	/**
	 * Function for registering post types with Plugin Post Types Definetly
	 *
	 * @param \WPPTD\App $wpptd App Object of Post Types Definetly
	 *
	 * @return mixed
	 */
	abstract public function register( $wpptd );
}