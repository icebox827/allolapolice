<?php
/**
 * Deprecated function.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * @deprecated
 *
 * @param $postID
 * @param $post
 */
function presscore_save_shortcode_inline_css( $postID, $post ) {
	the7_save_shortcode_inline_css( $postID, $post );
}

/**
 * @deprecated
 *
 * @param $content
 *
 * @return string
 */
function presscore_generate_shortcode_css( $content ) {
	return the7_generate_shortcode_css( $content );
}

/**
 * Returns favicon tags html.
 *
 * @deprecated
 * @since 2.2.1
 * @return string
 */
function presscore_get_favicon() {
	return dt_get_favicon( presscore_choose_right_image_based_on_device_pixel_ratio( of_get_option( 'general-favicon', '' ), of_get_option( 'general-favicon_hd', '' ) ) );
}

/**
 * Return favicon html.
 *
 * @deprecated
 *
 * @param $icon string
 *
 * @return string.
 * @since presscore 0.1
 */
function dt_get_favicon( $icon = '' ) {
	$output = '';
	if ( ! empty( $icon ) ) {

		if ( strpos( $icon, '/wp-content' ) === 0 || strpos( $icon, '/files' ) === 0 ) {
			$icon = get_site_url() . $icon;
		}

		$ext = explode( '.', $icon );
		if ( count( $ext ) > 1 ) {
			$ext = end( $ext );
		} else {
			return '';
		}

		switch ( $ext ) {
			case 'png':
				$icon_type = esc_attr( image_type_to_mime_type( IMAGETYPE_PNG ) );
				break;
			case 'gif':
				$icon_type = esc_attr( image_type_to_mime_type( IMAGETYPE_GIF ) );
				break;
			case 'jpg':
			case 'jpeg':
				$icon_type = esc_attr( image_type_to_mime_type( IMAGETYPE_JPEG ) );
				break;
			case 'ico':
				$icon_type = esc_attr( 'image/x-icon' );
				break;
			default:
				return '';
		}

		$output .= '<!-- icon -->' . "\n";
		$output .= '<link rel="icon" href="' . $icon . '" type="' . $icon_type . '" />' . "\n";
		$output .= '<link rel="shortcut icon" href="' . $icon . '" type="' . $icon_type . '" />' . "\n";
	}

	return $output;
}

/**
 * Chooses what src to use, based on device pixel ratio and theme settings
 *
 * @deprecated
 *
 * @param  string $regular_img_src Regular image src
 * @param  string $hd_img_src      Hd image src
 *
 * @return string                  Best suitable src
 */
function presscore_choose_right_image_based_on_device_pixel_ratio( $regular_img_src, $hd_img_src = '' ) {
	$output_src = '';

	if ( ! $regular_img_src && ! $hd_img_src ) {
	} elseif ( ! $regular_img_src ) {
		$output_src = $hd_img_src;
	} elseif ( ! $hd_img_src ) {
		$output_src = $regular_img_src;
	} else {
		$output_src = dt_is_hd_device() ? $hd_img_src : $regular_img_src;
	}

	return $output_src;
}

/**
 * Get image based on devicePixelRatio coocie and theme options.
 *
 * @deprecated
 *
 * @param $logo    array Regular logo.
 * @param $r_logo  array Retina logo.
 * @param $default array Default logo.
 * @param $custom  string Custom img attributes.
 *
 * @return string.
 */
function dt_get_retina_sensible_image( $logo, $r_logo, $default, $custom = '', $class = '' ) {
	if ( empty( $default ) ) {
		return '';
	}

	if ( $logo && ! $r_logo ) {
		$r_logo = $logo;
	} elseif ( $r_logo && ! $logo ) {
		$logo = $r_logo;
	} elseif ( ! $r_logo && ! $logo ) {
		$logo = $r_logo = $default;
	}

	$img_meta = dt_is_hd_device() ? $r_logo : $logo;

	if ( ! isset( $img_meta['size'] ) && isset( $img_meta[1], $img_meta[2] ) ) {
		$img_meta['size'] = image_hwstring( $img_meta[1], $img_meta[2] );
	}
	$output = dt_get_thumb_img(
		array(
			'wrap'      => '<img %IMG_CLASS% %SRC% %SIZE% %CUSTOM% />',
			'img_class' => $class,
			'img_meta'  => $img_meta,
			'custom'    => $custom,
			'echo'      => false,
			// TODO: add alt if it's possible
			'alt'       => '',
		)
	);

	return $output;
}

