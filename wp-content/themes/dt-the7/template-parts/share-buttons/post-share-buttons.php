<?php
/**
 * Template for post share buttons.
 *
 * @since   7.8.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="share-link-description"><?php echo esc_html( $share_buttons_header ); ?></div>
	<div class="share-buttons">
		<?php
		foreach ( $share_buttons as $share_button ) {
			printf(
				'<a class="%1$s" href="%2$s" title="%3$s" target="_blank" %4$s><span class="soc-font-icon"></span><span class="social-text">%5$s</span><span class="screen-reader-text">%6$s</span></a>' . "\n",
				esc_attr( $share_button['icon_class'] ),
				esc_url( $share_button['url'] ),
				esc_attr( $share_button['name'] ),
				$share_button['custom_atts'],
				esc_html( $share_button['alt_title'] ),
				esc_html( $share_button['title'] )
			);
		}
		?>
	</div>
</div>