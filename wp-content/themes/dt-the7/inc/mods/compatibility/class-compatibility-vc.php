<?php
/**
 * Visual Composer compatibility class.
 *
 * @package the7
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Presscore_Modules_Compatibility_VC', false ) ) :

	class Presscore_Modules_Compatibility_VC {

		public static function execute() {
			if ( ! class_exists( 'Vc_Manager', false ) ) {
				return;
			}

			if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
				vc_set_default_editor_post_types( apply_filters( 'presscore_mod_js_composer_default_editor_post_types', array( 'page', 'post' ) ) );
			}

			if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
				vc_set_shortcodes_templates_dir( PRESSCORE_THEME_DIR . '/inc/shortcodes/vc_templates' );
			}

			require_once locate_template( '/inc/shortcodes/vc-extensions.php' );

			add_action( 'init', array( __CLASS__, 'load_bridge' ), 20 );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_admin_static' ), 20 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'fix_vc_inline_styles' ), 9999 );
			add_action( 'admin_print_scripts-post.php', array( __CLASS__, 'editor_scripts' ), 9999 );
			add_action( 'admin_print_scripts-post-new.php', array( __CLASS__, 'editor_scripts' ), 9999 );
			add_action( 'admin_init', array( __CLASS__, 'remove_teaser_meta_box' ), 7 );
			add_filter( 'presscore_localized_script', array( __CLASS__, 'localize_script' ) );

			if ( presscore_vc_is_inline() ) {
				add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_vc_inline_assets' ), 20 );
			}

			add_action( 'vc_after_init_base', array( __CLASS__, 'remove_vc_the_excerpt_filter' ) );

			if ( get_option( 'wpb_js_gutenberg_disable' ) ) {
				add_action( 'wp_print_styles', array( __CLASS__, 'dequeue_gutenberg_stylesheets' ), 9999 );
				add_filter( 'presscore_get_dynamic_stylesheets_list', array( __CLASS__, 'remove_gutenberg_dynamic_stylesheets' ) );
			}
		}

		/**
		 * Enqueue VC inline styles after theme style css.
		 *
		 * In VC 6.0.2 inline styles was moved to after `js_composer_front` which cause some issues
		 * with overriding theme css.
		 *
		 * @since 7.6.2.5
		 */
		public static function fix_vc_inline_styles() {
			if ( ! function_exists( 'wp_styles' ) ) {
				return;
			}

			if ( isset( wp_styles()->registered['js_composer_front']->extra['after'] ) ) {
				$vc_inline_style = wp_styles()->get_data( 'js_composer_front', 'after' );
				wp_styles()->add_data( 'style', 'after', $vc_inline_style );
				wp_styles()->registered['js_composer_front']->extra['after'] = array();
			}
		}

		/**
		 * Dequeue gutenberg stylesheets.
		 */
		public static function dequeue_gutenberg_stylesheets() {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
		}

		/**
		 * Remove Gutenberg less.
		 *
		 * @param array $stylesheets Stylesheets definition.
		 *
		 * @return array
		 */
		public static function remove_gutenberg_dynamic_stylesheets( $stylesheets ) {
			if ( isset( $stylesheets['dt-custom']['imports']['dynamic_import_top'] ) ) {
				$stylesheets['dt-custom']['imports']['dynamic_import_top'] = array_diff(
					$stylesheets['dt-custom']['imports']['dynamic_import_top'],
					array( 'dynamic-less/plugins/gutenberg.less' )
				);
			}

			return $stylesheets;
		}

		/**
		 * Remove vc excerptFilter. This filter cause great performance overhead so theme replaces it with own, more performant one.
		 *
		 * @see the7_shortcodeaware_excerpt_filter
		 *
		 * @since 6.4.0
		 */
		public static function remove_vc_the_excerpt_filter() {
			remove_filter( 'the_excerpt', array( vc_manager()->vc(), 'excerptFilter' ) );
		}

		public static function load_bridge() {
			$shortcodes_to_remove = apply_filters( 'presscore_js_composer_shortcodes_to_remove', array(
				"vc_gallery",
				"vc_teaser_grid",
				"vc_button",
				"vc_cta_button",
				"vc_posts_grid",
				"vc_carousel",
				"vc_images_carousel",
				"vc_posts_slider",
				"vc_cta_button2",
			) );

			foreach ( $shortcodes_to_remove as $shortcode ) {
				vc_remove_element( $shortcode );
			}

			require_once locate_template( '/inc/shortcodes/js_composer_bridge.php' );

			do_action( 'presscore_js_composer_after_bridge_loaded' );
		}

		public static function load_admin_static( $hook ) {
			if ( ! in_array( $hook, array( 'post.php', 'new-post.php' ), true ) ) {
				return;
			}

			wp_enqueue_style( 'dt-vc-bridge', PRESSCORE_THEME_URI . '/inc/shortcodes/css/js_composer_bridge.css', array(), THE7_VERSION );

			if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
				wp_enqueue_script( 'vc-custom-view-by-dt', PRESSCORE_THEME_URI . '/inc/shortcodes/js/vc-custom-view.js', array(), THE7_VERSION, true );
			}
		}

		public static function editor_scripts() {
			if ( is_callable( 'vc_editor_post_types' ) && in_array( get_post_type(), vc_editor_post_types() ) ) {
				wp_enqueue_script( 'the7-vc-editor', trailingslashit( PRESSCORE_SHORTCODES_URI ) . 'vc_extend/vc-editor.js', array(), THE7_VERSION, true );
			}
		}

		/**
		 * Enqueue assets for vc inline editor.
		 */
		public static function enqueue_vc_inline_assets() {
			wp_enqueue_style( 'the7-vc-inline-editor', get_template_directory_uri() . '/inc/shortcodes/css/vc-inline-editor.css', array(), THE7_VERSION );
			wp_enqueue_script( 'the7-vc-inline-editor', get_template_directory_uri() . '/inc/shortcodes/js/vc-inline-editor.js', array(), THE7_VERSION, true );
		}

		public static function remove_teaser_meta_box() {
			global $vc_teaser_box;
			if ( is_callable( 'vc_editor_post_types' ) && ! empty( $vc_teaser_box ) ) {
				$pt_array = vc_editor_post_types();
				foreach ( $pt_array as $pt ) {
					remove_meta_box( 'vc_teaser', $pt, 'side' );
				}
				remove_action( 'save_post', array( &$vc_teaser_box, 'saveTeaserMetaBox' ) );
			}
		}

		/**
		 * Export VC settings to js.
		 *
		 * @param array $var
		 *
		 * @return array
		 */
		public static function localize_script( $var = array() ) {
			$var['VCMobileScreenWidth'] = get_option( 'wpb_js_responsive_max', '768' );
			return $var;
		}
	}

	Presscore_Modules_Compatibility_VC::execute();

endif;
