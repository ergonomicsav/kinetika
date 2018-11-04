<?php
// Before After
if ( !function_exists( 'mtheme_BeforeAfter' ) ) {
	function mtheme_BeforeAfter($atts, $content = null) {
		extract(shortcode_atts(array(
			"urls" => '',
			"url1" => '',
			"url2" => '',
			"format" => 'vertical',
			"pb_image_ids" => '',
		), $atts));

	$uniqueID = uniqid();
	$before_after_count=0;
	$before_after_url=array();

	if ($urls=="attachment_images") {

		$filter_image_ids = mtheme_get_custom_attachments ( get_the_id() );

			foreach ( $filter_image_ids as $attachment_id) {

				$imagearray = wp_get_attachment_image_src( $attachment_id , 'gridblock-full', false);
				$imageURI = $imagearray[0];

				if (isSet($imageURI)) {			
				
					$before_after_url[$before_after_count] = $imageURI;
					$before_after_count++;

				}

				if ($before_after_count==2) {
					break;
				}
			}

			$url1 = $before_after_url[0];
			$url2 = $before_after_url[1];

	}

      $beforeafter = '<div id="before-after-id-'.$uniqueID.'" class="before-after-shortcode before-after-container" data-orientation="vertical">';
        $beforeafter .= '<div class="twentytwenty-container">';
          $beforeafter .= '<img src="'.$url1.'" alt="before" />';
          $beforeafter .= '<img src="'.$url2.'" alt="after"/>';
        $beforeafter .= '</div>';
      $beforeafter .= '</div>';

	$beforeafter .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		$("#before-after-id-'.$uniqueID.'").twentytwenty({default_offset_pct: 0.5});
	})
	})(jQuery);
	/* ]]> */
	</script>
	';

	return $beforeafter;

	}
}
add_shortcode("beforeafter", "mtheme_BeforeAfter");

//Thumbnails for Gallery [thumbnails]
if ( !function_exists( 'mtheme_MetroGrids' ) ) {
	function mtheme_MetroGrids($atts, $content = null) {
		extract(shortcode_atts(array(
			"size" => 'thumbnail',
			"exclude_featured" => 'false',
			"format" => '',
			"edgetoedge" => 'false',
			"start" => '',
			"animated" => 'false',
			"end" => '',
			"pb_image_ids" => '',
			"columns" => '4',
			"title" => "false",
			"description" => "false",
			"id" => '1',
			"pageid" => ''
		), $atts));
		
	// Set a default
	//$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.MTHEME_PATH.$protected_placeholder.'" alt="preloading" /></div>';
		$animation_class='';
		if ($animated == "true") {
			$animation_class=' animation-standby animated flipInX';
		}
		
		$portfolio_count=0;
		$thumbnailcount=0;
		if ($pageid!='') {
			$thepageID=get_the_id();
		}

		if (trim($pb_image_ids)<>'' ) {
			$filter_image_ids = explode(',', $pb_image_ids);
		} else {
			$filter_image_ids = mtheme_get_custom_attachments ( $pageid );
		}

		if ($end < $start) {
			$end='';
			$start='';
		}

		$uniqureID=get_the_id()."-".uniqid();

		//$filter_image_ids = mtheme_get_custom_attachments ( $thepageID );
		
		if ( $filter_image_ids ) {

				$thumbnails =  '<div class="gridblock-metro-wrap gridblock-metro-wrap-'.$uniqureID.' clearfix">';
				$thumbnails .= '<div class="gridblock-metro">';

				$featuredID = get_post_thumbnail_id();

				foreach ( $filter_image_ids as $attachment_id) {
				
				$thumbnailcount++;
				
				if ($start!='') {
					if ($thumbnailcount < $start ) { continue; }
				}
				if ($end!='') {
					if ($thumbnailcount > $end ) { continue; }
				}

				if ( $exclude_featured=='true') {
					if ($featuredID==$attachment_id) continue; // skip rest of the loop
				}

				$imagearray = wp_get_attachment_image_src( $attachment_id , 'gridblock-full', false);
				$imageURI = $imagearray[0];			
				
				$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , 'gridblock-square-big' , false);
				$thumbnail_imageURI = $thumbnail_imagearray[0];

				$bigthumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , 'gridblock-square-big' , false);
				$bigthumbnail_imageURI = $bigthumbnail_imagearray[0];
				
				$imageID = get_post($attachment_id);
				
				$imageTitle = '';
				$imageDesc = '';
				if (isSet($imageID->post_title)) {
					$imageTitle = $imageID->post_title;
				}
				if (isSet($imageID->post_content)) {
					$imageDesc= $imageID->post_content;
				}

				$portfolio_count++;

				$cell_name="following-cell";
				if ($portfolio_count==1) {
					$cell_name="first-cell";
					$thumbnail_imageURI = $bigthumbnail_imageURI;
				}

				// if ($portfolio_count==1) {
				// 	$thumbnails .=   '<li class="clearfix"></li>';
				// }

				$thumbnails .=  '<div class="gridblock-element '.$animation_class.' gridblock-col-'.$portfolio_count.' gridblock-cell-'.$cell_name.'">';

				$thumbnails .= '<div class="gridblock-grid-element gridblock-element-inner" data-rel="'.get_the_id().'">';

					$thumbnails .= '<div class="gridblock-background-hover">';
						$thumbnails .= '<div class="gridblock-links-wrap">';


						$thumbnails .=  mtheme_activate_lightbox (
							$lightbox_type="magnific",
							$ID='',
							$link=$imageURI,
							$mediatype="image",
							$imagetitle=$imageTitle,
							$class="column-gridblock-icon",
							$navigation="magnific-image-gallery"
							);
							$thumbnails .= '<span class="hover-icon-effect"><i class="feather-icon-maximize"></i></span>';
						$thumbnails .= '</a>';


						$thumbnails .= '</div>';
					$thumbnails .= '</div>';

			$thumbnails .= '<img class="preload-image displayed-image" src="'.$thumbnail_imageURI.'" alt="'.mtheme_get_alt_text($featuredID).'">';
			
			$thumbnails .=  '</div>';
			$thumbnails .= '</div>';
		}
		$thumbnails .= '</div>';
		$thumbnails .= '</div>';

		return $thumbnails;

		}	
	}
}
add_shortcode("metrogrid", "mtheme_MetroGrids");

//Thumbnails for Gallery [thumbnails]
if ( !function_exists( 'mtheme_Thumbnails' ) ) {
	function mtheme_Thumbnails($atts, $content = null) {
		extract(shortcode_atts(array(
			"size" => 'thumbnail',
			"exclude_featured" => 'false',
			"attachment_linking" => 'false',
			"format" => '',
			"start" => '',
			"end" => '',
			"animated" => 'false',
			"gutter" => 'spaced',
			"boxtitle" => '',
			"pb_image_ids" => '',
			"columns" => '4',
			"title" => "false",
			"description" => "false",
			"id" => '1',
			"pageid" => ''
		), $atts));
		
	// Set a default
	$column_type="four";
	$portfolioImage_type="gridblock-large";

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}
	$gridblock_is_masonary = "";
	if ( $format == "masonary") {

		$gridblock_is_masonary = " gridblock-masonary";
		if ($columns==4) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}
	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/icons/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/icons/blank-grid.png';
	}
	$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.MTHEME_PATH.$protected_placeholder.'" alt="preloading" /></div>';
		
		$portfolio_count=0;
		$thumbnailcount=0;
		$thepageID=get_the_id();

		$pb_image_ids=trim($pb_image_ids);
		if ( !empty($pb_image_ids) ) {
			$filter_image_ids = explode(',', $pb_image_ids);
		} else {
			if ( $pageid == '') {
				$pageid = get_the_id();
			}
			$filter_image_ids = mtheme_get_custom_attachments ( $pageid );
		}

		if ($end < $start) {
			$end='';
			$start='';
		}

		$thumbnail_gutter_class='';
		if ($gutter=="nospace") {
			$thumbnail_gutter_class = ' thumnails-gutter-active ';
		}

		$title_desc_class = '';
		if ($title=="false" && $description=="false") {
			$title_desc_class = " no-title-no-desc";
		}
		$boxtitle_class='';
		if ($boxtitle=="true") {
			$boxtitle_class=" boxtitle-active";
		}

		//$filter_image_ids = mtheme_get_custom_attachments ( $thepageID );
		
		if ( $filter_image_ids ) {

				$thumbnails =  '<div class="thumbnails-shortcode gridblock-columns-wrap clearfix">';
				$thumbnails .= '<div class="thumbnails-grid-container thumbnail-gutter-'.$gutter.$gridblock_is_masonary.$thumbnail_gutter_class.$title_desc_class.$boxtitle_class.' gridblock-'.$column_type.'"  data-columns="'.$columns.'">';

				$featuredID = get_post_thumbnail_id();

				foreach ( $filter_image_ids as $attachment_id) {
				
				$thumbnailcount++;
				
				if ($start!='') {
					if ($thumbnailcount < $start ) { continue; }
				}
				if ($end!='') {
					if ($thumbnailcount > $end ) { continue; }
				}

				if ( $exclude_featured=='true') {
					if ($featuredID==$attachment_id) continue; // skip rest of the loop
				}

				$imagearray = wp_get_attachment_image_src( $attachment_id , 'fullsize', false);
				$imageURI = $imagearray[0];			
				
				$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type, false);
				$thumbnail_imageURI = $thumbnail_imagearray[0];
				
				$imageTitle='';
				$imageDesc='';
				$imageID = get_post($attachment_id);
				if (isSet( $imageID->post_title ) ) {
					$imageTitle = $imageID->post_title;
				}
				if (isSet( $imageID->post_content ) ) {
					$imageDesc= $imageID->post_content;
				}
				
				if ($portfolio_count==$columns) $portfolio_count=0;
				$portfolio_count++;

				// if ($portfolio_count==1) {
				// 	$thumbnails .=   '<li class="clearfix"></li>';
				// }
				$animation_class='';
				if ($animated == "true") {
					//$animation_class=' animation-standby animated rotateInUpRight';
					$animation_class=' animation-standby animated flipInX';
				}
				$thumbnails .=  '<div class="gridblock-element '.$animation_class.' gridblock-thumbnail-id-'.$attachment_id.' gridblock-col-'.$portfolio_count.'">';

				$thumbnails .= '<div class="gridblock-ajax gridblock-grid-element gridblock-element-inner" data-rel="'.get_the_id().'">';
						$thumbnails .=  mtheme_activate_lightbox (
							$lightbox_type="magnific",
							$ID='',
							$link=$imageURI,
							$mediatype="image",
							$imagetitle=$imageTitle,
							$class="vertical-images-link",
							$navigation="magnific-image"
							);
					$thumbnails .= '<div class="gridblock-background-hover">';
						$thumbnails .= '<div class="gridblock-links-wrap">';

					if ($attachment_linking=="true") {
						$thumbnails .= '<a class="column-gridblock-icon" href="'. get_attachment_link($attachment_id) .'" rel="bookmark" title="'.get_the_title().'">';
							$thumbnails .= '<span class="hover-icon-effect"><i class="feather-icon-plus"></i></span>';
						$thumbnails .= '</a>';
					}


							$thumbnails .= '<span class="column-gridblock-icon"><span class="hover-icon-effect"><i class="feather-icon-maximize"></i></span></span>';
						

							if ($boxtitle=="true") {
								$thumbnails .= '<span class="boxtitle-hover">';
								$thumbnails .= '<span class="shortcode-box-title">';
								$thumbnails .= $imageTitle;
								$thumbnails .= '</span>';
								$thumbnails .= '</span>';
							}

						$thumbnails .= '</div>';
					$thumbnails .= '</div>';
			$thumbnails .= '</a>';
			$thumbnails .= '<img class="preload-image displayed-image" src="'.$thumbnail_imagearray[0].'" alt="'.mtheme_get_alt_text($featuredID).'">';
			
			$thumbnails .=  '</div>';
			if ($title=="true" || $description=="true") {
				$portfoliogrid ='<div class="work-details">';
					if ($title=='true') {
						$portfoliogrid .= '<h4>';
						$portfoliogrid .=''. $imageTitle .'';
						$portfoliogrid .= '</h4>';
					}
					if ($description=='true') { $portfoliogrid .= '<p class="entry-content work-description">'.$imageDesc.'</p>'; }
				$portfoliogrid .='</div>';
				$thumbnails .= $portfoliogrid;
			}
			$thumbnails .= '</div>';
		}
		$thumbnails .= '</div>';
		$thumbnails .= '</div>';

		return $thumbnails;

		}	
	}
}
add_shortcode("thumbnails", "mtheme_Thumbnails");
/**
 * Portfolio Grid
 */
