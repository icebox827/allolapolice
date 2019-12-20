<?php
/**
 * Widget area manager on `widgets.php`.
 *
 * @since   7.6.0
 * @package The7/Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Admin_WA_Manager
 */
class The7_Admin_WA_Manager {

	/**
	 * Save settings handler.
	 *
	 * @see admin-functions.php
	 */
	public static function save() {
		if ( ! check_admin_referer( 'the7_admin_wa_manager_save' ) || ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( _x( 'Current user have no permission to edit widget areas.', 'admin', 'the7mk2' ) );
		}

		if ( isset( $_POST['the7'] ) ) {
			update_option( optionsframework_get_options_id(), $_POST['the7'] );
		}

		wp_safe_redirect( admin_url( 'widgets.php' ) );
		exit;
	}

	/**
	 * Display widget area manager.
	 *
	 * @see admin-functions.php
	 */
	public static function display() {
		?>
		<a class="page-title-action the7-toggle-wa-manager hidden" href="#"><?php echo esc_html_x( 'Manage widget areas', 'admin', 'the7mk2' ); ?></a>
		<div id="optionsframework" class="optionsframework postbox hidden" style="max-width: none; margin-top: 20px;">
			<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
				<input type="hidden" name="action" value="the7_admin_wa_manager_save">
				<input type="hidden" name="page" value="of-widgetareas-menu">
				<?php wp_nonce_field( 'the7_admin_wa_manager_save' ); ?>
				<div class="of-title">
					<h2><?php echo esc_html_x( 'Manage widget areas', 'admin', 'the7mk2' ); ?></h2>
				</div>
				<?php
				$options      = optionsframework_get_page_options( 'of-widgetareas-menu' );
				$of_interface = new The7_Options( array( $options['widgetareas'] ) );
				$of_interface->render_options_html( 'the7', array( 'widgetareas' => of_get_option( 'widgetareas' ) ) );
				?>
				<div class="section">
					<div class="option">
						<button type="submit" class="button button-primary" name="save"><?php echo esc_html_x( 'Save', 'admin', 'the7mk2' ); ?></button>
						<div class="clear"></div>
					</div>
				</div>
			</form>
		</div>

		<?php
	}

	/**
	 * Enqueue assets.
	 *
	 * @see admin-functions.php
	 */
	public static function enqueue_assets() {
		optionsframework_load_styles();
		optionsframework_load_scripts();
		of_localize_scripts();
	}
}
