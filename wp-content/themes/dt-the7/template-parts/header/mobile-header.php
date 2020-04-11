<?php
/**
 * Mobile header.
 *
 * @since   3.0.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

$classes = '';
if ( of_get_option( 'header-mobile-menu-show_dividers' ) ) {
	$classes = 'mobile-menu-show-divider';
}

$config = presscore_config();
$menu_close_caption = '';
if ( $config->get( 'header.mobile.close.hamburger.caption' ) !== 'disabled' ) {
	$menu_close_caption = '<span class="mobile-menu-close-caption">' . esc_html( $config->get( 'header.mobile.close.hamburger.caption.text' ) ) . '</span>';
}

$menu_icon    = '<div class="dt-close-mobile-menu-icon">' . $menu_close_caption . '<div class="close-line-wrap"><span class="close-line"></span><span class="close-line"></span><span class="close-line"></span></div></div>';

$show_outside = $config->get( 'header.mobile.menu-close_icon.position' ) === 'outside';
if ( $show_outside ) {
	echo $menu_icon;
}
?>
<div class="dt-mobile-header <?php echo $classes; ?>">
	<?php
	if ( ! $show_outside ) {
		echo $menu_icon;
	}
	?>
	<ul id="mobile-menu" class="mobile-main-nav" role="navigation">
		<?php
		if ( ! isset( $location ) ) {
			$location = ( presscore_has_mobile_menu() ? 'mobile' : 'primary' );
		}

		the7_display_mobile_menu( $location );
		?>
	</ul>
	<div class='mobile-mini-widgets-in-menu'></div>
</div>
