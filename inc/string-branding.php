<?php
/**
 * Functions to replace vendor branded strings with our brand
 */

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

/**
 * Cast a wide net over the wordpress-importer text domain
 */
function faithmade_replace_wordpress_importer( $translated_text, $text, $domain ) {
	 switch ( $translated_text ) {
        case 'If you have posts or comments in another system, WordPress can import those into this site. To get started, choose a system to import from below:';
            $translated_text = __( 'If you have posts or comments in another system, you can import those into this site. To get started, choose a system to import from below:' );
        	break;
        case 'When you click the button below WordPress will create an XML file for you to save to your computer.' :
        	$translated_text = __('When you click the button below Faithmade will create an XML file for you to save to your computer.');
        	break;
        case 'This format, which we call WordPress eXtended RSS or WXR, will contain your posts, pages, comments, custom fields, categories, and tags.' :
        	$translated_text = __('This format will contain your posts, pages, comments, custom fields, categories, and tags.');
        	break;
        case 'Once you&#8217;ve saved the download file, you can use the Import function in another WordPress installation to import the content from this site.' :
        	$translated_text = __('Once you&#8217;ve saved the download file, you can use the Import function in another Faithmade installation to import the content from this site.');
        	break;
        case 'a' :
        	$translated_text = __('b');
        	break;
    }

    return $translated_text;
}

add_filter( 'gettext', 'faithmade_replace_wordpress_importer', 10, 3 );

/**
 * Loads a language compatibility translation file overtop of the default gravity forms language file if the 
 * locale is en_US.  The loaded translation file replaces instances of WordPress with Faithmade.
 *
 */
function faithmade_load_gf_lang_compat_texdomain( $domain, $mofile ) {
	if( 'gravityforms' === $domain && plugin_dir_path( $mofile ) === WP_LANG_DIR . '/gravityforms/' ) {
		load_textdomain( 'gravityforms', dirname(FAITHMADE_PLUGIN_URL) . '/assets/lang-compat/gravityforms-' . get_locale() . '.mo' );
	}
}

add_action( 'load_textdomain', 'faithmade_load_gf_lang_compat_texdomain', 10, 2 );