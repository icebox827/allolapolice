<?php
/**
 * Fancy image shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Shortcode fancy image class.
 *
 */
class DT_Shortcode_FancyVideoVc extends DT_Shortcode {

	static protected $instance;

	protected $shortcode_name = 'dt_fancy_video_vc';
	protected $plugin_name = 'dt_mce_plugin_shortcode_fancy_video_vc';

	public static function get_instance() {
		if ( !self::$instance ) {
			self::$instance = new DT_Shortcode_FancyVideoVc();
		}
		return self::$instance;
	}

	protected function __construct() {
		add_shortcode( $this->shortcode_name, array($this, 'shortcode') );
	}

	public function shortcode( $atts, $content = null ) {
		$default_atts = array(
			'style'				=> '1',
			'image'				=> '',
			'image_alt'			=> '',
			'hd_image'			=> '',
			'media'				=> '',
			'padding'			=> '0',
			'align'				=> '',
			'animation'			=> 'none',
			'width'				=> '',
		);
		$attributes = shortcode_atts( $default_atts, $atts, $this->shortcode_name );

		// $attributes['type'] = in_array( $attributes['type'], array('image', 'video') ) ?  $attributes['type'] : $default_atts['type'];
		$attributes['style'] = sanitize_key( $attributes['style'] );
		$attributes['align'] = sanitize_key( $attributes['align'] );
		$attributes['padding'] = intval($attributes['padding']);
		$attributes['width'] = absint($attributes['width']);
		$attributes['image'] = esc_url($attributes['image']);
		$attributes['image_alt'] = esc_attr($attributes['image_alt']);
		$attributes['hd_image'] = esc_url($attributes['hd_image']);
		$attributes['media'] = esc_url($attributes['media']);
		// $attributes['lightbox'] = apply_filters('dt_sanitize_flag', $attributes['lightbox']);

		$container_classes = array( 'shortcode-single-image-wrap' );
		$media_classes = array( 'shortcode-single-image' );
		$container_style = array();
		$media = '';
		$content_block = '';

		$content = strip_shortcodes( $content );

		$attributes['type'] = 'video';
		$attributes['lightbox'] = 1;

		switch ( $attributes['style'] ) {
			case '3':
				$container_classes[] = 'br-standard';
			case '2':
				$container_classes[] = 'borderframe';
				$style = ' style="padding: ' . esc_attr($attributes['padding']) . 'px"';
				break;
			default: $style = '';
		}

		switch ( $attributes['align'] ) {
			case 'left': $container_classes[] = 'alignleft'; break;
			case 'right': $container_classes[] = 'alignright'; break;
			case 'centre':
			case 'center': $container_classes[] = 'alignnone'; break;
		}

		if ( presscore_shortcode_animation_on( $attributes['animation'] ) ) {
			$container_classes[] = presscore_get_shortcode_animation_html_class( $attributes['animation'] );
		}

		if ( $content ) {
			$container_classes[] = 'caption-on';
			$content_block = '<div class="shortcode-single-caption">' . $content . '</div>';
		}

		if ( $attributes['image'] && $attributes['hd_image'] ) {
			$image_src = sprintf( 'src="%1$s" srcset="%1$s 1x, %2$s 2x"', $attributes['image'], $attributes['hd_image'] );
		} else {
			$image_src = sprintf( 'src="%s"', $attributes['image'] ? $attributes['image'] : $attributes['hd_image'] );
		}

		$media = sprintf( '<img %s alt="%s" />', $image_src, $attributes['image_alt'] );

		$media = sprintf(
			'<div class="rollover-video">%s<a class="video-icon dt-pswp-item pswp-video" href="%s" title="%s" data-dt-img-description="%s"></a></div>',
			$media,
			$attributes['media'],
			$attributes['image_alt'],
			esc_attr( $content )
		);

		if ( $media ) {

			$media = sprintf( '<div class="%s"%s><div class="fancy-media-wrap">%s</div></div>', esc_attr( implode( ' ', $media_classes ) ), $style, $media );
		}

		if ( $attributes['width'] ) {

			$container_style[] = 'width: ' . $attributes['width'] . 'px';
		}

		$output = sprintf('<div class="%s"%s>%s</div>',
			esc_attr(implode(' ', $container_classes)),
			$container_style ? ' style="' . esc_attr( implode(';', $container_style) ) . '"' : '',
			$media . $content_block
		);

		return $output; 
	}

}

// create shortcode
DT_Shortcode_FancyVideoVc::get_instance();
