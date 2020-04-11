<?php
/**
 * The template for displaying all pages.
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$config = presscore_config();
$config->set( 'template', 'page' );

get_header();
?>

<?php if ( presscore_is_content_visible() ) : ?>

	<div id="content" class="content" role="main">

		<?php
		\Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content(); 
		?>

	</div><!-- #content -->

	<?php do_action( 'presscore_after_content' ); ?>

<?php endif; ?>

<?php get_footer(); ?>
