<?php
/**
 * The7 5.2.0 patch.
 *
 * @package the7
 * @since 5.2.0
 */

if ( ! class_exists( 'The7_DB_Patch_050200', false ) ) {

	class The7_DB_Patch_050200 extends The7_DB_Patch {

		protected function do_apply() {
			// Setup legacy settings if it's don't exists.
			if ( ! The7_Admin_Dashboard_Settings::exists() ) {
				$legacy_settings = array(
					'rows',
				    'icons-bar',
				    'portfolio-layout',
				);

				foreach ( $legacy_settings as $setting_id ) {
					The7_Admin_Dashboard_Settings::set( $setting_id, true );
				}
			}

			The7_Admin_Dashboard_Settings::set( 'silence-plugins', true );

			// Setup Post Types settings.
			$post_types_settings_map = array(
				'modules-portfolio-status' => 'portfolio',
			    'modules-testimonials-status' => 'testimonials',
			    'modules-team-status' => 'team',
			    'modules-logos-status' => 'logos',
			    'modules-benefits-status' => 'benefits',
			    'modules-albums-status' => 'albums',
			    'modules-slideshow-status' => 'slideshow',
			);

			foreach ( $post_types_settings_map as $of_key => $new_key ) {
				$post_type_enabled = true;

				if ( $this->option_exists( $of_key ) ) {
					$post_type_enabled = ( 'enabled' === $this->get_option( $of_key ) );
				}

				The7_Admin_Dashboard_Settings::set( $new_key, $post_type_enabled );
			}

			$post_types_slug_map = array(
				'general-post_type_portfolio_slug' => 'portfolio-slug',
			    'general-post_type_gallery_slug' => 'albums-slug',
			    'general-post_type_team_slug' => 'team-slug',
			);

			foreach ( $post_types_slug_map as $of_key => $new_key ) {
				if ( ! $this->option_exists( $of_key ) ) {
					continue;
				}

				$post_type_slug = $this->get_option( $of_key );
				The7_Admin_Dashboard_Settings::set( $new_key, $post_type_slug );
			}
		}

	}

}
