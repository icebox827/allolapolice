<?php
/**
 * This file contains shortcodes interface for Visual Composer.
 *
 * @package the7\Shortcodes
 * @since 1.0.0
 */

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Changing rows and columns classes.
 *
 * @param  string $class_string
 * @param  string $tag
 * @return string
 */
function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
	if ( $tag=='vc_column' || $tag=='vc_column_inner' ) {
		$class_string = preg_replace( '/vc_span(\d{1,2})/', 'wf-cell wf-span-$1', $class_string );
	}

	return $class_string;
}
add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );

/**
 * Adding our classes to paint standard VC shortcodes.
 *
 * @param  string $class_string
 * @param  string $tag
 * @param  array  $atts
 * @return string
 */
function custom_css_accordion( $class_string, $tag, $atts = array() ) {
	if ( in_array( $tag, array( 'vc_accordion', 'vc_progress_bar', 'vc_posts_slider' ) ) ) {
		$class_string .= ' dt-style';
	}

	if ( 'vc_accordion' === $tag ) {
		if ( array_key_exists( 'style' , $atts ) ) {
			switch ( $atts['style'] ) {
				case '2':
					$class_string .= ' dt-accordion-bg-on';
					break;

				case '3':
					$class_string .= ' dt-accordion-line-on';
					break;
			}
		}

		if ( array_key_exists( 'title_size', $atts ) ) {
			$class_string .= ' dt-accordion-' . presscore_get_font_size_class( $atts['title_size'] );
		}
	}

	return $class_string;
}
add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'custom_css_accordion', 10, 3 );

/**
 * VC Row.
 */

if ( The7_Admin_Dashboard_Settings::get( 'rows' ) ) {
	include_once dirname( __FILE__ ) . '/vc-bridges/the7-vc-row-bridge.php';
}

/**
 * Woocommerce shortcodes.
 */
$woocommerce_shortcodes = array(
	'recent_products',
	'featured_products',
    'products',
	'product_category',
    'product_categories',
	'sale_products',
	'best_selling_products',
    'top_rated_products',
    'product_attribute',
    'related_products',
);
foreach ( $woocommerce_shortcodes as $wc_shortcode ) {
	vc_remove_param( $wc_shortcode, 'columns' );
}

/**
 * VC Widgetized sidebar.
 */

vc_add_param( "vc_widget_sidebar", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __( "Show background", 'the7mk2' ),
	"admin_label" => true,
	"param_name" => "show_bg",
	"value" => array(
		"Yes" => "true",
		"No" => "false"
	)
) );

/**
 * VC Tabs.
 */

// undeprecate
vc_map_update( "vc_tabs", array(
	'name' => __( 'Tabs', 'the7mk2' ),
	'deprecated' => null,
	'category' => __('by Dream-Theme', 'the7mk2'),
	'icon' => 'dt_vc_ico_tabs',
	'weight' => -1,
) );

vc_map_update( 'vc_tab', array(
	'deprecated' => null,
) );

// title font size
vc_add_param("vc_tabs", array(
	"type" => "dropdown",
	"heading" => __("Title size", 'the7mk2'),
	"param_name" => "title_size",
	"value" => array(
		'small' => "small",
		'medium' => "normal",
		'large' => "big",
		'h1' => "h1",
		'h2' => "h2",
		'h3' => "h3",
		'h4' => "h4",
		'h5' => "h5",
		'h6' => "h6",
	),
	"std" => "big"
));

// style
vc_add_param("vc_tabs", array(
	"type" => "dropdown",
	"heading" => __("Style", 'the7mk2'),
	"param_name" => "style",
	"value" => array(
		"Style 1" => "tab-style-one",
		"Style 2" => "tab-style-two",
		"Style 3" => "tab-style-three",
		"Style 4" => "tab-style-four"
	)
));

/**
 * VC Tour.
 */

// undeprecate
vc_map_update("vc_tour", array(
	'name' => __( 'Tour', 'the7mk2' ),
	'deprecated' => null,
	'category' => __('by Dream-Theme', 'the7mk2'),
	'icon' => 'dt_vc_ico_tour',
	'weight' => -1,
));

// title font size
vc_add_param("vc_tour", array(
	"type" => "dropdown",
	"heading" => __("Title size", 'the7mk2'),
	"param_name" => "title_size",
	"value" => array(
		'small' => "small",
		'medium' => "normal",
		'large' => "big",
		'h1' => "h1",
		'h2' => "h2",
		'h3' => "h3",
		'h4' => "h4",
		'h5' => "h5",
		'h6' => "h6",
	),
	"std" => "big"
));

vc_add_param("vc_tour", array(
	"type" => "dropdown",
	"heading" => __("Style", 'the7mk2'),
	"param_name" => "style",
	"value" => array(
		"Style 1" => "tab-style-one",
		"Style 2" => "tab-style-two",
		"Style 3" => "tab-style-three",
		"Style 4" => "tab-style-four"
	)
));

