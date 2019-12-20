<?php
/**
 * Settings.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'presscore_meta_boxes_get_images_proportions' ) ) :

	/**
	 * Image proportions array.
	 *
	 * @return array.
	 */
	function presscore_meta_boxes_get_images_proportions( $prop = false ) {

		$ratios = array(
			'1'		=> array( 'ratio' => 0.33, 'desc' => '1:3' ),
			'2'		=> array( 'ratio' => 0.3636, 'desc' => '4:11' ),
			'3'		=> array( 'ratio' => 0.45, 'desc' => '9:20' ),
			'4'		=> array( 'ratio' => 0.5625, 'desc' => '9:16' ),
			'5'		=> array( 'ratio' => 0.6, 'desc' => '3:5' ),
			'6'		=> array( 'ratio' => 0.6666, 'desc' => '2:3' ),
			'7'		=> array( 'ratio' => 0.75, 'desc' => '3:4' ),
			'8'		=> array( 'ratio' => 1, 'desc' => '1:1' ),
			'9'		=> array( 'ratio' => 1.33, 'desc' => '4:3' ),
			'10'	=> array( 'ratio' => 1.5, 'desc' => '3:2' ),
			'11'	=> array( 'ratio' => 1.66, 'desc' => '5:3' ),
			'12'	=> array( 'ratio' => 1.77, 'desc' => '16:9' ),
			'13'	=> array( 'ratio' => 2.22, 'desc' => '20:9' ),
			'14'	=> array( 'ratio' => 2.75, 'desc' => '11:4' ),
			'15'	=> array( 'ratio' => 3, 'desc' => '3:1' ),
		);

		if ( false === $prop ) return $ratios;

		if ( isset($ratios[ $prop ]) ) return $ratios[ $prop ]['ratio'];

		return false;
	}

endif; // presscore_meta_boxes_get_images_proportions

if ( ! function_exists( 'presscore_get_social_icons_data' ) ) :

	/**
	 * Return social icons array( 'class', 'title' ).
	 *
	 */
	function presscore_get_social_icons_data() {
		$icons = array(
			'facebook'		=> __('Facebook', 'the7mk2'),
			'twitter'		=> __('Twitter', 'the7mk2'),
			'dribbble'		=> __('Dribbble', 'the7mk2'),
			'you-tube'		=> __('YouTube', 'the7mk2'),
			'rss'			=> __('Rss', 'the7mk2'),
			'delicious'		=> __('Delicious', 'the7mk2'),
			'flickr'		=> __('Flickr', 'the7mk2'),
			'lastfm'		=> __('Lastfm', 'the7mk2'),
			'linkedin'		=> __('Linkedin', 'the7mk2'),
			'vimeo'			=> __('Vimeo', 'the7mk2'),
			'tumbler'		=> __('Tumblr', 'the7mk2'),
			'pinterest'		=> __('Pinterest', 'the7mk2'),
			'devian'		=> __('Deviantart', 'the7mk2'),
			'skype'			=> __('Skype', 'the7mk2'),
			'github'		=> __('Github', 'the7mk2'),
			'instagram'		=> __('Instagram', 'the7mk2'),
			'stumbleupon'	=> __('Stumbleupon', 'the7mk2'),
			'behance'		=> __('Behance', 'the7mk2'),
			'mail'			=> __('Mail', 'the7mk2'),
			'website'		=> __('Website', 'the7mk2'),
			'px-500'		=> __('500px', 'the7mk2'),
			'tripedvisor'	=> __('TripAdvisor', 'the7mk2'),
			'vk'			=> __('VK', 'the7mk2'),
			'foursquare'	=> __('Foursquare', 'the7mk2'),
			'xing'			=> __('XING', 'the7mk2'),
			'weibo'			=> __('Weibo', 'the7mk2'),
			'odnoklassniki'	=> __('Odnoklassniki', 'the7mk2'),
			'research-gate'	=> __('ResearchGate', 'the7mk2'),
			'yelp'			=> __('Yelp', 'the7mk2'),
			'blogger'		=> __('Blogger', 'the7mk2'),
			'soundcloud'	=> __('SoundCloud', 'the7mk2'),
			'viber'	=> __('Viber', 'the7mk2'),
			'whatsapp'	=> __('Whatsapp', 'the7mk2'),
			'reddit'	=> __('Reddit', 'the7mk2'),
			'snapchat'	=> __('Snapchat', 'the7mk2'),
			'telegram'	=> __('Telegram', 'the7mk2'),
		);

		return apply_filters( 'presscore_get_social_icons_data', $icons );
	}

