<?php
/**
 * Core functions.
 *
 * @since presscore 0.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'the7_aq_resize' ) ) {

	/**
	 * This is just a tiny wrapper function for the class above so that there is no
	 * need to change any code in your own WP themes. Usage is still the same :)
	 */
	function the7_aq_resize( $url, $img_width, $img_height, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
		$aq_resize = The7_Aq_Resize::getInstance();

		return $aq_resize->process( $url, $img_width, $img_height, $width, $height, $crop, $single, $upscale );
	}
}

/**
 * Constrain dimensions helper.
 *
 * @param $w0 int
 * @param $h0 int
 * @param $w1 int
 * @param $h1 int
 * @param $change boolena
 *
 * @return array
 */
function dt_constrain_dim( $w0, $h0, &$w1, &$h1, $change = false ) {
	$prop_sizes = wp_constrain_dimensions( $w0, $h0, $w1, $h1 );

	if ( $change ) {
		$w1 = $prop_sizes[0];
		$h1 = $prop_sizes[1];
	}
	return array( $w1, $h1 );
}

/**
 * Resize image to speciffic dimetions.
 *
 * Magick - do not touch!
 *
 * Evaluate new width and height.
 * $img - image meta array ($img[0] - image url, $img[1] - width, $img[2] - height).
 * $opts - options array, supports w, h, zc, a, q.
 *
 * @param array $img
 * @param 
 * @return array
 */
function dt_get_resized_img( $img, $opts, $resize = true, $is_retina = false ) {

	$opts = apply_filters( 'dt_get_resized_img-options', $opts, $img );

	if ( !is_array( $img ) || !$img || (!$img[1] && !$img[2]) ) {
		return false;
	}

	if ( !is_array( $opts ) || !$opts ) {

		if ( !isset( $img[3] ) ) {

			$img[3] = image_hwstring( $img[1], $img[2] );
		}

		return $img;
	}

	$defaults = array( 'w' => 0, 'h' => 0, 'zc' => 1, 'z' => 1, 'hd_ratio' => 2, 'hd_convert' => true );
	$opts = wp_parse_args( $opts, $defaults );

	$w = absint( $opts['w'] );
	$h = absint( $opts['h'] );

	// Return original image if there is no proper dimensions.
	if ( !$w && !$h ) {
		if ( !isset( $img[3] ) ) {
			$img[3] = image_hwstring( $img[1], $img[2] );
		}

		return $img;
    }

	// If zoomcropping off and image smaller then required square
	if ( 0 == $opts['zc'] && ( $img[1] <= $w  && $img[2] <= $h ) ) {

		return array( $img[0], $img[1], $img[2], image_hwstring( $img[1], $img[2] ) );

	} elseif ( 3 == $opts['zc'] || empty ( $w ) || empty ( $h ) ) {

		if ( 0 == $opts['z'] ) {
			dt_constrain_dim( $img[1], $img[2], $w, $h, true );
		} else {
			$p = absint( $img[1] ) / absint( $img[2] );
			$hx = absint( floor( $w / $p ) ); 
			$wx = absint( floor( $h * $p ) );
			
			if ( empty( $w ) ) {
				$w = $wx;
			} else if ( empty( $h ) ) {
				$h = $hx;
			} else {
				if ( $hx < $h && $wx >= $w ) {
					$h = $hx;
				} elseif ( $wx < $w && $hx >= $h ) {
					$w = $wx;
				}
			}
		}

		if ( $img[1] == $w && $img[2] == $h ) {
			return array( $img[0], $img[1], $img[2], image_hwstring( $img[1], $img[2] ) );
		}

	}

	$img_h = $h;
	$img_w = $w;

	if ( $opts['hd_convert'] && $is_retina ) {
		$img_h = round( $img_h * $opts['hd_ratio'] );
		$img_w = round( $img_w * $opts['hd_ratio'] );
	}

	if ( 1 == $opts['zc'] ) {

		if ( $img[1] >= $img_w && $img[2] >= $img_h ) {

			// do nothing

		} else if ( $img[1] <= $img[2] && $img_w >= $img_h ) { // img=portrait; c=landscape

			$cw_new = $img[1];
			$k = $cw_new/$img_w;
			$ch_new = $k * $img_h;

		} else if ( $img[1] >= $img[2] && $img_w <= $img_h ) { // img=landscape; c=portrait

			$ch_new = $img[2];
			$k = $ch_new/$img_h;
			$cw_new = $k * $img_w;

		} else {

			$kh = $img_h/$img[2];
			$kw = $img_w/$img[1];
			$kres = max( $kh, $kw );
			$ch_new = $img_h/$kres;
			$cw_new = $img_w/$kres;

		}

		if ( isset($ch_new, $cw_new) ) {
			$img_h = absint(floor($ch_new));
			$img_w = absint(floor($cw_new));
		}

	}

	if ( $resize ) {
	    $img_width = $img_height = null;
	    if ( ! empty( $opts['speed_resize'] ) ) {
            $img_width = $img[1];
            $img_height = $img[2];
        }

		$file_url = the7_aq_resize( $img[0], $img_width, $img_height, $img_w, $img_h, true, true, false );
	}

	if ( empty( $file_url ) ) {
		$file_url = $img[0];
	}

	return array(
		$file_url,
		$img_w,
		$img_h,
		image_hwstring( $img_w, $img_h )
	);
}

