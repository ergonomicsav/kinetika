<?php
/**
 * Supersized
 */
?>
<?php
if (isSet($post->ID)) {
	$bg_choice= get_post_meta($post->ID, MTHEME . '_meta_background_choice', true);
	if ($bg_choice=="options_slideshow") { 
		$theme_options_set_background_slideshow = of_get_option('general_bgslideshow');
		$get_slideshow_from_page_id = $theme_options_set_background_slideshow;
	}
	if ($bg_choice=="image_attachments") { $get_slideshow_from_page_id = get_the_ID(); }
	if ($bg_choice=="fullscreen_post") {
		$get_slideshow_from_page_id = get_post_meta( $post->ID, MTHEME . '_slideshow_bgfullscreenpost', true);
	}
}
if ( mtheme_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$bg_choice= get_post_meta($woo_shop_post_id, MTHEME . '_meta_background_choice', true);
	if ($bg_choice=="options_slideshow") { 
		$theme_options_set_background_slideshow = of_get_option('general_bgslideshow');
		$get_slideshow_from_page_id = $theme_options_set_background_slideshow;
	}
	if ($bg_choice=="image_attachments") { $get_slideshow_from_page_id = $woo_shop_post_id; }
	if ($bg_choice=="fullscreen_post") {
		$get_slideshow_from_page_id = get_post_meta( $woo_shop_post_id, MTHEME . '_slideshow_bgfullscreenpost', true);
	}
}
$slideshow_pause_on_last=of_get_option('slideshow_pause_on_last');
$slideshow_pause_hover=of_get_option('slideshow_pause_hover');
$slideshow_random=of_get_option('slideshow_random');
$slideshow_interval=of_get_option('slideshow_interval');
$slideshow_transition=of_get_option('slideshow_transition');
$slideshow_transition_speed=of_get_option('slideshow_transition_speed');
$slideshow_portrait=of_get_option('slideshow_portrait');
$slideshow_landscape=of_get_option('slideshow_landscape');
$slideshow_fit_always=of_get_option('slideshow_fit_always');
$slideshow_vertical_center=of_get_option('slideshow_vertical_center');
$slideshow_horizontal_center=of_get_option('slideshow_horizontal_center');
$fullscreen_menu_toggle=of_get_option('fullscreen_menu_toggle');
$fullscreen_menu_toggle_nothome=of_get_option('fullscreen_menu_toggle_nothome');
$rootpath= get_stylesheet_directory_uri();

if (! $slideshow_pause_on_last) $slideshow_pause_on_last=0;
if (! $slideshow_pause_hover) $slideshow_pause_hover=0;
if (! $slideshow_fit_always) $slideshow_fit_always=0;
if (! $slideshow_portrait) $slideshow_portrait=0;
if (! $slideshow_landscape) $slideshow_landscape=0;
if (! $slideshow_vertical_center) $slideshow_vertical_center=0;
if (! $slideshow_horizontal_center) $slideshow_horizontal_center=0;

$supersized_image_path = get_template_directory_uri() . '/images/supersized/';
$slideshow_thumbnails="";

$featured_linked=false;
$attatchmentURL="";
$postLink="";
$thelimit=-1;
$count=0;

