<?php
/**
 * Supersized
 */
get_header();
?>
<?php
$featured_page = mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
//The Image IDs
$filter_image_ids = mtheme_get_custom_attachments ( $featured_page );
//Slideshow Settings
$slideshow_autoplay=of_get_option('slideshow_autoplay');
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

if (! $slideshow_autoplay) $slideshow_autoplay=0;
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

if ( post_password_required($featured_page) ) {
	$default_bg= of_get_option('general_passwordprotected_image');
	if ($default_bg=="") {
		$default_bg = of_get_option('general_background_image');
	}
	if ($default_bg<>"") {
		mtheme_fill_background_image($default_bg);
	}
	get_template_part( 'password', 'box' );
	} else {
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
// Don't Populate list if no Featured page is set
//$featured_page = 3875;
if ( $featured_page <>"" ) {
	if (!$filter_image_ids) {
		echo '<div class="mtheme-error-notice">No images present to display slideshow.</div>';
	}
if ($filter_image_ids) {
$custom = get_post_custom($featured_page);
if (isSet ($custom[ MTHEME . "_slideshowthumbnails"][0]) ) {
	$slideshow_thumbnails=$custom[ MTHEME . "_slideshowthumbnails"][0];
}
$slideshow_thumbnails_status="0";
if ($slideshow_thumbnails=="thumbnails") {
	$slideshow_thumbnails_status="1";
}
?>
<?php
// Static Titles and Description block
$static_description='';
$static_title='';
$static_link_text='';
$slideshow_link='';
$slideshow_title='';
$slideshow_caption='';
$static_url='';
$fullscreen_infobox='';
$slideshow_titledesc='enable';
$cover_style='';
$custom = get_post_custom($featured_page);
if (isSet($custom[MTHEME . "_static_title"][0])) $static_title=$custom[MTHEME . "_static_title"][0];
if (isSet($custom[MTHEME . "_static_description"][0])) $static_description=$custom[MTHEME . "_static_description"][0];
if (isSet($custom[MTHEME . "_static_link_text"][0])) $static_link_text=$custom[MTHEME . "_static_link_text"][0];
if (isSet($custom[MTHEME . "_static_url"][0])) $static_url=$custom[MTHEME . "_static_url"][0];
if (isSet($custom[MTHEME . "_fullscreen_infobox"][0])) $fullscreen_infobox=$custom[MTHEME . "_fullscreen_infobox"][0];
if (isSet($custom[MTHEME . "_slideshow_titledesc"][0])) $slideshow_titledesc=$custom[MTHEME . "_slideshow_titledesc"][0];
if (isSet($custom[MTHEME . "_cover_style"][0])) $cover_style=$custom[MTHEME . "_cover_style"][0];

$slideshow_no_description='';
if ( $static_description =='' ) {
	$slideshow_no_description = "";
}
$slideshow_no_description_no_title='';
if ( $static_description =='' && $static_title =='' ) {
	$slideshow_no_description_no_title = "";
}

$static_msg_display = false;

if ($static_link_text) $slideshow_link='<div class="static_slideshow_content_link '.$slideshow_no_description_no_title.'"><a class="supersized-button" href="'.$static_url.'">'. esc_attr($static_link_text) .'</a></div>';
if ($static_title) $slideshow_title='<div class="static_slideshow_title '.$slideshow_no_description.'">'. esc_attr($static_title) .'</div>';
if ($static_description) $slideshow_caption='<div class="static_slideshow_caption slideshow_caption_break">'. do_shortcode($static_description) .'</div>';

if ( $static_link_text != '' || $static_title != '' || $static_description != '' || $static_url != '' ) {
	$static_msg_display = true;
	$slide_ui_color = mtheme_get_first_slide_ui_color($featured_page);
	echo '<div class="coverphoto-outer-wrap fullscreen-slide-'.$slide_ui_color.'"><div id="coverphoto-text-wrap" class="slideshow-content-wrap fullscreen-coverphoto-outer coverphoto-type-'.$cover_style.'"><div class="fullscreen-coverphoto-inner coverphoto-text-container">' . $slideshow_title . $slideshow_caption . $slideshow_link . "</div></div></div>";
}
?>
<?php
mtheme_populate_slide_ui_colors($featured_page);
?>
<?php
ob_start();
?>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(function($){	
	jQuery.supersized({
		slideshow               :   1,
		autoplay				:	<?php echo esc_js($slideshow_autoplay); ?>,
		start_slide             :   1,
		image_path				:	'<?php echo esc_js($supersized_image_path); ?>',
		stop_loop				:	<?php echo esc_js($slideshow_pause_on_last); ?>,
		random					: 	0,
		slide_interval          :   <?php echo esc_js($slideshow_interval); ?>,
		transition              :   <?php echo esc_js($slideshow_transition); ?>,
		transition_speed		:	<?php echo esc_js($slideshow_transition_speed); ?>,
		new_window				:	0,
		pause_hover             :   <?php echo esc_js($slideshow_pause_hover); ?>,
		keyboard_nav            :   1,
		performance				:	2,
		image_protect			:	1,			   
		min_width		        :   0,
		min_height		        :   0,
		vertical_center         :   <?php echo esc_js($slideshow_vertical_center); ?>,
		horizontal_center       :   <?php echo esc_js($slideshow_horizontal_center); ?>,
		fit_always				:	<?php echo esc_js($slideshow_fit_always); ?>,
		fit_portrait         	:   <?php echo esc_js($slideshow_portrait); ?>,
		fit_landscape			:   <?php echo esc_js($slideshow_landscape); ?>,
		slide_links				:	'blank',
		thumb_links				:	1,
		thumbnail_navigation    :   <?php echo esc_js($slideshow_thumbnails_status); ?>,
		slides 					:  	[
<?php
	// Loop through the images
	foreach ( $filter_image_ids as $attachment_id) {
			$attachment = get_post( $attachment_id );
			$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
			$caption = $attachment->post_excerpt;
			//$href = get_permalink( $attachment->ID ),
			$imageURI = wp_get_attachment_image_src( $attachment_id, 'full', false );
			$imageURI = $imageURI[0];
			$imageTitle = apply_filters('the_title',$attachment->post_title);
			$imageDesc = apply_filters('the_content',$attachment->post_content);
			$thumb_imageURI = '';

			$link_text = ''; $link_url = ''; $slideshow_link = ''; $slideshow_color='';
			$link_text = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_link', true );
			$link_url = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_url', true );
			$slide_color = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_color', true );

		// If linking is On
		if ($featured_linked == 1 || $featured_linked == true) {
			$attatchmentURL = get_attachment_link($image->ID);
		}
		// Count
		$count++;
		if ($count>1) { echo ","; }
		$slideshow_title="";
		$slideshow_caption="";
		//Find and replace all new lines to BR tags
		$find   = array("\r\n", "\n", "\r");
		$replace = '<br />';
		$imageDesc = str_replace($find, $replace , $imageDesc);

		if (!$slide_color) {
			$slide_color="bright";
		}
		$slideshow_color = '<div class="fullscreen-slideshow-color" data-color="'.esc_attr($slide_color).'"></div>';

		if ( !$static_msg_display ) {
			// If static message is not filled in page meta fields
			$slideshow_no_description='';
			if ( !$imageDesc ) {
				$slideshow_no_description = "";
			}
			$slideshow_no_description_no_title='';
			if ( !$imageDesc && !$imageTitle ) {
				$slideshow_no_description_no_title = "";
			}

			if ( !isSet($slide_ui_color)) {
				$slide_ui_color='';
			}

if ($link_text) $slideshow_link='<div class="static_slideshow_content_link '.$slideshow_no_description_no_title.'"><a class="supersized-button" href="'.$link_url.'">'. esc_attr($link_text) .'</a></div>';
if ($imageTitle) $slideshow_title='<div class="static_slideshow_title '.$slideshow_no_description.'">'. esc_attr($imageTitle) .'</div>';
if ($imageDesc) $slideshow_caption='<div class="static_slideshow_caption slideshow_caption_break">'. do_shortcode($imageDesc) .'</div>';
			$slideshow_caption = '<div class="coverphoto-outer-wrap fullscreen-slide-'.$slide_ui_color.'"><div id="coverphoto-text-wrap" class="slideshow-content-wrap fullscreen-coverphoto-outer coverphoto-type-'.$cover_style.'"><div class="fullscreen-coverphoto-inner coverphoto-text-container">' . $slideshow_title . $slideshow_caption . $slideshow_link . "</div></div></div>";
		} else {
			// Empty if static message is filled in page settings
			$slideshow_color='';
			$slideshow_link='';
			$slideshow_title='';
			$slideshow_caption='';
		}

		if ($imageTitle=="" && $imageDesc=="") {
			$slideshow_caption = '';
		}

		$slideshow_display_code = $slideshow_caption;

		if ( $slideshow_titledesc == "disable" ) {
			$slideshow_display_code='';
		}
		
		echo "{image : '".esc_url($imageURI)."', title : '". $slideshow_color . $slideshow_display_code . "', thumb : '".esc_url($thumb_imageURI)."', url : ''}";
	}
?>
		],
		progress_bar			:	1,					
		mouse_scrub				:	1
	});
	if ($.fn.swipe) {
		jQuery(".page-is-fullscreen #supersized,.pattern-overlay,.super-navigation").swipe({
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
	global $mtheme_slideshow_supersized_script;
	$mtheme_slideshow_supersized_script = ob_get_contents();
	ob_end_clean();

	function mtheme_slideshow_script_add() {
		global $mtheme_slideshow_supersized_script;
		echo $mtheme_slideshow_supersized_script;
	}
	add_action('wp_footer', 'mtheme_slideshow_script_add',100);
?>
	<?php if ($count>1) { ?>
		<div class="slideshow-controls-wrap">

			<!--Slide counter-->
			<?php if ( ! of_get_option('hcount_disable') ) { ?>
			<div id="slidecounter">
				<span class="slidenumber"></span> / <span class="totalslides"></span>
			</div>
			<?php } ?>
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
							<a id="play-button"><i id="pauseplay" class="feather-icon-pause"></i></a>
						<?php } ?>
					<?php } ?>
				</div>
			</div>

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
<?php
// Enf of $image check - script wont run if null
}
// End of IF statement checking null images
}
?>
<?php
get_template_part( '/includes/fullscreen/audio', 'player' );
?>
<?php
//End password check wrap
}
?>
<?php get_footer(); ?>