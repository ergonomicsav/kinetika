<?php
/**
 * Fullscreen Video
 */
if (isset( $post->ID )) {
	$get_video_from_page_id= get_post_meta( $post->ID, MTHEME . '_video_bgfullscreenpost', true);
	$custom = get_post_custom($get_video_from_page_id);
}
if ( mtheme_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$get_video_from_page_id= get_post_meta( $woo_shop_post_id, MTHEME . '_video_bgfullscreenpost', true);
	$custom = get_post_custom($get_video_from_page_id);
}
$featured_page=$get_video_from_page_id;

$fullscreen_eventbox='';
$custom = get_post_custom($featured_page);
if (isSet($custom[MTHEME . "_html5_poster"][0])) $html5_poster=$custom[MTHEME . "_html5_poster"][0];
if (isSet($custom[MTHEME . "_html5_mp4"][0])) $html5_mp4=$custom[MTHEME . "_html5_mp4"][0];
if (isSet($custom[MTHEME . "_html5_webm"][0])) $html5_webm=$custom[MTHEME . "_html5_webm"][0];
if (isSet($custom[MTHEME . "_html5_ogv"][0])) $html5_ogv=$custom[MTHEME . "_html5_ogv"][0];

$video_control_bar=of_get_option('video_control_bar');
if ( !wp_is_mobile() ) {
?>
<script>
jQuery(document).ready(function($) {
	$(window).load(function() {
	"use strict";
	resizer();
	videojs.options.flash.swf = '<?php echo get_template_directory() . "/js/videojs/video-js.swf"; ?>';
	videojs("videocontainer", {}, function(){
	  // Player (this) is initialized and ready.
	});
	videojs("videocontainer").ready(function(){
	  	var myPlayer = this;
		$('#videocontainer').click(function() {
		if ($('#videocontainer').hasClass('vjs-playing')) {
		     myPlayer.pause();
		}
		if ($('#videocontainer').hasClass('vjs-paused')) {
		     myPlayer.play();
		}
		});
	});
    function resizer() {
        var width = jQuery(window).width();
		var ratio = 16/9;
		var pWidth; // player width, to be defined
		var	height = jQuery(window).height();
		var	pHeight; // player height, tbd
		var	videojs_container = jQuery('#backgroundvideo');
            console.log(width);
        // when screen aspect ratio differs from video, video must center and underlay one dimension

        if (width / ratio < height) { // if new video height < window height (gap underneath)
            pWidth = Math.ceil(height * ratio); // get new player width
            videojs_container.width(pWidth).height(height).css({left: (width - pWidth) / 2, top: 0}); // player width is greater, offset left; reset top
        } else { // new video width < window width (gap to right)
            pHeight = Math.ceil(width / ratio); // get new player height
            videojs_container.width(width).height(pHeight).css({left: 0, top: (height - pHeight) / 2}); // player height is greater, offset top; reset left
        }

    }
    // events
    $(window).resize(function() {
        resizer();
    });

    });
});
</script>
<div id="backgroundvideo" class="html5-background-video">
<video autoplay loop id="videocontainer" class="video-js vjs-default-skin" preload="auto" width="100%" height="100%" poster="<?php echo esc_url($html5_poster); ?>">
	<source src="<?php echo esc_attr($html5_webm); ?>" type="video/webm">
	<source src="<?php echo esc_attr($html5_mp4); ?>" type="video/mp4">
	<source src="<?php echo esc_attr($html5_ogv); ?>" type="video/ogg">
</video>
</div>
<?php
} else {
	$default_bg = $html5_poster;
	if ( has_post_thumbnail()) {
		$default_bg = mtheme_featured_image_link( get_the_id() );		
	}
	if ( $default_bg<>'' ) :
	 	?>
		<script type="text/javascript">
		/* <![CDATA[ */
		jQuery(document).ready(function(){
		<?php
			echo '
				jQuery.backstretch("'.esc_url($default_bg).'", {
					speed: 1000
				});
				';
		?>
		});
		/* ]]> */
		</script>
	 <?php
	 endif;
}