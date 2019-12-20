<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

require_once THE7_RWMB_FIELDS_DIR . 'file.php';
if ( ! class_exists( 'THE7_RWMB_File_Advanced_Field' ) )
{
	class THE7_RWMB_File_Advanced_Field extends THE7_RWMB_File_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			static $vars_localized;

			parent::admin_enqueue_scripts();

			// Make sure scripts for new media uploader in WordPress 3.5 is enqueued
			wp_enqueue_media();
			wp_enqueue_script( 'the7-mb-file-advanced', THE7_RWMB_JS_URL . 'file-advanced.js', array( 'jquery', 'underscore' ), THE7_RWMB_VER, true );
			if ( ! $vars_localized ) {
				wp_localize_script( 'the7-mb-file-advanced', 'the7mbFileAdvanced', array(
					'frameTitle' => __( 'Select Files', 'the7mk2' ),
				) );
				$vars_localized = true;
			}
		}

		/**
		 * Add actions
		 *
		 * @return void
		 */
		static function add_actions()
		{
			parent::add_actions();

			// Attach images via Ajax
			add_action( 'wp_ajax_the7_mb_attach_file', array( __CLASS__, 'wp_ajax_attach_file' ) );
			add_action( 'print_media_templates', array( __CLASS__, 'print_templates' ) );
		}

		static function wp_ajax_attach_file()
		{
			$post_id = is_numeric( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : 0;
			$field_id = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$attachment_ids = isset( $_POST['attachment_ids'] ) ? $_POST['attachment_ids'] : array();

			check_ajax_referer( "the7-mb-attach-file_{$field_id}" );
			foreach( $attachment_ids as $attachment_id )
				update_post_meta( $post_id, $field_id, $attachment_id );

			wp_send_json_success();
		}


		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$i18n_title  = apply_filters( 'the7_mb_file_advanced_select_string', _x( 'Select or Upload Files', 'file upload', 'the7mk2' ), $field );
			$attach_nonce = wp_create_nonce( "the7-mb-attach-file_{$field['id']}" );

			// Uploaded files
			$html = self::get_uploaded_files( $meta, $field );

			// Show form upload
			$classes = array( 'button', 'the7-mb-file-advanced-upload', 'hide-if-no-js', 'new-files' );
			if ( ! empty( $field['max_file_uploads'] ) && count( $meta ) >= (int) $field['max_file_uploads'] )
				$classes[] = 'hidden';

			$classes = implode( ' ', $classes );
			$html .= "<a href='#' class='{$classes}' data-attach_file_nonce={$attach_nonce}>{$i18n_title}</a>";

			return $html;
		}

		/**
		 * Get field value
		 * It's the combination of new (uploaded) images and saved images
		 *
		 * @param array $new
		 * @param array $old
		 * @param int   $post_id
		 * @param array $field
		 *
		 * @return array|mixed
		 */
		static function value( $new, $old, $post_id, $field )
		{
			$new = (array) $new;
			return array_unique( array_merge( $old, $new ) );
		}

		static function save( $new, $old, $post_id, $field ) {
		    if ( $new === null ) {
		        return;
            }

			$name = $field['id'];
			update_post_meta( $post_id, $name, $new );
        }

		static function print_templates()
		{
			$i18n_delete = apply_filters( 'the7_mb_file_delete_string', _x( 'Delete', 'file upload', 'the7mk2' ) );
			$i18n_edit   = apply_filters( 'the7_mb_file_edit_string', _x( 'Edit', 'file upload', 'the7mk2' ) );
			?>
            <script id="tmpl-the7-mb-file-advanced" type="text/html">
				<li>
					<div class="the7-mb-icon"><img src="{{ data.attachment.icon }}"></div>
					<div class="the7-mb-info">
						<a href="{{ data.attachment.url }}" target="_blank">{{ data.attachment.title }}</a>
						<p>{{ data.attachment.mime }}</p>
						<a title="<?php echo $i18n_edit; ?>" href="{{ data.attachment.editLink }}" target="_blank"><?php echo $i18n_edit; ?></a> |
						<a title="<?php echo $i18n_delete; ?>" class="the7-mb-delete-file" href="%" data-attachment_id="{{ data.attachment.id }}"><?php echo $i18n_delete; ?></a>
					</div>
				</li>
			</script>
            <?php
		}
	}
}
