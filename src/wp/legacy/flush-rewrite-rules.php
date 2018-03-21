<?php

namespace Skip\WP;

trait Flush_Rewrite_Rules {
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled
	 *                              or plugin is activated on an individual blog
	 *
	 * @since 1.0.0
	 */
	public static function flush_rewrite_rules( $network_wide ) {
		if ( $network_wide ) {
			if ( version_compare( get_bloginfo( 'version' ), '4.6', '<' ) ) {
				$site_ids = wp_list_pluck( wp_get_sites(), 'blog_id' );
			} else {
				$network  = get_network();
				$site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => $network->id ) );
			}
			foreach ( $site_ids as $site_id ) {
				switch_to_blog( $site_id );
				restore_current_blog();
			}
			add_action( 'shutdown', array( __CLASS__, 'flush_network_rewrite_rules' ) );
		} else {
			add_action( 'shutdown', 'flush_rewrite_rules' );
		}
	}

	/**
	 * Flushing rewrite rules network wide
	 *
	 * @since 1.0.0
	 */
	public static function flush_network_rewrite_rules () {
		if ( version_compare( get_bloginfo( 'version' ), '4.6', '<' ) ) {
			$site_ids = wp_list_pluck( wp_get_sites(), 'blog_id' );
		} else {
			$network  = get_network();
			$site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => $network->id ) );
		}
		foreach ( $site_ids as $site_id ) {
			switch_to_blog( $site_id );
			flush_rewrite_rules();
			restore_current_blog();
		}
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled
	 *                              or plugin is activated on an individual blog
	 */
	public static function activate_flush_rewrite_rules( $network_wide ) {
		static::flush_rewrite_rules( $network_wide );
	}
}