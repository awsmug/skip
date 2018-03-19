<?php

namespace Skip;

require_once ( dirname( __FILE__ ) . '/_traits/singleton.php' );
require_once ( dirname( __FILE__ ) . '/_traits/autoloader.php' );

class Skip_Autoloader {
	use Autoloader;

	protected function setup(){
		$this->dir = dirname( __FILE__  );
	}
}