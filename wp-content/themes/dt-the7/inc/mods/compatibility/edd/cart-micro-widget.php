<?php
/**
 * EDD cart micro widget.
 *
 * @since 6.6.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = presscore_config();

$cart_count    = edd_get_cart_quantity();
$cart_subtotal = edd_currency_filter( edd_format_amount( edd_get_cart_total() ) );

// Counter.
$show_products_counter = $config->get( 'edd.mini_cart.counter' );
if ( 'never' === $show_products_counter ) {
	$dt_product_counter_html = '';
} else {
	$cart_count_class = array( 'counter' );
	if ( 'if_not_empty' === $show_products_counter ) {
		$cart_count_class[] = 'hide-if-empty';

		if ( $cart_count <= 0 ) {
			$cart_count_class[] = 'hidden';
		}
	}

	// counter gradient bg
	switch ( $config->get( 'edd.mini_cart.counter.bg' ) ) {
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
$show_icon = $config->get( 'edd.mini_cart.icon' );
if ( ! $show_icon ) {
	$dt_cart_class[] = 'mini-icon-off';
}

// Caption.
$dt_cart_caption = $config->get( 'edd.mini_cart.caption', __( 'Your cart', 'the7mk2' ) );

if ( $config->get( 'edd.mini_cart.subtotal' ) ) {
	$dt_cart_caption .= ( $dt_cart_caption ? ':&nbsp;' : '' ) . $cart_subtotal;
}

if ( '' === $dt_cart_caption ) {
	$dt_cart_caption .= '&nbsp;';

	if ( $show_icon ) {
		$dt_cart_class[] = 'text-disable';
	}
}

switch ( $config->get( 'edd.mini_cart.counter.style' ) ) {
	case 'round':
		$dt_cart_class[] = 'round-counter-style';
		break;
	case 'rectangular':
		$dt_cart_class[] = 'rectangular-counter-style';
		break;
}

if ( $config->get_bool( 'edd.mini_cart.dropdown' ) ) {
	$dt_cart_class[] = 'show-sub-cart';
}

$cart_bottom_style = '';
if ( $cart_count <= 0 ) {
	$cart_bottom_style = 'style="display: none"';
}

$checkout_url = edd_get_checkout_uri();
$cart_items   = edd_get_cart_contents();
$widget_icon = '';
if ( of_get_option( 'header-elements-edd_cart-icon' ) === 'custom' ) {
	$widget_icon = '<i class="' . esc_attr( of_get_option( 'header-elements-edd_cart-custom-icon' ) ) . '"></i>';
}
?>

<div class="<?php echo 'edd-shopping-cart shopping-cart ' . presscore_esc_implode( ' ', $dt_cart_class ) ?>">

    <a class="<?php echo 'edd-ico-cart ' . presscore_esc_implode( ' ', $dt_cart_class ) ?>" href="<?php echo $checkout_url ?>"><?php echo $widget_icon, $dt_cart_caption, $dt_product_counter_html ?></a>

    <div class="shopping-cart-wrap">
        <div class="shopping-cart-inner">
			<?php
			$buttons = '';
			$buttons .= sprintf( '<a href="%1$s" class="button checkout">%2$s</a>', $checkout_url, __( 'Checkout', 'the7mk2' ) );
			?>
            <p class="buttons top-position">
				<?php echo $buttons ?>
            </p>

			<?php
			$products = array();
			foreach ( $cart_items as $cart_item_key => $cart_item ) {
				$id = is_array( $cart_item ) ? $cart_item['id'] : $cart_item;

				$remove_url   = edd_remove_item_url( $cart_item_key );
				$product_name = get_the_title( $id );
				$options      = ! empty( $cart_item['options'] ) ? $cart_item['options'] : array();
				$quantity     = edd_get_cart_item_quantity( $id, $options );
				$price        = edd_get_cart_item_price( $id, $options );

				$remove_link = sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', $remove_url, __( 'Remove this item', 'the7mk2' ) );
				$quantity    = '<span class="quantity">' . sprintf( '%s &times; %s', $quantity, $price ) . '</span>';

				$post_thimbnail_id = get_post_thumbnail_id( $id );
				if ( $post_thimbnail_id ) {
					$product_link = wp_get_attachment_image( $post_thimbnail_id );
				} else {
					$product_link = sprintf( '<img src="%s" width="80" height="80" alt="%s" />', PRESSCORE_THEME_URI . '/images/noimage-80x80.jpg', esc_attr( $product_name ) );
				}

				$product_link = sprintf( '<a href="%1$s">%2$s</a>', get_permalink( $id ), $product_link . $product_name );

				$products[] = "<li>{$remove_link}{$product_link}{$quantity}</li>";
			}

			$list_class = array( 'cart_list', 'product_list_widget' );
			if ( ! count( $products ) ) {
				$list_class[] = 'empty';
				$products[]   = sprintf( '<li>%s</li>', __( 'No products in the cart.', 'the7mk2' ) );
			}
			?>
            <ul class="<?php echo presscore_esc_implode( ' ', $list_class ); ?>">
				<?php
				echo join( '', $products );
				?>
            </ul>
            <div class="shopping-cart-bottom" <?php echo $cart_bottom_style ?>>
                <p class="total"><strong><?php _e( 'Subtotal', 'the7mk2' ) ?>:</strong> <?php echo $cart_subtotal ?></p>
                <p class="buttons">
					<?php echo $buttons ?>
                </p>
            </div>
        </div>
    </div>

</div>