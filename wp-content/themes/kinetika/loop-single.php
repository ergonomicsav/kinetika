<?php
$postformat = get_post_format();
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="post-<?php echo esc_attr($postformat); ?>-wrapper">
			<?php 
			$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
			if (isSet($isactive) && $isactive==1) {
				if ( post_password_required() ) {
					echo '<div class="entry-content postformat_contents clearfix">';
						echo '<div class="fullcontent-spacing title-container-wrap">';
							echo get_the_password_form();
						echo '</div>';
					echo '</div>';
				} else {
					$builder_data = do_shortcode('[template id="'.$post->ID.'"]');
					echo '<div class="entry-content">';
					echo $builder_data;
					echo '</div>';
				}
			} else {
				get_template_part( 'includes/postformats/default' );				
			}
			?>
			<?php comments_template(); ?>
		</div>
<?php endwhile; // end of the loop. ?>