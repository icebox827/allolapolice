<?php
defined( 'ABSPATH' ) || exit;

/**
 * Class DT_Shortcode_With_Inline_Css
 */
abstract class DT_Shortcode_With_Inline_Css extends DT_Shortcode {

	const INLINE_CSS_META_KEY = 'the7_shortcodes_dynamic_css';

	/**
	 * Shortcode name.
	 *
	 * @var string
	 */
	protected $sc_name;

	/**
	 * Shortcode attributes.
	 *
	 * @var array
	 */
	protected $atts = array();

	/**
	 * Shortcode default attributes.
	 *
	 * @var array
	 */
	protected $default_atts = array();

	/**
	 * Shortcode unique id.
	 *
	 * @var int
	 */
	protected $sc_id = 1;

	/**
	 * Shortcode unique class base part.
	 *
	 * @var string
	 */
	protected $unique_class_base = '';

	/**
	 * Shortcode unique class. Generated with DT_Shortcode_With_Inline_Css::get_unique_class().
	 *
	 * @var string
	 */
	protected $unique_class = '';

	/**
	 * @var bool
	 */
	protected $doing_shortcode = false;

	/**
	 * @var bool
	 */
	protected static $inline_css_printed = false;

	/**
	 * DT_Shortcode_With_Inline_Css constructor.
	 */
	public function __construct() {
		add_filter( "the7_generate_sc_{$this->sc_name}_css", array( $this, 'generate_inline_css' ), 10, 2 );
	}

	public function get_tag() {
		return $this->sc_name;
	}

	public function reset_id() {
		$this->sc_id = 1;
	}

	/**
	 * Base shortcode callback. Return shortcode HTML.
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function shortcode( $atts, $content = '' ) {
		if ( $this->doing_shortcode ) {
			return '';
		}

		$this->init_shortcode( $atts );


		if ( presscore_vc_is_inline() && $vc_inline_html = $this->get_vc_inline_html() ) {
			return $vc_inline_html;
		}

		$this->backup_post_object();
		$this->backup_theme_config();

		ob_start();
		$this->doing_shortcode = true;

		do_action( 'the7_before_shortcode_output', $this );

		$this->setup_config();
		$this->print_inline_css();
		$this->do_shortcode( $atts, $content );

		do_action( 'the7_after_shortcode_output', $this );

		$this->doing_shortcode = false;
		$output                = ob_get_clean();

		$this->restore_theme_config();
		$this->restore_post_object();

		return $output;
	}

	/**
	 * Generate shortcode inline css from provided less file.
	 *
	 * @param array $css
	 * @param array $atts
	 *
	 * @return array
	 */
	public function generate_inline_css( $css = array(), $atts = array() ) {
		$this->init_shortcode( $atts );

		$uid = the7_get_shortcode_uid( $this->get_tag(), $this->get_atts() );
		$css = (array) $css;
		try {
			$lessc       = new The7_Less_Compiler( (array) $this->get_less_vars(), (array) $this->get_less_import_dir() );
			$css[ $uid ] = $lessc->compile_file( $this->get_less_file_name(), $this->get_less_imports() );
		} catch ( Exception $e ) {
			$css[ $uid ] = "/*\n" . $e->getMessage() . "\n*/\n";

			return $css;
		}

		return $css;
	}

	/**
	 * Register shortcode.
	 *
	 * @uses DT_Shortcode_With_Inline_Css::sc_name
	 */
	public function add_shortcode() {
		if ( $this->sc_name ) {
			add_shortcode( $this->sc_name, array( $this, 'shortcode' ) );
		}
	}

	/**
	 * Output shortcode HTML.
	 *
	 * @param array  $atts
	 * @param string $content
	 */
	abstract protected function do_shortcode( $atts, $content = '' );

	/**
	 * Setup theme config for shortcode.
	 */
	 protected function setup_config() {
	 	// Do nothing.
	 }

	/**
	 * Return array of prepared less vars to insert to less file.
	 *
	 * @return array
	 */
	abstract protected function get_less_vars();

	/**
	 * Return shortcode less file absolute path to output inline.
	 *
	 * @return string
	 */
	abstract protected function get_less_file_name();

