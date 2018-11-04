<?php
global $mtheme_meta_box,$mtheme_events_box,$mtheme_active_metabox;

$mtheme_active_metabox="events";
$mtheme_sidebar_options = mtheme_generate_sidebarlist("events");

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

$mtheme_events_box = array(
	'id' => 'eventsmeta-box',
	'title' => 'Events Metabox',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'core',
	'fields' => array(
		array(
			'name' => __('Event Settings','mthemelocal'),
			'id' => MTHEME . '_events_section_id',
			'type' => 'break',
			'sectiontitle' => __('Events Settings','mthemelocal'),
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
			'name' => __('Description text','mthemelocal'),
			'id' => MTHEME . '_thumbnail_desc',
			'heading' => 'subhead',
			'type' => 'textarea',
			'desc' => __('Description text to display in fullscreen information box','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Event Status','mthemelocal'),
			'id' => MTHEME . '_event_notice',
			'class' => 'event_notice',
			'type' => 'select',
			'desc' => __('Event Status','mthemelocal'),
			'options' => array(
				'active' => 'Active',
				'inactive' => 'Hide from Listings',
				'postponed' => 'Display as Postponed',
				'cancelled' => 'Display as Cancelled'
				),
		),
		array(
			'name' => __('Event Date','mthemelocal'),
			'id' => MTHEME . '_event_startdate',
			'type' => 'datepicker',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('Start date','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Time','mthemelocal'),
			'id' => MTHEME . '_event_starttime',
			'type' => 'timepicker',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('Start time','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_endtime',
			'type' => 'timepicker',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('End time','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => 'End Date',
			'id' => MTHEME . '_event_enddate',
			'type' => 'datepicker',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('End date','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Venue','mthemelocal'),
			'id' => MTHEME . '_event_venue_name',
			'type' => 'text',
			'heading' => 'subhead',
			'desc' => __('Venue Name','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_street',
			'type' => 'text',
			'heading' => 'subhead',
			'desc' => __('Street','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_state',
			'type' => 'text',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('State','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_postal',
			'type' => 'text',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('Zip/Postal Code','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_country',
			'type' => 'country',
			'heading' => 'subhead',
			'desc' => __('Event country','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_phone',
			'type' => 'text',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('Phone','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_website',
			'type' => 'text',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('Website','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_currency',
			'type' => 'text',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('Cost Currency Symbol','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_event_venue_cost',
			'type' => 'text',
			'class' => 'textsmall',
			'heading' => 'subhead',
			'desc' => __('Cost Value','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Page Style','mthemelocal'),
			'id' => MTHEME . '_pagestyle',
			'type' => 'image',
			'std' => 'rightsidebar',
			'desc' => __('<strong>With Sidebar :</strong> Displays post with sidebar - two columns<br/><strong>Fullwidth without sidebar :</strong> Displays post as without sidebar','mthemelocal'),
			'options' => array(
				'fullwidth' => $mtheme_imagepath . 'page_nosidebar.png',
				'rightsidebar' => $mtheme_imagepath . 'page_rightsidebar.png',
				'leftsidebar' => $mtheme_imagepath . 'page_leftsidebar.png',
				'edge-to-edge' => $mtheme_imagepath . 'page_edgetoedge.png')
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
add_action("admin_init", "mtheme_eventsitemmetabox_init");
function mtheme_eventsitemmetabox_init(){
	add_meta_box("mtheme_eventsInfo-meta", "Events Options", "mtheme_eventsitem_metaoptions", "mtheme_events", "normal", "low");
}
/*
* Meta options for Events post type
*/
function mtheme_eventsitem_metaoptions(){
	global $mtheme_events_box, $post;
	mtheme_generate_metaboxes($mtheme_events_box,$post);
}
?>