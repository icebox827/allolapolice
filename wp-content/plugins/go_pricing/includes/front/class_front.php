<?php
/**
 * Front core class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
class GW_GoPricing_Front {	

	protected static $instance = null;
	protected $globals;

	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected $plugin_file;
	protected $plugin_base;
	protected $plugin_dir;
	protected $plugin_path;
	protected $plugin_url;


	/**
	 * Initialize the class
	 *
	 * @return void
	 */		  
	 
	public function __construct() {
		
		$this->globals = GW_GoPricing::instance();
		self::$plugin_version = $this->globals['plugin_version'];
		self::$db_version = $this->globals['db_version'];		
		self::$plugin_prefix = $this->globals['plugin_prefix'];
		self::$plugin_slug = $this->globals['plugin_slug'];
		$this->plugin_url = $this->globals['plugin_url'];
		$this->plugin_path = $this->globals['plugin_path'];

		// Enqueue public assets (scripts & styles)
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );		
		
		// Enqueue pluign frontend scripts
		add_action( 'go_pricing/enque_public_scripts', array( $this, 'enqueue_public_styles' ) );
		
		// Enqueue pluing frontend styles		
		add_action( 'go_pricing/enque_public_scripts', array( $this, 'enqueue_public_scripts' ) );	
		
		// Live preview
		add_action( 'init', array( $this, 'live_preview_safe_init' ) );
		add_action( 'wp_head', array( $this, 'live_preview_safe' ) );
		
	}

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
	 * Enqueue public scripts & styles depending on the settings
	 *
	 * @return void
	 */
	 	 
	public function enqueue_public_assets() {
		
		$settings = get_option( self::$plugin_prefix . '_table_settings', array() );
		global $post;		
		
		global $go_pricing_preview;
		if ( isset( $go_pricing_preview ) ) { 
			do_action( 'go_pricing/enque_public_scripts' );
			return;
		}
		
		// Set to global if not set
		// 3.3.8+ default value: auto
		// 3.3.10 + default value: global (auto is not reliable)
		if ( empty( $settings['public_assets'] ) ) $settings['public_assets'] = 'global';		
		
		switch( $settings['public_assets'] ) {

			// Auto detect shortcode
			case 'auto':
				if ( !GW_GoPricing_Helper::has_shortcode( 'go_pricing', array( 'go_pricing', 'go-pricing' ) ) ) return;
				break;
			
			// Manual restriction
			case 'manual' :

				if ( $post instanceof WP_Post && isset( $settings['plugin-pages'] ) && isset( $settings['plugin-pages-rule'] ) )  {

					$ids = trim( preg_replace( '/([^0-9][^,]{0})+/', ',', $settings['plugin-pages'] ), ',' );
					$ids = explode( ',', $ids );

					if ( $settings['plugin-pages-rule'] == 'in' ) {
						if ( !in_array( $post->ID, $ids ) ) return;
					} else {
						if ( in_array( $post->ID, $ids ) ) return;
					}
					
				}
				break;			
		}
	
		do_action( 'go_pricing/enque_public_scripts' );
				
	}	
	
	
	/**
	 * Enqueue public styles
	 *
	 * @return void
	 */
	 
	 
	public function enqueue_public_styles() {
		
		$general_settings = get_option( self::$plugin_prefix . '_table_settings', array() );
		wp_enqueue_style( self::$plugin_slug . '-styles', $this->plugin_url . 'assets/css/go_pricing_styles.css', false, self::$plugin_version );	
		if ( !empty( $general_settings['custom-css'] ) ) wp_add_inline_style( self::$plugin_slug . '-styles', $general_settings['custom-css'] );
		
	}
	
	
	/**
	 * Register public scripts
	 *
	 * @return void
	 */	
	
	public function enqueue_public_scripts() {
		
		$general_settings = get_option( self::$plugin_prefix . '_table_settings', array() );		
				
		$gmap_api_key = isset( $general_settings['gmap-apikey'] ) ? $general_settings['gmap-apikey'] : '';
		
		$in_footer = empty( $general_settings['js-in-header'] );

		// Option to disable TweenMax
		if ( empty( $general_settings['disable-gs'] ) ) {

			wp_register_script( 'gw-tweenmax', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.11.2/TweenMax.min.js', array(), null, false );
	
			// From WP 4.5 add compatibility mode
			if ( function_exists( 'wp_add_inline_script' ) ) {
				wp_add_inline_script( 'gw-tweenmax', 'var oldGS=window.GreenSockGlobals,oldGSQueue=window._gsQueue,oldGSDefine=window._gsDefine;window._gsDefine=null;delete(window._gsDefine);var gwGS=window.GreenSockGlobals={};', true );
				wp_add_inline_script( 'gw-tweenmax', 'try{window.GreenSockGlobals=null;window._gsQueue=null;window._gsDefine=null;delete(window.GreenSockGlobals);delete(window._gsQueue);delete(window._gsDefine);window.GreenSockGlobals=oldGS;window._gsQueue=oldGSQueue;window._gsDefine=oldGSDefine;}catch(e){}' );
			}
			wp_enqueue_script( 'gw-tweenmax' );

		}
						
		wp_register_script( self::$plugin_slug . '-scripts', $this->plugin_url . 'assets/js/go_pricing_scripts.js', array( 'jquery' ), self::$plugin_version, $in_footer );
		wp_enqueue_script( self::$plugin_slug . '-scripts' );
				
		wp_register_script( self::$plugin_slug . '-map', 'https://maps.googleapis.com/maps/api/js?key=' . esc_attr( $gmap_api_key ), array(), null, false );
		wp_register_script( self::$plugin_slug . '-gomap', $this->plugin_url . 'assets/lib/js/jquery.gomap-1.3.2.min.js', array( 'jquery', self::$plugin_slug . '-map' ), self::$plugin_version, false );
		
		global $wp_version;
		if ( version_compare( $wp_version, 3.6, '<' ) ) wp_register_script( self::$plugin_slug . '-mediaelementjs', $this->plugin_url . 'assets/plugins/js/mediaelementjs/mediaelement-and-player.min.js', array( 'jquery' ), self::$plugin_version, $in_footer );

	}

	/**
	 * Safe mode for live preview
	 *
	 * @return void
	 */
	public function live_preview_safe_init() {
		ob_start();
	}
	 
	public function live_preview_safe() {
		
		if ( !isset( $_GET['go_pricing_preview_id'] ) ) return;	
		$general_settings = get_option( self::$plugin_prefix . '_table_settings' );
		if ( !isset( $general_settings['safe-preview'] ) ) return;		
		
		$_GET['id'] = $_GET['go_pricing_preview_id'] ;
		add_filter('show_admin_bar', '__return_false');
		include_once ( $this->plugin_path . 'includes/preview.php' );
		
	}		

}

 

?>