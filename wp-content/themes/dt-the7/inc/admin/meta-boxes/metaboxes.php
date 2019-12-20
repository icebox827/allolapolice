<?php
/**
 * Theme metaboxes.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Load meta box fields templates
require_once PRESSCORE_ADMIN_DIR . '/meta-boxes/metabox-fields-templates.php';

/**
 * Get advanced settings open block.
 *
 * @return string.
 */
function presscore_meta_boxes_advanced_settings_tpl( $id = 'dt-advanced' ) {
	return sprintf(
		'<div class="hide-if-no-js"><div class="dt_hr"></div><p><a href="#advanced-options" class="dt_advanced">
				<input type="hidden" name="%1$s" data-name="%1$s" value="hide" />
				<span class="dt_advanced-show">%2$s</span>
				<span class="dt_advanced-hide">%3$s</span> 
				%4$s
			</a></p></div><div class="%1$s dt_container hide-if-js"><div class="dt_hr"></div>',
		esc_attr(''.$id),
		_x('+ Show', 'backend metabox', 'the7mk2'),
		_x('- Hide', 'backend metabox', 'the7mk2'),
		_x('advanced settings', 'backend metabox', 'the7mk2')
	);
}

// define global metaboxes array
global $DT_META_BOXES;
$DT_META_BOXES = array();

// Get widgetareas
$widgetareas_list = presscore_get_widgetareas_options();
if ( !$widgetareas_list ) {
	$widgetareas_list = array('none' => _x('None', 'backend metabox', 'the7mk2'));
}

// Ordering settings
$order_options = array(
	'ASC'	=> _x('ascending', 'backend', 'the7mk2'),
	'DESC'	=> _x('descending', 'backend', 'the7mk2'),
);

$orderby_options = array(
	'ID'			=> _x('ID', 'backend', 'the7mk2'),
	'author'		=> _x('author', 'backend', 'the7mk2'),
	'title'			=> _x('title', 'backend', 'the7mk2'),
	'date'			=> _x('date', 'backend', 'the7mk2'),
	'name'			=> _x('name', 'backend', 'the7mk2'),
	'modified'		=> _x('modified', 'backend', 'the7mk2'),
	'parent'		=> _x('parent', 'backend', 'the7mk2'),
	'rand'			=> _x('rand', 'backend', 'the7mk2'),
	'comment_count'	=> _x('comment_count', 'backend', 'the7mk2'),
	'menu_order'	=> _x('menu_order', 'backend', 'the7mk2'),
);

$yes_no_options = array(
	'1'	=> _x('Yes', 'backend metabox', 'the7mk2'),
	'0' => _x('No', 'backend metabox', 'the7mk2'),
);

$enabled_disabled = array(
	'1'	=> _x('Enabled', 'backend metabox', 'the7mk2'),
	'0' => _x('Disabled', 'backend metabox', 'the7mk2'),
);

// Image settings
$repeat_options = array(
	'repeat'	=> _x('repeat', 'backend', 'the7mk2'),
	'repeat-x'	=> _x('repeat-x', 'backend', 'the7mk2'),
	'repeat-y'	=> _x('repeat-y', 'backend', 'the7mk2'),
	'no-repeat'	=> _x('no-repeat', 'backend', 'the7mk2'),
);

$position_x_options = array(
	'center'	=> _x('center', 'backend', 'the7mk2'),
	'left'		=> _x('left', 'backend', 'the7mk2'),
	'right'		=> _x('right', 'backend', 'the7mk2'),
);

$position_y_options = array(
	'center'	=> _x('center', 'backend', 'the7mk2'),
	'top'		=> _x('top', 'backend', 'the7mk2'),
	'bottom'	=> _x('bottom', 'backend', 'the7mk2'),
);

$load_style_options = array(
	'ajax_pagination'	=> _x('Pagination & filter with AJAX', 'backend metabox', 'the7mk2'),
	'ajax_more'			=> _x('"Load more" button & filter with AJAX', 'backend metabox', 'the7mk2'),
	'lazy_loading'		=> _x('Lazy loading', 'backend metabox', 'the7mk2'),
	'default'			=> _x('Standard (no AJAX)', 'backend metabox', 'the7mk2')
);

