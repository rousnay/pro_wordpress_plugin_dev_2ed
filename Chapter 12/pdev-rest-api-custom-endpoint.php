<?php
/*
Plugin Name: PDEV REST API Custom Endpoint
Plugin URI: https://example.com/
Description: Register a custom endpoint in the WP REST API
Author: WROX
Author URI: http://wrox.com
*/

/**
 * Grab latest post title by the author ID
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,  * or null if none.
 */
function pdev_return_post_title_by_author_id( $data ) {

    $posts = get_posts( array(
        'author' => absint( $data['id'] ),
    ) );
 
    if ( empty( $posts ) ) {
        return new WP_Error( 'no_author', 'Invalid author', array( 'status' => 404 ) );
    }
 
    return $posts[0]->post_title;

}

add_action( 'rest_api_init', 'pdev_custom_endpoint' );

// Register your REST API custom endpoint
function pdev_custom_endpoint() {

    register_rest_route( 'pdev-plugin/v1', '/author/(?P<id>\d+)', 
        array(
            'methods'  => 'GET',
            'callback' => 'pdev_return_post_title_by_author_id',
        ) 
    );

}