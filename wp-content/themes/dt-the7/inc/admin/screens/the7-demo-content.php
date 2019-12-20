<?php
defined( 'ABSPATH' ) || exit;
?>
<div id="the7-dashboard" class="wrap">
    <h1><?php esc_html_e( 'Pre-made Websites', 'the7mk2' ); ?></h1>
    <div class="wp-header-end"></div>
    <div class="feature-section">
        <?php the7_demo_content()->admin->display_plugin_page(); ?>
    </div>
</div>