<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @since   1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$config           = presscore_config();
$page_template_id = (int) of_get_option( 'template_page_id_404' );
$style            = '';
if ( $page_template_id ) {
	$config->set( 'post_id', $page_template_id );
	// Turn on UA scripts and styles.
	add_filter( 'ultimate_global_scripts', 'the7__return_enable' );
} else {
	// Some styles for default 404 page layout.
	$style = 'min-height: 500px; text-align:center';
}

get_header();
?>

	<!-- Content -->
	<div id="content" class="content" role="main" style="<?php echo $style; ?>">

		<article id="post-0" class="post error404 not-found">

			<?php
			if ( $config->get( 'post_id' ) ) {
				$template_post = get_post( $config->get( 'post_id' ) );
				if ( $template_post instanceof WP_Post ) {
					if ( class_exists( 'Presscore_Modules_ArchiveExtModule' ) ) {
						Presscore_Modules_ArchiveExtModule::print_vc_inline_css( $template_post->ID );
					}
					// Setup global post to reach shortcodes inline css.
					$GLOBALS['post'] = $template_post;
					setup_postdata( $template_post );
					the_content();
					wp_reset_postdata();
				}
			} else {
				echo '<h1 class="entry-title">' . __( 'Oops! That page can&rsquo;t be found.', 'the7mk2' ) . '</h1>';
				echo '<p>' . __( 'It looks like nothing was found at this location. Try using the search box below:', 'the7mk2' ) . '</p>';
				get_search_form();
			}
			?>

		</article><!-- #post-0 .post .error404 .not-found -->

	</div><!-- #content .site-content -->

<?php do_action( 'presscore_after_content' ); ?>

<?php get_footer(); ?>
