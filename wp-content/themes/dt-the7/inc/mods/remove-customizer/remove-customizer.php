<?php
/**
 * "Remove Customizer" Module
 * Inspired by https://wordpress.org/plugins/customizer-remove-all-parts
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Presscore_Modules_Remove_Customizer_Module', false ) ) :

	class Presscore_Modules_Remove_Customizer_Module {

		/**
		 * Execute module.
		 */
		public static function execute() {
			add_action( 'load-themes.php', array( __CLASS__, 'add_load_themes_hooks' ) );
			add_action( 'wp_before_admin_bar_render', array(
				__CLASS__,
				'remove_wp_customize_support_script_from_admin_bar'
			), 9 );
		}

		/**
		 * Add hooks for themes.php admin page.
		 */
		public static function add_load_themes_hooks() {
		    add_action( 'admin_enqueue_scripts', array( __CLASS__, 'hide_customizer_buttons' ) );
        }

		/**
		 * Add inline css to hide Customizer buttons for active The7 theme.
		 */
        public static function hide_customizer_buttons() {
            // Do not hide Customizer for a child themes.
		    if ( is_child_theme() ) {
		        return;
            }

		    wp_add_inline_style( 'the7-admin', '
                /** Hide Customizer button on themes.php page for active dt-the7 theme **/
                .theme.active > .theme-id-container > .theme-actions {
					box-shadow: none;
					background: none
				}
                .theme.active .hide-if-no-customize,
                .theme-overlay.active .active-theme .hide-if-no-customize {
                    display: none;
                }
            ' );
        }

		/**
		 * Hide customizer in admin bar.
         *
         * @see wp_customize_support_script
		 */
		public static function remove_wp_customize_support_script_from_admin_bar() {
			remove_action( 'wp_before_admin_bar_render', 'wp_customize_support_script' );
		}
	}

	Presscore_Modules_Remove_Customizer_Module::execute();

endif;