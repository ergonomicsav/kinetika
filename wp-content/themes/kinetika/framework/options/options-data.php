<?php
/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */
function optionsframework_options() {
	
	// Pull all Google Fonts using API into an array
	//$fontArray = unserialize($fontsSeraliazed);
	$options_fonts = mtheme_google_fonts();
	
	// Pull all the categories into an array
	$options_categories = array(); 
	array_push($options_categories, "All Categories");
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();
	array_push($options_pages, "Not Selected"); 
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	if ($options_pages_obj) {
		foreach ($options_pages_obj as $page) {
			$options_pages[$page->ID] = $page->post_title;
		}
	}
	
	// Pull all the Featured into an array
	$featured_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');
	if ($featured_pages) {
		foreach($featured_pages as $key => $list) {
			$custom = get_post_custom($list->ID);
			if ( isset($custom["fullscreen_type"][0]) ) { 
				$slideshow_type=' ('.$custom["fullscreen_type"][0].')'; 
			} else {
			$slideshow_type="";
			}
			$options_featured[$list->ID] = $list->post_title . $slideshow_type;
		}
	} else {
		$options_featured[0]="Featured pages not found.";
	}
	
	// Pull all the Featured into an array
	$bg_slideshow_pages = mtheme_get_select_target_options('fullscreen_slideshow_posts');
	
	// Pull all the Portfolio into an array
	$portfolio_pages = get_posts('post_type=mtheme_portfolio&orderby=title&numberposts=-1&order=ASC');
	if ($portfolio_pages) {
		foreach($portfolio_pages as $key => $list) {
			$custom = get_post_custom($list->ID);
			$portfolio_list[$list->ID] = $list->post_title;
		}
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/framework/options/images/';
	$theme_imagepath =  get_template_directory_uri() . '/images/';
	$predefined_background_imagepath =  get_template_directory_uri() . '/images/titlebackgrounds/';
		
	$options = array();
		
$options[] = array( "name"			=> __("General", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Theme Style", "mthemelocal" ),
						"desc"			=> __( "Styles found in theme root : style.css / style-light.css", 'mthemelocal' ),
						"id"			=> "theme_style",
						"std"			=> "dark",
						"type"			=> "images",
						"options"	=> array(
							'dark' 		=> $imagepath . 'dark.png',
							'light'		=> $imagepath . 'light.png')
						);

	$options[] = array( "name" => __( "Menu type", 'mthemelocal' ),
						"desc" => __( "Menu type", 'mthemelocal' ),
						"id" => "header_menu_type",
						"std" => "header-middle",
						"type" => "images",
						"options" => array(
							'header-middle'	=> $imagepath . 'middle-menu.png',
							'header-center'	=> $imagepath . 'center-menu.png',
							'header-left'	=> $imagepath . 'left-menu.png',
							'vertical-menu'	=> $imagepath . 'vertical-menu.png',
							'boxed-header-middle'	=> $imagepath . 'boxed-middle-menu.png',
							'boxed-header-left'	=> $imagepath . 'boxed-left-menu.png',
							'minimal-header'	=> $imagepath . 'simple-toggle-menu.png')
						);

	$options[] = array( "name"			=> __( "Disable Comments in Pages", 'mthemelocal' ),
						"desc"			=> __( "Disables comments in pages even if comments are enabled in page settings.", 'mthemelocal' ),
						"id"			=> "disable_pagecomments",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __( "Add Facebook Opengraph Meta tags", 'mthemelocal' ),
						"desc"			=> __( "Adds meta tags to recognize featured image , title and decription used in posts and pages.", 'mthemelocal' ),
						"id"			=> "opengraph_status",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Google Map API Key. ( Required to display GMap by Google )","mthemelocal"),
						"desc"			=> __("Goole map now requires an API key to display google maps. How to get a <a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>Google Map API Key</a>","mthemelocal"),
						"id"			=> "googlemap_apikey",
						"std"			=> "Google Map API Key",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name" => __("Custom CSS", "mthemelocal" ),
					"type" => "heading");

	$options[] = array( "name" => __("Custom CSS", "mthemelocal" ),
						"desc" => __("You can include custom CSS to this field.<br/> eg. <code>.entry-title h1 { font-family: 'Lobster', cursive; }</code>", "mthemelocal" ),
						"id" => "custom_css",
						"std" => '',
						"class" => "big",
						"type" => "textarea");

	$options[] = array( "name" => __("Mobile Specific CSS", "mthemelocal" ),
						"desc" => __("Only for mobile specific CSS.<br/> eg. <code>.entry-title h1 { font-family: 'Lobster', cursive; }</code>", "mthemelocal" ),
						"id" => "mobile_css",
						"std" => '',
						"class" => "big",
						"type" => "textarea");

	$options[] = array( "name" => __("Fav icons", "mthemelocal" ),
					"type" => "heading");

	$options[] = array( "name"			=> __( 'Fav icon file', 'mthemelocal' ),
						"desc"			=> __( "Customize with your fav icon. The fav icon is displayed in the browser window", 'mthemelocal' ),
						"id"			=> "general_fav_icon",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( 'Apple fav icon', 'mthemelocal' ),
						"desc"			=> __( "Add to Home screen image icon. Image to represent webpage link to the Home screen for iOS ( 180px X 180px )", 'mthemelocal' ),
						"id"			=> "general_apple_icon",
						"type"			=> "upload");

$options[] = array( "name"			=> __("Horizontal Menu Logo", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Horizontal Menu Logo", 'mthemelocal' ),
						"desc"			=> __( "Upload logo for header", 'mthemelocal' ),
						"id"			=> "main_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( "Logo Width", 'mthemelocal' ),
						"desc"			=> __( "Logo width in pixels", 'mthemelocal' ),
						"id"			=> "logo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "154",
						"type"			=> "text");
						
	$options[] = array( "name"			=> __( "Top Space", 'mthemelocal' ),
						"desc"			=> __( "Top spacing for logo ( 0 sets default )", 'mthemelocal' ),
						"id"			=> "logo_topmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "28",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Left Space", 'mthemelocal' ),
						"desc"			=> __( "Left spacing for logo ( 0 sets default )", 'mthemelocal' ),
						"id"			=> "logo_leftmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Sticky Menu Logo ( Optional )", 'mthemelocal' ),
						"desc"			=> __( "Upload sticky menu logo", 'mthemelocal' ),
						"id"			=> "sticky_main_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( "Sticky Logo Width", 'mthemelocal' ),
						"desc"			=> __( "Sticky Logo width in pixels", 'mthemelocal' ),
						"id"			=> "sticky_logo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "154",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Sticky Top Space", 'mthemelocal' ),
						"desc"			=> __( "Sticky Top spacing for logo ( 0 sets default )", 'mthemelocal' ),
						"id"			=> "sticky_logo_topmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

$options[] = array( "name"			=> __("Vertical Menu Logo", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Vertical Menu Logo", 'mthemelocal' ),
						"desc"			=> __( "Upload logo for header", 'mthemelocal' ),
						"id"			=> "vmain_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( "Vertical Menu Logo Width", 'mthemelocal' ),
						"desc"			=> __( "Vertical Menu Logo width in pixels", 'mthemelocal' ),
						"id"			=> "vlogo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "300",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Top Space", 'mthemelocal' ),
						"desc"			=> __( "Top spacing for logo ( 0 sets default )", 'mthemelocal' ),
						"id"			=> "vlogo_topmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Left Space", 'mthemelocal' ),
						"desc"			=> __( "Left spacing for logo ( 0 sets default )", 'mthemelocal' ),
						"id"			=> "vlogo_leftmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

$options[] = array( "name"			=> __("Responsive Logo", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Responsive/Mobile Logo", 'mthemelocal' ),
						"desc"			=> __( "Upload logo for responsive layout.", 'mthemelocal' ),
						"id"			=> "responsive_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( "Responsive Logo Width", 'mthemelocal' ),
						"desc"			=> __( "Responsive Logo width in pixels", 'mthemelocal' ),
						"id"			=> "responsive_logo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Responsive Logo Top Space", 'mthemelocal' ),
						"desc"			=> __( "Top spacing for logo ( 0 sets default )", 'mthemelocal' ),
						"id"			=> "responsive_logo_topmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

$options[] = array( "name"			=> __("WP Login Logo", "mthemelocal" ),
					"type"			=> "heading");
						
	$options[] = array( "name"			=> __( "Custom WordPress Login Page Logo", 'mthemelocal' ),
						"desc"			=> __( "Upload logo for WordPress Login Page", 'mthemelocal' ),
						"id"			=> "wplogin_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( "WP Login logo Width", 'mthemelocal' ),
						"desc"			=> __( "Define Logo width in pixels", 'mthemelocal' ),
						"id"			=> "wplogin_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "300",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "WP Login logo Height", 'mthemelocal' ),
						"desc"			=> __( "Define Logo height in pixels", 'mthemelocal' ),
						"id"			=> "wplogin_height",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "300",
						"type"			=> "text");

$options[] = array( "name"			=> __("Preloader", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Preloader screen Logo ( required )", 'mthemelocal' ),
						"desc"			=> __( "Upload logo for preloader screen.", 'mthemelocal' ),
						"id"			=> "preloader_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( "Preloader Logo Width", 'mthemelocal' ),
						"desc"			=> __( "Preloader Logo width in pixels", 'mthemelocal' ),
						"id"			=> "preloader_logo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

		$options[] = array( "name"			=> __( "Preloader progress bar color", "mthemelocal" ),
							"desc"			=> __( "Preloader progress bar color", "mthemelocal" ),
							"id"			=> "preloader_color",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Preloader screen color", "mthemelocal" ),
							"desc"			=> __( "Preloader screen color", "mthemelocal" ),
							"id"			=> "preloader_bgcolor",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name" => __("Right Click", "mthemelocal" ),
					"type" => "heading");

	$options[] = array( "name" => __("Disable Right Click", "mthemelocal" ),
						"desc" => __("Disable right clicking.", "mthemelocal" ),
						"id" => "rightclick_disable",
						"std" => "0",
						"type" => "checkbox");

	$options[] = array( "name" => __("Right Click Message ( RCM )", "mthemelocal" ),
						"desc" => __("This text appears in the popup when right click is disabled.", "mthemelocal" ),
						"id" => "rightclick_disabletext",
						"std" => "You can enable/disable right clicking from Theme Options and customize this message too.",
						"type" => "textarea");

		$options[] = array( "name"			=> __( "RCM text color", "mthemelocal" ),
							"desc"			=> __( "RCM text color", "mthemelocal" ),
							"id"			=> "rcm_textcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "RCM background color", "mthemelocal" ),
							"desc"			=> __( "RCM background color", "mthemelocal" ),
							"id"			=> "rcm_bgcolor",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name"			=> __("RCM title size", "mthemelocal" ),
						"desc"			=> __("RCM title size in pixels. eg. 19", "mthemelocal" ),
						"id"			=> "rcm_size",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> __("RCM title letter spacing", "mthemelocal" ),
						"desc"			=> __("RCM title letter spacing in pixels. eg. 1", "mthemelocal" ),
						"id"			=> "rcm_letterspacing",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> __("RCM title weight", "mthemelocal" ),
						"desc"			=> __("RCM title weight. eg. 100, 200, 300, 400, 500, 600, 700, 800, 900", "mthemelocal" ),
						"id"			=> "rcm_weight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");


$options[] = array( "name"			=> __("Fullscreen Toggle", "mthemelocal" ),
					"type"			=> "heading");

		$options[] = array( "name" => __( "Disable Fullscreen Toggle Sitewide", 'mthemelocal' ),
							"desc" => __( "Disable Fullscreen Toggle.", 'mthemelocal' ),
							"id" => "disable_fullscreentoggle",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => __( "Fullscreen Toggle on Fullscreen Posts only", 'mthemelocal' ),
							"desc" => __( "Fullscreen Toggle on Fullscreen Posts only.", 'mthemelocal' ),
							"id" => "fullscreen_fullscreentoggle",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => __( "Fullscreen Toggle on Homepage only", 'mthemelocal' ),
							"desc" => __( "Fullscreen Toggle on Homepage Posts only.", 'mthemelocal' ),
							"id" => "fullscreen_homepagetoggle",
							"std" => "0",
							"type" => "checkbox");

$options[] = array( "name"			=> __("Background", "mthemelocal" ),
					"type"			=> "heading");	
						
	$options[] = array( "name" => __( "Background color", 'mthemelocal' ),
						"desc" => __( "No color selected by default.", 'mthemelocal' ),
						"id" => "general_background_color",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => __( "General Background Fullscreen Slideshow Page", 'mthemelocal' ),
						"desc" => __( "General Background Fullscreen Slideshow Page.", 'mthemelocal' ),
						"id" => "general_bgslideshow",
						"std" => "",
						"type" => "selectyper",
						"class" => "small",
						"options" => $bg_slideshow_pages);

	$options[] = array( "name" => __( "Fullscreen Password protected Background", 'mthemelocal' ),
						"desc" => __( "Upload background image for password protected fullscreen posts", 'mthemelocal' ),
						"id" => "general_passwordprotected_image",
						"type" => "upload");
						
	$options[] = array( "name" => __( "Background image ( required for archive pages )", 'mthemelocal' ),
						"desc" => __( "Upload background image", 'mthemelocal' ),
						"id" => "general_background_image",
						"type" => "upload");

	$options[] = array( "name" => __( "Photo Story archive background image", 'mthemelocal' ),
						"desc" => __( "Upload background image", 'mthemelocal' ),
						"id" => "photostory_background_image",
						"type" => "upload");

		$options[] = array( "name" => __( "Apply custom Page Opacity and Color", 'mthemelocal' ),
							"desc" => __( "Apply custom Page opacity.", 'mthemelocal' ),
							"id" => "page_opacity_customize",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name"			=> __( "Page background color", "mthemelocal" ),
							"desc"			=> __( "Page background color", "mthemelocal" ),
							"id"			=> "page_background",
							"std"			=> "",
							"type"			=> "color");

			$options[] = array( "name" => __( "Page background opacity ( default 85 )", 'mthemelocal' ),
								"desc" => __( "Page background opacity", 'mthemelocal' ),
								"id" => "page_background_opacity",
								"min" => "0",
								"max" => "100",
								"step" => "0",
								"unit" => '%',
								"std" => "85",
								"type" => "text");

$options[] = array( "name" => __("404", "mthemelocal" ),
					"type" => "heading");

		$options[] = array( "name" => __( "404 Background image ( for page not found. Optional )", 'mthemelocal' ),
							"desc" => __( "Upload background image", 'mthemelocal' ),
							"id" => "general_404_image",
							"type" => "upload");
						
		$options[] = array( "name"			=> __("404 Page title", "mthemelocal" ),
						"desc"			=> __("404 Page not Found!", "mthemelocal" ),
						"id"			=> "404_title",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name" => __("Fullscreen Homepage", "mthemelocal" ),
					"type" => "heading");

	$options[] = array( "name" => __( "Enable Fullscreen Hompage", 'mthemelocal' ),
						"desc" => __( "Enable fullscreen homepage.", 'mthemelocal' ),
						"id" => "fullcscreen_henable",
						"std" => "disable",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'disable' => "No",
							'enable' => "Yes")
						);

	$options[] = array( "name" => __( "Select Fullscreen Home", 'mthemelocal' ),
						"desc" => __( "Requires existing fullscreen posts.", 'mthemelocal' ),
						"id" => "fullcscreen_hselected",
						"std" => "",
						"type" => "select",
						"class" => "small",
						"options" => mtheme_get_select_target_options('fullscreen_posts')
						);

$options[] = array( "name" => __("Fullscreen Events box", "mthemelocal" ),
					"type" => "heading",
					"subheading"			=> 'header_section_order');

	$options[] = array( "name"			=> __("Event box title","mthemelocal"),
						"desc"			=> __("Event box title","mthemelocal"),
						"id"			=> "event_box_title",
						"std"			=> "Upcoming Events",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name" => __( "Fullscreen events box limit", 'mthemelocal' ),
						"desc" => __( "Fullscreen events box limit ( 0 for unimited )", 'mthemelocal' ),
						"id" => "events_box_limit",
						"min" => "0",
						"max" => "100",
						"step" => "0",
						"unit" => 'items',
						"std" => "0",
						"type" => "text");

	$options[] = array( "name" => __( "Fullscreen Events autoplay", 'mthemelocal' ),
						"desc" => __( "Fullscreen Events autoplay", 'mthemelocal' ),
						"id" => "events_autoplay",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'true' => "Yes",
							'false' => "No")
						);

$options[] = array( "name" => __("Fullscreen Portfolio box", "mthemelocal" ),
					"type" => "heading",
					"subheading"			=> 'header_section_order');

	$options[] = array( "name"			=> __("Fullscreen Portfolio box title","mthemelocal"),
						"desc"			=> __("Fullscreen Portfolio box title","mthemelocal"),
						"id"			=> "portfolio_box_title",
						"std"			=> "In Portfolio",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name" => __( "Fullscreen portfolio box limit", 'mthemelocal' ),
						"desc" => __( "Fullscreen portfolio box limit ( 0 for unimited )", 'mthemelocal' ),
						"id" => "portfolio_box_limit",
						"min" => "0",
						"max" => "100",
						"step" => "0",
						"unit" => 'items',
						"std" => "0",
						"type" => "text");

	$options[] = array( "name" => __( "Fullscreen Portfolio autoplay", 'mthemelocal' ),
						"desc" => __( "Fullscreen Portfolio autoplay", 'mthemelocal' ),
						"id" => "portfoliobox_autoplay",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'true' => "Yes",
							'false' => "No")
						);

$options[] = array( "name" => __("Fullscreen Blog box", "mthemelocal" ),
					"type" => "heading",
					"subheading"			=> 'header_section_order');

	$options[] = array( "name"			=> __("Fullscreen Blog box title","mthemelocal"),
						"desc"			=> __("Fullscreen Blog box title","mthemelocal"),
						"id"			=> "blog_box_title",
						"std"			=> "Recently in Blog",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name" => __( "Fullscreen blog box limit", 'mthemelocal' ),
						"desc" => __( "Fullscreen blog box limit ( 0 for unimited )", 'mthemelocal' ),
						"id" => "blog_box_limit",
						"min" => "0",
						"max" => "100",
						"step" => "0",
						"unit" => 'items',
						"std" => "0",
						"type" => "text");

	$options[] = array( "name" => __( "Fullscreen Blog autoplay", 'mthemelocal' ),
						"desc" => __( "Fullscreen Blog autoplay", 'mthemelocal' ),
						"id" => "blogbox_autoplay",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'true' => "Yes",
							'false' => "No")
						);

$options[] = array( "name" => __("Fullscreen Worktype box", "mthemelocal" ),
					"type" => "heading",
					"subheading"			=> 'header_section_order');

	$options[] = array( "name"			=> __("Fullscreen Worktype box title","mthemelocal"),
						"desc"			=> __("Fullscreen Worktype box title","mthemelocal"),
						"id"			=> "worktype_box_title",
						"std"			=> "Recently in Worktype",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name" => __( "Fullscreen Worktype box limit", 'mthemelocal' ),
						"desc" => __( "Fullscreen Worktype box limit ( 0 for unimited )", 'mthemelocal' ),
						"id" => "worktype_box_limit",
						"min" => "0",
						"max" => "100",
						"step" => "0",
						"unit" => 'items',
						"std" => "0",
						"type" => "text");

	$options[] = array( "name" => __( "Fullscreen Worktype autoplay", 'mthemelocal' ),
						"desc" => __( "Fullscreen Worktype autoplay", 'mthemelocal' ),
						"id" => "worktypebox_autoplay",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'true' => "Yes",
							'false' => "No")
						);

