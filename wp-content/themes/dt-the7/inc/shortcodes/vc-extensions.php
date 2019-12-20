<?php
/**
 * Visual Composer extensions.
 *
 */

/**
 * Class The7_Inc_Shortcodes_VCParams adds custom params vor VC shortcodes interface.
 */
class The7_Inc_Shortcodes_VCParams {

	/**
	 * The7_Inc_Shortcodes_VCParams constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_params' ), 15 );
		add_action( 'vc_backend_editor_enqueue_js_css', array( __CLASS__, 'enqueue_assets' ) );
		add_action( 'vc_frontend_editor_enqueue_js_css', array( __CLASS__, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue js and css files to load on VC back/front editor page.
	 */
	public static function enqueue_assets() {
		the7_register_style( 'the7-vc-params', PRESSCORE_ADMIN_URI . '/assets/css/vc-params' );
		the7_register_script( 'the7-vc-params', PRESSCORE_ADMIN_URI . '/assets/js/vc-params', array( 'jquery' ), false, true );

		wp_enqueue_style( 'the7-vc-params' );
		wp_enqueue_script( 'the7-vc-params' );
	}

	/**
	 * Return taxonomies list.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function taxonomy_settings_field( $settings, $value ) {
		$value_arr = $value_inner = $value;
		if ( ! is_array( $value_arr ) ) {
			$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
		}

		$terms_slugs  = array();
		$terms_fields = array();
		if ( ! empty( $settings['taxonomy'] ) ) {

			$terms = get_terms( $settings['taxonomy'] );
			if ( $terms && ! is_wp_error( $terms ) ) {

				foreach ( $terms as $term ) {
					$terms_slugs[] = $term->slug;

					$terms_fields[] = sprintf( '<label><input id="%s" class="%s" type="checkbox" name="%s" value="%s" %s/>%s</label>', $settings['param_name'] . '-' . $term->slug, $settings['param_name'] . ' ' . $settings['type'], $settings['param_name'], $term->slug, checked( in_array( $term->slug, $value_arr ), true, false ), $term->name );
				}

			}

			$value_inner = implode( ',', array_intersect( $value_arr, $terms_slugs ) );
		}

		return '<div class="dt_taxonomy_block">' . '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-checkboxes ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value_inner . '" />' . '<div class="dt_taxonomy_terms">' . implode( $terms_fields ) . '</div>' . '</div>';
	}

	/**
	 * Return posts list.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function posttype_settings_field( $settings, $value ) {
		$posts_fields = array();
		$posts_names  = array();

		$value_arr = $value_inner = $value;
		if ( ! is_array( $value_arr ) ) {
			$value_arr = array_map( 'trim', explode( ',', $value_arr ) );
		}

		if ( ! empty( $settings['posttype'] ) ) {

			$args = array(
				'no_found_rows'       => 1,
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => -1,
				'post_type'           => $settings['posttype'],
				'post_status'         => 'publish',
				'orderby'             => 'date',
				'order'               => 'DESC',
			);

			$dt_query = new WP_Query( $args );
			if ( $dt_query->have_posts() ) {

				foreach ( $dt_query->posts as $p ) {

					$posts_names[] = $p->post_name;

					$posts_fields[] = sprintf( '<label><input id="%s" class="%s" type="checkbox" name="%s" value="%s" %s/>%s</label>', $settings['param_name'] . '-' . $p->post_name, $settings['param_name'] . ' ' . $settings['type'], $settings['param_name'], $p->post_name, checked( in_array( $p->post_name, $value_arr ), true, false ), $p->post_title );

				}

			}

			$value_inner = implode( ',', array_intersect( $value_arr, $posts_names ) );
		}

		return '<div class="dt_posttype_block">' . '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-checkboxes ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value_inner . '" />' . '<div class="dt_posttype_post">' . implode( $posts_fields ) . '</div>' . '</div>';
	}

	/**
	 * Return title.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function title_settings_field( $settings, $value ) {
		return '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="" />';
	}

	/**
	 * Return subtitle.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function subtitle_settings_field( $settings, $value ) {
		return '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value" value="" />';
	}

	/**
	 * Return spacing param.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function spacing_param( $settings, $value ) {
		$units = ( isset( $settings['units'] ) ? $settings['units'] : array( 'px' ) );
		if ( ! is_array( $units ) ) {
			$units = array_map( 'trim', explode( ',', $units ) );
		}

		$html = '';

		// Spacing.
		$max               = 999;
		$spacing           = explode( ' ', $value );
		$sanitized_spacing = array();
		foreach ( array( 'Top', 'Right', 'Bottom', 'Left' ) as $i => $desc ) {
			// Get space value.
			$val     = '0';
			$dim_val = ( $spacing[ $i ] ? $spacing[ $i ] : '0px' );
			preg_match( '/([-0-9]*)(.*)/', $dim_val, $matches );
			if ( ! empty( $matches[1] ) ) {
				$val = min( intval( $matches[1] ), $max );
			}

			// Get space units.
			$cur_units = current( $units );
			if ( ! empty( $matches[2] ) && in_array( $matches[2], $units ) ) {
				$cur_units = $matches[2];
			}

			$sanitized_spacing[ $i ] = $val . $cur_units;

			// Units HTML.
			$units_html = '';
			if ( count( $units ) > 1 ) {
				foreach ( $units as $u ) {
					$units_html .= '<option value="' . esc_attr( $u ) . '" ' . selected( $u, $cur_units, false ) . '>' . esc_html( $u ) . '</option>';
				}
				$units_html = '<select class="dt_spacing-units" data-units="' . esc_attr( $cur_units ) . '">' . $units_html . '</select>';
			} else {
				$units_html = '<span class="dt_spacing-units" data-units="' . esc_attr( $cur_units ) . '">' . esc_html( $cur_units ) . '</span>';
			}

			$units_html = '<div class="dt_spacing-units-wrap">' . $units_html . '</div>';

			// Space HTML.
			$html .= '<div class="dt_spacing-space"><input type="number" max="' . $max . '" class="dt_spacing-value" value="' . esc_attr( $val ) . '">' . $units_html . '<span class="vc_description vc_clearfix">' . $desc . '<span></div>';
		}

		// Param value.
		$html = '<input type="hidden" class="wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) . '" value="' . esc_attr( implode( ' ', $sanitized_spacing ) ) . '">' . $html;

		return $html;
	}

	/**
	 * Return responsive columns param.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function responsive_columns_param( $settings, $value ) {
		$html           = '';
		$responsiveness = array(
			'desktop'  => __( 'Desktop', 'the7mk2' ),
			'h_tablet' => __( 'Hor. Tablet', 'the7mk2' ),
			'v_tablet' => __( 'Vert. Tablet', 'the7mk2' ),
			'phone'    => __( 'Mob. Phone', 'the7mk2' ),
		);

		$columns = DT_VCResponsiveColumnsParam::decode_columns( $value );

		$sanitized_columns = array();
		foreach ( $responsiveness as $device => $desc ) {
			$val = '';
			if ( ! empty( $columns[ $device ] ) ) {
				$val = $sanitized_columns[ $device ] = $columns[ $device ];
			}

			$html .= '<div class="dt_responsive_columns-column"><input type="number" max="12" min="1" class="dt_responsive_columns-value" data-device="' . esc_attr( $device ) . '" value="' . esc_attr( $val ) . '"><div class="dt_responsive_columns-units-wrap">' . __( 'col', 'the7mk2' ) . '</div><span class="vc_description vc_clearfix">' . $desc . '<span></div>';
		}

		$param_value = '';
		if ( $sanitized_columns ) {
			$param_value = DT_VCResponsiveColumnsParam::encode_columns( $sanitized_columns );
		}

		// Param value.
		$html = '<input type="hidden" class="wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) . '" value="' . esc_attr( $param_value ) . '">' . $html;

		return $html;
	}

	/**
	 * Return number param.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function number_param( $settings, $value ) {
		$settings['units'] = ( isset( $settings['units'] ) ? $settings['units'] : '' );
		$number_obj        = new DT_VCNumberParam( $value, $settings['units'] );

		$units_html = $number_obj->get_units_html();
		if ( $units_html ) {
			$units_html = '<div class="dt_number-units-wrap">' . $units_html . '</div>';
		}

		// Restrictions.
		$min  = ( isset( $settings['min'] ) ? ' min="' . intval( $settings['min'] ) . '"' : '' );
		$max  = ( isset( $settings['max'] ) ? ' max="' . intval( $settings['max'] ) . '"' : '' );
		$step = ( isset( $settings['step'] ) ? ' step="' . intval( $settings['step'] ) . '"' : '' );

		$number    = $number_obj->get_number();
		$cur_units = $number_obj->get_units();
		$value     = $number_obj->get_value();

		$html = '<input type="hidden" class="wpb_vc_param_value" data-units="' . esc_attr( $cur_units ) . '" name="' . esc_attr( $settings['param_name'] ) . '" value="' . esc_attr( $value ) . '">';
		$html .= '<input type="number"' . $min . $max . $step . ' class="dt_number-value" value="' . esc_attr( $number ) . '">' . $units_html;

		return $html;
	}

	/**
	 * Return number param with icon.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function number_param_with_icon( $settings, $value ) {
		$settings['units'] = ( isset( $settings['units'] ) ? $settings['units'] : '' );
		$settings['icon']  = ( isset( $settings['icon'] ) ? $settings['icon'] : '' );
		$number_obj        = new DT_VCNumberParam( $value, $settings['units'], $settings['icon'] );

		$units_html = $number_obj->get_units_html();
		if ( $units_html ) {
			$units_html = '<div class="dt_number-units-wrap">' . $units_html . '</div>';
		}

		// Restrictions.
		$min  = ( isset( $settings['min'] ) ? ' min="' . intval( $settings['min'] ) . '"' : '' );
		$max  = ( isset( $settings['max'] ) ? ' max="' . intval( $settings['max'] ) . '"' : '' );
		$step = ( isset( $settings['step'] ) ? ' step="' . intval( $settings['step'] ) . '"' : '' );

		$number    = $number_obj->get_number();
		$cur_units = $number_obj->get_units();
		$value     = $number_obj->get_value();
		$dashicon  = $settings['icon'];

		$html = '  <div class="dt-number-with-icon ">';
		$html .= '    <span class="dt-number-icon">';
		$html .= $dashicon;
		$html .= '     </span>';

		$html .= '<input type="hidden" class="wpb_vc_param_value" data-units="' . esc_attr( $cur_units ) . '" name="' . esc_attr( $settings['param_name'] ) . '" value="' . esc_attr( $value ) . '">';
		$html .= '<input type="number"' . $min . $max . $step . ' class="dt_number-value" value="' . esc_attr( $number ) . '">' . $units_html;
		$html .= '  </div>';

		return $html;
	}

	/**
	 * Return dimensions param.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function dimensions_param( $settings, $value ) {
		// Sanitize value.
		$_value = array_slice( array_map( 'absint', explode( 'x', strtolower( $value ) ) ), 0, 2 );
		// Make sure that all values is set.
		for ( $i = 0; $i < 2; $i++ ) {
			if ( empty( $_value[ $i ] ) ) {
				$_value[ $i ] = '';
			}
		}

		// Sanitize heading.
		$width_heading  = ( isset( $settings['headings'][0] ) ? $settings['headings'][0] : '' );
		$height_heading = ( isset( $settings['headings'][1] ) ? $settings['headings'][1] : '' );

		// Return HTML.
		$param_name  = $settings['param_name'];
		$width       = $_value[0];
		$height      = $_value[1];
		$param_value = '';
		if ( $width || $height ) {
			$param_value = implode( 'x', $_value );
		}

		return '<input type="hidden" class="wpb_vc_param_value" name="' . esc_attr( $param_name ) . '" value="' . esc_attr( $param_value ) . '">' . '<div class="dt_dimensions-value-wrap"><div class="wpb_element_label">' . $width_heading . '</div><input type="number" min="0" class="dt_dimensions-width" value="' . esc_attr( $width ) . '"></div>' . '<span class="dt_dimensions-delimiter">&times;</span>' . '<div class="dt_dimensions-value-wrap"><div class="wpb_element_label">' . $height_heading . '</div><input type="number" min="0" class="dt_dimensions-height" value="' . esc_attr( $height ) . '"></div>';
	}

	/**
	 * Return font style param. Checkboxes italic, bold, uppercase.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function font_style_param( $settings, $value ) {
		$_value = self::sanitize_font_style_param( $value );

		$italic    = $_value[0];
		$bold      = $_value[1];
		$uppercase = $_value[2];

		return '<input type="hidden" class="wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) . '" value="' . esc_attr( $value ) . '">' . '<label class="dt_font_style-italic-label"><input type="checkbox" class="dt_font_style-italic" value="italic" ' . checked( 'italic', $italic, false ) . '>' . esc_html( _x( 'Italic', 'backend', 'the7mk2' ) ) . '</label>' . '<label class="dt_font_style-bold-label"><input type="checkbox" class="dt_font_style-bold" value="bold" ' . checked( 'bold', $bold, false ) . '>' . esc_html( _x( 'Bold', 'backend', 'the7mk2' ) ) . '</label>' . '<label class="dt_font_style-uppercase-label"><input type="checkbox" class="dt_font_style-uppercase" value="uppercase" ' . checked( 'uppercase', $uppercase, false ) . '>' . esc_html( _x( 'Uppercase', 'backend', 'the7mk2' ) ) . '</label>';
	}

	/**
	 * Return font style param. Checkboxes italic, bold, uppercase.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function dt_image_param( $settings, $value ) {
		if ( ! $value ) {
			$value = $settings['value'];
		}
		$val          = '';
		$select_value = '';
		$checked      = '';
		$output       = '';

		// Set default value to $val
		if ( isset( $settings['value'] ) ) {
			$val = $settings['value'];
		}

		$param_name = $settings['param_name'];
		$name       = 'dt_image-' . $param_name;
		$classes    = array( 'of-radio-img-radio' );

		if ( empty( $value['base_dir'] ) ) {
			$dir = get_template_directory_uri();
		} else {
			$dir = $value['base_dir'];
		}
		$output .= '<input type="hidden" name="' . $param_name . '" class="wpb_vc_param_value radio-img ' . $param_name . '" value="' . $value . '">';

		foreach ( $settings['options'] as $key => $option ) {
			$input_classes = $classes;
			$selected      = '';
			$checked       = '';
			$attr          = '';


			if ( $value == $key ) {
				$selected = ' of-radio-img-selected';
				$checked  = ' checked="checked"';
			}
			$output .= '<div class="of-radio-img-inner-container">';

			$output .= '<input type="radio" id="' . esc_attr( $key ) . '" class="' . esc_attr( implode( ' ', $input_classes ) ) . '"' . $attr . ' value="' . esc_attr( $key ) . '" name="' . esc_attr( $settings['param_name'] ) . '" ' . $checked . ' />';

			$img_info = '';
			if ( is_array( $option ) && isset( $option['src'], $option['title'] ) ) {
				$img   = $dir . $option['src'];
				$title = $option['title'];

				if ( $title ) {

					$img_title_style = '';
					if ( isset( $option['title_width'] ) ) {
						$img_title_style = ' style="width: ' . absint( $option['title_width'] ) . 'px;"';
					}

					$img_info = '<div class="of-radio-img-label"' . $img_title_style . '>' . esc_html( $title ) . '</div>';
				}
			} else if ( $option !== $key ) {
				$img   = $dir . $option;
				$title = $option;
			} else {
				$img             = presscore_get_default_small_image();
				$img             = $img[0];
				$title           = $option;
				$img_title_style = '';
				if ( isset( $option['title_width'] ) ) {
					$img_title_style = ' style="width: ' . absint( $option['title_width'] ) . 'px;"';
				}

				$img_info = '<div class="of-radio-img-label"' . $img_title_style . '>' . esc_html( $title ) . '</div>';
			}

			$output .= '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '" class="of-radio-img-img' . $selected . '" onclick="dtRadioImagesSetCheckbox(\'' . esc_attr( $key ) . '\');" />';

			$output .= $img_info;

			$output .= '</div>';
		}

		return $output;

	}

	/**
	 * Return font style param. Checkboxes italic, bold, uppercase.
	 *
	 * @param array  $settings
	 * @param string $value
	 *
	 * @return string
	 */
	public function switch_param( $settings, $value ) {
		if ( ! $value ) {
			$value = $settings['value'];
		}

		list( $on, $off ) = array_values( $settings['options'] );
		list( $on_title, $off_title ) = array_keys( $settings['options'] );

		$values_attr = json_encode( array( $on, $off ) );
		$param_name  = $settings['param_name'];
		$id          = 'dt_switch-' . $param_name;

		return '<div class="the7-onoffswitch">' . '<input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $param_name ) . '" data-values="' . esc_attr( $values_attr ) . '" value="' . esc_attr( $value ) . '" class="wpb_vc_param_value the7-onoffswitch-checkbox ' . esc_attr( $param_name ) . '" ' . checked( $value, $on, false ) . '>' . '<label class="the7-onoffswitch-label" for="' . esc_attr( $id ) . '">' . '<div class="the7-onoffswitch-inner">' . '<div class="the7-onoffswitch-active">' . '<div class="the7-onoffswitch-switch">' . esc_html( $on_title ) . '</div>' . '</div>' . '<div class="the7-onoffswitch-inactive">' . '<div class="the7-onoffswitch-switch">' . esc_html( $off_title ) . '</div>' . '</div>' . '</div>' . '</label>' . '</div>';
	}

