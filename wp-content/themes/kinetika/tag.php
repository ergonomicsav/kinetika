<?php
/*
*  Tag page
*/
?>
 
<?php get_header(); ?>
<div class="contents-wrap float-left two-column">

	<?php
		rewind_posts();
		get_template_part( 'loop', 'tag' );
	?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>