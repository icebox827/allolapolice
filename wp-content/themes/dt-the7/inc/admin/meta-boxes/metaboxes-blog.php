<?php
/**
 * Blog and Post metaboxes.
 * @since presscore 0.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/***********************************************************/
// Blog category
/***********************************************************/

$prefix = '_dt_blog_';

$DT_META_BOXES['dt_page_box-display_blog'] = array(
	'id'		=> 'dt_page_box-display_blog',
	'title' 	=> _x('Display Blog Categories', 'backend metabox', 'the7mk2'),
	'pages' 	=> array( 'page' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'fields' 	=> array(

		// Sidebar widgetized area
		array(
			'id'       			=> "{$prefix}display",
			'type'     			=> 'fancy_category',
			// may be posts, taxonomy, both
			'mode'				=> 'taxonomy',
			'post_type'			=> 'post',
			'taxonomy'			=> 'category',
			// posts, categories, images
			'post_type_info'	=> array( 'categories' ),
			'main_tab_class'	=> 'dt_all_blog',
			'desc'				=> sprintf(
				'<h2>%s</h2><p><strong>%s</strong> %s</p><p><strong>%s</strong></p><ul><li><strong>%s</strong>%s</li><li><strong>%s</strong>%s</li><li><strong>%s</strong>%s</li></ul>',

				_x('ALL your Blog posts are being displayed on this page!', 'backend', 'the7mk2'),
				_x('By default all your Blog posts will be displayed on this page. ', 'backend', 'the7mk2'),
				_x('But you can specify which Blog categories will (or will not) be shown.', 'backend', 'the7mk2'),
				_x('In tabs above you can select from the following options:', 'backend', 'the7mk2'),

				_x( 'All', 'backend', 'the7mk2' ),

				_x(' &mdash; all Blog posts (from all categories) will be shown on this page.', 'backend', 'the7mk2'),

				_x( 'Only', 'backend', 'the7mk2' ),

				_x(' &mdash; choose Blog category(s) to be shown on this page.', 'backend', 'the7mk2'),

				_x( 'All, except', 'backend', 'the7mk2' ),

				_x(' &mdash; choose which category(s) will be excluded from displaying on this page.', 'backend', 'the7mk2')
			)
		)
	),
	'only_on'	=> array( 'template' => array('template-blog-list.php', 'template-blog-masonry.php') ),
);

/***********************************************************/
// Blog options
/***********************************************************/

$prefix = '_dt_blog_options_';

$DT_META_BOXES['dt_page_box-blog_options'] = array(
	'id'		=> 'dt_page_box-blog_options',
	'title' 	=> _x('Blog Options', 'backend metabox', 'the7mk2'),
	'pages' 	=> array( 'page' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'fields' 	=> array(

		////////////////////////
		// Masonry settings //
		////////////////////////

		// Masonry layout
		Presscore_Meta_Box_Field_Template::get_as_array( 'masonry layout', array( 'id' => "{$prefix}layout", 'show_on_template' => 'template-blog-masonry.php' ) ),

		// Gep between images
		Presscore_Meta_Box_Field_Template::get_as_array( 'gap between images', array( 'id' => "{$prefix}item_padding", 'show_on_template' => 'template-blog-masonry.php' ) ),

		// Column target width
		Presscore_Meta_Box_Field_Template::get_as_array( 'column target width', array( 'id' => "{$prefix}target_width", 'show_on_template' => 'template-blog-masonry.php' ) ),

		// Columns number
		Presscore_Meta_Box_Field_Template::get_as_array( 'columns number', array( 'id' => "{$prefix}columns_number", 'show_on_template' => 'template-blog-masonry.php' ) ),

		// 100% width
		Presscore_Meta_Box_Field_Template::get_as_array( '100 percent width', array( 'id' => "{$prefix}full_width", 'show_on_template' => 'template-blog-masonry.php' ) ),

		// Make all posts the same width
		array(
			'name'				=> _x( 'Make all posts the same width:', 'backend metabox', 'the7mk2' ),
			'id'				=> "{$prefix}posts_same_width",
			'type'				=> 'checkbox',
			'std'				=> 0,
			'divider'			=> 'top',
			'show_on_template'	=> 'template-blog-masonry.php'
		),

		// Background under posts
		Presscore_Meta_Box_Field_Template::get_as_array( 'background under masonry post', array(
			'name'				=> _x( 'Background under posts:', 'backend metabox', 'the7mk2' ),
			'id'				=> "{$prefix}bg_under_masonry_posts",
			'show_on_template'	=> 'template-blog-masonry.php'
		) ),

		// Content alignment
		Presscore_Meta_Box_Field_Template::get_as_array( 'content alignment', array(
			'id'				=> "{$prefix}post_content_alignment",
			'show_on_template'	=> 'template-blog-masonry.php',
			'divider'			=> 'top_and_bottom'
		) ),

		/////////////////////
		// List settings //
		/////////////////////

		// List layout
		Presscore_Meta_Box_Field_Template::get_as_array( 'list layout', array( 'id' => "{$prefix}list_layout", 'show_on_template' => 'template-blog-list.php' ) ),

		// Background under posts
		Presscore_Meta_Box_Field_Template::get_as_array( 'background under post', array(
			'name'				=> _x( 'Background under posts:', 'backend metabox', 'the7mk2' ),
			'id'				=> "{$prefix}bg_under_list_posts",
			'show_on_template'	=> 'template-blog-list.php',
			'divider'			=> 'top_and_bottom'
		) ),

		///////////////////////
		// Common settings //
		///////////////////////

		// Enable fancy date
		array(
			'name'			=> _x( 'Enable fancy date:', 'backend metabox', 'the7mk2' ),
			'id'			=> "{$prefix}enable_fancy_date",
			'type'			=> 'checkbox',
			'std'			=> 1
		),

		// Image sizing
		Presscore_Meta_Box_Field_Template::get_as_array( 'image sizing', array(
			'id'			=> "{$prefix}image_layout",
			'hide_fields'	=> array(
				'original' => array( "{$prefix}thumb_proportions" ),
			)
		) ),

		// Image proportions
		Presscore_Meta_Box_Field_Template::get_as_array( 'image proportions', array( 'id' => "{$prefix}thumb_proportions" ) ),

		// Media content width
		Presscore_Meta_Box_Field_Template::get_as_array( 'media content width', array( 'id' => "{$prefix}thumb_width", 'show_on_template' => 'template-blog-list.php' ) ),

		// Number of posts to display on one page
		array(
			'name'		=> _x( 'Number of posts to display on one page:', 'backend metabox', 'the7mk2' ),
			'id'		=> "{$prefix}ppp",
			'type'		=> 'text',
			'std'		=> '',
			'divider'	=> 'top_and_bottom'
		),

		// Loading mode
		Presscore_Meta_Box_Field_Template::get_as_array( 'loading mode', array( 'id' => "{$prefix}load_style" ) ),

		// Loading effect
		Presscore_Meta_Box_Field_Template::get_as_array( 'loading effect', array( 'id' => "{$prefix}load_effect", 'show_on_template' => 'template-blog-masonry.php' ) ),

		/////////////////////////
		// Advanced settings //
		/////////////////////////

		// Show all pages in paginator
		Presscore_Meta_Box_Field_Template::get_as_array( 'show all pages paginator', array(
			'before'	=> presscore_meta_boxes_advanced_settings_tpl( 'dt_blog-advanced' ), // advanced settings

			'id'		=> "{$prefix}show_all_pages"
		) ),

		// Show excerpts
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array( 'id' => "{$prefix}show_exerpts", 'name' => _x( 'Show excerpts:', 'backend metabox', 'the7mk2' ), 'divider' => 'top' ) ),

		// Show read more buttons
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array( 'id' => "{$prefix}show_details", 'name' => _x( 'Show read more buttons:', 'backend metabox', 'the7mk2' ), 'divider' => 'top' ) ),

		//////////////
		// Filter //
		//////////////

		// Show categories filter
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array(
			'id' => "{$prefix}show_filter",
			'name' => _x( 'Show categories filter:', 'backend metabox', 'the7mk2' ),
			'std' => 0,
			'divider' => 'top'
		) ),

		// Show name / date ordering
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array(
			'id' => "{$prefix}show_orderby",
			'std' => 0,
			'name' => _x( 'Show name / date ordering:', 'backend metabox', 'the7mk2' )
		) ),

		// Show asc / desc ordering
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array(
			'id' => "{$prefix}show_order",
			'std' => 0,
			'name' => _x( 'Show asc. / desc. ordering:', 'backend metabox', 'the7mk2' )
		) ),

		//////////////////////
		// Post meta data //
		//////////////////////

		// Show categories
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array( 'id' => "{$prefix}show_categories_in_post_meta", 'name' => _x( 'Show post categories:', 'backend metabox', 'the7mk2' ), 'divider' => 'top' ) ),

		// Show date
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array( 'id' => "{$prefix}show_date_in_post_meta", 'name' => _x( 'Show post date:', 'backend metabox', 'the7mk2' ) ) ),

		// Show author
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array( 'id' => "{$prefix}show_author_in_post_meta", 'name' => _x( 'Show post author:', 'backend metabox', 'the7mk2' ) ) ),

		// Show comments
		Presscore_Meta_Box_Field_Template::get_as_array( 'radio yes no', array( 'id' => "{$prefix}show_comments_in_post_meta", 'name' => _x( 'Show post comments:', 'backend metabox', 'the7mk2' ) ) ),

		//////////////////////
		// Order settings //
		//////////////////////

		// Order
		Presscore_Meta_Box_Field_Template::get_as_array( 'order', array( 'id' => "{$prefix}order", 'divider' => 'top' ) ),

		// Orderby
		Presscore_Meta_Box_Field_Template::get_as_array( 'orderby', array( 'id' => "{$prefix}orderby", 'after' => '</div>' ) ),

	),
	'only_on'	=> array( 'template' => array('template-blog-list.php', 'template-blog-masonry.php') ),
);

