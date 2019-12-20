<?php
/**
 * Microsite template helpers.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'presscore_microsite_hide_header' ) ) :

	// Microsite header classes filter
	function presscore_microsite_hide_header( $classes = array() ) {
		$classes[] = 'hidden-header';
		return $classes;
	}

endif;

if ( ! function_exists( 'presscore_microsite_disable_headers' ) ) :

	// Microsite header classes filter
	function presscore_microsite_disable_headers( $classes = array() ) {
		$classes[] = 'disable-headers';
		return $classes;
	}

endif;

if ( ! function_exists( 'presscore_microsite_top_bar_class_filter' ) ):

	/**
	 * Add custom classes to the top bar.
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function presscore_microsite_top_bar_class_filter( $classes ) {
		// Hide top bar.
		$classes[] = 'hide-top-bar';

		return $classes;
	}

endif;

if ( ! function_exists( 'presscore_microsite_logo_meta_convert' ) ) :

	/**
	 * Convert logo from page meta to theme options format and override $name option.
	 *
	 * @since  3.0.0
	 * @param  string $meta_id
	 * @param  array &$options
	 * @param  string $name
	 * @return boolean
	 */
	function presscore_microsite_logo_meta_convert( $meta_id, &$options, $name ) {
		global $post;

		$meta_logo = get_post_meta( $post->ID, $meta_id, true );
		if ( $meta_logo ) {
			$options[ $name ] = array( '', absint( $meta_logo[0] ) );

			return true;
		}

		// Empty logo.
		$options[ $name ] = array( '', 0 );

		return false;
	}

endif;

if ( ! function_exists( 'presscore_microsite_is_custom_logo' ) ) :

	/**
	 * @param string $meta_id
	 *
	 * @return bool
	 */
	function presscore_microsite_is_custom_logo( $meta_id ) {
		global $post;

		return ( 'custom' === get_post_meta( $post->ID, $meta_id, true ) ? true : false );
	}

endif;

if ( ! function_exists( 'presscore_microsite_theme_options_filter' ) ) :

	/**
	 * Microsite theme options filter.
	 *
	 * @param array $options
	 * @param string $name
	 *
	 * @return array
	 */
	function presscore_microsite_theme_options_filter( $options = array(), $name = '' ) {
		global $post;

		$field_prefix = '_dt_microsite_';

		/**
		 * Logo.
		 */
		$logo_options_meta = array(
			'header-logo_regular' => array(
				'value_meta_id' => 'main_logo_regular',
				'type_meta_id' => 'main_logo_type'
			),
		    'header-logo_hd' => array(
			    'value_meta_id' => 'main_logo_hd',
			    'type_meta_id' => 'main_logo_type'
		    ),
			'header-style-transparent-logo_regular' => array(
				'value_meta_id' => 'transparent_logo_regular',
				'type_meta_id' => 'transparent_logo_type'
			),
			'header-style-transparent-logo_hd' => array(
				'value_meta_id' => 'transparent_logo_hd',
				'type_meta_id' => 'transparent_logo_type'
			),
			'header-style-mixed-logo_regular' => array(
				'value_meta_id' => 'mixed_logo_regular',
				'type_meta_id' => 'mixed_logo_type'
			),
			'header-style-mixed-logo_hd' => array(
				'value_meta_id' => 'mixed_logo_hd',
				'type_meta_id' => 'mixed_logo_type'
			),
			'header-style-floating-logo_regular' => array(
				'value_meta_id' => 'floating_logo_regular',
				'type_meta_id' => 'floating_logo_type',
			),
			'header-style-floating-logo_hd' => array(
				'value_meta_id' => 'floating_logo_hd',
				'type_meta_id' => 'floating_logo_type'
			),
			'header-style-mobile-logo_regular' => array(
				'value_meta_id' => 'mobile_logo_regular',
				'type_meta_id' => 'mobile_logo_type'
			),
			'header-style-mobile-logo_hd' => array(
				'value_meta_id' => 'mobile_logo_hd',
				'type_meta_id' => 'mobile_logo_type'
			),
			'header-style-transparent-mobile-logo_regular' => array(
				'value_meta_id' => 'transparent_mobile_logo_regular',
				'type_meta_id' => 'transparent_mobile_logo_type'
			),
			'header-style-transparent-mobile-logo_hd' => array(
				'value_meta_id' => 'transparent_mobile_logo_hd',
				'type_meta_id' => 'transparent_mobile_logo_type'
			),
			'bottom_bar-logo_regular' => array(
				'value_meta_id' => 'bottom_logo_regular',
				'type_meta_id' => 'bottom_logo_type'
			),
			'bottom_bar-logo_hd' => array(
				'value_meta_id' => 'bottom_logo_hd',
				'type_meta_id' => 'bottom_logo_type'
			),
		);

		if ( array_key_exists( $name, $logo_options_meta ) ) {
			$logo_mode_meta_id = $field_prefix . $logo_options_meta[ $name ]['type_meta_id'];
			if ( presscore_microsite_is_custom_logo( $logo_mode_meta_id ) ) {
				$logo_value_meta_id = $field_prefix . $logo_options_meta[ $name ]['value_meta_id'];
				presscore_microsite_logo_meta_convert( $logo_value_meta_id, $options, $name );
			}
		}

		/**
		 * Logo mode.
		 */
		$logo_mode_meta = array(
			'header-style-floating-choose_logo' => 'floating_logo_type',
			'header-style-transparent-choose_logo' => 'transparent_logo_type',
		);

		if ( array_key_exists( $name, $logo_mode_meta ) ) {
			$logo_mode_meta_id = $field_prefix . $logo_mode_meta[ $name ];
			if ( presscore_microsite_is_custom_logo( $logo_mode_meta_id ) ) {
				$options[ $name ] = 'custom';
			}
		}

		/**
		 * Favicon.
		 */
		$favicon_meta = array(
			'general-favicon'    => 'favicon',
			'general-favicon_hd' => 'favicon_hd',
		);
		if ( array_key_exists( $name, $favicon_meta ) && presscore_microsite_is_custom_logo( "{$field_prefix}favicon_type" ) ) {
			$favicon = get_post_meta( $post->ID, "{$field_prefix}{$favicon_meta[$name]}", true );
			if ( $favicon ) {
				$icon_image = wp_get_attachment_image_src( $favicon[0], 'full' );

				if ( $icon_image ) {
					$options[ $name ] = $icon_image[0];
				}
			}
		}

		return $options;
	}

