<?php
/**
 * Admin View: Notice - Update
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<p><strong><?php _e( 'The7 database update', 'the7mk2' ); ?></strong> &#8211; <?php _e( 'We need to update your site database to match the latest theme version.', 'the7mk2' ); ?></p>
<p class="submit"><a href="<?php echo esc_url( add_query_arg( 'do_update_the7', 'true', admin_url( 'admin.php?page=the7-dashboard' ) ) ); ?>" class="the7-update-now button-primary"><?php _e( 'Run the updater', 'the7mk2' ); ?></a></p>
<script type="text/javascript">
    jQuery( '.the7-update-now' ).click( 'click', function() {
        return window.confirm( '<?php echo esc_js( __( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'the7mk2' ) ); ?>' ); // jshint ignore:line
    });
</script>