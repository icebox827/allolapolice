<?php

defined( 'ABSPATH' ) || exit;

class The7_Option_Field_Upload extends The7_Option_Field_Abstract {

	public function html() {
		$mode   = empty( $this->option['mode'] ) ? 'uri_only' : $this->option['mode'];
		$_desc  = empty( $this->option['dec'] ) ? '' : $this->option['dec'];
		$id     = $this->option['id'];
		$output = '';
		$att_id = 0;

		// If a value is passed and we don't have a stored value, use the value that's passed through.
		if ( is_array( $this->val ) ) {
			$att_id = empty( $this->val[1] ) ? 0 : absint( $this->val[1] );
			$val    = empty( $this->val[0] ) ? '' : (string) $this->val[0];
		} else {
			$val = (string) $this->val;
		}

		$uploader_name = $this->option_name;

		// Construct array of [ 'id', 'uri' ].
		if ( 'full' === $mode ) {
			$uploader_name .= '[uri]';
			$output        .= '<input type="hidden" class="upload-id" name="' . $this->option_name . '[id]" value="' . $att_id . '" />' . "\n";
		}

		$class = '';
		if ( $val ) {
			$class = 'has-file';
		}
		$output .= '<input id="' . $id . '" class="upload ' . $class . '" type="text" name="' . $uploader_name . '" value="' . $val . '" placeholder="' . __( 'No file chosen', 'the7mk2' ) . '" readonly="readonly"/>' . "\n";

		if ( $val ) {
			$output .= '<input id="remove-' . $id . '" class="remove-file uploader-button button" type="button" value="' . esc_attr__( 'Remove', 'the7mk2' ) . '" />' . "\n";
		} else {
			$output .= '<input id="upload-' . $id . '" class="upload-button uploader-button button" type="button" value="' . esc_attr__( 'Upload', 'the7mk2' ) . '" />' . "\n";
		}

		if ( $_desc ) {
			$output .= '<span class="of-metabox-desc">' . esc_html( $_desc ) . '</span>' . "\n";
		}

		$output .= '<div class="screenshot" id="' . $id . '-image">' . "\n";

		if ( $val ) {
			$remove = '<a class="remove-image">Remove</a>';

			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $val );
			if ( $image ) {
				$output .= '<img src="' . esc_attr( dt_get_of_uploaded_image( $val ) ) . '" alt="' . esc_attr( __( 'Image preview', 'the7mk2' ) ) . '" />' . $remove;
			} else {
				// Standard generic output if it's not an image.
				$output .= '<div class="no-image"><span class="file_link"><a href="' . esc_attr( $val ) . '" target="_blank" rel="external">' . esc_html__( 'View File', 'the7mk2' ) . '</a></span></div>';
			}
		}
		$output .= '</div>' . "\n";

		return $output;
	}
}