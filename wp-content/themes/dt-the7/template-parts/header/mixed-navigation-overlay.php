<?php
/**
 * Overlay header.
 *
 * @since   3.0.0
 * @package The7/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$config = presscore_config();
$classes = array( 'hide-overlay' );
$classes[] = presscore_array_value( $config->get( 'header.hamburger.close.bg' ), array(
'enabled' => 'hamburger-close-bg-enable',
'disabled' => 'hamburger-close-bg-disable',
) );
$classes[] = presscore_array_value( $config->get( 'header.hamburger.close.bg.hover' ), array(
'enabled' => 'hamburger-close-bg-hover-enable',
'disabled' => 'hamburger-close-bg-hover-disable',
) );
$classes[] = presscore_array_value( $config->get( 'header.hamburger.close.border' ), array(
'enabled' => 'hamburger-close-border-enable',
'disabled' => 'hamburger-close-border-disable',
) );
$classes[] = presscore_array_value( $config->get( 'header.hamburger.close.border.hover' ), array(
'enabled' => 'hamburger-close-border-hover-enable',
'disabled' => 'hamburger-close-border-hover-disable',
) );
$menu_close_caption = '';
if ( $config->get( 'header.close.hamburger.caption' ) !== 'disabled' ) {
	$menu_close_caption = '<span class="menu-toggle-caption">' . of_get_option( 'header-menu-close_icon-caption-text' ) . '</span>';
}
$menu_icon = sprintf(
	'<div class="%s">%s<div class="close-line-wrap"><span class="close-line"></span><span class="close-line"></span><span class="close-line"></span></div></div>',
	implode(' ', $classes),
	$menu_close_caption
);

?>

<div <?php presscore_header_class( 'masthead side-header' ); ?> role="banner">
	<?php echo $menu_icon; ?>
	<header class="header-bar">

		<?php presscore_get_template_part( 'theme', 'header/branding' ); ?>

		<?php presscore_get_template_part( 'theme', 'header/primary-menu' ); ?>

		<?php presscore_render_header_elements( 'below_menu' ); ?>

	</header>

</div>
