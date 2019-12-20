<?php
/**
 * Albums public part.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Presscore_Mod_Albums_Public {

	public function resolve_template_ajax( $response, $data, $template_name ) {
		if ( in_array( $template_name, array( 'template-albums-jgrid.php', 'template-albums.php' ) ) ) {

			$ajax_content = new Presscore_Mod_Albums_Ajax_Content_Builder();
			$response = $ajax_content->get_response( $data );

		} else if ( in_array( $template_name, array( 'template-media-jgrid.php', 'template-media.php' ) ) ) {

			$ajax_content = new Presscore_Mod_Media_Ajax_Content_Builder();
			$response = $ajax_content->get_response( $data );

		}
		return $response;
	}

	public function register_shortcodes() {
		foreach ( array( 'albums', 'albums-jgrid', 'albums-slider', 'photos-masonry', 'photos-jgrid', 'photos-slider', 'gallery-masonry', 'photos-carousel', 'albums-masonry', 'albums-carousel' ) as $shortcode_name ) {
			include_once plugin_dir_path( __FILE__ ) . "shortcodes/{$shortcode_name}/{$shortcode_name}.php";
		}
	}

	public function load_shortcodes_vc_bridge() {
		include_once plugin_dir_path( __FILE__ ) . "shortcodes/mod-albums-shortcodes-bridge.php";
	}

	public function init_widgets() {
		register_widget( 'Presscore_Inc_Widgets_Photos' );
	}

	public function init_template_config( $post_type, $template = null ) {
		if ( 'dt_gallery' == $post_type ) {
			presscore_congif_populate_single_album_vars();
		} else if ( 'page' == $post_type && 'albums' == $template ) {
			presscore_congif_populate_albums_vars();
		} else if ( 'page' == $post_type && 'media' == $template ) {
			presscore_congif_populate_media_vars();
		}
	}

	public function archive_post_content( $html ) {
		if ( ! $html ) {
			ob_start();

			add_filter( 'presscore_get_images_gallery_hoovered-title_img_args', 'presscore_gallery_post_exclude_featured_image_from_gallery', 15, 3 );
			presscore_populate_album_post_config();
			presscore_get_template_part( 'mod_albums', 'album-masonry/album' );
			remove_filter( 'presscore_get_images_gallery_hoovered-title_img_args', 'presscore_gallery_post_exclude_featured_image_from_gallery', 15, 3 );

			$html = ob_get_contents();
			ob_end_clean();
		}
		return $html;
	}

	public function cache_attachments( $attachments_id, $post_type, $posts_query ) {
		if ( 'dt_gallery' === $post_type ) {
			foreach( $posts_query->posts as $_post ) {
				$post_media = get_post_meta( $_post->ID, '_dt_album_media_items', true );
				$show_mini_images = presscore_config()->get( 'post.preview.mini_images.enabled' );
				if ( post_password_required( $_post->ID ) ) {
					$open_as = 'post';
				} else {
					$open_as = get_post_meta( $_post->ID, '_dt_album_options_open_album', true );
				}

				if ( 'post' === $open_as ) {

					if ( $show_mini_images ) {
						$post_media = array_slice( $post_media, 0, 3);
					} else {
						$post_media = array( $post_media[0] );
					}

				}

				if ( $post_media && is_array( $post_media ) ) {
					$attachments_id = array_merge( $attachments_id, $post_media );
				}
			}
		}
		return $attachments_id;
	}

	public function archive_page_id( $page_id ) {
		if ( $page_id ) {
			return $page_id;
		}

		if ( is_tax( 'dt_gallery_category' ) || is_post_type_archive( 'dt_gallery' ) ) {
			$page_id = of_get_option( 'template_page_id_gallery_category', null );
		}

		return $page_id;
	}

	public function the7_archive_display_full_content_filter( $display_full_content ) {
		if ( is_tax( 'dt_gallery_category' ) || is_post_type_archive( 'dt_gallery' ) ) {
			$display_full_content = of_get_option( 'template_page_id_gallery_category_full_content' );
		}

		return $display_full_content;
	}

	public function post_meta_wrap_class_filter( $class ) {
		if ( 'dt_gallery' == get_post_type() ) {
			$class[] = 'portfolio-categories';
		}
		return $class;
	}

	public function filter_page_title( $page_title ) {
		if ( of_get_option( 'show_static_part_of_archive_title' ) === '0' ) {
			return $page_title;
		}

		if ( is_tax( 'dt_gallery_category' ) ) {
			$page_title = sprintf( __( 'Albums Archives: %s', 'dt-the7-core' ), '<span>' . single_term_title( '', false ) . '</span>' );
		} elseif ( is_post_type_archive( 'dt_gallery' ) ) {
			$page_title = __( 'Albums Archive:', 'dt-the7-core' );
		}

		return $page_title;
	}

	public function filter_body_class( $classes ) {

		// photoscroller on single post
		if ( is_single() && 'dt_gallery' === get_post_type() && 'photo_scroller' == presscore_config()->get( 'post.media.type' ) ) {
			$classes[] = 'photo-scroller-album';
		}



		return $classes;
	}

	public function filter_masonry_wrap_taxonomy( $taxonomy, $post_type ) {
		if ( 'dt_gallery' == $post_type ) {
			$taxonomy = 'dt_gallery_category';
		}
		return $taxonomy;
	}

	public function filter_add_to_author_archive( $new_post_types ) {
		$new_post_types[] = 'dt_gallery';
		return $new_post_types;
	}

	/**
	 * Register dynamic stylesheets.
	 *
	 * @param array $dynamic_stylesheets
	 *
	 * @return array
	 */
	public function register_dynamic_stylesheet( $dynamic_stylesheets ) {
		$dynamic_stylesheets['the7-elements-albums-portfolio'] = array(
			'path' => The7pt()->plugin_path() . 'assets/css/legacy.less',
			'src' => 'the7-elements-albums-portfolio.less',
		);

		return $dynamic_stylesheets;
	}
}
