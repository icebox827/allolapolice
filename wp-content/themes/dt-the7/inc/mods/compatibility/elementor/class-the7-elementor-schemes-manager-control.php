<?php

/**
 * Allow to override an elementor schemes.
 *
 * @package The7
 */

namespace The7\Adapters\Elementor;

use Elementor\Core\Files\CSS\Global_CSS;
use Elementor\Plugin as Elementor;
use Elementor\Settings;
use Elementor\Core\Schemes as Elementor_Schemes;
use Elementor\Core\Schemes\Manager as Schemes_Manager;
use The7\Adapters\Elementor\Schemes\The7_Elementor_Color_Scheme;
use The7\Adapters\Elementor\Schemes\The7_Elementor_Typography_Scheme;

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Schemes_Manager_Control
 */
class The7_Schemes_Manager_Control {

	const  SETTING_USE_THE7_SCHEME = 'use_the7_schemes';

	public function bootstrap() {
		if ( self::is_the7_scheme_enabled() ) {
			add_action( 'elementor/init', [ $this, 'replace_elementor_schemes' ] );
			add_action( 'optionsframework_options_saved', [ $this, 'update_schemes_css' ] );
			add_filter( 'sanitize_option_' . 'elementor_disable_color_schemes', [ $this, 'prevent_to_enable_option' ] );
			add_filter( 'sanitize_option_' . 'elementor_disable_typography_schemes', [ $this, 'prevent_to_enable_option' ] );
		}
		if ( is_admin() ) {
			add_action( 'current_screen', [ $this, 'is_settings_screen' ] );
			add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, [ $this, 'add_settings' ], 100 );
		}
	}

	/**
	 * Checks whether the site admin has opted-in to use the7 scheme.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 */
	public static function is_the7_scheme_enabled() {
		return 'yes' === get_option( 'elementor_' . self::SETTING_USE_THE7_SCHEME, 'no' );
	}

	public function replace_elementor_schemes() {
		self::load_the7_schemes();

		$schemes_manger = Elementor::instance()->schemes_manager;

		if ( self::is_scheme_enabled( $schemes_manger, Elementor_Schemes\Color::get_type() ) ) {
			$schemes_manger->unregister_scheme( Elementor_Schemes\Color::get_type() );
			$schemes_manger->register_scheme( The7_Elementor_Color_Scheme::class );
		}

		if ( self::is_scheme_enabled( $schemes_manger, Elementor_Schemes\Typography::get_type() ) ) {
			$schemes_manger->unregister_scheme( Elementor_Schemes\Typography::get_type() );
			$schemes_manger->register_scheme( The7_Elementor_Typography_Scheme::class );
		}
	}

	public static function update_schemes_css() {
		self::load_the7_schemes();

		$schemes_manger = Elementor::instance()->schemes_manager;

		$regenerate_css = false;
		$scheme_types   = [ The7_Elementor_Color_Scheme::get_type(), The7_Elementor_Typography_Scheme::get_type() ];
		foreach ( $scheme_types as $scheme_type ) {
			if ( self::is_scheme_enabled( $schemes_manger, $scheme_type ) ) {
				$scheme = $schemes_manger->get_scheme( $scheme_type );
				$scheme->save_scheme( $scheme->get_default_scheme() );
				$regenerate_css = true;
			}
		}

		if ( $regenerate_css ) {
			$scheme_css_file = Global_CSS::create( 'global.css' );
			$scheme_css_file->update();
		}
	}

	public static function load_the7_schemes() {
		require_once __DIR__ . '/schemes/class-the7-elementor-color-scheme.php';
		require_once __DIR__ . '/schemes/class-the7-elementor-typography-scheme.php';
	}

	/**
	 * Prevent to enable option.
	 *
	 * @return 'no'
	 */
	public function prevent_to_enable_option( $new_value ) {
		return 'no';
	}

	/**
	 * Will enable elementor color schemes and typography if they were disabled.
	 */
	public static function enable_elementor_schemas_options() {
		update_option( 'elementor_disable_color_schemes', 'no' );
		update_option( 'elementor_disable_typography_schemes', 'no' );
	}

	public function add_settings( Settings $settings ) {
		$settings->add_fields(
			Settings::TAB_GENERAL,
			'general',
			[
				self::SETTING_USE_THE7_SCHEME => [
					'label'        => __( 'Use The7 presets', 'the7mk2' ),
					'field_args'   => [
						'type'     => 'checkbox',
						'value'    => 'yes',
						'sub_desc' => __(
							'Checking this box will replace Elementor\'s Default Colors and Default Fonts and force Elementor to use presets from The7 theme options.',
							'the7mk2'
						),
					],
					'setting_args' => [
						'The7\Adapters\Elementor\The7_Schemes_Manager_Control',
						'check_for_settings_option',
					],
				],
			]
		);
	}

	/**
	 * Return bool if scheme with  $scheme_type enabled in $scheme_manager
	 *
	 * @param Schemes_Manager $scheme_manager
	 * @param string          $scheme_type
	 *
	 * @return bool
	 */
	public static function is_scheme_enabled( Schemes_Manager $scheme_manager, $scheme_type ) {
		foreach ( $scheme_manager->get_registered_schemes() as $scheme ) {
			if ( $scheme::get_type() === $scheme_type ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check for settings opt-in.
	 * Checks whether the site admin has opted-in for the7 schemas, or not.
	 *
	 * @param string $new_value allowed the7 schemes value
	 *
	 * @return string Return `yes` the7 schemas allowed, `no` otherwise.
	 */
	public static function check_for_settings_option( $new_value ) {
		$old_value = get_option( 'elementor_' . self::SETTING_USE_THE7_SCHEME, 'yes' );

		if ( $old_value !== $new_value && 'yes' === $new_value ) {
			self::enable_elementor_schemas_options();
			self::update_schemes_css();
		}

		if ( empty( $new_value ) ) {
			$new_value = 'no';
		}

		return $new_value;
	}

	/**
	 * @param $current_screen
	 */
	public function is_settings_screen( $current_screen ) {
		if ( 'toplevel_page_elementor' === $current_screen->base ) {
			add_action( 'admin_print_footer_scripts', [ $this, 'admin_enqueue_script' ] );
		}
	}

	public function admin_enqueue_script() {
		?>
		<script type="text/javascript">
            jQuery(document).ready(function ($) {

                var $the7_checkbox = $("#tab-general #elementor_use_the7_schemes");
                var $elementor_color_schemes_checkbox = $("#tab-general #elementor_disable_color_schemes")
                var $elementor_typography_schemes_checkbox = $("#tab-general #elementor_disable_typography_schemes")
                $the7_checkbox.change(function () {
                    valiate_schemas_checkboxes();
                });

                valiate_schemas_checkboxes();

                function valiate_schemas_checkboxes() {
                    var isChecked = $the7_checkbox.is(":checked");

                    $elementor_color_schemes_checkbox.prop("disabled", isChecked);
                    $elementor_typography_schemes_checkbox.prop("disabled", isChecked);

                    if (isChecked) {
                        $elementor_color_schemes_checkbox.prop('checked', false);
                        $elementor_typography_schemes_checkbox.prop("checked", false);
                    }
                }
            });
		</script>
		<?php
	}
}