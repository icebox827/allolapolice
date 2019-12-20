<?php
/**
 * Class for connecting to plugin API
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
class GW_GoPricing_Api {

	protected $globals;
		
	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected static $plugin_path;
	
	protected $plugin_file;
	protected $plugin_base;
	
	protected $url = 'https://granthweb.com/api';
	protected $args_headers = array();
	protected $args_body = array();
	protected $use_cache = true;
	protected $cache_hash = null;
	protected $response = null;
	
	protected $api_cache;


	/**
	 * Initialize the class
	 *
	 * @return void
	 */	
	
	public function __construct( $body, $header = array(), $use_cache = true ) {
		
		$this->globals = GW_GoPricing::instance();
		self::$plugin_version = $this->globals['plugin_version'];
		self::$db_version = $this->globals['db_version'];		
		self::$plugin_prefix = $this->globals['plugin_prefix'];
		self::$plugin_slug = $this->globals['plugin_slug'];
		self::$plugin_path = $this->globals['plugin_path'];	
		
		$this->plugin_file = $this->globals['plugin_file'];
		$this->plugin_base = $this->globals['plugin_base'];		
		
		if ( !empty( $header ) ) $this->args_headers = $header;
		if ( !empty( $body ) ) $this->args_body = $body;
		if ( $use_cache === false ) $this->use_cache = false;
		
		$this->connect( $this->args_body, $this->args_headers, $this->use_cache );
		
	}

	
	/**
	 * Connet to API and get data
	 *
	 * @return array | bool
	 */	
	
	public function connect() {
		
		$now = time();
		
		// Cached API data
		$api_cache = wp_parse_args(
			get_option( self::$plugin_prefix . '_api_cache', array() ),
			array(
				'last_checked' => null,
				'last_status' => null,
				'requests' => array()
			)		
		);

		// Empty cache
		// $api_cache = array();
				
		// Mininum 1 hour if api is down
		if ( !empty( $api_cache['last_checked'] ) && $now - (int)$api_cache['last_checked']  <= 60 * 60 &&  $api_cache['last_status'] != 200 ) return;	
				
		global $wp_version;
		$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'user-agent'  => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ),
			'headers' => $this->args_headers,
			'body' => $this->args_body
		);
		
		$request_id = md5( serialize( $args ) );
		$request_data = null;
		
		// Check for cached data
		if ( $this->use_cache && isset( $api_cache['requests'][$request_id] ) ) {
			$request = $api_cache['requests'][$request_id];

			// If cache is valid and not too old (12+ hrs)
			if ( isset( $request['data'] ) && !empty( $request['time'] ) && $now - (int)$request['time']  <= 60 * 60 * 12 ) {
				$this->response = $request_data = $request['data'];
			}
		}
		
		// If cache data is not available or used
		if ( is_null( $request_data ) ) {
			
			$response = wp_remote_post( 
				$this->url, 
				$args
			);
			
			// If request is ok
			if ( ( $resp_code = wp_remote_retrieve_response_code( $response ) ) == '200' &&  wp_remote_retrieve_header( $response, 'content-type' ) == 'application/json' ) {
				$api_cache['requests'][$request_id]	= array(				
					'data' => $this->response = wp_remote_retrieve_body( $response ),
					'time' => $now
				);				
			}
			
			// Update db data			
			update_option( self::$plugin_prefix . '_api_cache', wp_parse_args(
				array(
					'last_checked' => $now,
					'last_status' => $resp_code
				),
				$api_cache	
			), false );				
			
		}

	}
	
	
	/**
	 * Return API result
	 *
	 * @return array | bool
	 */
	 	
	
	public function get_response() {	
	
		return $this->response;
		
	}
	

	/**
	 * Get API data
	 *
	 * @return array | bool
	 */
	 	
	
	public function get_data( $json = false ) {	
	
		if ( empty( $this->response ) ) return false;
	
		$data = json_decode( $this->response, true );

		if ( empty( $data['data'] ) ) return false;

		return $data['data'];
		
	}	
	
	
	/**
	 * Clear API chache
	 *
	 * @return void
	 */	
	
	public function clear_cache() {	
	
		delete_transient( self::$plugin_prefix . '_'.  $this->cache_hash );
		
	}
	

}

?>