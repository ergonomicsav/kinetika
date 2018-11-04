<?php
function mtheme_shortcodefunction_hex_to_rgb($color)
{
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}
function mtheme_fullpage( $atts, $content = null ) {
   extract( shortcode_atts( array(
   		'id' => '',
   		'class' => '',
		'border_style' => 'none',
		'border_width' => '1',
		'border_color' => '#eeeeee',
		'background_image' => '',
		'background_color' => '',
		'top' =>'',
		'text_align' => 'center',
		'bottom' => '',
		'textcolor' => ''
      ), $atts ) );

	global $fullblockid;
	if (!isSet($fullblockid)) {
		$fullblockid=1;
	} else {
		$fullblockid++;
	}
	if ($id !='' ) {
		$display_id = $id;
	} else {
		$display_id = get_the_id() . '-' . $fullblockid;
	}

	$fullpage='';
	$textclass='';
   	if ($textcolor=="bright") { $textclass="textbright"; }
	$fullpage .= '<div class="fullpage-block fullpage-block-'. $display_id . ' ' . $class . '" ';
	$fullpage .= ' style="background-color: '.$background_color.'; background-image: url('.$background_image.');';
	if ($border_style!="none") {
		$fullpage .= ' border-style:'.$border_style.'; border-color:'.$border_color.'; border-width:'.$border_width.'px; border-left:none; border-right:none;';
	}
	$fullpage .= ' padding-top:'.$top.'px; padding-bottom:'.$bottom.'px;';
	$fullpage .= ' background-attachment:fixed; background-position:50% 50%; background-repeat: repeat;">';
	$fullpage .= '<div class="fullpage-item '.$textclass.'">'.do_shortcode($content).'</div>';
	$fullpage .= '</div>';
	return $fullpage;
}
add_shortcode('fullpageblock', 'mtheme_fullpage');
function mtheme_Hr( $atts, $content = null ) {
   return '<div class="clearfix"></div><div class="hrule"></div>';
}
add_shortcode('hr', 'mtheme_Hr');

//Hrule [hr]
function mtheme_Hr_top( $atts, $content = null ) {
   return '<div class="clearfix"></div><div class="hrule top"><a href="#">'.__('Top','mtheme').'</a></div>';
}
add_shortcode('hr_top', 'mtheme_Hr_top');

//Hrule [hr]
function mtheme_Hr_padding( $atts, $content = null ) {
   return '<div class="clearfix"></div><div class="hr_padding"></div>';
}
add_shortcode('hr_padding', 'mtheme_Hr_padding');
/**
 * List shortcode.
 *
 * @ [list type=(check,star,note,play,bullet)]
 */
function mtheme_List( $atts, $content = null ) {
   extract( shortcode_atts( array(
	  'icon' => 'fa fa-check',
	  'color' => '#EC3939'
      ), $atts ) );

   	$checklist = '<div class="checklist">';
	//$checklist .= str_replace('<ul>', '<ul class="icons-ul">', $content);
	$checklist .= str_replace('<li>', '<li><i style="color:'.$color.';" class="'.$icon.'"></i>', do_shortcode($content));
	$checklist .= '</div>';

	return $checklist;
}
add_shortcode('checklist', 'mtheme_List');

/**
 * Notice / Alerts
 */
function mtheme_Alert( $atts, $content = null ) {

   extract( shortcode_atts( array(
	  'type' => 'yellow',
	  'icon' => 'feather-icon-cross'
      ), $atts ) );

	$notice ='<div class="noticebox info_'.$type.'">';
	$notice .= '<span class="close_notice feather-icon-cross"></span>';
	$notice .= '<i class="'.$icon.'"></i>';
	$notice .= '<div class="notice-text">'. trim( do_shortcode( wpautop( html_entity_decode($content) ) ) ).'</div>';
	$notice .= '</div>';
	
	return $notice;
		
}
add_shortcode('alert', 'mtheme_Alert');


//DropCaps [dropcap1] letter [/dropcap1]
function mtheme_DropCap( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'type' => '1',
      ), $atts ) );
   return '<span class="mtheme-dropcap dropcap'.$type.'">' . $content . '</span>';
}
add_shortcode('dropcap', 'mtheme_DropCap');

//Button [button link="yourlink.html"] text [/button]
function mtheme_Button( $atts, $content = null ) {

   extract( shortcode_atts( array(
      'link' => '#',
      'button_icon' => '',
	  'target' => '',
	  'button_align' => '',
	  'button_color' => '',
	  'size'=> 'normal',
      ), $atts ) );

   $uniqueID = uniqid();
	  
	if ($target=="_blank") { $target=' target="_blank"'; }
	if ($button_align=="{{button_align}}") { $button_align=''; }
	if ($button_align=='') {
		$button_align_style='';
	} else {
		$button_align_style= ' style="text-align:'.$button_align.';"';
	}
	$button = '<div class="button-shortcode button-shortcode-'.$uniqueID.'"'.$button_align_style.'>';
	$button .= '<a href="'.esc_url($link).'" ' . $target . '>';
	$button .= '<div class="mtheme-button animation-standby animated pulse">';
	if (isSet($button_icon) && !empty($button_icon) ) {
		$button .= '<span class="button-icon"><i class="'.$button_icon.'"></i></span>';
	}
	$button .= trim($content);
	$button .= '</div>';
	$button .= '</a>';
	$button .= '</div>';

	if (isSet($button_color) && !empty($button_color) ) {
		$button .= '<style>';
		$button .= '.button-shortcode-'.$uniqueID.' .mtheme-button:after { background-color: '.$button_color.'; }';
		$button .= '.button-shortcode-'.$uniqueID.' .mtheme-button { border-color: '.$button_color.'; color: '.$button_color.'; }';
		$button .= '</style>';
	}
	
   return $button;
}
add_shortcode('button', 'mtheme_Button');

//post list [postlist cat=3 num=5]
function mtheme_post_list($atts, $content = null) {
        extract(shortcode_atts(array(
                "num" => '5',
                "cat" => ''
        ), $atts));
        global $post;
        $myposts = get_posts('numberposts='.$num.'&order=DESC&orderby=post_date&category='.$cat);
        $retour='<div class="postlist"><ul>';
        foreach($myposts as $post) :
                setup_postdata($post);
             $retour.='<li><a href="'.get_permalink().'">'.the_title("","",false).'</a></li>';
        endforeach;
        $retour.='</ul></div> ';
		wp_reset_query();
        return $retour;
}
add_shortcode("posts", "mtheme_post_list");

/**
 * Usage: [pagelist child_of=x] x = id of the parent page, default = 0
 * Example: [pagelist child_of=12]
**/

function mtheme_pagelist($atts, $content = null) {
        extract(shortcode_atts(array(
                "childof" => ''
        ), $atts));
 $output = wp_list_pages('echo=0&child_of='.$childof.'&sort_column=menu_order&title_li=');
 return '<div class="postlist"><ul>'.$output.'</ul></div>';
}
add_shortcode('pages', 'mtheme_pagelist');
//Google Maps Shortcode
function mtheme_do_googleMaps($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '460',
      "height" => '480',
      "src" => ''
   ), $atts));
   return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed" ></iframe>';
}
add_shortcode("googlemap", "mtheme_do_googleMaps");

//Clear [clear]
function mtheme_Clear( $atts, $content = null ) {
   return '<div class="clear"></div>';
}
add_shortcode('clear', 'mtheme_Clear');

