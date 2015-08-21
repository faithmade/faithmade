<?php

namespace Mercator;

/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class Custom_Domain_Admin {

	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'faithmade_dm_options';

	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'faithmade_dm_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Custom Domain', 'faithmade' );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
		add_action( 'cmb2_save_options-page_fields', array( $this, 'save_meta_fields' ) );

	}

	/**
	 * Save domain mapping.
	 * @since 0.1.0
	 */
	public function save_meta_fields(){
		global $wpdb;

		$site_id       = get_current_blog_id();
		$site_url      = esc_url( $_POST['custom_domain'] );
		$site_active   = intval( $_POST['domain_active'] );

		if( ! $site_id || ! $site_url )
			return;

		// Suppress errors in case the table doesn't exist
		$where = array( 'blog_id' => $site_id );
		$where_format = array( '%d' );
		$result = $wpdb->delete( $wpdb->dmtable, $where, $where_format );

		$created = Mapping::create( $site_id, $site_url, $active = $site_active );

	}

	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

		// Include CMB CSS in the head to avoid FOUT
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key, array( 'cmb_styles' => false ) ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {

		//$class = "Mercator\Mapping";

		//$mapping = new $class();

		$site_id = get_current_blog_id();

		$this_mapping = Mapping::get_by_site( $site_id );

		$cmb = new_cmb2_box( array(
			'id'          => $this->metabox_id,
			'hookup'      => false,
			'show_on'     => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields

		$cmb->add_field( array(
			'name' => __( 'Your Domain', 'faithmade' ),
			'desc' => __( 'Enter your domain without the www (ex: faithmade.com)', 'faithmade' ),
			'id'   => 'custom_domain',
			'type' => 'text',
			'default' => $this_mapping,
		) );

		$cmb->add_field( array(
			'name' => __( 'Go live with custom domain:', 'faithmade' ),
			'desc' => sprintf( __( 'This will enable your custom domain and change the URL you use to access your website. You must complete <a href="%s">these steps</a> first.', 'faithmade' ), 'https://support.faithmade.com/custom-domain' ),
			'id'   => 'domain_active',
			'type' => 'select',
			'show_option_none' => false,
			'options'          => array(
				'0'   => __( 'No', 'cmb2' ),
				'1'   => __( 'Yes', 'cmb2' ),
			),
		) );

	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

/**
 * Helper function to get/return the Myprefix_Admin object
 * @since  0.1.0
 * @return Myprefix_Admin object
 */
function faithmade_dm_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new Custom_Domain_Admin();
		$object->hooks();
	}

	return $object;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function faithmade_dm_get_option( $key = '' ) {
	return cmb2_get_option( faithmade_dm_admin()->key, $key );
}

// Get it started
faithmade_dm_admin();