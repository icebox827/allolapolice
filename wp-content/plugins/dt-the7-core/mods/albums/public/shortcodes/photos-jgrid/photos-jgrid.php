<?php
/**
 * Photos justified grid shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Photos_Jgrid', false ) ) {

	class DT_Shortcode_Photos_Jgrid extends DT_Masonry_Posts_Shortcode {

		protected $shortcode_name = 'dt_photos_jgrid';
		protected $post_type = 'dt_gallery';
		protected $taxonomy = 'dt_gallery_category';

		public function shortcode( $atts, $content = null ) {
			parent::setup( $atts, $content );

			// vc inline dummy
			if ( presscore_vc_is_inline() ) {
			    return $this->vc_inline_dummy( array(
	                'class'  => 'dt_vc-photos_justified_grid',
	                'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_photo_justif_editor_ico.gif', 98, 104 ),
	                'title'  => _x( 'Photos Justified Grid', 'vc inline dummy', 'dt-the7-core' ),

	                'style' => array( 'height' => 'auto' )
	            ) );
			}

			return $this->shortcode_html();
		}

		protected function shortcode_html() {

			$dt_query = $this->get_albums_attachments( array(
				'orderby' => $this->atts['orderby'],
				'order' => $this->atts['order'],
				'number' => $this->atts['number'],
				'select' => $this->atts['select'],
				'category' => $this->atts['category']
			) );

			$output = '';
			if ( $dt_query->have_posts() ) {

				$this->backup_post_object();
				$this->backup_theme_config();
				$this->setup_config();

				ob_start();

				do_action( 'presscore_before_shortcode_loop', $this->shortcode_name, $this->atts );

				// masonry container open
				echo '<div ' . presscore_masonry_container_class( array( 'wf-container', 'dt-gallery-container', 'dt-photos-shortcode' ) ) . presscore_masonry_container_data_atts() . presscore_get_share_buttons_for_prettyphoto( 'photo' ) . '>';

					while( $dt_query->have_posts() ) { $dt_query->the_post();

						presscore_get_template_part( 'mod_albums', 'photo-masonry/photo' );

					}

				// masonry container close
				echo '</div>';

				do_action( 'presscore_after_shortcode_loop', $this->shortcode_name, $this->atts );

				$output = ob_get_contents();
				ob_end_clean();


				$this->restore_theme_config();
				$this->restore_post_object();

			}

			return $output;
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
				'category'       => '',
				'padding'        => '20',
				'proportion'     => '',
				'loading_effect' => 'none',
				'target_height'  => '240',
				'hide_last_row'  => '',
				'show_title'     => '',
				'show_excerpt'   => '',
				'number'         => '12',
				'order'          => 'desc',
				'orderby'        => 'date',
			);

			$attributes = shortcode_atts( $default_atts, $atts, $this->shortcode_name );

			// sanitize attributes
			$attributes['loading_effect'] = sanitize_key( $attributes['loading_effect'] );

			$attributes['order'] = apply_filters('dt_sanitize_order', $attributes['order']);
			$attributes['orderby'] = apply_filters('dt_sanitize_orderby', $attributes['orderby']);
			$attributes['number'] = apply_filters('dt_sanitize_posts_per_page', $attributes['number']);

			$attributes['show_title'] = apply_filters('dt_sanitize_flag', $attributes['show_title']);
			$attributes['show_excerpt'] = apply_filters('dt_sanitize_flag', $attributes['show_excerpt']);
			$attributes['hide_last_row'] = apply_filters('dt_sanitize_flag', $attributes['hide_last_row']);

			$attributes['padding'] = intval($attributes['padding']);
			$attributes['target_height'] = intval($attributes['target_height']);

			if ( $attributes['category'] ) {
				$attributes['category'] = presscore_sanitize_explode_string( $attributes['category'] );
				$attributes['select'] = 'only';
			} else {
				$attributes['select'] = 'all';
			}

			if ( $attributes['proportion'] ) {

				$wh = array_map( 'absint', explode(':', $attributes['proportion']) );
				if ( 2 == count($wh) && !empty($wh[0]) && !empty($wh[1]) ) {
					$attributes['proportion'] = array( 'width' => $wh[0], 'height' => $wh[1] );
				} else {
					$attributes['proportion'] = '';
				}

			}

			return $attributes;
		}

		protected function setup_config() {
			$config = &$this->config;
			$atts = &$this->atts;

			$config->set( 'template', 'media' );
			$config->set( 'layout', 'grid' );
			$config->set( 'justified_grid', true );
			$config->set( 'full_width', false );
			$config->set( 'load_style', 'default' );
			$config->set( 'post.preview.description.style', 'on_hoover_centered' );

			$config->set( 'hide_last_row', $atts['hide_last_row'] );
			$config->set( 'item_padding', $atts['padding'] );
			$config->set( 'image_layout', $atts['proportion'] ? 'resize' : 'original' );
			$config->set( 'thumb_proportions', $atts['proportion'] );
			$config->set( 'show_excerpts', $atts['show_excerpt'] );
			$config->set( 'show_titles', $atts['show_title'] );
			$config->set( 'target_height', $atts['target_height'] );

			$content_visible = $atts['show_title'] || $atts['show_excerpt'];
			$config->set( 'post.preview.content.visible', $content_visible );
			$config->set( 'post.preview.load.effect', $atts['loading_effect'] );
		}

	}

	add_shortcode( 'dt_photos_jgrid', array( new DT_Shortcode_Photos_Jgrid(), 'shortcode' ) );
}
