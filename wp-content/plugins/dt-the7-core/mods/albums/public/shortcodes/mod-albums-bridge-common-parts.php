<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// common
$loading_effect = array(
	array(
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
		"group" => __( "Appearance", 'dt-the7-core' ),
	),
);

$show_meta = array(
		array(
			"value"			=> array( "Show album categories" => "true" ),
			"param_name"	=> "show_categories",
			"type"			=> "checkbox",
			"group" => __( "Project Meta", 'dt-the7-core' ),
		),
		array(
			"value"			=> array( "Show album date" => "true" ),
			"param_name"	=> "show_date",
			"type"			=> "checkbox",
			"group" => __( "Project Meta", 'dt-the7-core' ),
		),
		array(
			"value"			=> array( "Show album author" => "true" ),
			"param_name"	=> "show_author",
			"type"			=> "checkbox",
			"group" => __( "Project Meta", 'dt-the7-core' ),
		),
		array(
			"value"			=> array( "Show album comments" => "true" ),
			"param_name"	=> "show_comments",
			"type"			=> "checkbox",
			"group" => __( "Project Meta", 'dt-the7-core' ),
		),
);

$ordering = array(
	array(
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
		'edit_field_class' => 'vc_col-sm-6 vc_column dt_stle',
	),
	array(
		'heading'          => __( 'Order way', 'dt-the7-core' ),
		'description'      => __( 'Designates the ascending or descending order.', 'dt-the7-core' ),
		'param_name'       => 'order',
		'type'             => 'dropdown',
		'value'            => array(
			'Descending' => 'desc',
			'Ascending'  => 'asc',
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	),
);

$category = array(
	array(
		"heading"		=> __( "Categories", 'dt-the7-core' ),
		"description"	=> __( "Note: By default, all your albums will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'dt-the7-core' ),
		"param_name"	=> "category",
		"type"			=> "dt_taxonomy",
		"taxonomy"		=> "dt_gallery_category",
		"admin_label"	=> true,
	)
);

$padding = array(
	array(
		"heading"		=> __( "Gap between images (px)", 'dt-the7-core' ),
		"param_name"	=> "padding",
		"type"			=> "textfield",
		"value"			=> "20",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __( "Appearance", 'dt-the7-core' ),
	),
);

$proportion = array(
	array(
		"heading"		=> __( "Thumbnails proportions", 'dt-the7-core' ),
		"description"	=> __( "Width:height (e.g. 16:9). Leave this field empty to preserve original image proportions.", 'dt-the7-core' ),
		"param_name"	=> "proportion",
		"type"			=> "textfield",
		"value"			=> "",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __( "Appearance", 'dt-the7-core' ),
	),
);

// albums
$show_albums_content = array(
		array(
			"value"			=> array( "Show albums titles" => "true" ),
			"param_name"	=> "show_title",
			"type"			=> "checkbox",
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
		array(
			"value"			=> array( "Show albums excerpts" => "true" ),
			"param_name"	=> "show_excerpt",
			"type"			=> "checkbox",
			"group" => __( "Appearance", 'dt-the7-core' ),
		),
);

$show_filter = array(
		array(
			"value"			=> array( "Show categories filter" => "true" ),
			"param_name"	=> "show_filter",
			"type"			=> "checkbox",
		),
);

$show_filter_ordering = array(
		array(
			"value"			=> array( "Show name / date ordering" => "true" ),
			"param_name"	=> "show_orderby",
			"type"			=> "checkbox",
		),
		array(
			"value"			=> array( "Show asc. / desc. ordering" => "true" ),
			"param_name"	=> "show_order",
			"type"			=> "checkbox",
		),
);

$show_miniatures = array(
	array(
		"value" => array( "Show image miniatures" => "true" ),
		"param_name" => "show_miniatures",
		"type" => "checkbox",
		"group" => __( "Appearance", 'dt-the7-core' ),
	),
);

$albums_to_show = array(
		array(
			"heading"		=> __( "Number of albums to show", 'dt-the7-core' ),
			"param_name"	=> "number",
			"type"			=> "textfield",
			"value"			=> "12",
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
);

$show_media_count = array(
	array(
		"value" => array( "Show number of images & videos" => "true" ),
		"param_name" => "show_media_count",
		"type" => "checkbox",
		"group" => __( "Project Meta", 'dt-the7-core' ),
	),
);

$albums_per_page = array(
		array(
			"heading"		=> __( "Albums per page", 'dt-the7-core' ),
			"param_name"	=> "posts_per_page",
			"type"			=> "textfield",
			"value"			=> "-1",
			"edit_field_class" => "vc_col-sm-6 vc_column",
		),
);

// photos
$show_photos_content = $show_albums_content;
$show_photos_content[0]["value"] = array( "Show titles" => "true" );
$show_photos_content[1]["value"] = array( "Show items descriptions" => "true" );

$photos_to_show = $albums_to_show;
$photos_to_show[0]["heading"] = __( "Number of items to show", 'dt-the7-core' );
$photos_to_show[0]["edit_field_class"] = "vc_col-xs-12 vc_column dt_row-6";

// masonry
$padding_masonry = $padding;
$padding_masonry[0]["description"] = __( "Image paddings (e.g. 5 pixel padding will give you 10 pixel gaps between images)", 'dt-the7-core' );

// scroller
$scroller_padding = $padding;
$scroller_padding[0]["edit_field_class"] = "vc_col-xs-12 vc_column dt_row-6";
$scroller_albums_to_show = $albums_to_show;
$scroller_albums_to_show[0]["edit_field_class"] = "vc_col-xs-12 vc_column dt_row-6";

$appearance = array(
	array(
		"heading" => __( "Appearance", 'dt-the7-core' ),
		"param_name" => "type",
		"type" => "dropdown",
		"value" => array(
			"Masonry" => "masonry",
			"Grid" => "grid",
		),
		"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		"group" => __("Appearance", 'dt-the7-core'),
	),
);

// jgrid
$target_height = array(
	array(
		"heading" => __( "Row target height (px)", 'dt-the7-core' ),
		"param_name" => "target_height",
		"type" => "textfield",
		"value" => "240",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __("Appearance", 'dt-the7-core'),
	),
);

$hide_last_row = array(
	array(
		"value" => array( "Hide last row if there's not enough images to fill it" => "true" ),
		"heading" => '&nbsp;',
		"param_name" => "hide_last_row",
		"type" => "checkbox",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __("Appearance", 'dt-the7-core'),
	),
);

// scroller
$scroller_arrows = array(
	array(
		"heading" => __("Arrows", 'dt-the7-core'),
		"param_name" => "arrows",
		"type" => "dropdown",
		"value" => array(
			'light' => 'light',
			'dark' => 'dark',
			'rectangular accent' => 'rectangular_accent',
			'disabled' => 'disabled',
		),
		"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		"group" => __("Slideshow", 'dt-the7-core'),
	),
	array(
		"group" => __("Slideshow", 'dt-the7-core'),
		"heading" => __("Show arrows on mobile device", 'dt-the7-core'),
		"param_name" => "arrows_on_mobile",
		"type" => "dropdown",
		"value" => array(
			"Yes" => "on",
			"No" => "off",
		),
		"dependency" => array(
			"element" => "arrows",
			"value" => array(
				'light',
				'dark',
				'rectangular_accent',
			),
		),
		"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
	),
);

$scroller_slidehow_controls = array(
	array(
		"heading" => __( "Autoslide interval (in milliseconds)", 'dt-the7-core' ),
		"param_name" => "autoslide",
		"type" => "textfield",
		"value" => "3000",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __("Slideshow", 'dt-the7-core'),
	),
	array(
		"value" => array( "Loop" => "true" ),
		"heading" => '&nbsp;',
		"param_name" => "loop",
		"type" => "checkbox",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __("Slideshow", 'dt-the7-core'),
	),
);

// hover
$descriptions = array(
	"heading"		=> __( "Show albums descriptions", 'dt-the7-core' ),
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
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$bg_under_posts = array(
	"heading"		=> __( "Background under albums", 'dt-the7-core' ),
	"param_name"	=> "bg_under_albums",
	"type"			=> "dropdown",
	"value"			=> array(
		'Enabled (image with paddings)'		=> 'with_paddings',
		'Enabled (image without paddings)'	=> 'fullwidth',
		'Disabled'							=> 'disabled'
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$hover_animation = array(
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
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$hover_bg_color = array(
	"heading"		=> __( "Image hover background color", 'dt-the7-core' ),
	"param_name"	=> "hover_bg_color",
	"type"			=> "dropdown",
	"value"			=> array(
		'Color (from Theme Options)'	=> 'accent',
		'Dark'							=> 'dark',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$bgwl_animation_effect = array(
	"heading"		=> __( "Animation effect", 'dt-the7-core' ),
	"param_name"	=> "bgwl_animation_effect",
	"type"			=> "dropdown",
	"value"			=> array(
		'Effect 1'	=> '1',
		'Effect 2'	=> '2',
		'Effect 3'	=> '3',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$hover_content_visibility = array(
	"heading"		=> __( "Content", 'dt-the7-core' ),
	"param_name"	=> "hover_content_visibility",
	"type"			=> "dropdown",
	"value"			=> array(
		'On hover'			=> 'on_hover',
		'Always visible'	=> 'always'
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$colored_bg_content_aligment = array(
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
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$content_aligment = array(
	"heading"		=> __( "Content alignment", 'dt-the7-core' ),
	"param_name"	=> "content_aligment",
	"type"			=> "dropdown",
	"value"			=> array(
		'Left'			=> 'left',
		'Centre'		=> 'center',
	),
	"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
	"group" => __( "Appearance", 'dt-the7-core' ),
);

$descriptions_masonry = array(
	$descriptions,
	array_merge( $bg_under_posts, array(
		"dependency"	=> array(
			"element"	=> "descriptions",
			"value"		=> array( 'under_image' ),
		),
	) ),
	array_merge( $hover_animation, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array( 'on_hover_centered' ),
		),
	) ),
	array_merge( $hover_bg_color, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array(
				'on_hover_centered',
				'under_image',
				'bg_with_lines',
			),
		),
	) ),
	array_merge( $bgwl_animation_effect, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array( 'bg_with_lines' ),
		),
	) ),
	array_merge( $hover_content_visibility, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array(
				'on_dark_gradient',
				'bg_with_lines',
			),
		),
	) ),
	array_merge( $colored_bg_content_aligment, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array( 'on_hover_centered' ),
		),
	) ),
	array_merge( $content_aligment, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array(
				'under_image',
				'on_dark_gradient',
				'from_bottom',
			),
		),
	) ),
);

$descriptions_jgrid = array(
	array_merge( $descriptions, array( 'value' => array_diff( $descriptions['value'], array( 'under_image' ) ) ) ),
	array_merge( $hover_animation, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array( 'on_hover_centered' ),
		),
	) ),
	array_merge( $hover_bg_color, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array(
				'on_hover_centered',
				'bg_with_lines',
			),
		),
	) ),
	array_merge( $bgwl_animation_effect, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array( 'bg_with_lines' ),
		),
	) ),
	array_merge( $hover_content_visibility, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array(
				'on_dark_gradient',
				'bg_with_lines',
			),
		),
	) ),
	array_merge( $colored_bg_content_aligment, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array( 'on_hover_centered' ),
		),
	) ),
	array_merge( $content_aligment, array(
		"dependency"	=> array(
			"element"		=> "descriptions",
			"value"			=> array(
				'on_dark_gradient',
				'from_bottom',
			),
		),
	) ),
);

