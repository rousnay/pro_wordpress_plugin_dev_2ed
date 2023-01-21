<?php
/**
 * Plugin Name: Create User
 * Plugin URI:  http://example.com/
 * Description: A plugin that inserts a "Jane Doe" user.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'init', 'pdev_create_user' );

function pdev_create_user() {

	// Bail if the user already exists.
	if ( username_exists( 'janedoe' ) ) {
		return;
	}

	// Create new user.
	$user = wp_create_user(
		'janedoe',
		'123456789',
		'jane@example.com'
	);

	// If the user wasn't created, display error message.
	if ( is_wp_error( $user ) ) {
		echo $user->get_error_message();
	}
}
