<?php
/*
Template Name: Blog list
*/
?>
<?php get_header(); ?>
<?php
global $mtheme_pagelayout_type,$mtheme_pagestyle;;
$mtheme_pagelayout_type="two-column";
$mtheme_pagestyle= get_post_meta($post->ID, MTHEME . '_pagestyle', true);
$floatside="float-left";
if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; }
if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; }
if ($mtheme_pagestyle=="nosidebar") { $mtheme_pagelayout_type="fullwidth"; }
?>
<?php if ($mtheme_pagestyle=="nosidebar") { ?>
	<div class="fullpage-contents-wrap">
<?php } else { ?>
	<div class="contents-wrap <?php echo esc_attr($floatside); ?> two-column">
<?php } ?>
	<?php
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
	$default_posts_per_page = get_option( 'posts_per_page' );
	$args = array( 'paged' => $paged,'posts_per_page'=> $default_posts_per_page );

	$postslist = new WP_Query( $args );
    if ( $postslist->have_posts() ) :
        while ( $postslist->have_posts() ) : $postslist->the_post();
    ?>
		<div class="entry-content-wrapper">
		<?php
		get_template_part( 'post', 'summary' );
		?>
		</div>
	<?php
	endwhile;
		echo mtheme_pagination($postslist->max_num_pages);
		wp_reset_postdata();
	endif;
	?>
</div>
<?php
if ($mtheme_pagestyle=="rightsidebar" || $mtheme_pagestyle=="leftsidebar" ) {
	get_sidebar();
}
?>
<?php get_footer(); ?>