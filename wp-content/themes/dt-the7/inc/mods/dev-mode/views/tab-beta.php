<?php
/**
 * Beta tab template.
 *
 * @package The7/Dev/Templates
 */

defined( 'ABSPATH' ) || exit;
?>
<h2>Enable Beta tester mode</h2>
<p>This mode allow you to use beta version of theme and plugins.</p>
<form action="admin.php?page=the7-dev" method="post" name="beta-tester">
	<?php wp_nonce_field( 'the7-dev-beta-tester' ); ?>
	<label for="the7-dev-beta-tester">Beta-tester</label>
	&nbsp;<input type="checkbox" id="the7-dev-beta-tester" name="beta-tester" <?php checked( The7_Dev_Beta_Tester::get_status(), 1 ); ?>>
	<p>
		<button class="button button-primary" name="save">Save</button>
	</p>
</form>
