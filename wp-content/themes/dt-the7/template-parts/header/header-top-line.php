<?php
/**
 * Top line header.
 *
 * @since   5.7.0
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
presscore_get_template_part( 'theme', 'header/mixed-navigation', presscore_get_mixed_header_navigation() );
$config                 = presscore_config();
$top_line_right_classes = '';
$top_line_left_classes  = '';
if ( ! presscore_get_header_elements_list( 'side_top_line' ) ) {
	$top_line_left_classes = 'empty-widgets';
}
if ( ! presscore_get_header_elements_list( 'top_line_right' ) ) {
	$top_line_right_classes = 'empty-widgets';
}
?>

<div <?php presscore_mixed_header_class( 'masthead mixed-header' ); ?> <?php presscore_header_inline_style(); ?> role="banner">

	<?php presscore_get_template_part( 'theme', 'header/top-bar' ); ?>

	<header class="header-bar">

		<?php
		presscore_get_template_part( 'theme', 'header/mixed-branding' );

		if ( 'center' === $config->get( 'header.mixed.view.top_line.logo.position' ) || 'left' === $config->get( 'header.mixed.view.top_line.logo.position' ) ) {
			echo '<div class="top-line-left ' . $top_line_left_classes . '" >';
			presscore_render_header_elements( 'side_top_line', 'left-widgets' );
			echo '</div><div class="top-line-right ' . $top_line_right_classes . '">';
			presscore_render_header_elements( 'top_line_right', 'right-widgets' );
			presscore_header_menu_icon();
			echo '</div>';
		} else if ( 'left_btn-right_logo' === $config->get( 'header.mixed.view.top_line.logo.position' ) || 'left_btn-center_logo' === $config->get( 'header.mixed.view.top_line.logo.position' ) ) {
			echo '<div class="top-line-left ' . $top_line_left_classes . '">';
			presscore_header_menu_icon();
			presscore_render_header_elements( 'side_top_line', 'left-widgets' );
			echo '</div><div class="top-line-right ' . $top_line_right_classes . '">';
			presscore_render_header_elements( 'top_line_right', 'right-widgets' );
			echo '</div>';
		}
		?>

	</header>

</div>