/**
 * DT master get image function. 
 *
 * @param $opts array
 *
 * @return string
 */
function dt_get_thumb_img( $opts = array() ) {
	global $post;

	$default_image = presscore_get_default_image();

	$defaults = array(
		'wrap' => '<a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %IMG_CLASS% %SIZE% %ALT% %IMG_TITLE% /></a>',
		'class' => '',
		'alt' => '',
		'title' => '',
		'custom' => '',
		'img_class' => '',
		'img_title' => '',
		'img_description' => '',
		'img_caption' => '',
		'href' => '',
		'img_meta' => array(),
		'img_id' => 0,
		'options' => array(),
		'default_img' => $default_image,
		'prop' => false,
		'lazy_loading' => false,
		'lazy_class'    => 'lazy-load',
		'lazy_bg_class' => 'layzr-bg',
		'echo' => true,
	);
	$opts = wp_parse_args( $opts, $defaults );
	$opts = apply_filters('dt_get_thumb_img-args', $opts);

	$original_image = null;
	if ( $opts['img_meta'] ) {
		$original_image = $opts['img_meta'];
	} elseif ( $opts['img_id'] ) {
		$original_image = wp_get_attachment_image_src( $opts['img_id'], 'full' );
	}

	if ( !$original_image ) {
		$original_image = $opts['default_img'];
	}

	// proportion
	if ( $original_image && !empty($opts['prop']) && ( empty($opts['options']['h']) || empty($opts['options']['w']) ) ) {
		$_prop = $opts['prop'];
		$_img_meta = $original_image;

		if ( $_prop > 1 ) {
			$h = (int) floor((int) $_img_meta[1] / $_prop);
			$w = (int) floor($_prop * $h );
		} else if ( $_prop < 1 ) {
			$w = (int) floor($_prop * $_img_meta[2]);
			$h = (int) floor($w / $_prop );
		} else {
			$w = $h = min($_img_meta[1], $_img_meta[2]);
		}

		if ( !empty($opts['options']['w']) && $w ) {
			$__prop = $h / $w;
			$w = intval($opts['options']['w']);
			$h = intval(floor($__prop * $w));
		} else if ( !empty($opts['options']['h']) && $h ) {
			$__prop = $w / $h;
			$h = intval($opts['options']['h']);
			$w = intval(floor($__prop * $h));
		}

		$opts['options']['w'] = $w;
		$opts['options']['h'] = $h;
	}

	$src = '';
	$hd_src = '';
	$resized_image = $resized_image_hd = array();

	if ( $opts['options'] ) {

		$resized_image = dt_get_resized_img( $original_image, $opts['options'], true, false );
		$resized_image_hd = dt_get_resized_img( $original_image, $opts['options'], true, true );

		$hd_src = $resized_image_hd[0];
		$src = $resized_image[0];

		if ( $resized_image_hd[0] === $resized_image[0] ) {
			$resized_image_hd = array();
		}

	} else {
		$resized_image = $original_image;
		$src = $resized_image[0];
	}

	if ( $img_id = absint( $opts['img_id'] ) ) {

		if ( '' === $opts['alt'] ) {
			$opts['alt'] = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
		}

		if ( '' === $opts['img_title'] ) {
			$opts['img_title'] = get_the_title( $img_id );
		}
	}

	$href = $opts['href'];
	if ( !$href ) {
		$href = $original_image[0];
	}

	$_width = $resized_image[1];
	$_height = $resized_image[2];

	if ( empty($resized_image[3]) || !is_string($resized_image[3]) ) {
		$size = image_hwstring( $_width, $_height );
	} else {
		$size = $resized_image[3];
	}

	$lazy_loading_src = "data:image/svg+xml,%3Csvg%20xmlns%3D&#39;http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg&#39;%20viewBox%3D&#39;0%200%20{$_width}%20{$_height}&#39;%2F%3E";

	$lazy_loading = ! empty( $opts['lazy_loading'] );
	$srcset_tpl = '%s %dw';

	if ( $lazy_loading ) {
		$src = str_replace( array(' '), array('%20'), $src );
		$hd_src = str_replace( array(' '), array('%20'), $hd_src );

		$esc_src = esc_attr( $src );
		$src_att = sprintf( $srcset_tpl, $esc_src, $resized_image[1] );
		if ( $resized_image_hd ) {
			$src_att .= ', ' . sprintf( $srcset_tpl, esc_attr( $hd_src ), $resized_image_hd[1] );
		}
		$src_att = 'src="' . $lazy_loading_src . '" data-src="' . $esc_src . '" data-srcset="' . $src_att . '"';
		$opts['img_class'] .= ' ' . $opts['lazy_class'];
		$opts['class'] .= ' ' . $opts['lazy_bg_class'];
	} else {
		$src_att = sprintf( $srcset_tpl, $src, $resized_image[1] );
		if ( $resized_image_hd ) {
			$src_att .= ', ' . sprintf( $srcset_tpl, $hd_src, $resized_image_hd[1] );
		}
		$src_sizes = $resized_image[1] . 'px';
		$src_att = 'src="' . esc_attr( $src ) . '" srcset="' . esc_attr( $src_att ) . '" sizes="' . esc_attr( $src_sizes ) . '"';
	}

	$class = empty( $opts['class'] ) ? '' : 'class="' . esc_attr( trim($opts['class']) ) . '"';
	$title = empty( $opts['title'] ) ? '' : 'title="' . esc_attr( trim($opts['title']) ) . '"';
	$img_title = empty( $opts['img_title'] ) ? '' : 'title="' . esc_attr( trim($opts['img_title']) ) . '"';
	$img_class = empty( $opts['img_class'] ) ? '' : 'class="' . esc_attr( trim($opts['img_class']) ) . '"';

	$output = str_replace(
		array(
			'%HREF%',
			'%CLASS%',
			'%TITLE%',
			'%CUSTOM%',
			'%SRC%',
			'%IMG_CLASS%',
			'%SIZE%',
			'%ALT%',
			'%IMG_TITLE%',
			'%RAW_TITLE%',
			'%RAW_ALT%',
			'%RAW_IMG_TITLE%',
			'%RAW_IMG_DESCRIPTION%',
			'%RAW_IMG_CAPTION%'
		),
		array(
			'href="' . esc_url( $href ) . '"',
			$class,
			$title,
			strip_tags( $opts['custom'] ),
			$src_att,
			$img_class,
			$size,
			'alt="' . esc_attr( $opts['alt'] ) . '"',
			$img_title,
			esc_attr( $opts['title'] ),
			esc_attr( $opts['alt'] ),
			esc_attr( $opts['img_title'] ),
			esc_attr( $opts['img_description'] ),
			esc_attr( $opts['img_caption'] )
		),
		$opts['wrap']
	);

	$output = apply_filters( 'dt_get_thumb_img-output', $output, $opts );

	if ( $opts['echo'] ) {
		echo $output;
		return '';
	}

	return $output;
}