mtheme_populate_slide_ui_colors($get_slideshow_from_page_id);
// Grab all image attachements from the featured page
$filter_image_ids = mtheme_get_custom_attachments ( $get_slideshow_from_page_id );
if ($filter_image_ids) {
	ob_start();
?>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(function($){
	jQuery.supersized({
		slideshow               :   1,
		autoplay				:	1,
		start_slide             :   1,
		image_path				:	'<?php echo esc_url($supersized_image_path); ?>',
		stop_loop				:	<?php echo esc_js($slideshow_pause_on_last); ?>,
		random					: 	0,
		slide_interval          :   <?php echo esc_js($slideshow_interval); ?>,
		transition              :   <?php echo esc_js($slideshow_transition); ?>,
		transition_speed		:	<?php echo esc_js($slideshow_transition_speed); ?>,
		new_window				:	0,
		pause_hover             :   <?php echo esc_js($slideshow_pause_hover); ?>,
		keyboard_nav            :   1,
		performance				:	2,
		image_protect			:	0,			   
		min_width		        :   0,
		min_height		        :   0,
		vertical_center         :   <?php echo esc_js($slideshow_vertical_center); ?>,
		horizontal_center       :   <?php echo esc_js($slideshow_horizontal_center); ?>,
		fit_always				:	<?php echo esc_js($slideshow_fit_always); ?>,
		fit_portrait         	:   <?php echo esc_js($slideshow_portrait); ?>,
		fit_landscape			:   <?php echo esc_js($slideshow_landscape); ?>,
		slide_links				:	'blank',
		thumb_links				:	1,
		thumbnail_navigation    :   0,
		slides 					:  	[
<?php
	foreach ( $filter_image_ids as $attachment_id) {
		$attachment = get_post( $attachment_id );
		$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
		$caption = $attachment->post_excerpt;
		$imageURI = $attachment->guid;
		if ($featured_linked == 1 || $featured_linked == true) {
			$attatchmentURL = get_attachment_link($image->ID);
		}
		$count++;
		if ($count>1) { echo ","; }
		$slideshow_title="";
		$slideshow_caption="";
		echo "{image : '".esc_url($imageURI)."', title : '', thumb : '', url : ''}";
	}
?>
		],
		progress_bar			:	1,			// Timer for each slide							
		mouse_scrub				:	1
	});
	if ($.fn.swipe) {
		jQuery("#supersized,.super-navigation,#slidecaption").swipe({
		  excludedElements: "button, input, select, textarea, .noSwipe",
		  swipeLeft: function() {
		    jQuery("#nextslide").trigger("click");
		  },
		  swipeRight: function() {
		    jQuery("#prevslide").trigger("click");
		  }
		});
	}
});
/* ]]> */
</script>
<?php
	global $mtheme_background_slideshow_supersized_script;
	$mtheme_background_slideshow_supersized_script = ob_get_contents();
	ob_end_clean();
	function mtheme_background_slideshow_script_add() {
		global $mtheme_background_slideshow_supersized_script;
		echo $mtheme_background_slideshow_supersized_script;
	}
	// Add script code to footer.
	add_action('wp_footer', 'mtheme_background_slideshow_script_add',100);
	?>
	<div class="background-slideshow-controls">
	<?php if ($count>1) { ?>
		<div class="slideshow-controls-wrap">

			<!--Slide counter-->
			<div id="slidecounter">
				<span class="slidenumber"></span> / <span class="totalslides"></span>
			</div>
			<!--Arrow Navigation-->
			<?php if ( ! of_get_option('hnavigation_disable') ) { ?>
			<div class="super-navigation">
			<div class="prevnext-wrap">
				<a id="nextslide" class="load-item"><i class="fa fa-angle-right"></i></a>
			</div>
			<div class="prevnext-wrap">
				<a id="prevslide" class="load-item"><i class="fa fa-angle-left"></i></a>
			</div>
			</div>
			<?php } ?>

			<div id="controls-wrapper" class="load-item">
				<div id="controls">		
					<!--Navigation-->
					<?php if ($count>1) { ?>
						<?php if ( ! of_get_option('hplaybutton_disable') ) { ?>
							<a id="play-button"><i id="pauseplay" class="fa fa-pause"></i></a>
						<?php } ?>
					<?php } ?>
				</div>
			</div>

			<div class="mtheme-share-toggle"><i class="fa fa-share-alt"></i></div>

		</div>
	<?php } ?>

	<div id="slidecaption"></div>
	<!--Control Bar-->
	<!--Time Bar-->
	<?php if ($count>1) { ?>
		<?php if ( ! of_get_option('hprogressbar_disable') ) { ?>
			<div id="progress-back" class="load-item">
				<div id="progress-bar"></div>
			</div>
		<?php } ?>
	<?php } ?>
	</div>
<?php
// Image null check
// Background ID check
}
?>