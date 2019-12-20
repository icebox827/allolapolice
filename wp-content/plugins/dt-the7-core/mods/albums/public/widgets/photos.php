<?php
/**
 * Photos widget.
 *
 * @package presscore.
 * @since presscore 1.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Presscore_Inc_Widgets_Photos extends WP_Widget {

	/* Widget defaults */
	public static $widget_defaults = array( 
		'title'         => '',
		'order'     	=> 'DESC',
		'orderby'   	=> 'date',
		'select'        => 'all',
		'show'          => 6,
		'max_width'		=> 77,
		'cats'          => array(),
	);

	/* Widget setup  */
	function __construct() {  
		/* Widget settings. */
		$widget_ops = array( 'description' => _x( 'Photos', 'widget', 'dt-the7-core' ) );

		/* Create the widget. */
		parent::__construct(
			'presscore-photos',
			DT_WIDGET_PREFIX . _x( 'Photos', 'widget', 'dt-the7-core' ),
			$widget_ops
		);
	}

	/* Display the widget  */
	function widget( $args, $instance ) {

		static $number = 0;
		$number++;

		extract( $args );

		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );

		// get albums from selected categories
		$args = array(
			'no_found_rows'     => 1,
			'posts_per_page'    => -1,
			'post_type'         => 'dt_gallery',
			'post_status'       => 'publish',
			'suppress_filters'  => false,
			'tax_query'         => array( array(
				'taxonomy'      => 'dt_gallery_category',
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

		$attachments_ids_array = array();

		// get attachments id
		if ( $p_query->have_posts() ) {
			foreach( $p_query->posts as $album ) {

				// get saved data, hope it's array
				$attachments = get_post_meta( $album->ID, '_dt_album_media_items', true );

				if ( !$attachments ) continue;
				
				$attachments_ids_array = array_merge( $attachments_ids_array, (array) $attachments );
			}
		}

		$attachments_ids_array = array_unique($attachments_ids_array);

		$a_query = false;
		if ( $attachments_ids_array ) {

			if ( 'menu_order' == $instance['orderby'] ) {

				$instance['orderby'] = 'post__in';

				if ( 'DESC' == $instance['order'] ) {

					krsort($attachments_ids_array);
					$attachments_ids_array = array_values($attachments_ids_array);
				}

			}

			$a_query = new WP_Query( array(
				'posts_per_page'    => $instance['show'],
				'no_found_rows'     => 1,
				'post_type'         => 'attachment',
				'post_mime_type'    => 'image',
				'post_status'       => 'inherit',
				'post__in'			=> $attachments_ids_array,
				'order'				=> $instance['order'],
				'orderby'			=> $instance['orderby'],
				'suppress_filters'  => false,
			) );
		}

		echo $before_widget . "\n";

		// title
		if ( $title ) echo $before_title . $title . $after_title . "\n";

		if ( $a_query && $a_query->have_posts() ) {

			$share_buttons = presscore_get_share_buttons_for_prettyphoto( 'photo' );

			echo '<div class="instagram-photos dt-gallery-container"' . $share_buttons . ' data-image-max-width="' . absint( $instance['max_width'] ) . '">' . "\n";

			while ( $a_query->have_posts() ) { $a_query->the_post();

				$post_id = get_the_ID();
				$thumb_meta = wp_get_attachment_image_src( $post_id, 'full' );
				$thumb_title = presscore_image_title_enabled( $post_id ) ? get_the_title() : false;

				if ( empty( $thumb_meta[1] ) || empty( $thumb_meta[2] ) ) {
				    continue;
                }

				dt_get_thumb_img( array(
					'img_meta'        => $thumb_meta,
					'img_id'          => $post_id,
					'class'           => 'rollover rollover-small dt-pswp-item',
					'img_description' => get_the_content(),
					'title'           => $thumb_title,
					'options'         => array( 'w' => $instance['max_width'], 'h' => $instance['max_width'] ),
					'wrap'            => '<a %HREF% %CLASS% %TITLE% data-dt-img-description="%RAW_IMG_DESCRIPTION%" data-large_image_width="' . $thumb_meta[1] . '" data-large_image_height = "' . $thumb_meta[2] . '" data-dt-location="' . esc_attr( get_permalink( $post_id ) ) . '"><img %IMG_CLASS% %SRC% %ALT% %SIZE% /></a>',
				) );
			}
			wp_reset_postdata();

			echo '</div>' . "\n";

		} // if have posts

		echo $after_widget . "\n";
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']      = strip_tags($new_instance['title']);
		$instance['order']      = apply_filters('dt_sanitize_order', $new_instance['order']);
		$instance['orderby']    = apply_filters('dt_sanitize_orderby', $new_instance['orderby']);
		$instance['select']     = in_array( $new_instance['select'], array('all', 'only', 'except') ) ? $new_instance['select'] : self::$widget_defaults['select'];
		$instance['show']       = intval($new_instance['show']);
		if ( $instance['show'] < -1 || $instance['show'] == 0 ) {
			$instance['show'] = self::$widget_defaults['show'];
		}

		$instance['cats']       = (array) $new_instance['cats'];
		if ( empty($instance['cats']) ) {
			$instance['select'] = self::$widget_defaults['select'];
		}

		$instance['max_width'] = absint( $new_instance['max_width'] );

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

		$terms = get_terms( 'dt_gallery_category', array(
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
			<strong><?php _ex('Show Photos from following categories:', 'widget', 'dt-the7-core'); ?></strong><br />
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
			<label for="<?php echo $this->get_field_id( 'max_width' ); ?>"><?php _ex('Image max width (px):', 'widget', 'dt-the7-core'); ?></label>
			<input id="<?php echo $this->get_field_id( 'max_width' ); ?>" name="<?php echo $this->get_field_name( 'max_width' ); ?>" value="<?php echo esc_attr($instance['max_width']); ?>" size="3" maxlength="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _ex('How many:', 'widget', 'dt-the7-core'); ?></label>
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