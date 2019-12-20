<?php
/**
 * The7 dashboard registration form.
 *
 * @package The7\Admin
 */

defined( 'ABSPATH' ) || exit;
?>
<h3><?php esc_html_e( 'Theme Registration', 'the7mk2' ); ?></h3>
<form method="post">
	<?php settings_fields( 'the7_theme_registration' ); ?>

	<p>
		<?php esc_html_e( 'Purchase Code:', 'the7mk2' ); ?>
		<br>
		<input id="the7_purchase_code" class="of-input" name="the7_purchase_code" type="text" value="" size="36" title="<?php esc_attr_e( 'Purchase Code', 'the7mk2' ); ?>"
		>
	</p>
	<p>
		<label>
			<input type="checkbox" id="the7-registration-terms">&nbsp;
			<?php
			echo wp_kses_post(
				sprintf(
					_x(
						/* translators: %s: license url. */
						'I give my consent to record my site address and purchase code in order to ensure <a href="%s" target="_blank">License</a> and copyright compliance. I understand that this information will be stored as long as the purchase code remains valid.',
						'admin',
						'the7mk2'
					),
					The7_Remote_API::LICENSE_URL
				)
			);
			?>
			</label>
	</p>
	<p>
		<button type="submit" id="the7-register-theme-button" class="button button-primary" name="register_theme" value="register" title="<?php esc_attr_e( 'Register Theme', 'the7mk2' ); ?>"><?php esc_html_e( 'Register Theme', 'the7mk2' ); ?></button>
	</p>
</form>
