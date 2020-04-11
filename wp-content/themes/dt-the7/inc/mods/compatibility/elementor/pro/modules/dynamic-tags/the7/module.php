<?php

namespace The7\Adapters\Elementor\Pro\DynamicTags\The7;

use Elementor\Modules\DynamicTags\Module as TagsModule;

class Module extends TagsModule {

	const THE7_GROUP = 'the7';

	public function __construct() {
		parent::__construct();
		require_once __DIR__ . '/tags/the7-color.php';
	}

	public function get_name() {
		return 'the7-tags';
	}

	public function get_tag_classes_names() {
		return [
			'The7_Color',
		];
	}

	public function get_groups() {
		return [
			self::THE7_GROUP => [
				'title' => __( 'The7', 'the7mk2' ),
			],
		];
	}
}