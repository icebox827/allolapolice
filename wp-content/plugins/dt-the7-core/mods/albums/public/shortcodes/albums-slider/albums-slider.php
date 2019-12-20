<?php
/**
 * Albums scroller shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Albums_Slider', false ) ) {

	class DT_Shortcode_Albums_Slider extends DT_Shortcode {

		protected $shortcode_name = 'dt_albums_scroller';
		protected $post_type = 'dt_gallery';
		protected $taxonomy = 'dt_gallery_category';
		protected $atts = array();

		public function shortcode( $atts, $content = null ) {
			$this->atts = $this->sanitize_attributes( $atts );

			// vc inline dummy
			if ( presscore_vc_is_inline() ) {
			    return $this->vc_inline_dummy( array(
	                'class'  => 'dt_vc-albums_scroller',
	                'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_album_carousel_editor_ico.gif', 131, 104 ),
	                'title'  => _x( 'Albums Scroller', 'vc inline dummy', 'dt-the7-core' ),

	                'style' => array( 'height' => 'auto' )
	            ) );
			}


			return $this->slider();
		}

		public function slider() {
			$output = '';
			$attributes = &$this->atts;

			// query
			$dt_query = $this->get_posts_by_terms( array(
				'orderby' => $attributes['orderby'],
				'order' => $attributes['order'],
				'number' => $attributes['number'],
				'select' => $attributes['select'],
				'category' => $attributes['category']
			) );
			if ( $dt_query->have_posts() ) {

				// setup
				$this->backup_post_object();
				$this->backup_theme_config();
				$this->setup_config();
				$this->add_hooks();

				ob_start();

				// loop
				while( $dt_query->have_posts() ) { $dt_query->the_post();

					presscore_populate_album_post_config();
					presscore_get_template_part( 'mod_albums', 'album-masonry/album' );
				}

				// store loop html
				$posts_html = ob_get_contents();
				ob_end_clean();

				// shape output
				$output = '<div ' . $this->get_container_html_class( array( 'dt-albums-shortcode', 'slider-wrapper owl-carousel dt-owl-carousel-init' ) ) . ' ' . $this->get_container_data_atts() . '>';
				$output .= $posts_html;
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

		protected function sanitize_attributes( &$atts ) {
			$attributes = shortcode_atts( array(
				'category'                    => '',
				'order'                       => 'desc',
				'orderby'                     => 'date',
				'number'                      => '12',
				'show_title'                  => '',
				'show_excerpt'                => '',
				'show_categories'             => '',
				'show_date'                   => '',
				'show_author'                 => '',
				'show_comments'               => '',
				'show_miniatures'             => '',
				'show_media_count'            => '',
				'padding'                     => '20',
				'descriptions'                => 'under_image',
				'hover_bg_color'              => 'accent',
				'bg_under_albums'             => 'with_paddings',
				'content_aligment'            => 'left',
				'colored_bg_content_aligment' => 'centre',
				'hover_animation'             => 'fade',
				'bgwl_animation_effect'       => '1',
				'hover_content_visibility'    => 'on_hover',
				'autoslide'                   => '3000',
				'loop'                        => '',
				'arrows'                      => 'light',
				'arrows_on_mobile' => 'on',
				'width'                       => '0',
				'max_width'                   => '',
				'height'                      => '210',
			), $atts, $this->shortcode_name );

			// sanitize attributes
			$attributes['order'] = apply_filters('dt_sanitize_order', $attributes['order']);
			$attributes['orderby'] = apply_filters('dt_sanitize_orderby', $attributes['orderby']);
			$attributes['number'] = apply_filters('dt_sanitize_posts_per_page', $attributes['number']);

			$attributes['show_title'] = apply_filters('dt_sanitize_flag', $attributes['show_title']);
			$attributes['show_excerpt'] = apply_filters('dt_sanitize_flag', $attributes['show_excerpt']);
			$attributes['show_categories'] = apply_filters('dt_sanitize_flag', $attributes['show_categories']);
			$attributes['show_date'] = apply_filters('dt_sanitize_flag', $attributes['show_date']);
			$attributes['show_author'] = apply_filters('dt_sanitize_flag', $attributes['show_author']);
			$attributes['show_comments'] = apply_filters('dt_sanitize_flag', $attributes['show_comments']);
			$attributes['show_miniatures'] = apply_filters('dt_sanitize_flag', $attributes['show_miniatures']);
			$attributes['show_media_count'] = apply_filters('dt_sanitize_flag', $attributes['show_media_count']);
			$attributes['loop'] = apply_filters('dt_sanitize_flag', $attributes['loop']);
			$attributes['arrows_on_mobile'] = apply_filters('dt_sanitize_flag', $attributes['arrows_on_mobile']);

			$attributes['descriptions'] = str_replace( 'hover', 'hoover', sanitize_key( $attributes['descriptions'] ) );
			$attributes['hover_content_visibility'] = str_replace( 'hover', 'hoover', sanitize_key( $attributes['hover_content_visibility'] ) );
			$attributes['hover_bg_color'] = sanitize_key( $attributes['hover_bg_color'] );
			$attributes['hover_animation'] = sanitize_key( $attributes['hover_animation'] );
			$attributes['bgwl_animation_effect'] = sanitize_key($attributes['bgwl_animation_effect']);

			$attributes['bg_under_albums'] = sanitize_key( $attributes['bg_under_albums'] );
			$attributes['content_aligment'] = sanitize_key( $attributes['content_aligment'] );
			$attributes['colored_bg_content_aligment'] = str_replace('centre', 'center', $attributes['colored_bg_content_aligment']);

			$attributes['arrows'] = sanitize_key( $attributes['arrows'] );

			$attributes['max_width'] = absint($attributes['max_width']);
			$attributes['width'] = absint($attributes['width']);
			$attributes['height'] = absint($attributes['height']);

			$attributes['padding'] = absint($attributes['padding']);
			$attributes['autoslide'] = absint($attributes['autoslide']);

			if ( $attributes['category']) {
				$attributes['category'] = presscore_sanitize_explode_string( $attributes['category'] );
				$attributes['select'] = 'only';
			} else {
				$attributes['select'] = 'all';
			}

			return $attributes;
		}

		protected function setup_config() {
			$config = presscore_get_config();
			$atts = &$this->atts;

			$config->map( array(
				'template'                                        => array( 'value', 'albums' ),
				'template.layout.type'                            => array( 'value', 'masonry' ),
				'layout'                                          => array( 'value', 'grid' ),
				'justified_grid'                                  => array( 'value', false ),
				'all_the_same_width'                              => array( 'value', true ),
				'post.preview.background.enabled'                 => array( 'value', false ),
				'post.preview.background.style'                   => array( 'value', false ),
				'post.preview.buttons.details.enabled'            => array( 'value', false ),
				'post.preview.load.effect'                        => array( 'value', false ),

				'show_titles'                                     => array( 'value', $atts['show_title'] ),
				'show_excerpts'                                   => array( 'value', $atts['show_excerpt'] ),

				'post.preview.width.min'                          => array( 'value', $atts['width'] ),
				'post.preview.description.style'                  => array( 'value', $atts['descriptions'] ),
				'post.preview.hover.animation'                    => array( 'value', $atts['hover_animation'] ),
				'post.preview.hover.color'                        => array( 'value', $atts['hover_bg_color'] ),
				'post.preview.hover.content.visibility'           => array( 'value', $atts['hover_content_visibility'] ),
				'post.preview.hover.title.visibility'             => array( 'value', $atts['hover_content_visibility'] ),
				'post.preview.hover.lines.animation'              => array( 'value', $atts['bgwl_animation_effect'] ),

				'post.meta.fields.media_number'                   => array( 'value', $atts['show_media_count'] ),
				'post.meta.fields.date'                           => array( 'value', $atts['show_date'] ),
				'post.meta.fields.categories'                     => array( 'value', $atts['show_categories'] ),
				'post.meta.fields.comments'                       => array( 'value', $atts['show_comments'] ),
				'post.meta.fields.author'                         => array( 'value', $atts['show_author'] ),
				'post.preview.mini_images.enabled'                => array( 'value', $atts['show_miniatures'] ),

				'is_scroller'                                    => array( 'value', true ),
			) );

			// content alignment
			if ( 'on_hoover_centered' == $atts['descriptions'] ) {
				$config->set( 'post.preview.description.alignment', $atts['colored_bg_content_aligment'] );
			} else if ( 'bg_with_lines' == $atts['descriptions'] ) {
				$config->set( 'post.preview.description.alignment', false );
			} else {
				$config->set( 'post.preview.description.alignment', $atts['content_aligment'] );
			}

			if ( 'under_image' == $atts['descriptions'] ) {
				$config->set( 'post.preview.background.enabled', ! in_array( $atts['bg_under_albums'], array( 'disabled', '' ) ) );
				$config->set( 'post.preview.background.style', $atts['bg_under_albums'] );
			}
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
				'loop' => $this->atts['loop'] ? 'true' : 'false'
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
			add_filter( 'presscore_get_images_gallery_hoovered-title_img_args', array( &$this, 'set_image_dimensions' ) );
			add_filter( 'presscore_get_images_gallery_hoovered-title_img_args', 'presscore_gallery_post_exclude_featured_image_from_gallery', 15, 3 );
		}

		protected function remove_hooks() {
			remove_filter( 'presscore_get_images_gallery_hoovered-title_img_args', array( &$this, 'set_image_dimensions' ) );
			remove_filter( 'presscore_get_images_gallery_hoovered-title_img_args', 'presscore_gallery_post_exclude_featured_image_from_gallery', 15, 3 );
		}

	}

	add_shortcode( 'dt_albums_scroller', array( new DT_Shortcode_Albums_Slider(), 'shortcode' ) );
}
