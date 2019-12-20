<?php
/**
 * Custom menu style 1 widget.
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
add_action( 'widgets_init', array( 'Presscore_Inc_Widgets_CustomMenu1', 'presscore_register_widget' ) );

class Presscore_Inc_Widgets_CustomMenu1 extends WP_Widget {
    
    /* Widget defaults */
    public static $widget_defaults = array( 
		'title'     	=> '',
		'menu'			=> '',
        'divider'       => true,
        'bold_text'     => false,
        'show_arrow'    => true
    );

	/* Widget setup  */
	function __construct() {  
        /* Widget settings. */
		$widget_ops = array( 'description' => _x( 'Custom menu style 1', 'widget', 'the7mk2' ) );

		/* Create the widget. */
        parent::__construct(
            'presscore-custom-menu-one',
            DT_WIDGET_PREFIX . _x( 'Custom menu style 1', 'widget', 'the7mk2' ),
            $widget_ops
        );
	}

	/* Display the widget  */
	function widget( $args, $instance ) {
		extract( $args );

        $instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		// Get menu
		$nav_menu = ! empty( $instance['menu'] ) ? wp_get_nav_menu_object( $instance['menu'] ) : false;

		if ( !$nav_menu )
			return;

		$menu_args = array(
			'menu'					=> $nav_menu,
	        'container'			    => false,
	        'menu_id' 			    => false,
	        'fallback_cb' 		    => '',
	        'menu_class' 		    => false,
	        'container_class'	    => false,
	        'dt_item_wrap_start'    => '<li class="%ITEM_CLASS%"><a href="%ITEM_HREF%">%ITEM_TITLE%</a>',
	        'dt_item_wrap_end'      => '</li>',
	        'dt_submenu_wrap_start' => '<ul>',
	        'dt_submenu_wrap_end'   => '</ul>',
	        'items_wrap'            => '<ul class="custom-menu' . ( $instance['divider'] ? ' dividers-on' : '' ) . ( $instance['bold_text'] ? ' enable-bold' : '' ) .( $instance['show_arrow'] ? ' show-arrow' : '' ) .'">%3$s</ul>',
	        'walker'				=> new Dt_Inc_Classes_WidgetsCustomMenu_Walker()
	    );

		echo $before_widget ;

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );

		// title
		if ( $title ) echo $before_title . $title . $after_title;

		wp_nav_menu( $menu_args );

		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
        $instance['menu'] = $new_instance['menu'];
		$instance['divider'] = isset( $new_instance['divider'] );
		$instance['bold_text'] = isset( $new_instance['bold_text'] );
		$instance['show_arrow'] = isset( $new_instance['show_arrow'] );

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

		<p>
			<label for="<?php echo $this->get_field_id( 'divider' ); ?>"><?php _ex('Show dividers', 'widget', 'the7mk2'); ?></label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'divider' ); ?>" name="<?php echo $this->get_field_name( 'divider' ); ?>" value="1" <?php checked( $instance['divider'] ); ?> />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'bold_text' ); ?>"><?php _ex('Bold text', 'widget', 'the7mk2'); ?></label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'bold_text' ); ?>" name="<?php echo $this->get_field_name( 'bold_text' ); ?>" value="1" <?php checked( $instance['bold_text'] ); ?> />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_arrow' ); ?>"><?php _ex('Show decorative arrows', 'widget', 'the7mk2'); ?></label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_arrow' ); ?>" name="<?php echo $this->get_field_name( 'show_arrow' ); ?>" value="1" <?php checked( $instance['show_arrow'] ); ?> />
		</p>

		<div style="clear: both;"></div>
	<?php
	}

	public static function presscore_register_widget() {
		register_widget( __CLASS__ );
	}
}
