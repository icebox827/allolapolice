<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Sortable extends The7_Option_Field_Abstract {

	public function html() {
		$output = '';

		if ( ! empty( $this->option['items'] ) ) {
			$sortable_items = $this->option['items'];
		} else {
			return '<p>No items specified. It needs array( id1 => name1, id2 => name2 ).</p>';
		}

		$saved_items = isset( $this->val ) ? (array) $this->val : array();
		$config_icon = '<span class="sortConfigIcon of-icon-edit"></span>';

		if ( ! empty( $this->option['fields'] ) && is_array( $this->option['fields'] ) ) {

			$output .= '<div class="sortable-fields-holder">';

			foreach ( $this->option['fields'] as $field_id => $field_settings ) {

				// classes
				$field_classes = 'connectedSortable content-holder';
				if ( ! empty( $field_settings['class'] ) ) {
					$field_classes .= ' ' . $field_settings['class'];
				}

				// items name
				$item_name = esc_attr( sprintf( '%s[%s][]', $this->option_name, $field_id ) );

				// saved items
				$saved_field_items = array_key_exists( $field_id, $saved_items ) ? $saved_items[ $field_id ] : array();

				// field title
				if ( ! empty( $field_settings['title'] ) ) {
					$output .= '<div class="sortable-field-title">' . esc_html( $field_settings['title'] ) . '</div>';
				}

				$output .= '<div class="sortable-field">';

				// output fields
				$output .= '<ul class="' . esc_attr( $field_classes ) . '" data-sortable-item-name="' . $item_name . '">';

				$output .= '<li class="ui-dt-sb-hidden"><input type="hidden" name="' . $item_name . '" value="" /></li>';

				if ( ! empty( $saved_field_items ) && is_array( $saved_field_items ) ) {

					foreach ( $saved_field_items as $item_value ) {

						if ( ! array_key_exists( $item_value, $sortable_items ) ) {
							continue;
						}

						$item_settings = $sortable_items[ $item_value ];
						$item_title    = empty( $item_settings['title'] ) ? 'undefined' : esc_html( $item_settings['title'] );
						$item_class    = empty( $item_settings['class'] ) ? '' : ' ' . esc_attr( $item_settings['class'] );

						$output .= '<li class="ui-state-default sortable-field-' . esc_attr( $item_value ) . $item_class . '"><input type="hidden" name="' . $item_name . '" value="' . esc_attr( $item_value ) . '" /><span class="sortable-element-title" data-title="' . esc_attr( $item_title ) . '">' . $item_title . '</span>' . $config_icon . '</li>';

						// remove item from palette list
						unset( $sortable_items[ $item_value ] );

					}
				}

				$output .= '</ul>';

				$output .= '</div>';

			}

			$output .= '</div>';

		}

		$output .= '<div class="sortable-items-holder">';

		// palette title
		if ( ! empty( $this->option['palette_title'] ) ) {
			$output .= '<div class="sortable-palette-title">' . esc_html( $this->option['palette_title'] ) . '</div>';
		}

		$output .= '<ul class="connectedSortable tools-palette">';

		foreach ( $sortable_items as $item_value => $item_settings ) {

			$item_title = empty( $item_settings['title'] ) ? 'undefined' : esc_html( $item_settings['title'] );
			$item_class = empty( $item_settings['class'] ) ? '' : ' ' . esc_attr( $item_settings['class'] );

			$output .= '<li class="ui-state-default sortable-field-' . esc_attr( $item_value ) . $item_class . '"><input type="hidden" value="' . esc_attr( $item_value ) . '" /><span class="sortable-element-title" data-title="' . esc_attr( $item_title ) . '">' . $item_title . '</span>' . $config_icon . '</li>';
		}

		$output .= '</ul>';

		$output .= '</div>';

		return $output;
	}
}