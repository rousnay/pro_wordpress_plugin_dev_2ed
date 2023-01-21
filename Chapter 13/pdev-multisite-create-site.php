<?php
/*
Plugin Name: Multisite Create Site Example Plugin
Plugin URI: http://example.com/wordpress-plugins/my-plugin
Description: A plugin to demonstrate creating sites in Multisite
Version: 1.0
Author: Brad Williams
Author URI: http://wrox.com
License: GPLv2
*/
             
add_action( 'admin_menu', 'pdev_multisite_create_menu' );
             
function pdev_multisite_create_menu() {
             
    //create custom top-level menu
    add_menu_page( 'Multisite Create Site Page',
        'Multisite Create Site',
        'manage_options', 'pdev-network-create',
        'pdev_multisite_create_site_settings' );
             
}
             
function pdev_multisite_create_site_settings() {
             
    //check if multisite is enabled
    if ( is_multisite() ) {
             
        //if the form was submitted lets process it
        if ( isset( $_POST['create_site'] ) ) {
             
            //populate the variables based on form values
            $domain = sanitize_text_field( $_POST['domain'] );
            $path = sanitize_text_field( $_POST['path'] );
            $title = sanitize_text_field( $_POST['title'] );
            $user_id = absint( $_POST['user_id'] );
             
            //verify the required values are set
            if ( $domain && $path && $title && $user_id ) {
             
                //create the new site in WordPress
                $new_site = wpmu_create_blog( $domain, $path,
                    $title, $user_id );
             
                //if successfully display a message
                if ( $new_site ) {
             
                    echo '<div class="notice notice-success is-dismissible">New site '
                        .$new_site. ' created successfully!</div>';
             
             
                }
             
            //if required values are not set display an error
            } else {
             
                echo '<div class="notice notice-error is-dismissible">
                    New site could not be created.
                    Required fields are missing
                    </div>';
             
            }
             
        }
        ?>
        <div class="wrap">
            <h2>Create New Site</h2>
            <form method="post">
            <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="fname">Domain</label>
                </th>
                <td><input maxlength="45" size="25" name="domain"
                        value="<?php echo DOMAIN_CURRENT_SITE; ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="fname">Path</label></th>
                <td>
                    <input maxlength="45" size="10" name="path" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="fname">Title</label></th>
                <td>
                    <input maxlength="45" size="25" name="title" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="fname">User ID</label>
                </th>
                <td>
                    <input maxlength="45" size="3" name="user_id" />
                </td>
            </tr>
            <tr valign="top">
                <td>
                <input type="submit" name="create_site"
                    value="Create Site" class="button-primary" />
                <input type="submit" name="reset" value="Reset"
                    class="button-secondary" />
                </td>
            </tr>
            </table>
            </form>
        </div>
        <?php
    } else {
             
        echo '<p>Multisite is not enabled</p>';
             
    }
             
}