/**
 * Load presscore template.
 *
 * @param $slug string
 * @param $name string
 */
function dt_get_template_part( $slug = '', $name = '' ) {
	if ( empty( $slug ) ) {
		return;
	}

	$dir_base = '/templates/';
	get_template_part( $dir_base . $slug, $name );
}

/**
 * Description here.
 *
 * @param $src string
 *
 * @return string
 *
 * @since presscore 0.1
 */
function dt_get_of_uploaded_image( $src ) {
	if ( ! $src ) {
		return '';
	}

	$uri = $src;
	if ( ! parse_url( $src, PHP_URL_SCHEME ) ) {

		if ( dt_maybe_uploaded_image_url( $src ) ) {

			$uri = site_url( $src );
		} else {

			$uri = PRESSCORE_PRESET_BASE_URI . $src;
		}
	}

	return $uri;
}

function dt_maybe_uploaded_image_url( $url ) {
	$uploads = wp_upload_dir();
	$baseurl = str_replace( site_url(), '', $uploads['baseurl'] );
	$pattern = '/' . trailingslashit( basename( WP_CONTENT_URL ) );
	return ( strpos( $url, $baseurl ) !== false || strpos( $url, $pattern ) !== false );
}

/**
 * Parse str to array with src, width and height
 * expample: image.jpg?w=25&h=45
 *
 * @param $str string
 *
 * @return array
 *
 * @since presscore 0.1
 */
