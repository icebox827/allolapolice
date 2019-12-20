<?php
/**
 * @package dt_the7_core
 * @since   1.11.0
 */

if ( ! class_exists( 'The7pt_Posts_Scroller', false ) ) {

	/**
	 * Class The7pt_Posts_Scroller
	 */
	class The7pt_Posts_Scroller {

		protected $post_backup;
		protected $config_backup;
		protected $query;
		protected $args = array();

		public function setup( $query, $args = array() ) {
			$defaults = array(
				'class'     => '',
				'padding'   => '0',
				'autoslide' => false,
				'loop'      => false,
				'arrows'    => true,
				'max_width' => false,
			);

			$this->args  = wp_parse_args( $args, $defaults );
			$this->query = $query;
		}

		public function render_html() {
			echo $this->get_html();
		}

		public function get_html() {

			$this->backup_post_object();
			$this->backup_theme_config();
			$this->setup_config();
			$this->add_hooks();

			ob_start();

			// loop
			while ( $this->query->have_posts() ) {
				$this->query->the_post();
				$this->render_slide();
			}

			// store loop html
			$posts_html = ob_get_contents();
			ob_end_clean();

			// shape output
			$output = '<div ' . $this->get_container_html_class() . ' ' . $this->get_container_data_atts() . '>';
			$output .= $posts_html;
			$output .= '</div>';

			$this->remove_hooks();
			$this->restore_theme_config();
			$this->restore_post_object();

			return $output;
		}

		public function set_image_dimensions( $args ) {
			$args['options'] = array( 'w' => $this->args['width'], 'h' => $this->args['height'] );
			$args['prop']    = false;

			return $args;
		}

		protected function get_container_html_class( $class = array() ) {
			switch ( $this->args['arrows'] ) {
				case 'light':
					$class[] = 'arrows-light';
					break;
				case 'dark':
					$class[] = 'arrows-dark';
					break;
				case 'accent':
					$class[] = 'arrows-accent';
					break;
			}

			$class[] = $this->args['class'];

			$html_class = presscore_masonry_container_class( $class );
			$html_class = str_replace( array(
				' iso-grid',
				'iso-grid ',
				' loading-effect-fade-in',
				'loading-effect-fade-in ',
			), '', $html_class );

			return $html_class;
		}

		protected function get_container_data_atts() {
			$data = array(
				'padding-side' => $this->args['padding'],
				'autoslide'    => $this->args['autoslide'] ? 'true' : 'false',
				'delay'        => $this->args['autoslide'],
				'loop'         => $this->args['loop'] ? 'true' : 'false',
			);

			if ( $this->args['max_width'] ) {
				$data['max-width'] = $this->args['max_width'];
			}
			if ( $this->args['arrows'] ) {
				$data_atts['arrows'] = $this->args['arrows'] ? 'true' : 'false';
			}

			return presscore_get_inlide_data_attr( $data );
		}

		protected function add_hooks() {
		}

		protected function remove_hooks() {
		}

		protected function backup_post_object() {
			global $post;
			$this->post_backup = $post;
		}

		protected function restore_post_object() {
			global $post;
			$post = $this->post_backup;
			setup_postdata( $post );
			unset( $this->post_backup );
		}

		protected function backup_theme_config() {
			$this->config_backup = presscore_get_config()->get();
		}

		protected function restore_theme_config() {
			presscore_get_config()->reset( $this->config_backup );
			unset( $this->config_backup );
		}

		protected function setup_config() {
		}

		protected function render_slide() {
		}

	}
}

/**
 * Keep old class name for back compatibility.
 */
if ( ! class_exists( 'Presscore_Posts_Slider_Scroller', false ) ) {
	class Presscore_Posts_Slider_Scroller extends The7pt_Posts_Scroller {

	}
}
