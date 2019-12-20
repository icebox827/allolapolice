<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'DT_WC_Shortcodes', false ) ):

	class DT_WC_Shortcodes {

		/**
		 * Init shortcodes.
		 */
		public static function init() {
			self::override_shortcodes();
		}

		/**
		 * List multiple products shortcode.
		 *
		 * @param array $atts
		 * @return string
		 */
		public static function product( $atts ) {
			/**
			 * Add masonry class filter.
			 *
			 * @see presscore_masonry_container_class
			 */
			add_filter( 'presscore_masonry_container_class', 'dt_woocommerce_product_shortcode_classes_filter' );

			/**
			 * Modify $config
			 */
			add_action( 'dt_wc_loop_start', 'dt_woocommerce_destroy_layout', 20 );

			// Do WC shortcode.
			$html = WC_Shortcodes::product( $atts );

			/**
			 * Remove masonry class filter.
			 *
			 * @see presscore_masonry_container_class
			 */
			remove_filter( 'presscore_masonry_container_class', 'dt_woocommerce_product_shortcode_classes_filter' );
			remove_action( 'dt_wc_loop_start', 'dt_woocommerce_destroy_layout', 20 );

			return $html;
		}

		/**
		 * Override default WC shortcodes.
		 */
		protected static function override_shortcodes() {
			if ( ! class_exists( 'WC_Shortcodes' ) ) {
				return;
			}

			$shortcodes = array(
				'product' => __CLASS__ . '::product',
			);

			foreach ( $shortcodes as $shortcode => $function ) {
				if ( ! method_exists( 'WC_Shortcodes', $shortcode ) ) {
					continue;
				}

				$shortcode_tag = apply_filters( "{$shortcode}_shortcode_tag", $shortcode );

				// Remove original shortcode.
				remove_shortcode( $shortcode_tag );

				// Register override.
				add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
			}
		}
	}

endif;
