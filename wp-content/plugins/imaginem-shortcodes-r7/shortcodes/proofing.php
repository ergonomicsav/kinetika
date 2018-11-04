<?php
//Thumbnails for Gallery [thumbnails]
if ( !function_exists( 'mtheme_Proofing' ) ) {
	function mtheme_Proofing($atts, $content = null) {
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
			"title" => "true",
			"description" => "false",
			"id" => '1',
			"proofingstatus" => 'active',
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

		$proof_edit_enabled = $proofingstatus;

		$proofing_all_items = "All items";
		$proofing_selected_items = "Selected";
		$proofing_selected_count = "Selected";
		$proofing_rejected_items = "Rejected";

		$proofing_choice_title = of_get_option('proofing_image_id');
		$opt_proofing_all_items = of_get_option('proofing_all_items');
		$opt_proofing_selected_items = of_get_option('proofing_selected_items');
		$opt_proofing_rejected_items = of_get_option('proofing_rejected_items');
		$opt_proofing_selected_count = of_get_option('proofing_selected_count');

		if ($opt_proofing_all_items<>"") {
			$proofing_all_items = $opt_proofing_all_items;
		}
		if ($opt_proofing_selected_items<>"") {
			$proofing_selected_items = $opt_proofing_selected_items;
		}
		if ($opt_proofing_rejected_items<>"") {
			$proofing_rejected_items = $opt_proofing_rejected_items;
		}
		if ($opt_proofing_selected_count<>"") {
			$proofing_selected_count = $opt_proofing_selected_count;
		}

		//$filter_image_ids = mtheme_get_custom_attachments ( $thepageID );
		
		if ( $filter_image_ids ) {

				$thumbnails =  '<div class="proofing-shortcode proofing-status-'.$proofingstatus.' thumbnails-shortcode gridblock-columns-wrap clearfix">';

					// Filterables
				$thumbnails .= '<div class="gridblock-header-wrap grid-block-header-proofing">';
					$thumbnails .= '<div class="gridblock-filter-select-wrap">';
						$thumbnails .= '<div id="gridblock-filters">';
							$thumbnails .= '<ul class="gridblock-filter-categories">';
								
								$thumbnails .= '<li class="filter-all-control">';
									$thumbnails .= '<a data-filter="*" data-title="All items" href="#">';
									$thumbnails .= '<span class="filter-seperator filter-seperator-all"></span>'.$proofing_all_items;
									$thumbnails .= '</a>';
								$thumbnails .= '</li>';

								$thumbnails .= '<li class="filter-control filter-category-control filter-control-selected">';
									$thumbnails .= '<a data-filter=".filter-selected" data-title="Selected" href="#">';
										$thumbnails .= '<span class="filter-seperator filter-seperator-all"></span>'.$proofing_selected_items;
									$thumbnails .= '</a>';
								$thumbnails .= '</li>';

								$thumbnails .= '<li class="filter-control filter-category-control filter-control-rejected">';
									$thumbnails .= '<a data-filter=".filter-unchecked" data-title="Rejected" href="#">';
										$thumbnails .= '<span class="filter-seperator filter-seperator-all"></span>'.$proofing_rejected_items;
									$thumbnails .= '</a>';
								$thumbnails .= '</li>';

							$thumbnails .= '</ul>';
						$thumbnails .= '</div>';
					$thumbnails .= '</div>';


					$thumbnails .=  '<div class="proofing-status-count-wrap"><div id="proofing-status-count"><span class="proofing-count-selected">0</span> / <span class="proofing-count-total">0</span> ' . $proofing_selected_count . '</div></div>';

				$thumbnails .= '</div>';
				$thumbnails .= '<div class="proofing-item-wrap thumbnails-grid-container thumbnail-gutter-'.$gutter.$gridblock_is_masonary.$thumbnail_gutter_class.$title_desc_class.' gridblock-'.$column_type.'"  data-columns="'.$columns.'">';

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

				$mtheme_proofing_status="false";
				$proofing_icon="feather-icon-check";
				$set_proofing="unchecked";

				$mtheme_proofing_status = get_post_meta($attachment_id,'checked',true);
				if ($mtheme_proofing_status=="true") {
					$set_proofing="selected";
					$proofing_icon="feather-icon-cross";
				}

				$thumbnails .=  '<div id="mtheme-proofing-item-'.$attachment_id.'" data-proofing_status="'.$set_proofing.'" class="filter-'.$set_proofing.' mtheme-proofing-item proofing-item-'.$set_proofing.' gridblock-element '.$animation_class.' gridblock-thumbnail-id-'.$attachment_id.' gridblock-col-'.$portfolio_count.'">';
				//$thumbnails .= mtheme_display_like_link( $attachment_id );
				$thumbnails .= '<div class="gridblock-ajax gridblock-grid-element gridblock-element-inner" data-rel="'.get_the_id().'">';
					$thumbnails .= '<i class="proofing-progress-indicator fa fa-circle-o-notch"></i>';
					$thumbnails .= '<span class="proofing-selected-marker"><i class="feather-icon-circle-check"></i></span>';
					$thumbnails .= '<div class="gridblock-background-hover">';
						$thumbnails .= '<div class="gridblock-links-wrap">';
					

						$thumbnails .=  mtheme_activate_lightbox (
							$lightbox_type="magnific",
							$ID='',
							$link=$imageURI,
							$mediatype="image",
							$lightbox_imagetitle=$imageTitle,
							$class="column-gridblock-icon column-gridblock-lightbox",
							$navigation="magnific-thumbnails"
							);
							$thumbnails .= '<span class="hover-icon-effect"><i class="feather-icon-maximize"></i></span>';
						$thumbnails .= '</a>';
						if ($proofingstatus=="active") {
						$thumbnails .= '<a class="column-gridblock-icon mtheme-proofing-choice mtheme-proofing-'.$proof_edit_enabled.'" data-image_id="'.$attachment_id.'" rel="bookmark" title="'.get_the_title().'">';
							$thumbnails .= '<span class="hover-icon-effect"><i class="proofing-icon-status '.$proofing_icon.'"></i></span>';
						$thumbnails .= '</a>';
						}

							if ($boxtitle=="true") {
								$thumbnails .= '<span class="boxtitle-hover">';
								$thumbnails .= '<a href="'.get_permalink().'" rel="bookmark" title="'. $imageTitle .'">';
								$thumbnails .= $imageTitle;
								$thumbnails .= '</a>';
								$thumbnails .= '</span>';
							}

						$thumbnails .= '</div>';
					$thumbnails .= '</div>';

			$thumbnails .= '<img class="preload-image displayed-image" src="'.$thumbnail_imagearray[0].'" alt="'.mtheme_get_alt_text($featuredID).'">';
			
			$thumbnails .=  '</div>';
			if ($title=="true" || $description=="true") {
				$portfoliogrid ='<div class="work-details">';
					if ($title=='true') {
						$portfoliogrid .= '<h4>';
						switch ($proofing_choice_title) {
							case 'default':
								$portfoliogrid .= '#'. $attachment_id;
								break;
							case 'filename':
								$portfoliogrid .= basename( get_attached_file( $attachment_id ) );
								break;
							case 'imagetitle':
								$portfoliogrid .= $imageTitle;
								break;
							
							default:
								$portfoliogrid .= '#'. $attachment_id;
								break;
						}
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
add_shortcode("proofing_gallery", "mtheme_Proofing");
?>