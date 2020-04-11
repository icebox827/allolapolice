<?php
/**
 * Admin functions.
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Display fav icon in admin.
 */
add_action( 'admin_head', 'the7_site_icon', 9 );

/**
 * Bootstrap widget area manager on `widgets.php`.
 */
add_action( 'admin_post_the7_admin_wa_manager_save', array( 'The7_Admin_WA_Manager', 'save' ) );
add_action( 'widgets_admin_page', array( 'The7_Admin_WA_Manager', 'display' ) );
add_action( 'load-widgets.php', array( 'The7_Admin_WA_Manager', 'enqueue_assets' ) );

add_action( 'save_post', 'the7_update_post_css_on_save', 20 );

/**
 * @param $post_id
 */
function the7_update_post_css_on_save( $post_id ) {
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	
	the7_update_post_css( $post_id );
}

/**
 * @param $post_id
 *
 * @throws Exception
 */
function the7_update_post_css( $post_id ) {
	$css = The7_Post_CSS_Generator::generate_css_for_post(
		$post_id,
		the7_get_new_shortcode_less_vars_manager(),
		new The7_Less_Compiler()
	);

	if ( $css ) {
		The7_Post_CSS_Generator::update_css_for_post( $post_id, $css );
	} else {
		The7_Post_CSS_Generator::delete_css_for_post( $post_id );
	}
}

if ( ! function_exists( 'presscore_themeoptions_add_share_buttons' ) ) :

	/**
	 * Share buttons field filter.
	 *
	 * Populate share buttons field on theme options page.
	 *
	 * @since 1.0.0
	 *
	 * @param array $buttons
	 * @return array
	 */
	function presscore_themeoptions_add_share_buttons( $buttons ) {
		$theme_soc_buttons = presscore_themeoptions_get_social_buttons_list();
		if ( $theme_soc_buttons && is_array( $theme_soc_buttons ) ) {
			$buttons = array_merge( $buttons, $theme_soc_buttons );
		}

		return $buttons;
	}

	add_filter( 'optionsframework_interface-social_buttons', 'presscore_themeoptions_add_share_buttons' );

endif;

if ( ! function_exists( 'presscore_less_cache_writable_filter' ) ) :

	function presscore_less_cache_writable_filter() {
		return ( '0' != get_option( 'presscore_less_css_is_writable', 1 ) );
	}

	add_filter( 'presscore_less_cache_writable', 'presscore_less_cache_writable_filter' );

endif;

/**
 * Add video url field for attachments.
 *
 */
function presscore_attachment_fields_to_edit( $fields, $post ) {

	// hopefuly add new field only for images
	if ( strpos( get_post_mime_type( $post->ID ), 'image' ) !== false ) {
		$video_url = get_post_meta( $post->ID, 'dt-video-url', true );
		$img_link = get_post_meta( $post->ID, 'dt-img-link', true );
		$hide_title = get_post_meta( $post->ID, 'dt-img-hide-title', true );

		$fields['dt-video-url'] = array(
				'label' 		=> _x('Video url', 'attachment field', 'the7mk2'),
				'input' 		=> 'text',
				'value'			=> $video_url ? $video_url : '',
				'show_in_edit' 	=> true
		);

		$fields['dt-img-link'] = array(
				'label' 		=> _x('Image link', 'attachment field', 'the7mk2'),
				'input' 		=> 'text',
				'value'			=> $img_link ? $img_link : '',
				'show_in_edit' 	=> true
		);

		$fields['dt-img-hide-title'] = array(
				'label' 		=> _x('Hide title', 'attachment field', 'the7mk2'),
				'input' 		=> 'html',
				'html'       	=> "<input id='attachments-{$post->ID}-dt-img-hide-title' type='checkbox' name='attachments[{$post->ID}][dt-img-hide-title]' value='1' " . checked($hide_title, true, false) . "/>",
				'show_in_edit' 	=> true
		);
	}

	return $fields;
}
add_filter( 'attachment_fields_to_edit', 'presscore_attachment_fields_to_edit', 10, 2 );

/**
 * Save vide url attachment field.
 *
 */