$font_size = array(
	'h1'		=> _x('h1', 'backend metabox', 'the7mk2'),
	'h2'		=> _x('h2', 'backend metabox', 'the7mk2'),
	'h3'		=> _x('h3', 'backend metabox', 'the7mk2'),
	'h4'		=> _x('h4', 'backend metabox', 'the7mk2'),
	'h5'		=> _x('h5', 'backend metabox', 'the7mk2'),
	'h6'		=> _x('h6', 'backend metabox', 'the7mk2'),
	'small'		=> _x('small', 'backend metabox', 'the7mk2'),
	'normal'	=> _x('medium', 'backend metabox', 'the7mk2'),
	'big'		=> _x('large', 'backend metabox', 'the7mk2')
);

$accent_custom_color = array(
	'accent'	=> _x('Accent', 'backend metabox', 'the7mk2'),
	'color'		=> _x('Custom color', 'backend metabox', 'the7mk2')
);

$proportions = presscore_meta_boxes_get_images_proportions();
$proportions_max = count($proportions);
$proportions_maybe_1x1 = array_search( 1, wp_list_pluck( $proportions, 'ratio' ) );

$rev_sliders = $layer_sliders = array( 'none' => _x('none', 'backend metabox', 'the7mk2') );
$slideshow_mode_options = array();
$slideshow_posts = array();

if ( post_type_exists( 'dt_slideshow' ) ) {

	$slideshow_query = new WP_Query( array(
		'no_found_rows'		=> true,
		'cache_results'		=> false,
		'posts_per_page'	=> -1,
		'post_type'			=> 'dt_slideshow',
		'post_status'		=> 'publish',
		'suppress_filters'  => false,
	) );

	if ( $slideshow_query->have_posts() ) {

		foreach ( $slideshow_query->posts as $slidehsow_post ) {

			$slideshow_posts[ $slidehsow_post->ID ] = esc_html( $slidehsow_post->post_title );
		}
	}

	// Show modes.
	$slideshow_mode_options['porthole'] = array( _x('Porthole slider', 'backend metabox', 'the7mk2'), array( 'portholeslider.gif', 75, 50) );
	$slideshow_mode_options['photo_scroller'] = array( _x('Photo scroller', 'backend metabox', 'the7mk2'), array( 'photoscroller.gif', 75, 50) );
}

if ( class_exists('RevSlider') ) {

	$rev = new RevSlider();

	$arrSliders = $rev->getArrSliders();
	foreach ( (array) $arrSliders as $revSlider ) { 
		$rev_sliders[ $revSlider->getAlias() ] = $revSlider->getTitle();
	}

	$slideshow_mode_options['revolution'] = array( _x('Slider Revolution', 'backend metabox', 'the7mk2'), array( 'sliderrevolution.gif', 75, 50) );
}

if ( function_exists('lsSliders') ) {

	$layerSliders = lsSliders( 9999 );

	foreach ( $layerSliders as $lSlide ) {

		$layer_sliders[ $lSlide['id'] ] = $lSlide['name'];
	}

	$slideshow_mode_options['layer'] = array( _x('LayerSlider', 'backend metabox', 'the7mk2'), array( 'layerslider.gif', 75, 50) );
}
reset( $slideshow_mode_options );

$pages_with_basic_meta_boxes = presscore_get_pages_with_basic_meta_boxes();

/***********************************************************/
// Sidebar options
/***********************************************************/

$prefix = '_dt_sidebar_';

