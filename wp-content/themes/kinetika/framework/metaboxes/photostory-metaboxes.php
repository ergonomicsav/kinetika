<?php
global $mtheme_meta_box,$mtheme_photostory_box,$mtheme_active_metabox;

$mtheme_active_metabox="photostory";
$mtheme_sidebar_options = mtheme_generate_sidebarlist("photostory");

require_once( MTHEME_OPTIONS_ROOT . 'google-fonts.php');
$options_fonts = mtheme_google_fonts();

// Pull all the Featured into an array
$bg_slideshow_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');

if ($bg_slideshow_pages) {
	$options_bgslideshow['none'] = "Not Selected";
	foreach($bg_slideshow_pages as $key => $list) {
		$custom = get_post_custom($list->ID);
		if ( isset($custom["fullscreen_type"][0]) ) { 
			$slideshow_type=$custom["fullscreen_type"][0]; 
		} else {
		$slideshow_type="";
		}
		if ($slideshow_type<>"Fullscreen-Video") {
			$options_bgslideshow[$list->ID] = $list->post_title;
		}
	}
} else {
	$options_bgslideshow[0]="Featured pages not found.";
}

$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';
$mtheme_imagepath_alt =  get_template_directory_uri() . '/framework/options/images/';

$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/';

$mtheme_photostory_box = array(
	'id' => 'featuredmeta-box',
	'title' => 'Fullscreen Metabox',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Fullscreen Settings','mthemelocal'),
			'id' => MTHEME . '_page_section_id',
			'type' => 'break',
			'sectiontitle' => __('Page Settings','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Add Images','mthemelocal'),
			'id' => MTHEME . '_image_attachments',
			'std' => 'Upload Images',
			'type' => 'image_gallery',
			'desc' => __('<div class="metabox-note">Add images from Media Uploader or by uploading new images.</div>','mthemelocal')
		),
		array(
			'name' => __('Description for gallery thumbnail ( Story Gallery )','mthemelocal'),
			'id' => MTHEME . '_thumbnail_desc',
			'type' => 'textarea',
			'desc' => __('This description is displayed below each thumbnail.','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Page Background color','mthemelocal'),
			'id' => MTHEME . '_pagebackground_color',
			'type' => 'color',
			'desc' => __('Page background color','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Display Titles & Descrition','mthemelocal'),
			'id' => MTHEME . '_slideshow_titledesc',
			'type' => 'select',
			'std' => 'enable',
			'desc' => __('Display title and description','mthemelocal'),
			'options' => array(
				'enable' => 'Enable',
				'disable' => 'Disable')
		),
		array(
			'name' => __('Fotorama Fill mode','mthemelocal'),
			'id' => MTHEME . '_fotorama_fill',
			'type' => 'select',
			'std' => 'enable',
			'desc' => __('Fotorama Fill mode','mthemelocal'),
			'options' => array(
				'cover' => 'Fill',
				'contain' => 'Fit')
		),
		array(
			'name' => __('Switch Menu','mthemelocal'),
			'id' => MTHEME . '_menu_choice',
			'type' => 'select',
			'desc' => __('Select a different menu for this page','mthemelocal'),
			'options' => mtheme_generate_menulist()
		),
		array(
			'name' => __('Page Title','mthemelocal'),
			'id' => MTHEME . '_page_title',
			'type' => 'select',
			'desc' => __('Page title','mthemelocal'),
			'std' => 'default',
			'options' => array(
				'default' => 'Theme Options default',
				'hide' => 'Hide',
				'show' => 'Show',
			)
		),
		array(
			'name' => __('Fullscreen Toggle','mthemelocal'),
			'id' => MTHEME . '_page_fullscreentoggle',
			'type' => 'select',
			'desc' => __('Fullscreen Toggle','mthemelocal'),
			'std' => 'default',
			'options' => array(
				'default' => 'Theme Options default',
				'hide' => 'Hide',
				'show' => 'Show',
			)
		),
	)
);
add_action("admin_init", "mtheme_photostoryitemmetabox_init");
function mtheme_photostoryitemmetabox_init(){
	add_meta_box("mtheme_photostoryInfo-meta", "Photostory Options", "mtheme_photostoryitem_metaoptions", "mtheme_photostory", "normal", "low");
}
/*
* Meta options for Photostory post type
*/
function mtheme_photostoryitem_metaoptions(){
	global $mtheme_photostory_box, $post;
	mtheme_generate_metaboxes($mtheme_photostory_box,$post);
}
?>