<?php
/**
 * Plugin Name: User Ratings
 * Plugin URI:  http://example.com/
 * Description: Updates user rating based on number of posts.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'save_post', 'pdev_add_user_rating' );

pdev_add_user_rating() {

	// Get the current user object.
	$user = wp_get_current_user();

	// Get the user's current rating.
	$rating = get_user_meta( $user->ID, 'user_rating', true );

	// Bail if user already has gold rating.
	if ( 'gold' === $rating ) {
		return;
	}

	// Get the user's post count.
	$posts = count_user_posts( $user->ID );

	// Update the user's rating based on number of posts.
	if ( 50 <= $posts ) {
		update_user_meta( $user->ID, 'user_rating', 'gold' );
	} elseif ( 25 <= $posts ) {
		update_user_meta( $user->ID, 'user_rating', 'silver' );
	}
}
