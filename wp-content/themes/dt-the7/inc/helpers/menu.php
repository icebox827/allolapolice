<?php
/**
 * Menu helpers.
 *
 * @package the7/helpers
 * @since 3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'presscore_get_primary_menu_class' ) ) :

	/**
	 * Primary menu wrap classes.
	 * 
	 * @param  string|array $class
	 * @return array
	 */
	function presscore_get_primary_menu_class( $class = '' ) {
		$classes = presscore_split_classes( $class );

		$config = presscore_config();
		switch( $config->get( 'header.menu.decoration.style' ) ) {
			case 'underline':
				$classes[] = 'underline-decoration';

				$classes[] = presscore_array_value( $config->get( 'header.menu.decoration.style.underline.direction' ), array(
					'left_to_right'      => 'l-to-r-line',
					'from_center'        => 'from-centre-line',
					'upwards'            => 'upwards-line',
					'downwards'          => 'downwards-line',
				) );
				break;
			case 'other':
				$classes[] = 'bg-outline-decoration';

				$classes[] = presscore_array_value( $config->get( 'header.menu.decoration.style.other.hover.style' ), array(
					'outline'    => 'hover-outline-decoration',
					'background' => 'hover-bg-decoration',
				) );

				if ( $config->get( 'header.menu.decoration.style.other.hover.line.enabled' ) ) {
					$classes[] = 'hover-line-decoration';
				}

				$classes[] = presscore_array_value( $config->get( 'header.menu.decoration.style.other.active.style' ), array(
					'outline'    => 'active-outline-decoration',
					'background' => 'active-bg-decoration',
				) );

				if ( $config->get( 'header.menu.decoration.style.other.active.line.enabled' ) ) {
					$classes[] = 'active-line-decoration';
				}
				break;
		}

		if ( presscore_is_gradient_color_mode( $config->get( 'header.menu.hover.color.style' ) ) ) {
			$classes[] = 'gradient-hover';
		}

		if ( $config->get( 'header.menu.show_next_lvl_icons' ) ) {
			$classes[] = 'level-arrows-on';
		}

		$classes[] = presscore_array_value( $config->get( 'header.menu.items.margins.style' ), array(
			'double'   => 'outside-item-double-margin',
			'custom'   => 'outside-item-custom-margin',
			'disabled' => 'outside-item-remove-margin',
		) );

		$classes = apply_filters( 'presscore_primary_menu_class', $classes );

		return presscore_sanitize_classes( $classes );
	}

endif;

if ( ! function_exists( 'presscore_get_primary_submenu_class' ) ) :

	/**
	 * Primary menu submenu classes.
	 * 
	 * @param  string|array $class
	 * @return array
	 */
	function presscore_get_primary_submenu_class( $class = '' ) {
		$classes = presscore_split_classes( $class );

		$config = presscore_config();

		if ( presscore_is_gradient_color_mode( $config->get( 'header.menu.submenu.hover.color.style' ) ) ) {
			$classes[] = 'gradient-hover';
		}

		$classes[] = presscore_array_value( $config->get( 'header.menu.submenu.background.hover.style' ), array(
			'background'          => 'hover-style-bg',
		) );

		if ( $config->get( 'header.menu.submenu.show_next_lvl_icons' ) ) {
			$classes[] = 'level-arrows-on';
		}

		$classes = apply_filters( 'presscore_primary_submenu_class', $classes );

		return presscore_sanitize_classes( $classes );
	}

endif;

if ( ! function_exists( 'presscore_nav_menu_list' ) ) :

	/**
	 * Display secondary nav menu.
	 *
	 * @since  3.0.0
	 *
	 * @param  string $location Menu location.
	 * @param  array  $args     Arguments like
	 *                          array(
	 *                          'menu_wrap_class'  => '',
	 *                          'before_menu_name' => '',
	 *                          'after_menu_name'  => '',
	 *                          'submenu_class'    => 'sub-nav',
	 *                          ).
	 */
	function presscore_nav_menu_list( $location, $args = array() ) {
		$locations = get_nav_menu_locations();
		$menu      = isset( $locations[ $location ] ) ? wp_get_nav_menu_object( $locations[ $location ] ) : null;
		if ( ! $menu ) {
			return;
		}

		$args = wp_parse_args(
			$args,
			array(
				'menu_wrap_class'  => '',
				'before_menu_name' => '',
				'after_menu_name'  => '',
				'submenu_class'    => 'sub-nav',
			)
		);

		$classes = presscore_split_classes( $args['menu_wrap_class'] );
		array_unshift( $classes, 'mini-nav' );

		echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		presscore_nav_menu(
			array(
				'theme_location'      => $location,
				'items_wrap'          => '<ul id="' . esc_attr( "{$location}-menu" ) . '">%3$s</ul>',
				'submenu_class'       => $args['submenu_class'],
				'parent_is_clickable' => true,
				'fallback_cb'         => '',
			)
		);
		echo '<div class="menu-select"><span class="customSelect1"><span class="customSelectInner">' . $args['before_menu_name'] . esc_html( $menu->name ) . $args['after_menu_name'] . '</span></span></div>';
		echo '</div>';
	}

endif;

