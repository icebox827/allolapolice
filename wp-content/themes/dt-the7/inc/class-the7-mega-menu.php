<?php
/**
 * The7 mega menu front class.
 *
 * @since   3.0.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Mega_Menu
 */
class The7_Mega_Menu {

	/**
	 * Columns for second menu level.
	 *
	 * @var int
	 */
	protected $columns = 3;

	/**
	 * Is mega menu enabled.
	 *
	 * @var bool
	 */
	protected $mega_menu_enabled = false;

	/**
	 * Add mega menu hooks.
	 */
	public function add_hooks() {
		add_action( 'presscore_nav_menu_start_el', array( $this, 'detect_mega_menu_action' ), 10, 3 );
		add_filter( 'presscore_nav_menu_css_class', array( $this, 'mega_menu_class_filter' ), 10, 4 );
		add_filter( 'presscore_nav_menu_el_before', array( $this, 'append_columns' ), 10, 4 );
		add_filter( 'presscore_nav_menu_start_lvl', array( $this, 'start_row' ), 10, 2 );
		add_filter( 'presscore_nav_menu_end_lvl', array( $this, 'end_row' ), 10, 2 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'append_widgets' ), 10, 2 );
		add_filter( 'presscore_nav_menu_item', array( $this, 'menu_item' ), 10, 5 );
	}

	/**
	 * Remove mega menu hooks.
	 */
	public function remove_hooks() {
		remove_action( 'presscore_nav_menu_start_el', array( $this, 'detect_mega_menu_action' ) );
		remove_filter( 'presscore_nav_menu_css_class', array( $this, 'mega_menu_class_filter' ) );
		remove_filter( 'presscore_nav_menu_el_before', array( $this, 'append_columns' ) );
		remove_filter( 'presscore_nav_menu_start_lvl', array( $this, 'start_row' ) );
		remove_filter( 'presscore_nav_menu_end_lvl', array( $this, 'end_row' ) );
		remove_filter( 'walker_nav_menu_start_el', array( $this, 'append_widgets' ) );
		remove_filter( 'presscore_nav_menu_item', array( $this, 'menu_item' ) );
	}

	/**
	 * Filter menu item. Add icon/image.
	 *
	 * @param string  $menu_item   Menu item code.
	 * @param string  $title       Menu item title.
	 * @param string  $description Menu item description.
	 * @param WP_Post $item        Menu item data object.
	 * @param int     $depth       Menu item depth.
	 *
	 * @return string
	 */
	public function menu_item( $menu_item, $title, $description, $item, $depth ) {
		if ( $menu_item ) {
			return $menu_item;
		}

		$icon = $this->dt_get_item_icon( $item );
		if ( isset( $item->the7_mega_menu['menu-item-image-position'], $item->the7_mega_menu['menu-item-icon-type'] ) && in_array( $item->the7_mega_menu['menu-item-icon-type'], array( 'image', 'icon' ), true ) && in_array( $item->the7_mega_menu['menu-item-image-position'], array( 'right_top', 'left_top' ), true ) ) {
			$menu_item = '<span class="menu-item-text">' . $icon . '<span class="menu-text">' . $title . '</span></span>' . $description;
		} else {
			$menu_item = $icon . '<span class="menu-item-text"><span class="menu-text">' . $title . '</span>' . $description . '</span>';
		}

		return $menu_item;
	}

	/**
	 * Early mega menu setup.
	 *
	 * Find out if mega menu enabled, set second level columns, is current item clickable.
	 *
	 * @param WP_Post  $item   Menu item data object.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $depth  Depth of menu item.
	 */
	public function detect_mega_menu_action( $item, $args, $depth ) {
		if ( 0 === $depth ) {
			if ( isset( $item->the7_mega_menu['mega-menu'] ) && $item->the7_mega_menu['mega-menu'] === 'on' ) {
				$this->mega_menu_enabled = true;
				$this->columns           = ( isset( $item->the7_mega_menu['mega-menu-columns'] ) ? (int) $item->the7_mega_menu['mega-menu-columns'] : 3 );
			} else {
				$this->mega_menu_enabled = false;
				$this->columns           = 3;
			}
		} elseif ( $this->mega_menu_enabled ) {
			// If mega menu enabled.
			if ( 1 === $depth ) {
				// Only items with $depth = 1 have ability to remove a link.
				$item->dt_is_clickable = empty( $item->the7_mega_menu['mega-menu-remove-link'] ) || $item->the7_mega_menu['mega-menu-remove-link'] === 'off';
			} else {
				// Items with $depth > 1 are clickable dy default.
				$item->dt_is_clickable = true;
			}
			if ( ! empty( $item->the7_mega_menu['mega-menu-widgets'] ) && $item->the7_mega_menu['mega-menu-widgets'] !== 'none' ) {
				$item->dt_is_parent = true;
			}
		}
	}

	/**
	 * Setup menu item classes.
	 *
	 * @param array    $classes Menu item classes.
	 * @param WP_Post  $item    Menu item data object.
	 * @param stdClass $args    An object of wp_nav_menu() arguments.
	 * @param int      $depth   Depth of menu item.
	 *
	 * @return array
	 */
	public function mega_menu_class_filter( $classes, $item, $args, $depth ) {
		if ( $this->mega_menu_enabled ) {

			if ( 0 === $depth ) {

				$classes[] = 'dt-mega-menu';

				if ( isset( $item->the7_mega_menu['mega-menu-fullwidth'] ) && $item->the7_mega_menu['mega-menu-fullwidth'] === 'on' ) {
					$classes[] = 'mega-full-width';
				} else {
					$classes[] = 'mega-auto-width';
				}

				if ( ! empty( $item->the7_mega_menu['mega-menu-columns'] ) ) {
					$classes[] = 'mega-column-' . (int) $item->the7_mega_menu['mega-menu-columns'];
				}
			} elseif ( 1 === $depth ) {

				if ( isset( $item->the7_mega_menu['mega-menu-hide-title'] ) && $item->the7_mega_menu['mega-menu-hide-title'] === 'on' ) {
					$classes[] = 'hide-mega-title';
					if ( ! isset( $item->the7_mega_menu['menu-item-icon-type'] ) || $item->the7_mega_menu['menu-item-icon-type'] === 'none' ) {
						$classes[] = 'empty-title';
					}
				}

				$classes[] = 'no-link';
				$classes[] = 'dt-mega-parent';
				$classes[] = $this->get_column_class( $this->columns );

				if ( isset( $item->the7_mega_menu['mega-menu-start-new-row'] ) && $item->the7_mega_menu['mega-menu-start-new-row'] === 'on' ) {
					$classes[] = 'new-row';
				}
			}

			if ( $item->description ) {
				$classes[] = 'with-subtitle';
			}
		}

		return $classes;
	}

	/**
	 * Append row wrap open tag to $output if mega menu enabled.
	 *
	 * @param string $output Menu item html.
	 * @param int    $depth  Depth of menu item.
	 *
	 * @return string
	 */
	public function start_row( $output, $depth ) {
		if ( 0 === $depth && $this->mega_menu_enabled ) {
			$output = '<div class="dt-mega-menu-wrap">' . $output;
		}

		return $output;
	}

	/**
	 * Append row wrap close tag to $output if mega menu enabled.
	 *
	 * @param string $output Menu item html.
	 * @param int    $depth  Depth of menu item.
	 *
	 * @return string
	 */
	public function end_row( $output, $depth ) {
		if ( 0 === $depth && $this->mega_menu_enabled ) {
			$output .= '</div>';
		}

		return $output;
	}

	/**
	 * Append columns HTML.
	 *
	 * @param string   $before HTML that will be output before menu item.
	 * @param WP_Post  $item   Menu item data object.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $depth  Depth of menu item.
	 *
	 * @return string
	 */
	public function append_columns( $before, $item, $args, $depth ) {
		if ( $this->mega_menu_enabled ) {

			if ( 1 === $depth && isset( $item->the7_mega_menu['mega-menu-start-new-row'] ) && $item->the7_mega_menu['mega-menu-start-new-row'] === 'on' ) {
				$args->walker->end_lvl( $before, $depth, $args );
				$args->walker->start_lvl( $before, $depth, $args );
			} elseif ( 2 === $depth && isset( $item->the7_mega_menu['mega-menu-start-new-column'] ) && $item->the7_mega_menu['mega-menu-start-new-column'] === 'on' ) {
				$fake_column_classes   = array(
					'menu-item',
					'menu-item-has-children',
					'dt-mega-parent',
					'has-children',
					'new-column',
				);
				$fake_column_classes[] = $this->get_column_class( $this->columns );

				if ( isset( $item->the7_mega_menu['mega-menu-hide-title'] ) && $item->the7_mega_menu['mega-menu-hide-title'] === 'on' ) {
					$fake_column_classes[] = 'hide-mega-title';
					if ( ! isset( $item->the7_mega_menu['menu-item-icon-type'] ) || $item->the7_mega_menu['menu-item-icon-type'] === 'none' ) {
						$classes[] = 'empty-title';
					}
				}

				$args->walker->end_lvl( $before, $depth - 1, $args );
				$args->walker->end_el( $before, $item, $depth - 1, $args );

				$before .= '<li class="' . implode( ' ', array_filter( $fake_column_classes ) ) . '">';

				$args->walker->start_lvl( $before, $depth - 1, $args );
			}
		}

		return $before;
	}

	/**
	 * Append widgets based on mega menu settings.
	 *
	 * @param string  $item_html Item HTML.
	 * @param WP_Post $item      Menu item data object.
	 *
	 * @return string
	 */
	public function append_widgets( $item_html, $item ) {
		if ( $this->mega_menu_enabled && ! empty( $item->the7_mega_menu['mega-menu-widgets'] ) && $item->the7_mega_menu['mega-menu-widgets'] !== 'none' ) {
			ob_start();
			echo '<ul class="sub-nav sub-nav-widgets"><li><div class="mega-menu-widgets sidebar-content">';
			dynamic_sidebar( $item->the7_mega_menu['mega-menu-widgets'] );
			echo '</div></li></ul>';
			$item_html .= ob_get_clean();
		}

		return $item_html;
	}

	/**
	 * Return column class based on $col arg. Supports 5 columns layout maximum.
	 *
	 * @param int $col Columns.
	 *
	 * @return string
	 */
	protected function get_column_class( $col ) {
		$columns_classes = array(
			1 => 'wf-1',
			2 => 'wf-1-2',
			3 => 'wf-1-3',
			4 => 'wf-1-4',
			5 => 'wf-1-5',
		);

		return isset( $columns_classes[ $col ] ) ? $columns_classes[ $col ] : '';
	}

	/**
	 * Return menu item icon if any.
	 *
	 * @param WP_Post $item Page data object.
	 *
	 * @return string
	 */
	protected function dt_get_item_icon( $item ) {
		$image_html = '';

		if ( isset( $item->the7_mega_menu['menu-item-icon-type'] ) ) {
			switch ( $item->the7_mega_menu['menu-item-icon-type'] ) {
				case 'html':
					$image_html = $item->the7_mega_menu['menu-item-icon-html'];
					break;
				case 'icon':
					$inline_style = $this->dt_get_icon_padding_inline_style( $item );
					if ( $inline_style ) {
						$inline_style = ' style="' . esc_attr( $inline_style ) . '"';
					}
					$image_html = '<i class="' . esc_attr( $item->the7_mega_menu['menu-item-icon'] ) . '"' . $inline_style . '></i>';
					break;
				case 'image':
					if ( empty( $item->the7_mega_menu['menu-item-image'][1] ) ) {
						break;
					}
					$image_style = '';
					$width       = 1;
					$height      = 1;
					if ( isset( $item->the7_mega_menu['menu-item-image-size'] ) ) {
						$size_option_value = (array) The7_Option_Field_Spacing::decode( $item->the7_mega_menu['menu-item-image-size'] );
						if ( count( $size_option_value ) === 2 ) {
							list( $width, $height ) = array_map( 'absint', wp_list_pluck( $size_option_value, 'val' ) );
						}
					}
					if ( isset( $item->the7_mega_menu['menu-item-image-border-radius'] ) ) {
						$image_style .= 'border-radius: ' . $item->the7_mega_menu['menu-item-image-border-radius'] . ';';
					}
					$image_style .= $this->dt_get_icon_padding_inline_style( $item );

					$image_html = dt_get_thumb_img(
						array(
							'class'   => 'rollover',
							'img_id'  => $item->the7_mega_menu['menu-item-image'][1],
							'alt'     => 'Menu icon',
							'options' => array(
								'w' => $width,
								'h' => $height,
							),
							'wrap'    => '<img %IMG_CLASS% %SRC% %ALT% %SIZE% %CUSTOM% />',
							'custom'  => 'style="' . esc_attr( $image_style ) . '"',
							'echo'    => false,
						)
					);
					break;
			}
		}

		return $image_html;
	}

	/**
	 * Return menu item padding inline style.
	 *
	 * @param WP_Post $item Page data object.
	 *
	 * @return string
	 */
	protected function dt_get_icon_padding_inline_style( $item ) {
		$style = '';
		if ( isset( $item->the7_mega_menu['menu-item-image-padding'] ) ) {
			$padding_option_value = The7_Option_Field_Spacing::decode( $item->the7_mega_menu['menu-item-image-padding'] );
			if ( $padding_option_value ) {
				$padding_style = '';
				foreach ( $padding_option_value as $padding ) {
					$padding_style .= "{$padding['val']}{$padding['units']} ";
				}
				$style = 'margin: ' . trim( $padding_style ) . ';';
			}
		}

		return $style;
	}
}
