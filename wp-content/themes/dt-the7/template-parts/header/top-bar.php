<?php
/**
 * Top bar.
 *
 * @since   1.0.0
 * @version 4.0.0
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div <?php presscore_top_bar_class( 'top-bar' ); ?>>
	<div class="top-bar-bg" <?php presscore_top_bar_inline_style(); ?>></div>
	<?php
	if ( presscore_get_header_elements_list( 'top_bar_left' ) ) {
		presscore_render_header_elements( 'top_bar_left', 'left-widgets' );
	} else {
		echo '<div class="mini-widgets left-widgets"></div>';
	}
	if ( presscore_get_header_elements_list( 'top_bar_right' ) ) {
		presscore_render_header_elements( 'top_bar_right', 'right-widgets' );
	} else {
		echo '<div class="mini-widgets right-widgets"></div>';
	}
	?>
</div>
