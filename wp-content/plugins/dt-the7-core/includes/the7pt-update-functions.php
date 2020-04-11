<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/the7pt-update-utility-functions.php';

function the7pt_set_db_version_1_11_0() {
	The7PT_Install::update_db_version( '1.11.0' );
}

function the7pt_set_db_version_1_13_0() {
	The7PT_Install::update_db_version( '1.13.0' );
}


/**
 * Migrate shortcodes gradients.
 *
 * @param array $atts
 *
 * @return array
 */
function the7pt_update_1_14_0_migrate_shortcodes_gradients( $atts ) {
	$new_atts = (array) $atts;
	if ( ! isset( $atts['image_hover_bg_color'] ) && ! empty( $atts['custom_rollover_bg_color'] ) ) {
		$new_atts['image_hover_bg_color'] = 'solid_rollover_bg';
	} elseif ( isset( $atts['image_hover_bg_color'] ) && $atts['image_hover_bg_color'] === 'solid_rollover_bg' && empty( $atts['custom_rollover_bg_color'] ) ) {
		unset( $new_atts['image_hover_bg_color'] );
	} elseif ( isset( $atts['image_hover_bg_color'] ) && $atts['image_hover_bg_color'] === 'gradient_rollover_bg' && empty( $atts['custom_rollover_bg_color_1'] ) ) {
		unset( $new_atts['image_hover_bg_color'] );
	} elseif ( isset( $atts['image_hover_bg_color'] ) && $atts['image_hover_bg_color'] === 'gradient_rollover_bg' && ! empty( $atts['custom_rollover_bg_color_1'] ) && ! empty( $atts['custom_rollover_bg_color_2'] ) ) {
		$color_1 = $atts['custom_rollover_bg_color_1'];
		$color_2 = $atts['custom_rollover_bg_color_2'];
		$angle   = isset( $atts['custom_rollover_gradient_deg'] ) ? $atts['custom_rollover_gradient_deg'] : '135deg';

		$new_atts['custom_rollover_bg_gradient'] = "$angle|$color_1 30%|$color_2 100%";
		unset(
			$new_atts['custom_rollover_bg_color_1'], $new_atts['custom_rollover_bg_color_2'], $new_atts['custom_rollover_gradient_deg']
		);
	}

	return $new_atts;
}

function the7pt_update_1_14_0_shortcodes_gradient_backward_compatibility() {
	$tags = array(
		'dt_portfolio_carousel',
		'dt_portfolio_masonry',
		'dt_gallery_photos_masonry',
		'dt_photos_carousel',
	);

	the7_migrate_shortcodes_in_all_posts( 'the7pt_update_1_14_0_migrate_shortcodes_gradients', $tags, __FUNCTION__ );
}

function the7pt_set_db_version_1_14_0() {
	The7PT_Install::update_db_version( '1.14.0' );
}

function the7pt_set_db_version_1_15_0() {
	The7PT_Install::update_db_version( '1.15.0' );
}

/**
 * Migrate portfolio back button urls.
 *
 * @since 1.18.0
 *
 * @uses  the7_update_740_back_button_migration
 */
function the7pt_update_1_18_0_portfolio_back_button_migration() {
	the7pt_update_posts_back_button_urls_in_meta_key( '_dt_project_options_back_button' );
}

/**
 * Migrate albums back button urls.
 *
 * @since 1.18.0
 *
 * @uses  the7_update_740_back_button_migration
 */
function the7pt_update_1_18_0_albums_back_button_migration() {
	the7pt_update_posts_back_button_urls_in_meta_key( '_dt_album_options_back_button' );
}

/**
 * Migrate theme options.
 *
 * @since 1.18.0
 *
 * @uses  the7pt_migrate_theme_options
 * @uses  The7pt_Options_Migration_1_18_0
 */
function the7pt_update_1_18_0_migrate_theme_options() {
	require_once PRESSCORE_MODS_DIR . '/theme-update/patches/interface-the7-db-patch.php';
	require_once dirname( __FILE__ ) . '/migrations/class-the7pt-options-migration-1-18-0.php';

	the7pt_migrate_theme_options( new The7pt_Options_Migration_1_18_0() );
}

/**
 * Update plugin db version.
 *
 * @since 1.18.0
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_1_18_0() {
	The7PT_Install::update_db_version( '1.18.0' );
}

/**
 * Update plugin db version.
 *
 * @since 2.0.0
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_0_0() {
	The7PT_Install::update_db_version( '2.0.0' );
}

/**
 * Update plugin db version.
 *
 * @since 2.0.0.1
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_0_0_1() {
	The7PT_Install::update_db_version( '2.0.0.1' );
}

/**
 * Update plugin db version.
 *
 * @since 2.0.2
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_0_2() {
	The7PT_Install::update_db_version( '2.0.2' );
}


/**
 * Update plugin db version.
 *
 * @since 2.0.3
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_0_3() {
	The7PT_Install::update_db_version( '2.0.3' );
}

/**
 * Update plugin db version.
 *
 * @since 2.0.6
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_0_6() {
	The7PT_Install::update_db_version( '2.0.6' );
}

/**
 * Update plugin db version.
 *
 * @since 2.0.7
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_0_7() {
	The7PT_Install::update_db_version( '2.0.7' );
}

/**
 * Update plugin db version.
 *
 * @since 2.1.0
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_1_0() {
	The7PT_Install::update_db_version( '2.1.0' );
}

/**
 * Update plugin db version.
 *
 * @since 2.2.0
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_2_0() {
	The7PT_Install::update_db_version( '2.2.0' );
}

/**
 * Update plugin db version.
 *
 * @since 2.2.3
 *
 * @uses  The7PT_Install::update_db_version
 */
function the7pt_set_db_version_2_2_4() {
	The7PT_Install::update_db_version( '2.2.4' );
}