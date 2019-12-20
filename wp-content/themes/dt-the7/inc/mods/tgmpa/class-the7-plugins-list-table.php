<?php

if ( ! class_exists( 'The7_Plugins_List_Table' ) ) {

	/**
	 * List table class for handling plugins.
	 */
	class The7_Plugins_List_Table extends The7_TGMPA_List_Table {

		/**
		 * Categorize the plugins which have open actions into views for the TGMPA page.
		 */
		protected function categorize_plugins_to_views() {
			$plugins = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			$theme_is_activated = presscore_theme_is_activated();

			// Show all plugins.
			foreach ( $this->tgmpa->plugins as $slug => $plugin ) {
				$plugins['all'][ $slug ] = $plugin;

				$plugin_is_external = ( 'external' == $plugin['source_type'] );

				if ( ! $this->tgmpa->is_plugin_installed( $slug ) ) {
					if ( ! $theme_is_activated && $plugin_is_external ) {
						continue;
					}

					$plugins['install'][ $slug ] = $plugin;
				} else {
					if (
						false !== $this->tgmpa->does_plugin_have_update( $slug )
						&& ( ! $plugin_is_external || $theme_is_activated )
					) {
						$plugins['update'][ $slug ] = $plugin;
					}

					if ( $this->tgmpa->can_plugin_activate( $slug ) ) {
						$plugins['activate'][ $slug ] = $plugin;
					}
				}
			}

			return $plugins;
		}

		/**
		 * Determine the plugin status message.
		 *
		 * @param string $slug Plugin slug.
		 * @return string
		 */
		protected function get_plugin_status_text( $slug ) {
			if ( ! $this->tgmpa->is_plugin_installed( $slug ) ) {
				return __( 'Not Installed', 'tgmpa' );
			}

			if ( ! $this->tgmpa->is_plugin_active( $slug ) ) {
				$install_status = __( 'Installed But Not Activated', 'tgmpa' );
			} else {
				$install_status = __( 'Active', 'tgmpa' );
			}

			if ( $this->tgmpa->does_plugin_require_update( $slug ) && false === $this->tgmpa->does_plugin_have_update( $slug ) ) {
				$update_status = __( 'Required Update not Available', 'tgmpa' );
			} elseif ( $this->tgmpa->does_plugin_require_update( $slug ) ) {
				$update_status = __( 'Requires Update', 'tgmpa' );
			} elseif ( false !== $this->tgmpa->does_plugin_have_update( $slug ) ) {
				$update_status = __( 'Update recommended', 'tgmpa' );
			} else {
				$update_status = __( 'Up to date', 'tgmpa' );
			}

			if ( $this->tgmpa->does_plugin_have_cross_version_update( $slug ) ) {
				$update_url  = $this->get_action_url( 'update', $slug, 'latest' );
				$button_text = sprintf(
					/* translators: %s: plugin version */
					__( 'Force Upgrade to %s', 'tgmpa' ),
					$this->tgmpa->get_plugin_latest_version( $slug )
				);
				$update_status .= '<br><a class="button-link button-link-delete force-update" href="' . esc_url( $update_url ) . '">' . esc_html( $button_text ) . '</a>';
			}

			$status_text = sprintf(
				/* translators: 1: install status, 2: update status */
				_x( '%1$s, %2$s', 'Install/Update Status', 'tgmpa' ),
				$install_status,
				$update_status
			);

			return $status_text;
		}

		/**
		 * Get the plugin source type text string.
		 *
		 * @since 2.5.0
		 *
		 * @param string $type Plugin type.
		 * @return string
		 */
		protected function get_plugin_source_type_text( $type ) {
			$string = '';

			switch ( $type ) {
				case 'repo':
					$string = __( 'WordPress Repository', 'tgmpa' );
					break;
				case 'external':
					if ( presscore_theme_is_activated() ) {
						$string = __( 'External Source', 'tgmpa' );
					} else {
						$string = wp_kses( sprintf( __( 'Please <a href="%s">register</a> the theme', 'tgmpa' ), admin_url( 'admin.php?page=the7-dashboard' ) ), array( 'a' => array( 'href' => true ) ) );
					}
					break;
				case 'bundled':
					$string = __( 'Pre-Packaged', 'tgmpa' );
					break;
			}

			return $string;
		}

		/**
		 * Get the actions which are relevant for a specific plugin row.
		 *
		 * @param array $item Array of item data.
		 * @return array Array with relevant action links.
		 */
		protected function get_row_actions( $item ) {
			$item_source = 'external';
			$item_slug = $item['slug'];
			if ( array_key_exists( $item_slug, $this->tgmpa->plugins ) && isset( $this->tgmpa->plugins[ $item_slug ]['source'] ) ) {
				$item_source = $this->tgmpa->plugins[ $item_slug ]['source'];
			}

			// If it's an external plugin and theme is not registered - show no actions.
			if ( 'repo' !== $item_source && ! presscore_theme_is_activated() ) {
				$prefix = ( defined( 'WP_NETWORK_ADMIN' ) && WP_NETWORK_ADMIN ) ? 'network_admin_' : '';
				return apply_filters( "tgmpa_{$prefix}plugin_action_links", array(), $item['slug'], $item, $this->view_context );
			}

			$actions      = array();
			$action_links = array();

			// Display the 'Install' action link if the plugin is not yet available.
			if ( ! $this->tgmpa->is_plugin_installed( $item['slug'] ) ) {
				/* translators: %2$s: plugin name in screen reader markup */
				$actions['install'] = __( 'Install %2$s', 'tgmpa' );
			} else {
				// Display the 'Update' action link if an update is available and WP complies with plugin minimum.
				if ( false !== $this->tgmpa->does_plugin_have_update( $item['slug'] ) && $this->tgmpa->can_plugin_update( $item['slug'] ) ) {
					/* translators: %2$s: plugin name in screen reader markup */
					$actions['update'] = __( 'Update %2$s', 'tgmpa' );
				}

				// Display the 'Activate' action link, but only if the plugin meets the minimum version.
				if ( $this->tgmpa->can_plugin_activate( $item['slug'] ) ) {
					/* translators: %2$s: plugin name in screen reader markup */
					$actions['activate'] = __( 'Activate %2$s', 'tgmpa' );
				}
			}

			// Create the actual links.
			foreach ( $actions as $action => $text ) {
				$nonce_url               = $this->get_action_url( $action, $item['slug'] );
				$action_links[ $action ] = sprintf(
					'<a href="%1$s">' . esc_html( $text ) . '</a>', // $text contains the second placeholder.
					esc_url( $nonce_url ),
					'<span class="screen-reader-text">' . esc_html( $item['sanitized_plugin'] ) . '</span>'
				);
			}

			$prefix = ( defined( 'WP_NETWORK_ADMIN' ) && WP_NETWORK_ADMIN ) ? 'network_admin_' : '';
			return apply_filters( "tgmpa_{$prefix}plugin_action_links", array_filter( $action_links ), $item['slug'], $item, $this->view_context );
		}

		/**
		 * Return action url.
		 *
		 * @param string $action      Can be install, update or activate.
		 * @param string $plugin_slug Plugin slug.
		 * @param string $version     Requested version. Can be recommended, minimum and latest.
		 *
		 * @return string
		 */
		protected function get_action_url( $action, $plugin_slug, $version = 'recommended' ) {
			$query_args = array(
				'plugin'           => urlencode( $plugin_slug ),
				'tgmpa-' . $action => $action . '-plugin',
			);

			if ( $this->tgmpa->plugin_has_multiple_versions( $plugin_slug ) ) {
				if ( $version === 'latest' ) {
					$query_args['ver'] = $this->tgmpa->get_plugin_latest_version( $plugin_slug );
				} elseif ( $version === 'minimum' ) {
					$query_args['ver'] = $this->tgmpa->get_plugin_minimum_version( $plugin_slug );
				} else {
					$query_args['ver'] = $this->tgmpa->get_plugin_recommended_version( $plugin_slug );
				}
			}

			return wp_nonce_url(
				add_query_arg(
					$query_args,
					$this->tgmpa->get_tgmpa_url()
				),
				'tgmpa-' . $action,
				'tgmpa-nonce'
			);
		}

		/**
		 * Processes bulk installation and activation actions.
		 *
		 * The bulk installation process looks for the $_POST information and passes that
		 * through if a user has to use WP_Filesystem to enter their credentials.
		 *
		 * @since 2.2.0
		 */
		public function process_bulk_actions() {
			// Bulk installation process.
			if ( 'tgmpa-bulk-install' === $this->current_action() || 'tgmpa-bulk-update' === $this->current_action() ) {

				check_admin_referer( 'bulk-' . $this->_args['plural'] );

				$install_type = 'install';
				if ( 'tgmpa-bulk-update' === $this->current_action() ) {
					$install_type = 'update';
				}

				$plugins_to_install = array();

				// Did user actually select any plugins to install/update ?
				if ( empty( $_POST['plugin'] ) ) {
					if ( 'install' === $install_type ) {
						$message = __( 'No plugins were selected to be installed. No action taken.', 'tgmpa' );
					} else {
						$message = __( 'No plugins were selected to be updated. No action taken.', 'tgmpa' );
					}

					echo '<div id="message" class="error"><p>', esc_html( $message ), '</p></div>';

					return false;
				}

				if ( is_array( $_POST['plugin'] ) ) {
					$plugins_to_install = (array) $_POST['plugin'];
				} elseif ( is_string( $_POST['plugin'] ) ) {
					// Received via Filesystem page - un-flatten array (WP bug #19643).
					$plugins_to_install = explode( ',', $_POST['plugin'] );
				}

				// Sanitize the received input.
				$plugins_to_install = array_map( 'urldecode', $plugins_to_install );
				$plugins_to_install = array_map( array( $this->tgmpa, 'sanitize_key' ), $plugins_to_install );

				// Validate the received input.
				foreach ( $plugins_to_install as $key => $slug ) {
					// Check if the plugin was registered with TGMPA and remove if not.
					if ( ! isset( $this->tgmpa->plugins[ $slug ] ) ) {
						unset( $plugins_to_install[ $key ] );
						continue;
					}

					// For install: make sure this is a plugin we *can* install and not one already installed.
					if ( 'install' === $install_type && false === $this->tgmpa->is_plugin_installable( $slug ) ) {
						unset( $plugins_to_install[ $key ] );
					}

					// For updates: make sure this is a plugin we *can* update (update available and WP version ok).
					if ( 'update' === $install_type && false === $this->tgmpa->is_plugin_updatetable( $slug ) ) {
						unset( $plugins_to_install[ $key ] );
					}
				}

				// No need to proceed further if we have no plugins to handle.
				if ( empty( $plugins_to_install ) ) {
					if ( 'install' === $install_type ) {
						$message = __( 'No plugins are available to be installed at this time.', 'tgmpa' );
					} else {
						$message = __( 'No plugins are available to be updated at this time.', 'tgmpa' );
					}

					echo '<div id="message" class="error"><p>', esc_html( $message ), '</p></div>';

					return false;
				}

				// Pass all necessary information if WP_Filesystem is needed.
				$url = wp_nonce_url(
					$this->tgmpa->get_tgmpa_url(),
					'bulk-' . $this->_args['plural']
				);

				// Give validated data back to $_POST which is the only place the filesystem looks for extra fields.
				$_POST['plugin'] = implode( ',', $plugins_to_install ); // Work around for WP bug #19643.

				$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
				$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

				if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
					return true; // Stop the normal page form from displaying, credential request form will be shown.
				}

				// Now we have some credentials, setup WP_Filesystem.
				if ( ! WP_Filesystem( $creds ) ) {
					// Our credentials were no good, ask the user for them again.
					request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

					return true;
				}

				/* If we arrive here, we have the filesystem */

				// Store all information in arrays since we are processing a bulk installation.
				$names      = array();
				$sources    = array(); // Needed for installs.
				$file_paths = array(); // Needed for upgrades.
				$to_inject  = array(); // Information to inject into the update_plugins transient.

				// Prepare the data for validated plugins for the install/upgrade.
				foreach ( $plugins_to_install as $slug ) {
					$name   = $this->tgmpa->plugins[ $slug ]['name'];
					$source = $this->tgmpa->get_download_url( $slug );

					// Add requested plugin version.
					if ( $this->tgmpa->plugin_has_multiple_versions( $slug ) ) {
						if ( isset( $_POST['plugin_version'][ $slug ] ) ) {
							$requested_version = wp_unslash( $_POST['plugin_version'][ $slug ] );
						} else {
							$requested_version = $this->tgmpa->get_plugin_minimum_version( $slug );
						}

						$source = $this->tgmpa->add_plugin_version_query_arg( $source, $slug, $requested_version );
					}

					if ( ! empty( $name ) && ! empty( $source ) ) {
						$names[] = $name;

						switch ( $install_type ) {

							case 'install':
								$sources[] = $source;
								break;

							case 'update':
								$file_paths[]                 = $this->tgmpa->plugins[ $slug ]['file_path'];
								$to_inject[ $slug ]           = $this->tgmpa->plugins[ $slug ];
								$to_inject[ $slug ]['source'] = $source;
								break;
						}
					}
				}
				unset( $slug, $name, $source );

				// Create a new instance of TGMPA_Bulk_Installer.
				$installer = new The7_TGMPA_Bulk_Installer(
					new The7_TGMPA_Bulk_Installer_Skin(
						array(
							'url'          => esc_url_raw( $this->tgmpa->get_tgmpa_url() ),
							'nonce'        => 'bulk-' . $this->_args['plural'],
							'names'        => $names,
							'install_type' => $install_type,
						)
					)
				);

				// Wrap the install process with the appropriate HTML.
				echo '<div class="tgmpa">',
				'<h2 style="font-size: 23px; font-weight: 400; line-height: 29px; margin: 0; padding: 9px 15px 4px 0;">', esc_html( get_admin_page_title() ), '</h2>
					<div class="update-php" style="width: 100%; height: 98%; min-height: 850px; padding-top: 1px;">';

				// Process the bulk installation submissions.
				add_filter( 'upgrader_source_selection', array( $this->tgmpa, 'maybe_adjust_source_dir' ), 1, 3 );

				if ( 'tgmpa-bulk-update' === $this->current_action() ) {
					// Inject our info into the update transient.
					$this->tgmpa->inject_update_info( $to_inject );

					$installer->bulk_upgrade( $file_paths );
				} else {
					$installer->bulk_install( $sources );
				}

				remove_filter( 'upgrader_source_selection', array( $this->tgmpa, 'maybe_adjust_source_dir' ), 1 );

				echo '</div></div>';

				return true;
			}

			// Bulk activation process.
			if ( 'tgmpa-bulk-activate' === $this->current_action() ) {
				check_admin_referer( 'bulk-' . $this->_args['plural'] );

				// Did user actually select any plugins to activate ?
				if ( empty( $_POST['plugin'] ) ) {
					echo '<div id="message" class="error"><p>', esc_html__( 'No plugins were selected to be activated. No action taken.', 'tgmpa' ), '</p></div>';

					return false;
				}

				// Grab plugin data from $_POST.
				$plugins = array();
				if ( isset( $_POST['plugin'] ) ) {
					$plugins = array_map( 'urldecode', (array) $_POST['plugin'] );
					$plugins = array_map( array( $this->tgmpa, 'sanitize_key' ), $plugins );
				}

				$plugins_to_activate = array();
				$plugin_names        = array();

				// Grab the file paths for the selected & inactive plugins from the registration array.
				foreach ( $plugins as $slug ) {
					if ( $this->tgmpa->can_plugin_activate( $slug ) ) {
						$plugins_to_activate[] = $this->tgmpa->plugins[ $slug ]['file_path'];
						$plugin_names[]        = $this->tgmpa->plugins[ $slug ]['name'];
					}
				}
				unset( $slug );

				// Return early if there are no plugins to activate.
				if ( empty( $plugins_to_activate ) ) {
					echo '<div id="message" class="error"><p>', esc_html__( 'No plugins are available to be activated at this time.', 'tgmpa' ), '</p></div>';

					return false;
				}

				// Now we are good to go - let's start activating plugins.
				$activate = activate_plugins( $plugins_to_activate );

				if ( is_wp_error( $activate ) ) {
					echo '<div id="message" class="error"><p>', wp_kses_post( $activate->get_error_message() ), '</p></div>';
				} else {
					$count        = count( $plugin_names ); // Count so we can use _n function.
					$plugin_names = array_map( array( 'TGMPA_Utils', 'wrap_in_strong' ), $plugin_names );
					$last_plugin  = array_pop( $plugin_names ); // Pop off last name to prep for readability.
					$imploded     = empty( $plugin_names ) ? $last_plugin : ( implode( ', ', $plugin_names ) . ' ' . esc_html_x( 'and', 'plugin A *and* plugin B', 'tgmpa' ) . ' ' . $last_plugin );

					printf( // WPCS: xss ok.
						'<div id="message" class="updated"><p>%1$s %2$s.</p></div>',
						esc_html( _n( 'The following plugin was activated successfully:', 'The following plugins were activated successfully:', $count, 'tgmpa' ) ),
						$imploded
					);

					// Update recently activated plugins option.
					$recent = (array) get_option( 'recently_activated' );
					foreach ( $plugins_to_activate as $plugin => $time ) {
						if ( isset( $recent[ $plugin ] ) ) {
							unset( $recent[ $plugin ] );
						}
					}
					update_option( 'recently_activated', $recent );
				}

				unset( $_POST ); // Reset the $_POST variable in case user wants to perform one action after another.

				return true;
			}

			return false;
		}
	}
}