/***********************************************************/
// Post options
/***********************************************************/

$prefix = '_dt_post_options_';

$DT_META_BOXES['dt_page_box-post_options'] = array(
	'id'		=> 'dt_page_box-post_options',
	'title' 	=> _x('Post Options', 'backend metabox', 'the7mk2'),
	'pages' 	=> array( 'post' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'fields' 	=> array(

		// Back button
		array(
			'name'  => _x( 'Back button url:', 'backend metabox', 'the7mk2' ),
			// Translators: %s link to theme options.
			'desc'  => sprintf( _x( 'Leave empty to use link from %s.', 'backend metabox', 'the7mk2' ), '<a href="' . admin_url( 'admin.php?page=of-blog-and-portfolio-menu&tab=blog-tab&mark=general-post_back_button_url#section-general-show_back_button_in_post' ) . '" target="_blank">' . _x( 'Theme Options', 'backend metabox', 'the7mk2' ) . '</a>' ),
			'id'    => "{$prefix}back_button",
			'type'  => 'text',
			'std'   => '',
			'class' => 'widefat',
		),

		// Hide featured image on post page
		array(
			'name'             => __( 'Hide featured image on post page:', 'the7mk2' ),
			'id'               => "{$prefix}hide_thumbnail",
			'type'             => 'checkbox',
			'std'              => 0,
			'divider'          => 'top',
		),

		// Related posts category
		array(
			'name'    	=> _x('Related posts category:', 'backend metabox', 'the7mk2'),
			'id'      	=> "{$prefix}related_mode",
			'type'    	=> 'radio',
			'std'		=> 'same',
			'options'	=> array(
				'same'		=> _x('from the same category', 'backend metabox', 'the7mk2'),
				'custom'	=> _x('choose category(s)', 'backend metabox', 'the7mk2'),
			),
			'hide_fields'	=> array(
				'same'	=> array( "{$prefix}related_categories" ),
			),
			'top_divider'	=> true
		),

		// Taxonomy list
		array(
			'id'      => "{$prefix}related_categories",
			'type'    => 'taxonomy_list',
			'options' => array(
				// Taxonomy name
				'taxonomy' => 'category',
				// How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree' or 'select'. Optional
				'type' => 'checkbox_list',
				// Additional arguments for get_terms() function. Optional
				'args' => array()
			),
			'multiple'    => true,
		),

		//  Post preview width (radio buttons)
		array(
			'name'    	=> _x('Post preview width:', 'backend metabox', 'the7mk2'),
			'id'      	=> "{$prefix}preview",
			'type'    	=> 'radio',
			'std'		=> 'normal',
			'options'	=> array(
				'normal'	=> _x('normal', 'backend metabox', 'the7mk2'),
				'wide'		=> _x('wide', 'backend metabox', 'the7mk2'),
			),
			'before'	=> '<p><small>' . sprintf(
				_x('Related posts can be enabled / disabled from %sTheme Options / Blog, Portfolio, Gallery%s', 'backend metabox', 'the7mk2'),
				'<a href="' . esc_url( add_query_arg( 'page', 'of-blog-and-portfolio-menu', get_admin_url() . 'admin.php' ) ) . '" target="_blank">',
				'</a>'
			) . '</small></p>',
		),
	),
);