function presscore_save_attachment_fields( $attachment_id ) {

	// video url
	if ( isset( $_REQUEST['attachments'][$attachment_id]['dt-video-url'] ) ) {

		$location = esc_url($_REQUEST['attachments'][$attachment_id]['dt-video-url']);
		update_post_meta( $attachment_id, 'dt-video-url', $location );
	}

	// image link
	if ( isset( $_REQUEST['attachments'][$attachment_id]['dt-img-link'] ) ) {

		$location = esc_url($_REQUEST['attachments'][$attachment_id]['dt-img-link']);
		update_post_meta( $attachment_id, 'dt-img-link', $location );
	}

	// hide title
	$hide_title = (int) isset( $_REQUEST['attachments'][$attachment_id]['dt-img-hide-title'] );
	update_post_meta( $attachment_id, 'dt-img-hide-title', $hide_title );
}
add_action( 'edit_attachment', 'presscore_save_attachment_fields' );

/**	
 * This function return array with thumbnail image meta for items list in admin are.
 * If fitured image not set it gets last image by menu order.
 * If there are no images and $noimage not empty it returns $noimage in other way it returns false
 *
 * @param integer $post_id
 * @param integer $max_w
 * @param integer $max_h
 * @param string $noimage
 */ 

function dt_get_admin_thumbnail ( $post_id, $max_w = 100, $max_h = 100, $noimage = '' ) {
	global $wp_query;
	$thumb = array();

	if ( $wp_query && $wp_query->posts ) {
		update_post_thumbnail_cache();
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
	}

	$thumb = apply_filters( 'presscore_admin_get_post_thumbnail', $thumb, get_post_type( $post_id ), $post_id );

	if ( empty( $thumb ) ) {

		if ( ! $noimage ) {
			return false;
		}

		$thumb = $noimage;
		$w = $max_w;
		$h = $max_h;
	} else {

		$sizes = wp_constrain_dimensions( $thumb[1], $thumb[2], $max_w, $max_h );
		$w = $sizes[0];
		$h = $sizes[1];
		$thumb = $thumb[0];
	}

	return array( esc_url( $thumb ), $w, $h );
}

/**
 * Description here.
 *
 * @param integer $post_id
 */
function dt_admin_thumbnail ( $post_id ) {
	global $post_type_object;

	$post_type       = $post_type_object->name;
	$default_img_map = array(
		'default'         => '/assets/images/post-no-img.gif',
		'dt_testimonials' => '/assets/images/testimonials-no-img.gif',
		'dt_team'         => '/assets/images/team-no-img.gif',
	);

	if ( array_key_exists( $post_type, $default_img_map ) ) {
		$default_image = $default_img_map[ $post_type ];
	} else {
		$default_image = $default_img_map['default'];
	}

	$thumbnail = dt_get_admin_thumbnail( $post_id, 60, 60, PRESSCORE_ADMIN_URI . $default_image );

	if ( $thumbnail ) {

		echo '<a style="display: inline-block;" href="post.php?post=' . absint( $post_id ) . '&action=edit" title="' . esc_attr_x( 'Post featured image', 'admin', 'the7mk2' ) . '">
					<img src="' . esc_url( $thumbnail[0] ) . '" width="' . esc_attr( $thumbnail[1] ) . '" height="' . esc_attr( $thumbnail[2] ) . '" alt="' . esc_attr( esc_attr_x( 'Post featured image', 'admin', 'the7mk2' ) ) . '" />
				</a>';
	}
}

/**
 * Add styles to media.
 *
 */
function presscore_admin_print_scripts_for_media() {
?>
<style type="text/css">
.fixed .column-presscore-media-title {
	width: 10%;
}
.fixed .column-presscore-media-title span {
	padding: 2px 5px;
}
.fixed .column-presscore-media-title .dt-media-hidden-title {
	background-color: red;
	color: white;
}
.fixed .column-presscore-media-title .dt-media-visible-title {
	background-color: green;
	color: white;
}
</style>
<?php
}
add_action( 'admin_print_scripts-upload.php', 'presscore_admin_print_scripts_for_media', 99 );

/**
 * Add thumbnails column in posts list.
 *
 */
