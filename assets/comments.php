<?php 
if ( post_password_required() ) {
	return;
}

$cpt_themename = basename(__DIR__) ; 


if ( have_comments() ) : ?>

<h2 class="comments-title">
<?php
	printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), $cpt_themename ),
		number_format_i18n( get_comments_number() ), get_the_title() );
?>
</h2>


<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
	<h1 class="screen-reader-text"><?php _e( 'Comment navigation', $cpt_themename ); ?></h1>
	<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', $cpt_themename ) ); ?></div>
	<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', $cpt_themename ) ); ?></div>
</nav><!-- #comment-nav-above -->
<?php endif; // Check for comment navigation. ?>


<ol class="comment_list">
	<?php
		wp_list_comments( array(
			'style'       => 'ol',
			'short_ping'  => true,
			'avatar_size' => 74,
		) );
	?>
</ol><!-- .comment_list -->

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
	<h1 class="screen-reader-text"><?php _e( 'Comment navigation', $cpt_themename ); ?></h1>
	<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', $cpt_themename ) ); ?></div>
	<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', $cpt_themename ) ); ?></div>
</nav><!-- #comment-nav-above -->
<?php endif; // Check for comment navigation. ?>

<?php if ( ! comments_open() ) : ?>
<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfourteen' ); ?></p>
<?php endif; ?>


<?php endif; // have_comments() ?>
