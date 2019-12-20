<?php
/**
 * Archives settings.
 *
 * @since   3.0.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$supported_shortcodes = array(
	'Blog Masonry & Grid',
	'Blog List',
	'Portfolio Masonry & Grid',
	'Portfolio Justified Grid',
	'Team Masonry & Grid',
	'Testimonials Masonry & Grid',
	'Albums Masonry & Grid',
	'Albums Justified Grid',
);
$options[]            = array(
	'desc' => sprintf( _x( "Settings bellow allow you to select pages to be used as templates for your 404, Archives and Search results. This includes header, footer, sidebar and <strong>content layout</strong> (beta feature).\nNote that Archives content and Search results appearance will be rendered in accordance with <strong>first</strong> <span class='of-tooltip'><strong>corresponding shortcode</strong><i class='tooltiptext'><b>Supported shortcodes:</b><br />%s</i></span> found on the page. Otherwise, it will default to masonry layout. Categorisation is always disabled and pagination defaults to the 'standard' mode.", 'theme-options', 'the7mk2' ), implode( '<br />', $supported_shortcodes ) ),
	'type' => 'info',
);

$options[] = array(
	'name' => _x( 'Archives', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'archives',
);

$options[] = array(
	'name' => _x( 'Archive title', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['show_static_part_of_archive_title'] = array(
	'id'      => 'show_static_part_of_archive_title',
	'name'    => _x( 'The7 archive title', 'theme-options', 'the7mk2' ),
	'desc'    => _x(
		'If this option is disabled, the static part of the title, f.e. “Archives:”, will be hidden.',
		'theme-options',
		'the7mk2'
	),
	'type'    => 'radio',
	'std'     => '1',
	'options' => array(
		'1' => _x( 'Enabled', 'admin', 'the7mk2' ),
		'0' => _x( 'Disabled', 'admin', 'the7mk2' ),
	),
);

$options[] = array(
	'name' => _x( 'Author', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['template_page_id_author'] = array(
	'id'   => 'template_page_id_author',
	'name' => _x( 'Author archive template', 'theme-options', 'the7mk2' ),
	'type' => 'pages_list',
	'std'  => '0',
);

$options['template_page_id_author_full_content'] = array(
	'id'         => 'template_page_id_author_full_content',
	'name'       => _x( 'Show full content of author archive template', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'std'        => '0',
	'options'    => array(
		'1' => _x( 'Yes', 'theme-options', 'the7mk2' ),
		'0' => _x( 'No', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'template_page_id_author',
		'operator' => '!=',
		'value'    => '0',
	),
);

$options[] = array(
	'name' => _x( 'Date', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['template_page_id_date'] = array(
	'id'   => 'template_page_id_date',
	'name' => _x( 'Date archive template', 'theme-options', 'the7mk2' ),
	'type' => 'pages_list',
	'std'  => '0',
);

$options['template_page_id_date_full_content'] = array(
	'id'         => 'template_page_id_date_full_content',
	'name'       => _x( 'Show full content of date archive template', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'std'        => '0',
	'options'    => array(
		'1' => _x( 'Yes', 'theme-options', 'the7mk2' ),
		'0' => _x( 'No', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'template_page_id_date',
		'operator' => '!=',
		'value'    => '0',
	),
);

$options[] = array(
	'name' => _x( 'Blog archives', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['template_page_id_blog_category'] = array(
	'id'   => 'template_page_id_blog_category',
	'name' => _x( 'Blog category template', 'theme-options', 'the7mk2' ),
	'type' => 'pages_list',
	'std'  => '0',
);

$options['template_page_id_blog_category_full_content'] = array(
	'id'         => 'template_page_id_blog_category_full_content',
	'name'       => _x( 'Show full content of blog category template', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'std'        => '0',
	'options'    => array(
		'1' => _x( 'Yes', 'theme-options', 'the7mk2' ),
		'0' => _x( 'No', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'template_page_id_blog_category',
		'operator' => '!=',
		'value'    => '0',
	),
);

$options[] = array( 'type' => 'divider' );

$options['template_page_id_blog_tags'] = array(
	'id'   => 'template_page_id_blog_tags',
	'name' => _x( 'Blog tags template', 'theme-options', 'the7mk2' ),
	'type' => 'pages_list',
	'std'  => '0',
);

$options['template_page_id_blog_tags_full_content'] = array(
	'id'         => 'template_page_id_blog_tags_full_content',
	'name'       => _x( 'Show full content of blog tags template', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'std'        => '0',
	'options'    => array(
		'1' => _x( 'Yes', 'theme-options', 'the7mk2' ),
		'0' => _x( 'No', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'template_page_id_blog_tags',
		'operator' => '!=',
		'value'    => '0',
	),
);

$options['archive_placeholder'] = array();

$options[] = array(
	'name' => _x( 'Search', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'search',
);

$options[] = array(
	'name' => _x( 'Search', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['template_page_id_search'] = array(
	'id'   => 'template_page_id_search',
	'name' => _x( 'Search page', 'theme-options', 'the7mk2' ),
	'type' => 'pages_list',
	'std'  => '0',
);

$options['template_page_id_search_full_content'] = array(
	'id'         => 'template_page_id_search_full_content',
	'name'       => _x( 'Show full content of search page template', 'theme-options', 'the7mk2' ),
	'type'       => 'radio',
	'std'        => '0',
	'options'    => array(
		'1' => _x( 'Yes', 'theme-options', 'the7mk2' ),
		'0' => _x( 'No', 'theme-options', 'the7mk2' ),
	),
	'dependency' => array(
		'field'    => 'template_page_id_search',
		'operator' => '!=',
		'value'    => '0',
	),
);

$options[] = array(
	'name' => _x( '404 page', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => '404-page',
);

$options[] = array(
	'name' => _x( '404 page template', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['template_page_id_404'] = array(
	'id'   => 'template_page_id_404',
	'name' => _x( 'Choose a page to take settings and content from', 'theme-options', 'the7mk2' ),
	'type' => 'pages_list',
	'std'  => '0',
);
