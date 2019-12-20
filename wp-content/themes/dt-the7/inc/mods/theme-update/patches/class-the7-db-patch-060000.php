<?php
/**
 * The7 6.0.0 patch.
 *
 * @package the7
 * @since 6.0.0
 */

if ( ! class_exists( 'The7_DB_Patch_060000', false ) ) {

	class The7_DB_Patch_060000 extends The7_DB_Patch {

		protected function do_apply() {
			$color_opacity_map = array(
				'header-bg-color' => 'header-bg-opacity',
				'general-content_boxes_bg_color' => 'general-content_boxes_bg_opacity',
				'general-bg_color' => 'general-bg_opacity',
				'dividers-color' => 'dividers-opacity',
				'general-spinner_color' => 'general-spinner_opacity',
				'top_bar-bg-color' => 'top_bar-bg-opacity',
				'header-elements-soc_icons-bg-color' => 'header-elements-soc_icons-bg-opacity',
				'header-elements-soc_icons-border-color' => 'header-elements-soc_icons-border-opacity',
				'header-elements-soc_icons-hover-bg-color' => 'header-elements-soc_icons-bg-hover-opacity',
				'header-elements-soc_icons-hover-border-color' => 'header-elements-soc_icons-hover-border-opacity',
				'header-decoration-color' => 'header-decoration-opacity',
				'header-mixed-decoration-color' => 'header-mixed-decoration-opacity',
				'header-mixed-bg-color' => 'header-mixed-bg-opacity',
				'header-menu_icon-bg-color' => 'header-menu_icon-bg-opacity',
				'header-menu_icon-hover-bg-color' => 'header-menu_icon-hover-bg-opacity',
				'header-classic-menu-bg-color' => 'header-classic-menu-bg-opacity',
				'header-slide_out-overlay-x_cursor-color' => 'header-slide_out-overlay-x_cursor-opacity',
				'header-floating_navigation-bg-color' => 'header-floating_navigation-bg-opacity',
				'header-floating_navigation-decoration-color' => 'header-floating_navigation-decoration-opacity',
				'header-menu-dividers-color' => 'header-menu-dividers-opacity',
				'header-menu-submenu-bg-color' => 'header-menu-submenu-bg-opacity',
				'bottom_bar-bg_color' => 'bottom_bar-bg_opacity',
				'sidebar-bg_color' => 'sidebar-bg_opacity',
				'sidebar-decoration_outline_color' => 'sidebar-decoration_outline_opacity',
				'footer-bg_color' => 'footer-bg_opacity',
				'footer-decoration_outline_color' => 'footer-decoration_outline_opacity',
				'header-transparent_bg_color' => 'header-transparent_bg_opacity',
				'general-content_boxes_decoration_outline_color' => 'general-content_boxes_decoration_outline_opacity',
				'header-mobile-menu-bg-color' => 'header-mobile-menu-bg-opacity',
				'header-mobile-overlay-bg-color' => 'header-mobile-overlay-bg-opacity',
				'breadcrumbs_bg_color' => 'breadcrumbs_bg_opacity',
				'breadcrumbs_border_color' => 'breadcrumbs_border_opacity',
				'general-title_overlay_color' => 'general-title_bg_overlay_opacity',
				'general-title_decoration_outline_color' => 'general-title_decoration_outline_opacity',
				'general-title_decoration_line_color' => 'general-title_decoration_line_opacity',
				'general-title_bg_color' => 'general-title_bg_opacity',
				'input_border_color' => 'input_border_opacity',
				'input_bg_color' => 'input_bg_opacity',
				'message_bg_color' => 'message_bg_opacity',
			);

			foreach ( $color_opacity_map as $color => $opacity ) {
				$_color = $this->get_option( $color );
				if ( $this->option_exists( $opacity ) && strpos( $_color, 'rgba' ) === false ) {
					$_opacity = $this->get_option( $opacity );
					$color_obj = new The7_Less_Vars_Value_Color( $_color );
					$color_obj->opacity( $_opacity );
					$rgba_color = $color_obj->get_rgba();
					if ( $rgba_color === '""' ) {
						$rgba_color = '';
					}
					$this->set_option( $color, $rgba_color );
					$this->remove_option( $opacity );
				}
			}

			$padding_map = array(
				'header-logo-padding',
				'header-style-transparent-logo-padding',
				'header-style-floating-logo-padding',
				'header-style-mobile-logo-padding',
				'bottom_bar-logo-padding',
				'header-style-mixed-logo-padding',
				'general-filter-padding',
				'general-filter-margin',
				'breadcrumbs_padding',
				'breadcrumbs_margin',
				'buttons-s_padding',
				'buttons-m_padding',
				'buttons-l_padding',
				'header-classic-elements-near_menu_right-padding',
				'header-classic-elements-near_logo_left-padding',
				'header-classic-elements-near_logo_right-padding',
				'header-inline-elements-near_menu_right-padding',
				'header-split-elements-near_menu_left-padding',
				'header-split-elements-near_menu_right-padding',
				'header-side-elements-below_menu-padding',
				'header-slide_out-elements-top_line-padding',
				'header-slide_out-elements-below_menu-padding',
				'header-overlay-elements-top_line-padding',
				'header-overlay-elements-below_menu-padding',
				'header-side-content-padding',
				'header-slide_out-content-padding',
				'header-overlay-content-padding',
				'header-menu-item-padding',
				'header-menu-item-margin',
				'header-menu-submenu-item-padding',
				'header-menu-submenu-item-margin',
				'header-menu_icon-margin',
			);

			foreach ( $padding_map as $padding ) {
				if ( $this->option_exists( $padding ) ) {
					continue;
				}

				$padding_value = array(
					$this->get_option( "$padding-top" ),
					$this->get_option( "$padding-right" ),
					$this->get_option( "$padding-bottom" ),
					$this->get_option( "$padding-left" ),
				);

				if ( join( '', $padding_value ) === '' ) {
					continue;
				}

				$padding_value = The7_Option_Field_Spacing::sanitize( join( ' ', $padding_value ), array( 'px' ), 4 );
				$padding_value = The7_Option_Field_Spacing::encode( $padding_value );

				$this->set_option( $padding, $padding_value );

				$this->remove_option( "$padding-top" );
				$this->remove_option( "$padding-right" );
				$this->remove_option( "$padding-bottom" );
				$this->remove_option( "$padding-left" );
			}

			// Vertical padding.
			$custom_padding_map = array(
				'header-classic-menu-margin' => array(
					'header-classic-menu-margin-top',
					'header-classic-menu-margin-bottom',
				),
				'header-side-menu-padding' => array(
					'header-side-menu-padding-top',
					'header-side-menu-padding-bottom',
				),
				'header-slide_out-menu-padding' => array(
					'header-slide_out-menu-padding-top',
					'header-slide_out-menu-padding-bottom',
				),
				'header-overlay-menu-padding' => array(
					'header-overlay-menu-padding-top',
					'header-overlay-menu-padding-bottom',
				),
				'general-page_content_margin' => array(
					'general-page_content_top_margin',
					'general-page_content_bottom_margin',
				),
				'top_bar-padding' => array(
					'top_bar-paddings-top',
					'top_bar-paddings-bottom',
					'top_bar-paddings-horizontal',
				),
				'footer-padding' => array(
					'footer-padding-top',
					'footer-padding-bottom'
				),
				'page_title-padding' => array(
					'page_title-padding-top',
					'page_title-padding-bottom',
				),
				'woocommerce_cart_padding' => array(
					'woocommerce_cart_top_padding',
					'woocommerce_cart_bottom_padding',
				),
			);

			foreach ( $custom_padding_map as $new_option => $old_options ) {
				if ( $this->option_exists( $new_option ) ) {
					continue;
				}

				$padding_value = array_map( array( $this, 'get_option' ), $old_options );

				if ( join( '', $padding_value ) === '' ) {
					continue;
				}

				$padding_value = The7_Option_Field_Spacing::sanitize( join( ' ', $padding_value ), array( 'px', '%' ), count( $old_options ) );
				$padding_value = The7_Option_Field_Spacing::encode( $padding_value );
				$this->set_option( $new_option, $padding_value );

				foreach ( $old_options as $option_to_remove ) {
					$this->remove_option( $option_to_remove );
				}
			}

			// New options.
			$new_options = array(
				'header-mobile-header-bg-color' => 'header-bg-color',
				'header-mobile-microwidgets-font-family' => 'header-elements-near_menu-font_family',
				'header-mobile-microwidgets-font-size' => 'header-elements-near_menu-font_size',
				'header-mobile-microwidgets-font-color' => 'header-menu-font-color',
				'header-mobile-menu_icon-color' => 'header-menu-font-color',
			);
			foreach ( $new_options as $new_option_name => $option_to_sync ) {
				if ( ! $this->option_exists( $new_option_name ) ) {
					$this->set_option( $new_option_name, $this->get_option( $option_to_sync ) );
				}
			}

			if ( ! $this->option_exists( 'header-mobile-menu_icon-bg-color' ) ) {
				$color_obj = new The7_Less_Vars_Value_Color( $this->get_option( 'header-bg-color' ) );
				$color_obj->opacity( 0 );
				$this->set_option( 'header-mobile-menu_icon-bg-color', $color_obj->get_rgba() );
			}

			if ( ! $this->option_exists( 'header-mobile-menu_icon-size' ) ) {
				$this->set_option( 'header-mobile-menu_icon-size', 'small' );
			}

			if ( ! $this->option_exists( 'header-mobile-menu_icon-bg-size' ) ) {
				$this->set_option( 'header-mobile-menu_icon-bg-size', 24 );
			}
		}
	}

}
