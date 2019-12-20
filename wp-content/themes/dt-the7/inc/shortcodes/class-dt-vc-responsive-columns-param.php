<?php

if ( ! class_exists( 'DT_VCResponsiveColumnsParam' ) ) :

	/**
	 * Class DT_VCResponsiveColumnsParam
	 */
	class DT_VCResponsiveColumnsParam {

		/**
		 * Try to convert $columns string like 'key1:value1|key2:value2' to array [key1=>value1, key2=>value2]. Just return $columns if is array.
		 *
		 * @param mixed $columns
		 *
		 * @return array
		 */
		public static function decode_columns( $columns ) {
			if ( ! $columns || ! ( is_string( $columns ) || is_array( $columns ) ) ) {
				return array();
			}

			if ( is_string( $columns ) ) {
				$columns_array = array();
				$exploded_columns = array_map( 'trim', explode( '|', $columns ) );
				foreach ( $exploded_columns as $column_str ) {
					list( $device, $col ) = explode( ':', $column_str );
					$col = absint( $col );
					if ( $col ) {
						$columns_array[ $device ] = $col;
					}
				}

				return $columns_array;
			}

			return $columns;
		}

		/**
		 * Convert array to string like 'key1:value1|key2:value2'.
		 *
		 * @param array $columns
		 *
		 * @return string
		 */
		public static function encode_columns( $columns ) {
			$columns_array = array();
			foreach ( $columns as $device => $col ) {
				$col = absint( $col );
				if ( $col ) {
					$columns_array[] = "{$device}:{$col}";
				}
			}

			return join( '|', $columns_array );
		}
	}

endif;
