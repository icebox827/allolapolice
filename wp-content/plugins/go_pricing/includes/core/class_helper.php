<?php
/**
 * Helper class
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Class
class GW_GoPricing_Helper {
		

	/**
	 * Clean input fields
	 *
	 * @return array
	 */
	 
	public static function clean_input( $data = array(), $format = 'filtered', $exclude_html_keys = array(), $exclude_all_keys = array() ) {
		
		foreach ( (array)$data as $key => $value ) {
			
			if ( is_array( $value ) ) { 
				$data[$key] = self::clean_input( $value, $format, $exclude_html_keys, $exclude_all_keys );	
			} else {
				if ( $format == 'html' || in_array( $key, (array)$exclude_html_keys, true  ) ) {
					$data[$key] = stripslashes( trim( $value ) );
				} elseif ( $format == 'raw' || in_array( $key, (array)$exclude_all_keys, true ) ) {
					$data[$key] = stripslashes( $value );
				} elseif ( $format == 'no_html' || in_array( $key, (array)$exclude_all_keys, true ) ) {
					$data[$key] = stripslashes( strip_tags( trim( $value ) ) );
				} else {
					$data[$key] = stripslashes( sanitize_text_field( $value ) );
				}
			}
			
		}
		
		return $data;
				
	}
	
	
	/**
	 * Remove input (remove private inputs)
	 *
	 * @return array
	 */	
	
	public static function remove_input( $data = array(), $keys = array(), $clean_private = true ) {
		
		foreach ( (array)$data as $key => $value ) {

			if ( is_array( $value ) ) { 			
				if ( in_array ( $key, (array)$keys, true ) || ( $clean_private === true && preg_match( '/^(_.*)+/' , $key ) == 1 ) ) {
					unset( $data[$key] );
				} else {
					$data[$key] = self::remove_input( $value, $keys, $clean_private );
				}
			} else {
				if ( in_array ( $key, (array)$keys, true ) || ( $clean_private === true && preg_match( '/^(_.*)+/' , $key ) == 1 ) ) unset( $data[$key] );										
			}
			
		}
		
		return $data;		
				
	}
	
	
	/**
	 * Parset data (remove private inputs)
	 *
	 * @return array
	 */	
	
	public static function parse_data( $data ) {
		
		if ( !is_string( $data ) || $data == '' ) return;
		
		parse_str( $data, $data );
		
		if ( function_exists( 'get_magic_quotes_gpc' ) && get_magic_quotes_gpc() ) $data = stripslashes_deep( $data );
		
		return $data;		
				
	}
	
	
	/**
	 * Escape % char in (s)printf arg
	 *
	 * @return string
	 */	
	 	
	
	public static function esc_sprint( $string ) {
		
		if ( empty( $string ) ) return $string;
				
		return preg_replace( '/[%]/', '%%', $string );
		
	}
	
	
	/**
	 * Clean escaped % char in (s)printf 
	 *
	 * @return string
	 */	
	 	
	
	public static function clean_esc_sprint( $string ) {
		
		if ( empty( $string ) ) return $string;
				
		return preg_replace( '/%%/', '%', $string );
		
	}
	
	
	/**
	 * Escape attribute (parse shortcodes before escaping)
	 *
	 * @return string
	 */	
	
	public static function esc_attr( $text = '' ) {	
	
		if ( empty( $text ) ) return $text;
	
		$text = do_shortcode( $text );
		$text = esc_attr( $text );

		/* not used
		$general_settings = get_option( 'go_pricing_table_settings' ); 
		
		if ( isset( $general_settings['fix-unescaped-quoutes'] ) ) {
			add_filter( 'the_content', array( __CLASS__, 'fix_unesc_atts' ) , PHP_INT_MAX );
			$text = preg_replace( '/(&(?:[a-z\d]+|#\d+|#x[a-f\d]+));/', '$1_;', $text );
		}*/

		return $text;
		
	}
	
	
	/**
	 * Fix decoded Double Quotes (&quot;)
	 *
	 * @return string (not used)
	 */		
	
	public static function fix_unesc_atts ( $content ) {
		
		if ( strstr( '#go-pricing-table', $content ) ) return $content;
		$content = preg_replace( '/(&(?:[a-z\d]+|#\d+|#x[a-f\d]+))_;/', '$1;', $content );
		return $content;
		
	}
	
	/**
	 * Has shortcode
	 * Check if the shortcode exist in post content and in builder metas
	 *
	 * @param string $tag Shortcode tag.
	 * @param string|array $text(s) Text to find in the content.
	 * @return bool True on success or false on failure.
	 */		
	
	public static function has_shortcode( $tag, $text = '' ) {

		global $post;

		// Search in content
		if ( $post instanceof WP_Post && GW_GoPricing_Helper::find_shortcode( $post->post_content, $tag, $text ) ) return true;

		// Muffin Buider (find in meta)
		if ( defined( 'MFN_OPTIONS_DIR' ) ) {
			$meta = get_post_meta( $post->ID, 'mfn-page-items-seo', true );
			if ( !empty( $meta ) && GW_GoPricing_Helper::find_shortcode( $meta, $tag, $text ) ) return true;
		}
		return false;		
	}
		
	/**
	 * Find shortcode
	 *
	 * @param string $content Content to seach.
	 * @param string $tag Shortcode tag.
	 * @param string|array $text(s) Text to find in the content
	 * @return bool True on success or false on failure.
	 */		
	
	public static function find_shortcode( $content, $tag, $text = '' ) {
		
		if ( !is_string( $content ) || !is_string( $tag ) ) return false;
		// If shortcode found
		if ( has_shortcode( $content, $tag ) ) return true;
				
		// Check given text(s) if shortcode not found
		if ( empty( $text ) || !is_string( $text ) && !is_array( $text ) ) return false;
		foreach( array_filter( array_map( 'trim', (array)$text) ) as $value) {
			if ( strstr(  $content, $value ) ) return true;	
		}
		return false;
		
	}	
	
}

?>