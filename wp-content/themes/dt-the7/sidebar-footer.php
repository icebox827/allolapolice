<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

$footer_sidebar = presscore_validate_footer_sidebar( presscore_config()->get( 'footer_widgetarea_id' ) );

$show_sidebar    = presscore_config()->get( 'footer_show' ) && is_active_sidebar( $footer_sidebar );
$show_bottom_bar = apply_filters( 'presscore_show_bottom_bar', presscore_config()->get( 'template.bottom_bar.enabled' ) );
$replace_footer = apply_filters( 'presscore_replace_footer', false ) ;
if ( $show_sidebar || $show_bottom_bar || $replace_footer ) : ?>

	<!-- !Footer -->
	<footer id="footer" <?php echo presscore_footer_html_class( 'footer' ); ?>>

		<?php
		if ( $show_sidebar || $replace_footer ) :
			$sidebar_layout = presscore_get_sidebar_layout_parser( presscore_config()->get( 'template.footer.layout' ) );
			$sidebar_layout->add_sidebar_columns();
			?>

			<div class="wf-wrap">
				<div class="wf-container-footer">
					<div class="wf-container">
						<?php
						do_action( 'presscore_before_footer_widgets' );
                        if (!$replace_footer){
	                        dynamic_sidebar( $footer_sidebar );
                        }
						?>
					</div><!-- .wf-container -->
				</div><!-- .wf-container-footer -->
			</div><!-- .wf-wrap -->

			<?php
			$sidebar_layout->remove_sidebar_columns();
		endif;

		if ( $show_bottom_bar ) {
			presscore_get_template_part( 'theme', 'footer/bottom-bar' );
		}
		?>

	</footer><!-- #footer -->

<?php endif ?>
