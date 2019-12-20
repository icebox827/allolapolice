<?php
/**
 * Optimize Font Awesome enqueue on front end.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_FontAwesome_Enqueue_Optimizer
 */
class The7_FontAwesome_Enqueue_Optimizer {

	/**
	 * Main method. Add all necessary hooks.
	 */
	public function run() {
		add_action( 'wp_footer', array( $this, 'optimize_in_footer' ), 9 );
		if ( The7_Icon_Manager::is_fontawesome_enabled() ) {
			add_filter( 'style_loader_src', array( $this, 'disable_vc_font_awesome' ), 10, 2 );
			add_filter( 'revslider_layer_content', array( $this, 'fix_icons_in_revslider_content' ) );
		}
	}

	/**
	 * Override revslider font logic.
	 */
	public function optimize_in_footer() {
		$vc_fa_is_enqueued        = wp_style_is( 'font-awesome', 'enqueued' );
		$revslider_fa_is_enqueued = ! empty( $GLOBALS['fa_icon_var'] ) || ! empty( $GLOBALS['fa_var'] );

		if ( The7_Icon_Manager::is_fontawesome_enabled() ) {
			if ( $vc_fa_is_enqueued ) {
				wp_enqueue_style( 'the7-awesome-fonts-back' );
				wp_dequeue_style( 'font-awesome' );
				wp_deregister_style( 'font-awesome' );
			}

			if ( $revslider_fa_is_enqueued && ! $this->is_revslider6() ) {
				wp_enqueue_style( 'the7-awesome-fonts-back' );
				$GLOBALS['fa_icon_var'] = false;
				$GLOBALS['fa_var']      = false;
			}
		} elseif ( $vc_fa_is_enqueued && $revslider_fa_is_enqueued && $this->is_revslider6() ) {
			$GLOBALS['fa_icon_var'] = false;
			$GLOBALS['fa_var']      = false;
		}
	}

	/**
	 * Override visual composer font logic.
	 *
	 * @param string $src    Style src.
	 * @param string $handle Style handle.
	 *
	 * @return bool
	 */
	public function disable_vc_font_awesome( $src, $handle ) {
		if ( $handle === 'font-awesome' ) {
			return false;
		}

		return $src;
	}

	/**
	 * Replace custom revslider icons classes with more common one for older plugin versions.
	 *
	 * Replace 'fa-icon-' with 'fa fa-' if revslidr version less than 6.0.0.
	 *
	 * @param string $html Revslider layer HTML.
	 *
	 * @return string
	 */
	public function fix_icons_in_revslider_content( $html ) {
		if ( ! $this->is_revslider6() ) {
			$html = str_replace( 'fa-icon-', 'fa fa-', $html );
		}

		return $html;
	}

	/**
	 * Return true if active revslidr version is 6.0.0 or greater, otherwise return false.
	 *
	 * @return bool
	 */
	public function is_revslider6() {
		return defined( 'RS_REVISION' ) && version_compare( RS_REVISION, '6.0.0', '>=' );
	}
}
