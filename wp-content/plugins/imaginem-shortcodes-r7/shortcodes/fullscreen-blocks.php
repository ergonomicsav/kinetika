<?php
// Portfolio
function mtheme_Worktype_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"transition" => 'fade'
	), $atts));

	$limit= of_get_option('worktype_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="";
	}
	
	//echo $type, $portfolio_type;
	if ($worktype_slugs!='') $all_works = explode(",", $worktype_slugs);
	$categories=  get_categories('orderby=slug&taxonomy=types&number='.$limit.'&title_li=');

	$portfolioImage_type="gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. of_get_option('worktype_box_title') . '</div>';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			foreach ($categories as $category){
				$taxonomy = "types";

				$term_slug = $category->slug;
				$term = get_term_by('slug', $term_slug, $taxonomy);

				if ( !isSet($all_works) || in_array($term_slug, $all_works) ) {				

					$hreflink = get_term_link($category->slug,'types');
					$mtheme_worktype_image_id = get_option('mtheme_worktype_image_id' . $category->term_id);
					$work_type_image = wp_get_attachment_image_src( $mtheme_worktype_image_id, $portfolioImage_type , false );

			
					$output .= '<div class="slideshow-box-wrapper">';
					$output .= '<div class="slideshow-box-image">';

					
						$output .= '<a href="'.esc_url( $hreflink ).'">';

						if ( isSet($work_type_image[0]) ) {
							$output .= mtheme_display_post_image (
								get_the_ID(),
								$have_image_url=$work_type_image[0],
								$link=false,
								$theimage_type=$portfolioImage_type,
								$imagetitle='',
								$class="displayed-image"
							);
						} else {
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
							$protected_placeholder = '/images/icons/blank-grid.png';
							$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';

						}
						$output .= '</a>';	

					$output .= '</div>';
					$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
					$output .= '<div class="slideshow-box-title">';
					
					$output .= '<a href="'.esc_url( $hreflink ).'">'. $category->name . '</a>';
					$output .= '</div>';

					$output .= '<div class="slideshow-box-description">';
						$output .= $category->description;
					$output .='</div>';

					$output .= '</div></div>';
					$output .='</div>';
				}

			}
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.esc_js( $uniqureID ).'");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '. esc_js($autoplay).',
		     slideSpeed: 1000,
		     navigation: true,
		     autoHeight: true,
		     pagination: false,
		     transitionStyle : "fade",
		     navigationText : ["",""],
		     responsiveRefreshRate: 200,
		 });';
	$output .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_worktype_infobox_slideshow", "mtheme_Worktype_Infobox_Slideshow");
// Portfolio
function mtheme_Portfolio_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"transition" => 'fade'
	), $atts));

	$limit= of_get_option('portfolio_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'post_type' => 'mtheme_portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $limit
		));	

	$portfolioImage_type="gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. of_get_option('portfolio_box_title') . '</div>';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			$description="";
			$customlink_URL='';
			$thumbnail='';
			if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { $description=$custom[MTHEME . '_thumbnail_desc'][0]; }
			if ( isset($custom[MTHEME . '_customlink'][0]) ) { $customlink_URL=$custom[MTHEME . '_customlink'][0]; }
			if ( isset($custom[MTHEME . '_customthumbnail'][0]) ) { $thumbnail=$custom[MTHEME . '_customthumbnail'][0]; }
			
			
				$output .= '<div class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				
				if ( post_password_required() ) {
					$output .= '<a href="'.get_permalink().'">';
						$output .= '<div class="gridblock-protected">';
						$output .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
						$protected_placeholder = '/images/icons/blank-grid-events.png';
						$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
						$output .= '</div>';
					$output .= '</a>';

				} else {
					if ( has_post_thumbnail() ) {
						if ($customlink_URL<>"") {
							$output .= '<a href="'.esc_url($customlink_URL).'">';
						} else {
							$output .= '<a href="'.get_permalink().'">';
						}
						if ($thumbnail<>"") {
							$output .= '<img src="'.$thumbnail.'" class="displayed-image" alt="thumbnail" />';
						} else {
							$output .= mtheme_display_post_image (
								get_the_ID(),
								$have_image_url="",
								$link=false,
								$theimage_type=$portfolioImage_type,
								$imagetitle='',
								$class="displayed-image"
								);
						}
						$output .= '</a>';
					} else {
							if ($customlink_URL<>"") {
								$output .= '<a href="'.esc_url($customlink_URL).'">';
							} else {
								$output .= '<a href="'.get_permalink().'">';
							}
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
							$protected_placeholder = '/images/icons/blank-grid.png';
							$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';
						$output .= '</a>';						
					}
				}	
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<div class="slideshow-box-title">';
				if ($customlink_URL<>"") {
					$output .= '<a href="'.esc_url($customlink_URL).'">'.get_the_title() . '</a>';
				} else {
					$output .= '<a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a>';
				}
				$output .= '</div>';

				$output .= '<div class="slideshow-box-description">';
					$output .= $description;
				$output .='</div>';

				$output .= '</div></div>';
				$output .='</div>';

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.esc_js( $uniqureID ).'");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '. esc_js($autoplay).',
		     slideSpeed: 1000,
		     navigation: true,
		     autoHeight: true,
		     pagination: false,
		     transitionStyle : "fade",
		     navigationText : ["",""],
		     responsiveRefreshRate: 200,
		 });';
	$output .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_portfolio_infobox_slideshow", "mtheme_Portfolio_Infobox_Slideshow");
