<?php
/**
 * Attachment template.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

global $post;

$config = presscore_config();
$config->set( 'template', 'image' );

get_header();
?>

			<!-- Content -->
			<div id="content" class="content" role="main">

				<?php if ( have_posts() ) : ?>

					<?php
					while ( have_posts() ) :
						the_post();
						?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php do_action( 'presscore_before_post_content' ); ?>

							<?php
							$img_meta = wp_get_attachment_image_src( $post->ID, 'full' );
							$img_args = array(
								'img_meta' => $img_meta,
								'img_id'   => $post->ID,
								'custom'   => 'data-dt-img-description="' . esc_attr( get_the_excerpt() ) . '"',
								'class'    => 'alignnone rollover rollover-zoom dt-pswp-item',
								'title'    => get_the_title(),
								'wrap'     => '<a %HREF% %CLASS% %CUSTOM% %TITLE%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /></a>',
							);

							if ( isset( $img_meta[1] ) && $img_meta[1] < 890 ) {
								$img_args['wrap']      = "\n" . '<img %IMG_CLASS% %SRC% %SIZE% %ALT%/>' . "\n";
								$img_args['class']     = '';
								$img_args['img_class'] = 'alignleft';
								$img_args['custom']    = '';
							}

							dt_get_thumb_img( $img_args );

							the_content();

							the7_display_post_share_buttons( 'photo' );
							?>

						</article>

						<?php do_action( 'presscore_after_post_content' ); ?>

					<?php endwhile ?>

				<?php endif ?>

			</div><!-- #content -->

			<?php do_action( 'presscore_after_content' ); ?>

<?php get_footer(); ?>
