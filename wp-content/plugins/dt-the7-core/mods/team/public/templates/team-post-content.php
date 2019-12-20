<?php
/**
 * Team post content template
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$config = Presscore_Config::get_instance();

//////////////////
// Get position //
//////////////////

$position = $config->get( 'post.member.position' );
if ( $position ) {
	$position = '<p>' . $position . '</p>';

} else {
	$position = '';

}

///////////////
// Get title //
///////////////

$title = get_the_title();
if ( $title ) {
	if('post' == $config->get( 'post.open_as' )  ){
		$title = '<div class="team-author-name"><a href=" '.get_permalink().' ">' . $title . '</a></div>';
	}else{
		$title = '<div class="team-author-name">' . $title . '</div>';
	}

} else {
	$title = '';

}

//////////////////////////
// Output author block  //
//////////////////////////

$author_block = $title . $position;
if ( $author_block ) {
	echo '<div class="team-author">' . $author_block . '</div>';
}

////////////////////
// Output content //
////////////////////

if ( $config->get( 'show_excerpts' ) ) {
	$content = apply_filters( 'the_excerpt', get_the_excerpt() );

	if ( $content ) {
		echo '<div class="team-content">' . $content . '</div>';
	}
}

///////////////
// Get links //
///////////////

$clear_links = array();
$links = $config->get( 'post.preview.links' );
if ( function_exists('presscore_get_team_links_array') ) {

	foreach ( presscore_get_team_links_array() as $id=>$data ) {

		if ( array_key_exists( $id , $links ) ) {
			$clear_links[] = presscore_get_social_icon( $id, $links[ $id ], $data['desc'] );
		}
	}

}

//////////////////
// Output links //
//////////////////

if ( !empty( $clear_links ) ) {
	echo '<div class="soc-ico">' . implode( '', $clear_links ) . '</div>';
}

///////////////
// Edit link //
///////////////

echo presscore_post_edit_link();