/**
 * Get device pixel ratio cookie value and check if it greater than 1.
 *
 * @deprecated
 * @return boolean
 */
function dt_is_hd_device() {
	return ( isset( $_COOKIE['devicePixelRatio'] ) && $_COOKIE['devicePixelRatio'] > 1.3 );
}

/**
 * Add little javascript that detects devicePixelRatio and if it's more than 1 - reload the page.
 *
 * @deprecated
 */
function dt_core_detect_retina_script() {
	/*
	function createCookie(name, value, days) {
		var expires;
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
		}
		else expires = "";
		document.cookie = name + "=" + value + expires + "; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}

	function areCookiesEnabled() {
		var r = false;
		createCookie("testing", "Hello", 1);
		if (readCookie("testing") != null) {
			r = true;
			eraseCookie("testing");
		}
		return r;
	}

	(function(w){
		var targetCookie = readCookie('devicePixelRatio'),
			dpr=((w.devicePixelRatio===undefined)?1:w.devicePixelRatio);

		if( !areCookiesEnabled() || (targetCookie != null) ) return;

		createCookie('devicePixelRatio', dpr, 7);

		if ( dpr != 1 ) {
			w.location.reload(true);
		}

	})(window)


	function createCookie(a,d,b){if(b){var c=new Date;c.setTime(c.getTime()+864E5*b);b="; expires="+c.toGMTString()}else b="";document.cookie=a+"="+d+b+"; path=/"}function readCookie(a){a+="=";for(var d=document.cookie.split(";"),b=0;b<d.length;b++){for(var c=d[b];" "==c.charAt(0);)c=c.substring(1,c.length);if(0==c.indexOf(a))return c.substring(a.length,c.length)}return null}function eraseCookie(a){createCookie(a,"",-1)}
	function areCookiesEnabled(){var a=!1;createCookie("testing","Hello",1);null!=readCookie("testing")&&(a=!0,eraseCookie("testing"));return a}(function(a){var d=readCookie("devicePixelRatio"),b=void 0===a.devicePixelRatio?1:a.devicePixelRatio;areCookiesEnabled()&&null==d&&(a.navigator.standalone?(d=new XMLHttpRequest,d.open("GET","<?php echo get_template_directory_uri();?>/set-cookie.php?devicePixelRatio="+b,!1),d.send()):createCookie("devicePixelRatio",b,7),a.location.reload(!0))})(window);


	*/
	if ( ! isset( $_COOKIE['devicePixelRatio'] ) ) :
		?>
		<script type="text/javascript">
			function createCookie(a, d, b) {
				if (b) {
					var c = new Date;
					c.setTime(c.getTime() + 864E5 * b);
					b = "; expires=" + c.toGMTString()
				} else b = "";
				document.cookie = a + "=" + d + b + "; path=/"
			}

			function readCookie(a) {
				a += "=";
				for (var d = document.cookie.split(";"), b = 0; b < d.length; b++) {
					for (var c = d[b]; " " == c.charAt(0);) c = c.substring(1, c.length);
					if (0 == c.indexOf(a)) return c.substring(a.length, c.length)
				}
				return null
			}

			function eraseCookie(a) {
				createCookie(a, "", -1)
			}

			function areCookiesEnabled() {
				var a = !1;
				createCookie("testing", "Hello", 1);
				null != readCookie("testing") && (a = !0, eraseCookie("testing"));
				return a
			}

			(function (a) {
				var d = readCookie("devicePixelRatio"), b = void 0 === a.devicePixelRatio ? 1 : a.devicePixelRatio;
				areCookiesEnabled() && null == d && (createCookie("devicePixelRatio", b, 7), 1 != b && a.location.reload(!0))
			})(window);
		</script>
		<?php
	endif;
}

/**
 * Remove wp_site_icon hook if favicons set in theme options.
 *
 * @deprecated
 * @since 2.3.1
 */
function presscore_remove_wp_site_icon() {
	if ( presscore_get_device_icons() ) {
		remove_action( 'wp_head', 'wp_site_icon', 99 );
	}
}

