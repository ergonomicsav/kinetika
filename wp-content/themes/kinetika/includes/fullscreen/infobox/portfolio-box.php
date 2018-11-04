<?php
$portfoliobox_autoplay = of_get_option('portfoliobox_autoplay');
if ($portfoliobox_autoplay<>"true" && $portfoliobox_autoplay<>"false") {
	$portfoliobox_autoplay="true";
}
echo do_shortcode('[display_portfolio_infobox_slideshow autoheight="false" autoplay="'.$portfoliobox_autoplay.'"]');
?>