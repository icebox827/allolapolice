<?php
/**
 * Mixed header branding.
 *
 * @since   3.0.0
 * @package The7/Templates
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="branding">

	<?php
	$logo = '';

	$logo .= presscore_get_the_mixed_logo();
	$logo .= presscore_get_the_mobile_logo();

	$logo_class = '';
	if ( presscore_is_floating_transparent_top_line_header() && 'main' === of_get_option( 'header-style-mixed-top_line-floating-choose_logo' ) ) {
		$logo_class = 'same-logo';
	}

	presscore_display_the_logo( $logo, $logo_class );
	?>

</div>