/**
 * Remove wp_site_icon hook if favicons set in theme options.
 *
 * @deprecated
 * @since 2.3.1
 */
function presscore_admin_remove_wp_site_icon() {
	if ( presscore_get_device_icons() ) {
		remove_action( 'admin_head', 'wp_site_icon' );
	}
}

/**
 * Display site icon.
 *
 * @deprecated
 * @since 2.2.1
 */
function presscore_site_icon() {
	the7_site_icon();
}

if ( ! function_exists( 'presscore_less_get_conditional_colors' ) ) :

	/**
	 * Function returns $color|$gradient|$accent based on $test value.
	 *
	 * @deprecated 6.6.0
	 * @since      3.0.0
	 *
	 * @param  array        $test
	 * @param  array        $color
	 * @param  array        $gradient
	 * @param  array|string $accent
	 *
	 * @return array|string
	 */
	function presscore_less_get_conditional_colors( $test, $color, $gradient, $accent, $opacity = null ) {
		switch ( call_user_func_array( 'of_get_option', (array) $test ) ) {
			case 'outline':
			case 'background':
			case 'color':
				$_color = array(
					call_user_func_array( 'of_get_option', (array) $color ),
					'""',
				);
				break;
			case 'gradient':
				$_color = call_user_func_array( 'of_get_option', (array) $gradient );
				if ( is_string( $_color ) ) {
					$_color = the7_less_prepare_gradient_var( $_color );
				}
				break;
			case 'accent':
			default:
				$_color = $accent;
		}

		return $_color;
	}

endif;

/**
 * @deprecated 6.6.0
 *
 * @param The7_Less_Vars_Manager_Interface $less_vars
 *
 * @return array
 */
function presscore_less_get_accent_colors( The7_Less_Vars_Manager_Interface $less_vars ) {
	return the7_less_get_accent_colors( $less_vars );
}

if ( ! function_exists( 'presscore_top_bar_text2_element' ) ) :

	/**
	 * Render header text2 mini widget.
	 *
	 * @deprecated 6.6.1
	 * @since      3.0.0
	 */
	function presscore_top_bar_text2_element() {
		presscore_top_bar_text_element( 'header-elements-text-2' );
	}

endif;

if ( ! function_exists( 'presscore_top_bar_text3_element' ) ) :

	/**
	 * Render header text3 mini widget.
	 *
	 * @deprecated 6.6.1
	 * @since      3.0.0
	 */
	function presscore_top_bar_text3_element() {
		presscore_top_bar_text_element( 'header-elements-text-3' );
	}

endif;

if ( ! function_exists( 'presscore_options_get_font_sizes' ) ) :

	/**
	 * @deprecated 6.6.1
	 * @return array
	 */
	function presscore_options_get_font_sizes() {
		return array(
			'big'    => _x( 'large', 'theme-options', 'the7mk2' ),
			'normal' => _x( 'medium', 'theme-options', 'the7mk2' ),
			'small'  => _x( 'small', 'theme-options', 'the7mk2' ),
		);
	}

endif;

if ( ! function_exists( 'presscore_options_get_show_hide' ) ) :

	/**
	 * @deprecated 6.6.1
	 * @return array
	 */
	function presscore_options_get_show_hide() {
		return array(
			'show' => _x( 'Show', 'theme-options', 'the7mk2' ),
			'hide' => _x( 'Hide', 'theme-options', 'the7mk2' ),
		);
	}

endif;

if ( ! function_exists( 'presscore_options_get_en_dis' ) ) :

	/**
	 * @deprecated 6.6.1
	 * @return array
	 */
	function presscore_options_get_en_dis() {
		return array(
			'1' => _x( 'Enabled', 'theme-options', 'the7mk2' ),
			'0' => _x( 'Disabled', 'theme-options', 'the7mk2' ),
		);
	}

endif;

