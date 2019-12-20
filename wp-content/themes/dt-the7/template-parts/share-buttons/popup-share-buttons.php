<?php
/**
 * Template for share buttons in popup.
 *
 * @since   7.8.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="<?php echo esc_attr( $wrap_class ); ?>">

	<?php
	echo presscore_get_button_html(
		array(
			'title' => esc_html( $share_buttons_header ),
			'href'  => '#',
			'class' => 'share-button entry-share h5-size' . ( $share_buttons_header ? '' : ' no-text' ),
		)
	);
	?>

	<div class="soc-ico">
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
