<?php
/*
* @ Header
*/
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php
	$fav_icon = of_get_option('general_fav_icon');
	if ( isSet($fav_icon) && !empty($fav_icon) ) {
		echo  '<link rel="shortcut icon" href="'.esc_url( $fav_icon ) . '" />';
	}
	wp_head();
	?>
</head>
<body <?php body_class(); ?>>
<?php
do_action('mtheme_contextmenu_msg');
do_action('mtheme_preloader_check');
//Demo Panel if active
do_action('mtheme_demo_panel');
//Check for sidebar choice
do_action('mtheme_get_sidebar_choice');
//Mobile menu
if ( !mtheme_is_fullscreen_home() && !is_404() ) {
	get_template_part('/includes/background/background','display');
}
if ( mtheme_is_fullscreen_home() ) {
	$featured_page=mtheme_get_active_fullscreen_post();
	$custom = get_post_custom( $featured_page );
	if ( isSet($custom[ MTHEME . "_fullscreen_type"][0]) ) {
		$fullscreen_type = $custom[ MTHEME . "_fullscreen_type"][0];
	}
	if ($fullscreen_type=="photowall" || $fullscreen_type=="carousel" ) {
		get_template_part('/includes/background/background','display');
	}
}
if (is_page_template('template-blank.php')) {

	$site_layout_width='fullwidth';

} else {

	get_template_part('/includes/menu/mobile','menu');
	//Header Navigation elements
	get_template_part('header','navigation');
}
echo '<div id="home" class="container-wrapper container-fullwidth">';
if (!mtheme_is_fullscreen_post()) {
	$header_menu_type = of_get_option('header_menu_type');
	if (MTHEME_DEMO_STATUS) {
		if (isSet($_GET['menu_type'])) {
			$header_menu_type = mtheme_demo_data_fetch($_GET['menu_type']);
		}
	}
	if ($header_menu_type=="vertical-menu") {
		echo '<div class="vertical-menu-body-container">';
	}
}
if (!is_page_template('template-blank.php') && !mtheme_is_fullscreen_post() ) {
	get_template_part('header','title');
}
$post_type = get_post_type( get_the_ID() );
$custom = get_post_custom( get_the_ID() );
$mtheme_pagestyle='';
$header_menu_type = of_get_option('header_menu_type');
if (MTHEME_DEMO_STATUS) {
	if (isSet($_GET['menu_type'])) {
		$header_menu_type = mtheme_demo_data_fetch($_GET['menu_type']);
	}
}
if ($header_menu_type == "boxed-header-middle" || $header_menu_type == "boxed-header-left") {
	echo '<div class="vertical-left-bar"></div>';
	echo '<div class="vertical-right-bar"></div>';
}
if (isset($custom[MTHEME . '_pagestyle'][0])) { $mtheme_pagestyle=$custom[MTHEME . '_pagestyle'][0]; }
if (!mtheme_is_fullscreen_post()) {
	echo '<div class="container clearfix">';
}
?>