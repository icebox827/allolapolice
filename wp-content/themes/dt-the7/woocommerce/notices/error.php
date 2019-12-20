<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $messages ){
	return;
}

?>
<div class="woocommerce-error" role="alert">
<ul class="woocommerce-error-text">
	<?php foreach ( $messages as $message ) : ?>
		<li><?php
            if ( function_exists( 'wc_kses_notice' ) ) {
	            echo wc_kses_notice( $message );
            } else {
	            echo wp_kses_post( $message );
            }
            ?></li>
	<?php endforeach; ?>
</ul>
<span class="close-message"></span>
</div>
