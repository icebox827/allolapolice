<?php

/**
 * Shortcode handler
 */

if ( !$go_pricing_table_id ) : ?>
<div class="go-pricing-cs-placeholder">
	<style type="text/css">
	.go-pricing-cs-placeholder { background:#f5f5f5;border:dashed 1px #e2e2e2;color:#9d9d9d;font-size:16px;padding:10px;	}
	.go-pricing-cs-placeholder svg {fill:#9d9d9d;height:50px;float:left;width:50px;}
	.go-pricing-cs-placeholder-content {line-height:20px;padding:15px;padding-left:65px;}
	</style>
	<svg><use xmlns:xlink="https://www.w3.org/1999/xlink" xlink:href="<?php echo esc_attr( GW_GoPricing_Cornerstone_Extend::instance()->url()  ); ?>assets/go_pricing_icon.svg#default"></use></svg>    
	<div class="go-pricing-cs-placeholder-content"><?php _e( 'Select a pricing table from the list.', 'go_pricing_textdomain' ); ?></div>
</div>
<?php 
else :
echo do_shortcode( '[go_pricing id="' . $go_pricing_table_id . '"]' );
endif; 
?>

