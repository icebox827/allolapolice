<?php
/**
 * Less related functions.
 *
 * @package the7
 * @since   1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This function returns less vars array to use with phpless.
 *
 * @return array
 */
function presscore_compile_less_vars() {
	$less_vars = the7_get_new_less_vars_manager();

	do_action( 'presscore_setup_less_vars', $less_vars );

	return apply_filters( 'presscore_compiled_less_vars', $less_vars->get_vars() );
}

if ( ! function_exists( 'the7_get_new_less_vars_manager' ) ) {

	/**
	 * Factory for The7_Less_Vars_Manager.
	 *
	 * @since 5.7.0
	 *
	 * @return The7_Less_Vars_Manager
	 */
	function the7_get_new_less_vars_manager() {
		return new The7_Less_Vars_Manager( new Presscore_Lib_SimpleBag(), new The7_Less_Vars_Factory() );
	}
}

if ( ! function_exists( 'the7_get_new_shortcode_less_vars_manager' ) ) {

	/**
	 * Factory function for shortcode less manager.
	 *
	 * @since 7.7.0
	 *
	 * @return The7_Less_Vars_Shortcode_Manager
	 */
	function the7_get_new_shortcode_less_vars_manager() {
		return new The7_Less_Vars_Shortcode_Manager( new Presscore_Lib_SimpleBag(), new The7_Less_Vars_Factory() );
	}

}

/**
 * Helper that returns array of accent less vars.
 *
 * @since 6.6.0
 *
 * @param  The7_Less_Vars_Manager_Interface $less_vars
 *
 * @return array Returns array like array( 'first-color', 'seconf-color' )
 */
function the7_less_get_accent_colors( The7_Less_Vars_Manager_Interface $less_vars ) {
	$accent_less_vars_names = array( 'accent-bg-color', 'accent-bg-color-2' );
	switch ( of_get_option( 'general-accent_color_mode' ) ) {
		case 'gradient':
			$gradient_obj = the7_less_create_gradient_obj( of_get_option( 'general-accent_bg_color_gradient' ) );
			list( $first_color, $gradient ) = the7_less_prepare_gradient_var( $gradient_obj );
			$accent_colors = array( $first_color, $gradient_obj );
			$less_vars->add_rgba_color( $accent_less_vars_names[0], $first_color );
			$less_vars->add_keyword( $accent_less_vars_names[1], $gradient );
			break;
		case 'color':
		default:
			$accent_colors = array( of_get_option( 'general-accent_bg_color' ), the7_less_create_gradient_obj() );
			$less_vars->add_hex_color( $accent_less_vars_names, $accent_colors );
	}

	return $accent_colors;
}

/**
 * Prepare gradient string to be exported as a less var.
 *
 * @since 6.6.0
 *
 * @param string|array|The7_Less_Gradient $gradient
 *
 * @return array
 */
function the7_less_prepare_gradient_var( $gradient ) {
	if ( is_a( $gradient, 'The7_Less_Gradient' ) ) {
		$gradient_obj = $gradient;
	} else {
		$gradient_obj = the7_less_create_gradient_obj( $gradient );
	}

	return array(
		$gradient_obj->get_color_stop( 1 )->get_color(),
		$gradient_obj->get_string(),
	);
}

/**
 * Return new The7_Less_Gradient object.
 *
 * @since 6.6.0
 *
 * @param string|array $gradient
 *
 * @return The7_Less_Gradient
 */
function the7_less_create_gradient_obj( $gradient = null ) {
	if ( is_array( $gradient ) && isset( $gradient[0], $gradient[1] ) ) {
		$gradient = "135deg|{$gradient[0]} 30%|{$gradient[1]} 100%";
	}

	return new The7_Less_Gradient( $gradient );
}
