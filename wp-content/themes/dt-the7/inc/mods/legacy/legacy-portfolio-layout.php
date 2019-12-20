<?php

class Presscore_Modules_Legacy_Portfolio_Layout {

	public static function launch() {
		add_action( 'presscore_config_base_init', array( __CLASS__, 'setup_portfolio_layout' ), 20, 2 );
		add_action( 'admin_init', array( __CLASS__, 'alter_project_meta_boxes' ), 25 );
		add_action( 'presscore_before_post', array( __CLASS__, 'alter_project_preview_mode' ) );
	}

	public static function setup_portfolio_layout( $post_type, $template = null ) {
		if ( 'dt_portfolio' !== $post_type ) {
			return;
		}

		$config = presscore_config();

		// Force to display only content.
		$show_featured_image = $config->get( 'post.media.featured_image.enabled' );

		$media_layout = 'disabled';
		if ( $show_featured_image ) {
			$media_layout = 'before';
		}
		$config->set( 'post.media.layout', $media_layout );

		$project_media = array();
		if ( $show_featured_image && has_post_thumbnail() ) {
			$project_media = array( get_post_thumbnail_id() );
		}
		$config->set( 'post.media.library', $project_media );

		// Force to display one image.
		$config->set( 'post.media.type', 'single_image' );
	}

	public static function alter_project_meta_boxes() {
		global $DT_META_BOXES;

		if ( ! $DT_META_BOXES ) {
			return;
		}

		$meta_boxes_to_remove = array(
			'dt_page_box-portfolio_post_media_options',
		    'dt_page_box-portfolio_post_media',
		);

		foreach ( $DT_META_BOXES as $box_key => $meta_box ) {
			if ( ! isset( $meta_box['id'] ) ) {
				continue;
			}

			$meta_box_id = $meta_box['id'];

			// Remove "Preview style" settings.
			if ( 'dt_page_box-portfolio_post' === $meta_box_id ) {
				foreach ( $meta_box['fields'] as $field_key => $field ) {
					if (
						isset( $field['id'] )
						&& in_array( $field['id'], array(
							'_dt_project_options_preview_style',
							'_dt_project_options_slider_proportions',
						) )
					) {
						unset( $DT_META_BOXES[ $box_key ]['fields'][ $field_key ] );
					}
				}
				unset( $field_key, $field );
			}

			if ( in_array( $meta_box_id, $meta_boxes_to_remove ) ) {
				unset( $DT_META_BOXES[ $box_key ] );
			}
		}
	}

	public static function alter_project_preview_mode() {
		global $post;

		if ( empty( $post->post_type ) || 'dt_portfolio' !== $post->post_type ) {
			return;
		}

		presscore_config()->set( 'post.preview.media.style', 'featured_image' );
	}
}