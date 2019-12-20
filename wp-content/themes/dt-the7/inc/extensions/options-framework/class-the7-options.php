<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class The7_Options implements The7_Options_Interface {

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @var array
	 */
	protected $containers = array();

	/**
	 * @var array
	 */
	protected $fields = array();

	/**
	 * The7_Options constructor.
	 *
	 * @param array $options
	 */
	public function __construct( $options ) {
		$this->options = (array) $options;
	}

	/**
	 * @param string $cur_page_id
	 * @param string $active_tab
	 */
	public function render_tabs_html( $cur_page_id, $active_tab ) {
		$is_first = true;
		foreach ( $this->options as $value ) {
			if ( isset( $value['type'] ) && $value['type'] === 'heading' ) {
				$tab_id    = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
				$tab_id    = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $tab_id ) ) . '-tab';
				$tab_url   = add_query_arg( array(
					'page' => $cur_page_id,
					'tab'  => $tab_id,
				), admin_url( 'admin.php', 'relative' ) );
				$tab_class = array( 'nav-tab', $tab_id );

				if ( $tab_id === $active_tab || ( $is_first && ! $active_tab ) ) {
					$tab_class[] = 'nav-tab-active';
				}
				$is_first = false;
				echo '<a id="' . esc_attr( $tab_id ) . '" class="' . implode( ' ', $tab_class ) . '" title="' . esc_attr( $value['name'] ) . '" href="' . esc_url_raw( $tab_url ) . '">' . esc_html( $value['name'] ) . '</a>';
			}
		}
	}

	/**
	 * @param string $options_base_name
	 * @param array  $settings
	 *
	 * @return string
	 */
	public function render_options_html( $options_base_name, $settings ) {
		$options_html = '';

		foreach ( $this->options as $option ) {
			if ( ! is_array( $option ) || ! array_key_exists( 'type', $option ) ) {
				continue;
			}

			$option_name = $this->get_option_name( $options_base_name, $option );
			$option_obj  = $this->get_field_object( $option_name, $option, $settings );
			if ( ! $option_obj ) {
				continue;
			}

			echo $this->do_container_closing_tag( $option_obj );

			if ( $option_obj->need_wrap() ) {
				$output = $this->wrap_option( $option_obj );
			} else {
				$output = $option_obj->html();
			}

			if ( isset( $option['dependency'] ) ) {
				optionsframework_fields_dependency()->set( $option['id'], $option['dependency'] );
			}

			$val = $option_obj->get_value();
			do_action( 'options-interface-before-output', $output, $option, $val );

			echo apply_filters( 'options-interface-output', $output, $option, $val );
		}

		echo $this->do_containers_closing_tag();

		return $options_html;
	}

	/**
	 * @param The7_Option_Field_Interface $option_obj
	 *
	 * @return string
	 */
	public function wrap_option( The7_Option_Field_Interface $option_obj ) {
		$output = '';
		$option = $option_obj->get_option();
		$val    = $option_obj->get_value();

		if ( ! empty( $option['before'] ) ) {
			$output .= $option['before'];
		}

		$data_attr = '';
		if ( is_string( $val ) ) {
			$data_attr .= ' data-value="' . esc_attr( $val ) . '"';
		}

		// Keep all ids lowercase with no spaces
		$option['id'] = preg_replace( '/(\W!-)/', '', strtolower( $option['id'] ) );

		$id = 'section-' . $option['id'];

		$class = 'section';
		if ( isset( $option['type'] ) ) {
			$class .= ' section-' . $option['type'];
		}
		if ( isset( $option['class'] ) ) {
			$class .= ' ' . $option['class'];
		}

		if ( isset( $_GET['mark'] ) && $option['id'] === $_GET['mark'] ) {
			$class .= ' marked';
		}

		$output .= '<div id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '"' . $data_attr . '>' . "\n";

		if ( isset( $option['divider'] ) && in_array( $option['divider'], array( 'top', 'surround' ) ) ) {
			$output .= '<div class="divider"></div>' . "\n";
		}

		$output .= '<div class="option">' . "\n";

		if ( ! empty( $option['name'] ) ) {

			$output .= '<div class="name">' . ( ! empty( $option['name'] ) ? esc_html( $option['name'] ) : '' ) . "\n";

			if ( isset( $option['desc'] ) ) {
				$explain_value = $option['desc'];
				$output        .= '<div class="explain"><small>' . esc_html( $explain_value ) . '</small></div>' . "\n";
			}

			$output .= '</div>' . "\n";
		}

		if ( $option['type'] !== 'editor' ) {

			if ( empty( $option['name'] ) ) {
				$output .= '<div class="controls controls-fullwidth">' . "\n";
			} else {
				$output .= '<div class="controls">' . "\n";
			}
		} else {
			$output .= '<div>' . "\n";
		}

		$output .= $option_obj->html();

		$output .= '</div>';

		$output .= '<div class="clear"></div>';

		$optionsframework_debug = presscore_options_debug();
		$do_not_export          = apply_filters( 'optionsframework_fields_black_list', array() );
		$preserved_options      = apply_filters( 'optionsframework_validate_preserve_fields', array() );

		/**
		 * Debug message.
		 */
		if ( $optionsframework_debug ) {
			$output .= '<div class="of-debug-fields">';

			// ID.
			$output .= '<div class="of-debug-field of-debug-option-id">ID: <code>' . esc_html( $option['id'] ) . '</code></div>';

			// STD.
			$debug_std = null;
			if ( isset( $option['std'] ) && ! is_array( $option['std'] ) ) {
				$debug_std = $option['std'];
			} else if ( isset( $option['std'] ) && 'gradient' === $option['type'] ) {
				$debug_std = implode( ', ', $option['std'] );
			}

			if ( null !== $debug_std ) {
				$output .= '<div class="of-debug-field of-debug-option-std">STD: <code>' . esc_html( $debug_std ) . '</code></div>';
			}

			// EXPORT.
			if ( in_array( $option['id'], $do_not_export ) ) {
				$output .= '<div class="of-debug-field of-debug-option-exportable">EXPORTABLE: <code>no</code></div>';
			}

			// PRESERVE.
			if ( in_array( $option['id'], $preserved_options ) ) {
				$output .= '<div class="of-debug-field of-debug-option-preserved">PRESERVED: <code>yes</code></div>';
			}

			$output .= '</div>';
		}

		$output .= '</div>';

		if ( isset( $option['divider'] ) && in_array( $option['divider'], array( 'bottom', 'surround' ) ) ) {
			$output .= '<div class="divider"></div><!-- divider -->' . "\n";
		}

		$output .= '</div>';

		if ( ! empty( $option['after'] ) ) {
			$output .= $option['after'];
		}

		return $output;
	}

	/**
	 * @param string $option_name
	 * @param array  $option
	 * @param array  $settings
	 *
	 * @return The7_Option_Field_Interface|null
	 */
	public function get_field_object( $option_name, $option, $settings ) {
		if ( ! isset( $option['type'] ) ) {
			return null;
		}

		$class_name = 'The7_Option_Field_' . implode( '_', array_map( 'ucfirst', explode( '_', $option['type'] ) ) );
		if ( ! class_exists( $class_name ) ) {
			return null;
		}

		if ( ! isset( $this->fields[ $class_name ] ) ) {
			$option_obj = new $class_name();

			if ( ! is_a( $option_obj, 'The7_Option_Field_Interface' ) ) {
				return null;
			}

			if ( is_a( $option_obj, 'The7_Option_Field_Exporter_Interface' ) ) {
				$option_obj->with_settings( $settings, $this->get_all_options_definitions() );
			}

			if ( is_a( $option_obj, 'The7_Option_Field_Composition_Interface' ) ) {
				$option_obj->with_interface( $this );
			}

			$this->fields[ $class_name ] = $option_obj;
		}

		if ( isset( $option['id'], $settings[ $option['id'] ] ) ) {
			$val = $settings[ $option['id'] ];
		} else {
			$val = null;
		}

		$this->fields[ $class_name ]->setup( $option_name, $option, $val );

		return $this->fields[ $class_name ];
	}

	/**
	 * @param string $options_base_name
	 * @param array  $option
	 *
	 * @return string
	 */
	public function get_option_name( $options_base_name, $option ) {
		if ( ! isset( $option['id'] ) ) {
			return '';
		}

		return $options_base_name . '[' . $option['id'] . ']';
	}

	/**
	 * Return all options definitions if `optionsframework_get_page_options` exists, empty array otherwise.
	 *
	 * @uses optionsframework_get_page_options
	 *
	 * @return array
	 */
	protected function get_all_options_definitions() {
		if ( function_exists( 'optionsframework_get_page_options' ) ) {
			return (array) optionsframework_get_page_options( false );
		}

		return array();
	}

	/**
	 * @param The7_Option_Field_Interface $option_obj
	 *
	 * @return string
	 */
	protected function do_container_closing_tag( The7_Option_Field_Interface $option_obj ) {
		if ( ! is_a( $option_obj, 'The7_Option_Field_Container_Interface' ) ) {
			return '';
		}

		$container = get_class( $option_obj );

		// Add new container type to stack.
		if ( ! in_array( $container, $this->containers, true ) ) {
			$this->containers[] = $container;

			return '';
		}

		// Do closing tags if container type already in stack.
		$index            = array_search( $container, $this->containers, true );
		$containers       = array_reverse( array_slice( $this->containers, $index ) );
		$this->containers = array_slice( $this->containers, 0, $index + 1 );

		$output = '';
		foreach ( $containers as $class ) {
			if ( isset( $this->fields[ $class ] ) ) {
				$output .= $this->fields[ $class ]->closing_tag();
			}
		}

		return $output;
	}

	/**
	 * @return string
	 */
	protected function do_containers_closing_tag() {
		$containers = array_reverse( $this->containers );

		$output = '';
		foreach ( $containers as $class ) {
			if ( isset( $this->fields[ $class ] ) ) {
				$output .= $this->fields[ $class ]->closing_tag();
			}
		}

		return $output;
	}
}