function dt_parse_of_uploaded_image_src ( $str ) {
	if ( empty( $str ) ) {
		return array();
	}

	$res_arr = array();
	$str_arr = explode( '?', $str );

	$res_arr[0] = dt_get_of_uploaded_image( current( $str_arr ) );

	// if no additional arguments specified
	if ( ! isset( $str_arr[1] ) ) {
		return array();
	} 

	$args_arr = array();
	wp_parse_str( $str_arr[1], $args_arr );

	if ( isset( $args_arr['w'] ) && isset( $args_arr['h'] ) ) {

		$res_arr[1] = intval( $args_arr['w'] );
		$res_arr[2] = intval( $args_arr['h'] );
	} else {

		return array();
	}

	return $res_arr;
}

/**
 * Return prepeared logo attributes array or null.
 *
 * @param $logo array array( 'href', 'id' )
 * @param $type string (normal/retina)
 *
 * @return mixed
 *
 * @since presscore 0.1
 */
function dt_get_uploaded_logo( $logo, $type = 'normal' ) {
	if( empty( $logo ) || ! is_array( $logo ) ) { return null; }

	$res_arr = null;

	if ( next( $logo ) ) {
		$logo_src = wp_get_attachment_image_src( current( $logo ), 'full' );
	} else {
		reset( $logo );
		$logo_src = dt_parse_of_uploaded_image_src( current( $logo ) );
	}

	if ( ! empty( $logo_src ) ) {

		if ( 'retina' === $type ) {
			$w = $logo_src[1]/2;
			$h = $logo_src[2]/2;
		} else {
			$w = $logo_src[1];
			$h = $logo_src[2];
		}

		$res_arr = array(
			0			=> $logo_src[0],
			1			=> $logo_src[1],
			2			=> $logo_src[2],
			'src'		=> $logo_src[0],
			'width'		=> $w,
			'height'	=> $h,
			'size'		=> image_hwstring( $w, $h )
		);
	}
	return $res_arr;
}

/**
 * Create html tag.
 *
 * @return object.
 *
 * @since presscore 0.1
 */
function dt_create_tag( $type, $options ) {
	switch( $type ) {
		case 'checkbox': return new DT_Mcheckbox( $options );
		case 'radio': return new DT_Mradio( $options );
		case 'select': return new DT_Mselect( $options );
		case 'button': return new DT_Mbutton( $options );
		case 'text': return new DT_Mtext( $options );
		case 'textarea': return new DT_Mtextarea( $options );
		case 'link': return new DT_Mlink( $options );
	}
}

function the7_get_image_mime( $image ) {
	$ext = explode( '.', $image );

	if ( count( $ext ) <= 1 ) {
		return '';
	}

	$ext = end( $ext );

	switch ( $ext ) {
		case 'png':
			return image_type_to_mime_type( IMAGETYPE_PNG );
		case 'gif':
			return image_type_to_mime_type( IMAGETYPE_GIF );
		case 'jpg':
		case 'jpeg':
			return image_type_to_mime_type( IMAGETYPE_JPEG );
		case 'ico':
			return 'image/x-icon';
		default:
			return '';
	}
}

/**
 * Return current paged/page query var or 1 if it's empty.
 *
 * @since 7.1.1
 *
 * @return int
 */
function the7_get_paged_var() {
	$pg = get_query_var( 'page' );

	if ( ! $pg ) {
		$pg = get_query_var( 'paged' );
		$pg = $pg ? $pg : 1;
	}

	/**
	 * Filter the returned paged var.
	 *
     * @since 7.1.1
     *
     * @see the7_get_paged_var()
     *
	 * @param int Paged var.
	 */
	return apply_filters( 'the7_get_paged_var', absint( $pg ) );
}

/**
 * Get page template name.
 *
 * Return template name based on current post ID or empty string if fail's.
 *
 * @return string.
 */
