<?php
/**
 * Project single media content part
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$config = Presscore_Config::get_instance();

if ( 'disabled' != $config->get( 'post.media.layout' ) ) {

	// get media
	$media_items = $config->get( 'post.media.library' );

	if ( !$media_items ) $media_items = array();

	// if we have post thumbnail and it's not hidden
	if ( has_post_thumbnail() && $config->get( 'post.media.featured_image.enabled' ) ) {
		array_unshift( $media_items, absint( get_post_thumbnail_id() ) );
	}

	$open_thumbnail_in_lightbox = $config->get( 'post.media.lightbox.enabled' );
	$media_type = $config->get( 'post.media.type' );
	$attachments_data = presscore_get_attachment_post_data( $media_items );
	$attachments_count = count( $attachments_data );
	$wrap_media = true;

	if ( $attachments_count > 1 && 'gallery' == $media_type ) {

		$gallery_columns = absint( $config->get( 'post.media.gallery.columns' ) );
		$gallery_columns = $gallery_columns ? $gallery_columns : 4;

		$media_html = presscore_get_images_gallery_1( $attachments_data, array(
			'columns' => $gallery_columns,
			'first_big' => $config->get( 'post.media.gallery.first_iamge_is_large' )
		) );

	} elseif ( $attachments_count > 1 && 'slideshow' == $media_type ) {

		// slideshow dimensions
		$slider_proportions = $config->get( 'post.media.slider.proportion' );
		if ( !is_array( $slider_proportions ) ) {
			$slider_proportions = array( 'width' => '', 'height' => '' );
		}
		$slider_proportions = wp_parse_args( $slider_proportions, array( 'width' => '', 'height' => '' ) );

		// Scale mode.
		$scale_mode = $config->get( 'post.media.slider.scale_mode' );
		$scale_mode = ( 'fit' === $scale_mode ? 'fit' : 'fill' );

		$media_html = presscore_get_photo_slider( $attachments_data, array(
			'class' 	=> array('slider-post  owl-carousel dt-owl-carousel-init slider-simple'),
			'width' 	=> absint( $slider_proportions['width'] ),
			'height'	=> absint( $slider_proportions['height'] ),
			'style'		=> ' style="width: 100%;" data-img-mode="' . $scale_mode . '"',
		) );

		// Do not wrap.
		$wrap_media = false;

	} elseif ( 'list' == $media_type ) {

		$media_html = presscore_get_images_list( $attachments_data, array(
			'open_in_lightbox' => $open_thumbnail_in_lightbox
		) );

	} else {
		$media_html = '';
		$attachment_data = current( $attachments_data );

		if ( ! empty( $attachment_data['ID'] ) ) {
			$class = array();
			$thumb_meta = wp_get_attachment_image_src( $attachment_data['ID'], 'full' );
			$image_args = array(
				'img_meta'     => array(
					$attachment_data['full'],
					$attachment_data['width'],
					$attachment_data['height'],
				),
				'img_id'       => empty( $attachment_data['ID'] ) ? $attachment_data['ID'] : 0,
				'alt'          => $attachment_data['alt'],
				'title'        => $attachment_data['title'],
				'img_class'    => 'preload-me',
				'custom'       => ' data-dt-img-description="' . esc_attr( $attachment_data['description'] ) . '" data-large_image_width="' . $thumb_meta[1] . '" data-large_image_height = "' . $thumb_meta[2] . '"',
				'echo'         => false,
				'lazy_loading' => presscore_lazy_loading_enabled(),
			);

			if ( $open_thumbnail_in_lightbox ) {
				$image_args['wrap'] = '<a %HREF% %CLASS% %CUSTOM%><img %SRC% %IMG_CLASS% %ALT% %IMG_TITLE% %SIZE% /></a>';
			} else {
				$image_args['wrap'] = '<img %IMG_CLASS% %SRC% %IMG_TITLE% %ALT% %SIZE% />';
			}

			// Featured image proportions.
			if ( 'resize' === of_get_option( 'general-portfolio_thumbnail_size' ) ) {
				$prop = of_get_option( 'general-portfolio_thumbnail_proportions' );
				$width = max( absint( $prop['width'] ), 1 );
				$height = max( absint( $prop['height'] ), 1 );

				$image_args['prop'] = $width / $height;
			}

			//$class[] = 'dt-single-mfp-popup';
			$class[] = 'dt-pswp-item';

			// check if image has video
			if ( empty($attachment_data['video_url']) ) {
				$class[] = 'rollover';
				$class[] = 'rollover-zoom';
				$class[] = 'pswp-image';

			} else {
				$class[] = 'video-icon';

				// $blank_image = presscore_get_blank_image();

				$image_args['href'] = $attachment_data['video_url'];
				$image_args['lazy_loading'] = false;
				$class[] = 'pswp-video';

				$image_args['wrap'] = '<div class="rollover-video"><img %SRC% %IMG_CLASS% %ALT% %IMG_TITLE% %SIZE% /><a %HREF% %TITLE% %CLASS% %CUSTOM%></a></div>';
			}

			$image_args['class'] = implode( ' ', $class );

			presscore_remove_lazy_load_attrs();
			$media_html = dt_get_thumb_img( $image_args );
			presscore_add_lazy_load_attrs();
		}
	}

	if ( $media_html && $wrap_media ) {
		$media_html = '<div class="images-container">' . $media_html . '</div>';
	}

	echo $media_html;

}
