<?php
/**
 * Team single post template.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	do_action( 'presscore_before_post_content' );

	the_content();

	do_action( 'presscore_after_post_content' );
	?>

</article>