if ( !function_exists( 'mPortfolioGrids' ) ) {
	function mPortfolioGrids($atts, $content = null) {
		extract(shortcode_atts(array(
			"pageid" => '',
			"format" => '',
			"columns" => '4',
			"limit" => '-1',
			"gutter" => 'spaced',
			"boxtitle" => 'true',
			"title" => 'true',
			"desc" => 'true',
			"worktype_slugs" => '',
			"pagination" => 'false',
			"type" => 'filter'
		), $atts));


	$portfoliogrid ='';

	// Set a default
	$column_type="four";
	$portfolioImage_type="gridblock-large";

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}
	$gridblock_is_masonary = "";
	if ( $format == "masonary") {

		$gridblock_is_masonary = "gridblock-masonary ";
		if ($columns==4) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}

	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/icons/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/icons/blank-grid.png';
	}
	//$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.MTHEME_PATH.$protected_placeholder.'" alt="preloading" /></div>';
	$thumbnail_gutter_class =  'portfolio-gutter-'.$gutter.' ';
	if ($gutter=="nospace") {
		$thumbnail_gutter_class .=  'thumnails-gutter-active ';
	}
	$flag_new_row=true;


	$portfoliogrid .= '<div id="gridblock-container" class="'.$thumbnail_gutter_class.$gridblock_is_masonary.'gridblock-'.$column_type.' clearfix" data-columns="'.$columns.'">';
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '<div class="gridblock-masonary-inner">';
	// }
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	$count=0;
	$terms=array();
	$work_slug_array=array();
	//echo $worktype_slugs;
	if ($worktype_slugs != "") {
		$type_explode = explode(",", $worktype_slugs);
		foreach ($type_explode as $work_slug) {
			$terms[] = $work_slug;
		}
		query_posts(array(
			'post_type' => 'mtheme_portfolio',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'paged' => $paged,
			'posts_per_page' => $limit,
			'tax_query' => array(
				array(
					'taxonomy' => 'types',
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN'
					)
				)
			));
	} else {
		query_posts(array(
			'post_type' => 'mtheme_portfolio',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'paged' => $paged,
			'posts_per_page' => $limit
			));	
	}

	$idCount=1;
	$portfolio_count=0;
	$portfolio_total_count=0;
	$portfoliofilters = array();

	if (have_posts()) : while (have_posts()) : the_post();
			//echo $type, $portfolio_type;
		$custom = get_post_custom(get_the_ID());
		$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
		$lightboxvideo="";
		$thumbnail="";
		$customlink_URL="";
		$description="";
		$portfolio_thumb_header="Image";

		if ( isset($custom[MTHEME . '_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom[MTHEME . '_thumbnail_linktype'][0]; }
		if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { $lightboxvideo=$custom[MTHEME . '_lightbox_video'][0]; }
		if ( isset($custom[MTHEME . '_customthumbnail'][0]) ) { $thumbnail=$custom[MTHEME . '_customthumbnail'][0]; }
		if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { $description=$custom[MTHEME . '_thumbnail_desc'][0]; }
		if ( isset($custom[MTHEME . '_customlink'][0]) ) { $customlink_URL=$custom[MTHEME . '_customlink'][0]; }
		if ( isset($custom[MTHEME . '_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom[MTHEME . '_portfoliotype'][0]; }

		if ($portfolio_count==$columns) $portfolio_count=0;

		$add_space_class = '';
		if ( $gutter!='nospace') {
			if ($title=='false' && $desc=='false') {
				$add_space_class = 'gridblock-cell-bottom-space';
			}
		}

		$protected="";
		$icon_class="column-gridblock-icon";
		$portfolio_count++;
		$portfolio_total_count++;

		$gridblock_ajax_class='';
		if ($type=='ajax') {
			$gridblock_ajax_class="gridblock-ajax ";
		}

		// Generate main DIV tag with portfolio information with filterable tags
		$portfoliogrid .= '<div class="gridblock-element gridblock-element-id-'.get_the_ID().' gridblock-element-order-'.$portfolio_total_count.' '.$add_space_class.' gridblock-filterable ';
		if ( is_array($portfolio_cats) ) {
			foreach ($portfolio_cats as $taxonomy) { 
				$portfoliogrid .=  'filter-' . $taxonomy->slug . ' ';
				if ($pagination=='true') {
					if (in_array($taxonomy->slug, $portfoliofilters)) {
					} else {
						$portfoliofilters[] = $taxonomy->slug;
					}
				}
			}
		}
		$idCount++;
		$portfoliogrid .= '" data-portfolio="portfolio-'. get_the_ID() .'" data-id="id-'. $idCount .'">';
			$portfoliogrid .= '<div class="'.$gridblock_ajax_class.'gridblock-grid-element gridblock-element-inner" data-portfolioid="'.get_the_id().'">';

				$portfoliogrid .= '<div class="gridblock-background-hover">';
					$portfoliogrid .= '<div class="gridblock-links-wrap box-title-'.$boxtitle.'">';


		//if Password Required

			//Make sure it's not a slideshow
		if ($type !="ajax") {
				//Switch check for Linked Type
			//Switch check for Linked Type

				if ( post_password_required() ) {
					$protected=" gridblock-protected"; $iconclass="";
					//$portfoliogrid .= '<a class="'.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
					$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
							$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-plus"></i></span>';
						$portfoliogrid .= '</a>';
				} else {

					if ($portfolio_link_type=="Lightbox_DirectURL") {
						$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
							$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-plus"></i></span>';
						$portfoliogrid .= '</a>';
					}

					switch ($portfolio_link_type) {
						case 'DirectURL':
							$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
							$icon_class='<i class="feather-icon-plus"></i>';
							break;

						case 'Customlink':
							$portfoliogrid .= '<a class="column-gridblock-icon" href="'.$customlink_URL.'">';
							$icon_class='<i class="feather-icon-link"></i>';
							break;

						case 'Lightbox_DirectURL':
						case 'Lightbox':
							if ( $lightboxvideo<>"" ) {
								$portfoliogrid .= mtheme_activate_lightbox (
									$lightbox_type="magnific",
									$ID=get_the_ID(),
									$link=$lightboxvideo,
									$mediatype="video",
									$imagetitle=get_the_title(),
									$class="column-gridblock-icon",
									$navigation="magnific-video"
									);
								$icon_class='<i class="feather-icon-play"></i>';
							} else {
								$portfoliogrid .= mtheme_activate_lightbox (
									$lightbox_type="magnific",
									$ID=get_the_ID(),
									$link=mtheme_featured_image_link( get_the_ID() ),
									$mediatype="image",
									$imagetitle=mtheme_featured_image_title( get_the_ID() ),
									$class="column-gridblock-icon",
									$navigation="magnific-image"
									);
								$icon_class='<i class="feather-icon-maximize"></i>';							
							}
							break;
					}
					//$portfoliogrid .= '<span class="gridblock-image-hover">';
					if ( isSet($icon_class) ) {
						$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
					}
					$portfoliogrid .= '</a>';
				}
				//$portfoliogrid .= '</span>';
				// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
				// Custom Thumbnail
		// If AJAX
		} else {
			$portfoliogrid .= '<span class="column-gridblock-icon">';
			$icon_class='<i class="feather-icon-eye"></i>';
			$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
			$portfoliogrid .= '</span>';
		}

				if ($boxtitle=="true") {

					$current_terms = wp_get_object_terms( get_the_ID(), 'types' );
					$current_worktype = '';
					$seperator = ',';
					foreach( $current_terms as $the_term ) {
						if ($the_term === end($current_terms)) {
							$seperator = '';
						}
						$current_worktype .= $the_term->name . $seperator;
					}
				
					$portfoliogrid .= '<span class="boxtitle-hover">';
					$portfoliogrid .= '<a href="'.get_permalink().'" rel="bookmark" title="'. get_the_title() .'">';
					$portfoliogrid .= get_the_title();
					$portfoliogrid .= '</a>';
					$portfoliogrid .= '<span class="boxtitle-worktype">'.$current_worktype.'</span>';
					$portfoliogrid .= '</span>';
				}
				
			$portfoliogrid .= '</div>';
		$portfoliogrid .= '</div>';

		if ( post_password_required() ) {

			$portfoliogrid .= '<div class="gridblock-protected">';
			$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
			if ( $format == "portrait" ) {
				$protected_placeholder = '/images/icons/blank-grid-portrait-related.png';
			} else {
				$protected_placeholder = '/images/icons/blank-grid.png';
			}
			$portfoliogrid .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
			$portfoliogrid .= '</div>';

		} else {
			if ($thumbnail<>"") {
				$portfoliogrid .= '<img src="'.$thumbnail.'" class="displayed-image" alt="thumbnail" />';
			} else {
				// Slideshow then generate slideshow shortcode
				$portfoliogrid .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$imagetype=$portfolioImage_type,
					$imagetitle=mtheme_featured_image_title( get_the_ID() ),
					$class="displayed-image"
				);

			}
		}
	$portfoliogrid .='</div>';
		if ($title=='true' || $desc=='true') {
			$portfoliogrid .='<div class="work-details">';
				$hreflink = get_permalink();
				if ($title=='true') {
					if ($type != "ajax") {
						$portfoliogrid .='<h4><a href="'.$hreflink.'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>';
					} else {
						$portfoliogrid .= '<h4>';
						$portfoliogrid .=''. get_the_title() .'';
						$portfoliogrid .= '</h4>';
					}
				}
				if ($desc=='true') $portfoliogrid .= '<p class="entry-content work-description">'.$description.'</p>';
			$portfoliogrid .='</div>';
		}


	$portfoliogrid .='</div>';

	//if ($portfolio_count==$columns)  $portfoliogrid .='</div>';

	endwhile; endif;
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '</div>';
	// }
	$portfoliogrid .='</div>';

	if ($pagination=='true') { 
		$portfoliogrid .= '<div class="clearfix">';
		$portfoliogrid .= mtheme_pagination();
		$portfoliogrid .= '</div>';
	}

	wp_reset_query();

	if ($type=="filter" || $type=="ajax") {

		$filter_portfoliogrid="";

		$countquery = array(
			'post_type' => 'mtheme_portfolio',
			'types' => $worktype_slugs,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => -1,
			);
		query_posts($countquery);
		if (have_posts()) : while (have_posts()) : the_post();
		endwhile;endif;

	if ($type=="ajax") {
		$filter_portfoliogrid .= '	<div class="ajax-gridblock-block-wrap clearfix">';
			$filter_portfoliogrid .= '	<div class="ajax-gallery-navigation clearfix">';
			$filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-next" href="#"><i class="feather-icon-arrow-right"></i></a>';
			$filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-hide" href="#"><i class="feather-icon-align-justify"></i></a>';
			$filter_portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-prev" href="#"><i class="feather-icon-arrow-left"></i></a>';
			$filter_portfoliogrid .= '		<span class="ajax-loading">Loading</span>';
			$filter_portfoliogrid .= '	</div>';
			$filter_portfoliogrid .= '	<div class="ajax-gridblock-window">';
			$filter_portfoliogrid .= '		<div id="ajax-gridblock-wrap"></div>';
			$filter_portfoliogrid .= '	</div>';
		$filter_portfoliogrid .= '	</div>';
	}
		$filter_portfoliogrid .= '<div class="gridblock-filter-select-wrap">';

			$filter_portfoliogrid .= '<ul id="gridblock-filters">';
			
			$filter_portfoliogrid .= '<li>';
				$filter_portfoliogrid .= '<a data-filter="*" data-title="'. of_get_option('portfolio_allitems') .'" href="#">';
				$filter_portfoliogrid .= of_get_option('portfolio_allitems');
				$filter_portfoliogrid .= '</a>';
			$filter_portfoliogrid .= '</li>';
						
		//$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
		if ($worktype_slugs!='') $all_works = explode(",", $worktype_slugs);
		$categories=  get_categories('orderby=slug&taxonomy=types&title_li=');
		foreach ($categories as $category){
			
			$taxonomy = "types";

			// Using Term Slug
			$term_slug = $category->slug;
			$term = get_term_by('slug', $term_slug, $taxonomy);

			// Enter only if Works is not set - means all included OR if work types are defined in shortcode
			if ( !isSet($all_works) || in_array($term_slug, $all_works) ) {
				// Fetch the count
				//echo $term->count;
				if ($pagination=='true') {
					if ( is_array($portfoliofilters) ) {
						$filter_found = false;
						$hide_filter='';
						if (in_array($category->slug, $portfoliofilters)) {
							$filter_found = true;
						}

					}
					if (!$filter_found) {
						$hide_filter = 'style="display:none;"';
						//echo $category->slug;
					}
				}
				$filter_portfoliogrid .= '<li '.$hide_filter.' class="filter-control filter-control-'.$category->slug.'">';
					$filter_portfoliogrid .= '<a data-filter=".filter-' . $category->slug .'" data-title="'. $category->name . '" href="#">';
						$filter_portfoliogrid .= $category->name;
					$filter_portfoliogrid .= '</a>';
				$filter_portfoliogrid .= '</li>';
			}
		}
			$filter_portfoliogrid .= '</ul>';
		$filter_portfoliogrid .= '</div>';
	//End of If Filter
	}

		if (isSet($filter_portfoliogrid)) {
			$portfoliogrid = $filter_portfoliogrid . $portfoliogrid;
		}
	//Reset query after Filters

		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("portfoliogrid", "mPortfolioGrids");


//Recent Works Carousel
if ( !function_exists( 'mLightboxCarousel' ) ) {
	function mLightboxCarousel($atts, $content = null) {
		extract(shortcode_atts(array(
			"pageid" => '',
			"pb_image_ids" => '',
			"format" => '',
			"carousel_type" => 'owl',
			"columns" => '4',
			"limit" => '-1',
			"title" => 'true',
			"desc" => 'true',
			"boxtitle" => 'true',
			"worktype_slug" => '',
			"pagination" => 'false'
		), $atts));

	$uniqureID=get_the_id()."-".uniqid();
	$column_type="four";
	$portfolioImage_type="gridblock-large";
	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}

	if ($worktype_slug=="-1") { $worktype_slug=''; }
	$portfolio_count=0;
	$flag_new_row=true;
	$portfoliogrid='';

	if ($carousel_type=="owl") {

		$portfoliogrid .= '<div class="gridblock-owlcarousel-wrap clearfix">';
		$portfoliogrid .= '<div id="owl-'.$uniqureID.'" class="owl-carousel">';
		
		if (trim($pb_image_ids)<>'' ) {
			$filter_image_ids = explode(',', $pb_image_ids);
		} else {
			$filter_image_ids = mtheme_get_custom_attachments ( $pageid );
		}

		$count_lightboxes=0;

		if ( $filter_image_ids ) {
			foreach ( $filter_image_ids as $attachment_id) {

					//echo $type, $portfolio_type;
				$custom = get_post_custom(get_the_ID());
				$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
				$lightboxvideo="";
				$thumbnail="";
				$customlink_URL="";
				$portfolio_thumb_header="Image";

				$imagearray = wp_get_attachment_image_src( $attachment_id , 'fullsize', false);
				$imageURI = $imagearray[0];			
				
				$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type, false);
				$thumbnail_imageURI = $thumbnail_imagearray[0];

				if (isSet($thumbnail_imageURI)) {
				
					$imageTitle='';
					$imageDesc='';
					$imageID = get_post($attachment_id);
					if (isSet($imageID->post_title)) {
						$imageTitle = $imageID->post_title;
					}
					if (isSet($imageID->post_content)) {
						$imageDesc= $imageID->post_content;
					}

					if ($portfolio_count==$columns) $portfolio_count=0;

					$protected="";
					$icon_class="column-gridblock-icon";
					$portfolio_count++;
					$portfoliogrid .= '<div class="gridblock-grid-element">';

						$portfoliogrid .= '<div class="gridblock-background-hover">';
							$portfoliogrid .= '<div class="gridblock-links-wrap">';

								$portfoliogrid .= mtheme_activate_lightbox (
									$lightbox_type="magnific",
									$ID=get_the_ID(),
									$link=$imageURI,
									$mediatype="video",
									$imagetitle=$imageTitle,
									$class="column-gridblock-icon",
									$navigation="magnific-lightboxcarousel"
									);
								$icon_class='<i class="feather-icon-maximize"></i>';

								if ($icon_class) $portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
							
								$portfoliogrid .= '</a>';
							// End of links wrap

							if ($boxtitle=="true") {
								$portfoliogrid .= '<span class="boxtitle-hover">';
								$portfoliogrid .= '<a href="'.get_permalink().'" rel="bookmark" title="'. $imageTitle .'">';
								$portfoliogrid .= $imageTitle;
								$portfoliogrid .= '</a>';
								$portfoliogrid .= '</span>';
							}
							
							$portfoliogrid .= '</div>';
						$portfoliogrid .= '</div>';

						$portfoliogrid .= mtheme_display_post_image (
							get_the_ID(),
							$have_image_url=$thumbnail_imageURI,
							$link=false,
							$type=$portfolioImage_type,
							$imagetitle=$imageTitle,
							$class="displayed-image"
						);

						$count_lightboxes++;

					$portfoliogrid .='</div>';

				}

			}
		}
		$portfoliogrid .='</div>';
		$portfoliogrid .='</div>';
		if ($count_lightboxes>0) {
		$portfoliogrid .='
		<script>
		/* <![CDATA[ */
		(function($){
		$(window).load(function(){
			$("#owl-'.$uniqureID.'").owlCarousel({
				itemsCustom : [
					[0, 1],
					[500, 2],
					[700, 3],
					[1024, '.$columns.']
				],
				items: '.$columns.',
				navigation : true,
				navigationText : ["",""],
				scrollPerPage : false
			});
		})
		})(jQuery);
		/* ]]> */
		</script>
		';
		}

	}

		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("lightboxcarousel", "mLightboxCarousel");

//Recent Works Carousel
if ( !function_exists( 'mWorksCarousel' ) ) {
	function mWorksCarousel($atts, $content = null) {
		extract(shortcode_atts(array(
			"pageid" => '',
			"format" => '',
			"carousel_type" => 'owl',
			"columns" => '4',
			"limit" => '-1',
			"title" => 'true',
			"desc" => 'true',
			"boxtitle" => 'true',
			"worktype_slug" => '',
			"pagination" => 'true'
		), $atts));

	$uniqureID=get_the_id()."-".uniqid();
	$column_type="four";
	$portfolioImage_type="gridblock-large";
	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}

	if ($worktype_slug=="-1") { $worktype_slug=''; }
	$portfolio_count=0;
	$flag_new_row=true;
	$portfoliogrid='';

	if ($carousel_type=="owl") {

		$portfoliogrid .= '<div class="gridblock-owlcarousel-wrap clearfix">';
		$portfoliogrid .= '<div id="owl-'.$uniqureID.'" class="owl-carousel">';
			if ( get_query_var('paged') ) {
				$paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
				$paged = get_query_var('page');
			} else {
				$paged = 1;
			}
				query_posts( 
					array( 
						'post_type' => 'mtheme_portfolio',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'types' => $worktype_slug,
						'paged' => $paged,
						'posts_per_page' => $limit
						)
					);

		if (have_posts()) : while (have_posts()) : the_post();

			//echo $type, $portfolio_type;
		$custom = get_post_custom(get_the_ID());
		$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
		$lightboxvideo="";
		$thumbnail="";
		$customlink_URL="";
		$portfolio_thumb_header="Image";

		if ( isset($custom[MTHEME . '_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom[MTHEME . '_thumbnail_linktype'][0]; }
		if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { $lightboxvideo=$custom[MTHEME . '_lightbox_video'][0]; }
		if ( isset($custom[MTHEME . '_customthumbnail'][0]) ) { $thumbnail=$custom[MTHEME . '_customthumbnail'][0]; }
		if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { $description=$custom[MTHEME . '_thumbnail_desc'][0]; }
		if ( isset($custom[MTHEME . '_customlink'][0]) ) { $customlink_URL=$custom[MTHEME . '_customlink'][0]; }
		if ( isset($custom[MTHEME . '_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom[MTHEME . '_portfoliotype'][0]; }

		if ($portfolio_count==$columns) $portfolio_count=0;

		$protected="";
		$icon_class="column-gridblock-icon";
		$portfolio_count++;
		$portfoliogrid .= '<div class="gridblock-grid-element">';

				$portfoliogrid .= '<div class="gridblock-background-hover">';
					$portfoliogrid .= '<div class="gridblock-links-wrap">';

			//if Password Required
			if ( post_password_required() ) {
				$protected=" gridblock-protected"; $iconclass="";
				$portfoliogrid .= '<a class="'.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
				//$portfoliogrid .= '<span class="hover-icon-effect"><i class="fa fa-lock fa-2x"></i></span>';
			} else {
				//Switch check for Linked Type

					if ($portfolio_link_type=="Lightbox_DirectURL") {
						
						$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';

						$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-plus"></i></span>';

						$portfoliogrid .= '</a>';
					}

					switch ($portfolio_link_type) {
						case 'DirectURL':
							$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
							$icon_class='<i class="feather-icon-plus"></i>';
							break;

						case 'Customlink':
							$portfoliogrid .= '<a class="column-gridblock-icon" href="'.$customlink_URL.'">';
							$icon_class='<i class="fa fa-external-link"></i>';
							break;

						case 'Lightbox_DirectURL':
						case 'Lightbox':
							if ( $lightboxvideo<>"" ) {
								$portfoliogrid .= mtheme_activate_lightbox (
									$lightbox_type="magnific",
									$ID=get_the_ID(),
									$link=$lightboxvideo,
									$mediatype="video",
									$imagetitle=get_the_title(),
									$class="column-gridblock-icon",
									$navigation="magnific-video"
									);
								$icon_class='<i class="fa fa-play"></i>';
							} else {
								$portfoliogrid .= mtheme_activate_lightbox (
									$lightbox_type="magnific",
									$ID=get_the_ID(),
									$link=mtheme_featured_image_link( get_the_ID() ),
									$mediatype="image",
									$imagetitle=mtheme_featured_image_title( get_the_ID() ),
									$class="column-gridblock-icon",
									$navigation="magnific-image"
									);
								$icon_class='<i class="feather-icon-maximize"></i>';							
							}
							break;
					}
					//$portfoliogrid .= '<span class="gridblock-image-hover">';
					if ( isSet($icon_class) ) {
						$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
					}
					//$portfoliogrid .= '</span>';
					// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
					// Custom Thumbnail
				}
				$portfoliogrid .= '</a>';
				// End of links wrap

				if ($boxtitle=="true") {

					$current_terms = wp_get_object_terms( get_the_ID(), 'types' );
					$current_worktype = $current_terms[0]->name; 
				
					$portfoliogrid .= '<span class="boxtitle-hover">';
					$portfoliogrid .= '<a href="'.get_permalink().'" rel="bookmark" title="'. get_the_title() .'">';
					$portfoliogrid .= get_the_title();
					$portfoliogrid .= '</a>';
					$portfoliogrid .= '<span class="boxtitle-worktype">'.$current_worktype.'</span>';
					$portfoliogrid .= '</span>';
				}
				
				$portfoliogrid .= '</div>';
			$portfoliogrid .= '</div>';

			if ( post_password_required() ) {

				$portfoliogrid .= '<div class="gridblock-protected">';
				$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
				if ( $format == "portrait" ) {
					$protected_placeholder = '/images/icons/blank-grid-portrait-related.png';
				} else {
					$protected_placeholder = '/images/icons/blank-grid.png';
				}
				$portfoliogrid .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
				$portfoliogrid .= '</div>';

			} else {
				if ($thumbnail<>"") {
					$portfoliogrid .= '<img src="'.$thumbnail.'" class="displayed-image" alt="thumbnail" />';
				} else {
					// Slideshow then generate slideshow shortcode
					$portfoliogrid .= mtheme_display_post_image (
						get_the_ID(),
						$have_image_url="",
						$link=false,
						$type=$portfolioImage_type,
						$imagetitle=mtheme_featured_image_title( get_the_ID() ),
						$class="displayed-image"
					);

				}
			}

		$portfoliogrid .='</div>';

		endwhile; endif;
		$portfoliogrid .='</div>';
		$portfoliogrid .='</div>';
		$portfoliogrid .='
		<script>
		/* <![CDATA[ */
		(function($){
		$(window).load(function(){
			$("#owl-'.$uniqureID.'").owlCarousel({
				itemsCustom : [
					[0, 1],
					[600, 1],
					[800, 2],
					[1000, 3],
					[1300, '.$columns.']
				],
				items: '.$columns.',
				navigation : true,
				navigationText : ["",""],
				pagination : '.$pagination.',
				scrollPerPage : false
			});
		})
		})(jQuery);
		/* ]]> */
		</script>
		';

	}

		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("workscarousel", "mWorksCarousel");

add_shortcode("portfolio_details", "mtheme_portfolio_details");
function mtheme_portfolio_details($atts, $content = null)
{
    extract(shortcode_atts(array(
        "project_title" => '',
        "like" => 'no',
        "alignment" => '',
        "project_detail_title" => '',
        "project_client_title" => '',
        "project_client_target" => '',
        "project_link_target" => '',
        "project_client" => '',
        "project_client_link" => '',
        "project_skills" => '',
        "project_link_title" => '',
        "project_link" => ''
    ), $atts));
    
    $content = wpautop(html_entity_decode($content));
    
    $project_skills = explode(',', $project_skills);
    shuffle($project_skills);
    $skills_html = '<ul>';
    foreach ($project_skills as $p_skill) {
        $skills_html .= '<li>' . $p_skill . '</li>';
    }
    $skills_html .= '</ul>';
    
    if ($alignment == "center") {
        $alignment_class = "center";
    }
    if ($alignment == "right") {
        $alignment_class = "right";
    }
    if ($alignment == "left") {
        $alignment_class = "left";
    }

    $project_target_tag = '';
    $client_target_tag = '';

    if ($project_link_target=="yes") {
        $project_target_tag = 'target="_blank"';
    }
    if ($project_client_target=="yes") {
        $client_target_tag = 'target="_blank"';
    }
    
    $output = '<div class="portfolio-details-section-inner portfolio-details-align-' . $alignment . ' entry-content portfolio-header-right-inner">';
    $output .= '<h2 class="project-heading">' . $project_title . '</h2>';
    $output .= '<div class="portfolio-content-summary entry-content medium">' . $content . '</div>';
    $output .= '<div class="portfolio-details-wrap">';
    $output .= '<div class="portfolio-details-inner">';
    $output .= '<div class="project-details project-info project-skills-column">';
    $output .= '<h4>' . of_get_option('portfolio_skills') . '</h4>';
    $output .= $skills_html;
    $output .= '</div>';
    if ( $project_link_title<>"" ) {

        $project_link_start = '';
        $project_link_end = '';
        $project_link_icon = '<i class="feather-icon-minus"></i>';
        if ( $project_link<>"" ) {
            $project_link_icon = '<i class="feather-icon-link"></i>';
            $project_link_start = '<a '.$project_target_tag.' href="'.esc_url($project_link).'">';
            $project_link_end = '</a>';
        }

        $output .= '<div class="project-details-link clear">';
        $output .= $project_link_icon;
        $output .= '<h4>'.$project_link_start. $project_link_title . $project_link_end. '</h4>';
        $output .= '</div>';
    }
    if ( $project_client<>"" ) {

        $client_link_start = '';
        $client_link_end = '';
        $client_link_icon = '<i class="feather-icon-minus"></i>';
        if ( $project_client_link<>"" ) {
            $client_link_icon = '<i class="feather-icon-link"></i>';
            $client_link_start = '<a '.$client_target_tag.' class="client-link" href="' . $project_client_link . '">';
            $client_link_end = '</a>';
        }

        $output .= '<div class="project-details-link clear">';
        $output .= $client_link_icon;
            $output .= '<h4>'.$client_link_start.'<span>' . $project_client . '</span>'.$client_link_end.'</h4>';
        $output .= '</div>';
    }
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
    
}

///////// Recent Blog Lists ///////////////
//++++++++++++++++++++++++++++++++++++++//
if ( !function_exists( 'mRecentBlog' ) ) {
	function mRecentBlog($atts, $content = null) {
		extract(shortcode_atts(array(
			"comments" => 'true',
			"date" => 'true',
			"columns" => '4',
			"limit" => '-1',
			"title" => 'true',
			"description" => 'true',
			"cat_slug" => '',
			"post_type" => '',
			"excerpt_length" => '15',
			"readmore_text" => '',
			"pagination" => 'false'
		), $atts));

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="gridblock-full";
		}

	$portfolio_count=0;
	$postformats="";
	$terms='';
	$terms=array();
	$count=0;
	$flag_new_row=true;
	$portfoliogrid='';
	$portfoliogrid .= '<div class="gridblock-columns-wrap clearfix">';
	$portfoliogrid .= '<div id="gridblock-container-blog" class="gridblock-'.$column_type.'">';

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	if ($post_type<>"") {
		$type_explode = explode(",", $post_type);
		foreach ($type_explode as $postformat) {
			$count++;
			$postformat_slug = "post-format-" . $postformat;
			$terms[] .= $postformat_slug;
		}
		
		query_posts(array(
			'category_name' => $cat_slug,
			'posts_per_page' => $limit,
			'paged' => $paged,
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => $terms
						)
					)
			));
	} else {
		query_posts(array(
			'category_name' => $cat_slug,
			'paged' => $paged,
			'posts_per_page' => $limit
			));	
	}

	if (have_posts()) : while (have_posts()) : the_post();
		//echo $type, $portfolio_type;

	$postformat = get_post_format();
	if($postformat == "") $postformat="standard";

	$portfolio_thumb_header="Image";

	if ($portfolio_count==$columns) $portfolio_count=0;

	$protected="";
	$icon_class="column-gridblock-icon";
	$portfolio_count++;

	//if ($portfolio_count==1) $portfoliogrid .= '<li class="clearfix"></li>';
	$portfoliogrid .= '<div class="blog-grid-element gridblock-element gridblock-col-'.$portfolio_count.'">';

		$portfoliogrid .= '<div class="blog-grid-element-inner">';
		
		$linkcenter ='';
		$linkcenter="gridblock-link-center";

		switch ($postformat) {
			case 'video':
				$postformat_icon = "feather-icon-play";
				break;
			case 'audio':
				$postformat_icon = "feather-icon-volume";
				break;
			case 'gallery':
				$postformat_icon = "feather-icon-layers";
				break;
			case 'quote':
				$postformat_icon = "feather-icon-speech-bubble";
				break;
			case 'link':
				$postformat_icon = "feather-icon-link";
				break;
			case 'aside':
				$postformat_icon = "feather-icon-align-justify";
				break;
			case 'image':
				$postformat_icon = "feather-icon-image";
				break;
			default:
				$postformat_icon ="feather-icon-paper";
				break;
		}

		//if Password Required
		if ( post_password_required() ) {
			$protected=" portfolio-protected"; $iconclass="";
			$portfoliogrid .= '<a class="grid-blank-element '.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
			$portfoliogrid .= '<span class="grid-icon-status"><i class="fa fa-lock fa-2x"></i></span>';
			$portfoliogrid .= '<div class="portfolio-protected"><img src="'.MTHEME_PATH.'/images/icons/blank-grid.png" alt="blank" /></div>';
		} else {

			if ( ! has_post_thumbnail() ) {
				$portfoliogrid .= '<a class="grid-blank-element '.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
				$portfoliogrid .= '<span class="grid-icon-status"><i class="'.$postformat_icon.' fa-2x"></i></span>';
				$portfoliogrid .= '<div class="gridblock-blank-element"><img src="'.MTHEME_PATH.'/images/icons/blank-grid.png" alt="blank" /></div>';
			}

			if ( has_post_thumbnail() ) {
			//Make sure it's not a slideshow
				//Switch check for Linked Type
				$portfoliogrid .= '<a class="gridblock-image-link blog-grid-element-has-image gridblock-columns" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
				$portfoliogrid .= '<span class="grid-icon-status"><i class="'.$postformat_icon.' fa-2x"></i></span>';
			// Display Hover icon trigger classes

			// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
			// Custom Thumbnail
			//Display Image
				$portfoliogrid .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$type=$portfolioImage_type,
					$imagetitle='',
					$class="preload-image displayed-image"
				);
			} else {
				
			}
		}
		$portfoliogrid .= '</a>';

		$portfoliogrid .= '<div class="blog-grid-element-content">';
			// If either of title and description needs to be displayed.
			if ($title=="true" || $description=="true") {
				$portfoliogrid .='<div class="work-details">';
					$hreflink = get_permalink();
					if ($title=="true") { $portfoliogrid .='<h4><a href="'.$hreflink.'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>'; }
					$summary_content = mtheme_excerpt_limit($excerpt_length);
					if ($readmore_text!='') {
						$summary_content .= '<div class="blogpost_readmore"><a href="'.$hreflink.'">'.$readmore_text.'</a></div>';
					}
					if ($postformat=='quote') $summary_content = get_post_meta( get_the_id() , MTHEME . '_meta_quote', true);
					if ($description=="true") { $portfoliogrid .= '<div class="entry-content work-description">'. $summary_content .'</div>'; }
				$portfoliogrid .='</div>';
			}

			$portfoliogrid .= '<div class="summary-info">';
				$category = get_the_category();
				if ($comments == 'true' ) {
					$portfoliogrid .= '<div class="summary-comment">';

					$num_comments = get_comments_number( get_the_id() ); // get_comments_number returns only a numeric value
					if ( comments_open() ) {
						if ( $num_comments == 0 ) {
							$comments_desc = __('0 <i class="feather-icon-speech-bubble"></i>');
						} elseif ( $num_comments > 1 ) {
							$comments_desc = $num_comments . __(' <i class="feather-icon-speech-bubble"></i>');
						} else {
							$comments_desc = __('1 <i class="feather-icon-speech-bubble"></i>');
						}
						$portfoliogrid .= '<a href="' . get_comments_link( get_the_id() ) .'">'. $comments_desc.'</a>';
					}
					$portfoliogrid .='</div>';
				}
				if ($date=='true') {
					$portfoliogrid .='<div class="summary-date"><i class="feather-icon-clock"></i> '.get_the_date('jS M y').'</div>';
				}
			$portfoliogrid .='</div>';

		$portfoliogrid .= '</div>';
	$portfoliogrid .= '</div>';
	$portfoliogrid .='</div>';


	endwhile; endif;
	$portfoliogrid .='</div>';
	$portfoliogrid .='</div>';

		if ($pagination=='true') $portfoliogrid .= mtheme_pagination();
		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("recentblog", "mRecentBlog");

///////// Recent Blog Lists ///////////////
//++++++++++++++++++++++++++++++++++++++//
if ( !function_exists( 'mBlogList' ) ) {
	function mBlogList($atts, $content = null) {
		extract(shortcode_atts(array(
			"comments" => 'true',
			"bloglist_style" => 'default',
			"date" => 'true',
			"columns" => '4',
			"limit" => '-1',
			"title" => 'true',
			"description" => 'true',
			"blogtimealign" => 'top',
			"cat_slug" => '',
			"excerpt_length" => '15',
			"post_type" => '',
			"pagination" => 'false'
		), $atts));

	$column_type="listbox";
	$portfolioImage_type="gridblock-large";

	$portfolio_count=0;
	$postformats="";
	$terms='';
	$terms=array();
	$count=0;
	$flag_new_row=true;

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	if ($post_type<>"") {
		$type_explode = explode(",", $post_type);
		foreach ($type_explode as $postformat) {
			$count++;
			$postformat_slug = "post-format-" . $postformat;
			$terms[] .= $postformat_slug;
		}
		
		query_posts(array(
			'category_name' => $cat_slug,
			'posts_per_page' => $limit,
			'paged' => $paged,
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => $terms
						)
					)
			));
	} else {
		query_posts(array(
			'category_name' => $cat_slug,
			'paged' => $paged,
			'posts_per_page' => $limit
			));	
	}
		ob_start();
		get_template_part( 'loop', 'blog' );
		$bloglist = '<div class="mtheme-shortcode-bloglist sc-bloglist-columns-'.$columns.' date-time-style-'.$blogtimealign.'">';
		$bloglist .= ob_get_clean();
		$bloglist .= '</div>';
		wp_reset_query();
		return $bloglist;
	}
}
add_shortcode("bloglist", "mBlogList");
///////// Recent Blog Lists Small ///////////////
//++++++++++++++++++++++++++++++++++++++//
if ( !function_exists( 'mBlogListSmall' ) ) {
	function mBlogListSmall($atts, $content = null) {
		extract(shortcode_atts(array(
			"comments" => 'true',
			"bloglist_style" => 'default',
			"date" => 'true',
			"columns" => '4',
			"limit" => '-1',
			"title" => 'true',
			"description" => 'true',
			"blogtimealign" => 'top',
			"cat_slug" => '',
			"excerpt_length" => '15',
			"post_type" => '',
			"pagination" => 'false'
		), $atts));

	$column_type="listbox";
	$portfolioImage_type="gridblock-large";

	$portfolio_count=0;
	$postformats="";
	$terms='';
	$terms=array();
	$count=0;
	$flag_new_row=true;

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	if ($post_type<>"") {
		$type_explode = explode(",", $post_type);
		foreach ($type_explode as $postformat) {
			$count++;
			$postformat_slug = "post-format-" . $postformat;
			$terms[] .= $postformat_slug;
		}
		
		query_posts(array(
			'category_name' => $cat_slug,
			'posts_per_page' => $limit,
			'paged' => $paged,
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => $terms
						)
					)
			));
	} else {
		query_posts(array(
			'category_name' => $cat_slug,
			'paged' => $paged,
			'posts_per_page' => $limit
			));	
	}
		ob_start();
		get_template_part( 'loop', 'blog' );
		$bloglist = '<div class="mtheme-shortcode-bloglist bloglist-small sc-bloglist-columns-'.$columns.' date-time-style-'.$blogtimealign.'">';
		$bloglist .= ob_get_clean();
		$bloglist .= '</div>';
		wp_reset_query();
		return $bloglist;
	}
}
add_shortcode("bloglistsmall", "mBlogListSmall");

///////// Recent Blog Lists ///////////////
//++++++++++++++++++++++++++++++++++++++//
if ( !function_exists( 'mRecentBlogListBox' ) ) {
	function mRecentBlogListBox($atts, $content = null) {
		extract(shortcode_atts(array(
			"comments" => 'true',
			"date" => 'true',
			"columns" => '4',
			"limit" => '-1',
			"title" => 'true',
			"description" => 'true',
			"cat_slug" => '',
			"excerpt_length" => '15',
			"post_type" => '',
			"pagination" => 'false'
		), $atts));

	$column_type="listbox";
	$portfolioImage_type="gridblock-large";

	$portfolio_count=0;
	$postformats="";
	$terms='';
	$terms=array();
	$count=0;
	$flag_new_row=true;
	$portfoliogrid='';
	$portfoliogrid .= '<div class="gridblock-listbox gridblock-columns-wrap clearfix">';
	$portfoliogrid .= '<ul class="gridblock-'.$column_type.' clearfix">';

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	if ($post_type<>"") {
		$type_explode = explode(",", $post_type);
		foreach ($type_explode as $postformat) {
			$count++;
			$postformat_slug = "post-format-" . $postformat;
			$terms[] .= $postformat_slug;
		}
		
		query_posts(array(
			'category_name' => $cat_slug,
			'posts_per_page' => $limit,
			'paged' => $paged,
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => $terms
						)
					)
			));
	} else {
		query_posts(array(
			'category_name' => $cat_slug,
			'paged' => $paged,
			'posts_per_page' => $limit
			));	
	}

	if (have_posts()) : while (have_posts()) : the_post();
		//echo $type, $portfolio_type;

	$postformat = get_post_format();
	if($postformat == "") $postformat="standard";

	$portfolio_thumb_header="Image";

	if ($portfolio_count==$columns) $portfolio_count=0;

	$protected="";
	$icon_class="column-gridblock-icon";
	$portfolio_count++;

	$portfoliogrid .= '<li class="gridblock-listbox-row gridblock-col-'.$portfolio_count.' clearfix">';
		
		$portfoliogrid .= '<div class="listbox-image">';

		$portfoliogrid .= '<span class="gridblock-link-hover">';
		
		$linkcenter ='';
		$linkcenter="gridblock-link-center";

		switch ($postformat) {
			case 'video':
				$postformat_icon = "feather-icon-play";
				break;
			case 'audio':
				$postformat_icon = "feather-icon-volume";
				break;
			case 'gallery':
				$postformat_icon = "feather-icon-layers";
				break;
			case 'quote':
				$postformat_icon = "feather-icon-speech-bubble";
				break;
			case 'link':
				$postformat_icon = "feather-icon-link";
				break;
			case 'aside':
				$postformat_icon = "feather-icon-align-justify";
				break;
			case 'image':
				$postformat_icon = "feather-icon-image";
				break;
			default:
				$postformat_icon ="feather-icon-paper";
				break;
		}
		

		$portfoliogrid .= '<a href="'.get_permalink().'"><span class="hover-icon-effect column-gridblock-link '.$linkcenter.'"><i class="'.$postformat_icon.'"></i></span></a>';
		$portfoliogrid .= '</span>';


		//if Password Required
		if ( post_password_required() ) {
			$protected=" gridblock-protected"; $iconclass="";
			$portfoliogrid .= '<a class="grid-blank-element '.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
			$portfoliogrid .= '<span class="grid-blank-status"><i class="fa fa-lock fa-2x"></i></span>';
			$portfoliogrid .= '<div class="gridblock-protected"><img src="'.MTHEME_PATH.'/images/icons/blank-grid.png" alt="blank" /></div>';
		} else {

			if ( ! has_post_thumbnail() ) {
				$portfoliogrid .= '<a class="grid-blank-element '.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
				$portfoliogrid .= '<span class="grid-blank-status"><i class="'.$postformat_icon.' fa-2x"></i></span>';
				$portfoliogrid .= '<div class="gridblock-protected"><img src="'.MTHEME_PATH.'/images/icons/blank-grid.png" alt="blank" /></div>';
			}

			if ( has_post_thumbnail() ) {
			//Make sure it's not a slideshow
				//Switch check for Linked Type
			$portfoliogrid .= '<a class="gridblock-image-link gridblock-columns" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
			// Display Hover icon trigger classes

			// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
			$portfoliogrid .= '<span class="gridblock-background-hover"></span>';
			// Custom Thumbnail
			//Display Image
				$portfoliogrid .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$type=$portfolioImage_type,
					$imagetitle='',
					$class="preload-image displayed-image"
				);
			} else {
				$portfoliogrid .= '<a class="'.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
				$portfoliogrid .= '<div class="post-nothumbnail"></div>';
			} 
		}
		$portfoliogrid .= '</a>';
		
		$portfoliogrid .= '<div class="listbox-content">';
		$portfoliogrid .= '<div class="summary-info">';
			$category = get_the_category();
			if ($comments == 'true' ) {
				$portfoliogrid .= '<div class="summary-comment">';

				$num_comments = get_comments_number( get_the_id() ); // get_comments_number returns only a numeric value
				if ( comments_open() ) {
					if ( $num_comments == 0 ) {
						$comments_desc = __('0 <i class="fa fa-comment-alt"></i>');
					} elseif ( $num_comments > 1 ) {
						$comments_desc = $num_comments . __(' <i class="fa fa-comment-alt"></i>');
					} else {
						$comments_desc = __('1 <i class="fa fa-comment-alt"></i>');
					}
					$portfoliogrid .= '<a href="' . get_comments_link( get_the_id() ) .'">'. $comments_desc.'</a>';
				}
				$portfoliogrid .='</div>';
			}
			if ($date=='true') {
				$portfoliogrid .='<div class="summary-date"><i class="fa fa-clock-o"></i> '.get_the_date('jS M y').'</div>';
			}
		$portfoliogrid .='</div>';
		$portfoliogrid .= '</div>';
		// If either of title and description needs to be displayed.
		if ($title=="true" || $description=="true") {
			$portfoliogrid .='<div class="work-details">';
				$hreflink = get_permalink();
				if ($title=="true") { $portfoliogrid .='<h4><a href="'.$hreflink.'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>'; }
				$summary_content = mtheme_excerpt_limit($excerpt_length);
				if ($postformat=='quote') $summary_content = get_post_meta( get_the_id() , MTHEME . '_meta_quote', true);
				if ($description=="true") { $portfoliogrid .= '<p class="entry-content work-description">'. $summary_content .'</p>'; }
			$portfoliogrid .='</div>';
		}
		$portfoliogrid .= '</div>';

	$portfoliogrid .='</li>';

	endwhile; endif;
	$portfoliogrid .='</ul>';
	$portfoliogrid .='</div>';

		if ($pagination=='true') $portfoliogrid .= mtheme_pagination();
		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("recent_blog_listbox", "mRecentBlogListBox");

// Since version 2.5
if ( !function_exists( 'mtheme_shortcode_worktype_albums' ) ) {
	function mtheme_shortcode_worktype_albums($atts, $content = null) {
		extract(shortcode_atts(array(
			"worktype_slugs" => '',
			"format" => '',
			"columns" => 4,
			"item_count" => true,
			"title" => true,
			"description" => true,
			"worktype_icon" => 'feather-icon-layers'
		), $atts));

	if ($worktype_icon=="") {
		$worktype_icon = 'feather-icon-layers';
	}

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}
	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/icons/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/icons/blank-grid.png';
	}
	//$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.MTHEME_PATH.$protected_placeholder.'" alt="preloading" /></div>';

		$add_space_class = '';
		if ($title=='false' && $description=='false') {
			$add_space_class = 'gridblock-cell-bottom-space';
		}


		$portfoliogrid = '<div id="gridblock-container" class="gridblock-'.$column_type.' clearfix">';

		//$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
		if ($worktype_slugs!='') $all_works = explode(",", $worktype_slugs);
		$categories=  get_categories('orderby=slug&taxonomy=types&title_li=');

		foreach ($categories as $category){
			$taxonomy = "types"; // can be category, post_tag, or custom taxonomy name

			// Use any one of the three methods below

			// Using Term ID
			//$term_id = $category->term_id;
			//$term = get_term_by('id', $term_id, $taxonomy);

			// Using Term Name
			//$term_name = 'A Category';
			//$term = get_term_by('name', $term_name, $taxonomy);

			// Using Term Slug
			$term_slug = $category->slug;
			$term = get_term_by('slug', $term_slug, $taxonomy);

			// Enter only if Works is not set - means all included OR if work types are defined in shortcode
			if ( !isSet($all_works) || in_array($term_slug, $all_works) ) {
				// Fetch the count
				//echo $term->count;
				

				$hreflink = get_term_link($category->slug,'types');
				$mtheme_worktype_image_id = get_option('mtheme_worktype_image_id' . $category->term_id);
				$work_type_image = wp_get_attachment_image_src( $mtheme_worktype_image_id, $portfolioImage_type , false );

				$portfoliogrid .= '<div class="gridblock-element '.$add_space_class.'">';
					$portfoliogrid .= '<div class="gridblock-grid-element gridblock-element-inner">';
						$portfoliogrid .= '<div class="gridblock-background-hover">
												<div class="gridblock-links-wrap">
													<a title="'.get_the_title().'" rel="bookmark" href="'.$hreflink.'" class="column-gridblock-icon">
														<span class="hover-icon-effect">
															<i class="'.$worktype_icon.'"></i>
														</span>
													</a>';

				if ($item_count=='true') {

					//Count the items and reset
					$countquery = array(
						'post_type' => 'mtheme_portfolio',
						'types' => $category->slug,
						'posts_per_page' => -1,
						);
					query_posts($countquery);
					$item_counter=0;
					if (have_posts()) : while (have_posts()) : the_post();
						$item_counter++;
					endwhile;endif;

					wp_reset_query();

					//Check number of items
					if ( $item_counter==1 ) {
						$count_suffix = "item";
					} else {
						$count_suffix = "items";
					}
					$portfoliogrid .= '<span class="album-item-count"><span>'. $item_counter . ' ' . $count_suffix . '</span></span>';
				}
												$portfoliogrid .= '</div>
											</div>';
				// //$portfoliogrid .= $preload_tag;
				// $portfoliogrid .= '<span class="gridblock-image-link album-image-wrap">';
				
				// To display count
					//Display image
					$portfoliogrid .= '<img class="preload-image displayed-image" src="'. $work_type_image[0] .'" alt="'.get_the_title().'">';
					//$portfoliogrid .= '</span>';
					$portfoliogrid .= '</div>';
				if ($title=="true" || $description=="true") {
					$portfoliogrid .='<div class="work-details">';
						if ($title=='true') {
							$portfoliogrid .= '<h4>';
							$portfoliogrid .= '<a href="'.$hreflink.'">';
							$portfoliogrid .= $category->name;
							$portfoliogrid .= '</a>';
							$portfoliogrid .= '</h4>';
						}
						if ($description=='true') { $portfoliogrid .= '<p class="entry-content work-description">'.$category->description.'</p>'; }
					$portfoliogrid .='</div>';
				}
			
				$portfoliogrid .= '</div>';
			}
		}
		$portfoliogrid .= '</div>';

		return $portfoliogrid;
	}
}
add_shortcode("worktype_albums", "mtheme_shortcode_worktype_albums");

///////// Blog Timeline ///////////////
//++++++++++++++++++++++++++++++++++++++//
if ( !function_exists( 'mBlog_Timeline' ) ) {
	function mBlog_Timeline($atts, $content = null) {
		extract(shortcode_atts(array(
			"comments" => 'true',
			"date" => 'true',
			"columns" => '2',
			"limit" => '-1',
			"title" => 'true',
			"description" => 'true',
			"cat_slug" => '',
			"post_type" => '',
			"excerpt_length" => '15',
			"readmore_text" => '',
			"pagination" => 'false'
		), $atts));

	$columns = 2;
	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="gridblock-full";
		}

	$portfolio_count=0;
	$postformats="";
	$terms='';
	$terms=array();
	$count=0;
	$blogcount=0;
	$flag_new_row=true;
	$portfoliogrid='';
	$portfoliogrid .= '<div class="gridblock-columns-wrap gridblock-timeline-block clearfix">';
	$portfoliogrid .= '<div class="gridblock-timeline-icon"><i class="feather-icon-layers"></i></div>';
	$portfoliogrid .= '<div id="gridblock-timeline" class="gridblock-two">';

	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	if ($post_type<>"") {
		$type_explode = explode(",", $post_type);
		foreach ($type_explode as $postformat) {
			$count++;
			$postformat_slug = "post-format-" . $postformat;
			$terms[] .= $postformat_slug;
		}
		
		query_posts(array(
			'category_name' => $cat_slug,
			'posts_per_page' => $limit,
			'paged' => $paged,
			'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => $terms
						)
					)
			));
	} else {
		query_posts(array(
			'category_name' => $cat_slug,
			'paged' => $paged,
			'posts_per_page' => $limit
			));	
	}

	$prev_month='';

	if (have_posts()) : while (have_posts()) : the_post();
		//echo $type, $portfolio_type;

	$postformat = get_post_format();
	if($postformat == "") $postformat="standard";

	$portfolio_thumb_header="Image";

	if ($portfolio_count==$columns) $portfolio_count=0;

	$protected="";
	$icon_class="column-gridblock-icon";
	$portfolio_count++;

	$blogcount++;
	if ($blogcount % 2 == 0) {
		$align_to = 'right';
	} else {
		$align_to = 'left';
	}

	$this_post = get_post( get_the_id());
	$blogpost_time = strtotime($this_post->post_date);
	$curr_month = date('n', $blogpost_time);

	if ($curr_month!=$prev_month) {
		$blogcount = 1;
		$align_to = 'left';
		$portfoliogrid .= '<div class="clearfix"></div><div class="blog-timeline-month-wrap">';
		$portfoliogrid .= '<div class="blog-timeline-month">'.get_the_date( 'F' ) . ' ' . get_the_date( 'Y' ). '</div>';
		$portfoliogrid .= '</div>';
	}
	//if ($portfolio_count==1) $portfoliogrid .= '<li class="clearfix"></li>';
	$portfoliogrid .= '<div class="blog-grid-element animation-standby animated fadeInUp blog-grid-element-'.$align_to.' gridblock-element gridblock-col-'.$portfolio_count.'">';

		$postformat = get_post_format();
		if($postformat == "") $postformat="standard";
		$portfoliogrid .= '<div class="blog-grid-element-inner timeline-format-'.$postformat.'">';
		
		$linkcenter ='';
		$linkcenter="gridblock-link-center";

		switch ($postformat) {
			case 'video':
				$postformat_icon = "feather-icon-play";
				break;
			case 'audio':
				$postformat_icon = "feather-icon-volume";
				break;
			case 'gallery':
				$postformat_icon = "feather-icon-stack-2";
				break;
			case 'quote':
				$postformat_icon = "feather-icon-speech-bubble";
				break;
			case 'link':
				$postformat_icon = "feather-icon-link";
				break;
			case 'aside':
				$postformat_icon = "feather-icon-align-justify";
				break;
			case 'image':
				$postformat_icon = "feather-icon-image";
				break;
			default:
				$postformat_icon ="feather-icon-paper";
				break;
		}

		//if Password Required
		if ( post_password_required() ) {
			$protected=" portfolio-protected"; $iconclass="";
			$portfoliogrid .= '<a class="grid-blank-element '.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
			$portfoliogrid .= '<span class="grid-icon-status"><i class="fa fa-lock fa-2x"></i></span>';
			$portfoliogrid .= '<div class="portfolio-protected"><img src="'.MTHEME_PATH.'/images/icons/blank-grid.png" alt="blank" /></div>';
		} else {

			$hreflink = get_permalink();
			if ($postformat=="link") {
				$linked_to= get_post_meta(get_the_id(), MTHEME . '_meta_link', true);
				if ( isSet($linked_to) && $linked_to<>"" ) {
					$hreflink = $linked_to;
				}
			}
			if ( ! has_post_thumbnail() ) {
				$portfoliogrid .= '<a class="grid-blank-element '.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.$hreflink.'" >';
				$portfoliogrid .= '<span class="grid-icon-status"><i class="'.$postformat_icon.' fa-2x"></i></span>';
				$portfoliogrid .= '<div class="gridblock-blank-element"><img src="'.MTHEME_PATH.'/images/icons/blank-grid.png" alt="blank" /></div>';
			}

			if ( has_post_thumbnail() ) {
			//Make sure it's not a slideshow
				//Switch check for Linked Type
				$portfoliogrid .= '<a class="gridblock-image-link gridblock-columns" href="'.$hreflink .'" rel="bookmark" title="'.get_the_title().'">';
				$portfoliogrid .= '<span class="grid-icon-status"><i class="'.$postformat_icon.' fa-2x"></i></span>';
			// Display Hover icon trigger classes

			// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
			// Custom Thumbnail
			//Display Image
				$portfoliogrid .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$type=$portfolioImage_type,
					$imagetitle='',
					$class="preload-image displayed-image"
				);
			} else {
				
			}
		}
		$portfoliogrid .= '</a>';

		$portfoliogrid .= '<div class="blog-grid-element-content">';
			// If either of title and description needs to be displayed.
			if ($title=="true" || $description=="true") {
				$portfoliogrid .='<div class="work-details">';
				$hreflink = get_permalink();
				if ($postformat=="link") {
					$linked_to= get_post_meta(get_the_id(), MTHEME . '_meta_link', true);
					if ( isSet($linked_to) && $linked_to<>"" ) {
						$hreflink = $linked_to;
					}
				}
				if ($title=="true") { $portfoliogrid .='<h4><a href="'.$hreflink.'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>'; }
					$summary_content = mtheme_excerpt_limit($excerpt_length);
					if ($readmore_text!='') {
						$summary_content .= '<div class="blogpost_readmore"><a href="'.$hreflink.'">'.$readmore_text.'</a></div>';
					}
					if ($postformat=='quote') $summary_content = get_post_meta( get_the_id() , MTHEME . '_meta_quote', true);
					if ($description=="true") { $portfoliogrid .= '<div class="entry-content work-description">'. $summary_content .'</div>'; }
				$portfoliogrid .='</div>';
			}

			$portfoliogrid .= '<div class="summary-info">';
				$category = get_the_category();
				if ($comments == 'true' ) {
					$portfoliogrid .= '<div class="summary-comment">';

					$num_comments = get_comments_number( get_the_id() ); // get_comments_number returns only a numeric value
					if ( comments_open() ) {
						if ( $num_comments == 0 ) {
							$comments_desc = __('0 <i class="feather-icon-speech-bubble"></i>');
						} elseif ( $num_comments > 1 ) {
							$comments_desc = $num_comments . __(' <i class="feather-icon-speech-bubble"></i>');
						} else {
							$comments_desc = __('1 <i class="feather-icon-speech-bubble"></i>');
						}
						$portfoliogrid .= '<a href="' . get_comments_link( get_the_id() ) .'">'. $comments_desc.'</a>';
					}
					$portfoliogrid .='</div>';
				}
				if ($date=='true') {
					$portfoliogrid .='<div class="summary-date"><i class="feather-icon-clock"></i> '.get_the_date().'</div>';
				}
			$portfoliogrid .='</div>';

		$portfoliogrid .= '</div>';
	$portfoliogrid .= '</div>';
	$portfoliogrid .='</div>';

	$prev_month = $curr_month;
	endwhile; endif;
	$portfoliogrid .='</div>';
	$portfoliogrid .='</div>';

		if ($pagination=='true') $portfoliogrid .= mtheme_pagination();
		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("blogtimeline", "mBlog_Timeline");


/**
 * Portfolio Grid
 */
if ( !function_exists( 'mmtheme_GalleryGrids' ) ) {
	function mmtheme_GalleryGrids($atts, $content = null) {
		extract(shortcode_atts(array(
			"pageid" => '',
			"format" => '',
			"columns" => '4',
			"limit" => '-1',
			"displaycategory" => 'false',
			"gutter" => 'spaced',
			"boxtitle" => 'true',
			"title" => 'true',
			"desc" => 'true',
			"worktype_slugs" => '',
			"pagination" => 'false',
			"type" => 'filter'
		), $atts));


	$portfoliogrid ='';
	// Set a default
	$column_type="four";
	$portfolioImage_type="gridblock-large";

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}
	$gridblock_is_masonary = "";
	if ( $format == "masonary") {

		$gridblock_is_masonary = "gridblock-masonary ";
		if ($columns==4) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}

	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/icons/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/icons/blank-grid.png';
	}
	//$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.MTHEME_PATH.$protected_placeholder.'" alt="preloading" /></div>';
	$thumbnail_gutter_class =  'portfolio-gutter-'.$gutter.' ';
	if ($gutter=="nospace") {
		$thumbnail_gutter_class .=  'thumnails-gutter-active ';
	}
	$flag_new_row=true;

	if ( $format == "square" ) {
		$portfolioImage_type="gridblock-square-big";
	}

	$xtra_class = '';
	if ($desc=='false') {
		$xtra_class = ' gridblock-desc-off';
	}
	$portfoliogrid .= '<div id="gridblock-container" class="'.$thumbnail_gutter_class.$gridblock_is_masonary.'gridblock-'.$column_type.$xtra_class.' clearfix" data-columns="'.$columns.'">';
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '<div class="gridblock-masonary-inner">';
	// }
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	$count=0;
	$terms=array();
	$work_slug_array=array();
	//echo $worktype_slugs;
	if ($worktype_slugs != "") {
		$type_explode = explode(",", $worktype_slugs);
		foreach ($type_explode as $work_slug) {
			$terms[] = $work_slug;
		}
		query_posts(array(
			'post_type' => 'mtheme_photostory',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'paged' => $paged,
			'posts_per_page' => $limit,
			'tax_query' => array(
				array(
					'taxonomy' => 'photostories',
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN'
					)
				)
			));
	} else {
		query_posts(array(
			'post_type' => 'mtheme_photostory',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'paged' => $paged,
			'posts_per_page' => $limit
			));	
	}

	$idCount=1;
	$portfolio_count=0;
	$portfolio_total_count=0;

	if (have_posts()) : while (have_posts()) : the_post();
			//echo $type, $portfolio_type;
		$custom = get_post_custom(get_the_ID());
		$portfolio_cats = get_the_terms( get_the_ID(), 'photostories' );
		$lightboxvideo="";
		$thumbnail="";
		$customlink_URL="";
		$description="";
		$portfolio_thumb_header="Image";

		if ( isset($custom[MTHEME . '_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom[MTHEME . '_thumbnail_linktype'][0]; }
		if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { $lightboxvideo=$custom[MTHEME . '_lightbox_video'][0]; }
		if ( isset($custom[MTHEME . '_customthumbnail'][0]) ) { $thumbnail=$custom[MTHEME . '_customthumbnail'][0]; }
		if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { $description=$custom[MTHEME . '_thumbnail_desc'][0]; }
		if ( isset($custom[MTHEME . '_customlink'][0]) ) { $customlink_URL=$custom[MTHEME . '_customlink'][0]; }
		if ( isset($custom[MTHEME . '_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom[MTHEME . '_portfoliotype'][0]; }

		if ($portfolio_count==$columns) $portfolio_count=0;

		$add_space_class = '';
		$xtra_class = '';
		if ( $gutter!='nospace') {
			if ($title=='false' && $desc=='false') {
				$add_space_class = 'gridblock-cell-bottom-space';
			}
		}	

		$protected="";
		$icon_class="column-gridblock-icon";
		$portfolio_count++;
		$portfolio_total_count++;

		$gridblock_ajax_class='';
		if ($type=='ajax') {
			$gridblock_ajax_class="gridblock-ajax ";
		}

		// Generate main DIV tag with portfolio information with filterable tags
		$portfoliogrid .= '<div class="gridblock-element gridblock-element-id-'.get_the_ID().' gridblock-element-order-'.$portfolio_total_count.' '.$add_space_class.' gridblock-filterable ';
		if ( is_array($portfolio_cats) ) {
			foreach ($portfolio_cats as $taxonomy) { 
				$portfoliogrid .=  'filter-' . $taxonomy->slug . ' '; 
			}
		}
		$idCount++;
		$portfoliogrid .= '" data-portfolio="portfolio-'. get_the_ID() .'" data-id="id-'. $idCount .'">';
			$portfoliogrid .= '<div class="'.$gridblock_ajax_class.'gridblock-grid-element gridblock-element-inner" data-portfolioid="'.get_the_id().'">';

				$portfoliogrid .= '<div class="gridblock-background-hover">';
					$portfoliogrid .= '<div class="gridblock-links-wrap">';


				if ( post_password_required() ) {
					$protected=" gridblock-protected"; $iconclass="";
					//$portfoliogrid .= '<a class="'.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
					$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
							$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-layers"></i></span>';
						$portfoliogrid .= '</a>';
				} else {

					$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
					$icon_class='<i class="feather-icon-layers"></i>';
					//$portfoliogrid .= '<span class="gridblock-image-hover">';
					if ( isSet($icon_class) ) {
						$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
					}
					$portfoliogrid .= '</a>';
				}

				if ($boxtitle=="true") {

					$current_terms = wp_get_object_terms( get_the_ID(), 'photostories' );
					$current_worktype = '';
					$seperator = ',';
					foreach( $current_terms as $the_term ) {
						if ($the_term === end($current_terms)) {
							$seperator = '';
						}
						$current_worktype .= $the_term->name . $seperator;
					}
				
					$portfoliogrid .= '<span class="boxtitle-hover">';
					$portfoliogrid .= '<a href="'.get_permalink().'" rel="bookmark" title="'. get_the_title() .'">';
					$portfoliogrid .= get_the_title();
					$portfoliogrid .= '</a>';
					$portfoliogrid .= '</span>';
				}
				
			$portfoliogrid .= '</div>';
		$portfoliogrid .= '</div>';

		if ( post_password_required() ) {

			$portfoliogrid .= '<div class="gridblock-protected">';
			$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
			if ( $format == "portrait" ) {
				$protected_placeholder = '/images/icons/blank-grid-portrait-related.png';
			} else {
				$protected_placeholder = '/images/icons/blank-grid.png';
			}
			$portfoliogrid .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
			$portfoliogrid .= '</div>';

		} else {
			if ($thumbnail<>"") {
				$portfoliogrid .= '<img src="'.$thumbnail.'" class="displayed-image" alt="thumbnail" />';
			} else {
				// Slideshow then generate slideshow shortcode
				$portfoliogrid .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$imagetype=$portfolioImage_type,
					$imagetitle=mtheme_featured_image_title( get_the_ID() ),
					$class="displayed-image"
				);

			}
		}
	$portfoliogrid .='</div>';
		if ($title=='true' || $desc=='true') {
			$portfoliogrid .='<div class="work-details">';
				$hreflink = get_permalink();
				if ($title=='true') {
					if ($type != "ajax") {
						$portfoliogrid .='<h4><a href="'.$hreflink.'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>';
					} else {
						$portfoliogrid .= '<h4>';
						$portfoliogrid .=''. get_the_title() .'';
						$portfoliogrid .= '</h4>';
					}
				}
				if ($desc=='true') $portfoliogrid .= '<p class="entry-content work-description">'.$description.'</p>';
			$portfoliogrid .='</div>';
		}


	$portfoliogrid .='</div>';

	//if ($portfolio_count==$columns)  $portfoliogrid .='</div>';

	endwhile; endif;
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '</div>';
	// }
	$portfoliogrid .='</div>';

		if ($pagination=='true') { 
			$portfoliogrid .= '<div class="clearfix">';
			$portfoliogrid .= mtheme_pagination();
			$portfoliogrid .= '</div>';
		}

		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("gallerygrid", "mmtheme_GalleryGrids");

//Recent Works Carousel
if ( !function_exists( 'mBlogCarousel' ) ) {
	function mBlogCarousel($atts, $content = null) {
		extract(shortcode_atts(array(
			"post_type" => '',
			"cat_slug" => '',
			"format" => '',
			"carousel_type" => 'owl',
			"columns" => '4',
			"limit" => '-1',
			"title" => 'true',
			"desc" => 'true',
			"boxtitle" => 'true',
			"cat_slug" => '',
			"pagination" => 'true'
		), $atts));

	$uniqureID=get_the_id()."-".uniqid();
	$column_type="four";
	$portfolioImage_type="gridblock-large";
	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}

	if ($cat_slug=="-1") { $cat_slug=''; }
	$portfolio_count=0;
	$flag_new_row=true;
	$portfoliogrid='';

	if ($post_type<>"") {
			$type_explode = explode(",", $post_type);
			foreach ($type_explode as $postformat) {
				$count++;
				$postformat_slug = "post-format-" . $postformat;
				$terms[] .= $postformat_slug;
			}
			
			query_posts(array(
				'category_name' => $cat_slug,
				'posts_per_page' => $limit,
				'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => $terms
							)
						)
				));
		} else {
			query_posts(array(
				'category_name' => $cat_slug,
				'posts_per_page' => $limit
				));	
		}

	if ($carousel_type=="owl") {

		$portfoliogrid .= '<div class="gridblock-owlcarousel-wrap clearfix">';
		$portfoliogrid .= '<div id="owl-'.$uniqureID.'" class="owl-carousel">';

		if (have_posts()) : while (have_posts()) : the_post();

			//echo $type, $portfolio_type;
		$custom = get_post_custom(get_the_ID());
		$portfolio_cats = get_the_terms( get_the_ID(), 'types' );
		$lightboxvideo="";
		$thumbnail="";
		$customlink_URL="";
		$portfolio_thumb_header="Image";

		if ($portfolio_count==$columns) $portfolio_count=0;

		$protected="";
		$icon_class="column-gridblock-icon";
		$portfolio_count++;
		$portfoliogrid .= '<div class="gridblock-grid-element">';

				$portfoliogrid .= '<div class="gridblock-background-hover">';
					$portfoliogrid .= '<div class="gridblock-links-wrap">';

				//if Password Required
				if ( post_password_required() ) {
					$protected=" gridblock-protected"; $iconclass="";
					$portfoliogrid .= '<a class="'.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
					//$portfoliogrid .= '<span class="hover-icon-effect"><i class="fa fa-lock fa-2x"></i></span>';
				} else {
					//Switch check for Linked Type

					$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';

					$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-plus"></i></span>';

					$portfoliogrid .= '</a>';

				}
				$portfoliogrid .= '</a>';
				// End of links wrap

				if ($boxtitle=="true") {

					$current_terms = wp_get_object_terms( get_the_ID(), 'category' );
					$current_worktype = $current_terms[0]->name; 
				
					$portfoliogrid .= '<span class="boxtitle-hover">';
					$portfoliogrid .= '<a href="'.get_permalink().'" rel="bookmark" title="'. get_the_title() .'">';
					$portfoliogrid .= get_the_title();
					$portfoliogrid .= '</a>';
					$portfoliogrid .= '<span class="boxtitle-worktype">'.$current_worktype.'</span>';
					$portfoliogrid .= '</span>';
				}
				
				$portfoliogrid .= '</div>';
			$portfoliogrid .= '</div>';

			if ( post_password_required() ) {

				$portfoliogrid .= '<div class="gridblock-protected">';
				$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
				if ( $format == "portrait" ) {
					$protected_placeholder = '/images/icons/blank-grid-portrait-related.png';
				} else {
					$protected_placeholder = '/images/icons/blank-grid.png';
				}
				$portfoliogrid .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
				$portfoliogrid .= '</div>';

			} else {
				if ($thumbnail<>"") {
					$portfoliogrid .= '<img src="'.$thumbnail.'" class="displayed-image" alt="thumbnail" />';
				} else {
					// Slideshow then generate slideshow shortcode
					$portfoliogrid .= mtheme_display_post_image (
						get_the_ID(),
						$have_image_url="",
						$link=false,
						$type=$portfolioImage_type,
						$imagetitle=mtheme_featured_image_title( get_the_ID() ),
						$class="displayed-image"
					);

				}
			}

		$portfoliogrid .='</div>';

		endwhile; endif;
		$portfoliogrid .='</div>';
		$portfoliogrid .='</div>';
		$portfoliogrid .='
		<script>
		/* <![CDATA[ */
		(function($){
		$(window).load(function(){
			$("#owl-'.$uniqureID.'").owlCarousel({
				itemsCustom : [
					[0, 1],
					[600, 1],
					[800, 2],
					[1000, 3],
					[1300, '.$columns.']
				],
				items: '.$columns.',
				navigation : true,
				navigationText : ["",""],
				pagination : '.$pagination.',
				scrollPerPage : false
			});
		})
		})(jQuery);
		/* ]]> */
		</script>
		';

	}

		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("blogcarousel", "mBlogCarousel");


/**
 * Portfolio Grid
 */
if ( !function_exists( 'mGridCreate' ) ) {
	function mGridCreate($atts, $content = null) {
		extract(shortcode_atts(array(
			"pageid" => '',
			"sortorder" => 'default',
			"grid_post_type" => '',
			"grid_tax_type" => '',
			"format" => '',
			"columns" => '4',
			"limit" => '-1',
			"gutter" => 'spaced',
			"boxtitle" => 'true',
			"title" => 'true',
			"desc" => 'true',
			"worktype_slugs" => '',
			"pagination" => 'false',
			"type" => 'filter'
		), $atts));


	$portfoliogrid ='';

	if ($type=="filter" || $type=="ajax") {

		$countquery = array(
			'post_type' => $grid_post_type,
			'types' => $worktype_slugs,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => -1,
			);
		query_posts($countquery);
		if (have_posts()) : while (have_posts()) : the_post();
		endwhile;endif;

	if ($type=="ajax") {
		$portfoliogrid .= '	<div class="ajax-gridblock-block-wrap clearfix">';
			$portfoliogrid .= '	<div class="ajax-gallery-navigation clearfix">';
			$portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-next" href="#"><i class="feather-icon-arrow-right"></i></a>';
			$portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-hide" href="#"><i class="feather-icon-align-justify"></i></a>';
			$portfoliogrid .= '		<a class="ajax-navigation-arrow ajax-prev" href="#"><i class="feather-icon-arrow-left"></i></a>';
			$portfoliogrid .= '		<span class="ajax-loading">Loading</span>';
			$portfoliogrid .= '	</div>';
			$portfoliogrid .= '	<div class="ajax-gridblock-window">';
			$portfoliogrid .= '		<div id="ajax-gridblock-wrap"></div>';
			$portfoliogrid .= '	</div>';
		$portfoliogrid .= '	</div>';
	}
		$portfoliogrid .= '<div class="gridblock-filter-select-wrap">';
			$portfoliogrid .= '<ul id="gridblock-filters">';
			
			$portfoliogrid .= '<li>';
				$portfoliogrid .= '<a data-filter="*" data-title="'. of_get_option('portfolio_allitems') .'" href="#">';
				$portfoliogrid .= of_get_option('portfolio_allitems');
				$portfoliogrid .= '</a>';
			$portfoliogrid .= '</li>';
						
		//$categories=  get_categories('child_of='.$portfolio_cat_ID.'&orderby=slug&taxonomy=types&title_li=');
		if ($worktype_slugs!='') $all_works = explode(",", $worktype_slugs);
		$categories=  get_categories('orderby=slug&taxonomy='.$grid_tax_type.'&title_li=');
		foreach ($categories as $category){
			
			$taxonomy = $grid_tax_type;

			// Using Term Slug
			$term_slug = $category->slug;
			$term = get_term_by('slug', $term_slug, $taxonomy);

			// Enter only if Works is not set - means all included OR if work types are defined in shortcode
			if ( !isSet($all_works) || in_array($term_slug, $all_works) ) {
				// Fetch the count
				//echo $term->count;
				$portfoliogrid .= '<li>';
					$portfoliogrid .= '<a data-filter=".filter-' . $category->slug .'" data-title="'. $category->name . '" href="#">';
						$portfoliogrid .= $category->name;
					$portfoliogrid .= '</a>';
				$portfoliogrid .= '</li>';
			}
		}
			$portfoliogrid .= '</ul>';
		$portfoliogrid .= '</div>';
	//End of If Filter
	}
	//Reset query after Filters
	wp_reset_query();

	// Set a default
	$column_type="four";
	$portfolioImage_type="gridblock-large";

	if ($columns==4) { 
		$column_type="four";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==3) { 
		$column_type="three";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==2) { 
		$column_type="two";
		$portfolioImage_type="gridblock-large";
		}
	if ($columns==1) { 
		$column_type="one";
		$portfolioImage_type="gridblock-full";
		}

	if ( $format == "portrait") {
		if ($columns==4) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-large-portrait";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}
	$gridblock_is_masonary = "";
	if ( $format == "masonary") {

		$gridblock_is_masonary = "gridblock-masonary ";
		if ($columns==4) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==3) { 
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==2) {
			$portfolioImage_type="gridblock-full-medium";
			}
		if ($columns==1) {
			$portfolioImage_type="gridblock-full";
			}
	}

	if ( $format == "portrait" ) {
		$protected_placeholder = '/images/icons/blank-grid-portrait.png';
	} else {
		$protected_placeholder = '/images/icons/blank-grid.png';
	}
	//$preload_tag = '<div class="preloading-placeholder"><span class="preload-image-animation"></span><img src="'.MTHEME_PATH.$protected_placeholder.'" alt="preloading" /></div>';
	$thumbnail_gutter_class =  'portfolio-gutter-'.$gutter.' ';
	if ($gutter=="nospace") {
		$thumbnail_gutter_class .=  'thumnails-gutter-active ';
	}
	$flag_new_row=true;


	$portfoliogrid .= '<div id="gridblock-container" class="'.$thumbnail_gutter_class.$gridblock_is_masonary.'gridblock-'.$column_type.' clearfix" data-columns="'.$columns.'">';
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '<div class="gridblock-masonary-inner">';
	// }
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}

	$count=0;
	$terms=array();
	$work_slug_array=array();

	$events_sort_start = false;

	if ( $grid_post_type == "mtheme_events" ) {
		if ($sortorder == "event_start" || $sortorder == "event_start_asc") {
			
			$events_sort_start = true;

			// Reindex
			query_posts(array(
				'post_type' => "mtheme_events",
				'posts_per_page' => '-1'
			));

			if (have_posts()) : while (have_posts()) : the_post();
				
				$custom = get_post_custom( get_the_id() );
				// echo '<pre>';
				// print_r($custom);
				// echo '</pre>';
				$curr_startdatetime = '';
				$curr_enddatetime = '';

				if (isSet($custom[MTHEME . '_event_enddate_unixdatetime'][0])) {
					$curr_enddatetime = $custom[MTHEME . '_event_enddate_unixdatetime'][0];
				}
				if (isSet($custom[MTHEME . '_event_startdate_unixdatetime'][0])) {
					$curr_startdatetime = $custom[MTHEME . '_event_startdate_unixdatetime'][0];
				}

				if ( isset($custom[MTHEME . '_event_startdate'][0]) && isset($custom[MTHEME . '_event_starttime'][0]) ) {
					
					$event_startdate=$custom[MTHEME . '_event_startdate'][0];
					$event_starttime=$custom[MTHEME . '_event_starttime'][0];

					if ( isset($custom[MTHEME . '_event_enddate'][0]) ) {
						$event_enddate=$custom[MTHEME . '_event_enddate'][0];
					} else {
						$event_enddate=$event_startdate;
					}
					$event_endtime=$custom[MTHEME . '_event_endtime'][0];

					// Get the start time and combine to unix date time
					$unixstartdate = str_replace('-', '/', $event_startdate);
					$unix_startdatetime = strtotime($unixstartdate . ' ' .$event_starttime);

					// Get end time and convert to unix date time
					$unixenddate = str_replace('-', '/', $event_enddate);
					$unix_enddatetime = strtotime($unixenddate . ' ' .$event_endtime);

					// Store them
					if ( $curr_startdatetime <> $unix_startdatetime ) {
						//echo '<br/>Updating Start ' . get_the_id();
						update_post_meta( get_the_id() , MTHEME . '_event_startdate_unixdatetime', $unix_startdatetime );
					}
					if ( $curr_enddatetime <> $unix_enddatetime ) {
						//echo '<br/>Updating End ' .$curr_enddatetime . '----' . $unix_enddatetime .' '. get_the_id();
						update_post_meta( get_the_id() , MTHEME . '_event_enddate_unixdatetime', $unix_enddatetime );
					}
				}

			endwhile; endif;
		}
	}

	$events_orderby = 'menu_order';
	$events_order = 'ASC';
	$events_meta_key = '';
	if ( $events_sort_start ) {
		$events_meta_key = MTHEME . '_event_startdate_unixdatetime';
		$events_orderby = 'meta_value_num';
		if ($sortorder == "event_start_asc" ) {
			$events_order = 'ASC';
		} else {
			$events_order = 'DESC';
		}
	}
	//echo $worktype_slugs;
	if ($worktype_slugs != "") {
		$type_explode = explode(",", $worktype_slugs);
		foreach ($type_explode as $work_slug) {
			$terms[] = $work_slug;
		}

		if ($grid_post_type=="mtheme_events") {
			query_posts(array(
				'post_type' => $grid_post_type,
				'meta_key' => $events_meta_key,
				'orderby' => $events_orderby,
				'order' => $events_order,
				'paged' => $paged,
				'posts_per_page' => $limit,
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> MTHEME . '_event_notice',
						'value'	  	=> 'inactive',
						'compare' 	=> 'NOT IN',
					),
				),
				'tax_query' => array(
					array(
						'taxonomy' => $grid_tax_type,
						'field' => 'slug',
						'terms' => $terms,
						'operator' => 'IN'
						)
					)
				));	
		} else {
			query_posts(array(
				'post_type' => $grid_post_type,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'paged' => $paged,
				'posts_per_page' => $limit,
				'tax_query' => array(
					array(
						'taxonomy' => $grid_tax_type,
						'field' => 'slug',
						'terms' => $terms,
						'operator' => 'IN'
						)
					)
				));
		}
	} else {

		if ($grid_post_type=="mtheme_events") {
			query_posts(array(
				'post_type' => $grid_post_type,
				'meta_key' => $events_meta_key,
				'orderby' => $events_orderby,
				'order' => $events_order,
				'paged' => $paged,
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
		} else {
			query_posts(array(
				'post_type' => $grid_post_type,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'paged' => $paged,
				'posts_per_page' => $limit
				));
		}
	}

	$idCount=1;
	$portfolio_count=0;
	$portfolio_total_count=0;

	if (have_posts()) : while (have_posts()) : the_post();
			//echo $type, $portfolio_type;
		$custom = get_post_custom(get_the_ID());
		if (isSet($$grid_tax_type)) {
			$portfolio_cats = get_the_terms( get_the_ID(), $grid_tax_type );
		}
		$lightboxvideo="";
		$thumbnail="";
		$customlink_URL="";
		$portfolio_thumb_header="Image";

		if ( isset($custom[MTHEME . '_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom[MTHEME . '_thumbnail_linktype'][0]; }
		if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { $lightboxvideo=$custom[MTHEME . '_lightbox_video'][0]; }
		if ( isset($custom[MTHEME . '_customthumbnail'][0]) ) { $thumbnail=$custom[MTHEME . '_customthumbnail'][0]; }
		if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { $description=$custom[MTHEME . '_thumbnail_desc'][0]; }
		if ( isset($custom[MTHEME . '_customlink'][0]) ) { $customlink_URL=$custom[MTHEME . '_customlink'][0]; }
		if ( isset($custom[MTHEME . '_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom[MTHEME . '_portfoliotype'][0]; }

		if ($portfolio_count==$columns) $portfolio_count=0;

		$add_space_class = '';
		if ( $gutter!='nospace') {
			if ($title=='false' && $desc=='false') {
				$add_space_class = 'gridblock-cell-bottom-space';
			}
		}

		$protected="";
		$icon_class="column-gridblock-icon";
		$portfolio_count++;
		$portfolio_total_count++;

		$gridblock_ajax_class='';
		if ($type=='ajax') {
			$gridblock_ajax_class="gridblock-ajax ";
		}

		// Generate main DIV tag with portfolio information with filterable tags
		$portfoliogrid .= '<div class="gridblock-element gridblock-element-id-'.get_the_ID().' gridblock-element-order-'.$portfolio_total_count.' '.$add_space_class.' gridblock-filterable ';
		if (isSet($portfolio_cats)) {
			if ( is_array($portfolio_cats) ) {
				foreach ($portfolio_cats as $taxonomy) { 
					$portfoliogrid .=  'filter-' . $taxonomy->slug . ' '; 
				}
			}
		}
		$idCount++;
		$portfoliogrid .= '" data-portfolio="portfolio-'. get_the_ID() .'" data-id="id-'. $idCount .'">';
			$portfoliogrid .= '<div class="'.$gridblock_ajax_class.'gridblock-grid-element gridblock-element-inner" data-portfolioid="'.get_the_id().'">';

				$portfoliogrid .= '<div class="gridblock-background-hover">';
					$portfoliogrid .= '<div class="gridblock-links-wrap">';


		//if Password Required

			//Make sure it's not a slideshow
		if ($type !="ajax") {
				//Switch check for Linked Type
			//Switch check for Linked Type

				if ( post_password_required() ) {
					$protected=" gridblock-protected"; $iconclass="";
					//$portfoliogrid .= '<a class="'.$protected.' gridblock-image-link gridblock-columns" title="'.get_the_title().'" href="'.get_permalink().'" >';
					$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
							$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-plus"></i></span>';
						$portfoliogrid .= '</a>';
				} else {

					if (isSet($portfolio_link_type)) {
						if ($portfolio_link_type=="Lightbox_DirectURL") {
							$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
								$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-plus"></i></span>';
							$portfoliogrid .= '</a>';
						}

						switch ($portfolio_link_type) {
							case 'DirectURL':
								$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
								$icon_class='<i class="feather-icon-plus"></i>';
								break;

							case 'Customlink':
								$portfoliogrid .= '<a class="column-gridblock-icon" href="'.$customlink_URL.'">';
								$icon_class='<i class="feather-icon-link"></i>';
								break;

							case 'Lightbox_DirectURL':
							case 'Lightbox':
								if ( $lightboxvideo<>"" ) {
									$portfoliogrid .= mtheme_activate_lightbox (
										$lightbox_type="magnific",
										$ID=get_the_ID(),
										$link=$lightboxvideo,
										$mediatype="video",
										$imagetitle=get_the_title(),
										$class="column-gridblock-icon",
										$navigation="magnific-video"
										);
									$icon_class='<i class="feather-icon-play"></i>';
								} else {
									$portfoliogrid .= mtheme_activate_lightbox (
										$lightbox_type="magnific",
										$ID=get_the_ID(),
										$link=mtheme_featured_image_link( get_the_ID() ),
										$mediatype="image",
										$imagetitle=mtheme_featured_image_title( get_the_ID() ),
										$class="column-gridblock-icon",
										$navigation="magnific-image"
										);
									$icon_class='<i class="feather-icon-maximize"></i>';							
								}
								break;
						}
					} else {
						
						$portfoliogrid .= '<a class="column-gridblock-icon" href="'.get_permalink() .'" rel="bookmark" title="'.get_the_title().'">';
						$icon_class='<i class="feather-icon-plus"></i>';
						
					}
					//$portfoliogrid .= '<span class="gridblock-image-hover">';
					if ( isSet($icon_class) ) {
						$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
					}
					$portfoliogrid .= '</a>';
				}
				//$portfoliogrid .= '</span>';
				// If it aint slideshow then display a background. Otherwise one is active in slideshow thumbnails.
				// Custom Thumbnail
		// If AJAX
		} else {
			$portfoliogrid .= '<span class="column-gridblock-icon">';
			$icon_class='<i class="feather-icon-eye"></i>';
			$portfoliogrid .= '<span class="hover-icon-effect">'.$icon_class .'</span>';
			$portfoliogrid .= '</span>';
		}

				if ($boxtitle=="true") {

					$current_terms = wp_get_object_terms( get_the_ID(), 'types' );
					if ( isSet($current_terms[0]->name) ) {
						$current_worktype = $current_terms[0]->name; 
					}
				
					$portfoliogrid .= '<span class="boxtitle-hover">';
					$portfoliogrid .= '<a href="'.get_permalink().'" rel="bookmark" title="'. get_the_title() .'">';
					$portfoliogrid .= get_the_title();
					$portfoliogrid .= '</a>';
					if (isSet($current_worktype)) {
						$portfoliogrid .= '<span class="boxtitle-worktype">'.$current_worktype.'</span>';
					}
					$portfoliogrid .= '</span>';
				}
				
			$portfoliogrid .= '</div>';
		$portfoliogrid .= '</div>';

		if ( post_password_required() ) {

			$portfoliogrid .= '<div class="gridblock-protected">';
			$portfoliogrid .= '<span class="hover-icon-effect"><i class="feather-icon-lock"></i></span>';
			if ( $format == "portrait" ) {
				$protected_placeholder = '/images/icons/blank-grid-portrait-related.png';
			} else {
				$protected_placeholder = '/images/icons/blank-grid.png';
			}
			$portfoliogrid .= '<img src="'.MTHEME_PATH.$protected_placeholder.'" alt="blank" />';
			$portfoliogrid .= '</div>';

		} else {
			if ($thumbnail<>"") {
				$portfoliogrid .= '<img src="'.$thumbnail.'" class="displayed-image" alt="thumbnail" />';
			} else {
				// Slideshow then generate slideshow shortcode
				$portfoliogrid .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$imagetype=$portfolioImage_type,
					$imagetitle=mtheme_featured_image_title( get_the_ID() ),
					$class="displayed-image"
				);

			}
		}
		$portfoliogrid .='</div>';
		if ($title=='true' || $desc=='true') {
			$portfoliogrid .='<div class="work-details">';
				$hreflink = get_permalink();
				if ($title=='true') {
					if ($type != "ajax") {
						$portfoliogrid .='<h4><a href="'.$hreflink.'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>';
					} else {
						$portfoliogrid .= '<h4>';
						$portfoliogrid .=''. get_the_title() .'';
						$portfoliogrid .= '</h4>';
					}
				}
				if ($desc=='true') $portfoliogrid .= '<p class="entry-content work-description">'.$description.'</p>';
			$portfoliogrid .='</div>';
		}


	$portfoliogrid .='</div>';

	//if ($portfolio_count==$columns)  $portfoliogrid .='</div>';

	endwhile; endif;
	// if ($format=="masonary") {
	// 	$portfoliogrid .= '</div>';
	// }
	$portfoliogrid .='</div>';

		if ($pagination=='true') { 
			$portfoliogrid .= '<div class="clearfix">';
			$portfoliogrid .= mtheme_pagination();
			$portfoliogrid .= '</div>';
		}

		wp_reset_query();
		return $portfoliogrid;
	}
}
add_shortcode("gridcreate", "mGridCreate");
?>
