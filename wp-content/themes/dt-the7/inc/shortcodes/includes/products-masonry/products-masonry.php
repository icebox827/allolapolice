<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'DT_Shortcode_ProductsMasonry', false ) ):

	class DT_Shortcode_ProductsMasonry extends DT_Shortcode_With_Inline_Css {

		/**
		 * @var string
		 */
		protected $post_type;

		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Shortcode_ProductsMasonry
		 */
		public static $instance = null;

		/**
		 * @return DT_Shortcode_ProductsMasonry
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * DT_Shortcode_ProductsMasonry constructor.
		 */
		public function __construct() {
			$this->sc_name = 'dt_products_masonry';
			$this->unique_class_base = 'products-masonry-shortcode-id';
			$this->post_type = 'product';
			$this->default_atts = array(
				'show_products' => 'all_products',
				'orderby' => 'date',
				'order' => 'desc',
				'layout' => 'content_below_img',
				'ids' => '',
				'skus' => '',
				'category_ids'    => '',
				'mode' => 'masonry',
				'gap_between_posts' => '15px',
				'responsiveness' => 'browser_width_based',
				'bwb_columns' => 'desktop:4|h_tablet:3|v_tablet:2|phone:1',
				'pwb_column_min_width' => '',
				'pwb_columns'                    => '',
				'loading_mode' => 'disabled',
				'dis_posts_total' => '-1',
				'st_posts_per_page' => '',
				'st_show_all_pages' => 'n',
				'st_gap_before_pagination' => '',
				'jsp_posts_total' => '-1',
				'jsp_posts_per_page' => '',
				'jsp_show_all_pages' => 'n',
				'jsp_gap_before_pagination' => '',
				'jsm_posts_total' => '-1',
				'jsm_posts_per_page' => '',
				'jsm_gap_before_pagination' => '',
				'jsl_posts_total' => '-1',
				'jsl_posts_per_page' => '',
				'custom_title_color' => '',
				'custom_content_color' => '',
				'custom_price_color' => '',
				'product_descr' => 'n',
				'product_rating' => 'y',
				'navigation_font_color' => '',
				'navigation_accent_color' => '',
				'show_categories_filter' => 'n',
				'gap_below_category_filter' => '',
			);

			parent::__construct();
		}

		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			// Loop query.
			$query = new WP_Query( $this->get_query_args() );

			do_action( 'presscore_before_shortcode_loop', $this->sc_name, $this->atts );
			add_action( 'dt_wc_loop_start', array( $this, '_setup_config' ), 15 );
            do_action( 'dt_wc_loop_start' );
            remove_action( 'dt_wc_loop_start', array( $this, '_setup_config' ), 15 );
            $this->_setup_config();
			do_action( 'presscore_before_loop' );

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

			echo '<div ' . $this->container_class( 'products-shortcode' ) . presscore_masonry_container_data_atts( $data_atts ) . '>';

			$filter_class = array( 'iso-filter' );

			if ( 'standard' == $loading_mode ) {
				$filter_class[] = 'without-isotope';
			}
			if ( 'grid' === $this->get_att( 'mode' ) ) {
				$filter_class[] = 'css-grid-filter';
			}

			if ( ! $this->get_flag( 'show_orderby_filter' ) && ! $this->get_flag( 'show_order_filter' ) ) {
				$filter_class[] = 'extras-off';
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

			DT_Blog_Shortcode_HTML::display_posts_filter( $terms, $filter_class );

			/**
			 * Products posts have a custom lazy loading classes.
			 */
			presscore_remove_lazy_load_attrs();

			echo '<div ' . $this->iso_container_class() . '>';

			// Start loop.
			if ( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();

				do_action('presscore_before_post');

				// populate config with current post settings
				presscore_populate_post_config();

				// Post visibility on the first page.
				$visibility = 'visible';
				if ( $data_post_limit >= 0 && $query->current_post >= $data_post_limit ) {
					$visibility = 'hidden';
				}

				$post_class_array = array(
					'post',
					'project-odd',
					'visible',
				);

				echo '<div ' . presscore_tpl_masonry_item_wrap_class( $visibility ) . presscore_tpl_masonry_item_wrap_data_attr() . '>';
				echo '<article ' . $this->post_class( $post_class_array ) . ' >';

				// Quick fix to prevent errors on page save when YoastSEO is active.
				if ( ! empty( $GLOBALS['product'] ) ) {
					woocommerce_show_product_loop_sale_flash();
					dt_woocommerce_template_product_desc_under();
				}

				echo '</article>';
				echo '</div>';

				do_action('presscore_after_post');

			endwhile; endif;
			if($this->get_att( 'show_products' ) == "top_products"){
				remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
			}
			wp_reset_postdata();

			echo '</div><!-- iso-container|iso-grid -->';

			presscore_add_lazy_load_attrs();

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
				dt_paginator( $query, array( 'class' => 'woocommerce-pagination paginator' ) );
			}

			echo '</div>';

			do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
			remove_filter( 'dt_woocommerce_get_product_preview_icons', 'dt_woocommerce_filter_product_preview_icons' );
            remove_action( 'woocommerce_after_shop_loop_item', 'dt_woocommerce_render_product_add_to_cart_icon', 40 );
			do_action( 'presscore_after_loop' );
			do_action( 'dt_wc_loop_end' );
		}


		/**
		 * Return container class attribute.
		 *
		 * @param array $class
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
				'grid' => 'mode-grid',
			);

			$mode = $this->get_att( 'mode' );
			if ( array_key_exists( $mode, $mode_classes ) ) {
				$class[] = $mode_classes[ $mode ];
			}

			$layout_classes = array(
				'content_below_img' => 'cart-btn-below-img',
				'btn_on_img' => 'cart-btn-on-img',
				'btn_on_img_hover' => 'cart-btn-on-hover cart-btn-on-img',
			);

			$layout = $this->get_att( 'layout' );
			if ( array_key_exists( $layout, $layout_classes ) ) {
				$class[] = $layout_classes[ $layout ];
			}
			if($this->atts['product_descr'] === 'n'){
				$class[] = 'hide-description';
			}
			if($this->atts['product_rating'] === 'n'){
				$class[] = 'hide-rating';
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

			if ( of_get_option( 'woocommerce_hover_image' ) ) {
				$class[] = 'wc-img-hover';
			}
			if ( 'grid' === $this->get_att( 'mode' ) ) {
				$class[] = 'dt-css-grid-wrap';
			}

			$class = $this->add_responsiveness_class( $class );

			// Dirty hack to remove .iso-container and .iso-grid
			$config = presscore_config();
			$layout = $config->get( 'layout' );
			$config->set( 'layout', false );

			$class_str = presscore_masonry_container_class( $class );

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

			return 'class="' . esc_attr( join( ' ', $class ) ) . '" ';
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
					'desktop' => 'desktop',
					'v_tablet' => 'v-tablet',
					'h_tablet' => 'h-tablet',
					'phone' => 'phone',
				);

				foreach ( $columns as $column => $data_att ) {
					$val = ( isset( $bwb_columns[ $column ] ) ? absint( $bwb_columns[ $column ] ) : '' );
					$data_atts[] = 'data-' . $data_att . '-columns-num="' . esc_attr( $val ) . '"';
				}
			}

			return $data_atts;
		}

		/**
		 * Return shortcode less file absolute path to output inline.
		 *
		 * @return string
		 */
		protected function get_less_file_name() {
			return get_template_directory() . '/css/dynamic-less/shortcodes/dt-products-masonry.less';
		}

		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {}

		public function _setup_config() {
			$config = presscore_config();
			$config->set( 'load_style', 'default' );
			$config->set( 'product.preview.show_rating', true );
			$config->set( 'product.preview.icons.show_cart', true );

			$wc_layout = 'masonry';
            switch ( $this->get_att( 'mode' ) ) {
                case 'grid':
                       $wc_layout = 'grid';
                    break;
              
            }

			$config->set( 'layout', $wc_layout );
			$config->set( 'post.preview.load.effect', 'none' );
			$config->set( 'post.preview.width.min', $this->get_att( 'pwb_column_min_width' ) );
			$config->set( 'template.columns.number', $this->get_att( 'pwb_columns' ) );
			$config->set( 'woocommerce_shop_template_responsiveness', $this->get_att( 'responsiveness' ) );

			$config->set( 'woocommerce_show_masonry_desc', $this->get_att( 'product_descr' ), true );
			$layout_map = array(
			    'content_below_img' => 'under_image',
			    'btn_on_img' => 'wc_btn_on_img',
			    'btn_on_img_hover' => 'wc_btn_on_hoover'
			);

			$layout = $this->get_att('layout');

			if ( array_key_exists( $layout, $layout_map ) ) {
			    $config->set( 'post.preview.description.style', $layout_map[ $layout ] );
			}
			$config->set( 'product.preview.add_to_cart.position', 'on_image' );
			 if ( 'standard' === $this->get_att( 'loading_mode' ) ) {
			 	$config->set( 'show_all_pages', $this->get_flag( 'st_show_all_pages' ) );

			} else {
				$config->set( 'show_all_pages', $this->get_flag( 'jsp_show_all_pages' ) );

				$config->set( 'request_display', false );
			}

			$config->set( 'template.posts_filter.terms.enabled', $this->get_flag( 'show_categories_filter' ) );
		}

		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'products-shortcode.' . $this->get_unique_class(), '~"%s"' );

			$less_vars->add_keyword( 'post-title-color', $this->get_att( 'custom_title_color', '~""') );
			$less_vars->add_keyword( 'post-content-color', $this->get_att( 'custom_content_color', '~""' ) );

			$less_vars->add_keyword( 'price-color', $this->get_att( 'custom_price_color', '~""' ) );
			

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
			$less_vars->add_pixel_number( 'shortcode-pagination-gap', $gap_before_pagination );
			$less_vars->add_keyword( 'shortcode-filter-color', $this->get_att( 'navigation_font_color', '~""' ) );
			$less_vars->add_keyword( 'shortcode-filter-accent', $this->get_att( 'navigation_accent_color', '~""' ) );
			$less_vars->add_pixel_number( 'shortcode-filter-gap', $this->get_att( 'gap_below_category_filter', '' ) );

			return $less_vars->get_vars();
		}

		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {

			return $this->vc_inline_dummy( array(
				'class'  => 'dt_vc-products_masonry',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_product_masonry_editor_ico.gif', 98, 104 ),
				'title'  => _x( 'Products Masonry & Grid', 'vc inline dummy', 'the7mk2' ),

				'style' => array( 'height' => 'auto' )
			) );
		}

		/**
		 * Return query args.
		 *
		 * @return array
		 */
		protected function get_query_args() {
			$pagination_mode = $this->get_att( 'loading_mode' );
			$posts_total = -1;
			global $woocommerce;
			switch ( $pagination_mode ) {
				case 'disabled':
					$posts_total = $this->get_att( 'dis_posts_total' );
					break;
				case 'standard':
					$posts_total = $this->get_att( 'st_posts_per_page' );
					break;
				case 'js_pagination':
					$posts_total = $this->get_att( 'jsp_posts_total' );
					break;
				case 'js_more':
					$posts_total = $this->get_att( 'jsm_posts_total' );
					break;
				case 'js_lazy_loading':
					$posts_total = $this->get_att( 'jsl_posts_total' );
					break;
			}

			$show_products_attd = $this->get_att( 'show_products' );
			$order = $this->get_att( 'order' );
			$orderby = $this->get_att( 'orderby' );
			if ( 'id' === $orderby ) {
				$orderby = 'ID';
			} elseif ( 'menu_order' === $orderby ) {
				$order = 'asc';
			}

			$meta_query = $tax_query = array();
			if($show_products_attd == "featured_products"){
				$meta_query  = WC()->query->get_meta_query();
				$tax_query   = WC()->query->get_tax_query();
				$tax_query[] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				);
			}
			if($show_products_attd == "top_products"){
				add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
				$meta_query = WC()->query->get_meta_query();
				$tax_query   = WC()->query->get_tax_query();
			}
			$terms_slugs = '';
			$query_args =  array(
				'post_type' => 'product',
        		'post_status'		  => 'publish',
				'ignore_sticky_posts'  => 1,
				'posts_per_page' 	   => $posts_total,
				'orderby' 			  => $orderby,
				'order' 				=> $order,
				'meta_query' 		   => $meta_query,
				'tax_query'           => $tax_query,
			);

			switch ( $show_products_attd ) {
				case 'all_products':
					$meta_query  = WC()->query->get_meta_query();
					$tax_query   = WC()->query->get_tax_query();
					if ( ! empty( $this->atts['skus'] ) ) {
						$query_args['meta_query'][] = array(
							'key'     => '_sku',
							'value'   => array_map( 'trim', explode( ',', $this->atts['skus'] ) ),
							'compare' => 'IN',
						);
					}

					if ( ! empty( $this->atts['ids'] ) ) {
						$query_args['post__in'] = array_map( 'trim', explode( ',', $this->atts['ids'] ) );
					}
					break;
				case 'sale_products':
					$product_ids_on_sale = wc_get_product_ids_on_sale();
					$meta_query = array();
					$meta_query[] = $woocommerce->query->visibility_meta_query();
					$meta_query[] = $woocommerce->query->stock_status_meta_query();
					$query_args['meta_query'] = $meta_query;
					$query_args['post__in'] = $product_ids_on_sale;
	            	break;
	            case 'best_selling_products':
		            $query_args['meta_key'] = 'total_sales';
					$query_args['orderby'] = 'meta_value_num';
					$meta_query = WC()->query->get_meta_query();
					$tax_query   = WC()->query->get_tax_query();
					break;
				case 'categories_products':

					if ( ! empty( $this->atts['category_ids'] ) ) {
						$ids        = array_filter( array_map( 'trim', explode( ',', $this->atts['category_ids'] ) ) );
						$query_args['tax_query'] = array(
							array(
								'taxonomy' 	 => 'product_cat',
								'terms' 		=> $ids,
								'field' 		=> 'term_id',
								'operator' 	 => 'IN'
							)
						);
					}else{
						$meta_query  = WC()->query->get_meta_query();
						$tax_query   = WC()->query->get_tax_query();

					}
					break;
			}
			//For standard pagination mode.
			if ( 'standard' == $pagination_mode ) {
				$query_args['paged'] = the7_get_paged_var();

				// Posts filter part.
				$config = presscore_config();
				$request = $config->get( 'request_display' );
				if ( ! empty( $request['terms_ids'] ) ) {
					if ( ! empty( $query_args['tax_query'] ) ) {
						$query_args['tax_query']['relation'] = 'AND';
					} else {
						$query_args['tax_query'] = array();
					}

					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $request['terms_ids'],
					);
				}
			}

			$query_args['tax_query'] = the7_product_visibility_tax_query( $query_args['tax_query'] );

			return $query_args;
		}

		/**
		 * Get terms to show in posts filter.
		 *
		 * @param $query
		 *
		 * @return array|int|WP_Error
		 */
		protected function get_posts_filter_terms( $query ) {
			$show_products = $this->get_att( 'show_products' );

			if ( 'sale_products' === $show_products ) {
				$post_ids = wc_get_product_ids_on_sale();

				return wp_get_object_terms( $post_ids, 'product_cat', array( 'fields' => 'all_with_object_id' ) );
			}

			if ( 'featured_products' === $show_products ) {
				$posts_query = new WP_Query( array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
					'fields'              => 'ids',
					'tax_query'           => WC()->query->get_tax_query( array( array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					) ) ),
				) );

				$post_ids = $posts_query->posts;

				return wp_get_object_terms( $post_ids, 'product_cat', array( 'fields' => 'all_with_object_id' ) );
			}

			if ( 'top_products' === $show_products ) {
				$posts_query = new WP_Query( array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
					'fields'              => 'ids',
					'tax_query'           => WC()->query->get_tax_query(),
					'meta_query'          => WC()->query->get_meta_query(),
				) );

				$post_ids = $posts_query->posts;

				return wp_get_object_terms( $post_ids, 'product_cat', array( 'fields' => 'all_with_object_id' ) );
			}

			if ( 'best_selling_products' === $show_products ) {
				$posts_query = new WP_Query( array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
					'fields'              => 'ids',
					'meta_key'            => 'total_sales',
					'tax_query'           => WC()->query->get_tax_query(),
					'meta_query'          => WC()->query->get_meta_query(),
				) );

				$post_ids = $posts_query->posts;

				return wp_get_object_terms( $post_ids, 'product_cat', array( 'fields' => 'all_with_object_id' ) );
			}

			$show_products_data_map = array(
				'all_products' => 'ids',
				'categories_products' => 'category_ids',
			);
			$data_key = ( array_key_exists( $show_products, $show_products_data_map ) ? $show_products_data_map[ $show_products ] : '' );
			$data = $this->get_att( $data_key );

			// If empty - return all categories.
			if ( empty( $data ) ) {
				return get_terms( array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
				) );
			}

			// If posts selected - return corresponded categories.
			if ( 'all_products' === $show_products ) {
				$post_ids = presscore_sanitize_explode_string( $data );

				return wp_get_object_terms( $post_ids, 'product_cat', array( 'fields' => 'all_with_object_id' ) );
			}

			// If categories selected.
			if ( 'categories_products' === $show_products ) {
				$get_terms_args = array(
					'taxonomy'   => 'product_cat',
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

			return array();
		}
	}

	DT_Shortcode_ProductsMasonry::get_instance()->add_shortcode();

endif;