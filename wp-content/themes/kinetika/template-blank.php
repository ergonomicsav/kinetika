<?php
/*
Template Name: Blank Page
*/
?>
<?php get_header(); ?>
<?php
if ( post_password_required() ) {
	
	echo '<div id="password-protected">';

	if (MTHEME_DEMO_STATUS) { _e('<p><h2>DEMO Password is 1234</h2></p>','mthemelocal'); }
	echo get_the_password_form();
	echo '</div>';
	
	} else {
	?>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="entry-page-wrapper entry-content clearfix">
						<?php
						$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
						if (isSet($isactive) && $isactive==1) {
							$builder_data = do_shortcode('[template id="'.$post->ID.'"]');
							echo $builder_data;
						} else {
							the_content();
							wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'mthemelocal' ), 'after' => '</div>' ) );				
						}
						?>
						</div>
						
			</div><!-- .entry-content -->
		<?php endwhile; else: ?>
	<?php endif; ?>
	<?php
	}
	?>
<?php get_footer(); ?>