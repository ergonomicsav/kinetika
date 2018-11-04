<?php
/*
* Category List
*/
?>
<?php get_header(); ?>
<div class="contents-wrap float-left two-column">
<?php
	if ( have_posts() )
		the_post();
?>
	<div class="entry-content-wrapper">

		<?php
		rewind_posts();
			get_template_part( 'loop', 'category' );
		?>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>