//Column2 [column2] text [/column2]
function mtheme_Column( $atts, $content = null ) {
   extract( shortcode_atts( array(
	  'span' => '2',
	  'last' => 'false'
      ), $atts ) );
   $lastclass='';
   $lastshortcodeclass='';
   if ($last=="yes") {
   		$lastclass = ' clearfix';
   		$lastshortcodeclass = ' last-shortcode-column';
   }
   $column = '<div class="shortcode-column span'.$span.$lastshortcodeclass.$lastclass.'">';
   $column .= do_shortcode(trim($content));
   $column .= '</div>';
   return $column;
}
add_shortcode('column', 'mtheme_Column');

//Toggle [toggle] text [/toggle]
function mtheme_Toggle( $atts, $content = null ) {

  	extract(shortcode_atts(array(
		"title" => 'Toggle',
		"state" => 'closed'
	), $atts));

  	$toggle_status="";
	if ($state=="open") { 
		$toggle_status="active";
	}
	  
	$toggle	=  '<div class="toggle-shortcode-wrap clearfix">';
	$toggle	.=	'<h2 class="toggle-shortcode '.$toggle_status.'">' . $title . '</h2>';
	$toggle .=	'<div class="toggle-container toggle-display-'.$state.'">';
	$toggle .=	wpautop( html_entity_decode($content) );
	$toggle	.=	'</div>';
	$toggle	.=	'</div>';
	//$toggle = do_shortcode($toggle);

	return $toggle;
}
add_shortcode('toggle', 'mtheme_Toggle');


//Highlight [highlight] text [/highlight]
function mtheme_Highlight( $atts, $content = null ) {
   return '<span class="highlight">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight', 'mtheme_Highlight');

//Big Italic
function mtheme_big_italic( $atts, $content = null ) {
		$big_italic = '<div class="big-italic">' . do_shortcode($content) . '</div>';

   return $big_italic;
}
add_shortcode('big_italic', 'mtheme_big_italic');

//Pullquote Right [pullquote_right] text [/pullquote_right]
function mtheme_Pullquote( $atts, $content = null ) {

   extract( shortcode_atts( array(
	  'align' => 'center',
	  'animated'=> 'none'
      ), $atts ) );

	if ($animated != 'none') {
		$animated = 'animation-standby animated ' .$animated;
	}

   $pullquote_left_symbol ='';
   $pullquote_right_symbol ='';

	$pullquote = '<div class="pullquote-'.$align.' '.$animated.'">' . do_shortcode( $pullquote_left_symbol . wpautop( html_entity_decode($content) ) . $pullquote_right_symbol ) . '</div>';

   return $pullquote;
}
add_shortcode('pullquote', 'mtheme_Pullquote');

/* Lightbox */
function mtheme_Lightbox( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"lightbox_url" => '',
		"lightbox_video_url" => '',
		"thumbnail_url" => '',
		"title" => '',
		'align' => ''
	), $atts));

$magnific_type = "magnific-image";

if ($lightbox_video_url<>"") {
	$lightbox_url=$lightbox_video_url;
	$magnific_type = "magnific-video";
}
$lightbox = '<div class="lightbox-shortcode gridblock-grid-element gridblock-element-inner">
	<div class="gridblock-background-hover">
		<div class="gridblock-links-wrap">
			<a href="'.$lightbox_url.'" title="'.$title.'" class="column-gridblock-icon" data-lightbox="'.$magnific_type.'">
				<span class="hover-icon-effect">
					<i class="feather-icon-maximize"></i>
				</span>
			</a>
		</div>
	</div>
	<img class="displayed-image" alt="thumbnail-image" src="'.$thumbnail_url.'">
</div>';

   return $lightbox;// . $imagesrc . $after;
}
add_shortcode('lightbox', 'mtheme_Lightbox');

//Picture frame [pictureframe]
function mtheme_PictureFrame( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"width" => '150',
		"height" => '',
		"zoom" => '',
		"title" => 'Untitled',
		"align" => 'none',
		"link" => 'none',
		"lightbox" => 'true',
		"image" => ''
	), $atts));
	
	$quality=MTHEME_IMAGE_QUALITY;
	$class="none";
	$before='';
	$after='';
	$fade='';
	$img_align='';
	
	
	if ( $height=="" || $height==0 ) { $height="auto"; } else { $height=$height . "px"; }
	$width=$width . "px";
	
	if ($align=="left") {$img_align="img-align-left";}
	if ($align=="right") {$img_align="img-align-right";}
	if ($align=="center") {$img_align="img-align-center";}
	if ($link<>"") {
		$before='<a title="'.$title.'" href="'. $link . '">';
		$after='</a>';
		$fade="portfolio-fadein";
		}
	if ($lightbox=="true") {
		$before='<a data-lightbox="magnific-image" title="'.$title.'" href="'. $image . '">';
		$after='</a>';
		$fade="pictureframe-image";
		}
	
	$class="pictureframe " . $img_align . " " . $fade;
		
	$imagesrc = '<img src="'. $image . '" class="'.$class.'" style="width:' . $width .'; height:'. $height .'" alt="thumbnail" />';


   return $before . $imagesrc . $after;
}
add_shortcode('pictureframe', 'mtheme_PictureFrame');

/*
* jQuery UI - Tabs shortcode
*/
global $olt_tab_shortcode_count, $olt_tab_shortcode_tabs;
$olt_tab_shortcode_count = 0;
function mtheme_display_shortcode_tab($atts,$content)
{
global $olt_tab_shortcode_count, $post, $olt_tab_shortcode_tabs;
extract(shortcode_atts(array(
'title' => null,
'class' => null,
), $atts));

if (!is_array($olt_tab_shortcode_tabs)) {
	$olt_tab_shortcode_tabs=array();
}

ob_start();

if($title):
$olt_tab_shortcode_tabs[] = array(
"title" => $title,
"id" => preg_replace("#[^a-z0-9\.]#i", "", $title)."-".$olt_tab_shortcode_count,
"class" => $class
);
?><div id="<?php echo preg_replace("#[^a-z0-9\.]#i", "", $title)."-".$olt_tab_shortcode_count; ?>" >
<div class="tab-contents">
<?php
$content = wpautop(html_entity_decode($content));
echo do_shortcode( $content );
?>
</div>
</div><?php
elseif($post->post_title):
$olt_tab_shortcode_tabs[] = array(
"title" => $post->post_title,
"id" => preg_replace("#[^a-z0-9\.]#i", "", $post->post_title)."-".$olt_tab_shortcode_count,
"class" =>$class
);
?><div id="<?php echo preg_replace("#[^a-z0-9\.]#i", "", $post->post_title)."-".$olt_tab_shortcode_count; ?>" >
<?php
$content = html_entity_decode($content);
echo do_shortcode( $content );
?>
</div><?php
else:
?>
<span style="color:red">Please enter a title attribute like [tab title="title name"]tab content[tab]</span>
<?php
endif;
$olt_tab_shortcode_count++;
return ob_get_clean();
}

