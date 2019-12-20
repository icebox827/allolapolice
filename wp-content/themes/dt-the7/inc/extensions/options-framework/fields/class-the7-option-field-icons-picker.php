<?php
defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Option_Field_Icons_Picker
 */
class The7_Option_Field_Icons_Picker extends The7_Option_Field_Abstract {

	public function html() {
		$field_id    = $this->option['id'];
		$allow_empty = isset( $this->option['allow_empty_value'] ) ? (bool) $this->option['allow_empty_value'] : false;
		$icons       = isset( $this->option['default_icons'] ) ? array( _x( 'Default', 'theme options', 'the7mk2' ) => (array) $this->option['default_icons'] ) : array();
		$icon_class  = isset( $this->option['icon_class'] ) ? $this->option['icon_class'] : 'moon-icon';

		return self::static_html( $this->option_name, $field_id, $this->val, array(
			'allow_empty' => $allow_empty,
			'icons'       => $icons,
			'icon_class'  => $icon_class,
		) );
	}

	/**
	 * Return icons picker HTML.
	 *
	 * @param string $name   Input name.
	 * @param string $id     Field id.
	 * @param string $value  Value string.
	 * @param array  $config Config.
	 *
	 * @return string
	 */
	public static function static_html( $name, $id, $value, $config = array() ) {
		$config = wp_parse_args( $config, array(
			'icons'             => array(),
			'allow_empty'       => false,
			'value_input_class' => '',
			'icon_class'        => 'moon-icon',
		) );

		$value = $value ? (string) $value : '';
		$icons = array();

		if ( $config['allow_empty'] ) {
			$icons['Empty'] = array( '' );
		}

		$icons = array_merge( $icons, $config['icons'] );

		/**
		 * Filter default icons set.
		 *
		 * @param array $icons
		 */
		$icons = apply_filters( 'the7_default_icons_in_settings', $icons );

		$output = '';

		$output .= '<div class="of-icons_picker-controls of-icons_picker-list-sub-is-closed">';
		$output .= '<input type="hidden" name="' . esc_attr( $name ) . '" class="of-icons_picker-value ' . esc_attr( $config['value_input_class'] ) . '" value="' . esc_attr( $value ) . '" />';
		$output .= '<ul class="of-icons_picker-list">';
		$output .= '<li class="of-icons_picker-selector" data-icon="' . esc_attr( $value ) . '"><i class="' . esc_attr( $config['icon_class'] ) . ' ' . esc_attr( $value ) . '"></i><span class="selector-button"><i class="of-icon-closed icomoon-the7-font-the7-arrow-29-1"></i><i class="of-icon-opened icomoon-the7-font-the7-arrow-29-0"></i></span>';
		$output .= '<ul class="of-icons_picker-list-sub">';
		$output .= '<input type="search" class="of-icons_picker-search widefat" placeholder="' . esc_attr( _x( 'Filter icons', 'admin', 'the7mk2' ) ) . '">';
		foreach ( $icons as $font => $icon_set ) {
			$output .= '<p class="of-icons_picker-list-group">' . esc_html( $font ) . '</p>';
			foreach ( $icon_set as $icon ) {
				$icon_att = esc_attr( $icon );
				$selected = $icon === $value ? 'class="selected"' : '';
				$output   .= '<li ' . $selected . ' data-icon="' . $icon_att . '" title="' . $icon_att . '">';
				$output   .= '<i class="' . esc_attr( $config['icon_class'] ) . ' ' . $icon_att . '"></i><label class="moon-icon">' . $icon_att . '</label>';
				$output   .= '</li>';
			}
		}
		$output .= '</ul>';
		$output .= '</li>';
		$output .= '</ul>';
		$output .= '</div>';

		return $output;
	}
}
