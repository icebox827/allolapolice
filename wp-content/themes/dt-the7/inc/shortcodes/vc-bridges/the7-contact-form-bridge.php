<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Contact Form", 'the7mk2'),
	"base" => "dt_contact_form",
	"icon" => "dt_vc_ico_contact_form",
	"class" => "dt_vc_sc_contact_form",
	"category" => __('by Dream-Theme', 'the7mk2'),
	"params" => array(
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Form fields", 'the7mk2'),
			"admin_label" => true,
			"param_name" => "fields",
			"value" => array(
				"name" => "name",
				"email" => "email",
				"telephone" => "telephone",
				"country" => "country",
				"city" => "city",
				"company" => "company",
				"website" => "website",
				"message" => "message"
			),
			"description" => __("Attention! At least one must be selected.", 'the7mk2')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Message textarea height", 'the7mk2'),
			"param_name" => "message_height",
			"value" => "6",
			"description" => __("Number of lines.", 'the7mk2'),
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => __("Required fields", 'the7mk2'),
			//"admin_label" => true,
			"param_name" => "required",
			"value" => array(
				"name" => "name",
				"email" => "email",
				"telephone" => "telephone",
				"country" => "country",
				"city" => "city",
				"company" => "company",
				"website" => "website",
				"message" => "message"
			),
			"description" => __("Attention! At least one must be selected.", 'the7mk2')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __('Submit button caption', 'the7mk2'),
			"param_name" => "button_title",
			"value" => "Send message",
			"description" => ""
		),
		array(
			'heading' => __( 'Show privacy message', 'the7mk2' ),
			'param_name' => 'terms',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			'heading' => __( 'Privacy message', 'the7mk2' ),
			'type' => 'textarea_raw_html',
			'edit_field_class' => 'vc_col-xs-12 vc_column the7-form-terms-field',
			'param_name' => 'terms_msg',
			'value' => base64_encode( rawurlencode( wp_kses_post( _x( 'By using this form you agree with the storage and handling of your data by this website.', 'widget', 'the7mk2' ) ) ) ),
			'dependency' => array(
				'element' => 'terms',
				'value' => 'y',
			),
		),
	)
);

