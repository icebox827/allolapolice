<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DT_Shortcode_GalleryMasonry', false ) ):

	class DT_Shortcode_GalleryMasonry extends The7pt_Shortcode_With_Inline_CSS {

		/**
		 * @var DT_Shortcode_GalleryMasonry
		 */
		public static $instance;

		/**
		 * @return DT_Shortcode_GalleryMasonry
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * DT_Shortcode_GalleryMasonry constructor.
		 */
		public function __construct() {
			$this->sc_name           = 'dt_gallery_photos_masonry';
			$this->unique_class_base = 'gallery-photos-masonry-shortcode-id';
			$this->taxonomy = 'dt_gallery_category';
			$this->post_type = 'dt_gallery';
			$this->default_atts      = array(
				'post_type'                      => 'category',
				'category'                       => '',
				'posts'                          => '',
				'mode'                           => 'masonry',
				'loading_effect'                 => 'none',
				'gap_between_posts'              => '5px',
				'image_sizing'                   => 'proportional',
				'resized_image_dimensions'       => '1x1',
				'image_scale_animation_on_hover' => 'quick_scale',
				'image_hover_bg_color'           => 'default',
				'image_border_radius'            => '0px',
				'image_decoration'   			 => 'none',
				'shadow_h_length'    			 => '0px',
				'shadow_v_length'    			 => '4px',
				'shadow_blur_radius' 			 => '12px',
				'shadow_spread'      			 => '3px',
				'shadow_color'       			 => 'rgba(0,0,0,.25)',
				'custom_rollover_bg_color'       => 'rgba(0,0,0,0.5)',
				'custom_rollover_bg_gradient'    => '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
				'hover_animation'                => 'fade',
				'responsiveness'                 => 'browser_width_based',
				'bwb_columns'                    => 'desktop:6|h_tablet:4|v_tablet:3|phone:2',
				'pwb_column_min_width'           => '',
				'pwb_columns'                    => '',
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
				'order'                          => 'desc',
				'orderby'                        => 'date',
				'show_zoom'                      => 'y',
				'gallery_image_zoom_icon'        => 'icomoon-the7-font-the7-zoom-06',
				'project_icon_size'              => '32px',
				'dt_project_icon'                => '',
				'project_icon_bg_size'           => '44px',
				'project_icon_border_width'      => '0',
				'project_icon_border_radius'     => '100px',
				'project_icon_color'             => 'rgba(255,255,255,1)',
				'project_icon_border_color'      => '',
				'project_icon_bg'                => 'n',
				'project_icon_bg_color'          => 'rgba(255,255,255,0.3)',
				'navigation_font_color'          => '',
				'navigation_accent_color'        => '',
				'css_dt_gallery'                 => '',
			);

			parent::__construct();
		}

		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			$post_type = $this->get_att( 'post_type' );
			$media_items = array(0);

			$loading_mode = $this->get_att( 'loading_mode' );

			$data_post_limit = '-1';
			switch ( $loading_mode ) {
				case 'js_pagination':
					$data_post_limit = $this->get_att( 'jsp_posts_per_page', 10 );
					break;
				case 'js_more':
					$data_post_limit = $this->get_att( 'jsm_posts_per_page', 10 );
					break;
				case 'js_lazy_loading':
					$data_post_limit = $this->get_att( 'jsl_posts_per_page', 10 );
					break;
			}

			if ( 'disabled' === $loading_mode ) {
				$data_pagination_mode = 'none';
			} else if ( in_array( $loading_mode, array( 'js_more', 'js_lazy_loading' ) ) ) {
				$data_pagination_mode = 'load-more';
			} else {
				$data_pagination_mode = 'pages';
			}
			$data_atts_array = array(
				'post-limit'      => (int) $data_post_limit,
				'pagination-mode' => esc_attr( $data_pagination_mode ),
			);

			//Hover icon
			$show_icon_zoom = '';
			if ( $this->get_att( 'show_zoom' ) === 'y' ) {
				$show_icon_zoom = '<span class="gallery-zoom-ico ' . esc_attr( $this->get_att( 'gallery_image_zoom_icon' ) ) . '"><span></span></span>';
			}

			//Responsiveness
			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$data_atts_array          = the7_shortcode_add_responsive_columns_data_attributes( $data_atts_array, $this->get_att( 'bwb_columns' ) );
			} 

			$data_atts_str = presscore_get_inlide_data_attr( $data_atts_array );
			

			echo '<div ' . $this->container_class( 'gallery-shortcode album-gallery-shortcode dt-gallery-container' ) . presscore_masonry_container_data_atts( $data_atts_str ) . '>';

			presscore_add_masonry_lazy_load_attrs();

				echo '<div ' . $this->iso_container_class() . '>';
					do_action( 'presscore_before_post' );
					presscore_populate_album_post_config();

					
					$dt_query = $this->get_albums_attachments( array(
						'orderby' => $this->atts['orderby'],
						'order' => $this->atts['order'],
						'number' => $this->get_posts_per_page( $loading_mode ),
						//'select' => $this->atts['select'],
						'category' => $this->atts['category']
					) );
					$post_class_array = array(
						'post',
						'visible',
					);

					while( $dt_query->have_posts() ) { 
						$dt_query->the_post();
						$img_id = get_the_ID();
						echo '<div ' . presscore_tpl_masonry_item_wrap_class(  ) . presscore_tpl_masonry_item_wrap_data_attr() . '>';
						
							echo '<article ' . $this->post_class( $post_class_array ) . '>';

								$content = presscore_mod_albums_get_photo_description();
								$img_class = 'alignnone rollover';
								if ( presscore_get_image_video_url( $img_id ) ) {
									$img_class .= ' rollover-video';
								} else if ( presscore_get_image_link( $img_id ) ) {
									// Do nothing.
								} else {
									$img_class .= ' rollover-zoom';
								}

								$thumb_meta = wp_get_attachment_image_src( $img_id, 'full' );
								$thumb_title = presscore_image_title_enabled( $img_id ) ? get_the_title() : false;

								$thumb_args = array(
									'echo'				=> false,
									'img_meta' 			=> $thumb_meta,
									'img_id'			=> $img_id,
									'img_class' 		=> 'preload-me',
									'class'				=> ' rollover-click-target rollover',
									'img_description'	=> get_the_content(),
									'title'				=> $thumb_title,
									'options'			=> presscore_set_image_dimesions(),
									'wrap'				=> '<a %HREF% %CLASS% %TITLE% data-dt-img-description="%RAW_IMG_DESCRIPTION%"  data-large_image_width="' . $thumb_meta[1] . '" data-large_image_height = "' . $thumb_meta[2]. '" %CUSTOM%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /><span class="gallery-rollover">' . $show_icon_zoom . '</span></a>'
								);

								$video_url = presscore_get_image_video_url( $img_id );
								$image_link = presscore_get_image_link( $img_id );

								if ( $video_url ) {
									$thumb_args['class'] .= ' dt-pswp-item pswp-video';
									$thumb_args['href'] = $video_url;
								} else if ( $image_link ) {
									$thumb_args['href'] = $image_link;
									$thumb_args['custom'] = ' target="_blank"';
								} else {
									$thumb_args['class'] .= ' dt-pswp-item';
								}

								// set proportion
								$thumb_args = presscore_add_thumbnail_class_for_masonry( $thumb_args );

								if ( of_get_option( 'social_buttons-photo' ) ) {
									$thumb_args = presscore_mod_albums_share_buttons_link( $thumb_args );
								}

								$image =  dt_get_thumb_img( $thumb_args );
							
								$template_args = array(
									'image'				=> $image,
									'content'			=> $content,
									'figure_class'		=> 'links-hovers-disabled',
								);
								echo $image;
								

						echo '</article>';
					echo '</div>';
					}
				echo '</div><!-- iso-container|iso-grid -->';

				presscore_remove_masonry_lazy_load_attrs();

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
				dt_paginator( $dt_query, array( 'class' => 'paginator' ) );
			}

			echo '</div>';

			do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
		}
		/**
		 * Return post classes.
		 *
		 * @param string|array $class
		 *
		 * @return string
		 */
		protected function post_class( $class = array() ) {
			if ( ! is_array( $class ) ) {
				$class = explode( ' ', $class );
			}

			return 'class="' . join( ' ', get_post_class( $class, null ) ) . '"';
		}

		/**
		 * Return container class attribute.
		 *
		 * @param array|string $class
		 *
		 * @return string
		 */
		protected function container_class( $class = array() ) {
			if ( ! is_array( $class ) ) {
				$class = explode( ' ', $class );
			}

			// Unique class.
			$class[] = $this->get_unique_class();

			$mode_classes = array(
				'masonry' => 'mode-masonry',
				'grid'    => 'mode-grid',
			);

			$mode = $this->get_att( 'mode' );
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
			if ( $this->get_flag( 'project_icon_bg' ) ) {
				$class[] = 'dt-icon-bg-on';
			} else {
				$class[] = 'dt-icon-bg-off';
			}
			if ( 'shadow' === $this->atts['image_decoration'] ) {
				$class[] = 'enable-img-shadow';
			}
			switch ( $this->get_att( 'image_scale_animation_on_hover' ) ) {
				case 'quick_scale':
					$class[] = 'quick-scale-img';
					break;
				case 'slow_scale':
					$class[] = 'scale-img';
					break;
			}

			if ( 'grid' === $this->get_att( 'mode' ) ) {
				$class[] = 'dt-css-grid-wrap';
			}

			if ( 'disabled' !== $this->get_att( 'image_hover_bg_color' ) ) {
				$class[] = 'enable-bg-rollover';
			}

			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$class[] = 'resize-by-browser-width';
			}

			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->get_att( 'css_dt_gallery' ), ' ' );
			}

			// Dirty hack to remove .iso-container and .iso-grid
			$config = presscore_config();
			$layout = $config->get( 'layout' );
			$config->set( 'layout', false );

			$class[] = presscore_tpl_get_hover_anim_class( $config->get( 'post.preview.hover.animation' ) );

			$class_str = presscore_masonry_container_class( $class );
			$class_str = str_replace( 'content-align-centre', '', $class_str );

			// Restore original 'layout'.
			$config->set( 'layout', $layout );

			return $class_str;
		}

		/**
		 * Iso container class.
		 *
		 * @param array $class
		 *
		 * @return string
		 */
		protected function iso_container_class( $class = array() ) {
			if ( 'grid' === $this->get_att( 'mode' ) ) {
				$class[] = 'dt-css-grid';
			} else {
				$class[] = 'iso-container';
			}

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '" ';
		}

		/**
		 * Return shortcode less file absolute path to output inline.
		 *
		 * @return string
		 */
		protected function get_less_file_name() {
			return The7PT()->plugin_path() . 'assets/css/shortcodes/gallery.less';
		}

		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();

			$config->set( 'template', 'media' );
			$config->set( 'load_style', 'default' );
			$config->set( 'layout', $this->get_att( 'mode' ) );
			$config->set( 'post.preview.load.effect', $this->get_att( 'loading_effect' ), 'none' );
			$config->set( 'image_layout', ( 'resize' === $this->get_att( 'image_sizing' ) ? $this->get_att( 'image_sizing' ) : 'original' ) );
			$config->set( 'thumb_proportions', '' );
			$config->set( 'post.preview.width.min', $this->get_att( 'pwb_column_min_width' ) );
			$config->set( 'template.columns.number', $this->get_att( 'pwb_columns' ) );
			$config->set( 'post.preview.hover.animation', $this->get_att( 'hover_animation' ) );
			$config->set( 'item_padding', $this->get_att( 'gap_between_posts' ) );
			if ( 'standard' === $this->get_att( 'loading_mode' ) ) {
				$config->set( 'show_all_pages', $this->get_flag( 'st_show_all_pages' ) );

				// Allow sorting from request.
				if ( ! $config->get( 'order' ) ) {
					$config->set( 'order', $this->get_att( 'order' ) );
				}

				if ( ! $config->get( 'orderby' ) ) {
					$config->set( 'orderby', $this->get_att( 'orderby' ) );
				}
			} else {
				$config->set( 'show_all_pages', $this->get_flag( 'jsp_show_all_pages' ) );

				$config->set( 'request_display', false );
				$config->set( 'order', $this->get_att( 'order' ) );
				$config->set( 'orderby', $this->get_att( 'orderby' ) );
			}
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
		}

		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'gallery-shortcode.' . $this->get_unique_class(), '~"%s"' );

			$less_vars->add_pixel_number( 'media-image-border-radius', $this->get_att( 'image_border_radius' ) );

			switch ( $this->get_att( 'image_hover_bg_color' ) ) {
				case 'gradient_rollover_bg':
					$first_color = 'rgba(0,0,0,0.6)';
					$gradient    = '';
					if ( function_exists( 'the7_less_prepare_gradient_var' ) ) {
						list( $first_color, $gradient ) = the7_less_prepare_gradient_var( $this->get_att( 'custom_rollover_bg_gradient' ) );
					}
					$less_vars->add_rgba_color( 'portfolio-rollover-bg', $first_color );
					$less_vars->add_keyword( 'portfolio-rollover-bg-gradient', $gradient );
					break;
				case 'solid_rollover_bg':
					$less_vars->add_keyword( 'portfolio-rollover-bg', $this->get_att( 'custom_rollover_bg_color', '~""' ) );
					break;
			}

			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$columns_attributes = the7_shortcode_add_responsive_columns_data_attributes( array(), $this->get_att( 'bwb_columns' ) );
				foreach ( $columns_attributes as $column => $val ) {
					$less_vars->add_keyword( $column, $val );
				}
			}

			$less_vars->add_pixel_number( 'grid-posts-gap', $this->get_att( 'gap_between_posts' ) );
			$less_vars->add_pixel_number( 'grid-post-min-width', $this->get_att( 'pwb_column_min_width' ) );

			$shadow_style = '';
			if ( 'shadow' === $this->atts['image_decoration'] ) {
				$shadow_style = join( ' ', array(
						$this->atts['shadow_h_length'],
						$this->atts['shadow_v_length'],
						$this->atts['shadow_blur_radius'],
						$this->atts['shadow_spread'],
						$this->atts['shadow_color'],
					) );
			}
			$less_vars->add_keyword( 'portfolio-img-shadow', $shadow_style );
			$less_vars->add_pixel_number( 'shortcode-filter-gap', $this->get_att( 'gap_below_category_filter', '' ) );
			$less_vars->add_keyword( 'shortcode-filter-color', $this->get_att( 'navigation_font_color', '~""' ) );
			$less_vars->add_keyword( 'shortcode-filter-accent', $this->get_att( 'navigation_accent_color', '~""' ) );

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

			$less_vars->add_pixel_number( 'project-icon-size', $this->get_att( 'project_icon_size' ) );
			$less_vars->add_pixel_number( 'project-icon-bg-size', $this->get_att( 'project_icon_bg_size' ) );
			$less_vars->add_pixel_number( 'project-icon-border-width', $this->get_att( 'project_icon_border_width' ) );
			$less_vars->add_pixel_number( 'project-icon-border-radius', $this->get_att( 'project_icon_border_radius' ) );
			$less_vars->add_keyword( 'project-icon-color', $this->get_att( 'project_icon_color', '~""' ) );
			$less_vars->add_keyword( 'project-icon-border-color', $this->get_att( 'project_icon_border_color', '~""' ) );
			$less_vars->add_keyword( 'project-icon-bg-color', $this->get_att( 'project_icon_bg_color', '~""' ) );

			return $less_vars->get_vars();
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {
			return $this->vc_inline_dummy( array(
				'class' => 'dt_vc-gallery_masonry',
				'img'   => array( PRESSCORE_SHORTCODES_URI . '/images/icon-media-gallery-grid.png', 32, 32 ),
				'title' => _x( 'Gallery masonry & grid', 'vc inline dummy', 'dt-the7-core' ),
				'style' => array( 'height' => 'auto' ),
			) );
		}

		protected function get_albums_attachments( $args = array() ) {
			$post_type = $this->get_att( 'post_type' );
			$defaults = array(
				'orderby' => 'date',
				'order' => 'DESC',
				'number' => false,
				'category' => array(),
				//'select' => 'all'
			);

			$args = wp_parse_args( $args, $defaults );

			if ( 'posts' === $post_type ) {
				$page_query = $this->get_posts_by_post_type( 'dt_gallery', $this->get_att( 'posts' ) );
				
			} else {
				$category_terms = presscore_sanitize_explode_string( $this->get_att( 'category' ) );
				$category_field = ( is_numeric( $category_terms[0] ) ? 'term_id' : 'slug' );

				$page_query = $this->get_posts_by_taxonomy( 'dt_gallery', 'dt_gallery_category', $category_terms, $category_field );
			}

			//$page_query = $this->get_posts_by_terms( $args );

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
			$pagination_mode = $this->get_att( 'loading_mode' );
			$posts_per_page = $this->get_posts_per_page( $pagination_mode );

			if ( $args['number'] ) {
				$media_args['posts_per_page'] = $posts_per_page ;
			}
			if ( 'standard' === $pagination_mode ) {
				$media_args['paged'] = dt_get_paged_var();
			}

			return new WP_Query( $media_args );
		}
		/**
		 * Return query args.
		 *
		 * @return array
		 */
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
					'suppress_filters' => false,
					'post__in'         => $post_ids,
				);

				$request = $config->get( 'request_display' );
				if ( ! empty( $request['terms_ids'] ) ) {
					$query_args['tax_query'] = array(
						array(
							'taxonomy' => 'dt_gallery_category',
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
		protected function get_posts_per_page( $pagination_mode ) {
			$posts_per_page = - 1;
			switch ( $pagination_mode ) {
				case 'disabled':
					$posts_per_page = $this->get_att( 'dis_posts_total' );
					break;
				case 'standard':
					$posts_per_page = $this->get_att( 'st_posts_per_page' );
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
			}

			return $posts_per_page;
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
						'taxonomy' => 'dt_gallery_category',
						'field'    => 'term_id',
						'terms'    => $request['terms_ids'],
					);
					$tax_query['relation'] = 'AND';
				}

				$query_args['orderby'] = $config->get( 'orderby' );
				$query_args['order'] = $config->get( 'order' );
			} else {
				// JS pagination.
				$query_args['orderby'] = $this->get_att( 'orderby' );
				$query_args['order'] = $this->get_att( 'order' );
				$query_args['paged'] = 1;
			}

			if ( $tax_query ) {
				$query_args['tax_query'] = $tax_query;
			}

			return new WP_Query( $query_args );
		}

	}

	DT_Shortcode_GalleryMasonry::get_instance()->add_shortcode();

endif;