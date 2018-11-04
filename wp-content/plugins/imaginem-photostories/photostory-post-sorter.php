<?php
/* ************************************
* Sort it for the Display List too
*************************************** */

if (is_admin()) {
	if ( 'edit.php' == basename($_SERVER['PHP_SELF']) ) {
		if ( isSet($_GET["page"]) ) {
			if ( $_GET["page"] == "gallery-post-sorter.php" ) {
				add_filter( 'posts_orderby', 'mtheme_story_orderby');
			}
		}
	}
}
function mtheme_story_orderby($orderby){
	global $wpdb;
	$orderby = "{$wpdb->posts}.menu_order, {$wpdb->posts}.post_date DESC";
	return($orderby);
} 
/* ************************************
* Ajax Sort for Gallery
*************************************** */

function mtheme_enable_story_sort() {
    add_submenu_page('edit.php?post_type=mtheme_photostory', 'Sort Stories', 'Sort Stories', 'edit_posts', basename(__FILE__), 'mtheme_sort_stories');
}
add_action('admin_menu' , 'mtheme_enable_story_sort');

 
/**
 * Display Sort admin
 *
 * @return void
 * @author Soul
 **/
function mtheme_sort_stories() {
	$gallery = new WP_Query('post_type=mtheme_photostory&posts_per_page=-1&orderby=menu_order&order=ASC');
?>
	<div class="wrap">
	<h2>Sort gallery Slides<img src="<?php echo home_url(); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
	<div class="description">
	Drag and Drop the slides to order them
	</div>
	<ul id="portfolio-list">
	<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
		<li id="<?php the_id(); ?>">
		<div>
		<?php 
		$image_url=wp_get_attachment_thumb_url( get_post_thumbnail_id() );
		$custom = get_post_custom(get_the_ID());
		$gallery_cats = get_the_terms( get_the_ID(), 'photostories' );
		
		?>
		<?php if ($image_url) { echo '<img class="mtheme_admin_sort_image" src="'.$image_url.'" width="30px" height="30px" alt="" />'; } ?>
		<span class="mtheme_admin_sort_title"><?php the_title(); ?></span>
		<?php
		if ($gallery_cats) {
		?>
		<span class="mtheme_admin_sort_categories"><?php foreach ($gallery_cats as $taxonomy) { echo ' | ' . $taxonomy->name; } ?></span>
		<?php
		}
		?>
		</div>

		</li>
	<?php endwhile; ?>
	</div><!-- End div#wrap //-->
 
<?php
}

/**
 * Upadate the gallery Sort order
 *
 * @return void
 * @author Soul
 **/
function mtheme_save_story_order() {
	global $wpdb; // WordPress database class
 
	$order = explode(',', $_POST['order']);
	$counter = 0;
 
	foreach ($order as $sort_id) {
		$wpdb->update($wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $sort_id) );
		$counter++;
	}
	die(1);
}
add_action('wp_ajax_story_sort', 'mtheme_save_story_order');

?>