<?php
/**
 * Template Name: Team
 *
 * Team template.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$config->set( 'template', 'team' );

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
					if ( $config->get( 'full_width' ) ) {
						echo '<div class="full-width-wrap">';
					}

					$container_classes = array( 'wf-container' );
					if ( get_post_meta( get_the_ID(), '_dt_team_options_round_images', true ) ) {
						$container_classes[] = 'round-images';
					}

					echo '<div ' . presscore_masonry_container_class(
						$container_classes
					) . presscore_masonry_container_data_atts() . '>';

					$page_query = presscore_get_filtered_posts(
						array(
							'post_type' => 'dt_team',
							'taxonomy'  => 'dt_team_category',
						)
					);
					if ( $page_query->have_posts() ) :
						while ( $page_query->have_posts() ) :
							$page_query->the_post();

							presscore_populate_team_config();

							presscore_get_template_part( 'mod_team', 'team-post' );

						endwhile;
						wp_reset_postdata();
					endif;

					echo '</div>';

					if ( $config->get( 'full_width' ) ) {
						echo '</div>';
					}

					dt_paginator( $page_query );
				}

				do_action( 'presscore_after_loop' );

				the7_display_post_share_buttons( 'page' );

			endwhile;
		endif;
		?>

	</div><!-- #content -->

	<?php
	do_action( 'presscore_after_content' );

endif;

get_footer(); ?>
