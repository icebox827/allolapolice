<?php
/**
 * The7 TGM class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'The7_TGMPA' ) ) {

	/**
	 * Class The7_TGMPA
	 */
	class The7_TGMPA extends The7_TGM_Plugin_Activation {

		/**
		 * Public plugin install action.
		 */
		public function public_do_plugin_install() {
			return $this->do_plugin_install();
		}

		/**
		 * Override parent method.
		 *
		 * @return bool
		 */
		protected function do_plugin_install() {
			add_filter( 'upgrader_package_options', array( $this, 'clear_plugin_destination_filter' ) );
			$installation_result = parent::do_plugin_install();
			remove_filter( 'upgrader_package_options', array( $this, 'clear_plugin_destination_filter' ) );

			return $installation_result;
		}

		/**
		 * Filter $options to clear plugin destination before installation.
		 *
		 * @param array $options TGMPA options.
		 *
		 * @return array
		 */
		public function clear_plugin_destination_filter( $options ) {
			$options['clear_destination'] = true;

			return $options;
		}

		/**
		 * Admin menu dummy method.
		 */
		public function admin_menu() {
			// Do nothing.
		}

		/**
		 * Echoes required plugin notice.
		 *
		 * Outputs a message telling users that a specific plugin is required for
		 * their theme. If appropriate, it includes a link to the form page where
		 * users can install and activate the plugin.
		 *
		 * Returns early if we're on the Install page.
		 *
		 * @global object $current_screen
		 *
		 * @return null Returns early if we're on the Install page.
		 */
		public function notices() {
			// Remove nag on the install page / Return early if the nag message has been dismissed or user < author.
			if ( ( $this->is_tgmpa_page() || $this->is_core_update_page() ) || get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_' . $this->id, true ) || ! current_user_can( apply_filters( 'tgmpa_show_admin_notice_capability', 'publish_posts' ) ) ) {
				return;
			}

			// Store for the plugin slugs by message type.
			$message = array();

			// Initialize counters used to determine plurality of action link texts.
			$install_link_count          = 0;
			$update_link_count           = 0;
			$activate_link_count         = 0;
			$total_required_action_count = 0;

			foreach ( $this->plugins as $slug => $plugin ) {
				if ( ! $this->is_plugin_installed( $slug ) ) {
					continue;
				}

				if ( $this->is_plugin_active( $slug ) && false === $this->does_plugin_have_update( $slug ) ) {
					continue;
				}

				if ( $this->does_plugin_require_update( $slug ) || false !== $this->does_plugin_have_update( $slug ) ) {
					if ( current_user_can( 'update_plugins' ) ) {
						$update_link_count++;

						if ( $this->does_plugin_require_update( $slug ) ) {
							$message['notice_ask_to_update'][] = $slug;
						} elseif ( false !== $this->does_plugin_have_update( $slug ) ) {
							$message['notice_ask_to_update_maybe'][] = $slug;
						}
					}
					if ( true === $plugin['required'] ) {
						$total_required_action_count++;
					}
				}
			}
			unset( $slug, $plugin );

			// If we have notices to display, we move forward.
			if ( ! empty( $message ) || $total_required_action_count > 0 ) {
				krsort( $message ); // Sort messages.
				$rendered = '';

				// As add_settings_error() wraps the final message in a <p> and as the final message can't be
				// filtered, using <p>'s in our html would render invalid html output.
				$line_template = '<span style="display: block; margin: 0.5em 0.5em 0 0; clear: both;">%s</span>' . "\n";

				if ( ! current_user_can( 'activate_plugins' ) && ! current_user_can( 'install_plugins' ) && ! current_user_can( 'update_plugins' ) ) {
					$rendered  = esc_html( $this->strings['notice_cannot_install_activate'] ) . ' ' . esc_html( $this->strings['contact_admin'] );
					$rendered .= $this->create_user_action_links_for_notice( 0, 0, 0, $line_template );
				} else {

					// If dismissable is false and a message is set, output it now.
					if ( ! $this->dismissable && ! empty( $this->dismiss_msg ) ) {
						$rendered .= sprintf( $line_template, wp_kses_post( $this->dismiss_msg ) );
					}

					// Render the individual message lines for the notice.
					foreach ( $message as $type => $plugin_group ) {
						$linked_plugins = array();

						// Get the external info link for a plugin if one is available.
						foreach ( $plugin_group as $plugin_slug ) {
							$linked_plugins[] = $this->get_info_link( $plugin_slug );
						}

						$count          = count( $plugin_group );
						$linked_plugins = array_map( array( 'TGMPA_Utils', 'wrap_in_em' ), $linked_plugins );
						$last_plugin    = array_pop( $linked_plugins ); // Pop off last name to prep for readability.
						$imploded       = empty( $linked_plugins ) ? $last_plugin : ( implode( ', ', $linked_plugins ) . ' ' . esc_html_x( 'and', 'plugin A *and* plugin B', 'tgmpa' ) . ' ' . $last_plugin );

						$rendered .= sprintf(
							$line_template,
							sprintf(
								translate_nooped_plural( $this->strings[ $type ], $count, 'tgmpa' ),
								$imploded,
								$count
							)
						);

					}

					$rendered .= $this->create_user_action_links_for_notice( $install_link_count, $update_link_count, $activate_link_count, $line_template );
				}

				// Register the nag messages and prepare them to be processed.
				add_settings_error( 'tgmpa', 'tgmpa', $rendered, $this->get_admin_notice_class() );
			}

			// Admin options pages already output settings_errors, so this is to avoid duplication.
			if ( 'options-general' !== $GLOBALS['current_screen']->parent_base ) {
				$this->display_settings_errors();
			}
		}

		/**
		 * Check if a plugin is installable. Does not take must-use plugins into account.
		 *
		 * @param string $slug Plugin slug.
		 * @return bool True if installable, false otherwise.
		 */
		public function is_plugin_installable( $slug ) {
			if ( 'external' === $this->plugins[ $slug ]['source_type'] && ! presscore_theme_is_activated() ) {
				return false;
			}

			return ! $this->is_plugin_installed( $slug );
		}

		/**
		 * Check to see if the plugin is 'updatetable', i.e. installed, with an update available
		 * and no WP version requirements blocking it.
		 *
		 * @since 2.6.0
		 *
		 * @param string $slug Plugin slug.
		 * @return bool True if OK to proceed with update, false otherwise.
		 */
		public function is_plugin_updatetable( $slug ) {
			if ( 'external' === $this->plugins[ $slug ]['source_type'] && ! presscore_theme_is_activated() ) {
				return false;
			}

			return parent::is_plugin_updatetable( $slug );
		}

		/**
		 * Check if plugin belongs to The7 theme.
		 *
		 * @since 2.6.0
		 *
		 * @param string $slug Plugin slug.
		 *
		 * @return bool True if plugin belong to The7.
		 */
		public function is_the7_plugin( $slug ) {
			if ( ! array_key_exists( $slug, $this->plugins ) ) {
				return false;
			}

			if ( $this->plugins[ $slug ]['source_type'] !== 'external' ) {
				return false;
			}

			$installed_plugins = $this->get_plugins();
			$plugin_file_path  = $this->plugins[ $slug ]['file_path'];

			if ( ! isset( $installed_plugins[ $plugin_file_path ]['Name'] ) ) {
				return false;
			}

			$plugin_name = strtolower( $installed_plugins[ $plugin_file_path ]['Name'] );
			if ( $plugin_name === 'pro elements' ) {
				return true;
			}

			return strpos( $plugin_name, 'the7' ) === 0;
		}

		/**
		 * Return bulk action link.
		 *
		 * @return string
		 */
		public function get_bulk_action_link() {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return '';
			}

			// For nonce action see TGMPA_List_Table::__construct().
			return wp_nonce_url( $this->get_tgmpa_url(), 'bulk-plugins' );
		}

		/**
		 * Returns the singleton instance of the class.
		 *
		 * @return \The7_TGMPA The7_TGMPA object.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	if ( ! function_exists( 'load_the7_tgmpa' ) ) {
		function load_the7_tgmpa() {
			$GLOBALS['the7_tgmpa'] = The7_TGMPA::get_instance();
		}
	}

	if ( did_action( 'plugins_loaded' ) ) {
		load_the7_tgmpa();
	} else {
		add_action( 'plugins_loaded', 'load_the7_tgmpa' );
	}
}
