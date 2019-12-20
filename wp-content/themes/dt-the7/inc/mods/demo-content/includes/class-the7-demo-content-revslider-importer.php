<?php

/**
 * Class The7_Demo_Content_Revslider_Importer
 */
class The7_Demo_Content_Revslider_Importer {

	/**
	 * @var null|RevSlider
	 */
	protected $revslider;

	/**
	 * @var array
	 */
	protected $existedSliders = array();

	/**
	 * The7_Demo_Content_Revslider_Importer constructor.
	 */
	public function __construct() {
		if ( class_exists( 'RevSliderSlider', false ) && method_exists( 'RevSliderSlider', 'importSliderFromPost' ) ) {
			$this->revslider = new RevSlider();

			foreach ( (array) $this->revslider->getArrSliders() as $revSlider ) {
				$this->existedSliders[] = $revSlider->getAlias();
			}
		}
	}

	/**
	 * Import $slider file.
	 *
	 * @param string $slider_alias Slider alias.
	 * @param string $slider_file Absolute path to slider.
	 *
	 * @return array|bool
	 */
	public function import_slider( $slider_alias, $slider_file ) {
		if ( $this->revslider === null || in_array( $slider_alias, $this->existedSliders, true ) ) {
			return false;
		}

		$this->existedSliders[] = $slider_alias;

		return $this->revslider->importSliderFromPost( true, true, $slider_file, false, false, true );
	}
}