	/**
	 * Return dummy html for VC inline editor.
	 *
	 * @return string
	 */
	protected function get_vc_inline_html() {
		return false;
	}

	/**
	 * Return less imports list.
	 *
	 * @return array
	 */
	protected function get_less_imports() {
		return array();
	}

	/**
	 * Return less import dir.
	 *
	 * @return array
	 */
	protected function get_less_import_dir() {
		return array( PRESSCORE_THEME_DIR . '/css/dynamic-less/shortcodes' );
	}

	/**
	 * Initialize shortcode.
	 *
	 * @param array $atts
	 */
	protected function init_shortcode( $atts = array() ) {
		do_action( 'the7_before_shortcode_init', $this, $this->sc_name );

		$this->atts         = shortcode_atts( $this->default_atts, $atts, $this->sc_name );
		$this->unique_class = '';

		do_action( 'the7_after_shortcode_init', $this, $this->sc_name );
	}

	/**
	 * Return unique shortcode class like {$unique_class_base}-{$sc_id}.
	 *
	 * @return string
	 */
	public function get_unique_class() {
		if ( ! $this->unique_class ) {
			$this->unique_class = $this->unique_class_base . '-' . the7_get_shortcode_uid( $this->get_tag(), $this->get_atts() );
		}

		return $this->unique_class;
	}

	public function set_unique_class( $class ) {
		$this->unique_class = $class;
	}

	/**
	 * Return $att_name attribute value or default one if empty.
	 *
	 * @param string $att_name
	 * @param string $default
	 *
	 * @return string
	 */
	protected function get_att( $att_name, $default = null ) {
		if ( array_key_exists( $att_name, $this->atts ) && '' !== $this->atts[ $att_name ] ) {
			return $this->atts[ $att_name ];
		}

		if ( ! is_null( $default ) ) {
			return $default;
		}

		if ( array_key_exists( $att_name, $this->default_atts ) ) {
			return $this->default_atts[ $att_name ];
		}

		return '';
	}

	public function get_atts() {
		return $this->atts;
	}

	/**
	 * Return sanitized boolean value.
	 *
	 * @param string $att_name
	 * @param string $default
	 *
	 * @return bool
	 */
	protected function get_flag( $att_name, $default = null ) {
		return apply_filters( 'dt_sanitize_flag', $this->get_att( $att_name, $default ) );
	}

	/**
	 * Print inline css. It depends on self::$inline_css_printed and output only if it's false.
	 *
	 * @return bool
	 */
	protected function print_inline_css() {
		/**
		 * Allow to short circuit inline css logic and go strait to output.
		 *
		 * @since 7.1.3
		 *
		 * @param string Live empty to execute default inline css logic.
		 * @param DT_Shortcode_With_Inline_Css This object.
		 */
		$inline_css = apply_filters( 'the7_shortcodes_get_custom_inline_css', '', $this );
		if ( ! $inline_css ) {
			$uid                   = the7_get_shortcode_uid( $this->get_tag(), $this->get_atts() );
			$shortcodes_inline_css = (array) get_post_meta( get_the_ID(), self::INLINE_CSS_META_KEY, true );
			if ( ! array_key_exists( $uid, $shortcodes_inline_css ) ) {
				$shortcode_css = $this->generate_inline_css( array(), $this->get_atts() );
				if ( array_key_exists( $uid, $shortcode_css ) ) {
					$shortcodes_inline_css[ $uid ] = $shortcode_css[ $uid ];
					update_post_meta( get_the_ID(), self::INLINE_CSS_META_KEY, $shortcodes_inline_css );
				}
			}

			if ( array_key_exists( $uid, $shortcodes_inline_css ) ) {
				$inline_css = $shortcodes_inline_css[ $uid ];
			}
		}

		/**
		 * Allow to change shortcodes inline css before output.
		 *
		 * @since 6.0.0
		 */
		$inline_css = apply_filters( 'the7_shortcodes_get_inline_css', $inline_css, $this );

		if ( $inline_css ) {
			echo '<style type="text/css" data-type="the7_shortcodes-inline-css">';
			echo $inline_css;
			echo '</style>';
		}

		return true;
	}

}