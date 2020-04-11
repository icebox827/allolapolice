<?php
/**
 * Testimonial post template.
 */

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$post_id     = get_the_ID();
$config      = presscore_config();
$show_avatar = $config->get( 'show_avatar', true );
$avatar      = '';
if ( $show_avatar ) {
	$avatar = '<span class="alignleft no-avatar"></span>';

	if ( has_post_thumbnail( $post_id ) ) {
		$avatar = dt_get_thumb_img(
			array(
				'img_id'  => get_post_thumbnail_id( $post_id ),
				'options' => array( 'w' => 60, 'h' => 60 ),
				'echo'    => false,
				'wrap'    => '<img %IMG_CLASS% %SRC% %SIZE% %IMG_TITLE% %ALT% />',
			)
		);

		$avatar_wrap_class = 'alignleft';
		if ( presscore_lazy_loading_enabled() ) {
			$avatar_wrap_class .= ' layzr-bg';
		}

		$avatar = '<span class="' . $avatar_wrap_class . '">' . $avatar . '</span>';
	}
}

$position = get_post_meta( $post_id, '_dt_testimonial_options_position', true );
if ( $position ) {
	$position = '<span class="text-secondary color-secondary">' . esc_html( $position ) . '</span>';
}

$title = get_the_title();
if ( $title ) {
	$title = '<span class="text-primary">' . esc_html( $title ) . '</span>';
}

$details_link = '';
if ( get_post_meta( $post_id, '_dt_testimonial_options_go_to_single', true ) ) {
	$details_link = ' ' . presscore_post_details_link( null, array( 'more-link' ), esc_html__( 'read more', 'dt-the7-core' ) );
}
?>
<article>
	<div class="testimonial-content">
		<?php
		if ( $post->post_excerpt ) {
			echo apply_filters( 'the_excerpt', get_the_excerpt() . $details_link );
		} else {
			echo apply_filters( 'the_content', get_the_content() . $details_link );
		}
		?>
	</div>
	<div class="testimonial-vcard">
		<div class="testimonial-thumbnail">
			<?php echo $avatar ?>
		</div>
		<div class="testimonial-desc">
			<?php echo $title . $position ?>
		</div>
	</div>
</article>
