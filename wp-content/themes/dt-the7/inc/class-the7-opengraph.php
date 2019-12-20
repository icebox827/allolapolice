<?php
/**
 * Class that handles OpenGraph meta tags.
 *
 * @since   3.7.2
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_OpenGraph
 */
class The7_OpenGraph {

	/**
	 * Output the site name straight from the blog info.
	 *
	 * @return string
	 */
	public function site_name() {
		return $this->og_tag( 'og:site_name', get_bloginfo( 'name' ) );
	}

	/**
	 * Output post title.
	 *
	 * @link https://developers.facebook.com/docs/reference/opengraph/object-type/article/
	 *
	 * @return string
	 */
	public function title() {
		return $this->og_tag( 'og:title', get_the_title() );
	}

	/**
	 * Output post excerpt as description.
	 *
	 * @return string
	 */
	public function description() {
		return $this->og_tag( 'og:description', get_the_excerpt() );
	}

	/**
	 * Output post thumbnail if any as image.
	 *
	 * @return string
	 */
	public function image() {
		$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		if ( isset( $post_thumbnail[0] ) ) {
			return $this->og_tag( 'og:image', esc_url_raw( $post_thumbnail[0] ) );
		}

		return '';
	}

	/**
	 * Output url.
	 *
	 * @link https://developers.facebook.com/docs/reference/opengraph/object-type/article/
	 *
	 * @return string
	 */
	public function url() {
		return $this->og_tag( 'og:url', esc_url_raw( get_the_permalink() ) );
	}

	/**
	 * Output the OpenGraph type.
	 *
	 * @link https://developers.facebook.com/docs/reference/opengraph/object-type/object/
	 *
	 * @return string
	 */
	public function type() {
		if ( is_front_page() || is_home() ) {
			$type = 'website';
		} elseif ( is_singular() ) {
			$type = 'article';
		} else {
			// We use "object" for archives etc. as article doesn't apply there.
			$type = 'object';
		}

		return $this->og_tag( 'og:type', $type );
	}

	/**
	 * Output the OpenGraph meta tag.
	 *
	 * @param string $property OG property.
	 * @param string $content Property content.
	 *
	 * @return string
	 */
	public function og_tag( $property, $content ) {
		$property = (string) $property;
		$content  = (string) $content;
		if ( ! $content ) {
			return '';
		}

		return '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $content ) . '" />' . "\n";
	}
}
