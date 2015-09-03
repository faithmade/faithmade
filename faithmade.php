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

function faithmade_replace_wordpress( $translated_text, $text, $domain ){

    switch ( $translated_text ) {
        case 'WordPress should correct invalidly nested XHTML automatically' :
            $translated_text = __( 'Faithmade should correct invalidly nested XHTML automatically', 'faithmade' );

        break;
    }

    return $translated_text;

}

add_filter( 'gettext', 'faithmade_replace_wordpress', 10, 3 );

function faithmade_replace_wordpress_xhtml( $translated_text, $text, $domain ){

    switch ( $translated_text ) {
        case 'WordPress should correct invalidly nested XHTML automatically' :
            $translated_text = __( 'Faithmade should correct invalidly nested XHTML automatically', 'faithmade' );

        break;
    }

    return $translated_text;

}

add_filter( 'gettext', 'faithmade_replace_wordpress_xhtml', 10, 3 );

function faithmade_replace_wordpress_comment_contains1( $translated_text, $text, $domain ){

    switch ( $translated_text ) {

        case 'When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be held in the <a href="edit-comments.php?comment_status=moderated">moderation queue</a>. One word or IP per line. It will match inside words, so &#8220;press&#8221; will match &#8220;WordPress&#8221;.':
            $translated_text = __( 'When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be held in the <a href="edit-comments.php?comment_status=moderated">moderation queue</a>. One word or IP per line. It will match inside words, so &#8220;made&#8221; will match &#8220;Faithmade&#8221;.' );

        break;
    }

    return $translated_text;

}

add_filter( 'gettext', 'faithmade_replace_wordpress_comment_contains1', 10, 3 );

function faithmade_replace_wordpress_comment_contains2( $translated_text, $text, $domain ){

    switch ( $translated_text ) {

        case 'When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be marked as spam. One word or IP per line. It will match inside words, so &#8220;press&#8221; will match &#8220;WordPress&#8221;.';
            $translated_text = __( 'When a comment contains any of these words in its content, name, URL, e-mail, or IP, it will be marked as spam. One word or IP per line. It will match inside words, so &#8220;made&#8221; will match &#8220;Faithmade&#8221;.' );

        break;
    }

    return $translated_text;

}

add_filter( 'gettext', 'faithmade_replace_wordpress_comment_contains2', 10, 3 );

function faithmade_replace_wordpress_permalink( $translated_text, $text, $domain ){

    switch ( $translated_text ) {
        case 'By default WordPress uses web <abbr title="Universal Resource Locator">URL</abbr>s which have question marks and lots of numbers in them; however, WordPress offers you the ability to create a custom URL structure for your permalinks and archives. This can improve the aesthetics, usability, and forward-compatibility of your links. A <a href="https://codex.wordpress.org/Using_Permalinks">number of tags are available</a>, and here are some examples to get you started.';
            $translated_text = __( 'By default Faithmade uses web <abbr title="Universal Resource Locator">URL</abbr>s which have question marks and lots of numbers in them; however, Faithmade offers you the ability to create a custom URL structure for your permalinks and archives. This can improve the aesthetics, usability, and forward-compatibility of your links. A <a href="https://codex.wordpress.org/Using_Permalinks">number of tags are available</a>, and here are some examples to get you started.' );

        break;
    }

    return $translated_text;

}

add_filter( 'gettext', 'faithmade_replace_wordpress_permalink', 10, 3 );

function faithmade_replace_gf_text( $translated_text, $text, $domain ){

    switch ( $translated_text ) {
        case 'Select the forms you would like to export. When you click the download button below, Gravity Forms will create a JSON file for you to save to your computer. Once you\'ve saved the download file, you can use the Import tool to import the forms.';
            $translated_text = __( 'Select the forms you would like to export. When you click the download button below, we will create a JSON file for you to save to your computer. Once you\'ve saved the download file, you can use the Import tool to import the forms.' );

        break;
    }

    return $translated_text;

}

add_filter( 'gettext', 'faithmade_replace_gf_text', 10, 3 );

function faithmade_replace_gf_text_again( $translated_text, $text, $domain ){

    switch ( $translated_text ) {
        case 'Select a form below to export entries. Once you have selected a form you may select the fields you would like to export and then define optional filters for field values and the date range. When you click the download button below, Gravity Forms will create a CSV file for you to save to your computer.';
            $translated_text = __( 'Select a form below to export entries. Once you have selected a form you may select the fields you would like to export and then define optional filters for field values and the date range. When you click the download button below, we will create a CSV file for you to save to your computer.' );

        break;
    }

    return $translated_text;

}

add_filter( 'gettext', 'faithmade_replace_gf_text_again', 10, 3 );


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
<<<<<<< HEAD
=======

>>>>>>> 642b83f... Add new menu icon with link
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

<<<<<<< HEAD
=======
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
>>>>>>> 642b83f... Add new menu icon with link

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
