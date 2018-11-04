<div class="title-container-outer-wrap">
	<div class="title-container-wrap">
	<div class="title-container clearfix">
		<?php
		do_action('mtheme_before_header_title');
		?>
		<?php
		$mtheme_pagestyle='';
		if (isSet($post->ID)){
			$custom = get_post_custom($post->ID);
		}
		if (isset($custom[MTHEME . '_pagestyle'][0])) {
			$mtheme_pagestyle=$custom[MTHEME . '_pagestyle'][0];
		} else {
			$mtheme_pagestyle="rightsidebar";
		}
		if ( is_home() ) { $mtheme_pagestyle="rightsidebar"; }
		if ( is_post_type_archive() ) { $mtheme_pagestyle="fullwidth"; }
		if ( is_tax() ) { $mtheme_pagestyle="fullwidth"; }
		if ($mtheme_pagestyle=="fullwidth" || $mtheme_pagestyle=="edge-to-edge") { $floatside=""; }
		if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; }
		if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; }

		if (isset($custom[MTHEME . '_pagetitle_style'][0])) {
			$mtheme_pagetitle_style=$custom[MTHEME . '_pagetitle_style'][0];
		}
		if (isSet($mtheme_pagetitle_style)) {
			$mtheme_pagetitle_style = ' ' . $mtheme_pagetitle_style;
		} else {
			$mtheme_pagetitle_style = '';
		}
		?>
		<div class="entry-title<?php echo esc_attr($mtheme_pagetitle_style); ?>">
			<h1 class="entry-title">
			<?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily Archives: <span>%s</span>', 'mthemelocal' ), get_the_date() ); ?>
			<?php elseif ( is_month() ) : ?>
							<?php printf( __( 'Monthly Archives: <span>%s</span>', 'mthemelocal' ), get_the_date( 'F Y' ) ); ?>
			<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Yearly Archives: <span>%s</span>', 'mthemelocal' ), get_the_date( 'Y' ) ); ?>
			<?php elseif ( is_author() ) : ?>
							<?php _e( 'Author Archives: ', 'mthemelocal' ); ?> <?php echo get_query_var('author_name'); ?>
			<?php elseif ( is_category() ) : ?>
							<?php printf( __( 'Category : %s', 'mthemelocal' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
			<?php elseif ( is_tag() ) : ?>
							<?php printf( __( 'Tag : %s', 'mthemelocal' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
			<?php elseif ( is_search() ) : ?>
							<?php printf( __( 'Search Results for: %s', 'mthemelocal' ), '<span>' . get_search_query() . '</span>' ); ?>
			<?php elseif ( is_404() ) : ?>
							<?php _e( '404 Page not Found!', 'mthemelocal' ); ?>		
			<?php elseif ( is_home() ) : ?>
							<?php bloginfo('name'); ?>
			<?php elseif ( is_front_page() ) : ?>
							<?php the_title(''); ?>
			<?php elseif ( is_post_type_archive('mtheme_portfolio') ) : ?>
							<?php echo of_get_option('portfolio_singular_refer'); ?>
			<?php elseif ( is_post_type_archive('mtheme_gallery') ) : ?>
							<?php echo of_get_option('gallery_singular_refer'); ?>
			<?php elseif ( is_post_type_archive('mtheme_events') ) : ?>
							<?php echo of_get_option('event_gallery_title'); ?>
			<?php elseif ( is_post_type_archive('mtheme_photostory') ) : ?>
							<?php echo of_get_option('story_archive_title'); ?>
			<?php elseif ( is_post_type_archive('product') ) : ?>
							<?php echo of_get_option('mtheme_woocommerce_shoptitle'); ?>
			<?php elseif ( is_tax() ) : ?>
							<?php
							$term = get_queried_object();
							if (!isSet($term->name) ) {
								$worktype = of_get_option('portfolio_singular_refer');
							} else {
								$worktype = $term->name;
							}
							echo $worktype;
							?>
			<?php else : ?>
							<?php the_title(''); ?>
			<?php endif; ?>
			</h1>
		</div>
		<?php
		do_action('mtheme_after_header_title');
		?>
	</div>
	<?php
	do_action('mtheme_display_portfolio_single_navigation');
	?>
</div>
</div>