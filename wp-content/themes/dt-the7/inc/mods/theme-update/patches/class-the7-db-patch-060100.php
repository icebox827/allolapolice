<?php
/**
 * The7 6.1.0 patch.
 * @package the7
 * @since   6.1.0
 */

if ( ! class_exists( 'The7_DB_Patch_060100', false ) ) {

	class The7_DB_Patch_060100 extends The7_DB_Patch {

		protected function do_apply() {
			// Migrate header.
			$header = $this->get_option( 'header-layout' );
			$header_layout = 'menu_icon';
			if ( $this->option_exists( "header-{$header}-layout" ) ) {
				$header_layout = $this->get_option( "header-{$header}-layout" );
			}

			if ( in_array( $header, array( 'slide_out', 'overlay' ), true ) && in_array( $header_layout, array(
					'menu_icon',
					'top_line',
					'side_line',
				), true ) ) {
				$this->set_option( 'header-layout', $header_layout );
				$this->set_option( 'header_navigation', $header );
				$this->remove_option( "header-{$header}-layout" );

				$this->_migrate_mixed_header_micro_widgets_settings();
				$this->_migrate_mixed_headers_settings();
			}

			$this->_migrate_top_bar();
			$this->_migrate_micro_widgets_fonts();
			$this->_migrate_micro_widgets_responsiveness();
			$this->_migrate_menu_padding();
			$this->_migrate_menu_icon_close_margin();
			$this->_migrate_transparent_mobile_logo();
		}

		private function _migrate_mixed_headers_settings() {
			$header = $this->get_option( 'header_navigation' );

			$top_line_settings = array(
				"header-{$header}-layout-top_line-height"              => 'layout-top_line-height',
				"header-{$header}-layout-top_line-is_fullwidth"        => 'layout-top_line-is_fullwidth',
				"header-{$header}-layout-top_line-logo-position"       => 'layout-top_line-logo-position',
				"header-{$header}-layout-side_line-width"              => 'layout-side_line-width',
				"header-{$header}-layout-side_line-position"           => 'layout-side_line-position',
				"header-{$header}-layout-menu_icon-show_floating_logo" => 'layout-menu_icon-show_floating_logo',
			);
			foreach ( $top_line_settings as $old => $new ) {
				$this->rename_option( $old, $new );
			}
		}

		private function _migrate_top_bar() {
			if ( $this->option_exists( 'top-bar-height' ) ) {
				// Bail if option exists to prevent data loss with repeated patch use.
				return;
			}

			$color_obj = new The7_Less_Vars_Value_Color( $this->get_option( 'header-bg-color' ) );
			$header_bg_color = $color_obj->opacity( 0 )->get_rgba();
			if ( $header_bg_color === '""' ) {
				$header_bg_color = '';
			}
			$empty_image = array(
				'image'      => '',
				'repeat'     => 'repeat',
				'position_x' => 'center',
				'position_y' => 'center',
			);

			switch ( $this->get_option( 'top_bar-bg-style' ) ) {
				case 'solid':
					$this->set_option( 'top_bar-bg-style', 'disabled' );
					$this->set_option( 'top-bar-height', 0 );
					break;
				case 'fullwidth_line':
				case 'content_line':
					$this->set_option( 'top_bar-bg-image', $empty_image );
					if ( ! $this->option_exists( 'top_bar-line-color' ) ) {
						$this->set_option( 'top_bar-line-color', $this->get_option( 'top_bar-bg-color' ) );
					}
					$this->set_option( 'top_bar-bg-color', $header_bg_color );
					$this->set_option( 'top-bar-height', 0 );
					break;
				case 'disabled':
					$this->set_option( 'top_bar-bg-image', $empty_image );
					$this->set_option( 'top_bar-bg-color', $header_bg_color );
					$this->set_option( 'top-bar-height', 0 );
					break;
			}
		}

		/**
		 * @see The7_DB_Patch_060100::_migrate_mixed_header_micro_widgets_settings() mixed header fonts migration
		 */
		private function _migrate_micro_widgets_fonts() {
			$header = $this->get_option( 'header-layout' );

			// Common fonts.
			$font_settings = array(
				'elements-near_menu-font_size',
				'elements-near_menu-font_color',
				'elements-near_menu-font_family',
			);

			if ( $header === 'classic' ) {
				$font_settings[] = 'elements-near_logo-font_size';
				$font_settings[] = 'elements-near_logo-font_color';
				$font_settings[] = 'elements-near_logo-font_family';
			}

			foreach ( $font_settings as $option_base ) {
				$this->rename_option( "header-{$option_base}", "header-{$header}-{$option_base}" );
			}
		}

		private function _migrate_mixed_header_micro_widgets_settings() {
			// Base settings.
			$header_layout = $this->get_option( 'header-layout' );
			$header = $this->get_option( 'header_navigation' );
			$options_to_migrate = array(
				'show_elements',
				'icons_style',
				'elements',
				'elements-top_line-padding',
				'elements-below_menu-padding',
			);
			foreach ( $options_to_migrate as $option_root ) {
				$this->rename_option( "header-{$header}-{$option_root}", "header-{$header_layout}-{$option_root}" );
			}

			// Top Line fonts.
			$near_logo_options = array(
				'header-elements-near_logo-font_size'   => "header-{$header_layout}-elements-in_top_line-font_size",
				'header-elements-near_logo-font_color'  => "header-{$header_layout}-elements-in_top_line-font_color",
				'header-elements-near_logo-font_family' => "header-{$header_layout}-elements-in_top_line-font_family",
			);
			foreach ( $near_logo_options as $old_option => $new_option ) {
				$this->rename_option( $old_option, $new_option );
			}
		}

		private function _migrate_micro_widgets_responsiveness() {
			$micro_widgets_map = array(
				'cart' => 'woocommerce_cart',
				'text3_area' => 'text-3',
				'text2_area' => 'text-2',
				'text_area' => 'text',
				'custom_menu' => 'menu',
				'social_icons' => 'soc_icons',
				'skype' => 'contact-skype',
				'email' => 'contact-email',
				'address' => 'contact-address',
				'phone' => 'contact-phone',
				'working_hours' => 'contact-clock',
				'info' => 'contact-info',
			);
			$header = $this->get_option( 'header-layout' );
			$header_elements = $this->get_option( "header-{$header}-elements" );
			$show_elements = $this->get_option( "header-{$header}-show_elements" );
			if ( $show_elements && $header_elements && is_array( $header_elements ) ) {
				foreach ( $header_elements as $elements_position => $elements ) {
					if ( ! is_array( $elements ) ) {
						continue;
					}

					foreach ( $elements as $element ) {
						$element_id = $element;
						if ( array_key_exists( $element, $micro_widgets_map ) ) {
							$element_id = $micro_widgets_map[ $element ];
						}

						$first_switch_option_id = "header-elements-{$element_id}-first-header-switch";
						$first_switch = $this->get_option( $first_switch_option_id );
						if ( $first_switch !== 'near_logo' ) {
							continue;
						}

						switch ( $elements_position ) {
							case 'top_bar_left':
								$this->set_option( $first_switch_option_id, 'top_bar_left' );
								break;
							case 'top_bar_right':
								$this->set_option( $first_switch_option_id, 'top_bar_right' );
								break;
							case 'side_top_line':
							case 'top_line_right':
							case 'near_menu_left':
							case 'near_menu_right':
								$this->set_option( $first_switch_option_id, 'near_logo' );
								break;
							default:
								$this->set_option( $first_switch_option_id, 'in_menu' );
						}
					}
				}
			}
		}

		private function _migrate_menu_padding() {
			$header_layout = $this->get_option( 'header-layout' );
			if ( ! in_array( $header_layout, array( 'side', 'top_line', 'side_line', 'menu_icon' ) ) ) {
				return;
			}

			$header = $this->get_option( 'header_navigation' );
			if ( ! $header ) {
				$header = 'side';
			}

			$menu_padding = $this->get_option( "header-{$header}-menu-padding" );
			if ( ! $menu_padding ) {
				return;
			}
			$this->remove_option( "header-{$header}-menu-padding" );
			list( $top_menu_padding, $bottom_menu_padding ) = The7_Option_Field_Spacing::decode( $menu_padding );

			$micro_widgets_below_menu_padding = $this->get_option( "header-{$header_layout}-elements-below_menu-padding" );
			if ( $micro_widgets_below_menu_padding ) {
				$micro_widgets_below_menu_padding = The7_Option_Field_Spacing::decode( $micro_widgets_below_menu_padding );
				$micro_widgets_below_menu_padding[0]['val'] += $bottom_menu_padding['val'];
				$this->set_option( "header-{$header_layout}-elements-below_menu-padding", The7_Option_Field_Spacing::encode( $micro_widgets_below_menu_padding ) );
			}

			$logo_padding = $this->get_option( 'header-logo-padding' );
			if ( $logo_padding ) {
				$logo_padding = The7_Option_Field_Spacing::decode( $logo_padding );
				$logo_padding[2]['val'] += $top_menu_padding['val'];
				$this->set_option( 'header-logo-padding', The7_Option_Field_Spacing::encode( $logo_padding ) );
			}
		}

		private function _migrate_menu_icon_close_margin() {
			if ( ! $this->option_exists( 'header-menu_icon-margin' ) ) {
				return;
			}

			$header = $this->get_option( 'header_navigation' );
			$menu_icon_margin = '30px 30px 30px 30px';
			if ( $header === 'slide_out' ) {
				$menu_icon_margin = $this->get_option( 'header-menu_icon-margin' );
			}
			$this->set_option( 'header-menu_close_icon-margin', $menu_icon_margin );
		}

		private function _migrate_transparent_mobile_logo() {
			$mobile_logo_padding = $this->get_option( 'header-style-mobile-logo-padding' );
			if ( $mobile_logo_padding && ! $this->option_exists( 'header-style-transparent-mobile-logo-padding' ) ) {
				$this->set_option( 'header-style-transparent-mobile-logo-padding', $mobile_logo_padding );
			}

			if ( $this->get_option( 'header-style-transparent-choose_logo' ) === 'custom' ) {
				$this->set_option( 'header-transparent-mobile-first_switch-logo', 'desktop' );
				$this->set_option( 'header-transparent-mobile-second_switch-logo', 'desktop' );
			} else {
				// Copy mobile header settings to transparent mobile header.
				$transparent_mobile_logo_map = array(
					'header-transparent-mobile-first_switch-logo' => $this->get_option( 'header-mobile-first_switch-logo' ),
					'header-transparent-mobile-second_switch-logo' => $this->get_option( 'header-mobile-second_switch-logo' ),
					'header-style-transparent-mobile-logo_regular' => $this->get_option( 'header-style-mobile-logo_regular' ),
					'header-style-transparent-mobile-logo_regular_hd' => $this->get_option( 'header-style-mobile-logo_regular_hd' ),
				);

				foreach ( $transparent_mobile_logo_map as $key => $val ) {
					if ( $val ) {
						$this->set_option( $key, $val );
					}
				}
			}
		}
	}

}