$options[] = array( "name" => __("Fullscreen WooCommerce box", "mthemelocal" ),
					"type" => "heading",
					"subheading"			=> 'header_section_order');

	$options[] = array( "name"			=> __("WooCommerce box title","mthemelocal"),
						"desc"			=> __("WooCommerce box title","mthemelocal"),
						"id"			=> "woocommerce_box_title",
						"std"			=> "Featured Products",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name" => __( "Fullscreen WooCommerce box limit", 'mthemelocal' ),
						"desc" => __( "Fullscreen WooCommerce box limit ( 0 for unimited )", 'mthemelocal' ),
						"id" => "woocommerce_box_limit",
						"min" => "0",
						"max" => "100",
						"step" => "0",
						"unit" => 'items',
						"std" => "0",
						"type" => "text");

	$options[] = array( "name" => __( "Fullscreen WooCommerce autoplay", 'mthemelocal' ),
						"desc" => __( "Fullscreen WooCommerce autoplay", 'mthemelocal' ),
						"id" => "woocommerce_autoplay",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'true' => "Yes",
							'false' => "No")
						);

$options[] = array( "name" => __("Fullscreen Media", "mthemelocal" ),
					"type" => "heading");
					
	$options[] = array( "name" => "Audio Settings",
						"type" => "info");
					
	$options[] = array( "name" => __( "Loop Audio Clip", 'mthemelocal' ),
						"desc" => __( "Loop the audio clip for fullscreen slideshows", 'mthemelocal' ),
						"id" => "audio_loop",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "On-start volume", 'mthemelocal' ),
						"desc" => __( "Volume to start with", 'mthemelocal' ),
						"id" => "audio_volume",
						"min" => "1",
						"max" => "100",
						"step" => "0",
						"unit" => '%',
						"std" => "75",
						"type" => "text");
						
	$options[] = array( "name" => __("Slideshow Settings", "mthemelocal" ),
						"type" => "info");

	$options[] = array( "name" => __("Disable Slideshow Progress Bar", "mthemelocal" ),
						"desc" => __("Disable slideshow progress bar", "mthemelocal" ),
						"id" => "hprogressbar_disable",
						"std" => "0",
						"type" => "checkbox");

		$options[] = array( "name" => __("Disable Slideshow Play button", "mthemelocal" ),
							"desc" => __("Disable slideshow play button", "mthemelocal" ),
							"id" => "hplaybutton_disable",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => __("Disable Slideshow Navigation Arrows", "mthemelocal" ),
							"desc" => __("Disable navigation arrows", "mthemelocal" ),
							"id" => "hnavigation_disable",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => __("Disable Slideshow Count", "mthemelocal" ),
							"desc" => __("Disable slideshow Count", "mthemelocal" ),
							"id" => "hcount_disable",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => __("Disable Slideshow Control bar", "mthemelocal" ),
							"desc" => __("Disable slideshow Control bar", "mthemelocal" ),
							"id" => "hcontrolbar_disable",
							"std" => "0",
							"type" => "checkbox");
						
	// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left					
	$options[] = array( "name" => __( "Transition", 'mthemelocal' ),
						"desc" => __( "Transition type", 'mthemelocal' ),
						"id" => "slideshow_transition",
						"std" => "1",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'1' => "Fade",
							'2' => "Slide Top",
							'3' => "Slide Right",
							'4' => "Slide Bottom",
							'5' => "Slide Left",
							'6' => "Carousel Right",
							'7' => "Carousel Left",
							'0' => "None")
						);
						
	$options[] = array( "name" => __( "Auto Play Slideshow", 'mthemelocal' ),
						"desc" => __( "Auto start slideshow on load", 'mthemelocal' ),
						"id" => "slideshow_autoplay",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Pause on last slide", 'mthemelocal' ),
						"desc" => __( "Pause on end of slideshow", 'mthemelocal' ),
						"id" => "slideshow_pause_on_last",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Pause on hover", 'mthemelocal' ),
						"desc" => __( "Pause slideshow on hover", 'mthemelocal' ),
						"id" => "slideshow_pause_hover",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Vertical center", 'mthemelocal' ),
						"desc" => __( "Vertical center images", 'mthemelocal' ),
						"id" => "slideshow_vertical_center",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Horizontal center", 'mthemelocal' ),
						"desc" => __( "Horizontal center images", 'mthemelocal' ),
						"id" => "slideshow_horizontal_center",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Fit portrait", 'mthemelocal' ),
						"desc" => __( "Portrait images will not exceed browser height", 'mthemelocal' ),
						"id" => "slideshow_portrait",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Fit Landscape", 'mthemelocal' ),
						"desc" => __( "Landscape images will not exceed browser width", 'mthemelocal' ),
						"id" => "slideshow_landscape",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Fit Always", 'mthemelocal' ),
						"desc" => __( "Image will never exceed browser width or height.", 'mthemelocal' ),
						"id" => "slideshow_fit_always",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => __( "Slide Interval", "mthemelocal" ),
						"desc" => __( "Length between transitions", "mthemelocal" ),
						"id" => "slideshow_interval",
						"min" => "500",
						"max" => "20000",
						"step" => "0",
						"unit" => 'px',
						"std" => "8000",
						"type" => "text");
						
	$options[] = array( "name" => __( "Transition speed", "mthemelocal" ),
						"desc" => __( "Speed of transition", "mthemelocal" ),
						"id" => "slideshow_transition_speed",
						"std" => "1000",
						"min" => "500",
						"max" => "20000",
						"step" => "0",
						"unit" => 'px',
						"type" => "text");

