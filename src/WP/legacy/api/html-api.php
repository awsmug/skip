<?php

namespace Skip\API;
use Skip\Singleton;

/**
 * Class HTML_Manager
 *
 * @package Skip
 */
class HTML_API {
	use Singleton;

	/**
	 * jQuery
	 *
	 * @return Jquery_API
	 */
	public function jquery () {
		return Jquery_API::get_instance();
	}
}