function dt_get_template_name( $post_id = 0, $force_in_loop = false ) {
	global $post;

	// work in admin
	if ( is_admin() && !$force_in_loop ) {

		if ( isset($_GET['post']) ) {

			$post_id = $_GET['post'];
		} elseif( isset($_POST['post_ID']) ) {

			$post_id = $_POST['post_ID'];
		}
	}

	// work in the loop
	if ( !$post_id && isset($post->ID) ) {
		$post_id = $post->ID;
	}

	return get_post_meta( absint($post_id), '_wp_page_template', true );
}

/**
 * Get theme metaboxes ids list.
 *
 * Loock global $wp_meta_boxes for metaboxes with theme related id prefix (by default 'dt_page_box').
 *
 * @param $opts array. array('id', 'page').
 * @return array.
 */
function dt_admin_get_metabox_list( $opts = array() ) {
	global $wp_meta_boxes;

	$defaults = array(
		'id'    => 'dt_page_box',
		'page'  => 'page'
	);
	$opts = wp_parse_args( $opts, $defaults );

	$meta_boxes = array();

	foreach( array('side', 'normal') as $context ) {
		foreach( array('high', 'sorted', 'core', 'default', 'low') as $priority ) {
			if( isset($wp_meta_boxes[$opts['page']][$context][$priority]) ) {
				foreach ( (array) $wp_meta_boxes[$opts['page']][$context][$priority] as $id=>$box ) {
					if( false !== strpos( $id, $opts['id']) ) {
						$meta_boxes[] = $id; 
					}
				}
			}
		}
	}
	return $meta_boxes;
}

/**
 * Prepare data for categorizer.
 * Returns array or false.
 *
 * @return mixed
 */
function dt_prepare_categorizer_data( array $opts ) {
	$defaults = array(
		'taxonomy'          => null,
		'post_type'         => null,
		'all_btn'           => true,
		'other_btn'         => true,
		'select'            => 'all',
		'terms'             => array(),
		'post_ids'          => array(),
	);
	$opts = wp_parse_args( $opts, $defaults );

	if( !($opts['taxonomy'] && $opts['post_type'] && is_array($opts['terms'])) ) {
		return false;
	}

	if ( !empty($opts['post_ids']) && 'all' != $opts['select'] ) {
		$opts['post_ids'] = array_map( 'intval', array_values($opts['post_ids']) );

		$query_args = array(
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post_type' => $opts['post_type'],
			'suppress_filters' => false,
		);

		if ( 'except' == $opts['select'] ) {
			$query_args['post__not_in'] = $opts['post_ids'];
		}

		if ( 'only' == $opts['select'] ) {
			$query_args['post__in'] = $opts['post_ids'];
		}

		// check if posts exists
		$check_posts = new WP_Query( $query_args );

		if ( ! $check_posts->have_posts() ) {
			return false;
		}

		$opts['post_ids'] = wp_list_pluck( $check_posts->posts, 'ID' );
		$posts_terms = wp_get_object_terms( $opts['post_ids'], $opts['taxonomy'], array( 'fields' => 'all_with_object_id' ) );

		if( is_wp_error($posts_terms) ) {
			return false;
		}

		$opts['terms'] = wp_list_pluck( $posts_terms, 'term_id' );
		$opts['select'] = 'only';
	}

	$args = array(
		'type' => $opts['post_type'],
		'hide_empty' => true,
		'hierarchical' => false,
		'orderby' => 'slug',
		'order' => 'ASC',
		'taxonomy' => $opts['taxonomy'],
		'pad_counts' => false,
		'include' => array(),
	);

	if ( isset( $opts['terms']['child_of'] ) ) {
		$args['child_of'] = $opts['terms']['child_of'];
		$args['hide_empty'] = 0;
		unset( $opts['terms']['child_of'] );
	}

	if ( ! empty( $opts['terms'] ) ) {
		$terms_arr = array_map( 'intval', array_values( $opts['terms'] ) );

		if ( 'except' == $opts['select'] ) {
			$args['exclude'] = $terms_arr;
		}

		if ( 'only' == $opts['select'] ) {
			$args['include'] = $terms_arr;
		}
	}

	/**
	 * Filter get_categories() args.
     *
     * @since 6.8.0
     *
     * @param array $args get_categories() args.
	 */
	$terms = get_categories( apply_filters( 'dt_prepare_categorizer_data_categories_args', $args ) );

	return array(
		'terms'         => $terms,
		'all_count'     => false,
		'other_count'   => false,
	);
}

