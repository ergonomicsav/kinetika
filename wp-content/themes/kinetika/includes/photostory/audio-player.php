<?php
$featured_page=mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
$sound_found=false;
$mp3_ext='';
$mp3_sep='';
$m4a_ext='';
$m4a_sep='';
$oga_ext='';
if (isset($custom[ MTHEME . "_slideshow_mp3"][0])) $mp3_file=$custom[ MTHEME . "_slideshow_mp3"][0];
if (isset($custom[ MTHEME . "_slideshow_m4a"][0])) $m4a_file=$custom[ MTHEME . "_slideshow_m4a"][0];
if (isset($custom[ MTHEME . "_slideshow_oga"][0])) $oga_file=$custom[ MTHEME . "_slideshow_oga"][0];

if ( isset($mp3_file) && $mp3_file<>'' ) { $sound_found=true; $mp3_ext ="mp3"; if ($m4a_file || $oga_file){ $mp3_sep=",";} }
if ( isset($m4a_file)  && $m4a_file<>'' ) { $sound_found=true; $m4a_ext ="m4a"; if ($oga_file){ $m4a_sep=",";} }
if ( isset($oga_file)  && $oga_file<>'' ) { $sound_found=true; $oga_ext ="oga";  }

if ($sound_found) {
	$files_used=$mp3_ext.$mp3_sep.$m4a_ext.$m4a_sep.$oga_ext;
}

if ( $sound_found ) {
	$volume_level = of_get_option('audio_volume')/100;
?>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function(){
	jQuery("#jquery_jplayer_<?php the_ID(); ?>").jPlayer({
		ready: function () {
			jQuery(this).jPlayer("setMedia", {
				<?php if ($mp3_file) echo 'mp3: "'.esc_url($mp3_file).'",'; ?>
				<?php if ($m4a_file) echo 'm4a: "'.esc_url($m4a_file).'",'; ?>
				<?php if ($oga_file) echo 'oga: "'.esc_url($oga_file).'",'; ?>
				end: ""
			}).jPlayer("play").jPlayer("volume", <?php echo esc_js( $volume_level ); ?>);
		},
		<?php
		if ( of_get_option('audio_loop') ) {
		?>
		ended: function() {
		jQuery(this).jPlayer("play");
		},
		<?php
		}
		?>
		swfPath: "<?php echo esc_url(get_stylesheet_directory_uri() . '/js/html5player/'); ?>",
		supplied: "<?php echo esc_js($files_used); ?>",
		cssSelectorAncestor: "#jp_interface_<?php esc_js(the_ID()); ?>"
	});
});
//]]>
</script>

<?php
if ( !wp_is_mobile() ) {
?>
<div class="fullscreenslideshow-audio">
<div id="jquery_jplayer_<?php esc_attr(the_ID()); ?>" class="jp-jplayer"></div>
<div class="jp-audio">
	<div class="jp-type-single">
		<div id="jp_interface_<?php esc_attr(the_ID()); ?>" class="jp-interface">
			<ul class="jp-controls">
				<li><a href="#" class="jp-mute" tabindex="1" title="mute">&#xe098;</a></li>
				<li><a href="#" class="jp-unmute" tabindex="1" title="unmute">&#xe099;</a></li>
			</ul>
		</div>
	</div>
</div>
</div>
<?php
}
?>
<?php
}
?>