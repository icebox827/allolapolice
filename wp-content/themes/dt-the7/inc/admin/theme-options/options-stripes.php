<?php
/**
 * Stripes.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page definition.
 */
$options[] = array(
	'page_title' => _x( 'Stripes', 'theme-options', 'the7mk2' ),
	'menu_title' => _x( 'Stripes', 'theme-options', 'the7mk2' ),
	'menu_slug'  => 'of-stripes-menu',
	'type'       => 'page',
);

foreach ( presscore_themeoptions_get_stripes_list() as $suffix => $stripe ) {

	/**
	 * Heading definition.
	 */
	$options[] = array( 'name' => $stripe['title'], 'type' => 'heading', 'id' => "stripe{$suffix}" );

	/**
	 * Stripe.
	 */
	$options[] = array( 'name' => $stripe['title'], 'type' => 'block' );

	$options[] = array( 'type' => 'title', 'name' => _x( 'Background', 'theme-options', 'the7mk2' ) );

	$options["stripes-stripe_{$suffix}_color"] = array(
		'name' => _x( 'Color', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_color",
		'std'  => $stripe['bg_color'],
		'type' => 'color',
	);

	$options["stripes-stripe_{$suffix}_bg_image"] = array(
		'name'   => _x( 'Add background image', 'theme-options', 'the7mk2' ),
		'id'     => "stripes-stripe_{$suffix}_bg_image",
		'std'    => $stripe['bg_img'],
		'type'   => 'background_img',
		'fields' => array(),
	);

	$options[] = array( 'type' => 'divider' );

	$options["stripes-stripe_{$suffix}_outline"] = array(
		'name'      => _x( 'Outlines', 'theme-options', 'the7mk2' ),
		'id'        => "stripes-stripe_{$suffix}_outline",
		'std'       => 'hide',
		'type'      => 'images',
		'class'     => 'small',
		'show_hide' => array( 'show' => true ),
		'options'   => array(
			'show' => array(
				'title' => _x( 'Show', 'theme-options', 'the7mk2' ),
				'src'   => '/inc/admin/assets/images/stripes-stripe-outline-enabled.gif',
			),
			'hide' => array(
				'title' => _x( 'Hide', 'theme-options', 'the7mk2' ),
				'src'   => '/inc/admin/assets/images/stripes-stripe-outline-disabled.gif',
			),
		),
	);

	$options[] = array( 'type' => 'js_hide_begin' );

	$options["stripes-stripe_{$suffix}_outline_color"] = array(
		'name' => _x( 'Outlines color', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_outline_color",
		'std'  => '#FFFFFF',
		'type' => 'color',
	);

	$options["stripes-stripe_{$suffix}_outline_opacity"] = array(
		'name' => _x( 'Outlines opacity', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_outline_opacity",
		'std'  => 100,
		'type' => 'slider',
	);

	$options[] = array( 'type' => 'js_hide_end' );

	$options[] = array( 'type' => 'divider' );

	$options[] = array( 'type' => 'title', 'name' => _x( 'Content boxes background', 'theme-options', 'the7mk2' ) );

	$options["stripes-stripe_{$suffix}_content_boxes_bg_color"] = array(
		'name' => _x( 'Background color', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_content_boxes_bg_color",
		'std'  => '#FFFFFF',
		'type' => 'color',
	);

	$options["stripes-stripe_{$suffix}_content_boxes_bg_opacity"] = array(
		'name' => _x( 'Background opacity', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_content_boxes_bg_opacity",
		'std'  => 100,
		'type' => 'slider',
	);

	$options["stripes-stripe_{$suffix}_content_boxes_decoration"] = array(
		'name'      => _x( 'Decoration', 'theme-options', 'the7mk2' ),
		'id'        => "stripes-stripe_{$suffix}_content_boxes_decoration",
		'std'       => 'none',
		'type'      => 'images',
		'class'     => 'small',
		'show_hide' => array( 'outline' => true ),
		'options'   => array(
			'none'    => array(
				'title' => _x( 'None', 'theme-options', 'the7mk2' ),
				'src'   => '/inc/admin/assets/images/general-content_boxes_decoration-none.gif',
			),
			'shadow'  => array(
				'title' => _x( 'Shadow', 'theme-options', 'the7mk2' ),
				'src'   => '/inc/admin/assets/images/general-content_boxes_decoration-shadow.gif',
			),
			'outline' => array(
				'title' => _x( 'Outline', 'theme-options', 'the7mk2' ),
				'src'   => '/inc/admin/assets/images/general-content_boxes_decoration-outline.gif',
			),
		),
	);

	$options[] = array( 'type' => 'js_hide_begin' );

	$options["stripes-stripe_{$suffix}_content_boxes_decoration_outline_color"] = array(
		'name' => _x( 'Decoration outline color', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_content_boxes_decoration_outline_color",
		'std'  => '#FFFFFF',
		'type' => 'color',
	);

	$options["stripes-stripe_{$suffix}_content_boxes_decoration_outline_opacity"] = array(
		'name' => _x( 'Decoration outline opacity', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_content_boxes_decoration_outline_opacity",
		'std'  => 100,
		'type' => 'slider',
	);

	$options[] = array( 'type' => 'js_hide_end' );

	$options[] = array( 'type' => 'divider' );

	$options[] = array( 'type' => 'title', 'name' => _x( 'Text', 'theme-options', 'the7mk2' ) );

	$options["stripes-stripe_{$suffix}_headers_color"] = array(
		'name' => _x( 'Headings color', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_headers_color",
		'std'  => $stripe['text_header_color'],
		'type' => 'color',
	);

	$options["stripes-stripe_{$suffix}_text_color"] = array(
		'name' => _x( 'Text color', 'theme-options', 'the7mk2' ),
		'id'   => "stripes-stripe_{$suffix}_text_color",
		'std'  => $stripe['text_color'],
		'type' => 'color',
	);

}
