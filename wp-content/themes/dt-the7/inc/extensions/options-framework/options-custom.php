<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widgetareas theme-options filter.
 */
function optionsframework_widgetareas_interface( $output, $value ) {

	// Name
	$output .= '<label for="widgetareas-name">' . _x('Sidebar name', 'theme-options', 'the7mk2') . '</label>';
	$output .= '<input type="text" id="widgetareas-name" class="of_fields_gen_title" value=""/>';

	// Description
	$output .= '<label for="widgetareas-description">' . _x('Sidebar description (optional)', 'theme-options', 'the7mk2') . '</label>';
	$output .= '<textarea id="widgetareas-description"></textarea>';    

	// Button
	$output .= '<button id="widgetareas-add" class="of_fields_gen_add">' . _x('Update', 'theme-options', 'the7mk2') . '</button>';

	return $output;
}

/**
 * Widgetareas ajax handler.
 */
function optionsframework_widgetareas_ajax() {
	$action = empty($_POST['type']) ? '' : $_POST['type'];
	$nonce = empty($_POST['waNonce']) ? '' : $_POST['waNonce'];
	$wa_id = empty($_POST['waId']) ? 0 : absint($_POST['waId']);
	$wa_title = empty($_POST['waTitle']) ? '' : $_POST['waTitle'];
	$wa_desc = empty($_POST['waDesc']) ? '' : $_POST['waDesc'];

	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'options-framework-nonce' ) ) {		
		die ( 'Busted!');
	}

	// ignore the request if the current user doesn't have
	// sufficient permissions
	if ( current_user_can( 'edit_theme_options' ) ) {
		
		$response = array( 'success' => false );
		$wa_array = of_get_option('widgetareas', array());

		if ( 'get' == $action && $wa_id ) {

			if ( $wa_array && isset($wa_array[ $wa_id ]) ) {

				$response['title'] = $wa_array[ $wa_id ]['title'];
				$response['desc'] = $wa_array[ $wa_id ]['desc'];
				$response['success'] = true;
			}
		} else if ( 'update' == $action && $wa_title ) {

			$known_options = get_option( 'optionsframework', array() );
			$saved_options = get_option( $known_options['id'], array() );
			
			if ( isset($saved_options['widgetareas']) ) {
				$wa_array = $saved_options['widgetareas'];
				
				// Get field id
				if ( !$wa_id ) { $wa_id = $wa_array['next_id']++; }
				
				// Update/Add new field
				$wa_array[ $wa_id ] = array(
					'title' => $wa_title,
					'desc'	=> $wa_desc
				);

				// Sanitize
				$saved_options['widgetareas'] = apply_filters('of_sanitize_widgetareas', $wa_array);

				// Update options
				$response['success'] = update_option($known_options['id'], $saved_options);
				$response['id'] = $wa_id;
			}
		}

		// generate the response
		$response = json_encode($response);
 
		// response output
		header( "Content-Type: application/json" );
		echo $response;
	}
 
	// IMPORTANT: don't forget to "exit"
	exit;
}
add_action('wp_ajax_process_widgetarea', 'optionsframework_widgetareas_ajax');

/**
 *	DEPRECATED.
 *
 * @param  boolean $get_defaults
 * @return array
 */
function dt_get_google_fonts_list( $get_defaults = false ) {
	return presscore_options_get_web_fonts();
}

/* find option pages in array */
function optionsframework_options_page_filter( $item ) {
	if( isset($item['type']) && 'page' == $item['type'] ) {
		return true;
	}
	return false;
}

