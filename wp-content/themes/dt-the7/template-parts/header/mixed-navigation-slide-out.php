<?php
/**
 * Slide out header.
 *
 * @since   3.0.0
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div <?php presscore_header_class( 'masthead side-header slide-out' ); ?> role="banner">

	<header class="header-bar">

		<?php presscore_get_template_part( 'theme', 'header/branding' ); ?>

		<?php presscore_get_template_part( 'theme', 'header/primary-menu' ); ?>

		<?php presscore_render_header_elements( 'below_menu' ); ?>

	</header>

</div>
