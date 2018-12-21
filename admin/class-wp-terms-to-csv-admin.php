<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/thatwpdeveloper/wp-terms-to-csv
 * @since      1.0.0
 *
 * @package    Wp_Terms_To_Csv
 * @subpackage Wp_Terms_To_Csv/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Terms_To_Csv
 * @subpackage Wp_Terms_To_Csv/admin
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Wp_Terms_To_Csv_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * TODO: Write this
	 *
	 * @since    1.0.0
	 */
	public function process_export() {

		WP_Terms_CSV_Factory::init();

		wp_die();
	}

	/**
	 * TODO: Write this
	 *
	 * @since    1.0.0
	 */
	public function add_export_form() {
		include plugin_dir_path( dirname( __FILE__ ) ) . '/admin/partials/csv-export-form.php';
	}

	/**
	 * TODO: Write this
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_page() {

		add_submenu_page(
			'tools.php',
			__( 'WP Terms to CSV', 'wp-terms-to-csv' ),
			__( 'WP Terms to CSV', 'wp-terms-to-csv' ),
			'manage_options',
			'wp-terms-to-csv',
			array( $this, 'add_export_form' )
		);
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
		 * defined in Wp_Terms_To_Csv_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Terms_To_Csv_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-terms-to-csv-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wp_Terms_To_Csv_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Terms_To_Csv_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-terms-to-csv-admin.js', array( 'jquery' ), $this->version, false );

	}

}
