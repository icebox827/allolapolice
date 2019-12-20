<?php
/**
 * Mobile header.
 *
 * @since   3.0.0
 *
 * @package The\Templates
 */

defined( 'ABSPATH' ) || exit;
?>
<div class='dt-close-mobile-menu-icon'><span></span></div>
<div class='dt-mobile-header'>
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
