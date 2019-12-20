<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $onclick
 * @var $img_size
 * @var $external_img_size
 * @var $caption
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $el_id
 * @var $css_animation
 * @var $style
 * @var $external_style
 * @var $border_color
 * @var $image_hovers
 * @var $lazy_loading
 * @var $css
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Single_image $this
 */
$title = $source = $image = $custom_src = $onclick = $img_size = $external_img_size =
$caption = $img_link_large = $link = $img_link_target = $alignment = $el_class = $el_id = $css_animation = $style = $external_style = $border_color = $external_border_color = $css = $image_hovers = $lazy_loading = $rel_no_follow = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Respect global lazy loading settings.
$lazy_loading = $lazy_loading && presscore_lazy_loading_enabled();
$default_src = vc_asset_url( 'vc/no_image.png' );

// backward compatibility. since 4.6
if ( empty( $onclick ) && isset( $img_link_large ) && 'yes' === $img_link_large ) {
	$onclick = 'img_link_large';
} elseif ( empty( $atts['onclick'] ) && ( ! isset( $atts['img_link_large'] ) || 'yes' !== $atts['img_link_large'] ) ) {
	$onclick = 'custom_link';
}

if ( 'external_link' === $source ) {
	$style = $external_style;
	$border_color = $external_border_color;
}

$border_color = ( '' !== $border_color ) ? ' vc_box_border_' . $border_color : '';

$img = false;
$img_id = 0;

switch ( $source ) {
	case 'media_library':
	case 'featured_image':

		if ( 'featured_image' === $source ) {
			$post_id = get_the_ID();
			if ( $post_id && has_post_thumbnail( $post_id ) ) {
				$img_id = get_post_thumbnail_id( $post_id );
			}
		} else {
			$img_id = preg_replace( '/[^\d]/', '', $image );
		}

		// set rectangular
		if ( preg_match( '/_circle_2$/', $style ) ) {
			$style = preg_replace( '/_circle_2$/', '_circle', $style );
			$img_size = $this->getImageSquareSize( $img_id, $img_size );
		}

		if ( ! $img_size ) {
			$img_size = 'medium';
		}

		$img = wpb_getImageBySize( array(
			'attach_id' => $img_id,
			'thumb_size' => $img_size,
			'class' => 'vc_single_image-img',
		) );

		// don't show placeholder in public version if post doesn't have featured image
		if ( 'featured_image' === $source ) {
			if ( ! $img && 'page' === vc_manager()->mode() ) {
				return;
			}
		}

		break;

	case 'external_link':
		// The7: Backward compatibility.
		if ( function_exists( 'vc_extract_dimensions' ) ) {
			$dimensions = vc_extract_dimensions( $external_img_size );
		} else {
			$dimensions = vcExtractDimensions( $external_img_size );
		}

		$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

		$custom_src = $custom_src ? $custom_src : $default_src;

		$img = array(
			'thumbnail' => '<img class="vc_single_image-img" ' . $hwstring . ' src="' . esc_url( $custom_src ) . '" />',
		);
		break;

	default:
		$img = false;
}

/**
 * The7: Share buttons fix.
 *
 * @since 5.5.0
 */
if ( $img ) {
	$permalink = $custom_src;
	if ( in_array( $source, array( 'media_library', 'featured_image' ) ) && isset( $img_id ) ) {
		$permalink = get_permalink( $img_id );
	}

	$img['thumbnail'] = str_replace( '/>', ' data-dt-location="' . esc_url( $permalink ) . '" />', $img['thumbnail'] );
}

if ( ! $img ) {
	$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . esc_url( $default_src ) . '" />';
}

/**
 * The7: Lazy loading.
 *
 * @since 3.1.4
 */
if ( $lazy_loading ) {
	$re = '/width=[\'"](\d+).*height=[\'"](\d+)/';
	preg_match( $re, $img['thumbnail'], $matches );
	if ( isset( $matches[1], $matches[2] ) ) {
		$_width = absint( $matches[1] );
		$_height = absint( $matches[2] );
		$_src_placeholder = "data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg' viewBox%3D'0 0 $_width $_height'%2F%3E";
		$img['thumbnail'] = str_replace( 'src="', 'src="' . $_src_placeholder . '" data-src="', $img['thumbnail'] );
		$img['thumbnail'] = str_replace( 'srcset="', 'data-srcset="', $img['thumbnail'] );
		$img['thumbnail'] = str_replace( 'class="', 'class="lazy-load ', $img['thumbnail'] );
	}
}

$el_class = $this->getExtraClass( $el_class );

// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$onclick = 'link_image';
}

// backward compatibility. will be removed in 4.7+
if ( ! empty( $atts['img_link'] ) ) {
	$link = $atts['img_link'];
	if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link ) ) {
		$link = 'http://' . $link;
	}
}

// backward compatibility
if ( in_array( $link, array(
	'none',
	'link_no',
), true ) ) {
	$link = '';
}

$a_attrs = array();

// The7: Custom image hovers style.
$image_hovers = apply_filters( 'dt_sanitize_flag', $image_hovers );

switch ( $onclick ) {
	case 'img_link_large':

		if ( 'external_link' === $source ) {
			$link = $custom_src;
		} else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}

		if ( $image_hovers ) {
			$a_attrs['class'] = 'rollover';
		}

		break;

	case 'link_image':
		$a_attrs['class'] = 'dt-pswp-item';

		if ( $image_hovers ) {
			$a_attrs['class'] .= ' rollover rollover-zoom';
		}

		// backward compatibility
		if ( ! vc_has_class( 'prettyphoto', $el_class ) && 'external_link' === $source ) {
			$link = $custom_src;
		} elseif ( ! vc_has_class( 'prettyphoto', $el_class ) ) {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}

		break;

	case 'custom_link':
		// $link is already defined

		if ( $image_hovers ) {
			$a_attrs['class'] = 'rollover';
		}

		break;

	case 'zoom':
		wp_enqueue_script( 'vc_image_zoom' );

		if ( 'external_link' === $source ) {
			$large_img_src = $custom_src;
		} else {
			$large_img_src = wp_get_attachment_image_src( $img_id, 'large' );
			if ( $large_img_src ) {
				$large_img_src = $large_img_src[0];
			}
		}

		$img['thumbnail'] = str_replace( '<img ', '<img data-vc-zoom="' . $large_img_src . '" ', $img['thumbnail'] );

		break;
}

// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$el_class = vc_remove_class( 'prettyphoto', $el_class );
}

$wrapperClass = 'vc_single_image-wrapper ' . $style . ' ' . $border_color;

if ( $lazy_loading ) {
	$wrapperClass .= ' layzr-bg';
}

if ( $link ) {
	$a_attrs['href'] = $link;
	$a_attrs['target'] = $img_link_target;
	if ( $rel_no_follow ) {
		$a_attrs['rel'] = 'nofollow';
	}
	if ( ! empty( $a_attrs['class'] ) ) {
		$wrapperClass .= ' ' . $a_attrs['class'];
		unset( $a_attrs['class'] );
	}
	$link_datas = wp_get_attachment_image_src( $img_id, 'large' );
	$html = '<a ' . vc_stringify_attributes( $a_attrs ) . '  class="' . $wrapperClass . '" data-large_image_width="' . (int) $link_datas[1] . '" data-large_image_height = "' . (int) $link_datas[2]. '"   ' . presscore_get_share_buttons_for_prettyphoto( 'photo' ) . '  >' . $img['thumbnail'] . '</a>';
} else {
	$html = '<div class="' . $wrapperClass . '">' . $img['thumbnail'] . '</div>';
}

// The7: Custom animation.
$animation_class = $this->getCSSAnimation( $css_animation );
if ( ! $animation_class ) {
	$animation_class = presscore_get_shortcode_animation_html_class( $css_animation );
}
$class_to_filter = 'wpb_single_image wpb_content_element vc_align_' . $alignment . ' ' . $animation_class;

$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if ( in_array( $source, array( 'media_library', 'featured_image' ), true ) && 'yes' === $add_caption ) {
	$img_id = apply_filters( 'wpml_object_id', $img_id, 'attachment' );
	$post = get_post( $img_id );
	$caption = $post->post_excerpt;
} else {
	if ( 'external_link' === $source ) {
		$add_caption = 'yes';
	}
}

if ( 'yes' === $add_caption && '' !== $caption ) {
	$html .= '<figcaption class="vc_figure-caption">' . esc_html( $caption ) . '</figcaption>';
}
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$output = '
	<div ' . implode( ' ', $wrapper_attributes ) . ' class="' . esc_attr( trim( $css_class ) ) . '">
		' . wpb_widget_title( array(
	'title' => $title,
	'extraclass' => 'wpb_singleimage_heading',
) ) . '
		<figure class="wpb_wrapper vc_figure">
			' . $html . '
		</figure>
	</div>
';

if ( version_compare( WPB_VC_VERSION, '6.0.3', '<' ) ) {
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} else {
	return $output;
}
