<?php
$events_autoplay = of_get_option('events_autoplay');
if ($events_autoplay<>"true" && $events_autoplay<>"false") {
	$events_autoplay="true";
}
echo do_shortcode('[display_events_infobox_slideshow autoheight="false" autoplay="'.$events_autoplay.'"]');
?>