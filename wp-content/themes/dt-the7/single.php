<?php
/**
 * The Template for displaying all single posts.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

get_header( 'single' );
?>

<?php
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'header-main' );

		if ( presscore_is_content_visible() ) {
			do_action( 'presscore_before_loop' );
			?>

			<div id="content" class="content" role="main">

				<?php if ( post_password_required() ) { ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php
						do_action( 'presscore_before_post_content' );
						the_content();
						do_action( 'presscore_after_post_content' );
						?>

					</article>

					<?php
				} else {
					get_template_part( 'content-single', str_replace( 'dt_', '', get_post_type() ) );
				}

				comments_template( '', true );
				?>

			</div><!-- #content -->

			<?php
			do_action( 'presscore_after_content' );
		}
	}
}

get_footer();
?>
