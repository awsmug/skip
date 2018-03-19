<?php

namespace Skip\WP;
use Skip\Exception;

/**
 * Trait WP_Enqueue_Scripts
 *
 * @package Skip\WP
 */
trait WP_Enqueue_Scripts {
	/**
	 * @var bool
	 */
	private static $js_frontend_loaded = false;

	/**
	 * @var bool
	 */
	private static $js_backend_loaded = false;

	/**
	 * @var bool
	 */
	private static $css_frontend_loaded = false;

	/**
	 * @var bool
	 */
	private static $css_backend_loaded = false;

	/**
	 * Enqueue all scripts
	 *
	 * This function have to be loaded once by class which is using this trait.
	 */
	public function enqueue_scripts(){
		if( ! is_admin() ) {
			if( did_action( 'wp_enqueue_scripts' ) > 0 ) {
				throw new Exception( 'Actionhook "wp_enqueue_scripts" already passed.' );
			}

			if( ! self::$js_frontend_loaded ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_js_frontend' ) );
				self::$js_frontend_loaded = true;
			}

			if( ! self::$css_frontend_loaded ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css_frontend' ) );
				self::$css_frontend_loaded = true;
			}
		} else {
			if( did_action( 'admin_enqueue_scripts' ) > 0 ) {
				throw new Exception( 'Actionhook "admin_enqueue_scripts" already passed.' );
			}

			if( ! self::$js_backend_loaded ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_js_backend' ) );
				self::$js_backend_loaded = true;
			}

			if( ! self::$css_backend_loaded ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_css_backend' ) );
				self::$css_backend_loaded = true;
			}
		}
	}

	/**
	 * Enqueue JavaScript in frontent
	 *
	 * Add all JavaScripts which have to be loaded with wp_enqueue_script in this function
	 * by overwriting them in classes which are using this trait.
	 */
	public function enqueue_js_frontend() {}

	/**
	 * Enqueue JavaScript in backend
	 *
	 * Add all JavaScripts which have to be loaded with wp_enqueue_script in this function
	 * by overwriting them in classes which are using this trait.
	 */
	public function enqueue_js_backend() {}

	/**
	 * Enqueue CSS in frontent
	 *
	 * Add all CSS which have to be loaded with wp_enqueue_style in this function
	 * by overwriting them in classes which are using this trait.
	 */
	public function enqueue_css_frontend() {}

	/**
	 * Enqueue CSS in backend
	 *
	 * Add all CSS which have to be loaded with wp_enqueue_style in this function
	 * by overwriting them in classes which are using this trait.
	 */
	public function enqueue_css_backend() {}
}