endif; // presscore_get_social_icons_data

if ( ! function_exists( 'presscore_themeoptions_get_social_buttons_list' ) ) :

	/**
	 * Social buttons.
	 */
	function presscore_themeoptions_get_social_buttons_list() {
		return array(
			'facebook' 	=> __('Facebook', 'the7mk2'),
			'twitter' 	=> __('Twitter', 'the7mk2'),
			'pinterest' => __('Pinterest', 'the7mk2'),
			'linkedin' 	=> __('LinkedIn', 'the7mk2'),
			'whatsapp' 	=> __('WhatsApp', 'the7mk2'),
		);
	}

endif; // presscore_themeoptions_get_social_buttons_list

if ( ! function_exists( 'presscore_themeoptions_get_template_list' ) ) :

	/**
	 * Templates list.
	 */
	function presscore_themeoptions_get_template_list(){
		return array(
			'post' 				=> _x('Social buttons in blog posts', 'theme-options', 'the7mk2'),
			'portfolio_post' 	=> _x('Social buttons in portfolio projects', 'theme-options', 'the7mk2'),
			'photo' 			=> _x('Social buttons in media (photos and videos)', 'theme-options', 'the7mk2'),
			'page' 				=> _x('Social buttons on pages and page templates', 'theme-options', 'the7mk2'),
		);
	}

endif; // presscore_themeoptions_get_template_list

if ( ! function_exists( 'presscore_themeoptions_get_stripes_list' ) ) :

	/**
	 * Stripes list.
	 */
	function presscore_themeoptions_get_stripes_list() {
		return array(
			1 => array(
				'title'				=> _x('Stripe 1', 'theme-options', 'the7mk2'),

				'bg_color'			=> '#222526',
				'bg_opacity'		=> 100,
				'bg_color_ie'		=> '#222526',
				'bg_img'			=> array(
					'image'			=> '',
					'repeat'		=> 'repeat',
					'position_x'	=> 'center',
					'position_y'	=> 'center'
				),
				'bg_fullscreen'		=> false,

				'text_color'		=> '#828282',
				'text_header_color'	=> '#ffffff',

				'div_color'		=> '#828282',
				'div_opacity'		=> 100,
				'div_color_ie'		=> '#828282',

				'addit_color'		=> '#dcdcdb',
				'addit_opacity'		=> 100,
				'addit_color_ie'	=> '#dcdcdb',
			),
			2 => array(
				'title'				=> _x('Stripe 2', 'theme-options', 'the7mk2'),

				'bg_color'			=> '#aeaeae',
				'bg_opacity'		=> 100,
				'bg_color_ie'		=> '#aeaeae',
				'bg_img'			=> array(
					'image'			=> '',
					'repeat'		=> 'repeat',
					'position_x'	=> 'center',
					'position_y'	=> 'center'
				),
				'bg_fullscreen'		=> false,

				'text_color'		=> '#828282',
				'text_header_color'	=> '#ffffff',

				'div_color'		=> '#dcdcdb',
				'div_opacity'		=> 100,
				'div_color_ie'		=> '#dcdcdb',

				'addit_color'		=> '#dcdcdb',
				'addit_opacity'		=> 100,
				'addit_color_ie'	=> '#dcdcdb',
			),
			3 => array(
				'title'				=> _x('Stripe 3', 'theme-options', 'the7mk2'),

				'bg_color'			=> '#cacaca',
				'bg_opacity'		=> 100,
				'bg_color_ie'		=> '#cacaca',
				'bg_img'			=> array(
					'image'			=> '',
					'repeat'		=> 'repeat',
					'position_x'	=> 'center',
					'position_y'	=> 'center'
				),
				'bg_fullscreen'		=> false,

				'text_color'		=> '#828282',
				'text_header_color'	=> '#ffffff',

				'div_color'		=> '#dcdcdb',
				'div_opacity'		=> 100,
				'div_color_ie'		=> '#dcdcdb',

				'addit_color'		=> '#dcdcdb',
				'addit_opacity'		=> 100,
				'addit_color_ie'	=> '#dcdcdb',
			),
		);
	}

