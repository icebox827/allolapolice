<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
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
<div class="woocommerce-message" role="alert">
<?php foreach ( $messages as $message ) : ?>
	<div class="woocommerce-message-text">
		<?php
            if ( function_exists( 'wc_kses_notice' ) ) {
                echo wc_kses_notice( $message );
            } else {
                echo wp_kses_post( $message );
            }
		?>
    </div>
    <span class="close-message"></span>
<?php endforeach; ?>
</div>
<?php
if ( is_product() && of_get_option( 'header-elements-woocommerce_cart-show_sub_cart' ) ) {
	echo '<span class="added-to-cart" data-timer=""></span>';
}
?>
