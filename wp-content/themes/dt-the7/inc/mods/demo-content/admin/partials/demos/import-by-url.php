<?php
defined( 'ABSPATH' ) || exit;
?>

<div id="the7-dashboard" class="wrap the7-import-by-url-page">
    <h1><?php echo esc_html( get_admin_page_title() ) ?></h1>
    <div class="wp-header-end"></div>
    <div class="the7-import-page">
		<?php include dirname( __FILE__ ) . '/import-by-url-form.php' ?>
    </div>
</div>