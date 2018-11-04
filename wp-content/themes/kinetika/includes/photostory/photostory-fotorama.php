<?php
/**
 * Kenburns
 */
get_header();
$featured_page = mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
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
// Don't Populate list if no Featured page is set
//The Image IDs
$photostory_transition="slide";
$photostory_transition = of_get_option('photostory_transition');
if ($photostory_transition<>"slide" && $photostory_transition<>"crossfade") {
	$photostory_transition="slide";
}
$custom = get_post_custom($featured_page);
$slideshow_titledesc='';
if (isSet($custom[MTHEME . "_fotorama_fill"][0])) {
	$fotorama_fill=$custom[MTHEME . "_fotorama_fill"][0];
}
if (isSet($custom[MTHEME . "_slideshow_titledesc"][0])) $slideshow_titledesc=$custom[MTHEME . "_slideshow_titledesc"][0];
if ($slideshow_titledesc<>"enable") {
	$slideshow_titledesc="disabled";
}
if ( $featured_page <>"" ) { 

$filter_image_ids = mtheme_get_custom_attachments ( $featured_page );
mtheme_populate_slide_ui_colors($featured_page);
if ($filter_image_ids) {
	do_action('mtheme_display_photostory_single_navigation');
?>
<div id="fotorama-container-wrap">
<?php		
$fullcreen = do_shortcode('[fotorama pagetitle="false" transition="'.$photostory_transition.'" titledesc="'.$slideshow_titledesc.'" filltype="'.$fotorama_fill.'" pageid='.$featured_page.']');
echo $fullcreen;
?>
</div>
<?php
}
}
//End Password Check
}
?>
<?php get_footer(); ?>