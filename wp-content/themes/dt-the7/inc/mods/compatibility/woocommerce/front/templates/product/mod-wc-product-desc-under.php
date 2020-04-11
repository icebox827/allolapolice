<?php
defined( 'ABSPATH' ) || exit;

global $product;
?>
<figure class="woocom-project">
	<div class="woo-buttons-on-img">

		<?php
		presscore_wc_template_loop_product_thumbnail( 'alignnone' );

		$rollover_icons = dt_woocommerce_get_product_preview_icons();
		if ( $rollover_icons ) {
			echo '<div class="woo-buttons">' . $rollover_icons . '</div>';
		}

		if ( ! $product->is_in_stock() ) {
			echo '<span class="out-stock-label">' . __( 'Out Of Stock', 'the7mk2' ) . '</span>';
		}

		the7_ti_wishlist_button();
		?>

	</div>
	<figcaption class="woocom-list-content">

		<?php echo dt_woocommerce_get_product_description(); ?>

	</figcaption>
</figure>
