<div class="post-format-media">
<?php
global $mtheme_pagelayout_type;
$width=MTHEME_MAX_CONTENT_WIDTH;

$posthead_size="gridblock-full-medium";

$blogpost_style= get_post_meta($post->ID, MTHEME . '_pagestyle', true);
if ($blogpost_style == "nosidebar") {
	$posthead_size="gridblock-full";
}

if ( $mtheme_pagelayout_type=="fullwidth" ) {
	$posthead_size="gridblock-full";
}

if ( $mtheme_pagelayout_type=="two-column" ) {
	$posthead_size="gridblock-full-medium";
}

if (in_the_loop()) {
	$posthead_size="gridblock-full";
}

$height= get_post_meta($post->ID, MTHEME . '_meta_gallery_height', true);

$flexi_slideshow = do_shortcode('[slideshowcarousel thumbnails="false" lightbox="true" title="true" imagesize='.$posthead_size.']');
echo $flexi_slideshow;
?>
</div>