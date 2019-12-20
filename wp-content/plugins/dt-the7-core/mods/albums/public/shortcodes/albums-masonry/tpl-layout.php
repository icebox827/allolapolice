<?php
/**
 * Masonry albums layout template.
 */

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = presscore_config();
$image = isset( $image ) ? $image : '';
$mini_images = isset( $mini_images ) ? $mini_images : '';
?>

<?php if ( ! empty( $image ) ) : ?>

<div class="post-thumbnail-wrap">
	<figure class="post-thumbnail">

		<?php
		$rollover_icons = '';
		if ( $config->get( 'post.preview.mini_images.enabled' ) == 'image_miniatures' ) {
			if ( $mini_images ) {
				$rollover_icons = '<span class="album-rollover">'.$mini_images.'</span>';
			}
		}
		else if($config->get( 'post.preview.mini_images.enabled' ) == 'icon'){
			
			$rollover_icons = '<span class="album-rollover"><span class="album-zoom-ico ' . esc_attr( $config->get( 'post.preview.icon' ) ) . '"><span></span></span></span>';
		}

		echo $image  . $rollover_icons;
		?>

	</figure>
</div>

<?php endif; ?>

<div class="post-entry-content">

	<?php 
		$title_class = '';
		if ( 'lightbox' == $config->get( 'post.open_as' ) ) {
			$title_class = 'dt-trigger-first-pswp';
		}
	?>

	<h3 class="entry-title">
		<a href="<?php echo get_permalink(); ?>" class="<?php echo $title_class; ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
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
	if ( $config->get( 'show_read_more' ) && isset( $details_btn ) ) {
		echo $details_btn;
	}
	?>

</div>