<?php

/**
 * Element Controls
 */

$pricing_tables = GW_GoPricing_Data::get_tables( '', false, 'title', 'ASC' );

if ( !empty( $pricing_tables ) ) {
	foreach ( $pricing_tables as $pricing_table ) {
		if ( !empty( $pricing_table['name'] ) && !empty( $pricing_table['id'] ) ) {
			$dropdown_data[] = array( 
				'value' =>$pricing_table['id'], 
				'label' => sprintf('%1$s (#%2$s)', $pricing_table['name'], $pricing_table['postid'])
			);
		}
	}
}

if ( empty( $dropdown_data ) ) $dropdown_data[0] = __('No tables found!', 'go_pricing_textdomain' );

return array(
	'go_pricing_table_id' => array(
		'type' => 'select',
		'ui' => array(
			'title' => __( 'Select a table', 'go_pricing_textdomain' ),
			'tooltip' => __( 'Select a pricing table from the list.', 'go_pricing_textdomain' ),
		),
		'options' => array(
			'choices' => $dropdown_data
		)
	)
);