<?php
/*
*  Page
*/
?>
<?php get_header(); ?>
<?php
$event_startdate='';
$event_starttime='';
$event_endtime='';
$event_enddate='';
$event_notice='';
$event_venue_name='';
$event_venue_street='';
$event_venue_state='';
$event_venue_postal='';
$event_venue_country='';
$event_venue_phone='';
$event_venue_website='';
$event_venue_currency='';
$event_venue_cost='';

$custom = get_post_custom($post->ID);
if (isset($custom[MTHEME . '_event_startdate'][0])) $event_startdate=$custom[MTHEME . '_event_startdate'][0];
if (isset($custom[MTHEME . '_event_starttime'][0])) $event_starttime=$custom[MTHEME . '_event_starttime'][0];
if (isset($custom[MTHEME . '_event_endtime'][0])) $event_endtime=$custom[MTHEME . '_event_endtime'][0];
if (isset($custom[MTHEME . '_event_enddate'][0])) $event_enddate=$custom[MTHEME . '_event_enddate'][0];

if (isset($custom[MTHEME . '_event_notice'][0])) $event_notice=$custom[MTHEME . '_event_notice'][0];

if (isset($custom[MTHEME . '_event_venue_name'][0])) $event_venue_name=$custom[MTHEME . '_event_venue_name'][0];
if (isset($custom[MTHEME . '_event_venue_street'][0])) $event_venue_street=$custom[MTHEME . '_event_venue_street'][0];
if (isset($custom[MTHEME . '_event_venue_state'][0])) $event_venue_state=$custom[MTHEME . '_event_venue_state'][0];
if (isset($custom[MTHEME . '_event_venue_postal'][0])) $event_venue_postal=$custom[MTHEME . '_event_venue_postal'][0];
if (isset($custom[MTHEME . '_event_venue_country'][0])) $event_venue_country=$custom[MTHEME . '_event_venue_country'][0];
if (isset($custom[MTHEME . '_event_venue_phone'][0])) $event_venue_phone=$custom[MTHEME . '_event_venue_phone'][0];
if (isset($custom[MTHEME . '_event_venue_website'][0])) $event_venue_website=$custom[MTHEME . '_event_venue_website'][0];

if (isset($custom[MTHEME . '_event_venue_currency'][0])) $event_venue_currency=$custom[MTHEME . '_event_venue_currency'][0];
if (isset($custom[MTHEME . '_event_venue_cost'][0])) $event_venue_cost=$custom[MTHEME . '_event_venue_cost'][0];

