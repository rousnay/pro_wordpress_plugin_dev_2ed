<?php
/**
 * Plugin Name: Force Admin Color
 * Plugin URI:  http://example.com/
 * Description: Makes sure the current user has the "fresh" color scheme.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'admin_init', 'pdev_force_admin_color' );

function pdev_force_admin_color() {

	// Get the current WP_User object.
	$user = wp_get_current_user();

	// Bail if no current user object.
	if ( empty( $user ) ) {
		return;
	}

	// Get user's admin color scheme.
	$color = get_user_meta( $user->ID, 'admin_color', true );

	// If not the fresh color scheme, update it.
	if ( 'fresh' !== $color ) {

		wp_update_user( [
			'ID'          => $user->ID,
			'admin_color' => 'fresh'
		] );
	}
}
