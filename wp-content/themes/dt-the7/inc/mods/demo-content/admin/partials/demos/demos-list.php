<?php
defined( 'ABSPATH' ) || exit;
?>

<?php if ( count( $dummies_list ) > 5 ): ?>

    <div class="dt-dummy-search">
        <label class="screen-reader-text" for="dt-dummy-search-input"><?php esc_html_e( 'Search by demo name or URL (link):', 'the7mk2' ); ?></label>
        <input type="search" id="dt-dummy-search-input" class="widefat" value="" placeholder="<?php esc_attr_e( 'Search by demo name or URL (link)', 'the7mk2' ); ?>" autofocus/>
    </div>

<?php endif; ?>

<?php foreach ( $dummies_list as $dummy_info ) : ?>

	<?php
	$dummy_title = ( empty( $dummy_info['title'] ) ? '' : $dummy_info['title'] );
	$dummy_id    = ( empty( $dummy_info['id'] ) ? '' : $dummy_info['id'] );
	?>

    <div class="dt-dummy-content" data-dummy-id="<?php echo esc_attr( $dummy_id ); ?>">

		<?php if ( $dummy_title ) : ?>
            <h3><?php echo esc_html( $dummy_title ); ?></h3>
		<?php endif; ?>

        <div class="dt-dummy-import-item">

			<?php if ( ! empty( $dummy_info['screenshot'] ) ) : ?>
				<?php
				$width  = 215;
				$height = 161;
				$img    = '<img src="' . esc_url( $dummy_info['screenshot'] ) . '" alt="' . esc_attr( $dummy_title ) . '" ' . image_hwstring( $width, $height ) . '/>';

				if ( ! empty( $dummy_info['link'] ) ) {
					$img = '<a href="' . esc_url( $dummy_info['link'] ) . '" target="_blank">' . $img . '</a>';
				}
				?>
                <div class="dt-dummy-screenshot">
					<?php echo $img; ?>
                </div>
			<?php endif; ?>

            <div class="dt-dummy-controls">
				<?php
				if ( ! presscore_theme_is_activated() ) {
					include dirname( __FILE__ ) . '/theme-not-activated.php';
				} else {
					include dirname( __FILE__ ) . '/per-demo-import-interface.php';
				}
				?>
            </div>

        </div>

    </div>

<?php endforeach; ?>

