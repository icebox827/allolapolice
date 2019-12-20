<?php
/**
 * Microwidget search view.
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$show_icon = presscore_config()->get( 'header.elements.search.icon.enabled' );

$class = 'disabled' === $show_icon ? ' mini-icon-off' : '';

$caption = presscore_config()->get( 'header.elements.search.caption' );
if ( $caption ) {
	$caption = '<span>' . esc_html( $caption ) . '</span>';
}

$input_caption = presscore_config()->get( 'header.elements.search.input.caption' );

if ( ! $caption && 'disabled' !== $show_icon ) {
	$class .= ' text-disable';
}

$class_icon = '';
if ( presscore_config()->get( 'header.elements.search.icon' ) === 'disabled' ) {
	$class_icon = ' search-icon-disabled';
}

if ( ! $input_caption ) {
	$input_caption = '&nbsp;';
}

$custom_icon = '';
if ( presscore_config()->get( 'header.elements.search.icon' ) === 'custom' ) {
	$custom_icon = '<i class="' . presscore_config()->get( 'header.elements.search.custom.icon' ) . '"></i>';
}

$custom_search_icon = '';
if ( 'custom' === $show_icon ) {
	$custom_search_icon = '<i class=" mw-icon ' . presscore_config()->get( 'header.elements.search.icon.custom' ) . '"></i>';
}
?>
<form class="searchform mini-widget-searchform<?php echo $class_icon; ?>" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<label for="the7-micro-widget-search" class="screen-reader-text"><?php esc_html_e( 'Search:', 'the7mk2' ); ?></label>
	<?php if ( in_array( presscore_config()->get( 'header.elements.search.style' ), array( 'classic', 'animate_width' ) ) ) : ?>

		<input type="text" id="the7-micro-widget-search" class="field searchform-s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_html( $input_caption ); ?>"/>

		<a href="#go" class="search-icon"><?php echo $custom_icon; ?></a>

	<?php elseif ( presscore_config()->get( 'header.elements.search.style' ) === 'popup' ) : ?>
		<a href="#go" class="submit<?php echo $class; ?>"><?php echo $custom_search_icon . $caption; ?></a>
		<div class="popup-search-wrap">
			<input type="text" id="the7-micro-widget-search" class="field searchform-s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_html( $input_caption ); ?>"/>

			<a href="#go" class="search-icon"><?php echo $custom_icon; ?></a>
		</div>
	<?php else : ?>
		<div class='overlay-search-wrap'>
			<input type="text" id="the7-micro-widget-search" class="field searchform-s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_html( $input_caption ); ?>"/>

			<a href="#go" class="search-icon"><?php echo $custom_icon; ?></a>
		</div>


		<a href="#go" class="submit<?php echo $class; ?>"><?php echo $custom_search_icon . $caption; ?></a>

		<?php
	endif;

	do_action( 'presscore_header_searchform_fields' );
	?>
	<?php if ( of_get_option( 'header-elements-search-by' ) === 'products' ) : ?>
		<input type="hidden" name="post_type" value="product">
	<?php endif; ?>
	<input type="submit" class="assistive-text searchsubmit" value="<?php esc_attr_e( 'Go!', 'the7mk2' ); ?>"/>
</form>
