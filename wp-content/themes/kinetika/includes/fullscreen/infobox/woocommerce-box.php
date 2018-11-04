<?php
/**
 * Blog Slideshow .
 *
 */
$woocommerce_autoplay = of_get_option('woocommerce_autoplay');
if ($woocommerce_autoplay<>"true" && $woocommerce_autoplay<>"false") {
	$woocommerce_autoplay="true";
}
echo do_shortcode('[display_woocommerce_infobox_slideshow autoheight="false" autoplay="'.$woocommerce_autoplay.'"]');
?>