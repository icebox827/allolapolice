<?php
	function dt_checkout_breadcrumb_class($endpoint){
		$classes = array();
		if($endpoint == 'cart' && is_cart() ||
			$endpoint == 'checkout' && is_checkout() && !is_wc_endpoint_url('order-received') ||
			$endpoint == 'order-received' && is_wc_endpoint_url('order-received')) {
			$classes[] = 'current';
		} else if(is_wc_endpoint_url('order-received') || $endpoint == 'order-received' && is_wc_endpoint_url('order-received')) {
			
			$classes[] = 'current';
		} else{
			$classes[] = 'hide-for-small';
		}
		return implode(' ', $classes);
	}
?>

<div class="checkout-page-title">
	<nav class="checkout-breadcrumbs">
	   <a href="<?php echo wc_get_cart_url(); ?>" class="current step-cart <?php echo dt_checkout_breadcrumb_class('cart'); ?>">
	   		<span class="checkout-name"><?php _e('Your Cart', 'the7mk2'); ?></span>
	   		<span class="checkout-step"><span class="checkout-counter"><?php _e('1', 'the7mk2'); ?></span><span class="checkout-line"></span></span>
	   </a>
	   <a href="<?php echo wc_get_checkout_url(); ?>" class="step-checkout <?php echo dt_checkout_breadcrumb_class('checkout') ?>">
	   		<span class="checkout-name"><?php _e('Checkout Details', 'the7mk2'); ?></span>
	   		<span class="checkout-step"><span class="checkout-counter"><?php _e('2', 'the7mk2'); ?></span><span class="checkout-line"></span></span>
	   </a>
	   <a href="#" class="no-click step-complete <?php echo dt_checkout_breadcrumb_class('order-received'); ?>">
	   		<span class="checkout-name"><?php _e('Order Complete', 'the7mk2'); ?></span>
	   		<span class="checkout-step"><span class="checkout-counter"><?php _e('3', 'the7mk2'); ?></span><span class="checkout-line"></span></span>
	   </a>
    </nav>
</div><!-- .page-title -->