	public function gradient_picker( $settings, $value ) {
		$field_name = $settings['param_name'];

		return The7_Option_Field_Gradient_Picker::static_html( $field_name, $field_name, $value, array(
			'hide_angle_controls' => false,
			'value_input_class'   => 'wpb_vc_param_value',
		) );
	}

	public function add_shortcode_param( $name, $form_field_callback, $script_url = null ) {
		if ( defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, 4.4 ) >= 0 ) {
			if ( function_exists( 'vc_add_shortcode_param' ) ) {
				vc_add_shortcode_param( $name, $form_field_callback, $script_url );
			}
		} elseif ( function_exists( 'add_shortcode_param' ) ) {
			add_shortcode_param( $name, $form_field_callback, $script_url );
		}
	}

	public function enqueue_icon_picker_styles() {
		wp_deregister_style( 'font-awesome' );
		wp_dequeue_style( 'font-awesome' );
		the7_register_style( 'the7-awesome-fonts-back', PRESSCORE_THEME_URI . '/fonts/FontAwesome/back-compat' );
		the7_register_fontawesome_style( 'font-awesome' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'the7-awesome-fonts-back' );
	}

	/**
	 * Register params.
	 */
	public function register_params() {
		if ( The7_Icon_Manager::is_fontawesome_enabled() ) {
			add_action( 'vc_backend_editor_enqueue_js_css', array( $this, 'enqueue_icon_picker_styles' ), 50 );
			add_action( 'vc_frontend_editor_enqueue_js_css', array( $this, 'enqueue_icon_picker_styles' ), 50 );
		}

		$dir        = get_template_directory_uri();
		$script_url = "{$dir}/inc/shortcodes/vc_extend/dt-vc-scripts.js";

		$this->add_shortcode_param( 'dt_title', array( $this, 'title_settings_field' ) );
		$this->add_shortcode_param( 'dt_subtitle', array( $this, 'subtitle_settings_field' ) );
		$this->add_shortcode_param( 'dt_taxonomy', array( $this, 'taxonomy_settings_field' ), $script_url );
		$this->add_shortcode_param( 'dt_posttype', array( $this, 'posttype_settings_field' ), $script_url );
		$this->add_shortcode_param( 'dt_spacing', array( $this, 'spacing_param' ), $script_url );
		$this->add_shortcode_param( 'dt_responsive_columns', array( $this, 'responsive_columns_param' ), $script_url );
		$this->add_shortcode_param( 'dt_dimensions', array( $this, 'dimensions_param' ), $script_url );
		$this->add_shortcode_param( 'dt_number', array( $this, 'number_param' ), $script_url );
		$this->add_shortcode_param( 'dt_number_with_icon', array( $this, 'number_param_with_icon' ), $script_url );
		$this->add_shortcode_param( 'dt_font_style', array( $this, 'font_style_param' ), $script_url );
		$this->add_shortcode_param( 'dt_switch', array( $this, 'switch_param' ), $script_url );
		$this->add_shortcode_param( 'dt_navigation', array( $this, 'dt_icon_settings_field' ), PRESSCORE_ADMIN_URI . '/assets/js/vc/params/dt-icons-picker.js' );
		$this->add_shortcode_param( 'icon_manager', array( $this, 'dt_icon_settings_field' ), PRESSCORE_ADMIN_URI . '/assets/js/vc/params/dt-icons-picker.js' );
		$this->add_shortcode_param( 'dt_soc_icon_manager', array( $this, 'dt_icon_settings_field' ), PRESSCORE_ADMIN_URI . '/assets/js/vc/params/dt-icons-picker.js' );
		$this->add_shortcode_param( 'dt_radio_image', array( $this, 'dt_image_param' ), $script_url );
		$this->add_shortcode_param( 'dt_gradient_picker', array( $this, 'gradient_picker' ), PRESSCORE_ADMIN_URI . '/assets/js/vc/params/dt-gradient-picker.js' );

		// Extend default autocomplete param with custom js.
		$this->add_shortcode_param( 'autocomplete', 'vc_autocomplete_form_field', "{$dir}/inc/shortcodes/vc_extend/dt-autocomplete.js" );
	}

	/**
	 * Sanitize font style param.
	 *
	 * @param string|array $value
	 *
	 * @return array
	 */
	public static function sanitize_font_style_param( $value ) {
		$_value = $value;
		if ( ! is_array( $_value ) ) {
			$_value = array_map( 'trim', explode( ':', $value ) );
		}

		$defaults = array( 'normal', 'normal', 'none' );
		foreach ( $defaults as $i => $default ) {
			if ( empty( $_value[ $i ] ) ) {
				$_value[ $i ] = $default;
			}
		}

		return $_value;
	}

	/**
	 * Return font icons param.
	 *
	 * @param array $settings
	 * @param string|array $value
	 *
	 * @return string
	 */
	public function dt_icon_settings_field( $settings, $value ) {
		$icons = array();
		$predefined_icons = presscore_get_icons_for_vc_icon_picker( $settings['param_name'] );
		if ( $predefined_icons ) {
			$icons['Predefined'] = $predefined_icons;
		}

		return The7_Option_Field_Icons_Picker::static_html( $settings['param_name'], $settings['param_name'], $value, array(
			'icons' => $icons,
			'value_input_class' => 'wpb_vc_param_value',
		) );
	}

	/**
	 * Return font soc icons param.
	 *
	 * @param string|array $value
	 *
	 * @return array
	 */
	public function dt_soc_icons_settings_field( $settings, $soc_value ) {
		$dependency = '';
		//$uid = uniqid();
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type       = isset( $settings['type'] ) ? $settings['type'] : '';
		$class      = isset( $settings['class'] ) ? $settings['class'] : '';
		$icons = array();
		if ( $param_name == "dt_soc_icon" ) {
			$icons = array(
				'dt-icon-px-500',
				'dt-icon-behance',
				'dt-icon-blogger',
				'dt-icon-delicious',
				'dt-icon-devian',
				'dt-icon-dribbble',
				'dt-icon-facebook',
				'dt-icon-flickr',
				'dt-icon-foursquare',
				'dt-icon-github',
				'dt-icon-instagram',
				'dt-icon-lastfm',
				'dt-icon-linkedin',
				'dt-icon-mail',
				'dt-icon-odnoklassniki',
				'dt-icon-pinterest',
				'dt-icon-reddit',
				'dt-icon-research-gate',
				'dt-icon-rss',
				'dt-icon-skype',
				'dt-icon-soundcloud',
				'dt-icon-stumbleupon',
				'dt-icon-tripedvisor',
				'dt-icon-tumbler',
				'dt-icon-twitter',
				'dt-icon-viber',
				'dt-icon-vimeo',
				'dt-icon-vk',
				'dt-icon-website',
				'dt-icon-weibo',
				'dt-icon-whatsapp',
				'dt-icon-xing',
				'dt-icon-yelp',
				'dt-icon-you-tube',
				'dt-icon-snapchat',
				'dt-icon-telegram',
			);
		}

		$icons = apply_filters( 'the7_icons_in_settings', $icons );
		$output = '<input type="hidden" name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" value="' . $soc_value . '" />';
		$output .= '<ul class="dt-icon-list">';
		$output .= '<li class="dt-icons-selector" data-car-icon=""><i class="soc-font-icon moon-icon "></i><span class="selector-button"><i class="icomoon-the7-font-the7-arrow-05"></i></span>';
		$output .= '<ul class="dt-icon-list-sub">';
		$n      = 1;
		foreach ( $icons as $icon ) {
			$selected = ( $icon == $soc_value ) ? 'class="selected"' : '';
			$id       = 'dt-icon-' . $n;

			$output .= '<li ' . $selected . ' data-car-icon="' . $icon . '"><i class="soc-font-icon moon-icon ' . $icon . '"></i><label class="soc-font-icon moon-icon">' . $icon . '</label></li>';

			$n++;
		}
		$output .= '</ul>';
		$output .= '</li>';
		$output .= '</ul>';

		return $output;
	}
}

