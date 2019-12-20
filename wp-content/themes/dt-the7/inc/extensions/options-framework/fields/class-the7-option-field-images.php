<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Images extends The7_Option_Field_Abstract {

	public function html() {
		$show_hide = empty( $this->option['show_hide'] ) ? array() : (array) $this->option['show_hide'];
		$classes   = array( 'of-radio-img-radio' );

		if ( ! empty( $show_hide ) ) {
			$classes[] = 'of-js-hider';
		}

		if ( empty( $this->option['base_dir'] ) ) {
			$dir = get_template_directory_uri();
		} else {
			$dir = $this->option['base_dir'];
		}

		$output = '';
		foreach ( $this->option['options'] as $key => $image_data ) {
			$input_classes = $classes;
			$selected      = '';
			$checked       = '';
			$attr          = '';

			if ( $this->val == $key ) {
				$selected = ' of-radio-img-selected';
				$checked  = ' checked="checked"';
			}

			if ( ! empty( $show_hide[ $key ] ) ) {
				$input_classes[] = 'js-hider-show';

				if ( true !== $show_hide[ $key ] ) {

					if ( is_array( $show_hide[ $key ] ) ) {
						$data_js_target = implode( ', .', $show_hide[ $key ] );
					} else {
						$data_js_target = $show_hide[ $key ];
					}

					$attr = ' data-js-target="' . $data_js_target . '"';
				}
			}

			$output .= '<div class="of-radio-img-inner-container">';

			$output .= '<input type="radio" id="' . esc_attr( $this->option['id'] . '_' . $key ) . '" class="' . esc_attr( implode( ' ', $input_classes ) ) . '"' . $attr . ' value="' . esc_attr( $key ) . '" name="' . esc_attr( $this->option_name ) . '" ' . $checked . ' />';

			$img_info = '';
			if ( is_array( $image_data ) && isset( $image_data['src'], $image_data['title'] ) ) {
				$img   = $dir . $image_data['src'];
				$title = $image_data['title'];

				if ( $title ) {

					$img_title_style = '';
					if ( isset( $image_data['title_width'] ) ) {
						$img_title_style = ' style="width: ' . absint( $image_data['title_width'] ) . 'px;"';
					}

					$img_info = '<div class="of-radio-img-label"' . $img_title_style . '>' . esc_html( $title ) . '</div>';
				}
			} else if ( $image_data !== $key ) {
				$img   = $dir . $image_data;
				$title = $image_data;
			} else {
				$img             = presscore_get_default_small_image();
				$img             = $img[0];
				$title           = $image_data;
				$img_title_style = '';
				if ( isset( $image_data['title_width'] ) ) {
					$img_title_style = ' style="width: ' . absint( $image_data['title_width'] ) . 'px;"';
				}

				$img_info = '<div class="of-radio-img-label"' . $img_title_style . '>' . esc_html( $title ) . '</div>';
			}

			$output .= '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( $title ) . '" class="of-radio-img-img' . $selected . '" onclick="dtRadioImagesSetCheckbox(\'' . esc_attr( $this->option['id'] . '_' . $key ) . '\');" />';

			$output .= $img_info;

			$output .= '</div>';
		}

		return $output;
	}
}