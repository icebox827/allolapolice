<?php
/**
 * Admin View: Notice - Registration
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="notice">
	<p><strong><?php echo esc_html_x( 'Thank you for choosing The7!', 'admin', 'the7mk2' ) ?></strong></p>
	<p>
		<?php
		echo wp_kses_post(
			sprintf(
				_x(
					/* translators: %s: the7 dashboard url */
					'<strong>Please <a href="%s">register</a></strong> this copy of theme to get access to premium plugins, pre-built websites, 1-click updates and more.',
					'admin',
					'the7mk2'
				),
				admin_url( 'admin.php?page=the7-dashboard' )
			)
		);
		?>
	</p>
	<p>
		<?php
		echo wp_kses_post(
			sprintf(
				_x(
					/* translators: 1: license url, 2: theme purchase url */
					'Also be advised that according to <a href="%1$s" target="_blank">ThemeForest Standard Licenses</a> each site/project built with The7 requires a separate license, which can be purchased <a href="%2$s" target="_blank">here</a>.',
					'admin',
					'the7mk2'
				),
				The7_Remote_API::LICENSE_URL,
				The7_Remote_API::THEME_PURCHASE_URL
			)
		);
		?>
	</p>
</div>