/**
 * Class DT_VCNumberParam
 */
class DT_VCNumberParam {

	/**
	 * @var int|string
	 */
	protected $number;

	/**
	 * @var array
	 */
	protected $units;

	/**
	 * @var string
	 */
	protected $cur_units;

	/**
	 * DT_VCNumberParam constructor.
	 *
	 * @param       $value
	 * @param array $units
	 */
	public function __construct( $value, $units = array() ) {
		if ( ! is_array( $units ) ) {
			$units = array_map( 'trim', explode( ',', $units ) );
		}

		$this->units = $units;

		preg_match( '/([-0-9]*)(.*)/', $value, $matches );
		$this->number = '';
		if ( isset( $matches[1] ) ) {
			$this->number = ( is_numeric( $matches[1] ) ? intval( $matches[1] ) : '' );
		}

		$this->cur_units = current( $units );
		if ( ! empty( $matches[2] ) && in_array( $matches[2], $units ) ) {
			$this->cur_units = $matches[2];
		}
	}

	/**
	 * Return number.
	 *
	 * @return int|string
	 */
	public function get_number() {
		return $this->number;
	}

	/**
	 * Return current units.
	 *
	 * @return string
	 */
	public function get_units() {
		return $this->cur_units;
	}

	/**
	 * Return combined number and units.
	 *
	 * @return string
	 */
	public function get_value() {
		if ( '' === $this->number ) {
			return '';
		}

		return $this->number . $this->cur_units;
	}