/**
 * Get symplyfied post mime type.
 *
 * @param $post_id int
 *
 * @return string Mime type
 */
function dt_get_short_post_myme_type( $post_id = '' ) {
	$mime_type = get_post_mime_type( $post_id );
	if ( $mime_type ) {
		$mime_type = current(explode('/', $mime_type));
	}
	return $mime_type;
}

/**
 * Returns oembed generated html based on $src or false.
 *
 * @param $src string
 * @param $width mixed
 * @param $height mixed
 *
 * @return mixed.
 */
function dt_get_embed( $src, $width = '', $height = '' ) {
    $the7_embed = new The7_Embed( $src );
	$the7_embed->set_width( $width );
	$the7_embed->set_height( $height );

	return $the7_embed->get_html();
}

/**
 * Inner left join filter for query.
 *
 * @param $parts array
 *
 * @return array
 */
function dt_core_join_left_filter( $parts ) {
	if( isset($parts['join']) && !empty($parts['join']) ) {
		$parts['join'] = str_replace( 'INNER', 'LEFT', $parts['join']);
	}
	return $parts;
}

/**
 * Order sanitize filter.
 *
 * @param $order string
 *
 * @return string
 */
function dt_sanitize_order( $order = '' ) {
	return in_array($order, array('ASC', 'asc')) ? 'ASC' : 'DESC';
}
add_filter( 'dt_sanitize_order', 'dt_sanitize_order', 15 );

/**
 * Orderby sanitize filter.
 *
 * @param $orderby string
 *
 * @return string
 */
function dt_sanitize_orderby( $orderby = '' ) {
	$orderby_values = array(
		'none',
		'ID',
		'author',
		'title',
		'name',
		'date',
		'modified',
		'parent',
		'rand',
		'comment_count',
		'menu_order',
		'meta_value',
		'meta_value_num',
		'post__in',
	);

	return in_array($orderby, $orderby_values) ? $orderby : 'date';
}
add_filter( 'dt_sanitize_orderby', 'dt_sanitize_orderby', 15 );

/**
 * Posts per page sanitize.
 *
 * @param $ppp mixed (string/integer)
 *
 * @return int
 */
function dt_sanitize_posts_per_page( $ppp = '', $max = -1 ) {
	$ppp = intval($ppp);
	return $ppp <= 0 || ($max > 0 && $ppp >= $max) ? -1 : $ppp;
}
add_filter('dt_sanitize_posts_per_page', 'dt_sanitize_posts_per_page', 15, 2);

/**
 * Flag sanitize.
 *
 * @param $flag string
 *
 * @return boolean
 */
function dt_sanitize_flag( $flag = '' ) {
	return in_array($flag, array('1', 'true', 'y', 'on', 'enabled'));
}
add_filter( 'dt_sanitize_flag', 'dt_sanitize_flag', 15 );

/**
 * Get attachment data by id.
 * Source http://wordpress.org/ideas/topic/functions-to-get-an-attachments-caption-title-alt-description
 *
 * Return attachment meta array if $attachment_id is valid, other way return false.
 *
 * @param $attachment_id int
 *
 * @return mixed
 */
function dt_get_attachment( $attachment_id ) {

	$attachment = get_post( $attachment_id );

	if ( !$attachment || is_wp_error($attachment) ) {
		return false;
	}

	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}

/**
 * Check if current page is login page.
 *
 * @return boolean
 */
function dt_is_login_page() {

	return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
}

/**
 * Get current admin page name.
 *
 * @return string
 */
function dt_get_current_page_name() {

	if ( isset($GLOBALS['pagenow']) && is_admin() ) {

		return $GLOBALS['pagenow'];
	} else {

		return false;
	}
}

/**
 * Count words based on wp_trim_words() function.
 *
 * @param $text string
 * @param $num_words int
 *
 * @return int
 */
function dt_count_words( $text, $num_words = 55 ) {
	$text = wp_strip_all_tags( $text );
	/* translators: If your word count is based on single characters (East Asian characters),
	   enter 'characters'. Otherwise, enter 'words'. Do not translate into your own language. */
	if ( 'characters' == _x( 'words', 'word count: words or characters?', 'the7mk2' ) && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
		$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
		preg_match_all( '/./u', $text, $words_array );
		$words_array = array_slice( $words_array[0], 0, null );
	} else {
		$words_array = preg_split( "/[\n\r\t ]+/", $text, -1, PREG_SPLIT_NO_EMPTY );
	}

	return count( $words_array );
}

