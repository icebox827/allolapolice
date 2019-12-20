<?php
/**
 * Team Masonry shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Team_Masonry', false ) ) :

	class DT_Shortcode_Team_Masonry extends The7pt_Shortcode_With_Inline_CSS {
		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Team_Shortcode_Masonry
		 */
		public static $instance = null;

		/**
		 * @return DT_Team_Shortcode_Masonry
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {

			$this->sc_name = 'dt_team_masonry';
			$this->unique_class_base = 'team-masonry-shortcode-id';
			$this->taxonomy = 'dt_team_category';
			$this->post_type = 'dt_team';

			$this->default_atts = array(
				'post_type' => 'category',
				'posts' => '',
				'posts_offset' => 0,
				'category' => '',
				'order' => 'desc',
				'orderby' => 'date',
				'type' => 'grid',
				'loading_effect' => 'none',
				'img_border_radius' => '0px',
				'content_bg' => 'y',
				'custom_content_bg_color' => '',
				'post_content_paddings' => '20px 20px 20px 20px',
				'image_sizing' => 'resize',
				'resized_image_dimensions' => '1x1',
				'img_max_width' => '',
				'image_paddings' => '0px 0px 0px 0px',
				'image_scale_animation_on_hover' => 'y',
				'image_hover_bg_color' => 'y',
				'gap_between_posts'              => '15px',
				'responsiveness'                 => 'browser_width_based',
				'bwb_columns'                    => 'desktop:3|h_tablet:3|v_tablet:2|phone:1',
				'pwb_column_min_width'           => '',
				'pwb_columns'                    => '',
				'content_alignment' => 'center',
				'post_title_font_style' => ':bold:',
				'post_title_font_size' => '',
				'post_title_line_height' => '',
				'custom_title_color' => '',
				'post_title_bottom_margin' => '0',
				'post_date' => 'y',
				'post_category' => 'y',
				'post_author' => 'y',
				'post_comments' => 'y',
				'team_position' => 'y',
				'team_position_font_style' => 'normal:bold:none',
				'team_position_font_size' => '',
				'team_position_line_height' => '',
				'team_position_color' => '',
				'team_position_bottom_margin' => '10px',
				'show_team_desc' => 'y',
				'post_content' => 'show_excerpt',
				'excerpt_words_limit' => '',
				'content_font_style' => '',
				'content_font_size' => '',
				'content_line_height' => '',
				'custom_content_color' => '',
				'content_bottom_margin' => '5px',
				'read_more_button' => 'default_link',
				'read_more_button_text' => 'View details',
				'show_soc_icon'	=> 'y',
				'show_icons_under' => 'under_position',
				'soc_icon_size'	=> '16px',
				'dt_soc_icon' => '',
				'soc_icon_bg_size' => '26px',
				'soc_icon_border_width'	=> '0',
				'soc_icon_border_radius'=> '100px',
				'soc_icon_color' => 'rgba(255,255,255,1)',
				'soc_icon_border_color'	=> '',
				'soc_icon_bg' => 'y',
				'soc_icon_bg_color'	=> '',
				'soc_icon_color_hover' => 'rgba(255,255,255,0.75)',
				'soc_icon_border_color_hover' => '',
				'soc_icon_bg_hover' => 'y',
				'soc_icon_bg_color_hover' => '',
				'soc_icon_gap' => '4px',
				'soc_icon_below_gap' => '15px',
				'css_dt_team_masonry' => '',
				'el_class' => '',
				'loading_mode'                   => 'disabled',
				'dis_posts_total'                => '-1',
				'st_posts_per_page'              => '',
				'st_show_all_pages'              => 'n',
				'st_gap_before_pagination'       => '',
				'jsp_posts_total'                => '-1',
				'jsp_posts_per_page'             => '',
				'jsp_show_all_pages'             => 'n',
				'jsp_gap_before_pagination'      => '',
				'jsm_posts_total'                => '-1',
				'jsm_posts_per_page'             => '',
				'jsm_gap_before_pagination'      => '',
				'jsl_posts_total'                => '-1',
				'jsl_posts_per_page'             => '',
				'navigation_font_color'          => '',
				'navigation_accent_color'        => '',
				'show_categories_filter'         => 'n',
			);
			parent::__construct();
		}
		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			$query = $this->get_loop_query();

			do_action( 'presscore_before_shortcode_loop', $this->sc_name, $this->atts );

			// Remove default masonry posts wrap.
			presscore_remove_posts_masonry_wrap();

			$loading_mode = $this->get_att( 'loading_mode' );

			$data_post_limit = '-1';
			switch ( $loading_mode ) {
				case 'js_pagination':
					$data_post_limit = $this->get_att( 'jsp_posts_per_page', get_option( 'posts_per_page' ) );
					break;
				case 'js_more':
					$data_post_limit = $this->get_att( 'jsm_posts_per_page', get_option( 'posts_per_page' ) );
					break;
				case 'js_lazy_loading':
					$data_post_limit = $this->get_att( 'jsl_posts_per_page', get_option( 'posts_per_page' ) );
					break;
			}

			if ( 'disabled' == $loading_mode ) {
				$data_pagination_mode = 'none';
			} else if ( in_array( $loading_mode, array( 'js_more', 'js_lazy_loading' ) ) ) {
				$data_pagination_mode = 'load-more';
			} else {
				$data_pagination_mode = 'pages';
			}

			$data_atts = array(
				'data-post-limit="' . intval( $data_post_limit ) . '"',
				'data-pagination-mode="' . esc_attr( $data_pagination_mode ) . '"',
			);
			$data_atts = $this->add_responsiveness_data_atts( $data_atts );

				echo '<div ' . $this->get_container_html_class( 'dt-team-masonry-shortcode dt-team-shortcode' ) .  presscore_masonry_container_data_atts( $data_atts ) .  '>';

				// Posts filter.
				$filter_class = array( 'iso-filter', 'extras-off' );

				if ( 'standard' === $loading_mode ) {
					$filter_class[] = 'without-isotope';
				}

				if ( 'grid' === $this->get_att( 'mode' ) ) {
					$filter_class[] = 'css-grid-filter';
				}

				$config = presscore_config();

				switch ( $config->get( 'template.posts_filter.style' ) ) {
					case 'minimal':
						$filter_class[] = 'filter-bg-decoration';
						break;
					case 'material':
						$filter_class[] = 'filter-underline-decoration';
						break;
				}

				$terms = array();
				if ( $this->get_flag( 'show_categories_filter' ) ) {
					$terms = $this->get_posts_filter_terms( $query );
				}

				DT_Portfolio_Shortcode_HTML::display_posts_filter( $terms, $filter_class );

					echo '<div ' . $this->iso_container_class() . '>';

					if ( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
					do_action('presscore_before_post');

						// Post visibility on the first page.
						$visibility = 'visible';
						if ( $data_post_limit >= 0 && $query->current_post >= $data_post_limit ) {
							$visibility = 'hidden';
						}
						echo '<div ' . presscore_tpl_masonry_item_wrap_class( $visibility ) . presscore_tpl_masonry_item_wrap_data_attr() . '>';

						presscore_populate_team_config();
						printf( '<div class="%s">', implode( ' ', get_post_class( 'team-container visible post' ) ) );

							presscore_get_template_part( 'mod_team', 'team-post-media' );

							echo '<div class="team-desc">';
								echo '<div class="team-author">';

									// Output author name
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
									echo $title;

									// Output author position
									$position = $config->get( 'post.member.position' );
									if ( $position ) {
										$position = '<p>' . $position . '</p>';

									} else {
										$position = '';

									}
									echo $position;
								echo '</div>';

								// Output description 
								echo '<div class="team-content">' . $this->get_post_excerpt() . '</div>';

								$clear_links = array();
								$links = $config->get( 'post.preview.links' );
								if ( function_exists('presscore_get_team_links_array') ) {

									foreach ( presscore_get_team_links_array() as $id=>$data ) {

										if ( array_key_exists( $id , $links ) ) {
											$clear_links[] = presscore_get_social_icon( $id, $links[ $id ], $data['desc'] );
										}
									}

								}

								// Output soc links

								if ( !empty( $clear_links ) && $this->get_att( 'show_soc_icon' ) == 'y' ) {
									echo '<div class="soc-ico">' . implode( '', $clear_links ) . '</div>';
								}

								// Output view btn
								if($this->atts['read_more_button'] != 'off' && 'post' == $config->get( 'post.open_as' )  ){
									$details_btn_style = $this->get_att( 'read_more_button' );
									$details_btn_text = $this->get_att( 'read_more_button_text' );
									$details_btn_class = ('default_button' === $details_btn_style ? array( 'dt-btn-s', 'dt-btn' ) : array());
									echo DT_Blog_Shortcode_HTML::get_details_btn( $details_btn_style, $details_btn_text, $details_btn_class );
								}

							echo '</div>';
						echo '</div>';
					echo '</div>';
					
					do_action('presscore_after_post');

					endwhile; endif;

			echo '</div><!-- iso-container|iso-grid -->';

			if ( 'disabled' == $loading_mode ) {
				// Do not output pagination.
			} else if ( in_array( $loading_mode, array( 'js_more', 'js_lazy_loading' ) ) ) {
				// JS load more.
				echo dt_get_next_page_button( 2, 'paginator paginator-more-button' );
			} else if ( 'js_pagination' == $loading_mode ) {
				// JS pagination.
				echo '<div class="paginator" role="navigation"></div>';
			} else {
				// Pagination.
				dt_paginator( $query, array( 'class' => 'paginator' ) );
			}

			echo '</div>';

			do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
		}

		protected function get_container_html_class( $class = array() ) {
			if ( ! is_array( $class ) ) {
				$class = explode( ' ', $class );
			}
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();
			$mode_classes = array(
				'masonry' => 'mode-masonry',
				'grid'    => 'mode-grid',
			);

			// loading effect
			$class[] = presscore_tpl_get_load_effect_class($this->get_att( 'loading_effect' ));
			$mode = $this->get_att( 'type' );
			if ( array_key_exists( $mode, $mode_classes ) ) {
				$class[] = $mode_classes[ $mode ];
			}

			$loading_mode = $this->get_att( 'loading_mode' );
			if ( 'standard' !== $loading_mode ) {
				$class[] = 'jquery-filter';
			}

			if ( 'js_lazy_loading' === $loading_mode ) {
				$class[] = 'lazy-loading-mode';
			}


			if ( $this->get_flag( 'jsp_show_all_pages' ) ) {
				$class[] = 'show-all-pages';
			}

			if ( 'left' === $this->get_att( 'content_alignment' ) ) {
				$class[] = 'content-align-left';
			}else{
				$class[] = 'content-align-center';
			};

			if ( $this->get_flag( 'content_bg' ) ) {
				$class[] = 'content-bg-on';
			}

			if($this->atts['team_position'] === 'n'){
				$class[] = 'hide-team-position';
			}
			if ( 'grid' === $this->get_att( 'type' ) ) {
				$class[] = 'dt-css-grid-wrap';
			}

			if ( $this->get_flag( 'image_scale_animation_on_hover' ) ) {
				$class[] = 'scale-img';
			}
			if ( 'grid' === $this->get_att( 'type' ) ) {
				$class[] = 'dt-css-grid-wrap';
			}
			if ( !$this->get_flag( 'image_hover_bg_color' ) ) {
				$class[] = 'disable-bg-rollover';
			}

			if($this->atts['soc_icon_bg'] === 'y'){
				$class[] = 'dt-icon-bg-on';
			}else{
				$class[] = 'dt-icon-bg-off';
			};

			if($this->atts['soc_icon_bg_hover'] === 'y'){
				$class[] = 'dt-icon-hover-bg-on';
			}else{
				$class[] = 'dt-icon-hover-bg-off';
			};
			if($this->atts['show_icons_under'] === 'under_position'){
				$class[] = 'move-icons-under-position';
			}
			$class = $this->add_responsiveness_class( $class );

			
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_team_masonry'], ' ' );
			};
			$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
		}
		/**
		 * Iso container class.
		 *
		 * @param array $class
		 *
		 * @return string
		 */
		protected function iso_container_class( $class = array() ) {
			if ( 'grid' === $this->get_att( 'type' ) ) {
				$class[] = 'dt-css-grid';
			} else {
				$class[] = 'iso-container';
			}

			return 'class="' . esc_attr( join( ' ', $class ) ) . '" ';
		}
		/**
		 * Browser responsiveness classes.
		 *
		 * @param array $class
		 *
		 * @return array
		 */
		protected function add_responsiveness_class( $class = array() ) {
			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$class[] = 'resize-by-browser-width';
			}

			return $class;
		}
		/**
		 * Browser responsiveness data attributes.
		 *
		 * @param array $data_atts
		 *
		 * @return array
		 */
		protected function add_responsiveness_data_atts( $data_atts = array() ) {
			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$bwb_columns = DT_VCResponsiveColumnsParam::decode_columns( $this->get_att( 'bwb_columns' ) );
				$columns = array(
					'desktop'  => 'desktop',
					'v_tablet' => 'v-tablet',
					'h_tablet' => 'h-tablet',
					'phone'    => 'phone',
				);

				foreach ( $columns as $column => $data_att ) {
					$val = ( isset( $bwb_columns[ $column ] ) ? absint( $bwb_columns[ $column ] ) : '' );
					$data_atts[] = 'data-' . $data_att . '-columns-num="' . esc_attr( $val ) . '"';
				}
			}

			return $data_atts;
		}
			/**
		 * Return post excerpt with $length words.
		 *
		 * @return mixed
		 */
		 protected function get_post_excerpt() {

			if ( 'n' === $this->atts['show_team_desc'] ) {
				return '';
			}

			//$post_back = $post;

			if ( 'show_content' === $this->atts['post_content'] ) {
				$excerpt = apply_filters( 'the_content', get_the_content() );
			} else {
				$length = absint( $this->atts['excerpt_words_limit'] );
				$excerpt = apply_filters( 'the7_shortcodeaware_excerpt', get_the_excerpt() );

				if ( $length ) {
					$excerpt = wp_trim_words( $excerpt, $length );
				}

				$excerpt = apply_filters( 'the_excerpt', $excerpt );
			}

			return $excerpt;
		 }
		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();

			$config->set( 'load_style', 'default' );
			$config->set( 'template', 'team' );
			$config->set( 'layout', $this->get_att( 'type' ) );
			$config->set( 'post.preview.load.effect', $this->get_att( 'loading_effect' ), 'none' );
			$show_post_content = ( 'n' !== $this->get_att( 'show_team_desc' ) );
			$config->set( 'show_excerpts', $show_post_content );
			$config->set( 'post.preview.content.visible', $show_post_content );
			$config->set( 'show_details', ( 'off' !== $this->get_att( 'read_more_button' ) ) );
			$config->set( 'image_layout', ( 'resize' === $this->get_att( 'image_sizing' ) ? $this->get_att( 'image_sizing' ) : 'original' ) );
			if ( 'resize' == $this->get_att( 'image_sizing' ) && $this->get_att( 'resized_image_dimensions' ) ) {
				// Sanitize.
				$img_dim = array_slice( array_map( 'absint', explode( 'x', strtolower( $this->get_att( 'resized_image_dimensions' ) ) ) ), 0, 2 );
				// Make sure that all values is set.
				for ( $i = 0; $i < 2; $i++ ) {
					if ( empty( $img_dim[ $i ] ) ) {
						$img_dim[ $i ] = '';
					}
				}
				$config->set( 'thumb_proportions', array( 'width' => $img_dim[0], 'height' => $img_dim[1] ) );
			} else {
				$config->set( 'thumb_proportions', '' );
			}
			if ( 'standard' === $this->get_att( 'loading_mode' ) ) {
				$config->set( 'show_all_pages', $this->get_flag( 'st_show_all_pages' ) );
			} else {
				$config->set( 'show_all_pages', $this->get_flag( 'jsp_show_all_pages' ) );
				$config->set( 'request_display', false );
			}
			$config->set( 'order', $this->get_att( 'order' ) );
			$config->set( 'orderby', $this->get_att( 'orderby' ) );
			$config->set( 'post.preview.description.style', 'under_image' );
			$config->set( 'item_padding', $this->get_att( 'gap_between_posts' ) );
			$config->set( 'post.preview.width.min', $this->get_att( 'pwb_column_min_width' ) );
			$config->set( 'template.columns.number', $this->get_att( 'pwb_columns' ) );
			$config->set( 'post.preview.background.enabled', $this->get_att( 'members_bg') );
			$config->set( 'template.posts_filter.terms.enabled', $this->get_flag( 'show_categories_filter' ) );
		}
		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'dt-team-shortcode.' . $this->get_unique_class(), '~"%s"' );
			$less_vars->add_pixel_or_percent_number( 'post-content-width', $this->get_att( 'bo_content_width' ) );
			$less_vars->add_pixel_number( 'post-content-top-overlap', $this->get_att( 'bo_content_overlap' ) );
			$less_vars->add_pixel_or_percent_number( 'post-content-overlap', $this->get_att( 'grovly_content_overlap' ) );
			$less_vars->add_keyword( 'post-content-bg', $this->get_att( 'custom_content_bg_color', '~""' ) );
			$less_vars->add_pixel_number( 'team-img-max-width', $this->get_att( 'img_max_width' ) );
			$less_vars->add_paddings( array(
				'post-content-padding-top',
				'post-content-padding-right',
				'post-content-padding-bottom',
				'post-content-padding-left',
			), $this->get_att( 'post_content_paddings' ) );
			$less_vars->add_paddings( array(
				'post-thumb-padding-top',
				'post-thumb-padding-right',
				'post-thumb-padding-bottom',
				'post-thumb-padding-left',
			), $this->get_att( 'image_paddings' ), '%|px' );
			$less_vars->add_pixel_number( 'img-border-radius', $this->get_att( 'img_border_radius' ) );
			//Post tab
			$less_vars->add_font_style( array(
				'post-title-font-style',
				'post-title-font-weight',
				'post-title-text-transform',
			), $this->get_att( 'post_title_font_style' ) );
			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$bwb_columns = DT_VCResponsiveColumnsParam::decode_columns( $this->get_att( 'bwb_columns' ) );
				$columns = array(
					'desktop'  => 'desktop',
					'v_tablet' => 'v-tablet',
					'h_tablet' => 'h-tablet',
					'phone'    => 'phone',
				);

				foreach ( $columns as $column => $data_att ) {
					$val = ( isset( $bwb_columns[ $column ] ) ? absint( $bwb_columns[ $column ] ) : '' );
					$data_atts[] = 'data-' . $data_att . '-columns-num="' . esc_attr( $val ) . '"';
					
					$less_vars->add_keyword( $data_att. '-columns-num', esc_attr( $val ) );
			
				}
			};
			$less_vars->add_pixel_number( 'grid-posts-gap', $this->get_att( 'gap_between_posts' ) );
			$less_vars->add_pixel_number( 'grid-post-min-width', $this->get_att( 'pwb_column_min_width' ));
			$less_vars->add_pixel_number( 'grid-desire-col-num', $this->get_att( 'pwb_columns' ) );
			$less_vars->add_pixel_number( 'post-title-font-size', $this->get_att( 'post_title_font_size' ) );
			$less_vars->add_pixel_number( 'post-title-line-height', $this->get_att( 'post_title_line_height' ) );
			$less_vars->add_pixel_number( 'team-position-font-size', $this->get_att( 'team_position_font_size' ) );
			$less_vars->add_pixel_number( 'team-position-line-height', $this->get_att( 'team_position_line_height' ) );
			$less_vars->add_keyword( 'post-title-color', $this->get_att( 'custom_title_color', '~""' ) );
			$less_vars->add_keyword( 'team-position-color', $this->get_att( 'team_position_color', '~""' ) );
			$less_vars->add_keyword( 'post-content-color', $this->get_att( 'custom_content_color', '~""' ) );
			$less_vars->add_pixel_number( 'post-excerpt-font-size', $this->get_att( 'content_font_size' ) );
			$less_vars->add_pixel_number( 'post-excerpt-line-height', $this->get_att( 'content_line_height' ) );
			$less_vars->add_pixel_number( 'team-position-margin-bottom', $this->get_att( 'team_position_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-title-margin-bottom', $this->get_att( 'post_title_bottom_margin' ) );
			$less_vars->add_pixel_number( 'post-excerpt-margin-bottom', $this->get_att( 'content_bottom_margin' ) );
			$less_vars->add_font_style( array(
				'team-position-font-style',
				'team-position-font-weight',
				'team-position-text-transform',
			), $this->get_att( 'team_position_font_style' ) );
			$less_vars->add_font_style( array(
				'post-content-font-style',
				'post-content-font-weight',
				'post-content-text-transform',
			), $this->get_att( 'content_font_style' ) );
			$less_vars->add_pixel_number( 'soc-icon-size', $this->get_att( 'soc_icon_size' ) );
			$less_vars->add_pixel_number( 'soc-icon-bg-size', $this->get_att( 'soc_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'soc-icon-border-width', $this->get_att( 'soc_icon_border_width' ) );
			$less_vars->add_pixel_number( 'soc-icon-border-radius', $this->get_att( 'soc_icon_border_radius' ) );
			$less_vars->add_keyword( 'soc-icon-color', $this->get_att( 'soc_icon_color', '~""') );
			$less_vars->add_keyword( 'soc-icon-color-hover', $this->get_att( 'soc_icon_color_hover', '~""' ) );
			$less_vars->add_keyword( 'soc-icon-border-color', $this->get_att( 'soc_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'soc-icon-border-color-hover', $this->get_att( 'soc_icon_border_color_hover', '~""' ) );
			$less_vars->add_keyword( 'soc-icon-bg-color', $this->get_att( 'soc_icon_bg_color', '~""' ) );
			$less_vars->add_keyword( 'soc-icon-bg-color-hover', $this->get_att( 'soc_icon_bg_color_hover', '~""' ) );
			$less_vars->add_pixel_number( 'team-icon-gap', $this->get_att( 'soc_icon_gap' ) );
			$less_vars->add_pixel_number( 'team-icon-gap-below', $this->get_att( 'soc_icon_below_gap' ) );

			$gap_before_pagination = '';
			switch ( $this->get_att( 'loading_mode' ) ) {
				case 'standard':
					$gap_before_pagination = $this->get_att( 'st_gap_before_pagination', '' );
					break;
				case 'js_pagination':
					$gap_before_pagination = $this->get_att( 'jsp_gap_before_pagination', '' );
					break;
				case 'js_more':
					$gap_before_pagination = $this->get_att( 'jsm_gap_before_pagination', '' );
					break;
			}
			$less_vars->add_pixel_number( 'shortcode-pagination-gap', $gap_before_pagination );
			$less_vars->add_keyword( 'shortcode-filter-color', $this->get_att( 'navigation_font_color', '~""' ) );
			$less_vars->add_keyword( 'shortcode-filter-accent', $this->get_att( 'navigation_accent_color', '~""' ) );

			return $less_vars->get_vars();
		}

		protected function get_less_file_name() {
			if ( the7pt_is_theme_version_smaller_or_equal_to( '6.7.0' ) ) {
				return get_template_directory() . '/css/dynamic-less/shortcodes/dt-team-masonry.less';
			}

			return The7PT()->plugin_path() . 'assets/css/shortcodes/dt-team-masonry.less';
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return $this->vc_inline_dummy( array(
				'class'  => 'dt_team_masonry',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_team_masonry_editor_ico.gif', 98, 104 ),
				'title'  => _x( 'Team Masonry & Grid', 'vc inline dummy', 'dt-the7-core' ),

				'style' => array( 'height' => 'auto' )
			) );
		}

		/**
		 * Return posts query.
		 *
		 * @since 1.16.0
		 *
		 * @return WP_Query
		 */
		protected function get_loop_query() {
			$query = apply_filters( 'the7_shortcode_query', null, $this->sc_name, $this->atts );
			if ( is_a( $query, 'WP_Query' ) ) {
				return $query;
			}

			add_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
			add_filter( 'found_posts', array( $this, 'fix_pagination' ), 1, 2 );

			// Loop query.
			$post_type = $this->get_att( 'post_type' );
			if ( 'posts' === $post_type ) {
				$query = $this->get_posts_by_post_type( 'dt_team', $this->get_att( 'posts' ) );
			}else {
				$category_terms = presscore_sanitize_explode_string( $this->get_att( 'category' ) );
				$category_field = ( is_numeric( $category_terms[0] ) ? 'term_id' : 'slug' );

				$query = $this->get_posts_by_taxonomy( 'dt_team', 'dt_team_category', $category_terms, $category_field );
			}

			remove_action( 'pre_get_posts', array( $this, 'add_offset' ), 1 );
			remove_filter( 'found_posts', array( $this, 'fix_pagination' ), 1 );

			return $query;
		}

		/**
		 * Add offset to the posts query.
		 *
		 * @since 1.16.0
		 *
		 * @param WP_Query $query
		 */
		public function add_offset( &$query ) {
			$offset  = (int) $this->atts['posts_offset'];
			$ppp     = (int) $query->query_vars['posts_per_page'];
			$current = (int) $query->query_vars['paged'];

			if ( $query->is_paged ) {
				$page_offset = $offset + ( $ppp * ( $current - 1 ) );
				$query->set( 'offset', $page_offset );
			} else {
				$query->set( 'offset', $offset );
			}
		}

		/**
		 * Fix pagination accordingly with posts offset.
		 *
		 * @since 1.16.0
		 *
		 * @param int $found_posts
		 *
		 * @return int
		 */
		public function fix_pagination( $found_posts ) {
			return $found_posts - (int) $this->atts['posts_offset'];
		}

		protected function get_posts_by_post_type( $post_type, $post_ids = array() ) {
			$pagination_mode = $this->get_att( 'loading_mode' );
			$posts_per_page = $this->get_posts_per_page( $pagination_mode );

			if ( is_string( $post_ids ) ) {
				$post_ids = presscore_sanitize_explode_string( $post_ids );
			}
			$post_ids = array_filter( $post_ids );

			if ( 'standard' === $pagination_mode ) {
				$config = presscore_config();
				$query_args = array(
					'orderby'          => $config->get( 'orderby' ),
					'order'            => $config->get( 'order' ),
					'posts_per_page'   => $posts_per_page,
					'post_type'        => $post_type,
					'post_status'      => 'publish',
					'paged'            => dt_get_paged_var(),
					'suppress_filters' => false,
					'post__in'         => $post_ids,
				);

				$request = $config->get( 'request_display' );
				if ( ! empty( $request['terms_ids'] ) ) {
					$query_args['tax_query'] = array(
						array(
							'taxonomy' => 'dt_team_category',
							'field'    => 'term_id',
							'terms'    => $request['terms_ids'],
						),
					);
				}
			} else {
				$query_args = array(
					'orderby'          => $this->get_att( 'orderby' ),
					'order'            => $this->get_att( 'order' ),
					'posts_per_page'   => $posts_per_page,
					'post_type'        => $post_type,
					'post_status'      => 'publish',
					'paged'            => 1,
					'suppress_filters' => false,
					'post__in'         => $post_ids,
				);
			}

			return new WP_Query( $query_args );
		}

		protected function get_posts_by_taxonomy( $post_type, $taxonomy, $taxonomy_terms = array(), $taxonomy_field = 'term_id' ) {
			$pagination_mode = $this->get_att( 'loading_mode' );
			$posts_per_page = $this->get_posts_per_page( $pagination_mode );

			if ( is_string( $taxonomy_terms ) ) {
				$taxonomy_terms = presscore_sanitize_explode_string( $taxonomy_terms );
			}
			$taxonomy_terms = array_filter( $taxonomy_terms );

			$query_args = array(
				'posts_per_page'   => $posts_per_page,
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'suppress_filters' => false,
			);

			$tax_query = array();
			if ( $taxonomy_terms ) {
				$tax_query = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => $taxonomy_field,
						'terms'    => $taxonomy_terms,
					),
				);
			}

			if ( 'standard' === $pagination_mode ) {
				$config = presscore_config();
				$request = $config->get( 'request_display' );
				if ( ! empty( $request['terms_ids'] ) ) {
					$tax_query[] = array(
						'taxonomy' => 'dt_team_category',
						'field'    => 'term_id',
						'terms'    => $request['terms_ids'],
					);
					$tax_query['relation'] = 'AND';
				}

				$query_args['orderby'] = $config->get( 'orderby' );
				$query_args['order'] = $config->get( 'order' );
				$query_args['paged'] = dt_get_paged_var();
			} else {
				// JS pagination.
				$query_args['orderby'] = $this->get_att( 'orderby' );
				$query_args['order'] = $this->get_att( 'order' );
				$query_args['paged'] = 1;
			}

			if ( $tax_query ) {
				$query_args['tax_query'] = $tax_query;
			}

			add_action( 'pre_get_posts', array( $this, 'sticky_posts_fix' ) );

			return new WP_Query( $query_args );
		}

		protected function get_posts_per_page( $pagination_mode ) {
			$max_posts_per_page = 99999;
			switch ( $pagination_mode ) {
				case 'disabled':
					$posts_per_page = $this->get_att( 'dis_posts_total' );
					break;
				case 'standard':
					$posts_per_page = $this->get_att( 'st_posts_per_page' );
					$posts_per_page = $posts_per_page ? $posts_per_page : get_option( 'posts_per_page' );
					break;
				case 'js_pagination':
					$posts_per_page = $this->get_att( 'jsp_posts_total' );
					break;
				case 'js_more':
					$posts_per_page = $this->get_att( 'jsm_posts_total' );
					break;
				case 'js_lazy_loading':
					$posts_per_page = $this->get_att( 'jsl_posts_total' );
					break;
				default:
					return $max_posts_per_page;
			}

			$posts_per_page = (int) $posts_per_page;
			if ( $posts_per_page === -1 ) {
				return $max_posts_per_page;
			}

			return $posts_per_page;
		}

		/**
		 * pre_get_posts filter that add sticky posts to taxonomy
		 *
		 * @param $q
		 */
		public function sticky_posts_fix( $q ) {
			remove_action( 'pre_get_posts', array( $this, 'sticky_posts_fix' ) );

			// Set is_home to true.
			$q->is_home = true;

			if ( ! $q->get( 'tax_query' ) ) {
				return;
			}

			// Get all stickies
			$stickies = get_option( 'sticky_posts' );
			// Make sure we have stickies, if not, bail.
			if ( !$stickies ) {
				return;
			}

			// Query the stickies according to category.
			$args = array(
				'post__in'            => $stickies,
				'posts_per_page'      => -1,
				'ignore_sticky_posts' => 1,
				'tax_query'           => $q->get( 'tax_query' ),
				'orderby'             => 'post__in',
				'order'               => 'ASC',
				'fields'              => 'ids',
			);
			$valid_sticky_query = new WP_Query( $args );
			$valid_sticky_ids = $valid_sticky_query->posts;

			// Make sure we have valid ids.
			if ( !$valid_sticky_ids ) {
				$q->set( 'post__not_in', $stickies );
				return;
			}

			// Remove these ids from the sticky posts array.
			$invalid_ids = array_diff( $stickies, $valid_sticky_ids );

			// Check if we still have ids left in $invalid_ids.
			if ( !$invalid_ids ) {
				return;
			}

			// Lets remove these invalid ids from our query.
			$q->set( 'post__not_in', $invalid_ids );
		}

		protected function get_posts_filter_terms( $query ) {
			$post_type = $this->get_att( 'post_type' );
			$data = $this->get_att( $post_type );

			// If empty - return all categories.
			if ( empty( $data ) ) {
				return get_terms( array(
					'taxonomy'   => 'dt_team_category',
					'hide_empty' => true,
				) );
			}

			// If posts selected - return corresponded categories.
			if ( 'posts' === $post_type ) {
				$post_ids = presscore_sanitize_explode_string( $data );

				return wp_get_object_terms( $post_ids, 'dt_team_category', array( 'fields' => 'all_with_object_id' ) );
			}

			// If categories selected.
			if ( 'category' === $post_type ) {
				$get_terms_args = array(
					'taxonomy'   => 'dt_team_category',
					'hide_empty' => true,
				);

				$categories = presscore_sanitize_explode_string( $data );
				if ( ! is_numeric( $categories[0] ) ) {
					$get_terms_args['slug'] = $categories;
				} else {
					$get_terms_args['include'] = $categories;
				}

				return get_terms( $get_terms_args );
			}
		}
	}

	// create shortcode
	DT_Shortcode_Team_Masonry::get_instance()->add_shortcode();
endif;
