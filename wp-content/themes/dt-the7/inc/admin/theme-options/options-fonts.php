<?php
/**
 * Typography.
 *
 * @package The7/Options
 */

defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name' => _x( 'Content Fonts', 'theme-options', 'the7mk2' ),
	'type' => 'heading',
	'id'   => 'content-fonts',
);

$options[] = array(
	'name' => _x( 'Text color', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['content-headers_color'] = array(
	'name' => _x( 'Headings color', 'theme-options', 'the7mk2' ),
	'id'   => 'content-headers_color',
	'std'  => '#252525',
	'type' => 'color',
);

$options['content-primary_text_color'] = array(
	'name' => _x( 'Primary text color', 'theme-options', 'the7mk2' ),
	'id'   => 'content-primary_text_color',
	'std'  => '#686868',
	'type' => 'color',
);

$options['content-secondary_text_color'] = array(
	'name' => _x( 'Secondary text color', 'theme-options', 'the7mk2' ),
	'id'   => 'content-secondary_text_color',
	'std'  => '#999999',
	'type' => 'color',
);

$options['content-links_color'] = array(
	'name' => _x( 'Links color', 'theme-options', 'the7mk2' ),
	'id'   => 'content-links_color',
	'std'  => '#999999',
	'type' => 'color',
);

$options[] = array(
	'name' => _x( 'Basic font', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options['fonts-font_family'] = array(
	'name'  => _x( 'Choose basic font-family', 'theme-options', 'the7mk2' ),
	'id'    => 'fonts-font_family',
	'std'   => 'Open Sans',
	'type'  => 'web_fonts',
	'fonts' => 'all',
);

$font_sizes = array(
	'big_size'    => array(
		'font_std'  => 15,
		'font_desc' => _x( 'Large font size', 'theme-options', 'the7mk2' ),
		'lh_std'    => 20,
		'lh_desc'   => _x( 'Large line-height', 'theme-options', 'the7mk2' ),
		'msg'       => _x( 'Default font for content area & most shortcodes.', 'theme-options', 'the7mk2' ),
	),
	'normal_size' => array(
		'font_std'  => 13,
		'font_desc' => _x( 'Medium font size', 'theme-options', 'the7mk2' ),
		'lh_std'    => 20,
		'lh_desc'   => _x( 'Medium line-height', 'theme-options', 'the7mk2' ),
		'msg'       => _x(
			'Default font for widgets in side bar & bottom bar. Can be chosen for some shortcodes.',
			'theme-options',
			'the7mk2'
		),
	),
	'small_size'  => array(
		'font_std'  => 11,
		'font_desc' => _x( 'Small font size', 'theme-options', 'the7mk2' ),
		'lh_std'    => 20,
		'lh_desc'   => _x( 'Small line-height', 'theme-options', 'the7mk2' ),
		'msg'       => _x(
			'Default font for bottom bar, breadcrumbs, some meta information etc. Can be chosen for some shortcodes.',
			'theme-options',
			'the7mk2'
		),
	),
);

foreach ( $font_sizes as $id => $data ) {

	$options[] = array( 'type' => 'divider' );

	$options[] = array(
		'type' => 'info',
		'desc' => $data['msg'],
	);

	$options[ 'fonts-' . $id ] = array(
		'name'     => $data['font_desc'],
		'id'       => 'fonts-' . $id,
		'std'      => $data['font_std'],
		'type'     => 'slider',
		'options'  => array(
			'min' => 1,
			'max' => 120,
		),
		'sanitize' => 'font_size',
	);

	$options[ 'fonts-' . $id . '_line_height' ] = array(
		'name'     => $data['lh_desc'],
		'id'       => 'fonts-' . $id . '_line_height',
		'std'      => $data['lh_std'],
		'type'     => 'slider',
		'options'  => array(
			'min' => 1,
			'max' => 120,
		),
		'sanitize' => 'font_size',
	);

}

$options[] = array(
	'name' => _x( 'Headings fonts', 'theme-options', 'the7mk2' ),
	'type' => 'block',
);

$options[] = array(
	'name' => _x( 'Apply to all', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['fonts-headers-font-family'] = array(
	'name'  => _x( 'Font-family', 'theme-options', 'the7mk2' ),
	'id'    => 'fonts-headers-font-family',
	'std'   => '',
	'type'  => 'web_fonts',
	'fonts' => 'all',
	'desc'  => _x( 'Choose font-family for all headings at once.', 'theme-options', 'the7mk2' ),
	'save'  => false,
);

$options['fonts-headers-text-transform'] = array(
	'name'    => _x( 'Text transformation', 'theme-options', 'the7mk2' ),
	'id'      => 'fonts-headers-text-transform',
	'type'    => 'select',
	'std'     => '',
	'options' => array(
		''           => '-- No Change --',
		'none'       => 'None',
		'uppercase'  => 'Uppercase',
		'lowercase'  => 'Lowercase',
		'capitalize' => 'Capitalize',
	),
	'class'   => 'mini',
	'desc'    => _x( 'Choose text transformation for all headings at once.', 'theme-options', 'the7mk2' ),
	'save'    => false,
	'divider' => 'bottom',
);

$options[] = array(
	'name' => _x( 'H1', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['fonts-h1-typography'] = array(
	'id'   => 'fonts-h1-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 44,
		'line_height'    => 50,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'H2', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['fonts-h2-typography'] = array(
	'id'   => 'fonts-h2-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 26,
		'line_height'    => 30,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'H3', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['fonts-h3-typography'] = array(
	'id'   => 'fonts-h3-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 22,
		'line_height'    => 30,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'H4', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options[] = array(
	'desc' => _x(
		'Default font for post titles in masonry, grid, list layouts and scrollers.',
		'theme-options',
		'the7mk2'
	),
	'type' => 'info',
);

$options['fonts-h4-typography'] = array(
	'id'   => 'fonts-h4-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 18,
		'line_height'    => 20,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'H5', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options[] = array(
	'desc' => _x( 'Default font for widget titles in sidebar & footer.', 'theme-options', 'the7mk2' ),
	'type' => 'info',
);

$options['fonts-h5-typography'] = array(
	'id'   => 'fonts-h5-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 15,
		'line_height'    => 20,
		'text_transform' => 'none',
	),
);

$options[] = array( 'type' => 'divider' );

$options[] = array(
	'name' => _x( 'H6', 'theme-options', 'the7mk2' ),
	'type' => 'title',
);

$options['fonts-h6-typography'] = array(
	'id'   => 'fonts-h6-typography',
	'type' => 'typography',
	'std'  => array(
		'font_family'    => 'Open Sans',
		'font_size'      => 12,
		'line_height'    => 20,
		'text_transform' => 'none',
	),
);
