<?php
/**
 * WPML compatibility class.
 *
 * @package the7
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Presscore_Modules_Compatibility_WPML', false ) ) :

	class Presscore_Modules_Compatibility_WPML {

		public static function execute() {

			// load wpml helpers
			require_once trailingslashit( PRESSCORE_MODS_DIR ) . 'compatibility/' . basename( dirname( __FILE__ ) ) . '/wpml-integration.php';

			/**
			 * Do not load wpml language switcher css.
			 */
			if ( of_get_option('wpml_dt-custom_style') && ! defined( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS' ) ) {
				define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
			}
			// admin scripts
			require_once dirname(__FILE__) . '/admin/mod-wpml-admin-functions.php';
			/**
			 * Dirty hack that fixes front page pagination with custom query.
			 */
			remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
			add_action( 'template_redirect', 'wp_shortlink_header',  11, 0 );

			/**
			 * Enqueue dynamic stylesheets.
			 */
			if (  of_get_option('wpml_dt-custom_style') ) {
				add_filter( 'presscore_get_dynamic_stylesheets_list', array( __CLASS__, 'enqueue_dynamic_stylesheets_filter' ) );
			}

			/**
			 * Add editor.
			 */
			add_action( 'init', array( __CLASS__, 'enable_editor_for_post_types_action' ), 16 );

			/**
			 * Hide editor.
			 */
			add_action( 'admin_print_styles-post.php', array( __CLASS__, 'hide_editor_for_post_types_action' ) );
			add_action( 'admin_print_styles-post-new.php', array( __CLASS__, 'hide_editor_for_post_types_action' ) );

			/**
			 * Render language switcher.
			 */
			add_action( 'presscore_render_header_element-language', array( __CLASS__, 'render_header_language_switcher_action' ) );

			/**
			 * Add language microwidget options.
			 */
			add_filter( 'presscore_options_files_to_load', array( __CLASS__, 'add_microwidget_options_filter' ) );

			/**
			 * For some reasons WPML remove '<ul></div>' from pages based menu html and add it after laguage switcher code.
			 * It has destroyed menu html so here we override this 'bad' WPML filter.
			 */
			// TODO WPML will introduce templating language switcher - this call will be deprecated
			global $icl_language_switcher;
			if ( is_object( $icl_language_switcher ) ) {
				remove_filter( 'wp_page_menu', array( $icl_language_switcher, 'wp_page_menu_filter' ), 10, 2 );
				add_filter( 'wp_page_menu', array( __CLASS__, 'wp_page_menu_filter' ), 10, 2 );
			}

			/**
			 * Add header layout elements.
			 */
			add_filter( 'header_layout_elements', array( __CLASS__, 'add_header_layout_elements_filter' ) );

			/**
			 * Add lang attribute for header search form.
			 */
			add_action( 'presscore_header_searchform_fields', array( __CLASS__, 'add_header_searchform_lang_action' ) );

			/**
			 * Translate frontend.
			 */

			// Post back link.
			add_filter( 'presscore_post_back_link_id', array( __CLASS__, 'presscore_post_back_link_id_filter' ) );

			/**
			 * Translate theme options.
			 */
			add_action( 'optionsframework_after_validate', array( __CLASS__, 'register_social_icons_strings' ) );
			add_action( 'dt_of_get_option-header-elements-soc_icons', array( __CLASS__, 'translate_social_icons_url' ) );

			/**
			 * Translate custom fields.
			 */

			// Template category.
			add_filter( 'the7_mb_fancy_category_meta', array( __CLASS__, 'the7_mb_fancy_category_meta_filter' ), 10, 2 );

			// Images list.
			add_filter( 'the7_mb_image_advanced_mk2_meta', array( __CLASS__, 'the7_mb_image_advanced_mk2_meta_filter' ) );

			// Related posts.
			add_filter( 'the7_mb_taxonomy_list_meta', array( __CLASS__, 'the7_mb_taxonomy_list_meta_filter' ), 10, 2 );

			// Slideshow.
			add_filter( 'the7_mb__dt_slideshow_sliders_meta', array( __CLASS__, 'the7_mb__dt_slideshow_sliders_meta_filter' ) );

			// Back button page.
			add_filter( 'the7_mb_dropdown_pages_meta', array( __CLASS__, 'the7_mb_dropdown_pages_meta_filter' ), 10, 2 );

			if ( is_admin() && ! wp_doing_ajax() && ! wp_doing_cron() ) {
				// Setup WPML settings.
				self::setup_wpml_settings();
			}
		}

		/**
		 * Setup WPML settings.
		 */
		public static function setup_wpml_settings() {
			global $sitepress;

			if ( ! is_a( $sitepress, 'SitePress' ) ) {
				return;
			}

			// Enable language cookies by default.
			if ( class_exists( 'WPML_Cookie_Setting' ) ) {
				$wpml_cookie = new WPML_Cookie_Setting( $sitepress );
				if ( $wpml_cookie->get_setting() === false ) {
					$wpml_cookie->set_setting( 1 );
				}
			}
		}

		public static function register_social_icons_strings( $options ) {
			if ( empty( $options['header-elements-soc_icons'] ) ) {
				return;
			}

			foreach ( $options['header-elements-soc_icons'] as $index => $icon ) {
				$icon_name = $icon['icon'];
				do_action( 'wpml_register_single_string', 'Header icons', "$icon_name-icon-url-$index", $icon['url'] );
			}
		}

		public static function translate_social_icons_url( $option ) {
			if ( empty( $option ) || ! is_array( $option ) ) {
				return $option;
			}

			foreach ( $option as $index => $icon ) {
				$icon_name = $icon['icon'];
				$option[ $index ]['url'] = apply_filters( 'wpml_translate_single_string', $icon['url'], 'Header icons', "$icon_name-icon-url-$index" );
			}

			return $option;
		}

		public static function add_microwidget_options_filter( $options ) {
			if ( array_key_exists( 'of-header-menu', $options ) ) {
				$options['of-wpml-language-microwidget-options'] = plugin_dir_path( __FILE__ ) . 'lang-mw-options.php';
			}
			return $options;
		}

		public static function enable_editor_for_post_types_action() {
			add_post_type_support( 'dt_slideshow', 'editor' );
			add_post_type_support( 'dt_logos', 'editor' );
		}

		public static function hide_editor_for_post_types_action() {
			if ( in_array( get_post_type(), array( 'dt_slideshow', 'dt_logos' ) ) ) {
				wp_add_inline_style( 'dt-mb-magick', '#postdivrich { display: none; }' );
			}
		}

		public static function render_header_language_switcher_action() {
			echo '<div class="' . presscore_esc_implode( ' ', presscore_get_mini_widget_class( 'header-elements-language', 'mini-wpml' ) ) . '">';
			do_action( 'wpml_add_language_selector' );
			echo '</div>';
		}

		public static function wp_page_menu_filter( $items, $args ) {
			$obj_args = new stdClass();
			foreach ( $args as $key => $value ) {
				$obj_args->$key = $value;
			}

			return apply_filters( 'wp_nav_menu_items', $items, $obj_args );
		}

		public static function add_header_layout_elements_filter( $elements = array() ) {
			$elements['language'] = array( 'title' => _x( 'WPML lang.', 'theme-options', 'the7mk2' ), 'class' => '' );
			return $elements;
		}

		public static function enqueue_dynamic_stylesheets_filter( $dynamic_stylesheets ) {
			$dynamic_stylesheets['wpml.less'] = array(
				'path' => PRESSCORE_THEME_DIR . '/css/compatibility/wpml.less',
				'src' => PRESSCORE_THEME_URI . '/css/compatibility/wpml.less',
				'fallback_src' => '',
				'deps' => array(),
				'ver' => THE7_VERSION,
				'media' => 'all'
			);
			return $dynamic_stylesheets;
		}

		public static function add_header_searchform_lang_action() {
			echo '<input type="hidden" name="lang" value="' . apply_filters( 'wpml_current_language', null ) .'"/>';
		}

		public static function the7_mb_fancy_category_meta_filter( $meta, $field = array() ) {
			// Translate terms.
			if ( isset( $meta['terms_ids'], $field['taxonomy'] ) ) {
				$meta['terms_ids'] = presscore_translate_object_id( $meta['terms_ids'], $field['taxonomy'] );
			}

			// Translate posts.
			if ( isset( $meta['posts_ids'], $field['post_type'] ) ) {
				$meta['posts_ids'] = presscore_translate_object_id( $meta['posts_ids'], $field['post_type'] );
			}

			return $meta;
		}

		public static function the7_mb_image_advanced_mk2_meta_filter( $meta ) {
			return presscore_translate_object_id( $meta, 'attachment' );
		}

		public static function the7_mb__dt_slideshow_sliders_meta_filter( $meta ) {
			return presscore_translate_object_id( $meta, 'dt_slideshow' );
		}

		public static function the7_mb_taxonomy_list_meta_filter( $meta, $field ) {
			if ( isset( $field['options']['taxonomy'] ) ) {
				return presscore_translate_object_id( $meta, $field['options']['taxonomy'] );
			}

			return $meta;
		}

		public static function the7_mb_dropdown_pages_meta_filter( $meta, $field ) {
			return presscore_translate_object_id( $meta, 'page' );
		}

		public static function presscore_post_back_link_id_filter( $page_id ) {
			return presscore_translate_object_id( $page_id, 'page' );
		}
	}
	if ( did_action( 'wpml_loaded' ) ) {
		Presscore_Modules_Compatibility_WPML::execute();
	}


endif;