if ( ! function_exists( 'presscore_options_tpl_logo' ) ) :

	/**
	 * @deprecated 6.6.1
	 */
	function presscore_options_tpl_logo( &$options, $prefix = '', $fields = array() ) {
		$_fields = array();

		$_fields['logo_regular'] = array(
			'name' => _x( 'Logo', 'theme-options', 'the7mk2' ),
			'type' => 'upload',
			'mode' => 'full',
			'std'  => array( '', 0 ),
		);

		$_fields['logo_hd'] = array(
			'name' => _x( 'High-DPI (retina) logo', 'theme-options', 'the7mk2' ),
			'type' => 'upload',
			'mode' => 'full',
			'std'  => array( '', 0 ),
		);

		$_fields = array_merge_recursive( $_fields, $fields );

		$prefix = ( $prefix ? $prefix . '-' : '' );
		foreach ( $_fields as $field_id => $field ) {
			$field_id = ( isset( $field['id'] ) ? $field['id'] : $field_id );
			if ( ! is_numeric( $field_id ) ) {
				$field_id = $prefix . $field_id;

				$field['id'] = $field_id;

				$options[ $field_id ] = $field;
			} else {
				$options[] = $field;
			}
		}
	}

endif;

if ( ! function_exists( 'presscore_get_team_links_array' ) ) :

	/**
	 * Return links list for team post meta box.
	 *
	 * @deprecated 6.6.1 Moved to dt-the7-core.
	 * @return array.
	 */
	function presscore_get_team_links_array() {
		$team_links = array(
			'website' => array( 'desc' => _x( 'Personal blog / website', 'team link', 'the7mk2' ) ),
			'mail'    => array( 'desc' => _x( 'E-mail', 'team link', 'the7mk2' ) ),
		);

		$common_links = presscore_get_social_icons_data();
		if ( $common_links ) {

			foreach ( $common_links as $key => $value ) {

				if ( isset( $team_links[ $key ] ) ) {
					continue;
				}

				$team_links[ $key ] = array( 'desc' => $value );
			}
		}

		return $team_links;
	}

endif;

if ( ! function_exists( 'presscore_get_blank_image' ) ) :

	/**
	 * Get blank image.
	 *
	 * @deprecated 6.10.0
	 */
	function presscore_get_blank_image() {
		return PRESSCORE_THEME_URI . '/images/1px.gif';
	}

endif;

/**
 * Return current paged/page query var or 1 if it's empty.
 *
 * @since      1.0.0
 * @deprecated 7.1.1 Use the7_get_paged_var()
 * @see        the7_get_paged_var()
 *
 * @return int
 */
function dt_get_paged_var() {
	return the7_get_paged_var();
}

/**
 * It's just a stub to deprecated function that is used in dt-the7-core.
 *
 * @deprecated 7.5.0 Do not use.
 *
 * @return bool
 */
function presscore_post_format_supports_media_content() {
	return true;
}

if ( ! function_exists( 'presscore_display_share_buttons_for_image' ) ) :

	/**
	 * @deprecated 7.8.0
	 *
	 * @see the7_display_image_share_buttons
	 *
	 * @return string
	 *
	 */
	function presscore_display_share_buttons_for_image( $place = '', $options = array() ) {
		_doing_it_wrong(
			__FUNCTION__,
			sprintf( __( 'Function is deprecated, use %s instead.' ), 'the7_display_image_share_buttons' ),
			'7.8.0'
		);

		$default_options = array(
			'class' => array( 'album-share-overlay' ),
		);
		$options         = wp_parse_args( $options, $default_options );

		return presscore_display_share_buttons( $place, $options );
	}

endif;

