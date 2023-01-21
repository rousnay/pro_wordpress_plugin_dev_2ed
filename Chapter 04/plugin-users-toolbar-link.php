<?php
/**
 * Plugin Name: Users Toolbar Link
 * Plugin URI:  http://example.com/
 * Description: Adds a toolbar link to the users admin screen.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'wp_before_admin_bar_render', 'pdev_toolbar' );

function pdev_toolbar() {
	global $wp_admin_bar;

	if ( current_user_can( 'edit_users' ) ) {

		$wp_admin_bar->add_menu( [
			'id'    => 'pdev-users',
			'title' => 'Users',
			'href'  => esc_url( admin_url( 'users.php' ) )
		] );
	}
}
