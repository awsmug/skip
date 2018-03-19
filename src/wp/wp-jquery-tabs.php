<?php

namespace Skip\WP;
use Skip\HTML\Jquery\Jquery_Tabs;

/**
 * Class Skip_WP_Jquery_Tabs
 *
 * Wrapper for WordPress functionalities of Skip jQuery Tabs
 */
class WP_Jquery_Tabs extends Jquery_Tabs  {
	use WP_Enqueue_Scripts;

	/**
	 * Initializing
	 */
	protected function init() {
		$this->enqueue_scripts();
	}

	/**
	 * Enqueue jQuery Tabs JS in frontend
	 */
	public function enqueue_js_frontend() {
		wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery' ) );
	}
}