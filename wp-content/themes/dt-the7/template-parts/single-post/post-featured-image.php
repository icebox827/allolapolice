<?php
global $post;

$show_thumbnail = ! get_post_meta( $post->ID, '_dt_post_options_hide_thumbnail', true );
if ( $show_thumbnail && has_post_thumbnail() ) {
	$thumbnail_id = get_post_thumbnail_id();
	$video_url    = presscore_get_image_video_url( $thumbnail_id );
	if ( $video_url ) {
		$post_media_html = '<div class="post-video alignnone">' . dt_get_embed( $video_url ) . '</div>';
	} else {
		$thumb_args = array(
			'class'  => 'alignnone',
			'img_id' => $thumbnail_id,
			'wrap'   => '<img %IMG_CLASS% %SRC% %SIZE% %IMG_TITLE% %ALT% />',
			'echo'   => false,
		);

		// Thumbnail proportions.
		if ( 'resize' === of_get_option( 'blog-thumbnail_size' ) ) {
			$prop   = of_get_option( 'blog-thumbnail_proportions' );
			$width  = max( absint( $prop['width'] ), 1 );
			$height = max( absint( $prop['height'] ), 1 );

			$thumb_args['prop'] = $width / $height;
		}

		$post_media_html = presscore_get_blog_post_fancy_date();
		if ( presscore_config()->get_bool( 'post.fancy_category.enabled' ) ) {
			$post_media_html .= presscore_get_post_fancy_category();
		}

		$post_media_html .= dt_get_thumb_img( $thumb_args );
	}

	echo '<div class="post-thumbnail">' . $post_media_html . '</div>';
}

