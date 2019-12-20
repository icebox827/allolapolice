<?php
/**
 * Template for WooCommerce cart microwidget.
 *
 * @since 4.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_cart() ) {
	do_action( 'woocommerce_before_mini_cart' );
}

$config = presscore_config();

// Counter.
$show_products_counter = $config->get( 'woocommerce.mini_cart.counter' );
if ( 'never' === $show_products_counter ) {
	$dt_product_counter_html = '';
} else {
	$cart_count       = WC()->cart->get_cart_contents_count();
	$cart_count_class = array( 'counter' );
	if ( 'if_not_empty' === $show_products_counter ) {
		$cart_count_class[] = 'hide-if-empty';
		if ( $cart_count <= 0 ) {
			$cart_count_class[] = 'hidden';
		}
	}

	switch ( $config->get( 'woocommerce.mini_cart.counter.bg' ) ) {
		case 'gradient':
			$cart_count_class[] = 'gradient-bg';
			break;
		case 'color':
			$cart_count_class[] = 'custom-bg';
			break;
	}

	$dt_product_counter_html = sprintf( '<span class="%1$s">%2$s</span>', presscore_esc_implode( ' ', $cart_count_class ), $cart_count );
}

$dt_cart_class = array();

// Icon.
$show_icon = $config->get( 'woocommerce.mini_cart.icon' );
if ( ! $show_icon ) {
	$dt_cart_class[] = 'mini-icon-off';
}

// Caption.
$dt_cart_caption = $config->get( 'woocommerce.mini_cart.caption', __( 'Your cart', 'the7mk2' ) );

if ( $config->get( 'woocommerce.mini_cart.subtotal' ) ) {
	$dt_cart_caption .= ( $dt_cart_caption ? ':&nbsp;' : '' ) . WC()->cart->get_cart_subtotal();
}

if ( '' === $dt_cart_caption ) {
	$dt_cart_caption .= '&nbsp;';
	if ( $show_icon ) {
		$dt_cart_class[] = 'text-disable';
	}
}

switch ( $config->get( 'woocommerce.mini_cart.counter.style' ) ) {
	case 'round':
		$dt_cart_class[] = 'round-counter-style';
		break;
	case 'rectangular':
		$dt_cart_class[] = 'rectangular-counter-style';
		break;
}

if ( $config->get_bool( 'woocommerce.mini_cart.dropdown' ) ) {
	$dt_cart_class[] = 'show-sub-cart';
}

$cart_bottom_style = '';
if ( count( WC()->cart->get_cart() ) <= 0 ) {
	$cart_bottom_style = 'style="display: none"';
}

$cart_hash   = The7_WC_Mini_Cart::get_cart_fragment_hash();
$widget_icon = '';
if ( of_get_option( 'header-elements-woocommerce_cart-icon' ) === 'custom' ) {
	$widget_icon = '<i class="' . esc_attr( of_get_option( 'header-elements-woocommerce_cart-custom-icon' ) ) . '"></i>';
}
?>

<div class="<?php echo 'wc-shopping-cart shopping-cart ' . presscore_esc_implode( ' ', $dt_cart_class ); ?>" data-cart-hash="<?php echo esc_attr( $cart_hash ); ?>">

	<a class="<?php echo 'wc-ico-cart ' . presscore_esc_implode( ' ', $dt_cart_class ); ?>" href="<?php echo wc_get_cart_url(); ?>"><?php echo $widget_icon, $dt_cart_caption, $dt_product_counter_html; ?></a>

	<div class="shopping-cart-wrap">
		<div class="shopping-cart-inner">
			<?php do_action( 'woocommerce_before_mini_cart_contents' ); ?>

			<?php
			$buttons  = '';
			$buttons .= sprintf( '<a href="%1$s" class="button view-cart">%2$s</a>', wc_get_cart_url(), __( 'View Cart', 'the7mk2' ) );
			$buttons .= sprintf( '<a href="%1$s" class="button checkout">%2$s</a>', wc_get_checkout_url(), __( 'Checkout', 'the7mk2' ) );
			?>
			<p class="buttons top-position">
				<?php echo $buttons; ?>
			</p>

			<?php
			$products = array();
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product           = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_is_visible = apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key );

				if ( ! $_product || ! $product_is_visible || $cart_item['quantity'] <= 0 || ! $_product->exists() ) {
					continue;
				}

				$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$remove_link   = apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), __( 'Remove this item', 'the7mk2' ) ), $cart_item_key );
				$quantity      = apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key );
				$product_data  = wc_get_formatted_cart_item_data( $cart_item );
				$product_link  = str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name;
				if ( $_product->is_visible() ) {
					$product_link = sprintf( '<a href="%1$s">%2$s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $product_link );
				}

				$products[] = "<li>{$remove_link}{$product_link}{$product_data}{$quantity}</li>";
			}

			$list_class = array( 'cart_list', 'product_list_widget' );
			if ( ! count( $products ) ) {
				$list_class[] = 'empty';
				$products[]   = sprintf( '<li>%s</li>', __( 'No products in the cart.', 'the7mk2' ) );
			}
			?>
			<ul class="<?php echo presscore_esc_implode( ' ', $list_class ); ?>">
				<?php
				echo implode( '', $products );

				do_action( 'woocommerce_mini_cart_contents' );
				?>
			</ul>
			<div class="shopping-cart-bottom" <?php echo $cart_bottom_style; ?>>
				<p class="total">
					<strong><?php _e( 'Subtotal', 'the7mk2' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?>
				</p>
				<p class="buttons">
					<?php echo $buttons; ?>
				</p>
			</div>
			<?php do_action( 'woocommerce_after_mini_cart' ); ?>
		</div>
	</div>

</div>