$DT_META_BOXES['dt_page_box-sidebar'] = array(
	'id'		=> 'dt_page_box-sidebar',
	'title' 	=> _x('Sidebar Options', 'backend metabox', 'the7mk2'),
	'pages' 	=> $pages_with_basic_meta_boxes,
	'context' 	=> 'side',
	'priority' 	=> 'low',
	'fields' 	=> array(

		// Sidebar option
		array(
			'name'    	=> _x('Sidebar position', 'backend metabox', 'the7mk2'),
			'id'      	=> "{$prefix}position",
			'type'    	=> 'radio',
			'std'		=> 'right',
			'options'	=> array(
				'left' 		=> array( _x('Left', 'backend metabox', 'the7mk2'), array('sidebar-left.gif', 75, 50) ),
				'right' 	=> array( _x('Right', 'backend metabox', 'the7mk2'), array('sidebar-right.gif', 75, 50) ),
				'disabled'	=> array( _x('Disabled', 'backend metabox', 'the7mk2'), array('sidebar-disabled.gif', 75, 50) ),
			),
			'hide_fields'	=> array(
				'disabled'	=> array("{$prefix}widgetarea_id", "{$prefix}hide_on_mobile" ),
			)
		),

		// Sidebar widget area
		array(
			'name'     		=> _x('Sidebar widget area', 'backend metabox', 'the7mk2'),
			'id'       		=> "{$prefix}widgetarea_id",
			'type'     		=> 'select',
			'options'  		=> $widgetareas_list,
			'std'			=> 'sidebar_1',
			'top_divider'	=> true
		),

		// Hide on mobile
		array(
			'name'    		=> _x('Hide on mobile layout', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}hide_on_mobile",
			'type'    		=> 'checkbox',
			'std'			=> 0
		),
	)
);

/***********************************************************/
// Footer options
/***********************************************************/

$prefix = '_dt_footer_';

$DT_META_BOXES['dt_page_box-footer'] = array(
	'id'		=> 'dt_page_box-footer',
	'title' 	=> _x('Footer Options', 'backend metabox', 'the7mk2'),
	'pages' 	=> $pages_with_basic_meta_boxes,
	'context' 	=> 'side',
	'priority' 	=> 'low',
	'fields' 	=> array(

		// Footer option
		array(
			'name'    		=> _x('Show widgetized footer', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}show",
			'type'    		=> 'checkbox',
			'std'			=> 1,
			'hide_fields'	=> array( "{$prefix}widgetarea_id", "{$prefix}hide_on_mobile" ),
		),

		// Sidebar widgetized area
		array(
			'name'     		=> _x('Footer widget area', 'backend metabox', 'the7mk2'),
			'id'       		=> "{$prefix}widgetarea_id",
			'type'     		=> 'select',
			'options'  		=> $widgetareas_list,
			'std'			=> 'sidebar_2',
			'top_divider'	=> true
		),

		// Hide on mobile
		array(
			'name'    		=> _x('Hide on mobile layout', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}hide_on_mobile",
			'type'    		=> 'checkbox',
			'std'			=> 0
		),
	)
);

/***********************************************************/
// Header options
/***********************************************************/
$header_title_options = array(
	'enabled'	=> array( _x('Show page title', 'backend metabox', 'the7mk2'), array('regular-title.gif', 100, 60) ),
	'disabled'	=> array( _x('Hide page title', 'backend metabox', 'the7mk2'), array('no-title.gif', 100, 60) ),
	'fancy'		=> array( _x('Fancy title', 'backend metabox', 'the7mk2'), array('fancy-title.gif', 100, 60) ),
	'slideshow'	=> array( _x('Slideshow', 'backend metabox', 'the7mk2'), array('slider.gif', 100, 60) ),
);

// Hide options if there is no slideshows.
if ( empty( $slideshow_mode_options ) ) {
	unset(  $header_title_options['slideshow'] );
}

$prefix = '_dt_header_';