function presscore_admin_add_thumbnail_column( $defaults ){
	$head = array_slice( $defaults, 0, 2 );
	$tail = array_slice( $defaults, 2 );

	$head['presscore-thumbs'] = _x( 'Thumbnail', 'backend', 'the7mk2' );

	$defaults = array_merge( $head, $tail );

	return $defaults;
}

/**
 * Add sidebar and footer columns in posts list.
 *
 */
function presscore_admin_add_sidebars_columns( $defaults ){
	$defaults['presscore-sidebar'] = _x( 'Sidebar', 'backend', 'the7mk2' );
	$defaults['presscore-footer'] = _x( 'Footer', 'backend', 'the7mk2' );
	return $defaults;
}
add_filter( 'manage_edit-page_columns', 'presscore_admin_add_sidebars_columns' );
add_filter( 'manage_edit-post_columns', 'presscore_admin_add_sidebars_columns' );

/**
 * Add slug column for posts list.
 *
 */
function presscore_admin_add_slug_column( $defaults ){
	$defaults['presscore-slug'] = _x( 'Slug', 'backend', 'the7mk2' );
	return $defaults;
}

/**
 * Add title column for media.
 *
 */
function presscore_admin_add_media_title_column( $columns ) {
	$columns['presscore-media-title'] = _x( 'Image title', 'backend', 'the7mk2' );
	return $columns;
}
add_filter( 'manage_media_columns', 'presscore_admin_add_media_title_column' );

/**
 * Handle custom columns.
 *
 */
function presscore_admin_handle_columns( $column_name, $id ){
	switch ( $column_name ) {
		case 'presscore-thumbs': dt_admin_thumbnail( $id ); break;
		case 'presscore-sidebar':
			echo presscore_admin_get_sidebar_column_message( $id );
			break;

		case 'presscore-footer':
			echo presscore_admin_get_footer_sidebar_column_message( $id );
			break;

		case 'presscore-slug':
			if ( $dt_post = get_post( $id ) ) {
				echo $dt_post->post_name;
			} else {
				echo '&mdash;';
			}
			break;
	}
}
add_action( 'manage_posts_custom_column', 'presscore_admin_handle_columns', 10, 2 );
add_action( 'manage_pages_custom_column', 'presscore_admin_handle_columns', 10, 2 );

function presscore_admin_get_sidebar_column_message( $post_id ) {
	global $DT_META_BOXES;

	$registered_sidebars = presscore_get_widgetareas_options();
	$sidebar_id = presscore_validate_sidebar( get_post_meta( $post_id, '_dt_sidebar_widgetarea_id', true ) );
	$sidebar_name = $registered_sidebars[ $sidebar_id ];

	if ( ! isset( $DT_META_BOXES['dt_page_box-sidebar']['fields'] ) ) {
		return $sidebar_name;
	}

	// Find sidebar layout options.
	$meta_fields = $DT_META_BOXES['dt_page_box-sidebar']['fields'];
	$position_meta_field_id = '_dt_sidebar_position';
	$position = get_post_meta( $post_id, $position_meta_field_id, true );
	$position_name = '';

	foreach( $meta_fields as $meta_field ) {
		if ( isset( $meta_field['id'] ) && $position_meta_field_id === $meta_field['id'] && isset( $meta_field['options'][ $position ] ) ) {
			$position_name = $meta_field['options'][ $position ];
			break;
		}
	}

	if ( ! $position_name ) {
		return $sidebar_name;
	} else if ( is_array( $position_name ) ) {
		$position_name = current( $position_name );
	}

	if ( 'disabled' === $position ) {
		return $position_name;
	}

	return esc_html( _x( 'Position:', 'admin', 'the7mk2' ) . ' ' . $position_name ) . '<br/>' . esc_html( $sidebar_name );
}

function presscore_admin_get_footer_sidebar_column_message( $post_id ) {
	$position = get_post_meta( $post_id, '_dt_footer_show', true );

	if ( ! $position ) {
		return _x( 'Disabled', 'admin', 'the7mk2' );
	}

	$registered_sidebars = presscore_get_widgetareas_options();
	$sidebar_id = presscore_validate_footer_sidebar( get_post_meta( $post_id, '_dt_footer_widgetarea_id', true ) );
	$sidebar_name = $registered_sidebars[ $sidebar_id ];

	return $sidebar_name;
}

