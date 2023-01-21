<?php
/**
 * Plugin Name: Post List Shortcode
 * Plugin URI:  http://example.com/
 * Description: Output the last 10 posts via the [pdev_post_list] shortcode.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'init', 'pdev_register_post_list_shortcodes' );

// Register shortcodes.
function pdev_register_post_list_shortcodes() {
	add_shortcode( 'pdev_post_list', 'pdev_post_list_shortcode' );
}

// Shortcode callback function.
function pdev_post_list_shortcode() {

	// Create empty string for content.
	$html = '';

	// Query last 10 posts.
	$query = new WP_Query( [
		'post_type'      => 'post',
		'posts_per_page' => 10,
		'order'          => 'DESC',
		'orderby'        => 'date'
	] );

	// Check if there are any posts before output.
	if ( $query->have_posts() ) {

		// Open list tag if posts are found.
		$html .= '<ul>';

		// Loop through the found posts.
		while ( $query->have_posts() ) {
			$query->the_post();

			// Add list item with linked post title.
			$html .= sprintf(
				'<li><a href="%s">%s</a></li>',
				esc_url( get_permalink() ),
				the_title( '', '', false )
			);
		}

		// Close list tag.
		$html .= '</ul>';
	}

	// Reset post data.
	wp_reset_postdata();

	// Return shortcode HTML.
	return $html;
}