if ( ! function_exists( 'presscore_primary_nav_menu' ) ) :

	/**
	 * Display theme primary nav menu.
	 *
	 * @since  3.0.0
	 * @param  string $location
	 */
	function presscore_primary_nav_menu( $location ) {
		do_action( 'presscore_primary_nav_menu_before' );

		presscore_nav_menu( array(
			'theme_location'      => $location,
			'items_wrap'          => '%3$s',
			'submenu_class'       => implode( ' ', presscore_get_primary_submenu_class( 'sub-nav' ) ),
			'parent_is_clickable' => presscore_config()->get( 'header.menu.submenu.parent_clickable' ),
		) );

		do_action( 'presscore_primary_nav_menu_after' );
	}

endif;

if ( ! function_exists( 'presscore_has_mobile_menu' ) ) :

	/**
	 * This helper checks if a page has mobile menu on it.
	 *
	 * @since 3.0.0
	 * @return boolean
	 */
	function presscore_has_mobile_menu() {
		return apply_filters( 'presscore_has_mobile_menu', has_nav_menu( 'mobile' ) );
	}

endif;

/**
 * Display mobile nav menu.
 *
 * @since 7.6.0
 *
 * @param string $location Menu location to display.
 */
function the7_display_mobile_menu( $location ) {
	do_action( 'presscore_primary_nav_menu_before' );

	presscore_nav_menu(
		array(
			'theme_location'      => $location,
			'items_wrap'          => '%3$s',
			'submenu_class'       => implode( ' ', presscore_get_primary_submenu_class( 'sub-nav' ) ),
			'parent_is_clickable' => presscore_config()->get( 'header.menu.submenu.parent_clickable' ),
			'walker'              => new The7_Walker_Nav_Menu_Mobile(),
		)
	);

	do_action( 'presscore_primary_nav_menu_after' );
}

/**
 * Return menu cache key based on $args.
 *
 * @since 6.4.0
 *
 * @param array $args Some array.
 *
 * @return string
 */
function the7_get_menu_cache_key( $args ) {
	$args['walker'] = get_class( $args['walker'] );

	return 'the7_menu_cache-' . md5( wp_json_encode( $args ) );
}

if ( ! function_exists( 'presscore_disable_posts_meta_cache_warming' ) ) {

	/**
	 * Disable post meta cache update for $wp_query.
	 * Intended to be used with 'pre_get_posts' action.
	 *
	 * @since 6.1.1
	 *
	 * @param WP_Query $wp_query WP Query object.
	 */
	function presscore_disable_posts_meta_cache_warming( $wp_query ) {
		$wp_query->query_vars['update_post_meta_cache'] = false;
	}
}

if ( ! function_exists( 'presscore_nav_menu' ) ) :

	function presscore_nav_menu( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'theme_location' => 'primary',
			'container' => false,
			'container_class' => false,
			'menu_class' => false,
			'menu_id' => 'mainmenu',
			'fallback_cb' => 'presscore_page_menu',
			'before' => '',
			'after' => '',
			'items_wrap' => '<ul id="%1$s">%3$s</ul>',
			'echo' => true,
			'submenu_class' => 'sub-nav',
			'parent_is_clickable' => true,
		) );
		$args = apply_filters( 'presscore_nav_menu_args', $args );

		if ( empty( $args['walker'] ) ) {
			$args['walker'] = new The7_Walker_Nav_Menu();
		}

		$nav_menu = apply_filters( 'presscore_pre_nav_menu', null, $args );

		if ( null !== $nav_menu ) {
			if ( $args['echo'] ) {
				echo $nav_menu;
				return;
			}

			return $nav_menu;
		}

		$html = wp_cache_get( the7_get_menu_cache_key( $args ), 'the7-tmp' );
		if ( ! $html ) {
			$_args = $args;
			$_args['echo'] = false;

			// Try to resolve high memory consumption.
			add_action( 'pre_get_posts', 'presscore_disable_posts_meta_cache_warming' );
			$html = wp_nav_menu( $_args );
			remove_action( 'pre_get_posts', 'presscore_disable_posts_meta_cache_warming' );

			wp_cache_add( the7_get_menu_cache_key( $args ), $html, 'the7-tmp' );
		}

		if ( $args['echo'] ) {
			echo $html;
		} else {
			return $html;
		}
	}

endif;

if ( ! function_exists( 'presscore_page_menu' ) ) :

	function presscore_page_menu( $args = array() ) {
		$defaults = array(
			'sort_column'       => 'menu_order, post_title',
			'container_class'   => 'nav-bg',
			'menu_id'           => 'nav',
			'echo'              => false,
			'link_before'       => '',
			'link_after'        => '',
		);
		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'wp_page_menu_args', $args );
		$menu = '';

		$list_args = $args;
		$list_args['echo'] = false;
		$list_args['title_li'] = '';
		$list_args['walker'] = new The7_Walker_Page();

		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages( $list_args ) );

		if ( isset( $menu ) ) {
			$menu = sprintf(
				$args['items_wrap'],
				$args['menu_id'],
				$args['menu_class'],
				$menu
			);
		}

		$menu = apply_filters( 'wp_page_menu', $menu, $args );

		if ( $args['echo'] ) {
			echo $menu;
			return;
		} else {
			return $menu;
		}
	}

endif;