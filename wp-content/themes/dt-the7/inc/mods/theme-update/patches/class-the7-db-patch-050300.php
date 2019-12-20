<?php
/**
 * The7 5.3.0 patch.
 *
 * @package the7
 * @since 5.3.0
 */

if ( ! class_exists( 'The7_DB_Patch_050300', false ) ) {

	class The7_DB_Patch_050300 extends The7_DB_Patch {

		protected function do_apply() {
			if ( $this->option_exists( 'general-title_size' ) ) {
				$title_size = $this->get_option( 'general-title_size' );

				// h1-h6
				if ( in_array( $title_size, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) ) {
					$font_family = $this->get_option( "fonts-{$title_size}_font_family" );
					if ( $font_family ) {
						$this->set_option( 'general-font_family', $font_family );
					}

					$font_size = $this->get_option( "fonts-{$title_size}_font_size" );
					if ( $font_size ) {
						$this->set_option( 'general-title_size', $font_size );
					}

					$line_height = $this->get_option( "fonts-{$title_size}_line_height" );
					if ( $line_height ) {
						$this->set_option( 'general-title_line_height', $line_height );
					}

					$capitalize = $this->get_option( "fonts-{$title_size}_uppercase" );
					$this->set_option( 'general-title_uppercase', $capitalize );

					// small, medium, large
				} elseif ( in_array( $title_size, array( 'big', 'normal', 'small' ) ) ) {
					$font_family = $this->get_option( 'fonts-h1_font_family' );
					if ( $font_family ) {
						$this->set_option( 'general-font_family', $font_family );
					}

					$font_size = $this->get_option( "fonts-{$title_size}_size" );
					if ( $font_size ) {
						$this->set_option( 'general-title_size', $font_size );
					}

					$line_height = $this->get_option( "fonts-{$title_size}_size_line_height" );
					if ( $line_height ) {
						$this->set_option( 'general-title_line_height', $line_height );
					}

					$this->set_option( 'general-title_uppercase', 0 );
				}
			}

			// Breadcrumbs.
			if ( ! $this->option_exists( 'general-breadcrumbs_font_family' ) ) {
				$this->set_option( 'general-breadcrumbs_font_family', $this->get_option( 'fonts-font_family' ) );
				$this->set_option( 'general-breadcrumbs_font_size', $this->get_option( 'fonts-small_size' ) );
				$this->set_option( 'general-breadcrumbs_line_height', $this->get_option( 'fonts-small_size_line_height' ) );
				$this->set_option( 'breadcrumbs_border_radius', $this->get_option( 'general-border_radius' ) );
				$breadcrumbs_bg = $this->get_option( 'general-breadcrumbs_bg_color' );
				if ( 'black' === $breadcrumbs_bg ) {
					$this->set_option( 'general-breadcrumbs_bg_color', 'enabled' );
					$this->set_option( 'breadcrumbs_bg_color', '#0F1213' );
					$this->set_option( 'breadcrumbs_bg_opacity', 10 );
				} elseif ( 'white' === $breadcrumbs_bg ) {
					$this->set_option( 'general-breadcrumbs_bg_color', 'enabled' );
					$this->set_option( 'breadcrumbs_bg_color', '#FFFFFF' );
					$this->set_option( 'breadcrumbs_bg_opacity', 12 );
				}
			}

			// Title padding.
			foreach ( array( 'page_title-padding-top', 'page_title-padding-bottom' ) as $title_padding_option_name ) {
				$title_padding = $this->get_option( $title_padding_option_name );
				$title_padding = apply_filters( 'of_sanitize_css_width', $title_padding );
				$this->set_option( $title_padding_option_name, $title_padding );
			}

			// Tile style.
			if ( 'fullwidth_line' === $this->get_option( 'general-title_bg_mode' ) ) {
				$this->set_option( 'general-title_bg_mode', 'content_line' );
			}

			if ( ! $this->option_exists( 'general-title_decoration_line_color' ) ) {
				$this->set_option( 'general-title_decoration_line_color', $this->get_option( 'dividers-color' ) );
				$this->set_option( 'general-title_decoration_line_opacity', $this->get_option( 'dividers-opacity' ) );
			}

			if ( ! $this->option_exists( 'general-title_scroll_effect' ) ) {
				$title_parallax_speed = $this->get_option( 'general-title_bg_parallax' );
				if ( $title_parallax_speed && ! in_array( $title_parallax_speed, array( '', '0' ) ) ) {
					$title_scroll_effect = 'parallax';
				} elseif ( $this->get_option( 'general-title_bg_fixed' ) ) {
					$title_scroll_effect = 'fixed';
				} else {
					$title_scroll_effect = 'default';
				}
				$this->set_option( 'general-title_scroll_effect', $title_scroll_effect );
			}

			$title_bg_image = $this->get_option( 'general-title_bg_image' );
			if ( is_array( $title_bg_image ) && ! empty( $title_bg_image['image'] )  ) {
				$this->set_option( 'general-title_enable_bg_img', 'enabled' );
			} else {
				$this->set_option( 'general-title_enable_bg_img', 'disabled' );
			}

			// Fallback to default skin.
			$skin = $this->get_option( 'preset' );
			$skins_list = optionsframework_get_presets_list();
			if ( ! in_array( $skin, $skins_list ) ) {
				$default_skin = apply_filters( 'options_framework_first_run_skin', '' );
				$this->set_option( 'preset', $default_skin );
			}

			// Flush theme options cache.
			delete_transient( 'dt_opts_assets_inc_presets_images' );
			delete_transient( 'dt_opts_assets_images_backgrounds_patterns' );
		}

	}

}
