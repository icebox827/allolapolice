<?php
/**
 * Editor popup part - Button view
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;
 
?>
<?php if ( $skin == 'clean') : ?>
</table>
<div class="gwa-section" data-parent-id="type" data-parent-value="button"<?php echo !empty( $postdata['type'] ) && $postdata['type'] != 'button' ? ' style="display:none;"' : ''; ?>><span><?php _e( 'Column Hover Colors', 'go_pricing_textdomain' ); ?></span></div> 
<table class="gwa-table" data-parent-id="type" data-parent-value="button"<?php echo !empty( $postdata['type'] ) && $postdata['type'] != 'button' ? ' style="display:none;"' : ''; ?>>
    <tr>
        <th><label><?php _e( 'Text Color', 'go_pricing_textdomain' ); ?></label></th>
        <td><label><div class="gwa-colorpicker gwa-colorpicker-inline" tabindex="0"><input type="hidden" name="button[color-hover]" value="<?php echo esc_attr( isset( $postdata['button']['color-hover'] ) ? $postdata['button']['color-hover'] : '' ); ?>"><span class="gwa-cp-picker"><span<?php echo ( !empty( $postdata['button']['color-hover'] ) ? ' style="background:' . $postdata['button']['color-hover'] . ';"' : '' ); ?>></span></span><span class="gwa-cp-label"><?php echo ( !empty( $postdata['button']['color-hover'] ) ? $postdata['button']['color-hover'] : '&nbsp;' ); ?></span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $postdata['button']['color-hover'] ) ? $postdata['button']['color-hover'] : '' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></div></label></td>
        <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Color of the button text.', 'go_pricing_textdomain' ); ?></p></td>
    </tr>
    <tr>
        <th><label><?php _e( 'Background Color', 'go_pricing_textdomain' ); ?></label></th>
        <td><label><div class="gwa-colorpicker gwa-colorpicker-inline" tabindex="0"><input type="hidden" name="button[bg-color-hover]" value="<?php echo esc_attr( isset( $postdata['button']['bg-color-hover'] ) ? $postdata['button']['bg-color-hover'] : '' ); ?>"><span class="gwa-cp-picker"><span<?php echo ( !empty( $postdata['button']['bg-color-hover'] ) ? ' style="background:' . $postdata['button']['bg-color-hover'] . ';"' : '' ); ?>></span></span><span class="gwa-cp-label"><?php echo ( !empty( $postdata['button']['bg-color-hover'] ) ? $postdata['button']['bg-color-hover'] : '&nbsp;' ); ?></span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $postdata['button']['bg-color-hover'] ) ? $postdata['button']['bg-color-hover'] : '' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'go_pricing_textdomain' ); ?>"><i class="fa fa-heart"></i></a></div></div></div></label></td>
        <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Color of the button background.', 'go_pricing_textdomain' ); ?></p></td>
    </tr>  
<?php endif; ?>