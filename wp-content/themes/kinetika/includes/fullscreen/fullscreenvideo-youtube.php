<?php
$featured_page=mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$fullscreen_infobox='';
$custom = get_post_custom($featured_page);
if (isSet($custom[MTHEME . "_fullscreen_infobox"][0])) $fullscreen_infobox=$custom[MTHEME . "_fullscreen_infobox"][0];
if (isSet($custom[MTHEME . "_youtubevideo"][0])) $youtube=$custom[MTHEME . "_youtubevideo"][0];

?>
<div id="backgroundvideo">
</div>
<script>
jQuery(document).ready(function($) {
	var options = { videoId: '<?php echo esc_attr($youtube); ?>', wrapperZIndex: -1, start: 0, mute: false, repeat: true, ratio: 16/9 };
	$('#backgroundvideo').tubular(options);
});
</script>
<?php
get_template_part( '/includes/fullscreen/information', 'box' );
?>