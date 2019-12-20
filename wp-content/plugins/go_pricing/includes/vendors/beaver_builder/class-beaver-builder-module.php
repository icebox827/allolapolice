<?php
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;

/**
 * Go Pricing Module for Beaver Builder
 * Module Class
 */
class GW_GoPricing_BeaverBuilderModule extends FLBuilderModule {

    protected static $instance;

    /**
     * Constructor of the class
     */
    public function __construct() {
        parent::__construct(
            array(
                'name' => esc_html__( 'Go Pricing', 'go_pricing_textdomain' ),
                'description' => __( 'The New Generation Pricing Tables', 'go_pricing_textdomain' ),
                'category' => __( 'Granth Modules', 'go_pricing_textdomain' ),
                'icon' => 'assets/icon.svg',
				'partial_refresh' => true 
            )
        );
		

		if ( FLBuilderModel::is_builder_active() !== true ) return;
        $this->add_css( 'go-pricing--bb-module-css', $this->url . 'assets/module.css' );
        $this->add_js( 'go-pricing--bb-module-js', $this->url . 'assets/module.js', array('jquery') , '', true );
    }

}

?>