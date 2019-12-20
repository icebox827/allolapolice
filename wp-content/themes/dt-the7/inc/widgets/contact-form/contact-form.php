<?php
/**
 * Contact form widget.
 *
 * @since 1.0.0
 *
 * @package The7
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'widgets_init', array( 'Presscore_Inc_Widgets_ContactForm', 'presscore_register_widget' ) );

class Presscore_Inc_Widgets_ContactForm extends WP_Widget {

	public static $widget_defaults = array(
		'title'     	=> '',
		'text'			=> '',
		'fields'    	=> array(),
		'send_to'		=> '',
		'msg_height'	=> 6,
		'button_size'	=> 'm',
		'button_title'	=> '',
        'terms'         => false,
        'terms_msg'     => '',
	);

	public static $fields_list = array();

	/**
	 * The7 ReCaptcha object.
	 *
	 * @var The7_ReCaptcha
	 */
	protected $captcha;

	/**
	 * Widget setup.
     */
	function __construct() {
		$widget_ops = array( 'description' => _x( 'Contact form', 'widget', 'the7mk2' ) );

		parent::__construct(
			'presscore-contact-form-widget',
			DT_WIDGET_PREFIX . _x( 'Contact form', 'widget', 'the7mk2' ),
			$widget_ops
		);

		self::$fields_list = array(
			'name'		=> array( 'title' => __( 'Name', 'the7mk2' ), 'defaults' => array( 'on' => true, 'required' => true ) ),
			'email'		=> array( 'title' => __( 'E-mail', 'the7mk2' ), 'defaults' => array( 'on' => true, 'required' => true ) ),
			'telephone'	=> array( 'title' => __( 'Telephone', 'the7mk2' ), 'defaults' => array( 'on' => false, 'required' => false ) ),
			'country'	=> array( 'title' => __( 'Country', 'the7mk2' ), 'defaults' => array( 'on' => false, 'required' => false ) ),
			'city'		=> array( 'title' => __( 'City', 'the7mk2' ), 'defaults' => array( 'on' => false, 'required' => false ) ),
			'company'	=> array( 'title' => __( 'Company', 'the7mk2' ), 'defaults' => array( 'on' => false, 'required' => false ) ),
			'website'	=> array( 'title' => __( 'Website', 'the7mk2' ), 'defaults' => array( 'on' => false, 'required' => false ) ),
			'message'	=> array( 'title' => __( 'Message', 'the7mk2' ), 'defaults' => array( 'on' => true, 'required' => false ) ),
		);

		self::$widget_defaults['terms_msg'] = _x( 'By using this form you agree with the storage and handling of your data by this website.', 'widget', 'the7mk2' );

		add_filter( 'dt_core_send_mail-to', array( $this, 'widget_send_to_email_filter' ), 20, 2 );

		$this->captcha = new The7_ReCaptcha();
	}

	/**
     * Output widget.
     *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {

		// enqueue script in footer
		$this->presscore_enqueue_scripts();

		static $number = 0;
		$number++;

		extract( $args );

		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
		$text = $instance['text'];
		$send_to = $instance['send_to'];
		$fields = $instance['fields'];
		$fields_not_empty = in_array(true, wp_list_pluck($fields, 'on') );
		$msg_height = $instance['msg_height'];

		$class_adapter = array(
			'email'	=> 'mail'
		);

		echo $before_widget ;

		// title
		if ( $title ) echo $before_title . $title . $after_title;

		// content
		if ( $text ) echo '<div class="widget-info">' . apply_filters('get_the_excerpt', $text) . '</div>';

		// fields
		if ( $fields_not_empty ) {

			$form_class = array(
				'dt-contact-form',
				'dt-form',
			);

			if ( $instance['terms'] ) {
			    $form_class[] = 'privacy-form';
            }
			$form_class = implode( ' ', $form_class );

			// form begin
			echo '<form class="'. esc_attr( $form_class ) . '" method="post">';

			echo '<input type="hidden" name="widget_id" value="' . $this->id . '" />';

			// some sort of bot check
			echo '<input type="hidden" name="send_message" value="" />';
			echo '<input type="hidden" name="security_token" value="' . esc_attr( of_get_option( 'contact_form_security_token' ) ) . '"/>';

			$fields_str = '';
			$message = '';

			// fields loop
			foreach ( $fields as $index=>$field ) {

				// if field disabled - continue
				if ( empty( $field['on'] ) ) {
					continue;
				}

				// if field not in reference array - continue
				// this check may be replased with array_intersect_key before loop
				if ( !isset(self::$fields_list[ $index ]) ) {
					continue;
				}

				// get field data from reference array ( title and default values )
				$field_data = self::$fields_list[ $index ];

				// init some handy variables
				$valid_class = '';
				$title = $field_data['title'];
				$name = $index;
				$required_str = 'false';
				$field_class = $index;

				// class adapter for some of fields
				if ( isset($class_adapter[ $index ]) ) $field_class = $class_adapter[ $index ];

				// do some stuff for required fields
				if ( $field['required'] ) {

					// add * to title )
					$title .= ' *';

					// some strange flag
					$required_str = 'true';

					// construct validation class for validationEngine
					$valid_params = array( 'required' );

					switch( $index ) {
						case 'email': $valid_params[] = 'custom[email]'; break;
						case 'telephone': $valid_params[] = 'custom[phone]'; break;
						case 'website': $valid_params[] = 'custom[url]'; break;
					}

					$valid_class = ' class="' . esc_attr( sprintf('validate[%s]', implode( ',', $valid_params ) ) ) . '"';
				}

				// escape some variables for output
				$title = esc_attr( $title );
				$name = esc_attr( $name );
				$required_str = esc_attr( $required_str );

				// textarea or input ?
				if ( 'message' != $index ) {

					$tmp_field = '<input type="text"' . $valid_class . ' placeholder="' . $title . '" name="' . $name . '" value="" aria-required="' . $required_str . '">' . "\n";

				} else {

					$tmp_field = '<textarea' . $valid_class . ' placeholder="' . $title . '" name="' . $name . '" rows="' . esc_attr( $msg_height ) . '" aria-required="' . $required_str . '"></textarea>' . "\n";

				}

				// end field output
				$tmp_field = sprintf(
					'<span class="form-%s"><label class="assistive-text">%s</label>%s</span>',
					esc_attr($field_class),
					// $name,
					$title,
					$tmp_field
				);

				if ( 'message' != $index ) {
					$fields_str .= $tmp_field;
				} else {
					$message = $tmp_field;
				}

			}

			if ( $fields_str ) {
				$fields_str = '<div class="form-fields">' . $fields_str . '</div>';
			}

			echo $fields_str . $message;

			if ( $this->captcha->is_active() ) {
				echo '<div class="the7-g-captcha"></div>';
			}

			if ( $instance['terms'] ) {
			    $terms_field_id = 'the7-form-terms-' . md5( (string) rand( 0, 9999 ) );
			    $terms_msg = $instance['terms_msg'] ? $instance['terms_msg'] : self::$widget_defaults['terms_msg'];
				printf(
				    '<p class="the7-form-terms-wrap"><input type="checkbox" id="%1$s" name="terms" class="validate[required] the7-form-terms" aria-required="true" />&nbsp;<label for="%1$s"><span class="form-terms-text">%2$s</span></label></p>',
                    $terms_field_id,
                    wp_kses_post( $terms_msg )
                );
			}

			$button_title = !empty($instance['button_title']) ? $instance['button_title'] : __( 'Submit', 'the7mk2' );

			// buttons
			echo '<p>';

			echo presscore_get_button_html( array(
				'href' => '#',
				'title' => esc_html( $button_title ),
				'class' => 'dt-btn dt-btn-' . esc_attr( $instance['button_size'] ) . ' dt-btn-submit',
				'atts' => ' rel="nofollow"'
			) );


			echo '<input class="assistive-text" type="submit" value="' . esc_attr( __( 'submit', 'the7mk2' ) ) . '">';

			echo '</p>';

			// form end
			echo '</form>' . "\n";
		}
		
		echo $after_widget;
	}

	/**
     * Update the widget settings.
     *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( $old_instance, self::$widget_defaults );

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = $new_instance['text'];

		$instance['send_to'] = $new_instance['send_to'];
		$instance['fields'] = self::presscore_sanitize_fields($new_instance['fields']);
		$instance['msg_height'] = absint( $new_instance['msg_height'] );

		$instance['button_size'] = in_array( $instance['button_size'], array( 's', 'm', 'l' ) ) ? $instance['button_size'] : self::$widget_defaults['button_size'];
		$instance['button_title'] = esc_html( $instance['button_title'] );

		$instance['terms'] = (bool) $new_instance['terms'];
		$terms_msg = $new_instance['terms_msg'] ? $new_instance['terms_msg'] : self::$widget_defaults['terms_msg'];
		$instance['terms_msg'] = wp_kses_post( $terms_msg );

		return $instance;
	}

	/**
     * Displays the widget settings controls on the widget panel.
     *
	 * @param array $instance
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$instance = wp_parse_args( (array) $instance, self::$widget_defaults );
		$fields = empty( $instance['fields'] ) ? array() : $instance['fields'];

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex('Title:', 'widget',  'the7mk2'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _ex('Text:', 'widget',  'the7mk2'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" rows="10" class="widefat" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_html($instance['text']); ?></textarea>
		</p>
		<h4><?php _ex('Fields:', 'widget', 'the7mk2'); ?></h4>
		<table style="width: 100%; text-align: left; line-height: 1.5">
            <tbody>
        <?php
		foreach ( self::$fields_list as $index=>$field ) :
			$value = isset( $fields[ $index ] ) ? $fields[ $index ] : array();
			$field_on = isset( $value['on'] ) ? $value['on'] : $field['defaults']['on'];
			$field_required = isset( $value['required'] ) ? $value['required'] : $field['defaults']['required'];
		?>
		<tr>
			<th><?php echo $field['title'] . ':'; ?></th>
			<td><label><input type="radio" name="<?php echo $this->get_field_name( 'fields' ) . "[$index]"; ?>[on]" value="1" <?php checked( $field_on ); ?> /><?php _ex('on', 'widget', 'the7mk2'); ?></label>
			<label><input type="radio" name="<?php echo $this->get_field_name( 'fields' ) . "[$index]"; ?>[on]" value="0" <?php checked( !$field_on ); ?> /><?php _ex('off', 'widget', 'the7mk2'); ?></label></td>
			<td><label><input type="checkbox" name="<?php echo $this->get_field_name( 'fields' ) . "[$index]"; ?>[required]" value="1" <?php checked($field_required); ?>/>&nbsp;<?php _ex('required', 'widget', 'the7mk2'); ?></label></td>
		</tr>
		<?php endforeach; ?>
            </tbody>
        </table>
        <p>
			<label for="<?php echo $this->get_field_id( 'terms' ); ?>"><?php _ex('Show privacy message', 'widget', 'the7mk2'); ?></label>&nbsp;<input type="checkbox" id="<?php echo $this->get_field_id( 'terms' ); ?>" name="<?php echo $this->get_field_name( 'terms' ); ?>" value="1" <?php checked( $instance['terms'] ) ?> onchange="the7ContactFormWidgetCheckTerms(this)"/>
		</p>
        <p class="the7-contact-form-widget-terms-msg-block" <?php echo $instance['terms'] ? '' : 'style="display: none;"' ?>>
            <label for="<?php echo $this->get_field_id( 'terms_msg' ); ?>"><?php _ex('Privacy message:', 'widget',  'the7mk2'); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'terms_msg' ); ?>" rows="5" class="widefat" name="<?php echo $this->get_field_name( 'terms_msg' ); ?>"><?php echo wp_kses_post($instance['terms_msg']); ?></textarea>
        </p>
		<p>
			<label><?php _ex('Message field height (in lines)', 'widget', 'the7mk2'); ?>&nbsp;<input type="text" name="<?php echo $this->get_field_name( 'msg_height' ); ?>" value="<?php echo esc_attr($instance['msg_height']); ?>" size="3"/></label>
		</p>
		<p>
			<label><?php _ex('Send mail to:', 'widget', 'the7mk2'); ?><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'send_to' ); ?>" value="<?php echo esc_attr($instance['send_to']); ?>"/></label>
		</p>
		<div style="clear: both;"></div>
	<?php
	}

	/**
	 * Enqueue scripts.
	 */
	function presscore_enqueue_scripts() {
		wp_register_script(
			'the7-form-validator',
			PRESSCORE_THEME_URI . '/js/atoms/plugins/validator/jquery.validationEngine.js',
			array( 'jquery' ),
			THE7_VERSION,
			true
		);
		$ve_locale = $this->_get_validator_locale();
		wp_register_script(
			'the7-form-validator-translation',
			PRESSCORE_THEME_URI . '/js/atoms/plugins/validator/languages/jquery.validationEngine-' . $ve_locale . '.js',
			array( 'the7-form-validator' ),
			THE7_VERSION,
			true
		);
		the7_register_script(
			'the7-contact-form',
			PRESSCORE_THEME_URI . '/js/dt-contact-form',
			array( 'the7-form-validator', 'the7-form-validator-translation' ),
			THE7_VERSION,
			true
		);
		wp_enqueue_script( 'the7-contact-form' );

		if ( $this->captcha->is_active() ) {
			$this->captcha->enqueue_scripts();
		}
	}

	function _get_validator_locale() {
	    $supported_locales = array(
		    'ca',
            'cs',
            'da',
            'de',
            'el',
            'en',
            'es',
            'et',
            'fa',
            'fi',
            'fr',
            'hr',
            'hu',
            'id',
            'it',
            'ja',
            'lt',
            'nb',
            'nl',
            'nn',
            'no',
            'pl',
            'pt',
            'pt_BR',
            'ro',
            'ru',
            'se',
            'sv',
            'tr',
            'vi',
            'zh_CN',
            'zh_TW',
        );

		$current_locale = get_locale();
		if ( ! in_array( $current_locale, array( 'pt_BR', 'zh_CN', 'zh_TW' ) ) ) {
			$current_locale = current( explode( '_', $current_locale ) );
		}

		if ( ! in_array( $current_locale, $supported_locales ) ) {
			$current_locale = 'en';
        }

		return $current_locale;
    }

	/**
	 * Filter send_to mail attribute.
	 *
	 * @param string $em      Default email.
	 * @param array  $request Request arguments array.
	 *
	 * @return string
	 */
	public function widget_send_to_email_filter( $em = '', $request = array() ) {
		if ( ! empty( $request['widget_id'] ) ) {
			$widget_id = str_replace( "{$this->id_base}-", '', $request['widget_id'] );
			$option = get_option( $this->option_name );
			if ( isset( $option[ $widget_id ] ) && ! empty( $option[ $widget_id ]['send_to'] ) ) {
				return $option[ $widget_id ]['send_to'];
			}
		}

		return $em;
	}

	/**
     * Sanitize widget fields.
     *
	 * @param array $fields
	 *
	 * @return array
	 */
	public static function presscore_sanitize_fields( $fields = array() ) {

		// clear fields
		$fields = array_intersect_key($fields, self::$fields_list);

		// sanitize data
		foreach ( $fields as &$field ) {
			$field['on'] = (bool) absint($field['on']);
			$field['required'] = isset( $field['required'] );
		}

		return $fields;
	}

	/**
	 * Register widget.
	 */
	public static function presscore_register_widget() {
		register_widget( get_class() );
	}
}
