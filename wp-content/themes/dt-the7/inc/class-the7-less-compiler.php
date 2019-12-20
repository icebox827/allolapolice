<?php
/**
 * The7 Less compiler.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Less_Compiler
 */
class The7_Less_Compiler {

	/**
	 * Less compiler.
	 *
	 * @var the7_lessc Less compiler.
	 */
	protected $lessc;

	/**
	 * The7_Less_Compiler constructor.
	 *
	 * @param array      $less_vars  Less vars array.
	 * @param array|null $import_dir Import dir.
	 *
	 * @throws Exception Throws Exception if WP Filesystem is not accessible.
	 */
	public function __construct( $less_vars = array(), $import_dir = null ) {
		global $wp_filesystem;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$wp_upload = wp_get_upload_dir();
		if ( ! $wp_filesystem && ! WP_Filesystem( false, $wp_upload['basedir'] ) ) {
			throw new Exception( __( 'Cannot access file system.', 'the7mk2' ) );
		}

		if ( ! class_exists( 'the7_lessc' ) ) {
			require PRESSCORE_DIR . '/vendor/lessphp/the7_lessc.inc.php';
		}

		$this->lessc = new the7_lessc();

		// Register custom less functions.
		The7_Less_Functions::register_functions( $this->lessc );

		if ( $import_dir === null ) {
			$import_dir = array( PRESSCORE_THEME_DIR . '/css', PRESSCORE_THEME_DIR . '/css/dynamic-less' );
		}

		$this->lessc->setImportDir( $import_dir );
		$this->lessc->setVariables( $less_vars );
	}

	/**
	 * Compile less to css.
	 *
	 * @param string $source_file Source file.
	 * @param string $output_file Output file.
	 * @param array  $imports     Imports.
	 */
	public function compile_to_file( $source_file, $output_file, $imports = array() ) {
		$css = $this->compile_file( $source_file, $imports );
		$css = $this->make_relative_urls( $css, $source_file, $output_file );
		wp_mkdir_p( dirname( $output_file ) );
		$this->put_contents( $output_file, $css );
	}

	/**
	 * Compile less file.
	 *
	 * @param string $less_file Less file.
	 * @param array  $imports   Imports.
	 *
	 * @return false|string
	 */
	public function compile_file( $less_file, $imports = array() ) {
		$less = $this->get_file_contents( $less_file );

		return $this->compile( $less, $imports );
	}

	/**
	 * Compile less code.
	 *
	 * @param string $less    Less code.
	 * @param array  $imports Imports.
	 *
	 * @return false|string
	 */
	public function compile( $less, $imports = array() ) {
		if ( $imports ) {
			$imports           = array_filter( (array) $imports );
			$import_anchors    = array();
			$import_statements = array();
			foreach ( $imports as $import_anchor => $import_files ) {
				$import_anchors[]    = '// ' . strtoupper( $import_anchor );
				$import_statements[] = array_reduce(
					(array) $import_files,
					array( $this, 'reduce_dynamic_imports' )
				);
			}
			$less = str_replace(
				$import_anchors,
				$import_statements,
				$less
			);
		}

		return $this->lessc->compile( $less );
	}

	/**
	 * Return file contents.
	 *
	 * @global WP_Filesystem_Base $wp_filesystem
	 *
	 * @param string $source_file Source file.
	 *
	 * @return string|false Read data on success, false on failure.
	 */
	public function get_file_contents( $source_file ) {
		/**
		 * WP Filesystem global.
		 *
		 * @var WP_Filesystem_Base $wp_filesystem
		 */
		global $wp_filesystem;

		return $wp_filesystem->get_contents( $source_file );
	}

	/**
	 * Determine that $abspath is writable.
	 *
	 * @param string $abspath Absolute path.
	 *
	 * @return bool
	 */
	public function is_writable( $abspath ) {
		global $wp_filesystem;

		return $wp_filesystem->is_writable( $abspath );
	}

	/**
	 * Meant to internal usage. Reduce import files array to import statements string.
	 *
	 * @param string $cary Import statements string.
	 * @param string $file Import file.
	 *
	 * @return string
	 */
	public function reduce_dynamic_imports( $cary, $file ) {
		$file = (string) $file;

		return "$cary\n@import \"{$file}\";";
	}

	/**
	 * Create/overwrite $output_file file with $content.
	 *
	 * @global WP_Filesystem_Base $wp_filesystem
	 *
	 * @param string $output_file Output file.
	 * @param string $content Content.
	 */
	protected function put_contents( $output_file, $content ) {
		/**
		 * WP Filesystem global.
		 *
		 * @var WP_Filesystem_Base $wp_filesystem
		 */
		global $wp_filesystem;

		$wp_filesystem->put_contents( $output_file, $content );
	}

	/**
	 * Make relative urls.
	 *
	 * @param string $css CSS.
	 * @param string $source_file Source file.
	 * @param string $output_file Output file.
	 *
	 * @return string
	 */
	protected function make_relative_urls( $css, $source_file, $output_file ) {
		$url_filter = new The7_Relative_Url_Filter( $source_file, $output_file );
		$css        = preg_replace_callback(
			'#url\s*\((?P<quote>[\'"]{0,1})(?P<url>[^\'"\)]+)\1\)#siU',
			array( $url_filter, 'filter' ),
			$css
		);

		return $css;
	}
}

class The7_Relative_Url_Filter {

	protected $path_from_uploads_to_wp_root;
	protected $path_from_wp_root_to_theme;

	public function __construct( $source_file, $output_file ) {
		$wp_upload_dir = wp_get_upload_dir();
		$content_relative_path = str_replace( $wp_upload_dir['basedir'], $wp_upload_dir['baseurl'], dirname( $output_file ) );
		$content_relative_path = str_replace( trailingslashit( site_url() ), '', $content_relative_path );
		$this->path_from_uploads_to_wp_root = implode( '/', array_fill( 0, count( explode( '/', $content_relative_path ) ), '..' ) );
		$this->path_from_wp_root_to_theme = str_replace( ABSPATH, '', dirname( $source_file ) );
	}

	public function filter( $matches ) {
		if ( preg_match( '#^(http|@|data:|/)#Ui', $matches[2] ) ) {
			return str_replace( site_url(), $this->path_from_uploads_to_wp_root, $matches[0] );
		}

		return sprintf( 'url(%s%s%1$s)', $matches[1], "{$this->path_from_uploads_to_wp_root}/{$this->path_from_wp_root_to_theme}/{$matches[2]}" );
	}
}