<?php

function faithmade_signup_remove_styles(){
	/**
	 * Removes the inline styles from the signup template.
	 */
	remove_action( 'wp_head', 'wpmu_signup_stylesheet' );
}

add_action( 'wp_head', 'faithmade_signup_remove_styles', 0 );

function faithmade_signup_enqueue_styles(){
	wp_enqueue_style( 'faithmade-signup', plugins_url( '/signup.css', FAITHMADE_PLUGIN_URL ) );
}

add_action( 'wp_enqueue_scripts', 'faithmade_signup_enqueue_styles' );