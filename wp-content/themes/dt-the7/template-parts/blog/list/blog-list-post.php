<?php
/**
 * Blog post template for the list layout.
 */

defined( 'ABSPATH' ) || exit;

// Remove presscore_the_excerpt() filter.
remove_filter( 'presscore_post_details_link', 'presscore_return_empty_string', 15 );

$config = presscore_config();

$article_content_layout = presscore_get_template_image_layout( $config->get( 'layout' ), $config->get( 'post.query.var.current_post' ) );
$post_class = array(
	'post',
	"project-{$article_content_layout}",
);

if ( ! has_post_thumbnail() ) {
	$post_class[] = 'no-img';
}
?>

<?php do_action( 'presscore_before_post' ); ?>

	<article <?php post_class( $post_class ); ?>>

		<?php
		if ( 'wide' === $config->get( 'post.preview.width' ) ) {
			$article_content_layout = 'odd';
		}

		presscore_get_template_part( 'theme', 'blog/list/blog-list-post-inner', $article_content_layout );
		?>

	</article>

<?php do_action( 'presscore_after_post' ); ?>