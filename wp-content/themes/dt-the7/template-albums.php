<?php
/**
 * Template Name: Albums - masonry & grid
 *
 * Media Albums template. Uses dt_gallery post type and dt_gallery_category taxonomy.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$config->set( 'template', 'albums' );
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
					$page_query    = presscore_get_filtered_posts(
						array(
							'post_type' => 'dt_gallery',
							'taxonomy'  => 'dt_gallery_category',
						)
					);

					presscore_display_posts_filter(
						array(
							'post_type' => 'dt_gallery',
							'taxonomy'  => 'dt_gallery_category',
							'query'     => $page_query,
						)
					);

					// Fullwidth wrap open.
					if ( $config->get( 'full_width' ) ) {
						echo '<div class="full-width-wrap">';
					}

					// Masonry container open.
					echo '<div ' . presscore_masonry_container_class(
						array( 'wf-container', 'dt-albums-template' )
					) . presscore_masonry_container_data_atts() . '>';

					if ( $page_query->have_posts() ) {
						add_filter(
							'presscore_get_images_gallery_hoovered-title_img_args',
							'presscore_gallery_post_exclude_featured_image_from_gallery',
							15,
							3
						);

						while ( $page_query->have_posts() ) {
							$page_query->the_post();
							presscore_populate_album_post_config();
							presscore_get_template_part( 'mod_albums', 'album-masonry/album' );
						}
						wp_reset_postdata();

						remove_filter(
							'presscore_get_images_gallery_hoovered-title_img_args',
							'presscore_gallery_post_exclude_featured_image_from_gallery',
							15
						);
					}

					// Masonry container close.
					echo '</div>';

					// Fullwidth wrap close.
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

	<?php
	do_action( 'presscore_after_content' );

endif;

get_footer(); ?>