/**
 * Simple function to print from the filter array.
 *
 * @see http://stackoverflow.com/questions/5224209/wordpress-how-do-i-get-all-the-registered-functions-for-the-content-filter
 */
function dt_print_filters_for( $hook = '' ) {
	global $wp_filter;

	if( empty( $hook ) || !isset( $wp_filter[$hook] ) ) {
		return;
	}

	print '<pre>';
	print_r( $wp_filter[$hook] );
	print '</pre>';
}

/**
 * Get next post url.
 *
 * @param int $max_page Optional. Max page.
 *
 * @return string
 */
function dt_get_next_posts_url( $max_page = 0 ) {
	global $paged, $wp_query;

	if ( ! $paged = (int) get_query_var( 'page' ) ) {
		$paged = (int) get_query_var( 'paged' );
	}

	if ( ! $max_page ) {
		$max_page = $wp_query->max_num_pages;
	}

	if ( ! $paged ) {
		$paged = 1;
	}

	$nextpage = (int) $paged + 1;

	if ( ! $max_page || $max_page >= $nextpage ) {
		return get_pagenum_link( $max_page );
	}

	return '';
}

function dt_is_woocommerce_enabled() {
	return class_exists( 'Woocommerce' );
}

function dt_the7_core_is_enabled() {
    return function_exists( 'The7PT' );
}

function dt_is_legacy_mode() {
	return Presscore_Modules_Legacy::is_legacy_mode_active();
}

/**
 * @todo: Remove in 5.7.0
 *
 * @deprecated
 * @return bool
 */
function dt_is_plugins_silenced() {
	return false;
}

function dt_make_image_src_ssl_friendly( $src ) {
	$ssl_friendly_src = (string) $src;
	if ( is_ssl() ) {
		$ssl_friendly_src = str_replace('http:', 'https:', $ssl_friendly_src);
	}
	return $ssl_friendly_src;
}

function dt_array_push_after( $src, $in, $pos ) {
	if ( is_int( $pos ) ) {
		$R = array_merge( array_slice( $src, 0, $pos + 1 ), $in, array_slice( $src, $pos+1 ) );
	} else {
		foreach( $src as $k => $v ) {
			if ( is_int( $k ) ) {
				$R[] = $v;
			} else {
				$R[ $k ] = $v;
			}

			if ( $k === $pos ) {
				$R = array_merge( $R, $in );
			}
		}
	}
	return $R;
}

function dt_plugin_dir_relative_path( $file ) {
	$regexp = array( '/\\\/', '/\/\//' );
	$plugin_path = preg_replace( $regexp, '/', plugin_dir_path( $file ) );
	$template_path = preg_replace( $regexp, '/', get_template_directory() );
	$stylesheet_path = preg_replace( $regexp, '/', get_stylesheet_directory() );
	return str_replace( array( $stylesheet_path, $template_path ), '', $plugin_path );
}

function presscore_get_post_type_edit_link( $post_type, $text = null ) {
	$link = '';
	if ( post_type_exists( $post_type ) ) {
		$link = '<a href="' . esc_url( add_query_arg( 'post_type', $post_type, get_admin_url() . 'edit.php' ) ) . '" target="_blank">' . ( $text ? $text : _x( 'Edit post type', 'backend', 'the7mk2' ) ) . '</a>';
	}
	return $link;
}

if ( ! function_exists( 'presscore_config' ) ) :

	/**
	 * @return Presscore_Config
	 */
	function presscore_config() {
		return Presscore_Config::get_instance();
	}

endif;

if ( ! function_exists( 'presscore_get_template_part' ) ) :

	function presscore_get_template_part( $interface, $slug, $name = null, $args = array() ) {
		return presscore_template_manager()->get_template_part( $interface, $slug, $name, $args );
	}

endif;

if ( ! function_exists( 'presscore_template_manager' ) ) :

	function presscore_template_manager() {
		static $instance = null;
		if ( null === $instance ) {
			$instance = new The7_Template_Manager();
		}
		return $instance;
	}

endif;

if ( ! function_exists( 'presscore_query' ) ) :

	function presscore_query() {
		static $instance = null;
		if ( null === $instance ) {
			$instance = new The7_Query();
		}
		return $instance;
	}

