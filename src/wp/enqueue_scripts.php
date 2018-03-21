<?php

namespace Skip\WP;

/**
 * Trait WP_Enqueue_Scripts
 *
 * @package Skip\WP
 */
trait Enqueue_Scripts {
	/**
	 * Javascript files
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $js_files = array();

	/**
	 * CSS files
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $css_files = array();

	/**
	 * Adding methods
	 *
	 * @since 1.0.0
	 */
	private function enqueue_scripts() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_js' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_css') );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_js' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_css' ) );
	}

	/**
	 * Enqueue frontend JS
	 *
	 * @since 1.0.0
	 */
	private function enqueue_frontend_js () {
		if( ! array_key_exists( 'frontend', $this->js_files ) ) {
			return;
		}

		foreach( $this->js_files[ 'frontend' ] AS $file ){
			wp_enqueue_script( md5( microtime() ), $file );
		}
	}

	/**
	 * Enqueue frontend CSS
	 *
	 * @since 1.0.0
	 */
	private function enqueue_frontend_css () {
		if( ! array_key_exists( 'frontend', $this->css_files ) ) {
			return;
		}

		foreach( $this->css_files[ 'frontend' ] AS $file ){
			wp_enqueue_style( md5( microtime() ), $file );
		}
	}

	/**
	 * Enqueue backend JS
	 *
	 * @since 1.0.0
	 */
	private function enqueue_backend_js () {
		if( ! array_key_exists( 'backend', $this->js_files ) ) {
			return;
		}

		foreach( $this->js_files[ 'backend' ] AS $file ){
			wp_enqueue_script( md5( microtime() ), $file );
		}
	}

	/**
	 * Enqueue backend CSS
	 *
	 * @since 1.0.0
	 */
	private function enqueue_backend_css () {
		if( ! array_key_exists( 'backend', $this->css_files ) ) {
			return;
		}

		foreach( $this->css_files[ 'backend' ] AS $file ){
			wp_enqueue_style( md5( microtime() ), $file );
		}
	}

	/**
	 * Adding CSS
	 *
	 * @param string $url URL to CSS file
	 * @param string $where 'frontend' or 'backend'
	 *
	 * @since 1.0.0
	 */
	public final function add_css( $url, $where = 'frontend' ) {
		$this->css_files[ $where ] = $url;
	}

	/**
	 * Adding JS
	 *
	 * @param string $url URL to CSS file
	 * @param string $where 'frontend' or 'backend'
	 *
	 * @since 1.0.0
	 */
	public final function add_js( $url, $where = 'frontend' ) {
		$this->js_files[ $where ] = $url;
	}

	/**
	 * Hiding functions from IDE autocomplete
	 *
	 * @param string $method
	 * @param array $arguments
	 *
	 * @since 1.0.0
	 */
	public function __call( $method, $arguments ) {
		switch( $method ) {
			case 'enqueue_frontend_js':
				$this->enqueue_frontend_js();
				break;
			case 'enqueue_frontend_css':
				$this->enqueue_frontend_css();
				break;
			case 'enqueue_backend_js':
				$this->enqueue_backend_js();
				break;
			case 'enqueue_backend_css':
				$this->enqueue_backend_css();
				break;
		}
	}
}