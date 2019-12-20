<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Fields_Generator extends The7_Option_Field_Abstract {

	public function html() {
		if ( ! isset( $this->option['options']['fields'] ) || ! is_array( $this->option['options']['fields'] ) ) {
			return '';
		}

		$del_link = '<div class="submitbox"><a href="#" class="of_fields_gen_del submitdelete">' . _x( 'Delete', 'backend fields', 'the7mk2' ) . '</a></div>';

		$output = '';
		$output .= '<ul class="of_fields_gen_list">';

		// saved elements
		if ( is_array( $this->val ) ) {

			// create elements
			foreach ( $this->val as $index => $field ) {

				$block = $b_title = '';
				// use patterns
				foreach ( $this->option['options']['fields'] as $name => $data ) {

					// if only_for list isset and current index not in the list - skip this element
					if ( isset( $data['only_for'] ) && is_array( $data['only_for'] ) && ! in_array( $index, $data['only_for'] ) ) {
						continue;
					}

					// checked если поле присутствует в записи, если нет поля value в шаблоне
					// или если оно есть и равно значению поля в записи
					$checked = false;
					if ( isset( $field[ $name ] ) && ( ! isset( $data['value'] ) || ( isset( $data['value'] ) && $data['value'] == $field[ $name ] ) ) ) {
						$checked = true;
					}

					// get the title
					if ( isset( $data['class'] ) && 'of_fields_gen_title' === $data['class'] ) {
						$b_title = $field[ $name ];
					}

					$el_args = array(
						'name'        => sprintf( '%s[%d][%s]', $this->option_name, $index, $name ),
						'description' => isset( $data['description'] ) ? $data['description'] : '',
						'class'       => isset( $data['class'] ) ? $data['class'] : '',
						'value'       => ( 'checkbox' === $data['type'] ) ? '' : $field[ $name ],
						'checked'     => $checked,
					);

					if ( 'select' === $data['type'] ) {
						$el_args['options']  = isset( $data['options'] ) ? $data['options'] : array();
						$el_args['selected'] = $el_args['value'];
					}

					if ( isset( $data['desc_wrap'] ) ) {
						$el_args['desc_wrap'] = $data['desc_wrap'];
					}

					if ( isset( $data['wrap'] ) ) {
						$el_args['wrap'] = $data['wrap'];
					}

					if ( isset( $data['style'] ) ) {
						$el_args['style'] = $data['style'];
					}

					// create form elements
					$element = dt_create_tag( $data['type'], $el_args );

					$block .= $element;
				}

				$output .= '<li class="nav-menus-php nav-menu-index-' . $index . '">';
				$output .= '<div class="of_fields_gen_title menu-item-handle" data-index="' . $index . '"><span class="dt-menu-item-title">' . esc_attr( $b_title ) . '</span>';
				$output .= '<span class="item-controls"><a class="item-edit"></a></span></div>';
				$output .= '<div class="of_fields_gen_data menu-item-settings description" style="display: none;">' . $block;
				$output .= $del_link;
				$output .= '</div>';
				$output .= '</li>';
			}
		}

		$output .= '</ul>';

		// control panel
		$output .= '<div class="of_fields_gen_controls">';

		if ( ! empty( $this->option['options']['title'] ) ) {
			$output .= '<div class="name">' . esc_html( $this->option['options']['title'] ) . '</div>';
		}

		// use pattern
		foreach ( $this->option['options']['fields'] as $name => $data ) {
			if ( isset( $data['only_for'] ) ) {
				continue;
			}

			$el_args = array(
				'name'        => sprintf( '%s[%s]', $this->option_name, $name ),
				'description' => isset( $data['description'] ) ? $data['description'] : '',
				'class'       => isset( $data['class'] ) ? $data['class'] : '',
				'checked'     => isset( $data['checked'] ) ? $data['checked'] : false,
			);

			if ( 'select' === $data['type'] ) {
				$el_args['options']  = isset( $data['options'] ) ? $data['options'] : array();
				$el_args['selected'] = isset( $data['selected'] ) ? $data['selected'] : false;
			}

			if ( isset( $data['desc_wrap'] ) ) {
				$el_args['desc_wrap'] = $data['desc_wrap'];
			}

			if ( isset( $data['wrap'] ) ) {
				$el_args['wrap'] = $data['wrap'];
			}

			if ( isset( $data['style'] ) ) {
				$el_args['style'] = $data['style'];
			}

			if ( isset( $data['value'] ) ) {
				$el_args['value'] = $data['value'];
			}

			// create form
			$element = dt_create_tag( $data['type'], $el_args );

			$output .= $element;
		}

		// add button
		$button = dt_create_tag( 'button', array(
			'name'  => $this->option_name . '[add]',
			'title' => isset( $this->option['options']['button']['title'] ) ? $this->option['options']['button']['title'] : _x( 'Add', 'backend fields button', 'the7mk2' ),
			'class' => 'of_fields_gen_add button-secondary',
		) );

		$output .= $button;

		$output .= '</div>';

		return $output;
	}
}