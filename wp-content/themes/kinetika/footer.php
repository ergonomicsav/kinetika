<?php
/*
* Footer
*/
?>
<?php
function mtheme_display_bg_image() {
	global $mtheme_bg_image_script;
	if ( isSet($mtheme_bg_image_script) ){
		echo $mtheme_bg_image_script;
	}
}
if ( mtheme_is_fullscreen_post() ) {
	$fullscreen_type = mtheme_get_fullscreen_type();
	if ($fullscreen_type=="photowall") {
		add_action( 'wp_footer', 'mtheme_display_bg_image');
	}
	if ($fullscreen_type=="carousel") {
		add_action( 'wp_footer', 'mtheme_display_bg_image');
	}
}
?>
<div class="contentclearfix clearfix"></div>
</div>
<footer>
<?php
$footer_info = stripslashes_deep( of_get_option('footer_copyright') );
if (mtheme_is_fullscreen_post() ) {
	$custom = get_post_custom( get_the_ID() );
	$header_menu_type = of_get_option('header_menu_type');
	if (MTHEME_DEMO_STATUS) {
		if (isSet($_GET['menu_type'])) {
			$header_menu_type = mtheme_demo_data_fetch($_GET['menu_type']);
		}
	}
	if ($header_menu_type <> "vertical-menu") {

		if ( is_active_sidebar( 'fullscreen_footer' ) ) {
			$fullscreen_widgets_active = '';
		} else {
			$fullscreen_widgets_active = ' fullscreen-footer-fullwidth';
		}
?>
<div class="fullscreen-footer-wrap<?php echo $fullscreen_widgets_active; ?>">
	<div class="fullscreen-footer-info">
	<?php echo do_shortcode( $footer_info ); ?>
	</div>
	<?php
	if ( is_active_sidebar( 'fullscreen_footer' ) ) {
	?>
	<div class="fullscreen-footer-social">
		<div class="login-socials-wrap clearfix">
		<?php
		dynamic_sidebar('fullscreen_footer');
		?>
		</div>
	</div>
	<?php
	}
	?>
</div>
<?php
	}
}
if ( !wp_is_mobile() ) {
?>
<div id="goto-top" title="top of page"><i class="fa fa-chevron-up"></i></div>
<?php
}
if ( !mtheme_is_fullscreen_post() ) {
	add_action( 'wp_footer', 'mtheme_display_bg_image');
}
if (!is_page_template('template-blank.php') && !mtheme_is_fullscreen_post() ) {
	if (of_get_option('footerwidget_status') && is_active_sidebar( 'footer_1' ) ) {
	?>
	<div class="footer-container-wrap clearfix">
		<div class="footer-container clearfix">
			<div id="footer" class="sidebar widgetized clearfix">
				<?php 
					echo '<div class="footer-column">';
					dynamic_sidebar("footer_1");  
					echo '</div>';
				?>
			</div>	
		</div>
	</div>
	<?php
	} else {
		//echo '<div class="footer-margin"></div>';
	}
	?>
<?php
	$header_menu_type = of_get_option('header_menu_type');
	echo '<div id="copyright">';
	echo do_shortcode( $footer_info );
	echo '</div>';
?>
<?php
} // end of blank template check
?>
</footer>
<?php
if (!mtheme_is_fullscreen_post()) {
	$header_menu_type = of_get_option('header_menu_type');
	if (MTHEME_DEMO_STATUS) {
		if (isSet($_GET['menu_type'])) {
			$header_menu_type = mtheme_demo_data_fetch($_GET['menu_type']);
		}
	}
	if ($header_menu_type=="vertical-menu") {
		echo '</div>';
	}
	echo '</div>';
}
?>
<?php
wp_footer();
?>
</body>
</html>