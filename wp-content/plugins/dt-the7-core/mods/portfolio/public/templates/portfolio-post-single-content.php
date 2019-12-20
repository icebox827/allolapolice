<?php
/**
 * Portfolio project single post template
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

ob_start();
include 'portfolio-post-single-media.php';
$media_content = ob_get_contents();
ob_end_clean();

$config = presscore_config();
switch( $config->get( 'post.media.layout' ) ) {

	case 'before':

		if ( $media_content ) {

			echo '<div class="project-slider">';
				echo $media_content;
			echo '</div>';

		}

		echo '<div class="project-content">';
			the_content();
		echo '</div>';

		include 'portfolio-post-single-links.php';
		break;

	case 'after':

		echo '<div class="project-content">';
			the_content();
		echo '</div>';

		if ( $media_content ) {

			echo '<div class="project-slider">';
				echo $media_content;
			echo '</div>';

		}

		include 'portfolio-post-single-links.php';
		break;

	case 'left':

		if ( $media_content ) {

			echo '<div class="project-wide-col left-side project-slider">';
				echo $media_content;
			echo '</div>';

			// floationg content
			$content_container_class = '';
			if ( $config->get( 'post.content.floating.enabled' ) ) {
				$content_container_class = ' floating-content';
			}

			echo '<div class="project-narrow-col project-content' . $content_container_class . '">';
				the_content();
			echo '</div>';

		} else {

			echo '<div class="project-content">';
				the_content();
			echo '</div>';
		}

		include 'portfolio-post-single-links.php';
		break;

	case 'right':


		if ( $media_content ) {

			// floationg content
			$content_container_class = '';
			if ( $config->get( 'post.content.floating.enabled' ) ) {
				$content_container_class = ' floating-content';
			}

			echo '<div class="project-narrow-col project-content' . $content_container_class . '">';
				the_content();
			echo '</div>';
			echo '<div class="project-wide-col right-side project-slider">';
				echo $media_content;
			echo '</div>';

		} else {

			echo '<div class="project-content">';
				the_content();
			echo '</div>';

		}

		include 'portfolio-post-single-links.php';
		break;

	default:

		echo '<div class="project-content">';
			the_content();
		echo '</div>';
		include 'portfolio-post-single-links.php';
		break;

}
