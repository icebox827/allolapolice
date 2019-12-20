<?php
/**
 * Options templates.
 *
 * @package The7\Options\Templates
 * @since   3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Presscore_Lib_Options_MicrowidgetFontTemplate', false ) ) :

	/**
	 * Logo options template class.
	 */
	class Presscore_Lib_Options_MicrowidgetFontTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['typography'] = array(
				'type' => 'typography',
				'std'  => array(
					'font_family' => 'Arial',
					'font_size'   => 14,
				),
			);

			$_fields['font_color'] = array(
				'name' => _x( 'Font color', 'theme-options', 'the7mk2' ),
				'type' => 'color',
				'std'  => '#888888',
			);

			$_fields['custom-icon-size'] = array(
				'name'    => _x( 'Icon size', 'theme-options', 'the7mk2' ),
				'type'    => 'slider',
				'std'     => 16,
				'options' => array( 'min' => 9, 'max' => 120 ),
			);

			$_fields['custom-icon-color'] = array(
				'name' => _x( 'Icon color', 'theme-options', 'the7mk2' ),
				'type' => 'alpha_color',
				'std'  => '',
				'desc' => _x( 'Leave empty to use font color.', 'theme-options', 'the7mk2' ),
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_LogoTemplate', false ) ) :

	/**
	 * Logo options template class.
	 */
	class Presscore_Lib_Options_LogoTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['logo_regular'] = array(
				'name' => _x( 'Logo', 'theme-options', 'the7mk2' ),
				'type' => 'upload',
				'mode' => 'full',
				'std'  => array( '', 0 ),
			);

			$_fields['logo_hd'] = array(
				'name' => _x( 'High-DPI (retina) logo', 'theme-options', 'the7mk2' ),
				'type' => 'upload',
				'mode' => 'full',
				'std'  => array( '', 0 ),
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_IndentsTemplate', false ) ) :

	/**
	 * Indents options template class.
	 */
	class Presscore_Lib_Options_IndentsTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['top'] = array(
				'name'     => _x( 'Top padding (px)', 'theme-options', 'the7mk2' ),
				'type'     => 'text',
				'std'      => '0',
				'class'    => 'mini',
				'sanitize' => 'dimensions',
			);

			$_fields['right'] = array(
				'name'     => _x( 'Right padding (px)', 'theme-options', 'the7mk2' ),
				'type'     => 'text',
				'std'      => '0',
				'class'    => 'mini',
				'sanitize' => 'dimensions',
			);

			$_fields['bottom'] = array(
				'name'     => _x( 'Bottom padding (px)', 'theme-options', 'the7mk2' ),
				'type'     => 'text',
				'std'      => '0',
				'class'    => 'mini',
				'sanitize' => 'dimensions',
			);

			$_fields['left'] = array(
				'name'     => _x( 'Left padding (px)', 'theme-options', 'the7mk2' ),
				'type'     => 'text',
				'std'      => '0',
				'class'    => 'mini',
				'sanitize' => 'dimensions',
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_IndentsMarginsTemplate', false ) ) :

	/**
	 * Margin indents options template class.
	 */
	class Presscore_Lib_Options_IndentsMarginsTemplate extends Presscore_Lib_Options_IndentsTemplate {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = parent::do_execute();

			$_fields['top']['name']    = _x( 'Top margin (px)', 'theme-options', 'the7mk2' );
			$_fields['right']['name']  = _x( 'Right margin (px)', 'theme-options', 'the7mk2' );
			$_fields['bottom']['name'] = _x( 'Bottom margin (px)', 'theme-options', 'the7mk2' );
			$_fields['left']['name']   = _x( 'Left margin (px)', 'theme-options', 'the7mk2' );

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_IndentsHTemplate', false ) ) :

	/**
	 * Horizontal indents options template class.
	 */
	class Presscore_Lib_Options_IndentsHTemplate extends Presscore_Lib_Options_IndentsTemplate {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = parent::do_execute();

			// remove vertical indention
			unset( $_fields['top'], $_fields['bottom'] );

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_IndentsVTemplate', false ) ) :

	/**
	 * Vertical indents options template class.
	 */
	class Presscore_Lib_Options_IndentsVTemplate extends Presscore_Lib_Options_IndentsTemplate {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = parent::do_execute();

			// remove horizontal indention
			unset( $_fields['left'], $_fields['right'] );

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_SideHeaderMenuTemplate', false ) ) :

	/**
	 * Side header menu options template class.
	 */
	class Presscore_Lib_Options_SideHeaderMenuTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['menu-position'] = array(
				'name'    => _x( 'Menu position', 'theme-options', 'the7mk2' ),
				'type'    => 'images',
				'std'     => 'v_top',
				'options' => array(
					'v_top'    => array(
						'title' => _x( 'Top', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-menu-position-top.gif',
					),
					'v_center' => array(
						'title' => _x( 'Center', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-menu-position-center.gif',
					),
					'v_bottom' => array(
						'title' => _x( 'Bottom', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-menu-position-bottom.gif',
					),
				),
				'class'   => 'small',
			);

			$_fields['logo-position'] = array(
				'name'    => _x( 'Logo and microwidgets position', 'theme-options', 'the7mk2' ),
				'type'    => 'images',
				'std'     => 'fully_inside',
				'options' => array(
					'fully_inside' => array(
						'title' => _x( 'Along the edges of menu', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-logo-position-fullyinside.gif',
					),
					'inside'       => array(
						'title' => _x( 'Along the edges of navigation area', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-logo-position-inside.gif',
					),
				),
				'class'   => 'small',
			);

			$_fields['menu-items_alignment'] = array(
				'name'    => _x( 'Menu items alignment', 'theme-options', 'the7mk2' ),
				'type'    => 'images',
				'std'     => 'left',
				'options' => array(
					'left'   => array(
						'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-menu-itemsalignment-left.gif',
					),
					'center' => array(
						'title' => _x( 'Center', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-menu-itemsalignment-center.gif',
					),
				),
				'class'   => 'small',
			);

			$_fields['menu-items_link'] = array(
				'name'    => _x( 'Menu items link area', 'theme-options', 'the7mk2' ),
				'type'    => 'images',
				'std'     => 'fullwidth',
				'options' => array(
					'fullwidth' => array(
						'title' => _x( 'Full-width', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-menu-itemslink-fullwidth.gif',
					),
					'textwidth' => array(
						'title' => _x( 'Text-width', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-menu-itemslink-textwidth.gif',
					),
				),
				'class'   => 'small',
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_SideHeaderContentTemplate', false ) ) :

	/**
	 * Side header content options template class.
	 */
	class Presscore_Lib_Options_SideHeaderContentTemplate extends Presscore_Lib_Options_IndentsTemplate {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['content-width'] = array(
				'name'  => _x( 'Width of header content', 'theme-options', 'the7mk2' ),
				'std'   => '220px',
				'type'  => 'number',
				'units' => 'px|%',
			);

			$_fields['content-position'] = array(
				'name'    => _x( 'Position of header content', 'theme-options', 'the7mk2' ),
				'type'    => 'images',
				'std'     => 'left',
				'options' => array(
					'left'   => array(
						'title' => _x( 'Left', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-content-position-left.gif',
					),
					'center' => array(
						'title' => _x( 'Center', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-content-position-center.gif',
					),
					'right'  => array(
						'title' => _x( 'Right', 'theme-options', 'the7mk2' ),
						'src'   => '/inc/admin/assets/images/header-side-content-position-right.gif',
					),
				),
				'class'   => 'small',
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_SlideoutHeaderLayoutTemplate', false ) ) :

	/**
	 * Side header layout options template class.
	 */
	class Presscore_Lib_Options_SlideoutHeaderLayoutTemplate extends Presscore_Lib_Options_IndentsTemplate {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_MobileHeaderTemplate', false ) ) :

	/**
	 * Mobile header options template class.
	 */
	class Presscore_Lib_Options_MobileHeaderTemplate extends Presscore_Lib_Options_IndentsTemplate {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['after'] = array(
				'name'  => _x( 'Switch after', 'theme-options', 'the7mk2' ),
				'std'   => '1024px',
				'type'  => 'number',
				'units' => 'px',
			);

			$_fields['layout'] = array(
				'name'    => _x( 'Layout', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'std'     => 'left_right',
				'options' => array(
					'left_right'   => _x( 'Left menu + right logo', 'theme-options', 'the7mk2' ),
					'left_center'  => _x( 'Left menu + centered logo', 'theme-options', 'the7mk2' ),
					'right_left'   => _x( 'Right menu + left logo', 'theme-options', 'the7mk2' ),
					'right_center' => _x( 'Right menu + centered logo', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['height'] = array(
				'name'  => _x( 'Header height', 'theme-options', 'the7mk2' ),
				'std'   => '150px',
				'type'  => 'number',
				'units' => 'px',
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_HeaderElementMobileLayoutTemplate', false ) ) :

	/**
	 * Header element mobile layout options template class.
	 */
	class Presscore_Lib_Options_HeaderElementMobileLayoutTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['on-desktops'] = array(
				'name'    => _x( 'On desktops', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'std'     => 'show',
				'options' => array(
					'show' => _x( 'Show', 'theme-options', 'the7mk2' ),
					'hide' => _x( 'Hide', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['first-header-switch'] = array(
				'name'    => _x( 'First header switch point (tablet)', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'std'     => 'near_logo',
				'options' => array(
					'near_logo'     => _x( 'Mobile header', 'theme-options', 'the7mk2' ),
					'top_bar_left'  => _x( 'Top bar (left)', 'theme-options', 'the7mk2' ),
					'top_bar_right' => _x( 'Top bar (right)', 'theme-options', 'the7mk2' ),
					'in_menu'       => _x( 'Mobile navigation', 'theme-options', 'the7mk2' ),
					'hidden'        => _x( 'Hide', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['second-header-switch'] = array(
				'name'    => _x( 'Second header switch point (phone)', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'std'     => 'in_menu',
				'divider' => 'bottom',
				'options' => array(
					'near_logo'  => _x( 'Mobile header', 'theme-options', 'the7mk2' ),
					'in_top_bar' => _x( 'Top bar', 'theme-options', 'the7mk2' ),
					'in_menu'    => _x( 'Mobile navigation', 'theme-options', 'the7mk2' ),
					'hidden'     => _x( 'Hide', 'theme-options', 'the7mk2' ),
				),
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_BasicHeaderElementTemplate', false ) ) :

	/**
	 * Basic header element options template class.
	 */
	class Presscore_Lib_Options_BasicHeaderElementTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			if ( class_exists( 'Presscore_Lib_Options_HeaderElementMobileLayoutTemplate', false ) ) {
				$element = new Presscore_Lib_Options_HeaderElementMobileLayoutTemplate();
				$element->execute( $_fields, '' );
				unset( $element );
			}

			$_fields['caption'] = array(
				'name'     => _x( 'Caption', 'theme-options', 'the7mk2' ),
				'type'     => 'text',
				'std'      => '',
				'sanitize' => 'textarea',
				'divider'  => 'top',
			);

			$_fields['icon'] = array(
				'name'    => _x( 'Graphic icon', 'theme-options', 'the7mk2' ),
				'type'    => 'select',
				'class'   => 'middle',
				'std'     => 'custom',
				'options' => array(
					'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
					'custom'   => _x( 'Enabled', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['custom-icon'] = array(
				'name'          => 'Select icon',
				'id'            => 'custom-icon',
				'type'          => 'icons_picker',
				'default_icons' => presscore_options_micro_widgets_common_icons(),
				'std'           => 'the7-mw-icon-address',
				'dependency'    => array(
					'field'    => 'icon',
					'operator' => '==',
					'value'    => 'custom',
				),
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_ExtConditionalColorTemplate', false ) ) :

	/**
	 * Conditional color with accent options template class.
	 */
	class Presscore_Lib_Options_ExtConditionalColorTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields['color-style'] = array(
				'name'    => _x( 'Font color', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'class'   => 'small',
				'std'     => 'accent',
				'options' => array(
					'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
					'color'    => _x( 'Custom color', 'theme-options', 'the7mk2' ),
					'gradient' => _x( 'Custom gradient', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['color'] = array(
				'name'       => _x( 'Color', 'theme-options', 'the7mk2' ),
				'type'       => 'color',
				'std'        => '#ffffff',
				'dependency' => array(
					array(
						array(
							'field'    => 'color-style',
							'operator' => '==',
							'value'    => 'color',
						),
					),
				),
			);

			$_fields['gradient'] = array(
				'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				'type'       => 'gradient_picker',
				'std'        => '135deg|#ffffff 30%|#000000 100%',
				'dependency' => array(
					array(
						array(
							'field'    => 'color-style',
							'operator' => '==',
							'value'    => 'gradient',
						),
					),
				),
			);

			return $_fields;
		}
	}

endif;

if ( ! class_exists( 'Presscore_Lib_Options_HeaderElementButtonTemplate', false ) ) :

	/**
	 * Header element buttom micro widget options template class.
	 */
	class Presscore_Lib_Options_HeaderElementButtonTemplate extends The7_Options_Template_Abstract {

		/**
		 * @return array
		 */
		protected function do_execute() {
			$_fields = array();

			$_fields[] = array(
				'name' => _x( 'Button settings', 'theme-options', 'the7mk2' ),
				'type' => 'title',
			);

			$_fields['name'] = array(
				'name' => _x( 'Button name', 'theme-options', 'the7mk2' ),
				'type' => 'text',
				'std'  => _x( 'Button', 'theme-options', 'the7mk2' ),
			);

			$_fields['url'] = array(
				'name' => _x( 'Link', 'theme-options', 'the7mk2' ),
				'type' => 'text',
				'std'  => '',
			);

			$_fields['target'] = array(
				'name' => _x( 'Open link in a new tab', 'theme-options', 'the7mk2' ),
				'type' => 'checkbox',
				'std'  => '0',
			);

			$_fields['smooth-scroll'] = array(
				'name' => _x( 'Enable smooth scroll for anchor navigation', 'theme-options', 'the7mk2' ),
				'type' => 'checkbox',
				'std'  => '0',
			);

			$_fields['typography'] = array(
				'type' => 'typography',
				'std'  => array(
					'font_family' => 'Roboto:700',
					'font_size'   => 14,
				),
			);

			$_fields['border_radius'] = array(
				'name'  => _x( 'Border radius', 'theme-options', 'the7mk2' ),
				'std'   => '0px',
				'type'  => 'number',
				'units' => 'px',
			);

			$_fields['border_width'] = array(
				'name'  => _x( 'Border width', 'theme-options', 'the7mk2' ),
				'std'   => '1px',
				'type'  => 'number',
				'units' => 'px',
			);

			$_fields['padding'] = array(
				'name' => _x( 'Paddings', 'theme-options', 'the7mk2' ),
				'type' => 'spacing',
				'std'  => '10px 20px 10px 20px',
			);

			$_fields[] = array( 'type' => 'divider' );

			$_fields[] = array(
				'name' => _x( 'Icon settings', 'theme-options', 'the7mk2' ),
				'type' => 'title',
			);

			$_fields['icon'] = array(
				'name' => _x( 'Show icon', 'theme-options', 'the7mk2' ),
				'type' => 'checkbox',
				'std'  => '0',
			);

			$_fields['icon-size'] = array(
				'name'       => _x( 'Icon size', 'theme-options', 'the7mk2' ),
				'type'       => 'slider',
				'std'        => 14,
				'options'    => array( 'min' => 8, 'max' => 50 ),
				'dependency' => array(
					'field'    => 'icon',
					'operator' => '==',
					'value'    => '1',
				),
			);

			$_fields['choose-icon'] = array(
				'name'       => 'Select icon',
				'type'       => 'icons_picker',
				'std'        => false,
				'dependency' => array(
					'field'    => 'icon',
					'operator' => '==',
					'value'    => '1',
				),
			);

			$_fields['icon-position'] = array(
				'name'       => _x( 'Icon alignment', 'theme-options', 'the7mk2' ),
				'type'       => 'select',
				'class'      => 'middle',
				'std'        => 'right',
				'options'    => array(
					'right' => _x( 'Right', 'theme-options', 'the7mk2' ),
					'left'  => _x( 'Left', 'theme-options', 'the7mk2' ),
				),
				'dependency' => array(
					'field'    => 'icon',
					'operator' => '==',
					'value'    => '1',
				),
			);

			$_fields[] = array( 'type' => 'divider' );

			$_fields[] = array(
				'name' => _x( 'Normal state', 'theme-options', 'the7mk2' ),
				'type' => 'title',
			);

			$_fields['icon-color'] = array(
				'name'    => _x( 'Text & icon color', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'class'   => 'small',
				'std'     => 'color',
				'options' => array(
					'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
					'color'    => _x( 'Mono color', 'theme-options', 'the7mk2' ),
					'gradient' => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['icon-color-mono'] = array(
				'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
				'type'       => 'alpha_color',
				'std'        => '#ffffff',
				'dependency' => array(
					'field'    => 'icon-color',
					'operator' => '==',
					'value'    => 'color',
				),
			);

			$_fields['icon-color-gradient'] = array(
				'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				'type'        => 'gradient_picker',
				'std'         => '90deg|#ffffff 30%|#000000 100%',
				'fixed_angle' => '90deg',
				'dependency'  => array(
					'field'    => 'icon-color',
					'operator' => '==',
					'value'    => 'gradient',
				),
			);

			$_fields['border-color'] = array(
				'name'    => _x( 'Border color', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'class'   => 'small',
				'std'     => 'accent',
				'options' => array(
					'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
					'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
					'color'    => _x( 'Mono color', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['border-color-mono'] = array(
				'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
				'type'       => 'alpha_color',
				'std'        => '#ffffff',
				'dependency' => array(
					'field'    => 'border-color',
					'operator' => '==',
					'value'    => 'color',
				),
			);

			$_fields['bg'] = array(
				'name'    => _x( 'Button background color', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'class'   => 'small',
				'std'     => 'accent',
				'options' => array(
					'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
					'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
					'color'    => _x( 'Mono color', 'theme-options', 'the7mk2' ),
					'gradient' => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['bg-color'] = array(
				'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
				'type'       => 'alpha_color',
				'std'        => '#ffffff',
				'dependency' => array(
					'field'    => 'bg',
					'operator' => '==',
					'value'    => 'color',
				),
			);

			$_fields['bg-gradient'] = array(
				'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				'type'       => 'gradient_picker',
				'std'        => '135deg|#ffffff 30%|#000000 100%',
				'dependency' => array(
					'field'    => 'bg',
					'operator' => '==',
					'value'    => 'gradient',
				),
			);

			$_fields[] = array( 'type' => 'divider' );

			$_fields[] = array(
				'name' => _x( 'Hover state', 'theme-options', 'the7mk2' ),
				'type' => 'title',
			);

			$_fields['hover-icon-color'] = array(
				'name'    => _x( 'Text & icon color', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'class'   => 'small',
				'std'     => 'color',
				'options' => array(
					'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
					'color'    => _x( 'Mono color', 'theme-options', 'the7mk2' ),
					'gradient' => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['hover-icon-color-mono'] = array(
				'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
				'type'       => 'alpha_color',
				'std'        => '#ffffff',
				'dependency' => array(
					'field'    => 'hover-icon-color',
					'operator' => '==',
					'value'    => 'color',
				),
			);

			$_fields['hover-icon-color-gradient'] = array(
				'name'        => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				'type'        => 'gradient_picker',
				'std'         => '90deg|#ffffff 30%|#000000 100%',
				'fixed_angle' => '90deg',
				'dependency'  => array(
					'field'    => 'hover-icon-color',
					'operator' => '==',
					'value'    => 'gradient',
				),
			);

			$_fields['hover-border-color'] = array(
				'name'    => _x( 'Border color', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'class'   => 'small',
				'std'     => 'accent',
				'options' => array(
					'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
					'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
					'color'    => _x( 'Mono color', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['hover-border-color-mono'] = array(
				'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
				'type'       => 'alpha_color',
				'std'        => '#ffffff',
				'dependency' => array(
					'field'    => 'hover-border-color',
					'operator' => '==',
					'value'    => 'color',
				),
			);

			$_fields['hover-bg'] = array(
				'name'    => _x( 'Button background color', 'theme-options', 'the7mk2' ),
				'type'    => 'radio',
				'class'   => 'small',
				'std'     => 'accent',
				'options' => array(
					'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
					'accent'   => _x( 'Accent', 'theme-options', 'the7mk2' ),
					'color'    => _x( 'Mono color', 'theme-options', 'the7mk2' ),
					'gradient' => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				),
			);

			$_fields['hover-bg-color'] = array(
				'name'       => _x( 'Choose color', 'theme-options', 'the7mk2' ),
				'type'       => 'alpha_color',
				'std'        => '#ffffff',
				'dependency' => array(
					'field'    => 'hover-bg',
					'operator' => '==',
					'value'    => 'color',
				),
			);

			$_fields['hover-bg-gradient'] = array(
				'name'       => _x( 'Gradient', 'theme-options', 'the7mk2' ),
				'type'       => 'gradient_picker',
				'std'        => '135deg|#ffffff 30%|#000000 100%',
				'dependency' => array(
					'field'    => 'hover-bg',
					'operator' => '==',
					'value'    => 'gradient',
				),
			);

			return $_fields;
		}
	}

endif;
