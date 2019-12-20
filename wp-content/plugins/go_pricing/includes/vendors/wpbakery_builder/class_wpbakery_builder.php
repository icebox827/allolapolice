<?php
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;

/**
 * Go Pricing Module for WPBakery Page Builder
 */
class GW_GoPricing_WPBakery_Builder implements Vc_Vendor_Interface {

	public function load() {
		vc_lean_map( 
			'go_pricing',
			array( $this, 'sc_settings' ) 
		);
	}

	/**
	 * Mapping settings for lean method
	 * @param $tag
	 *
	 * @return array
	 */
	public function sc_settings( $tag ) {

		$names = array();
		$pricing_tables = GW_GoPricing_Data::get_tables( '', false, 'title', 'ASC' );

		if ( !empty( $pricing_tables ) ) {
			foreach ( $pricing_tables as $pricing_table ) {
				if ( !empty( $pricing_table['name'] ) && !empty( $pricing_table['id'] ) ) {
					$dropdown_data[sprintf('%1$s (#%2$s)', $pricing_table['name'], $pricing_table['postid'])] = $pricing_table['id'];
				}
			}
		}
		
		if ( empty( $dropdown_data ) ) $dropdown_data[0] = __('No tables found!', 'go_pricing_textdomain' );

		return array (
			'base' => $tag,
			'name' => __( 'Go Pricing', 'go_pricing_textdomain' ),
			'description' => __( 'Amazing responsive pricing tables', 'go_pricing_textdomain' ),
			'base' => 'go_pricing',
			'category' => __( 'Content', 'go_pricing_textdomain' ),	
			'class' => '',
			'icon' => plugin_dir_url( __FILE__ ) . 'assets/icon.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Table Name', 'go_pricing_textdomain' ),
					'param_name' => 'id',
					'value' => $dropdown_data,
					'description' => __( 'Select Pricing Table', 'go_pricing_textdomain' ),
					'admin_label' => true,
					'save_always' => true
				)
			)
		);
	}
}