/* find options for current page */
function optionsframework_options_for_page_filter( $item ) {
	static $bingo = false;
	static $found_main = false;

	if ( $item == 0 ) { $bingo = $found_main = false; }

	if( !isset($_GET['page']) ) {
		if( !isset($_POST['_wp_http_referer']) ) {
			return true;
		}else {
			$arr = array();
			wp_parse_str($_POST['_wp_http_referer'], $arr);
			$current = current($arr);
		}
	}else {
		$current = $_GET['page'];
	}

	if( 'options-framework' == $current && !$found_main ) {
		$bingo = true;
		$found_main = true;
	}

	if( isset($item['type']) && 'page' == $item['type'] && $item['menu_slug'] == $current ) {
		$bingo = true;
		return false;
	}elseif( isset($item['type']) && 'page' == $item['type'] ) {
		$bingo = false;
	}

	return $bingo;
}

function optionsframework_get_cur_page_id() {
	if ( isset( $_REQUEST['page'] ) ) {
		return basename( wp_unslash( $_REQUEST['page'] ) );
	}

	if ( isset( $_POST['_wp_http_referer'] ) ) {
		$arr = array();
		wp_parse_str( $_POST['_wp_http_referer'], $arr );
		return current( $arr );
	}

	return false;
}

function optionsframework_presets_data( $id ) {
	$preset = array();
	$registered_presets = optionsframework_get_presets_list();
	if ( array_key_exists( $id, $registered_presets ) ) {

		$preset = apply_filters( 'presscore_options_return_preset', array(), $id );
		if ( $preset ) {
			return $preset;
		}

		include OPTIONS_FRAMEWORK_PRESETS_DIR . $id . '.php';

		if ( isset( $presets[ $id ] ) ) {
			$preset = $presets[ $id ];
		}
	}
	return $preset;
}

/**
 * Store framework pages.
 *
 */
function optionsframework_menu_items() {
	$menu_config = array();
	$menu_config_file = locate_template( 'inc/admin/theme-options-menu-list.php', false, false );
	if ( $menu_config_file ) {
		$menu_config = include $menu_config_file;
	}
	$options_files = optionsframework_get_options_files();

	$menu_config = array_intersect_key( $menu_config, $options_files );

	$menu_config = apply_filters( 'presscore_options_menu_config', $menu_config );

	return The7_Options_Menu_Items_Composition::create_from_array( $menu_config );
}

function optionsframework_get_options_files( $page_slug = false ) {
	$files_list = include trailingslashit( PRESSCORE_ADMIN_DIR ) . 'theme-options-files.php';
	$files_list = presscore_assure_is_array( $files_list );

	$files_list = apply_filters( 'presscore_options_files_list', $files_list, $page_slug );

	if ( $page_slug !== false ) {
		return isset( $files_list[ $page_slug ] ) ? array( $page_slug => $files_list[ $page_slug ] ) : array();
	}

	return $files_list;
}

function optionsframework_get_page_options( $page_slug ) {
	return optionsframework_load_options( optionsframework_get_options_files( $page_slug ) );
}

function optionsframework_get_menu_items_list() {
	$user_menu = apply_filters( 'presscore_options_menu_items', optionsframework_menu_items()->get_all() );
	reset( $user_menu );
	return $user_menu;
}

function optionsframework_load_options( $files_list ) {
	$files_list = presscore_assure_is_array( $files_list );

	$files_list = apply_filters( 'presscore_options_files_to_load', $files_list );

	$options = array();

	if ( $files_list ) {
		include PRESSCORE_ADMIN_OPTIONS_DIR . '/options.php';

		foreach ( $files_list as $slug=>$file_path ) {
			include $file_path;
		}
	}

	$options = apply_filters( 'presscore_loaded_options', $options, $files_list );

	return $options;
}


