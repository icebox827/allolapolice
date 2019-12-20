<?php
/**
 * Masonry blog layout template.
 */

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$rollover_class = the7pt_get_portfolio_rollover_class();
$config = presscore_config();
$target = '';
if($config->get( 'follow_external_link' )){
	$target = $config->get( 'post.buttons.link.target_blank' );
}
?>

<?php if ( ! empty( $post_media ) ) : ?>

<div class="post-thumbnail-wrap <?php echo $rollover_class; ?> ">
	<div class="post-thumbnail">

		<?php
		echo $post_media;
		presscore_get_template_part( 'mod_portfolio_shortcodes', 'portfolio-masonry/tpl-rollover-links', false, array(
			'project_link_icon'  => $project_link_icon,
			'external_link_icon' => $external_link_icon,
			'image_zoom_icon'    => $image_zoom_icon,
			'follow_link'        => $follow_link,
			'target'             => $target,
		) );
		?>

	</div>
</div>

<?php endif; ?>

<div class="post-entry-content">

	<h3 class="entry-title">
		<a href="<?php echo $follow_link; ?>" target="<?php echo $target;?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
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