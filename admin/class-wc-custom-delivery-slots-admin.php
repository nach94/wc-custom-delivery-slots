<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://helloeveryone.me/
 * @since      1.0.0
 *
 * @package    Wc_Custom_Delivery_Slots
 * @subpackage Wc_Custom_Delivery_Slots/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Custom_Delivery_Slots
 * @subpackage Wc_Custom_Delivery_Slots/admin
 * @author     HelloEveryone <hola@helloeveryone.me>
 */
class Wc_Custom_Delivery_Slots_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function add_admin_menu() {
		add_menu_page(
			'Delivery Slots',
			'Delivery Slots',
			'manage_options',
			'wc-custom-delivery-slots',
			array( $this, 'display_admin_page' ),
			'dashicons-clock',
			10
		);
	}

	public function display_admin_page() {
		include 'partials/wc-custom-delivery-slots-admin-display.php';
	}

	public function register_settings() {
		register_setting( 'wc_custom_delivery_slots_group', 'wc_custom_delivery_slots_options', array( $this, 'validate_options' ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Custom_Delivery_Slots_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Custom_Delivery_Slots_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-custom-delivery-slots-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Custom_Delivery_Slots_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Custom_Delivery_Slots_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-custom-delivery-slots-admin.js', array( 'jquery' ), $this->version, false );

	}

}