	/**
	 * Return units selector HTML. If units is empty return empty string.
	 *
	 * @return string
	 */
	public function get_units_html() {
		if ( ! $this->units ) {
			return '';
		}

		if ( count( $this->units ) == 1 ) {
			return '<span>' . esc_html( $this->cur_units ) . '</span>';
		}

		$units_html = '';
		foreach ( $this->units as $u ) {
			$units_html .= '<option value="' . esc_attr( $u ) . '" ' . selected( $u, $this->cur_units, false ) . '>' . esc_html( $u ) . '</option>';
		}
		$units_html = '<select class="dt_number-units">' . $units_html . '</select>';

		return $units_html;
	}
}

if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {

	// Add VC params.
	new The7_Inc_Shortcodes_VCParams();

	/**
	 * Register custom vc_pie shortcode script.
	 */
	function presscore_vc_register_custom_vc_pie_script() {
		if ( version_compare( WPB_VC_VERSION, '6.0.2', '<' ) ) {
			$dependencies = array(
				'jquery',
				'waypoints',
				'progressCircle',
			);
		} else {
			$dependencies = array(
				'jquery',
				'vc_waypoints',
				'progressCircle',
			);
		}
		wp_register_script( 'vc_dt_pie', PRESSCORE_THEME_URI . '/inc/shortcodes/vc_extend/jquery.vc_chart.js', $dependencies, THE7_VERSION );
	}

	add_action( 'wp_enqueue_scripts', 'presscore_vc_register_custom_vc_pie_script', 15 );
}

