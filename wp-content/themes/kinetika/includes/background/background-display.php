<?php
if (isSet($post->ID)) {
	$bg_choice= get_post_meta($post->ID, MTHEME . '_meta_background_choice', true);
	$custom_bg_image_url= get_post_meta($post->ID, MTHEME . '_meta_background_url', true);
	$image_link=mtheme_featured_image_link($post->ID);
}
// For Debug
// print_r($bg_choice . " " .  $post->ID . " " . $image_link );

	$default_bg= of_get_option('general_background_image'); // Theme Options set image
	$theme_options_set_background_slideshow = of_get_option('general_bgslideshow');
	$photowall_background_image = of_get_option('photowall_background_image');

	if (!isSet($bg_choice) ) {
		$bg_choice="options_image";
	}
	// Check custom posts

function mtheme_generate_bg_script ($the_image) {
	global $mtheme_bg_image_script;
	if ($the_image) {
		$mtheme_bg_image_script = '<script>/* <![CDATA[ */';
		$mtheme_bg_image_script .= 'jQuery(document).ready(function($){';
		$mtheme_bg_image_script .= 'if ($.fn.backstretch) {';
		$mtheme_bg_image_script .= '$.backstretch("'.esc_url($the_image).'", {  speed: 1000	});';
		$mtheme_bg_image_script .= '}';
		$mtheme_bg_image_script .= '})';
		$mtheme_bg_image_script .= '/* ]]> */</script>';
	}
}
if (isSet($fullscreen_slideshowpost)) {
	if ($fullscreen_slideshowpost != "none" && $fullscreen_slideshowpost<>"") {
		$bg_choice="Fullscreen Post Slideshow";
	}
}
if ( is_archive() || is_search() ) $bg_choice="default";

if ( is_post_type_archive('mtheme_photostory') ) {
	$photostory_bg = of_get_option('photostory_background_image');
	if ($photostory_bg<>"") {
		$default_bg = $photostory_bg;
	}
}

if ( mtheme_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$bg_choice= get_post_meta($woo_shop_post_id, MTHEME . '_meta_background_choice', true);
	$custom_bg_image_url= get_post_meta($woo_shop_post_id, MTHEME . '_meta_background_url', true);
	$image_link=mtheme_featured_image_link($woo_shop_post_id);
}

if ( !mtheme_is_fullscreen_home()) {
	if ($bg_choice != "none") {
		switch ($bg_choice) {
			case "options_slideshow" :
			case "image_attachments" :
			case "fullscreen_post" :
				if ($bg_choice=="options_slideshow") { $get_slideshow_from_page_id = $theme_options_set_background_slideshow; }
				if ($bg_choice=="image_attachments") { $get_slideshow_from_page_id = get_the_ID(); }
				if ($bg_choice=="fullscreen_post") {
					if (isset( $post->ID )) $get_slideshow_from_page_id= get_post_meta( $post->ID, MTHEME . '_slideshow_bgfullscreenpost', true);
				}
				get_template_part( '/includes/background/fullscreen', 'slideshow' );
			break;
			case "featured_image" :
				mtheme_generate_bg_script ($image_link);
			break;
			case "custom_url" :
				mtheme_generate_bg_script ($custom_bg_image_url);
			break;
			case "options_image" :
				mtheme_generate_bg_script ($default_bg);
			break;		
			case "video_background" :
				if (isset( $post->ID )) {
					$get_video_from_page_id= get_post_meta( $post->ID, MTHEME . '_video_bgfullscreenpost', true);
					$custom = get_post_custom($get_video_from_page_id);
					if ( mtheme_page_is_woo_shop() ) {
						$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
						$get_video_from_page_id= get_post_meta( $woo_shop_post_id, MTHEME . '_video_bgfullscreenpost', true);
						$custom = get_post_custom($get_video_from_page_id);
					}
					//HTML5
					if (isSet($custom[MTHEME . "_html5_mp4"][0])) {
						$html5_mp4=$custom[MTHEME . "_html5_mp4"][0];
					}
					if ( isSet($html5_mp4) ) {
						get_template_part( '/includes/background/fullscreenvideo', 'html5' );
					}
					//Youtube
					if (isSet($custom[MTHEME . "_youtubevideo"][0])) {
						$youtube_video=$custom[MTHEME . "_youtubevideo"][0];
					}
					if ( isSet($youtube_video) ) {
						get_template_part( '/includes/background/fullscreenvideo', 'youtube' );
					}
				}
			break;
			default :
				if ( !mtheme_is_fullscreen_post() ) {
					if ($default_bg) {
						mtheme_generate_bg_script ($default_bg);
					}
				}
			break;
		}
	}
}
if ( mtheme_is_fullscreen_post() ) {

	$fullscreen_type = mtheme_get_fullscreen_type();
	if ($fullscreen_type=="photowall" || $fullscreen_type=="carousel" ) {
		if ( mtheme_is_fullscreen_home() ) {
			$image_link=mtheme_featured_image_link( mtheme_get_active_fullscreen_post() );
		}
		if ($image_link<>"") {
			mtheme_generate_bg_script ($image_link);
		}
	}
}
?>