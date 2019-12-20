<?php
/**
 * Photos scroller shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Photos_Scroller', false ) ) {

	class DT_Shortcode_Photos_Scroller extends DT_Shortcode {

		protected $shortcode_name = 'dt_small_photos';
		protected $post_type = 'dt_gallery';
		protected $taxonomy = 'dt_gallery_category';
		protected $atts = array();
		protected $config = null;

		public function __construct() {
			$this->config = presscore_get_config();
		}

		public function shortcode( $atts, $content = null ) {
			$attributes = $this->atts = $this->sanitize_attributes( $atts );

			// vc inline dummy
			if ( presscore_vc_is_inline() ) {
			    return $this->vc_inline_dummy( array(
	                'class'  => 'dt_vc-photos_scroller',
	                'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_photo_carousel_editor_ico.gif', 131, 104 ),
	                'title'  => _x( 'Photos Scroller', 'vc inline dummy', 'dt-the7-core' ),

	                'style' => array( 'height' => 'auto' )
	            ) );
			}

			$output = '';

			$dt_query = $this->get_albums_attachments( array(
				'orderby' => $attributes['orderby'],
				'order' => 'DESC',
				'number' => $attributes['number'],
				'select' => $attributes['select'],
				'category' => $attributes['category']
			) );

			if ( $dt_query->have_posts() ) {

				$this->backup_post_object();
				$this->backup_theme_config();
				$this->setup_config();
				$this->add_hooks();

				ob_start();

				// loop
				while( $dt_query->have_posts() ) { $dt_query->the_post();

					presscore_get_template_part( 'mod_albums', 'photo-masonry/photo' );
				}

				$posts_html = ob_get_contents();
				ob_end_clean();

				// shape output
				$output = '<div ' . $this->get_container_html_class( array( 'dt-photos-shortcode', 'slider-wrapper owl-carousel dt-owl-carousel-init ', 'shortcode-instagram', 'dt-gallery-container' ) ) . ' ' . $this->get_container_data_atts() . presscore_get_share_buttons_for_prettyphoto( 'photo' ) . '>';
				$output .=  $posts_html ;
				// if ( $attributes['arrows'] ) {
				// 	$output .= '<div class="prev"><i></i></div><div class="next"><i></i></div>';
				// }
				$output .= '</div>';

				// cleanup
				$this->remove_hooks();
				$this->restore_theme_config();
				$this->restore_post_object();

			}

			return $output;
		}

		public function set_image_dimensions( $args ) {
			$args['options'] = array( 'w' => $this->atts['width'], 'h' => $this->atts['height'] );
			$args['prop'] = false;
			return $args;
		}

		protected function get_albums_attachments( $args = array() ) {
			$defaults = array(
				'orderby' => 'date',
				'order' => 'DESC',
				'number' => false,
				'category' => array(),
				'select' => 'all'
			);

			$args = wp_parse_args( $args, $defaults );

			$page_query = $this->get_posts_by_terms( $args );

			$media_items = array(0);
			if ( $page_query->have_posts() ) {
				$media_items = array();
				foreach ( $page_query->posts as $gallery ) {
					$gallery_media = get_post_meta( $gallery->ID, '_dt_album_media_items', true );
					if ( is_array( $gallery_media ) ) {
						$media_items = array_merge( $media_items, $gallery_media );
					}
				}
			}

			$media_items = array_unique( $media_items );

			$media_args = array(
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'post_status' => 'inherit',
				'post__in' => $media_items,
				'orderby' => 'post__in',
				'suppress_filters'  => false,
			);

			if ( $args['number'] ) {
				$media_args['posts_per_page'] = intval( $args['number'] );
			}

			return new WP_Query( $media_args );
		}

		protected function sanitize_attributes( &$atts ) {
			$default_atts = array(
				'category' => '',
				'padding' => '20',
				'show_title' => '',
				'show_excerpt' => '',
				'number' => '12',
				'orderby' => 'recent',
				'autoslide' => '3000',
				'loop' => '',
				'arrows' => 'light',
				'arrows_on_mobile' => 'on',
				'width' => '0',
				'max_width' => '',
				'height' => '210',
			);

			$attributes = shortcode_atts( $default_atts, $atts, $this->shortcode_name );

			// sanitize attributes
			$attributes['orderby'] = ( 'recent' == $attributes['orderby'] ? 'date' : 'rand' );
			$attributes['number'] = apply_filters('dt_sanitize_posts_per_page', $attributes['number']);

			$attributes['show_title'] = apply_filters('dt_sanitize_flag', $attributes['show_title']);
			$attributes['show_excerpt'] = apply_filters('dt_sanitize_flag', $attributes['show_excerpt']);
			$attributes['loop'] = apply_filters('dt_sanitize_flag', $attributes['loop']);
			$attributes['arrows_on_mobile'] = apply_filters('dt_sanitize_flag', $attributes['arrows_on_mobile']);

			$attributes['arrows'] = sanitize_key( $attributes['arrows'] );

			$attributes['max_width'] = absint($attributes['max_width']);
			$attributes['width'] = absint($attributes['width']);
			$attributes['height'] = absint($attributes['height']);

			$attributes['padding'] = absint($attributes['padding']);
			$attributes['autoslide'] = absint($attributes['autoslide']);

			if ( $attributes['category'] ) {
				$attributes['category'] = presscore_sanitize_explode_string( $attributes['category'] );
				$attributes['select'] = 'only';
			} else {
				$attributes['select'] = 'all';
			}

			return $attributes;
		}

		protected function setup_config() {
			$config = &$this->config;
			$attributes = &$this->atts;

			$config->set( 'template', 'media' );
			$config->set( 'layout', 'grid' );
			$config->set( 'load_style', 'default' );
			$config->set( 'image_layout', 'original' );
			$config->set( 'justified_grid', false );
			$config->set( 'thumb_proportions', false );
			$config->set( 'template.columns.number', false );
			$config->set( 'post.preview.load.effect', false );

			$config->set( 'item_padding', $attributes['padding'] );
			$config->set( 'show_excerpts', $attributes['show_excerpt'] );
			$config->set( 'show_titles', $attributes['show_title'] );

			$content_visible = $attributes['show_title'] || $attributes['show_excerpt'];

			$config->set( 'post.preview.content.visible', $content_visible );
			$config->set( 'post.preview.description.style', ( $content_visible ? 'on_hoover_centered' : 'disabled' ) );
			$config->set( 'post.preview.width.min', $attributes['width'] );

			$config->set( 'is_scroller', true );
		}

		protected function get_container_html_class( $class = array() ) {
			$attributes = &$this->atts;

			switch ( $attributes['arrows'] ) {
				case 'light':
					$class[] = 'arrows-light';
					break;
				case 'dark':
					$class[] = 'arrows-dark';
					break;
				case 'rectangular_accent':
					$class[] = 'arrows-accent';
					break;
			}

			if ( 'disabled' !== $attributes['arrows'] && $attributes['arrows_on_mobile'] ) {
				$class[] = 'enable-mobile-arrows';
			}

			$html_class = presscore_masonry_container_class( $class );
			$html_class = str_replace( array( ' iso-grid', 'iso-grid ', ' loading-effect-fade-in', 'loading-effect-fade-in ' ), '', $html_class );

			return $html_class;
		}

		protected function get_container_data_atts() {
			$data_atts = array(
				'padding-side' => $this->atts['padding'],
				'autoslide' => $this->atts['autoslide'] ? 'true' : 'false',
				'delay' => $this->atts['autoslide'],
				'loop' => $this->atts['loop'] ? 'true' : 'false',
			);

			if ( $this->atts['max_width'] ) {
				$data_atts['max-width'] = $this->atts['max_width'];
			}
			if (  $this->atts['arrows'] ) {
				$data_atts['arrows'] = $this->atts['arrows'] ? 'true' : 'false';
			}

			return presscore_get_inlide_data_attr( $data_atts );
		}

		protected function add_hooks() {
			add_filter( 'dt_get_thumb_img-args', array( &$this, 'set_image_dimensions' ) );
		}

		protected function remove_hooks() {
			remove_filter( 'dt_get_thumb_img-args', array( &$this, 'set_image_dimensions' ) );
		}

	}

	add_shortcode( 'dt_small_photos', array( new DT_Shortcode_Photos_Scroller(), 'shortcode' ) );
}