if ( ! function_exists( 'presscore_get_share_buttons_list' ) ) :

	/**
	 * @deprecated 7.8.0
	 *
	 * @see the7_get_share_buttons_list
	 *
	 * @return string
	 */
	function presscore_get_share_buttons_list( $place, $post_id = null ) {
		global $post;

		_doing_it_wrong(
			__FUNCTION__,
			sprintf( __( 'Function is deprecated, use %s instead.' ), 'the7_get_share_buttons_list' ),
			'7.8.0'
		);

		$buttons = of_get_option( 'social_buttons-' . $place, array() );

		if ( empty( $buttons ) ) {
			return array();
		}

		// get title
		if ( ! $post_id ) {
			$_post = $post;
			$post_id = $_post->ID;
		} else {
			$_post = get_post( $post_id );
		}

		$t = isset( $_post->post_title ) ? $_post->post_title : '';

		// get permalink
		$u = get_permalink( $post_id );

		$buttons_list = presscore_themeoptions_get_social_buttons_list();
		$protocol = is_ssl() ? "https" : "http";
		$share_buttons = array();

		foreach ( $buttons as $button ) {
			$esc_url = true;
			$url = $custom = $icon_class = '';
			$desc = $buttons_list[ $button ];

			switch ( $button ) {
				case 'twitter':
					$icon_class = 'twitter';
					$url = add_query_arg( array( 'url' => rawurlencode( $u ), 'text' => urlencode( $t ) ), 'https://twitter.com/share' );
					break;
				case 'facebook':
					$icon_class = 'facebook';
					$url = add_query_arg( array( 'u' => rawurlencode( $u ), 't' => urlencode( $t ) ), 'http://www.facebook.com/sharer.php' );
					break;
				case 'pinterest':
					$icon_class = 'pinterest pinit-marklet';
					$url = '//pinterest.com/pin/create/button/';
					$custom = ' data-pin-config="above" data-pin-do="buttonBookmark"';
					// if image
					if ( wp_attachment_is_image( $post_id ) ) {
						$image = wp_get_attachment_image_src( $post_id, 'full' );
						if ( ! empty( $image ) ) {
							$url = add_query_arg( array(
													  'url'         => rawurlencode( $u ),
													  'media'       => rawurlencode( $image[0] ),
													  'description' => rawurlencode( apply_filters( 'get_the_excerpt', $_post->post_content ) )
												  ), $url );
							$custom = ' data-pin-config="above" data-pin-do="buttonPin"';
							$icon_class = 'pinterest';
						}
					}
					break;
				case 'linkedin':
					$bt = get_bloginfo( 'name' );
					$url = $protocol . '://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode( $u ) . '&title=' . rawurlencode( $t ) . '&summary=&source=' . rawurlencode( $bt );
					$icon_class = 'linkedin';
					break;
				case 'whatsapp':
					$esc_url = false;
					$url = 'https://api.whatsapp.com/send?text=' . rawurlencode( "{$t} - {$u}" );
					$custom = ' data-action="share/whatsapp/share"';
					$icon_class = 'whatsapp';
					break;
			}

			if ( $esc_url ) {
				$url = esc_url( $url );
			}

			$share_button = '<a class="' . $icon_class . '" href="' . $url . '" title="' . esc_attr( $desc ) . '" target="_blank"' . $custom . '><span class="soc-font-icon"></span><span class="screen-reader-text">' . sprintf( __( 'Share with %s', 'the7mk2' ), $desc ) . '</span></a>';

			$share_buttons[] = apply_filters( 'presscore_share_button', $share_button, $button, $icon_class, $url, $desc, $t, $u );
		}

		return apply_filters( 'presscore_get_share_buttons_list', $share_buttons, $place, $post_id );
	}

endif;

if ( ! function_exists( 'presscore_display_share_buttons' ) ) :

	/**
	 * Display share buttons.
	 *
	 * @deprecated 7.8.0
	 *
	 * @param string $place   Place.
	 * @param array  $options Options.
	 *
	 * @return string
	 */
	function presscore_display_share_buttons( $place = '', $options = array() ) {
		_doing_it_wrong(
			__FUNCTION__,
			__( 'Function is deprecated, do not use.' ),
			'7.8.0'
		);

		$default_options = array(
			'echo'			=> true,
			'class'			=> array( 'project-share-overlay' ),
			'id'			=> null,
			'title'			=> of_get_option( "social_buttons-{$place}-button_title", '' )
		);
		$options = wp_parse_args($options, $default_options);

		$share_buttons = presscore_get_share_buttons_list( $place, $options['id'] );

		if ( apply_filters( 'presscore_hide_share_buttons', empty( $share_buttons ) ) ) {
			return '';
		}

		$class = $options['class'];
		if ( ! is_array($class) ) {
			$class = explode( ' ', $class );
		}

		$title = esc_html( $options['title'] );

		$html =	'<div class="' . esc_attr( implode( ' ', $class ) ) . '">'
				   . presscore_get_button_html( array(
													'title' => $title ? $title : __( 'Share this', 'the7mk2' ),
													'href' => '#',
													'class' => 'share-button entry-share h5-size' . ( $title ? '' : ' no-text' )
												) )
				   . '<div class="soc-ico">'
				   . implode( '', $share_buttons )
				   . '</div>'
				   . '</div>';

		$html = apply_filters( 'presscore_display_share_buttons', $html );

		if ( $options['echo'] ) {
			echo $html;
		}
		return $html;
	}

