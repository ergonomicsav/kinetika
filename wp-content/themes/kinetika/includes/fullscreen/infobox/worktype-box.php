<?php
$worktype_autoplay = of_get_option('worktypebox_autoplay');
if ($worktype_autoplay<>"true" && $worktype_autoplay<>"false") {
	$worktype_autoplay="true";
}
echo do_shortcode('[display_worktype_infobox_slideshow autoheight="false" autoplay="'.$worktype_autoplay.'"]');
?>