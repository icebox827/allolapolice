<?php
/**
 * Team shortcode.
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Team', false ) ) {

	class DT_Shortcode_Team extends DT_Shortcode {

		static protected $instance;

		protected $shortcode_name = 'dt_team';
		protected $post_type = 'dt_team';
		protected $taxonomy = 'dt_team_category';

		public static function get_instance() {
			if ( !self::$instance ) {
				self::$instance = new DT_Shortcode_Team();
			}
			return self::$instance;
		}

		protected function __construct() {
			add_shortcode( $this->shortcode_name, array( $this, 'shortcode' ) );
		}

		public function shortcode( $atts, $content = null ) {
			$atts = $this->compatibility_check( $atts );
			$attributes = $this->sanitize_attributes( $atts );

			if ( presscore_vc_is_inline() ) {
			    return $this->vc_inline_dummy( array(
	                'class'  => 'dt_team',
	                'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_team_masonry_editor_ico.gif', 98, 104 ),
	                'title'  => _x( 'Team (old)', 'vc inline dummy', 'dt-the7-core' ),

	                'style' => array( 'height' => 'auto' )
	            ) );
			}

			$output = '';
			$dt_query = $this->get_posts_by_terms( $attributes );
			if ( $dt_query->have_posts() ) {

				$this->backup_post_object();
				$this->backup_theme_config();

				$this->setup_config( $attributes );

				ob_start();

				do_action( 'presscore_before_shortcode_loop', $this->shortcode_name, $attributes );

				if ( $attributes['full_width'] ) { echo '<div class="full-width-wrap">'; }

				$masonry_classes = array( 'wf-container' );

				if ( $attributes['round_images'] ) {
					$masonry_classes[] = 'round-images';
				}

				$masonry_data_atts = array();

				// Responsiveness part.
				if ( 'browser_width_based' === $attributes['responsiveness'] ) {
					$masonry_classes[] = 'resize-by-browser-width';
					$masonry_data_atts[] = 'data-desktop-columns-num="' . $attributes['columns_on_desk'] . '"';
					$masonry_data_atts[] = 'data-v-tablet-columns-num="' . $attributes['columns_on_vtabs'] . '"';
					$masonry_data_atts[] = 'data-h-tablet-columns-num="' . $attributes['columns_on_htabs'] . '"';
					$masonry_data_atts[] = 'data-phone-columns-num="' . $attributes['columns_on_mobile'] . '"';
				}

				echo '<div ' . presscore_masonry_container_class( $masonry_classes ) . presscore_masonry_container_data_atts( $masonry_data_atts ) . '>';

					while ( $dt_query->have_posts() ) { $dt_query->the_post();

						presscore_populate_team_config();

						presscore_get_template_part( 'mod_team', 'team-post' );

					}

				echo '</div>';

				if ( $attributes['full_width'] ) { echo '</div>'; }

				do_action( 'presscore_after_shortcode_loop', $this->shortcode_name, $attributes );

				$output .= ob_get_contents();
				ob_end_clean();

				$this->restore_theme_config();
				$this->restore_post_object();

			}

			return $output;
		}

		protected function sanitize_attributes( $atts ) {
			$attributes = shortcode_atts( array(
				'type' => 'masonry',
				'category' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'number' => '12',
				'padding' => '20',
				'responsiveness' => 'post_width_based',
				'column_width' => '370',
				'columns' => '2',
				'columns_on_desk' => '3',
				'columns_on_htabs' => '3',
				'columns_on_vtabs' => '3',
				'columns_on_mobile' => '3',
				'members_bg' => 'true',
				'images_sizing' => 'original',
				'show_excerpts' => '',
				'proportion' => '',
				'full_width' => '',
				'round_images' => '',
			), $atts, $this->shortcode_name );

			$attributes['type'] = in_array($attributes['type'], array('masonry', 'grid') ) ? $attributes['type'] : 'masonry';

			$attributes['responsiveness'] = sanitize_key( $attributes['responsiveness'] );

			$attributes['order'] = apply_filters('dt_sanitize_order', $attributes['order']);
			$attributes['orderby'] = apply_filters('dt_sanitize_orderby', $attributes['orderby']);
			$attributes['number'] = apply_filters('dt_sanitize_posts_per_page', $attributes['number']);

			$attributes['full_width'] = apply_filters('dt_sanitize_flag', $attributes['full_width']);
			$attributes['members_bg'] = apply_filters('dt_sanitize_flag', $attributes['members_bg']);
			$attributes['show_excerpts'] = apply_filters('dt_sanitize_flag', $attributes['show_excerpts']);
			$attributes['round_images'] = apply_filters('dt_sanitize_flag', $attributes['round_images']);

			$attributes['images_sizing'] = in_array( $attributes['images_sizing'], array( 'original', 'resize' ) ) ? $attributes['images_sizing'] : 'original';

			$attributes['padding'] = intval($attributes['padding']);
			$attributes['column_width'] = absint($attributes['column_width']);
			$attributes['columns'] = absint($attributes['columns']);
			$attributes['columns_on_desk'] = absint($attributes['columns_on_desk']);
			$attributes['columns_on_htabs'] = absint($attributes['columns_on_htabs']);
			$attributes['columns_on_vtabs'] = absint($attributes['columns_on_vtabs']);
			$attributes['columns_on_mobile'] = absint($attributes['columns_on_mobile']);

			if ( $attributes['category']) {
				$attributes['category'] = explode(',', $attributes['category']);
				$attributes['category'] = array_map('trim', $attributes['category']);
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

		protected function setup_config( &$attributes ) {
			$config = Presscore_Config::get_instance();

			$config->set( 'template', 'team' );

			////////////////////
			// Image sizing //
			////////////////////

			$config->set( 'image_layout', $attributes['images_sizing'] );
			$config->set( 'thumb_proportions', $attributes['proportion'] );

			$config->set( 'show_excerpts', $attributes['show_excerpts'] );

			//////////////
			// Layout //
			//////////////

			$config->set( 'layout', $attributes['type'] );
			$config->set( 'full_width', $attributes['full_width'] );

			$config->set( 'post.preview.description.style', 'under_image' );
			$config->set( 'load_style', 'default' );

			///////////////////
			// Items style //
			///////////////////

			$config->set( 'item_padding', $attributes['padding'] );
			$config->set( 'post.preview.width.min', $attributes['column_width'] );
			$config->set( 'template.columns.number', $attributes['columns'] );
			$config->set( 'post.preview.background.enabled', $attributes['members_bg'] );
		}


		public function compatibility_check( $atts ) {
			// For old round images settings.
			if ( isset( $atts['images_sizing'] ) && 'round' === $atts['images_sizing'] ) {
				$atts['round_images'] = 'y';
			}

			return $atts;
		}
	}

	// create shortcode
	DT_Shortcode_Team::get_instance();

}
