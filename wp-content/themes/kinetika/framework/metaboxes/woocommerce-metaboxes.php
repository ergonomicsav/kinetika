<?php
global $mtheme_meta_box,$mtheme_woocommerce_box,$mtheme_active_metabox;

$mtheme_active_metabox="woocommerce";
$mtheme_sidebar_options = mtheme_generate_sidebarlist("portfolio");

$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/';

$mtheme_woocommerce_box = array(
	'id' => 'woocommercemeta-box',
	'title' => 'Woocommerce Metabox',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __('Attach Images','mthemelocal'),
			'id' => MTHEME . '_image_attachments',
			'std' => __('Upload Images','mthemelocal'),
			'type' => 'image_gallery',
			'desc' => __('<div class="metabox-note">Attach images to this page/post.</div>','mthemelocal')
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
		array(
			'name' => __('Page Background color','mthemelocal'),
			'id' => MTHEME . '_pagebackground_color',
			'type' => 'color',
			'desc' => __('Page background color','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Page Opacity','mthemelocal'),
			'id' => MTHEME . '_pagebackground_opacity',
			'type' => 'select',
			'desc' => __('Page background opacity','mthemelocal'),
			'std' => 'default',
			'options' => array(
				'default' => 'Default',
				'0' => 'Transparent',
				'25' => '25%',
				'50' => '50%',
				'75' => '75%',
				'100' => 'Opaque'
			)
		),
		array(
			'name' =>  __('Background Slideshow / Image from','mthemelocal'),
			'id' => MTHEME . '_meta_background_choice',
			'type' => 'select',
			'target' => 'backgroundslideshow_choices',
			'desc' => __('<div class="metabox-note">
			<strong>Static Image from Theme options</strong> <em>Satic image set from theme options as background</em><br/>
			<strong>Slideshow from Theme options:</strong> <em>Slideshow chosen from theme options as background</em><br/>
			<strong>Slideshow from post/page image attachments:</strong> <em>Slideshow from images attached to this post/page</em><br/>
			<strong>Static image using post/page featured image:</strong> <em>Static image from featured image of this post/page</em><br/>
			<strong>Slideshow from a fullscreen post:</strong> <em>Slideshow from a fullscreen post - choose from next selector.</em><br/>
			<strong>Static image using custom background image:</strong> <em>Static image from custom background image url listed below</em><br/>
			<strong>Background Color:</strong> <em>Background color choice</em><br/>
			</div>
			','mthemelocal'),
			'options' => ''
		),
		array(
			'name' => __('Background Slideshow from a fullscreen post','mthemelocal'),
			'id' => MTHEME . '_slideshow_bgfullscreenpost',
			'type' => 'select',
			'target' => 'fullscreen_slideshow_posts',
			'desc' => __('<div class="metabox-note"><strong>Note :</strong>If selected, your choice of fullscreen slideshow post is used to create the  page background slideshow</div>','mthemelocal'),
			'options' => ''
		),
		array(
			'name' => __('Background Video from a fullscreen post','mthemelocal'),
			'id' => MTHEME . '_video_bgfullscreenpost',
			'type' => 'select',
			'target' => 'fullscreen_video_bg',
			'desc' => __('<div class="metabox-note"><strong>Note :</strong>Display page background using youtube or html5 videos</div>','mthemelocal'),
			'options' => ''
		),
		array(
			'name' => __('Custom background image URL','mthemelocal'),
			'id' => MTHEME . '_meta_background_url',
			'type' => 'upload',
			'target' => 'image',
			'std' => '',
			'desc' => __('<div class="metabox-note">Upload or provide full url of background. eg. <code>http://www.domain.com/path/image.jpg</code></div>','mthemelocal')
		)
	)
);
add_action("admin_init", "mtheme_woocommerceitemmetabox_init");
function mtheme_woocommerceitemmetabox_init(){
	add_meta_box("mtheme_woocommerceInfo-meta", "WooCommerce Options", "mtheme_woocommerceitem_metaoptions", "product", "normal", "low");
}
/*
* Meta options for Portfolio post type
*/
function mtheme_woocommerceitem_metaoptions(){
	global $mtheme_woocommerce_box, $post;
	mtheme_generate_metaboxes($mtheme_woocommerce_box,$post);
}
?>