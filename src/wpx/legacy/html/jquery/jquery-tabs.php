<?php

namespace Skip\HTML\Jquery;

use Skip\Exception;
use Skip\HTML\HTML;
use Skip\Id;
use Skip\Singleton;

/**
 * Class Skip_Jquery_tabs
 * Creates jQuery tabs HTML
 */
class Jquery_Tabs implements HTML {
	use Id, Singleton;

	/**
	 * All added tabs
	 *
	 * @var array
	 */
	private $_tabs = array();

	/**
	 * Adding a tab
	 *
	 * @param string      $title
	 * @param string      $content
	 * @param null|string $html_id
	 *
	 * @return Jquery_Tabs
	 */
	public function add_tab( $title, $content, $html_id = null ) {
		$this->_tabs[] = array(
			'id'      => $this->random_id( $html_id ),
			'title'   => $title,
			'content' => $content
		);

		return $this;
	}

	/**
	 * Getting HTML of Tabs
	 *
	 * @throws Exception
	 * @return string $html
	 */
	public function get_html() {
		if ( count( $this->_tabs ) === 0 ) {
			throw new Exception( 'There have been no tabs added to show.' );
		}

		// jQuery requires an ID
		if ( empty( $this->id ) ) {
			$this->set_id();
		}

		$html = '<div id="tabs-' . $this->id . '" class="jqueryui-tabs">';
		$html .= $this->get_title_html();
		$html .= $this->get_content_html();
		$html .= '</div>';
		$html .= $this->get_js();

		return $html;
	}

	/**
	 * Creating tabs title html
	 *
	 * @return string $html
	 */
	private function get_title_html() {
		$html = '<ul id="tab-title-' . $this->id . '">';
		foreach ( $this->_tabs AS $tab ) {
			$html .= '<li><a href="#tab-content-' . $tab[ 'id' ] . sanitize_title( $tab[ 'title' ] ) .  '">' . $tab[ 'title' ] . '</a></li>';
		}
		$html .= '</ul>';

		return $html;
	}

	/**
	 * Creating tabs content html
	 *
	 * @return string $html
	 */
	private function get_content_html() {
		$html = '';
		foreach ( $this->_tabs AS $tab ) {
			$html .= '<div id="tab-content-' . $tab[ 'id' ] . sanitize_title( $tab[ 'title' ] ) .  '"">' . $tab[ 'content' ] . '</div>';
		}

		return $html;
	}

	/**
	 * Getting JS which initializes the tabs
	 *
	 * @return string $html
	 */
	private function get_js() {
		$html = '<script language="javascript">';
		$html .= 'jQuery("document").ready(function($){$( "#tabs-' . $this->id . '" ).tabs();});';
		$html .= '</script>';

		return $html;
	}

	/**
	 * Reset tabs
	 *
	 * @return Jquery_Tabs
	 */
	public function reset_tabs() {
		$this->_tabs = array();

		return $this;
	}
}