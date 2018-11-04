<?php
/**
 * Fullscreen Video
 */
get_header();
$featured_page=mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
if (isSet($custom[MTHEME . "_youtubevideo"][0])) $youtube=$custom[MTHEME . "_youtubevideo"][0];
if (isSet($custom[MTHEME . "_vimeovideo"][0])) $vimeoID=$custom[MTHEME . "_vimeovideo"][0];
if (isSet($custom[MTHEME . "_html5_mp4"][0])) $html5_mp4=$custom[MTHEME . "_html5_mp4"][0];
if (isSet($custom[MTHEME . "_html5_wemb"][0])) $html5_wemb=$custom[MTHEME . "_html5_wemb"][0];

$video_control_bar=of_get_option('video_control_bar');
$fullscreen_menu_toggle=of_get_option('fullscreen_menu_toggle');
$fullscreen_menu_toggle_nothome=of_get_option('fullscreen_menu_toggle_nothome');

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
?>
<?php
$vimeo_active=false;
$youtube_active=false;
$html5_active=false;
// Activate Vimeo iframe for fullscreen playback
if ( isSet($vimeoID) && !empty($vimeoID) ) {
	$vimeo_active=true;
	get_template_part('/includes/fullscreen/fullscreenvideo','vimeo');
}
// Play Youtube and Other Video files
if (isSet($youtube) && !empty($youtube) && !$vimeo_active) {
	$youtube_active=true;
	get_template_part('/includes/fullscreen/fullscreenvideo','youtube');
}
if (isSet($html5_mp4) || isSet($html5_mp4)) {
	if (!$vimeo_active && !$youtube_active) {
		$html5_active=true;
		get_template_part('/includes/fullscreen/fullscreenvideo','html5');
	}
}
//End password check wrap
}
?>
<?php get_footer(); ?>