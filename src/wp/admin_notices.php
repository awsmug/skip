<?php

namespace Skip\WP;

/**
 * Trait WP_Enqueue_Scripts
 *
 * @package Skip\WP
 */
trait Admin_Notices {

	/**
	 * Admin Notices
	 *
	 * @var array
	 *
	 * @since 1.0.0
	 */
	private $admin_notices = array();

	/**
	 * Initialising admin notices trait, needed started one time for showing
	 *
	 * @since 1.0.0
	 */
	protected function admin_notices() {
		add_action( 'admin_notices', array( $this, 'show_admin_notices' ) );
	}

	/**
	 * Adding a notice to show
	 *
	 * @param string $message Message to show
	 * @param string $type Notice type 'error', 'warning', 'success' or 'info'.
	 *
	 * @since 1.0.0
	 */
	protected function add_notice( $message, $type = 'info' ) {
		$this->admin_notices[ $type ][] = $message;
	}

	/**
	 * Showing admin notices
	 *
	 * @since 1.0.0
	 */
	private function show_admin_notices() {
		foreach( $this->admin_notices AS $type => $messages ) {
			$html = '<div class="notice notice-' . $type . ' is-dismissible">';
			foreach( $messages AS $message ) {
				$html.= '<p>' . $message . '</p>';
			}
			$html.= '</div>';
		}

		echo $html;
	}

	/**
	 * Hiding methods from IDE
	 *
	 * @param string $method Method name
	 * @param array $arguments Arguments to pass
	 *
	 * @since 1.0.0
	 */
	public function __call( $method, $arguments ) {
		switch( $method ) {
			case 'show_admin_notices':
				$this->show_admin_notices();
				break;
		}
	}
}