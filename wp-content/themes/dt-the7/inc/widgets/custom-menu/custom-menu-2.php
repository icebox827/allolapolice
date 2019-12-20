<?php
/**
 * Custom menu style 2 widget.
 *
 * @package presscore.
 * @since presscore 1.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Dt_Inc_Classes_WidgetsCustomMenu_Walker', false ) ) {
	require_once 'widgets-custom-menu.class.php';
}

/* Load the widget */
add_action( 'widgets_init', array( 'Presscore_Inc_Widgets_CustomMenu2', 'presscore_register_widget' ) );

class Presscore_Inc_Widgets_CustomMenu2 extends WP_Widget {
	
	/* Widget defaults */
	public static $widget_defaults = array( 
		'title'     	=> '',
		'menu'			=> '',
	);

	/* Widget setup  */
	function __construct() {  
		/* Widget settings. */
		$widget_ops = array( 'description' => _x( 'Custom menu style 2', 'widget', 'the7mk2' ) );

		/* Create the widget. */
		parent::__construct(
			'presscore-custom-menu-two',
			DT_WIDGET_PREFIX . _x( 'Custom menu style 2', 'widget', 'the7mk2' ),
			$widget_ops
		);
	}

	/* Display the widget  */
	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );

		// Get menu
		$nav_menu = ! empty( $instance['menu'] ) ? wp_get_nav_menu_object( $instance['menu'] ) : false;

		if ( !$nav_menu )
			return;

		$args = array(
			'menu'					=> $nav_menu,
			'container'			    => false,
			'menu_id' 			    => false,
			'fallback_cb' 		    => '',
			'menu_class' 		    => false,
			'container_class'	    => false,
			'dt_item_wrap_start'    => '<li class="%ITEM_CLASS%"><a href="%ITEM_HREF%"><span>%ITEM_TITLE%</span></a>',
			'dt_item_wrap_end'      => '</li>',
			'dt_submenu_wrap_start' => '<ul class="custom-menu">',
			'dt_submenu_wrap_end'   => '</ul>',
			'items_wrap'            => '<ul class="custom-nav">%3$s</ul>',
			'walker'				=> new Dt_Inc_Classes_WidgetsCustomMenu_Walker()
		);

		$before_widget = str_replace('widget_presscore-custom-menu-2', 'widget_presscore-custom-menu-2 widget-custom-nav' , $before_widget);

		echo $before_widget ;

		// title
		if ( $title ) echo $before_title . $title . $after_title;

		wp_nav_menu( $args );	

		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['menu'] = $new_instance['menu'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex('Title:', 'widget',  'the7mk2'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'menu' ); ?>"><?php _ex('Choose custom menu:', 'widget',  'the7mk2'); ?></label>
			<select id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>">
		<?php
			foreach ( $menus as $menu ) {
				echo '<option value="' . $menu->term_id . '"'
					. selected( $instance['menu'], $menu->term_id, false )
					. '>'. $menu->name . '</option>';
			}
		?>
			</select>
		</p>

		<div style="clear: both;"></div>
	<?php
	}

	public static function presscore_register_widget() {
		register_widget( __CLASS__ );
	}
}
