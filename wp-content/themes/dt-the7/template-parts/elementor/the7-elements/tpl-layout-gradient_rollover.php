<?php
/**
 * Gradient rollover template.
 *
 * @package The7pt
 */

defined( 'ABSPATH' ) || exit;

$rollover_class = '';
if ( ! empty( $icons_html ) ) {
	$rollover_class = 'rollover-active';
}

$placeholder_class = '';
if ( ! has_post_thumbnail() ) {
	$placeholder_class = 'overlay-placeholder';
}
?>

<div class="post-thumbnail-wrap <?php echo $rollover_class; ?>">
	<div class="post-thumbnail <?php echo $placeholder_class; ?>">

		<?php
		if ( ! empty( $post_media ) ) {
			echo $post_media;
		}
		?>

	</div>
</div>

<div class="post-entry-content">
	<div class="post-entry-wrapper">

		<?php
		if ( ! empty( $icons_html ) ) {
			echo '<div class="project-links-container">' . $icons_html . '</div>';
		}
		?>

		<h3 class="entry-title">
			<a href="<?php echo esc_url( $follow_link ); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>

		<?php
		if ( isset( $post_meta ) ) {
			echo $post_meta;
		}

		if ( isset( $post_excerpt ) ) {
			echo '<div class="entry-excerpt">';
			echo $post_excerpt;
			echo '</div>';
		}

		if ( isset( $details_btn ) ) {
			echo $details_btn;
		}
		?>

	</div>
</div>