endif;

if ( ! function_exists( 'presscore_load_template' ) ) :

	function presscore_load_template( $_template_file, $args = array(), $require_once = true ) {
		return presscore_template_manager()->load_template( $_template_file, $args, $require_once );
	}

endif;

function presscore_split_classes( $class ) {
	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_map( 'esc_attr', $class );
	}

	return $classes;
}

function presscore_sanitize_classes( $classes ) {
	$classes = array_map( 'esc_attr', $classes );
	$classes = array_filter( $classes );
	$classes = array_unique( $classes );
	return $classes;
}

function presscore_theme_is_activated() {
	return ( 'yes' === get_site_option( 'the7_registered' ) );
}

function presscore_activate_theme() {
	update_site_option( 'the7_registered', 'yes' );
	do_action( 'the7_after_theme_activation' );
}

function presscore_deactivate_theme() {
	delete_site_option( 'the7_registered' );
	do_action( 'the7_after_theme_deactivation' );
}

function presscore_delete_purchase_code() {
	delete_site_option( 'the7_purchase_code' );
}

function presscore_get_purchase_code() {
	return get_site_option( 'the7_purchase_code' );
}

function presscore_get_censored_purchase_code() {
	$code = presscore_get_purchase_code();
	$starred_part = substr( $code, 4, -4 );
	if ( $starred_part ) {
		$code = str_replace( $starred_part, str_repeat( '*', strlen( $starred_part ) ), $code );
	}

	return $code;
}

/**
 * Check if silence mode enabled
 *
 * @return boolean
 */
function presscore_is_silence_enabled() {
	return presscore_theme_is_activated() && The7_Admin_Dashboard_Settings::get( 'silence-purchase-notification' );
}

/**
 * Wrapper for set_time_limit to see if it is enabled.
 *
 * @since 6.4.0
 * @param int $limit Time limit.
 */
function the7_set_time_limit( $limit = 0 ) {
	if ( function_exists( 'set_time_limit' ) && false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
		@set_time_limit( $limit ); // @codingStandardsIgnoreLine
	}
}

if ( ! function_exists( 'the7_get_theme_version' ) ):

	/**
     * Returns parent theme version.
     *
     * @TODO: Remove in 6.1.0
     *
     * @deprecated
     *
	 * @return false|string
	 */
    function the7_get_theme_version() {
        return THE7_VERSION;
    }

endif;

/**
 * Add a submenu page after specified submenu page.
 *
 * This function takes a capability which will be used to determine whether
 * or not a page is included in the menu.
 *
 * The function which is hooked in to handle the output of the page must check
 * that the user has the required capability as well.
 *
 * @since 7.0.0
 *
 * @global array $submenu
 * @global array $menu
 * @global array $_wp_real_parent_file
 * @global bool  $_wp_submenu_nopriv
 * @global array $_registered_pages
 * @global array $_parent_pages
 *
 * @param string   $parent_slug The slug name for the parent menu (or the file name of a standard
 *                              WordPress admin page).
 * @param string   $page_title  The text to be displayed in the title tags of the page when the menu
 *                              is selected.
 * @param string   $menu_title  The text to be used for the menu.
 * @param string   $capability  The capability required for this menu to be displayed to the user.
 * @param string   $menu_slug   The slug name to refer to this menu by. Should be unique for this menu
 *                              and only include lowercase alphanumeric, dashes, and underscores characters
 *                              to be compatible with sanitize_key().
 * @param callable $function    The function to be called to output the content for this page.
 * @param string $insert_after  Insert after menu item with that slug.
 * @return false|string The resulting page's hook_suffix, or false if the user does not have the capability required.
 */
function the7_add_submenu_page_after( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '', $insert_after = '' ) {
	$hook = add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );

	if ( $hook && $insert_after ) {
		global $submenu;

		$menu_slug   = plugin_basename( $menu_slug );
		$new_submenu = array();
		foreach ( $submenu[ $parent_slug ] as $i => $item ) {
			if ( $item[2] === $menu_slug ) {
				continue;
			}

			isset( $new_submenu[ $i ] ) ? $new_submenu[] = $item : $new_submenu[ $i ] = $item;
			if ( $item[2] === $insert_after ) {
				$new_submenu[] = array( $menu_title, $capability, $menu_slug, $page_title );
			}
		}
		$submenu[ $parent_slug ] = $new_submenu;
	}

	return $hook;
}