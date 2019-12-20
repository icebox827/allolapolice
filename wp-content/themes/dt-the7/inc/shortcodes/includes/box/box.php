<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Shortcode box class.
 *
 */
class DT_Shortcode_Box extends DT_Shortcode {

    static protected $instance;

    protected $shortcode_name = 'dt_box';
    protected $plugin_name = 'dt_mce_plugin_shortcode_box';

    public static function get_instance() {
        if ( !self::$instance ) {
            self::$instance = new DT_Shortcode_Box();
        }
        return self::$instance;
    }

    protected function __construct() {
        add_shortcode( $this->shortcode_name, array( $this, 'shortcode' ) );
        add_filter( 'dt_get_puny_shortcodes', array( $this, 'register_puny_shortcode' ) );
    }

    public function shortcode( $atts, $content = null ) {
        if ( !$content ) return '';
	    return '<div class="wf-container">' . do_shortcode( $content ) . '</div>';
    }

    public function register_puny_shortcode( $puny_shortcodes = array() ) {
        $puny_shortcodes[ $this->shortcode_name ] = array( $this, 'shortcode' );
        return $puny_shortcodes;
    }

}

// create shortcode
DT_Shortcode_Box::get_instance();