/**
 * Show title status in media list.
 *
 * @since 3.1
 */
function presscore_display_title_status_for_media( $column_name, $id ) {
	if ( 'presscore-media-title' == $column_name ) {
		$hide_title = get_post_meta( $id, 'dt-img-hide-title', true );

		if ( $hide_title ) {
			echo '<span class="dt-media-hidden-title">' . _x('Hidden', 'media title hidden', 'the7mk2') . '</span>';
		} else {
			echo '<span class="dt-media-visible-title">' . _x('Visible', 'media title visible', 'the7mk2') . '</span>';
		}
	}
}
add_action( 'manage_media_custom_column', 'presscore_display_title_status_for_media', 10, 2 );

if ( ! function_exists( 'the7_register_admin_scripts' ) ) {

	function the7_register_admin_scripts() {
		$template_uri = PRESSCORE_ADMIN_URI;

		$register_styles = array(
			'the7-admin'          => array(
				'src' => "{$template_uri}/assets/css/admin-style",
			),
			'the7-font'           => array(
				'src' => PRESSCORE_THEME_URI . '/fonts/icomoon-the7-font/icomoon-the7-font',
			),
			'the7-meta-box-magic' => array(
				'src' => "{$template_uri}/assets/css/admin-meta-box-magic",
			),
		);

		foreach ( $register_styles as $name => $props ) {
			the7_register_style( $name, $props['src'] );
		}

		$register_scripts = array(
			'the7-meta-box-magic'    => array(
				'src'       => "{$template_uri}/assets/js/admin-meta-box-magic",
				'deps'      => array( 'jquery' ),
				'in_footer' => true,
			),
			'the7-dashboard-plugins' => array(
				'src'       => "{$template_uri}/assets/js/the7-plugins",
				'deps'      => array( 'jquery' ),
				'in_footer' => true,
			),
		);

		foreach ( $register_scripts as $name => $props ) {
			the7_register_script( $name, $props['src'], $props['deps'], THE7_VERSION, $props['in_footer'] );
		}

		wp_localize_script(
			'the7-dashboard-plugins',
			'the7DashboardPlugins',
			array(
				'forceUpgradeAlertText' => __(
					'Please, mind that after an upgrade, plugin speciffic content would be not compatible with older versions of plugin.',
					'the7mk2'
				),
			)
		);
	}

    add_action( 'admin_enqueue_scripts', 'the7_register_admin_scripts', 0 );

}

if ( ! function_exists( 'presscore_admin_scripts' ) ) :

	/**
	 * Add metaboxes scripts and styles.
	 */
	function presscore_admin_scripts() {
		wp_enqueue_style( 'the7-admin' );
		wp_enqueue_style( 'the7-font' );
	}

	add_action( 'admin_enqueue_scripts', 'presscore_admin_scripts' );

endif;

if ( ! function_exists( 'presscore_admin_post_scripts' ) ) :

	/**
	 * Add metaboxes scripts and styles.
	 */
	function presscore_admin_post_scripts( $hook ) {
		if ( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
			return;
		}

		wp_enqueue_style( 'the7-meta-box-magic' );
		wp_enqueue_script( 'the7-meta-box-magic' );

		// Proportions slider data.
		$proportions = presscore_meta_boxes_get_images_proportions();
		$proportions['length'] = count( $proportions );
		wp_localize_script( 'the7-meta-box-magic', 'the7mbImageRatios', $proportions );

		// Localize meta boxes dependencies.
		global $DT_META_BOXES;
		$localized_meta_boxes = array();
		foreach ( $DT_META_BOXES as $meta_box ) {
			$localized_meta_boxes[ $meta_box['id'] ] = isset($meta_box['only_on'], $meta_box['only_on']['template']) ? (array) $meta_box['only_on']['template'] : array();
		}
		wp_localize_script( 'the7-meta-box-magic', 'dtMetaboxes', $localized_meta_boxes );

		$page_template = dt_get_template_name();
		$page_template = $page_template ? $page_template : 'default';
		wp_localize_script( 'the7-meta-box-magic', 'dtPageTemplate', array(
			'templateName' => $page_template,
		) );
	}

	add_action( 'admin_enqueue_scripts', 'presscore_admin_post_scripts' );

