<?php
/**
 * Tools tab template.
 *
 * @package The7/Dev/Templates
 */

defined( 'ABSPATH' ) || exit;
?>
<h2>Tools</h2>
<?php
$tools_message = get_transient( 'the7-dev-tools-message' );
if ( $tools_message ) {
	echo '<div class="the7-dev-tools-message the7-dashboard-notice the7-notice notice inline notice-info">' . wp_kses_post( $tools_message ) . '</div>';
	delete_transient( 'the7-dev-tools-message' );
}
?>
<form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
	<?php wp_nonce_field( 'the7-dev-tools' ); ?>
	<input type="hidden" name="action" value="the7_use_dev_tool">
	<p>
		<button type="submit" class="button button-primary" name="tool" value="regenerate_shortcodes_css">Regenerate Shortcodes CSS</button>
	</p>
	<p>
		<button type="submit" class="button button-primary" name="tool" value="download_speed_test">Test Download Speed From The7 Repository</button>
	</p>
	<p>
		<button type="submit" class="button button-primary" name="tool" value="delete_all_theme_options_backups">Delete all backups</button>
		<select name="theme_options_backup">
			<option value="">--none--</option>
			<?php
			$backup_records = The7_Options_Backup::get_records();
			foreach ( $backup_records as $backup ) {
				$backup_name = str_replace( 'the7-theme-options-backup-', '', $backup );
				echo '<option value="' . esc_attr( $backup ) . '">' . esc_html( $backup_name ) . '</option>';
			}
			?>
		</select>
		<button type="submit" class="button button-primary" name="tool" value="restore_theme_options_from_backup">Restore options</button>
	</p>
</form>
