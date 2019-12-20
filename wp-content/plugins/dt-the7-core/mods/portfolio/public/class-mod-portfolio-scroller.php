<?php

if ( ! class_exists( 'Presscore_Portfolio_Posts_Scroller', false ) ) {

	class Presscore_Portfolio_Posts_Scroller extends The7pt_Posts_Scroller {

		protected function setup_config() {
			$config = presscore_config();

			$config->set( 'is_scroller', true );
			$config->set( 'template', 'portfolio' );
			$config->set( 'template.layout.type', 'masonry' );
			$config->set( 'layout', 'grid' );
			$config->set( 'justified_grid', false );
			$config->set( 'all_the_same_width', true );
			$config->set( 'post.preview.load.effect', false );

			$config->set( 'show_titles', $this->args['show_title'] );
			$config->set( 'show_excerpts', $this->args['show_excerpt'] );

			if ( 'under_image' === $this->args['appearance'] ) {
				$config->set( 'post.preview.background.enabled', ! in_array( $this->args['bg_under_projects'], array(
					'disabled',
					'',
				), true ) );
				$config->set( 'post.preview.background.style', $this->args['bg_under_projects'] );
			} else {
				$config->set( 'post.preview.background.enabled', false );
				$config->set( 'post.preview.background.style', false );
			}

			$config->set( 'post.preview.description.style', $this->args['appearance'] );
			$config->set( 'post.preview.description.alignment', $this->args['content_aligment'] );
			$config->set( 'post.preview.hover.animation', $this->args['hover_animation'] );
			$config->set( 'post.preview.hover.color', $this->args['hover_bg_color'] );
			$config->set( 'post.preview.hover.content.visibility', $this->args['hover_content_visibility'] );

			$config->set( 'show_links', $this->args['show_link'] );
			$config->set( 'show_details', $this->args['show_details'] );
			$config->set( 'show_zoom', $this->args['show_zoom'] );

			$config->set( 'post.meta.fields.date', $this->args['show_date'] );
			$config->set( 'post.meta.fields.categories', $this->args['show_categories'] );
			$config->set( 'post.meta.fields.comments', $this->args['show_comments'] );
			$config->set( 'post.meta.fields.author', $this->args['show_author'] );
			$config->set( 'thumb_proportions', $this->args['proportions'] );
			$config->set( 'image_layout', 'resize' );
		}

		protected function get_container_data_atts() {
			$data = array(
				'padding-side' => $this->args['padding'],
				'autoslide'    => $this->args['autoslide'] ? 'true' : 'false',
				'delay'        => $this->args['autoslide'],
				'loop'         => $this->args['loop'] ? 'true' : 'false',
				'arrows'       => 'true',
				'next-icon'    => 'icon-ar-017-r',
				'prev-icon'    => 'icon-ar-017-l',
			);

			if ( isset( $this->args['columns'] ) && is_array( $this->args['columns'] ) ) {
				$data = array_merge( $data, $this->args['columns'] );
			}

			return presscore_get_inlide_data_attr( $data );
		}

		protected function render_slide() {
			presscore_populate_portfolio_config();
			presscore_get_config()->set( 'post.preview.media.style', 'featured_image' );
			presscore_get_template_part( 'mod_portfolio', 'masonry/project' );
		}

	}

}