endif;

if ( ! function_exists( 'presscore_admin_widgets_scripts' ) ) :

	/**
	 * Add widgets scripts. Enqueued only for widgets.php.
	 */
	function presscore_admin_widgets_scripts( $hook ) {
		if ( 'widgets.php' !== $hook ) {
			return;
		}

		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		the7_register_style( 'the7-widgets', PRESSCORE_ADMIN_URI . '/assets/css/admin-widgets' );
		the7_register_script( 'the7-widgets', PRESSCORE_ADMIN_URI . '/assets/js/admin-widgets', array(
			'jquery',
			'wp-color-picker',
		), false, true );

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'the7-widgets' );
		wp_enqueue_script( 'the7-widgets' );

		wp_localize_script( 'the7-widgets', 'dtWidgtes', array(
			'title'			=> _x( 'Title', 'widget', 'the7mk2' ),
			'content'		=> _x( 'Content', 'widget', 'the7mk2' ),
			'percent'		=> _x( 'Percent', 'widget', 'the7mk2' ),
			'showPercent'	=> _x( 'Show', 'widget', 'the7mk2' ),
		) );
	}

	add_action( 'admin_enqueue_scripts', 'presscore_admin_widgets_scripts', 15 );

endif;

if ( ! function_exists( 'presscore_editor_open_images_in_lightbox' ) ) :

	/**
     * Add lightbox attributes to images inserted through editor.
     *
	 * @param $html
	 * @param $id
	 * @param $caption
	 * @param $title
	 * @param $align
	 * @param $url
	 * @param $size
	 * @param $alt
	 *
	 * @return mixed
	 */
	function presscore_editor_open_images_in_lightbox( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
        $url_extension = pathinfo( $url, PATHINFO_EXTENSION );
        if ( in_array( $url_extension, array( 'jpg', 'jpeg', 'png', 'gif' ) ) ) {
            $atts = sprintf( ' data-dt-img-description="%s"', esc_attr( $caption ) );
	        $image_src = wp_get_attachment_image_src( $id, 'full' );
	        if ( ! empty( $image_src ) ) {
		        list( $img_src, $width, $height ) = $image_src;
		        $atts .= sprintf( ' data-large_image_width="%s"', esc_attr( $width ) );
		        $atts .= sprintf( ' data-large_image_height="%s"', esc_attr( $height ) );
            }
	        $anchor_classes = 'dt-pswp-item';

	        // <a> tag with class.
	        $replacements_count = 0;
	        $html = preg_replace( '/^(<a .*?)class="(\w*?)"(.*?>)(.*?<img.*?\/>.*?)(<\/a>)/', '${1}class="${2} ' . $anchor_classes . '"' . $atts . '${3}${4}${5}', $html, 1, $replacements_count );

	        // <a> tag without class.
            if ( ! $replacements_count ) {
                $html = preg_replace( '/^(<a .*?)(.*?>)(.*?<img.*?\/>.*?)(<\/a>)/', '${1}class="' . $anchor_classes . '"' . $atts . ' ${2}${3}${4}', $html );
            }
        }

        return $html;
    }

	add_filter( 'image_send_to_editor', 'presscore_editor_open_images_in_lightbox', 10, 8 );

endif;

function presscore_is_dev_env() {
	return defined( 'DT_DEV_ENV' ) && DT_DEV_ENV;
}

if ( presscore_is_dev_env() ) {

	function presscore_do_dev_env_actions() {
		delete_option( 'presscore_db_is_fixed' );
	}
	add_action( 'init', 'presscore_do_dev_env_actions' );

}


