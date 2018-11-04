<?php
/*
Template Name: Event Gallery
*/
?>
<?php
get_header();
?>
<?php
$portfolio_style= get_post_meta($post->ID, MTHEME . '_portfolio_style', true);
$portfolio_category= get_post_meta($post->ID, MTHEME . '_portfolio_category', true);
$portfolio_link= get_post_meta($post->ID, MTHEME . '_portfolio_link', true);

$event_achivelisting=of_get_option('event_achivelisting');

$portfolio_perpage="6";
$count=0;
$columns=$event_achivelisting;

$portfolio_cat= get_term_by ( 'name', $portfolio_category,'types' );
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
$format=of_get_option('portfolio_archive_format');
echo do_shortcode('[gridcreate grid_post_type="mtheme_events" grid_tax_type="tagevents" boxtitle="false" worktype_slugs="'.$worktype.'" format="'.$format.'" type="default" limit="-1" pagination="true" columns="'.$columns.'" title="true" desc="true"]');
?>
</div>
<?php get_footer(); ?>