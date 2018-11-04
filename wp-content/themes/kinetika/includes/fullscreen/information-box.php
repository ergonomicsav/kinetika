<?php
$featured_page=mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
$fullscreen_infobox="";
if (isSet($custom[MTHEME . "_fullscreen_infobox"][0])) {
	$fullscreen_infobox=$custom[MTHEME . "_fullscreen_infobox"][0];
}
if ($fullscreen_infobox=="events") {
	get_template_part( '/includes/fullscreen/infobox/events', 'box' );
}
if ($fullscreen_infobox=="portfolio") {
	get_template_part( '/includes/fullscreen/infobox/portfolio', 'box' );
}
if ($fullscreen_infobox=="blog") {
	get_template_part( '/includes/fullscreen/infobox/blog', 'box' );
}
if ($fullscreen_infobox=="worktype") {
	get_template_part( '/includes/fullscreen/infobox/worktype', 'box' );
}
if ($fullscreen_infobox=="woofeatured") {
	get_template_part( '/includes/fullscreen/infobox/woocommerce', 'box' );
}
?>