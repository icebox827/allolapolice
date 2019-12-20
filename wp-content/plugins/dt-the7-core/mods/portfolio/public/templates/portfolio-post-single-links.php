<?php
/**
 * Portfolio project single links content part
 */

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) { exit; }

wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dt-the7-core' ), 'after' => '</div>', 'echo' => false ) );

$config = presscore_config();
$project_link = '';
if ( (string) $config->get( 'post.buttons.link.enabled' ) === '1' ) {
	$title = $config->get( 'post.buttons.link.title' );
	if ( ! $title ) {
		$title = __( 'Link', 'dt-the7-core' );
	}

	$project_link = presscore_get_button_html(
		array(
			'title'  => '<i class="icomoon-the7-font-the7-link-02" aria-hidden="true"></i>&nbsp;' . $title,
			'href'   => $config->get( 'post.buttons.link.url' ),
			'target' => $config->get( 'post.buttons.link.target_blank' ),
			'class'  => 'btn-project-link',
		)
	);
}
$post_meta = presscore_get_single_posted_on();
if ( $project_link || $post_meta ) {
	echo '<div class="project-info-box">' . $project_link . $post_meta . '</div>';
}

if ( function_exists( 'the7_display_post_share_buttons' ) ) {
	the7_display_post_share_buttons( 'portfolio_post' );
}

echo presscore_new_post_navigation( array(
	'prev_src_text'      => __( 'Previous project:', 'dt-the7-core' ),
	'next_src_text'      => __( 'Next project:', 'dt-the7-core' ),
	'taxonomy'           => 'dt_portfolio_category',
	'screen_reader_text' => __( 'Project navigation', 'dt-the7-core' ),
) );
