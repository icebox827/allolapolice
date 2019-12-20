<?php

class The7_WC_Mini_Cart {

	/**
	 * Init mini cart.
	 */
	public static function init() {
		add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'get_cart_fragments' ), 10, 1 );
		add_action( 'presscore_render_header_element-cart', array( __CLASS__, 'render_cart_micro_widget' ) );
		add_filter( 'presscore_localized_script', array( __CLASS__, 'localize_cart_fragment_hash' ) );
	}

	/**
	 * Return cart fragment hash.
	 *
	 * @since 6.2.2
	 *
	 * @return string
	 */
	public static function get_cart_fragment_hash() {
		return md5( wp_json_encode( optionsframework_get_options() ) );
	}

	/**
	 * Localize cart fragment hash to be used in js.
	 *
	 * @since 6.2.2
	 * @param array $data
	 *
	 * @return array
	 */
	public static function localize_cart_fragment_hash( $data ) {
		$data['wcCartFragmentHash'] = self::get_cart_fragment_hash();

		return $data;
	}

	/**
	 * Add mini cart fragments.
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	public static function get_cart_fragments( $fragments ) {
		ob_start();
		dt_woocommerce_configure_mini_cart();
		self::render_cart_inner();
		$fragments['.wc-shopping-cart'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Render mini cart.
	 */
	public static function render_cart_inner() {
		get_template_part( 'inc/mods/compatibility/woocommerce/front/templates/cart/mod-wc-mini-cart' );
	}

	public static function render_cart_micro_widget() {
		printf( '<div class="%s">', presscore_esc_implode( ' ', presscore_get_mini_widget_class( 'header-elements-woocommerce_cart' ) ) );
		self::render_cart_inner();
		echo '</div>';
	}
}
