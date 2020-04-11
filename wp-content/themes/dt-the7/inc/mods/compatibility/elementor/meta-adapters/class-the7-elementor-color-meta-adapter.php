<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor\Meta_Adapters;

use \Color;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Color_Meta_Adapter {

	/**
	 * Update post meta color with opacity.
	 *
	 * @param string                       $val      Color value.
	 * @param array                        $control  Elementor controls array.
	 * @param \Elementor\Core\Base\Document $document Elementor document class.
	 *
	 * @return bool|int
	 */
	public static function update_alpha_color( $val, $control, $document ) {
		if ( ! isset( $control['meta']['color'], $control['meta']['opacity'] ) ) {
			return false;
		}

		if ( empty( $val ) ) {
			$val = $control['args']['default'];
		}

		try {
			$color = new Color( $val );
			$document->update_meta( $control['meta']['color'], '#' . $color->getHex() );
			$document->update_meta( $control['meta']['opacity'], $color->getOpacity() );

			return true;
		} catch ( Exception $e ) {
			error_log( $e->getMessage() );

			return false;
		}
	}

	/**
	 * Return rgba color combined from post meta.
	 *
	 * @param array                        $control  Elementor controls array.
	 * @param \Elementor\Core\Base\Document $document Elementor document class.
	 *
	 * @return string
	 */
	public static function get_alpha_color( $control, $document ) {
		if ( ! isset( $control['meta']['color'], $control['meta']['opacity'] ) ) {
			return $control['args']['default'];
		}

		$color      = $document->get_meta( $control['meta']['color'], true );
		$opacity    = $document->get_meta( $control['meta']['opacity'], true );
		$rgba_color = dt_stylesheet_color_hex2rgba( $color, $opacity );

		if ( ! $rgba_color ) {
			$rgba_color = $control['args']['default'];
		}

		return $rgba_color;
	}

}