// Events
function mtheme_Events_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"transition" => 'fade',
		"autoheight" => 'true'
	), $atts));

	$limit= of_get_option('events_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'post_type' => 'mtheme_events',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => $limit,
		'meta_query'	=> array(
			'relation'		=> 'AND',
			array(
				'key'	 	=> MTHEME . '_event_notice',
				'value'	  	=> 'inactive',
				'compare' 	=> 'NOT IN',
			),
		),
		));	

	$portfolioImage_type="gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. of_get_option('event_box_title') . '</div>';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			$description="";
			if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { $description=$custom[MTHEME . '_thumbnail_desc'][0]; }
			
			
				$output .= '<div class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				
				if ( post_password_required() ) {
					$output .= '<a href="'.get_permalink().'">';
						$output .= '<div class="gridblock-protected">';
						$output .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
						$protected_placeholder = '/images/icons/blank-grid-events.png';
						$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
						$output .= '</div>';
					$output .= '</a>';

				} else {
					if ( has_post_thumbnail() ) {
						$output .= '<a href="'.get_permalink().'">';
						$output .= mtheme_display_post_image (
							get_the_ID(),
							$have_image_url="",
							$link=false,
							$theimage_type=$portfolioImage_type,
							$imagetitle='',
							$class="displayed-image"
						);
						$output .= '</a>';
					} else {
						$output .= '<a href="'.get_permalink().'">';
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
							$protected_placeholder = '/images/icons/blank-grid.png';
							$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';
						$output .= '</a>';						
					}
				}	
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<div class="slideshow-box-title"><a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a></div>';

				$output .= '<div class="slideshow-box-description">';
					$output .= $description;
				$output .='</div>';

				$output .= '</div></div>';
				$output .='</div>';

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.esc_js( $uniqureID ).'");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '. esc_js($autoplay).',
		     slideSpeed: 1000,
		     navigation: true,
		     autoHeight: '.$autoheight.',
		     pagination: false,
		     transitionStyle : "fade",
		     navigationText : ["",""],
		     responsiveRefreshRate: 200,
		 });';
	$output .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_events_infobox_slideshow", "mtheme_Events_Infobox_Slideshow");
