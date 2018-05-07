<?php

namespace Skip\API;

use Skip\Singleton;
use Skip\Tools;

/**
 * Class Skip_Manager
 *
 * Managing the superfunction
 *
 * @author Sven Wagener - Awesome UG
 */
trait Skip_API{
	use Singleton;

	/**
	 * HTML Object return
	 *
	 * @return HTML_API
	 */
	public function _html() {
		return HTML_API::get_instance();
	}

	/**
	 * Tools Object returns
	 *
	 * @return Tools
	 */
	public function _tools() {
		return Tools::get_instance();
	}
}
