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

	/**
	 * Possible template directories
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $template_dirs = array();

	/**
	 * Template file (full path and filename)
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $template_file;

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
		$this->template_file = $this->locate_template();

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
	protected function add_template_path( $path ) {
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

		ob_start();
		$this->$method_name;
		$html = ob_get_clean();

		return $html;
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
	 * Get template file
	 *
	 * @return mixed
	 *
	 * @since 1.0.0
	 */
	protected function get_template_file() {
		return $this->template_file;
	}

	/**
	 * Locate template
	 *
	 * @return string|bool Filename with full path, false if not found
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	private function locate_template() {
		$template_filename = $this->get_template_name() . 'php';

		foreach( $this->template_dirs AS $dir ) {
			$filename = $dir . '/' . $template_filename;

			if( file_exists( $filename ) ) {
				return $filename;
			}
		}

		throw new Skip_Exception( 'Template file not found: ' . $template_filename );
	}

	/**
	 * Loading template file with vars
	 *
	 * @param string $template_file Template file
	 * @param array $vars Variables to add
	 *
	 * @since 1.0.0
	 */
	public static function load_template( $template_file, $require_once = true, $vars = array() ) {
		if ( ! empty( $vars ) ) {
			extract( $vars, EXTR_SKIP );
		}

		if ( $template_file ) {
			require_once $template_file;
		} else {
			require $template_file;
		}
	}

	/**
	 * Loading Standard template in common way
	 *
	 * @since 1.0.0
	 */
	private function _standard_template() {
		load_template( $this->get_template_file() );
	}

	/**
	 * Catching functions
	 *
	 * @param string $method
	 * @param array $arguments
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	public function __call( $method, $arguments ) {
		if( substr( $method, 0, 9 ) === 'template_' ) {
			$this->_standard_template();
		} else {
			throw new Skip_Exception( 'Method name ' . $method . ' not found or allowed' );
		}
	}
}