if ( post_password_required() ) {
		echo '<div class="entry-content" id="password-protected">';
		echo get_the_password_form();
		if (MTHEME_DEMO_STATUS) { echo '<h2>DEMO Password is 1234</h2>'; }
		echo '</div>';
	} else {

	$filter_image_ids = mtheme_get_custom_attachments ( get_the_id() );
	$mtheme_pagestyle= get_post_meta($post->ID, MTHEME . '_pagestyle', true);
	$floatside="float-left";
	if ($mtheme_pagestyle=="nosidebar") { $floatside=""; }
	if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; }
	if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; }

	if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" ) {
		$mtheme_pagestyle="rightsidebar";
		$floatside="float-left";
	}
	$image_size_type = "gridblock-full-medium";
	if ( $mtheme_pagestyle=="fullwidth") {
		$floatside='';
		$image_size_type = "gridblock-full";
		$mtheme_pagestyle='nosidebar';
	}
	?>
	<div class="page-contents-wrap <?php echo esc_attr($floatside); ?> <?php if ($mtheme_pagestyle != "nosidebar") { echo 'two-column'; } ?>">

	<?php
	$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
	$page_builder_mode = false;
	if (isSet($isactive) && $isactive==1) {
		$page_builder_mode = true;
	}
	if ( !$page_builder_mode ) {
		if ( isSet($filter_image_ids) && $filter_image_ids[0]<>'' ) {
			$flexi_slideshow = do_shortcode('[slideshowcarousel padeid="" imagesize="'.$image_size_type.'"]');
			echo $flexi_slideshow;
		} else {
			// Show Image			
			echo mtheme_display_post_image (
				$post->ID,
				$have_image_url=false,
				$link=false,
				$type=$image_size_type,
				$post->post_title,
				$class="portfolio-single-image" 
			);
		}
		get_template_part('/includes/share','this');			
	}
	if ( $page_builder_mode ) {
		echo '<div class="entry-content">';
		$builder_data = do_shortcode('[template id="'.$post->ID.'"]');
		echo $builder_data;
		echo '</div>';
	}
	?>

			<div class="entry-content portfolio-details-section-inner events-inner">
			<?php
			if ( post_password_required() ) {
				// If password
			} else {
			?>
				<div class="portfolio-details-wrap">
					<?php
					$postponed_msg = of_get_option('events_postponed_msg');
					$cancelled_msg = of_get_option('events_cancelled_msg');
					switch ($event_notice) {
						case 'postponed':
							echo '<div class="entry-content events-notice">';
							echo do_shortcode('[alert type="blue" icon="mfont et-icon-linegraph"]'. $postponed_msg .'[/alert]');
							echo '</div>';
							break;
					case 'cancelled':
							echo '<div class="entry-content events-notice">';
							echo do_shortcode('[alert type="red" icon="mfont et-icon-caution"]'. $cancelled_msg .'[/alert]');
							echo '</div>';
							break;
						default:
							# code...
							break;
					}
					?>
					<div class="portfolio-details-inner events-details-wrap">
						<div class="entry-content">
							<div class="event-details-column event-details-column-one column2 column_space">
								<h2 class="event-heading"><i class="event-icon feather-icon-clock"></i><?php _e('Event Details','mthemelocal'); ?></h2>
								<ul class="event-details event-date-time">
								<?php
								$event_startdate = str_replace('-', '/', $event_startdate);
								$event_enddate = str_replace('-', '/', $event_enddate);
								$event_time_format = of_get_option('events_time_format');
							    if ($event_time_format == "24hr") {
							    	$event_starttime  = date("H:i", strtotime($event_starttime));
							    	$event_endtime  = date("H:i", strtotime($event_endtime));
							    } else {
							    	$event_starttime  = date("h:i A", strtotime($event_starttime));
							    	$event_endtime  = date("h:i A", strtotime($event_endtime));
							    }
								echo '<li><strong>'.__('From:','mthemelocal').'</strong> '.date_i18n( get_option( 'date_format' ), strtotime($event_startdate) ).'</li>';
								echo '<li><strong>'.__('To:','mthemelocal').'</strong> '.date_i18n( get_option( 'date_format' ), strtotime($event_enddate) ).'</li>';
								echo '<li><strong>'.__('Starting at:','mthemelocal').'</strong> '.$event_starttime.'</li>';
								echo '<li><strong>'.__('Finishing at:','mthemelocal').'</strong> '.$event_endtime.'</li>';
								?>
								</ul>
								<?php
								if ($event_venue_cost<>"") {
								?>
								<h2 class="event-heading"><i class="event-icon feather-icon-tag"></i><?php _e('Event Price','mthemelocal'); ?></h2>
								<ul class="event-details event-price">
								<?php
								echo '<li>'. $event_venue_currency . " " . number_format_i18n( $event_venue_cost, 2 ) .'</li>';
								?>
								</ul>
								<?php
								}
								?>
							</div>
							<?php
							if ($event_venue_name<>"") {
							?>
							<div class="event-details-column column2">
								<h2 class="event-heading"><i class="event-icon feather-icon-location"></i><?php _e('Address','mthemelocal'); ?></h2>
								<ul class="event-details event-address">
								<?php
								echo '<li>'.$event_venue_name.'</li>';
								echo '<li>'.$event_venue_street.'</li>';
								echo '<li>'.$event_venue_state.'</li>';
								echo '<li>'.$event_venue_postal.'</li>';
								$event_country = mtheme_country_list("display",$event_venue_country);
								if ($event_country<>"Choose Country") {
									echo '<li>'.$event_country.'</li>';
								}
								echo '<li>'.$event_venue_phone.'</li>';
								echo '<li>'.$event_venue_website.'</li>';
								?>
								</ul>
							</div>
							<?php
							}
							?>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php
				if ( !$page_builder_mode ) {
				?>
				<div class="portfolio-content-summary">
				<?php
				if ( have_posts() ) while ( have_posts() ) : the_post();
				the_content();
				endwhile;
				?>
				</div>
			<?php
				}
			// end of password check
			}
			?>
			</div>
	</div>
	<?php
	global $mtheme_pagestyle;
	if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
		get_sidebar();
	}
}
?>
<?php get_footer(); ?>