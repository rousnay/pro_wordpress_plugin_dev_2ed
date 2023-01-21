<?php
/*
Plugin Name: REST API - Create, Update, and Delete Post Examples
Plugin URI: https://example.com/
Description: Create, update, and delete a new post using the WordPress REST API
Author: WROX
Author URI: http://wrox.com
*/

// Register a custom page for your plugin
add_action( 'admin_menu', 'pdev_create_menu' );
             
function pdev_create_menu() {
             
    // Create custom top-level menu
    add_menu_page( 'PDEV REST API FUN', 'PDEV REST API',
        'manage_options', 'pdev-rest-api', 'pdev_create_new_post',
        'dashicons-smiley' );
             
}

function pdev_create_new_post() {

    if ( isset( $_POST['create-post'] ) ) {
       
        // Set the API URL to send the request
        $api_url = 'http://example.com/wp-json/wp/v2/posts';

        // Using Basic Auth, set your username and password
        $api_header_args = array(
                'Authorization' => 'Basic ' . base64_encode( 'brad:pa55w0rd' )
            );

        // Create the new post data array
        $api_body_args = array(
            'title'   => 'REST API Test Post',
            'status'  => 'draft',
            'content' => 'This is my test post. There are many like it, but this one is mine.',
            'excerpt' => 'Read this amazing post'
            );

        // Send the request to the remote REST API
        $api_response = wp_remote_post( $api_url, array(
            'headers' => $api_header_args,
            'body' => $api_body_args
        ) );
         
        // Decode the body response
        $body = json_decode( $api_response['body'] );

        // Verify the response message was 'created' 
        if( wp_remote_retrieve_response_message( $api_response ) === 'Created' ) {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>The post ' . $body->title->rendered . ' has been created successfully</p>';
            echo '</div>';
        }

    }elseif ( isset( $_POST['update-post'] ) ) {

        // Set the API URL to send the request
        $api_url = 'http://example.com/wp-json/wp/v2/posts/<ID>/';

        // Using Basic Auth, set your username and password
        $api_header_args = array(
                'Authorization' => 'Basic ' . base64_encode( 'brad:pa55w0rd' )
            );

        // Create the post data array to update
        $api_body_args = array(
            'title'   => 'UPDATED: REST API Test Post'
            );

        // Send the request to the remote REST API
        $api_response = wp_remote_post( $api_url, array(
            'headers' => $api_header_args,
            'body' => $api_body_args
        ) );
         
        // Decode the body response
        $body = json_decode( $api_response['body'] );
        
        // Verify the response message was 'created' 
        if( wp_remote_retrieve_response_message( $api_response ) === 'OK' ) {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>The post ' . $body->title->rendered . ' has been updated successfully</p>';
            echo '</div>';
        }

    }elseif ( isset( $_POST['delete-post'] ) ) {

        // Set the API URL to send the request
        $api_url = 'http://example.com/wp-json/wp/v2/posts/<ID>/';

        // Using Basic Auth, set your username and password
        $api_header_args = array(
                'Authorization' => 'Basic ' . base64_encode( 'brad:pa55w0rd' )
            );

        // Send the request to the remote REST API
        $api_response = wp_remote_post( $api_url, array(
            'method'  => 'DELETE',
            'headers' => $api_header_args
        ) );
         
        // Decode the body response
        $body = json_decode( $api_response['body'] );

        // Verify the response message was 'created' 
        if( wp_remote_retrieve_response_message( $api_response ) === 'OK' ) {

            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>The post ' . $body->title->rendered . ' has been deleted successfully</p>';
            echo '</div>';

        }

    }
    ?>
    <h1>Create or Update a Post using the REST API</h1>
    <p>Click the button below to create a new post on an external WordPress website using the REST API</p>
    <form method="post">
        <input type="submit" name="create-post" class="button-primary" value="Create Post" />
        <input type="submit" name="update-post" class="button-primary" value="Update Post" />
        <input type="submit" name="delete-post" class="button-primary" value="Delete Post" />
    </form>
    <?php

}