endif; // presscore_themeoptions_get_stripes_list

if ( ! function_exists( 'presscore_options_get_safe_fonts' ) ) :

	/**
	 * Web safe fonts.
	 *
	 * @return array
	 */
	function presscore_options_get_safe_fonts() {
		return apply_filters( 'presscore_options_get_safe_fonts', array(
			'Andale Mono'                   => 'Andale Mono',
			'Arial'                         => 'Arial',
			'Arial:600'                     => 'Arial Bold',
			'Arial:400italic'               => 'Arial Italic',
			'Arial:600italic'               => 'Arial Bold Italic',
			'Arial Black'                   => 'Arial Black',
			'Comic Sans MS'                 => 'Comic Sans MS',
			'Comic Sans MS:600'             => 'Comic Sans MS Bold',
			'Courier New'                   => 'Courier New',
			'Courier New:600'               => 'Courier New Bold',
			'Courier New:400italic'         => 'Courier New Italic',
			'Courier New:600italic'         => 'Courier New Bold Italic',
			'Georgia'                       => 'Georgia',
			'Georgia:600'                   => 'Georgia Bold',
			'Georgia:400italic'             => 'Georgia Italic',
			'Georgia:600italic'             => 'Georgia Bold Italic',
			'Impact Lucida Console'         => 'Impact Lucida Console',
			'Lucida Sans Unicode'           => 'Lucida Sans Unicode',
			'Marlett'                       => 'Marlett',
			'Minion Web'                    => 'Minion Web',
			'Symbol'                        => 'Symbol',
			'Times New Roman'               => 'Times New Roman',
			'Times New Roman:600'           => 'Times New Roman Bold',
			'Times New Roman:400italic'     => 'Times New Roman Italic',
			'Times New Roman:600italic'     => 'Times New Roman Bold Italic',
			'Tahoma'                        => 'Tahoma',
			'Tahoma:600'                    => 'Tahoma Bold',
			'Trebuchet MS'                  => 'Trebuchet MS',
			'Trebuchet MS:600'              => 'Trebuchet MS Bold',
			'Trebuchet MS:400italic'        => 'Trebuchet MS Italic',
			'Trebuchet MS:600italic'        => 'Trebuchet MS Bold Italic',
			'Verdana'                       => 'Verdana',
			'Verdana:600'                   => 'Verdana Bold',
			'Verdana:400italic'             => 'Verdana Italic',
			'Verdana:600italic'             => 'Verdana Bold Italic',
			'Webdings'                      => 'Webdings',
		) );
	}

endif;

if ( ! function_exists( 'presscore_options_get_web_fonts' ) ) :

	/**
	 * Web fonts.
	 *
	 * @return array
	 */
	function presscore_options_get_web_fonts() {
		$web_fonts_list = wp_cache_get( 'web_fonts', 'presscore' );
		if ( false === $web_fonts_list ) {
			$web_fonts_list = include trailingslashit( PRESSCORE_EXTENSIONS_DIR ) . 'web-fonts.php';
			wp_cache_add( 'web_fonts', $web_fonts_list, 'presscore', 60 );
		}

		return apply_filters( 'presscore_options_get_web_fonts', $web_fonts_list );
	}

endif;

if ( ! function_exists( 'presscore_options_get_all_fonts' ) ) :

	/**
	 * Returns merged safe and web fonts.
	 * 
	 * @return array
	 */
	function presscore_options_get_all_fonts() {
		$web_fonts = presscore_options_get_web_fonts();
		$safe_fonts = presscore_options_get_safe_fonts();
		return array_merge( $safe_fonts, $web_fonts );
	}

endif;

