<?php

namespace Skip\BP;

/**
 * Class BP_Subnav
 *
 * Wrapper for WordPress functionalities of Skip jQuery Tabs
 */
abstract class BP_Subnav {

	private $menu_title;
	private $menu_slug;
	private $parent_url;
	private $parent_slug;
	private $template;
	private $position;

	final public function init( $menu_title, $menu_slug, $parent_url, $parent_slug, $template = 'members/single/plugins', $position = 10 ) {
		$this->menu_title = $menu_title;
		$this->menu_slug = $menu_slug;
		$this->parent_url = $parent_url;
		$this->parent_slug = $parent_slug;
		$this->template = $template;
		$this->position = $position;

		add_action( 'bp_setup_nav', array( $this, 'setup_nav' ), 20 );
	}


	final public function setup_nav() {
		$args = array(
			'name' => $this->menu_title,
			'slug' => $this->menu_slug,
			'parent_url' => $this->parent_url,
			'parent_slug' => $this->parent_slug,
			'screen_function' => array( $this, 'show' ),
			'position' => 40 );

		bp_core_new_subnav_item( $args );
	}

	final public function show() {
		if ( ! bp_is_current_action( $this->menu_slug ) ) {
			return;
		}

		add_action( 'bp_template_title', array( $this, 'title' ) );
		add_action( 'bp_template_content', array( $this, 'content' ) );

		bp_core_load_template( array( $this->template ) );
	}

	abstract public function title();

	abstract public function content();
}