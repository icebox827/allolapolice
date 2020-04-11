<?php
// Alternative function for wp_remote_get
if(!function_exists('bsf_get_remote_version')) {
	function bsf_get_remote_version( $products ) {
		global $ultimate_referer;

		$path = bsf_get_api_url() . '?referer=' . $ultimate_referer;

		$data = array(
			'action'   => 'bsf_get_product_versions',
			'ids'      => $products,
			'site_url' => get_site_url()
		);

		$request = wp_remote_post(
			$path,
			array(
				'body'    => $data,
				'timeout' => '10',
			)
		);

		// Request http URL if the https version fails.
		if ( is_wp_error( $request ) && wp_remote_retrieve_response_code( $request ) !== 200 ) {
			$path    = bsf_get_api_url( true ) . '?referer=' . $ultimate_referer;
			$request 	= wp_remote_post(
				$path, array(
					'body'    => $data,
					'timeout' => '8',
				)
			);
		}

		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$result = json_decode( wp_remote_retrieve_body( $request ) );
			if ( ! empty( $result ) ) {
				if ( empty( $result->error ) ) {
					return $result->updated_versions;
				} else {
					return $result->error;
				}
			}
		}
	}
}

if ( ! function_exists( 'bsf_check_product_update' ) ) {
	function bsf_check_product_update() {
		$is_update    = true;
		$registered   = array();
		$all_products = brainstorm_get_all_products( false, false, true );

		foreach ( $all_products as $key => $product ) {
			if ( ! isset( $product['id'] ) ) {
				continue;
			}
			$constant = strtoupper( str_replace( '-', '_', $product['id'] ) );
			$constant = 'BSF_' . $constant . '_CHECK_UPDATES';
			if ( defined( $constant ) && ( constant( $constant ) === 'false' || constant( $constant ) === false ) ) {
				continue;
			}
			$registered[] = $product['id'];
		}

		$remote_versions = bsf_get_remote_version( $registered );

		$brainstrom_products         = get_option( 'brainstrom_products', array() );
		$brainstrom_bundled_products = get_option( 'brainstrom_bundled_products', array() );

		$bsf_product_plugins = isset( $brainstrom_products['plugins'] ) ? $brainstrom_products['plugins'] : array();
		$bsf_product_themes  = isset( $brainstrom_products['themes'] ) ? $brainstrom_products['themes'] : array();

		if ( $remote_versions !== false ) {
			if ( ! empty( $remote_versions ) ) {
				$is_bundled_update = false;
				foreach ( $remote_versions as $rkey => $remote_data ) {
					$rid               = ( isset( $remote_data->id ) ) ? (string) $remote_data->id : '';
					$remote_version    = ( isset( $remote_data->remote_version ) ) ? $remote_data->remote_version : '';
					$in_house          = ( isset( $remote_data->in_house ) ) ? $remote_data->in_house : '';
					$on_market         = ( isset( $remote_data->on_market ) ) ? $remote_data->on_market : '';
					$is_product_free   = ( isset( $remote_data->is_product_free ) ) ? $remote_data->is_product_free : '';
					$short_name        = ( isset( $remote_data->short_name ) ) ? $remote_data->short_name : '';
					$changelog_url     = ( isset( $remote_data->changelog_url ) ) ? $remote_data->changelog_url : '';
					$purchase_url      = ( isset( $remote_data->purchase_url ) ) ? $remote_data->purchase_url : '';
					$version_beta      = ( isset( $remote_data->version_beta ) ) ? $remote_data->version_beta : '';
					$download_url      = ( isset( $remote_data->download_url ) ) ? $remote_data->download_url : '';
					$download_url_beta = ( isset( $remote_data->download_url_beta ) ) ? $remote_data->download_url_beta : '';
					$tested_upto       = ( isset( $remote_data->tested ) ) ? $remote_data->tested : '';
					foreach ( $bsf_product_plugins as $key => $plugin ) {
						if ( ! isset( $plugin['id'] ) ) {
							continue;
						}
						$pid = (string) $plugin['id'];
						if ( $pid === $rid ) {
							$brainstrom_products['plugins'][ $key ]['remote']            = $remote_version;
							$brainstrom_products['plugins'][ $key ]['in_house']          = $in_house;
							$brainstrom_products['plugins'][ $key ]['on_market']         = $on_market;
							$brainstrom_products['plugins'][ $key ]['is_product_free']   = $is_product_free;
							$brainstrom_products['plugins'][ $key ]['short_name']        = $short_name;
							$brainstrom_products['plugins'][ $key ]['changelog_url']     = $changelog_url;
							$brainstrom_products['plugins'][ $key ]['purchase_url']      = $purchase_url;
							$brainstrom_products['plugins'][ $key ]['version_beta']      = $version_beta;
							$brainstrom_products['plugins'][ $key ]['download_url_beta'] = $download_url_beta;
							$brainstrom_products['plugins'][ $key ]['download_url']      = $download_url;
							$brainstrom_products['plugins'][ $key ]['tested']            = $tested_upto;
							$is_update = true;
						}
					}

					foreach ( $bsf_product_themes as $key => $theme ) {
						if ( ! isset( $theme['id'] ) ) {
							continue;
						}
						$pid = $theme['id'];
						if ( $pid === $rid ) {
							$brainstrom_products['themes'][ $key ]['remote']            = $remote_version;
							$brainstrom_products['themes'][ $key ]['in_house']          = $in_house;
							$brainstrom_products['themes'][ $key ]['on_market']         = $on_market;
							$brainstrom_products['themes'][ $key ]['is_product_free']   = $is_product_free;
							$brainstrom_products['themes'][ $key ]['short_name']        = $short_name;
							$brainstrom_products['themes'][ $key ]['changelog_url']     = $changelog_url;
							$brainstrom_products['themes'][ $key ]['purchase_url']      = $purchase_url;
							$brainstrom_products['themes'][ $key ]['version_beta']      = $version_beta;
							$brainstrom_products['themes'][ $key ]['download_url']      = $download_url;
							$brainstrom_products['themes'][ $key ]['download_url_beta'] = $download_url_beta;
							$is_update = true;
						}
					}

					if ( isset( $remote_data->bundled_products ) && ! empty( $remote_data->bundled_products ) ) {
						if ( ! empty( $brainstrom_bundled_products ) && is_array( $brainstrom_bundled_products ) ) {
							foreach ( $brainstrom_bundled_products as $bkeys => $bps ) {
								foreach ( $bps as $bkey => $bp ) {
									if ( ! isset( $bp->id ) ) {
										continue;
									}
									foreach ( $remote_data->bundled_products as $rbp ) {
										if ( ! isset( $rbp->id ) ) {
											continue;
										}
										if ( $rbp->id === $bp->id ) {
											$bprd = $brainstrom_bundled_products[ $bkeys ];
											$brainstrom_bundled_products[ $bkeys ][ $bkey ]->remote            = $rbp->remote_version;
											$brainstrom_bundled_products[ $bkeys ][ $bkey ]->parent            = $rbp->parent;
											$brainstrom_bundled_products[ $bkeys ][ $bkey ]->short_name        = $rbp->short_name;
											$brainstrom_bundled_products[ $bkeys ][ $bkey ]->changelog_url     = $rbp->changelog_url;
											$brainstrom_bundled_products[ $bkeys ][ $bkey ]->download_url      = isset( $rbp->download_url ) ? $rbp->download_url : false;
											$brainstrom_bundled_products[ $bkeys ][ $bkey ]->download_url_beta = isset( $rbp->download_url_beta ) ? $rbp->download_url_beta : false;
											$is_bundled_update = true;
										}
									}
								}
							}
						}
					}
				}

				if ( $is_bundled_update ) {
					update_option( 'brainstrom_bundled_products', $brainstrom_bundled_products );
				}
			}
		}

		if ( $is_update ) {
			update_option( 'brainstrom_products', $brainstrom_products );
		}
	}
}
if ( ! defined( 'BSF_CHECK_PRODUCT_UPDATES' ) ) {
	$BSF_CHECK_PRODUCT_UPDATES = true;
} else {
	$BSF_CHECK_PRODUCT_UPDATES = BSF_CHECK_PRODUCT_UPDATES;
}