if ( ! function_exists( 'presscore_options_get_header_layout_elements' ) ) :

	/**
	 * Retrieve header micro-widgets list.
	 *
	 * @return array
	 */
	function presscore_options_get_header_layout_elements() {
		return apply_filters( 'header_layout_elements', array(
			'social_icons'   => array( 'title' => _x( 'Social icons', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'search'         => array( 'title' => _x( 'Search', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'custom_menu'    => array( 'title' => _x( 'Menu 1', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'menu2'          => array( 'title' => _x( 'Menu 2', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'login'          => array( 'title' => _x( 'Login', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'text_area'      => array( 'title' => _x( 'Text 1', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'text2_area'     => array( 'title' => _x( 'Text 2', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'text3_area'     => array( 'title' => _x( 'Text 3', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'text4_area'     => array( 'title' => _x( 'Text 4', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'text5_area'     => array( 'title' => _x( 'Text 5', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'multipurpose_1' => array( 'title' => _x( 'Multipurpose 1', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'multipurpose_2' => array( 'title' => _x( 'Multipurpose 2', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'multipurpose_3' => array( 'title' => _x( 'Multipurpose 3', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'multipurpose_4' => array( 'title' => _x( 'Multipurpose 4', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'address'        => array( 'title' => _x( 'Multipurpose 5', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'email'          => array( 'title' => _x( 'Multipurpose 6', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'phone'          => array( 'title' => _x( 'Multipurpose 7', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'skype'          => array( 'title' => _x( 'Multipurpose 8', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'working_hours'  => array( 'title' => _x( 'Multipurpose 9', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'button'         => array( 'title' => _x( 'Button 1', 'theme-options', 'the7mk2' ), 'class' => '' ),
			'button-2'       => array( 'title' => _x( 'Button 2', 'theme-options', 'the7mk2' ), 'class' => '' ),
		) );
	}

endif;

if ( ! function_exists( 'presscore_options_micro_widgets_common_icons' ) ) {

	/**
	 * Return array of common micro-widgets icons classes.
	 *
	 * @since 7.3.0
	 *
	 * @param array $icons
	 *
	 * @return array
	 */
	function presscore_options_micro_widgets_common_icons( $icons = array() ) {
		$common_icons = array(
			'icomoon-the7-font-the7-mail-01',
			'icomoon-the7-font-the7-mail-011',
			'icomoon-the7-font-the7-mail-02',
			'icomoon-the7-font-the7-mail-03',
			'icomoon-the7-font-the7-mw-mail-04',
			'icomoon-the7-font-the7-mw-mail-041',
			'icomoon-the7-font-the7-mail-05',
			'icomoon-the7-font-the7-mail-mail-06',
			'icomoon-the7-font-the7-mail-07',
			'icomoon-the7-font-the7-mail-08',
			'icomoon-the7-font-the7-mail-09',
			'icomoon-the7-font-the7-phone-01',
			'icomoon-the7-font-the7-phone-02',
			'icomoon-the7-font-the7-phone-03',
			'icomoon-the7-font-the7-phone-04',
			'icomoon-the7-font-the7-phone-041',
			'icomoon-the7-font-the7-phone-05',
			'icomoon-the7-font-the7-phone-051',
			'icomoon-the7-font-the7-phone-06',
			'icomoon-the7-font-the7-phone-07',
			'icomoon-the7-font-the7-phone-071',
			'icomoon-the7-font-the7-home-00',
			'icomoon-the7-font-the7-home-02',
			'icomoon-the7-font-the7-home-021',
			'icomoon-the7-font-the7-home-022',
			'icomoon-the7-font-the7-home-03',
			'icomoon-the7-font-the7-home-04',
			'icomoon-the7-font-the7-map-02',
			'icomoon-the7-font-the7-map-03',
			'icomoon-the7-font-the7-map-04',
			'icomoon-the7-font-the7-map-05',
			'icomoon-the7-font-the7-map-06',
			'icomoon-the7-font-the7-map-07',
			'icomoon-the7-font-the7-clock-00',
			'icomoon-the7-font-the7-clock-01',
			'icomoon-the7-font-the7-clock-02',
			'icomoon-the7-font-the7-clock-03'
		);

		return (array) apply_filters( 'the7_options_micro_widgets_common_icons', array_merge( $common_icons, $icons ) );
	}

}
