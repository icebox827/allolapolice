<?php
/**
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Web_Fonts_Compressor {

	/**
	 * @var array
	 */
	protected $fonts = array();

	/**
	 * @var string
	 */
	protected $display = '';

	/**
	 * The7_Web_Fonts_Compressor constructor.
	 *
	 * @param array $fonts
	 */
	public function __construct( array $fonts ) {
		foreach ( $fonts as &$font ) {
			if ( ! $font instanceof The7_Web_Font_Interface ) {
				$font = new The7_Web_Font( $font );
			}
		}

		$this->fonts = $fonts;
	}

	/**
	 * @param string $display
	 */
	public function add_display_prop( $display ) {
		$this->display = $display;
	}

	/**
	 * @return string
	 */
	public function compress_to_url() {
		$compressed_fonts = $this->compress_fonts_to_array( $this->fonts );
		$query_args       = array(
			'family' => implode( '|', $compressed_fonts ),
		);

		if ( $this->display ) {
			$query_args['display'] = sanitize_key( $this->display );
		}

		return add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	/**
	 * @param array $fonts
	 *
	 * @return array
	 */
	protected function compress_fonts_to_array( array $fonts ) {
		$compressed_fonts = array();
		foreach ( $fonts as $font ) {
			$family = $font->get_family();

			if ( ! $family ) {
				continue;
			}

			if ( ! array_key_exists( $family, $compressed_fonts ) ) {
				$compressed_fonts[ $family ] = array();
			}

			$weight = $font->get_weight();
			if ( $weight ) {
				$compressed_fonts[ $family ] = array_merge( $compressed_fonts[ $family ], $weight );
			}
		}

		$composed_string_parts = array();
		foreach ( $compressed_fonts as $font_family => $font_data ) {
			$composed_font = str_replace( ' ', '+', $font_family );

			if ( ! empty( $font_data ) ) {
				$font_data = array_unique( $font_data );
				sort( $font_data );
				$composed_font .= ':' . implode( ',', $font_data );
			}

			$composed_string_parts[] = $composed_font;
		}

		return $composed_string_parts;
	}

}
