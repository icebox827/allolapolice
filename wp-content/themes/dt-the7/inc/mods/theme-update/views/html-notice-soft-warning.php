<?php
$domains_count = isset( $domains_count ) ? (int) $domains_count : 'N';
?>
<p>
	<strong>Hey!</strong> We have noticed that you were using this purchase code on <?php echo $domains_count ?> website addresses. Please don't forget that according to <a href="<?php echo The7_Remote_API::LICENSE_URL ?>" target="_blank">Envato Standard License</a> each site requires a separate code. You can purchase more licenses <a href="<?php echo The7_Remote_API::THEME_THEMEFOREST_PAGE_URL ?>" target="_blank">here</a> and manage them in <a href="<?php echo The7_Remote_API::PURCHASE_CODES_MANAGE_URL ?>" target="_blank">this tool</a>. Thank you!
</p>