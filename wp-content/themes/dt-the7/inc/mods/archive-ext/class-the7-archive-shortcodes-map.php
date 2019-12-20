<?php
// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class The7_Archive_Shortcodes_Map
 */
class The7_Archive_Shortcodes_Map {

	/**
	 * @var array $map
	 */
	protected $map = array(
		'dt_blog_masonry'         => 'DT_Shortcode_BlogMasonry',
		'dt_blog_list'            => 'DT_Shortcode_BlogList',
		'dt_portfolio_masonry'    => 'DT_Shortcode_PortfolioMasonry',
		'dt_portfolio_jgrid'      => 'DT_Shortcode_Portfolio_Jgrid',
		'dt_team_masonry'         => 'DT_Shortcode_Team_Masonry',
		'dt_testimonials_masonry' => 'DT_Shortcode_Testimonials_Masonry',
		'dt_albums'               => 'DT_Shortcode_Albums',
		'dt_albums_masonry'       => 'DT_Shortcode_AlbumsMasonry',
		'dt_albums_jgrid'         => 'DT_Shortcode_Albums_Jgrid',
	);

	/**
	 * Retrieve shortcodes tags array.
	 *
	 * @return array
	 */
	public function get_tags() {
		return array_keys( $this->map );
	}

	/**
	 * Retrieve shortcode class name.
	 *
	 * @param string $tag
	 *
	 * @return mixed|null
	 */
	public function get_class_name( $tag ) {
		if ( array_key_exists( $tag, $this->map ) ) {
			return $this->map[ $tag ];
		}

		return null;
	}
}