if ( ( false === get_transient( 'bsf_check_product_updates' ) && ( $BSF_CHECK_PRODUCT_UPDATES === true || $BSF_CHECK_PRODUCT_UPDATES === 'true' ) ) ) {

	if ( true === bsf_time_since_last_versioncheck( 48, 'bsf_local_transient' ) ) {
		global $ultimate_referer;
		$ultimate_referer = 'on-transient-delete';
		bsf_check_product_update();
		update_option( 'bsf_local_transient', current_time( 'timestamp' ) );
		set_transient( 'bsf_check_product_updates', true, 2 * DAY_IN_SECONDS );
	}

}

if ( ! function_exists( 'get_bsf_product_upgrade_link' ) ) {
	function get_bsf_product_upgrade_link( $product ) {
		$brainstrom_products = ( get_option( 'brainstrom_products' ) ) ? get_option( 'brainstrom_products' ) : array();

		$mix                    = $bsf_product_plugins = $bsf_product_themes = $registered = array();
		$licence_require_update = '';

		if ( ! empty( $brainstrom_products ) ) :
			$bsf_product_plugins = ( isset( $brainstrom_products['plugins'] ) ) ? $brainstrom_products['plugins'] : array();
			$bsf_product_themes  = ( isset( $brainstrom_products['themes'] ) ) ? $brainstrom_products['themes'] : array();
		endif;

		$mix    = array_merge( $bsf_product_plugins, $bsf_product_themes );
		$status = ( isset( $product['status'] ) ) ? $product['status'] : '';
		$name   = ( isset( $product['bundled'] ) && ( $product['bundled'] ) ) ? $product['name'] : $product['product_name'];
		$free   = ( isset( $product['is_product_free'] ) && ( $product['is_product_free'] == true || $product['is_product_free'] == 'true' ) ) ? $product['is_product_free'] : 'false';

		$id = $product['id'];

		$original_id = $id;

		$not_registered_msg = 'Activate your licence for one click update.';
		if ( $product['bundled'] ) {
			$product_name = '';
			$parent       = $product['parent'];
			foreach ( $mix as $key => $bsf_p ) {
				if ( $bsf_p['id'] == $parent ) {
					$status       = ( isset( $bsf_p['status'] ) ) ? $bsf_p['status'] : '';
					$product_name = ( isset( $bsf_p['product_name'] ) ) ? $bsf_p['product_name'] : '';
					$id           = $parent;
					break;
				}
			}
			$not_registered_msg = 'This is bundled with ' . $product_name . ', Activate ' . $product_name . '\'s licence for one click update.';
		}

		if ( array_key_exists( 'licence_require_update', $product ) ) {
			$licence_require_update = $product['licence_require_update'];
		}

		if ( $status === 'registered' || ( $free === true || $free === 'true' ) || $licence_require_update == 'false' ) {

			$request = bsf_registration_page_url( '&action=upgrade&id=' . $original_id );

			if ( $product['bundled'] ) {
				$request .= '&bundled=' . $id;
			}
			if ( is_multisite() ) {
				$link = '<a href="' . network_admin_url( $request ) . '" data-pid="' . $original_id . '" data-bundled="' . $product['bundled'] . '" data-bid="' . $id . '" class="bsf-update-product-button">' . __( 'Update ' . $name . '.', 'bsf' ) . '</a><span class="spinner bsf-update-spinner"></span>';
			} else {
				$link = '<a href="' . admin_url( $request ) . '" data-pid="' . $original_id . '" data-bundled="' . $product['bundled'] . '" data-bid="' . $id . '" class="bsf-update-product-button">' . __( 'Update ' . $name . '.', 'bsf' ) . '</a><span class="spinner bsf-update-spinner"></span>';
			}
		} else {
			$link = '<a href="' . bsf_registration_page_url( '&id=' . $id ) . '">' . __( $not_registered_msg, 'bsf' ) . '</a>';

		}

		return $link;
	}
}

/**
 * Unique sort final update ready array
 *
 * @param array
 *
 * @return array with unique plugins
 */
if ( ! function_exists( 'bsf_array_unique' ) ) {
	function bsf_array_unique( $arrs ) {

		$available_inits = array();

		foreach ( $arrs as $key => $arr ) {
			if ( array_key_exists( 'init', $arr ) ) {
				if ( in_array( $arr['init'], $available_inits ) ) {
					unset( $arrs[ $key ] );
				} else {
					array_push( $available_inits, $arr['init'] );
				}
			}
		}

		return $arrs;
	}
}
