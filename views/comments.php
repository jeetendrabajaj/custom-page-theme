<?php

if ( post_password_required() )
	return;
?>

<?php if ( have_comments() ) : ?>
	<h2 class="comments_title">
		<?php
		echo "==>".get_the_title() ;
			//printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'twentythirteen' ),
			//	number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
		?>
	</h2>


<ol class="comment_list">
	<?php
		wp_list_comments( array(
			'style'       => 'ol',
			'short_ping'  => true,
			'avatar_size' => 74,
		) );
	?>
</ol><!-- .comment-list -->


<?php endif; // have_comments() ?>
