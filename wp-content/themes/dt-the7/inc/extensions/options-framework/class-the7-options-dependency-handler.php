<?php
/**
 * Theme options dependency class.
 *
 * @since   7.5.0
 * @package The7\Options
 */

/**
 * Theme options dependency class.
 *
 * Support short syntax:
 * array(
 *  'field' => '',
 *  'operator' => '',
 *  'value' => '',
 * );
 *
 * Short AND syntax:
 * array(
 *  array(),
 *  // AND
 *  array(),
 * );
 *
 * Default syntax:
 * array(
 *  array(
 *      array(),
 *  ),
 *  // OR
 *  array(
 *      array(),
 *      // AND
 *      array(),
 *  ),
 * );
 */
class The7_Options_Dependency_Handler {

	/**
	 * @var array
	 */
	protected $dependencies = array();

	/**
	 * Store dependencies.
	 *
	 * @param string $id
	 * @param array  $dep
	 */
	public function set( $id, $dep ) {
		$dep = $this->decode_short_syntax( $dep );

		// AND.
		foreach ( $dep as &$and_parts ) {
			// OR.
			foreach ( $and_parts as &$or_part ) {
				$or_part = $this->prepare_dependency( $or_part );
			}
		}
		unset( $or_part, $and_parts );

		$this->dependencies[ $id ] = $dep;
	}

	/**
	 * Return dependency array.
	 *
	 * @param string $id
	 *
	 * @return array|null
	 */
	public function get( $id ) {
		if ( isset( $this->dependencies[ $id ] ) ) {
			return $this->dependencies[ $id ];
		}

		return null;
	}

	/**
	 * Return all stored dependencies.
	 *
	 * @return array
	 */
	public function get_all() {
		return $this->dependencies;
	}

	/**
	 * Reduce dependency to understandable values.
	 *
	 * @param array $dependency
	 *
	 * @return array
	 */
	protected function prepare_dependency( $dependency ) {
		// Dependency from theme option value.
		if ( isset( $dependency['option'], $dependency['operator'], $dependency['value'] ) ) {
			$option_value = of_get_option( $dependency['option'] );
			switch ( $dependency['operator'] ) {
				case 'IN':
					$result = in_array( $option_value, (array) $dependency['value'], true );
					break;
				case 'NOT_IN':
					$result = ! in_array( $option_value, (array) $dependency['value'], true );
					break;
				case '!=':
					$result = $option_value !== $dependency['value'];
					break;
				case '==':
				default:
					$result = $option_value === $dependency['value'];
			}

			return array(
				'bool_value' => $result,
			);
		}

		return $dependency;
	}

	/**
	 * Decode short syntax.
	 *
	 * @param array $dep
	 *
	 * @return array
	 */
	public function decode_short_syntax( $dep ) {
		if ( $this->maybe_rule_definition( $dep ) ) {
			return array(
				array(
					$dep,
				),
			);
		}

		reset( $dep );
		$and_rule = current( $dep );
		if ( $this->maybe_rule_definition( $and_rule ) ) {
			return array(
				$dep,
			);
		}

		return $dep;
	}

	/**
	 * Test for rule definition.
	 *
	 * @param mixed $rule
	 *
	 * @return bool
	 */
	protected function maybe_rule_definition( $rule ) {
		return isset( $rule['operator'], $rule['value'] ) && ( isset( $rule['field'] ) || isset( $rule['option'] ) );
	}
}
