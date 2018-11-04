<?php
/**
 * Photowall
 */
get_header();
$featured_page = mtheme_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$count=0;
$custom = get_post_custom($featured_page);
$slideshow_titledesc="enable";
if (isSet($custom[MTHEME . "_photowall_type"][0])) $photowall_type=$custom[MTHEME . "_photowall_type"][0];
if (isSet($custom[MTHEME . "_slideshow_titledesc"][0])) $slideshow_titledesc=$custom[MTHEME . "_slideshow_titledesc"][0];
if (isSet($custom[MTHEME . "_photowall_workstypes"][0])) {
	$worktype_slugs=$custom[MTHEME . "_photowall_workstypes"][0];
	} else {
		$worktype_slugs="";
	}
$limit=-1;
?>
<?php
if ( post_password_required() ) {
	$default_bg= of_get_option('general_passwordprotected_image');
	if ($default_bg=="") {
		$default_bg = of_get_option('general_background_image');
	}
	if ($default_bg<>"") {
		mtheme_fill_background_image($default_bg);
	}
	get_template_part( 'password', 'box' );
	} else {
?>
<div class="photowall-preload circular-preloader"></div>
<div class="photowall-wrap">
<div id="photowall-container">
<?php
$animation_class='';
// Don't Populate list if no Featured page is set
if ( $featured_page <>"" ) { 
	if ($photowall_type=="portfolio") {

		$count=0;
		$terms=array();
		$work_slug_array=array();
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

		if (have_posts()) : while (have_posts()) : the_post();

			$custom = get_post_custom(get_the_ID());
			if ( isset($custom[MTHEME . '_thumbnail_linktype'][0]) ) { $portfolio_link_type=$custom[MTHEME . '_thumbnail_linktype'][0]; }
			if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { $lightboxvideo=$custom[MTHEME . '_lightbox_video'][0]; }
			if ( isset($custom[MTHEME . '_customthumbnail'][0]) ) { $thumbnail=$custom[MTHEME . '_customthumbnail'][0]; }
			if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { $description=$custom[MTHEME . '_thumbnail_desc'][0]; }
			if ( isset($custom[MTHEME . '_customlink'][0]) ) { $customlink_URL=$custom[MTHEME . '_customlink'][0]; }
			if ( isset($custom[MTHEME . '_portfoliotype'][0]) ) { $portfolio_thumb_header=$custom[MTHEME . '_portfoliotype'][0]; }

			$imageTitle= get_the_title();
			if ($description) $slideshow_caption= $description;

			echo '<div class="photowall-item">';
			if ( $portfolio_link_type == "Customlink" ) {
				echo '<a href="'.$customlink_URL.'" title="'.get_the_title().'">';
			} else {
				echo '<a href="'.get_permalink().'" title="'.get_the_title().'">';
			}
				// Slideshow then generate slideshow shortcode

			//if Password Required
			if ( post_password_required() ) {
				$protected=" gridblock-protected"; $iconclass="";
				echo '<span class="grid-blank-status"><i class="feather-icon-lock"></i></span>';
				echo '<div class="gridblock-protected"><img src="'.MTHEME_PATH.'/images/icons/blank-grid.png" /></div>';
			} else {
				echo mtheme_display_post_image (
						get_the_ID(),
						$have_image_url="",
						$link=false,
						$type="gridblock-full-medium",
						get_the_title(),
						$class="photowall-image"
					);
			}

			if ($slideshow_titledesc=="enable") {
				echo '<div class="photowall-content-wrap">';
				echo '<div class="photowall-box">';				
				if ($imageTitle || $description) {
					if ($imageTitle) {
						echo '<div class="photowall-title">' . $imageTitle . '</div>';
					}
					if ($description) {
						echo '<div class="photowall-desc">' . $description . '</div>';
					}
				}
				echo '</div>';
				echo '</div>';
			}
			echo '</a>';
			echo '</div>';

		endwhile; endif;

		wp_reset_query();

	} else {
		
		$filter_image_ids = mtheme_get_custom_attachments ( $featured_page );
		if ($filter_image_ids) {
			foreach ( $filter_image_ids as $attachment_id) {

				$attachment = get_post( $attachment_id );
				$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
				$caption = $attachment->post_excerpt;
				//$href = get_permalink( $attachment->ID ),
				$imageURI = $attachment->guid;

				$thumb_imagearray = wp_get_attachment_image_src( $attachment->ID , 'gridblock-full-medium', false);
				$thumb_imageURI = $thumb_imagearray[0];

				$imageTitle = apply_filters('the_title',$attachment->post_title);
				$imageDesc = apply_filters('the_content',$attachment->post_content);
				// Count
				$count++;

				$slideshow_title="";
				$slideshow_caption="";
				
				//Find and replace all new lines to BR tags
				$find   = array("\r\n", "\n", "\r");
				$replace = '<br />';
				$imageDesc = str_replace($find, $replace , $imageDesc);
				
				if ($imageTitle) $slideshow_title='<div class="slideshow_title">'. esc_attr($imageTitle) .'</div>';
				if ($imageDesc) $slideshow_caption='<div class="slideshow_caption">'. $imageDesc .'</div>';

				echo '<div class="photowall-item '.$animation_class.'">';
				echo '<div class="photowall-item-inner">';	
				echo '<a title="'.$imageTitle.'" data-lightbox="magnific-image-gallery" href="'.$imageURI.'">';
				echo mtheme_display_post_image (
					$post->ID,
					$have_image_url = $thumb_imageURI,
					$link =false,
					$type = "gridblock-full",
					$title = $post->post_title,
					$class="photowall-image",
					$navigation=false
				);
					if ($slideshow_titledesc=="enable") {
						echo '<div class="photowall-content-wrap">';
						echo '<div class="photowall-box">';
						if ( $imageTitle || $imageDesc ) {

							if ($imageTitle) {
								echo '<div class="photowall-title">' . $imageTitle . '</div>';
							}
							if ($imageDesc) {
								echo '<div class="photowall-desc">' . $imageDesc . '</div>';
							}
						}
						echo '</div>';
						echo '</div>';
					}

				echo '</a>';
				echo '</div>';
				echo '</div>';
			}
		}
		// If Ends here for the Featured Page
	}
}
?>
</div>
</div>
<?php
//End of Password Check
}
?>
<?php get_footer(); ?>