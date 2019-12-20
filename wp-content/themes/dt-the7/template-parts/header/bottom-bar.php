<?php
/**
 * Description here.
 *
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div role="complementary" <?php presscore_top_bar_class( 'header-bottom-bar' ); ?>>
	<div class="wf-wrap">
		<div class="wf-container-top">
			<div class="wf-table wf-mobile-collapsed">

				<?php presscore_render_header_elements( 'bottom' ); ?>

			</div><!-- .wf-table -->
		</div><!-- .wf-container-top -->
	</div><!-- .wf-wrap -->
</div><!-- .header-bottom-bar -->
