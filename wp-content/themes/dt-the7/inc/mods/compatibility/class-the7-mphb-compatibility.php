<?php
/**
 * Compatibility class for Hotel Booking Lite plugin
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_MPHB_Compatibility
 */
class The7_MPHB_Compatibility {

	/**
	 * Main method.
	 */
	public function bootstrap() {
		add_filter( 'presscore_pages_with_basic_meta_boxes', array( $this, 'add_default_meta_boxes' ) );
		add_filter( 'mphb_template_path', array( $this, 'override_mphb_template_path' ) );
		add_filter( 'presscore_get_dynamic_stylesheets_list', array( $this, 'add_dynamic_stylesheets' ) );

		// Remove calendar.
		remove_action( 'mphb_render_single_room_type_content', array( '\MPHB\Views\SingleRoomTypeView', 'renderCalendar' ), 60 );
		remove_action( 'mphb_render_single_room_type_metas', array( '\MPHB\Views\SingleRoomTypeView', 'renderCalendar' ), 40 );

		add_action( 'mphb_render_single_room_type_metas', array( $this, 'single_template_open_attributes_and_form_wrap' ), 18 );

		// Attributes wrap.
		add_action( 'mphb_render_single_room_type_metas', array( $this, 'single_template_open_attributes_wrap' ), 19 );
		add_action( 'mphb_render_single_room_type_metas', array( $this, 'single_template_close_wrap' ), 31 );

		// Reservation form wrap.
		add_action( 'mphb_render_single_room_type_before_reservation_form', array( $this, 'single_template_open_reservation_form_wrap' ), 9 );
		add_action( 'mphb_render_single_room_type_after_reservation_form', array( $this, 'single_template_close_wrap' ), 11 );

		// Move facilities outside of attributes list.
		remove_action( 'mphb_render_single_room_type_attributes', array( '\MPHB\Views\SingleRoomTypeView', 'renderFacilities' ), 30 );
		add_action( 'mphb_render_single_room_type_metas', array( '\MPHB\Views\SingleRoomTypeView', 'renderFacilities' ), 35 );

		// Make separate list from facilities.
		remove_action( 'mphb_render_single_room_type_before_facilities', array( '\MPHB\Views\SingleRoomTypeView', '_renderFacilitiesListItemOpen' ), 10 );
		add_action( 'mphb_render_single_room_type_before_facilities', array( $this, 'render_facilities_list_item_open' ), 10 );

		remove_action( 'mphb_render_single_room_type_before_facilities', array( '\MPHB\Views\SingleRoomTypeView', '_renderAttributesListItemValueHolderOpen' ), 30 );
		remove_action( 'mphb_render_single_room_type_after_facilities', array( '\MPHB\Views\SingleRoomTypeView', '_renderAttributesListItemValueHolderClose' ), 10 );

		remove_action( 'mphb_render_single_room_type_after_facilities', array( '\MPHB\Views\SingleRoomTypeView', '_renderFacilitiesListItemClose' ), 20 );
		add_action( 'mphb_render_single_room_type_after_facilities', array( $this, 'render_facilities_list_item_close' ), 20 );

		add_action( 'mphb_render_single_room_type_metas', array( $this, 'single_template_close_wrap' ), 51 );

		// Adjust single room gallery imga size.
		add_filter( 'mphb_single_room_type_gallery_image_size', array( $this, 'single_room_type_gallery_size' ) );
		add_filter( 'mphb_loop_room_type_gallery_nav_slider_image_size', array( $this, 'single_room_type_gallery_size' ) );

		add_image_size( 'the7_mphb_gallery_image_size', 200, 125, true );

		// Override themes archive loop.
		add_filter( 'the7_mphb_room_type_archive_loop', array( $this, 'archive_loop' ) );
	}

	/**
	 * Add default meta boxes for plugin main post type `mphb_room_type`.
	 *
	 * @param array $post_types List of post types with default meta boxes.
	 *
	 * @return array
	 */
	public function add_default_meta_boxes( $post_types ) {
		$post_types[] = 'mphb_room_type';

		return $post_types;
	}

	/**
	 * Override MPHB theme template path.
	 *
	 * @return string
	 */
	public function override_mphb_template_path() {
		return 'inc/mods/compatibility/mphb-templates/';
	}

	/**
	 * Import plugin related less files to the custom.css.
	 *
	 * @param array $stylesheets Dynamic stylesheets array.
	 *
	 * @return array
	 */
	public function add_dynamic_stylesheets( $stylesheets ) {
		if ( isset( $stylesheets['dt-custom']['imports']['dynamic_import_bottom'] ) ) {
			$stylesheets['dt-custom']['imports']['dynamic_import_bottom'][] = 'compatibility/mph-booking.less';
		}

		return $stylesheets;
	}

	/**
	 * Render open tag for attributes and form wrap.
	 */
	public function single_template_open_attributes_and_form_wrap() {
		echo '<div class="room-type-content">';
	}

	/**
	 * Render open tag for attributes wrap.
	 */
	public function single_template_open_attributes_wrap() {
		echo '<div class="mphb-details-wrap">';
	}

	/**
	 * Render open tag for reservation form wrap.
	 */
	public function single_template_open_reservation_form_wrap() {
		echo '<div class="mphb-reservation-form-wrap">';
	}

	/**
	 * Render close tag for wrap.
	 */
	public function single_template_close_wrap() {
		echo '</div>';
	}

	/**
	 * Render facilities list open tag.
	 */
	public function render_facilities_list_item_open() {
		echo '<div class="mphb-room-type-facilities">';
	}

	/**
	 * Render facilities list close tag.
	 */
	public function render_facilities_list_item_close() {
		echo '</div>';
	}

	/**
	 * Override single room gallery image size to 320x200.
	 *
	 * @param string|array $size Image size.
	 *
	 * @return array
	 */
	public function single_room_type_gallery_size( $size ) {
		return 'the7_mphb_gallery_image_size';
	}

	/**
	 * Use MPHB native loop to display archive.
	 *
	 * @return bool
	 */
	public function archive_loop() {
		$room_query = $GLOBALS['wp_the_query'];

		if ( $room_query->have_posts() ) {

			do_action( 'mphb_sc_rooms_before_loop', $room_query );

			while ( $room_query->have_posts() ) {
				$room_query->the_post();

				do_action( 'mphb_sc_rooms_before_item' );

				$template_atts = array(
					'isShowGallery'    => true,
					'isShowImage'      => true,
					'isShowTitle'      => true,
					'isShowExcerpt'    => true,
					'isShowDetails'    => true,
					'isShowPrice'      => true,
					'isShowViewButton' => true,
					'isShowBookButton' => true,
				);
				mphb_get_template_part( 'shortcodes/rooms/room-content', $template_atts );

				do_action( 'mphb_sc_rooms_after_item' );

			}

			wp_reset_postdata();

			do_action( 'mphb_sc_rooms_after_loop', $room_query );

			return true;
		}

		return false;
	}
}
