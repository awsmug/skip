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
class Template_Loader{
	/**
	 * Passed arguments
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $arguments = array();

	/**
	 * Template prefix for templates files
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $template_prefix;

	/**
	 * Template name
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $template_name;


	private $template_dirs = array();

	/**
	 * Template_Loader constructor.
	 *
	 * @throws Skip_Exception
	 *
	 * @return string HTML of template
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

		$this->template_dirs = array(
			get_template_directory()
		);

		$this->init();

		return $this->load();
	}

	/**
	 * Initializing point for sub classes (maybe to add template path etc.)
	 *
	 * @since 1.0.0
	 */
	protected function init() {}

	/**
	 * Adds path to search for templates
	 *
	 * @param string $path
	 *
	 * @since 1.0.0
	 */
	public function add_template_path( $path ) {
		$this->template_dirs[] = $path;
	}

	/**
	 * Loads the Template
	 *
	 * @return string HTML of template
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	private function load() {
		$method_name = 'template_' . $this->template_name;

		if( ! method_exists( $this, $method_name  ) ) {
			throw new Skip_Exception( 'Missing template method ' . $method_name . ' in template loader class' );
		}

		return $this->$method_name;
	}

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
	 * Get specific argument
	 *
	 * @param $num
	 *
	 * @return mixed
	 */
	protected function get_argument( $num ) {
		return $this->arguments[ $num ];
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

	/**
	 * Setting template prefix which is used before template filenames
	 *
	 * @param string $prefix
	 *
	 * @since 1.0.0
	 */
	protected function set_template_prefix( $prefix ) {
		$this->template_prefix = $prefix;
	}

	/**
	 * Get template prefix
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	protected function get_template_prefix() {
		return $this->template_prefix;
	}

	/**
	 * Locate template
	 *
	 * @return string Filename with full path
	 *
	 * @since 1.0.0
	 */
	protected function locate_template() {
		$template_filename = $this->get_template_name() . 'php';

		foreach( $this->template_dirs AS $dir ) {
			$filename = $dir . '/' . $template_filename;

			if( file_exists( $filename ) ) {
				return $filename;
			}
		}
	}
}