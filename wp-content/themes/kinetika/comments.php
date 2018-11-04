<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!','mthemelocal'));

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'mthemelocal' ); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
<div class="commentform-wrap entry-content">
	<h2 id="comments">
		<?php
			printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'mthemelocal' ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h2>

	<div class="comment-nav">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php 
	$avatar_size=get_option( MTHEME . '_avatar_size' );
	if ( empty($avatar_size) ) { $avatar_size=64; }
	wp_list_comments( 'avatar_size=' . $avatar_size ); 
	?>
	</ol>

	<div class="comment-nav">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="no-comments"><?php _e( 'Comments are closed.', 'mthemelocal' ); ?></p>
	<?php endif; ?>
<?php endif; ?>

<?php
if ( comments_open() ) {
	echo '<div id="commentform-section">';
	$form_args = array( 'title_reply' => __('Leave a reply','mthemelocal') );
	comment_form( $form_args );
	echo '</div>';
}
?>