if ( ! function_exists( 'presscore_of_localized_vars_filter' ) ) :

	/**
	 * Setup blocks dependencies for "Top Bar & Header" options page. Filter optionsframework localized vars.
	 *
	 * @since 3.0.0
	 *
	 * @param  array $vars
	 * @return array
	 */
	function presscore_of_localized_vars_filter( $vars ) {
		if ( 'of-header-menu' != optionsframework_get_cur_page_id() ) {
			return $vars;
		}

		$vars['blockDependencies'] = array(
			//Microwidgets

			'classic-microwidgets-settings' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'classic',
					),
					array(
						'field' => 'header-classic-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'inline-microwidgets' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'inline',
					),
				),
			),
			'inline-microwidgets-settings' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'inline',
					),
					array(
						'field' => 'header-inline-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'split-microwidgets' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'split',
					),
				),
			),
			'split-microwidgets-settings' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'split',
					),
					array(
						'field' => 'header-split-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'side-microwidgets' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'side',
					),
				),
			),
			'side-microwidgets-settings' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'side',
					),
					array(
						'field' => 'header-side-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'top-line-microwidgets' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'top_line',
					),
				),
			),
			'top-line-microwidgets-settings' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'top_line',
					),
					array(
						'field' => 'header-top_line-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'side-line-microwidgets' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'side_line',
					),
				),
			),
			'side-line-microwidgets-settings' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'side_line',
					),
					array(
						'field' => 'header-side_line-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'menu-icon-microwidgets' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'menu_icon',
					),
				),
			),
			'menu-icon-microwidgets-settings' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'menu_icon',
					),
					array(
						'field' => 'header-menu_icon-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'top-bar-microwidgets' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'classic',
					),
					array(
						'field' => 'header-classic-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'inline',
					),
					array(
						'field' => 'header-inline-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'split',
					),

					array(
						'field' => 'header-split-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'side',
					),
					array(
						'field' => 'header-side-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'top_line',
					),
					array(
						'field' => 'header-top_line-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'side_line',
					),
					array(
						'field' => 'header-side_line-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'menu_icon',
					),
					array(
						'field' => 'header-menu_icon-show_elements',
						'operator' => '==',
						'value' => '1',
					),
				),
			),

			// Menu
			'menu-horizontal-decoration-block' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'classic',
					)
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'inline',
					)
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'split',
					)
				)
			),
			'menu-top-headers-indention' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'classic',
					)
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'inline',
					)
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'split',
					)
				)
			),

			// Floating header
			'floating-header-tab' => array(
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'classic',
					)
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'inline',
					)
				),
				array(
					array(
						'field' => 'header-layout',
						'operator' => '==',
						'value' => 'split',
					)
				),
				
			),
			// Woocommerce
			'isotope-block-settings' => array(
                array(
                    array(
                        'field' => 'wc_view_mode',
                        'operator' => '==',
                        'value' => 'masonry_grid',
                    ),
                ),
                array(
                    array(
                        'field' => 'wc_view_mode',
                        'operator' => '==',
                        'value' => 'view_mode',
                    )
                ),
            ),
            'list-block-settings' => array(
                array(
                    array(
                        'field' => 'wc_view_mode',
                        'operator' => '==',
                        'value' => 'list',
                    ),
                ),
                array(
                    array(
                        'field' => 'wc_view_mode',
                        'operator' => '==',
                        'value' => 'view_mode',
                    )
                ),
            ),
            
			
		);

		return $vars;
	}

	add_filter( 'of_localized_vars', 'presscore_of_localized_vars_filter' );

endif;

