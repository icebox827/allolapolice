<?php
/**
 * WooCommerce compatibility class.
 *
 * @package the7
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

class The7_Woocommerce_Compatibility {

	public function bootstrap() {
		$mod_dir = dirname( __FILE__ );

		// admin scripts
		require_once "{$mod_dir}/admin/mod-wc-shortcodes.php";
		require_once "{$mod_dir}/admin/mod-wc-admin-functions.php";

		// frontend scripts
		require_once "{$mod_dir}/front/mod-wc-class-template-config.php";
		require_once "{$mod_dir}/front/mod-wc-template-functions.php";
		require_once "{$mod_dir}/front/mod-wc-template-config.php";
		require_once "{$mod_dir}/front/mod-wc-template-hooks.php";
		require_once "{$mod_dir}/front/class-the7-wc-mini-cart.php";

		// add wooCommerce support
		add_theme_support( 'woocommerce', array(
			'gallery_thumbnail_image_width' => 200,
		) );

		if ( of_get_option( 'woocommerce-product_zoom' ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_filter( 'woocommerce_show_admin_notice', array( $this, 'hide_admin_notoces' ), 10, 2 );

		The7_WC_Mini_Cart::init();

		presscore_template_manager()->add_path( 'woocommerce', 'inc/mods/compatibility/woocommerce/front/templates' );
	}

	/**
	 * Hide some admin notices. The less you know, the better.
	 *
	 * @param bool   $show   Show or not the notice.
	 * @param string $notice Notice id.
	 *
	 * @return bool
	 */
	public function hide_admin_notoces( $show, $notice ) {
		if ( $notice === 'template_files' ) {
			return false;
		}

		return $show;
	}
}
