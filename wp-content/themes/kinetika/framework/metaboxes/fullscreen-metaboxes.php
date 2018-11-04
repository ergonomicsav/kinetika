<?php
global $mtheme_meta_box,$mtheme_fullscreen_box,$mtheme_active_metabox;

$mtheme_active_metabox="fullscreen";
$mtheme_sidebar_options = mtheme_generate_sidebarlist("portfolio");

// Pull all the Featured into an array
$bg_slideshow_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');

require_once( MTHEME_OPTIONS_ROOT . 'google-fonts.php');
$options_fonts = mtheme_google_fonts();

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

$portfolio_worktypes = get_categories('taxonomy=types&title_li=');
$len = count($portfolio_worktypes);
$portfolio_list_options='';
$count=0;
foreach($portfolio_worktypes as $key => $list) {
	$count++;	
	if (isSet($list->slug)) {
		if ( $len == $count ) {
				$portfolio_list_options .= $list->slug;
		} else {
			$portfolio_list_options .= $list->slug . ',';
		}
	}
}

$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/';

/**
 * Add Photographer Name and URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 
function mtheme_attachment_fields_fullscreen_link( $form_fields, $post ) {
	$form_fields['mtheme_attachment_fullscreen_link'] = array(
		'label' => 'Fullscreen Button Text',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'mtheme_attachment_fullscreen_link', true ),
		'helps' => '* Only for Fullscreen Slideshow & Static images',
	);

	$form_fields['mtheme_attachment_fullscreen_url'] = array(
		'label' => 'Fullscreen Button Link',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'mtheme_attachment_fullscreen_url', true ),
		'helps' => '* Only for Fullscreen Slideshow & Static images',
	);

	$form_fields["mtheme_attachment_fullscreen_color"]["label"] = __("UI color ( Slideshow images )",'mthemelocal');
	$form_fields["mtheme_attachment_fullscreen_color"]["input"] = "html";
    $form_fields['mtheme_attachment_fullscreen_color']['html'] = "<select name='attachments[{$post->ID}][mtheme_attachment_fullscreen_color]'>";
    $form_fields['mtheme_attachment_fullscreen_color']['html'] .= '<option '.selected(get_post_meta($post->ID, "mtheme_attachment_fullscreen_color", true), 'bright',false).' value="bright">Bright</option>';
    $form_fields['mtheme_attachment_fullscreen_color']['html'] .= '<option '.selected(get_post_meta($post->ID, "mtheme_attachment_fullscreen_color", true), 'dark',false).' value="dark">Dark</option>';
    $form_fields['mtheme_attachment_fullscreen_color']['html'] .= '</select>';

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'mtheme_attachment_fields_fullscreen_link', 10, 2 );

/**
 * Save values of Photographer Name and URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

function mtheme_attachment_fields_fullscreen_link_save( $post, $attachment ) {
	if( isset( $attachment['mtheme_attachment_fullscreen_link'] ) )
		update_post_meta( $post['ID'], 'mtheme_attachment_fullscreen_link', $attachment['mtheme_attachment_fullscreen_link'] );

	if( isset( $attachment['mtheme_attachment_fullscreen_url'] ) )
		update_post_meta( $post['ID'], 'mtheme_attachment_fullscreen_url', esc_url( $attachment['mtheme_attachment_fullscreen_url'] ) );

	if( isset( $attachment['mtheme_attachment_fullscreen_color'] ) )
		update_post_meta( $post['ID'], 'mtheme_attachment_fullscreen_color', $attachment['mtheme_attachment_fullscreen_color'] );

	return $post;
}

add_filter( 'attachment_fields_to_save', 'mtheme_attachment_fields_fullscreen_link_save', 10, 2 );


$mtheme_fullscreen_box = array(
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
			'name' => __('Fullscreen Type','mthemelocal'),
			'id' => MTHEME . '_fullscreen_type',
			'type' => 'image',
			'triggerStatus'=> 'on',
			'std' => 'slideshow',
			'class' => 'page_type',
			'desc' => __('Fullscreen page type','mthemelocal'),
			'options' => array(
				'slideshow' => $mtheme_imagepath . 'fullscreen_slideshow.png',
				'kenburns' => $mtheme_imagepath . 'fullscreen_kenburns.png',
				'coverphoto' => $mtheme_imagepath . 'fullscreen_coverphoto.png',
				'photowall' => $mtheme_imagepath . 'fullscreen_photowall.png',
				'carousel' => $mtheme_imagepath . 'fullscreen_carousel.png',
				'particles' => $mtheme_imagepath . 'fullscreen_particles.png',
				'video' => $mtheme_imagepath . 'fullscreen_video.png',
				'fotorama' => $mtheme_imagepath . 'fullscreen_fotorama.png',
				'revslider' => $mtheme_imagepath . 'fullscreen_revslider.png')
		),
		array(
			'name' => __('Particle Type','mthemelocal'),
			'id' => MTHEME . '_particle_type',
			'type' => 'select',
			'std' => 'lightbox',
			'class' => 'page_type-particles page_type-trigger',
			'desc' => __('Particle type','mthemelocal'),
			'options' => array(
				'default' => 'Default',
				'stars' => 'Stars',
				'snow' => 'Snow',
				'grab' => 'Grab',
				'move' => 'Move')
		),
		array(
			'name' => __('Particles / Cover Text Style','mthemelocal'),
			'id' => MTHEME . '_cover_style',
			'type' => 'image',
			'std' => 'plain',
			'class' => 'page_type-coverphoto page_type-particles page_type-trigger',
			'desc' => __('Cover Text Style','mthemelocal'),
			'options' => array(
				'plain' => $mtheme_imagepath . 'cover_plain.png',
				'border' => $mtheme_imagepath . 'cover_border.png',
				'fill' => $mtheme_imagepath . 'cover_fill.png',
				'topbottom' => $mtheme_imagepath . 'cover_topbottom.png',
				'underline' => $mtheme_imagepath . 'cover_underline.png')
		),
		array(
			'name' => __('Fotorama Fill mode','mthemelocal'),
			'id' => MTHEME . '_fotorama_fill',
			'type' => 'select',
			'std' => 'enable',
			'class' => 'page_type-fotorama page_type-trigger',
			'desc' => __('Fotorama Fill mode','mthemelocal'),
			'options' => array(
				'cover' => 'Fill',
				'contain' => 'Fit')
		),
		array(
			'name' => __('Fotorama Thumbnails','mthemelocal'),
			'id' => MTHEME . '_fotorama_thumbnails',
			'type' => 'select',
			'std' => 'enable',
			'class' => 'page_type-fotorama page_type-trigger',
			'desc' => __('Fotorama Thumbnails','mthemelocal'),
			'options' => array(
				'enable' => 'Enable',
				'disable' => 'Disable')
		),
		array(
			'name' => __('Revolution Slider','mthemelocal'),
			'id' => MTHEME . '_revslider',
			'type' => 'select',
			'class' => 'page_type-revslider page_type-trigger',
			'desc' => __('Display Revolution Slider','mthemelocal'),
			'options' => mtheme_rev_slider_selectors()
		),
		array(
			'name' => __('Display Information Box','mthemelocal'),
			'id' => MTHEME . '_fullscreen_infobox',
			'type' => 'select',
			'class' => 'page_type-slideshow page_type-kenburns page_type-video page_type-trigger',
			'std' => 'auto',
			'desc' => __('Display Informattion Box. Only for fullscreen slideshows, kenburns and videos','mthemelocal'),
			'options' => array(
				'none' => __('None','mthemelocal'),
				'events' => __('Events','mthemelocal'),
				'portfolio' => __('Portfolio','mthemelocal'),
				'blog' => __('Blog Posts','mthemelocal'),
				'worktype' => __('Work Type Albums','mthemelocal'),
				'woofeatured' => __('WooCommerce Featured','mthemelocal')
				)
		),

		array(
			'name' => __('Carousel text color','mthemelocal'),
			'id' => MTHEME . '_carousel_text',
			'type' => 'select',
			'std' => 'auto',
			'class' => 'page_type-carousel page_type-trigger',
			'desc' => __('Select text brightness. For flat colors select a setting other than Auto','mthemelocal'),
			'options' => array(
				'carousel-white' => 'White',
				'carousel-black' => 'Black')
		),

		array(
			'name' => __('Title font','mthemelocal'),
			'id' => MTHEME . '_fullscreentitlefont_meta',
			'type' => 'fontselector',
			'class' => 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
			'desc' => __('Slideshow/Static Title Font','mthemelocal'),
			'options' => $options_fonts
		),

		array(
			'name' => __('Title font size','mthemelocal'),
			'id' => MTHEME . '_fullscreentitlesize_meta',
			'type' => 'text',
			'class' => 'mtextfield-small page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
			'desc' => __('Slideshow/Static Title size in pixels. Only numerical value eg. 52','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Title line-height','mthemelocal'),
			'id' => MTHEME . '_fullscreentitlelineheight_meta',
			'type' => 'text',
			'class' => 'mtextfield-small page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
			'desc' => __('Slideshow/Static Title letter spacing in pixels. Only numerical value eg. 2','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Title letter-spacing','mthemelocal'),
			'id' => MTHEME . '_fullscreentitlespacing_meta',
			'type' => 'text',
			'class' => 'mtextfield-small page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
			'desc' => __('Slideshow/Static Title line height in pixels. Only numerical value eg. 2','mthemelocal'),
			'std' => ''
		),

		array(
			'name' => __('For Cover Photo, Particles, Kenburns & Static Slideshow Text','mthemelocal'),
			'id' => MTHEME . '_static_title',
			'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
			'type' => 'text',
			'desc' => __('Static Title','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_static_description',
			'heading' => 'subhead',
			'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
			'type' => 'textarea',
			'desc' => __('Static Decription','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_static_link_text',
			'heading' => 'subhead',
			'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
			'type' => 'text',
			'desc' => __('Static Button Text','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_static_url',
			'heading' => 'subhead',
			'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
			'type' => 'text',
			'desc' => __('Static Button Link','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('For Photowall','mthemelocal'),
			'id' => MTHEME . '_photowall_type',
			'type' => 'select',
			'std' => 'lightbox',
			'class' => 'page_type-photowall page_type-trigger',
			'desc' => __('Photowall type','mthemelocal'),
			'options' => array(
				'lightbox' => 'Lightbox from Image Attachments',
				'portfolio' => 'Linked to Portfolio items')
		),
		array(
			'name' => __('Portfolio Worktypes to populate Photowall ( enter comma seperated slugs )<br/><br/>','mthemelocal') . '<small>' . $portfolio_list_options . '</small>',
			'id' => MTHEME . '_photowall_workstypes',
			'heading' => 'subhead',
			'type' => 'text',
			'std' => '',
			'class' => 'page_type-photowall page_type-trigger',
			'desc' => __('Enter comma seperated slugs. Leave Blank to list all.','mthemelocal'),
		),
		array(
			'name' => __('Switch Menu','mthemelocal'),
			'id' => MTHEME . '_menu_choice',
			'type' => 'select',
			'desc' => __('Select a different menu for this page','mthemelocal'),
			'options' => mtheme_generate_menulist()
		),
		array(
			'name' => __('Audio & Video Settings','mthemelocal'),
			'id' => MTHEME . '_page_section_id',
			'type' => 'break',
			'class'=> 'page_type-slideshow page_type-video page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
			'sectiontitle' => __('Audio & Video Settings','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Slideshow Audio files (optional)','mthemelocal'),
			'id' => MTHEME . '_slideshow_mp3',
			'class'=> 'slideshowaudio page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
			'type' => 'text',
			'desc' => __('Enter MP3 file path for Slideshow. ( full url )','mthemelocal'),
			'std' => ''
		),

		array(
			'name' => '',
			'id' => MTHEME . '_slideshow_oga',
			'heading' => 'subhead',
			'class'=> 'slideshowaudio page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
			'type' => 'text',
			'desc' => __('Enter OGA file path for Slideshow ( full url )','mthemelocal'),
			'std' => ''
		),

		array(
			'name' => '',
			'id' => MTHEME . '_slideshow_m4a',
			'heading' => 'subhead',
			'class'=> 'slideshowaudio page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
			'type' => 'text',
			'desc' => __('Enter M4A file path for Slideshow ( full url )','mthemelocal'),
			'std' => ''
		),
		
		array(
			'name' => __('Vimeo video ID','mthemelocal'),
			'id' => MTHEME . '_vimeovideo',
			'class'=> 'fullscreenvideo page_type-video page_type-trigger',
			'type' => 'text',
			'desc' => __('Enter Vimeo video ID for fullscreen playback','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('Youtube video ID','mthemelocal'),
			'id' => MTHEME . '_youtubevideo',
			'class'=> 'fullscreenvideo page_type-video page_type-trigger',
			'type' => 'text',
			'desc' => __('Youtube IDs<br/>eg: <code>ylLzyHk54Z0</code>. Youtube video IDs can be found at the end of youtube url - <br/>http://www.youtube.com/watch?v=<code>ylLzyHk54Z0</code>','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => __('HTML5 Video','mthemelocal'),
			'id' => MTHEME . '_html5_poster',
			'class'=> 'html5video page_type-video page_type-trigger',
			'type' => 'upload',
			'desc' => __('Poster image','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_html5_mp4',
			'heading' => 'subhead',
			'class'=> 'html5video page_type-video page_type-trigger',
			'type' => 'text',
			'desc' => __('MP4 file','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_html5_webm',
			'heading' => 'subhead',
			'class'=> 'html5video page_type-video page_type-trigger',
			'type' => 'text',
			'desc' => __('WEBM file','mthemelocal'),
			'std' => ''
		),
		array(
			'name' => '',
			'id' => MTHEME . '_html5_ogv',
			'heading' => 'subhead',
			'class'=> 'html5video page_type-video page_type-trigger',
			'type' => 'text',
			'desc' => __('OGV file','mthemelocal'),
			'std' => ''
		),
	)
);
add_action("admin_init", "mtheme_fullscreenitemmetabox_init");
function mtheme_fullscreenitemmetabox_init(){
    add_meta_box("mtheme_featured-meta", "Featured Options", "mtheme_featured_options", "mtheme_featured", "normal", "low");
}
/*
* Meta options for Portfolio post type
*/
function mtheme_featured_options(){
	global $mtheme_fullscreen_box, $post;
	mtheme_generate_metaboxes($mtheme_fullscreen_box,$post);
}
?>