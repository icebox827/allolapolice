<?php
/**
 * Page microsite template.
 */
?>

<div id="content" class="content" role="main">

	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			do_action( 'presscore_before_loop' );
			the_content();
			the7_display_post_share_buttons( 'page' );
			comments_template( '', true );
		}
	} else {
		get_template_part( 'no-results', 'microsite' );
	}
	?>

</div><!-- #content -->

<?php do_action( 'presscore_after_content' ); ?>
