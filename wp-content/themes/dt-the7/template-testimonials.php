<?php
/**
 * Template Name: Testimonials
 *
 * Testimonials template.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$config->set( 'template', 'testimonials' );
$config->set( 'template.layout.type', 'masonry' );

add_action( 'presscore_before_main_container', 'presscore_page_content_controller', 15 );

get_header();

if ( presscore_is_content_visible() ) : ?>

	<!-- Content -->
	<div id="content" class="content" role="main">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();

				do_action( 'presscore_before_loop' );

				if ( post_password_required() ) {
					the_content();
				} else {
					$config_backup = $config->get();

					if ( $config->get( 'full_width' ) ) {
						echo '<div class="full-width-wrap">';
					}

					echo '<div ' . presscore_masonry_container_class(
						array( 'wf-container' )
					) . presscore_masonry_container_data_atts() . '>';

					$page_query = presscore_get_filtered_posts(
						array(
							'post_type' => 'dt_testimonials',
							'taxonomy'  => 'dt_testimonials_category',
						)
					);

					if ( $page_query->have_posts() ) :
						while ( $page_query->have_posts() ) :
							$page_query->the_post();

							get_template_part( 'content', 'testimonials' );

						endwhile;
						wp_reset_postdata();
					endif;

					echo '</div>';

					if ( $config->get( 'full_width' ) ) {
						echo '</div>';
					}

					presscore_complex_pagination( $page_query );

					$config->reset( $config_backup );
				}

				do_action( 'presscore_after_loop' );

				the7_display_post_share_buttons( 'page' );

			endwhile;
		endif;
		?>

	</div><!-- #content -->

	<?php do_action( 'presscore_after_content' );

endif;

get_footer(); ?>
