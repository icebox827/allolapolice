<?php

if ( ! class_exists( 'Presscore_Modules_Posts_Defaults', false ) ) {

	class Presscore_Modules_Posts_Defaults {

		public static function execute() {
			// Bail for not admin screens.
			if ( ! is_admin() ) {
				return;
			}

			include_once dirname( __FILE__ ) . '/class-the7-post-meta-preset.php';
			include_once dirname( __FILE__ ) . '/interface-the7-post-meta-data-provider.php';
			include_once dirname( __FILE__ ) . '/class-the7-post-meta-wp-provider.php';
			include_once dirname( __FILE__ ) . '/class-the7-post-meta-wp-sanitizer.php';
			include_once dirname( __FILE__ ) . '/class-the7-post-meta-defaults.php';

			// Add meta boxes.
			add_action( 'load-post.php', array( __CLASS__, 'add_meta_box_actions' ) );

			// Handle ajax.
			add_action( 'wp_ajax_the7_meta_preset', array( __CLASS__, 'handle_meta_presets_ajax_action' ) );

			// Handle bulk actions.
			add_action( 'bulk_edit_custom_box', array( __CLASS__, 'bulk_actions' ), 10, 2 );
			add_action( 'quick_edit_custom_box', array( __CLASS__, 'bulk_actions' ), 10, 2 );
			add_action( 'save_post', array( __CLASS__, 'handle_bulk_action' ), 10, 2 );

			// Replace box defaults.
			add_action( 'the7_before_meta_box_registration', array( __CLASS__, 'replace_box_defaults' ) );

			add_action( 'admin_print_styles-post.php', array( __CLASS__, 'localize_js_data' ), 5 );
		}

		public static function localize_js_data() {
		    $strings = array(
                'enterName' => __( 'Enter preset name', 'the7mk2' ),
                'presetSaved' => __( 'Preset saved', 'the7mk2' ),
                'defaultsSaved' => __( 'Defaults saved', 'the7mk2' ),
                'applyingPreset' => __( 'Applying preset ...', 'the7mk2' ),
            );
            wp_localize_script( 'the7-meta-box-magic', 'the7MetaPresetsStrings', $strings );

            $nonces = array(
                '_ajax_nonce' => wp_create_nonce( 'the7-meta-presets' ),
            );
			wp_localize_script( 'the7-meta-box-magic', 'the7MetaPresetsNonces', $nonces );
		}

		public static function handle_meta_presets_ajax_action() {
		    if ( ! check_ajax_referer( 'the7-meta-presets', false, false ) ) {
			    wp_send_json_error( array( 'msg' => __( 'Seems that you use expired or incorrect nonce. Please reload the page and try again.', 'the7mk2' ) ) );
            }

            $action = ( isset( $_POST['preset_action'] ) ? sanitize_key( $_POST['preset_action'] ) : '' );
			$post_id = ( isset( $_POST['postID'] ) ? absint( $_POST['postID'] ) : null );
			$id = ( isset( $_POST['id'] ) ? absint( $_POST['id'] ) : null );
			$title = ( isset( $_POST['title'] ) ? $_POST['title'] : '' );
			$meta = ( isset( $_POST['meta'] ) ? $_POST['meta'] : array() );
			$response = array();

			try {
			    switch ( $action ) {
                    case 'add_preset':
                        $new_presets_names = self::add_preset( $post_id, $title, $meta );
                        $response = array( 'presetsNames' => $new_presets_names );
                        break;
                    case 'save_preset':
                        self::save_preset( $post_id, $id, $meta );
                        break;
                    case 'apply_preset':
                        self::apply_preset( $post_id, $id );
                        break;
				    case 'delete_preset':
					    $new_presets_names = self::delete_preset( $post_id, $id );
					    $response = array( 'presetsNames' => $new_presets_names );
					    break;
                    case 'save_defaults':
                        self::save_defaults( $post_id, $meta );
                        break;
                    default:
	                    wp_send_json_error( array( 'msg' => __( "Invalid action: {$action}" , 'the7mk2' ) ) );
                }
			} catch ( Exception $e ) {
				wp_send_json_error( array( 'msg' => $e->getMessage() ) );
			}

			wp_send_json_success( $response );
		}

		public static function add_preset( $post_id, $title, $meta ) {
			$meta = wp_list_pluck( $meta, 'value', 'name' );
			$post_type = get_post_type( $post_id );
			$wp_provider = self::new_post_meta_wp_provider( $post_type );
			$preset = new The7_Post_Meta_Preset( $wp_provider );
			$preset->set_meta( The7_Post_Meta_WP_Sanitizer::sanitize_meta( $meta, $post_id ) );
			$preset->set_title( The7_Post_Meta_WP_Sanitizer::sanitize_title( $title ) );
			$preset->save();

			return self::prepare_presets_names_for_output( $wp_provider->get_presets_names() );
		}

		public static function save_preset( $post_id, $id, $meta ) {
			$meta = wp_list_pluck( $meta, 'value', 'name' );
			$post_type = get_post_type( $post_id );
			$wp_provider = self::new_post_meta_wp_provider( $post_type );
			$preset = new The7_Post_Meta_Preset( $wp_provider, $id );
			$preset->set_meta( The7_Post_Meta_WP_Sanitizer::sanitize_meta( $meta, $post_id ) );
			$preset->delete();
			$preset->save();
		}

		public static function apply_preset( $post_id, $id ) {
			$post_type = get_post_type( $post_id );
			$wp_provider = self::new_post_meta_wp_provider( $post_type );
			$preset = new The7_Post_Meta_Preset( $wp_provider, $id );
			$preset->apply_to_post( $post_id );
		}

		public static function delete_preset( $post_id, $id ) {
			$post_type = get_post_type( $post_id );
			$wp_provider = self::new_post_meta_wp_provider( $post_type );
			$preset = new The7_Post_Meta_Preset( $wp_provider, $id );
			$preset->delete();

			return self::prepare_presets_names_for_output( $wp_provider->get_presets_names() );
		}

		public static function save_defaults( $post_id, $meta ) {
			$meta = wp_list_pluck( $meta, 'value', 'name' );
			$post_type = get_post_type( $post_id );
			$defaults = new The7_Post_Meta_Defaults( $post_type );
			$defaults->set( The7_Post_Meta_WP_Sanitizer::sanitize_meta( $meta, $post_id ) );
        }

		public static function new_post_meta_wp_provider( $post_type ) {
			$post_type = sanitize_key( $post_type );

			return new The7_Post_Meta_WP_Provider(
				"the7_{$post_type}_presets",
				"the7_{$post_type}_presets_names"
			);
		}

		public static function prepare_presets_names_for_output( $names ) {
			$escaped_names = array();
			foreach ( $names as $id => $name ) {
				$escaped_names[] = array( 'id' => $id, 'name' => $name );
			}

			if ( empty( $escaped_names ) ) {
				$escaped_names[] = array( 'id' => '', 'name' => _x( '-- No presets --', 'admin', 'the7mk2' ) );
			}

			return array_reverse( $escaped_names );
		}

		/**
		 * Add meta box actions.
		 */
		public static function add_meta_box_actions() {
			add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
        }

		/**
		 * Add the meta box.
		 */
		public static function add_meta_box() {
			add_meta_box( 'the7-post-meta-presets-box', __( 'Settings Presets', 'the7mk2' ), array(
				__CLASS__,
				'render_meta_box',
			), presscore_get_pages_with_basic_meta_boxes(), 'side', 'default' );
		}

		/**
		 * Render the meta box.
		 */
		public static function render_meta_box( $post ) {
			?>

            <p>
                <select id="the7-post-meta-presets" name="_the7_post_meta_presets">
					<?php
					$presets_provider = self::new_post_meta_wp_provider( $post->post_type );
					$presets_names = self::prepare_presets_names_for_output( $presets_provider->get_presets_names() );

					foreach ( $presets_names as $preset_name ) {
						printf( '<option value="%1$s">%2$s</option>', $preset_name['id'], $preset_name['name'] );
					}
					?>
                </select>
            </p>
			<?php
			$preset_action_status = '';
			if ( $presets_names[0]['id'] === '' ) {
				$preset_action_status = 'disabled="disabled"';
			}
			?>
            <p id="the7-post-meta-presets-actions">
                <button type="button" id="the7-post-meta-add-preset" class="button button-secondary"><?php esc_html_e( 'Create new', 'the7mk2' ) ?></button>
                <button type="button" id="the7-post-meta-save-preset" class="button button-primary" <?php echo $preset_action_status ?>><?php esc_html_e( 'Save', 'the7mk2' ) ?></button>
                <button type="button" id="the7-post-meta-delete-preset" class="button button-secondary" <?php echo $preset_action_status ?>><?php esc_html_e( 'Delete', 'the7mk2' ) ?></button>
            </p>
            <div class="the7-mb-field the7-mb-heading-wrapper"><div class="dt_hr dt_hr-top"></div><h4><?php esc_html_e( 'Preset Actions', 'the7mk2' ) ?></h4></div>
            <p>
                <button type="button" id="the7-post-meta-save-defaults" class="button button-secondary"><?php esc_html_e( 'Save as default', 'the7mk2' ) ?></button>
                <button type="button" id="the7-post-meta-apply-preset" class="button button-primary" <?php echo $preset_action_status ?>><?php esc_html_e( 'Apply to page', 'the7mk2' ) ?></button>
            </p>

			<?php
		}

		public static function bulk_actions( $column, $type ) {
			$post_types = presscore_get_pages_with_basic_meta_boxes();

			// Display for one custom column.
			if ( 'presscore-sidebar' !== $column || ! in_array( $type, $post_types ) ) {
				return;
			}
			?>
			<div class="presscore-bulk-actions">
				<fieldset class="inline-edit-col-left dt-inline-edit-sidebars">
					<legend class="inline-edit-legend"><?php _ex( 'Apply setting preset', 'backend bulk edit', 'the7mk2' ) ?></legend>
                    <p><small><?php echo esc_html_x( 'To apply setting preset just select one from the list below and press Update button.', 'backend bulk edit', 'the7mk2' ) ?></small></p>
					<div class="inline-edit-col">
						<div class="inline-edit-group">
							<label class="alignleft">
								<span class="title"><?php _ex( 'Setting preset', 'backend bulk edit', 'the7mk2' ) ?></span>
								<select name="_dt_bulk_apply_post_meta_preset">
                                    <option value="-1"><?php _ex( '&mdash; No Change &mdash;', 'backend bulk edit', 'the7mk2' ) ?></option>
									<?php
									$presets_provider = self::new_post_meta_wp_provider( $type );
									$presets_names = self::prepare_presets_names_for_output( $presets_provider->get_presets_names() );

									foreach ( $presets_names as $preset_name ) {
									    // Exclude empty array filler. We have a default value above.
									    if ( '' === $preset_name['id'] ) {
									        continue;
                                        }

										printf( '<option value="%1$s">%2$s</option>', $preset_name['id'], $preset_name['name'] );
									}
									?>
								</select>
							</label>
						</div>
					</div>
				</fieldset>
			</div>
			<?php
		}

		public static function handle_bulk_action( $post_id, $post ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! self::check_bulk_action() && ! self::check_quick_editor_action() ) {
			    return;
            }

			// Check permissions.
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

            // update sidebar
            if ( isset( $_REQUEST['_dt_bulk_apply_post_meta_preset'] ) && '-1' != $_REQUEST['_dt_bulk_apply_post_meta_preset'] ) {
	            $wp_provider = self::new_post_meta_wp_provider( $post->post_type );
	            $preset = new The7_Post_Meta_Preset( $wp_provider, $_REQUEST['_dt_bulk_apply_post_meta_preset'] );
	            $preset->apply_to_post( $post_id );
            }
		}

		protected static function check_quick_editor_action() {
			// Verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times.
			if ( ! check_ajax_referer( 'inlineeditnonce', '_inline_edit', false ) ) {
				return false;
			}

			return true;
        }

		protected static function check_bulk_action() {
			// Verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times.
			if ( ! check_ajax_referer( 'bulk-posts', false, false ) ) {
				return false;
			}

			if ( ! isset( $_REQUEST['bulk_edit'] ) ) {
				return false;
			}

			return true;
        }

		public static function replace_box_defaults() {
			if ( defined( 'DOING_AJAX' ) ) {
				return;
			}

			global $DT_META_BOXES;

			if ( isset( $_GET['post'] ) ) {
				$post_id = (int) $_GET['post'];
			} elseif ( isset( $_POST['post_ID'] ) ) {
				$post_id = (int) $_POST['post_ID'];
			} else {
				$post_id = 0;
			}

			if ( $post_id ) {
				$post_type = get_post_type( $post_id );
			} elseif ( isset( $_GET['post_type'] ) ) {
				$post_type = $_GET['post_type'];
			} else {
				$post_type = 'post';
			}

			if ( ! post_type_exists( $post_type ) ) {
				return;
			}

			$defaults = new The7_Post_Meta_Defaults( $post_type );
			$post_meta_defaults = $defaults->get();
			if ( empty( $post_meta_defaults ) ) {
				return;
			}

			foreach ( $DT_META_BOXES as $meta_id => $meta_box ) {
				foreach ( $DT_META_BOXES[ $meta_id ]['fields'] as $key => &$field ) {
					$field_id = $field['id'];

					if ( array_key_exists( $field_id, $post_meta_defaults ) ) {
						$field['std'] = $post_meta_defaults[ $field_id ];
					}
				}
			}
        }
	}

	Presscore_Modules_Posts_Defaults::execute();
}