$DT_META_BOXES['dt_page_box-header_options'] = array(
	'id'		=> 'dt_page_box-header_options',
	'title' 	=> _x('Page Header Options', 'backend metabox', 'the7mk2'),
	'pages' 	=> $pages_with_basic_meta_boxes,
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'fields' 	=> array(

		// Header options
		array(
			'id'      	=> "{$prefix}title",
			'type'    	=> 'radio',
			'std'		=> 'enabled',
			'options'	=> $header_title_options,
			'hide_fields'	=> array(
				'enabled'	=> array( "{$prefix}background_settings", "{$prefix}background-disabled-settings" ),
				'disabled'	=> array( "{$prefix}background_settings" ),
				'fancy'	    => array( "{$prefix}background-disabled-settings" ),
				'slideshow'	=> array( "{$prefix}background-disabled-settings" ),
			),
			'class'     => 'wide',
		),

		// Header overlapping
		array(
			// container begin !!!
			'before'      => '<div class="the7-mb-flickering-field ' . "the7-mb-input-{$prefix}background_settings" . '">',

			'name'        => '',
			'id'          => "{$prefix}background",
			'type'        => 'radio',
			'std'         => 'normal',
			'top_divider' => true,
			'options'     => array(
				'normal'          => array( _x( 'Default', 'backend metabox', 'the7mk2' ), array( 'regular.gif', 75, 50 ) ),
				'overlap'         => array( _x( "Overlapping", 'backend metabox', 'the7mk2' ), array( 'overl.gif', 75, 50 ) ),
				'transparent'     => array( _x( "Transparent", 'backend metabox', 'the7mk2' ), array( 'transp.gif', 75, 50 ) ),
			),
			'hide_fields' => array(
				'normal'          => array( "{$prefix}transparent_settings" ),
				'overlap'         => array( "{$prefix}transparent_settings" ),
			),
		),

		array(
			// container begin !!!
			'before'      => "<div class=\"the7-mb-flickering-field the7-mb-input-{$prefix}header-below-slideshow\">",

			"type"        => "radio",
			"id"          => "{$prefix}background_below_slideshow",
			"name"        => _x( "Header below slideshow", "theme-options", 'the7mk2' ),
			"std"         => "disabled",
			"options"     => array(
				'enabled'  => _x( "Enabled", "theme-options", 'the7mk2' ),
				'disabled' => _x( "Disabled", "theme-options", 'the7mk2' )
			),
			'top_divider' => true,

			'after'       => '</div>',
		),

		array(
			// container begin !!!
			'before'		=> '<div class="the7-mb-flickering-field ' . "the7-mb-input-{$prefix}transparent_settings" . '">',

			"type"    => "radio",
			"id"      => "{$prefix}transparent_bg_color_scheme",
			"name"    => _x( "Color scheme", "theme-options", 'the7mk2' ),
			"std"     => "light",
			"options" => array(
				'from_options' => _x( "From Theme Options", "theme-options", 'the7mk2' ),
				'light'        => _x( "Light", "theme-options", 'the7mk2' ),
			),

		),

		array(
			'name'    		=> _x(' Top bar color', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}transparent_top_bar_bg_color",
			'type'    		=> 'color',
			'std'			=> '#ffffff',
		),

		array(
			'name'	=> _x('Top bar opacity', 'backend metabox', 'the7mk2'),
			'id'	=> "{$prefix}transparent_top_bar_bg_opacity",
			'type'	=> 'slider',
			'std'	=> 25,
			'js_options' => array(
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,
			),
		),

		array(
			'name'    		=> _x('Header background color', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}transparent_bg_color",
			'type'    		=> 'color',
			'std'			=> '#000000',
		),

		array(
			'name'	=> _x('Header background opacity', 'backend metabox', 'the7mk2'),
			'id'	=> "{$prefix}transparent_bg_opacity",
			'type'	=> 'slider',
			'std'	=> 50,
			'js_options' => array(
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,
			),
			'after'  => '</div></div>',
		),
		// Disable page title.
		array(
			// container begin !!!
			'before'      => '<div class="the7-mb-flickering-field ' . "the7-mb-input-{$prefix}background-disabled-settings" . '">',

			'name'        => '',
			'id'          => "{$prefix}disabled_background",
			'type'        => 'radio',
			'std'         => 'normal',
			'top_divider' => true,
			'options'     => array(
				'normal'          => array( _x( 'Default', 'backend metabox', 'the7mk2' ), array( 'regular.gif', 75, 50 ) ),
				'transparent'     => array( _x( "Transparent", 'backend metabox', 'the7mk2' ), array( 'transp.gif', 75, 50 ) ),
			),
			'hide_fields' => array(
				'normal'          => array( "{$prefix}background-disabled-transparent_settings" ),
			),
		),
		array(
			// container begin !!!
			'before'  => '<div class="the7-mb-flickering-field the7-mb-input-' . $prefix . 'background-disabled-transparent_settings">',

			"type"    => "radio",
			"id"      => "{$prefix}disabled_transparent_bg_color_scheme",
			"name"    => _x( "Color scheme", "theme-options", 'the7mk2' ),
			"std"     => "light",
			"options" => array(
				'from_options' => _x( "From Theme Options", "theme-options", 'the7mk2' ),
				'light'        => _x( "Light", "theme-options", 'the7mk2' ),
			),
		),
		array(
			'name'    		=> _x(' Top bar color', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}disabled_transparent_top_bar_bg_color",
			'type'    		=> 'color',
			'std'			=> '#ffffff',
		),
		array(
			'name'	=> _x('Top bar opacity', 'backend metabox', 'the7mk2'),
			'id'	=> "{$prefix}disabled_transparent_top_bar_bg_opacity",
			'type'	=> 'slider',
			'std'	=> 25,
			'js_options' => array(
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,
			),
		),
		array(
			'name'    		=> _x('Transparent background color', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}disabled_transparent_bg_color",
			'type'    		=> 'color',
			'std'			=> '#000000',
		),
		array(
			'name'	=> _x('Transparent background opacity', 'backend metabox', 'the7mk2'),
			'id'	=> "{$prefix}disabled_transparent_bg_opacity",
			'type'	=> 'slider',
			'std'	=> 50,
			'js_options' => array(
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,
			),

			'after'  => '</div></div>',
		),
	)
);