$album_number_order_title = array(
	array(
		"heading" => __( "Albums Number & Order", 'dt-the7-core' ),
		"param_name" => "dt_title",
		"type" => "dt_title",
	)
);

$album_filter_title = array( array(
	"heading" => __( "Albums Filter", 'dt-the7-core' ),
	"param_name" => "dt_title",
	"type" => "dt_title",
) );

$album_design_title = array( array(
	"heading" => __( "Album Design", 'dt-the7-core' ),
	"param_name" => "dt_title",
	"type" => "dt_title",
	"group" => __("Appearance", 'dt-the7-core'),
                             ) );

$album_elements_title = array( array(
	"heading" => __( "Album Elements", 'dt-the7-core' ),
	"param_name" => "dt_title",
	"type" => "dt_title",
	"group" => __("Appearance", 'dt-the7-core'),
) );

$photo_number_order_title = array(
	array(
		"heading" => __( "Albums Number & Order", 'dt-the7-core' ),
		"param_name" => "dt_title",
		"type" => "dt_title",
	)
);

$photo_filter_title = array(
	array(
	                             "heading" => __( "Albums Filter", 'dt-the7-core' ),
	                             "param_name" => "dt_title",
	                             "type" => "dt_title",
    )
);

$photo_design_title = array(
	array(
	                             "heading" => __( "Album Design", 'dt-the7-core' ),
	                             "param_name" => "dt_title",
	                             "type" => "dt_title",
	                             "group" => __("Appearance", 'dt-the7-core'),
                             )
);