function mtheme_display_shortcode_tabs( $attr, $content )
{
// wordpress function
extract(shortcode_atts(array(
'type' => "horizontal"
), $attr));

global $olt_tab_shortcode_count,$post, $olt_tab_shortcode_tabs;
$olt_tab_shortcode_tabs="";
$vertical_tabs = "";
if( isset( $attr['vertical_tabs']) ):
$vertical_tabs = ( (bool)$attr['vertical_tabs'] ? "vertical-tabs": "");
unset($attr['vertical_tabs']);
endif;

// $attr['disabled'] = (bool)$attr['disabled'];
if ( isset($attr['collapsible']) ) $attr['collapsible'] = (bool)$attr['collapsible'];
$query_atts = shortcode_atts(
array(
'collapsible' => false,
'event' =>'click'
), $attr);
// there might be a better way of doing this
$id = "random-tab-id-".rand(0,1000);

ob_start();
?>
<div class="clearfix" id="<?php echo $id ?>" class="tabs-shortcode <?php echo $vertical_tabs; ?>"><?php

$content = (substr($content,0,6) =="<br />" ? substr( $content,6 ): $content);
$content = str_replace("]<br />","]",$content);

$str = do_shortcode( $content ); ?>
<ul>
<?php
$tab_counter=0;
foreach( $olt_tab_shortcode_tabs as $li_tab ):
$tab_counter++;
?><li <?php if( $li_tab['class']): ?> class='<?php echo $li_tab['class'];?>' <?php endif; ?> ><a href="#<?php echo $li_tab['id']; ?>"><?php echo $li_tab['title']; ?></a></li><?php
endforeach;



?></ul><?php echo $str; ?></div>
<?php
if ($type!="vertical") {
?>
<style>/* <![CDATA[ */
<?php
$css_tab_length= 100/$tab_counter;
echo '#' . $id . ' .ui-tabs-nav li { width:'. $css_tab_length .'%;}';
?>
/* ]]> */
</style>
<?php
}
?>
<script type="text/javascript"> /* <![CDATA[ */
jQuery(document).ready(function($) {
	<?php
	if ( $type != "vertical" ) {
	?>
	jQuery("#<?php echo $id ?>").tabs(<?php echo json_encode($query_atts); ?> );
	<?php
	} else {
	?>
	jQuery("#<?php echo $id ?>").tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	jQuery("#<?php echo $id ?> li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	<?php
	}
	?>
});
/* ]]> */
</script>

<?php
$post_content = ob_get_clean();

return str_replace("\r\n", '',$post_content);
}

function olt_tabs_shortcode_init() {
    
    add_shortcode('tab', 'mtheme_display_shortcode_tab'); // Individual tab
    add_shortcode('tabs', 'mtheme_display_shortcode_tabs'); // The shell
}

add_action('init','olt_tabs_shortcode_init');

global $olt_accordion_shortcode_count;
$olt_accordion_shortcode_count = 0;

function mtheme_accordiontab($atts,$content)
{
	global $olt_accordion_shortcode_count,$post;
	extract(shortcode_atts(array(
		'title' => null,
		'class' => null,
	), $atts));
	
	ob_start();
	
	if($title):
		?>
		<h3 ><a href="#<?php echo preg_replace("#[^a-z0-9\.]#i", "", $title)."-".$olt_accordion_shortcode_count; ?>"><?php echo $title; ?></a></h3>
		<div class="accordian-shortcode-content <?php echo $class; ?>" >
			<?php
			$content = wpautop(html_entity_decode($content) );
			echo do_shortcode( $content );
			?>
		</div>
		<?php
	elseif($post->post_title):
	?>
		<div id="<?php echo preg_replace("#[^a-z0-9\.]#i", "", $post->post_title)."-".$olt_accordion_shortcode_count; ?>" >
			<?php
			$content = html_entity_decode($content);
			echo do_shortcode( $content );
			?>
		</div>
	<?php
	else:
	?>
		<span style="color:red">Please enter a title attribute like [accordion title="title name"]accordion content[accordion]</span>
		<?php 	
	endif;
	$olt_accordion_shortcode_count++;
	return ob_get_clean();
}

function mtheme_accordiontabs($attr,$content)
{
	// wordpress function 
	global $olt_accordion_shortcode_count,$post;
	
	if (isset($attr['autoHeight'])) $attr['autoHeight'] =  (bool)$attr['autoHeight'];
	if (isset($attr['disabled'])) $attr['disabled'] =  (bool)$attr['disabled'];
	if ($attr['active']==-1) {
		$attr['active'] =  (bool)$attr['active'];
	} else {
		$attr['active'] =  (int)$attr['active'];
	}
	if (isset($attr['clearStyle'])) $attr['clearStyle'] = (bool)$attr['clearStyle'];
	if (isset($attr['collapsible'])) $attr['collapsible'] = (bool)$attr['collapsible'];
	if (isset($attr['fillSpace'])) $attr['fillSpace']= (bool)$attr['fillSpace'];
	$query_atts = shortcode_atts(
		array(
			'heightStyle' => 'content',
			'autoHeight' => false, 
			'disabled' => false,
			'active'	=> 0,
			'animated' => 'slide',
			'clearStyle' => false,
			'collapsible' => true,
			'event'=>'click',
			'fillSpace'=>false
		), $attr);
	
	// there might be a better way of doing this
	$id = "random-accordion-id-".rand(0,1000);
	
	$content = (substr($content,0,6) =="<br />" ? substr($content,6): $content);
	$content = str_replace("]<br />","]",$content);
	ob_start();
	?>
	<div id="<?php echo $id ?>" class="wp-accordion accordions-shortcode">
		<?php echo do_shortcode( $content ); ?> 
	</div>
	<script type="text/javascript"> /* <![CDATA[ */ 
	jQuery(document).ready( function($){ jQuery("#<?php echo $id ?>").accordion(<?php echo json_encode($query_atts); ?> ); }); 
	/* ]]> */ </script>

	<?php
	$post_content = ob_get_clean();
	
	return str_replace("\r\n", '',$post_content);
}

function olt_accordions_shortcode_init() {
    
    add_shortcode('accordion', 'mtheme_accordiontab'); // Individual accordion
    add_shortcode('accordions', 'mtheme_accordiontabs'); // The shell
	
}
add_action('init','olt_accordions_shortcode_init');

function mtheme_progressbar_group($atts, $content = null) {
	$progressbar = '<div class="progressbar-wrap">';
	$progressbar .= do_shortcode($content);
	$progressbar .= '</div>';
	return $progressbar;
}
add_shortcode('progress_group', 'mtheme_progressbar_group');
// Progress Bars
function mtheme_progressbar($atts, $content = null) {
	extract(shortcode_atts(array(
		'color' => null,
		'unit' => '%'
	), $atts));

	$rgb = mtheme_shortcodefunction_hex_to_rgb($color);
	$rgb_css = $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2];
	$rgba_css = 'rgba(' . $rgb_css . ',0.1);';

	$skill ='<h3 class="progressbar-title">'.$atts['title'].'<span class="skill-bar-percent">'.$atts['percentage'].$atts['unit'].'</span></h3>';
	$skill .='<div style="background-color:'.$rgba_css.';" class="skillbar" data-percent="'.$atts['percentage'].'">';
	$skill .='<div style="background-color:'.$color.';" class="skillbar-bar"></div>';
	$skill .='</div>';
	return $skill;
}
add_shortcode('progressbar', 'mtheme_progressbar');