endif;

if ( ! function_exists( 'presscore_microsite_add_options_filters' ) ) :

	function presscore_microsite_add_options_filters() {
		global $post;

		if ( ! $post || ! presscore_is_microsite() ) {
			return;
		}

		// add filter for theme options here
		add_filter( 'dt_of_get_option', 'presscore_microsite_theme_options_filter', 15, 2 );
	}

	add_action( 'presscore_config_before_base_init', 'presscore_microsite_add_options_filters' );

endif;

if ( ! function_exists( 'presscore_microsite_menu_filter' ) ) :

	/**
	 * Microsite menu filter.
	 *
	 */
	function presscore_microsite_menu_filter( $args = array() ) {
		$location = $args['theme_location'];
		$page_menu = get_post_meta( get_the_ID(), "_dt_microsite_{$location}_menu", true );
		$page_menu = intval( $page_menu );

		if ( $page_menu > 0 ) {
			$args['menu'] = $page_menu;
		}

		return $args;
	}

endif;

if ( ! function_exists( 'presscore_microsite_pre_nav_menu_filter' ) ) :

	/**
	 * Add capability to display page menu on microsite. Same as empty menu location.
	 *
	 * @since  3.0.0
	 * @param mixed $nav_menu
	 * @param array $args
	 * @return string
	 */
	function presscore_microsite_pre_nav_menu_filter( $nav_menu, $args = array() ) {
		$location = $args['theme_location'];
		$page_menu = get_post_meta( get_the_ID(), "_dt_microsite_{$location}_menu", true );
		if ( intval( $page_menu ) < 0 && isset( $args['fallback_cb'] ) && is_callable( $args['fallback_cb'] ) ) {
			$args['echo'] = false;
			return call_user_func( $args['fallback_cb'], $args );
		}

		return $nav_menu;
	}

endif;

if ( ! function_exists( 'presscore_microsite_has_mobile_menu_filter' ) ) :

	function presscore_microsite_has_mobile_menu_filter( $has_menu ) {
		$page_menu = get_post_meta( get_the_ID(), '_dt_microsite_mobile_menu', true );
		$page_menu = intval( $page_menu );
		if ( 0 !== $page_menu ) {
			return true;
		}

		return $has_menu;
	}

endif;

if ( ! function_exists( 'presscore_microsite_setup' ) ) :

	function presscore_microsite_setup() {
		global $post;

		if ( ! $post || ! presscore_is_microsite() ) {
			return;
		}

		// add menu filter here
		add_filter( 'presscore_nav_menu_args', 'presscore_microsite_menu_filter' );
		add_filter( 'presscore_pre_nav_menu', 'presscore_microsite_pre_nav_menu_filter', 10, 2 );
		add_filter( 'presscore_has_mobile_menu', 'presscore_microsite_has_mobile_menu_filter' );

		// hide template parts
		$config = presscore_config();
		$hidden_parts = get_post_meta( $post->ID, "_dt_microsite_hidden_parts", false );
		$hide_header = in_array( 'header', $hidden_parts );
		$hide_floating_menu = in_array( 'floating_menu', $hidden_parts );

		if ( $hide_header ) {
			add_filter( 'body_class', 'presscore_microsite_hide_header' );

			if ( $hide_floating_menu ) {
				add_filter( 'presscore_show_header', '__return_false' );
				add_filter( 'body_class', 'presscore_microsite_disable_headers' );
			}
		}

		// Hide top bar.
		if ( in_array( 'top_bar', $hidden_parts ) ) {
			add_filter( 'presscore_top_bar_class', 'presscore_microsite_top_bar_class_filter' );
		}

		// hide bottom bar
		if ( in_array( 'bottom_bar', $hidden_parts ) ) {
			add_filter( 'presscore_show_bottom_bar', '__return_false' );
		} else {
			add_filter( 'presscore_show_bottom_bar', '__return_true' );
		}

		// hide content
		if ( in_array( 'content', $hidden_parts ) ) {
			add_filter( 'presscore_is_content_visible', '__return_false' );
		}

		$loading = get_post_meta( $post->ID, '_dt_microsite_page_loading', true );
		$config->set( 'template.beautiful_loading.enabled', ( $loading ? $loading : 'enabled' ) );

		$layout = get_post_meta( $post->ID, '_dt_microsite_page_layout', true );
		$config->set( 'template.layout', ( $layout ? $layout : 'wide' ) );

		$config->set( 'header.floating_navigation.enabled', ! $hide_floating_menu );
	}

	add_action( 'presscore_config_base_init', 'presscore_microsite_setup' );

endif;

if ( ! function_exists( 'presscore_is_microsite' ) ) :

	/**
	 * @since 3.0.0
	 * @return boolean
	 */
	function presscore_is_microsite() {
		return ( 'microsite' === presscore_config()->get( 'template' ) );
	}

endif;
