<?php

namespace Skip\WP;

trait Hooks {
	private function get_hooks() {
		$hooks = array(
			'wp' => array( 10, 1 )
		);
	}

	public function init_hooks( $hook_priorities = array() ) {
		$called_class = get_called_class();

		if( property_exists( $called_class, 'wp' ) ) add_action( 'wp', array( $called_class, 'wp' ) );
	}

	/**
	 *
	 * @param $wp
	 */
	public function wp() {}
}