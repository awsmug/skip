<?php

use Skip\API\API;

require_once ( dirname( __FILE__ ) . '/src/autoloader.php' );

/**
 * The mighty and magic Superfunction!
 *
 * @return API
 */
function skip() {
	return API::get_instance();
}

\Skip\Skip_Autoloader::get_instance();