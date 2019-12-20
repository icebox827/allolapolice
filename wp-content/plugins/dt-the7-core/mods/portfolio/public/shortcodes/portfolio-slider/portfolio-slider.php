<?php
/**
 * Portfolio scroller shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Portfolio_Slider', false ) ) {

	class DT_Shortcode_Portfolio_Slider extends DT_Shortcode {

		protected $shortcode_name = 'dt_portfolio_slider';
		protected $post_type = 'dt_portfolio';
		protected $taxonomy = 'dt_portfolio_category';
		protected $atts = array();

		public function shortcode( $atts, $content = null ) {
			$this->atts = $this->sanitize_attributes( $atts );

			// vc inline dummy
			if ( presscore_vc_is_inline() ) {
			    return $this->vc_inline_dummy( array(
	                'class'  => 'dt_vc-portfolio_scroller',
	                'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_portfolio_carousel_editor_ico.gif', 131, 104 ),
	                'title'  => _x( 'Portfolio Scroller', 'vc inline dummy', 'dt-the7-core' ),

	                'style' => array( 'height' => 'auto' )
	            ) );
			}

			return $this->portfolio_slider();
		}

		protected function portfolio_slider() {
			$output = '';

			// query
			$dt_query = $this->get_posts_by_terms( array(
				'orderby' => $this->atts['orderby'],
				'order' => $this->atts['order'],
				'number' => $this->atts['number'],
				'select' => $this->atts['select'],
				'category' => $this->atts['category']
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

					presscore_populate_portfolio_config();

					presscore_get_config()->set( 'post.preview.media.style', 'featured_image' );

					presscore_get_template_part( 'mod_portfolio', 'masonry/project' );
				}

				// store loop html
				$posts_html = ob_get_contents();
				ob_end_clean();

				// shape output
				$output = '<div ' . $this->get_container_html_class( array( 'dt-portfolio-shortcode', 'slider-wrapper  owl-carousel dt-owl-carousel-init' ) ) . ' ' . $this->get_container_data_atts() . '>';
				$output .=  $posts_html;
				$output .= '</div>';

				// cleanup
				$this->remove_hooks();
				$this->restore_theme_config();
				$this->restore_post_object();
			}

			return $output;
		}

		protected function sanitize_attributes( &$atts ) {
			$attributes = shortcode_atts( array(
				'category' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'number' => '12',
				'show_title' => '',
				'show_excerpt' => '',
				'show_details' => '',
				'show_link' => '',
				'show_zoom' => '',
				'show_categories' => '',
				'show_date' => '',
				'show_author' => '',
				'show_comments' => '',
				'padding' => '20',
				'appearance' => 'under_image',
				'hover_bg_color' => 'accent',
				'bg_under_projects' => 'disabled',
				'content_aligment' => 'left',
				'hover_animation' => 'fade',
				'colored_bg_content_aligment' => 'centre',
				'bgwl_animation_effect' => '1',
				'hover_content_visibility' => 'on_hover',
				'autoslide' => '3000',
				'loop' => '',
				'arrows' => 'light',
				'arrows_on_mobile' => 'on',
				'max_width' => '',
				'width' => '',
				'height' => '210',
			), $atts, $this->shortcode_name );

			// sanitize attributes
			$attributes['order'] = apply_filters('dt_sanitize_order', $attributes['order']);
			$attributes['orderby'] = apply_filters('dt_sanitize_orderby', $attributes['orderby']);
			$attributes['number'] = apply_filters('dt_sanitize_posts_per_page', $attributes['number']);

			$attributes['show_title'] = apply_filters('dt_sanitize_flag', $attributes['show_title']);
			$attributes['show_excerpt'] = apply_filters('dt_sanitize_flag', $attributes['show_excerpt']);
			$attributes['show_details'] = apply_filters('dt_sanitize_flag', $attributes['show_details']);
			$attributes['show_link'] = apply_filters('dt_sanitize_flag', $attributes['show_link']);
			$attributes['show_zoom'] = apply_filters('dt_sanitize_flag', $attributes['show_zoom']);
			$attributes['show_categories'] = apply_filters('dt_sanitize_flag', $attributes['show_categories']);
			$attributes['show_date'] = apply_filters('dt_sanitize_flag', $attributes['show_date']);
			$attributes['show_author'] = apply_filters('dt_sanitize_flag', $attributes['show_author']);
			$attributes['show_comments'] = apply_filters('dt_sanitize_flag', $attributes['show_comments']);
			$attributes['loop'] = apply_filters('dt_sanitize_flag', $attributes['loop']);
			$attributes['arrows_on_mobile'] = apply_filters('dt_sanitize_flag', $attributes['arrows_on_mobile']);

			$attributes['appearance'] = str_replace( 'hover', 'hoover', sanitize_key( $attributes['appearance'] ) );
			$attributes['hover_content_visibility'] = str_replace( 'hover', 'hoover', sanitize_key( $attributes['hover_content_visibility'] ) );
			$attributes['hover_animation'] = sanitize_key( $attributes['hover_animation'] );
			$attributes['bgwl_animation_effect'] = sanitize_key($attributes['bgwl_animation_effect']);
			$attributes['hover_bg_color'] = sanitize_key( $attributes['hover_bg_color'] );
			$attributes['bg_under_projects'] = sanitize_key( $attributes['bg_under_projects'] );
			$attributes['content_aligment'] = sanitize_key( $attributes['content_aligment'] );
			$attributes['colored_bg_content_aligment'] = str_replace('centre', 'center', $attributes['colored_bg_content_aligment']);
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
			$config = presscore_get_config();

			$config->map( array(
				'template'								=> array( 'value', 'portfolio' ),
				'template.layout.type'					=> array( 'value', 'masonry' ),
				'layout'								=> array( 'value', 'grid' ),
				'justified_grid'						=> array( 'value', false ),
				'all_the_same_width'					=> array( 'value', true ),
				'post.preview.background.enabled'		=> array( 'value', false ),
				'post.preview.background.style'			=> array( 'value', false ),
				'post.preview.load.effect'				=> array( 'value', false ),

				'post.preview.width.min'				=> array( 'value', $this->atts['width'] ? $this->atts['width'] : 300 ),

				'show_titles'							=> array( 'value', $this->atts['show_title'] ),
				'show_excerpts'							=> array( 'value', $this->atts['show_excerpt'] ),

				'post.preview.description.style'		=> array( 'value', $this->atts['appearance'] ),
				'post.preview.description.alignment'	=> array( 'value', $this->atts['content_aligment'] ),
				'post.preview.hover.animation'			=> array( 'value', $this->atts['hover_animation'] ),
				'post.preview.hover.color'				=> array( 'value', $this->atts['hover_bg_color'] ),
				'post.preview.hover.content.visibility'	=> array( 'value', $this->atts['hover_content_visibility'] ),
				'post.preview.hover.title.visibility'	=> array( 'value', $this->atts['hover_content_visibility'] ),
				'post.preview.hover.lines.animation'	=> array( 'value', $this->atts['bgwl_animation_effect'] ),

				'show_links'							=> array( 'value', $this->atts['show_link'] ),
				'show_details'							=> array( 'value', $this->atts['show_details'] ),
				'show_zoom'								=> array( 'value', $this->atts['show_zoom'] ),

				'post.meta.fields.date'					=> array( 'value', $this->atts['show_date'] ),
				'post.meta.fields.categories'			=> array( 'value', $this->atts['show_categories'] ),
				'post.meta.fields.comments'				=> array( 'value', $this->atts['show_comments'] ),
				'post.meta.fields.author'				=> array( 'value', $this->atts['show_author'] ),

				'is_scroller'							=> array( 'value', true ),
			) );

			// content alignment
			if ( 'on_hoover_centered' == $this->atts['appearance'] ) {
				$config->set( 'post.preview.description.alignment', $this->atts['colored_bg_content_aligment'] );
			} else if ( 'bg_with_lines' == $this->atts['appearance'] ) {
				$config->set( 'post.preview.description.alignment', false );
			} else {
				$config->set( 'post.preview.description.alignment', $this->atts['content_aligment'] );
			}

			// preview background
			if ( 'under_image' == $this->atts['appearance'] ) {
				$config->set( 'post.preview.background.enabled', ! in_array( $this->atts['bg_under_projects'], array( 'disabled', '' ) ) );
				$config->set( 'post.preview.background.style', $this->atts['bg_under_projects'] );
			}
		}

		public function set_image_dimensions( $args ) {
			$args['options'] = array( 'w' => $this->atts['width'], 'h' => $this->atts['height'] );
			$args['prop'] = false;
			return $args;
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
			add_filter( 'dt_portfolio_thumbnail_args', array( &$this, 'set_image_dimensions' ) );
		}

		protected function remove_hooks() {
			remove_filter( 'dt_portfolio_thumbnail_args', array( &$this, 'set_image_dimensions' ) );
		}

	}

	add_shortcode( 'dt_portfolio_slider', array( new DT_Shortcode_Portfolio_Slider(), 'shortcode' ) );
}
