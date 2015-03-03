<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to seniores_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package seniores
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>

		<div class="crossroad-comments cb">
			<h3 id="comments" class="comments-title">
				<?php comments_number(__('0 Comments', 'sn'), __('1 Comment', 'sn'), __('% Comments', 'sn')); ?>
			</h3>
			<ul>
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use seniores_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define seniores_comment() and that will be used instead.
				 * See seniores_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'sn_comment' ) );
			?>
			</ul>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h5 class="vhide"><?php _e( 'Comment navigation', 'sn' ); ?></h5>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'sn' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'sn' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php else : ?>

		<h3 class="cb"><?php _e('No comments.', 'sn'); ?></h3>
		<div class="message message-notice">
			<p><?php _e('Be the first to post a comment.', 'sn') ?></p>
			<a href="#" class="close icon icon-close-box"><span class="vhide"><?php _e('Close', 'sn'); ?></span></a>
		</div>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<h2><?php _e( 'Comments are closed.', 'sn' ); ?></h2>
	<?php endif; ?>

	<?php

	if ( comments_open() ) :

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'class_submit'      => 'btn btn-s',
			'title_reply'       => __( 'Leave a Reply', 'sn' ),
			'title_reply_to'    => __( 'Leave a Reply to %s', 'sn' ),
			'cancel_reply_link' => __( 'Cancel Reply', 'sn' ),
			'label_submit'      => __( 'Post Comment', 'sn' ),

			'comment_field' =>  '<p class="comment-form-comment"><label for="comment" class="h6">' . __( 'Comment', 'sn' ) .
			'</label><span class="inp-fix"><textarea id="comment" name="comment" cols="100%" rows="6" aria-required="true" class="inp-text">' .
			'</textarea></span></p><p><button type="submit" name="submit" class="btn"><span>' . __( 'Post Comment', 'sn' ) . '</span></button></p>',

			'must_log_in' => '<p class="must-log-in">' .
			sprintf(
			__( 'You must be <a href="%s">logged in</a> to post a comment.', 'sn' ),
			wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
			sprintf(
			__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'sn' ),
			admin_url( 'profile.php' ),
			$user_identity,
			wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			) . '</p>',
			'comment_notes_after' => '',

			'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' =>
				'<p class="comment-form-author">' .
				'<label for="author" class="h6">' . __( 'Name', 'sn' ) . ( $req ? ' <span class="required">*</span>' : '' ) .'</label> ' .
				'<span class="inp-fix"><input id="author" name="author" type="text" class="inp-text" value="' . esc_attr( $commenter['comment_author'] ) .
				'" size="30"' . $aria_req . ' /></span></p>',

				'email' =>
				'<p class="comment-form-email"><label for="email" class="h6">' . __( 'Email', 'sn' ) . ( $req ? ' <span class="required">*</span>' : '' ) .'</label> ' .
				'<span class="inp-fix"><input id="email" name="email" type="text" class="inp-text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" size="30"' . $aria_req . ' /></span></p>',

				'url' =>
				'<p class="comment-form-url"><label for="url" class="h6">' .
				__( 'Website', 'sn' ) . '</label>' .
				'<span class="inp-fix"><input id="url" name="url" type="text" class="inp-text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				'" size="30" /></span></p>'
			)),
		);

	    comment_form($args);

	endif; // end if comments open check ?>
