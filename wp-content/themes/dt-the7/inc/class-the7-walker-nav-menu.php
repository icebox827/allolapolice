<?php
/**
 * The7 nav menu walker class.
 *
 * @since   7.6.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Nav_Menu_Walker
 */
class The7_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Array of parent menu items ids.
	 *
	 * @var array
	 */
	protected $dt_menu_parents = array();

	/**
	 * Determine is current item first in level.
	 *
	 * @var bool
	 */
	protected $dt_is_first = true;

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 *
	 * @see Walker::start_lvl()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$this->dt_is_first = true;

		$output .= apply_filters(
			'presscore_nav_menu_start_lvl',
			'<ul class="' . esc_attr( $args->submenu_class ) . '">',
			$depth,
			$args
		);
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 *
	 * @see Walker::end_lvl()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= apply_filters( 'presscore_nav_menu_end_lvl', '</ul>', $depth, $args );
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 *
	 * @see Walker::start_el()
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item->dt_is_first     = $this->dt_is_first;
		$item->dt_is_parent    = in_array( $item->ID, $this->dt_menu_parents );
		$item->dt_is_clickable = ( ! $item->dt_is_parent || $args->parent_is_clickable );

		do_action( 'presscore_nav_menu_start_el', $item, $args, $depth );

		$classes = $this->dt_get_item_classes( $item, $args, $depth );

		$link_before = apply_filters( 'presscore_nav_menu_link_before', $args->link_before, $item, $args, $depth );
		$link_after  = apply_filters( 'presscore_nav_menu_link_after', $args->link_after, $item, $args, $depth );
		$el_before   = apply_filters( 'presscore_nav_menu_el_before', '', $item, $args, $depth );

		// li wrap.
		$output .= $el_before . '<li class="' . implode( ' ', array_filter( $classes ) ) . '">';

		$title       = apply_filters( 'the_title', $item->title, $item->ID );
		$title       = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$description = '';
		if ( $item->description ) {
			$description = '<span class="subtitle-text">' . esc_html( $item->description ) . '</span>';
		}

		$menu_item = apply_filters( 'presscore_nav_menu_item', '', $title, $description, $item, $depth );
		if ( ! $menu_item ) {
			$menu_item = '<span class="menu-item-text"><span class="menu-text">' . $title . '</span>' . $description . '</span>';
		}

		$menu_item = $link_before . $menu_item . $link_after;

		$attributes = $this->dt_prepare_atts( $this->dt_get_item_atts( $item, $args, $depth ) );
		if ( $attributes ) {
			$item_output = '<a' . $attributes . '>' . $menu_item . '</a>';
		} else {
			$item_output = '<span>' . $menu_item . '</span>';
		}

		$item_output = $args->before . $item_output . $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 *
	 * @see Walker::end_el()
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$this->dt_is_first = false;
		$el_after          = apply_filters( 'presscore_nav_menu_el_after', '', $item, $args, $depth );

		$output .= '</li>' . $el_after . ' ';
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth. It is possible to set the
	 * max depth to include all depths, see walk() method.
	 *
	 * This method should not be called directly, use the walk() method instead.
	 *
	 * @param object $element           Data object.
	 * @param array  $children_elements List of elements to continue traversing (passed by reference).
	 * @param int    $max_depth         Max depth to traverse.
	 * @param int    $depth             Depth of current element.
	 * @param array  $args              An array of arguments.
	 * @param string $output            Used to append additional content (passed by reference).
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];
		$id       = $element->$id_field;

		if ( ! empty( $children_elements[ $id ] ) ) {
			$this->dt_menu_parents[] = $id;
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Return item attributes array.
	 *
	 * @param WP_Post  $item  Page data object.
	 * @param stdClass $args  An object of wp_nav_menu() arguments.
	 * @param int      $depth Depth of page.
	 * @param array    $atts  Array of item attributes.
	 *
	 * @return array
	 */
	protected function dt_get_item_atts( $item, $args, $depth, $atts = array() ) {
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['class']  = '';

		if ( ! $item->dt_is_clickable ) {
			$atts['class'] .= 'not-clickable-item';
		}

		$atts['data-level'] = absint( $depth ) + 1;

		if ( isset( $item->the7_mega_menu['menu-item-icon-type'] ) && in_array( $item->the7_mega_menu['menu-item-icon-type'], array( 'image', 'icon' ) ) ) {
			$atts['class'] .= ' mega-menu-img';
			if ( isset( $item->the7_mega_menu['menu-item-image-position'] ) ) {
				$atts['class'] .= ' mega-menu-img-' . $item->the7_mega_menu['menu-item-image-position'];
			}
		}

		$atts = apply_filters( 'presscore_nav_menu_link_attributes', $atts, $item, $args, $depth );

		return apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
	}

	/**
	 * Convert array of attributes to string.
	 *
	 * @param array $atts Attributes array.
	 *
	 * @return string
	 */
	protected function dt_prepare_atts( $atts = array() ) {
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= " {$attr}='{$value}'";
			}
		}

		return $attributes;
	}

	/**
	 * Return array of item classes.
	 *
	 * @param WP_Post  $item  Page data object.
	 * @param stdClass $args  An object of wp_nav_menu() arguments.
	 * @param int      $depth Depth of page.
	 *
	 * @return array
	 */
	protected function dt_get_item_classes( $item, $args, $depth ) {
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if (
			in_array( 'current-menu-item', $classes ) ||
			in_array( 'current-menu-parent', $classes ) ||
			in_array( 'current-menu-ancestor', $classes )
		) {
			$classes[] = 'act';
		}

		if ( $item->dt_is_first ) {
			$classes[] = 'first';
		}

		if ( $item->dt_is_parent ) {
			$classes[] = 'has-children';
		}

		$classes = apply_filters( 'presscore_nav_menu_css_class', $classes, $item, $args, $depth );

		return apply_filters( 'nav_menu_css_class', array_unique( $classes ), $item, $args, $depth );
	}
}
