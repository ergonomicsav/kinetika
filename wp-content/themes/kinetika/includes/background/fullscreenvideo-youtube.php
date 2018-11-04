<?php
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
if (isSet($custom[MTHEME . "_fullscreen_eventbox"][0])) $fullscreen_eventbox=$custom[MTHEME . "_fullscreen_eventbox"][0];
if (isSet($custom[MTHEME . "_youtubevideo"][0])) $youtube=$custom[MTHEME . "_youtubevideo"][0];
	if ( !wp_is_mobile() ) {
?>
<div id="backgroundvideo">
</div>
<script>
jQuery(document).ready(function($) {
	var options = { videoId: '<?php echo esc_js($youtube); ?>', wrapperZIndex: -1, start: 0, mute: false, repeat: true, ratio: 16/9 };
	$('#backgroundvideo').tubular(options);
});
</script>
<?php
	} else {
		if ( has_post_thumbnail()) :
			$default_bg = mtheme_featured_image_link( get_the_id() );
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
?>