// Counter
function mtheme_counter($atts, $content = null) {
	extract(shortcode_atts(array(
		"size" => '150',
		"title" => '',
		"percentage" => '90',
		"textsize" => '32',
		"bgcolor" => '#f0f0f0',
		"fgcolor" => '#EC3939',
		"donutwidth" => '3'
	), $atts));
	if ($percentage>100) {
		$percentage="100";
	}
	$uniqurePageID=get_the_id()."-".dechex(mt_rand(1,65535));
	$counter = '';
	$counter .= '<div class="donutcounter-wrap service-column">';
	$counter .='<div class="donutcounter-item" id="donutchart-'.$uniqurePageID.'" data-percent="'.$percentage.'"></div>';
	$counter .= '<div class="service-content">';
	$counter .= '<h4>'.$title.'</h4>';
	$counter .= '<div class="service-details">'. wpautop( html_entity_decode($content) ).'</div>';
	$counter .= '</div>';
	$counter .= '</div>';
	$counter .="
<script>
jQuery(document).ready(function($){
	$('#donutchart-".$uniqurePageID."').waypoint(function() {
	$('#donutchart-".$uniqurePageID."').donutchart({
		'size': '".$size."',
		'donutwidth': ".$donutwidth.",
		'fgColor' : '".$fgcolor."',
		'bgColor' : '".$bgcolor."',
		'textsize': '".$textsize."'
	});
	$('#donutchart-".$uniqurePageID."').donutchart('animate');
	}, { offset: 'bottom-in-view',triggerOnce: true });
});
</script>";
	return $counter;
}
add_shortcode('counter', 'mtheme_counter');

/* Font Awesome */
function mtheme_fontawesome($atts, $content = null) {
	extract( shortcode_atts( array(
        'class' => 'fa fa-wrench'
    ), $atts ));
    $fontawesome = '<i class="'.$class.'"></i>';
    return $fontawesome;
}
add_shortcode('fontawesome', 'mtheme_fontawesome');

// Dividers
function mtheme_divider($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'type' => '',
		'textcolor' => '',
		'textbackground' => '',
		'style' => 'blank',
		'top' => '30',
		'bottom' => ''
	), $atts));
	$divider = '';
	$stylecss ='margin-top:'.$top.'px;';
	if ( isSet($bottom) && !empty($bottom) ) {
		$stylecss .= 'margin-bottom:'.$bottom.'px;';
	}
	if ( $type == "{{type}}") {
		$type = '';
	}
	if ( $type == "default") {
		$type = 'default-divider ';
	}
	if ( $type == "dark") {
		$type = 'dark-divider ';
	}
	if ( $type == "bright") {
		$type = 'bright-divider ';
	}
	$titlespan ='';
	if ( $title !='' ) {
		$titlespan = '<span class="divider-title">'.$title.'</span>';
	}
	$divider .= '<div class="clearfix divider-common '.$type.' divider-'.$style.'" style="'.$stylecss.'">'.$titlespan.'</div>';
	
	return $divider;
}
add_shortcode('divider', 'mtheme_divider');

// ###################################
// Headings
// ###################################
function mtheme_heading($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
		'align' => '',
		'content_richtext' => '',
		'animated' => 'none',
		'size' => '3',
		'style' => 'line',
		'top' => '40',
		'bottom' => '0',
		'marginbottom' => '60',
		'button' => '',
		'width' => '',
		'button_link' => ''
	), $atts));
	$divider = '';
	if ( $bottom == "0" ) { 
		$bottom = $top;
		}

	$textalign='';
	if ($align<>'') {
		$textalign = ' style="text-align:'.$align.';"';
	}

	if ($animated != 'none') {
		$animated = 'animation-standby animated ' .$animated;
	}

	$titletag = '<h'. $size .' class="section-title">'.$title.'</h'.$size.'>';

	if (isSet($top) && trim($top) > 0 ) {
		$top = $top . 'px';
	}
	if (isSet($bottom) && trim($bottom) > 0 ) {
		$bottom = $bottom . 'px';
	}
	if (isSet($width) && trim($width) > 0 ) {
		$width = 'width:' . $width . '%;';
	} else {
		$width='';
	}

	$heading = '<div class="section-heading '.$animated.' section-align-'.$align.'" style="'.$width.'padding-top:'.$top.';padding-bottom:'.$bottom.';margin-bottom:'.$marginbottom.'px;">';
	$heading .= $titletag;
	if ( trim($subtitle) ) {
		$heading .= '<h3 class="section-subtitle">'.$subtitle.'</h3>';
	}
	$heading .= '<div class="section-end"></div>';
	if ( trim($content_richtext) ) {
		$heading .= '<div class="section-contents clearfix">'.wpautop( html_entity_decode($content_richtext) ).'</div>';
	}
	if (!empty($button)) {
	$heading .= '
			<a href="'.esc_url($button_link).'">
			<div class="mtheme-button animation-standby animated pulse">
			'.$button.'
			</div>
			</a>';
	}
	$heading .= '</div>';
	return $heading;
}
add_shortcode('heading', 'mtheme_heading');

// ###################################
// Information Box
// ###################################
function mtheme_infobox($atts, $content = null) {
	global $iconplace,$iconcolor,$iconbackground;
	$iconplace='';
	$iconcolor='';
	$iconbackground='';
	$servicebox='';
	extract(shortcode_atts(array(
		'column' => '4',
		'boxplace' => 'horizontal',
		'layout' => 'icon-with-title',
		'iconplace' => 'left',
		'iconcolor' => '',
		'iconbackground' => ''
	), $atts));
	$alignicon = "alignicon-top";
	if ($iconplace == "left") $alignicon = "alignicon-left";
	if ($iconplace == "right") $alignicon = "alignicon-right";

	$servicebox .= '<div class="service-column service-info-box service-column-'.$column.' service-boxes-'.$layout.' '.$alignicon.' '.$alignicon.'-'.$boxplace.' serviceboxes-'.$boxplace.' clearfix">';
	$servicebox .= do_shortcode($content);
	$servicebox .= '</div>';

	return $servicebox;
}
add_shortcode('infobox', 'mtheme_infobox');

// ###################################
// Information Item
// ###################################
	function mtheme_infobox_item($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => '',
			'link' => '',
			'linktext' => '',
			'image' => '',
			'last_item' => 'no'
		), $atts));

		$service = '';
		$iconcolor_css='';
		$iconbackground_css='';
		$service_icon='';

		global $iconplace,$iconcolor,$iconbackground;

		$iconsize = "fa fa-2x";
		if ($iconcolor) $iconcolor_css = 'color:' .$iconcolor. ';';
		
		if ($image) $service_image = '<img class="service-image" src="'.$image.'" alt="info-image" />';
		if ( $link <>"" ) { $service_image = '<a class="service-image-link" href="'.esc_url($link).'" >' . $service_image . '</a>'; }

		$column_edge="service-item-space";
		if ($last_item=="yes") { $column_edge="clearfix"; }
		if ($last_item=="builder") { $column_edge=""; }
		$service .= '<div class="service-column service-item '.$column_edge.'">';

		//if ( $link <>"" ) { $title = '<a href="'.esc_url($link).'" >' . $title . '</a>'; }
		if ($image) $service .= $service_image;
			$service .= '<div class="service-content">';
			$service .= '<h4>'.$title.'</h4>';
				$service .= '<div class="service-details">';
				$service .= wpautop( html_entity_decode($content) );
				if ($link!='' && $linktext!='' ) {
					$service .= '<div class="subtle-fade readmore-service"><a href="'.esc_url($link).'">'.$linktext.'</a></div>';
				}
				$service .= '</div>';
			$service .= '</div>';
		$service .= '</div>';

		return $service;
	}
