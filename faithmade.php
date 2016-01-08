<?php
/**
 * Plugin Name: Faithmade Admin Theme
 * Description: The admin theme for Faithmade sub-sites.
 * Version: 0.2
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
    require_once( 'inc/string-branding.php' );
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

function faithmade_remove_gf_menu_links() {
    //remove_submenu_page( 'gf_edit_forms', 'gf_settings' );
    remove_submenu_page( 'gf_edit_forms', 'gf_update' );
    remove_submenu_page( 'gf_edit_forms', 'gf_addons' );
    remove_submenu_page( 'gf_edit_forms', 'gf_help' );
}

add_action( 'admin_menu', 'faithmade_remove_gf_menu_links', 99999 );

function faithmade_admin_bar_logo( $wp_admin_bar ) {
    $args = array(
            'id' => 'faithmade-logo',
            'title' => '<span class="ab-icon"></span>',
            'href' => network_home_url(),
            'meta' => array(
                'title' => __('Faithmade Home'),
            ),
        );

    $wp_admin_bar->add_node( $args );
}

add_action( 'admin_bar_menu', 'faithmade_admin_bar_logo', 1 );


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

function faithmade_admin_bar_logo_replace(){
    echo '<style type="text/css">
    #wpadminbar #wp-admin-bar-faithmade-logo > .ab-item{
        padding-left: 10px;
        padding-right: 6px;
    }

    #wpadminbar #wp-admin-bar-faithmade-logo > .ab-item .ab-icon:after{
    content: "";
    background-image: url("' . plugins_url() . '/faithmade-plugin/assets/images/faithmade-lion.svg");
    background-size: contain;
    width: 22px;
    height: 22px;
    display: inline-block;
}
</style>';

}

add_action( 'wp_head', 'faithmade_admin_bar_logo_replace' );
add_action( 'admin_head', 'faithmade_admin_bar_logo_replace' );

/**
 * Redirect to blog
 * http://premium.wpmudev.org/forums/topic/you-attempted-to-access-the-main-site-dashboard-but-you-do-not-currently-have-privileges?utm_expid=3606929-52.ZpfeUjXqSWOCaoohIqoFQQ.0&utm_referrer=https%3A%2F%2Fwww.google.com%2F#post-693847
 */
add_filter('login_redirect', 'custom_redirect_filter', 0, 3);

function custom_redirect_filter($redirect_to, $request, $user) {

    if( is_user_logged_in() ):

        $user_blogs = get_blogs_of_user($user->ID);

        foreach ($user_blogs as $user_blog) {
            $user_blog->path;
            return site_url($user_blog->path);
        }

    endif;

    return site_url();
}

function faithmade_cache_control() {
    if( ! class_exists('rtCamp\WP\Nginx\Helper') ) 
        return;

    global $rt_wp_nginx_purger;
    add_action( 'save_post', array( &$rt_wp_nginx_purger, 'purge_them_all' ), 200, 1 );
    add_action( 'wp_creating_autosave', array( &$rt_wp_nginx_purger, 'purge_them_all' ), 200, 1 );
}
add_action( 'init', 'faithmade_cache_control', 15 );

/**
 * Enqueues Styles on wp-activate.php
 * 
 * @return void
 */
function faithmade_enqueue_activate_styles() {
    wp_enqueue_script( 'faithmade-wp-activate-style', plugins_url( 'activate.css', __FILE__ );
}
add_action( 'activate_wp_head', 'faithmade_enqueue_activate_styles', 200 );