endif;

if ( ! function_exists( 'presscore_display_new_share_buttons' ) ) :

	/**
	 * Display share buttons.
	 *
	 * @deprecated 7.8.0
	 *
	 * @param string $place   Place.
	 * @param array  $options Options.
	 *
	 * @return string
	 */
	function presscore_display_new_share_buttons( $place = '', $options = array() ) {
		_doing_it_wrong(
			__FUNCTION__,
			__( 'Function is deprecated, do not use.' ),
			'7.8.0'
		);

		$default_options = array(
			'echo'			=> true,
			'class'			=> array( 'single-share-box' ),
			'id'			=> null,
			'title'			=> of_get_option( "social_buttons-{$place}-button_title", '' )
		);
		$options = wp_parse_args($options, $default_options);

		$share_buttons = presscore_get_share_buttons_list( $place, $options['id'] );

		if ( apply_filters( 'presscore_hide_share_buttons', empty( $share_buttons ) ) ) {
			return '';
		}

		$class = $options['class'];
		if ( ! is_array( $class ) ) {
			$class = explode( ' ', $class );
		}

		$html =	'<div class="' . esc_attr( implode( ' ', $class ) ) . '">'
				   . '<div class="share-link-description">' . esc_html( $options['title'] ) . '</div>'
				   . '<div class="share-buttons">'
				   . implode( '', $share_buttons )
				   . '</div>'
				   . '</div>';

		$html = apply_filters( 'presscore_display_share_buttons', $html );

		if ( $options['echo'] ) {
			echo $html;
		}
		return $html;
	}

endif;

if ( ! function_exists( 'presscore_display_share_buttons_for_post' ) ) :

	/**
	 * @deprecated 7.8.0
	 *
	 * @param string $place   Place.
	 * @param array  $options Options.
	 */
	function presscore_display_share_buttons_for_post( $place = '', $options = array() ) {
		_doing_it_wrong(
			__FUNCTION__,
			sprintf( __( 'Function is deprecated, use %s instead.' ), 'the7_display_post_share_buttons' ),
			'7.8.0'
		);

		$post_id = null;
		if ( isset( $options['id'] ) ) {
			$post_id = $options['id'];
		}

		$wrap_class = 'single-share-box';
		if ( isset( $options['class'] ) ) {
			$wrap_class = is_array( $options['class'] ) ? implode( ' ', $options['class'] ) : $options['class'];
		}

		the7_display_post_share_buttons( $place, $post_id, $wrap_class );
	}

endif;

/**
 * @deprecated 7.8.0
 *
 * @return array
 */
function presscore_set_image_width_options() {

	$config = presscore_get_config();
	$target_image_width = $config->get('post.preview.width.min');

	if ( 'wide' == $config->get( 'post.preview.width' ) && !$config->get('all_the_same_width') ) {
		$target_image_width *= 3;
		$image_options = array( 'w' => absint( round( $target_image_width ) ), 'z' => 0, 'hd_convert' => false );

	} else {
		$target_image_width *= 1.5;
		$image_options = array( 'w' => absint( round( $target_image_width ) ), 'z' => 0 );

	}

	return $image_options;
}

/**
 * Display image share buttons. Used in sliders and image gallery with list layout.
 *
 * @since 7.8.0
 * @deprecated 7.8.1
 *
 * @param null   $image_id   ID of the image to share. If null, then current post will be used instead.
 * @param string $wrap_class Buttons wrap class.
 */
function the7_display_image_share_buttons( $image_id = null, $wrap_class = 'album-share-overlay' ) {
	$place         = 'photo';
	$share_buttons = the7_get_share_buttons_list( $place, $image_id );
	if ( apply_filters( 'presscore_hide_share_buttons', empty( $share_buttons ) ) ) {
		return;
	}

	presscore_get_template_part(
		'theme',
		'share-buttons/image-share-buttons',
		null,
		array(
			'wrap_class'           => $wrap_class,
			'share_buttons_header' => the7_get_share_buttons_header( $place ),
			'share_buttons'        => $share_buttons,
		)
	);
}

