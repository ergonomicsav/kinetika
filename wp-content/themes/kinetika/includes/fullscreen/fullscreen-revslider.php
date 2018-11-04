<?php
/**
 * Revolution Slider
 */
get_header();
$featured_page=mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
if ( isSet($custom[ MTHEME . "_revslider"][0]) ) {
	$revslider = $custom[ MTHEME . "_revslider"][0];
}
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
	echo do_shortcode('[rev_slider '.$revslider.']');
}
get_footer();
?>