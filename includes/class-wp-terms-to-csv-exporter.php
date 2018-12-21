<?php

/**
 * Fired after form submit.
 *
 * @link       https://github.com/thatwpdeveloper/wp-terms-to-csv
 * @since      1.0.0
 *
 * @package    Wp_Terms_To_Csv
 * @subpackage Wp_Terms_To_Csv/includes
 */

/**
 * Fired after form submit.
 *
 * Gets all the data and builds the CSV file.
 *
 * @since      1.0.0
 * @package    Wp_Terms_To_Csv
 * @subpackage Wp_Terms_To_Csv/includes
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
final class WP_Terms_CSV_Factory {

	/**
	* Holds the instance of the class.
	*
	* @since      1.0.0
    * @access private
	* @var array $instance Holds the instance of the class.
	*/
	private static $instance;
	/**
	 * Placeholder for all registered taxonomies inside WordPress.
	 *
	 * @since      1.0.0
	 * @var array $taxonomies Placeholder for all registered taxonomies inside WordPress.
	 */
	public $taxonomies;
	/**
	 * Placeholder for all registered terms inside WordPress.
	 *
	 * @since      1.0.0
	 * @var array $terms Placeholder for all registered terms inside WordPress.
	 */
	public $terms;
	/**
	 * Placeholder for the generated filename.
	 *
	 * @since      1.0.0
	 * @access     private
	 * @var string $filename Placeholder for the generated filename.
	 */
	private $filename;
	/**
	 * Placeholder for the generated structure.
	 *
	 * @since      1.0.0
	 * @access     private
	 * @var array $structure Placeholder for the generated structure.
	 */
	private $structure = array();
	/**
	 * Placeholder for arguments related to querying terms.
	 *
	 * @since      1.0.0
	 * @access     public
	 * @var array $terms_args Placeholder for arguments related to querying terms.
	 */
	public $terms_args;
	/**
	 * Placeholder for arguments related to querying taxonomies.
	 *
	 * @since      1.0.0
	 * @access     public
	 * @var array $taxonomies_args Placeholder for arguments related to querying taxonomies.
	 */
	public $taxonomies_args;
	/**
	 * Placeholder for the data outputed to file.
	 *
	 * @since      1.0.0
	 * @access     public
	 * @var array $file_data Placeholder for the data outputed to file.
	 */
	protected static $file_data = array();


	/**
	 * WP_Terms_CSV_Factory constructor.
	 */
	public function __construct() {

		$this->set_taxonomies_args();
		$this->set_terms_args();

		add_action( 'wp', $this->run_export() );
	}

	/**
	 * Sets the taxonomies arguments for retrieving data from WordPress.
	 *
	 * @since      1.0.0
	 * @access     protected
	 * @return mixed
	 */
	protected function set_taxonomies_args() {

		$this->taxonomies_args['query'] = array(
			'public' => true
		);

		$this->taxonomies_args['output'] = 'names';

		$this->taxonomies_args['operator'] = 'and';


		return $this->taxonomies_args;
	}

	/**
	 * Sets the terms arguments for retrieving data from WordPress.
	 *
	 * @since      1.0.0
	 * @access     protected
	 * @return mixed
	 */
	protected function set_terms_args() {

		$this->terms_args['query'] = array(
			'hide_empty' => false
		);

		return $this->terms_args;
	}

	/**
	 * @return array
	 */
	protected function get_taxonomies() {

		$this->taxonomies = get_taxonomies(
			$this->taxonomies_args['query'],
			$this->taxonomies_args['output'],
			$this->taxonomies_args['operator']
		);

		return $this->taxonomies;
	}

	/**
	 * @param $taxonomy
	 *
	 * @return array|int|WP_Error
	 */
	public function get_terms( $taxonomy ) {

		$this->terms = get_terms( $taxonomy, $this->terms_args['query'] );


		return $this->terms;
	}

	/**
	 * @return string
	 */
	public function set_filename() {

		$now = date( 'j-m-Y-h-i-s-a' );

		$custom_filename = sanitize_text_field( $_REQUEST['filename'] );

		if ( ! empty( $custom_filename ) ) {
			$this->filename = $custom_filename;
		} else {
			$this->filename = 'csv-terms-export-' . $now;
		}

		return $this->filename;
	}

	/**
	 * @return array
	 */
	protected function set_structure_columns() {
		$this->structure['names'] = array();
		$this->structure['slugs'] = array();
		$this->structure['count'] = array();

		return $this->structure;
	}

	/**
	 * @param $taxonomy
	 *
	 * @return array
	 */
	public function set_structure_headings( $taxonomy ) {

		array_unshift( $this->structure['names'], $taxonomy );
		array_unshift( $this->structure['slugs'], $taxonomy . '-slugs' );
		array_unshift( $this->structure['count'], $taxonomy . '-count' );

		return $this->structure;

	}

	/**
	 *
	 */
	public function get_headers() {
		$this->set_header( 'Content-type: text/csv' );
		$this->set_header( 'Content-Disposition: attachment; filename=' . $this->filename . '.csv' );
		$this->set_header( 'Pragma: no-cache' );
		$this->set_header( 'Expires: 0' );
	}

	/**
	 * @param $terms
	 *
	 * @return array
	 */
	public function iterate_terms( $terms ) {

		foreach ( $terms as $term ) {
			$this->structure['names'][] = $term->name;
			$this->structure['slugs'][] = $term->slug;
			$this->structure['count'][] = $term->count;
		}

		return $this->structure;
	}

	/**
	 *
	 */
	public function iterate_taxonomies() {

		foreach ( $this->taxonomies as $taxonomy ) {

			$this->set_structure_columns();

			$this->set_structure_headings( $taxonomy );

			$this->iterate_terms(
				$this->get_terms( $taxonomy )
			);

			$this->prepare_contents();
		}
	}


	/**
	 * @param $array
	 *
	 * @return array
	 */
	public static function transpose( $array ) {
		return array_map( null, ...$array );
	}

	/**
	 * @param $header
	 */
	public function set_header( $header ) {
		return header( $header );
	}

	/**
	 * @return array
	 */
	public function prepare_contents() {
		self::$file_data[] = $this->structure['names'];
		self::$file_data[] = $this->structure['slugs'];
		self::$file_data[] = $this->structure['count'];

		return self::$file_data;
	}

	/**
	 *
	 */
	public function output_to_file() {

		$file = fopen( 'php://output', 'w' );

		foreach ( self::transpose( self::$file_data ) as $column ) {
			fputcsv( $file, $column );
		}
	}

	/**
	 *
	 */
	public function run_export() {

		$this->get_taxonomies();

		if ( ! is_admin() || empty( $this->taxonomies ) ) {
			return;
		}

		$this->iterate_taxonomies();

		$this->set_filename();

		$this->get_headers();

		$this->output_to_file();

		exit();
	}

	public static function init()
	{
		if (!isset(self::$instance)) {
			self::$instance = new WP_Terms_CSV_Factory();
		}
		return self::$instance;
	}

}