<?php
/**
 * Post microsite template.
 */
?>

<?php
$post_classes = array( 'content' );
if ( presscore_config()->get_bool( 'post.fancy_date.enabled' ) ) {
	$post_classes[] = presscore_blog_fancy_date_class();
}
?>
<div id="content" role="main" <?php post_class( $post_classes ) ?>>

	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			presscore_get_template_part( 'theme', 'single-post/post-featured-image' );
			do_action( 'presscore_before_loop' );
			the_content();
			the7_display_post_share_buttons( 'post' );
			comments_template( '', true );
		}
	} else {
		get_template_part( 'no-results', 'microsite' );
	}
	?>

</div><!-- #content -->

<?php do_action( 'presscore_after_content' ); ?>
