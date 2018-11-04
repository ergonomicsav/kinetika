<?php
/*
404 Page
*/
?>
 
<?php get_header(); ?>

<?php
$default_bg= of_get_option('general_background_image');
$default_404_bg= of_get_option('general_404_image');
if (!isSet($default_404_bg) || $default_404_bg == "") {
	$default_404_bg = $default_bg;
}
if (isSet($default_404_bg) && $default_404_bg<>"") {
?>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function(){
<?php
	echo '
		jQuery.backstretch("'.esc_url($default_404_bg).'", {
			speed: 1000
		});
		';
?>
});
/* ]]> */
</script>
<?php
}
?>
<div class="page-contents-wrap">
	<div class="entry-page-wrapper entry-content clearfix">
		<div class="mtheme-404-wrap mtheme-vh-center">
			<div class="mtheme-404-icon">
				<i class="feather-icon-help"></i>
			</div>
			<?php
			$error_msg = of_get_option('404_title');
			if ($error_msg=="") {
				$error_msg = '404 Page not Found!';
			}
			?>
			<div class="mtheme-404-error-message1"><?php echo esc_attr($error_msg); ?></div>
			<h4><?php _e( 'Would you like to search for the page', 'mthemelocal' ); ?></h4>
			<?php get_search_form(); ?>
		</div>
	</div><!-- .entry-content -->
</div>

<?php get_footer(); ?>