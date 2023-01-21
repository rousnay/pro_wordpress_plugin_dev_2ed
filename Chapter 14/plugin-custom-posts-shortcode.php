<?php
/**
 * Plugin Name: Custom Posts Shortcode
 * Plugin URI:  http://example.com/
 * Description: Output posts via the [pdev_custom_posts] shortcode.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'init', 'pdev_register_custom_posts_shortcodes' );

// Register shortcodes.
function pdev_register_custom_posts_shortcodes() {
	add_shortcode( 'pdev_custom_posts', 'pdev_custom_posts_shortcode' );
}

// Shortcode callback function.
function pdev_custom_posts_shortcode( $attr ) {

	// Create empty string for content.
	$html = '';

	// Parse attributes.
	$attr = shortcode_atts(
		[
			'post_type'      => 'post',
			'posts_per_page' => 10,
			'order'          => 'DESC',
			'orderby'        => 'date'
		],
		$attr,
		'pdev_custom_posts'
	);

	// Sanitize attributes before proceeding.

	// Make sure post type exists.
	$attr['post_type'] = post_type_exists( $attr['post_type'] )
	                     ? $attr['post_type']
			     : 'post';

	// Posts per page should be an integer.
	$attr['posts_per_page'] = intval( $attr['posts_per_page'] );

	// Only allow ascending or descending.
	$attr['order'] = in_array( $attr['order'], [ 'ASC', 'DESC' ] )
			    ? $attr['order']
			    : 'DESC';

	// Strip tags from orderby.
	$attr['orderby'] = wp_strip_all_tags( $attr['orderby'] );

	// Query last 10 posts.
	$query = new WP_Query( [
		'post_type'      => $attr['post_type'],
		'posts_per_page' => $attr['posts_per_page'],
		'order'          => $attr['order'],
		'orderby'        => $attr['orderby']
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