if ( ! function_exists( 'presscore_vc_add_stripe_decoration_classes' ) ):

	/**
	 * Add stripe HTML decoration classes based on theme options.
	 *
	 * @param array $classes
	 * @param array $atts
	 *
	 * @return array
	 */
	function presscore_vc_add_stripe_decoration_classes( $classes, $atts ) {
		$type = esc_attr( $atts['type'] );
		if ( in_array( $type, array( '1', '2', '3' ) ) ) {
			switch ( of_get_option( "stripes-stripe_{$type}_content_boxes_decoration", 'none' ) ) {
				case 'shadow':
					$classes[] = 'shadow-element-decoration';
					break;
				case 'outline':
					$classes[] = 'outline-element-decoration';
					break;
			}

			if ( 'show' == of_get_option( "stripes-stripe_{$type}_outline", 'hide' ) ) {
				$classes[] = 'outline-stripe-decoration';
			}
		}

		return $classes;
	}

	add_filter( 'presscore_vc_row_stripe_class', 'presscore_vc_add_stripe_decoration_classes', 10, 2 );

endif;

if ( ! function_exists( 'presscore_vc_add_ultimate_addons_icons' ) ) :

	add_filter( 'vc_iconpicker-type-ult', 'presscore_vc_add_ultimate_addons_icons' );

	/**
	 * Ultimate Addons icons for VC iconpicker.
	 *
	 * @param $origin_icons
	 *
	 * @return array
	 */
	function presscore_vc_add_ultimate_addons_icons( $origin_icons ) {
		$upload_dir = wp_get_upload_dir();
		$path       = trailingslashit( $upload_dir['basedir'] );
		$new_icons  = array();
		$fonts      = get_option( 'smile_fonts', array() );
		if ( ! is_array( $fonts ) ) {
			return $origin_icons;
		}

		foreach ( $fonts as $font => $font_data ) {
			$icons = array();
			include( $path . $font_data['include'] . '/' . $font_data['config'] );

			if ( empty( $icons ) ) {
				continue;
			}

			foreach ( $icons as $icons_set_name => $icons_set ) {
				// Icon set.
				$new_icons[ $icons_set_name ] = array();
				foreach ( $icons_set as $icon ) {
					$icon_class = $icon['class'];
					// Icon. class => name
					$new_icons[ $icons_set_name ][] = array( "{$icons_set_name}-{$icon_class}" => ucfirst( $icon_class ) );
				}
			}
		}

		return array_merge( $origin_icons, $new_icons );
	}

