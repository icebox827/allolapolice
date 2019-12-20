<?php
/**
 * Dummy info view.
 *
 * @package dt-dummy
 * @since   2.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$need_to_install_plugins = ! $this->plugins_checker()->is_plugins_active( $dummy_info['required_plugins'] );
?>

<?php if ( $dummy_info['id'] === 'main' ): ?>

	<div class="dt-dummy-controls-block dt-dummy-info-content">
		<?php
		echo wp_kses_post(
			__(
				'<p><strong>Important!</strong> This demo is huge. Many servers will struggle importing it.<br><strong>Please make a full site backup</strong> before proceeding with the import. In case of emergency, you may have to restore your database (or the whole website) from it.</p>',
				'the7mk2'
			)
		);
		?>
	</div>

<?php endif; ?>

<?php if ( empty( $dummy_info['include_attachments'] ) ) : ?>

	<div class="dt-dummy-controls-block dt-dummy-info-content">
		<p><strong><?php esc_html_e( 'Please note that all copyrighted images were replaced with a placeholder pictures.', 'the7mk2' ); ?></strong></p>
	</div>

<?php endif; ?>

<?php if ( $need_to_install_plugins ): ?>

    <?php include dirname( __FILE__ ) . '/required-plugins.php'; ?>

<?php endif; ?>

	<div class="dt-dummy-controls-block">

    <?php if ( $need_to_install_plugins ): ?>

        <div class="dt-dummy-field">
            <label><input type="checkbox" name="install_plugins" value="1" checked="checked" /><?php esc_html_e( 'Install required plugins', 'the7mk2' ); ?></label>
        </div>

    <?php endif; ?>

        <div class="dt-dummy-import-settings">
            <div class="dt-dummy-field">
                <label><input type="checkbox" name="import_post_types" checked="checked" value="1" /><?php esc_html_e( 'Import the entire content', 'the7mk2' ); ?></label><span class="dt-dummy-checkbox-desc"><?php esc_html_e( '(Note that this will automatically switch your active Menu and Homepage.)', 'the7mk2' ); ?></span>
            </div>
            <div class="dt-dummy-field">
                <label><input type="checkbox" name="import_theme_options" value="1" /><?php _e( 'Import Theme Options', 'the7mk2' ); ?></label><span class="dt-dummy-checkbox-desc"><?php printf( strip_tags( __( '(Attention! That this will overwrite your current Theme Options and widget areas. You may want to %1$sexport%2$s them before proceeding.)', 'the7mk2' ) ), '<a href="' . admin_url( 'admin.php?page=of-importexport-menu' ) . '" target="_blank">', '</a>' ); ?></span>
            </div>
            <div class="dt-dummy-field">
                <label><input type="checkbox" name="import_attachments" checked="checked" value="1" /><?php _e( 'Download and import file attachments', 'the7mk2' ); ?></label>
            </div>
            <div class="dt-dummy-field">
                <label><input type="checkbox" name="import_rev_sliders" checked="checked" value="1" /><?php _e( 'Import slider(s)', 'the7mk2' ); ?></label>
            </div>
            <div class="dt-dummy-field">
                <?php
                _e( 'Assign posts to an existing user:', 'the7mk2' );
                wp_dropdown_users( array(
	                'class' => 'dt-dummy-content-user',
	                'selected' => get_current_user_id(),
                ) );
                ?>
            </div>
	    </div>
    </div>
	<div class="dt-dummy-controls-block dt-dummy-control-buttons">
		<div class="dt-dummy-button-wrap">
			<button class="button button-primary dt-dummy-button-import"><?php _e( 'Import content', 'the7mk2' ); ?></button><span class="spinner"></span>
		</div>
	</div>
    <div class="dt-dummy-controls-block">
        <hr style="margin-bottom: 1.1em;">
        <p><strong>Want to import a particular page(s)?</strong></p>
    </div>
    <div class="dt-dummy-controls-block dt-dummy-control-buttons dt-dummy-controls-block-import-one-page" >
        <div class="dt-dummy-button-wrap">
            <button class="button button-primary dt-dummy-button-import-one-page">Select page(s) to import</button><span class="spinner"></span>
        </div>
    </div>
