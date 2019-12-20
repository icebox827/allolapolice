<?php
/**
 * The7 mega menu admin class.
 *
 * @since   3.0.0
 *
 * @package The7\Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Admin_Mega_Menu
 */
class The7_Admin_Mega_Menu {

	const MENU_ITEM_SETTINGS_NAME = '_menu_item_the7_mega_menu_settings';

	/**
	 * Return array of mega menu options.
	 *
	 * @return array
	 */
	protected function mega_menu_settings_definition() {
		return require dirname( __FILE__ ) . '/mega-menu-options.php';
	}

	/**
	 * Setup custom menu item fields before output.
	 *
	 * @param object $menu_item The menu item object.
	 *
	 * @return object
	 */
	public function wp_setup_nav_menu_item( $menu_item ) {
		$menu_item->the7_mega_menu = get_post_meta( $menu_item->ID, self::MENU_ITEM_SETTINGS_NAME, true );

		return $menu_item;
	}

	/**
	 * Update custom menu item fields.
	 *
	 * @param int $menu_id         ID of the updated menu.
	 * @param int $menu_item_db_id ID of the updated menu item.
	 */
	public function wp_update_nav_menu_item( $menu_id, $menu_item_db_id ) {
		if ( ! empty( $_POST[ self::MENU_ITEM_SETTINGS_NAME ][ $menu_item_db_id ] ) ) {
			$mega_menu_settings = optionsframework_sanitize_options_values(
				$this->mega_menu_settings_definition(),
				json_decode(
					wp_unslash(
						$_POST[ self::MENU_ITEM_SETTINGS_NAME ][ $menu_item_db_id ]
					),
					$assoc = true
				)
			);

			update_post_meta( $menu_item_db_id, self::MENU_ITEM_SETTINGS_NAME, $mega_menu_settings );
		}
	}

	/**
	 * Render modal window content placeholder. Later on, theme options HTML would be placed inside
	 * .presscore-modal-content with ajax callback.
	 */
	public function output_popup_template() {
		?>

		<div id="the7-mega-menu-settings" class="popupContainer" style="display: none"></div>

		<?php
	}

	/**
	 * Ajax callback that renders theme options HTML.
	 */
	public function ajax_render_mega_menu_settings() {
		$item_depth    = isset( $_POST['item_depth'] ) ? (int) $_POST['item_depth'] : 0;
		$item_id       = isset( $_POST['item_id'] ) ? (int) $_POST['item_id'] : 0;
		$item_settings = isset( $_POST['item_settings'] ) ? (array) json_decode(
			wp_unslash( $_POST['item_settings'] ),
			true
		) : array();
		if ( ! $item_settings && $item_id ) {
			$item_settings = (array) get_post_meta( $item_id, self::MENU_ITEM_SETTINGS_NAME, $single = true );
		}
		$parent_mega_menu = isset( $_POST['parent_mega_menu'] ) ? $_POST['parent_mega_menu'] : 'off';
		$parent_id        = isset( $_POST['parent_id'] ) ? (int) $_POST['parent_id'] : 0;
		if ( ! $parent_mega_menu && $parent_id ) {
			$parent_settings  = get_post_meta( $parent_id, self::MENU_ITEM_SETTINGS_NAME, $single = true );
			$parent_mega_menu = isset( $parent_settings['mega-menu'] ) ? $parent_settings['mega-menu'] : 'off';
		}

		$of_interface  = new The7_Options( $this->mega_menu_settings_definition() );
		$item_settings = optionsframework_sanitize_options_values(
			$this->mega_menu_settings_definition(),
			$item_settings
		);
		?>

		<div id="optionsframework" class="optionsframework">
			<input type="hidden" id="section-item-depth" class="section" value="" data-value="<?php echo esc_attr( $item_depth ); ?>"></input>
			<input type="hidden" id="section-parent-mega-menu" class="section" value="" data-value="<?php echo esc_attr( $parent_mega_menu ); ?>"></input>
			<?php $of_interface->render_options_html( 'the7-mega-menu', $item_settings ); ?>
		</div>

		<?php

		exit;
	}

	/**
	 * Enqueue theme options and mega menu related scripts and styles.
	 */
	public function admin_enqueue_scripts() {
		// Collect dependencies.
		foreach ( $this->mega_menu_settings_definition() as $option ) {
			if ( isset( $option['id'], $option['dependency'] ) ) {
				optionsframework_fields_dependency()->set( $option['id'], $option['dependency'] );
			}
		}

		optionsframework_load_styles();
		optionsframework_load_scripts();
		of_localize_scripts();

		the7_register_style( 'the7-mega-menu', PRESSCORE_ADMIN_URI . '/assets/css/the7-mega-menu' );
		the7_register_script( 'the7-mega-menu', PRESSCORE_ADMIN_URI . '/assets/js/the7-mega-menu', array(), false, true );
		wp_enqueue_script( 'the7-mega-menu' );
		wp_enqueue_style( 'the7-mega-menu' );

		wp_localize_script(
			'the7-mega-menu',
			'the7MegaMenuTemplates',
			array(
				'megaMenuButton'             => '<button type="button" class="button button-primary the7-options-tb-popup" data-popup-id="the7-mega-menu-settings">' . esc_html_x( 'The7 Mega Menu', 'admin', 'the7mk2' ) . '</button>',
				'itemSettingsStorageElement' => '<input type="hidden" class="the7-mega-menu-settings" name="' . self::MENU_ITEM_SETTINGS_NAME . '[%itemID%]" value="">',
				'popupBottomBar'             => '<div class="optionsframework-submit"><a href="#closeTB" class="button-primary">' . esc_html_x( 'Change and close', 'admin', 'the7mk2' ) . '</a></div>',
				'popupTitle'                 => esc_html_x( 'The7 Mega Menu', 'admin', 'the7mk2' ),
			)
		);
	}
}