$photo_elements_title = array(
	array(
	                               "heading" => __( "Album Elements", 'dt-the7-core' ),
	                               "param_name" => "dt_title",
	                               "type" => "dt_title",
	                               "group" => __("Appearance", 'dt-the7-core'),
                               )
);

$responsiveness = array(
	array(
		"heading" => __("Responsiveness", 'dt-the7-core'),
		"param_name" => "responsiveness",
		"type" => "dropdown",
		"value" => array(
			"Post width based" => "post_width_based",
			"Browser width based" => "browser_width_based",
		),
		"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		"group" => __( "Responsiveness", 'dt-the7-core' ),
	),
	array(
		"heading" => __("Columns on Desktop", 'dt-the7-core'),
		"param_name" => "columns_on_desk",
		"type" => "textfield",
		"value" => "3",
		"edit_field_class" => "vc_col-sm-3 vc_column",
		"dependency" => array(
			"element" => "responsiveness",
			"value" => array(
				"browser_width_based",
			),
		),
		"group" => __( "Responsiveness", 'dt-the7-core' ),
	),
	array(
		"heading" => __("Columns on Horizontal Tablet", 'dt-the7-core'),
		"param_name" => "columns_on_htabs",
		"type" => "textfield",
		"value" => "3",
		"edit_field_class" => "vc_col-sm-3 vc_column",
		"dependency" => array(
			"element" => "responsiveness",
			"value" => array(
				"browser_width_based",
			),
		),
		"group" => __( "Responsiveness", 'dt-the7-core' ),
	),
	array(
		"heading" => __("Columns on Vertical Tablet", 'dt-the7-core'),
		"param_name" => "columns_on_vtabs",
		"type" => "textfield",
		"value" => "3",
		"edit_field_class" => "vc_col-sm-3 vc_column",
		"dependency" => array(
			"element" => "responsiveness",
			"value" => array(
				"browser_width_based",
			),
		),
		"group" => __( "Responsiveness", 'dt-the7-core' ),
	),
	array(
		"heading" => __("Columns on Mobile Phone", 'dt-the7-core'),
		"param_name" => "columns_on_mobile",
		"type" => "textfield",
		"value" => "3",
		"edit_field_class" => "vc_col-sm-3 vc_column",
		"dependency" => array(
			"element" => "responsiveness",
			"value" => array(
				"browser_width_based",
			),
		),
		"group" => __( "Responsiveness", 'dt-the7-core' ),
	),
	array(
		"heading" => __( "Column minimum width (px)", 'dt-the7-core' ),
		"param_name" => "column_width",
		"type" => "textfield",
		"value" => "370",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"dependency" => array(
			"element" => "responsiveness",
			"value" => array(
				"post_width_based",
			),
		),
		"group" => __( "Responsiveness", 'dt-the7-core' ),
	),
	array(
		"heading" => __( "Desired columns number", 'dt-the7-core' ),
		"param_name" => "columns",
		"type" => "textfield",
		"value" => "2",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"dependency" => array(
			"element" => "responsiveness",
			"value" => array(
				"post_width_based",
			),
		),
		"group" => __( "Responsiveness", 'dt-the7-core' ),
	),
);

$thumbnails_width = array(
	array(
		"heading" => __( "Thumbnails width", 'dt-the7-core' ),
		"description" => __( "In pixels. Leave this field empty if you want to preserve original thumbnails proportions.", 'dt-the7-core' ),
		"param_name" => "width",
		"type" => "textfield",
		"value" => "",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __( "Appearance", 'dt-the7-core' ),
	),
);

$thumbnails_height = array(
	array(
		"heading" => __( "Thumbnails height", 'dt-the7-core' ),
		"description" => __( "In pixels.", 'dt-the7-core' ),
		"param_name" => "height",
		"type" => "textfield",
		"value" => "210",
		"edit_field_class" => "vc_col-sm-6 vc_column",
		"group" => __( "Appearance", 'dt-the7-core' ),
	),
);

$thumbnails_max_width = array(
	array(
		"heading" => __( "Thumbnails max width", 'dt-the7-core' ),
		"description" => __("In percents.", 'dt-the7-core'),
		"param_name" => "max_width",
		"type" => "textfield",
		"value" => "",
		"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		"group" => __( "Appearance", 'dt-the7-core' ),
	),
);
