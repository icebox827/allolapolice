<?php
/**
 * Required plugins view.
 *
 * @package The7/DemoContent
 * @since   2.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var The7_Demo_Content_Admin $this
 */

$inactive_plugins   = $this->plugins_checker()->get_inactive_plugins();
$plugins_to_install = $this->plugins_checker()->get_plugins_to_install();
?>

<div class="dt-dummy-controls-block">
    <div class="dt-dummy-required-plugins">
        <p>
            <strong><?php esc_html_e( 'In order to import this demo, you need to install/activate the following plugins:', 'the7mk2' ); ?></strong>
        </p>
        <ol>
			<?php
			$required_plugins = array_merge( $inactive_plugins, $plugins_to_install );
			foreach ( $required_plugins as $plugin_name ) {
				echo "<li>{$plugin_name}</li>";
			}
			?>
        </ol>
        <input type="hidden" name="plugins_to_install" value="<?php echo esc_attr( implode( ',', array_keys( $plugins_to_install ) ) ); ?>">
        <input type="hidden" name="plugins_to_activate" value="<?php echo esc_attr( implode( ',', array_keys( $inactive_plugins ) ) ); ?>">
    </div>
</div>