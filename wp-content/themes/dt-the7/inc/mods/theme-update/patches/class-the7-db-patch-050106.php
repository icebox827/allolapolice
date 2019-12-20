<?php
/**
 * The7 5.1.6 patch.
 *
 * @package the7
 * @since 5.1.6
 */

if ( ! class_exists( 'The7_DB_Patch_050106', false ) ) {

	class The7_DB_Patch_050106 extends The7_DB_Patch {

		protected function do_apply() {
			// Get pages with mircosite template.
			$pages = get_posts( array(
				'post_type' => 'page',
				'fields' => 'ids',
				'nopaging' => true,
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-microsite.php'
			) );

			if ( $pages ) {

				$field_prefix = '_dt_microsite_';
				$logos = array(
					'main',
					'transparent',
					'mixed',
					'floating',
					'mobile',
					'bottom',
				);

				foreach ( $pages as $page_id ) {

					/**
					 * Logo.
					 */
					foreach ( $logos as $logo ) {
						$logo .= '_logo';

						// Skip if type is set.
						$logo_type = get_post_meta( $page_id,"{$field_prefix}{$logo}_type", true );
						if ( ! empty( $logo_type ) ) {
							continue;
						}

						// Update type if custom logo is set.
						$logo_regular = get_post_meta( $page_id, "{$field_prefix}{$logo}_regular", true );
						$log_hd = get_post_meta( $page_id, "{$field_prefix}{$logo}_hd", true );
						if (
							! empty( $logo_regular )
							|| ! empty( $log_hd )
						) {
							update_post_meta( $page_id,"{$field_prefix}{$logo}_type", 'custom' );
						}
					}

					/**
					 * Favicon.
					 */
					$favicon_type = get_post_meta( $page_id,"{$field_prefix}favicon_type", true );
					$favicon = get_post_meta( $page_id,"{$field_prefix}favicon", true );
					if (
						empty( $favicon_type )
						|| ! empty( $favicon )
					) {
						update_post_meta( $page_id,"{$field_prefix}favicon_type", 'custom' );
					}
				}
			};
		}

	}

}
