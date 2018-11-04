<?php
function mtheme_knowledgebase_display_categories($atts, $content = null) {
	extract(shortcode_atts(array(
		"columns" => "4",
		"section_slugs" =>'',
		"id" => "1",
		"postlimit" => "5"
	), $atts));

	$output='';
	$count=0;

	global $kb_list_count;

	$taxonomy="kbsection";

	if ($section_slugs!='') $all_sections = explode(",", $section_slugs);

	$categories=  get_categories('orderby=slug&taxonomy='.$taxonomy.'&title_li=');

	$kb_list_count++;
	$output .= '<div id="kbase-'.$id.'" class="knowledgepress-id-'.get_the_id().' clear">';

	foreach ($categories as $category){
		
			$count++;
			
			$column_space = " column_space";
			if ($columns == $count) {
					$column_space='';
					$count = 0;
			}

			//Count the items and reset
			$countquery = array(
				'post_type' => 'mtheme_knowledgebase',
				'kbsection' => $category->slug,
				'posts_per_page' => -1,
				);
			query_posts($countquery);

			$item_counter=0;
			if (have_posts()) : while (have_posts()) : the_post();
					$item_counter++;
			endwhile; endif;

			$hreflink = get_term_link($category->slug,'kbsection');

			$term_slug = $category->slug;
			$term = get_term_by('slug', $term_slug, $taxonomy);
			if ( !isSet($all_sections) || in_array($term_slug, $all_sections) ) {

					$output .= '<div class="column'.$columns.$column_space.'">';
					$output .= '<div class="mtheme-knowledgebase-archive mtheme-kb-cat-'.$category->slug.'">';
					$output .= '<div class="mtheme-kb-heading-info">';
					$output .= '<h2>';
					$output .= '<a href="'.$hreflink.'">';
					$output .= $category->name;
					$output .= '</a>';
					$output .= '</h2>';
					$output .= '<span class="kb-post-count">'.$item_counter. ' articles</span>';
					$output .= '</div>';

					$kbase_query = array(
						'post_type' => 'mtheme_knowledgebase',
						'kbsection' => $category->slug,
						'posts_per_page' => $postlimit,
						);
					query_posts($kbase_query);
					
					if (have_posts()) : 

							$output .= '<ul>';

							while (have_posts()) : the_post();
							
									$output .= '<li><h4>';
									$output .= '<a href="'.get_the_permalink().'">';
									$output .= get_the_title();
									$output .= '</a>';
									$output .= '</h4></li>';
						
							endwhile;
							
							$output .= '</ul>';

					endif;

					wp_reset_query();

					$output .= '<div class="knowledge-section-view-all">';
					$output .= '<a href="'.$hreflink.'">';
					$output .= 'View all';
					$output .= '</a>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>';

			}

	}

	$output .= '</div>';

	return $output;
}
add_shortcode("knowledgebase", "mtheme_knowledgebase_display_categories");

function mtheme_faq_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"limit" => '',
		"category_slugs" => '',
	), $atts));

	// Define limit
	if( $limit ) { 
		$posts_per_page = $limit; 
	} else {
		$posts_per_page = '-1';
	}

	$cat='';
	$output = '';

	$taxonomy="mfaqcategory";

	if ($category_slugs!='') $all_categories = explode(",", $category_slugs);

	$categories=  get_categories('orderby=slug&taxonomy='.$taxonomy.'&title_li=');
	
	foreach ($categories as $category){

			// Create the Query
			$post_type 		= 'mtheme_faq';
			$orderby 		= 'post_date';
			$order 			= 'DESC';
						
			$query = new WP_Query( array ( 
										'post_type'			=> $post_type,
										'mfaqcategory'		=> $category->slug,
										'posts_per_page'	=> $posts_per_page,
										'orderby'			=> $orderby, 
										'order'				=> $order,
										'cat'				=> $cat,
										'no_found_rows'  	=> 1
										)
								);
			?>
			
			<?php
				if ($query->have_posts()) : 

						$term_slug = $category->slug;
						$term = get_term_by('slug', $term_slug, $taxonomy);
						if ( !isSet($all_categories) || in_array($term_slug, $all_categories) ) {
								// Loop 
								$output .= '<div class="mtheme-faq-wrap">';
								$output .= '<h4>' . $category->name . '</h4>';
								while ($query->have_posts()) : $query->the_post();

										$output .= do_shortcode('[faq_toggle id="'.get_the_id().'" title="'.get_the_title().'" state="closed"] '.get_the_content().' [/faq_toggle]');
									
								endwhile;
								$output .= '</div>';
						}
				endif;
			
			// Reset query to prevent conflicts
			wp_reset_query();

	}
	
	return $output;

}
add_shortcode("faq", "mtheme_faq_shortcode");




//Toggle [toggle] text [/toggle]
function mtheme_faq_toggle( $atts, $content = null ) {

  	extract(shortcode_atts(array(
		"title" => 'Toggle',
		"state" => 'closed',
		"id" => '0'
	), $atts));

  	$toggle_status="";
	if ($state=="open") { 
		$toggle_status="active";
	}
	  
	$toggle	=  '<div id="faq-toggle-'.$id.'" class="faq-toggle-shortcode-wrap clearfix">';
	$toggle	.=	'<a id="faq-'.$id.'" class="faq-toggle-link'.$toggle_status.'">' . $title . '</a>';
	$toggle .=	'<div class="faq-toggle-container faq-toggle-display-'.$state.'">';
	$toggle .=	$content;
	$toggle	.=	'</div>';
	$toggle	.=	'</div>';
	$toggle = do_shortcode($toggle);

	return $toggle;
}
add_shortcode('faq_toggle', 'mtheme_faq_toggle');
?>