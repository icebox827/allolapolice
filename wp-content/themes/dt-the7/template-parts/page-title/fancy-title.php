<?php
defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$css    = The7_Fancy_Title_CSS::get_css_for_post( $config->get( 'post_id' ) );
if ( $css ) {
	echo '<style id="the7-fancy-title-css" type="text/css">' . "\n$css\n" . '</style>';
}

// Title.
$title = '';

// TODO apply 'the_title' filter here
$custom_title = ( 'generic' === $config->get( 'fancy_header.title.mode' ) ) ? presscore_get_page_title() : $config->get( 'fancy_header.title' );
if ( $custom_title ) {

	// $title_class = presscore_get_font_size_class( $config->get('fancy_header.title.font.size') );

	$title_class = '';
	if ( 'accent' === $config->get( 'fancy_header.title.color.mode' ) ) {
		$title_class .= ' color-accent';
	}

	$custom_title = '<h1 class="fancy-title entry-title' . $title_class . '" ><span>' . strip_tags( $custom_title ) . '</span></h1>';

	$title .= apply_filters( 'presscore_page_title', $custom_title );

}

// Subtitle.
// TODO apply 'the_title' filter here
$sybtitle = $config->get( 'fancy_header.subtitle' );
if ( $sybtitle ) {

	$subtitle_class = "";
	if ( 'accent' === $config->get( 'fancy_header.subtitle.color.mode' ) ) {
		$subtitle_class .= ' color-accent';
	}

	$title .= sprintf( '<h2 class="fancy-subtitle %s"', $subtitle_class );


	$title .= '><span>' . strip_tags( $sybtitle ) . '</span></h2>';

}

// Container class
$container_classes = array( 'fancy-header' );

if ( $title ) {
	$title = '<div class="fancy-title-head hgroup">' . $title . '</div>';

	// if title and subtitle empty
} else {
	$container_classes[] = 'titles-off';

}

// Breadcrumbs.
$breadcrumbs = '';
if ( 'enabled' === $config->get( 'fancy_header.breadcrumbs' ) ) {

	$breadcrumbs_args = array(
		'beforeBreadcrumbs' => '',
		'afterBreadcrumbs'  => '',
	);

	$breadcrumbs_class = 'breadcrumbs text-small';

	switch ( $config->get( 'fancy_header.breadcrumbs.bg_color' ) ) {
		case 'black':
			$breadcrumbs_class .= ' bg-dark breadcrumbs-bg';
			break;

		case 'white':
			$breadcrumbs_class .= ' bg-light breadcrumbs-bg';
			break;
	}

	$breadcrumbs_args['listAttr'] = ' class="' . $breadcrumbs_class . '"';

	$breadcrumbs = presscore_get_breadcrumbs( $breadcrumbs_args );

} else {
	$container_classes[] = 'breadcrumbs-off';

}
if ( 'disabled' === $config->get( 'fancy_header.responsive.breadcrumbs' ) ) {
	$container_classes[] = 'breadcrumbs-mobile-off';
}

$content = $title . $breadcrumbs;
switch ( $config->get( 'fancy_header.title.aligment' ) ) {
	case 'center':
		$container_classes[] = 'title-center';
		break;
	case 'right':
		$container_classes[] = 'title-right';
		$content             = $breadcrumbs . $title;
		break;
	case 'all_left':
		$container_classes[] = 'content-left';
		break;
	case 'all_right':
		$container_classes[] = 'content-right';
		break;
	default:
		$container_classes[] = 'title-left';
}

// Parallax settings.
$data_attr      = array();
$parallax_speed = $config->get( 'fancy_header.parallax.speed' );
if ( $parallax_speed && 'parallax' === $config->get( 'fancy_header.bg.fixed' ) ) {
	$container_classes[] = 'fancy-parallax-bg';
	$data_attr[]         = 'data-prlx-speed="' . $parallax_speed . '"';
}
?>
<header id="fancy-header" class="<?php echo esc_attr( implode( ' ', $container_classes ) ) ?>" <?php echo implode( ' ', $data_attr ) ?>>
    <div class="wf-wrap"><?php echo $content ?></div>

	<?php if ( $config->get_bool( 'fancy_header.bg.overlay' ) ): ?>
        <span class="fancy-header-overlay"></span>
	<?php endif ?>

</header>