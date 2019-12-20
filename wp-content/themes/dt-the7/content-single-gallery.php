<?php
/**
 * Album single page template.
 *
 * @since  1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'project-post' ); ?>>

	<?php
	do_action( 'presscore_before_post_content' );

	switch ( presscore_config()->get( 'post.media.type' ) ) {
		case 'photo_scroller':
			break;
		case 'jgrid':
		case 'masonry_grid':
			presscore_get_template_part( 'mod_albums', 'albums-post-single-media' );
			break;
		default:
			echo '<div class="project-slider">';
			presscore_get_template_part( 'mod_albums', 'albums-post-single-media' );
			echo '</div>';
	}

	if ( get_the_content() ) {
		echo '<div class="project-content">';
		the_content();
		echo '</div>';
	}

	$post_meta = presscore_get_single_posted_on();
	if ( $post_meta ) {
		echo '<div class="post-meta wf-mobile-collapsed">' . $post_meta . '</div>';
	}

	echo presscore_new_post_navigation(
		array(
			'prev_src_text'      => __( 'Previous album:', 'the7mk2' ),
			'next_src_text'      => __( 'Next album:', 'the7mk2' ),
			'taxonomy'           => 'dt_gallery_category',
			'screen_reader_text' => __( 'Album navigation', 'the7mk2' ),
		)
	);

	do_action( 'presscore_after_post_content' );
	?>

</article>
