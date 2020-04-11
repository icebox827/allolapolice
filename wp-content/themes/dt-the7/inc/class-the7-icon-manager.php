<?php
/**
 * The7 Icons Manager.
 *
 * @since 6.8.0
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Icon_Manager
 */
class The7_Icon_Manager {

	protected static $iconlist = array();

	const ICONS_DIR_NAME   = 'smile_fonts';
	const TEMP_DIR_NAME    = 'smile_temp';
	const CONFIG_FILE_NAME = 'charmap.php';

	/**
	 * Add base hooks.
	 */
	public static function add_hooks() {
		add_action( 'admin_menu', array( __CLASS__, 'add_admin_menu' ) );
		add_action( 'wp_ajax_the7_icons_manager_add_zipped_font', array( __CLASS__, 'add_zipped_font' ) );
		add_action( 'wp_ajax_the7_icons_manager_remove_zipped_font', array( __CLASS__, 'remove_zipped_font' ) );
		add_action( 'wp_ajax_the7_icons_manager_add_font_awesome', array( __CLASS__, 'add_font_awesome' ) );
		add_action( 'wp_ajax_the7_icons_manager_add_ua_default_icons', array( __CLASS__, 'add_ua_default_icons' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_icon_fonts' ) );
	}

	/**
	 * Add admin menu page.
	 */
	public static function add_admin_menu() {
		$hook_suffix = add_submenu_page(
			'the7-dashboard',
			_x( 'Icons Manager', 'admin', 'the7mk2' ),
			_x( 'Icons Manager', 'admin', 'the7mk2' ),
			'edit_theme_options',
			'the7-icons',
			array(
				__CLASS__,
				'icon_manager_dashboard',
			)
		);

		if ( class_exists( 'The7_Admin_Dashboard' ) ) {
			$the7_dashboard = new The7_Admin_Dashboard();
			add_action( 'admin_print_styles-' . $hook_suffix, array( $the7_dashboard, 'enqueue_styles' ) );
			add_action( 'admin_print_scripts-' . $hook_suffix, array( $the7_dashboard, 'enqueue_scripts' ) );
		}

		add_action( 'admin_print_scripts-' . $hook_suffix, array( __CLASS__, 'admin_scripts' ) );
	}

	/**
	 * Enqueue admin scripts.
	 */
	public static function admin_scripts() {
		$admin_uri = PRESSCORE_ADMIN_URI;

		the7_register_style( 'the7-icon-manager', "{$admin_uri}/assets/css/the7-icon-manager" );
		the7_register_script( 'the7-icon-manager', "{$admin_uri}/assets/js/the7-icon-manager", array( 'jquery' ) );

		wp_enqueue_script( 'the7-icon-manager' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_media();
		wp_enqueue_style( 'the7-icon-manager' );

		if ( self::is_fontawesome_enabled() ) {
			the7_register_fontawesome_style( 'the7-awesome-fonts' );
			wp_enqueue_style( 'the7-awesome-fonts' );
		}

		self::enqueue_icon_fonts();

		wp_localize_script(
			'the7-icon-manager',
			'the7IconManagerLocal',
			array(
				'nonces' => array(
					'add_zipped_font'          => wp_create_nonce( 'the7-add-zipped-fonts-nonce' ),
					'remove_zipped_font'       => wp_create_nonce( 'the7-remove-zipped-fonts-nonce' ),
					'add_add_font_awesome'     => wp_create_nonce( 'the7-add-font-awesome-nonce' ),
					'add_add_ua_default_icons' => wp_create_nonce( 'the7-add-ua-default-icons-nonce' ),
				),
				'text'   => array(
					'error'   => array(
						'invalid_file_format'       => wp_kses_post( _x( 'Please upload a valid ZIP file.<br/>You can create the file on icomoon.io', 'admin', 'the7mk2' ) ),
						'server_error'              => esc_html_x( 'Could not add the font because the server did not respond. Please reload the page, then try again.', 'admin', 'the7mk2' ),
						'could_not_add_font'        => wp_kses_post( _x( 'Could not add the font.<br/>The script returned the following error:', 'admin', 'the7mk2' ) ),
						'server_error_while_delete' => wp_kses_post( _x( 'Could not remove the font because the server did not respond.<br/>Please reload the page, then try again', 'admin', 'the7mk2' ) ),
						'could_not_remove_font'     => esc_html_x( 'Could not remove the font', 'admin', 'the7mk2' ),
					),
					'success' => array(
						'font_added' => esc_html_x( 'Font icon added successfully! Reloading ...', 'admin', 'the7mk2' ),
					),
				),
			)
		);
	}

	/**
	 * Enqueue icon fonts.
	 */
	public static function enqueue_icon_fonts() {
		$fonts = self::get_custom_icons();

		if ( ! $fonts ) {
			return;
		}

		$font_base_url = self::get_font_url();
		foreach ( $fonts as $font => $info ) {
			if ( strpos( $info['style'], 'http://' ) !== false ) {
				wp_enqueue_style( 'the7-' . $font, $info['style'] );
			} else {
				wp_enqueue_style( 'the7-' . $font, trailingslashit( $font_base_url ) . $info['style'] );
			}
		}
	}

	/**
	 * Display icons manager page.
	 */
	public static function icon_manager_dashboard() {
		self::maybe_delete_all_fonts();
		?>
			<div id="the7-dashboard" class="wrap">
				<h1>
				<?php echo esc_html_x( 'Icon Fonts Manager', 'admin', 'the7mk2' ); ?>
					<a href="#the7_upload_icon" class="add-new-h2 the7_upload_icon"
					   data-target="iconfont_upload"
					   data-title="<?php echo esc_attr_x( 'Upload/Select Fontello Font Zip', 'admin', 'the7mk2' ); ?>"
					   data-type="application/zip"
					   data-button="<?php echo esc_attr_x( 'Insert Fonts Zip File', 'admin', 'the7mk2' ); ?>"
					   data-trigger="the7_icon_manager_insert"
					   data-class="media-frame"
					>
					<?php echo esc_html_x( 'Upload New Icons', 'admin', 'the7mk2' ); ?>
					</a>&nbsp;<span class="spinner"></span>

					<?php if ( ! self::is_fontawesome_enabled() ) { ?>
						<a href="#the7_install_fa" class="add-new-h2 the7_add_fontawesome" data-fa-type="fa4">
							<?php echo esc_html_x( 'Install Font Awesome 4', 'admin', 'the7mk2' ); ?>
						</a>
						<a href="#the7_install_fa" class="add-new-h2 the7_add_fontawesome" data-fa-type="fa5">
							<?php echo esc_html_x( 'Install Font Awesome 5', 'admin', 'the7mk2' ); ?>
						</a>
					<?php } ?>

					<?php
					if ( class_exists( 'Ultimate_VC_Addons', false ) && ! self::is_ua_default_icons_installed() ) {
						printf(
							'<a href="#the7_install_bsf_default_icons" class="add-new-h2 the7-add-ua-default-font">%s</a>',
							esc_html_x( 'Install UA default icons', 'admin', 'the7mk2' )
						);
					}
					?>
				</h1>
				<div id="msg"></div>
			<?php
			self::print_icon_set( self::get_the7_icons(), 'The7 Icons', '', false );
			self::get_font_set();
			$fa_status = self::is_fontawesome_enabled();
			if ( $fa_status ) {
				$fa_title = $fa_status === 'fa5' ? 'Font Awesome 5' : 'Font Awesome 4';
				self::print_icon_set( self::get_fontawesome_icons(), $fa_title );
			}
			?>
			</div>
			<?php
	}

	/**
	 * Display icons set.
	 */
	public static function get_font_set() {
		$upload_dir = wp_get_upload_dir();
		$fonts = self::get_custom_icons();
		foreach ( $fonts as $font => $info ) {
			$icon_set = array();
			$icons    = array();
			$file     = $info['include'] . '/' . $info['config'];
			if ( ! file_exists( $file ) ) {
				$file       = trailingslashit( $upload_dir['basedir'] ) . $file;
				if ( ! file_exists( $file ) ) {
					self::remove_font( $font );
					continue;
				}
			}
			include $file;
			if ( ! empty( $icons ) ) {
				$icon_set = array_merge( $icon_set, $icons );
			}

			self::print_icon_set( $icon_set, $font, "$font-" );
		}
	}

	public static function print_icon_set( $icon_set, $font, $icons_prefix = '', $can_be_deleted = true ) {
		if ( empty( $icon_set ) ) {
			return '';
		}

		$unescaped_font = $font;
		$font           = str_replace( ' ', '-', $font );
		$output         = '<div class="icon_set-' . esc_attr( $font ) . ' metabox-holder">';
		$output        .= '<div class="postbox">';
		reset( $icon_set );
		$count = count( current( $icon_set ) );
		if ( $font === 'smt' || $font === 'Defaults' ) {
			$output .= '<h3 class="icon_font_name"><strong>' . _x( 'Default Icons', 'admin', 'the7mk2' ) . '</strong>';
		} else {
			$output .= '<h3 class="icon_font_name"><strong>' . esc_html( ucfirst( $unescaped_font ) ) . '</strong>';
		}
		$output .= '<span class="fonts-count count-' . esc_attr( $font ) . '">' . $count . '</span>';
		if ( $can_be_deleted ) {
			$output .= '<button class="button button-secondary button-small the7_del_icon" data-delete=' . esc_attr( $font ) . ' data-title="' . esc_attr( _x( 'Delete Icon Set', 'admin', 'the7mk2' ) ) . '">' . esc_html( _x( 'Delete Icon Set', 'admin', 'the7mk2' ) ) . '</button>';
		}
		$output .= '</h3>';
		$output .= '<div class="inside"><div class="icon_actions">';
		$output .= '</div>';
		$output .= '<div class="icon_search"><ul class="icons-list fi_icon">';
		foreach ( $icon_set as $icons ) {
			foreach ( $icons as $icon ) {
				$output .= '<li title="' . esc_attr( $icon['class'] ) . '" data-icons="' . esc_attr( $icon['class'] ) . '" data-icons-tag="' . esc_attr( $icon['tags'] ) . '">';
				$output .= '<i class="' . esc_attr( $icons_prefix . $icon['class'] ) . '"></i><label class="icon">' . esc_html( $icon['class'] ) . '</label></li>';
			}
		}
		$output .= '</ul>';
		$output .= '</div><!-- .icon_search-->';
		$output .= '</div><!-- .inside-->';
		$output .= '</div><!-- .postbox-->';
		$output .= '</div>';

		echo $output;
	}

	/**
	 * Ajax action to add icons.
	 */
	public static function add_zipped_font() {
		global $wp_filesystem;

		try {
			check_ajax_referer( 'the7-add-zipped-fonts-nonce', 'security' );

			if ( ! current_user_can( apply_filters( 'the7_file_upload_capability', 'switch_themes' ) ) ) {
				throw new Exception(
					_x(
						"Using this feature is reserved for Super Admins. You unfortunately don't have the necessary permissions.",
						'admin',
						'the7mk2'
					)
				);
			}

			self::load_wp_filesystem();

			if ( ! isset( $_POST['values']['id'] ) ) {
				throw new Exception( _x( 'Unable to get attachment id.', 'admin', 'the7mk2' ) );
			}

			$tmp_dir    = self::get_tmp_dir();
			$font_dir   = self::get_font_dir();
			$attachment = $_POST['values'];
			$filter     = array(
				'\.eot',
				'\.svg',
				'\.ttf',
				'\.woff',
				'\.json',
				'\.css',
			);
			$unzipped   = self::zip_flatten( get_attached_file( $attachment['id'] ), $tmp_dir, $filter );
			if ( ! $unzipped ) {
				throw new Exception( _x( 'Unable to unzip icons archive.', 'admin', 'the7mk2' ) );
			}

			$installed_fonts = (array) $wp_filesystem->dirlist( $font_dir );
			$font_name       = self::create_config( $tmp_dir, $font_dir, array_keys( $installed_fonts ) );

			die( 'the7_icon_font_added: ' . $font_name );
		} catch ( Exception $e ) {
			echo $e->getMessage();
			die();
		}
	}

	/**
	 * Ajax action to remove icons.
	 */
	public static function remove_zipped_font() {
		global $wp_filesystem;

		try {
			check_ajax_referer( 'the7-remove-zipped-fonts-nonce', 'security' );

			if ( ! current_user_can( apply_filters( 'the7_file_upload_capability', 'switch_themes' ) ) ) {
				throw new Exception(
					_x(
						"Using this feature is reserved for Super Admins. You unfortunately don't have the necessary permissions.",
						'admin',
						'the7mk2'
					)
				);
			}

			$font = sanitize_text_field( wp_unslash( $_POST['del_font'] ) );

			$is_font_awesome = in_array( $font, array( 'Font-Awesome-4', 'Font-Awesome-5' ), true );
			$is_ua_default_icons = $font === 'Defaults';

			$return_value = 'the7_icon_font_removed';
			if ( $is_font_awesome || $is_ua_default_icons ) {
				$return_value .= '_with_reload';
			}

			if ( $is_font_awesome ) {
				self::disable_fontawesome();
			} else {
				self::load_wp_filesystem();

				$list = self::load_iconfont_list();
				if ( ! isset( $list[ $font ] ) ) {
					throw new Exception( _x( 'Was not able to remove Font.', 'admin', 'the7mk2' ) );
				}

				$font_to_delete = $list[ $font ];
				$wp_filesystem->rmdir( $font_to_delete['include'], true );
				self::remove_font( $font );
			}

			die( $return_value );
		} catch ( Exception $e ) {
			echo $e->getMessage();
			die();
		}
	}

	/**
	 * Add Font Awesome.
	 *
	 * @throws Exception
	 */
	public static function add_font_awesome() {
		try {
			check_ajax_referer( 'the7-add-font-awesome-nonce', 'security' );

			if ( ! current_user_can( apply_filters( 'the7_file_upload_capability', 'switch_themes' ) ) ) {
				throw new Exception(
					_x(
						"Using this feature is reserved for Super Admins. You unfortunately don't have the necessary permissions.",
						'admin',
						'the7mk2'
					)
				);
			}

			$type = isset( $_POST['type'] ) ? $_POST['type'] : 'fa5';
			$type === 'fa5' ? self::enable_fontawesome5() : self::enable_fontawesome4();
			die( 'the7_icon_font_added: FontAwesome' );
		} catch ( Exception $e ) {
			echo $e->getMessage();
			die();
		}
	}

	/**
	 * Add UA default icons.
	 */
	public function add_ua_default_icons() {
		try {
			check_ajax_referer( 'the7-add-ua-default-icons-nonce', 'security' );

			if ( ! current_user_can( apply_filters( 'the7_file_upload_capability', 'switch_themes' ) ) ) {
				throw new Exception(
					_x(
						"Using this feature is reserved for Super Admins. You unfortunately don't have the necessary permissions.",
						'admin',
						'the7mk2'
					)
				);
			}

			if ( class_exists( 'AIO_Icon_Manager' ) ) {
				$ua_icons_manager = new AIO_Icon_Manager();
				$ua_icons_manager->AIO_move_fonts();
				die( 'the7_icon_font_added: Defaults' );
			}
			die( _x( 'Seems that Ultimate VC Addons plugin is inactive. Please, activate it and try again.', 'admin', 'the7mk2' ) );
		} catch ( Exception $e ) {
			echo $e->getMessage();
			die();
		}
	}

	/**
	 * @return string
	 */
	protected static function get_tmp_dir() {
		$wp_upload_dir = wp_get_upload_dir();

		return trailingslashit( $wp_upload_dir['basedir'] ) . self::ICONS_DIR_NAME . '/' . self::TEMP_DIR_NAME;
	}

	/**
	 * @return string
	 */
	protected static function get_font_dir() {
		$wp_upload_dir = wp_get_upload_dir();

		return trailingslashit( $wp_upload_dir['basedir'] ) . self::ICONS_DIR_NAME;
	}

	/**
	 * @return string
	 */
	protected static function get_font_url() {
		$wp_upload_dir = wp_get_upload_dir();

		return set_url_scheme( trailingslashit( $wp_upload_dir['baseurl'] ) ) . self::ICONS_DIR_NAME;
	}

	/**
	 * @param       $file
	 * @param       $to
	 * @param array $filter
	 *
	 * @return bool
	 * @throws Exception
	 */
	protected static function zip_flatten( $file, $to, $filter = array() ) {
		global $wp_filesystem;

		wp_raise_memory_limit( 'admin' );

		$to = trailingslashit( $to );

		if ( $wp_filesystem->exists( $to ) ) {
			$wp_filesystem->rmdir( $to, true );
		}

		if ( ! wp_mkdir_p( $to ) ) {
			throw new Exception( __( "Wasn't able to create temp folder", 'the7mk2' ) );
		}

		if ( ! class_exists( 'ZipArchive' ) ) {
			throw new Exception( __( "Wasn't able to work with Zip Archive", 'the7mk2' ) );
		}

		$z     = new ZipArchive();
		$zopen = $z->open( $file, ZIPARCHIVE::CHECKCONS );
		if ( $zopen !== true ) {
			throw new Exception( __( 'Incompatible Archive.', 'the7mk2' ) );
		}

		for ( $i = 0; $i < $z->numFiles; $i++ ) {
			if ( ! $info = $z->statIndex( $i ) ) {
				throw new Exception( __( 'Could not retrieve file from archive.', 'the7mk2' ) );
			}

			// Directory.
			if ( '/' === substr( $info['name'], -1 ) ) {
				continue;
			}

			// Don't extract the OS X-created __MACOSX directory files.
			if ( 0 === strpos( $info['name'], '__MACOSX/' ) ) {
				continue;
			}

			// Don't extract invalid files:
			if ( 0 !== validate_file( $info['name'] ) ) {
				continue;
			}

			if ( $filter ) {
				$regex = implode( '|', $filter );
				if ( ! preg_match( "!($regex)$!", $info['name'] ) ) {
					continue;
				}
			}

			$contents = $z->getFromIndex( $i );
			if ( false === $contents ) {
				throw new Exception( __( 'Could not extract file from archive.', 'the7mk2' ) );
			}

			if ( ! $wp_filesystem->put_contents( $to . basename( $info['name'] ), $contents, FS_CHMOD_FILE ) ) {
				throw new Exception( __( 'Could not copy file.', 'the7mk2' ) );
			}
		}
		$z->close();

		return true;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	protected static function create_config( $work_dir, $font_dir, $installed_fonts = array() ) {
		global $wp_filesystem;

		$json_file = self::find_json( $work_dir );
		$svg_file  = self::find_svg( $work_dir );
		if ( empty( $json_file ) || empty( $svg_file ) ) {
			$wp_filesystem->rmdir( $work_dir, true );
			throw new Exception( __( 'selection.json or SVG file not found. Was not able to create the necessary config files', 'the7mk2' ) );
		}

		$response = $wp_filesystem->get_contents( trailingslashit( $work_dir ) . $svg_file );
		$json     = $wp_filesystem->get_contents( trailingslashit( $work_dir ) . $json_file );

		if ( '' === $json || '' === $response ) {
			return '';
		}

		$xml = simplexml_load_string( $response );

		$font_attr = $xml->defs->font->attributes();
		$font_name = (string) $font_attr['id'];

		if ( $font_name === 'unknown' || in_array( $font_name, $installed_fonts, true ) ) {
			$wp_filesystem->rmdir( $work_dir, true );
			throw new Exception( __( 'It seems that the font with the same name is already exists! Please upload the font with different name.', 'the7mk2' ) );
		}

		$glyphs = $xml->defs->font->children();

		$unicodes = array();
		if ( isset( $glyphs->glyph ) ) {
			foreach ( $glyphs->glyph as $glyph ) {
				$attributes = $glyph->attributes();
				$unicodes[] = (string) $attributes['unicode'];
			}
			unset( $unicodes[0] );
		}

		$file_contents = json_decode( $json );
		if ( ! isset( $file_contents->IcoMoonType ) ) {
			$wp_filesystem->rmdir( $work_dir, true );
			throw new Exception( __( 'Uploaded font is not from IcoMoon. Please upload fonts created with the IcoMoon App Only.', 'the7mk2' ) );
		}

		$icons = $file_contents->icons;
		if ( empty( $icons ) ) {
			$wp_filesystem->rmdir( $work_dir, true );
			throw new Exception( __( 'There are no icons.', 'the7mk2' ) );
		}

		$n           = 1;
		$json_config = array();
		foreach ( $icons as $icon ) {
			$icon_name                               = $icon->properties->name;
			$tags                                    = implode( ',', $icon->icon->tags );
			$json_config[ $font_name ][ $icon_name ] = array(
				'class'   => str_replace( array( ' ', ',' ), array( '', ' ' ), $icon_name ),
				'tags'    => $tags,
				'unicode' => $unicodes[ $n++ ],
			);
		}

		self::write_config( $font_name, $json_config, $work_dir );
		self::re_write_css( $font_name, $work_dir );
		self::rename_files( $font_name, $work_dir );
		self::rename_folder( $work_dir, "{$font_dir}/{$font_name}" );
		self::add_font( $font_name, self::ICONS_DIR_NAME . "/{$font_name}" );

		return $font_name;
	}

	/**
	 * @param $font_name
	 * @param $json_config
	 * @param $work_dir
	 *
	 * @throws Exception
	 */
	protected static function write_config( $font_name, $json_config, $work_dir ) {
		global $wp_filesystem;

		$config = '<?php $icons = array();';
		foreach ( $json_config[ $font_name ] as $icon => $info ) {
			if ( empty( $info ) ) {
				$wp_filesystem->rmdir( $work_dir, true );
				throw new Exception( __( 'Was not able to write a config file', 'the7mk2' ) );
			}

			$config .= "\r\n\$icons['{$font_name}']['{$icon}'] = array('class'=>'{$info['class']}','tags'=>'{$info['tags']}','unicode'=>'{$info['unicode']}');";
		}

		$charmap = $work_dir . '/' . self::CONFIG_FILE_NAME;
		if ( ! $wp_filesystem->put_contents( $charmap, $config ) ) {
			$wp_filesystem->rmdir( $work_dir, true );
			throw new Exception( __( 'Was not able to write a config file', 'the7mk2' ) );
		}
	}

	/**
	 * @param $font_name
	 * @param $work_dir
	 *
	 * @throws Exception
	 */
	protected static function re_write_css( $font_name, $work_dir ) {
		global $wp_filesystem;

		$style = $work_dir . '/style.css';
		$file  = $wp_filesystem->get_contents( $style );
		if ( ! $file ) {
			throw new Exception( __( 'Unable to write css. Upload icons downloaded only from icomoon', 'the7mk2' ) );
		}

		$find_and_replace = array(
			'fonts/'  => '',
			'icon-'   => "{$font_name}-",
			'.icon {' => "[class^='{$font_name}-'], [class*='{$font_name}-'] {",
			'i {'     => "[class^={$font_name}-'], [class*='{$font_name}-'] {",
		);
		$str              = str_replace( array_keys( $find_and_replace ), array_values( $find_and_replace ), $file );

		/* Remove comments */
		$str = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str );

		/* Remove tabs, spaces, newlines, etc. */
		$str = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $str );

		$wp_filesystem->put_contents( $style, $str );
	}

	/**
	 * @param $font_name
	 * @param $work_dir
	 */
	protected static function rename_files( $font_name, $work_dir ) {
		$extensions = array( 'eot', 'svg', 'ttf', 'woff', 'css' );
		foreach ( glob( trailingslashit( $work_dir ) . '*' ) as $file ) {
			$path_parts = pathinfo( $file );

			if ( strpos( $path_parts['filename'], '.dev' ) !== false || ! in_array( $path_parts['extension'], $extensions ) ) {
				continue;
			}

			if ( $path_parts['filename'] !== $font_name ) {
				rename( $file, trailingslashit( $path_parts['dirname'] ) . $font_name . '.' . $path_parts['extension'] );
			}
		}
	}

	/**
	 * @param $source_dir
	 * @param $destination_dir
	 *
	 * @return bool
	 * @throws Exception
	 */
	protected static function rename_folder( $source_dir, $destination_dir ) {
		global $wp_filesystem;

		$wp_filesystem->rmdir( $destination_dir );
		if ( ! rename( $source_dir, $destination_dir ) ) {
			$wp_filesystem->rmdir( $source_dir );
			throw new Exception( __( 'Unable to add this font. Please try again.', 'the7mk2' ) );
		}

		return true;
	}

	protected static function maybe_delete_all_fonts() {
		global $wp_filesystem, $plugin_page;

		if ( ! isset( $_GET['delete-the7-fonts'] ) ) {
			return;
		}

		if ( ! current_user_can( apply_filters( 'the7_file_upload_capability', 'switch_themes' ) ) ) {
			wp_die( __( "Using this feature is reserved for Super Admins. You unfortunately don't have the necessary permissions.", 'the7mk2' ) );
		}

		try {
			self::load_wp_filesystem();
		} catch ( Exception $e ) {
			wp_die( $e->getMessage() );
		}

		$wp_filesystem->rmdir( self::get_font_dir(), true );
		delete_option( 'smile_fonts' );
		wp_redirect( admin_url( "admin.php?page={$plugin_page}" ) );
		exit;
	}

	protected static function add_font( $font_name, $font_dir ) {
		$fonts               = self::get_custom_icons();
		$fonts[ $font_name ] = array(
			'include' => $font_dir,
			'folder'  => $font_dir,
			'style'   => "{$font_name}/{$font_name}.css",
			'config'  => self::CONFIG_FILE_NAME,
		);
		update_option( 'smile_fonts', $fonts );
	}

	protected static function remove_font( $font ) {
		$fonts = self::get_custom_icons();
		if ( isset( $fonts[ $font ] ) ) {
			unset( $fonts[ $font ] );
			update_option( 'smile_fonts', $fonts );
		}
	}

	/**
	 * @param string $tmp_dir
	 *
	 * @return string
	 */
	protected static function find_json( $tmp_dir ) {
		$files = scandir( $tmp_dir );
		foreach ( $files as $file ) {
			if ( strpos( strtolower( $file ), '.json' ) !== false && $file[0] !== '.' ) {
				return $file;
			}
		}

		return '';
	}

	/**
	 * @param string $tmp_dir
	 *
	 * @return string
	 */
	protected static function find_svg( $tmp_dir ) {
		$files = scandir( $tmp_dir );
		foreach ( $files as $file ) {
			if ( strpos( strtolower( $file ), '.svg' ) !== false && $file[0] !== '.' ) {
				return $file;
			}
		}

		return '';
	}

	/**
	 * Return icons files list to enqueue.
	 *
	 * @return array
	 */
	public static function load_iconfont_list() {
		if ( ! empty( self::$iconlist ) ) {
			return self::$iconlist;
		}

		$font_configs = self::get_custom_icons();
		// if we got any include the charmaps and add the chars to an array
		$upload_dir = wp_get_upload_dir();
		$path       = trailingslashit( $upload_dir['basedir'] );
		$url        = trailingslashit( $upload_dir['baseurl'] );
		foreach ( $font_configs as $key => $config ) {
			if ( empty( $config['full_path'] ) ) {
				$font_configs[ $key ]['include'] = $path . $font_configs[ $key ]['include'];
				$font_configs[ $key ]['folder']  = $url . $font_configs[ $key ]['folder'];
			}
		}
		// cache the result
		self::$iconlist = $font_configs;

		return $font_configs;
	}

	/**
	 * Return icons classes to be used in shortcodes UI.
	 *
	 * @return array
	 */
	public static function get_icons_classes() {
		$icons_classes = array();
		foreach ( self::get_icon_fonts_list() as $font => $icons ) {
			$icons_classes[ $font ] = array();

			foreach ( array_keys( $icons ) as $icon ) {
				$icons_classes[ $font ][] = current( explode( ',', "$font-$icon" ) );
			}
		}

		return $icons_classes;
	}

	/**
	 * @return array
	 */
	public static function get_icon_fonts_list() {
		$upload_dir = wp_get_upload_dir();
		$path       = trailingslashit( $upload_dir['basedir'] );
		$icon_fonts = array();
		$icon_fonts = array_merge( $icon_fonts, self::get_the7_icons() );
		foreach ( self::get_custom_icons() as $font => $info ) {
			$icons = array();
			$file  = $path . $info['include'] . '/' . $info['config'];
			if ( ! is_readable( $file ) ) {
				continue;
			}

			include $file;

			if ( ! isset( $icons[ $font ] ) ) {
				continue;
			}

			$icon_fonts[ $font ] = $icons[ $font ];
		}

		if ( self::is_fontawesome_enabled() ) {
			$icon_fonts = array_merge( $icon_fonts, self::get_fontawesome_icons() );
		}

		return $icon_fonts;
	}

	/**
	 * @throws Exception
	 */
	protected static function load_wp_filesystem() {
		global $wp_filesystem;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$wp_upload = wp_get_upload_dir();
		if ( ! $wp_filesystem && ! WP_Filesystem( false, $wp_upload['basedir'] ) ) {
			throw new Exception( __( 'Cannot access file system.', 'the7mk2' ) );
		}
	}

	/**
	 * Return 'smile_fonts' option value.
	 *
	 * @return array
	 */
	protected static function get_custom_icons() {
		$icons = get_option( 'smile_fonts' );

		return $icons ? (array) $icons : array();
	}

	/**
	 * Return true if UA Default icons is installed.
	 *
	 * @return bool
	 */
	public static function is_ua_default_icons_installed() {
		$installed_icons = self::get_custom_icons();

		return array_key_exists( 'Defaults', $installed_icons );
	}

	public static function is_fontawesome_enabled() {
		return get_option( 'the7_fontawesome_enabled' );
	}

	public static function enable_fontawesome5() {
		update_option( 'the7_fontawesome_enabled', 'fa5' );
	}

	public static function enable_fontawesome4() {
		update_option( 'the7_fontawesome_enabled', 'fa4' );
	}

	public static function disable_fontawesome() {
		update_option( 'the7_fontawesome_enabled', false );
	}

	protected static function get_fontawesome_icons() {
		$font_awesome_icons                 = array();
		$font_awesome_icons['Font Awesome'] = include PRESSCORE_EXTENSIONS_DIR . '/font-awesome-icons.php';
		foreach ( $font_awesome_icons['Font Awesome'] as &$fa_icon ) {
			$fa_icon = array(
				'class'   => $fa_icon,
				'tags'    => '',
				'unicode' => '',
			);
		}

		return $font_awesome_icons;
	}

	protected static function get_the7_icons() {
		$the7_icons               = array();
		$the7_icons['The7 Icons'] = include PRESSCORE_EXTENSIONS_DIR . '/the7-icons-list.php';
		foreach ( $the7_icons['The7 Icons'] as &$fa_icon ) {
			$fa_icon = array(
				'class'   => $fa_icon,
				'tags'    => '',
				'unicode' => '',
			);
		}

		return $the7_icons;
	}
}
