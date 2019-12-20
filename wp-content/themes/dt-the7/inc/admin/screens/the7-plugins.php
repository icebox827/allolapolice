<?php
defined( 'ABSPATH' ) || exit;

/**
 * @var The7_TGMPA $the7_tgmpa
 */
global $the7_tgmpa;

// If there is another $the7_tgmpa registered.
if ( ! is_a( $the7_tgmpa, 'The7_TGMPA' ) ) {
    $the7_tgmpa_file = __( 'cannot find class file', 'the7mk2' );
    if ( $the7_tgmpa && class_exists( 'ReflectionClass', false ) ) {
	    $the7_tgmpaReflection = new ReflectionClass( get_class( $the7_tgmpa ) );
	    $the7_tgmpa_file = str_replace( ABSPATH, '', $the7_tgmpaReflection->getFileName() );
    }
?>
<div id="the7-dashboard" class="wrap">
    <h1><?php esc_html_e( 'Recommended Plugins', 'the7mk2' ); ?></h1>
    <div class="the7-postbox">
        <p><?php
	        /* translators: 1: file. */
            echo wp_kses_post( sprintf( __( 'There is a conflict with external TGM_Plugin_Activation class %s. Please turn off plugin that uses TGM_Plugin_Activation or contact our support.', 'the7mk2' ), "<code>{$the7_tgmpa_file}</code>" ) );
            ?></p>
    </div>
</div>
   <?php

    return;
}

if ( isset( $_POST['just_install'] ) ) {
    $the7_tgmpa->is_automatic = false;
}

// Store new instance of plugin table in object.
$plugin_table = new The7_Plugins_List_Table();

// Return early if processing a plugin installation action.
if ( ( ( 'tgmpa-bulk-install' === $plugin_table->current_action() || 'tgmpa-bulk-update' === $plugin_table->current_action() ) && $plugin_table->process_bulk_actions() ) || $the7_tgmpa->public_do_plugin_install() ) {
	return;
}

// Force refresh of available plugin information so we'll know about manual updates/deletes.
wp_clean_plugins_cache( false );

?>
<div id="the7-dashboard" class="wrap">
    <h1><?php esc_html_e( 'Recommended Plugins', 'the7mk2' ); ?></h1>
        <?php $plugin_table->prepare_items(); ?>
        <?php $plugin_table->views(); ?>

        <form id="tgmpa-plugins" action="" method="post">
            <input type="hidden" name="tgmpa-page" value="<?php echo esc_attr( $the7_tgmpa->menu ); ?>" />
            <input type="hidden" name="plugin_status" value="<?php echo esc_attr( $plugin_table->view_context ); ?>" />
            <?php $plugin_table->display(); ?>
        </form>
</div>