<?php
/**
 * Admin notices class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


// Class
class GW_GoPricing_AdminNotices {

	protected static $instance = null;
	protected $globals;
		
	protected static $plugin_version;
	protected static $db_version;
	protected static $plugin_prefix;
	protected static $plugin_slug;
	protected static $plugin_path;


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
		self::$plugin_path = $this->globals['plugin_path'];

		// Admin notices action - remotes messages
		add_action( 'admin_notices', array( $this, 'print_remote_admin_notices' ) );	

		// Admin notices action
		add_action( 'admin_notices', array( $this, 'print_admin_notices' ) );	
	
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
	 * Print admin notices
	 *
	 * @return void
	 */		  
		 
	public static function print_admin_notices() {
		
		$notices = $new_notices = get_option( self::$plugin_prefix . '_notices' ); 
		if ( $notices === false ) return;
		
		foreach ( $notices as $notice_key => $notice ) {

			// Set message class
			$class = 'updated';
			
			if ( !empty( $notice['type'] ) ) {
				
				switch( $notice['type'] ) {
				
					case 'error' : 
						$class = 'error';
						break;

					case 'success' : 
						$class = 'updated';
						break;

					case 'info' : 
						$class = 'info';
						break;					

				}
				
			}
			
			// Show message
			if ( !empty( $notice['message'] ) ) {
				$content = '';
				foreach ( (array)$notice['message'] as $msg ) {
					$content .= '<p><strong>' . $msg . '</strong></p>';
				}
				include( self::$plugin_path . 'includes/admin/views/view_message.php' );
				
			}
			
			unset( $new_notices[$notice_key] );
			
		}
		
		if ( $new_notices != $notices ) update_option( self::$plugin_prefix . '_notices', $new_notices ); 
		
	}	
		
		
	/**
	 * Print remote admin notices
	 *
	 * @return void
	 */	

	public static function print_remote_admin_notices() {
		
		$screen = get_current_screen();
		if ( empty( $screen ) || empty( $screen->id ) || preg_match('/^go-pricing_page|toplevel_page_go-pricing/', $screen->id ) != 1 ) return;
		
		$apicall = new GW_GoPricing_Api( array( 'product' => 'go_pricing', 'type' => 'message' ) );
		
		$api_data = $apicall->get_data();	

		if ( empty( $api_data ) ) return;
		
		/* Defaults */
		$cid_base = 'go_pricing_msg_';
		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				'target' => array(),
				'class' => array()
			),
			'br' => array(),
			'em' => array(),
			'p' => array(),
			'strong' => array(),
			'small' => array(),
		);		
		
		$banner_header = '<div class="gwa-banner-header">%s</div>';
		$banner_body = '%1$s<div class="gwa-banner-main">%2$s<div class="gwa-banner-content">%3$s</div></div>';
		
		if ( !empty( $api_data ) && is_array( $api_data ) ) {
			
			foreach ( $api_data as $api_message ) {
				
				/* Validate basics */
				if ( !isset( $api_message['target'] ) || !isset( $api_message['id'] ) || !isset( $api_message['type'] ) || !isset( $api_message['content'] ) ) continue;

				/* Validate page */
				if ( $api_message['target'] == 'dashboard' && preg_match('/^toplevel_page_go-pricing/', $screen->id ) != 1 ) continue;

				/* Validate id */
				if ( isset( $_COOKIE[$cid_base . $api_message['id']] ) ) continue;				
				
								/* Validate date */
				$now = date( 'd-m-Y' );
				$from = !empty( $api_message['from'] ) ? date( 'd-m-Y', strtotime( $api_message['from'] ) ) : $now;
				$to = !empty( $api_message['to'] ) ? date( 'd-m-Y', strtotime( $api_message['to'] ) ) : $now;				
				
				if ( strtotime($from) > strtotime($now) || strtotime($to) < strtotime($now) ) continue;		
				$msg_classes = array( 'gwa-clearfix', 'notice');
				$msg_styles = array();
				$msg = '';
				
				if ( $api_message['type'] == 'banner' ) {
					
					$msg_classes[] = 'gwa-banner';
					if ( isset( $api_message['scheme'] ) && $api_message['scheme'] == 'dark' ) $msg_classes[] = 'gwa-banner-dark';
					
					if ( !empty( $api_message['bg_color'] ) ) $msg_styles[] = sprintf( 'background-color:%s', $api_message['bg_color'] );
					if ( !empty( $api_message['bg_image'] ) ) $msg_styles[] = sprintf( 'background-image:url(%s)', $api_message['bg_image'] );					
					
					$banner_media = !empty( $api_message['media'] ) ? sprintf( '<div class="gwa-banner-media"><img src="%s"></div>', $api_message['media'] ) : '';
					$banner_header = '';
					if ( !empty( $api_message['title'] ) ) {
						$banner_header = sprintf( '<div class="gwa-banner-header">%1$s%2$s</div>', 
							!empty( $api_message['title_thumb'] ) ? '<div class="gwa-banner-header-thumb"><img src="' . $api_message['title_thumb'] . '"></div>' : '',
							!empty( $api_message['title'] ) ? '<div class="gwa-banner-header-title">' . $api_message['title'] . '</div>' : ''
						);
					}
					$button_classes = array( 'gwa-btn-style2' );
					$banner_button = '';
					if ( !empty( $api_message['button'] ) ) {
						
						if ( !empty( $api_message['button']['text'] ) && !empty( $api_message['button']['url'] ) ) {
							
							if ( !empty( $api_message['button']['class'] ) ) {
								$button_classes = explode( ' ', trim( $api_message['button']['class'] ) );
							}
							
							$banner_button = sprintf( '<a href="%1$s" target="_blank"%2$s>%3$s</a>',
								$api_message['button']['url'],
								!empty( $button_classes ) ? ' class="' . implode(' ', $button_classes ) . '"' : '',
								$api_message['button']['text']
							);
						}
						
					}
					
					$banner_content = sprintf( '<div class="gwa-banner-content"><p>%1$s</p>%2$s</div>', 
						wp_kses( $api_message['content'], $allowed_html ),
						!empty( $banner_button ) ? '<p>'. $banner_button . '</p>' : ''
					);
					$banner_main = sprintf( '<div class="gwa-banner-main">%1$s%2$s</div>', $banner_header, $banner_content );
				
					$msg = $banner_media . $banner_main;
				
				} else {
					$msg_classes[] = 'gwa-message';
					$msg = wp_kses( $api_message['content'], $allowed_html );
				}
				
				printf( '<div id="message" data-id="%1$s" class="%2$s"%3$s>%4$s<a href="#" class="gwa-message-close" title="%5$s"></a></div>', 
					$api_message['id'],
					!empty( $msg_classes ) ? trim( implode( ' ', $msg_classes ) ) : '',
					!empty( $msg_styles ) ? ' style="' . trim( implode( ';', $msg_styles ) ) . '"' : '',					
					$msg, 
					esc_attr__( 'Close', 'go_pricing_textdomain' )
				);				
				
			}
			
		}
		
	}


	/**
	 * Show admin notices
	 *
	 * @return void
	 */		  
		 
	public static function show() {

		self::print_admin_notices();
		
	}


	/**
	 * Add admin notice
	 *
	 * @return void
	 */		  
		

	public static function add( $id = '', $type = 'success', $message = '', $override = true ) {
		
		if ( empty( $message ) ) return;
				
		$notices = $new_notices = get_option( self::$plugin_prefix . '_notices' );
		
		if ( !empty( $new_notices[$id] ) && (bool)$override === false ) {
			$old_message = $new_notices[$id]['message'];
			$new_notices[$id]['message'] = array_merge( (array)$old_message, (array)$message );
		} else {			
			$new_notices[$id] = array (
				'type' => $type, 
				'message' => array( $message )
			);
		}
		
		if ( $new_notices != $notices ) update_option( self::$plugin_prefix . '_notices', $new_notices ); 		
		
	}
	
	/**
	 * Get admin notice
	 *
	 * @return array
	 */		  
		

	public static function get( $id = '', $type = 'error' ) {
		
		if ( empty( $id ) ) return false;
		return get_option( self::$plugin_prefix . '_notices' ); 		
		
	}	
	
}

?>