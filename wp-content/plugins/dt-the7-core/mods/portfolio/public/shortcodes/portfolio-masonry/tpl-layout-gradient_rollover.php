<?php
/**
 * Masonry blog layout template.
 */

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$rollover_class = "";
if ( 1 == presscore_project_preview_buttons_count() ) {
		$rollover_class .= ' rollover-active';
}

$config = presscore_config();
$target = '';
if($config->get( 'follow_external_link' )){
	$target = $config->get( 'post.buttons.link.target_blank' );
}
?>

<div class="post-thumbnail-wrap <?php echo $rollover_class; ?>">
	<div class="post-thumbnail<?php echo ( has_post_thumbnail() ? '' : ' overlay-placeholder' ); ?>">

		<?php echo ( isset( $post_media ) ? $post_media : '' ); ?>
	</div>
</div>

<div class="post-entry-content">
	<div class="post-entry-wrapper">
		<?php
		presscore_get_template_part( 'mod_portfolio_shortcodes', 'portfolio-masonry/tpl-rollover-links', false, array(
			'project_link_icon'  => $project_link_icon,
			'external_link_icon' => $external_link_icon,
			'image_zoom_icon'    => $image_zoom_icon,
			'follow_link'        => $follow_link,
			'target'             => $target,
		) );
		?>

		<h3 class="entry-title">
			<a href="<?php echo  $follow_link; ?>" target="<?php echo $target;?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
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
</div>