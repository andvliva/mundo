<?php
/**
 * Class MB_Columns
 *
 * @package    Meta Box
 * @subpackage Meta Box Columns
 */

/**
 * Class MB_Columns
 */
class MB_Columns {

	/**
	 * Meta box object.
	 *
	 * @var RW_Meta_Box
	 */
	protected $meta_box;

	/**
	 * Store the meta box's columns data.
	 *
	 * @var array
	 */
	protected $columns = array();

	/**
	 * Store the columns data which fields use.
	 *
	 * @var array
	 */
	protected $last_column_fields = array();

	/**
	 * Store the last processed fields for each level.
	 *
	 * @var array
	 */
	protected $last_fields = array();

	/**
	 * Store last field for each rows.
	 * Is an array with key is row id and value last field of that row.
	 *
	 * @var array
	 */
	protected $last_row_fields = array();

	/**
	 * Store the total column of a row.
	 *
	 * @var int
	 */
	protected $total_columns = array();

	/**
	 * Track level of field.
	 *
	 * @var int
	 */
	protected $level = -1;

	/**
	 * Add hooks to meta box
	 *
	 * @param RW_Meta_Box $meta_box Meta box object.
	 */
	public function __construct( RW_Meta_Box $meta_box ) {
		$this->meta_box = $meta_box;
		$this->fetch_column_data();
		$this->parse_fields( $this->meta_box->meta_box['fields'] );

		add_action( 'rwmb_before_' . $this->meta_box->id, array( $this, 'filter_field_html' ) );
		add_action( 'rwmb_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'rwmb_after', array( $this, 'remove_markup_filter' ) );
	}

	/**
	 * Fetch and store column data from meta box.
	 */
	protected function fetch_column_data() {
		if ( empty( $this->meta_box->meta_box['columns'] ) ) {
			return;
		}

		$columns = $this->meta_box->columns;
		foreach ( $columns as $column_id => $column_data ) {
			$this->columns[ sanitize_key( $column_id ) ] = $this->parse_column_data( $column_data );
		}
	}

	/**
	 * Parse column data.
	 *
	 * @param  array|int $column_data Column data.
	 *
	 * @return array
	 */
	protected function parse_column_data( $column_data ) {
		if ( is_array( $column_data ) ) {
			return wp_parse_args( $column_data, array(
				'size'  => 12,
				'class' => '',
			) );
		}

		return array(
			'size'  => intval( $column_data ),
			'class' => '',
		);
	}

	/**
	 * Parse meta box fields.
	 *
	 * @param array $fields List of fields.
	 */
	protected function parse_fields( &$fields ) {
		$this->level++;
		$this->total_columns[ $this->level ] = 0;
		foreach ( $fields as $index => $field ) {
			$field['level'] = $this->level;
			$field          = $this->add_logic_data( $field );
			if ( isset( $field['fields'] ) ) {
				$this->parse_fields( $field['fields'] );
			}

			$fields[ $index ] = $field;
		}

		$this->level--;
	}

	/**
	 * Add column logic to field.
	 *
	 * @param array $field Field data.
	 *
	 * @return array
	 */
	protected function add_logic_data( $field ) {
		// Make old syntax compatible.
		if ( empty( $field['column'] ) ) {
			$field = $this->normalize_field_legacy( $field );
		}

		// If still no column defined, it's a naked field.
		if ( empty( $field['column'] ) ) {
			return $field;
		}

		$column_id = sanitize_key( $field['column'] );
		$level     = $field['level'];

		// Do nothing if meta box doesn't have this column.
		if ( ! isset( $this->columns[ $column_id ] ) ) {
			return $field;
		}

		$column           = $this->columns[ $column_id ];
		$field['_column'] = array(
			'start_column' => false,
			'end_column'   => false,
			'start_row'    => false,
			'end_row'      => false,
		);

		// Field starts a new column. Only calculate total columns when new column is created.
		if ( ! isset( $this->last_column_fields[ $column_id ] ) ) {
			if ( 12 <= $this->total_columns[ $level ] ) {
				$this->total_columns[ $level ] = 0;
			}

			if ( 0 === $this->total_columns[ $level ] ) {
				$field['_column']['start_row'] = true;

				// Track the ID of last row field.
				$this->last_row_fields[] = isset( $this->last_fields[ $level ] ) ? $this->last_fields[ $level ] : '';
			}

			$field['_column']['start_column'] = true;
			$field['_column']['size']         = $column['size'];
			$field['_column']['class']        = $column['class'];
			$this->total_columns[ $level ]    += $column['size'];
		}

		$this->last_column_fields[ $column_id ] = $field['id'];
		$this->last_fields[ $level ]            = $field['id'];

		return $field;
	}

	/**
	 * Add column class to field and output opening/closing div for row
	 *
	 * @param array $field Field configuration.
	 *
	 * @return array
	 */
	protected function normalize_field_legacy( $field ) {
		if ( empty( $field['columns'] ) ) {
			return $field;
		}

		$column_id                   = 'column-' . uniqid();
		$this->columns[ $column_id ] = array(
			'size'  => $field['columns'],
			'class' => '',
		);
		$field['column']             = $column_id;

		return $field;
	}

	/**
	 * Add filter for adding column markup to fields.
	 */
	public function filter_field_html() {
		add_filter( 'rwmb_outer_html', array( $this, 'add_column_markup' ), 0, 2 );
	}

	/**
	 * Add column markup for field base on normalized data.
	 *
	 * @param string $outer_html Field HTML.
	 * @param array $field Field data.
	 *
	 * @return string
	 */
	public function add_column_markup( $outer_html, $field ) {
		$this->check_end_column( $field );
		$this->check_end_row( $field );

		$before = '';
		$after  = '';
		if ( $this->is_start_row( $field ) ) {
			$before .= '<div class="rwmb-row">';
		}

		if ( $this->is_start_column( $field ) ) {
			$before .= sprintf( '<div class="%s">', esc_attr( $this->get_column_class( $field ) ) );
		}

		if ( $this->is_end_column( $field ) ) {
			$after .= '</div><!-- .rwmb-column -->';
		}

		if ( $this->is_end_row( $field ) ) {
			$after .= '</div><!-- .rwmb-row -->';
		}

		return $before . $outer_html . $after;
	}

	/**
	 * Check if field is end of column.
	 *
	 * @param array $field Field data.
	 */
	protected function check_end_column( &$field ) {
		if ( in_array( $field['id'], $this->last_column_fields, true ) ) {
			$field['_column']['end_column'] = true;
		}
	}

	/**
	 * Check if field is end of row.
	 *
	 * @param array $field Field data.
	 */
	protected function check_end_row( &$field ) {
		if ( in_array( $field['id'], $this->last_row_fields, true ) || in_array( $field['id'], $this->last_fields ) ) {
			$field['_column']['end_row'] = true;
		}
	}

	/**
	 * Check if this field is start field of column.
	 *
	 * @param  array $field Field data after normalized.
	 *
	 * @return boolean
	 */
	protected function is_start_column( $field ) {
		return ! empty( $field['_column']['start_column'] );
	}

	/**
	 * Check if this field is end field of column.
	 *
	 * @param  array $field Field data after normalized.
	 *
	 * @return boolean
	 */
	protected function is_end_column( $field ) {
		return ! empty( $field['_column']['end_column'] );
	}

	/**
	 * Check if this field is start field of row.
	 *
	 * @param  array $field Field data after normalized.
	 *
	 * @return boolean
	 */
	protected function is_start_row( $field ) {
		return ! empty( $field['_column']['start_row'] );
	}

	/**
	 * Check if this field is end field of row.
	 *
	 * @param  array $field Field data after normalized.
	 *
	 * @return boolean
	 */
	protected function is_end_row( $field ) {
		return ! empty( $field['_column']['end_row'] );
	}

	/**
	 * Get column CSS class.
	 *
	 * @param  array $field Field data.
	 *
	 * @return string
	 */
	protected function get_column_class( $field ) {
		$classes = array( 'rwmb-column' );

		// Column size.
		$classes[] = 'rwmb-column-' . intval( $field['_column']['size'] );

		// Custom column class.
		if ( isset( $field['_column']['class'] ) ) {
			$classes[] = $field['_column']['class'];
		}

		// Custom first and last classes.
		if ( $this->is_start_column( $field ) && $this->is_start_row( $field ) ) {
			$classes[] = 'rwmb-column-first';
		}
		if ( $this->is_end_column( $field ) && $this->is_end_row( $field ) ) {
			$classes[] = 'rwmb-column-last';
		}

		return implode( ' ', $classes );
	}

	/**
	 * Enqueue scripts and styles for columns
	 */
	public function enqueue() {
		list( , $url ) = RWMB_Loader::get_path( dirname( __FILE__ ) );
		wp_enqueue_style( 'rwmb-columns', $url . 'columns.css', '', '1.0.0' );
	}

	/**
	 * Remove filter after displayed meta box.
	 */
	public function remove_markup_filter() {
		remove_filter( 'rwmb_outer_html', array( $this, 'add_column_markup' ), 0 );
	}
}
