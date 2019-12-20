<?php
/**
 * Templates settings
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options[] = array( 'name' => _x( 'General', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'general' );

$options[] = array( 'name' => _x( 'Categorization & sorting', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-filter_style'] = array(
	'id'      => 'general-filter_style',
	'name'    => _x( 'Style', 'theme-options', 'the7mk2' ),
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'ios',
	'options' => array(
		'ios'      => array(
			'title' => _x( 'No decoration', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-filter-no-decor.gif',
		),
		'minimal'  => array(
			'title' => _x( 'Background', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-filter-background.gif',
		),
		'material' => array(
			'title' => _x( 'Underline', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-filter-underline.gif',
		),
	),
);

$options['general-filter_style-minimal-border_radius'] = array(
	'name'       => _x( 'Border radius', 'theme-options', 'the7mk2' ),
	'id'         => 'general-filter_style-minimal-border_radius',
	'std'        => '100px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'general-filter_style',
		'operator' => '==',
		'value'    => 'minimal',
	),
);

$options['general-filter_style-material-line_size'] = array(
	'name'       => _x( 'Line size', 'theme-options', 'the7mk2' ),
	'id'         => 'general-filter_style-material-line_size',
	'std'        => '2px',
	'type'       => 'number',
	'units'      => 'px',
	'dependency' => array(
		'field'    => 'general-filter_style',
		'operator' => '==',
		'value'    => 'material',
	),
);

$options[] = array( 'type' => 'divider' );

$options['filter-typography'] = array(
	'id'   => 'filter-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 16,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options['general-filter-padding'] = array(
	'id'   => 'general-filter-padding',
	'name' => _x( 'Padding', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '5px 5px 5px 5px',
);

$options[] = array( 'type' => 'divider' );

$options['general-filter-margin'] = array(
	'id'   => 'general-filter-margin',
	'name' => _x( 'Margin', 'theme-options', 'the7mk2' ),
	'type' => 'spacing',
	'std'  => '0px 5px 0px 5px',
);

$options[] = array(
	'name' => _x( 'Gap below categorization & before pagination', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['general-navigation_margin'] = array(
	'id'    => 'general-navigation_margin',
	'name'  => _x( 'Gap', 'theme-options', 'the7mk2' ),
	'std'   => '50px',
	'type'  => 'number',
	'units' => 'px',
);

$options[] = array( 'name' => _x( 'Blog', 'theme-options', 'the7mk2' ), 'type' => 'heading', 'id' => 'blog' );

$options[] = array( 'name' => _x( 'Fancy date', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['blog-fancy_date-style'] = array(
	'name'    => _x( 'Style', 'theme-options', 'the7mk2' ),
	'id'      => 'blog-fancy_date-style',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 'circle',
	'options' => array(
		'circle'     => array(
			'title' => _x( 'Circle', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/date-round.gif',
		),
		'vertical'   => array(
			'title' => _x( 'Vertical', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/date-vert.gif',
		),
		'horizontal' => array(
			'title' => _x( 'Horizontal', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/date-hor.gif',
		),
	),
);

$options[] = array( 'name' => _x( 'Fancy elements in posts', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['post-show_fancy_date'] = array(
	'name' => _x( 'Show fancy date', 'theme-options', 'the7mk2' ),
	'id'   => 'post-show_fancy_date',
	'type' => 'checkbox',
	'std'  => '1',
);

$options['post-show_fancy_categories'] = array(
	'name' => _x( 'Show fancy categories', 'theme-options', 'the7mk2' ),
	'id'   => 'post-show_fancy_categories',
	'type' => 'checkbox',
	'std'  => '1',
);

$options[] = array( 'name' => _x( 'Single post featured image', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['blog-thumbnail_size'] = array(
	'name'    => _x( 'Featured image sizing', 'theme-options', 'the7mk2' ),
	'id'      => 'blog-thumbnail_size',
	'type'    => 'radio',
	'std'     => 'original',
	'options' => array(
		'original' => _x( 'Preserve images proportions', 'theme-options', 'the7mk2' ),
		'resize'   => _x( 'Resize images', 'theme-options', 'the7mk2' ),
	),
);

$options['blog-thumbnail_proportions'] = array(
	'name'       => _x( 'Featured image proportions', 'theme-options', 'the7mk2' ),
	'id'         => 'blog-thumbnail_proportions',
	'type'       => 'square_size',
	'std'        => array(
		'width'  => 3,
		'height' => 2,
	),
	'dependency' => array(
		'field'    => 'blog-thumbnail_size',
		'operator' => '==',
		'value'    => 'resize',
	),
);

$options[] = array( 'name' => _x( 'Author info in posts', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-show_author_in_blog'] = array(
	'name'    => _x( 'Show author info in blog posts', 'theme-options', 'the7mk2' ),
	'id'      => 'general-show_author_in_blog',
	'std'     => 1,
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-show_author_in_blog-yes.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options[] = array(
	'name' => _x( 'Previous & next buttons', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['general-next_prev_in_blog'] = array(
	'name'    => _x( 'Show in blog posts', 'theme-options', 'the7mk2' ),
	'id'      => 'general-next_prev_in_blog',
	'type'    => 'images',
	'class'   => 'small',
	'std'     => 1,
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-next-prev-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options[] = array( 'name' => _x( 'Back button', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-show_back_button_in_post'] = array(
	'name'    => _x( 'Back button', 'theme-options', 'the7mk2' ),
	'id'      => 'general-show_back_button_in_post',
	'std'     => '0',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-show-back-button-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['general-post_back_button_url'] = array(
	'name'       => _x( 'Back button url', 'theme-options', 'the7mk2' ),
	'id'         => 'general-post_back_button_url',
	'type'       => 'text',
	'class'      => 'wide',
	'dependency' => array(
		'field'    => 'general-show_back_button_in_post',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array( 'name' => _x( 'Meta information', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-blog_meta_on'] = array(
	'name'    => _x( 'Meta information', 'theme-options', 'the7mk2' ),
	'id'      => 'general-blog_meta_on',
	'std'     => '1',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-album_meta_on-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['general-blog_meta_date'] = array(
	'name'       => _x( 'Date', 'theme-options', 'the7mk2' ),
	'id'         => 'general-blog_meta_date',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-blog_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-blog_meta_author'] = array(
	'name'       => _x( 'Author', 'theme-options', 'the7mk2' ),
	'id'         => 'general-blog_meta_author',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-blog_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-blog_meta_categories'] = array(
	'name'       => _x( 'Categories', 'theme-options', 'the7mk2' ),
	'id'         => 'general-blog_meta_categories',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-blog_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-blog_meta_comments'] = array(
	'name'       => _x( 'Comments', 'theme-options', 'the7mk2' ),
	'id'         => 'general-blog_meta_comments',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-blog_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-blog_meta_tags'] = array(
	'name'       => _x( 'Tags', 'theme-options', 'the7mk2' ),
	'id'         => 'general-blog_meta_tags',
	'type'       => 'checkbox',
	'std'        => 1,
	'dependency' => array(
		'field'    => 'general-blog_meta_on',
		'operator' => '==',
		'value'    => '1',
	),
);

$options[] = array( 'name' => _x( 'Related posts', 'theme-options', 'the7mk2' ), 'type' => 'block' );

$options['general-show_rel_posts'] = array(
	'name'    => _x( 'Related posts', 'theme-options', 'the7mk2' ),
	'id'      => 'general-show_rel_posts',
	'std'     => '0',
	'type'    => 'images',
	'class'   => 'small',
	'options' => array(
		'1' => array(
			'title' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/general-show_rel_posts-enabled.gif',
		),
		'0' => array(
			'title' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
			'src'   => '/inc/admin/assets/images/microwidgets-disabled.gif',
		),
	),
);

$options['general-rel_posts_head_title'] = array(
	'name'       => _x( 'Title', 'theme-options', 'the7mk2' ),
	'id'         => 'general-rel_posts_head_title',
	'std'        => __( 'Related Posts', 'the7mk2' ),
	'type'       => 'text',
	'dependency' => array(
		'field'    => 'general-show_rel_posts',
		'operator' => '==',
		'value'    => '1',
	),
);

$options['general-rel_posts_max'] = array(
	'name'       => _x( 'Maximum number of related posts', 'theme-options', 'the7mk2' ),
	'id'         => 'general-rel_posts_max',
	'std'        => 6,
	'type'       => 'text',
	'sanitize'   => 'ppp',
	'dependency' => array(
		'field'    => 'general-show_rel_posts',
		'operator' => '==',
		'value'    => '1',
	),
);

// options placeholder
$options['blog_and_portfolio_placeholder'] = array();

// options placeholder
$options['blog_and_portfolio_advanced_tab_placeholder'] = array();