/**
 * VC Progress bars.
 */

vc_add_param("vc_progress_bar", array(
	"type" => "dropdown",
	"heading" => __( 'Style', 'the7mk2' ),
	"param_name" => "caption_pos",
	"value" => array(
		'Style 1 (text on the bar)' => 'on',
		'Style 2 (text above the thick bar)' => 'top',
		'Style 3 (text above the thin bar)' => 'thin_top',
	)
));

vc_add_param("vc_progress_bar", array(
	"type" => "dropdown",
	"heading" => __( 'Background', 'the7mk2' ),
	"param_name" => "bgstyle",
	"value" => array(
		'Default' => 'default',
		'Outlines' => 'outline',
		'Semitransparent' => 'transparent',
	)
));

// add accent predefined color
$param = WPBMap::getParam('vc_progress_bar', 'bgcolor');
$param['value'] = array( 'Accent' => 'accent-bg', 'Custom' => 'custom' );
WPBMap::mutateParam('vc_progress_bar', $param);

$animation_options = array(
	'label'  => 'The7 animations',
	'values' => array_diff( presscore_get_vc_animation_options(), array(
		'',
		'bounceIn',
		'bounceInDown',
		'bounceInLeft',
		'bounceInRight',
		'bounceInUp',
		'fadeIn',
		'fadeInDown',
		'fadeInDownBig',
		'fadeInLeft',
		'fadeInLeftBig',
		'fadeInRight',
		'fadeInRightBig',
		'fadeInUp',
		'fadeInUpBig',
		'flipInX',
		'flipInY',
		'rotateIn',
		'rotateInDownLeft',
		'rotateInDownRight',
		'rotateInUpLeft',
		'rotateInUpRight',
		'rollIn',
		'zoomIn',
		'zoomInDown',
		'zoomInLeft',
		'zoomInRight',
		'zoomInUp',
	) ),
);

/**
 * VC Column text.
 */

// add custom animation
$param = WPBMap::getParam('vc_column_text', 'css_animation');
$param['settings']['custom'][] = $animation_options;
WPBMap::mutateParam('vc_column_text', $param);

/**
 * VC Message Box.
 */

// add custom animation
$param = WPBMap::getParam('vc_message', 'css_animation');
$param['settings']['custom'][] = $animation_options;
WPBMap::mutateParam('vc_message', $param);

/**
 * VC Single Image.
 */

// add custom animation
$param = WPBMap::getParam('vc_single_image', 'css_animation');
$param['settings']['custom'][] = $animation_options;
WPBMap::mutateParam('vc_single_image', $param);

// replace pretty photo with theme popup
$param = WPBMap::getParam('vc_single_image', 'onclick');

if ( $param && $key = array_search( 'link_image', $param['value'] ) ) {
	unset( $param['value'][ $key ] );

	$key = 'Open Magnific Popup';

	$param['value'][ $key ] = 'link_image';

	WPBMap::mutateParam('vc_single_image', $param);
}
unset( $param, $key );

vc_add_param("vc_single_image", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Image hovers", 'the7mk2'),
	"param_name" => "image_hovers",
	"std" => "true",
	"value" => array(
		"Disabled" => "false",
		"Enabled" => "true"
	)
));

/**
 * @since 3.1.4
 */
vc_add_param("vc_single_image", array(
	"type" => "checkbox",
	"heading" => __("Lazy loading", 'the7mk2'),
	"param_name" => "lazy_loading",
));

/**
 * @since 7.3.3
 */
vc_add_param( 'vc_single_image', array(
	'type'       => 'checkbox',
	'heading'    => __( 'Nofollow', 'the7mk2' ),
	'param_name' => 'rel_no_follow',
	'dependency' => array(
		'element' => 'onclick',
		'value'   => array( 'img_link_large', 'custom_link' ),
	),
) );

/**
 * VC Accordion.
 */

// undeprecate
vc_map_update( "vc_accordion", array(
	"deprecated" => null,
	"name"       => __( 'Accordion', 'the7mk2' ),
	"category"   => __( 'by Dream-Theme', 'the7mk2' ),
	"icon"       => "dt_vc_ico_accordion",
	"weight"     => - 1,
) );

vc_map_update( 'vc_accordion_tab', array(
	'deprecated' => null,
));

// title font size
vc_add_param("vc_accordion", array(
	"type" => "dropdown",
	"heading" => __("Title size", 'the7mk2'),
	"param_name" => "title_size",
	"value" => array(
		'small' => "small",
		'medium' => "normal",
		'large' => "big",
		'h1' => "h1",
		'h2' => "h2",
		'h3' => "h3",
		'h4' => "h4",
		'h5' => "h5",
		'h6' => "h6",
	),
	"std" => "big"
));

vc_add_param("vc_accordion", array(
	"type" => "dropdown",
	"heading" => __("Style", 'the7mk2'),
	"param_name" => "style",
	"value" => array(
		'Style 1 (no background)' => '1',
		'Style 2 (with background)' => '2',
		'Style 3 (with dividers)' => '3'
	),
	"description" => ""
));

