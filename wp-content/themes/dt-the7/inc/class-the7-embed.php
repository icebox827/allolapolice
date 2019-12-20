<?php
/**
 * The7 embed class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Embed
 */
class The7_Embed {

	/**
	 * @var string
	 */
	protected $src;

	/**
	 * @var int
	 */
	protected $width = 0;

	/**
	 * @var int
	 */
	protected $height = 0;

	/**
	 * The7_Embed constructor.
	 *
	 * @param string $src
	 */
	public function __construct( $src ) {
		$this->src = $src;
	}

	/**
	 * @param string $width
	 */
	public function set_width( $width ) {
		$this->width = (int) $width;
	}

	/**
	 * @param string $height
	 */
	public function set_height( $height ) {
		$this->height = (int) $height;
	}

	/**
	 * Return embed html or false if $wp_embed not set.
	 *
	 * @return bool|string
	 */
	public function get_html() {
		global $wp_embed;

		if ( empty( $wp_embed ) ) {
			return false;
		}

		$embed_atts = array();
		if ( $this->width ) {
			$embed_atts[] = sprintf( 'width="%s"', $this->width );
		}
		if ( $this->height ) {
			$embed_atts[] = sprintf( 'height="%s"', $this->height );
		}

		$embed_shortcode = sprintf( '[embed %1$s]%2$s[/embed]', join( ' ', $embed_atts ), $this->src );

		$this->add_hooks();
		$embed_html = do_shortcode( $wp_embed->run_shortcode( $embed_shortcode ) );
		$this->remove_hooks();

		return $embed_html;
	}

	/**
	 * Filter. Add width attribute to video shortcode.
	 *
	 * @param string $video
	 *
	 * @return string
	 */
	public function _fix_video_file_width_filter( $video ) {
		if ( ! preg_match( '/(width=\"?\d*\"?)/', $video ) ) {
			$video = preg_replace( '/(video)/', sprintf( '$1 width="%s"', $this->width ), $video );
		}

		return $video;
	}

	/**
	 * Add hooks.
	 */
	protected function add_hooks() {
		add_filter( 'wp_embed_handler_video', array( $this, '_fix_video_file_width_filter' ), 10 );
	}

	/**
	 * Remove hooks.
	 */
	protected function remove_hooks() {
		remove_filter( 'wp_embed_handler_video', array( $this, '_fix_video_file_width_filter' ), 10 );
	}
}