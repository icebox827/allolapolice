<?php

interface The7_Less_Gradient_Color_Stop_Interface {

	/**
	 * @param mixed $val
	 *
	 * @return The7_Less_Gradient_Color_Stop_Interface
	 */
	public function with_opacity( $val );

	/**
	 * @return string
	 */
	public function get_string();

	/**
	 * @return string
	 */
	public function get_color();

}