/**
 * VC Button.
 */

vc_add_param( 'vc_btn', array(
	'type' => 'checkbox',
	'heading' => __( 'Smooth scroll?', 'the7mk2' ),
	'param_name' => 'smooth_scroll',
	'description' => __( 'for #anchor navigation', 'the7mk2' )
) );

vc_lean_map( 'vc_pie', null, dirname( __FILE__ ) . '/vc-bridges/the7-vc-pie-bridge.php' );
vc_lean_map( 'dt_fancy_title', null, dirname( __FILE__ ) . '/vc-bridges/the7-fancy-title-bridge.php' );
vc_lean_map( 'dt_fancy_separator', null, dirname( __FILE__ ) . '/vc-bridges/the7-fancy-separator-bridge.php' );
vc_lean_map( 'dt_quote', null, dirname( __FILE__ ) . '/vc-bridges/the7-fancy-quote-bridge.php' );
vc_lean_map( 'dt_call_to_action', null, dirname( __FILE__ ) . '/vc-bridges/the7-call-to-action-bridge.php' );
vc_lean_map( 'dt_teaser', null, dirname( __FILE__ ) . '/vc-bridges/the7-teaser-bridge.php' );
vc_lean_map( 'dt_banner', null, dirname( __FILE__ ) . '/vc-bridges/the7-banner-bridge.php' );
vc_lean_map( 'dt_contact_form', null, dirname( __FILE__ ) . '/vc-bridges/the7-contact-form-bridge.php' );
vc_lean_map( 'dt_blog_posts_small', null, dirname( __FILE__ ) . '/vc-bridges/the7-blog-mini-bridge.php' );
vc_lean_map( 'dt_blog_list', null, dirname( __FILE__ ) . '/vc-bridges/the7-blog-list-bridge.php' );
vc_lean_map( 'dt_blog_masonry', null, dirname( __FILE__ ) . '/vc-bridges/the7-blog-masonry-bridge.php' );
vc_lean_map( 'dt_blog_carousel', null, dirname( __FILE__ ) . '/vc-bridges/the7-blog-carousel-bridge.php' );
vc_lean_map( 'dt_blog_posts', null, dirname( __FILE__ ) . '/vc-bridges/the7-blog-posts-old-bridge.php' );
vc_lean_map( 'dt_blog_scroller', null, dirname( __FILE__ ) . '/vc-bridges/the7-blog-scroller-old-bridge.php' );
vc_lean_map( 'dt_gap', null, dirname( __FILE__ ) . '/vc-bridges/the7-gap-old-bridge.php' );
vc_lean_map( 'dt_fancy_image', null, dirname( __FILE__ ) . '/vc-bridges/the7-fancy-media-bridge.php' );
vc_lean_map( 'dt_button', null, dirname( __FILE__ ) . '/vc-bridges/the7-button-old-bridge.php' );
vc_lean_map( 'dt_vc_list', null, dirname( __FILE__ ) . '/vc-bridges/the7-fancy-list-bridge.php' );
vc_lean_map( 'dt_before_after', null, dirname( __FILE__ ) . '/vc-bridges/the7-before-after-bridge.php' );
vc_lean_map( 'dt_breadcrumbs', null, dirname( __FILE__ ) . '/vc-bridges/the7-breadcrumbs-bridge.php' );
vc_lean_map( 'dt_carousel', null, dirname( __FILE__ ) . '/vc-bridges/the7-carousel-bridge.php' );
vc_lean_map( 'dt_default_button', null, dirname( __FILE__ ) . '/vc-bridges/the7-default-button-bridge.php' );
vc_lean_map( 'dt_soc_icons', null, dirname( __FILE__ ) . '/vc-bridges/the7-social-icons-bridge.php' );
vc_lean_map( 'dt_single_soc_icon', null, dirname( __FILE__ ) . '/vc-bridges/the7-social-icon-bridge.php' );
vc_lean_map( 'dt_icon', null, dirname( __FILE__ ) . '/vc-bridges/the7-icon-bridge.php' );
vc_lean_map( 'dt_icon_text', null, dirname( __FILE__ ) . '/vc-bridges/the7-text-with-icon-bridge.php' );
vc_lean_map( 'dt_gallery_masonry', null, dirname( __FILE__ ) . '/vc-bridges/the7-media-gallery-masonry-bridge.php' );
vc_lean_map( 'dt_media_gallery_carousel', null, dirname( __FILE__ ) . '/vc-bridges/the7-media-gallery-carousel-bridge.php' );

if ( dt_is_woocommerce_enabled() ) {
	vc_lean_map( 'dt_products_carousel', null, dirname( __FILE__ ) . '/vc-bridges/the7-products-carousel-bridge.php' );
	vc_lean_map( 'dt_products_masonry', null, dirname( __FILE__ ) . '/vc-bridges/the7-products-masonry-bridge.php' );
}