<?php
/*
Template Name: PhotoStory Gallery
*/
?>
<?php
get_header();
?>
<?php
$portfolio_style= get_post_meta($post->ID, MTHEME . '_portfolio_style', true);
$portfolio_category= get_post_meta($post->ID, MTHEME . '_portfolio_category', true);
$portfolio_link= get_post_meta($post->ID, MTHEME . '_portfolio_link', true);

$portfolio_layout=of_get_option('photostory_achivelisting');

$portfolio_perpage="6";
$count=0;
$columns=$portfolio_layout;
if ( $columns<3 ) {
	$columns=3;
}

$portfolio_cat= get_term_by ( 'name', $portfolio_category,'photostory' );
if (isset($portfolio_cat -> slug)) { $portfolio_cat_slug=$portfolio_cat -> slug; $portfolio_category=$portfolio_cat_slug; }
if (isset($portfolio_cat -> term_id)) $portfolio_cat_ID=$portfolio_cat -> term_id;

// Get which term is being querries and do shortcode with $term->slug
$term = get_queried_object();
if (!isSet($term->slug) ) {
	$worktype='';
} else {
	$worktype = $term->slug;
}
?>
<div class="entry-content fullwidth-column clearfix">
<?php
$format=of_get_option('photostory_archive_format');
if ( $format<>"landscape" && $format<>"square" && $format<>"portrait" && $format<>"masonary" ) {
	$format="landscape";
}
echo do_shortcode('[gallerygrid displaycategory="false" desc="true" worktype_slugs="'.$worktype.'" format="'.$format.'" type="default" limit="-1" pagination="true" columns="'.$columns.'"]');
?>
</div>
<?php get_footer(); ?>