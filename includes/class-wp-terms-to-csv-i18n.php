<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/thatwpdeveloper/wp-terms-to-csv
 * @since      1.0.0
 *
 * @package    Wp_Terms_To_Csv
 * @subpackage Wp_Terms_To_Csv/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Terms_To_Csv
 * @subpackage Wp_Terms_To_Csv/includes
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Wp_Terms_To_Csv_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-terms-to-csv',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
