<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config         = presscore_config();
$rollover_icons = '';
$span_tpl       = '<span class="%s"></span>';
if ( $config->get( 'show_links' ) ) {
	$project_link = presscore_get_project_link( 'project-link', sprintf( $span_tpl, $external_link_icon ) );
	if ( $project_link ) {
		$rollover_icons = $project_link;
	}
}
$rollover_icons .= presscore_get_project_rollover_zoom_icon( array(
	'popup'         => 'single',
	'attachment_id' => get_post_thumbnail_id(),
	'text'          => sprintf( $span_tpl, $image_zoom_icon ),
) );
if ( $config->get( 'show_details' ) ) {
	$rollover_icons .= '<a href=" ' . $follow_link . '" target="' . $target . '" class="project-details" aria-label="' . esc_attr__( 'Details link', 'dt-the7-core' ) . '">' . sprintf( $span_tpl, $project_link_icon ) . '</a>';
}
if ( $rollover_icons ) {
	echo '<div class="project-links-container">' . $rollover_icons . '</div>';
}