$prefix = '_dt_page_overrides_';

$DT_META_BOXES['dt_page_box-page_vertical_margins'] = array(
	'id'		=> 'dt_page_box-page_vertical_margins',
	'title' 	=> _x('Page Margins', 'backend metabox', 'the7mk2'),
	'pages' 	=> $pages_with_basic_meta_boxes,
	'context' 	=> 'side',
	'priority' 	=> 'low',
	'fields' 	=> array(
		array(
			'name'			=> _x('Top (in px)', 'backend metabox', 'the7mk2'),
			'desc'			=> _x('Leave empty to use value from theme options.', 'backend metabox', 'the7mk2'),
			'id'    		=> "{$prefix}top_margin",
			'type'  		=> 'text',
			'std'   		=> '',
		),
		array(
			'name'			=> _x('Bottom (in px)', 'backend metabox', 'the7mk2'),
			'desc'			=> _x('Leave empty to use value from theme options.', 'backend metabox', 'the7mk2'),
			'id'    		=> "{$prefix}bottom_margin",
			'type'  		=> 'text',
			'std'   		=> '',
		),
	)
);

/***********************************************************/
// Slideshow Options
/***********************************************************/

$prefix = '_dt_slideshow_';

$DT_META_BOXES['dt_page_box-slideshow_options'] = array(
	'id'		=> 'dt_page_box-slideshow_options',
	'title' 	=> _x('Slideshow Options', 'backend metabox', 'the7mk2'),
	'pages' 	=> $pages_with_basic_meta_boxes,
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'only_on' => array(
		'meta_value' => array(
			'_dt_header_title' => 'slideshow',
		)
	),
	'fields' 	=> array(

		// Slideshow mode
		array(
			'id'      	=> "{$prefix}mode",
			'type'    	=> 'radio',
			'std'		=> key( $slideshow_mode_options ),
			'options'	=> $slideshow_mode_options,
			'hide_fields'	=> array(
				'porthole' => array( "{$prefix}photo_scroller_container", "{$prefix}revolution_slider", "{$prefix}layer_container" ),
				'photo_scroller' => array( "{$prefix}porthole_container", "{$prefix}revolution_slider", "{$prefix}layer_container" ),
				'3d' => array( "{$prefix}porthole_container", "{$prefix}revolution_slider", "{$prefix}layer_container", "{$prefix}photo_scroller_container" ),
				'revolution' => array( "{$prefix}porthole_container",  "{$prefix}sliders", "{$prefix}layer_container", "{$prefix}photo_scroller_container" ),
				'layer' => array( "{$prefix}porthole_container", "{$prefix}sliders", "{$prefix}revolution_slider", "{$prefix}photo_scroller_container" ),
			)
		),

		// Sldeshows
		array(
			'name'    		=> _x('Slideshow(s)', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}sliders",
			'type'    		=> 'checkbox_list',
			'desc'  		=> $slideshow_posts ? _x('if non selected, all slideshows will be displayed.', 'backend metabox', 'the7mk2') . ' ' . presscore_get_post_type_edit_link( 'dt_slideshow', _x( 'Edit slideshows', 'backend metabox', 'the7mk2' ) ) : _x( 'none', 'backend metabox', 'the7mk2' ),
			'options'		=> $slideshow_posts,
			'top_divider'	=> true,
		),


		// Slideshow layout
		array(
			// container begin !!!
			'before'		=> '<div class="the7-mb-input-' . $prefix . 'porthole_container the7-mb-flickering-field">',

			'name'			=> _x('Slider layout', 'backend metabox', 'the7mk2'),
			'id'      	=> "{$prefix}layout",
			'type'    	=> 'radio',
			'std'		=> 'fullwidth',
			'options'	=> array(
				'fullwidth'		=> _x('full-width', 'backend metabox', 'the7mk2'),
				'fixed'			=> _x('content-width', 'backend metabox', 'the7mk2'),
			),
			'top_divider'	=> true,
		),

		// Slider proportions
		array(
			'name'			=> _x('Slider proportions', 'backend metabox', 'the7mk2'),
			'id'    		=> "{$prefix}slider_proportions",
			'type'  		=> 'simple_proportions',
			'std'   		=> array('width' => 1200, 'height' => 500),
		),

		// Scaling
		array(
			'name'			=> _x('Images sizing ', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}scaling",
			'type'    		=> 'radio',
			'std'			=> 'fill',
			'options'	=> array(
				'fit'		=> _x('fit (preserve proportions)', 'backend metabox', 'the7mk2'),
				'fill'		=> _x('fill the viewport (crop)', 'backend metabox', 'the7mk2'),
			),
			'top_divider'	=> true,
		),

		// Autoplay
		array(
			'name'			=> _x('On page load slideshow is ', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}autoplay",
			'type'    		=> 'radio',
			'std'			=> 'paused',
			'options'	=> array(
				'play'		=> _x('playing', 'backend metabox', 'the7mk2'),
				'paused'	=> _x('paused', 'backend metabox', 'the7mk2'),
			),
			'top_divider'	=> true,
		),

		// Autoslide interval
		array(
			'name'			=> _x('Autoslide interval (in milliseconds)', 'backend metabox', 'the7mk2'),
			'id'    		=> "{$prefix}autoslide_interval",
			'type'  		=> 'text',
			'std'   		=> '5000'
		),

		// Hide captions
		array(
			'name'    		=> _x('Hide captions', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}hide_captions",
			'type'    		=> 'checkbox',
			'std'			=> 0,

			// container end
			'after'			=> '</div>'
		),

		//////////////////////
		// Photo scroller //
		//////////////////////

		array(
			// container begin !!!
			'before'	=> '<div class="the7-mb-input-' . $prefix . 'photo_scroller_container the7-mb-flickering-field">',

			'name'		=> _x( 'Layout', 'backend metabox', 'the7mk2' ),
			'id'		=> "{$prefix}photo_scroller_layout",
			'type'		=> 'radio',
			'std'		=> 'fullscreen',
			'options'	=> array(
				'fullscreen'	=> _x( 'Fullscreen slideshow', 'backend metabox', 'the7mk2' ),
				'with_content'	=> _x( 'Fullscreen slideshow + text area', 'backend metabox', 'the7mk2' )
			),
			'divider'	=> 'top'
		),

		array(
			'name'     		=> _x( 'Background under slideshow', 'backend metabox', 'the7mk2' ),
			'id'       		=> "{$prefix}photo_scroller_bg_color",
			'type'     		=> 'color',
			'std'			=> '#000000',
			'divider'		=> 'top'
		),

		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array(
			'id'		=> "{$prefix}photo_scroller_overlay",
			'name'		=> _x( 'Show pixel overlay', 'backend metabox', 'the7mk2' ),
			'divider'	=> 'top'
		) ),

		array(
			'name'			=> _x('Top padding', 'backend metabox', 'the7mk2'),
			'id'			=> "{$prefix}photo_scroller_top_padding",
			'type'			=> 'text',
			'std'			=> '0',
			'divider'		=> 'top'
		),

		array(
			'name'			=> _x('Bottom padding', 'backend metabox', 'the7mk2'),
			'id'			=> "{$prefix}photo_scroller_bottom_padding",
			'type'			=> 'text',
			'std'			=> '0',
			'divider'		=> 'top'
		),

		array(
			'name'			=> _x('Side paddings', 'backend metabox', 'the7mk2'),
			'id'			=> "{$prefix}photo_scroller_side_paddings",
			'type'			=> 'text',
			'std'			=> '0',
			'divider'		=> 'top'
		),

		Presscore_Meta_Box_Field_Template::get_as_array( 'opacity slider', array(
			'name'		=> _x( 'Inactive image transparency (%)', 'backend metabox', 'the7mk2' ),
			'id'		=> "{$prefix}photo_scroller_inactive_opacity",
			'std' => 15,
			'divider'	=> 'top'
		) ),

		array(
			'name'     	=> _x( 'Thumbnails', 'backend metabox', 'the7mk2' ),
			'id'       	=> "{$prefix}photo_scroller_thumbnails_visibility",
			'type'     	=> 'radio',
			'std'		=> 'show',
			'options'  	=> array(
				'show'		=> _x( 'Show by default', 'backend metabox', 'the7mk2' ),
				'hide'		=> _x( 'Hide by default', 'backend metabox', 'the7mk2' ),
				'disabled'	=> _x( 'Disable', 'backend metabox', 'the7mk2' )
			),
			'divider'	=> 'top'
		),

		array(
			'name'		=> _x( 'Thumbnails width', 'backend metabox', 'the7mk2' ),
			'id'		=> "{$prefix}photo_scroller_thumbnails_width",
			'type'		=> 'text',
			'std'		=> '',
			'divider'	=> 'top'
		),

		array(
			'name'		=> _x( 'Thumbnails height', 'backend metabox', 'the7mk2' ),
			'id'		=> "{$prefix}photo_scroller_thumbnails_height",
			'type'		=> 'text',
			'std'		=> 85,
			'divider'	=> 'top'
		),

		array(
			'name'     	=> _x( 'Autoplay', 'backend metabox', 'the7mk2' ),
			'id'       	=> "{$prefix}photo_scroller_autoplay",
			'type'     	=> 'radio',
			'std'		=> 'play',
			'options'  	=> array(
				'play'		=> _x( 'Play', 'backend metabox', 'the7mk2' ),
				'paused'	=> _x( 'Paused', 'backend metabox', 'the7mk2' ),
			),
			'divider'	=> 'top'
		),

		array(
			'name'		=> _x( 'Autoplay speed', 'backend metabox', 'the7mk2' ),
			'id'		=> "{$prefix}photo_scroller_autoplay_speed",
			'type'		=> 'text',
			'std'		=> '4000',
			'divider'	=> 'top'
		),

		array(
			'type' => 'heading',
			'name' => _x( 'Landscape images', 'backend metabox', 'the7mk2' ),
			'id' => 'fake_id',
		),

		// Landscape images settings

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller max width', array(
			'id' => "{$prefix}photo_scroller_ls_max_width",
		) ),

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller min width', array(
			'id' => "{$prefix}photo_scroller_ls_min_width",
		) ),

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller filling mode desktop', array(
			'id' => "{$prefix}photo_scroller_ls_fill_dt",
		) ),

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller filling mode mobile', array(
			'id' => "{$prefix}photo_scroller_ls_fill_mob",
		) ),

		// Portrait iamges settings

		array(
			'type' => 'heading',
			'name' => _x( 'Portrait images', 'backend metabox', 'the7mk2' ),
			'id' => 'fake_id',
		),

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller max width', array(
			'id' => "{$prefix}photo_scroller_pt_max_width",
		) ),

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller min width', array(
			'id' => "{$prefix}photo_scroller_pt_min_width",
		) ),

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller filling mode desktop', array(
			'id' => "{$prefix}photo_scroller_pt_fill_dt",
		) ),

		Presscore_Meta_Box_Field_Template::get_as_array( 'photoscroller filling mode mobile', array(
			'id' => "{$prefix}photo_scroller_pt_fill_mob",

			// container end !!!
			'after' => '</div>',
		) ),

		// Revolution slider
		array(
			'name'     		=> _x('Choose slider ', 'backend metabox', 'the7mk2'),
			'id'       		=> "{$prefix}revolution_slider",
			'type'     		=> 'select',
			'std'			=>'none',
			'options'  		=> $rev_sliders,
			'multiple' 		=> false,
			'top_divider'	=> true
		),

		// LayerSlider
		array(
			// container begin !!!
			'before'		=> '<div class="the7-mb-input-' . $prefix . 'layer_container the7-mb-flickering-field">',

			'name'     		=> _x('Choose slider', 'backend metabox', 'the7mk2'),
			'id'       		=> "{$prefix}layer_slider",
			'type'     		=> 'select',
			'std'			=>'none',
			'options'  		=> $layer_sliders,
			'multiple' 		=> false,
			'top_divider'	=> true
		),

		// Fixed background
		array(
			// container end !!!
			'after'			=> '</div>',

			'name'    		=> _x('Enable slideshow background and paddings', 'backend metabox', 'the7mk2'),
			'id'      		=> "{$prefix}layer_show_bg_and_paddings",
			'type'    		=> 'checkbox',
			'std'			=> 0
		),

	)
);