$options[] = array( "name"			=> __("Events", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name" => __( "Events Time format", 'mthemelocal' ),
						"desc" => __( "Events Time format", 'mthemelocal' ),
						"id" => "events_time_format",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'conventional' => "AM/PM",
							'24hr' => "24 Hrs")
						);

	$options[] = array( "name"			=> __("Event gallery title","mthemelocal"),
						"desc"			=> __("Event gallery title","mthemelocal"),
						"id"			=> "event_gallery_title",
						"std"			=> "Events",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Events gallery sort order", "mthemelocal" ),
						"desc"			=> __( "Events gallery sort order", 'mthemelocal' ),
						"id"			=> "event_sort_order",
						"std"			=> "default",
						"type"			=> "select",
						"options"	=> array(
							'default'		=> __("Default ( Manual sort )", "mthemelocal" ),
							'event_start' 	=> __("Event start ( DESC )", "mthemelocal" ),
							'event_start_asc' 	=> __("Event start ( ASC )", "mthemelocal" ))
						);

	$options[] = array(	"name"			=> __("Prefered events archive page", "mthemelocal" ),
						"desc"			=> __("Prefered events archive page.", "mthemelocal" ),
						"id"			=> "events_archive_page",
						"std"			=> '',
						"type"			=> "selectyper",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_pages);

	$options[] = array( "name"			=> __("Number of thumbnail columns for Events archive listing", "mthemelocal" ),
						"desc"			=> __("Affects events archives. eg. Browsing Events category links.", "mthemelocal" ),
						"id"			=> "event_achivelisting",
						"min"			=> "1",
						"max"			=> "4",
						"step"			=> "0",
						"unit"			=> 'columns',
						"std"			=> "3",
						"type"			=> "text");

	$options[] = array( "name" => __( "Pagination for archive ( set 0 to display all )", "mthemelocal" ),
						"desc" => __( "Pagination for archive ( set 0 to display all )", "mthemelocal" ),
						"id" => "events_archive_pagination",
						"std" => "6",
						"min" => "0",
						"max" => "40",
						"step" => "0",
						"unit" => 'items',
						"type" => "text");

	$options[] = array( "name"			=> __("Postponed message","mthemelocal"),
						"desc"			=> __("Message for postponed events","mthemelocal"),
						"id"			=> "events_postponed_msg",
						"std"			=> "Event Postponed",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Cancelled message","mthemelocal"),
						"desc"			=> __("Message for cancelled events","mthemelocal"),
						"id"			=> "events_cancelled_msg",
						"std"			=> "Event Cancelled",
						"class"			=> "tiny",
						"type"			=> "text");