endif;

function presscore_get_icons_for_vc_icon_picker( $type = '' ) {
	$icons = array(
		'next_icon'               => array(
			'icon-ar-021-r',
			'icon-ar-022-r',
			'icon-ar-023-r',
			'icon-ar-001-r',
			'icon-ar-002-r',
			'icon-ar-003-r',
			'icon-ar-004-r',
			'icon-ar-005-r',
			'icon-ar-006-r',
			'icon-ar-007-r',
			'icon-ar-008-r',
			'icon-ar-009-r',
			'icon-ar-010-r',
			'icon-ar-011-r',
			'icon-ar-012-r',
			'icon-ar-013-r',
			'dt-icon-the7-arrow-0-41',
			'icon-ar-014-r',
			'icon-ar-015-r',
			'icon-ar-017-r',
			'icon-ar-018-r',
			'icon-ar-019-r',
			'icon-ar-020-r',
			'icomoon-the7-font-the7-arrow-29-2',
			'dt-icon-the7-arrow-07',
			'dt-icon-the7-arrow-03',
		),
		'prev_icon'               => array(
			'icon-ar-021-l',
			'icon-ar-022-l',
			'icon-ar-023-l',
			'icon-ar-001-l',
			'icon-ar-002-l',
			'icon-ar-003-l',
			'icon-ar-004-l',
			'icon-ar-005-l',
			'icon-ar-006-l',
			'icon-ar-007-l',
			'icon-ar-008-l',
			'icon-ar-009-l',
			'icon-ar-010-l',
			'icon-ar-011-l',
			'icon-ar-012-l',
			'icon-ar-013-l',
			'dt-icon-the7-arrow-0-42',
			'icon-ar-014-l',
			'icon-ar-015-l',
			'icon-ar-017-l',
			'icon-ar-018-l',
			'icon-ar-019-l',
			'icon-ar-020-l',
			'icomoon-the7-font-the7-arrow-29-3',
			'dt-icon-the7-arrow-06',
			'icomoon-the7-font-the7-arrow-02'
		),
		'project_link_icon'       => array(
			'icon-portfolio-p208',
			'icon-portfolio-p206',
			'dt-icon-the7-menu-004',
			'dt-icon-the7-menu-007',
		),
		'external_link_icon'      => array(
			'icon-portfolio-p201',
			'icomoon-the7-font-the7-link-01',
			'icon-portfolio-p204',
			'icomoon-the7-font-the7-link-03',
		),
		'image_zoom_icon'         => array(
			'icomoon-the7-font-the7-zoom-01',
			'icomoon-the7-font-the7-zoom-02',
			'icomoon-the7-font-the7-zoom-03',
			'icomoon-the7-font-the7-zoom-044',
			'icomoon-the7-font-the7-zoom-05',
			'icomoon-the7-font-icon-gallery-011-2',
			'icomoon-the7-font-the7-zoom-06',
			'icomoon-the7-font-the7-zoom-08',
			'icomoon-the7-font-the7-expand-01',
			'icomoon-the7-font-the7-expand-02',
			'icomoon-the7-font-the7-expand-03',
			'icomoon-the7-font-the7-expand-04',
			'icomoon-the7-font-the7-expand-05',
			'icomoon-the7-font-the7-expand-06',
			'icomoon-the7-font-the7-expand-07',
			'icomoon-the7-font-the7-expand-08',
			'icomoon-the7-font-the7-plus-00',
			'icomoon-the7-font-the7-plus-01',
			'icomoon-the7-font-the7-plus-02',
			'icomoon-the7-font-the7-plus-03',
			'icomoon-the7-font-the7-plus-04',
			'icomoon-the7-font-the7-plus-05',
			'icomoon-the7-font-the7-plus-06',
			'icomoon-the7-font-the7-plus-07',
			'icomoon-the7-font-the7-plus-08',
			'icomoon-the7-font-the7-plus-09',
			'icomoon-the7-font-the7-plus-10',
			'icomoon-the7-font-the7-plus-11',
			'icomoon-the7-font-the7-plus-12',
		),
		'gallery_image_zoom_icon' => array(
			'icomoon-the7-font-the7-zoom-01',
			'icomoon-the7-font-the7-zoom-02',
			'icomoon-the7-font-the7-zoom-03',
			'icomoon-the7-font-the7-zoom-044',
			'icomoon-the7-font-the7-zoom-05',
			'icomoon-the7-font-icon-gallery-011-2',
			'icomoon-the7-font-the7-zoom-06',
			'icomoon-the7-font-the7-zoom-08',
			'icomoon-the7-font-the7-expand-01',
			'icomoon-the7-font-the7-expand-02',
			'icomoon-the7-font-the7-expand-03',
			'icomoon-the7-font-the7-expand-04',
			'icomoon-the7-font-the7-expand-05',
			'icomoon-the7-font-the7-expand-06',
			'icomoon-the7-font-the7-expand-07',
			'icomoon-the7-font-the7-expand-08',
			'icomoon-the7-font-the7-plus-00',
			'icomoon-the7-font-the7-plus-01',
			'icomoon-the7-font-the7-plus-02',
			'icomoon-the7-font-the7-plus-03',
			'icomoon-the7-font-the7-plus-04',
			'icomoon-the7-font-the7-plus-05',
			'icomoon-the7-font-the7-plus-06',
			'icomoon-the7-font-the7-plus-07',
			'icomoon-the7-font-the7-plus-08',
			'icomoon-the7-font-the7-plus-09',
			'icomoon-the7-font-the7-plus-10',
			'icomoon-the7-font-the7-plus-11',
			'icomoon-the7-font-the7-plus-12',
		),
		'dt_soc_icon'             => array(
			'dt-icon-px-500',
			'dt-icon-behance',
			'dt-icon-blogger',
			'dt-icon-delicious',
			'dt-icon-devian',
			'dt-icon-dribbble',
			'dt-icon-facebook',
			'dt-icon-flickr',
			'dt-icon-foursquare',
			'dt-icon-github',
			'dt-icon-instagram',
			'dt-icon-lastfm',
			'dt-icon-linkedin',
			'dt-icon-mail',
			'dt-icon-odnoklassniki',
			'dt-icon-pinterest',
			'dt-icon-reddit',
			'dt-icon-research-gate',
			'dt-icon-rss',
			'dt-icon-skype',
			'dt-icon-soundcloud',
			'dt-icon-stumbleupon',
			'dt-icon-tripedvisor',
			'dt-icon-tumbler',
			'dt-icon-twitter',
			'dt-icon-viber',
			'dt-icon-vimeo',
			'dt-icon-vk',
			'dt-icon-website',
			'dt-icon-weibo',
			'dt-icon-whatsapp',
			'dt-icon-xing',
			'dt-icon-yelp',
			'dt-icon-you-tube',
			'dt-icon-snapchat',
			'dt-icon-telegram',
		),
	);

	if ( array_key_exists( $type, $icons ) ) {
		return $icons[ $type ];
	}

	return array();
}

