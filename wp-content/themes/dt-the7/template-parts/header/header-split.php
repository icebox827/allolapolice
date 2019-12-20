<?php
/**
 * Split header.
 *
 * @since   3.0.0
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div <?php presscore_header_class( 'masthead split-header' ); ?> <?php presscore_header_inline_style(); ?> role="banner">

	<?php presscore_get_template_part( 'theme', 'header/top-bar' ); ?>

	<header class="header-bar">

		<?php presscore_get_template_part( 'theme', 'header/branding' ); ?>

		<nav class="navigation">

			<?php presscore_get_template_part( 'theme', 'header/primary-menu', null, array( 'menu_location' => 'split_left' ) ); ?>

			<?php presscore_render_header_elements( 'near_menu_left' ); ?>

		</nav>

		<nav class="navigation">

			<?php presscore_get_template_part( 'theme', 'header/primary-menu', null, array( 'menu_location' => 'split_right' ) ); ?>

			<?php presscore_render_header_elements( 'near_menu_right' ); ?>

		</nav>

	</header>

</div>
