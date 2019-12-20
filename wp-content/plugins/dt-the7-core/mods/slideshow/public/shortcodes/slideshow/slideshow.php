<?php
/**
 * Slideshow shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Shortcode slideshow class.
 *
 */
class DT_Shortcode_Slideshow extends DT_Shortcode {

	protected $shortcode_name = 'dt_slideshow';
	protected $plugin_name = 'dt_mce_plugin_shortcode_slideshow';

	public function shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'posts'     => '',
			'width'     => '800',
			'height'    => '450',
			'scale_mode' => 'fill',
			'autoplay'  => 'false',
			'interval'  => '5000',
		), $atts, $this->shortcode_name ) );

		// sanitize attributes
		$width = absint( $width );
		$height = absint( $height );
		$scale_mode = ( 'fit' === $scale_mode ? 'fit' : 'fill' );
		$interval = absint( $interval );
		$autoplay = apply_filters( 'dt_sanitize_flag', $autoplay );

		$posts = array_map( 'trim', explode(',', $posts) );

		$attachments_id = array();
		$selected_posts_titles = array();

		if ( presscore_vc_is_inline() ) {
		    return $this->vc_inline_dummy( array(
                'class'  => 'dt_slideshow',
                'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_slideshow_editor_ico.gif', 98, 104 ),
                'title'  => _x( 'Slideshow', 'vc inline dummy', 'dt-the7-core' ),

                'style' => array( 'height' => 'auto' )
            ) );
		}

		if ( $posts ) {
			// get posts by slug
			foreach ( $posts as $post_slug ) { 
				$args = array(
					'no_found_rows'         => 1,
					'ignore_sticky_posts'   => 1,
					'posts_per_page'        => 1,
					'post_type'             => 'dt_slideshow',
					'post_status'           => 'publish',
					'name'                  => $post_slug,
					'suppress_filters'      => false,
				);

				$dt_query = new WP_Query( $args );
				if ( $dt_query->have_posts() ) {
					$dt_post = $dt_query->posts[0];

					$selected_posts_titles[] = get_the_title( $dt_post );

					$slides_id = get_post_meta( $dt_post->ID, '_dt_slider_media_items', true );
					if ( $slides_id ) {
						$attachments_id = array_merge( $attachments_id, $slides_id );
					}
				}
			}
		// get fresh one
		} else {
			$args = array(
				'no_found_rows' => 1,
				'ignore_sticky_posts' => 1,
				'posts_per_page' => 1,
				'post_type' => 'dt_slideshow',
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'DESC',
				'suppress_filters' => false,
			);

			$dt_query = new WP_Query( $args );
			if ( $dt_query->have_posts() ) {
				$dt_post = $dt_query->posts[0];

				$selected_posts_titles[] = get_the_title( $dt_post );

				$slides_id = get_post_meta( $dt_post->ID, '_dt_slider_media_items', true );
				if ( $slides_id ) {
					$attachments_id = array_merge( $attachments_id, $slides_id );
				}
			}
		}

		if ( function_exists('vc_is_inline') && vc_is_inline() ) {

			if ( empty($selected_posts_titles) ) {
				$dummy_posts_titles = __( 'No posts selected', 'dt-the7-core' );

			} else {
				$dummy_posts_titles = esc_html( join( ', ', $selected_posts_titles ) );

			}

			$output = '
				<div class="dt_vc-shortcode_dummy dt_vc-royal_slider" style="height: 250px;">
					<h5>Slideshow</h4>
					<p class="text-small"><strong>Display slider(s):</strong> ' . $dummy_posts_titles . '</p>
				</div>
			';

		} else {

			$attachments_data = presscore_get_attachment_post_data( $attachments_id );
			$output = presscore_get_photo_slider( $attachments_data, array(
				'width'     => $width,
				'height'    => $height,
				'autoplay'  => $autoplay,
				'interval'  => $interval,
				'class'     => array( 'slider-simple', 'shortcode-photo-slider',
				'owl-carousel', 'dt-owl-carousel-init' ),
				'style'     => ' style="width: 100%" data-img-mode="' . esc_attr( $scale_mode ) . '"',
			) );

		}

		return $output; 
	}

}

add_shortcode( 'dt_slideshow', array( new DT_Shortcode_Slideshow(), 'shortcode' ) );
