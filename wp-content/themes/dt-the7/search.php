<?php
/**
 * Search results page.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$config->set( 'template', 'search' );
$config->set( 'layout', 'masonry' );
$config->set( 'template.layout.type', 'masonry' );

get_header();
?>

	<!-- Content -->
	<div id="content" class="content" role="main">

		<?php
		if ( have_posts() ) {
			the7_search_loop();
		} else {
			get_template_part( 'no-results', 'search' );
		}
		?>

	</div><!-- #content -->

<?php do_action( 'presscore_after_content' ); ?>

<?php get_footer(); ?>
