<?php
/**
 * The7 class for page based navigation.
 *
 * @since 7.6.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Page_Walker
 */
class The7_Walker_Page extends Walker_Page {
	private $dt_menu_parents = array();
	private $dt_is_first = true;

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Calls parent function in wp-includes/class-wp-walker.php
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

		if ( ! $element ) {
			return;
		}

		//Add indicators for top level menu items with submenus
		$id_field = $this->db_fields['id'];

		if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
			$this->dt_menu_parents[] = $element->$id_field;
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$this->dt_is_first = true;

		$output .= '<ul class="' . esc_attr( $args['submenu_class'] ) . '">';
	}

	function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		if ( $depth ) {
			$indent = str_repeat( "\t", $depth );
		} else {
			$indent = '';
		}

		$css_class = array( 'menu-item', 'page_item', 'page-item-' . $page->ID );

		if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
			$css_class[] = 'page_item_has_children';
		}

		if ( ! empty( $current_page ) ) {
			$_current_page = get_post( $current_page );
			if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
				$css_class[] = 'current_page_ancestor';
			}
			if ( $page->ID == $current_page ) {
				$css_class[] = 'current_page_item';
				$css_class[] = 'act';
			} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
				$css_class[] = 'current_page_parent';
			}
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current_page_parent';
		}

		if ( $this->dt_is_first ) {
			$css_class[] = 'first';
		}

		$dt_is_parent = in_array( $page->ID, $this->dt_menu_parents );

		// add parent class
		if ( $dt_is_parent ) {
			$css_class[] = 'has-children';
		}

		$atts = array();
		$atts['href'] = get_permalink( $page->ID );

		// nonclicable parent menu items
		if ( $dt_is_parent && ! $args['parent_is_clickable'] ) {
			$atts['class'] = 'not-clickable-item';
		}

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$attributes .= " {$attr}='{$value}'";
			}
		}

		$css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

		if ( '' === $page->post_title ) {
			/* translators: %d: ID of a post */
			$page->post_title = sprintf( __( '#%d (no title)', 'the7mk2' ), $page->ID );
		}

		$args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
		$args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

		$output .= $indent . sprintf(
				'<li class="%s"><a %s>%s%s%s</a>',
				$css_classes,
				$attributes,
				$args['link_before'],
				'<span class="menu-item-text"><span class="menu-text">' . apply_filters( 'the_title', $page->post_title, $page->ID ) . '</span></span>',
				$args['link_after']
			);

		if ( ! empty( $args['show_date'] ) ) {
			if ( 'modified' == $args['show_date'] ) {
				$time = $page->post_modified;
			} else {
				$time = $page->post_date;
			}

			$date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
			$output .= " " . mysql2date( $date_format, $time );
		}
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</ul>';
	}

	function end_el( &$output, $page, $depth = 0, $args = array() ) {
		$this->dt_is_first = false;

		$output .= '</li>';
	}

}