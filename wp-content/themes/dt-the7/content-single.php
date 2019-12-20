<?php
/**
 * Single post content template.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

global $post;

$config = presscore_config();

$post_classes = array();
if ( $config->get_bool( 'post.fancy_date.enabled' ) ) {
	$post_classes[] = presscore_blog_fancy_date_class();
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>

	<?php
	do_action( 'presscore_before_post_content' );

	// Post featured image.
	presscore_get_template_part( 'theme', 'single-post/post-featured-image' );

	// Post content.
	echo '<div class="entry-content">';
	the_content();
	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'the7mk2' ),
			'after'  => '</div>',
		)
	);
	echo '</div>';

	// Post meta.
	$post_meta = presscore_get_single_posted_on();
	if ( $config->get( 'post.meta.fields.tags' ) ) {
		$post_meta .= presscore_get_post_tags_html();
	}

	if ( $post_meta ) {
		echo '<div class="post-meta wf-mobile-collapsed">' . $post_meta . '</div>';
	}

	the7_display_post_share_buttons( 'post' );

	if ( $config->get( 'post.author_block' ) ) {
		presscore_display_post_author();
	}

	echo presscore_new_post_navigation();

	presscore_display_related_posts();

	do_action( 'presscore_after_post_content' );
	?>

</article>
