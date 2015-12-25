<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php
		$fields =  array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? '<span class="required"> *</span>' : '' ) . '</label> ' .
						'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? '<span class="required"> *</span>' : '' ) .'</label> ' .
						'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>'
		); 
	?>
	<?php	
		$comments_args = array(
	        'comment_notes_after' => '',
	        'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	        'comment_field' => '<p class="comment-form-comment"><label for="comment">Введите текст отзыва</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
	        'title_reply' => 'Оставить отзыв',
	        'label_submit' => 'Отправить',
	        'title_reply_to' => 'Ответить на отзыв %s'
		);
	?>

	<?php comment_form($comments_args); ?>

	<?php if ( have_comments() ) : ?>

		<?php // twentyfifteen_comment_nav(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => false,
					'avatar_size' => 230,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php // twentyfifteen_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
	<?php endif; ?>

</div><!-- .comments-area -->