Include dirname( __FILE__ ) . '/fancy-title-meta-box.php';

/***********************************************************/
// Content area options
/***********************************************************/

$prefix = '_dt_content_';

$DT_META_BOXES['dt_page_box-page_content'] = array(
	'id'		=> 'dt_page_box-page_content',
	'title' 	=> _x('Content Area Options', 'backend metabox', 'the7mk2'),
	'pages' 	=> array( 'page' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'fields' 	=> array(

		// Display content area
		array(
			'name'    	=> _x('Display content area', 'backend metabox', 'the7mk2'),
			'id'      	=> "{$prefix}display",
			'type'    	=> 'radio',
			'std'		=> 'no',
			'options'	=> array(
				'no' 			=> _x('no', 'backend metabox', 'the7mk2'),
				'on_first_page'	=> _x('first page', 'backend metabox', 'the7mk2'),
				'on_all_pages'	=> _x('all pages', 'backend metabox', 'the7mk2'),
			),
			'hide_fields'	=> array('no'	=> "{$prefix}position")
		),

		// Content area position
		array(
			'name'    	=> _x('Content area position', 'backend metabox', 'the7mk2'),
			'id'      	=> "{$prefix}position",
			'type'    	=> 'radio',
			'std'		=> 'before_items',
			'options'	=> array(
				'before_items'	=> array( _x('Before items', 'backend metabox', 'the7mk2'), array( 'before-posts.gif', 60, 67 ) ),
				'after_items'	=> array( _x('After items', 'backend metabox', 'the7mk2'), array( 'under-posts.gif', 60, 67 ) ),
			),
		),

	),
	'only_on'	=> array( 'template' => array(
		'template-portfolio-list.php',
		'template-portfolio-masonry.php',
		'template-portfolio-jgrid.php',
		'template-blog-list.php',
		'template-blog-masonry.php',
		'template-albums.php',
		'template-albums-jgrid.php',
		'template-media.php',
		'template-media-jgrid.php',
		'template-team.php',
		'template-testimonials.php',
	) ),
);
