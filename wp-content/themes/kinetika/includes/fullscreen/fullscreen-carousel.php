<?php
/**
 * Carousel
 */
get_header();
$carousel_text='';
$slideshow_titledesc='';
$featured_page=mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
if ( isSet($custom[ MTHEME . "_carousel_text"][0]) ) {
	$carousel_text = $custom[ MTHEME . "_carousel_text"][0];
}
if (isSet($custom[MTHEME . "_slideshow_titledesc"][0])) $slideshow_titledesc=$custom[MTHEME . "_slideshow_titledesc"][0];

$count=0;
if ( post_password_required($featured_page) ) {
	// Grab default background set from theme options	
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
	$count=0;
	$captions='';
	$carousel='';
?>
<div class="circular-preloader"></div>
<div class="fullscreen-horizontal-carousel <?php echo esc_attr($carousel_text); ?>">
            <span class="colorswitch prev-hcarousel"></span>
            <span class="colorswitch next-hcarousel"></span>
  <div class="horizontal-carousel-outer">
        <div class="horizontal-carousel-inner">
            <div class="horizontal-carousel-wrap">
                <ul class="horizontal-carousel">
<?php		
	// Loop through the images
	foreach ( $filter_image_ids as $attachment_id) {
		$attachment = get_post( $attachment_id );
		$imageURI = $attachment->guid;

		$thumb_imagearray = wp_get_attachment_image_src( $attachment->ID , 'gridblock-full', false);
		$thumb_imageURI = $thumb_imagearray[0];
				
		$imageTitle = apply_filters('the_title',$attachment->post_title);
		$imageDesc = apply_filters('the_content',$attachment->post_content);

		$count++;
		$carousel .= '<li data-id="'.esc_attr($count).'" data-position="0" data-title="'.esc_attr($imageTitle).'" class="hc-slides slide-'.esc_attr($count).'">';
		$carousel .= '<div class="hc-image-wrap">';
		$carousel .= '<img title="'.esc_attr($imageTitle).'" data-lightbox="magnific-carousel-gallery" data-mfp-src="'.$thumb_imageURI.'" src="'.esc_url($thumb_imageURI).'" alt="'.esc_attr($imageTitle).'"/>';
		if ($slideshow_titledesc=="enable") {
			$carousel .= '<div class="responsive-titles">';
			$carousel .= '<div class="title"><h3 class="colorswitch">'.$imageTitle.'</h3></div>';
			$carousel .= '<div class="description colorswitch">'.$imageDesc.'</div>';
			$carousel .= '</div>';
		}
		$carousel .= '</div>';
		$carousel .= '</li>';
	}
	echo $carousel;
?>
              </ul>
            </div>
        </div>      
  </div>
</div>
<?php
// If Ends here for the Featured Page
}
}
?>
<?php
//End Password Check
}
?>
<?php get_footer(); ?>