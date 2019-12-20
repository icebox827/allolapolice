<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to presscore_comment() which is
 * located in the inc/template-hooks.php file.
 *
 * @since 1.0.0
 *
 * @package The7\Templates
 */

defined( 'ABSPATH' ) || exit;

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() || ( ! comments_open() && 0 === (int) get_comments_number() ) ) {
	return;
}
?>

	<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3><?php comments_number(); ?></h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

		<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'the7mk2' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'the7mk2' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'the7mk2' ) ); ?></div>
		</nav><!-- #comment-nav-before .site-navigation .comment-navigation -->

		<?php endif; ?>

		<ol class="comment-list">
			<?php
				/**
				 * Loop through and list the comments. Tell wp_list_comments()
				 * to use presscore_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define presscore_comment() and that will be used instead.
				 * See presscore_comment() in inc/template-hooks.php for more.
				 */
				wp_list_comments( array( 'callback' => 'presscore_comment' ) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'the7mk2' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'the7mk2' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'the7mk2' ) ); ?></div>
		</nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
		<?php endif; ?>

	<?php endif; ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && 0 !== (int) get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'the7mk2' ); ?></p>
	<?php endif ?>
	<?php
	global $user_identity;

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? 'aria-required="true"' : '' );
	// translators: %s - required mark.
	$required_text = sprintf( ' ' . __( 'Required fields are marked %s', 'the7mk2' ), '<span class="required">*</span>' );
	$consent       = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$comment_form_args = array(

		'fields'               => apply_filters(
			'comment_form_default_fields',
			array(

				'author'  => '<div class="form-fields"><span class="comment-form-author">' . '<label class="assistive-text" for="author">' . __( 'Name &#42;', 'the7mk2' ) . '</label><input id="author" name="author" type="text" placeholder="' . __( 'Name&#42;', 'the7mk2' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' /></span>',

				'email'   => '<span class="comment-form-email"><label class="assistive-text" for="email">' . __( 'Email &#42;', 'the7mk2' ) . '</label><input id="email" name="email" type="text" placeholder="' . __( 'Email&#42;', 'the7mk2' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' /></span>',

				'url'     => '<span class="comment-form-url"><label class="assistive-text" for="url">' . __( 'Website', 'the7mk2' ) . '</label><input id="url" name="url" type="text" placeholder="' . __( 'Website', 'the7mk2' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></div>',

				'cookies' => '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" ' . $consent . ' /><label for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'the7mk2' ) . '</label></p>',

			)
		),

		'comment_field'        => '<p class="comment-form-comment"><label class="assistive-text" for="comment">' . __( 'Comment', 'the7mk2' ) . '</label><textarea id="comment" placeholder="' . __( 'Comment', 'the7mk2' ) . '" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',

		// translators: %s - login url.
		'must_log_in'          => '<p class="must-log-in text-small">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'the7mk2' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',

		// translators: %1$s - profile url, %2$s - user display name, %3$s - logout url.
		'logged_in_as'         => '<p class="logged-in-as text-small">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'the7mk2' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',

		'comment_notes_before' => '<p class="comment-notes text-small">' . __( 'Your email address will not be published.', 'the7mk2' ) . ( $req ? $required_text : '' ) . '</p>',

	);
	?>

	<?php comment_form( $comment_form_args ); ?>

	</div><!-- #comments .comments-area -->
