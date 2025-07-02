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

		add_submenu_page(
			'wc-custom-delivery-slots',
			'Configurar horarios',
			'Configurar horarios',
			'manage_options',
			'wc-custom-delivery-slots-slots-config',
			array( $this, 'display_slots_config_page' )
		);
	}

	public function display_admin_page() {
		include 'partials/views/main-page/wc-custom-delivery-slots-admin-main-page.php';
	}

	public function display_slots_config_page() {
		include 'partials/views/slots-config/wc-custom-delivery-slots-admin-slots-config.php';
	}

	public function register_settings() {
		register_setting( 'wc_custom_delivery_slots_group', 'wc_custom_delivery_slots', array( $this, 'validate_options' ) );
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

	public function validate_options($input) {
		// Si no se envió el campo de métodos de envío, lo seteamos como array vacío
		if (!isset($input['_wc_cds_shipping_methods'])) {
			$input['_wc_cds_shipping_methods'] = array();
		}
		// Procesar fechas especiales para asegurar que se guarden todas
		if (isset($input['_wc_cds_special_dates']) && is_array($input['_wc_cds_special_dates'])) {
			$special_dates = array();
			foreach ($input['_wc_cds_special_dates'] as $row) {
				if (!empty($row['date'])) {
					$special_dates[] = array(
						'date' => sanitize_text_field($row['date']),
						'fee' => isset($row['fee']) ? floatval($row['fee']) : '',
						'every_year' => isset($row['every_year']) ? '1' : '',
					);
				}
			}
			$input['_wc_cds_special_dates'] = $special_dates;
		} else {
			$input['_wc_cds_special_dates'] = array();
		}
		return $input;
	}

}
