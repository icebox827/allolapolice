<?php
/**
 * Admin View: Notice - Beta tester mode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<p>
    <strong><?php _e( 'Important', 'the7mk2' ); ?>:</strong> <?php _e( 'You are using The7 in BETA testing mode and will receive latest nightly updates.', 'the7mk2' ); ?>
    <?php printf( __( 'To disable BETA testing mode, visit %s page.', 'the7mk2' ), sprintf( '<a href="%s">%s</a>', admin_url( '?page=the7-dev&tab=beta' ), __( 'The7 Dev', 'the7mk2' ) ) ); ?>
</p>
