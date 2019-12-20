<?php
/**
 * Blog scroller shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Blog_Slider', false ) ) {

	class DT_Shortcode_Blog_Slider extends DT_Shortcode {

		static protected $instance;

		protected $shortcode_name = 'dt_blog_scroller';
		protected $post_type = 'post';
		protected $taxonomy = 'category';
		protected $atts = array();
		protected $config = null;

		public static function get_instance() {
			if ( !self::$instance ) {
				self::$instance = new DT_Shortcode_Blog_Slider();
			}
			return self::$instance;
		}

		protected function __construct() {
			add_shortcode( $this->shortcode_name, array( $this, 'shortcode' ) );
			$this->config = presscore_get_config();
		}

		public function shortcode( $atts, $content = null ) {
			$this->atts = $this->sanitize_attributes( $atts );

			// vc inline dummy
			if ( presscore_vc_is_inline() ) {
				return $this->vc_inline_dummy( array(
	                'class'  => 'dt_vc-blog_scroller',
	                'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_blog_carousel_editor_ico.gif', 131, 104 ),
	                'title'  => _x( 'Blog Scroller (old)', 'vc inline dummy', 'the7mk2' ),

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
					presscore_get_template_part( 'theme', 'blog/masonry/blog-masonry-post' );
				}

				// store loop html
				$posts_html = ob_get_contents();
				ob_end_clean();

				// cleanup
				$this->remove_hooks();
				$this->restore_theme_config();
				$this->restore_post_object();

				// shape output
				$output = '<div ' . $this->get_container_html_class( array( 'dt-blog-shortcode', 'slider-wrapper  owl-carousel dt-owl-carousel-init' ) ) . ' ' . $this->get_container_data_atts() . '>';
				$output .= $posts_html;
				$output .= '</div>';

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
				'category' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'number' => '12',
				'show_excerpt' => '',
				'show_categories' => '',
				'show_date' => '',
				'show_author' => '',
				'show_comments' => '',
				'padding' => '20',
				'hover_bg_color' => 'accent',
				'bg_under_posts' => 'with_paddings',
				'content_aligment' => 'left',
				'hover_content_visibility' => 'on_hover',
				'autoslide' => '3000',
				'loop' => '',
				'arrows' => 'light',
				'arrows_on_mobile' => 'on',
				'width' => '0',
				'max_width' => '',
				'height' => '210',
			), $atts, $this->shortcode_name );

			// sanitize attributes
			$attributes['order'] = apply_filters('dt_sanitize_order', $attributes['order']);
			$attributes['orderby'] = apply_filters('dt_sanitize_orderby', $attributes['orderby']);
			$attributes['number'] = apply_filters('dt_sanitize_posts_per_page', $attributes['number']);

			$attributes['show_excerpt'] = apply_filters('dt_sanitize_flag', $attributes['show_excerpt']);
			$attributes['show_categories'] = apply_filters('dt_sanitize_flag', $attributes['show_categories']);
			$attributes['show_date'] = apply_filters('dt_sanitize_flag', $attributes['show_date']);
			$attributes['show_author'] = apply_filters('dt_sanitize_flag', $attributes['show_author']);
			$attributes['show_comments'] = apply_filters('dt_sanitize_flag', $attributes['show_comments']);
			$attributes['loop'] = apply_filters('dt_sanitize_flag', $attributes['loop']);
			$attributes['arrows_on_mobile'] = apply_filters('dt_sanitize_flag', $attributes['arrows_on_mobile']);

			$attributes['hover_content_visibility'] = str_replace( 'hover', 'hoover', sanitize_key( $attributes['hover_content_visibility'] ) );
			$attributes['hover_bg_color'] = sanitize_key( $attributes['hover_bg_color'] );
			$attributes['bg_under_posts'] = sanitize_key( $attributes['bg_under_posts'] );
			$attributes['content_aligment'] = sanitize_key( $attributes['content_aligment'] );
			$attributes['arrows'] = sanitize_key( $attributes['arrows'] );

			$attributes['max_width'] = absint($attributes['max_width']);
			$attributes['width'] = absint($attributes['width']);
			$attributes['height'] = absint($attributes['height']);

			$attributes['padding'] = absint($attributes['padding']);
			$attributes['autoslide'] = absint($attributes['autoslide']);

			if ( $attributes['category']) {
				$attributes['category'] = explode(',', $attributes['category']);
				$attributes['category'] = array_map('trim', $attributes['category']);
				$attributes['select'] = 'only';
			} else {
				$attributes['select'] = 'all';
			}

			return $attributes;
		}

		protected function setup_config() {
			$config = &$this->config;
			$attributes = &$this->atts;

			$config->set( 'template', 'blog' );
			$config->set( 'template.layout.type', 'masonry' );
			$config->set( 'layout', 'grid' );
			$config->set( 'post.preview.description.style', 'under_image' );
			$config->set( 'post.fancy_date.enabled', false );
			$config->set( 'show_details', false );

			$config->set( 'show_excerpts', $attributes['show_excerpt'] );
			$config->set( 'post.preview.width.min', $attributes['width'] );
			$config->set( 'post.preview.background.enabled', ! in_array( $attributes['bg_under_posts'], array( 'disabled', '' ) ) );
			$config->set( 'post.preview.background.style', $attributes['bg_under_posts'], false );
			$config->set( 'post.preview.description.alignment', $attributes['content_aligment'] );
			$config->set( 'post.meta.fields.date', $attributes['show_date'] );
			$config->set( 'post.meta.fields.categories', $attributes['show_categories'] );
			$config->set( 'post.meta.fields.comments', $attributes['show_comments'] );
			$config->set( 'post.meta.fields.author', $attributes['show_author'] );

			// blog post settings
			$config->set( 'post.preview.width', 'normal' );
			$config->set( 'post.preview.gallery.style', 'hovered_gallery' );
			$config->set( 'post.preview.gallery.sideshow.proportions', array( 'width' => '', 'height' => '' ) );

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

			if ( 'dark' == $attributes['hover_bg_color'] ) {
				$class[] = 'hover-color-static';
			}

			if ( 'disabled' != $attributes['bg_under_posts'] ) {
				$class[] = 'bg-on';

				if ( 'fullwidth' == $attributes['bg_under_posts'] ) {
					$class[] = 'fullwidth-img';
				}
			}

			if ( 'center' == $attributes['content_aligment'] ) {
				$class[] = 'text-centered';
			}

			$class[] = 'description-under-image';

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
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
			add_filter( 'dt_post_thumbnail_args', array( &$this, 'set_image_dimensions' ) );
			add_filter( 'presscore_get_images_gallery_hoovered-title_img_args', array( &$this, 'set_image_dimensions' ) );
		}

		protected function remove_hooks() {
			remove_filter( 'dt_post_thumbnail_args', array( &$this, 'set_image_dimensions' ) );
			remove_filter( 'presscore_get_images_gallery_hoovered-title_img_args', array( &$this, 'set_image_dimensions' ) );
		}

	}

	// create shortcode
	DT_Shortcode_Blog_Slider::get_instance();

}
