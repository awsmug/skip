<?php

namespace Skip\WP;

use Skip\Skip_Exception;

/**
 * Class Template_Loader
 *
 * @package Skip\WP
 *
 * @since 1.0.0
 */
abstract class Template_Loader{
	/**
	 * Passed arguments
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $arguments = array();

	/**
	 * Template name
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $template_name;

	/**
	 * Template_Loader constructor.
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if( func_num_args() === 0 ) {
			throw new Skip_Exception( 'Template loader needs at least one argument' );
		}

		$this->arguments = func_get_args();
		$this->template_name = $this->argument[ 0 ];

		if( empty( $this->template_name ) ) {
			throw new Skip_Exception( 'Empty value for parameter 1 is not allowed' );
		}

		$this->load();
	}

	/**
	 * Loads the Template
	 *
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	abstract function load();

	/**
	 * Get arguments
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	protected function get_arguments() {
		return $this->arguments;
	}


	/**
	 * Get template name
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	protected function get_template_name() {
		return $this->template_name;
	}
}