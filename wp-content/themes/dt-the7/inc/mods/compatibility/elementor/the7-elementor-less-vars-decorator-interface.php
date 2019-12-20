<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor;

use The7_Less_Vars_Manager_Interface;

defined( 'ABSPATH' ) || exit;

interface The7_Elementor_Less_Vars_Decorator_Interface extends The7_Less_Vars_Manager_Interface {

	public function add_set_of_responsive_keywords( $base_var, $values, $defaults );

}
