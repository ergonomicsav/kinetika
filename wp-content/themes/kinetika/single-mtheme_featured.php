<?php
//Defined in Theme Framework functions
$featured_page = get_the_ID();
$custom = get_post_custom( get_the_ID() );
if ( isSet($custom[ MTHEME . "_fullscreen_type"][0]) ) {
	$fullscreen_type = $custom[ MTHEME . "_fullscreen_type"][0];
}
$fullscreen_post_load = mtheme_get_fullscreen_file($fullscreen_type);
if (isSet($fullscreen_post_load)) {
	switch ($fullscreen_post_load) {
		case "photowall" :
			get_template_part('/includes/fullscreen/fullscreen', 'photowall' );
		break;

		case "kenburns" :
			get_template_part('/includes/fullscreen/fullscreen', 'kenburns' );
		break;

		case "coverphoto" :
			get_template_part('/includes/fullscreen/fullscreen', 'coverphoto' );
		break;

		case "particles" :
			get_template_part('/includes/fullscreen/fullscreen', 'particles' );
		break;

		case "fotorama" :
			get_template_part('/includes/fullscreen/fullscreen', 'fotorama' );
		break;

		case "carousel" :
			get_template_part('/includes/fullscreen/fullscreen', 'carousel' );
		break;
		
		case "supersized" :
			get_template_part('/includes/fullscreen/fullscreen', 'supersized' );
		break;
		
		case "video" :
			get_template_part('/includes/fullscreen/fullscreen', 'video' );
		break;

		case "revslider" :
			get_template_part('/includes/fullscreen/fullscreen', 'revslider' );
		break;
		default:
		break;
	}
} else {
	echo 'fullscreen type not found';
}
?>