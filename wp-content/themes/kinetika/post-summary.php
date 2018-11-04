<?php

if ( !isset($count) ) $count=0;

$single_summary_type= get_post_meta($post->ID, MTHEME . '_post_summary_type', true);
$single_video_type= get_post_meta($post->ID, MTHEME . '_post_video_type', true);
$single_height= get_post_meta($post->ID, MTHEME . '_post_summary_image_height', true);
$single_height_setting= get_post_meta($post->ID, MTHEME . '_post_height_setting', true);

if ($single_height=="") { $single_height=0; }
if ($single_height_setting=="Auto" || $single_height_setting="") { $single_height=0; }

$width=MTHEME_MIN_CONTENT_WIDTH;
$postformat = get_post_format();
if($postformat == "") $postformat="standard";
$count++;
?>
<div class="<?php if ($count==1) { echo 'topseperator'; } ?> entry-wrapper post-<?php echo esc_attr($postformat); ?>-wrapper clearfix">
<div class="blog-details-section">
	<div class="blog-details-section-inner">
		<span class="the-day"><?php echo get_the_date( 'd' ); ?></span>
		<span class="the-month"><?php echo get_the_date( 'M' ); ?></span>
		<span class="the-year"><?php echo get_the_date( 'Y' ); ?></span>
	</div>
</div>
<div class="blog-content-section">
<?php
get_template_part( 'includes/postformats/default' );
?>
</div>
</div>