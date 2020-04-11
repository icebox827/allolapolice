<?php
/**
 * Contact info widget.
 *
 * @package presscore.
 * @since presscore 1.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Load the widget */
add_action( 'widgets_init', array( 'Presscore_Inc_Widgets_ContactInfo', 'presscore_register_widget' ) );

class Presscore_Inc_Widgets_ContactInfo extends WP_Widget {

	/* Widget defaults */
	public static $widget_defaults = array( 
		'title'     => '',
		'text'		=> '',
		'links'     => array(),
		'fields'    => array(),
	);

	public static $social_icons = array();

	/* Widget setup  */
	function __construct() {  
		/* Widget settings. */
		$widget_ops = array( 'description' => _x( 'Contact info', 'widget', 'the7mk2' ) );

		/* Create the widget. */
		parent::__construct(
			'presscore-contact-info-widget',
			DT_WIDGET_PREFIX . _x( 'Contact info', 'widget', 'the7mk2' ),
			$widget_ops
		);

		if ( function_exists('presscore_get_social_icons_data') ) {
			self::$social_icons = presscore_get_social_icons_data();
		}
	}

	/* Display the widget  */
	function widget( $args, $instance ) {

		extract( $args );

		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$text = $instance['text'];
		$links = $instance['links'];
		$fields = $instance['fields'];

		echo $before_widget ;

		// title
		if ( $title ) echo $before_title . $title . $after_title;

		$simulated_text_widget_instance = array_merge( $instance, array(
			'filter' => false, // Because wpautop is not applied.
			'visual' => false, // Because it wasn't created in TinyMCE.
		) );
		$text = apply_filters( 'widget_text', $text, $simulated_text_widget_instance );

		// content
		if ( $text ) {
			echo '<div class="widget-info">' . $text . '</div>';
		}

		// fields
		if ( !empty($fields) ) {

			echo '<ul class="contact-info">';

			foreach ( $fields as $field ) {

				echo '<li>';

				if ( !empty($field['title']) ) echo '<span class="color-primary">' . $field['title'] . '</span><br />';

				if ( !empty($field['content']) ) echo $field['content'];

				echo '</li>';

			}

			echo '</ul>';

		}

		// social links
		if ( !empty($links) && implode('', (array)$links) ) {

			echo '<div class="soc-ico"><p class="assistive-text">' . __( 'Find us on:', 'the7mk2' ) . '</p>';

			foreach ( $links as $class => $link ) {
				if ( ! $link || ! array_key_exists( $class, self::$social_icons ) ) {
					continue;
				}

				// translators: %s : icon name
				$icon_title = sprintf( __( '%s page opens in new window', 'the7mk2' ), self::$social_icons[ $class ] );

				echo presscore_get_social_icon( $class, $link, $icon_title );
			}

			echo '</div>';

		}

		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['text'] = $new_instance['text'];
		$instance['links'] = array();
		if ( ! empty( $new_instance['links'] ) && is_array( $new_instance['links'] ) ) {
			$instance['links'] = array_filter( array_map( 'trim', $new_instance['links'] ) );
        }
		$instance['fields'] = isset( $new_instance['fields'] ) ? $new_instance['fields'] : array();

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
		$links = empty( $instance['links'] ) ? array() : $instance['links'];
		$fields = empty( $instance['fields'] ) ? array() : $instance['fields'];

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex('Title:', 'widget',  'the7mk2'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _ex('Text:', 'widget',  'the7mk2'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" rows="10" class="widefat" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea($instance['text']); ?></textarea>
		</p>

		<h4><?php _ex('Fields:', 'widget', 'the7mk2'); ?></h4>

		<div class="dt-widget-sortable-container">
			<ul class="dt-widget-sortable ui-sortable">

				<?php foreach ( $fields as $index=>$field ) : ?>

				<li class="ui-state-default" data-index="<?php echo $index; ?>">
					<a href="javascript:void(0);" class="dt-widget-sortable-remove"></a>
					<input type="text" name="<?php echo $this->get_field_name( 'fields' ) . "[$index]"; ?>[title]" placeholder="<?php echo esc_attr( __( 'Title', 'the7mk2' ) ); ?>" value="<?php echo esc_attr( $field['title'] ); ?>" /><br />
					<textarea class="widefat" name="<?php echo $this->get_field_name( 'fields' ) . "[$index]"; ?>[content]" placeholder="<?php echo esc_attr( __( 'Content', 'the7mk2' ) ); ?>"><?php echo esc_textarea( $field['content'] ); ?></textarea>
				</li>

			<?php endforeach; ?>

			</ul>
			<a href="javascript:void(0);" class="dt-widget-sortable-add" data-fields-name="<?php echo $this->get_field_name( 'fields' ); ?>" data-field-type="contact-info"><?php _ex( 'Add', 'widget', 'the7mk2' ); ?></a>
		</div>

		<p>
			<h4><?php _ex('Social links:', 'widget', 'the7mk2'); ?></h4>

			<?php foreach ( self::$social_icons as $class=>$title ) : $val = isset($links[ $class ]) ? esc_attr($links[ $class ]) : ''; ?>

				<label><?php echo $title . ':'; ?><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'links' ) . '[' . esc_attr($class) . ']'; ?>" value="<?php echo $val; ?>" /></label><br /><br />

			<?php endforeach; ?>

		</p>

		<div style="clear: both;"></div>
	<?php
	}

	public static function presscore_register_widget() {
		register_widget( get_class() );
		add_action( 'admin_footer', array(__CLASS__, 'presscore_admin_add_widget_templates') );
	}

	/**
	 * Add template for widget.
	 */
	public static function presscore_admin_add_widget_templates() {
		if ( 'widgets.php' != $GLOBALS['hook_suffix'] ) {
			return;
		}
		?>
		<script type="text/html" id="tmpl-dt-widget-contact-info-field">
			<li class="ui-state-default" data-index="{{ data.nextIndex }}">
				<a href="javascript:void(0);" class="dt-widget-sortable-remove"></a>
				<input type="text" name="{{ data.fieldsName }}[{{ data.nextIndex }}][title]" placeholder="{{ data.title }}" value="" /><br />
				<textarea class="widefat" name="{{ data.fieldsName }}[{{ data.nextIndex }}][content]" placeholder="{{ data.content }}"></textarea>
			</li>
		</script>
		<?php
	}

}
