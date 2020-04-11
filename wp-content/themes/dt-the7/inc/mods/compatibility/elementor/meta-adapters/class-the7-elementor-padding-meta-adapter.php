<?php
/**
 * @package The7
 */

namespace The7\Adapters\Elementor\Meta_Adapters;

defined( 'ABSPATH' ) || exit;

class The7_Elementor_Padding_Meta_Adapter {

	/**
	 * Update padding post meta.
	 *
	 * @param string                        $val      Padding value.
	 * @param array                         $control  Elementor controls array.
	 * @param \Elementor\Core\Base\Document $document Elementor document class.
	 *
	 * @return bool|int
	 */
	public static function update_padding( $val, $control, $document ) {
		$margin = '';
		if ( $val['size'] !== '' ) {
			$margin = $val['size'] . $val['unit'];
		}

		return $document->update_meta( $control['meta'], $margin );
	}

	/**
	 * Return dimension array extracted from post meta.
	 *
	 * @param array                         $control  Elementor controls array.
	 * @param \Elementor\Core\Base\Document $document Elementor document class.
	 *
	 * @return array
	 */
	public static function get_padding( $control, $document ) {
		$margin = $document->get_meta( $control['meta'], true );
		preg_match( '/([-0-9]*)(.*)/', $margin, $matches );
		list( $_, $size, $unit ) = $matches;
		$unit = $unit ?: 'px';

		return compact( 'size', 'unit' );
	}

}
