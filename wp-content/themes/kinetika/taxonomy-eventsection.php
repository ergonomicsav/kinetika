<?php
get_header();
?>
<?php
$event_achivelisting=of_get_option('event_achivelisting');

$portfolio_perpage="6";
$count=0;
$columns=$event_achivelisting;

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
$event_sort_order=of_get_option('event_sort_order');
echo do_shortcode('[gridcreate grid_post_type="mtheme_events" sortorder="'.$event_sort_order.'" grid_tax_type="eventsection" boxtitle="false" worktype_slugs="'.$worktype.'" format="'.$format.'" type="default" limit="-1" pagination="true" columns="'.$columns.'" title="true" desc="true"]');
?>
</div>
<?php get_footer(); ?>