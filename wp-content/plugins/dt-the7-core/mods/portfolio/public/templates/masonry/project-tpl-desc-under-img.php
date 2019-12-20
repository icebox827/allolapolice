<?php
/**
 * Project template with description under image.
 *
 * @package the7\Portfolio\Templates
 * @since 3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$image = $rollover_content = $rollover_class = '';

// media
switch ( presscore_config()->get( 'post.preview.media.style' ) ) {
	case 'featured_image':
		$image_id = has_post_thumbnail() ? get_post_thumbnail_id() : 0;

		$link_class = 'alignnone';
		$link_class .= presscore_get_image_video_url( $image_id ) ? ' rollover-video' : ' rollover';

		$image = presscore_project_get_thumbnail_img( $image_id, $link_class );

		// rollover icons
		$rollover_content = presscore_project_get_preview_buttons( $image_id );
		$rollover_class = the7pt_get_portfolio_rollover_class();
		break;
	case 'slideshow':
		$image = presscore_get_project_media_slider( array( 'alignnone','owl-carousel', 'dt-owl-carousel-init', 'slider-masonry' ) );
		break;
}

// content
$content = presscore_project_get_preview_content();

$template_args = array(
	'image'				=> $image,
	'content'			=> $content,
	'rollover_content'	=> $rollover_content,
	'figure_class'		=> $rollover_class,
);

// description under image template
presscore_get_template_part( 'theme', 'post-layouts/description-under-image-odd', null, $template_args );
