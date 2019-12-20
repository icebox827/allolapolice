<?php
/**
 * Masonry blog layout template.
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$show_icon_zoom = '';
?>

<?php if ( ! empty( $post_media ) ) : ?>

<div class="post-thumbnail-wrap">
	<div class="post-thumbnail">
		<?php echo presscore_get_blog_post_fancy_date(); ?>

		<?php
		if ( $config->get( 'post.fancy_category.enabled' ) ) {
			$fancy_category_args = ( isset( $fancy_category_args ) ? $fancy_category_args : array() );
			echo presscore_get_post_fancy_category( $fancy_category_args );
		}
		?>

		<?php echo $post_media; ?>
	</div>
</div>

<?php endif; ?>

<div class="post-entry-content">

	<div class="post-head-wrapper">
		<?php 
		if ( $config->get( 'blog.show_icon') ) {
			$show_icon_zoom = '<span class="gallery-zoom-ico ' . ( $config->get( 'blog.show_icon.html' ) ) . '"><span></span></span>';
		}
		echo $show_icon_zoom ; ?>
		<h3 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>

		<?php echo presscore_get_posted_on(); ?>
	</div>

	<?php
	$post_entry = '';

	if ( $config->get( 'show_excerpts' ) && isset( $post_excerpt ) ) {
		$post_entry .= '<div class="entry-excerpt">';
		$post_entry .= $post_excerpt;
		$post_entry .= '</div>';
	}

	if ( $config->get( 'show_details' ) && isset( $details_btn ) ) {
		$post_entry .= $details_btn;
	}

	if ( $post_entry ) {
		echo '<div class="post-entry-wrapper">' . $post_entry . '</div>';
	}
	?>

</div>