<?php
/**
 * Install tab template.
 *
 * @package The7/Dev/Templates
 */

defined( 'ABSPATH' ) || exit;
?>
<h2>Re-Install theme</h2>
<p class="the7-subtitle">If you need to re-install latest theme version, you can do so here:</p>
<form action="update.php?action=upgrade-theme&the7-force-update=true" method="post" name="upgrade-themes">
	<?php wp_nonce_field( 'upgrade-theme_dt-the7' ); ?>
	<input type="hidden" name="theme" value="dt-the7">
	<button class="button button-primary" name="upgrade">Re-install The7</button>
</form>
