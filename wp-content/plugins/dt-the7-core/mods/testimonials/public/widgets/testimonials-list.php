<?php
/**
 * Testimonials list widget.
 *
 * @package presscore.
 * @since presscore 1.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Presscore_Inc_Widgets_TestimonialsList extends WP_Widget {

	/* Widget defaults */
	public static $widget_defaults = array( 
		'title'         => '',
		'order'     	=> 'DESC',
		'orderby'   	=> 'date',
		'select'        => 'all',
		'show_avatar' => '1',
		'show'          => 6,
		'cats'          => array(),
	);

	/* Widget setup  */
	function __construct() {  
		/* Widget settings. */
		$widget_ops = array( 'description' => _x( 'Testimonials list', 'widget', 'dt-the7-core' ) );

		/* Create the widget. */
		parent::__construct(
			'presscore-testimonials-list',
			DT_WIDGET_PREFIX . _x( 'Testimonials list', 'widget', 'dt-the7-core' ),
			$widget_ops
		);
	}

	/* Display the widget  */
	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );

		$args = array(
			'no_found_rows'     => 1,
			'posts_per_page'    => $instance['show'],
			'post_type'         => 'dt_testimonials',
			'post_status'       => 'publish',
			'orderby'           => $instance['orderby'],
			'order'             => $instance['order'],
			'suppress_filters'  => false,
			'tax_query'         => array( array(
				'taxonomy'      => 'dt_testimonials_category',
				'field'         => 'term_id',
				'terms'         => $instance['cats']
			) ),
		);

		switch( $instance['select'] ) {
			case 'only': $args['tax_query'][0]['operator'] = 'IN'; break;
			case 'except': $args['tax_query'][0]['operator'] = 'NOT IN'; break;
			default: unset( $args['tax_query'] );
		}

		$p_query = new WP_Query( $args ); 

		echo $before_widget ;

		// title
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( $p_query->have_posts() ) {

			echo '<div class="testimonials list-view">', "\n", '<ul>', "\n";

			$config = Presscore_Config::get_instance();
			$config_backup = $config->get();
			$this->setup_config( $instance );

			while( $p_query->have_posts() ) { $p_query->the_post();

				echo '<li>';
					presscore_get_template_part( 'mod_testimonials', 'testimonials-post' );
				echo '</li>';

			} // while have posts
			wp_reset_postdata();
			$config->reset( $config_backup );

			echo '</ul>', "\n", '</div>', "\n";

		} // if have posts

		echo $after_widget;
	}
	protected function setup_config( $instance = array() ) {
		$config = presscore_get_config();

		$config->set( 'show_avatar', $instance['show_avatar'] );
	}
	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['show_avatar'] = array_key_exists( 'show_avatar', $new_instance ) ? 1 : 0;
		$instance['title']      = strip_tags($new_instance['title']);
		$instance['order']      = apply_filters('dt_sanitize_order', $new_instance['order']);
		$instance['orderby']    = apply_filters('dt_sanitize_orderby', $new_instance['orderby']);
		$instance['select']     = in_array( $new_instance['select'], array('all', 'only', 'except') ) ? $new_instance['select'] : 'all';
		$instance['show']       = intval($new_instance['show']);
		$instance['cats']       = (array) $new_instance['cats'];

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

		$terms = get_terms( 'dt_testimonials_category', array(
			'hide_empty'    => 1,
			'hierarchical'  => false 
		) );

		$orderby_list = array(
			'ID'        => _x( 'Order by ID', 'widget', 'dt-the7-core' ),
			'author'    => _x( 'Order by author', 'widget', 'dt-the7-core' ),
			'title'     => _x( 'Order by title', 'widget', 'dt-the7-core' ),
			'date'      => _x( 'Order by date', 'widget', 'dt-the7-core' ),
			'modified'  => _x( 'Order by modified', 'widget', 'dt-the7-core' ),
			'rand'      => _x( 'Order by rand', 'widget', 'dt-the7-core' ),
			'menu_order'=> _x( 'Order by menu', 'widget', 'dt-the7-core' )
		);

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex('Title:', 'widget',  'dt-the7-core'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<p>
			<strong><?php _ex('Category:', 'widget', 'dt-the7-core'); ?></strong><br />
			<?php if( !is_wp_error($terms) ): ?>

				<div class="dt-widget-switcher">

					<label><input type="radio" name="<?php echo $this->get_field_name( 'select' ); ?>" value="all" <?php checked($instance['select'], 'all'); ?> /><?php _ex('All', 'widget', 'dt-the7-core'); ?></label>
					<label><input type="radio" name="<?php echo $this->get_field_name( 'select' ); ?>" value="only" <?php checked($instance['select'], 'only'); ?> /><?php _ex('Only', 'widget', 'dt-the7-core'); ?></label>
					<label><input type="radio" name="<?php echo $this->get_field_name( 'select' ); ?>" value="except" <?php checked($instance['select'], 'except'); ?> /><?php _ex('Except', 'widget', 'dt-the7-core'); ?></label>

				</div>

				<div class="hide-if-js">

					<?php foreach( $terms as $term ): ?>

					<input id="<?php echo $this->get_field_id($term->term_id); ?>" type="checkbox" name="<?php echo $this->get_field_name('cats'); ?>[]" value="<?php echo $term->term_id; ?>" <?php checked( in_array($term->term_id, $instance['cats']) ); ?> />
					<label for="<?php echo $this->get_field_id($term->term_id); ?>"><?php echo $term->name; ?></label><br />

					<?php endforeach; ?>

				</div>

			<?php endif; ?>

		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_avatar' ); ?>"><?php echo _ex('Show image:', 'widget',  'dt-the7-core'); ?></label>
			<input id="<?php echo $this->get_field_id( 'show_avatar' ); ?>" type="checkbox" name="<?php echo $this->get_field_name('show_avatar'); ?>[]" value="1" <?php checked( $instance['show_avatar'] ); ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _ex('Number of testimonials:', 'widget', 'dt-the7-core'); ?></label>
			<input id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo esc_attr($instance['show']); ?>" size="2" maxlength="2" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _ex('Sort by:', 'widget', 'dt-the7-core'); ?></label>
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
				<?php foreach( $orderby_list as $value=>$name ): ?>
				<option value="<?php echo $value; ?>" <?php selected( $instance['orderby'], $value ); ?>><?php echo $name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		</p>
			<label>
			<input name="<?php echo $this->get_field_name( 'order' ); ?>" value="ASC" type="radio" <?php checked( $instance['order'], 'ASC' ); ?> /><?php _ex('Ascending', 'widget', 'dt-the7-core'); ?>
			</label>
			<label>
			<input name="<?php echo $this->get_field_name( 'order' ); ?>" value="DESC" type="radio" <?php checked( $instance['order'], 'DESC' ); ?> /><?php _ex('Descending', 'widget', 'dt-the7-core'); ?>
			</label>
		</p>

		<div style="clear: both;"></div>
	<?php
	}
}