if ( ! function_exists( 'presscore_options_black_list' ) ) :

	/**
	 * List of options ids that do not included while export.
	 *
	 * @since 1.0.0
	 *
	 * @param  array  $fields
	 * @return array
	 */
	function presscore_options_black_list( $fields = array() ) {
		$fields_black_list = array(
			'general-tracking_code',
			'general-post_type_portfolio_slug',
			'general-post_type_gallery_slug',
			'general-post_type_team_slug',
			'general-contact_form_send_mail_to',

			'general-favicon',
			'general-favicon_hd',
			'general-handheld_icon-old_iphone',
			'general-handheld_icon-old_ipad',
			'general-handheld_icon-retina_iphone',
			'general-handheld_icon-retina_ipad',

			'header-menu-submenu-parent_is_clickable',

			'footer-layout',
			'bottom_bar-copyrights',
			'bottom_bar-text',

			'general-beautiful_loading',

			'general-show_author_in_blog',
			'general-next_prev_in_blog',
			'general-show_back_button_in_post',
			'general-post_back_button_target_page_id',
			'general-blog_meta_on',
			'general-blog_meta_date',
			'general-blog_meta_author',
			'general-blog_meta_categories',
			'general-blog_meta_comments',
			'general-blog_meta_tags',

			'general-next_prev_in_portfolio',
			'general-show_back_button_in_project',
			'general-project_back_button_target_page_id',

			'general-portfolio_meta_on',
			'general-portfolio_meta_date',
			'general-portfolio_meta_author',
			'general-portfolio_meta_categories',
			'general-portfolio_meta_comments',

			'general-show_rel_projects',
			'general-rel_projects_head_title',
			'general-rel_projects_title',
			'general-rel_projects_excerpt',
			'general-rel_projects_info_date',
			'general-rel_projects_info_author',
			'general-rel_projects_info_comments',
			'general-rel_projects_info_categories',
			'general-rel_projects_link',
			'general-rel_projects_zoom',
			'general-rel_projects_details',
			'general-rel_projects_max',
			'general-rel_projects_fullwidth_height',
			'general-rel_projects_fullwidth_width_style',
			'general-rel_projects_fullwidth_width',
			'general-rel_projects_height',
			'general-rel_projects_width_style',
			'general-rel_projects_width',

			'social_buttons-post-button_title',
			'social_buttons-post',
			'social_buttons-portfolio_post-button_title',
			'social_buttons-portfolio_post',
			'social_buttons-photo-button_title',
			'social_buttons-photo',
			'social_buttons-page-button_title',
			'social_buttons-page',

			'widgetareas',

			// archives
			'template_page_id_author',
			'template_page_id_date',
			'template_page_id_blog_category',
			'template_page_id_blog_tags',
			'template_page_id_search',
			'template_page_id_portfolio_category',
			'template_page_id_gallery_category',

			//wpml
			'wpml_dt-custom_style',
			'contact_form_security_token',
			'contact_form_recaptcha_site_key',
			'contact_form_recaptcha_secret_key',
		);

		return array_unique( array_merge( $fields, $fields_black_list ) );
	}

	add_filter( 'optionsframework_fields_black_list', 'presscore_options_black_list' );
	add_filter( 'optionsframework_validate_preserve_fields', 'presscore_options_black_list', 14 );

endif;

