<?php
/**
 * Blog Slideshow .
 *
 */
$blogbox_autoplay = of_get_option('blogbox_autoplay');
if ($blogbox_autoplay<>"true" && $blogbox_autoplay<>"false") {
	$blogbox_autoplay="true";
}
echo do_shortcode('[display_blog_infobox_slideshow autoheight="false" autoplay="'.$blogbox_autoplay.'"]');
?>