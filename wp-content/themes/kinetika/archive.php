<?php
/**
 * Archive
 *
 */
get_header(); ?>
<?php
global $mtheme_pagelayout_type;
$mtheme_pagelayout_type="two-column";
?>
<div class="contents-wrap float-left two-column">
<?php
	if ( have_posts() )
		the_post();
?>
	<?php
		rewind_posts();
		get_template_part( 'loop', 'archive' );
	?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
