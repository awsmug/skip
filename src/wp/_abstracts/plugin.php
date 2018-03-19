<?php

namespace Skip\WP;

use Skip\Singleton;

/**
 * Class Plugin
 *
 * Create a class from this abstract class and put it into the main plugin file. It contains basic functionalities for plugin creation.
 *
 * @package Skip
 */
abstract class Plugin {
	use Singleton;

	/**
	 * Textdomain
	 *
	 * @var string|null
	 */
	public $textdomain = null;

	/**
	 * Assets sub directory
	 *
	 * @var string
	 */
	protected $asssets_path = 'assets/';

	/**
	 * Initializing Plugin
	 */
	protected final function init() {
		self::plugin_hooks();

		if( property_exists( $this, 'post_types' ) ) {
			$this->post_types();
		}

		if( property_exists( $this, 'shortcodes' ) ) {
			$this->shortcodes();
		}

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'run' ) );
	}

	/**
	 *  Put in your functionality which have to be loaded after all plugins loaded
	 */
	public function run(){}

	public static function activate(){}

	public static function deactivate(){}

	public static function uninstall(){}

	private static final function plugin_hooks() {
		$plugin_file = self::get_path() . '/' . self::get_plugin_file();

		register_activation_hook( $plugin_file, array( get_called_class(), 'activate' ) );
		register_deactivation_hook( $plugin_file, array( get_called_class(), 'deactivate' ) );
		register_uninstall_hook( $plugin_file, array( get_called_class(), 'uninstall' ) );
	}

	/**
	 * Loading textdomain
	 */
	public final function load_textdomain() {
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
	public final static function get_url( $path = '' ) {
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

	public final static function get_plugin_file() {
		$rc = new \ReflectionClass( get_called_class() );
		return basename( $rc->getFileName() );
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

		return $this->get_url( $urlpath );
	}
}

