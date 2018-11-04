<?php
/**
*  loop attachment
 */
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php // get_sidebar(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-wrapper entry-content clearfix">
						<?php
						// Show Image
						if ( wp_attachment_is_image() ) :
							?>
							<?php
							echo mtheme_activate_lightbox (
							$lightbox_type="magnific",
							$ID=get_the_ID(),
							$link=wp_get_attachment_url(),
							$mediatype="video",
							$imagetitle=$post->post_title,
							$class="",
							$navigation="magnific-image-gallery"
							);
							?>
								<?php
								echo mtheme_display_post_image (
									$post->ID,
									$have_image_url=false,
									$link=false,
									$type="fullwidth",
									$post->post_title,
									$class="" 
								);
								?>
							</a>
							<?php
						endif;
						?>
						
						<div class="navigation">
							<div class="nav-previous">
							<?php //previous_image_link( array( 35, 35 ) ); ?>
							<span>&nbsp;</span>
							<?php previous_image_link( false , __('<i class="feather-icon-arrow-left"></i>','mthemelocal') ); ?>
							
							</div>
							<div class="nav-lightbox">
								<?php
								echo mtheme_activate_lightbox (
								$lightbox_type="magnific",
								$ID=get_the_ID(),
								$link=wp_get_attachment_url(),
								$mediatype="video",
								$imagetitle=$post->post_title,
								$class="",
								$navigation="magnific-image-gallery"
								);
								?>
									<?php _e('<i class="feather-icon-search"></i>','mthemelocal'); ?>
								</a>
							</div>
							<div class="nav-next">
							<?php //next_image_link( array( 35, 35 ) ); ?>
							<?php next_image_link( false , __('<i class="feather-icon-arrow-right"></i>','mthemelocal') ); ?>
							</div>
						</div><!-- #nav-below -->
						
						<div class="entry-attachment">
						<?php if ( wp_attachment_is_image() ) :
							$attachments = array_values( get_children( array( 
										'post_parent' => $post->post_parent, 
										'post_status' => 'inherit', 
										'post_type' => 'attachment', 
										'post_mime_type' => 'image', 
										'order' => 'ASC', 
										'orderby' => 'menu_order ID' ) ) );
										
							foreach ( $attachments as $k => $attachment ) {
								if ( $attachment->ID == $post->ID )
									break;
							}
							$k++;
							// If there is more than 1 image attachment in a gallery
							if ( count( $attachments ) > 1 ) {
								if ( isset( $attachments[ $k ] ) )
									// get the URL of the next image attachment
									$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
								else
									// or get the URL of the first image attachment
									$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
							} else {
								// or, if there's only 1 image attachment, get the URL of the image
								$next_attachment_url = wp_get_attachment_url();
							}
						?>
						<?php else : ?>
						<a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment">
							<?php echo basename( get_permalink() ); ?>
						</a>
						<?php endif; ?>
						</div><!-- .entry-attachment -->
			
						<?php the_excerpt(); ?>

		<div class="always-center">
				<?php
				if ( is_single() && !post_password_required() ) {
					get_template_part('/includes/share','this');
				}
				?>
		</div>
						<?php 
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>
						<div class="clear"></div>			
					</div>
			</div>

<?php endwhile; // end of the loop. ?>