$options[] = array( "name"			=> __("Portfolios", "mthemelocal" ),
					"type"			=> "heading");
					
	$options[] = array( "name"			=> __("Enable comments", "mthemelocal" ),
						"desc"			=> __("Enable comments for portfolio items. Switching off will disable comments and comment information on portfolio thumbnails.", "mthemelocal" ),
						"id"			=> "portfolio_comments",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __( "Default portfolio archive list orientation", "mthemelocal" ),
						"desc"			=> __( "Default portfolio archive list orientation", 'mthemelocal' ),
						"id"			=> "portfolio_archive_format",
						"std"			=> "landscape",
						"type"			=> "select",
						"options"	=> array(
							'landscape'		=> 'Landscape',
							'portrait' 		=> 'Portrait')
						);

	$options[] = array(	"name"			=> __("Prefered portfolio archive page", "mthemelocal" ),
						"desc"			=> __("Prefered portfolio archive page.", "mthemelocal" ),
						"id"			=> "portfolio_archive_page",
						"std"			=> '',
						"type"			=> "selectyper",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_pages);

	$options[] = array( "name"			=> __("Number of thumbnail columns for Portfolio archive listing", "mthemelocal" ),
						"desc"			=> __("Affects portfolio archives. eg. Browsing portfolio category links.", "mthemelocal" ),
						"id"			=> "portfolio_achivelisting",
						"min"			=> "1",
						"max"			=> "4",
						"step"			=> "0",
						"unit"			=> 'columns',
						"std"			=> "3",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Enable Recent Portfolio blocks", "mthemelocal" ),
						"desc"			=> __("Enable recent portfolio block in portfolio details page.", "mthemelocal" ),
						"id"			=> "portfolio_recently",
						"std"			=> "1",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __( "Display Related portfolio orientation", "mthemelocal" ),
						"desc"			=> __( "Display Related portfolio orientation", 'mthemelocal' ),
						"id"			=> "portfolio_related_format",
						"std"			=> "landscape",
						"type"			=> "select",
						"options"	=> array(
							'landscape'		=> 'Landscape',
							'portrait' 		=> 'Portrait')
						);

	$options[] = array( "name"			=> __("Portfolio permalink slug (Important Note below)","mthemelocal"),
						"desc"			=> __("Slug name used in portfolio permalink. <br/> IMPORTANT NOTE: After changing this please make sure to flush the old cache by visiting wp-admin > Settings > Permalinks","mthemelocal"),
						"id"			=> "portfolio_permalink_slug",
						"std"			=> "project",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Portfolio refered as ( Singular )","mthemelocal"),
						"desc"			=> __("Text name to refer portfolio as a singular ( one item )","mthemelocal"),
						"id"			=> "portfolio_singular_refer",
						"std"			=> "Project",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Portfolio refered as ( Plural )","mthemelocal"),
						"desc"			=> __("Text name to refer portfolio as plural ( many items )","mthemelocal"),
						"id"			=> "portfolio_plural_refer",
						"std"			=> "Projects",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Portfolio project description text","mthemelocal"),
						"desc"			=> __("Portfolio project description text","mthemelocal"),
						"id"			=> "portfolio_project_desc",
						"std"			=> "Project Description",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Portfolio project details text","mthemelocal"),
						"desc"			=> __("Portfolio project details text","mthemelocal"),
						"id"			=> "portfolio_project_details",
						"std"			=> "Project Details",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Portfolio project link text","mthemelocal"),
						"desc"			=> __("Portfolio project link text","mthemelocal"),
						"id"			=> "portfolio_link_text",
						"std"			=> "Project Link",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Refer to Client as","mthemelocal"),
						"desc"			=> __("Refer to Client as. Seen in Portfolio details pages","mthemelocal"),
						"id"			=> "portfolio_client_refer",
						"std"			=> "Client",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Refer to Skills as","mthemelocal"),
						"desc"			=> __("Refer to Skills as. Seen in Portfolio details pages","mthemelocal"),
						"id"			=> "portfolio_skill_refer",
						"std"			=> "Skills",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Portfolio carousel heading","mthemelocal"),
						"desc"			=> __("Portfolio carousel heading displayed in single post page","mthemelocal"),
						"id"			=> "portfolio_carousel_heading",
						"std"			=> "In Portfolios",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Ajax Portfolio View Project text","mthemelocal"),
						"desc"			=> __("Ajax Portfolio View Project text","mthemelocal"),
						"id"			=> "ajax_portfolio_viewtext",
						"std"			=> "View Project",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Filter tag for all Items","mthemelocal"),
						"desc"			=> __("Displays as a filterable tag in place of all items","mthemelocal"),
						"id"			=> "portfolio_allitems",
						"std"			=> "All Projects",
						"class"			=> "tiny",
						"type"			=> "text");

