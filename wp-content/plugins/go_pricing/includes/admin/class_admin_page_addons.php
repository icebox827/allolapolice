<?php
/**
 * Add-ons page controller class
 */
 
 
// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


// Class
class GW_GoPricing_AdminPage_Addons extends GW_GoPricing_AdminPage {
	
	/**
	 * Register ajax actions
	 *
	 * @return void
	 */	

	public function register_ajax_actions( $ajax_action_callback ) { 
		
	}
	

	/**
	 * Action
	 *
	 * @return void
	 */	
	 	
	public function action() {
		
		// Load views if action is empty		
		if ( empty( $this->action ) ) {
			
			$this->content( $this->view() );
			
		}
			
	}
	
	
	/**
	 * Load views
	 *
	 * @return string
	 */	
	
	public function view( $view = '', $data = null ) {

		ob_start();
		include_once( 'views/page/addons.php' );
		return ob_get_clean();
		
	}
	
}
 

?>