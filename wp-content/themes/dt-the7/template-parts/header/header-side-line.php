<?php
/**
 * Side line header.
 *
 * @since   5.7.0
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php presscore_get_template_part( 'theme', 'header/mixed-navigation', presscore_get_mixed_header_navigation() ); ?>

<div <?php presscore_mixed_header_class( 'masthead mixed-header vertical' ); ?> role="banner">

	<?php presscore_get_template_part( 'theme', 'header/top-bar' ); ?>

	<header class="header-bar">

		<?php presscore_get_template_part( 'theme', 'header/mixed-branding' ); ?>

		<?php presscore_header_menu_icon(); ?>

	</header>

</div>
