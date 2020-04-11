<?php
/**
 * @since   8.3.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

class The7_Post_CSS_Generator {

	const META_KEY = 'the7_fancy_title_css';

	/**
	 * @param int|string                       $post_id   Post ID.
	 * @param The7_Less_Vars_Manager_Interface $less_vars Less vars manager object.
	 */
	public static function fancy_titles_les_vars( $post_id, The7_Less_Vars_Manager_Interface $less_vars ) {
		$less_vars->add_pixel_number(
			'fancy-header-height',
			get_post_meta( $post_id, '_dt_fancy_header_height', true )
		);
		$less_vars->add_pixel_number(
			'fancy-header-font-size',
			get_post_meta( $post_id, '_dt_fancy_header_title_font_size', true )
		);
		$less_vars->add_pixel_number(
			'fancy-header-line-height',
			get_post_meta( $post_id, '_dt_fancy_header_title_line_height', true )
		);
		$less_vars->add_hex_color(
			'fancy-header-title-color',
			get_post_meta( $post_id, '_dt_fancy_header_title_color', true )
		);
		$less_vars->add_keyword(
			'fancy-header-text-transform',
			get_post_meta( $post_id, '_dt_fancy_header_text_transform', true )
		);
		$less_vars->add_keyword(
			'fancy-header-subtitle-text-transform',
			get_post_meta( $post_id, '_dt_fancy_header_subtitle_text_transform', true )
		);
		$less_vars->add_pixel_number(
			'fancy-header-subtitle-font-size',
			get_post_meta( $post_id, '_dt_fancy_header_subtitle_font_size', true )
		);
		$less_vars->add_pixel_number(
			'fancy-header-subtitle-line-height',
			get_post_meta( $post_id, '_dt_fancy_header_subtitle_line_height', true )
		);
		$less_vars->add_hex_color(
			'fancy-header-subtitle-color',
			get_post_meta( $post_id, '_dt_fancy_header_subtitle_color', true )
		);
		$less_vars->add_hex_color(
			'fancy-header-breadcrumbs-color',
			get_post_meta( $post_id, '_dt_fancy_header_breadcrumbs_text_color', true )
		);
		$less_vars->add_pixel_number(
			'fancy-header-responsiveness-switch',
			get_post_meta( $post_id, '_dt_fancy_header_responsiveness_switch', true )
		);
		$less_vars->add_pixel_number(
			'fancy-header-responsivene-height',
			get_post_meta( $post_id, '_dt_fancy_header_responsive_height', true )
		);
		$less_vars->add_pixel_number(
			'fancy-header-responsivene-font-size',
			get_post_meta( $post_id, '_dt_fancy_header_responsive_font_size', true )
		);
		$less_vars->add_pixel_number(
			'fancy-responsivene-title-line-height',
			get_post_meta( $post_id, '_dt_fancy_header_responsive_title_line_height', true )
		);
		$less_vars->add_pixel_number(
			'fancy-subtitle-responsivene-font-size',
			get_post_meta( $post_id, '_dt_fancy_header_responsive_subtitle_font_size', true )
		);
		$less_vars->add_pixel_number(
			'fancy-subtitle-responsivene-line-height',
			get_post_meta(
				$post_id,
				'_dt_fancy_header_responsive_subtitle_line_height',
				true
			)
		);
		$less_vars->add_rgba_color(
			'fancy-header-overlay-color',
			get_post_meta( $post_id, '_dt_fancy_header_overlay_color', true ),
			get_post_meta( $post_id, '_dt_fancy_header_bg_overlay_opacity', true )
		);
		$less_vars->add_pixel_or_percent_number(
			'fancy-header-padding-top',
			get_post_meta( $post_id, '_dt_fancy_header_padding-top', true )
		);
		$less_vars->add_pixel_or_percent_number(
			'fancy-header-padding-bottom',
			get_post_meta( $post_id, '_dt_fancy_header_padding-bottom', true )
		);

		$bg_image_repeat = get_post_meta( $post_id, '_dt_fancy_header_bg_repeat', true );
		$bg_image_size   = 'auto auto';
		if ( get_post_meta( $post_id, '_dt_fancy_header_bg_fullscreen', true ) ) {
			$bg_image_repeat = 'no-repeat';
			$bg_image_size   = 'cover';
		}

		$less_vars->add_keyword( 'fancy-header-bg-size', $bg_image_size );

		if ( get_post_meta( $post_id, '_dt_fancy_header_bg_image_origin', true ) === 'featured_image' ) {
			$bg_image_id = get_post_thumbnail_id( $post_id );
		} else {
			$bg_image_id = current( (array) get_post_meta( $post_id, '_dt_fancy_header_bg_image', true ) );
		}

		$bg_image_url = '';
		if ( $bg_image_id ) {
			$bg_image_parts = wp_get_attachment_image_src( $bg_image_id, 'full' );
			if ( ! empty( $bg_image_parts[0] ) ) {
				$bg_image_url = $bg_image_parts[0];
			}
		}

		$less_vars->add_image(
			array(
				'fancy-header-bg-image',
				'fancy-header-bg-repeat',
				'fancy-header-bg-position-x',
				'fancy-header-bg-position-y',
			),
			array(
				'image'      => $bg_image_url,
				'repeat'     => $bg_image_repeat,
				'position_x' => get_post_meta( $post_id, '_dt_fancy_header_bg_position_x', true ),
				'position_y' => get_post_meta( $post_id, '_dt_fancy_header_bg_position_y', true ),
			)
		);

		$bg_attachment = 'scroll';
		if ( 'fixed' === get_post_meta( $post_id, '_dt_fancy_header_scroll_effect', true ) ) {
			$bg_attachment = 'fixed';
		}

		$less_vars->add_keyword( 'fancy-header-bg-attachment', $bg_attachment );
		$less_vars->add_rgb_color(
			'fancy-header-bg-color',
			get_post_meta( $post_id, '_dt_fancy_header_bg_color', true )
		);
	}

	/**
	 * @param                                  $post_id
	 * @param The7_Less_Vars_Manager_Interface $less_vars
	 */
	public static function post_content_padding_less_vars( $post_id, The7_Less_Vars_Manager_Interface $less_vars ) {
		$post_padding = array(
			'page-padding-top'           => get_post_meta( $post_id, '_dt_page_overrides_top_margin', true ),
			'page-padding-right'         => get_post_meta( $post_id, '_dt_page_overrides_right_margin', true ),
			'page-padding-bottom'        => get_post_meta( $post_id, '_dt_page_overrides_bottom_margin', true ),
			'page-padding-left'          => get_post_meta( $post_id, '_dt_page_overrides_left_margin', true ),
			'mobile-page-padding-top'    => get_post_meta( $post_id, '_dt_mobile_page_padding_top', true ),
			'mobile-page-padding-right'  => get_post_meta( $post_id, '_dt_mobile_page_padding_right', true ),
			'mobile-page-padding-bottom' => get_post_meta( $post_id, '_dt_mobile_page_padding_bottom', true ),
			'mobile-page-padding-left'   => get_post_meta( $post_id, '_dt_mobile_page_padding_left', true ),
		);

		foreach ( $post_padding as $var => $value ) {
			if ( $value !== '' ) {
				$less_vars->add_pixel_or_percent_number( $var, $value );
			}
		}

		$less_vars->add_pixel_number( 'switch-content-paddings', of_get_option( 'general-switch_content_paddings' ) );
	}

	/**
	 * @param                                  $post_id
	 * @param The7_Less_Vars_Manager_Interface $less_vars
	 * @param The7_Less_Compiler               $less_compiler
	 *
	 * @return false|string
	 */
	public static function generate_css_for_post( $post_id, The7_Less_Vars_Manager_Interface $less_vars, The7_Less_Compiler $less_compiler ) {
		try {
			$imports = array();

			$title_type = get_post_meta( $post_id, '_dt_header_title', true );
			if ( $title_type === 'fancy' ) {
				self::fancy_titles_les_vars( $post_id, $less_vars );
				$imports['DYNAMIC_IMPORT_BOTTOM'] = 'fancy-titles.less';
			}
			self::post_content_padding_less_vars( $post_id, $less_vars );

			$less_variables = $less_vars->get_vars();

			if ( ! $less_variables ) {
				return '';
			}

			foreach ( $less_variables as $key => $val ) {
				if ( $val === '~""' || $val === '' ) {
					unset( $less_variables[ $key ] );
				}
			}

			$less_compiler->set_variables( $less_variables );
			$less_compiler->set_import_dir( array( PRESSCORE_THEME_DIR . '/css/dynamic-less/' ) );

			return $less_compiler->compile_file(
				PRESSCORE_THEME_DIR . '/css/dynamic-less/single-post-inline-css.less',
				$imports
			);
		} catch ( Exception $e ) {
			error_log( $e->getMessage() );

			return '';
		}
	}

	/**
	 * @param int|string $post_id Post ID.
	 * @param string     $css     String with CSS code.
	 */
	public static function update_css_for_post( $post_id, $css ) {
		return update_metadata( 'post', $post_id, self::META_KEY, $css );
	}

	/**
	 * @param int|string $post_id Post ID.
	 *
	 * @return string
	 */
	public static function get_css_for_post( $post_id ) {
		return (string) get_post_meta( $post_id, self::META_KEY, true );
	}

	/**
	 * @param int|string $post_id Post ID.
	 */
	public static function delete_css_for_post( $post_id ) {
		delete_metadata( 'post', $post_id, self::META_KEY );
	}
}
