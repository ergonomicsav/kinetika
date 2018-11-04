<?php
/*
*  Single Page
*/
?>
<?php get_header(); ?>
<?php
$floatside="";
$mtheme_pagestyle= get_post_meta($post->ID, MTHEME . '_pagestyle', true);
if (!isSet($mtheme_pagestyle) || $mtheme_pagestyle=="") {
	$mtheme_pagestyle="rightsidebar";
}
if ($mtheme_pagestyle != "nosidebar") {
	$floatside="float-left";
	if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left two-column"; }
	if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right two-column"; }
} else {
	$floatside="fullwidth-column";
}
if ( post_password_required() ) {
	$floatside="fullwidth-column";
}
if ($mtheme_pagestyle == "edge-to-edge") {
	$floatside="";
}
?>
<div class="contents-wrap <?php echo esc_attr($floatside); ?>">
<?php
get_template_part( 'loop', 'single' );
?>
</div>
<?php
if ( !post_password_required() ) {
	if ($mtheme_pagestyle != "nosidebar") {
		global $mtheme_pagestyle;
		if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
			get_sidebar();
		}
	}
}
get_footer();
?>