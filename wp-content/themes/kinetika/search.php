<?php
/*
*  Search Page
*/
?>
 
<?php get_header(); ?>
<?php
global $mtheme_pagelayout_type;
$mtheme_pagelayout_type="two-column";
?>

	<?php if ( have_posts() ) : ?>

	<div class="contents-wrap float-left two-column">

		<?php
			get_template_part( 'loop', 'search' );
		?>
	</div>

	<?php get_sidebar(); ?>
	<?php else : ?>
	<div class="page-contents-wrap">
		<div class="entry-wrapper lower-padding">
		<div class="entry-spaced-wrapper">
			<div class="entry-content mtheme-search-no-results">
				<h4><?php _e( 'Nothing Found', 'mthemelocal' ); ?></h4>
				<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'mthemelocal' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div>
		</div>
	</div>

	<?php endif; ?>

<?php get_footer(); ?>