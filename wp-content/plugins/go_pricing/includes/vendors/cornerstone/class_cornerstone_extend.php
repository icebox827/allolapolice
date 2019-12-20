<?php
/**
 * Cornerstone Extend class
 */


/* Prevent direct call */
if ( ! defined( 'WPINC' ) ) { die; }

class GW_GoPricing_Cornerstone_Extend {

	protected static $instance = null;
	protected $url;
	protected $path;	
	
 
	/**
	 * Return an instance of this class
	 *
	 * @return object
	 */
	 
	public static function instance() {
		
		if ( self::$instance == null ) self::$instance = new self;
		return self::$instance;
		
	}	
 
 	/**
	 * Constructor of the class
	 */

	public function __construct() {
		
         $this->_init();
		 
    }
 

  	/**
	 * Init function
	 */
 
 	private function _init() {

		if ( !function_exists( 'cornerstone_register_element' ) ) return;
		
		$this->path = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );		
	
		add_action( 'cornerstone_register_elements', array( $this, 'cornerstone_register' ) );
		add_filter( 'cornerstone_icon_map', array( $this, 'icon_map' ) );				
		
	}
 
	/**
	 * Add to Cornerstone
	 */ 
 
    public function cornerstone_register() {
		
		cornerstone_register_element( 'CS_Go_Pricing', 'go_pricing', $this->path . 'includes' );
				
    }
	
	/**
	 * Register Icon
	 */ 
 
    public function icon_map( $icon_map ) {
		
		$icon_map['go_pricing'] = $this->url . 'assets/go_pricing_icon.svg';
		return $icon_map;
						
    }
	
	/**
	 * Return URL
	 */ 
 
    public function url() {
		
		return $this->url;
    }		

}