add_shortcode('infobox_item', 'mtheme_infobox_item');

// ###################################
// ImageBox
// ###################################
	function mtheme_imagebox_item($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => '',
			'icon' => '',
			'link' => '',
			'target' => '',
			'linktext' => '',
			'displaytype' => '',
			'image' => '',
			'last_item' => 'no'
		), $atts));

		if ($target <> "_blank") {
			$target == "_self";
		}
		$the_content = wpautop( html_entity_decode($content) );

				$contentbox = '';
				$contentbox .= '<div class="imagebox-content-'.$displaytype.' imagebox-content-wrap">';
				$contentbox .= '<div class="imagebox-box">';
				if ( $title || $the_content ) {
					if ($title) {
						if ($link<>"" && $displaytype<>"inside") {
							$contentbox .= '<a class="textlink" target="'.esc_attr($target).'" href="'.esc_url($link).'">';
						}
						$contentbox .= '<div class="imagebox-title">' . $title . '</div>';
						if ($link<>"" && $displaytype<>"inside") {
							$contentbox .= '</a>';
						}
					}
					if ($the_content) {
						$contentbox .= '<div class="imagebox-desc">' . $the_content . '</div>';
					}
				}
				$contentbox .= '</div>';
				$contentbox .= '</div>';

				$imagebox = '';
				$imagebox .= '<div class="imagebox-item-wrap imagebox-item-wrap-'.$displaytype.'">';
						if ($displaytype=="above") {
							$imagebox .= $contentbox;
						}
					$imagebox .= '<div class="imagebox-item">';
						$imagebox .= '<div class="imagebox-item-inner">';
						if ($link<>"") {
							$imagebox .= '<a target="'.esc_attr($target).'" href="'.esc_url($link).'">';
						}
						$imagebox .= mtheme_display_post_image (
							get_the_id(),
							$have_image_url = $image,
							$imagelink =false,
							$type = "gridblock-full",
							$imagetitle = $title,
							$class="imagebox-image",
							$navigation=false
						);
						if ($link<>"") {
							$imagebox .= '<div class="imagebox-icon"><i class="'.$icon.'"></i></div>';
						}
						if ($displaytype=="inside") {
							$imagebox .= $contentbox;
						}
						if ($link<>"") {
							$imagebox .= '</a>';
						}
						$imagebox .= '</div>';
					$imagebox .= '</div>';
						if ($displaytype=="below") {
							$imagebox .= $contentbox;
						}
				$imagebox .= '</div>';

		return $imagebox;
	}
add_shortcode('imagebox_item', 'mtheme_imagebox_item');


// ###################################
// Service Box
// ###################################
function mtheme_servicebox($atts, $content = null) {
	global $iconplace,$iconcolor,$iconbackground,$iconbackground_opacity,$iconborder,$animated,$boxplace;
	$iconplace='';
	$iconcolor='';
	$animated='';
	$iconbackground='';
	$iconbackground_opacity='';
	$servicebox='';
	$boxplace='';
	$iconborder = '';
	extract(shortcode_atts(array(
		'column' => '4',
		'boxplace' => 'horizontal',
		'layout' => 'icon-with-title',
		'iconplace' => 'left',
		'iconcolor' => '',
		'iconborder' => 'true',
		'iconbackground' => '',
		'animated' => 'none',
		'iconbackground_opacity' => ''
	), $atts));
	$alignicon = "alignicon-top";
	if ($iconplace == "left") $alignicon = "alignicon-left";
	if ($iconplace == "right") $alignicon = "alignicon-right";

	if ($iconborder=="false") {
		$iconborder="no-border";
	}

	if ($animated != 'none' && $boxplace=="horizontal" ) {
		$animated = 'animation-standby animated ' .$animated;
	}
	$servicebox .= '<div class="service-column '.$animated.' service-column-'.$column.' service-boxes-'.$layout.' '.$iconborder.' '.$alignicon.' '.$alignicon.'-'.$boxplace.' serviceboxes-'.$boxplace.' clearfix">';
	$servicebox .= do_shortcode( wpautop(html_entity_decode($content)) );
	$servicebox .= '</div>';

	return $servicebox;
}
add_shortcode('servicebox', 'mtheme_servicebox');

// ###################################
// Service Item
// ###################################
	function mtheme_servicebox_item($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => '',
			'link' => '',			
			'linktext' => '',
			'icon' => '',
			'pagebuilder' =>'',
			'last_item' => 'no'
		), $atts));

		$link=trim($link);

		$service = '';
		$iconcolor_css='';
		$iconbackground_css='';
		$iconbackground_rgba_css='';
		$iconborder_css='';
		$service_icon='';

		global $iconplace,$animated,$iconcolor,$iconbackground,$iconbackground_opacity,$iconborder,$boxplace;


		if ($animated != 'none' && $boxplace=="vertical" ) {
			$animated = 'animation-standby animated ' .$animated;
		}

		$iconsize = "fa-2x";
		if ($iconcolor) {
			$iconcolor_css = 'color:' . $iconcolor. ';';
		}
		if ($iconbackground) {
			$iconbackground_css = 'background-color:' .$iconbackground. ';';
			if ($iconbackground_opacity) {
				$rgb = mtheme_shortcodefunction_hex_to_rgb($iconbackground);
				$rgb_css = $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2];
				$iconbackground_rgba_css = 'background-color: rgba(' . $rgb_css . ',' . $iconbackground_opacity. ');';
			}
		}
		if ($iconborder=="true") {
			$iconborder_css = 'border-color:'.$iconcolor. ';';
		} else {
			$iconborder_css = '';
		}
		
		if ( $iconplace =="top" ) { $iconsize = ""; }
		if ( $boxplace =="vertical" ) { $iconsize = ""; }
		if ($icon) $service_icon .= '<div data-iconcolor="'.$iconcolor.'" data-bgcolor="'.$iconbackground.'" class="service-icon"><i style="'. $iconcolor_css . $iconbackground_css . $iconbackground_rgba_css . $iconborder_css . '" class="fontawesome in-circle '.$iconsize.' '.$icon.'"></i></div>';

		$column_edge="service-item-space";
		if ($last_item=="yes") $column_edge="clearfix";
		if ($pagebuilder=="active") {
			$column_edge="";
		}
		$service .= '<div class="service-item '.$animated.' '.$column_edge.'">';

		if ( $link <>"" ) { $title = '<a href="'.esc_url($link).'" >' . $title . '</a>'; }
		if ($icon) $service .= $service_icon;
		$service .= '<div class="service-content">';
		$service .= '<h4>'.$title.'</h4>';
		$service .= '<div class="service-details">';
		$service_content = do_shortcode($content);
		$service .= wpautop( html_entity_decode($service_content) );
		if ($link!='' && $linktext!='' ) {
			$service .= '<div class="subtle-fade readmore-service"><a href="'.esc_url($link).'">'.$linktext.'</a></div>';
		}
		$service .= '</div>';
		$service .= '</div>';
		$service .= '</div>';

		return $service;
	}
add_shortcode('servicebox_item', 'mtheme_servicebox_item');

