<?php
/**
 * Base options template abstract class.
 *
 * @since   3.0.0
 * @package The7\Options
 */

/**
 * Options template abstract base class.
 */
abstract class The7_Options_Template_Abstract {

	/**
	 * Apply options template to $options array.
	 *
	 * @param  array &$options
	 * @param  string $prefix
	 * @param  array  $fields
	 */
	public function execute( &$options, $prefix, $fields = array(), $dependency = array() ) {
		$_fields = $this->do_execute();

		$_fields = $this->merge_fields( $_fields, $fields );
		$_fields = array_filter( $_fields );

		$prefix = ( $prefix ? $prefix . '-' : '' );
		foreach ( $_fields as $field_id => $field ) {
			$field_id = ( isset( $field['id'] ) ? $field['id'] : $field_id );

			if ( ! is_numeric( $field_id ) ) {
				$field_id = $prefix . $field_id;

				$field['id'] = $field_id;

				$field = $this->prefacing_dependency( $prefix, $field );

				if ( $dependency ) {
					$field['dependency'] = isset( $field['dependency'] ) ? array_merge_recursive( $field['dependency'], $dependency ) : $dependency;
				}

				$options[ $field_id ] = $field;
			} else {
				$options[] = $field;
			}
		}
	}

	protected function merge_fields( &$fields1, &$fields2 ) {
		$merged = $fields1;

		foreach ( $fields2 as $key => &$value ) {
			if ( is_array( $value ) && isset ( $merged [ $key ] ) && is_array( $merged [ $key ] ) ) {
				$merged [ $key ] = $this->merge_fields( $merged [ $key ], $value );
			} else {
				$merged [ $key ] = $value;
			}
		}

		return $merged;
	}

	protected function prefacing_dependency( $prefix, $field ) {
		if ( ! isset( $field['dependency'] ) ) {
			return $field;
		}

		$field['dependency'] = optionsframework_fields_dependency()->decode_short_syntax( $field['dependency'] );

		foreach ( $field['dependency'] as $i => $or ) {
			foreach ( $or as $j => $and ) {
				$field['dependency'][ $i ][ $j ]['field'] = $prefix . $and['field'];
			}
		}

		return $field;
	}

	/**
	 * Template method.
	 *
	 * @return array
	 */
	abstract protected function do_execute();
}