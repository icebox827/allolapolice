<?php

class The7_Core_Compatibility {


	/**
	 * Initiate compatibility actions.
	 */
	public static function setup() {
		$plugin_version = The7PT()->version();

		if ( version_compare( $plugin_version, '1.4.1', '>=' ) ) {
			self::hide_modules_options();
			add_action( 'the7_before_meta_box_registration', array(
				__CLASS__,
				'exclude_meta_fields_from_presets',
			), 9999 );
		}

		add_action( 'admin_notices', array( __CLASS__, 'display_outdated_plugin_notice' ) );
	}

	/**
     * Determine is dt-the7-core has compatible version or not.
     *
	 * @return bool
	 */
	public static function plugin_is_compatible() {
		return version_compare( The7PT()->version(), THE7_CORE_COMPATIBLE_VERSION, '>=' );
	}

	/**
	 * Display notice about outdated dt-the7-core plugin.
	 */
	public static function display_outdated_plugin_notice() {
		if ( ! current_user_can( 'update_plugins' ) || self::plugin_is_compatible() ) {
		    return;
        }
	    ?>
        <div class="the7-dashboard-notice the7-notice notice notice-error">
            <p>
				<?php echo wp_kses_post( sprintf( __( '<strong>Important notice</strong>: You have an outdated version of <strong>The7 Elements</strong> plugin. For better compatibility with theme it is required to <a href="%s">update the plugin</a>.', 'the7mk2' ), admin_url( 'admin.php?page=the7-plugins' ) ) ) ?>
            </p>
        </div>
		<?php
	}

	/**
	 * Remove theme options for backwars compatibility.
	 */
	public static function hide_modules_options() {
		remove_filter( 'presscore_options_files_to_load', array( 'The7PT_Admin', 'add_module_options' ) );
	}

	/**
	 * Exclude some fields from presets and defaults.
	 */
	public static function exclude_meta_fields_from_presets() {
		global $DT_META_BOXES;

		foreach ( $DT_META_BOXES as &$meta_box ) {
			// Exclude albums media.
			if ( $meta_box['id'] === 'dt_page_box-album_post_media' && isset( $meta_box['fields'][0]['id'] ) ) {
				$meta_box['fields'][0]['exclude_from_presets'] = true;
				// Exclude project media.
			} elseif ( $meta_box['id'] === 'dt_page_box-portfolio_post_media' && isset( $meta_box['fields'][0]['id'] ) ) {
				$meta_box['fields'][0]['exclude_from_presets'] = true;
				// Exclude teammate options.
			} elseif ( $meta_box['id'] === 'dt_page_box-testimonial_options' && ! empty( $meta_box['fields'] ) ) {
				foreach ( $meta_box['fields'] as &$field ) {
					if ( $field['id'] === '_dt_teammate_options_go_to_single' ) {
						continue;
					}

					$field['exclude_from_presets'] = true;
				}
			}
		}
	}
}