if ( ! function_exists( 'presscore_get_royal_slider' ) ) :

	/**
	 * Royal media slider.
	 *
	 * @deprecated 7.8.1
	 *
	 * @param array $media_items Attachments id's array.
	 * @return string HTML.
	 */
	function presscore_get_royal_slider( $attachments_data, $options = array() ) {

		if ( empty( $attachments_data ) ) {
			return '';
		}

		presscore_remove_lazy_load_attrs();

		$default_options = array(
			'echo'      => false,
			'width'     => null,
			'height'    => null,
			'class'     => array(),
			'style'     => '',
			'show_info' => array( 'title', 'link', 'description' )
		);
		$options = wp_parse_args( $options, $default_options );

		// common classes
		$options['class'][] = 'royalSlider';
		$options['class'][] = 'rsShor';

		$container_class = implode(' ', $options['class']);

		$data_attributes = '';
		if ( !empty($options['width']) ) {
			$data_attributes .= ' data-width="' . absint($options['width']) . '"';
		}

		if ( !empty($options['height']) ) {
			$data_attributes .= ' data-height="' . absint($options['height']) . '"';
		}

		if ( isset( $options['autoplay'] ) ) {
			$data_attributes .= ' data-autoslide="' . ( $options['interval'] ? $options['interval'] : $default_options['interval'] ) . '"';
		}

		if ( isset( $options['interval'] ) ) {
			$options['interval'] = absint( $options['interval'] );
			$data_attributes .= ' data-paused="' . ( $options['autoplay'] ? 'false' : 'true' ) . '"';
		}

		$html = "\n" . '<ul class="' . esc_attr($container_class) . '"' . $data_attributes . $options['style'] . '>';

		foreach ( $attachments_data as $data ) {

			if ( empty($data['full']) ) continue;

			$is_video = !empty( $data['video_url'] );

			$html .= "\n\t" . '<li' . ( ($is_video) ? ' class="rollover-video"' : '' ) . '>';

			$image_args = array(
				'img_meta' 	=> array( $data['full'], $data['width'], $data['height'] ),
				'img_id'	=> $data['ID'],
				'alt'		=> $data['alt'],
				'title'		=> $data['title'],
				'caption'	=> $data['caption'],
				'img_class' => 'rsImg',
				'custom'	=> '',
				'class'		=> '',
				'echo'		=> false,
				'wrap'		=> '<img %IMG_CLASS% %SRC% %SIZE% %ALT% %CUSTOM% />',
			);

			if ( $is_video ) {
				$video_url = remove_query_arg( array('iframe', 'width', 'height'), $data['video_url'] );
				$image_args['custom'] = 'data-rsVideo="' . esc_url($video_url) . '"';
			}

			$image = dt_get_thumb_img( $image_args );

			$html .= "\n\t\t" . $image;

			if ( !empty($data['link']) && in_array('link', $options['show_info']) ) {
				$html .= "\n\t\t" . '<a href="' . $data['link'] . '" class="rsCLink" target="_blank"></a>';
			}

			$caption_html = '';
			$links = '';

			if ( in_array('share_buttons', $options['show_info']) ) {
				ob_start();
				the7_display_image_share_buttons( $data['ID'] );
				$links .= "\n\t\t\t\t" . ob_get_clean();
			}

			if ( $links ) {
				$caption_html .= '<div class="album-content-btn">' . $links . '</div>';
			}

			if ( !empty($data['title']) && in_array('title', $options['show_info']) ) {
				$caption_html .= "\n\t\t\t\t" . '<h4>' . esc_html($data['title']) . '</h4>';
			}

			if ( !empty($data['description']) && in_array('description', $options['show_info']) ) {
				$caption_html .= "\n\t\t\t\t" . wpautop($data['description']);
			}

			if ( $caption_html ) {
				$html .= "\n\t\t" . '<div class="slider-post-caption">' . "\n\t\t\t" . '<div class="slider-post-inner">' . $caption_html . "\n\t\t\t" . '</div>' . "\n\t\t" . '</div>';
			}

			$html .= '</li>';

		}

		$html .= '</ul>';

		if ( $options['echo'] ) {
			echo $html;
		}

		presscore_add_lazy_load_attrs();

		return $html;
	}

endif;
