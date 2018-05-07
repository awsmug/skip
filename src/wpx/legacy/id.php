<?php

namespace Skip;

/**
 * ID Handling in Skip
 *
 * @package Skip
 */
trait Id{
	/**
	 * @var string
	 */
	private $id;

	/**
	 * Setting Id
	 *
	 * @param null|string $id
	 *
	 * @return $this
	 */
	public function set_id( $id = null ) {
		if( empty( $id ) ) {
			$this->id = $this->random_id();
		}

		return $this;
	}

	/**
	 * Getting Id
	 *
	 * @return string $id
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Creating a random Id
	 *
	 * @return string
	 */
	protected function random_id() {
		return substr( md5( time() ), 3, 9 );
	}
}