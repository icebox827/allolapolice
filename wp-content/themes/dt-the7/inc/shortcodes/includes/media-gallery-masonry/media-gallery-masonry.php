<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'DT_Shortcode_MediaGalleryMasonry', false ) ):

	class DT_Shortcode_MediaGalleryMasonry extends DT_Shortcode_With_Inline_Css {

		/**
		 * @var DT_Shortcode_MediaGalleryMasonry
		 */
		public static $instance;

		/**
		 * @return DT_Shortcode_MediaGalleryMasonry
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * DT_Shortcode_MediaGalleryMasonry constructor.
		 */
		public function __construct() {
			$this->sc_name           = 'dt_gallery_masonry';
			$this->unique_class_base = 'gallery-masonry-shortcode-id';
			$this->default_atts = array(
				'include'                        => 'include',
				'mode'                           => 'masonry',
				'loading_effect'                 => 'none',
				'gap_between_posts'              => '5px',
				'image_sizing'                   => 'proportional',
				'resized_image_dimensions'       => '1x1',
				'image_scale_animation_on_hover' => 'quick_scale',
				'image_border_radius'            => '0px',
				'image_decoration'               => 'none',
				'shadow_h_length'                => '0px',
				'shadow_v_length'                => '4px',
				'shadow_blur_radius'             => '12px',
				'shadow_spread'                  => '3px',
				'shadow_color'                   => 'rgba(0,0,0,.25)',
				'image_hover_bg_color'           => 'default',
				'custom_rollover_bg_color'       => 'rgba(0,0,0,0.5)',
				'custom_rollover_bg_gradient'    => '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
				'hover_animation'                => 'fade',
				'responsiveness'                 => 'browser_width_based',
				'bwb_columns'                    => 'desktop:6|h_tablet:4|v_tablet:3|phone:2',
				'pwb_column_min_width'           => '',
				'pwb_columns'                    => '',
				'loading_mode'                   => 'disabled',
				'jsp_posts_total'                => '-1',
				'jsp_posts_per_page'             => '',
				'jsp_show_all_pages'             => 'n',
				'jsp_gap_before_pagination'      => '',
				'jsm_posts_total'                => '-1',
				'jsm_posts_per_page'             => '',
				'jsm_gap_before_pagination'      => '',
				'jsl_posts_total'                => '-1',
				'jsl_posts_per_page'             => '',
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
				'on_click'                       => 'popup',
			);

			parent::__construct();
		}

		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
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

			$show_icon_zoom = '';
			if ( $this->get_att( 'show_zoom' ) === 'y' ) {
				$show_icon_zoom = '<span class="gallery-zoom-ico ' . esc_attr( $this->get_att( 'gallery_image_zoom_icon' ) ) . '"><span></span></span>';
			}

			$data_atts_array = array(
				'post-limit'      => (int) $data_post_limit,
				'pagination-mode' => esc_attr( $data_pagination_mode ),
			);

			$config = presscore_config();
			$image_is_wide = ( 'wide' === $config->get( 'post.preview.width' ) && ! $config->get( 'all_the_same_width' ) );

			if ( 'browser_width_based' === $this->get_att( 'responsiveness' ) ) {
				$data_atts_array = the7_shortcode_add_responsive_columns_data_attributes(
					$data_atts_array,
					$this->get_att( 'bwb_columns' )
				);

				$thumb_img_resize_options = the7_calculate_bwb_image_resize_options(
					DT_VCResponsiveColumnsParam::decode_columns( $this->get_att( 'bwb_columns' ) ),
					$this->get_att( 'gap_between_posts' ),
					$image_is_wide
				);
			} else {
				$thumb_img_resize_options = the7_calculate_columns_based_image_resize_options(
					$this->get_att( 'pwb_column_min_width' ),
					$config->get( 'template.content.width' ),
					$this->get_att( 'pwb_columns' ),
					$image_is_wide
				);
			}

			$data_atts_str = presscore_get_inlide_data_attr( $data_atts_array );

			echo '<div ' . $this->container_class( 'gallery-shortcode dt-gallery-container' ) . presscore_masonry_container_data_atts( $data_atts_str ) . '>';

			presscore_add_masonry_lazy_load_attrs();

			echo '<div ' . $this->iso_container_class() . '>';

			$image_ids = explode( ',', $this->get_att( 'include' ) );
			$query     = new WP_Query( array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post__in'       => $image_ids,
				'posts_per_page' => '-1',
				'orderby'        => 'post__in',
			) );

			global $post;

			$popup_on_click = $this->get_att( 'on_click' ) === 'popup';
			while ( $query->have_posts() ) {
				$query->the_post();

				$image_data_array = wp_get_attachment_image_src( $post->ID, 'full' );
				if ( ! $image_data_array ) {
					continue;
				}

				$img_title = '';
				$video_url = esc_url( get_post_meta( $post->ID, 'dt-video-url', true ) );
				if ( presscore_image_title_enabled( $post->ID ) ) {
					$img_title = get_the_title();
				}

				echo '<div ' . presscore_tpl_masonry_item_wrap_class() . presscore_tpl_masonry_item_wrap_data_attr() . '>';

				$thumb_args = array(
					'wrap'     => '<figure class="post visible"><span %CLASS% %CUSTOM% %TITLE%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /><span class="gallery-rollover">' . $show_icon_zoom . '</span></span></figure>',
					'img_meta' => $image_data_array,
					'class'    => 'rollover',
					'title'    => $img_title,
					'alt'      => get_post_meta( $post->ID, '_wp_attachment_image_alt', true ),
					'echo'     => true,
					'options'  => $thumb_img_resize_options,
				);

				if ( $popup_on_click ) {
					$thumb_args['wrap'] = '<figure class="post visible"><a %HREF% %CLASS% %CUSTOM% %TITLE%><img %IMG_CLASS% %SRC% %ALT% %SIZE% /><span class="gallery-rollover">' . $show_icon_zoom . '</span></a></figure>';
					$thumb_args['class'] .= ' dt-pswp-item';
					$thumb_args['custom'] = presscore_get_inlide_data_attr( array(
						'large_image_width'  => esc_attr( $image_data_array[1] ),
						'large_image_height' => esc_attr( $image_data_array[2] ),
						'dt-img-description' => esc_attr( get_the_content() ),
					) );
				}

				if ( $video_url ) {
					$thumb_args['href'] = $video_url;
					if ( $popup_on_click ) {
						$thumb_args['class'] .= ' pswp-video';
					}
				}

				if ( $this->get_att( 'image_sizing' ) === 'resize' ) {
					list( $thumb_width, $thumb_height ) = the7_shortcode_decode_image_dimension( $this->get_att( 'resized_image_dimensions' ) );
					$thumb_args['prop'] = the7_get_image_proportion( $thumb_width, $thumb_height );
				}

				dt_get_thumb_img( $thumb_args );

				echo '</div>';
			}

			echo '</div><!-- iso-container|iso-grid -->';

			presscore_remove_masonry_lazy_load_attrs();

			if ( 'disabled' === $loading_mode ) {
				// Do not output pagination.
			} else if ( in_array( $loading_mode, array( 'js_more', 'js_lazy_loading' ) ) ) {
				// JS load more.
				echo dt_get_next_page_button( 2, 'paginator paginator-more-button' );
			} else if ( 'js_pagination' === $loading_mode ) {
				// JS pagination.
				echo '<div class="paginator" role="navigation"></div>';
			} else {
				// Pagination.
				dt_paginator( $image_ids, array( 'class' => 'paginator' ) );
			}

			echo '</div>';

			do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
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
			return get_template_directory() . '/css/dynamic-less/shortcodes/gallery.less';
		}

		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			$config = presscore_config();

			$config->set( 'load_style', 'default' );
			$config->set( 'layout', $this->get_att( 'mode' ) );
			$config->set( 'post.preview.load.effect', $this->get_att( 'loading_effect' ), 'none' );
			$config->set( 'image_layout', ( 'resize' === $this->get_att( 'image_sizing' ) ? $this->get_att( 'image_sizing' ) : 'original' ) );
			$config->set( 'thumb_proportions', '' );
			$config->set( 'post.preview.width.min', $this->get_att( 'pwb_column_min_width' ) );
			$config->set( 'template.columns.number', $this->get_att( 'pwb_columns' ) );
			$config->set( 'post.preview.hover.animation', $this->get_att( 'hover_animation' ) );
			$config->set( 'item_padding', $this->get_att( 'gap_between_posts' ) );
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
				'title' => _x( 'Media gallery masonry & grid', 'vc inline dummy', 'the7mk2' ),
				'style' => array( 'height' => 'auto' ),
			) );
		}

	}

	DT_Shortcode_MediaGalleryMasonry::get_instance()->add_shortcode();

endif;