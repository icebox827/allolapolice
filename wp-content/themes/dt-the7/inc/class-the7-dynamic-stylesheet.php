<?php
/**
 * The7 dynamic stylesheet class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Dynamic_Stylesheet
 */
class The7_Dynamic_Stylesheet {

	protected $version;
	protected $dependency;
	protected $media;
	protected $handle;
	protected $css_url;
	protected $css_abspath;
	protected $css_body;
	protected $css_body_handle;
	protected $less_src;
	protected $less_abspath;

	const THEME_CSS_DIR = 'css';
	const COMPILED_CSS_DIR = 'the7-css';

	public function __construct( $handle, $less_src ) {
		$wp_upload = wp_get_upload_dir();
		$css_src = str_replace( '.less', '.css', $less_src );
		$compiled_css_dir = self::COMPILED_CSS_DIR;

		$this->less_abspath = self::get_theme_css_dir() . "/{$less_src}";
		$this->css_abspath = "{$wp_upload['basedir']}/{$compiled_css_dir}/{$css_src}";
		$this->css_url = "{$wp_upload['baseurl']}/{$compiled_css_dir}/{$css_src}";
		$this->handle = $handle;
		$this->less_src = $less_src;
		$this->css_body_handle = 'dt-main';
		$this->media = 'all';
		$this->dependency = false;
		$this->version = false;
	}

	public function setup_with_array( $args ) {
		foreach ( $args as $prop => $val ) {
			if ( property_exists( $this, $prop ) ) {
				$this->$prop = $val;
			}
		}
	}

	public function register() {
		wp_register_style( $this->handle, set_url_scheme( $this->css_url ), $this->dependency, $this->version, $this->media );
	}

	public function enqueue() {
		if ( $this->css_body ) {
			$css_body = $this->css_body;
			if ( is_ssl() ) {
				$css_body = str_replace( site_url( '', 'http' ), site_url( '', 'https' ), $css_body );
			}

			wp_add_inline_style( $this->css_body_handle, $css_body );

			return;
		}

		if ( wp_style_is( $this->handle, 'registered' ) ) {
			wp_enqueue_style( $this->handle );
		} else {
			wp_enqueue_style( $this->handle, set_url_scheme( $this->css_url ), $this->dependency, $this->version, $this->media );
		}
	}

	public function get_less_file() {
		return $this->less_abspath;
	}

	public function set_less_file( $file ) {
		return $this->less_abspath = $file;
	}

	public function get_css_file() {
		return $this->css_abspath;
	}

	public static function get_theme_css_dir() {
		return trailingslashit( get_template_directory() ) . self::THEME_CSS_DIR;
	}

	/**
	 * @return mixed
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * @param mixed $version
	 */
	public function set_version( $version ) {
		$this->version = $version;
	}

	/**
	 * @return mixed
	 */
	public function get_dependency() {
		return $this->dependency;
	}

	/**
	 * @param mixed $dependency
	 */
	public function set_dependency( $dependency ) {
		$this->dependency = $dependency;
	}

	/**
	 * @return mixed
	 */
	public function get_media() {
		return $this->media;
	}

	/**
	 * @param mixed $media
	 */
	public function set_media( $media ) {
		$this->media = $media;
	}

	/**
	 * @return mixed
	 */
	public function get_css_abspath() {
		return $this->css_abspath;
	}

	/**
	 * @param mixed $css_abspath
	 */
	public function set_css_abspath( $css_abspath ) {
		$this->css_abspath = $css_abspath;
	}

	/**
	 * @return mixed
	 */
	public function get_css_body() {
		return $this->css_body;
	}

	/**
	 * @param mixed $css_body
	 */
	public function set_css_body( $css_body ) {
		$this->css_body = $css_body;
	}
}