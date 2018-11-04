<?php
/**
 * Flexi Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_FelxiSlideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"pageid" => '',
		"hovericon"=> false,
		"hovertype"=> 'ajax',
		"transition" => 'fade',
		"imagesize" => 'fullwidth',
		"height" => '434',
		"width" => '650',
		"slideshowtitle" => false,
		"lightbox" => false,
		"lboxtitle" => false
	), $atts));
	
	//echo $type, $portfolio_type;
	$thepageID=get_the_id();
	if ($pageid<>'') $thepageID=$pageid;
	$count=1;

	$flexID = "ID" . dechex(time()).dechex(mt_rand(1,65535));
	$uniqurePageID=get_the_id()."-".dechex(mt_rand(1,65535));

	$filter_image_ids = mtheme_get_custom_attachments ( $thepageID );						
	if ( $filter_image_ids ) 
	{
	$output = '
	<div class="spaced-wrap clearfix">
		<div class="flexslider-loader"></div>
		<div class="flexslider-container-page flexislider-container-'.$flexID.' ">
			<div id="flex'.$flexID.'" class="flexslider">
			<ul class="slides">';
			foreach ( $filter_image_ids as $attachment_id) {
			$imagearray = wp_get_attachment_image_src( $attachment_id , $imagesize, false);
			$imageURI = $imagearray[0];
			$imageID = get_post($attachment_id);
			$imageTitle = $imageID->post_title;
			$imageCaption = $imageID->post_excerpt;
			$fullimagearray = wp_get_attachment_image_src( $attachment_id , '', false);
			$fullimageURI = $fullimagearray[0];
			$lightboxTitle="";
			$output .= '<li>';
			if ($lboxtitle=='true') $lightboxTitle = 'title="'.$imageTitle.'" ';
			if ($lightbox=='true') {
				$output .= '<a class="gridblock-image-link flexislideshow-link" '. $lightboxTitle .'data-lightbox="magnific-image-gallery" href="'.$fullimageURI.'">';
			}
			if ($hovericon=='true') {
				$hovercolumn="ajax";
				if ($hovertype=="portfolio") $hovercolumn="column";
				$output .= '<span class="'.$hovertype.'-image-hover"><span class="hover-icon-effect '.$hovercolumn.'-gridblock-icon"><i class="icon-search"></i></span></span>';
				$count++;
				$output .= '<span class="gridblock-background-hover"></span>';
			}
					$output .= mtheme_showimage (
						$imageURI,
						$link="",
						$resize=false,
						$height,
						$width,
						$quality=MTHEME_IMAGE_QUALITY,
						$crop=1,
						$alt_text = mtheme_get_alt_text( $attachment_id ),
						$class="displayed-image"
						);
			if ($lightbox=='true') $output .= '</a>';
			if ( $slideshowtitle=='true' && $imageTitle != '' ) $output .= '<div class="sc_slideshowtitle">'.$imageTitle.'</div>';
			if ($lightbox=='true') {
				$output .= '<div class="lightbox-toggle"><a class="gridblock-image-link flexislideshow-link" '. $lightboxTitle .'data-lightbox="magnific-image-gallery" href="'.$fullimageURI.'">';
					$output .= '<i class="feather-icon-maximize"></i>';
				$output .= '</a></div>';
			}
			$output .='</li>';
			}
		$output .='</ul></div></div></div>';
		$output .='
<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery("#flex'.$flexID.'").flexslider({
			animation: "'.$transition.'",
			slideshow: false,
			prevText: "",
			nextText: "",
			pauseOnAction: true,
			pauseOnHover: true,
			smoothHeight: true,
			controlsContainer: "flexslider-container-'.$flexID.'",
			start: function(){
				jQuery(".flexslider-loader").slideUp("fast");
			}
		});
	});
</script>
';
	return $output;
	}	
}
add_shortcode("flexislideshow", "mtheme_FelxiSlideshow");


/**
 * AJAX Flexi Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_AJAXFelxiSlideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"pageid" => '1',
		"lightbox" => 'true',
		"lboxtitle" => 'true',
		"crop" => 'true',
		"height" => '434',
		"width" => '1020',
		"type" => 'Fill',
		"resize" => true,
		"title" => 'false'
	), $atts));
	$withplus=$width+20;
	$resize_image=false;
	if ($resize=="true") { $resize_image=true; }
	$quality=MTHEME_IMAGE_QUALITY;
	$link_end="";
	$lightbox_link="";
	$crop_image= " ,imageCrop: false";
	$lightbox_link = " ,lightbox: false";
	$portfolio_type= " ,lightbox: false ,imageCrop: true";
	
	if ($type=="Normal") $portfolio_type= " ,lightbox: false ,imageCrop: false";
	if ($type=="Fill") $portfolio_type= " ,lightbox: false ,imageCrop: true";
	if ($type=="Normal-plus-Lightbox") $portfolio_type= " ,lightbox: true ,imageCrop: false";
	if ($type=="Fill-plus-Lightbox") $portfolio_type= " ,lightbox: true ,imageCrop: true";
	
	//echo $type, $portfolio_type;
	//global $mtheme_thepostID;

	$flexID = "ID" . dechex(time()).dechex(mt_rand(1,65535));
	$filter_image_ids = mtheme_get_custom_attachments ( $pageid );						
	if ( $filter_image_ids ) 
	{
	$output = '
	<div class="spaced-wrap clearfix">
		<div class="flexslider-container-page flexislider-container1">
			<div id="flex1" class="flexslider">
			<ul class="slides">';
			foreach ( $filter_image_ids as $attachment_id) {
			$imagearray = wp_get_attachment_image_src( $attachment_id , 'gridblock-full', false);
			$imageURI = $imagearray[0];
			$imageID = get_post($attachment_id);
			$imageTitle = $imageID->post_title;
			$imageCaption = $imageID->post_excerpt;

			$fullimagearray = wp_get_attachment_image_src( $attachment_id , '', false);
			$fullimageURI = $fullimagearray[0];

			if ($title=="false") { $imageTitle=""; }
			$output .= '<li>';

					$output .= mtheme_showimage (
						$imageURI,
						$link="",
						$resize=false,
						$height,
						$width,
						$quality=MTHEME_IMAGE_QUALITY, 
						$crop=1,
						$alt_text = mtheme_get_alt_text( $attachment_id ),
						$class=""
						);
			if ($lightbox=='true') {
				if ($lboxtitle=='true') $lightboxTitle = 'title="'.$imageTitle.'" ';
				$output .= '<div class="lightbox-toggle"><a class="gridblock-image-link flexislideshow-link" '. $lightboxTitle .'data-lightbox="magnific-image-gallery" href="'.$fullimageURI.'">';
					$output .= '<i class="feather-icon-maximize"></i>';
				$output .= '</a></div>';
			}
			
			$output .='</li>';
			}
		$output .='</ul></div></div></div>';
	return $output;
	}	
}
add_shortcode("ajaxflexislideshow", "mtheme_AJAXFelxiSlideshow");

/**
 * AJAX Flexi Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_Verticalimages($atts, $content = null) {
	extract(shortcode_atts(array(
		"pageid" => '',
		"dpage" => 'sdfdsf',
		"height" =>'',
		"animation" =>'true',
		"width" =>'',
		"imagesize" => 'gridblock-full-medium'
	), $atts));

	$filter_image_ids = mtheme_get_custom_attachments ( $pageid );

	$uniqurePageID = dechex(mt_rand(1,65535));

	if ( $filter_image_ids ) 
	{
	$output = '
			<ul class="vertical_images clearfix">';
			foreach ( $filter_image_ids as $attachment_id) {
			$imagearray = wp_get_attachment_image_src( $attachment_id , $imagesize, false);
			$imageURI = $imagearray[0];
			$imageID = get_post($attachment_id);
			$imageTitle="";
			if (isSet($imageID->post_title)) {
				$imageTitle = $imageID->post_title;
			}
			$imageCaption="";
			if (isSet($imageID->post_excerpt)) {
				$imageCaption = $imageID->post_excerpt;
			}
			$fullimagearray = wp_get_attachment_image_src( $attachment_id , '', false);
			$fullimageURI = $fullimagearray[0];

			if ($animation=="true") {
				$animation_classes = ' animation-standby animated fadeIn';
			} else {
				$animation_classes = '';
			}

			$output .= '<li class="'.$animation_classes.'">';

			$output .= '<a class="vertical-images-link" title="'.$imageTitle.'" data-lightbox="magnific-image-gallery" href="'.$fullimageURI.'">';
					$output .= mtheme_showimage (
						$imageURI,
						$link="",
						$resize=false,
						$height,
						$width,
						$quality=MTHEME_IMAGE_QUALITY, 
						$crop=1,
						$alt_text = mtheme_get_alt_text( $attachment_id ),
						$class=""
						);

			$output .= '</a>';

			if ($imageTitle<>"") {
				$output .= '<div class="vertical-images-title-wrap">';
				$output .= '<div class="vertical-images-title">'.$imageTitle.'</div>';
				$output .= '</div>';
			}
			$output .='</li>';
			}
		$output .='</ul>';
	return $output;
	}	
}
add_shortcode("vertical_images", "mtheme_Verticalimages");


/**
 * Blog Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_BlogSlideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"cat_slug" => '',
		"autoplay" => 'false',
		"transition" => 'fade',
		"limit" => ''
	), $atts));
	
	//echo $type, $portfolio_type;
	query_posts(array(
		'category_name' => $cat_slug,
		'posts_per_page' => $limit
		));

	$uniqureID=get_the_id()."-".uniqid();

	$portfolioImage_type="gridblock-full";

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap clearfix">';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			if ( has_post_thumbnail() ) {
				$output .= '<li class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				$lightbox_image = mtheme_featured_image_link( get_the_id() );

				$lightbox_media = $lightbox_image;

				$custom = get_post_custom(get_the_ID());

				if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { 
					$lightbox_media=$custom[MTHEME . '_lightbox_video'][0];
				}
				
				$output .= '<a class="gridblock-image-link flexislideshow-link"' .' title="'.get_the_title().'" data-lightbox="magnific-image-gallery" href="'.$lightbox_media.'">';

				$output .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$theimage_type=$portfolioImage_type,
					$imagetitle='',
					$class="displayed-image"
				);
				$output .= '</a>';
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<div class="slideshow-box-title"><a href="'.get_permalink().'">'.get_the_title().'</a></div>';

				$output .= '<div class="slideshow-box-info">';
					$output .='<div class="slideshow-box-categories">';
					foreach((get_the_category()) as $category) { 
					    $output .= '<span>'.$category->cat_name.'</span>';
					} 
					$output .='</div>';
					$category = get_the_category();
					$output .= '<div class="slideshow-box-comment">';

					$num_comments = get_comments_number( get_the_id() ); // get_comments_number returns only a numeric value
					if ( comments_open() ) {
						if ( $num_comments == 0 ) {
							$comments_desc = __('0 <i class="feather-icon-speech-bubble"></i>');
						} elseif ( $num_comments > 1 ) {
							$comments_desc = $num_comments . __(' <i class="feather-icon-speech-bubble"></i>');
						} else {
							$comments_desc = __('1 <i class="feather-icon-speech-bubble"></i>');
						}
						$output .= '<a href="' . get_comments_link( get_the_id() ) .'">'. $comments_desc.'</a>';
					}
					$output .='</div>';
					$output .='<div class="slideshow-box-date"><i class="feather-icon-clock"></i> '.get_the_date('jS M y').'</div>';
				$output .='</div>';

				$output .= '</div>';
				$output .= '</div>';
				$output .='</li>';
			}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.$uniqureID.'");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '.$autoplay.',
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
add_shortcode("recent_blog_slideshow", "mtheme_BlogSlideshow");


/**
 * Portfolio Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_PortfolioSlideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"worktype_slugs" => '',
		"autoplay" => 'false',
		"transition" => 'fade'
	), $atts));

	if ($limit=='') {
		$limit="-1";
	}
	
	//echo $type, $portfolio_type;
	$countquery = array(
		'post_type' => 'mtheme_portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'types' => $worktype_slugs,
		'posts_per_page' => $limit,
		);
	query_posts($countquery);

	$portfolioImage_type="gridblock-full";


	$uniqureID=get_the_id()."-".uniqid();

	if ($autoplay <> "true") {
		$autoplay="false";
	}
	$output = '<div class="gridblock-owlcarousel-wrap clearfix">';
	$output .= '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';
	
			if (have_posts()) : while (have_posts()) : the_post();

			if ( has_post_thumbnail() ) {
				$output .= '<li class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';

				$lightbox_image = mtheme_featured_image_link( get_the_id() );

				$lightbox_media = $lightbox_image;

				$custom = get_post_custom(get_the_ID());

				if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { 
					$lightbox_media=$custom[MTHEME . '_lightbox_video'][0];
				}
				
				$output .= '<a class="gridblock-image-link flexislideshow-link"' .' title="'.get_the_title().'" data-lightbox="magnific-image-gallery" href="'.$lightbox_media.'">';

				$image_id = get_post_thumbnail_id( get_the_ID() , $portfolioImage_type); 
				$image_url = wp_get_attachment_image_src($image_id,$portfolioImage_type);  
				$image_url = $image_url[0];
				$img_obj = get_post($image_id);
				$img_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

				$output .= '<img data-src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $img_alt ) .'" class="displayed-image lazyOwl"/>';

				$output .= '</a>';
				$output .= '</div>';
				$output .= '<div class="slideshow-box-content"><div class="slideshow-box-content-inner">';
				$output .= '<div class="slideshow-box-title"><a href="'.get_permalink().'">'.get_the_title().'</a></div>';

			$output .= '<div class="slideshow-box-info">';
				$output .='<div class="slideshow-box-categories">';
				$categories = get_the_term_list( get_the_id(), 'types', '', ' / ', '' );
				    $output .= '<span>'.$categories.'</span>';
				$output .='</div>';
			$output .='</div>';

				$output .= '</div></div>';
				$output .='</li>';
			}

			endwhile; endif;
	$output .='</div>';
	$output .='</div>';

	$output .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.$uniqureID.'");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '.$autoplay.',
		     slideSpeed: 1000,
		     lazyLoad : true,
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
add_shortcode("recent_portfolio_slideshow", "mtheme_PortfolioSlideshow");

//Recent Works Carousel
function mtheme_imageslideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"windowtype" => '',
		"pageid" => '',
		"imagesize" => 'gridblock-full',
		"pb_image_ids" => '',
		"autoplay" => 'false',
		"thumbnails" => 'true',
		"lightbox" => 'true',
		"format" => '',
		"carousel_type" => 'owl',
		"columns" => '4',
		"limit" => '-1',
		"displaytitle" => 'false',
		"desc" => 'true',
		"boxtitle" => 'true',
		"worktype_slug" => '',
		"pagination" => 'false'
	), $atts));

$uniqureID=get_the_id()."-".uniqid();

if ($windowtype=="ajax") {
	$uniqureID = "ajax";
}
if ($autoplay <> "true") {
	$autoplay="false";
}
$column_type="four";
$portfolioImage_type=$imagesize;
$portfolioImage_type2="gridblock-tiny";

if ($worktype_slug=="-1") { $worktype_slug=''; }
$portfolio_count=0;
$flag_new_row=true;
$portfoliogrid='';
$portfoliogrid2='';

if ($carousel_type=="owl") {

	$portfoliogrid_line1 = '<div class="gridblock-owlcarousel-wrap clearfix">';
	$portfoliogrid_line2 = '<div id="owl-'.$uniqureID.'" class="owl-carousel owl-slideshow-element">';

	$portfoliogrid2_line1 = '<div class="gridblock-owlcarousel-wrap clearfix">';
	$portfoliogrid2_line2 = '<div id="owl-'.$uniqureID.'-2" class="owl-carousel owl-thumbnail-element">';
	
	if (trim($pb_image_ids)<>'' ) {
		$filter_image_ids = explode(',', $pb_image_ids);
	} else {
		if ( !isSet($pageid) || empty($pageid) || $pageid=='' ) {
			$pageid = get_the_id();
		}
		$filter_image_ids = mtheme_get_custom_attachments ( $pageid );
	}

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
			
			$slideshow_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type, false);
			$slideshow_imageURI = $slideshow_imagearray[0];

			$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , $portfolioImage_type2, false);
			$thumbnail_imageURI = $thumbnail_imagearray[0];

			if ($portfolio_count==$columns) $portfolio_count=0;

			if ( isSet($slideshow_imageURI) && !empty( $slideshow_imageURI ) ) {

				$imageID = get_post($attachment_id);
				$imageTitle = $imageID->post_title;
				$imageDesc= $imageID->post_content;

				$protected="";
				$icon_class="column-gridblock-icon";
				$portfolio_count++;
				$portfoliogrid .= '<div class="gridblock-slideshow-element">';

				// Large image sequence
				if ($lightbox=="true") {
				$portfoliogrid .= mtheme_activate_lightbox (
					$lightbox_type="magnific",
					$ID=get_the_ID(),
					$link=$imageURI,
					$mediatype="video",
					$imagetitle=$imageTitle,
					$class="slideshow-lightbox",
					$navigation="magnific-image-gallery"
					);
				}

					$portfoliogrid .= mtheme_display_post_image (
						$attachment_id,
						$have_image_url=$slideshow_imageURI,
						$link=false,
						$type=$portfolioImage_type,
						$imagetitle=$imageTitle,
						$class="owl-slide-image"
					);
				if ($lightbox=="true") {
					$portfoliogrid .= '</a>';
				}
					if ($displaytitle=='true') {
						$portfoliogrid .= '<div class="slideshow-owl-title">'.$imageTitle.'</div>';
					}

				$portfoliogrid .='</div>';

				// Thumbnails sequence
				if ( $thumbnails == 'true' ) {
					$portfoliogrid2 .= '<div class="gridblock-thumbnail-element">';

					$portfoliogrid2 .= mtheme_display_post_image (
						$attachment_id,
						$have_image_url=$thumbnail_imageURI,
						$link=false,
						$type=$portfolioImage_type2,
						$imagetitle=$imageTitle,
						$class="owl-thumbnail"
					);
					$portfoliogrid2 .='</div>';
				}

			}

		}
	}
	$portfoliogrid .='</div>';
	$portfoliogrid .='</div>';

	$portfoliogrid2 .='</div>';
	$portfoliogrid2 .='</div>';

	$portfoliogrid_script ='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		 var sync1 = $("#owl-'.$uniqureID.'");
		 var sync2 = $("#owl-'.$uniqureID.'-2");

		 sync1.owlCarousel({
		     singleItem: true,
		     autoPlay: '.$autoplay.',
		     slideSpeed: 1000,
		     navigation: true,
		     autoHeight: true,
		     pagination: false,
		     transitionStyle : "fade",
		     ';
		     if ( $thumbnails == 'true' ) {
		     	$portfoliogrid_script .= 'afterAction: syncPosition,';
		 	 }
		     $portfoliogrid_script .= 'navigationText : ["",""],
		     responsiveRefreshRate: 200,
		 });';

	if ( $thumbnails == 'true' ) {
		$portfoliogrid_script .= '
		 sync2.owlCarousel({
		     items: 15,
		     itemsDesktop: [1199, 10],
		     itemsDesktopSmall: [979, 10],
		     itemsTablet: [768, 8],
		     itemsMobile: [479, 4],
		     pagination: false,
		     responsiveRefreshRate: 100,
		     afterInit: function(el) {
		         el.find(".owl-item").eq(0).addClass("synced");
		     }
		 });

		 function syncPosition(el) {
		     var current = this.currentItem;
		     $("#owl-'.$uniqureID.'-2")
		         .find(".owl-item")
		         .removeClass("synced")
		         .eq(current)
		         .addClass("synced")
		     if ($("#owl-'.$uniqureID.'-2").data("owlCarousel") !== undefined) {
		         center(current)
		     }
		 }

		 $("#owl-'.$uniqureID.'-2").on("click", ".owl-item", function(e) {
		     e.preventDefault();
		     var number = $(this).data("owlItem");
		     sync1.trigger("owl.goTo", number);
		 });

		 function center(number) {
		     var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		     var num = number;
		     var found = false;
		     for (var i in sync2visible) {
		         if (num === sync2visible[i]) {
		             var found = true;
		         }
		     }

		     if (found === false) {
		         if (num > sync2visible[sync2visible.length - 1]) {
		             sync2.trigger("owl.goTo", num - sync2visible.length + 2)
		         } else {
		             if (num - 1 === -1) {
		                 num = 0;
		             }
		             sync2.trigger("owl.goTo", num);
		         }
		     } else if (num === sync2visible[sync2visible.length - 1]) {
		         sync2.trigger("owl.goTo", sync2visible[1])
		     } else if (num === sync2visible[0]) {
		         sync2.trigger("owl.goTo", num - 1)
		     }
		 }';
	}
	$portfoliogrid_script .= '
	})
	})(jQuery);
	/* ]]> */
	</script>
	';

	$portfoliogrid2_script = '';
	if ( $thumbnails == 'true' ) {
		$portfoliogrid2_script ='
		<script>
		/* <![CDATA[ */
		(function($){
		$(window).load(function(){
			$("#owl-'.$uniqureID.'-2").owlCarousel({
				itemsCustom : [
					[0, 2],
					[500, 2],
					[700, 3],
					[1024, 4]
				],
				items: 4,
				navigation : false,
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

	if ($windowtype=="ajax") {
		$portfoliogrid_script='';
	}

	$slideshow_1 = $portfoliogrid_line1 . $portfoliogrid_line2 . $portfoliogrid;
	$slideshow_2 = $portfoliogrid2_line1 . $portfoliogrid2_line2 . $portfoliogrid2 . $portfoliogrid_script;

	return $slideshow_1 . $slideshow_2;
}
add_shortcode("slideshowcarousel", "mtheme_imageslideshow");

//Recent Works Carousel
function mtheme_fotorama($atts, $content = null) {
	extract(shortcode_atts(array(
		"filltype" => 'cover',
		"transition" => 'crossfade',
		"autoplay" => 'true',
		"hash" => 'false',
		"pagetitle" => "false",
		"titledesc" => "enable",
		"titles" => "enable",
		"pageid" => '',
		"pb_image_ids" => '',
		"thumbnails" => 'true',
		"format" => '',
		"carousel_type" => 'owl',
		"columns" => '4',
		"limit" => '-1',
		"displaytitle" => 'false',
		"desc" => 'true',
		"boxtitle" => 'true',
		"worktype_slug" => '',
		"pagination" => 'false'
	), $atts));

$uniqureID=get_the_id()."-".uniqid();
$column_type="four";
$portfolioImage_type="gridblock-full";
$portfolioImage_type2="gridblock-large";

if ($worktype_slug=="-1") { $worktype_slug=''; }
$portfolio_count=0;
$flag_new_row=true;
$portfoliogrid='';
$portfoliogrid2='';


$fotorama = '<div class="mtheme-fotorama">';
$fotorama .= '<div class="fotorama"
 data-fit="'.$filltype.'"
 data-nav="thumbs"
 data-loop="true"
 data-keyboard="true"
 data-hash="'.$hash.'"
 data-transition="'.$transition.'"
 data-transition-duration="1000"
 data-autoplay="'.$autoplay.'"
 data-auto="false"
 >';
	
	if (trim($pb_image_ids)<>'' ) {
		$filter_image_ids = explode(',', $pb_image_ids);
	} else {
		if ( !isSet($pageid) || empty($pageid) || $pageid=='' ) {
			$pageid = get_the_id();
		}
		$filter_image_ids = mtheme_get_custom_attachments ( $pageid );
	}

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

			$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , 'gridblock-tiny', false);
			$thumbnail_imageURI = $thumbnail_imagearray[0];

			if ( isSet($imageURI) && !empty( $imageURI ) ) {

				$imageID = get_post($attachment_id);
				$imageTitle = $imageID->post_title;
				$imageDesc= $imageID->post_content;
				if ($titles<>"enable") {
					$imageTitle='';
				}
				$displaypagetitle='';
				if ($pagetitle=="true") {
					$displaypagetitle= '<h1>'.get_the_title().'</h1>';
				}

				$title_desc='';
				if ($titledesc=="enable") {
					$title_desc = 'data-caption="'.$displaypagetitle.'<h2>'.$imageTitle.'</h2><p>'.esc_html($imageDesc).'</p>" ';
				}

				$fotorama .= '<a '.$title_desc.'href="'.$imageURI.'">';
				$fotorama .= '<img src="'.esc_url($thumbnail_imageURI).'" alt="'.esc_attr($imageTitle).'" />';
				$fotorama .= '</a>';
			}

		}
	}
	
	$fotorama .='</div>';
	$fotorama .='</div>';

	return $fotorama;
}
add_shortcode("fotorama", "mtheme_fotorama");
?>