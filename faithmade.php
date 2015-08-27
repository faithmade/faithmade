<?php
/**
 * Plugin Name: Faithmade Admin Theme
 * Description: The admin theme for Faithmade sub-sites.
 * Version: 0.1
 * Author: Caleb Sylvest and Chris Wallace
 * Author URI: http://liftux.com
 * Text Domain: faithmade
 */

define( 'FAITHMADE_PLUGIN_URL', __FILE__ );

/**
 * Loads files relative to the plugin root.
 */
function faithmade_asset_url( $file ){

    return plugins_url( $file, FAITHMADE_PLUGIN_URL );

}

function faithmade_login_stylesheet() {
    wp_enqueue_style( 'faithmade-login', faithmade_asset_url( 'style-login.css' ) );
}
add_action( 'login_enqueue_scripts', 'faithmade_login_stylesheet', 10 );


if( is_admin() ){
    require_once( 'cmb2/init.php' );
    require_once( 'inc/custom-admin.php' );
    //require_once( 'inc/domain-mapping.php' );
}

if( strpos($_SERVER['REQUEST_URI'],'/wp-signup.php') !== false ){
    require_once( 'inc/custom-signup.php' );
}

function faithmade_adminbar_css() {
    if( is_user_logged_in() ){
        wp_enqueue_style( 'faithmade-admin-bar', faithmade_asset_url( 'admin-bar.css' ) );
    }
}

add_action( 'wp_enqueue_scripts', 'faithmade_adminbar_css' );

/**
 * Remove admin bar links.
 */
function faithmade_remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    //$wp_admin_bar->remove_menu('new-content');      // Remove the content link
    //$wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    //$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
add_action( 'wp_before_admin_bar_render', 'faithmade_remove_admin_bar_links' );
