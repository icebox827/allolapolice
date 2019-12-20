<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<header><h4><?php esc_html_e( 'Customer Details', 'the7mk2' ); ?></h4></header>

<table class="shop_table customer_details">
	<?php if ( $order->get_customer_note() ) : ?>
        <tr>
            <th><?php esc_html_e( 'Note:', 'the7mk2' ); ?></th>
            <td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
        </tr>
	<?php endif; ?>

	<?php if ( $order->get_billing_email() ) : ?>
        <tr>
            <th><?php esc_html_e( 'Email:', 'the7mk2' ); ?></th>
            <td><?php echo esc_html( $order->get_billing_email() ); ?></td>
        </tr>
	<?php endif; ?>

	<?php if ( $order->get_billing_phone() ) : ?>
        <tr>
            <th><?php esc_html_e( 'Phone:', 'the7mk2' ); ?></th>
            <td><?php echo esc_html( $order->get_billing_phone() ); ?></td>
        </tr>
	<?php endif; ?>

    <tr>
        <th><?php esc_html_e( 'Billing Address', 'the7mk2' ); ?></th>
        <td><?php echo wp_kses_post( $order->get_formatted_billing_address( __( 'N/A', 'the7mk2' ) ) ); ?></td>
    </tr>

	<?php if ( $show_shipping ) : ?>
        <tr>
            <th><?php esc_html_e( 'Shipping Address', 'the7mk2' ); ?></th>
            <td><?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'the7mk2' ) ) ); ?></td>
        </tr>
	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</table>

