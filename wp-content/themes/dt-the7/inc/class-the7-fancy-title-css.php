<?php
/**
 * Class The7_Fancy_Title_CSS
 *
 * @since   7.3.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Fancy_Title_CSS
 */
class The7_Fancy_Title_CSS {

	const META_KEY = 'the7_fancy_title_css';

	/**
	 * Bootstrap fancy title css generation.
	 */
	public static function bootstrap() {
		add_action( 'save_post', array( __CLASS__, 'generate_css_for_post' ), 99999 );
	}

	/**
	 * Remove hooks.
	 */
	public static function remove_hooks() {
		remove_action( 'save_post', array( __CLASS__, 'generate_css_for_post' ), 99999 );
	}

	/**
	 * Add less vars to `$less_vars` object, based on settings from `$post_id` post.
	 *
	 * @param int|string                     $post_id Post ID.
	 * @param The7_Less_Vars_Manager_Interface $less_vars Less vars manager object.
	 */
	public static function add_less_vars_from_post( $post_id, The7_Less_Vars_Manager_Interface $less_vars ) {
		$less_vars->add_pixel_number( 'fancy-header-height', get_post_meta( $post_id, '_dt_fancy_header_height', true ) );
		$less_vars->add_pixel_number( 'fancy-header-font-size', get_post_meta( $post_id, '_dt_fancy_header_title_font_size', true ) );
		$less_vars->add_pixel_number( 'fancy-header-line-height', get_post_meta( $post_id, '_dt_fancy_header_title_line_height', true ) );
		$less_vars->add_hex_color( 'fancy-header-title-color', get_post_meta( $post_id, '_dt_fancy_header_title_color', true ) );
		$less_vars->add_keyword( 'fancy-header-text-transform', get_post_meta( $post_id, '_dt_fancy_header_text_transform', true ) );
		$less_vars->add_keyword( 'fancy-header-subtitle-text-transform', get_post_meta( $post_id, '_dt_fancy_header_subtitle_text_transform', true ) );
		$less_vars->add_pixel_number( 'fancy-header-subtitle-font-size', get_post_meta( $post_id, '_dt_fancy_header_subtitle_font_size', true ) );
		$less_vars->add_pixel_number( 'fancy-header-subtitle-line-height', get_post_meta( $post_id, '_dt_fancy_header_subtitle_line_height', true ) );
		$less_vars->add_hex_color( 'fancy-header-subtitle-color', get_post_meta( $post_id, '_dt_fancy_header_subtitle_color', true ) );
		$less_vars->add_hex_color( 'fancy-header-breadcrumbs-color', get_post_meta( $post_id, '_dt_fancy_header_breadcrumbs_text_color', true ) );
		$less_vars->add_pixel_number( 'fancy-header-responsiveness-switch', get_post_meta( $post_id, '_dt_fancy_header_responsiveness_switch', true ) );
		$less_vars->add_pixel_number( 'fancy-header-responsivene-height', get_post_meta( $post_id, '_dt_fancy_header_responsive_height', true ) );
		$less_vars->add_pixel_number( 'fancy-header-responsivene-font-size', get_post_meta( $post_id, '_dt_fancy_header_responsive_font_size', true ) );
		$less_vars->add_pixel_number( 'fancy-responsivene-title-line-height', get_post_meta( $post_id, '_dt_fancy_header_responsive_title_line_height', true ) );
		$less_vars->add_pixel_number( 'fancy-subtitle-responsivene-font-size', get_post_meta( $post_id, '_dt_fancy_header_responsive_subtitle_font_size', true ) );
		$less_vars->add_pixel_number( 'fancy-subtitle-responsivene-line-height', get_post_meta( $post_id, '_dt_fancy_header_responsive_subtitle_line_height', true ) );
		$less_vars->add_rgba_color( 'fancy-header-overlay-color', get_post_meta( $post_id, '_dt_fancy_header_overlay_color', true ), get_post_meta( $post_id, '_dt_fancy_header_bg_overlay_opacity', true ) );
		$less_vars->add_pixel_or_percent_number( 'fancy-header-padding-top', get_post_meta( $post_id, '_dt_fancy_header_padding-top', true ) );
		$less_vars->add_pixel_or_percent_number( 'fancy-header-padding-bottom', get_post_meta( $post_id, '_dt_fancy_header_padding-bottom', true ) );

		$bg_image_repeat = get_post_meta( $post_id, '_dt_fancy_header_bg_repeat', true );
		$bg_image_size   = 'auto auto';
		if ( get_post_meta( $post_id, '_dt_fancy_header_bg_fullscreen', true ) ) {
			$bg_image_repeat = 'no-repeat';
			$bg_image_size   = 'cover';
		}

		$less_vars->add_keyword( 'fancy-header-bg-size', $bg_image_size );

		$bg_image_url = '';
		$bg_image_id  = current( (array) get_post_meta( $post_id, '_dt_fancy_header_bg_image', true ) );
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
		$less_vars->add_rgb_color( 'fancy-header-bg-color', get_post_meta( $post_id, '_dt_fancy_header_bg_color', true ) );
	}

	/**
	 * Generate css for fancy title in `$post_id` post.
	 *
	 * If `_dt_header_title` post meta is not `fancy`, than css will be deleted.
	 * Ready css is saved in `self::META_KEY` post meta.
	 *
	 * @param int|string $post_id Post ID.
	 */
	public static function generate_css_for_post( $post_id ) {
		// Prevent style generation for reviews.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$title_type = get_post_meta( $post_id, '_dt_header_title', true );
		if ( $title_type !== 'fancy' ) {
			self::delete_css_for_post( $post_id );

			return;
		}

		// Generate css here.
		try {
			$lessc = new the7_lessc();
			The7_Less_Functions::register_functions( $lessc );
			$less_vars = the7_get_new_less_vars_manager();
			self::add_less_vars_from_post( $post_id, $less_vars );
			$lessc->setVariables( $less_vars->get_vars() );
			$lessc->setImportDir( array( PRESSCORE_THEME_DIR . '/css/dynamic-less/' ) );
			$css = $lessc->compileFile( PRESSCORE_THEME_DIR . '/css/dynamic-less/fancy-titles.less' );
			self::update_css_for_post( $post_id, $css );
		} catch ( Exception $e ) {
			error_log( $e->getMessage() );
		}
	}

	/**
	 * Update post meta with fancy title css.
	 *
	 * @param int|string $post_id Post ID.
	 * @param string     $css String with CSS code.
	 */
	public static function update_css_for_post( $post_id, $css ) {
		update_post_meta( $post_id, self::META_KEY, $css );
	}

	/**
	 * Return fancy title css for post.
	 *
	 * @param int|string $post_id Post ID.
	 *
	 * @return string
	 */
	public static function get_css_for_post( $post_id ) {
		return (string) get_post_meta( $post_id, self::META_KEY, true );
	}

	/**
	 * Delete post meta with fancy title css.
	 *
	 * @param int|string $post_id Post ID.
	 */
	public static function delete_css_for_post( $post_id ) {
		delete_post_meta( $post_id, self::META_KEY );
	}
}
