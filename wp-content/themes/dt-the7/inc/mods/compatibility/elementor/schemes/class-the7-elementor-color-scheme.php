<?php

namespace The7\Adapters\Elementor\Schemes;

use Elementor\Core\Schemes\Color;
use Elementor\Settings;

defined( 'ABSPATH' ) || exit;

/**
 * The7 extended Elementor color scheme.
 * Elementor color scheme class is responsible for initializing a scheme for
 * colors.
 * @since 1.0.0
 */
class The7_Elementor_Color_Scheme extends Color {

	/**
	 * Get default color scheme.
	 * Retrieve the default color scheme.
	 * @since  1.0.0
	 * @access public
	 * @return array Default color scheme.
	 */
	public function get_default_scheme() {
		return [
			self::COLOR_1 => of_get_option( 'content-headers_color', '#000000' ),
			self::COLOR_2 => of_get_option( 'content-primary_text_color', '#000000' ),
			self::COLOR_3 => of_get_option( 'content-secondary_text_color', '#000000' ),
			self::COLOR_4 => the7_theme_accent_color(),
		];
	}

	/**
	 * Print color scheme content template.
	 * Used to generate the HTML in the editor using Underscore JS template. The
	 * variables for the class are available using `data` JS object.
	 * @since  1.0.0
	 * @access public
	 */
	public function print_template_content() {
		?>
        <div class="elementor-panel-scheme-content elementor-panel-box">
            <div class="elementor-panel-scheme-items elementor-panel-box-content" style="display: none"></div>
        </div>
        <div class="elementor-panel-scheme-colors-more-palettes elementor-panel-box">
            <div class="elementor-panel-heading">
                <div class="elementor-panel-heading-title"><?php echo __( 'The7 palette', 'the7mk2' ); ?></div>
            </div>
            <div class="elementor-panel-box-content">
				<?php foreach ( $this->_get_system_schemes_to_print() as $scheme_name => $scheme ) : ?>
                    <div class="elementor-panel-scheme-color-system-scheme"
                         data-scheme-name="<?php echo esc_attr( $scheme_name ); ?>">
                        <div class="elementor-panel-scheme-color-system-items">
							<?php foreach ( $scheme['items'] as $color_value ) : ?>
                                <div class="elementor-panel-scheme-color-system-item"
                                     style="background-color: <?php echo esc_attr( $color_value ); ?>;"></div>
							<?php endforeach; ?>
                        </div>
                        <div class="elementor-title"><?php echo $scheme['title']; ?></div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>

        <div class="elementor-content-the7 elementor-scheme-color-the7 elementor-nerd-box">
            <img class="elementor-nerd-box-icon" src="<?php echo ELEMENTOR_ASSETS_URL . 'images/information.svg'; ?>"/>
            <div class="elementor-nerd-box-title"><?php echo __( 'Elementor uses The7 colors', 'the7mk2' ); ?></div>
            <div class="elementor-nerd-box-message"><?php printf( __( 'You can disable it from the <a href="%s" target="_blank">Elementor settings page</a>.', 'the7mk2' ), Settings::get_url() ); ?></div>
        </div>
		<?php
	}

	/**
	 * Init system color schemes.
	 * Initialize the system color schemes.
	 * @since  1.0.0
	 * @access protected
	 * @return array System color schemes.
	 */
	protected function _init_system_schemes() {
		return [
			'the7_options' => [
				'title' => __( 'The7 theme options', 'the7mk2' ),
				'items' => $this->get_default_scheme(),
			],
		];
	}
}