if ( ! function_exists( 'dt_productIdAutocompleteSuggesterExactSku' ) ) :
	function dt_productIdAutocompleteSuggesterExactSku( $query ) {
		global $wpdb;
		$query        = trim( $query );
		$product_id   = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", stripslashes( $query ) ) );
		$product_data = get_post( $product_id );
		if ( 'product' !== $product_data->post_type ) {
			return '';
		}

		$product_object = wc_get_product( $product_data );
		if ( is_object( $product_object ) ) {

			$product_sku   = $product_object->get_sku();
			$product_title = $product_object->get_title();
			$product_id    = $product_object->get_id();

			$product_sku_display = '';
			if ( ! empty( $product_sku ) ) {
				$product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
			}

			$product_title_display = '';
			if ( ! empty( $product_title ) ) {
				$product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
			}

			$product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;

			$data          = array();
			$data['value'] = $product_id;
			$data['label'] = $product_id_display . $product_title_display . $product_sku_display;

			return ! empty( $data ) ? $data : false;
		}

		return false;
	}
endif;
if ( ! function_exists( 'dt_productIdDefaultValueFromSkuToId' ) ) :
	function dt_productIdDefaultValueFromSkuToId( $query ) {
		$result = dt_productIdAutocompleteSuggesterExactSku( $query );

		return isset( $result['value'] ) ? $result['value'] : false;
	}
endif;


if ( ! function_exists( 'dt_productsIdsDefaultValue' ) ) :
	/**
	 * Replaces product skus to id's.
	 *
	 * @since 4.4
	 *
	 * @param $current_value
	 * @param $param_settings
	 * @param $map_settings
	 * @param $atts
	 *
	 * @return string
	 */
	function dt_productsIdsDefaultValue( $current_value, $param_settings, $map_settings, $atts ) {
		$value = trim( $current_value );
		if ( strlen( trim( $value ) ) === 0 && isset( $atts['skus'] ) && strlen( $atts['skus'] ) > 0 ) {
			$data       = array();
			$skus       = $atts['skus'];
			$skus_array = explode( ',', $skus );
			foreach ( $skus_array as $sku ) {
				$id = dt_productIdDefaultValueFromSkuToId( trim( $sku ) );
				if ( is_numeric( $id ) ) {
					$data[] = $id;
				}
			}
			if ( ! empty( $data ) ) {
				$values = explode( ',', $value );
				$values = array_merge( $values, $data );
				$value  = implode( ',', $values );
			}
		}

		return $value;
	}
endif;
if ( ! function_exists( 'dt_productIdAutocompleteSuggester' ) ) :
	//Filters For autocomplete param:
	/**
	 * Suggester for autocomplete by id/name/title/sku
	 *
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return array - id's from products with title/sku.
	 */
	function dt_productIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id      = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
					FROM {$wpdb->posts} AS a
					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : -1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['id'];
				$data['label'] = __( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . __( 'Title', 'js_composer' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $value['sku'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}
endif;
if ( ! function_exists( 'dt_productIdAutocompleteRender' ) ) :
	/**
	 * Find product by id
	 *
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	function dt_productIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get product
			$product_object = wc_get_product( (int) $query );
			if ( is_object( $product_object ) ) {
				$product_sku   = $product_object->get_sku();
				$product_title = $product_object->get_title();
				$product_id    = $product_object->get_id();

				$product_sku_display = '';
				if ( ! empty( $product_sku ) ) {
					$product_sku_display = ' - ' . __( 'Sku', 'js_composer' ) . ': ' . $product_sku;
				}

				$product_title_display = '';
				if ( ! empty( $product_title ) ) {
					$product_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $product_title;
				}

				$product_id_display = __( 'Id', 'js_composer' ) . ': ' . $product_id;

				$data          = array();
				$data['value'] = $product_id;
				$data['label'] = $product_id_display . $product_title_display . $product_sku_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}
endif;
if ( ! function_exists( 'dt_productCategoryCategoryAutocompleteSuggester' ) ) :
	/**
	 * Autocomplete suggester to search product category by name/slug or id.
	 *
	 * @since 4.4
	 *
	 * @param      $query
	 * @param bool $slug - determines what output is needed
	 *                   default false - return id of product category
	 *                   true - return slug of product category
	 *
	 * @return array
	 */
	function dt_productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
		global $wpdb;
		$cat_id          = (int) $query;
		$query           = trim( $query );
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : -1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = __( 'Id', 'js_composer' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'js_composer' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'js_composer' ) . ': ' . $value['slug'] : '' );
				$result[]      = $data;
			}
		}

		return $result;
	}
endif;

