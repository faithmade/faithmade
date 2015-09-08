<?php
/**
 * Custom admin theme for Faithmade.
 *
 * This theme removes some of the "fluff" and incorporates custom styles
 * for the administrative portion of all user sites.
 */

// add our custom stylesheet
add_action( 'admin_enqueue_scripts', 'faithmade_custom_css' );

function faithmade_custom_css() {
	wp_enqueue_style( 'faithmade-styles', faithmade_asset_url( 'style.css' ) );
	add_editor_style( faithmade_asset_url( 'editor-style.css' ) );
}

/**
 * Removes admin items from multisite.
 */
function faithmade_remove_admin_items() {
	if( ! is_super_admin() ){
		remove_menu_page( 'plugins.php' );
	}
	if( ! current_user_can( 'switch_themes') ) {
		remove_menu_page( 'tools.php' );
	}
}

add_action( 'admin_menu', 'faithmade_remove_admin_items', 99 );

/**
 * Remove welcome panel.
 */
remove_action( 'welcome_panel', 'wp_welcome_panel' );

/**
 * remove admin color scheme picker.
 */
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

/**
 * Remove dashboard widgets.
 */
function faithmade_remove_wp_dashboard_widgets() {
	global $wp_meta_boxes;
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}

add_action( 'admin_init', 'faithmade_remove_wp_dashboard_widgets' );

/**
 * Change admin footer text
 */
function faithmade_remove_admin_footer_text($footer_text =''){
	return 'Copyright ' . date('Y') . ' The Faithmade Website Co. All Rights Reserved.';
}
add_filter('admin_footer_text', 'faithmade_remove_admin_footer_text', 1000);

/**
 * Remove WordPress version from admin.
 */
function faithmade_remove_admin_footer_upgrade($footer_text =''){
	return '';
}
add_filter('update_footer', 'faithmade_remove_admin_footer_upgrade', 1000);

/**
 * Remove tools menu. We don't need it.
 */
function faithmade_remove_menus(){

  //remove_menu_page( 'tools.php' ); //Tools

}
add_action( 'admin_menu', 'faithmade_remove_menus' );

/**
 * Remove help tab from all admin pages.
 */
function faithmade_remove_help_tabs() {
	$screen = get_current_screen();
	$screen->remove_help_tabs();
}

add_action('admin_head', 'faithmade_remove_help_tabs');

/**
 * Remove Screen Options on Dashboard only.
 */
function faithmade_remove_screen_options($show_screen){
	$screen = get_current_screen();

	if( $screen->id === 'dashboard')
		return false;
	else
		return $show_screen;
}
add_filter('screen_options_show_screen','faithmade_remove_screen_options');

/**
 * Send emails from WordPress as support@faithmade.net.
 */
function faithmade_from_email(){
	return 'support@faithmade.net';
}
add_filter('wp_mail_from','mail_from');

/**
 * Send emails from WordPress as Faithmade.
 */
function faithmade_from_name(){
	return 'Faithmade';
}
add_filter('wp_mail_from_name','mail_from_name');

/**
 * Removes CoSchedule Redirect on Activation on Site Creation
 * 
 * @internal CoSchedule has a singleton core class and their is not access to the
 * instance outside of the class, so we have to hook redirect.
 */
function faithmade_maybe_suppress_coschedule_redirect( $location, $status ) {
	// Bail if this is any redirect except coschedule's
	if( ! strpos( $location, 'tm_coschedule_calendar' ) ) {
		return $location;
	}

	// If we are coming from wp-admin/plugins.php we can assume this was user initiated,
	// in which case, we want them to redirect to the setup page.
	if( false !== strpos( parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_PATH), 'wp-admin/plugins.php' ) ) {
		return $location;
	}

	// This should be our unique use case where users are coming in to a fresh dashboard without having
	// expired the coschedule activation redirect function.  In this case, override it and send them home.
	return admin_url();
}
if( is_admin() ) {
	add_action( 'wp_redirect', 'faithmade_maybe_suppress_coschedule_redirect', 10, 2 );
}
