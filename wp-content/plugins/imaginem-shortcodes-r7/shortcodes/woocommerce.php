<?php
/**
 * WooCommerce Featured Slideshow .
 *
 * @ [flexislideshow link=(lightbox,direct,none)]
 */
function mtheme_woocommerce_featured_Slideshow($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => '-1',
		"cat_slug" => '',
		"transition" => 'fade',
		"limit" => ''
	), $atts));
	
	//echo $type, $portfolio_type;
	query_posts(array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'meta_key' => '_featured',
		'meta_value' => 'yes'
		));	

	$flexID = "ID" . dechex(time()).dechex(mt_rand(1,65535));
	$uniqurePageID=get_the_id()."-".dechex(mt_rand(1,65535));
						
	$portfolioImage_type = "blog-full";
	$output = '
	<div class="spaced-wrap woocommerce-slideshow clearfix">
		<div class="flexslider-container-page flexislider-container-'.$flexID.' clearfix">
			<div id="flex'.$flexID.'" class="flexslider">
			<ul class="slides">';

			if (have_posts()) : while (have_posts()) : the_post();

			if ( has_post_thumbnail() ) {
				$output .= '<li class="slideshow-box-wrapper">';
				$output .= '<div class="slideshow-box-image">';
				$output .= mtheme_display_post_image (
					get_the_ID(),
					$have_image_url="",
					$link=false,
					$theimage_type=$portfolioImage_type,
					$imagetitle='',
					$class="preload-image displayed-image"
				);
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
			ob_start();
			woocommerce_get_template('loop/price.php');
			$price = ob_get_contents();
			ob_end_clean();
			$output .='<div class="slideshow-box-date">'.$price.'</div>';
			$output .='</div>';

				$output .= '</div></div>';
				$output .='</li>';
			}

			endwhile; endif;

		$output .='</ul></div></div><div class="clear"></div></div>';
		$output .='
<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery("#flex'.$flexID.'").flexslider({
			animation: "'.$transition.'",
			slideshow: true,
			pauseOnAction: true,
			pauseOnHover: true,
			smoothHeight: true,
			controlsContainer: "flexslider-container-'.$flexID.'",
			start: function(){
				jQuery(".flexslider-container-page,.gridblock-element .ajax-image-block").css("background","none");
			},
		});
	});
</script>
';
	wp_reset_query();
	return $output;
}
add_shortcode("woocommerce_featured_slideshow", "mtheme_woocommerce_featured_Slideshow");

// Woo Best Selling
add_shortcode('woocommerce_carousel_bestselling', 'mtheme_woocommerce_bestselling_slideshow');
function mtheme_woocommerce_bestselling_slideshow($atts, $content) {
	extract(shortcode_atts(array(
		'limit' => '5'
	), $atts));

    $args = array(
        'post_type' => 'product',
		'post_status' => 'publish',
		'ignore_sticky_posts'   => 1,
		'posts_per_page' => $limit,
		'meta_key' 		=> 'total_sales',
		'orderby' 		=> 'meta_value'
    );

	$uniqueID=get_the_id()."-".dechex(mt_rand(1,65535));

	ob_start();
	?>
	<div class="shortcode-woo-carousel-group woocommerce clearfix">
	<ul id="shortcode-woo-carousel-owl-<?php echo $uniqueID; ?>" class="products owl-carousel">
	    <?php
	    $products = new WP_Query( $args );
	    
	    if ( $products->have_posts() ) : ?>
	                
	        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
	    
	            <?php woocommerce_get_template_part( 'content', 'product' ); ?>

	        <?php endwhile; // end of the loop. ?>
	        
	    <?php
	    
	    endif; 
	    //wp_reset_query();
	    wp_reset_postdata();
	    ?>
	</ul>
	</div>
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		$("#shortcode-woo-carousel-owl-<?php echo $uniqueID; ?>").owlCarousel({
			itemsCustom : [
				[0, 1],
				[700, 2],
				[1024, 3]
			],
			items: 3,
			navigation : true,
			navigationText : ["",""],
			scrollPerPage : true,
			pagination: true,
			autoPlay: false
		});
	})
	})(jQuery);
	/* ]]> */
	</script>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
?>