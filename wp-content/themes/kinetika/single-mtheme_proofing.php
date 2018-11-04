<?php
/*
*  Page
*/
?>
 
<?php get_header(); ?>
<?php
$custom = get_post_custom($post->ID);

$proofing_startdate = '';

if (isset($custom[MTHEME . '_proofing_status'][0])) $proofing_status=$custom[MTHEME . '_proofing_status'][0];
if (isset($custom[MTHEME . '_proofing_startdate'][0])) $proofing_startdate=$custom[MTHEME . '_proofing_startdate'][0];
if (isset($custom[MTHEME . '_proofing_client'][0])) $proofing_client=$custom[MTHEME . '_proofing_client'][0];
if (isset($custom[MTHEME . '_proofing_location'][0])) $proofing_location=$custom[MTHEME . '_proofing_location'][0];
if (isset($custom[MTHEME . '_proofing_download'][0])) $proofing_download=$custom[MTHEME . '_proofing_download'][0];

$proofing_startdate = str_replace('-', '/', $proofing_startdate);
$proofing_startdate = date_i18n( get_option( 'date_format' ), strtotime($proofing_startdate) );

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
			<div class="proofing-content-wrap">
				<div class="entry-content proofing-content">
					<?php
					$proofing_locked_msg = __("Proofing gallery selection has been locked.","mthemelocal");
					$proofing_active_msg = __("Proofing gallery is active for selection.","mthemelocal");

					if (MTHEME_DEMO_STATUS) {
						$proofing_active_msg .= __('<br/><strong>In Demo</strong> selections are not saved. Otherwise selections retain even on page refreshing.','mthemelocal');
					}
					$proofing_disable_msg = __("Please contact us to activate this proofing gallery.","mthemelocal");
					$proofing_download_msg = __("Proofing gallery Locked for Download.","mthemelocal");
					switch ($proofing_status) {
						case 'lock':
							echo '<div class="entry-content proofing-notice">';
							echo do_shortcode('[alert type="green" icon="mfont et-icon-lock"]'. $proofing_locked_msg .'[/alert]');
							echo '</div>';
							break;
					case 'active':
							echo '<div class="entry-content proofing-notice">';
							echo do_shortcode('[alert type="yellow" icon="mfont et-icon-layers"]'. $proofing_active_msg .'[/alert]');
							echo '</div>';
							break;
					case 'download':
							echo '<div class="entry-content proofing-notice">';
							echo do_shortcode('[alert type="yellow" icon="mfont et-icon-download"]'. $proofing_download_msg .'[/alert]');
							echo '</div>';
							break;
					case 'inactive':
							echo '<div class="entry-content proofing-notice">';
							echo do_shortcode('[alert type="red" icon="mfont et-icon-caution"]'. $proofing_disable_msg .'[/alert]');
							echo '</div>';
							break;
						default:
							# code...
							break;
					}
					if ( post_password_required() ) {
						// If password
					} else {
							echo '<h2 class="event-heading"></i>'.__('Proofing Details','mthemelocal').'</h2>';
							echo '<ul class="event-details event-date-time">';
							if (isSet($proofing_startdate)) {
								echo '<li>'.$proofing_startdate.'</li>';
							}
							if (isSet($proofing_client)) {
								echo '<li>'.__('Client:','mthemelocal'). ' ' . $proofing_client.'</li>';
							}
							if (isSet($proofing_location)) {
								echo '<li>'.__('Location:','mthemelocal'). ' ' .$proofing_location.'</li>';
							}
							echo '</ul>';
							if ( isSet($proofing_download) && $proofing_download <>"" && $proofing_status == "download") {

								$button_style = "dark";
								$theme_style=of_get_option('theme_style');
								if (MTHEME_DEMO_STATUS) {
									if ( isSet($_GET['themeskin'] )) { 
										$demo_skin = $_GET['themeskin'];
										if ($demo_skin == "light") {
											$theme_style="light";
										}
										if ($demo_skin == "dark") {
											$theme_style = "dark";
										}
									}
								}
								if ($theme_style=="dark") {
									$button_style = "text-is-bright";
								}
							?>
							<div class="button-shortcode <?php echo $button_style; ?> proofing-gallery-button">
								<a target="_blank" href="<?php echo esc_url($proofing_download); ?>">
									<div class="mtheme-button big-button animated pulse animation-action">
										<i class="fa fa-download"></i> <?php _e('Download','mthemelocal'); ?>
									</div>
								</a>
							</div>
							<?php
							}
							if ($proofing_status<>"inactive") {
								if ( have_posts() ) while ( have_posts() ) : the_post();
								the_content();
								endwhile;
							}
						?>
					<?php
					// end of password check
					}
					?>
				</div>
			</div>
	<?php
	if ( !post_password_required() && $proofing_status<>"inactive" ) {
		if ($filter_image_ids) {
			$proofing_gallery = do_shortcode('[proofing_gallery proofingstatus="'.$proofing_status.'" padeid=""]');
			echo $proofing_gallery;
		}
	}
	?>
	<?php
	if ( !post_password_required() ) {
	?>
	<?php
	if ( $proofing_status<>"inactive" ) {
		comments_template();
	}
	?>
	</div>
	<?php
		global $mtheme_pagestyle;
		if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
			get_sidebar();
		}
	}
}
?>
<?php get_footer(); ?>