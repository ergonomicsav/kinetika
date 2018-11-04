<?php
//Defined in Theme Framework functions
$featured_page = get_the_ID();
$custom = get_post_custom( get_the_ID() );
$fullscreen_type = "fotorama";
$fullscreen_post_load = mtheme_get_fullscreen_file($fullscreen_type);
if (isSet($fullscreen_post_load)) {
	switch ($fullscreen_post_load) {
		case "fotorama" :
			get_template_part('/includes/photostory/photostory', 'fotorama' );
		break;

		default:
		break;
	}
} else {
	echo 'photostory type not found';
}
?>