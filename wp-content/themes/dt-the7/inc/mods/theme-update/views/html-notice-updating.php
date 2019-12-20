<?php
/**
 * Admin View: Notice - Updating
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<p><strong><?php _e( 'The7 database update', 'the7mk2' ); ?></strong> &#8211; <?php _e( 'Your database is being updated in the background.', 'the7mk2' ); ?> <a href="<?php echo esc_url( add_query_arg( 'force_update_the7', 'true', admin_url( 'admin.php?page=the7-dashboard' ) ) ); ?>"><?php _e( 'Taking a while? Click here to run it now.', 'the7mk2' ); ?></a></p>