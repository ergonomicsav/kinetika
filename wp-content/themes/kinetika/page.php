<?php
/*
*  Page
*/
?>
 
<?php get_header(); ?>
<?php
if ( post_password_required() ) {
	echo '<div class="entry-content" id="password-protected">';
	echo get_the_password_form();
	if (MTHEME_DEMO_STATUS) { echo '<h2>DEMO Password is 1234</h2>'; }
	echo '</div>';
} else {
	$mtheme_pagestyle= get_post_meta($post->ID, MTHEME . '_pagestyle', true);
	$floatside="float-left";
	if ($mtheme_pagestyle=="nosidebar") { $floatside=""; }
	if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; }
	if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; }

	if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" ) {
		$mtheme_pagestyle="rightsidebar";
		$floatside="float-left";
	}
	if ( $mtheme_pagestyle=="edge-to-edge") {
		$floatside='';
		$mtheme_pagestyle='nosidebar';
	}
	?>
	<div class="page-contents-wrap <?php echo esc_attr($floatside); ?> <?php if ($mtheme_pagestyle != "nosidebar") { echo 'two-column'; } ?>">
	<?php
	get_template_part( 'loop', 'page' );
	?>
	</div>
	<?php
	global $mtheme_pagestyle;
	if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
		get_sidebar();
	}
}
?>
<?php get_footer(); ?>