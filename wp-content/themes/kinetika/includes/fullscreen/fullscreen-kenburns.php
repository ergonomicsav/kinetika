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
if ( $featured_page <>"" ) { 

$filter_image_ids = mtheme_get_custom_attachments ( $featured_page );
mtheme_populate_slide_ui_colors($featured_page);
if ($filter_image_ids) {
?>
<div class="kenburns-preloader"></div>
<div id="kenburns-container">
<?php		
	// Loop through the images
	foreach ( $filter_image_ids as $attachment_id) {
		$attachment = get_post( $attachment_id );
		$imageURI = $attachment->guid;
		echo mtheme_display_post_image (
			$post->ID,
			$have_image_url=$imageURI,
			$link=false,
			$type="full",
			$post->post_title,
			$class="kenburns-images"
		);
	}
?>
</div>
<?php
// Static Titles and Description block
$static_description='';
$static_title='';
$static_link_text='';
$slideshow_link='';
$slideshow_title='';
$slideshow_caption='';
$fullscreen_infobox='';
$static_url='';
$slideshow_titledes="enable";
$custom = get_post_custom($featured_page);
if (isSet($custom[MTHEME . "_static_title"][0])) $static_title=$custom[MTHEME . "_static_title"][0];
if (isSet($custom[MTHEME . "_static_description"][0])) $static_description=$custom[MTHEME . "_static_description"][0];
if (isSet($custom[MTHEME . "_static_link_text"][0])) $static_link_text=$custom[MTHEME . "_static_link_text"][0];
if (isSet($custom[MTHEME . "_static_url"][0])) $static_url=$custom[MTHEME . "_static_url"][0];
if (isSet($custom[MTHEME . "_fullscreen_infobox"][0])) $fullscreen_infobox=$custom[MTHEME . "_fullscreen_infobox"][0];
if (isSet($custom[MTHEME . "_slideshow_titledesc"][0])) $slideshow_titledesc=$custom[MTHEME . "_slideshow_titledesc"][0];

$slideshow_no_description='';
if ( $static_description =='' ) {
	$slideshow_no_description = "slideshow_text_shift_up";
}
$slideshow_no_description_no_title='';
if ( $static_description =='' && $static_title =='' ) {
	$slideshow_no_description_no_title = "slideshow_text_shift_up";
}

$static_msg_display = false;

if ($static_link_text) $slideshow_link='<div class="static_slideshow_content_link '.$slideshow_no_description_no_title.'"><a class="supersized-button" href="'.$static_url.'">'. esc_attr($static_link_text) .'</a></div>';
if ($static_title) $slideshow_title='<div class="static_slideshow_title '.$slideshow_no_description.'">'. esc_attr($static_title) .'</div>';
if ($static_description) $slideshow_caption='<div class="static_slideshow_caption slideshow_caption_break">'. do_shortcode($static_description) .'</div>';

if ( $static_link_text != '' || $static_title != '' || $static_description != '' || $static_url != '' ) {
	$static_msg_display = true;
	if ( $slideshow_titledesc == "enable" ) {
			echo '<div id="static_slidecaption" class="slideshow-content-wrap">' . $slideshow_title . $slideshow_caption . $slideshow_link . "</div>";
	}
}
?>
<?php
get_template_part( '/includes/fullscreen/information', 'box' );
get_template_part( '/includes/fullscreen/audio', 'player' );
// If Ends here for the Featured Page
}
}
?>
<?php
//End Password Check
}
?>
<?php get_footer(); ?>