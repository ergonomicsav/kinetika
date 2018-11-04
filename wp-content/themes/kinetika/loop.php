<?php
/**
 * Loop
 *
 */
?>
<?php 
if ( have_posts() ) while ( have_posts() ) : the_post();
	get_template_part( 'post', 'summary' );
endwhile;
get_template_part( '/includes/paginate', 'navigation' );
?>