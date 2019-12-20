<?php
/**
 * Search form template.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;
?>
	<form class="searchform" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="the7-search" class="screen-reader-text"><?php esc_html_e( 'Search:', 'the7mk2' ); ?></label>
		<input type="text" id="the7-search" class="field searchform-s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Type and hit enter &hellip;', 'the7mk2' ); ?>" />
		<input type="submit" class="assistive-text searchsubmit" value="<?php esc_attr_e( 'Go!', 'the7mk2' ); ?>" />
		<a href="#go" class="submit"></a>
	</form>
