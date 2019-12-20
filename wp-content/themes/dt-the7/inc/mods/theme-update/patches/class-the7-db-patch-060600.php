<?php
/**
 * The7 6.6.0 patch.
 *
 * @package the7
 * @since   6.6.0
 */

if ( ! class_exists( 'The7_DB_Patch_060600', false ) ) {

	class The7_DB_Patch_060600 extends The7_DB_Patch {

		protected function do_apply() {
			/**
			 * It's important to launch migrate_links_color() before migrate_gradients().
			 */
			$this->migrate_links_color();

			$this->migrate_title_gradient();
			$this->migrate_gradients();
			$this->migrate_to_rgba_colors();
			$this->migrate_submenu_hover_bg_color();
		}

		private function migrate_gradients() {
			$gradient_map = array(
				'general-accent_bg_color_gradient'                  => null,
				'general-fullscreen_overlay_gradient'               => array(
					'opacity' => 'general-fullscreen_overlay_opacity',
				),
				'header-elements-soc_icons-bg-gradient'             => null,
				'header-elements-soc_icons-border-gradient'         => null,
				'header-elements-soc_icons-hover-bg-gradient'       => null,
				'header-elements-soc_icons-border-hover-gradient'   => null,
				'header-slide_out-overlay-bg-gradient'              => array(
					'opacity' => 'header-slide_out-overlay-bg-opacity',
				),
				'image_hover-color_gradient'                        => array(
					'opacity' => 'image_hover-opacity',
				),
				'image_hover-project_rollover_color_gradient'       => array(
					'opacity' => 'image_hover-project_rollover_opacity',
				),
				'header-menu-decoration-other-hover-line-gradient'  => array(
					'opacity' => 'header-menu-decoration-other-hover-line-opacity',
				),
				'header-menu-decoration-other-active-gradient'      => array(
					'opacity' => 'header-menu-decoration-other-active-opacity',
				),
				'header-menu-decoration-other-active-line-gradient' => array(
					'opacity' => 'header-menu-decoration-other-active-line-opacity',
				),
				'header-menu-decoration-other-click_decor-gradient' => array(
					'opacity' => 'header-menu-decoration-other-click_decor-opacity',
				),
				'header-mobile-menu-font-hover-gradient'            => array(
					'angle' => '90deg',
				),
				'buttons-color_gradient'                            => null,
				'buttons-hover_color_gradient'                      => null,
				'header-menu-submenu-hover-bg-gradient'             => null,
				'header-menu-hover-font-gradient'                   => array(
					'angle' => '90deg',
				),
				'header-menu-active_item-font-gradient'             => array(
					'angle' => '90deg',
				),
				'header-menu-submenu-hover-font-gradient'           => array(
					'angle' => '90deg',
				),
				'header-menu-submenu-active-font-gradient'          => array(
					'angle' => '90deg',
				),
				'header-menu-decoration-underline-gradient'         => null,
				'header-menu-decoration-other-hover-gradient'       => array(
					'opacity' => 'header-menu-decoration-other-opacity',
				),
			);

			foreach ( $gradient_map as $option_name => $mutator ) {
				$gradient = $this->get_option( $option_name );
				if ( ! is_array( $gradient ) ) {
					continue;
				}

				$opacity = 100;
				if ( isset( $mutator['opacity'] ) && $this->option_exists( $mutator['opacity'] ) ) {
					$opacity = (int) $this->get_option( $mutator['opacity'] );
				}

				$angle = '135deg';
				if ( isset( $mutator['angle'] ) ) {
					$angle = $mutator['angle'];
				}

				$gradient = $this->convert_gradient_array_to_string( $gradient, $angle, $opacity );
				$this->set_option( $option_name, $gradient );
			}
		}

		private function migrate_to_rgba_colors() {
			$color_opacity_map = array(
				'general-fullscreen_overlay_color'               => 'general-fullscreen_overlay_opacity',
				'header-slide_out-overlay-bg-color'              => 'header-slide_out-overlay-bg-opacity',
				'image_hover-color'                              => 'image_hover-opacity',
				'image_hover-project_rollover_color'             => 'image_hover-project_rollover_opacity',
				'header-menu-decoration-other-hover-line-color'  => 'header-menu-decoration-other-hover-line-opacity',
				'header-menu-decoration-other-active-color'      => 'header-menu-decoration-other-active-opacity',
				'header-menu-decoration-other-active-line-color' => 'header-menu-decoration-other-active-line-opacity',
				'header-menu-decoration-other-click_decor-color' => 'header-menu-decoration-other-click_decor-opacity',
				'header-menu-decoration-other-hover-color'       => 'header-menu-decoration-other-opacity',
			);

			foreach ( $color_opacity_map as $color_option => $opacity_option ) {
				if ( ! $this->option_exists( $color_option ) ) {
					continue;
				}

				$opacity = 100;
				if ( $this->option_exists( $opacity_option ) ) {
					$opacity = (int) $this->get_option( $opacity_option );
				}

				$color_obj = new The7_Less_Vars_Value_Color( $this->get_option( $color_option ) );
				$this->set_option( $color_option, $color_obj->opacity( $opacity )->get_rgba() );
			}
		}

		private function migrate_links_color() {
			if ( ! $this->option_exists( 'general-accent_color_mode' ) ) {
				return;
			}

			switch ( $this->get_option( 'general-accent_color_mode' ) ) {
				case 'color':
					$this->set_option( 'content-links_color', $this->get_option( 'general-accent_bg_color' ) );
					break;
				case 'gradient':
					$accent_gradient = $this->get_option( 'general-accent_bg_color_gradient' );
					if ( is_array( $accent_gradient ) && isset( $accent_gradient[0] ) ) {
						$this->set_option( 'content-links_color', $accent_gradient[0] );
					}
					break;
			}
		}

		private function migrate_submenu_hover_bg_color() {
			if ( ! $this->option_exists( 'header-menu-submenu-hover-font-color-style' ) ) {
				return;
			}

			$this->set_option( 'header-menu-submenu-hover-bg-opacity', 7 );
			$this->set_option( 'header-menu-submenu-active-bg-opacity', 7 );

			$color_obj = new The7_Less_Vars_Value_Color( $this->get_option( 'header-menu-submenu-hover-font-color' ) );
			$bg_color  = $color_obj->opacity( 7 )->get_rgba();
			$this->set_option( 'header-menu-submenu-hover-bg-color', $bg_color );
			$this->set_option( 'header-menu-submenu-active-bg-color', $bg_color );

			$submenu_hover_bg_map = array(
				'header-menu-submenu-hover-bg-color-style'  => 'header-menu-submenu-hover-font-color-style',
				'header-menu-submenu-active-bg-color-style' => 'header-menu-submenu-hover-font-color-style',
				'header-menu-submenu-hover-bg-gradient'     => 'header-menu-submenu-hover-font-gradient',
				'header-menu-submenu-active-bg-gradient'    => 'header-menu-submenu-hover-font-gradient',
			);

			foreach ( $submenu_hover_bg_map as $bg_option => $text_option ) {
				$this->set_option( $bg_option, $this->get_option( $text_option ) );
			}
		}

		private function migrate_title_gradient() {
			$gradient = $this->get_option( 'general-title_bg_gradient' );
			if ( ! is_array( $gradient ) ) {
				return;
			}

			$angle = '135deg';
			if ( $this->option_exists( 'general-title_dir_gradient' ) ) {
				$angle = (int) $this->get_option( 'general-title_dir_gradient' ) . 'deg';
				$this->remove_option( 'general-title_dir_gradient' );
			}

			$this->set_option( 'general-title_bg_gradient', $this->convert_gradient_array_to_string( $gradient, $angle ) );
		}

		/**
		 * Convert gradient value.
		 *
		 * @param string|array $gradient
		 * @param string       $angle
		 * @param int          $opacity
		 *
		 * @return string
		 */
		private function convert_gradient_array_to_string( $gradient, $angle = '135deg', $opacity = 100 ) {
			if ( ! is_array( $gradient ) || ! isset( $gradient[0], $gradient[1] ) ) {
				return (string) $gradient;
			}

			foreach ( $gradient as $i => $color ) {
				$color_obj      = new The7_Less_Vars_Value_Color( $color );
				$gradient[ $i ] = $opacity === 100 ? $color_obj->get_hex() : $color_obj->opacity( $opacity )->get_rgba();
			}

			return "{$angle}|{$gradient[0]} 30%|{$gradient[1]} 100%";
		}

	}

}