//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_dt_products_carousel_ids_callback', 'dt_productIdAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_dt_products_carousel_ids_render', 'dt_productIdAutocompleteRender', 10, 1 ); // Render exact product. Must return an array (label,value)
//For param: ID default value filter
add_filter( 'vc_form_fields_render_field_dt_products_carousel_ids_param_value', 'dt_productsIdsDefaultValue', 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

add_filter( 'vc_autocomplete_dt_products_carousel_category_ids_callback', 'dt_productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array


//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_dt_products_masonry_ids_callback', 'dt_productIdAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_dt_products_masonry_ids_render', 'dt_productIdAutocompleteRender', 10, 1 ); // Render exact product. Must return an array (label,value)
//For param: ID default value filter
add_filter( 'vc_form_fields_render_field_dt_products_masonry_ids_param_value', 'dt_productsIdsDefaultValue', 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

add_filter( 'vc_autocomplete_dt_products_masonry_category_ids_callback', 'dt_productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array

// Blog.
$posts_label_tpl       = _x( 'Id: %1$s - Title: %2$s', 'shortcodes interface', 'the7mk2' );
$taxonomy_label_tpl    = _x( 'Id: %1$s - Name: %2$s - Slug: %3$s', 'shortcodes interface', 'the7mk2' );
$posts_autocomplete    = new The7_VC_Posts_Autocomplete( 'post', $posts_label_tpl );
$category_autocomplete = new The7_VC_Taxonomy_Autocomplete( 'category', $taxonomy_label_tpl );
$tags_autocomplete     = new The7_VC_Taxonomy_Autocomplete( 'post_tag', $taxonomy_label_tpl );

foreach ( array( 'dt_blog_masonry', 'dt_blog_list', 'dt_blog_carousel' ) as $shortcode_tag ) {
	// Posts.
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_callback", array( $posts_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_render", array( $posts_autocomplete, 'renderer' ) );

	// Category.
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_callback", array( $category_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_render", array( $category_autocomplete, 'renderer' ) );

	// Tags.
	add_filter( "vc_autocomplete_{$shortcode_tag}_tags_callback", array( $tags_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_tags_render", array( $tags_autocomplete, 'renderer' ) );
}
//Portfolio
$posts_label_tpl       = _x( 'Id: %1$s - Title: %2$s', 'shortcodes interface', 'the7mk2' );
$taxonomy_label_tpl    = _x( 'Id: %1$s - Name: %2$s - Slug: %3$s', 'shortcodes interface', 'the7mk2' );
$posts_autocomplete    = new The7_VC_Posts_Autocomplete( 'dt_portfolio', $posts_label_tpl );
$category_autocomplete = new The7_VC_Taxonomy_Autocomplete( 'dt_portfolio_category', $taxonomy_label_tpl );
$tags_autocomplete     = new The7_VC_Taxonomy_Autocomplete( 'post_tag', $taxonomy_label_tpl );

foreach ( array( 'dt_portfolio_carousel', 'dt_portfolio_masonry' ) as $shortcode_tag ) {
	// Posts.
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_callback", array( $posts_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_render", array( $posts_autocomplete, 'renderer' ) );

	// Category.
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_callback", array( $category_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_render", array( $category_autocomplete, 'renderer' ) );
}
// Team.
$posts_label_tpl       = _x( 'Id: %1$s - Title: %2$s', 'shortcodes interface', 'the7mk2' );
$taxonomy_label_tpl    = _x( 'Id: %1$s - Name: %2$s - Slug: %3$s', 'shortcodes interface', 'the7mk2' );
$posts_autocomplete    = new The7_VC_Posts_Autocomplete( 'dt_team', $posts_label_tpl );
$category_autocomplete = new The7_VC_Taxonomy_Autocomplete( 'dt_team_category', $taxonomy_label_tpl );

foreach ( array( 'dt_team_carousel', 'dt_team_masonry' ) as $shortcode_tag ) {
	// Posts.
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_callback", array( $posts_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_render", array( $posts_autocomplete, 'renderer' ) );

	// Category.
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_callback", array( $category_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_render", array( $category_autocomplete, 'renderer' ) );
}
// Testimonials.
$posts_label_tpl       = _x( 'Id: %1$s - Title: %2$s', 'shortcodes interface', 'the7mk2' );
$taxonomy_label_tpl    = _x( 'Id: %1$s - Name: %2$s - Slug: %3$s', 'shortcodes interface', 'the7mk2' );
$posts_autocomplete    = new The7_VC_Posts_Autocomplete( 'dt_testimonials', $posts_label_tpl );
$category_autocomplete = new The7_VC_Taxonomy_Autocomplete( 'dt_testimonials_category', $taxonomy_label_tpl );

foreach ( array( 'dt_testimonials_carousel', 'dt_testimonials_masonry' ) as $shortcode_tag ) {
	// Posts.
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_callback", array( $posts_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_render", array( $posts_autocomplete, 'renderer' ) );

	// Category.
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_callback", array( $category_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_render", array( $category_autocomplete, 'renderer' ) );
}

//Gallery
$posts_label_tpl       = _x( 'Id: %1$s - Title: %2$s', 'shortcodes interface', 'the7mk2' );
$taxonomy_label_tpl    = _x( 'Id: %1$s - Name: %2$s - Slug: %3$s', 'shortcodes interface', 'the7mk2' );
$posts_autocomplete    = new The7_VC_Posts_Autocomplete( 'dt_gallery', $posts_label_tpl );
$category_autocomplete = new The7_VC_Taxonomy_Autocomplete( 'dt_gallery_category', $taxonomy_label_tpl );
$tags_autocomplete     = new The7_VC_Taxonomy_Autocomplete( 'post_tag', $taxonomy_label_tpl );

foreach ( array(  'dt_photos_carousel','dt_gallery_photos_masonry', 'dt_albums_masonry', 'dt_albums_carousel' ) as $shortcode_tag ) {
	// Posts.
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_callback", array( $posts_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_posts_render", array( $posts_autocomplete, 'renderer' ) );

	// Category.
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_callback", array( $category_autocomplete, 'suggester' ) );
	add_filter( "vc_autocomplete_{$shortcode_tag}_category_render", array( $category_autocomplete, 'renderer' ) );
}