// ###################################
// Callout Message
// ###################################
	function mtheme_callout_msg($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => '',
			'type' => '',
			'description' => '',
			'button' => '',
			'animated' => 'none',
			'button_color' =>'',
			'button_icon' =>'',
			'button_type' =>'',
			'button_text' =>'',
			'button_link' => ''
		), $atts));

		if ($animated != 'none') {
			$animated = 'animation-standby animated ' .$animated;
		}

		$service = '';
		$iconcolor_css='';
		$iconbackground_css='';
		$service_icon='';

		$callout =  '<div class="callout-wrap '.$animated.' calltype-'.$type.' clearfix">';
			$callout .=  '<div class="callout clearfix">';
				$callout .=  '<div class="first-half">';
				$callout .= '<h2 class="callout-title">'.$title.'</h2>';
				$callout .= '<div class="callout-desc">'. wpautop( html_entity_decode($description) ) .'</div>';
				$callout .= '</div>';
				
				if (isSet($button_text) && !empty($button_text)) {
					$callout .=  '<div class="second-half">';
					$callout .= '<div class="callout-button">';
					$callout .= do_shortcode('[button link="'.$button_link.'" button_icon="'.$button_icon.'" button_color="'.$button_color.'"]'.$button_text.'[/button]');
					$callout .= '</div>';
					$callout .= '</div>';
				}
				
			$callout .= '</div>';
		$callout .= '</div>';
		return $callout;
	}
add_shortcode('callout', 'mtheme_callout_msg');

// ###################################
// Pricing Table
// ###################################
	function mtheme_pricing_table($atts, $content = null) {
		extract(shortcode_atts(array(
			'columns' => '4',
			'service' => 'false'
		), $atts));

		global $pricing_columns;
		$pricing_columns = "column".$columns;

		$service_class='';
		if ($service == 'true') {
			$service_class = "pricing-table-service ";
		}
		$pricing_table =  '<div class="pricing-table '.$service_class.'clearfix">';
		$pricing_table .= do_shortcode($content);
		$pricing_table .= '</div>';
		return $pricing_table;
	}
add_shortcode('pricing_table', 'mtheme_pricing_table');

// ###################################
// Pricing Column
// ###################################
	function mtheme_pricing_column($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => '',
			'title_bgcolor' =>'',
			'type' => '1',
			'animated' => 'none',
			'topspace' => '175',
			'featured' => 'false'
		), $atts));

		global $pricing_columns;

		if ($animated != 'none') {
			$animated = 'animation-standby animated ' .$animated;
		}

		$highlight='';
		if ($featured=="true") $highlight="pricing_highlight";
		$pricing_table = '<div style="background-color:'.$title_bgcolor.';" class="pricing-column-target '.$animated.' '.$pricing_columns.' '.$highlight.'">';
		$pricing_table .= '<div class="pricing-column-type-'.$type.' pricing-column">';
		if ($type=="2") { 
			$pricing_table .= '<ul style="margin-top:'.$topspace.'px">';
		} else {
			$pricing_table .= '<ul>';
		}
		$pricing_table .= '<li class="pricing-title"><h2>'.$title.'</h2></li>';
		$pricing_table .= do_shortcode($content);
		$pricing_table .= '</ul>';
		$pricing_table .= '</div>';
		$pricing_table .= '</div>';
		return $pricing_table;
	}
add_shortcode('pricing_column', 'mtheme_pricing_column');

// ###################################
// Pricing Price
// ###################################
	function mtheme_pricing_price($atts, $content = null) {
		extract(shortcode_atts(array(
			'currency' => '$',
			'price' => '17',
			'duration' => 'Monthly'
		), $atts));

		$price_sep = explode('.',$price);
		$pricing_table = '<li class="pricing-section">';
			$pricing_table .= '<div class="pricing-wrap">';
				$pricing_table .= '<div class="pricing-cell">';
				if ( !isSet($price_sep[1]) ) {
					$price_sep[1]='';
				}
					$pricing_table .= '<span class="pricing-currency">'.$currency.'</span>'.$price_sep[0].'<span class="pricing-suffix">'.$price_sep[1].'</span>';
				$pricing_table .= '</div>';
				$pricing_table .= '<div class="pricing-duration">'.$duration.'</div>';
			$pricing_table .= '</div>';
		$pricing_table .= '</li>';
		return $pricing_table;
	}
add_shortcode('pricing_price', 'mtheme_pricing_price');

// ###################################
// Pricing Service
// ###################################
	function mtheme_pricing_service($atts, $content = null) {

		$pricing_service = '<div class="pricing-service">';
			$content = wpautop( html_entity_decode($content) );
			$pricing_service .= do_shortcode( $content );
		$pricing_service .= '</div>';
		return $pricing_service;
	}
add_shortcode('pricing_service', 'mtheme_pricing_service');

// ###################################
// Pricing Row
// ###################################
	function mtheme_pricing_row($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => ''
		), $atts));

		
		$pricing_table = '<li class="pricing-row pricing-tick-'.$type.'">';
		if ($type=="tick") { $pricing_table .= '<i class="feather-icon-check"></i>'; }
		if ($type=="cross") { $pricing_table .= '<i class="feather-icon-cross"></i>'; }
		$pricing_table .= do_shortcode($content);
		$pricing_table .= '</li>';
		return $pricing_table;
	}
add_shortcode('pricing_row', 'mtheme_pricing_row');

// ###################################
// Pricing Footer
// ###################################
	function mtheme_pricing_footer($atts, $content = null) {
		extract(shortcode_atts(array(
			'title' => 'Pricing'
		), $atts));

		
		$pricing_table = '<li class="pricing-footer">';
		$pricing_table .= do_shortcode($content);
		$pricing_table .= '</li>';
		return $pricing_table;
	}
add_shortcode('pricing_footer', 'mtheme_pricing_footer');


// ###################################
// FontAwesome
// ###################################
add_shortcode('icongenerator', 'mtheme_fontawesome_icon_gen');
function mtheme_fontawesome_icon_gen($atts, $content = null) {

	extract(shortcode_atts(array(
		'size' => '',
		'align' => 'center',
		'icon' => 'feather-icon-disc',
		'iconcolor' => ''
	), $atts));

	$css_style = 'font-size:'.$size.'px; color:'.$iconcolor.' !important;';

	$fontawesome = '<div class="clearfix" style="text-align:'.$align.';">';
	$fontawesome .= '<i style="'.$css_style.'" class="shortcode-fontawesome-icon '.$icon.'"'.'></i>';
	$fontawesome .= '</div>';

	return $fontawesome;
}



// ###################################
// @ Since Version 2.4
// Counter
// ###################################
add_shortcode('count', 'mtheme_counter_timer');
function mtheme_counter_timer($atts, $content = null) {

	extract(shortcode_atts(array(
		'icon' => '',
		'from' => '0',
		'title' => 'title',
		'decimal_places' => '0',
		'to' => '1000',
		'iconcolor' => '',
	), $atts));

	$uniqueID=get_the_id()."-".dechex(mt_rand(1,65535));

	$css_style = 'color:'.$iconcolor.' !important;';

	$fontawesome = '<i style="'.$css_style.'" class="time-count-icon '.$icon.'"'.'></i>';

	$counter = '';
	$counter = '<div class="shortcode-time-counter-block service-column">';
	$counter .= $fontawesome;
	$counter .= '<div class="time-count-data text-intensity-switch odometer time-count-class-'.$uniqueID.'" id="time-count-data-'.$uniqueID.'">0</div>';
	$counter .= '<div class="service-content">';
	$counter .= '<h4 class="text-intensity-switch-low">'.$title.'</h4>';
	$counter .= '<div class="service-details">';
	$counter .= do_shortcode($content);
	$counter .= '</div>';
	$counter .= '</div>';
	$counter .= '</div>';

	$counter .="
<script>
/* <![CDATA[ */
jQuery(document).ready(function($){
	if ($.fn.waypoint) {
		$('.time-count-class-".$uniqueID."').waypoint(function() {
			$(this).html(".$to.");
		}, {
			offset: '70%'
		});
	}
});
/* ]]> */
</script>";

	return $counter;
}

