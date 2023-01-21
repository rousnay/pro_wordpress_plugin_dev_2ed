<?php
/**
 * Plugin Name: Debug Notices
 * Plugin URI:  https://wrox.com
 * Description: Plugin to create debug errors
 * Version:     0.0.1
 * Author:      WROX
 * Author URI:  https://wrox.com
 */

add_filter( 'the_content', function( $content = '' ) {
	$post = get_post();

    // If viewing a post with the 'post' post type
    if ( ! empty( $post ) && ( 'post' === $post->post_type ) ) {
        $author_box  = '<div class=”author-box”>';
        $author_box .= '<h3>' . get_the_author_meta( 'display_name' ) . '</h3>';
        $author_box .= '<p>' . get_the_author_meta( 'description' ) . '</p>';
        $author_box .= '</div>';
    }

    // Append the author box to the content.
	if ( ! empty( $author_box ) ) {
		$content = $content . $author_box;
	}

    // Return the content.
    return $content;
} );
