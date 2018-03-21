<?php

namespace Skip\WP;

abstract class WP_Translation_Overwrite {
	/**
	 * The Single instances of the components
	 *
	 * @var $_instaces
	 * @since 1.0.0
	 */
	protected static $_instances = null;

	/**
	 * Translations
	 *
	 * @var array
	 * @since 1.0.0
	 */
	protected $translations = array();

	/**
	 * Textdomain
	 *
	 * @var $textdomain
	 * @since 1.0.0
	 */
	public $textdomain;

	/**
	 * Main Instance
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		$class = get_called_class();
		if ( ! isset( self::$_instances[ $class ] ) ) {
			self::$_instances[ $class ] = new $class();
			self::$_instances[ $class ]->init_base_hooks();
			self::$_instances[ $class ]->translations = self::$_instances[ $class ]->translations();
		}

		return self::$_instances[ $class ];
	}

	/**
	 * Translate
	 *
	 * @param string $translation
	 * @param string $text
	 * @param string $textdomain
	 *
	 * @return string $translation
	 *
	 * @since 1.0.0
	 */
	public function translate( $translation, $text, $domain ) {
		if( $domain !== $this->textdomain ) {
			return $translation;
		}

		if( ! array_key_exists( 'gettext', $this->translations ) ) {
			return $translation;
		}

		if ( ! array_key_exists( $text, $this->translations[ 'gettext' ] ) ) {
			return $translation;
		}

		return $this->translations[ 'gettext' ][ $text ];

	}

	/**
	 * Filters, translates and retrieves the singular or plural form based on the supplied number.
	 *
	 * @param string $translation The unfiltered translation.
	 * @param string $single The text to be used if the number is singular.
	 * @param string $plural The text to be used if the number is plural.
	 * @param int    $number The number to compare against to use either the singular or plural form.
	 * @param string $domain Optional. Text domain. Unique identifier for retrieving translated strings.
	 *
	 * @return string $translation The filtered translation.
	 *
	 * @since 1.0.0
	 */
	public function translate_n( $translation, $single, $plural, $number, $domain ) {
		if( $domain !== $this->textdomain ) {
			return $translation;
		}

		if( ! array_key_exists( 'ngettext', $this->translations ) ) {
			return $translation;
		}

		if ( ! array_key_exists( $single, $this->translations[ 'ngettext' ] ) ) {
			return $translation;
		}

		$translation = _n( $single, $plural, $number, $this->translations[ 'ngettext' ][ $single ][ 'textdomain' ] );

		return $translation;
	}

	/**
	 * Translate with context
	 *
	 * @param string $translation
	 * @param string $text
	 * @param string $context
	 * @param string $domain
	 *
	 * @return string $translation
	 *
	 * @since 1.0.0
	 */
	public function translate_with_context( $translation, $text, $context, $domain ) {
		if( $domain !== $this->textdomain ) {
			return $translation;
		}

		if ( ! array_key_exists( $context, $this->translations ) ) {
			return $translation;
		}

		if ( ! array_key_exists( $text, $this->translations[ $context ] ) ) {
			return $translation;
		}

		return $this->translations[ $context ][ $text ];
	}

	/**
	 * Initializing Base Hooks for all Components
	 *
	 * @since 1.0.0
	 */
	private function init_base_hooks() {
		add_filter( 'gettext', array( $this, 'translate' ), 10, 3 );
		add_filter( 'ngettext', array( $this, 'translate_n' ), 10, 5 );
		add_filter( 'gettext_with_context', array( $this, 'translate_with_context' ), 10, 4 );
	}
}

