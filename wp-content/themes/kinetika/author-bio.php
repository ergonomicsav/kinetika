<div class="entry-content author-info">
	<h2 class="author-heading"><?php _e( 'Published by', 'mthemelocal' ); ?></h2>
	<div class="author-avatar">
		<?php
		$author_bio_avatar_size = apply_filters( 'mtheme_author_bio_avatar_size', 60 );
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h3 class="vcard author author-title"><span class="fn"><?php echo get_the_author(); ?></span></h3>

		<div class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<div class="autho-linked-button">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
					<div class="mtheme-button animated pulse animation-action"><?php printf( __( 'Posts by %s', 'mthemelocal' ), get_the_author() ); ?></div>
				</a>
			</div>
		</div><!-- .author-bio -->
	</div><!-- .author-description -->
</div><!-- .author-info -->