$options[] = array( "name"			=> __("Proofing", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Proofing Gallery image ID", "kinatrix" ),
						"desc"			=> esc_html__( "Proofing Gallery image ID", 'kinatrix' ),
						"id"			=> "proofing_image_id",
						"std"			=> "default",
						"type"			=> "select",
						"options"	=> array(
							'default'		=> 'Default',
							'filename'		=> 'File Name',
							'imagetitle' 		=> 'Image Title')
						);

	$options[] = array( "name"			=> __("All item text","mthemelocal"),
						"desc"			=> __("All item text","mthemelocal"),
						"id"			=> "proofing_all_items",
						"std"			=> "All items",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Selected item text","mthemelocal"),
						"desc"			=> __("Selected item text","mthemelocal"),
						"id"			=> "proofing_selected_items",
						"std"			=> "Selected",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Selected count text","mthemelocal"),
						"desc"			=> __("Selected count text","mthemelocal"),
						"id"			=> "proofing_selected_count",
						"std"			=> "Selected",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Rejected item text","mthemelocal"),
						"desc"			=> __("Rejected item text","mthemelocal"),
						"id"			=> "proofing_rejected_items",
						"std"			=> "Rejected",
						"class"			=> "tiny",
						"type"			=> "text");

$options[] = array( "name"			=> __("Photo Stories", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Default story archive list orientation", "mthemelocal" ),
						"desc"			=> __( "Default story archive list orientation", 'mthemelocal' ),
						"id"			=> "photostory_archive_format",
						"std"			=> "landscape",
						"type"			=> "select",
						"options"	=> array(
							'landscape'		=> 'Landscape',
							'square'		=> 'Square',
							'masonary'		=> 'Masonry',
							'portrait' 		=> 'Portrait')
						);

	$options[] = array( "name"			=> __("Story archive title","mthemelocal"),
						"desc"			=> __("Story archive title","mthemelocal"),
						"id"			=> "story_archive_title",
						"std"			=> "Stories",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array(	"name"			=> __("Prefered photostories archive page", "mthemelocal" ),
						"desc"			=> __("Prefered photostories archive page.", "mthemelocal" ),
						"id"			=> "photostory_archive_page",
						"std"			=> '',
						"type"			=> "selectyper",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_pages);

	$options[] = array( "name"			=> __("Number of thumbnail columns for archive listing", "mthemelocal" ),
						"desc"			=> __("Column in grid list for photo story archive.", "mthemelocal" ),
						"id"			=> "photostory_achivelisting",
						"min"			=> "1",
						"max"			=> "4",
						"step"			=> "0",
						"unit"			=> 'columns',
						"std"			=> "3",
						"type"			=> "text");

	$options[] = array( "name" => __( "Pagination for archive ( set 0 to display all )", "mthemelocal" ),
						"desc" => __( "Pagination for archive ( set 0 to display all )", "mthemelocal" ),
						"id" => "photostory_archive_pagination",
						"std" => "6",
						"min" => "0",
						"max" => "40",
						"step" => "0",
						"unit" => 'items',
						"type" => "text");

	$options[] = array( "name"			=> __( "Transition type for photo story slideshow", "mthemelocal" ),
						"desc"			=> __( "Transition type", 'mthemelocal' ),
						"id"			=> "photostory_transition",
						"std"			=> "slide",
						"type"			=> "select",
						"options"	=> array(
							'slide'		=> 'Slide',
							'crossfade'	=> 'Fade')
						);
						
$options[] = array( "name"			=> __("Blog", "mthemelocal" ),
					"type"			=> "heading");
					
	$options[] = array( "name"			=> __("Display Fullpost Archives", "mthemelocal" ),
						"desc"			=> __("Display fullpost archives", "mthemelocal" ),
						"id"			=> "postformat_fullcontent",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Display Author Bio", "mthemelocal" ),
						"desc"			=> __("Display Author Bio", "mthemelocal" ),
						"id"			=> "author_bio",
						"std"			=> "0",
						"type"			=> "checkbox");
						
	$options[] = array( "name"			=> __("Hide allowed HTML tags info", "mthemelocal" ),
						"desc"			=> __("Hide allowed HTML tags info after comments box", "mthemelocal" ),
						"id"			=> "blog_allowedtags",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Read more text", "mthemelocal" ),
						"desc"			=> __("Enter text for Read more", "mthemelocal" ),
						"id"			=> "read_more",
						"std"			=> "Continue reading",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> __("Page Title", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __("Hide Page title", "mthemelocal" ),
						"desc"			=> __("Hide Page title from all pages", "mthemelocal" ),
						"id"			=> "hide_pagetitle",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Page title size", "mthemelocal" ),
						"desc"			=> __("Page title size in pixels. eg. 42", "mthemelocal" ),
						"id"			=> "pagetitle_size",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Page title letter spacing", "mthemelocal" ),
						"desc"			=> __("Page title letter spacing in pixels. eg. 6", "mthemelocal" ),
						"id"			=> "pagetitle_letterspacing",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Page title weight", "mthemelocal" ),
						"desc"			=> __("Page title weight. eg. 100, 200, 300, 400, 500, 600, 700, 800, 900", "mthemelocal" ),
						"id"			=> "pagetitle_weight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> __("Lightbox", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __("Display Only Lightbox Image", "mthemelocal" ),
						"desc"			=> __("Display only lightbox image excluding others to occupy maximum space", "mthemelocal" ),
						"id"			=> "lightbox_max_space",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Disable Lightbox sharing icons", "mthemelocal" ),
						"desc"			=> __("Disable Lightbox sharing icons", "mthemelocal" ),
						"id"			=> "lightbox_sharing_disable",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Disable Lightbox counter", "mthemelocal" ),
						"desc"			=> __("Disable Lightbox counter", "mthemelocal" ),
						"id"			=> "lightbox_counter_disable",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Disable Lightbox arrows", "mthemelocal" ),
						"desc"			=> __("Disable Lightbox arrows", "mthemelocal" ),
						"id"			=> "lightbox_arrows_disable",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __("Disable Lightbox title", "mthemelocal" ),
						"desc"			=> __("Disable Lightbox title", "mthemelocal" ),
						"id"			=> "lightbox_title_disable",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __( "Lightbox background color", "mthemelocal" ),
						"desc"			=> __( "Lightbox background color", "mthemelocal" ),
						"id"			=> "lightbox_bgcolor",
						"std"			=> "",
						"type"			=> "color");

	$options[] = array( "name"			=> __( "Lightbox element color", "mthemelocal" ),
						"desc"			=> __( "Lightbox element color", "mthemelocal" ),
						"id"			=> "lightbox_elementcolor",
						"std"			=> "",
						"type"			=> "color");

$options[] = array( "name"			=> __("Sidebars", "mthemelocal" ),
					"type"			=> "heading");

				
	for ($sidebar_count=1; $sidebar_count <=MTHEME_MAX_SIDEBARS; $sidebar_count++ ) {

	$options[] = array( "name"			=> __("Sidebar ", "mthemelocal" ) . $sidebar_count,
							"type"			=> "info");
						
		$options[] = array( "name"			=> __("Sidebar Name", "mthemelocal" ),
						"desc"			=> __("Activate sidebars by naming them.", "mthemelocal" ),
						"id"			=> "mthemesidebar-".$sidebar_count,
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> __("Sidebar Description", "mthemelocal" ),
						"desc"			=> __("A small description to display inside the widget to easily identify it. Widget description is only shown in admin mode inside the widget.", "mthemelocal" ),
						"id"			=> "theme_sidebardesc".$sidebar_count,
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");
	}



$options[] = array( "name"			=> __("Color", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Accent Color", "mthemelocal" ),
						"desc"			=> __( "Accent Color", "mthemelocal" ),
						"id"			=> "accent_color",
						"std"			=> "",
						"type"			=> "color");

$options[] = array( "name"			=> __("Menu Color", "mthemelocal" ),
				"type"			=> "heading",
				"subheading"			=> 'header_section_order');

		$options[] = array( "name"			=> __( "Menu bar color", "mthemelocal" ),
							"desc"			=> __( "Menu bar color", "mthemelocal" ),
							"id"			=> "menubar_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Menu link color", "mthemelocal" ),
							"desc"			=> __( "Menu link color", "mthemelocal" ),
							"id"			=> "menu_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Current menu link color", "mthemelocal" ),
							"desc"			=> __( "Current menu link color", "mthemelocal" ),
							"id"			=> "currentmenu_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu background color", "mthemelocal" ),
							"desc"			=> __( "Submenu  background color", "mthemelocal" ),
							"id"			=> "menusubcat_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu link color", "mthemelocal" ),
							"desc"			=> __( "Submenu link color", "mthemelocal" ),
							"id"			=> "menusubcat_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu link hover color", "mthemelocal" ),
							"desc"			=> __( "Submenu link hover color", "mthemelocal" ),
							"id"			=> "menusubcat_linkhovercolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu link underline color", "mthemelocal" ),
							"desc"			=> __( "Submenu link underline color", "mthemelocal" ),
							"id"			=> "menusubcat_linkunderlinecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Current Submenu link color", "mthemelocal" ),
							"desc"			=> __( "Current Submenu link color", "mthemelocal" ),
							"id"			=> "currentmenusubcat_linkcolor",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"			=> __("Responsive/Toggle Menu Color", "mthemelocal" ),
				"type"			=> "heading",
				"subheading"			=> 'header_section_order');

		$options[] = array( "name"			=> __( "Responsive Menu bar color", "mthemelocal" ),
							"desc"			=> __( "Responsive Menu bar color", "mthemelocal" ),
							"id"			=> "mobilemenubar_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Responsive Menu toggle icon color", "mthemelocal" ),
							"desc"			=> __( "Responsive Menu toggle icon color", "mthemelocal" ),
							"id"			=> "mobilemenubar_togglecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Responsive Menu background color", "mthemelocal" ),
							"desc"			=> __( "Responsive Menu background color", "mthemelocal" ),
							"id"			=> "mobilemenu_bgcolor",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name"			=> __( "Use an image as Responsive menu background", 'mthemelocal' ),
						"desc"			=> __( "Use an image as Responsive menu background", 'mthemelocal' ),
						"id"			=> "mobilemenu_bgimage",
						"type"			=> "upload");

		$options[] = array( "name"			=> __( "Responsive Menu text and icon color", "mthemelocal" ),
							"desc"			=> __( "Responsive Menu text and icon color", "mthemelocal" ),
							"id"			=> "mobilemenu_texticons",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Responsive Menu hover color", "mthemelocal" ),
							"desc"			=> __( "Responsive Menu hover color", "mthemelocal" ),
							"id"			=> "mobilemenu_hover",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Responsive Menu active color", "mthemelocal" ),
							"desc"			=> __( "Responsive Menu active color", "mthemelocal" ),
							"id"			=> "mobilemenu_active",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Responsive Menu line colors", "mthemelocal" ),
							"desc"			=> __( "Responsive Menu line colors", "mthemelocal" ),
							"id"			=> "mobilemenu_linecolors",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"			=> __("Vertical Menu Color", "mthemelocal" ),
				"type"			=> "heading",
				"subheading"			=> 'header_section_order');

	$options[] = array( "name"			=> __( "Use an image as Vertical menu background", 'mthemelocal' ),
						"desc"			=> __( "Use an image as Vertical menu background", 'mthemelocal' ),
						"id"			=> "verticalmenu_bgimage",
						"type"			=> "upload");

		$options[] = array( "name"			=> __( "Menu bar color", "mthemelocal" ),
							"desc"			=> __( "Menu bar color", "mthemelocal" ),
							"id"			=> "vmenubar_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Menu link color", "mthemelocal" ),
							"desc"			=> __( "Menu link color", "mthemelocal" ),
							"id"			=> "vmenubar_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Menu horizontal lines", "mthemelocal" ),
							"desc"			=> __( "Menu horizontal lines", "mthemelocal" ),
							"id"			=> "vmenubar_hlinecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Menu link hover color", "mthemelocal" ),
							"desc"			=> __( "Menu link hover color", "mthemelocal" ),
							"id"			=> "vmenubar_linkhovercolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Active Menu link color", "mthemelocal" ),
							"desc"			=> __( "Active Menu link color", "mthemelocal" ),
							"id"			=> "vmenubar_linkactivecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Social icon color", "mthemelocal" ),
							"desc"			=> __( "Social icon color", "mthemelocal" ),
							"id"			=> "vmenubar_socialcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Copyright text color", "mthemelocal" ),
							"desc"			=> __( "Copyright text color", "mthemelocal" ),
							"id"			=> "vmenubar_copyrightcolor",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"				=> __("Page Color", "mthemelocal" ),
					"type"				=> "heading",
					"subheading"		=> 'header_section_order');

		$options[] = array( "name"			=> __( "Page contents color", "mthemelocal" ),
							"desc"			=> __( "Page contents color", "mthemelocal" ),
							"id"			=> "page_contentscolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Page contents heading color", "mthemelocal" ),
							"desc"			=> __( "Page contents heading color", "mthemelocal" ),
							"id"			=> "page_contentsheading",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"				=> __("Portfolio Color", "mthemelocal" ),
					"type"				=> "heading",
					"subheading"		=> 'header_section_order');

		$options[] = array( "name"			=> __( "Portfolio grid hover background color", "mthemelocal" ),
							"desc"			=> __( "Portfolio grid hover background color", "mthemelocal" ),
							"id"			=> "portfolio_hovercolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name" => __( "Apply portfolio grid hover opacity", 'mthemelocal' ),
							"desc" => __( "Apply portfolio grid hover opacity. Make sure color is applied for opacity to affect.", 'mthemelocal' ),
							"id" => "portfolio_grid_opacity",
							"std" => "0",
							"type" => "checkbox");

			$options[] = array( "name" => __( "Portfolio grid hover bg opacity ( default 50 )", 'mthemelocal' ),
								"desc" => __( "Portfolio grid hover bg opacity", 'mthemelocal' ),
								"id" => "portfolio_hoveropacity",
								"min" => "0",
								"max" => "100",
								"step" => "0",
								"unit" => '%',
								"std" => "50",
								"type" => "text");

		$options[] = array( "name"			=> __( "Portfolio grid icon link background color", "mthemelocal" ),
							"desc"			=> __( "Portfolio grid icon link background color", "mthemelocal" ),
							"id"			=> "portfolio_iconlink",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Portfolio grid icon link color", "mthemelocal" ),
							"desc"			=> __( "Portfolio grid icon link color", "mthemelocal" ),
							"id"			=> "portfolio_gridicon",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"				=> __("Sidebar Color", "mthemelocal" ),
					"type"				=> "heading",
					"subheading"		=> 'header_section_order');

		$options[] = array( "name"			=> __( "Sidebar heading color", "mthemelocal" ),
							"desc"			=> __( "Sidebar heading color", "mthemelocal" ),
							"id"			=> "sidebar_headingcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Sidebar link color", "mthemelocal" ),
							"desc"			=> __( "Sidebar link color", "mthemelocal" ),
							"id"			=> "sidebar_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Sidebar text color", "mthemelocal" ),
							"desc"			=> __( "Sidebar text color", "mthemelocal" ),
							"id"			=> "sidebar_textcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Sidebar link underline", "mthemelocal" ),
							"desc"			=> __( "Sidebar link underline", "mthemelocal" ),
							"id"			=> "sidebar_linkbordercolor",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name" => "Footer Color",
					"type" => "heading",
					"subheading" => 'header_section_order');

		$options[] = array( "name" => __( "Apply custom footer opacity", 'mthemelocal' ),
							"desc" => __( "Apply custom footer opacity. Make sure footer color is applied for opacity to affect.", 'mthemelocal' ),
							"id" => "footer_opacity_customize",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => "Footer background",
							"desc" => "Footer background",
							"id" => "footer_bgcolor",
							"std" => "",
							"type" => "color");

			$options[] = array( "name" => __( "Footer background opacity ( default 10 )", 'mthemelocal' ),
								"desc" => __( "Footer background opacity", 'mthemelocal' ),
								"id" => "footer_background_opacity",
								"min" => "0",
								"max" => "100",
								"step" => "0",
								"unit" => '%',
								"std" => "10",
								"type" => "text");

	$options[] = array( "name" => "Footer Label text color",
						"desc" => "Footer Label text color",
						"id" => "footer_labeltext",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer text color",
						"desc" => "Footer text color",
						"id" => "footer_text",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer text link color",
						"desc" => "Footer text link color",
						"id" => "footer_link",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer text link hover color",
						"desc" => "Footer text link hover color",
						"id" => "footer_linkhover",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer icon color",
						"desc" => "Footer icon color",
						"id" => "footer_iconcolor",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer seperator line color",
						"desc" => "Footer seperator line color",
						"id" => "footer_hline",
						"std" => "",
						"type" => "color");

		$options[] = array( "name" => "Footer copyright label text",
							"desc" => "Footer copyright label text",
							"id" => "footer_copyrighttext",
							"std" => "",
							"type" => "color");

						