add_shortcode('anchor', 'mtheme_anchor');
function mtheme_anchor( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'id' => '#anchor'
	), $atts));

	$anchor = '<span id="'.$id.'" data-id="anchor"></span>';

	return $anchor;
}


// ###################################
// Hero Image
// ###################################
add_shortcode('heroimage', 'mtheme_heroimage');
function mtheme_heroimage( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'image' => '',
			'text' => '',
			'text_location' => 'middle',
			'intensity' => 'light',
			'link' => '',
			'icon' => '',
			'icon_image' => '',
			'offsetclass' => 'outer-wrap',
			'text_slide' => 'single',
			'text_decoration' => 'none'
	), $atts));

	$output = '<div id="heroimage" class="heroimage-wrap textlocation-'.$text_location.' intensity-'.$intensity.' mtheme-parallax" data-stellar-background-ratio="0.5" style="background-image: url('.esc_url($image).');">';
	if ($text_slide!="disable") {
		$output .= '<div class="hero-text-wrap"><ul class="'.$text_decoration.' '.$text_slide.'">';
		$output .= do_shortcode($content);
		$output .= '</ul></div>';
	}
	$output .= '<div class="mouse-pointer-wrap">';
	$output .= '<div class="bright hero-link-to-base">';
	if ($icon=="true") {
		$output .= '<div class="mouse-pointer"><div class="indication-animated indicate-bounce mouse-wheel"></div></div>';
	}
	$output .= '</div>';
	$link = trim($link);
	$text = trim($text);
	if ( isSet($link) && !empty($link) && isSet($text) && !empty($text) ) {
		$output .= '<a class="bright" href="'.esc_url($link).'">';
		$output .= '<div class="hero-button mtheme-button animated pulse animation-action">'.esc_html($text).'</div>';
		$output .= '</a>';
	}
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('heroimage_text', 'mtheme_heroimage_textslides');
function mtheme_heroimage_textslides($atts, $content = null) {
	extract(shortcode_atts(array(
			'title' => '',
			'subtitle' => ''
	), $atts));

	$output = '	<li>
		<h3 class="hero-subtitle">
			'.esc_html($subtitle).'
		</h3>
		<h2 class="hero-title">
			'.html_entity_decode($title).'
		</h2>
	</li>';

	return $output;
}

// ###################################
// PhotoCard
// ###################################
add_shortcode('photocard', 'mtheme_photocard');
function mtheme_photocard( $atts, $content_richtext = null ) {
	extract(shortcode_atts(array(
			'image' => '',
			'imageid' => '',
			'title' => '',
			'text_align' => 'center',
			'subtitle' => '',
			'background_color' => '',
			'button_status' => '',
			'button' => '',
			'video_mp4' => '',
			'video_ogv' => '',
			'video_webm' => '',
			'animated' => 'none',
			'content_color' => '',
			'button_link' => '',
			'image_block' => 'left',
			'background_color' => ''
	), $atts));

	if ($animated != 'none') {
		$animated = 'animation-standby animated ' .$animated;
	}

	$opposite = 'column-float-left column-half';
	if ($image_block=='left') {
		$opposite = 'column-float-right column-half';
	}
	if ($image_block=='bottom') {
		$opposite = 'column-float-none image-set-bottom';
	}
	if ($image_block=='top') {
		$opposite = 'column-float-none image-set-top';
	}

	if ( !empty($imageid)) {
		$image_array = wp_get_attachment_image_src($imageid,'gridblock-full',false);
		//print_r($image_array);
		$image_src = $image_array[0];
	} else {
		$image_src=$image;
	}

	if ($image_block=='bottom' || $image_block=='top' ) {
		$image_set = '
		<div class="photocard-image-wrap">
			<img class="fullwidth-image" src="'.esc_url($image_src).'"  alt="'.esc_attr( mtheme_get_alt_text($imageid) ).'" />
		</div>';
	} else {
		$video_class='';
		if ( !empty($video_mp4) && isSet($video_mp4) && $video_mp4!='' ) {
			$video_class = "photocard-video";
		}
		$image_set = '<div class="photocard-image-wrap '.$video_class.' column-half column-float-'.$image_block.'">';
			if ( !wp_is_mobile() ) {
				if ( !empty($video_mp4) && isSet($video_mp4) && $video_mp4!='' ) {
					$image_set .= '<div id="photocardvideo">';
					$image_set .= '<video autoplay loop muted>';
					    $image_set .= '<source src="'.esc_url($video_mp4).'" type="video/mp4" />';
					    $image_set .= '<source src="'.esc_url($video_webm).'" type="video/webm" />';
					    $image_set .= '<source src="'.esc_url($video_ogv).'" type="video/ogv" />';
					    $image_set .= '<img class="photocardvideo-fallback-image" src="'.esc_url($image_src).'" alt="videofallback" />';
					    //$image_set .= '<div class="photocard-image-container" style="background-image:url('.esc_url($image_src).');"></div>';
					$image_set .= '</video>';
					$image_set .= '</div>';
				} else {
					$image_set .= '<div class="photocard-image-container" style="background-image:url('.esc_url($image_src).');"></div>';
				}
			} else {
				$image_set .= '<div class="photocard-image-container" style="background-image:url('.esc_url($image_src).');"></div>';
			}
		$image_set .= '</div>';
	}

	$css_style="";
	if ( !empty( $background_color ) ) {
		$css_style = 'style="background-color:'.$background_color.';"';
	}

	$content_set = '
	<div class="photocard-content-wrap photocard-'. $content_color .' '.$opposite.'" '.$css_style.'>
		<div class="photocard-contents-inner text-align-'.$text_align.'">
			<div class="heading-block">
				<h2 class="photocard-title">
				'.$title.'
				</h2>
				<h3 class="photocard-subtitle">
					'.$subtitle.'
				</h3>
			</div>
			<div class="photocard-contents">
			'. wpautop( html_entity_decode($content_richtext) ).'
			</div>';
	if (!empty($button)) {
	$content_set .= '
			<a href="'.esc_url($button_link).'">
			<div class="mtheme-button animation-standby animated pulse">
			'.$button.'
			</div>
			</a>';
	}
	$content_set .= '
		</div>
	</div>';

if ( $image_block=="bottom" ) {
	$final_set = $content_set . $image_set;
} else {
	$final_set = $image_set . $content_set;
}

	$output = '
<div class="photocard-wrap '.$animated.' clearfix">
'.$final_set.'
</div>
';

return $output;
}


