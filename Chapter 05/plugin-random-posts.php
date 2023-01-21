<?php
/**
 * Plugin Name: Random Posts
 * Plugin URI:  http://example.com/
 * Description: Randomly orders posts on the home/blog page.
 * Author:      WROX
 * Author URI:  http://wrox.com
 */

add_action( 'pre_get_posts', 'pdev_random_posts' );

function pdev_random_posts( $query ) {

	if ( $query->is_main_query() && $query->is_home() ) {
		$query->set( 'orderby', 'rand' );
	}
}
