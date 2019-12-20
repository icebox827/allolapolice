<?php
defined( 'ABSPATH' ) || exit;

// Address.
$options[] = array(
	'name'                => _x( 'Multipurpose 5', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-address-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-address', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 5', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => 'the7-mw-icon-address',
	),
) );

// Email.
$options[] = array(
	'name'                => _x( 'Multipurpose 6', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-email-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-email', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 6', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => 'the7-mw-icon-mail',
	),
) );

// Phone.
$options[] = array(
	'name'                => _x( 'Multipurpose 7', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-phone-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-phone', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 7', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => 'the7-mw-icon-phone',
	),
) );

// Skype.
$options[] = array(
	'name'                => _x( 'Multipurpose 8', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-skype-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-skype', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 8', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => 'the7-mw-icon-skype',
	),
) );

// Working hours.
$options[] = array(
	'name'                => _x( 'Multipurpose 9', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-working_hours-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-clock', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 9', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => 'the7-mw-icon-clock',
	),
) );

// Multipurpose.
$options[] = array(
	'name'                => _x( 'Multipurpose 1', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-multipurpose_1-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);
presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-multipurpose_1', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 1', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => '',
	),
) );

$options[] = array(
	'name'                => _x( 'Multipurpose 2', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-multipurpose_2-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);
presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-multipurpose_2', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 2', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => '',
	),
) );

$options[] = array(
	'name'                => _x( 'Multipurpose 3', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-multipurpose_3-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);
presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-multipurpose_3', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 3', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => '',
	),
) );

$options[] = array(
	'name'                => _x( 'Multipurpose 4', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-multipurpose_4-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);
presscore_options_apply_template( $options, 'basic-header-element', 'header-elements-contact-multipurpose_4', array(
	'caption'     => array(
		'name'    => _x( 'Multipurpose 4', 'theme-options', 'the7mk2' ),
		'divider' => false,
		'class'   => 'wide sortable-element-title-val',
	),
	'custom-icon' => array(
		'std' => '',
	),
) );