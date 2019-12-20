<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Shortcode testimonials class.
 *
 */
class DT_Shortcode_Gap extends DT_Shortcode {

    static protected $instance;

    protected $shortcode_name = 'dt_gap';
    protected $plugin_name = 'dt_mce_plugin_shortcode_gap';

    public static function get_instance() {
        if ( !self::$instance ) {
            self::$instance = new DT_Shortcode_Gap();
        }
        return self::$instance;
    }

    protected function __construct() {
        add_shortcode( $this->shortcode_name, array($this, 'shortcode') );
    }

    public function shortcode( $atts, $content = null ) {
       extract( shortcode_atts( array(
		'height' => 10,
	    ), $atts, $this->shortcode_name ) );
	    
	    $output = '<div class="gap" style="line-height: ' . absint($height) . 'px; height: ' . absint($height) . 'px;"></div>';
	    
	    return $output;
    }

}

// create shortcode
DT_Shortcode_Gap::get_instance();
