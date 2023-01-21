<?php
/**
 * Plugin Name: Related Posts
 * Plugin URI:  http://example.com/
 * Description: Displays a list of related posts on singular views.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_filter( 'the_content', 'pdev_related_posts' );

function pdev_related_posts( $content ) {

	// Bail if not viewing a single post.
	if ( ! is_singular( 'post' ) || ! in_the_loop() ) {
		return $content;
	}

	// Get the current post ID.
	$post_id = get_the_ID();

	// Check for cached posts.
	$posts = wp_cache_get( $post_id, 'pdev_related_posts' );

	// If no cached posts, query them.
	if ( ! $cache ) {
		$categories = get_the_category();

		$posts = get_posts( [
			'category' => absint( $categories[0]->term_id ),
			'post__not_in' => [ $post_id ],
			'numberposts'  => 5
		] );

		// Save the cached posts.
		if ( $posts ) {
			wp_cache_set(
				$post_id,
				$posts,
				'pdev_related_posts',
				DAY_IN_SECONDS
			);
		}
	}

	// If posts were found at this point.
	if ( $posts ) {

		$content .= '<h3>Related Posts</h3>';

		$content .= '<ul>';

		foreach ( $posts as $post ) {
			$content .= sprintf(
				'<li><a href="%s">%s</a></li>',
				esc_url( get_permalink( $post->ID ) ),
				esc_html( get_the_title( $post->ID ) )
			);
		}

		$content .= '</ul>';
	}

	return $content;
}
