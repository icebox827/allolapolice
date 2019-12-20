<?php
/**
 * Masonry blog layout template.
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$show_icon_zoom = '';
?>

<div class="post-thumbnail-wrap">
	<div class="post-thumbnail<?php echo ( has_post_thumbnail() ? '' : ' overlay-placeholder' ); ?>">
		<?php echo presscore_get_blog_post_fancy_date(); ?>

		<?php
		if ( $config->get( 'post.fancy_category.enabled' ) ) {
			$fancy_category_args = ( isset( $fancy_category_args ) ? $fancy_category_args : array() );
			echo presscore_get_post_fancy_category( $fancy_category_args );
		}
		?>

		<?php echo ( isset( $post_media ) ? $post_media : '' ); ?>
	</div>
</div>

<div class="post-entry-content">
	<div class="post-entry-wrapper">
		<?php 
		if ( $config->get( 'blog.show_icon') ) {
			$show_icon_zoom = '<span class="gallery-zoom-ico ' . ( $config->get( 'blog.show_icon.html' ) ) . '"><span></span></span>';
		}
		echo $show_icon_zoom ; ?>
		<h3 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>

		<?php echo presscore_get_posted_on(); ?>

		<?php
		if ( $config->get( 'show_excerpts' ) && isset( $post_excerpt ) ) {
			echo '<div class="entry-excerpt">';
			echo $post_excerpt;
			echo '</div>';
		}
		?>

		<?php
		if ( $config->get( 'show_details' ) && isset( $details_btn ) ) {
			echo $details_btn;
		}
		?>

	</div>
</div>