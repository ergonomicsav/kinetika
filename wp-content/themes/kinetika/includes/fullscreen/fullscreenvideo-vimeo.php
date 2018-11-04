<?php
$featured_page=mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$fullscreen_infobox='';
$custom = get_post_custom($featured_page);
if (isSet($custom[MTHEME . "_fullscreen_infobox"][0])) $fullscreen_infobox=$custom[MTHEME . "_fullscreen_infobox"][0];
if (isSet($custom[MTHEME . "_vimeovideo"][0])) $vimeoID=$custom[MTHEME . "_vimeovideo"][0];
$embed_type = "iframe";
	if( is_ssl() ) {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}
?>
<div id="fullscreenvimeo">
<<?php echo esc_attr($embed_type); ?> frameborder="0" allowfullscreen="" webkitallowfullscreen="" src="<?php echo $protocol; ?>://player.vimeo.com/video/<?php echo $vimeoID; ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1&amp;loop=0"></<?php echo esc_attr($embed_type); ?>>
</div>
<?php
get_template_part( '/includes/fullscreen/information', 'box' );
?>