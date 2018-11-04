<?php
function mtheme_theme_Socials( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"social_icon" => '',
		"social_link" => '',
		"social_text" => '',
		"social_color" => '',
		"align" => 'false'
	), $atts));

	if ($align =="false" ) {
		// Initially built for staff shortcode. For individual use it will have to have the align variable set.
		$socials = '<li><a class="ntips" title="'.$social_text.'" href="'.$social_link.'"><i class="'.$social_icon.'"></i></a></li>';
	} else {
		$socials = '<div class="social-shortcode align-'.$align.' social-margin-'.$align.'"><a class="ntips" title="'.$social_text.'" href="'.$social_link.'"><i style="color:'.$social_color.'" class="'.$social_icon.'"></i></a></div>';
	}
	return $socials;
}
add_shortcode('socials', 'mtheme_theme_Socials');
//People
function mtheme_People( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"name" => '',
		"animated" => 'none',
		"image" => '',
		'imageid' => '',
		"title" => '',
		"desc" => ''
	), $atts));

if ( !empty($imageid)) {
	$image_array = wp_get_attachment_image_src($imageid,'gridblock-large-portrait',false);
	//print_r($image_array);
	$image_src = $image_array[0];
} else {
	$image_src=$image;
}

if ($animated != 'none') {
	$animated = 'animation-standby animated ' .$animated;
}

$personsocials = '<ul class="person-socials clearfix">';
$personsocials .= do_shortcode($content);
$personsocials .= '</ul>';

$persondescription='';
if ($desc<>"") {
	$persondescription = '<div class="person-desc">'. wpautop( html_entity_decode($desc) ).'</div>';
}

$person = '
<div class="person '.$animated.'">
	<div class="person-image-wrap">
			'.$personsocials.'
		<div class="person-image">
			<img src="'.esc_url($image_src).'" alt="'.esc_attr($name).'" title="'.esc_attr($name).'" />
		</div>
	</div>
	<div class="person-details">
	<h4 class="staff-position">'.$title.'</h4>
	<h3>'.$name.'</h3>
	'.$persondescription.'
	</div>
</div>';

   return $person;
}
add_shortcode('staff', 'mtheme_People');
// Testimonials
add_shortcode('testimonials', 'mtheme_Testimonials');
	function mtheme_Testimonials($atts, $content) {

		$id = "testimonial-id-".rand(0,1000);

		$qblock = '';
$qblock .= '
<div class="testimonials-wrap">
	<div id="'.$id.'" class="owl-carousel">
';
		$qblock .= do_shortcode($content);
		$qblock .= '
	</div>
</div>';
$qblock .='
<script>
/* <![CDATA[ */
(function($){
$(window).load(function(){
	$("#'.$id.'").owlCarousel({
		items: 1,
		singleItem : true,
		transitionStyle : "fade",
		navigation : false,
		navigationText : ["",""],
		scrollPerPage : false,
		pagination: true,
		autoPlay: true
	});
})
})(jQuery);
/* ]]> */
</script>';

		return $qblock;
	}
// The Saying
function mtheme_Testimonial($atts, $content) {
	extract(shortcode_atts(array(
		"quote" => '',
		"name" => '',
		"company" => '',
		"link" => '',
		"position" =>'',
		"image" => '',
		"imageid" => ''
	), $atts));

	if ( !empty($imageid)) {
		$image_array = wp_get_attachment_image_src($imageid,'gridblock-tiny',false);
		//print_r($image_array);
		$image_src = $image_array[0];
	} else {
		$image_src=$image;
	}

	$testimonial = '';
	$testimonial .= '<div>';
		$testimonial .= '<div class="testimonial-say">';
			$testimonial .= '<span class="client-say">';
			$testimonial .= wpautop( html_entity_decode($quote) );
			$testimonial .= '</span>';
			$testimonial .= '<div class="client-info">';
				$testimonial .= '<span class="client-name">';
				$testimonial .= $name;
				$testimonial .= '</span>';
				$testimonial .= '<span class="client-company">';
				$link=trim($link);
				if (!empty( $link )) { $testimonial .= '<a href="'.$link.'">'; }
				$testimonial .=  $company;
				if (!empty( $link )) { $testimonial .= '</a>'; }
				$testimonial .= '</span>';
			$testimonial .= '</div>';
			if ( $image_src !="" ) {
				$testimonial .= '<div class="client-details">';
				$testimonial .= '<img class="client-image" src="'.$image_src.'" alt="testimonial-image" />';
				$testimonial .= '</div>';
			}
		$testimonial .= '</div>';
	$testimonial .= '</div>';
	return $testimonial;
}
add_shortcode('testimonial', 'mtheme_Testimonial');

// Clients
//Obsolete
add_shortcode('clients', 'mtheme_Clients');
function mtheme_Clients($atts, $content) {
	extract(shortcode_atts(array(
		'column' => '5'
	), $atts));

	$clientbox = '<div class="client-column-'.$column.' clearfix">';
	$clientbox .= do_shortcode($content);
	$clientbox .= '</div>';

	return $clientbox;
}
// The Saying
function mtheme_Client($atts, $content) {
	extract(shortcode_atts(array(
		"logo" => '',
		"link" => '',
		"hovertitle" =>'',
		"last_item" => 'no'
	), $atts));

	$column_edge="client-item-space";
	if ($last_item=="yes") $column_edge="clearfix";
	$client = '<div class="client-item '.$column_edge.'">';
	if ( $link <>"" ) { $client .= '<a class="ntips" title="'.$hovertitle.'" href="'.$link.'" >'; }
	$client .= '<img src="' . $logo . '" alt="client" />';
	if ( $link <>"" ) { $client .= '</a>'; }
	$client .= '</div>';

	return $client;
}
add_shortcode('client', 'mtheme_Client');

// Display Logo Carousel
add_shortcode('carousel_group', 'mtheme_carousel_group');
function mtheme_carousel_group($atts, $content) {
	extract(shortcode_atts(array(
		'columns' => '5'
	), $atts));

	$uniqueID=get_the_id()."-".dechex(mt_rand(1,65535));

	$carousel_group = '<div class="shortcode-carousel-group clearfix">';
	$carousel_group .= '<div id="shortcode-carousel-owl-'.$uniqueID.'" class="owl-carousel">';
	$carousel_group .= do_shortcode($content);
	$carousel_group .= '</div>';
	$carousel_group .= '</div>';
	$carousel_group .='
	<script>
	/* <![CDATA[ */
	(function($){
	$(window).load(function(){
		$("#shortcode-carousel-owl-'.$uniqueID.'").owlCarousel({
			itemsCustom : [
				[0, 1],
				[700, 3],
				[1024, '.$columns.']
			],
			items: 5,
			navigation : false,
			navigationText : ["",""],
			scrollPerPage : false,
			pagination: false,
			autoPlay: 10000
		});
	})
	})(jQuery);
	/* ]]> */
	</script>
	';

	return $carousel_group;
}
// The Saying
function mtheme_carousel_item($atts, $content) {
	extract(shortcode_atts(array(
		"image" => '',
		"link" => '',
		'name' => ''
	), $atts));

	$carousel_item = '<div class="shortcode-carousel-item">';
	if ( trim($link) != "" ) { $carousel_item .= '<a href="'.esc_url($link).'" >'; }
	$carousel_item .= '<img src="' . esc_url($image) . '" alt="'.$name.'" class="stips" title="'.$name.'" />';
	if ( trim($link) <>"" ) { $carousel_item .= '</a>'; }
	$carousel_item .= '</div>';

	return $carousel_item;
}
add_shortcode('carousel_item', 'mtheme_carousel_item');
?>