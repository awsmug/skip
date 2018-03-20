<?php

use Skip\API\API;

require_once ( dirname( __FILE__ ) . '/vendor/autoload.php' );

/**
 * The mighty and magic Superfunction!
 *
 * @return API
 */
function skip() {
	return API::get_instance();
}