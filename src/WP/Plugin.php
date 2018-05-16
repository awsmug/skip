<?php

namespace Skip\WP;

use Skip\Singleton;
use Skip\Skip_Exception;

/**
 * Class Plugin
 *
 * Create a class from this abstract class and put it into the main plugin file. It contains basic functionalities for plugin creation.
 *
 * @package Skip\WP
 *
 * @since 1.0.0
 */
abstract class Plugin {
	use Singleton;
	use Enqueue_Scripts;

	/**
	 * Textdomain
	 *
	 * @var string|null
	 *
	 * @since 1.0.0
	 */
	private $textdomain = null;

	/**
	 * Assets sub directory
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $assets_path = 'assets/';

	/**
	 * Initializing Plugin
	 *
	 * @since 1.0.0
	 */
	private final function _init() {
		$this->setup();
		$this->_activation_hooks();

		$this->enqueue_scripts();

		add_action( 'plugins_loaded', array( __CLASS__, '_load_textdomain' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'run' ) );
	}

	/**
	 * Running Plugin after all Plugins loaded
	 *
	 * @since 1.0.0
	 */
	abstract public function run();

	/**
	 * Running Setup at the beginning
	 *
	 * @since 1.0.0
	 */
	abstract protected function setup();

	/**
	 * Setting textdomain
	 *
	 * @param string $textdomain
	 */
	protected function set_textdomain( $textdomain ) {
		$this->textdomain = $textdomain;
	}

	/**
	 * Setting asset path
	 *
	 * @param string $asset_path
	 */
	protected function set_asset_path( $asset_path ) {
		$this->assets_path = $asset_path;
	}

	/**
	 * On Plugin activation
	 *
	 * @since 1.0.0
	 */
	public static function plugin_activate(){}

	/**
	 * On Plugin deactivation
	 *
	 * @since 1.0.0
	 */
	public static function plugin_deactivate(){}

	/**
	 * On Plugin uninstalling
	 *
	 * @since 1.0.0
	 */
	public static function plugin_uninstall(){}

	/**
	 * Registering all activation hooks
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	private final function _activation_hooks() {
		$plugin_file = self::get_plugin_file();

		register_activation_hook( $plugin_file, array( $this, 'plugin_activate' ) );
		register_deactivation_hook( $plugin_file, array( $this, 'plugin_deactivate' ) );
		register_uninstall_hook( $plugin_file, array( $this, 'plugin_uninstall' ) );
	}

	/**
	 * Loading textdomain
	 *
	 * @since 1.0.0
	 */
	public final function _load_textdomain() {
		if( empty( $this->textdomain ) ) {
			return;
		}

		load_plugin_textdomain( $this->textdomain );
	}

	/**
	 * Get Plugin URL
	 *
	 * @param string $path Path to subdirectory
	 *
	 * @return string
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	public final static function get_url() {
		try{
			$rc = new \ReflectionClass( get_called_class() );
		} catch ( \ReflectionException $e ) {
			throw new Skip_Exception( $e->getMessage(), 0, $e );
		}

		return plugin_dir_url( $rc->getFileName() );
	}

	/**
	 * Getting Plugin path
	 *
	 * @param string $path Path to subdirectory
	 *
	 * @return string
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	public final static function get_path() {
		try{
			$rc = new \ReflectionClass( get_called_class() );
		} catch ( \ReflectionException $e ) {
			throw new Skip_Exception( $e->getMessage(), 0, $e );
		}

		return plugin_dir_path( $rc->getFileName() );
	}

	/**
	 * Getting plugin filename (with path)
	 *
	 * @return string
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	public final static function get_plugin_file() {
		try{
			$rc = new \ReflectionClass( get_called_class() );
			$filename = $rc->getFileName();
		} catch ( \ReflectionException $e ) {
			throw new Skip_Exception( $e->getMessage(), 0, $e );
		}

		return $filename;
	}

	/**
	 * Returns asset url path
	 *
	 * @param string $name Name of asset
	 * @param string $mode css/js/png/gif/svg/vendor-css/vendor-js
	 * @param boolean $force whether to force to load the provided version of the file (not using .min conditionally)
	 *
	 * @return string
	 *
	 * @throws Skip_Exception
	 *
	 * @since 1.0.0
	 */
	public final function get_asset_url( $name, $mode = '', $force = false ) {
		$urlpath = $this->assets_path;

		$can_min = true;

		switch ( $mode ) {
			case 'css':
				$urlpath .= 'dist/css/' . $name . '.css';
				break;
			case 'js':
				$urlpath .= 'dist/js/' . $name . '.js';
				break;
			case 'jpg':
			case 'png':
			case 'gif':
			case 'svg':
				$urlpath .= 'dist/img/' . $name . '.' . $mode;
				$can_min = false;
				break;
			case 'vendor-css':
				$urlpath .= 'dist/css/vendor/' . $name . '.css';
				break;
			case 'vendor-js':
				$urlpath .= 'dist/js/vendor/' . $name . '.js';
				break;
			default:
				return '';
		}

		if ( $can_min && ! $force ) {
			if ( defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG ) {
				$urlpath = explode( '.', $urlpath );
				array_splice( $urlpath, count( $urlpath ) - 1, 0, 'min' );
				$urlpath = implode( '.', $urlpath );
			}
		}

		return $this->get_url() . $urlpath;
	}
}

