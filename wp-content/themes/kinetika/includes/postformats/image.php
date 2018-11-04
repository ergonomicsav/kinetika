<?php
if ( has_post_thumbnail() ) {
	echo '<div class="post-format-media">';
}
global $mtheme_pagelayout_type;
$width=MTHEME_MAX_CONTENT_WIDTH;
$single_height='';

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

$lightbox_status= get_post_meta($post->ID, MTHEME . '_meta_lightbox', true);
$image_link=mtheme_featured_image_link($post->ID);

if ($image_link<>"") {
	if ($lightbox_status=="enabled_lightbox") {
		echo '<a title="'.mtheme_featured_image_title( get_the_id() ).'" class="postformat-image-lightbox" data-lightbox="magnific-image" href="'. esc_url( $image_link ) .'">';
	} else {
		echo '<a href="'. esc_url( get_permalink() ) .'">';
	}
	echo '<span class="lightbox-indicate"><i class="feather-icon-maximize"></i></span>';
}
echo mtheme_display_post_image (
	$post->ID,
	$have_image_url=false,
	$link=false,
	$type=$posthead_size,
	$post->post_title,
	$class="postformat-image" 
);
echo '</a>';

if ( has_post_thumbnail() ) {
	echo '</div>';
}
?>