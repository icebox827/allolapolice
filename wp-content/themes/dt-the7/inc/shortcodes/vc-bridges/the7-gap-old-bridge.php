<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Gap (old) ", 'the7mk2'),
	"base" => "dt_gap",
	"icon" => "dt_vc_ico_gap",
	"class" => "dt_vc_sc_gap",
	"category" => __('The7 Old', 'the7mk2'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Gap height", 'the7mk2'),
			"admin_label" => true,
			"param_name" => "height",
			"value" => "10",
			"description" => __("In pixels.", 'the7mk2')
		)
	)
);
