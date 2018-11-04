<?php
global $wp_version;
// CUSTOM ADMIN LOGIN HEADER LOGO
function mtheme_custom_login_logo()  
{
	$wp_login_width = of_get_option('wplogin_width');
	$wplogin_height = of_get_option('wplogin_height');

	if ( $wp_login_width == 0 || $wp_login_width == '' ) {
		$wp_login_width = '320';
	}
	if ( $wplogin_height == 0 || $wplogin_height == '' ) {
		$wplogin_height = '220';
	}

	if ( of_get_option('wplogin_logo') ) {
		echo '<style type="text/css">#login h1 a { width:'.$wp_login_width.'px; height:'.$wplogin_height.'px; background-size:'.$wp_login_width.'px !important; background-image:url('.of_get_option('wplogin_logo').')  !important; } </style>';  
	}

}
add_action('login_head',  'mtheme_custom_login_logo');
/*-------------------------------------------------------------------------*/
/* Inject Theme path to JS scripts */
/*-------------------------------------------------------------------------*/
function mtheme_path_to_js_script() { 
	// Load only if its theme options
	if ('admin.php' == basename($_SERVER['PHP_SELF'])) {
	?>
		<script type="text/javascript">
		var mtheme_uri="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>";
		</script>
		<?php
	}
}
add_action('admin_head', 'mtheme_path_to_js_script');
/*-------------------------------------------------------------------------*/
/* Admin JS and CSS */
/*-------------------------------------------------------------------------*/
function mtheme_adminscripts() {

	// Load if Theme Options or if in Post Edit mode
	if ( 'edit.php' == basename($_SERVER['PHP_SELF']) || 'post-new.php' == basename($_SERVER['PHP_SELF']) || 'post.php' == basename($_SERVER['PHP_SELF'])) {
        function mtheme_post_edit_scripts(){
            $file_dir=get_template_directory_uri();
    		wp_enqueue_style("styles", $file_dir ."/framework/admin/css/style.css", false, "1.0", "all");
    		wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-datepicker');
    		wp_enqueue_script('jquery-ui-slider');
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script('wp-color-picker');
        }
        add_action('admin_enqueue_scripts', 'mtheme_post_edit_scripts');
	}
	if ('post-new.php' == basename($_SERVER['PHP_SELF']) || 'post.php' == basename($_SERVER['PHP_SELF'])) {
        function mtheme_post_new_scripts(){
            $file_dir=get_template_directory_uri();
    		wp_enqueue_script("postmeta", $file_dir."/framework/admin/js/postmetaboxes.js?ver=1.0", array( 'jquery' ), "1.0",false);
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script('wp-color-picker');
        }
        add_action('admin_enqueue_scripts', 'mtheme_post_new_scripts');
	}
}
add_action('admin_menu', 'mtheme_adminscripts');
?>