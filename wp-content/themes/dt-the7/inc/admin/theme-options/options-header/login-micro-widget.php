<?php
defined( 'ABSPATH' ) || exit;

$options[] = array(
	'name'                => _x( 'Login', 'theme-options', 'the7mk2' ),
	'id'                  => 'microwidgets-login-block',
	'type'                => 'block',
	'class'               => 'block-disabled',
	'exclude_from_search' => true,
);

presscore_options_apply_template( $options, 'header-element-mobile-layout', 'header-elements-login' );

$options['header-elements-login-caption'] = array(
	'id'   => 'header-elements-login-caption',
	'name' => _x( 'Login caption', 'theme-options', 'the7mk2' ),
	'type' => 'text',
	'std'  => _x( 'Login', 'theme-options', 'the7mk2' ),
);

$options['header-elements-logout-caption'] = array(
	'id'   => 'header-elements-logout-caption',
	'name' => _x( 'Logout caption', 'theme-options', 'the7mk2' ),
	'type' => 'text',
	'std'  => _x( 'Logout', 'theme-options', 'the7mk2' ),
);

$options['header-elements-login-icon'] = array(
	'id'      => 'header-elements-login-icon',
	'name'    => _x( 'Graphic icon', 'theme-options', 'the7mk2' ),
	'type'    => 'select',
	'class'   => 'middle',
	'std'     => 'custom',
	'options' => array(
		'disabled' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		'custom'   => _x( 'Custom', 'theme-options', 'the7mk2' ),
	),
);

$options['header-elements-login-custom-icon'] = array(
	'name'          => _x( 'Select icon', 'theme-options', 'the7mk2' ),
	'id'            => 'header-elements-login-custom-icon',
	'type'          => 'icons_picker',
	'default_icons' => array(
		'icomoon-the7-font-the7-login-00',
		'icomoon-the7-font-the7-login-01',
		'icomoon-the7-font-the7-login-02',
		'icomoon-the7-font-the7-login-021',
		'icomoon-the7-font-the7-login-03',
		'icomoon-the7-font-the7-login-031',
		'icomoon-the7-font-the7-login-04',
		'icomoon-the7-font-the7-login-05',
	),
	'std'           => 'the7-mw-icon-login',
	'dependency'    => array(
		'field'    => 'header-elements-login-icon',
		'operator' => '==',
		'value'    => 'custom',
	),
);

$options['header-elements-login-use_logout_url'] = array(
	'id'   => 'header-elements-login-use_logout_url',
	'name' => _x( 'Use custom logout link', 'theme-options', 'the7mk2' ),
	'type' => 'checkbox',
	'std'  => '',
);

$options['header-elements-login-url'] = array(
	'id'   => 'header-elements-login-url',
	'name' => _x( 'Link', 'theme-options', 'the7mk2' ),
	'type' => 'text',
	'std'  => '',
);

$options['header-elements-login-logout_url'] = array(
	'id'         => 'header-elements-login-logout_url',
	'name'       => _x( 'Logout link', 'theme-options', 'the7mk2' ),
	'type'       => 'text',
	'std'        => '',
	'dependency' => array(
		'field'    => 'header-elements-login-use_logout_url',
		'operator' => '==',
		'value'    => '1',
	),
);