$options[] = array( "name"			=> __("Fonts", "mthemelocal" ),
					"type"			=> "heading");
					
$options[] = array( "name"			=> __("Enable Google Web Fonts", "mthemelocal" ),
					"desc"			=> __("Enable Google Web fonts", "mthemelocal" ),
					"id"			=> "default_googlewebfonts",
					"std"			=> "0",
					"type"			=> "checkbox");

	$options[] = array(	"name"			=> __("Slideshow Title font","mthemelocal"),
						"desc"			=> __("Select font for slideshow title","mthemelocal"),
						"id"			=> "super_title",
						"std"			=> 'Default Font',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);	

	$options[] = array(	"name"			=> __("Slideshow Caption font","mthemelocal"),
						"desc"			=> __("Select font for slideshow caption","mthemelocal"),
						"id"			=> "super_caption",
						"std"			=> 'Default Font',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);

	$options[] = array(	"name"			=> __("Hero image title","mthemelocal"),
						"desc"			=> __("Select font for hero title","mthemelocal"),
						"id"			=> "hero_title",
						"std"			=> 'Default Font',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);	
						
	$options[] = array(	"name"			=> __("Menu Font", "mthemelocal" ),
						"desc"			=> __("Select menu font", "mthemelocal" ),
						"id"			=> "menu_font",
						"std"			=> '',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);
						
	$options[] = array(	"name"			=> __("Heading Font (applies to all headings)", "mthemelocal" ),
						"desc"			=> __("Select heading font", "mthemelocal" ),
						"id"			=> "heading_font",
						"std"			=> '',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);	
						
	$options[] = array(	"name"			=> __("Contents", "mthemelocal" ),
						"desc"			=> __("Select font for headings inside posts and pages", "mthemelocal" ),
						"id"			=> "page_contents",
						"std"			=> '',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);

		$options[] = array( "name"			=> __("Content Font Size", "mthemelocal" ),
						"desc"			=> __("Contents font size in pixels.", "mthemelocal" ),
						"id"			=> "pagecontent_fontsize",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> __("Content line height", "mthemelocal" ),
						"desc"			=> __("Contents line height in pixels.", "mthemelocal" ),
						"id"			=> "pagecontent_lineheight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> __("Content letter spacing", "mthemelocal" ),
						"desc"			=> __("Content letter spacing in pixels.", "mthemelocal" ),
						"id"			=> "pagecontent_letterspacing",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> __("Content font weight", "mthemelocal" ),
						"desc"			=> __("Content font weight.(100,200,300,400,500,600,700,800,900)", "mthemelocal" ),
						"id"			=> "pagecontent_fontweight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> __("Custom Font", "mthemelocal" ),
					"type"			=> "heading",
					"subheading"			=> 'default_googlewebfonts');

	$options[] = array( "name"			=> __("Font Embed Code", "mthemelocal" ),
						"desc"			=> __("eg. <code>&lt;link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'&gt;</code>", "mthemelocal" ),
						"id"			=> "custom_font_embed",
						"std"			=> '',
						"type"			=> "textarea");

	$options[] = array( "name"			=> __("CSS Codes for Custom Font", "mthemelocal" ),
						"desc"			=> __("eg. <code>.entry-title h1 { font-family: 'Lobster', cursive; }</code>", "mthemelocal" ),
						"id"			=> "custom_font_css",
						"std"			=> '',
						"type"			=> "textarea");

