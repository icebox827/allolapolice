<?php
/**
 * The7 avatar class.
 *
 * @package The7
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Avatar
 */
class The7_Avatar {

	/**
	 * Wrapper for get_avatar() with some filters.
	 *
	 * @param mixed      $id_or_email ID or Email.
	 * @param int        $size Image size.
	 * @param string     $default Default avatar image url.
	 * @param string     $alt Avatar image alt.
	 * @param null|array $args Arguments.
	 *
	 * @return false|string
	 */
	public static function get_avatar( $id_or_email, $size = 96, $default = '', $alt = '', $args = null ) {
		add_filter( 'get_avatar', array( __CLASS__, 'check_gravatar_existence_filter' ), 10, 6 );
		$avatar = get_avatar( $id_or_email, $size, $default, $alt, $args );
		remove_filter( 'get_avatar', array( __CLASS__, 'check_gravatar_existence_filter' ) );

		return $avatar;
	}

	/**
	 * Return false if gravatar in use and user do not have one.
	 *
	 * @param string $avatar Avatar url.
	 * @param string $id_or_email Uler ID or Email.
	 * @param int    $args_size Image size.
	 * @param string $args_default Default avatar.
	 * @param string $args_alt Avatar image alt.
	 * @param array  $args Arguments.
	 *
	 * @return bool
	 */
	public static function check_gravatar_existence_filter( $avatar, $id_or_email, $args_size, $args_default, $args_alt, $args = array() ) {
		$args = wp_parse_args( $args, array(
			'url' => '',
		) );

		if ( ! preg_match( '/.*\.gravatar\.com.*/', $avatar ) || self::is_gravatar_exists( $args['url'] ) ) {
			// non gravatar or gravatar exists.
			return $avatar;
		}

		return false;
	}

	/**
	 * Check if provided gravatar url response with 200.
	 *
	 * Cache result for $url in wp_cache for 24 hours.
	 *
	 * @param string $url Gravatar url.
	 *
	 * @return bool
	 */
	public static function is_gravatar_exists( $url ) {
		if ( ! $url ) {
			return false;
		}

		$_uri     = remove_query_arg( array( 's', 'd', 'f', 'r' ), $url );
		$hash_key = md5( strtolower( trim( $_uri ) ) );
		$data     = (string) wp_cache_get( $hash_key );
		if ( empty( $data ) ) {
			$_uri     = add_query_arg( 'd', '404', $_uri );
			$response = wp_remote_head( $_uri );
			if ( is_wp_error( $response ) ) {
				$data = 'not200';
			} else {
				$data = (string) $response['response']['code'];
			}
			wp_cache_set( $hash_key, $data, $group = '', $expire = DAY_IN_SECONDS );
		}

		return $data === '200';
	}
}
