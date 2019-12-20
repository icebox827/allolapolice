<?php
/**
 * Welcome header for not registered theme.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;
?>
<h1><?php echo esc_html_x( 'Thank you for choosing The7!', 'admin', 'the7mk2' ) ?></h1>
<p class="the7-subtitle">
	<?php
	echo wp_kses_post(
		sprintf(
			_x(
				/* translators: %s: the7 purchase url */
				'Please register this copy of theme to get access to premium plugins, pre-made websites, 1-click updates and more. If you don’t have a license yet, you can purchase it <a href="%s" target="_blank">here</a>.',
				'admin',
				'the7mk2'
			),
			The7_Remote_API::THEME_PURCHASE_URL
		)
	);
	?>
</p>