//Blog Carousel
function mtheme_Blog_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"category_name" => '',
		"autoplay" => 'false',
		"transition" => 'fade',
		"cat_slug"=> ''
	), $atts));

	$limit= of_get_option('blog_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'category_name' => $cat_slug,
		'posts_per_page' => $limit
		));	

	$portfolioImage_type="gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. of_get_option('blog_box_title') . '</div>';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			$description= mtheme_trim_sentence( get_the_excerpt() , 120 );
			
				if ( has_post_thumbnail() ) {
					$output .= '<div class="slideshow-box-wrapper">';
					$output .= '<div class="slideshow-box-image">';

					
					if ( post_password_required() ) {
						$output .= '<a href="'.get_permalink().'">';
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
							$protected_placeholder = '/images/icons/blank-grid-events.png';
							$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';
						$output .= '</a>';

					} else {
						if ( has_post_thumbnail() ) {
							$output .= '<a href="'.get_permalink().'">';
							$output .= mtheme_display_post_image (
								get_the_ID(),
								$have_image_url="",
								$link=false,
								$theimage_type=$portfolioImage_type,
								$imagetitle='',
								$class="displayed-image"
							);
							$output .= '</a>';
						} else {
							$output .= '<a href="'.get_permalink().'">';
								$output .= '<div class="gridblock-protected">';
								$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
								$protected_placeholder = '/images/icons/blank-grid.png';
								$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
								$output .= '</div>';
							$output .= '</a>';						
						}
					}	
					$output .= '</div>';
					$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
					$output .= '<div class="slideshow-box-title"><a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a></div>';

					$output .= '<div class="slideshow-box-description">';
						$output .= $description;
					$output .='</div>';

					$output .= '</div></div>';
					$output .='</div>';
				}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.esc_js( $uniqureID ).'");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '. esc_js($autoplay).',
		     slideSpeed: 1000,
		     navigation: true,
		     autoHeight: true,
		     pagination: false,
		     transitionStyle : "fade",
		     navigationText : ["",""],
		     responsiveRefreshRate: 200,
		 });';
	$output .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_blog_infobox_slideshow", "mtheme_Blog_Infobox_Slideshow");
//WooCommerce Slideshows
function mtheme_WooCommerce_Infobox_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"category_name" => '',
		"autoplay" => 'false',
		"transition" => 'fade',
		"cat_slug"=> ''
	), $atts));

	$limit= of_get_option('woocommerce_box_limit');

	if ( $limit=='' || !isSet($limit) || $limit=='0' ) {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;

	query_posts(array(
		'post_type' => 'product',
		'posts_per_page' => $limit,
		'meta_key' => '_featured',
		'meta_value' => 'yes'
		));	

	$portfolioImage_type="gridblock-events";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap mtheme-events-carousel clearfix">';
	$output .= '<div class="mtheme-events-heading">'. of_get_option('woocommerce_box_title') . '</div>';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			$description= mtheme_trim_sentence( get_the_excerpt() , 120 );
			
				if ( has_post_thumbnail() ) {
					$output .= '<div class="slideshow-box-wrapper">';
					$output .= '<div class="slideshow-box-image">';

					
					if ( post_password_required() ) {
						$output .= '<a href="'.get_permalink().'">';
							$output .= '<div class="gridblock-protected">';
							$output .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
							$protected_placeholder = '/images/icons/blank-grid-events.png';
							$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
							$output .= '</div>';
						$output .= '</a>';

					} else {
						if ( has_post_thumbnail() ) {
							$output .= '<a href="'.get_permalink().'">';
							$output .= mtheme_display_post_image (
								get_the_ID(),
								$have_image_url="",
								$link=false,
								$theimage_type=$portfolioImage_type,
								$imagetitle='',
								$class="displayed-image"
							);
							$output .= '</a>';
						} else {
							$output .= '<a href="'.get_permalink().'">';
								$output .= '<div class="gridblock-protected">';
								$output .= '<span class="hover-icon-effect"><i class="feather-icon-target"></i></span>';
								$protected_placeholder = '/images/icons/blank-grid.png';
								$output .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
								$output .= '</div>';
							$output .= '</a>';						
						}
					}	
					$output .= '</div>';
					$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
					$output .= '<div class="slideshow-box-title"><a href="'.esc_url( get_permalink() ).'">'.get_the_title() . '</a></div>';

					ob_start();
					wc_get_template('loop/price.php');
					$woo_price = ob_get_contents();
					ob_end_clean();

					$output .= '<div class="slideshow-box-price">'.$woo_price.'</div>';

					$output .= '<div class="slideshow-box-description">';
						$output .= $description;
					$output .='</div>';

					$output .= '</div></div>';
					$output .='</div>';
				}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.esc_js( $uniqureID ).'");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '. esc_js($autoplay).',
		     slideSpeed: 1000,
		     navigation: true,
		     autoHeight: true,
		     pagination: false,
		     transitionStyle : "fade",
		     navigationText : ["",""],
		     responsiveRefreshRate: 200,
		 });';
	$output .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';
	
	wp_reset_query();
	return $output;


}
add_shortcode("display_woocommerce_infobox_slideshow", "mtheme_WooCommerce_Infobox_Slideshow");
?>