<?php
/**
 * The Sidebar containing the main widget areas.
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

if ( 'disabled' === presscore_config()->get( 'sidebar_position' ) ) {
	return;
}

$sidebar = presscore_validate_sidebar( presscore_config()->get( 'sidebar_widgetarea_id' ) );

$dividers_off = '';
if ( ! presscore_config()->get( 'sidebar.style.dividers.horizontal' ) ) {
	$dividers_off = ' widget-divider-off';
}

if ( is_active_sidebar( $sidebar ) ) : ?>

	<aside id="sidebar" <?php echo presscore_sidebar_html_class( 'sidebar' ); ?>>
		<div class="sidebar-content<?php echo $dividers_off; ?>">
			<?php
			do_action( 'presscore_before_sidebar_widgets' );
			dynamic_sidebar( $sidebar );
			?>
		</div>
	</aside><!-- #sidebar -->

<?php endif ?>
