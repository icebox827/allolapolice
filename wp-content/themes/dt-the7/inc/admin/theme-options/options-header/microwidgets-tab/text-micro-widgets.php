<?php
defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name'                => _x( 'Text 1', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-text_area-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-text' );

$options['header-elements-text'] = array(
	'id'       => 'header-elements-text',
	'type'     => 'textarea',
	'std'      => false,
	'sanitize' => 'without_sanitize',
);

// Text 2.
$options[] = array(
	'name'                => _x( 'Text 2', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-text2_area-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-text-2' );

$options['header-elements-text-2'] = array(
	'id'       => 'header-elements-text-2',
	'type'     => 'textarea',
	'std'      => false,
	'sanitize' => 'without_sanitize',
);

// Text 3.
$options[] = array(
	'name'                => _x( 'Text 3', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-text3_area-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-text-3' );

$options['header-elements-text-3'] = array(
	'id'       => 'header-elements-text-3',
	'type'     => 'textarea',
	'std'      => false,
	'sanitize' => 'without_sanitize',
);

// Text 4.
$options[] = array(
	'name'                => _x( 'Text 4', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-text4_area-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-text-4' );

$options['header-elements-text-4'] = array(
	'id'       => 'header-elements-text-4',
	'type'     => 'textarea',
	'std'      => false,
	'sanitize' => 'without_sanitize',
);

// Text 5.
$options[] = array(
	'name'                => _x( 'Text 5', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-text5_area-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-text-5' );

$options['header-elements-text-5'] = array(
	'id'       => 'header-elements-text-5',
	'type'     => 'textarea',
	'std'      => false,
	'sanitize' => 'without_sanitize',
);