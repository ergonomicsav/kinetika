<?php
/*
Template Name: 100% Width Page
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
	<div id="homepage" class="<?php if ( is_front_page() ) { echo 'is-front-page'; } ?>">
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
						}
						?>
						</div>
			</div><!-- .entry-content -->

		<?php endwhile; else: ?>
	<?php endif; ?>
	</div>
	<?php
	}
	?>
<?php get_footer(); ?>