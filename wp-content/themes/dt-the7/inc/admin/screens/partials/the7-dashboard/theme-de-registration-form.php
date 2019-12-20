<?php
/**
 * The7 dashboard de-registration form.
 *
 * @package The7\Admin
 */

defined( 'ABSPATH' ) || exit;
?>
<h3><?php esc_html_e( 'Theme is Registered', 'the7mk2' ); ?></h3>
<form method="post">
	<?php settings_fields( 'the7_theme_registration' ); ?>

	<p>
		<?php esc_html_e( 'Your purchase code is:', 'the7mk2' ); ?>
		<br>
		<code class="the7-code"><?php echo esc_html( presscore_get_censored_purchase_code() ); ?></code>
	</p>
	<p>
		<button type="submit" class="button button-primary" name="deregister_theme" value="de-register" title="<?php esc_attr_e( 'De-register Theme', 'the7mk2' ); ?>"><?php esc_html_e( 'De-register Theme', 'the7mk2' ); ?></button>
	</p>
</form>
