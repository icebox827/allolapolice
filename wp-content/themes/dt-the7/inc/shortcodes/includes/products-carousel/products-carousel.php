<?php
/**
 * Products Carousel shortcode
 *
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'DT_Shortcode_Products_Carousel', false ) ) :

	class DT_Shortcode_Products_Carousel extends DT_Shortcode_With_Inline_Css {
		/**
		 * @var string
		 */
		protected $post_type;


		/**
		 * @var string
		 */
		protected $taxonomy;

		/**
		 * @var DT_Products_Shortcode_Carousel
		 */
		public static $instance = null;

		/**
		 * @return DT_Products_Shortcode_Carousel
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct() {
			$this->sc_name = 'dt_products_carousel';
			$this->unique_class_base = 'products-carousel-shortcode-id';
			$this->post_type = 'product';

			$this->default_atts = array(
				'show_products' => 'all_products',
				'order' => 'desc',
				'orderby' => 'date',
				'dis_posts_total' => '12',
				'layout' => 'content_below_img',
				'ids' => '',
				'skus' => '',
				'category_ids'    => '',
				'slide_to_scroll' => 'single',
				'slides_on_wide_desk' => '4',
				'slides_on_desk' => '3',
				'slides_on_lapt' => '3',
				'slides_on_h_tabs' => '3',
				'slides_on_v_tabs' => '2',
				'slides_on_mob' => '1',
				'adaptive_height' => 'y',
				'item_space' => '30',
				'stage_padding' => '0',
				'speed' => '600',
				'autoplay' => 'n',
				'autoplay_speed' => "6000",
				'product_descr' => 'n',
				'product_rating' => 'y',
				'custom_title_color' => '',
				'custom_content_color' => '',
				'custom_price_color' => '',
				'arrows' => 'y',
				'arrow_icon_size' => '18px',
				'r_arrow_icon_paddings' => '0 0 0 0',
				'l_arrow_icon_paddings' => '0 0 0 0',
				'arrow_bg_width' => "36px",
				'arrow_bg_height' => "36px",
				'arrow_border_radius' => '500px',
				'arrow_border_width' => '0',
				'arrow_icon_color' => '#ffffff',
				'arrow_icon_border' => 'y',
				'arrow_border_color' => '',
				'arrows_bg_show' => 'y',
				'arrow_bg_color' => '',
				'arrow_icon_color_hover' => 'rgba(255,255,255,0.75)',
				'arrow_icon_border_hover' => 'y',
				'arrow_border_color_hover' => '',
				'arrows_bg_hover_show' => 'y',
				'arrow_bg_color_hover' => '',
				'r_arrow_v_position' => 'center',
				'r_arrow_h_position' => 'right',
				'r_arrow_v_offset' => '0',
				'r_arrow_h_offset' => '-43px',
				'l_arrow_v_position' => 'center',
				'l_arrow_h_position' => 'left',
				'l_arrow_v_offset' => '0',
				'l_arrow_h_offset' => '-43px',
				'arrow_responsiveness' => 'reposition-arrows',
				'hide_arrows_mobile_switch_width' => '778px',
				'reposition_arrows_mobile_switch_width' => '778px',
				'l_arrows_mobile_h_position' => '10px',
				'r_arrows_mobile_h_position' => '10px',
				'show_bullets' => 'n',
				'bullets_style' => 'small-dot-stroke',
				'bullet_size' => '10px',
				'bullet_color' => '',
				'bullet_color_hover' => '',
				'bullet_gap' => "16px",
				'bullets_v_position' => 'bottom',
				'bullets_h_position' => 'center',
				'bullets_v_offset' => '20px',
				'bullets_h_offset' => '0',
				'next_icon' => 'icon-ar-017-r',
				'prev_icon' => 'icon-ar-017-l',
				'css_dt_blog_carousel' => '',
				'el_class' => '',
			);
			parent::__construct();
		}
		/**
		 * Do shortcode here.
		 */
		protected function do_shortcode( $atts, $content = '' ) {
			$query =  new WP_Query( $this->get_query_args() );

			do_action( 'presscore_before_shortcode_loop', $this->sc_name, $this->atts );

			add_action( 'dt_wc_loop_start', array( $this, '_setup_config' ), 15 );

            do_action( 'dt_wc_loop_start' );

            remove_action( 'dt_wc_loop_start', array( $this, '_setup_config' ), 15 );

			do_action( 'presscore_before_loop' );

			presscore_remove_posts_masonry_wrap();

			$this->_setup_config();
		
			echo '<div ' . $this->get_container_html_class( array( 'owl-carousel products-carousel-shortcode dt-owl-carousel-call' ) ) . ' ' . $this->get_container_data_atts() . '>';
				if ( $query->have_posts() ):

					$post_class_array = array(
						'post',
					);

					$lazy_loading_enabled = presscore_lazy_loading_enabled();
					if ( $lazy_loading_enabled ) {
						add_filter( 'wp_get_attachment_image_attributes', array( $this, 'add_owl_lazy_loading_class' ), 20 );
					}

					while ( $query->have_posts() ) : $query->the_post();
						do_action('presscore_before_post');

						echo '<article ' . $this->post_class( $post_class_array ) . ' >';

						// Quick fix to prevent errors on page save when YoastSEO is active.
						if ( ! empty( $GLOBALS['product'] ) ) {
							woocommerce_show_product_loop_sale_flash();
							dt_woocommerce_template_product_desc_under();
						}

						echo '</article>';

						do_action('presscore_after_post');
					endwhile;

					if ( $lazy_loading_enabled ) {
						remove_filter( 'wp_get_attachment_image_attributes', array( $this, 'add_owl_lazy_loading_class' ), 20 );
					}

				endif;
				if($this->get_att( 'show_products' ) == "top_products"){
					remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
				}
				wp_reset_postdata();
				
			echo '</div>';
			do_action( 'presscore_after_loop' );
			do_action( 'dt_wc_loop_end' );
			do_action( 'presscore_after_shortcode_loop', $this->sc_name, $this->atts );
			remove_filter( 'dt_woocommerce_get_product_preview_icons', 'dt_woocommerce_filter_product_preview_icons' );
            remove_action( 'woocommerce_after_shop_loop_item', 'dt_woocommerce_render_product_add_to_cart_icon', 40 );
		}
		
		protected function get_container_html_class( $class = array() ) {
			$el_class = $this->atts['el_class'];

			// Unique class.
			$class[] = $this->get_unique_class();

			$layout_classes = array(
				'content_below_img' => 'cart-btn-below-img',
				'btn_on_img' => 'cart-btn-on-img',
				'btn_on_img_hover' => 'cart-btn-on-hover cart-btn-on-img',
			);
			$layout = $this->get_att( 'layout' );
			if ( array_key_exists( $layout, $layout_classes ) ) {
				$class[] = $layout_classes[ $layout ];
			};


			switch ( $this->atts['bullets_style'] ) {
				case 'scale-up':
					$class[] = 'bullets-scale-up';
					break;
				case 'stroke':
					$class[] = 'bullets-stroke';
					break;
				case 'fill-in':
					$class[] = 'bullets-fill-in';
					break;
				case 'small-dot-stroke':
					$class[] = 'bullets-small-dot-stroke';
					break;
				case 'ubax':
					$class[] = 'bullets-ubax';
					break;
				case 'etefu':
					$class[] = 'bullets-etefu';
					break;
			};
			switch ( $this->atts['arrow_responsiveness'] ) {
				case 'hide-arrows':
					$class[] = 'hide-arrows';
					break;
				case 'reposition-arrows':
					$class[] = 'reposition-arrows';
					break;
			};
			
			if($this->atts['arrows_bg_show'] === 'y'){
				$class[] = 'arrows-bg-on';
			}else{
				$class[] = 'arrows-bg-off';
			};
			if($this->atts['arrow_icon_border'] === 'y'){
				$class[] = 'dt-arrow-border-on';
			}
			if($this->atts['arrow_icon_border_hover'] === 'y'){
				$class[] = 'dt-arrow-hover-border-on';
			}
			
			if ( $this->get_att( 'arrow_bg_color' ) === $this->get_att( 'arrow_bg_color_hover' ) ) {
				$class[] = 'disable-arrows-hover-bg';
			};

			if($this->atts['arrows_bg_hover_show'] === 'y'){
				$class[] = 'arrows-hover-bg-on';
			}else{
				$class[] = 'arrows-hover-bg-off';
			};
			if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
				$class[] = vc_shortcode_custom_css_class( $this->atts['css_dt_blog_carousel'], ' ' );
			};
			if ( of_get_option( 'woocommerce_hover_image' ) ) {
				$class[] = 'wc-img-hover';
			}
			if($this->atts['product_descr'] === 'n'){
				$class[] = 'hide-description';
			}
			if($this->atts['product_rating'] === 'n'){
				$class[] = 'hide-rating';
			}

			$class[] = $el_class;

			return 'class="' . esc_attr( implode( ' ', $class ) ) . '"';
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

		protected function get_container_data_atts() {
			$data_atts = array(
				'scroll-mode' => ($this->atts['slide_to_scroll'] == "all") ? 'page' : '1',
				'wide-col-num' => $this->atts['slides_on_wide_desk'],
				'col-num' => $this->atts['slides_on_desk'],
				'laptop-col' => $this->atts['slides_on_lapt'],
				'h-tablet-columns-num' => $this->atts['slides_on_h_tabs'],
				'v-tablet-columns-num' => $this->atts['slides_on_v_tabs'],
				'phone-columns-num' => $this->atts['slides_on_mob'],
				'auto-height' => ($this->atts['adaptive_height'] === 'y') ? 'true' : 'false',
				'col-gap' => $this->atts['item_space'],
				'stage-padding' => $this->atts['stage_padding'],
				'speed' => $this->atts['speed'],
				'autoplay' => ($this->atts['autoplay'] === 'y') ? 'true' : 'false',
				'autoplay_speed' => $this->atts['autoplay_speed'],
				'arrows' => ($this->atts['arrows'] === 'y') ? 'true' : 'false',
				'bullet' => ($this->atts['show_bullets'] === 'y') ? 'true' : 'false',
				'next-icon'=> $this->atts['next_icon'],
				'prev-icon'=> $this->atts['prev_icon'],
			);

			return presscore_get_inlide_data_attr( $data_atts );
		}
		/**
		 * Setup theme config for shortcode.
		 */
		protected function setup_config() {
			//$config = presscore_config();
		}
		public function _setup_config() {
			$config = presscore_config();
			$config->set( 'layout', 'carousel' );
			$config->set( 'product.preview.show_rating', true );
			$config->set( 'product.preview.icons.show_cart', true );
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
		}

		/**
		 * Add owl lazy loading class.
		 *
		 * @param array $attr Image attributes.
		 *
		 * @return array
		 */
		public function add_owl_lazy_loading_class( $attr ) {
			if ( isset( $attr['class'] ) ) {
				$attr['class'] = str_replace( array( 'lazy-load', 'iso-lazy-load' ), 'owl-lazy-load', $attr['class'] );
			}

			return $attr;
		}

		/**
		 * Return array of prepared less vars to insert to less file.
		 *
		 * @return array
		 */
		protected function get_less_vars() {
			$less_vars = the7_get_new_shortcode_less_vars_manager();

			$less_vars->add_keyword( 'unique-shortcode-class-name', 'products-carousel-shortcode.' . $this->get_unique_class(), '~"%s"' );
			$less_vars->add_keyword( 'post-title-color', $this->get_att( 'custom_title_color', '~""') );
			$less_vars->add_keyword( 'post-content-color', $this->get_att( 'custom_content_color', '~""' ) );

			$less_vars->add_keyword( 'price-color', $this->get_att( 'custom_price_color', '~""' ) );

			$less_vars->add_pixel_number( 'icon-size', $this->get_att( 'arrow_icon_size' ) );
			$less_vars->add_paddings( array(
				'l-icon-padding-top',
				'l-icon-padding-right',
				'l-icon-padding-bottom',
				'l-icon-padding-left',
			), $this->get_att( 'l_arrow_icon_paddings' ) );
			$less_vars->add_paddings( array(
				'r-icon-padding-top',
				'r-icon-padding-right',
				'r-icon-padding-bottom',
				'r-icon-padding-left',
			), $this->get_att( 'r_arrow_icon_paddings' ) );
			$less_vars->add_pixel_number( 'arrow-width', $this->get_att( 'arrow_bg_width' ) );
			$less_vars->add_pixel_number( 'arrow-height', $this->get_att( 'arrow_bg_height' ) );
			$less_vars->add_pixel_number( 'arrow-border-radius', $this->get_att( 'arrow_border_radius' ) );
			$less_vars->add_pixel_number( 'arrow-border-width', $this->get_att( 'arrow_border_width' ) );

			$less_vars->add_keyword( 'icon-color', $this->get_att( 'arrow_icon_color', '~""' ) );
			$less_vars->add_keyword( 'arrow-border-color', $this->get_att( 'arrow_border_color', '~""' ) );
			$less_vars->add_keyword( 'arrow-bg', $this->get_att( 'arrow_bg_color', '~""' ) );
			$less_vars->add_keyword( 'icon-color-hover', $this->get_att( 'arrow_icon_color_hover', '~""' ) );
			$less_vars->add_keyword( 'arrow-border-color-hover', $this->get_att( 'arrow_border_color_hover', '~""' ) );
			$less_vars->add_keyword( 'arrow-bg-hover', $this->get_att( 'arrow_bg_color_hover', '~""' ) );
			
			$less_vars->add_keyword( 'arrow-right-v-position', $this->get_att( 'r_arrow_v_position' ) );
			$less_vars->add_keyword( 'arrow-right-h-position', $this->get_att( 'r_arrow_h_position' ) );
			$less_vars->add_pixel_number( 'r-arrow-v-position', $this->get_att( 'r_arrow_v_offset' ) );
			$less_vars->add_pixel_number( 'r-arrow-h-position', $this->get_att( 'r_arrow_h_offset' ) );

			$less_vars->add_keyword( 'arrow-left-v-position', $this->get_att( 'l_arrow_v_position' ) );
			$less_vars->add_keyword( 'arrow-left-h-position', $this->get_att( 'l_arrow_h_position' ) );
			$less_vars->add_pixel_number( 'l-arrow-v-position', $this->get_att( 'l_arrow_v_offset' ) );
			$less_vars->add_pixel_number( 'l-arrow-h-position', $this->get_att( 'l_arrow_h_offset' ) );
			$less_vars->add_pixel_number( 'hide-arrows-switch', $this->get_att( 'hide_arrows_mobile_switch_width' ) );
			$less_vars->add_pixel_number( 'reposition-arrows-switch', $this->get_att( 'reposition_arrows_mobile_switch_width' ) );
			$less_vars->add_pixel_number( 'arrow-left-h-position-mobile', $this->get_att( 'l_arrows_mobile_h_position' ) );
			$less_vars->add_pixel_number( 'arrow-right-h-position-mobile', $this->get_att( 'r_arrows_mobile_h_position' ) );

			$less_vars->add_pixel_number( 'bullet-size', $this->get_att( 'bullet_size' ) );
			$less_vars->add_keyword( 'bullet-color', $this->get_att( 'bullet_color', '~""' ) );
			$less_vars->add_keyword( 'bullet-color-hover', $this->get_att( 'bullet_color_hover', '~""' ) );
			$less_vars->add_pixel_number( 'bullet-gap', $this->get_att( 'bullet_gap' ) );
			$less_vars->add_keyword( 'bullets-v-position', $this->get_att( 'bullets_v_position' ) );
			$less_vars->add_keyword( 'bullets-h-position', $this->get_att( 'bullets_h_position' ) );
			$less_vars->add_pixel_number( 'bullet-v-position', $this->get_att( 'bullets_v_offset' ) );
			$less_vars->add_pixel_number( 'bullet-h-position', $this->get_att( 'bullets_h_offset' ) );
			

			return $less_vars->get_vars();
		}
		protected function get_less_file_name() {
			// @TODO: Remove in production.
			$less_file_name = 'dt-products-carousel';

			$less_file_path = trailingslashit( get_template_directory() ) . "css/dynamic-less/shortcodes/{$less_file_name}.less";

			return $less_file_path;
		}
		/**
		 * Return dummy html for VC inline editor.
		 *
		 * @return string
		 */
		protected function get_vc_inline_html() {

			return $this->vc_inline_dummy( array(
				'class'  => 'dt_products_carousel',
				'img' => array( PRESSCORE_SHORTCODES_URI . '/images/vc_product_carousel_editor_ico.gif', 131, 104 ),
				'title'  => _x( 'Products Carousel', 'vc inline dummy', 'the7mk2' ),

				'style' => array( 'height' => 'auto' )
			) );
		}
	
		protected function get_query_args() {
			global $woocommerce;
			$show_products_attd = $this->get_att( 'show_products' );
			$post_count = $this->get_att( 'dis_posts_total', '-1' );

			$order = $this->get_att( 'order' );
			$orderby = $this->get_att( 'orderby' );
			if ( 'id' === $orderby ) {
				$orderby = 'ID';
			} elseif ( 'menu_order' === $orderby ) {
				$order = 'asc';
			}

			$meta_query = $tax_query = '';
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
			$query_args =  array(
				'post_type' => 'product',
        		'post_status'		  => 'publish',
				'ignore_sticky_posts'  => 1,
				'posts_per_page' 	   => $post_count,
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

			$query_args['tax_query'] = the7_product_visibility_tax_query( $query_args['tax_query'] );

			return $query_args;
		}
	}
	
	// create shortcode
	DT_Shortcode_Products_Carousel::get_instance()->add_shortcode();
endif;
