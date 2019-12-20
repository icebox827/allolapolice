<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class DT_Shortcode_Fancy_Title extends DT_Shortcode {

	static protected $instance;
	static protected $num = 0;

	public static function get_instance() {
		if ( !self::$instance ) {
			self::$instance = new DT_Shortcode_Fancy_Title();
		}
		return self::$instance;
	}

	protected function __construct() {

		add_shortcode( 'dt_fancy_title', array($this, 'shortcode') );
	}

	public function shortcode( $atts, $content = null ) {

		// shortcode instances counter
		self::$num++;

		$default_atts = array(
			'title' => 'Title',
			'title_align' => 'center',
			'title_size' => 'normal',
			'title_color' => 'default',
			'custom_title_color' => '',
			'separator_style' => '',
			'separator_color' => 'default',
			'custom_separator_color' => '',
			'el_width' => '100',
			'title_bg' => 'disabled',
		);

		extract(shortcode_atts($default_atts, $atts, 'dt_fancy_title'));

		/////////////////////
		// sanitize atts //
		/////////////////////

		$title = esc_html( $title );
		$title_align = sanitize_key( $title_align );
		$title_size = sanitize_key( $title_size );
		$title_color = sanitize_key( $title_color );
		$custom_title_color = esc_attr( $custom_title_color );
		$separator_style = sanitize_key( $separator_style );
		$separator_color = sanitize_key( $separator_color );
		$custom_separator_color = esc_attr( $custom_separator_color );
		$el_width = absint($el_width);
		if ( $el_width > 100 ) {
			$el_width = 100;
		}
		$title_bg = sanitize_key( $title_bg );

		//////////////////
		// inline css //
		//////////////////

		$title_inline_style = '';
		if ( "custom" == $title_color && $custom_title_color ) {
			$title_inline_style .= "color: {$custom_title_color};";
		}

		$separator_inline_style = '';
		if ( "custom" == $separator_color && $custom_separator_color ) {
			$separator_inline_style .= "border-color: {$custom_separator_color};";

			if ( "enabled" == $title_bg ) {
				$title_inline_style .= "background-color: {$custom_separator_color};";
			}
		}

		$fancy_text_inline_style = '';
		if ( $el_width ) {

			$fancy_text_inline_style .= "width: {$el_width}%;";
		}

		///////////////
		// classes //
		///////////////

		$title_class = array( 'dt-fancy-title' );
		if ( "enabled" == $title_bg ) {
			$title_class[] = 'bg-on';
		}

		$separator_class = array( 'dt-fancy-separator' );
		switch ( $title_align ) {
			case 'left':
				$separator_class[] = 'title-left';
				break;
			case 'right':
				$separator_class[] = 'title-right';
				break;
		}

		if ( 'small' == $title_size ) {
			$separator_class[] = 'text-small';
		} else if ( 'big' == $title_size ) {
			$separator_class[] = 'text-big';
		} else if ( in_array( $title_size, array( "h1", "h2", "h3", "h4", "h5", "h6" ) ) ) {
			$separator_class[] = $title_size . '-size';
		}

		if ( $separator_style ) {
			$separator_class[] = 'style-' . $separator_style;
		}

		switch ( $title_color ) {
			case 'accent':
				$separator_class[] = 'accent-title-color';
				break;

			case 'title':
				$separator_class[] = 'title-color';
				break;
		}

		if ( 'accent' == $separator_color ) {
			$separator_class[] = 'accent-border-color';
		}

		//////////////
		// output //
		//////////////

		if ( $fancy_text_inline_style ) {
			$fancy_text_inline_style = ' style="' . esc_attr($fancy_text_inline_style) . '"';
		}

		if ( $title_inline_style ) {
			$title_inline_style = ' style="' . esc_attr($title_inline_style) . '"';
		}

		if ( $separator_inline_style ) {
			$separator_inline_style = ' style="' . esc_attr($separator_inline_style) . '"';
		}

		$output = '<div class="' . ( esc_attr( join( ' ', $separator_class ) ) ) . '"' . $fancy_text_inline_style . '>'; // dt-fancy-separator

		$output .= '<div class="' . ( esc_attr( join( ' ', $title_class ) ) ) . '"' . $title_inline_style . '>'; // dt-fancy-title

		$output .= '<span class="separator-holder separator-left"' . $separator_inline_style . '></span>';

		$output .= $title;

		$output .= '<span class="separator-holder separator-right"' . $separator_inline_style . '></span>';

		$output .= '</div>'; // !dt-fancy-title

		$output .= '</div>'; // !dt-fancy-separator

		return $output;
	}

}

// create shortcode
DT_Shortcode_Fancy_Title::get_instance();
