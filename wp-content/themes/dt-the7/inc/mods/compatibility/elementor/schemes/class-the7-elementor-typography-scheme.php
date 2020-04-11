<?php

namespace The7\Adapters\Elementor\Schemes;

use Elementor\Core\Schemes\Typography;
use Elementor\Settings;
use The7_Option_Field_Typography;
use The7_Web_Font;

defined( 'ABSPATH' ) || exit;

/**
 * The7 extended Elementor typography scheme.
 * Elementor typography scheme class is responsible for initializing a scheme
 * for typography.
 * @since 1.0.0
 */
class The7_Elementor_Typography_Scheme extends Typography {

	/**
	 * Get The7 typography scheme.
	 * Retrieve The7 typography scheme.
	 * @since  1.0.0
	 * @access public
	 * @return array Default typography scheme.
	 */
	public function get_default_scheme() {
		$font_array = [
			self::TYPOGRAPHY_1 => The7_Option_Field_Typography::sanitize( of_get_option( 'fonts-h1-typography' ) ),
			self::TYPOGRAPHY_2 => The7_Option_Field_Typography::sanitize( of_get_option( 'fonts-h2-typography' ) ),
			self::TYPOGRAPHY_3 => The7_Option_Field_Typography::sanitize( of_get_option( 'fonts-font_family' ) ),
			self::TYPOGRAPHY_4 => The7_Option_Field_Typography::sanitize( of_get_option( 'fonts-font_family' ) ),
		];

		$typography = [];

		foreach ( $font_array as $id => $font ) {
			$the7_web_font = new The7_Web_Font( $font['font_family'] );

			$font_weight = $the7_web_font->get_weight();
			$font_weight = empty( $font_weight[0] ) ? 'normal' : $font_weight[0];

			$typography[ $id ] = [
				'font_family' => $the7_web_font->get_family(),
				'font_weight' => $font_weight,
			];
		}

		return $typography;
	}

	/**
	 * Print typography scheme content template.
	 * Used to generate the HTML in the editor using Underscore JS template. The
	 * variables for the class are available using `data` JS object.
	 * @since  1.0.0
	 * @access public
	 */
	public function print_template_content() {
		?>
        <div class="elementor-panel-scheme-items" style="display: none"></div>

        <div class="elementor-content-the7 elementor-scheme-typeface-the7 elementor-nerd-box">
            <img class="elementor-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; ?>"/>
            <div class="elementor-nerd-box-title"><?php echo __( 'Elementor uses The7 fonts', 'the7mk2' ); ?></div>
            <div class="elementor-nerd-box-message"><?php printf( __( 'You can disable it from the <a href="%s" target="_blank">Elementor settings page</a>.', 'the7mk2' ), Settings::get_url() ); ?></div>
        </div>
		<?php
	}
}