<?php
/**
 * Masonry blog layout template.
 */

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = presscore_config();
$target = '';
if($config->get( 'follow_external_link' )){
	$target = $config->get( 'post.buttons.link.target_blank' );
}
$image = isset( $image ) ? $image : '';
$mini_images = isset( $mini_images ) ? $mini_images : '';
?>

<div class="post-thumbnail-wrap">
	<figure class="post-thumbnail<?php echo ( $image ? '' : ' overlay-placeholder' ); ?>">
		<?php echo $image; ?>
	</figure>
</div>

<div class="post-entry-content">
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


		echo $rollover_icons;
		?>
		<?php 
			$title_class = '';
			if ( 'lightbox' == $config->get( 'post.open_as' ) ) {
				$title_class = 'dt-trigger-first-pswp';
			}
		?>


	<!-- <div class="post-head-wrapper"> -->

		<h3 class="entry-title">
			<a href="<?php echo get_permalink(); ?>"  class="<?php echo $title_class; ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>

		<?php echo presscore_get_posted_on(); ?>
	<!-- </div> -->

	<?php
	$post_entry = '';

	if ( $config->get( 'show_excerpts' ) && isset( $post_excerpt ) ) {
		$post_entry .= '<div class="entry-excerpt">';
		$post_entry .= $post_excerpt;
		$post_entry .= '</div>';
	}

	if ( $config->get( 'show_read_more' ) && isset( $details_btn ) ) {
		$post_entry .= $details_btn;
	}

	if ( $post_entry ) {
		echo $post_entry ;
	}
	?>

</div>