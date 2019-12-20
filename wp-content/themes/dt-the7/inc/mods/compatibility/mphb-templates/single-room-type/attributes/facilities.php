<?php

/**
 * Available variables
 * - WP_Term[] $facilities
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( !empty( $facilities ) ) : ?>

	<?php

	/**
	 * @hooked \MPHB\Views\SingleRoomTypeView::_renderFacilitiesListItemOpen			- 10
	 * @hooked \MPHB\Views\SingleRoomTypeView::_renderFacilitiesTitle					- 20
	 * @hooked \MPHB\Views\SingleRoomTypeView::_renderAttributesListItemValueHolderOpen	- 30
	 */
	do_action( 'mphb_render_single_room_type_before_facilities' );

	$facilities = array_map( function( $facility ) {

		$facilityLink = get_term_link( $facility );

		if ( is_wp_error( $facilityLink ) ) {
			$facilityLink = '#';
		}

		$facilityLink = sprintf( '<a href="%s">%s</a>', esc_url( $facilityLink ), $facility->name );
		$html = '<li><span class="' . esc_attr( 'facility-' . $facility->slug ) . '">' . $facilityLink . '</span></li>';

		return $html;
	}, $facilities );

	$itemsDelimeter = apply_filters( 'mphb_room_type_facilities_delimiter', '' );

	echo '<ul class="mphb-attribute-value">';
	echo join( $itemsDelimeter, $facilities );
	echo '</ul>';

	/**
	 * @hooked \MPHB\Views\SingleRoomTypeView::_renderAttributesListItemValueHolderClose	- 10
	 * @hooked \MPHB\Views\SingleRoomTypeView::_renderFacilitiesListItemClose				- 20
	 */
	do_action( 'mphb_render_single_room_type_after_facilities' );
	?>

<?php endif; ?>