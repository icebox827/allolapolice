<?php 
/**
 * Plugin Update Page
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	

// Get current user id 
$user_id = get_current_user_id();

// Get general settings
$general_settings = get_option( self::$plugin_prefix . '_table_settings' );

// Get data from API
$apicall = new GW_GoPricing_Api( array( 'product' => 'go_pricing', 'type' => 'info' ) );
$api_data = $apicall->get_data();

?>
<!-- Top Bar -->
<div class="gwa-ptopbar">
	<div class="gwa-ptopbar-icon"></div>
	<div class="gwa-ptopbar-title">Go Pricing</div>
	<div class="gwa-ptopbar-content"><label><span class="gwa-label"><?php _e( 'Help', 'go_pricing_textdomain' ); ?></span><select data-action="help" class="gwa-w90"><option value="1"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 1 ? ' selected="selected"' : ''; ?>><?php _e( 'Tooltip', 'go_pricing_textdomain' ); ?></option><option value="2"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 2 ? ' selected="selected"' : ''; ?>><?php _e( 'Show', 'go_pricing_textdomain' ); ?></option><option value="0"<?php echo isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) && $_COOKIE['go_pricing']['settings']['help'][$user_id] == 0 ? ' selected="selected"' : ''; ?>><?php _e( 'None', 'go_pricing_textdomain' ); ?></option></select></label></div>
</div>
<!-- /Top Bar -->

<!-- Page Content -->
<div class="gwa-pcontent" data-help="<?php echo esc_attr( isset( $_COOKIE['go_pricing']['settings']['help'][$user_id] ) ? $_COOKIE['go_pricing']['settings']['help'][$user_id] : '' ); ?>">

		<!-- Admin Box -->
		<div class="gwa-abox">
			<div class="gwa-abox-header">
	            <div class="gwa-abox-header-tab gwa-current">
					<div class="gwa-abox-header-icon"><i class="fa fa-puzzle-piece"></i></div>
					<div class="gwa-abox-title"><?php _e( 'Plugin Add-ons', 'go_pricing_textdomain' ); ?></div>
				</div>
                <div class="gwa-abox-ctrl"></div>
			</div>
			<div class="gwa-abox-content-wrap">
				<div class="gwa-abox-content">
                    <?php 
						if ( empty( $api_data ) || empty( $api_data['addons'] ) ) {
							printf( '<div style="margin:10px;"><strong>%s</strong></div>', __( 'Oops, API data is not available, please try again later!', 'go_pricing_textdomain' ) );			
						
						} else {
							
							$item = '';
							
							foreach( $api_data['addons'] as $addon ) {
								
								$item_header = '';
								$item_main = '';
								$item_main_desc = '';
								$item_main_meta = '';
								$item_main_footer = '';																
								
								if ( !empty( $addon['name'] ) ) {
									
									/* header */
									$item_header = sprintf( '<div class="gwa-listbox-header"><div class="gwa-product">%1$s%2$s</div></div>',
										!empty( $addon['thumbnail'] ) ? sprintf( '<div class="gwa-product-thumb"><img src="%s"></div>', $addon['thumbnail'] ) : '',
										!empty( $addon['shortname'] ) ? sprintf( '<div class="gwa-product-title">%1$s%2$s</div>', 
											$addon['shortname'],
											!empty( $addon['tagline'] ) ? '<small>' . $addon['tagline']  . '</small>' : ''
										) : ''
									);
									
									/* main */
									$item_main_desc = !empty( $addon['short_description'] ) ? sprintf( '<div class="gwa-product-desciption">%s</div>', wpautop( $addon['short_description'] ) ) : '';
									
									$metadata = array();
									if ( !empty( $addon['version'] ) ) {
										$metadata[] = array( 
											'label' => __( 'Latest Version' , 'go_pricing_textdomain'), 
											'data' => $addon['version']
										);
									}
									
									if ( !empty( $addon['core_min'] ) ) {
										$metadata[] = array( 
											'label' => __( 'Go Pricing Requirement' , 'go_pricing_textdomain'), 
											'data' => $addon['core_min'] . '+'
										);
									}
									
									$metadata_html = '';
									if ( !empty( $metadata ) ) {
										foreach( $metadata as $meta ) {
											if ( empty( $meta['label'] ) || empty( $meta['data'] ) ) continue;
											$metadata_html .= sprintf( '<div class="gwa-product-metadata"><strong>%1$s</strong>%2$s</div>', $meta['label'], $meta['data'] );
										}
									}
									
									$item_main_meta = sprintf( '<div class="gwa-product-meta gwa-clearfix">%s</div>', $metadata_html );
									
									$item_main_footer = sprintf( '<div class="gwa-product-footer">%s</div>',
										!empty( $addon['purchase_url'] ) ? sprintf( '<a href="%1$s" class="gwa-btn-style2" target="_blank">%2$s</a>', 
											$addon['purchase_url'],
											__( 'Buy Now' , 'go_pricing_textdomain')
										) : ''
									);
									
									$item_main = sprintf( '<div class="gwa-listbox-main">%1$s%2$s%3$s</div>', $item_main_desc, $item_main_meta, $item_main_footer );
									
								}
								
								$item .= sprintf( '<div class="gwa-listbox-item gwa-clearfix">%1$s%2$s</div>', $item_header, $item_main );
							
							}
							
							printf( '<div class="gwa-listbox">%s</div>', $item );
																		
						}
					?>
				</div>
			 </div>
		</div>
		<!-- /Admin Box -->
		
</div>
<!-- /Page Content -->