if ( ! function_exists( 'presscore_themeoption_preserved_fields' ) ) :

	/**
	 * List of theme options ids that do not change after skin switch.
	 *
	 * @since 1.0.0
	 *
	 * @param  array  $fields
	 * @return array
	 */
	function presscore_themeoption_preserved_fields( $fields = array() ) {
		$preserved_fields = array(
			// header logo
			'header-logo_regular',
			'header-logo_hd',

			// bottom logo
			'bottom_bar-logo_regular',
			'bottom_bar-logo_hd',

			// mobile logo
			'header-style-mobile-logo_regular',
			'header-style-mobile-logo_hd',
			'header-style-mobile-logo-padding-top',
			'header-style-mobile-logo-padding-bottom',

			// floating logo
			'header-style-floating-choose_logo',
			'header-style-floating-logo_regular',
			'header-style-floating-logo_hd',

			// menu icons dimentions
			'header-icons_size',
			'header-submenu_icons_size',
			'header-submenu_next_level_indicator',
			'header-next_level_indicator',

			// header layout
			'header-login_caption',
			'header-logout_caption',
			'header-search_caption',
			'header-woocommerce_cart_caption',

			// Header layout.
			'header-classic-elements',
			'header-classic-show_elements',
			'header-inline-elements',
			'header-inline-show_elements',
			'header-split-elements',
			'header-split-show_elements',
			'header-side-elements',
			'header-side-show_elements',
			'header-slide_out-elements',
			'header-slide_out-show_elements',
			'header-overlay-elements',
			'header-overlay-show_elements',

			// Microwidgets.
			'header-elements-search-caption',
			'header-elements-search-icon',
			'header-elements-search-second-header-switch',
			'header-elements-contact-address-caption',
			'header-elements-contact-address-icon',
			'header-elements-contact-address-second-header-switch',
			'header-elements-contact-phone-caption',
			'header-elements-contact-phone-icon',
			'header-elements-contact-phone-second-header-switch',
			'header-elements-contact-email-caption',
			'header-elements-contact-email-icon',
			'header-elements-contact-email-second-header-switch',
			'header-elements-contact-skype-caption',
			'header-elements-contact-skype-icon',
			'header-elements-contact-skype-second-header-switch',
			'header-elements-contact-clock-caption',
			'header-elements-contact-clock-icon',
			'header-elements-contact-clock-second-header-switch',
			'header-elements-contact-multipurpose_1-caption',
			'header-elements-contact-multipurpose_1-icon',
			'header-elements-contact-multipurpose_1-second-header-switch',
			'header-elements-contact-multipurpose_2-caption',
			'header-elements-contact-multipurpose_2-icon',
			'header-elements-contact-multipurpose_2-second-header-switch',
			'header-elements-contact-multipurpose_3-caption',
			'header-elements-contact-multipurpose_3-icon',
			'header-elements-contact-multipurpose_3-second-header-switch',
			'header-elements-contact-multipurpose_4-caption',
			'header-elements-contact-multipurpose_4-icon',
			'header-elements-contact-multipurpose_4-second-header-switch',
			'header-elements-login-caption',
			'header-elements-logout-caption',
			'header-elements-login-icon',
			'header-elements-login-second-header-switch',
			'header-elements-login-url',
			'header-elements-text-second-header-switch',
			'header-elements-text',
			'header-elements-text-2-second-header-switch',
			'header-elements-text-2',
			'header-elements-text-3-second-header-switch',
			'header-elements-text-3',
			'header-elements-menu-second-header-switch',
			'header-elements-menu-style',
			'header-elements-menu-style-first-switch',
			'header-elements-menu-style-second-switch',
			'header-elements-soc_icons-second-header-switch',
			'header-elements-soc_icons',
			'header-elements-woocommerce_cart-caption',
			'header-elements-woocommerce_cart-icon',
			'header-elements-woocommerce_cart-second-header-switch',
			'header-elements-woocommerce_cart-show_sub_cart',
			'header-elements-woocommerce_cart-show_subtotal',
			'header-elements-woocommerce_cart-show_counter',
		);

		return array_unique( array_merge( $fields, $preserved_fields ) );
	}

	add_filter( 'optionsframework_validate_preserve_fields', 'presscore_themeoption_preserved_fields', 15 );

endif;

if ( ! function_exists( 'presscore_get_wp_memory_limit' ) ):

	/**
     * Return wp memory limit in bytes.
     *
	 * @return int
	 */
    function presscore_get_wp_memory_limit() {
	    return wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) );
    }

endif;

if ( ! function_exists( 'presscore_get_icons_for_icons_picker' ) ) {

	/**
	 * Ajax response with custom icons (as json).
     *
     * @since 7.1.3
	 */
	function presscore_get_icons_for_icons_picker() {
		$icon_manager_icons                 = apply_filters( 'the7_icons_in_settings', array() );

		$the7_icons = require PRESSCORE_EXTENSIONS_DIR . '/the7-icons-list.php';
		$icon_manager_icons = array( 'The7 Icons' => $the7_icons ) + $icon_manager_icons;

		if ( The7_Icon_Manager::is_fontawesome_enabled() ) {
			$icon_manager_icons['Font Awesome'] = include PRESSCORE_EXTENSIONS_DIR . '/font-awesome-icons.php';
		}
		wp_send_json( $icon_manager_icons );
	}
	add_action( 'wp_ajax_the7_get_icons_for_icons_picker', 'presscore_get_icons_for_icons_picker' );
}

if ( ! function_exists( 'presscore_get_post_type_edit_link_template' ) ) {

	/**
	 * Return post type edit link template or empty string if it's not possible.
	 *
	 * Replace %#% placeholder with actual post id.
	 *
	 * @sine 7.2.0
	 *
	 * @param string $post_type
	 *
	 * @return string
	 */
	function presscore_get_post_type_edit_link_template( $post_type ) {
		$post_type_object = get_post_type_object( $post_type );
		if ( ! $post_type_object || ! $post_type_object->_edit_link ) {
			return '';
		}
		$action = '&amp;action=edit';

		return admin_url( str_replace( '99999', '%#%', sprintf( $post_type_object->_edit_link . $action, 99999 ) ) );
	}

}