function presscore_opts_get_bg_images() {
	return array(
		'/images/backgrounds/patterns/full/archers.gif'             => '/images/backgrounds/patterns/thumbs/archers.jpg',
		'/images/backgrounds/patterns/full/binding_dark.gif'        => '/images/backgrounds/patterns/thumbs/binding_dark.jpg',
		'/images/backgrounds/patterns/full/brickwall.gif'           => '/images/backgrounds/patterns/thumbs/brickwall.jpg',
		'/images/backgrounds/patterns/full/congruent_outline.png'   => '/images/backgrounds/patterns/thumbs/congruent_outline.jpg',
		'/images/backgrounds/patterns/full/congruent_pentagon.png'  => '/images/backgrounds/patterns/thumbs/congruent_pentagon.jpg',
		'/images/backgrounds/patterns/full/crisp_paper_ruffles.jpg' => '/images/backgrounds/patterns/thumbs/crisp_paper_ruffles.jpg',
		'/images/backgrounds/patterns/full/escheresque_ste.png'     => '/images/backgrounds/patterns/thumbs/escheresque_ste.jpg',
		'/images/backgrounds/patterns/full/gplaypattern.jpg'        => '/images/backgrounds/patterns/thumbs/gplaypattern.jpg',
		'/images/backgrounds/patterns/full/graphy-dark.png'         => '/images/backgrounds/patterns/thumbs/graphy-dark.jpg',
		'/images/backgrounds/patterns/full/graphy-light.png'        => '/images/backgrounds/patterns/thumbs/graphy-light.jpg',
		'/images/backgrounds/patterns/full/grey_wood.jpg'           => '/images/backgrounds/patterns/thumbs/grey_wood.jpg',
		'/images/backgrounds/patterns/full/grid-dark.png'           => '/images/backgrounds/patterns/thumbs/grid-dark.jpg',
		'/images/backgrounds/patterns/full/grid-light.png'          => '/images/backgrounds/patterns/thumbs/grid-light.jpg',
		'/images/backgrounds/patterns/full/halftone-dark.png'       => '/images/backgrounds/patterns/thumbs/halftone-dark.jpg',
		'/images/backgrounds/patterns/full/halftone-light.png'      => '/images/backgrounds/patterns/thumbs/halftone-light.jpg',
		'/images/backgrounds/patterns/full/herald.png'              => '/images/backgrounds/patterns/thumbs/herald.jpg',
		'/images/backgrounds/patterns/full/linedpaper.jpg'          => '/images/backgrounds/patterns/thumbs/linedpaper.jpg',
		'/images/backgrounds/patterns/full/low_contrast_linen.jpg'  => '/images/backgrounds/patterns/thumbs/low_contrast_linen.jpg',
		'/images/backgrounds/patterns/full/notebook.gif'            => '/images/backgrounds/patterns/thumbs/notebook.jpg',
		'/images/backgrounds/patterns/full/poly.png'                => '/images/backgrounds/patterns/thumbs/poly.jpg',
		'/images/backgrounds/patterns/full/retro-dark.png'          => '/images/backgrounds/patterns/thumbs/retro-dark.jpg',
		'/images/backgrounds/patterns/full/retro-light.png'         => '/images/backgrounds/patterns/thumbs/retro-light.jpg',
		'/images/backgrounds/patterns/full/skulls.gif'              => '/images/backgrounds/patterns/thumbs/skulls.jpg',
		'/images/backgrounds/patterns/full/stardust.gif'            => '/images/backgrounds/patterns/thumbs/stardust.jpg',
		'/images/backgrounds/patterns/full/subtle_grunge.png'       => '/images/backgrounds/patterns/thumbs/subtle_grunge.jpg',
	);
}

function presscore_options_debug() {
	return ( defined( 'OPTIONS_FRAMEWORK_DEBUG' ) && OPTIONS_FRAMEWORK_DEBUG );
}

function presscore_options_add_debug_info() {
	if ( ! presscore_options_debug() ) {
		return;
	}

	echo '<button class="show-debug-info button hide-if-js">toggle debug info</button>';

	the7_register_script( 'the7-options-debug', PRESSCORE_ADMIN_URI . '/assets/js/options-debug', array( 'jquery' ), false, true );
	wp_enqueue_script( 'the7-options-debug' );
}
add_action( 'optionsframework_before', 'presscore_options_add_debug_info' );
