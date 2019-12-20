<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'The7_Compatibility_EDD', false ) ) {

	class The7_Compatibility_EDD {

		public static function execute() {
			if ( ! class_exists( 'Easy_Digital_Downloads', false ) ) {
				return;
			}

			if ( is_admin() ) {
				add_filter( 'header_layout_elements', array( __CLASS__, 'add_cart_micro_widget' ) );
				add_filter( 'presscore_options_files_to_load', array( __CLASS__, 'add_cart_micro_widget_options' ) );
				add_action( 'presscore_setup_less_vars', array( __CLASS__, 'cart_micro_widget_less_vars' ), 20 );
			}

			add_action( 'wp_ajax_the7_edd_cart_micro_widget', array( __CLASS__, 'cart_micro_widget_ajax' ) );
			add_action( 'wp_ajax_nopriv_the7_edd_cart_micro_widget', array( __CLASS__, 'cart_micro_widget_ajax' ) );
			add_action( 'presscore_render_header_element-edd_cart', array( __CLASS__, 'render_cart_micro_widget' ) );
			add_filter( 'presscore_get_dynamic_stylesheets_list', array( __CLASS__, 'register_dynamic_stylesheet' ) );
		}

		public static function register_dynamic_stylesheet( $stylesheets ) {
			$stylesheets['edd-custom'] = array(
				'src' => 'compatibility/edd-custom.less',
			);

			return $stylesheets;
		}

		/**
		 * Add EDD cart micro widget in header theme options.
		 *
		 * @since 6.6.1
		 *
		 * @param array $elements Micro widgets array.
		 *
		 * @return array $elements Micro widgets array.
		 */
		public static function add_cart_micro_widget( $elements = array() ) {
			$elements['edd_cart'] = array( 'title' => _x( 'EDD Cart', 'theme-options', 'the7mk2' ), 'class' => '' );

			return $elements;
		}


		/**
		 * Add EDD cart micro widget options in header theme options.
		 *
		 * @since 6.6.1
		 *
		 * @param array $option_files Option files array.
		 *
		 * @return array $option_files Option files array.
		 */
		public static function add_cart_micro_widget_options( $option_files ) {
			if ( array_key_exists( 'of-header-menu', $option_files ) ) {
				$option_files['of-edd-mod-injected-header-options'] = dirname( __FILE__ ) . '/options-inject-in-header.php';
			}

			return $option_files;
		}

		public static function configure_cart_micro_widget_settings() {
			$config = presscore_config();
			$config->set( 'edd.mini_cart.caption', of_get_option( 'header-elements-edd_cart-caption' ) );
			$config->set( 'edd.mini_cart.icon', of_get_option( 'header-elements-edd_cart-icon', true ) );
			$config->set( 'edd.mini_cart.subtotal', of_get_option( 'header-elements-edd_cart-show_subtotal' ) );
			$config->set( 'edd.mini_cart.counter', of_get_option( 'header-elements-edd_cart-show_counter', 'allways' ) );
			$config->set( 'edd.mini_cart.counter.style', of_get_option( 'header-elements-edd_cart-counter-style', 'round' ) );
			$config->set( 'edd.mini_cart.counter.bg', of_get_option( 'header-elements-edd_cart-counter-bg', 'accent' ) );
			$config->set( 'edd.mini_cart.dropdown', of_get_option( 'header-elements-edd_cart-show_sub_cart' ) );
		}

		public static function cart_micro_widget_less_vars( The7_Less_Vars_Manager_Interface $less_vars ) {
			$less_vars->add_hex_color( 'edd-product-counter-color', of_get_option( 'header-elements-edd_cart-counter-color' ) );
			$less_vars->add_hex_color(
				'edd-sub-cart-color',
				of_get_option( 'header-elements-edd_cart-sub_cart-font-color' )
			);

	 		$less_vars->add_pixel_number(
	     		'edd-sub-cart-width',
	     		of_get_option( 'header-elements-edd_cart-sub_cart-bg-width' )
	     	);
			$less_vars->add_rgba_color(
				'edd-sub-cart-bg',
				of_get_option( 'header-elements-edd_cart-sub_cart-bg-color' )
			);

			$counter_color_vars = array( 'edd-product-counter-bg', 'edd-product-counter-bg-2' );
			switch ( of_get_option( 'header-elements-edd_cart-counter-bg' ) ) {
				case 'color':
					$less_vars->add_rgba_color( $counter_color_vars, array(
						of_get_option( 'header-elements-edd_cart-counter-bg-color' ),
						null,
					) );
					break;
				case 'gradient':
					$gradient_obj = the7_less_create_gradient_obj( of_get_option( 'header-elements-edd_cart-counter-bg-gradient' ) );
					$less_vars->add_rgba_color( $counter_color_vars[0], $gradient_obj->get_color_stop( 1 )->get_color() );
					$less_vars->add_keyword( $counter_color_vars[1], $gradient_obj->with_angle( 'left' )->get_string() );
					break;
				case 'accent':
				default:
					list( $first_color, $gradient ) = the7_less_get_accent_colors( $less_vars );
					$less_vars->add_rgba_color( $counter_color_vars[0], $first_color );
					$less_vars->add_keyword( $counter_color_vars[1], $gradient->with_angle( 'left' )->get_string() );
			}

			$less_vars->add_pixel_number( 'mw-edd-cart-counter-size', of_get_option( 'header-elements-woocommerce_edd_cart-counter-size', 9 ) );

			$less_vars->add_number( 'edd-cart-total-width', of_get_option( 'edd_cart_total_width' ) );
		}

		/**
		 * Render cart micro widget.
		 *
		 * @since 6.6.1
		 */
		public static function render_cart_micro_widget() {
			self::configure_cart_micro_widget_settings();
			$classes = presscore_esc_implode( ' ', presscore_get_mini_widget_class( 'header-elements-edd_cart' ) );
			echo '<div class="' . $classes . '">';
			get_template_part( 'inc/mods/compatibility/edd/cart-micro-widget' );
			echo '</div>';
		}

		public static function cart_micro_widget_ajax() {
			self::configure_cart_micro_widget_settings();
			get_template_part( 'inc/mods/compatibility/edd/cart-micro-widget' );
			die();
		}
	}

	The7_Compatibility_EDD::execute();
}