$options[] = array( "name"			=> __("WPML", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Disable Built-in WPML language selector", 'mthemelocal' ),
						"desc"			=> __( "Disable Built-in WPML language selector", 'mthemelocal' ),
						"id"			=> "wpml_lang_selector_disable",
						"std"			=> "0",
						"type"			=> "checkbox");

$options[] = array( "name"			=> __("WooCommerce", "mthemelocal" ),
					"type"			=> "heading");

		$options[] = array( "name"			=> __("WooCommerce Shop default title", "mthemelocal" ),
						"desc"			=> __("Shop title for WooCommerce shop. ( default 'Shop' ).", "mthemelocal" ),
						"id"			=> "mtheme_woocommerce_shoptitle",
						"std"			=> "Shop",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Enable Product Zoom", 'mthemelocal' ),
						"desc"			=> __( "Enable product zoom in details page", 'mthemelocal' ),
						"id"			=> "mtheme_woo_zoom",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __( "Fullwidth Shop Archive", 'mthemelocal' ),
						"desc"			=> __( "Display fullwidth shop archive", 'mthemelocal' ),
						"id"			=> "mtheme_wooarchive_fullwidth",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> __( "Disable Menu Cart icon", 'mthemelocal' ),
						"desc"			=> __( "Disable Menu Cart icon", 'mthemelocal' ),
						"id"			=> "mtheme_woocart_menu",
						"std"			=> "0",
						"type"			=> "checkbox");
						
$options[] = array( "name"			=> __("Footer", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> "Widgetized Footer",
						"desc"			=> "Display Widgetized Footer",
						"id"			=> "footerwidget_status",
						"std"			=> "1",
						"type"			=> "checkbox");
					
	$options[] = array( "name"			=> __("Copyright text", "mthemelocal" ),
						"desc"			=> __("Enter your copyright and other texts to display in footer", "mthemelocal" ),
						"id"			=> "footer_copyright",
						"std"			=> "Copyright &copy; [display_current_year]",
						"type"			=> "textarea");

$options[] = array( "name"			=> __("Export", "mthemelocal" ),
					"type"			=> "heading");

	$options[] = array( "name"			=> __("Export Options ( Copy this ) Read-Only.", "mthemelocal" ),
						"desc"			=> __("Select All, copy and store your theme options backup. You can use these value to import theme options settings.", "mthemelocal" ),
						"id"			=> "exportpack",
						"std"			=> '',
						"class"			=> "big",
						"type"			=> "exporttextarea");

$options[] = array( "name"			=> __("Import Options", "mthemelocal" ),
					"type"			=> "heading",
					"subheading"		=> 'exportpack');

	$options[] = array( "name"			=> __("Import Options ( Paste and Save )", "mthemelocal" ),
						"desc"			=> __("CAUTION: Copy and Paste the Export Options settings into the window and Save to apply theme options settings.", "mthemelocal" ),
						"id"			=> "importpack",
						"std"			=> '',
						"class"			=> "big",
						"type"			=> "importtextarea");

	return $options;
}
?>