<?php
/*
 Single Portfolio Page
*/
?>
<?php get_header(); ?>
<?php
/**
*  Portfolio Loop
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php

		global $mtheme_portfolio_current_post;
		$mtheme_portfolio_current_post=$post;
		$width=MTHEME_FULLPAGE_WIDTH;
		$portfolio_page_header="";
		$portfolio_client="";
		$portfolio_projectlink="";
		$portfolio_client_link="";
		
		$custom = get_post_custom($post->ID);
		$mtheme_pagestyle="fullwidth";
		if (isset($custom[MTHEME . '_pagestyle'][0])) $mtheme_pagestyle=$custom[MTHEME . '_pagestyle'][0];
		if (isset($custom[MTHEME . '_portfoliotype'][0])) $portfolio_page_header=$custom[MTHEME . '_portfoliotype'][0];
		if (isset($custom[MTHEME . '_video_embed'][0])) $portfolio_videoembed=$custom[MTHEME . '_video_embed'][0];
		if (isset($custom[MTHEME . '_customlink'][0])) $custom_link=$custom[MTHEME . '_customlink'][0];
		if (isset($custom[MTHEME . '_clientname'][0])) $portfolio_client=$custom[MTHEME . '_clientname'][0];
		if (isset($custom[MTHEME . '_clientname_link'][0])) $portfolio_client_link=$custom[MTHEME . '_clientname_link'][0];
		if (isset($custom[MTHEME . '_projectlink'][0])) $portfolio_projectlink=$custom[MTHEME . '_projectlink'][0];
		if (isset($custom[MTHEME . '_skills_required'][0])) $portfolio_skills_required=$custom[MTHEME . '_skills_required'][0];

		if ( isset($custom[MTHEME . '_ajax_description'][0])) {
			$description=$custom[MTHEME . '_ajax_description'][0];
			$description=nl2br($description);
		}

		$floatside="float-left";
		$two_column='two-column';
		$floatside_portfolio="float-left";
		$fullwidth_column='';
		$floatside_portfolio_opp = "float-right";
		if ($mtheme_pagestyle=="edge-to-edge") { $floatside=""; $two_column=""; $fullwidth_column="edge-to-edge-column"; $floatside_portfolio = ""; $floatside_portfolio_opp = "";}
		if ($mtheme_pagestyle=="fullwidth") { $floatside=""; $two_column=""; $fullwidth_column="fullwidth-column"; $floatside_portfolio = ""; $floatside_portfolio_opp = "";}
		if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; $floatside_portfolio = $floatside; $floatside_portfolio_opp = "float-right"; }
		if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; $floatside_portfolio = $floatside; $floatside_portfolio_opp = "float-left";}

		if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" ) {
			$mtheme_pagestyle="rightsidebar";
			$floatside="float-left";
		}
		if ( post_password_required() ) {
			$mtheme_pagestyle="";
			$floatside="";
			$two_column="";
		}

		if ( post_password_required() ) {
			$two_column="";
			$floatside_portfolio="";
		}

		$image_size_type = "gridblock-full";
		if ( $two_column == "two-column" ) {
			$image_size_type = "gridblock-full-medium";
		}

?>
	<div class="portfolio-header-wrap <?php echo esc_attr($fullwidth_column); ?> clearfix">
		<div class="portfolio-header-left entry-content <?php echo esc_attr($mtheme_pagestyle) . ' ' . esc_attr($two_column); ?> <?php echo esc_attr($floatside_portfolio); ?>">
		<?php
		$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
		$page_builder_mode = false;
		if (isSet($isactive) && $isactive==1) {
			$page_builder_mode = true;
		}
		if (!$page_builder_mode) {
			if ( ! post_password_required() ) {
				
				switch ($portfolio_page_header) {

					case "Metro" :
						$metro_grid = do_shortcode('[metrogrid edgetoedge="true" pageid="'.get_the_id().'"]');
						echo $metro_grid;
						
					break;

					case "beforeafter" :
						$beforeafter = do_shortcode('[beforeafter urls="attachment_images"]');
						echo $beforeafter;
						
					break;

					case "Slideshow" :
						$flexi_slideshow = do_shortcode('[slideshowcarousel padeid=""]');
						echo $flexi_slideshow;
						
					break;
					case "Vertical" :
						$mtheme_thepostID=$post->ID;
						//global $mtheme_thepostID;
						$vertical_images = do_shortcode('[vertical_images pageid="'.get_the_id().'" imagesize="'.$image_size_type.'"]');
						echo $vertical_images;
					break;
					case "Image" :
						// Show Image			
						echo mtheme_display_post_image (
							$post->ID,
							$have_image_url=false,
							$link=false,
							$type="fullwidth",
							$post->post_title,
							$class="portfolio-single-image" 
						);

					break;
					case "Video" :
						echo '<div class="fitVids">';
							echo $portfolio_videoembed;
						echo '</div>';
						$vertical_images = do_shortcode('[vertical_images pageid="'.get_the_id().'" imagesize="'.$image_size_type.'"]');
						echo $vertical_images;
					break;
					
				}
			}
		}
		if (!$page_builder_mode) {
			if ( $mtheme_pagestyle == "portfolio_default" && !post_password_required() ) {
				get_template_part('/includes/share','this');
			}
		} else {
			if ($mtheme_pagestyle !="rightsidebar" && $mtheme_pagestyle !="leftsidebar" ) {
				$mtheme_pagestyle='';
			}
		}
		if ( $mtheme_pagestyle != "portfolio_default" ) {
		?>
						
				<div class="entry-portfolio-content entry-content clearfix">
				<?php
				if ( post_password_required() ) {
					echo '<div class="entry-content" id="password-protected">';
					echo get_the_password_form();
					if (MTHEME_DEMO_STATUS) { echo '<h2>DEMO Password is 1234</h2>'; }
					echo '</div>';
				} else {
					if ($page_builder_mode) {
						$builder_data = do_shortcode('[template id="'.$post->ID.'"]');
						echo $builder_data;
					} else {
						if ( have_posts() ) while ( have_posts() ) : the_post();
							the_content();
						endwhile;
						if ( !post_password_required() ) {
							get_template_part('/includes/share','this');
						}
					}
				}
				?>
				</div>

			</div>
		<?php
				if ( ! post_password_required() ) {
					global $mtheme_pagestyle;
					if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
						get_sidebar();
					}
				}
		?>
		</div>
		<?php
		} else {
		?>
		<?php
		}
		if ( $mtheme_pagestyle == "portfolio_default" ) {
		?>
		</div>
		<div class="portfolio-details-section portfolio-header-right <?php echo esc_attr($floatside_portfolio_opp); ?>">
			<div class="portfolio-details-section-inner entry-content portfolio-header-right-inner">

				<h2 class="project-heading"><?php echo of_get_option('portfolio_project_desc'); ?></h2>
				<div class="portfolio-content-summary entry-content">
				<?php
				if ( have_posts() ) while ( have_posts() ) : the_post();
					the_content();
				endwhile;
				?>
				</div>
				
				<div class="portfolio-details-wrap">
					<div class="portfolio-details-inner">
						<?php
						if ( isSet($portfolio_client) && !empty($portfolio_client) || isSet($portfolio_projectlink) && !empty($portfolio_projectlink) || isSet($portfolio_skills_required) && !empty($portfolio_skills_required) ) {
						?>
							<h2 class="project-heading"><?php echo of_get_option('portfolio_project_details'); ?></h2>
							<?php
							if ( isSet($portfolio_client) && !empty($portfolio_client) ) {
							?>
								<div class="project-details project-info clearfix">
									<?php if ( $portfolio_client ) { echo '<h4>' . of_get_option('portfolio_client_refer') . '</h4>'; } ?>
									<?php if ( $portfolio_client_link !='' ) { echo '<a class="client-link" href="'.$portfolio_client_link .'">'; } ?>
										<?php echo '<span>'.$portfolio_client.'</span>'; ?>
									<?php if ( $portfolio_client_link !='' ) { echo '</a>'; } ?>
								</div>
							<?php
							}
							?>
							<?php
							if ( isSet($portfolio_skills_required) && !empty($portfolio_skills_required) ) {
							?>
								<div class="project-details project-info project-skills-column">
									<?php
									if (isSet($portfolio_skills_required)) {
									?>
										<h4><?php echo of_get_option('portfolio_skill_refer'); ?></h4>
										<?php
										$skills_user = $portfolio_skills_required;
										$skills = explode(',', $skills_user);

									    $skill_list = '<ul>';
									    	foreach( $skills as $skill ):
									    $skill_list .= '<li>';
									    $skill_list .= $skill;
									    $skill_list .= '</li>';
									    	endforeach;
									    $skill_list .= '</ul>';
									    echo $skill_list;
									}
								    ?>
								</div>
							<?php
							}
							if ( isSet($portfolio_projectlink) && !empty($portfolio_projectlink) ) {
							?>
							<div class="project-details-link clear">
								<?php
									echo '<i class="feather-icon-link"></i><h4><a href="'.esc_url($portfolio_projectlink).'">'.of_get_option('portfolio_link_text').'</a></h4>';
								?>
							</div>
							<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
		<?php
		}
		?>
		<?php
		if ( ! post_password_required() ) {
		if (of_get_option('portfolio_comments')) {
			if ( comments_open() ) {
			?>
			<div class="portfolio-header-wrap entry-content clearfix">
				<div class="two-column float-left">
				<?php
					comments_template();
				?>
				</div>
			</div>
			<?php
			}
		}
		}
		?>
	</div>
<?php
if (isset($custom[MTHEME . '_pagestyle'][0])) {
	$mtheme_pagestyle=$custom[MTHEME . '_pagestyle'][0];
}
$portfolio_itemcarousel = "enable";
if (isset($custom[MTHEME . '_portfolio_itemcarousel'][0])) {
	$portfolio_itemcarousel=$custom[MTHEME . '_portfolio_itemcarousel'][0];
	if ( $portfolio_itemcarousel == "default" ) {
		$portfolio_itemcarousel = "enable";
	}
}
if (is_singular('mtheme_portfolio') ) {
	if ( ! post_password_required() ) {
		if (of_get_option('portfolio_recently') && $portfolio_itemcarousel=="enable" ) {
	?>
	<div class="portfolio-end-block portfolio-header-wrap clearfix">
		<div class="portfolio-section-heading section-align-center">
			<h2 class="section-title"><?php echo of_get_option('portfolio_carousel_heading'); ?></h2>
		</div>
		<?php
		$orientation = of_get_option('portfolio_related_format');
		if ($orientation == 'portrait') {
			$column_slots = 3;
		} else {
			$column_slots = 3;
		}
		echo do_shortcode('[workscarousel pagination="false" format="'.$orientation.'" worktype_slug="" boxtitle=true columns='.$column_slots.']');
		?>
	</div>
	<?php
		}
	}
}
?>
<?php get_footer(); ?>