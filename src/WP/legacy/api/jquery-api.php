<?php

namespace Skip\API;
use Skip\Singleton;
use Skip\Jquery_Tabs;

/**
 * Class HTML_Manager
 *
 * @package Skip
 */
class Jquery_API {
	use Singleton;

	/**
	 * jQuery Tabs
	 *
	 * @return Jquery_Tabs
	 */
	public function tabs() {
		return Jquery_Tabs::get_instance();
	}
}