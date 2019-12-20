<?php
/**
 * Legacy module.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Presscore_Modules_Legacy' ) ) :

	class Presscore_Modules_Legacy {

		/**
		 * Legacy settings ids.
		 *
		 * @var array
		 */
		static $settings = array();

		/**
		 * Execute module.
		 */
		public static function execute() {
			self::$settings = array(
				'rows',
				'admin-icons-bar',
			    'overlapping-headers',
			);

			if ( dt_the7_core_is_enabled() ) {
				self::$settings = array_merge( self::$settings, array(
					'benefits',
					'logos',
					'portfolio-layout',
				) ) ;
			}

			self::handle_legacy_code();
		}

		/**
		 * Handle legacy code hideout.
		 */
		public static function handle_legacy_code() {
			$base_dir = dirname( __FILE__ );

			foreach ( self::$settings as $id ) {
				if ( The7_Admin_Dashboard_Settings::get( $id ) ) {
					continue;
				}

				$file_name = "{$base_dir}/legacy-{$id}.php";
				if ( file_exists( $file_name ) ) {
					include $file_name;
				}

				$class_name = self::get_class_name( $id );

				if ( class_exists( $class_name ) && is_callable( array( $class_name, 'launch' ) ) ) {
					call_user_func( array( $class_name, 'launch' ) );
				}
			}
		}

		/**
		 * Prepare legacy handler class name.
		 *
		 * @param string $id
		 *
		 * @return string
		 */
		protected static function get_class_name( $id ) {
			$class_name = 'Presscore_Modules_Legacy_';
			$class_name .= implode( '_', array_map( array( __CLASS__, 'sanitize_handler_class_name' ), explode( '-', $id ) ) );

			return $class_name;
		}

		/**
		 * Sanitize class name part.
		 *
		 * @param string $name
		 *
		 * @return string
		 */
		public static function sanitize_handler_class_name( $name ) {
			return ucfirst( strtolower( $name ) );
		}

		/**
		 * Returns true if legacy mode is active.
		 *
		 * @return bool
		 */
		public static function is_legacy_mode_active() {
			// Do not count icons-bar.
			$settings = array_diff( self::$settings, array( 'admin-icons-bar' ) );

			foreach ( $settings as $id ) {
				if ( The7_Admin_Dashboard_Settings::get( $id ) ) {
					return true;
				}
			}

			return false;
		}
	}

	Presscore_Modules_Legacy::execute();

endif;