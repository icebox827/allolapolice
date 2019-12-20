<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Background_Img extends The7_Option_Field_Composition_Abstract {

	public function html() {
		$preset_images = empty( $this->option['preset_images'] ) ? presscore_opts_get_bg_images( $this->option['id'] ) : $this->option['preset_images'];
		$output        = '';

		if ( $preset_images ) {

			$output .= '<div class="of-background-preset-images">';

			if ( empty( $this->option['images_base_dir'] ) ) {
				$dir = get_template_directory_uri();
			} else {
				$dir = $this->option['images_base_dir'];
			}

			foreach ( $preset_images as $full_src => $thumb_src ) {
				$selected = '';
				$img      = $dir . $thumb_src;
				$data_img = $dir . $full_src;

				if ( strpos( $this->val['image'], $full_src ) !== false ) {
					$selected = ' of-radio-img-selected';
				}

				$output .= '<img data-full-src="' . esc_attr( $data_img ) . '" src="' . esc_url( $img ) . '" alt="' . esc_attr_x( 'Preset image', 'backend fields', 'the7mk2' ) . '" class="of-radio-img-img' . $selected . '" width="47" height="47" />';
			}

			$output .= '</div>';

		}

		$background = $this->val;

		// Background Image
		if ( ! isset( $background['image'] ) ) {
			$background['image'] = '';
		}

		$id = $this->option['id'];
		$upload_definition = array(
			'id'   => $id,
			'type' => 'upload',
		);

		$uploader_obj = $this->interface->get_field_object( $this->option_name . '[image]', $upload_definition, array( $id => $background['image'] ) );
		$output .= $uploader_obj->html();

		$class = 'of-background-properties';

		if ( '' === $background['image'] ) {
			$class .= ' hide';
		}

		$output .= '<div class="' . esc_attr( $class ) . '">';

		if ( ! isset( $this->option['fields'] ) || in_array( 'repeat', (array) $this->option['fields'] ) ) {

			// Background Repeat
			$output  .= '<select class="of-background of-background-repeat" name="' . esc_attr( $this->option_name . '[repeat]' ) . '" id="' . esc_attr( $this->option['id'] . '_repeat' ) . '">';
			$repeats = of_recognized_background_repeat();

			foreach ( $repeats as $key => $repeat ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>' . esc_html( $repeat ) . '</option>';
			}
			$output .= '</select>';

		}

		if ( ! isset( $this->option['fields'] ) || in_array( 'position_x', (array) $this->option['fields'] ) ) {

			// Background Position x
			$output    .= '<select class="of-background of-background-position" name="' . esc_attr( $this->option_name . '[position_x]' ) . '" id="' . esc_attr( $this->option['id'] . '_position_x' ) . '">';
			$positions = of_recognized_background_horizontal_position();

			foreach ( $positions as $key => $position ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position_x'], $key, false ) . '>' . esc_html( $position ) . '</option>';
			}
			$output .= '</select>';

		}

		if ( ! isset( $this->option['fields'] ) || in_array( 'position_y', (array) $this->option['fields'] ) ) {

			// Background Position y
			$output    .= '<select class="of-background of-background-position" name="' . esc_attr( $this->option_name . '[position_y]' ) . '" id="' . esc_attr( $this->option['id'] . '_position_y' ) . '">';
			$positions = of_recognized_background_vertical_position();

			foreach ( $positions as $key => $position ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position_y'], $key, false ) . '>' . esc_html( $position ) . '</option>';
			}
			$output .= '</select>';

		}

		// Background Attachment

		$output .= '</div>';

		return $output;
	}
}