add_shortcode('singleimage', 'mtheme_singleimage');
function mtheme_singleimage ( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'image' => '',
		'imageid' => '',
		'align' => '',
		'link_url' => '',
		'link_type' => '',
		'animated' => '',
		'paddingtop' => '',
		'paddingbottom' => ''
	), $atts));

	if ($animated != 'none') {
		$animated = 'animation-standby animated ' .$animated;
	}

	if ($paddingtop>0) {
		$paddingtop = $paddingtop . 'px';
	}
	if ($paddingbottom>0) {
		$paddingbottom = $paddingbottom . 'px';
	}
	if ($link_url=="{{link_url}}") { $link_url=''; }
	if ($link_type=="{{link_type}}") { $link_type=''; }

	$open_link='';
	$close_link='';

	if ($link_url<>"") {
		if ($link_type<>"") {
			if ($link_type=="_blank") {
				$link_target = 'target="_blank"';
			}
			if ($link_type=="_self") {
				$link_target = 'target="_self"';
			}
		}
		$open_link = '<a '.$link_target.'href="'.esc_url($link_url).'">';
		$close_link = '</a>';
	}
	$extra_class = '';
	if ($align == "fullwidth") {
		$align = "center";
		$extra_class = "single-image-fullwidth ";
	}
	$output = '<div class="single-image-block '.$extra_class . $animated.'" style="padding-top:'.$paddingtop.';padding-bottom:'.$paddingbottom.';text-align:'.esc_attr($align).';">';
	$output .= $open_link . '<img src="'.esc_url($image).'" alt="'.esc_attr( mtheme_get_alt_text($imageid) ).'"/>'.$close_link;
	$output .= '</div>';

	return $output;
}

// Contents
function mtheme_displaypagecontent($atts, $content = null) {
	extract(shortcode_atts(array(
		'content' => ''
	), $atts));

	$content = get_the_content();
	$content = apply_filters('the_content', $content);
	$output = do_shortcode($content);
	return $output;
}
add_shortcode('pagecontent', 'mtheme_displaypagecontent');

// Contents
function mtheme_displayrichtext($atts, $content = null) {
	extract(shortcode_atts(array(
		'content_richtext' => ''
	), $atts));
	
	$output = html_entity_decode($content_richtext);
	return $output;
}
add_shortcode('displayrichtext', 'mtheme_displayrichtext');
// TextBox
function mtheme_textbox($atts, $content = null) {
	extract(shortcode_atts(array(
   		'padding_sides' => '0',
		'padding_top' => '0',
		'padding_bottom' => '0',
		'margin_sides' => '0',
		'margin_top' => '0',
		'margin_bottom' => '0',
		'text_color' =>'',
		'background_color' =>'',
		'border_size' => '1',
		'border_color' => '',
		'border_style' => 'solid',
		'content_richtext' => ''
	), $atts));

	if ($padding_top <> 0) {
		$padding_top = $padding_top . 'px';
	}
	if ($padding_bottom <> 0) {
		$padding_bottom = $padding_bottom . 'px';
	}
	if ($padding_sides <> 0) {
		$padding_sides = $padding_sides . 'px';
	}
	if ($margin_top <> 0) {
		$margin_top = $margin_top . 'px';
	}
	if ($margin_bottom <> 0) {
		$margin_bottom = $margin_bottom . 'px';
	}
	if ($margin_sides <> 0) {
		$margin_sides = $margin_sides . 'px';
	}

	$border_size = 'border-width:'.$border_size.'px;';
	$border_color = 'border-color:'.$border_color.';';
	$border_style = 'border-style:'.$border_style.';';
	$padding = 'padding: '.$padding_top. ' ' .$padding_sides.' '.$padding_bottom;
	$margin = 'margin: '.$margin_top. ' ' .$margin_sides.' '.$margin_bottom;
	$background = 'background-color: '.$background_color.';';
	$text_color = 'color: '.$text_color.';';
	$output = '<div style="'.$padding.';'.$margin.';'.$background.$text_color.$border_size.$border_color.$border_style.'">';
	$output .= wpautop(html_entity_decode($content));
	$output .= '</div>';
	return $output;
}
add_shortcode('textbox', 'mtheme_textbox');

// Contents
function mtheme_display_currentyear($atts, $content = null) {
	extract(shortcode_atts(array(
		'content_richtext' => ''
	), $atts));
	
	$output = date('Y');
	return $output;
}
add_shortcode('display_current_year', 'mtheme_display_currentyear');

// Hline
function mtheme_hline($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => 'single',
		'height' => '1',
		'linecolor' => '',
		'top' => '30',
		'bottom' => ''
	), $atts));
	$divider = '';
	$stylecss ='margin-top:'.$top.'px;';
	if ( isSet($bottom) && !empty($bottom) ) {
		$stylecss .= 'margin-bottom:'.$bottom.'px;';
	}
	if ( isSet($linecolor) && !empty($linecolor) ) {
		$stylecss .= 'border-color:'.$linecolor.';';
	}
	if ( isSet($height) && !empty($height) ) {
		$stylecss .= 'border-width:'.$height.'px;';
	}
	$divider .= '<div class="clearfix hline-common hline-'.$style.'" style="'.$stylecss.'"></div>';
	
	return $divider;
}
add_shortcode('hline', 'mtheme_hline');

//Button [button link="yourlink.html"] text [/button]
function mtheme_Modal( $atts, $content = null ) {

   extract( shortcode_atts( array(
      'link' => '#',
      'modal_id' => '',
      'buttontext' => '',
      'button_icon' => '',
	  'target' => '',
	  'button_align' => '',
	  'button_color' => '',
	  'size'=> 'normal',
      ), $atts ) );

    $uniqueID = uniqid();

 $modalwindow_popup = '
 <div class="modal-dimmer" id="'.$modal_id.'">
	 <div class="modal-dimmer-outer">
		 <div class="modal-dimmer-inner md-modal md-effect-2">
		 	<div class="modal-dimmer-text md-content entry-content">
		 	<div class="modal-close-button"><i class="simpleicon-close"></i></div>
		 	'.do_shortcode( wpautop( html_entity_decode($content) ) ).'
		 	</div>
		 </div>
	 </div>
 </div>
 ';
	
	$button = $modalwindow_popup;
	if ($target=="_blank") { $target=' target="_blank"'; }
	if ($button_align=="{{button_align}}") { $button_align=''; }
	if ($button_align=='') {
		$button_align_style='';
	} else {
		$button_align_style= ' style="text-align:'.$button_align.';"';
	}
	$button .= '<div class="button-shortcode button-shortcode-'.$uniqueID.'"'.$button_align_style.'>';
	$button .= '<span data-modalid="'.$modal_id.'" class="modal-trigger-button">';
	$button .= '<div class="mtheme-button animation-standby animated pulse">';
	if (isSet($button_icon) && !empty($button_icon) ) {
		$button .= '<span class="button-icon"><i class="'.$button_icon.'"></i></span>';
	}
	$button .= trim($buttontext);
	$button .= '</div>';
	$button .= '</span>';
	$button .= '</div>';

	if (isSet($button_color) && !empty($button_color) ) {
		$button .= '<style>';
		$button .= '.button-shortcode-'.$uniqueID.' .mtheme-button:after { background-color: '.$button_color.'; }';
		$button .= '.button-shortcode-'.$uniqueID.' .mtheme-button { border-color: '.$button_color.'; color: '.$button_color.'; }';
		$button .= '</style>';
	}
	
   return $button;
}
add_shortcode('modalwindow', 'mtheme_Modal');
?>