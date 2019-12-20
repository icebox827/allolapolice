<?php
/**
 * Checkout login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
	return;
}

?>
<div class="wc-login-wrap">
<?php
$info_message  = apply_filters( 'woocommerce_checkout_login_message',  ' <span class="showlogin-tag"><i class="icomoon-the7-font-the7-login-04" aria-hidden="true"></i>' .__( 'Returning customer?', 'the7mk2' ) ) . '</span>';
$info_message .= ' <a href="#" class="showlogin">' . __( 'Click here to login', 'the7mk2' ) . '</a>';
wc_print_notice( $info_message, 'notice' );

woocommerce_login_form(
	array(
		'message'  => esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.', 'the7mk2' ),
		'redirect' => wc_get_checkout_url(),
		'hidden'   => true,
	)
);
?>
</div>