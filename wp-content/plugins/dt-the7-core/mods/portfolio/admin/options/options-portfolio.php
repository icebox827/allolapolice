<?php
/**
 * Templates settings
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$new_options = array();

$new_options[] = array(
	'name' => _x( 'Portfolio', 'theme-options', 'dt-the7-core' ),
	'type' => 'heading',
	'id'   => 'portfolio',
);

$new_options[] = array(
	'name' => _x( 'Single project featured image', 'theme-options', 'dt-the7-core' ),
	'type' => 'block',
);

$new_options['general-portfolio_thumbnail_size'] = array(
	'name'    => _x( 'Featured image sizing', 'theme-options', 'dt-the7-core' ),
	'id'      => 'general-portfolio_thumbnail_size',
	'type'    => 'radio',
	'std'     => 'original',
	'options' => array(
		'original' => _x( 'Preserve images proportions', 'theme-options', 'dt-the7-core' ),
		'resize'   => _x( 'Resize images', 'theme-options', 'dt-the7-core' ),
	),
	'desc'    => _x( "Doesn't affect legacy project media settings.", 'theme-options', 'dt-the7-core' ),
);

$new_options['general-portfolio_thumbnail_proportions'] = array(
	'name'       => _x( 'Featured image proportions', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-portfolio_thumbnail_proportions',
	'type'       => 'square_size',
	'std'        => array(
		'width'  => 3,
		'height' => 2,
	),
	'dependency' => array(
		'field'    => 'general-portfolio_thumbnail_size',
		'operator' => '==',
		'value'    => 'resize',
	),
);

$new_options[] = array(
	'name' => _x( 'Previous &amp; next buttons', 'theme-options', 'dt-the7-core' ),
	'type' => 'block',
);

$new_options['general-next_prev_in_portfolio'] = array(
	'name'    => _x( 'Show in portfolio posts', 'theme-options', 'dt-the7-core' ),
	'id'      => 'general-next_prev_in_portfolio',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 1,
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/general-next-prev-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$new_options[] = array( 'name' => _x( 'Back button', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$new_options['general-show_back_button_in_project'] = array(
	'name'    => _x( 'Back button', 'theme-options', 'dt-the7-core' ),
	'type'    => 'images',
	'id'      => 'general-show_back_button_in_project',
	'std'     => '0',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/general-show-back-button-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$new_options['general-project_back_button_url'] = array(
	'name'       => _x( 'Back button url', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-project_back_button_url',
	'type'       => 'text',
	'std'        => '',
	'class'      => 'wide',
	'dependency' => array(
		'field'    => 'general-show_back_button_in_project',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options[] = array( 'name' => _x( 'Meta information', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$new_options['general-portfolio_meta_on'] = array(
	'name'    => _x( 'Meta information', 'theme-options', 'dt-the7-core' ),
	'type'    => 'images',
	'id'      => 'general-portfolio_meta_on',
	'std'     => '1',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/general-album_meta_on-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$new_options['general-portfolio_meta_date'] = array(
	'name'       => _x( 'Date', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-portfolio_meta_date',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-portfolio_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-portfolio_meta_author'] = array(
	'name'       => _x( 'Author', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-portfolio_meta_author',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-portfolio_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-portfolio_meta_categories'] = array(
	'name'       => _x( 'Categories', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-portfolio_meta_categories',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-portfolio_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-portfolio_meta_comments'] = array(
	'name'       => _x( 'Number of comments', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-portfolio_meta_comments',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-portfolio_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options[] = array( 'name' => _x( 'Related projects', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$new_options['general-show_rel_projects'] = array(
	'name'    => _x( 'Related projects', 'theme-options', 'dt-the7-core' ),
	'id'      => 'general-show_rel_projects',
	'std'     => '0',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/general-show_rel_projects-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'dt-the7-core' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$new_options['general-rel_projects_head_title'] = array(
	'name'       => _x( 'Title', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_head_title',
	'std'        => __( 'Related Projects', 'dt-the7-core' ),
	'type'       => 'text',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_title'] = array(
	'name'       => _x( 'Show titles', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_title',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_excerpt'] = array(
	'name'       => _x( 'Show excerpts', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_excerpt',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_info_date'] = array(
	'name'       => _x( 'Show date', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_info_date',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_info_author'] = array(
	'name'       => _x( 'Show author', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_info_author',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_info_comments'] = array(
	'name'       => _x( 'Show number of comments', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_info_comments',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_info_categories'] = array(
	'name'       => _x( 'Show categories', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_info_categories',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_link'] = array(
	'name'       => _x( 'Link icon', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_link',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_zoom'] = array(
	'name'       => _x( 'Zoom icon', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_zoom',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_details'] = array(
	'name'       => _x( 'Details icon', 'theme-options', 'dt-the7-core' ),
	'id'         => 'general-rel_projects_details',
	'std'        => '1',
	'type'       => 'checkbox',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['general-rel_projects_max'] = array(
	'name'       => _x( 'Maximum number of related projects', 'theme-options', 'dt-the7-core' ),
	'type'       => 'text',
	'id'         => 'general-rel_projects_max',
	'std'        => 12,
	'sanitize'   => 'ppp',
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['portfolio-rel_projects_proportions'] = array(
	'name'       => _x( 'Image proportions', 'theme-options', 'dt-the7-core' ),
	'id'         => 'portfolio-rel_projects_proportions',
	'type'       => 'square_size',
	'std'        => array(
		'width'  => 1,
		'height' => 1,
	),
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options['portfolio-rel_projects_columns'] = array(
	'name'       => _x( 'Number of columns', 'theme-options', 'dt-the7-core' ),
	'id'         => 'portfolio-rel_projects_columns',
	'type'       => 'responsive_columns',
	'class'      => 'of-6-col',
	'columns'    => array(
		'wide_desktop' => _x( 'Wide desktop', 'theme-options', 'dt-the7-core' ),
		'desktop'      => _x( 'Desktop', 'theme-options', 'dt-the7-core' ),
		'laptop'       => _x( 'Laptop', 'theme-options', 'dt-the7-core' ),
		'h_tablet'     => _x( 'Horizontal Tablet', 'theme-options', 'dt-the7-core' ),
		'v_tablet'     => _x( 'Vertical Tablet', 'theme-options', 'dt-the7-core' ),
		'phone'        => _x( 'Mobile Phone', 'theme-options', 'dt-the7-core' ),
	),
	'std'        => array(
		'wide_desktop' => 4,
		'desktop'      => 3,
		'laptop'       => 3,
		'h_tablet'     => 3,
		'v_tablet'     => 2,
		'phone'        => 1,
	),
	'dependency' => array(
		'field'    => 'general-show_rel_projects',
		'operator' => '==',
		'value'    => '1',
	),
);

$new_options[] = array( 'name' => _x( 'Breadcrumbs', 'theme-options', 'dt-the7-core' ), 'type' => 'block' );

$breadcrumbs_placeholder = '';
$post_type_object        = get_post_type_object( 'dt_portfolio' );
if ( isset( $post_type_object->labels->singular_name ) ) {
	$breadcrumbs_placeholder = $post_type_object->labels->singular_name;
}
$new_options['portfolio-breadcrumbs-text'] = array(
	'name'        => _x( 'Breadcrumbs text', 'theme-options', 'dt-the7-core' ),
	'desc'        => _x( 'Leave empty to use post type singular name.', 'theme-options', 'dt-the7-core' ),
	'id'          => 'portfolio-breadcrumbs-text',
	'type'        => 'text',
	'std'         => '',
	'placeholder' => $breadcrumbs_placeholder,
	'class'       => 'wide',
);

if ( isset( $options ) ) {
	$options = dt_array_push_after( $options, $new_options, 'blog_and_portfolio_placeholder' );
}

unset( $new_options );
