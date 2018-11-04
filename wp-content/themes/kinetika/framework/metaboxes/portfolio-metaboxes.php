<?php
global $mtheme_meta_box,$mtheme_portfolio_box,$mtheme_active_metabox;

$mtheme_active_metabox="portfolio";
$mtheme_sidebar_options = mtheme_generate_sidebarlist("portfolio");

// Pull all the pages into an array
$options_pages = array();
$options_pages['default-0'] = 'Default';
$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
if ($options_pages_obj) {
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}
}

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

$mtheme_portfolio_box = array(
	'id' => 'portfoliometa-box',
	'title' => 'Portfolio Metabox',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'core',
	'fields' => array(
		array(
			'name' => __('Portfolio Settings','mthemelocal'),
			'id' => MTHEME . '_portfolio_section_id',
			'type' => 'break',
			'sectiontitle' => __('Portfolio Settings','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Attach Images','mthemelocal'),
			'id' => MTHEME . '_image_attachments',
			'std' => __('Upload Images','mthemelocal'),
			'type' => 'image_gallery',
			'desc' => __('<div class="metabox-note">Attach images to this page/post.</div>','mthemelocal')
		),
		array(
			'name' => __('Portfolio type','mthemelocal'),
			'id' => MTHEME . '_portfoliotype',
			'std' => 'Image',
			'type' => 'image',
			'triggerStatus'=> 'on',
			'class' => 'portfolio_type',
			'desc' => __('Select type of Portfolio.','mthemelocal'),
			'options' => array(
				'Image' => $mtheme_imagepath_alt . 'portfolio_image.png',
				'Metro' => $mtheme_imagepath_alt . 'portfolio_metro.png',
				'beforeafter' => $mtheme_imagepath_alt . 'portfolio_beforeafter.png',
				'Vertical' => $mtheme_imagepath_alt . 'portfolio_vertical.png',
				'Slideshow' => $mtheme_imagepath_alt . 'portfolio_slideshow.png',
				'Video' => $mtheme_imagepath_alt . 'portfolio_video.png',
				'None' => $mtheme_imagepath_alt . 'portfolio_none.png'
				)
		),
		array(
			'name' => __('Page Style','mthemelocal'),
			'id' => MTHEME . '_pagestyle',
			'type' => 'image',
			'std' => 'rightsidebar',
			'desc' => __('<strong>With Sidebar :</strong> Displays post with sidebar - two columns<br/><strong>Fullwidth without sidebar :</strong> Displays post as without sidebar<br/><strong>Edge to Edge :</strong> Edge to Edge page without sidebar and title. For Pagebuilder use.','mthemelocal'),
			'options' => array(
				'portfolio_default' => $mtheme_imagepath . 'portfolio_default.png',
				'fullwidth' => $mtheme_imagepath . 'page_nosidebar.png',
				'rightsidebar' => $mtheme_imagepath . 'page_rightsidebar.png',
				'leftsidebar' => $mtheme_imagepath . 'page_leftsidebar.png',
				'edge-to-edge' => $mtheme_imagepath . 'page_edgetoedge.png')
		),
		array(
			'name' => __('Description for gallery thumbnail ( Portfolio Gallery )','mthemelocal'),
			'id' => MTHEME . '_thumbnail_desc',
			'type' => 'textarea',
			'desc' => __('This description is displayed below each thumbnail.','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Portfolio AJAX description','mthemelocal'),
			'id' => MTHEME . '_ajax_description',
			'heading' => 'subhead',
			'type' => 'textarea',
			'desc' => __('Used for Ajax item description.','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Choice of Sidebar','mthemelocal'),
			'id' => MTHEME . '_sidebar_choice',
			'class' => 'sidebar_choice',
			'type' => 'select',
			'desc' => __('For Sidebar Active Pages and Posts','mthemelocal'),
			'options' => $mtheme_sidebar_options
		),
		array(
			'name' => __('Portfolio Archive Page','mthemelocal'),
			'id' => MTHEME . '_portfolio_archive',
			'class' => 'portfolio_archive',
			'type' => 'select',
			'desc' => __('Portfolio archive page for this item','mthemelocal'),
			'options' => $options_pages
		),
		array(
			'name' => __('Display Recent Portfolio Carousel','mthemelocal'),
			'id' => MTHEME . '_portfolio_itemcarousel',
			'type' => 'select',
			'desc' => __('Display Portfolio item carousel at the end of page.','mthemelocal'),
			'std' => 'default',
			'options' => array(
				'default' => 'Theme Options Default',
				'disable' => 'Disable',
				'enable' => 'Enable'
			)
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
			'name' => __('Video Embed Code','mthemelocal'),
			'id' => MTHEME . '_video_embed',
			'heading' => 'subhead',
			'type' => 'textarea',
			'class' => 'portfolio_type-Video portfolio_type-trigger',
			'desc' => __('Video Embed code for Video Portfolio.','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Gallery thumbnail link type','mthemelocal'),
			'id' => MTHEME . '_thumbnail_linktype',
			'type' => 'image',
			'std' => 'Lightbox',
			'desc' => __('Link type of portfolio image in portfolio galleries.','mthemelocal'),
			'options' => array(
				'Lightbox_DirectURL' => $mtheme_imagepath_alt . 'thumb_lightbox_directlink.png',
				'Lightbox' => $mtheme_imagepath_alt . 'thumb_lightbox.png',
				'Customlink' => $mtheme_imagepath_alt . 'thumb_customlink.png',
				'DirectURL' => $mtheme_imagepath_alt . 'thumb_directlink.png'
				)
		),
		array(
			'name' => __('Fill for Lightbox Video','mthemelocal'),
			'id' => MTHEME . '_lightbox_video',
			'heading' => 'subhead',
			'class'=> 'portfoliolinktype',
			'type' => 'text',
			'desc' => __('To display a Lightbox Video.<br/>Eg.<br/>http://www.youtube.com/watch?v=D78TYCEG4<br/>http://vimeo.com/172881','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Fill for Custom Link','mthemelocal'),
			'id' => MTHEME . '_customlink',
			'heading' => 'subhead',
			'class'=> 'portfoliolinktype',
			'type' => 'text',
			'desc' => __('For any link. URL followed with <code>http://</code>','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Skills Required (optional)','mthemelocal'),
			'id' => MTHEME . '_skills_required',
			'heading' => 'subhead',
			'type' => 'text',
			'desc' => __('Comma seperated skills sets. eg. PHP,HTML,CSS,Illustrator,Photoshop','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Client Name (optional)','mthemelocal'),
			'id' => MTHEME . '_clientname',
			'type' => 'text',
			'heading' => 'subhead',
			'desc' => __('Name of Client','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Client Link (optional)','mthemelocal'),
			'id' => MTHEME . '_clientname_link',
			'type' => 'text',
			'heading' => 'subhead',
			'desc' => __('URL of Client','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Project Link (optional)','mthemelocal'),
			'id' => MTHEME . '_projectlink',
			'type' => 'text',
			'heading' => 'subhead',
			'desc' => __('Project link. URL followed with <code>http://</code>','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Custom Thumbnail. (optional)','mthemelocal'),
			'id' => MTHEME . '_customthumbnail',
			'type' => 'upload',
			'target' => 'image',
			'desc' => __('Thumbnail URL. URL followed with <code>http://</code>','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Background Settings','mthemelocal'),
			'id' => MTHEME . '_header_section_id',
			'type' => 'break',
			'sectiontitle' => __('Background Settings','mthemelocal'),
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
add_action("admin_init", "mtheme_portfolioitemmetabox_init");
function mtheme_portfolioitemmetabox_init(){
	add_meta_box("mtheme_portfolioInfo-meta", "Portfolio Options", "mtheme_portfolioitem_metaoptions", "mtheme_portfolio", "normal", "low");
}
/*
* Meta options for Portfolio post type
*/
function mtheme_portfolioitem_metaoptions(){
	global $mtheme_portfolio_box, $post;
	mtheme_generate_metaboxes($mtheme_portfolio_box,$post);
}
?>