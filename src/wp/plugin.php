<?php

namespace Skip\WP;

/**
 * Class Plugin
 *
 * Create a class from this abstract class and put it into the main plugin file. It contains basic functionalities for plugin creation.
 *
 * @package Skip
 *
 * @since 1.0.0
 */
abstract class Plugin {
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
	private $asssets_path = 'assets/';

	/**
	 * Plugin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initializing Plugin
	 *
	 * @since 1.0.0
	 */
	private final function init() {
		$this->setup();
		$this->_activation_hooks();

		$this->enqueue_scripts();

		add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'run' ) );
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
		$this->asssets_path = $asset_path;
	}

	/**
	 * On Plugin activation
	 *
	 * @since 1.0.0
	 */
	public function plugin_activate(){}

	/**
	 * On Plugin deactivation
	 *
	 * @since 1.0.0
	 */
	public function plugin_deactivate(){}

	/**
	 * On Plugin uninstalling
	 *
	 * @since 1.0.0
	 */
	public function plugin_uninstall(){}

	/**
	 * Refistering all activation hooks
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
	 */
	public final static function get_url() {
		$rc = new \ReflectionClass( get_called_class() );
		return plugin_dir_url( $rc->getFileName() );
	}

	/**
	 * Getting Plugin path
	 *
	 * @param string $path Path to subdirectory
	 *
	 * @return string
	 */
	public final static function get_path() {
		$rc = new \ReflectionClass( get_called_class() );
		return plugin_dir_path( $rc->getFileName() );
	}

	/**
	 * @return string
	 * @throws \ReflectionException
	 */
	public final static function get_plugin_file() {
		$rc = new \ReflectionClass( get_called_class() );
		return $rc->getFileName();
	}

	/**
	 * Returns asset url path
	 *
	 * @param string $name Name of asset
	 * @param string $mode css/js/png/gif/svg/vendor-css/vendor-js
	 * @param boolean $force whether to force to load the provided version of the file (not using .min conditionally)
	 *
	 * @return string
	 */
	public final function get_asset_url( $name, $mode = '', $force = false ) {
		$urlpath = $this->asssets_path;

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

