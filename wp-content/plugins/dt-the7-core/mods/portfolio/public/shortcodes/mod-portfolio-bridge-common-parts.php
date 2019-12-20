<?php
/**
 * Portfolio shortcodes VC bridge.
 *
 * @package the7\Portfolio\Shortcodes
 * @since 3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// templates
$loading_effect = array(
	"group"         => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Loading effect", 'dt-the7-core' ),
	"param_name"	=> "loading_effect",
	"type"			=> "dropdown",
	"value"			=> array(
		'None'				=> 'none',
		'Fade in'			=> 'fade_in',
		'Move up'			=> 'move_up',
		'Scale up'			=> 'scale_up',
		'Fall perspective'	=> 'fall_perspective',
		'Fly'				=> 'fly',
		'Flip'				=> 'flip',
		'Helix'				=> 'helix',
		'Scale'				=> 'scale',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$show_title = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"param_name"	=> "show_title",
	"type"			=> "checkbox",
	"value"			=> array( "Show projects titles" => "true" ),
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$show_excerpt = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"param_name"	=> "show_excerpt",
	"type"			=> "checkbox",
	"value"			=> array( "Show projects excerpts" => "true" ),
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$show_categories = array(
	"group" => __( "Project Meta", 'dt-the7-core' ),
	"param_name"	=> "show_categories",
	"type"			=> "checkbox",
	"value"			=> array( "Show project categories" => "true" ),
);

$show_date = array(
	"group" => __( "Project Meta", 'dt-the7-core' ),
	"param_name"	=> "show_date",
	"type"			=> "checkbox",
	"value"			=> array( "Show project date" => "true" ),
);

$show_author = array(
	"group" => __( "Project Meta", 'dt-the7-core' ),
	"param_name"	=> "show_author",
	"type"			=> "checkbox",
	"value"			=> array( "Show project author" => "true" ),
);

$show_comments = array(
	"group" => __( "Project Meta", 'dt-the7-core' ),
	"param_name"	=> "show_comments",
	"type"			=> "checkbox",
	"value"			=> array( "Show project comments" => "true" ),
);

$show_filter = array(
	"param_name"	=> "show_filter",
	"type"			=> "checkbox",
	"value"			=> array( "Show categories filter" => "true" ),
);

$show_orderby = array(
	"param_name"	=> "show_orderby",
	"type"			=> "checkbox",
	"value"			=> array( "Show name / date ordering" => "true" ),
);

$show_order = array(
	"param_name"	=> "show_order",
	"type"			=> "checkbox",
	"value"			=> array( "Show asc. / desc. ordering" => "true" ),
);

$show_details = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"param_name"	=> "show_details",
	"type"			=> "checkbox",
	"value"			=> array( "Details icon on hover" => "true" ),
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$show_link = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"param_name"	=> "show_link",
	"type"			=> "checkbox",
	"value"			=> array( "Link icon on hover" => "true" ),
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$show_zoom = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"param_name"	=> "show_zoom",
	"type"			=> "checkbox",
	"value"			=> array( "Zoom icon on hover" => "true" ),
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$number = array(
	"heading"		=> __( "Number of projects to show", 'dt-the7-core' ),
	"param_name"	=> "number",
	"type"			=> "textfield",
	"value"			=> "12",
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$posts_per_page = array(
	"heading"		=> __( "Projects per page", 'dt-the7-core' ),
	"param_name"	=> "posts_per_page",
	"type"			=> "textfield",
	"value"			=> "-1",
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$orderby = array(
	'heading'          => __( 'Order by', 'dt-the7-core' ),
	'description'      => __( 'Select how to sort retrieved posts.', 'dt-the7-core' ),
	'param_name'       => 'orderby',
	'type'             => 'dropdown',
	'std'              => 'date',
	'value'            => array(
		'Author'        => 'author',
		'Slug'          => 'name',
		'Date'          => 'date',
		'Name'          => 'title',
		'ID'            => 'ID',
		'Modified'      => 'modified',
		'Comment count' => 'comment_count',
		'Menu order'    => 'menu_order',
		'Rand'          => 'rand',
	),
	'edit_field_class' => 'vc_col-sm-6 vc_column',
);

$order = array(
	"heading"		=> __( "Order way", 'dt-the7-core' ),
	"description"	=> __( "Designates the ascending or descending order.", 'dt-the7-core' ),
	"param_name"	=> "order",
	"type"			=> "dropdown",
	"value"			=> array(
		"Descending"	=> "desc",
		"Ascending"		=> "asc",
	),
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$category = array(
	"heading"		=> __( "Categories", 'dt-the7-core' ),
	"param_name"	=> "category",
	"type"			=> "dt_taxonomy",
	"taxonomy"		=> "dt_portfolio_category",
	"admin_label"	=> true,
	"description"	=> __( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'dt-the7-core' ),
);

$padding = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Gap between images (px)", 'dt-the7-core' ),
	"param_name"	=> "padding",
	"type"			=> "textfield",
	"value"			=> "20",
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$proportion = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Thumbnails proportions", 'dt-the7-core' ),
	"description"	=> __( "Width:height (e.g. 16:9). Leave this field empty to preserve original image proportions.", 'dt-the7-core' ),
	"param_name"	=> "proportion",
	"type"			=> "textfield",
	"value"			=> "",
	"edit_field_class" => "vc_col-sm-6 vc_column",
);

$descriptions = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Show projects descriptions", 'dt-the7-core' ),
	"param_name"	=> "descriptions",
	"type"			=> "dropdown",
	"value"			=> array(
		'Under images'							=> 'under_image',
		'On colored background'					=> 'on_hover_centered',
		'On dark gradient'						=> 'on_dark_gradient',
		'In the bottom'							=> 'from_bottom',
		'Background & animated lines'			=> 'bg_with_lines',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$bg_under_projects = array(

	"heading"		=> __( "Background under projects", 'dt-the7-core' ),
	"param_name"	=> "bg_under_projects",
	"type"			=> "dropdown",
	"value"			=> array(
		'Enabled (image with paddings)'		=> 'with_paddings',
		'Enabled (image without paddings)'	=> 'fullwidth',
		'Disabled'							=> 'disabled',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$hover_animation = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Animation", 'dt-the7-core' ),
	"param_name"	=> "hover_animation",
	"type"			=> "dropdown",
	"value"			=> array(
		'Fade'						=> 'fade',
		'Direction aware'			=> 'direction_aware',
		'Reverse direction aware'	=> 'redirection_aware',
		'Scale in'					=> 'scale_in',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$hover_bg_color = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Image hover background color", 'dt-the7-core' ),
	"param_name"	=> "hover_bg_color",
	"type"			=> "dropdown",
	"value"			=> array(
		'Color (from Theme Options)'	=> 'accent',
		'Dark'							=> 'dark',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$bgwl_animation_effect = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Animation effect", 'dt-the7-core' ),
	"param_name"	=> "bgwl_animation_effect",
	"type"			=> "dropdown",
	"value"			=> array(
		'Effect 1'	=> '1',
		'Effect 2'	=> '2',
		'Effect 3'	=> '3',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$hover_content_visibility = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Content", 'dt-the7-core' ),
	"param_name"	=> "hover_content_visibility",
	"type"			=> "dropdown",
	"value"			=> array(
		'On hover'			=> 'on_hover',
		'Always visible'	=> 'always'
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$colored_bg_content_aligment = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Content alignment", 'dt-the7-core' ),
	"param_name"	=> "colored_bg_content_aligment",
	"type"			=> "dropdown",
	"value"			=> array(
		"Centre"		=> "centre",
		"Bottom"		=> "bottom",
		"Left & top"	=> "left_top",
		"Left & bottom"	=> "left_bottom",
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$content_aligment = array(
	"group" => __( "Appearance", 'dt-the7-core' ),
	"heading"		=> __( "Content alignment", 'dt-the7-core' ),
	"param_name"	=> "content_aligment",
	"type"			=> "dropdown",
	"value"			=> array(
		'Left'			=> 'left',
		'Centre'		=> 'center',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
);

$number_order_title = array(
	"heading" => __( "Projects Number & Order", 'dt-the7-core' ),
	"param_name" => "dt_title",
	"type" => "dt_title",
);

$design_title = array(
	"group" => __("Appearance", 'dt-the7-core'),
	"heading" => __( "Project Design", 'dt-the7-core' ),
	"param_name" => "dt_title",
	"type" => "dt_title",
);

$elements_title = array(
	"group" => __("Appearance", 'dt-the7-core'),
	"heading" => __( "Project Elements", 'dt-the7-core' ),
	"param_name" => "dt_title",
	"type" => "dt_title",
);

$filter_title = array(
	"heading" => __( "Projects Filter", 'dt-the7-core' ),
	"param_name" => "dt_title",
	"type" => "dt_title",
);
