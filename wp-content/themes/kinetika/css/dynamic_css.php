<?php
$dynamic_css='';
$heading_classes='
.woocommerce .product h1,
.woocommerce .product h2,
.woocommerce .product h3,
.woocommerce .product h4,
.woocommerce .product h5,
.woocommerce .product h6,
.entry-content > h1,
.entry-content > h2,
.entry-content > h3,
.entry-content > h4,
.entry-content > h5,
.entry-content > h6,
h1,
h2,
h3,
h4,
h5,
h6,
.hero-text-wrap,
.sidebar h3,
.entry-title h1,
h1.section-title,
.pricing-table-service .pricing-title h2,
.portfolio-end-block h2.section-title';

$page_contents_classes='
body,
.entry-content,
.sidebar-widget,
.homemenu .sf-menu .megamenu-textbox,
.homemenu .sf-menu ul li a
';

$hero_title_class = 'h2.hero-title';

$slideshow_title_classes = '.slideshow_title, .static_slideshow_title';
$slideshow_caption_classes = '.slideshow_caption, .static_slideshow_caption';
//Font
if (of_get_option('default_googlewebfonts')) {
	$dynamic_css .= mtheme_apply_font ( "page_contents" , $page_contents_classes );
	$dynamic_css .= mtheme_apply_font ( "heading_font" , $heading_classes );
	$dynamic_css .= mtheme_apply_font ( "menu_font" , ".homemenu .sf-menu a, .homemenu .sf-menu,.homemenu .sf-menu ul li a,.vertical-menu ul.mtree,.vertical-menu ul.mtree a" );
	$dynamic_css .= mtheme_apply_font ( "super_title" , $slideshow_title_classes );
	$dynamic_css .= mtheme_apply_font ( "super_caption" , $slideshow_caption_classes );
	$dynamic_css .= mtheme_apply_font ( "hero_title" , $hero_title_class );
}
//Preloader Logo
$preloader_logo=of_get_option('preloader_logo');
if ($preloader_logo) {
	$dynamic_css .= '.pace,.theme-is-dark .pace { background-image: url('.$preloader_logo.'); }';
}
$preloader_color=of_get_option('preloader_color');
$preloader_color_rgb=mtheme_hex2RGB($preloader_color,true);
if ($preloader_color) {
	$dynamic_css .= "
	.pace .pace-progress,.theme-is-dark .pace .pace-progress {
	background:".$preloader_color.";
	background: linear-gradient(left, rgba(0,0,0,0) 0%,rgba(".$preloader_color_rgb.",0.65) 100%);
	background: -moz-linear-gradient(left, rgba(0,0,0,0) 0%, rgba(".$preloader_color_rgb.",0.65) 100%);
	background: -ms-linear-gradient(left, rgba(0,0,0,0) 0%,rgba(".$preloader_color_rgb.",0.65) 100%);
	background: -o-linear-gradient(left, rgba(0,0,0,0) 0%,rgba(".$preloader_color_rgb.",0.65) 100%);
	background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(".$preloader_color_rgb.",0.65)));
	background: -webkit-linear-gradient(left, rgba(0,0,0,0) 0%,rgba(".$preloader_color_rgb.",0.65) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$preloader_color."', endColorstr='".$preloader_color."',GradientType=1 );
	}
	";
}
$preloader_bgcolor=of_get_option('preloader_bgcolor');
if ($preloader_bgcolor) {
	$dynamic_css .= "
	.pace,.theme-is-dark .pace, .preloader-cover-screen,.theme-is-dark .preloader-cover-screen {
	background-color:".$preloader_bgcolor.";
	}
	";
}

//Logo
$logo_width=of_get_option('logo_width');
if ($logo_width) {
	$dynamic_css .= '.logo img { width: '.$logo_width.'px; }';
}
$sticky_logo_width=of_get_option('sticky_logo_width');
if ($sticky_logo_width) {
	$dynamic_css .= '.stickymenu-zone.sticky-menu-activate .logo img { height:auto; width: '.$sticky_logo_width.'px; }';
}
$logo_topmargin=of_get_option('logo_topmargin');
if ($logo_topmargin) {
	$dynamic_css .= '.logo img { top: '.$logo_topmargin.'px; }';
}
$sticky_logo_topmargin=of_get_option('sticky_logo_topmargin');
if ($sticky_logo_topmargin) {
	$dynamic_css .= '.stickymenu-zone.sticky-menu-activate .logo img { top: '.$sticky_logo_topmargin.'px; }';
}
$logo_leftmargin=of_get_option('logo_leftmargin');
if ($logo_leftmargin) {
	$dynamic_css .= '.logo img { margin-left: '.$logo_leftmargin.'px; }';
}
//Vertical Menu Logo
$verticalmenu_bgimage=of_get_option('verticalmenu_bgimage');
if ($verticalmenu_bgimage) {
	$dynamic_css .= 'body .vertical-menu,body.theme-is-light .vertical-menu { background-image: url('.$verticalmenu_bgimage.'); }';
}
$vlogo_width=of_get_option('vlogo_width');
if ($vlogo_width) {
	$dynamic_css .= '.vertical-logoimage { width: '.$vlogo_width.'px; }';
}
$vlogo_topmargin=of_get_option('vlogo_topmargin');
if ($vlogo_topmargin) {
	$dynamic_css .= '.vertical-logoimage { margin-top: '.$vlogo_topmargin.'px; }';
}
$vlogo_leftmargin=of_get_option('vlogo_leftmargin');
if ($vlogo_leftmargin) {
	$dynamic_css .= '.vertical-logoimage { margin-left: '.$vlogo_leftmargin.'px; }';
}
$responsive_logo_width = of_get_option('responsive_logo_width');
if ($responsive_logo_width) {
	$dynamic_css .= '.logo-mobile .logoimage { width: '.$responsive_logo_width.'px; }';
	$dynamic_css .= '.logo-mobile .logoimage { height: auto; }';
}
$responsive_logo_topmargin = of_get_option('responsive_logo_topmargin');
if ($responsive_logo_topmargin) {
	$dynamic_css .= '.logo-mobile .logoimage { top: '.$responsive_logo_topmargin.'px; }';
}

//Accents
$accent_color=of_get_option('accent_color');
$accent_color_rgb=mtheme_hex2RGB($accent_color,true);
$slideshow_transbar_rgb=mtheme_hex2RGB($accent_color,true);

if (MTHEME_DEMO_STATUS) {
	if ( isSet( $_SESSION['demo_color'] ) || isSet( $_GET['demo_color'] ) ) {
		if ( isSet( $_GET['demo_color'] ) ) $_SESSION['demo_color']=$_GET['demo_color'];
		if ( isSet($_SESSION['demo_color'] )) $demo_color = $_SESSION['demo_color'];
		if (isSet($demo_color)) {
			$accent_color='#'.$demo_color;
		}
	}
}

if ($accent_color) {
$dynamic_css .= mtheme_change_class('.grid-preloader-accent',"fill",$accent_color,'');
$accent_change_color = "
.entry-content a:hover,
.project-details a,
.post-single-tags a:hover,
.post-meta-category a:hover,
.post-single-meta a:hover,
.post-navigation a:hover,
.sidebar ul li a:hover,
.entry-post-title h2 a:hover,
.comment-reply-title small a,
.header-shopping-cart a:hover,
#gridblock-filter-select i,
.entry-content .blogpost_readmore a,
.pricing-table .pricing_highlight .pricing-price,
#wp-calendar tfoot td#prev a,
#wp-calendar tfoot td#next a,
.sidebar-widget .widget_nav_menu a:hover,
.footer-widget .widget_nav_menu a:hover,
.entry-content .faq-toggle-link:before,
.mtheme-knowledgebase-archive ul li:before,
.like-vote-icon,
.readmore-service a,
.work-details h4,
.work-details h4 a:hover,
#gridblock-filters li .is-active,
#gridblock-filters li a:focus,
#gridblock-filters a:focus,
#gridblock-filters li .is-active,
#gridblock-filters li .is-active:hover,
.post-single-tags a,
.service-content h4 a:hover,
.postsummarywrap a:hover,
.toggle-menu-list li a:hover,
.ui-accordion-header:hover .ui-accordion-header-icon:after,
.quote_say i,
#footer a:hover,
.nav-previous a:hover,
.nav-next a:hover,
.nav-lightbox a:hover,
.portfolio-nav-item i:hover,
.project-details-link i,
.project-details-link h4 a,
.entry-content .entry-post-title h2 a:hover,
.woocommerce .mtheme-woocommerce-description-wrap a.add_to_cart_button:hover,
.woocommerce ul.products li.product h3 a:hover,
.woocommerce-page ul.products li.product h3 a:hover,
.woocommerce .woocommerce-info a,
.tagcloud a:hover,
#footer .tagcloud a:hover,
.event-icon,
.entry-content .ui-accordion-header:hover .ui-accordion-header-icon:after,
#recentposts_list .recentpost_info .recentpost_title:hover,
#popularposts_list .popularpost_info .popularpost_title:hover,
.client-link span,
.mtheme-events-carousel .slideshow-box-title a:hover,
.woocommerce .product_meta a:hover,
ul.mtree li.mtree-open > a:hover,
ul.mtree li.mtree-open > a,
ul.mtree li.mtree-active > a:hover,
.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a,
.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a:hover,
ul.mtree li.mtree-active > a,
.entry-content .service-content h4 a
";
$accent_change_background = "
.gridblock-displayed .gridblock-selected-icon,
.skillbar-title,
.skillbar-bar,
div.jp-volume-bar-value,
div.jp-play-bar,
#wp-calendar caption,
#wp-calendar tbody td a,
.like-alreadyvoted,
.flexslider-container-page .flex-direction-nav li a:hover,
.lightbox-toggle a:hover,
a.ajax-navigation-arrow,
.blog-timeline-month,
.ui-accordion-header.ui-state-active a,
.entry-content .ui-tabs .ui-tabs-nav .ui-state-active a,
.entry-content .ui-tabs .ui-tabs-nav .ui-state-active a:hover,
.pagination span.current,
.gridblock-thumbnail-element:hover,
.synced .gridblock-thumbnail-element,
.woocommerce span.onsale,
.woocommerce-page span.onsale,
.mtheme-woo-order-list ul li:hover,
.woocommerce #content div.product form.cart .button,
.woocommerce div.product form.cart .button,
.woocommerce-page #content div.product form.cart .button,
.woocommerce-page div.product form.cart .button,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.woocommerce nav.woocommerce-pagination ul li span.current,
.entry-content .ui-accordion-header.ui-state-active a,
.mtheme-proofing-item.proofing-item-selected .work-details
";

$accent_change_border = "
ul#thumb-list li.current-thumb,
ul#thumb-list li.current-thumb:hover,
.home-step:hover .step-element img,
.home-step-wrap li,
.gridblock-element:hover,
.gridblock-grid-element:hover,
.gridblock-displayed:hover,
.entry-content blockquote,
#gridblock-filters li .is-active,
#gridblock-filters li a:focus,
#gridblock-filters a:focus,
#gridblock-filters li .is-active,
#gridblock-filters li .is-active:hover,
.person:hover .person-image img,
.main-menu-wrap .homemenu .sf-menu .mega-item .children-depth-0,
.main-menu-wrap .homemenu ul ul,
.like-vote-icon,
#gridblock-timeline .blog-grid-element-left:before,
#gridblock-timeline .blog-grid-element-right:before,
#header-searchform #hs,
.pagination span.current,
.sidebar h3:after,
.fotorama__thumb-border,
.project-details-link i,
.woocommerce .quantity input.qty:hover,
.woocommerce #content .quantity input.qty:hover,
.woocommerce-page .quantity input.qty:hover,
.woocommerce-page #content .quantity input:hover,
.woocommerce .quantity input.qty:focus,
.woocommerce #content .quantity input.qty:focus,
.woocommerce-page .quantity input.qty:focus,
.woocommerce-page #content .quantity input:focus,
.woocommerce input.button:hover,
.woocommerce .shipping-calculator-form button:hover,
.woocommerce .woocommerce-message a.button:hover,
.woocommerce .shipping-calculator-button:hover,
.woocommerce #sidebar #respond input#submit:hover,
.woocommerce #sidebar a.button:hover,
.woocommerce #sidebar button.button:hover,
.woocommerce #sidebar input.button:hover,
.wpcf7-form input:focus,
.wpcf7-form textarea:focus,
.entry-content-wrapper .sticky .postformat_contents,
.entry-content-wrapper.post-is-sticky .type-post,
.woocommerce nav.woocommerce-pagination ul li span.current,
.mtheme-proofing-item .gridblock-ajax,
.mtheme-proofing-item.proofing-item-selected .gridblock-ajax
";

	$dynamic_css .= mtheme_change_class($accent_change_color,"color",$accent_color,'');
	$dynamic_css .= mtheme_change_class($accent_change_background,"background-color",$accent_color,'');
	$dynamic_css .= mtheme_change_class($accent_change_border,"border-color",$accent_color,'');

	$dynamic_css .= ".entry-content .pullquote-left { border-right-color:".$accent_color.";}";

	$dynamic_css .= ".entry-content .pullquote-center { border-top-color:".$accent_color.";}";
	$dynamic_css .= ".entry-content .pullquote-center { border-bottom-color:".$accent_color.";}";

	$dynamic_css .= ".blog-details-section-inner,.entry-content .pullquote-right,.callout,.calltype-line-left .callout { border-left-color:".$accent_color.";}";
	
}

//Preloader
$preloader_color=of_get_option('preloader_color');
if ($preloader_color) {
	$dynamic_css .= mtheme_change_class('.grid-preloader-accent',"fill",$preloader_color,'');
}
$preloader_logo_width = of_get_option('preloader_logo_width');
if ($preloader_logo_width <> 0) {
	$dynamic_css .= '.pace { background-size: '.$preloader_logo_width.'px auto; }';
}

// Menu colors

$menubar_bgcolor=of_get_option('menubar_bgcolor');
$menubar_bgcolor_rgb=mtheme_hex2RGB($menubar_bgcolor,true);
if ($menubar_bgcolor) {
	$dynamic_css .= mtheme_change_class('.outer-wrap',"background-color",$menubar_bgcolor,'');
	$dynamic_css .= '.outer-wrap { background:rgba('. $menubar_bgcolor_rgb .',0.8); }';
	$dynamic_css .= '.stickymenu-zone.sticky-menu-activate { background:rgba('. $menubar_bgcolor_rgb .',1); }';
}
$menu_linkcolor=of_get_option('menu_linkcolor');
if ($menu_linkcolor) {
	$dynamic_css .= mtheme_change_class('.homemenu ul li a, .header-cart i,.sticky-menu-activate .homemenu ul li a,.stickymenu-zone.sticky-menu-activate .homemenu ul li a',"color",$menu_linkcolor,'');
	$dynamic_css .= mtheme_change_class('.homemenu .sf-menu li.menu-item a:before',"border-color",$menu_linkcolor,'');
}

$menu_titlelinkhover_color=of_get_option('menu_titlelinkhover_color');
if ($menu_titlelinkhover_color) {
	$dynamic_css .= mtheme_change_class('.mainmenu-navigation .homemenu ul li a:hover',"color",$menu_titlelinkhover_color,'');
}

$menusubcat_bgcolor=of_get_option('menusubcat_bgcolor');
if ($menusubcat_bgcolor) {
	$dynamic_css .= mtheme_change_class('.homemenu .sf-menu .mega-item .children-depth-0, .homemenu ul ul',"background-color",$menusubcat_bgcolor,'');
}

$currentmenu_linkcolor=of_get_option('currentmenu_linkcolor');
if ($currentmenu_linkcolor) {
	$dynamic_css .= mtheme_change_class('.homemenu li.current-menu-parent > a',"color",$currentmenu_linkcolor,'');
}
$currentmenusubcat_linkcolor=of_get_option('currentmenusubcat_linkcolor');
if ($currentmenusubcat_linkcolor) {
	$dynamic_css .= mtheme_change_class('.homemenu .sub-menu li.current-menu-item > a',"color",$currentmenusubcat_linkcolor,'');
}


$menusubcat_linkcolor=of_get_option('menusubcat_linkcolor');
if ($menusubcat_linkcolor) {
	$dynamic_css .= mtheme_change_class('.mainmenu-navigation .homemenu ul ul li a',"color",$menusubcat_linkcolor,'');
}

$menusubcat_linkhovercolor=of_get_option('menusubcat_linkhovercolor');
if ($menusubcat_linkhovercolor) {
	$dynamic_css .= mtheme_change_class('.mainmenu-navigation .homemenu ul ul li:hover>a',"color",$menusubcat_linkhovercolor,'');
}
$menusubcat_linkunderlinecolor=of_get_option('menusubcat_linkunderlinecolor');
if ($menusubcat_linkunderlinecolor) {
	$dynamic_css .= mtheme_change_class('.mainmenu-navigation .homemenu ul ul li a ',"border-color",$menusubcat_linkunderlinecolor,'');
}
$menu_parentactive_color=of_get_option('menu_parentactive_color');
if ($menu_parentactive_color) {
	$dynamic_css .= mtheme_change_class('.homemenu li.current-menu-item a:before, .homemenu li.current-menu-ancestor a:before ',"background-color",$menu_parentactive_color,'');
}
$menu_search_color=of_get_option('menu_search_color');
if ($menu_search_color) {
	$dynamic_css .= mtheme_change_class('.header-search i.icon-search,.header-search i.icon-remove',"color",$menu_search_color,'');
}
$menu_search_hovercolor=of_get_option('menu_search_hovercolor');
if ($menu_search_hovercolor) {
	$dynamic_css .= mtheme_change_class('.header-search i.icon-search:hover,.header-search i.icon-remove:hover',"color",$menu_search_hovercolor,'');
}

// Vertical Menu

$vmenubar_bgcolor=of_get_option('vmenubar_bgcolor');
$vmenubar_bgcolor_rgba=mtheme_hex2RGB($vmenubar_bgcolor,true);
if ($vmenubar_bgcolor) {
	$more_menuClasses = '.boxed-site-layout .outer-wrap,
	.boxed-site-layout .fullscreen-footer-wrap,
	.boxed-site-layout #copyright,
	.boxed-site-layout .vertical-left-bar,
	.boxed-site-layout .vertical-right-bar,
	.vertical-menu';

	$dynamic_css .= $more_menuClasses .' { background:rgba('. $vmenubar_bgcolor_rgba .',1); }';
}
$vmenubar_linkcolor=of_get_option('vmenubar_linkcolor');
if ($vmenubar_linkcolor) {
	$dynamic_css .= mtheme_change_class('.vertical-menu ul.mtree li.mtree-node > a:before,.vertical-menu ul.mtree a',"color",$vmenubar_linkcolor,'');
}
$vmenubar_linkhovercolor=of_get_option('vmenubar_linkhovercolor');
if ($vmenubar_linkhovercolor) {
	$dynamic_css .= mtheme_change_class('.vertical-menu ul.mtree li > a:hover',"color",$vmenubar_linkhovercolor,'');
	//$dynamic_css .= mtheme_change_class('.vertical-menu ul.mtree li.mtree-open > a,.vertical-menu ul.mtree li.mtree-open > a:hover, .vertical-menu ul.mtree a:hover',"color",$vmenubar_linkhovercolor,'');
}
$vmenubar_linkactivecolor=of_get_option('vmenubar_linkactivecolor');
if ($vmenubar_linkactivecolor) {
	$dynamic_css .= mtheme_change_class('.vertical-menu ul.mtree li.mtree-open > a,.vertical-menu ul.mtree li.mtree-open > a:hover, .vertical-menu ul.mtree a:hover',"color",$vmenubar_linkactivecolor,'');
}
$vmenubar_socialcolor=of_get_option('vmenubar_socialcolor');
if ($vmenubar_socialcolor) {
	$dynamic_css .= mtheme_change_class('.vertical-menu .social-header-wrap ul li.social-icon i',"color",$vmenubar_socialcolor,'');
}
$vmenubar_copyrightcolor=of_get_option('vmenubar_copyrightcolor');
if ($vmenubar_copyrightcolor) {
	$dynamic_css .= mtheme_change_class('.vertical-footer-wrap .fullscreen-footer-info',"color",$vmenubar_copyrightcolor,'');
	$dynamic_css .= '.vertical-footer-wrap .fullscreen-footer-info { border-top-color:'. $vmenubar_copyrightcolor .'; }';
}
$vmenubar_hlinecolor=of_get_option('vmenubar_hlinecolor');
if ($vmenubar_hlinecolor) {
	$dynamic_css .= '.vertical-menu ul.mtree a,ul.mtree li.mtree-node > ul > li:last-child { border-bottom-color:'. $vmenubar_hlinecolor .'; }';
}


$vmenu_active_itemcolor=of_get_option('vmenu_active_itemcolor');
if ($vmenu_active_itemcolor) {
	$dynamic_css .= mtheme_change_class('ul.mtree li.mtree-open > a:hover, ul.mtree li.mtree-open > a',"color",$vmenu_active_itemcolor,'');
}
$vmenu_itemcolor=of_get_option('vmenu_itemcolor');
if ($vmenu_itemcolor) {
	$dynamic_css .= mtheme_change_class('ul.mtree a',"color",$vmenu_itemcolor,'');
}
$vmenu_hover_itemcolor=of_get_option('vmenu_hover_itemcolor');
if ($vmenu_hover_itemcolor) {
	$dynamic_css .= mtheme_change_class('ul.mtree li> a:hover,ul.mtree li.mtree-active > a:hover,ul.mtree li.mtree-active > a',"color",$vmenu_hover_itemcolor,'');
}
$vmenu_search_itemcolor=of_get_option('vmenu_search_itemcolor');
if ($vmenu_search_itemcolor) {
	$dynamic_css .= mtheme_change_class('.menu-is-vertical .header-search i',"color",$vmenu_search_itemcolor,'');
}
$vmenu_social_itemcolor=of_get_option('vmenu_social_itemcolor');
if ($vmenu_social_itemcolor) {
	$dynamic_css .= mtheme_change_class('.menu-is-vertical .social-header-wrap ul li.social-icon i',"color",$vmenu_social_itemcolor,'');
}


// Slideshow Color

$slideshow_title=of_get_option('slideshow_title');
if ($slideshow_title) {
	$dynamic_css .= mtheme_change_class( '.slideshow_title', "color",$slideshow_title,'' );
}
$slideshow_captiontxt=of_get_option('slideshow_captiontxt');
if ($slideshow_captiontxt) {
	$dynamic_css .= mtheme_change_class( '#slidecaption .slideshow_caption', "color",$slideshow_captiontxt,'' );
}
$slideshow_buttontxt=of_get_option('slideshow_buttontxt');
if ($slideshow_buttontxt) {
	$dynamic_css .= mtheme_change_class( '.slideshow_content_link a, .static_slideshow_content_link a', "color",$slideshow_buttontxt,'' );
}
$slideshow_buttonborder=of_get_option('slideshow_buttonborder');
if ($slideshow_buttonborder) {
	$dynamic_css .= mtheme_change_class( '.slideshow_content_link a, .static_slideshow_content_link a', "border-color",$slideshow_buttonborder,'' );
}
$slideshow_buttonhover_text=of_get_option('slideshow_buttonhover_text');
if ($slideshow_buttonhover_text) {
	$dynamic_css .= mtheme_change_class( '.slideshow_content_link a:hover, .static_slideshow_content_link a:hover', "color",$slideshow_buttonhover_text,'' );
}
$slideshow_buttonhover_bg=of_get_option('slideshow_buttonhover_bg');
if ($slideshow_buttonhover_bg) {
	$dynamic_css .= mtheme_change_class( '.slideshow_content_link a:hover, .static_slideshow_content_link a:hover', "background-color",$slideshow_buttonhover_bg,'' );
	$dynamic_css .= mtheme_change_class( '.slideshow_content_link a:hover, .static_slideshow_content_link a:hover', "border-color",$slideshow_buttonhover_bg,'' );
}
$slideshow_captionbg=of_get_option('slideshow_captionbg');
$slideshow_captionbg_rgb=mtheme_hex2RGB($slideshow_captionbg,true);
if ($slideshow_captionbg) {
	$dynamic_css .= "#slidecaption {
background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(".$slideshow_captionbg_rgb.",0.55)));
background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$slideshow_captionbg."', endColorstr='".$slideshow_captionbg."',GradientType=0 );
}";
}
$slideshow_transbar=of_get_option('slideshow_transbar');
$slideshow_transbar_rgb=mtheme_hex2RGB($slideshow_transbar,true);
if ($slideshow_transbar) {
	$dynamic_css .= "
	#progress-bar {
	background:".$slideshow_transbar.";
	}
	";
}
$slideshow_currthumbnail=of_get_option('slideshow_currthumbnail');
if ($slideshow_currthumbnail) {
	$dynamic_css .= mtheme_change_class( 'ul#thumb-list li.current-thumb', "border-color",$slideshow_currthumbnail,'');
}

$general_bgcolor = of_get_option('general_background_color');
if ($general_bgcolor) {
	$dynamic_css .= mtheme_change_class( 'body,body.theme-boxed',"background-color", $general_bgcolor,'' );
}

$page_opacity_customize=of_get_option('page_opacity_customize');
$page_background=of_get_option('page_background');
$page_background_rgb=mtheme_hex2RGB($page_background,true);
if ($page_opacity_customize) {
	$page_background_opacity=of_get_option('page_background_opacity')/100;
	$dynamic_css .= '.container-wrapper { background: rgba('. $page_background_rgb .','.$page_background_opacity.'); }';
}
$page_contentscolor=of_get_option('page_contentscolor');
if ($page_contentscolor) {
	$dynamic_css .= mtheme_change_class( '.woocommerce .entry-summary div[itemprop="description"],.entry-content,.entry-content .pullquote-left,.entry-content .pullquote-right,.entry-content .pullquote-center', "color",$page_contentscolor,'' );
}
$page_contentsheading=of_get_option('page_contentsheading');
if ($page_contentsheading) {
$content_headings = '
.woocommerce div.product .product_title,
.woocommerce #content div.product .product_title,
.woocommerce-page div.product .product_title,
.woocommerce-page #content div.product .product_title,
.entry-content h1,
.entry-content h2,
.entry-content h3,
.entry-content h4,
.entry-content h5,
.entry-content h6
';
	$dynamic_css .= mtheme_change_class( $content_headings, "color",$page_contentsheading,'' );
}

$footer_opacity_customize=of_get_option('footer_opacity_customize');
$footer_bgcolor=of_get_option('footer_bgcolor');
$footer_bgcolor_rgb=mtheme_hex2RGB($footer_bgcolor,true);
if ($footer_opacity_customize) {
	$footer_background_opacity=of_get_option('footer_background_opacity')/100;
	$dynamic_css .= '.footer-container-wrap,#copyright { background: rgba('. $footer_bgcolor_rgb .','.$footer_background_opacity.'); }';
} else {
	if ($footer_bgcolor) {
		$dynamic_css .= mtheme_change_class( '.footer-container-wrap,#copyright', "background",$footer_bgcolor,'' );
	}
}
$footer_labeltext=of_get_option('footer_labeltext');
if ($footer_labeltext) {
	$dynamic_css .= mtheme_change_class( '#footer h3', "color",$footer_labeltext,'' );
}
$footer_iconcolor=of_get_option('footer_iconcolor');
if ($footer_iconcolor) {
	$dynamic_css .= mtheme_change_class( '#footer i,#footer span:before', "color",$footer_iconcolor,'important' );
}
$footer_text=of_get_option('footer_text');
if ($footer_text) {
	$dynamic_css .= mtheme_change_class( '#footer,#footer .footer-column .sidebar-widget,#footer .contact_address_block .contact_name', "color",$footer_text,'' );
}
$footer_link=of_get_option('footer_link');
if ($footer_link) {
	$dynamic_css .= mtheme_change_class( '#footer a,#footer .footer-column .sidebar-widget a', "color",$footer_link,'' );
}
$footer_linkhover=of_get_option('footer_linkhover');
if ($footer_linkhover) {
	$dynamic_css .= mtheme_change_class( '#footer a:hover,#footer .footer-column .sidebar-widget a:hover', "color",$footer_linkhover,'' );
}
$footer_hline=of_get_option('footer_hline');
if ($footer_hline) {
	$dynamic_css .= mtheme_change_class( '#footer.sidebar ul li', "border-top-color",$footer_hline,'' );
}
$footer_copyrightbg=of_get_option('footer_copyrightbg');
if ($footer_copyrightbg) {
	$dynamic_css .= mtheme_change_class( '#copyright', "background-color",$footer_copyrightbg,'' );
}
$footer_copyrighttext=of_get_option('footer_copyrighttext');
if ($footer_copyrighttext) {
	$dynamic_css .= mtheme_change_class( '#copyright', "color",$footer_copyrighttext,'' );
}



$fullscreen_toggle_color = of_get_option('fullscreen_toggle_color');
if ($fullscreen_toggle_color) {
	$dynamic_css .= mtheme_change_class( '.menu-toggle',"color", $fullscreen_toggle_color,'' );
}
$fullscreen_toggle_bg = of_get_option('fullscreen_toggle_bg');
if ($fullscreen_toggle_bg) {
	$dynamic_css .= mtheme_change_class( '.menu-toggle',"background-color", $fullscreen_toggle_bg,'' );
	$dynamic_css .= mtheme_change_class( '.menu-toggle:after',"border-color", $fullscreen_toggle_bg,'' );
}

$fullscreen_toggle_hovercolor = of_get_option('fullscreen_toggle_hovercolor');
if ($fullscreen_toggle_hovercolor) {
	$dynamic_css .= mtheme_change_class( '.menu-toggle:hover',"color", $fullscreen_toggle_hovercolor,'' );
}

$fullscreen_toggle_hoverbg = of_get_option('fullscreen_toggle_hoverbg');
if ($fullscreen_toggle_hoverbg) {
	$dynamic_css .= mtheme_change_class( '.menu-toggle:hover',"background-color", $fullscreen_toggle_hoverbg,'' );
	$dynamic_css .= mtheme_change_class( '.menu-toggle:hover:after',"border-color", $fullscreen_toggle_hoverbg,'' );
}

$footer_copyrightbg=of_get_option('footer_copyrightbg');
$footer_copyrightbg_rgb=mtheme_hex2RGB($footer_copyrightbg,true);
if ($footer_copyrightbg) {
	$dynamic_css .= '#copyright { background:rgba('. $footer_copyrightbg_rgb .',0.8); }';
}
$footer_copyrighttext=of_get_option('footer_copyrighttext');
if ($footer_copyrighttext) {
	$dynamic_css .= mtheme_change_class( '#copyright', "color",$footer_copyrighttext,'' );
}


$sidebar_headingcolor=of_get_option('sidebar_headingcolor');
if ($sidebar_headingcolor) {
	$dynamic_css .= mtheme_change_class( '.sidebar h3', "color",$sidebar_headingcolor,'' );
}
$sidebar_linkcolor=of_get_option('sidebar_linkcolor');
if ($sidebar_linkcolor) {
	$dynamic_css .= mtheme_change_class( '#recentposts_list .recentpost_info .recentpost_title, #popularposts_list .popularpost_info .popularpost_title,.sidebar a', "color",$sidebar_linkcolor,'' );
}
$sidebar_linkbordercolor=of_get_option('sidebar_linkbordercolor');
if ($sidebar_linkbordercolor) {
	$dynamic_css .= mtheme_change_class( '.sidebar ul li', "border-color",$sidebar_linkbordercolor,'' );
}
$sidebar_textcolor=of_get_option('sidebar_textcolor');
if ($sidebar_textcolor) {
	$dynamic_css .= mtheme_change_class( '.contact_address_block .about_info, #footer .contact_address_block .about_info, #recentposts_list p, #popularposts_list p,.sidebar-widget ul#recentcomments li,.sidebar', "color",$sidebar_textcolor,'' );
}

if ( of_get_option('custom_font_css')<>"" ) {
	$dynamic_css .= of_get_option('custom_font_css');
}

$photowall_title_color=of_get_option('photowall_title_color');
if ($photowall_title_color) {
$dynamic_css .= mtheme_change_class( '.photowall-title', "color",$photowall_title_color,'' );
}

$photowall_description_color=of_get_option('photowall_description_color');
if ($photowall_description_color) {
$dynamic_css .= mtheme_change_class( '.photowall-desc', "color",$photowall_description_color,'' );
}

$photowall_hover_titlecolor=of_get_option('photowall_hover_titlecolor');
if ($photowall_hover_titlecolor) {
$dynamic_css .= mtheme_change_class( '.photowall-item:hover .photowall-title', "color",$photowall_hover_titlecolor,'' );
}
$photowall_hover_descriptioncolor=of_get_option('photowall_hover_descriptioncolor');
if ($photowall_hover_descriptioncolor) {
$dynamic_css .= mtheme_change_class( '.photowall-item:hover .photowall-desc', "color",$photowall_hover_descriptioncolor,'' );
}

$photowall_description_color=of_get_option('photowall_description_color');
if ($photowall_description_color) {
$dynamic_css .= mtheme_change_class( '.photowall-desc', "color",$photowall_description_color,'' );
}

// The icons
$forum_icon_css = mtheme_set_fontawesome('fa fa-cubes' , of_get_option('forum_icon') , $get_css_code = true );
if ( isSet($forum_icon_css) ) {
	$dynamic_css .= '
	#bbpress-forums ul.forum li.bbp-forum-info:before {
	content:"'.$forum_icon_css.'";
	}
	';
}

$blog_allowedtags=of_get_option('blog_allowedtags');
if ($blog_allowedtags) {
$dynamic_css .= '.form-allowed-tags { display:none; }';
}
$dynamic_css .= stripslashes_deep( of_get_option('custom_css') );

//Mobile Specific
$mobile_css = stripslashes_deep( of_get_option('mobile_css') );
if (isSet($mobile_css)) {
	$dynamic_css .= '
	@media only screen and (max-width: 1024px) {
		'.$mobile_css.'
	}
	@media only screen and (min-width: 768px) and (max-width: 959px) {
		'.$mobile_css.'
	}
	@media only screen and (max-width: 767px) {
		'.$mobile_css.'
	}
	@media only screen and (min-width: 480px) and (max-width: 767px) {
		'.$mobile_css.'
	}';
}

$lightbox_disable=of_get_option('lightbox_sharing_disable');
if ($lightbox_disable) {
$dynamic_css .= '.maginific-lightbox-sharing { display:none; }';
}
$lightbox_max_space=of_get_option('lightbox_max_space');
if ($lightbox_max_space) {
$dynamic_css .= '.mfp-bottom-bar { display:none; } img.mfp-img { padding: 5px 0; }';
}
$lightbox_counter_disable=of_get_option('lightbox_counter_disable');
if ($lightbox_counter_disable) {
$dynamic_css .= '.mfp-counter { display:none; }';
}
$lightbox_arrows_disable=of_get_option('lightbox_arrows_disable');
if ($lightbox_arrows_disable) {
$dynamic_css .= '.mfp-arrow { display:none; } .mfp-container{ padding-left:5px; padding-right:5px;}';
}
$lightbox_title_disable=of_get_option('lightbox_title_disable');
if ($lightbox_title_disable) {
$dynamic_css .= '.mfp-title { text-indent:-999999px; } .maginific-lightbox-sharing { text-indent:0; }';
}
$lightbox_bgcolor=of_get_option('lightbox_bgcolor');
if ($lightbox_bgcolor) {
$dynamic_css .= '.mfp-bg,.theme-is-dark .mfp-bg { background-color:'.$lightbox_bgcolor.'; }';
}
$lightbox_elementcolor=of_get_option('lightbox_elementcolor');
if ($lightbox_elementcolor) {
$dynamic_css .= '.mfp-arrow,.mfp-close,.mfp-content .maginific-lightbox-sharing .lightbox-share i,.mfp-title,.mfp-counter { color:'.$lightbox_elementcolor.'; }';
}


// Font size
$pagecontent_fontsize=of_get_option('pagecontent_fontsize');
if ($pagecontent_fontsize<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .entry-summary div[itemprop="description"],
#footer .contact_address_block .about_info,
.contact_address_block,
.sidebar,
.sidebar-widget,
#footer .contact_address_block .contact_name {
	font-size:'.$pagecontent_fontsize.'px;
}';
}
// Line Height
$pagecontent_lineheight=of_get_option('pagecontent_lineheight');
if ($pagecontent_lineheight<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .entry-summary div[itemprop="description"],
#footer .contact_address_block .about_info,
.contact_address_block,
.sidebar,
.sidebar-widget,
#footer .contact_address_block .contact_name {
	line-height:'.$pagecontent_lineheight.'px;
}';
}
// Letter Spacing
$pagecontent_letterspacing=of_get_option('pagecontent_letterspacing');
if ($pagecontent_letterspacing<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .entry-summary div[itemprop="description"],
#footer .contact_address_block .about_info,
.contact_address_block,
.sidebar,
.sidebar-widget,
#footer .contact_address_block .contact_name {
	letter-spacing:'.$pagecontent_letterspacing.'px;
}';
}
// Portfolio Grids
$portfolio_iconlink=of_get_option('portfolio_iconlink');
$portfolio_iconlink_rgb=mtheme_hex2RGB($portfolio_iconlink,true);
if ($portfolio_iconlink_rgb<>"") {
$dynamic_css .= '.column-gridblock-icon:after { background: rgba('. $portfolio_iconlink_rgb .', 0.9); }';
$dynamic_css .= '.column-gridblock-icon:hover:after { background: rgba('. $portfolio_iconlink_rgb .', 1); }';
}
$portfolio_gridicon=of_get_option('portfolio_gridicon');
if ($portfolio_gridicon<>"") {
$dynamic_css .= '
.column-gridblock-icon i {
	color:'.$portfolio_gridicon.';
}';
}
$portfolio_hovercolor=of_get_option('portfolio_hovercolor');
if ($portfolio_hovercolor<>"") {
$dynamic_css .= '
.gridblock-background-hover {
	background-color:'.$portfolio_hovercolor.';
}';
}
$portfolio_grid_opacity=of_get_option('portfolio_grid_opacity');
$portfolio_hoveropacity=of_get_option('portfolio_hoveropacity');
if ($portfolio_grid_opacity) {
	$portfolio_hovercolor_rgb=mtheme_hex2RGB($portfolio_hovercolor,true);
	$portfolio_hoveropacity=of_get_option('portfolio_hoveropacity')/100;
	$dynamic_css .= '.gridblock-background-hover { background: rgba('. $portfolio_hovercolor_rgb .','.$portfolio_hoveropacity.'); }';
}
// Font Weight
$pagecontent_fontweight=of_get_option('pagecontent_fontweight');
if ($pagecontent_fontweight<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .entry-summary div[itemprop="description"],
#footer .contact_address_block .about_info,
.contact_address_block,
.sidebar,
.sidebar-widget,
#footer .contact_address_block .contact_name {
	font-weight:'.$pagecontent_fontweight.';
}';
}
$hide_pagetitle=of_get_option('hide_pagetitle');
if ($hide_pagetitle=="1") {
	$dynamic_css .= '.title-container { display:none; }';
}
$pagetitle_size=of_get_option('pagetitle_size');
if ($pagetitle_size<>"") {
	$dynamic_css .= '.entry-title h1 { font-size:'.$pagetitle_size.'px; line-height:'.$pagetitle_size.'px; }';
}
$pagetitle_letterspacing=of_get_option('pagetitle_letterspacing');
if ($pagetitle_letterspacing<>"") {
	$dynamic_css .= '.entry-title h1 { letter-spacing:'.$pagetitle_letterspacing.'px; }';
}
$pagetitle_weight=of_get_option('pagetitle_weight');
if ($pagetitle_weight<>"") {
	$dynamic_css .= '.entry-title h1 { font-weight:'.$pagetitle_weight.'; }';
}
//Mobile Menu color
$mobilemenubar_bgcolor=of_get_option('mobilemenubar_bgcolor');
if ($mobilemenubar_bgcolor) {
	$dynamic_css .= mtheme_change_class('.theme-is-dark .mobile-menu-toggle,.mobile-menu-toggle,.header-is-simple.theme-is-dark .mobile-menu-icon,.header-is-simple.theme-is-light .mobile-menu-icon',"background-color",$mobilemenubar_bgcolor,'');
}
$mobilemenubar_togglecolor=of_get_option('mobilemenubar_togglecolor');
if ($mobilemenubar_togglecolor) {
	$dynamic_css .= mtheme_change_class('.theme-is-dark .mobile-menu-icon,.mobile-menu-icon,.theme-is-light.body-dashboard-push-left .mobile-menu-icon',"color",$mobilemenubar_togglecolor,'');
}
$mobilemenu_bgcolor=of_get_option('mobilemenu_bgcolor');
if ($mobilemenu_bgcolor) {
	$dynamic_css .= mtheme_change_class('.responsive-mobile-menu,.theme-is-light .responsive-mobile-menu',"background-color",$mobilemenu_bgcolor,'');
	$dynamic_css .= '.theme-is-dark .responsive-mobile-menu #mobile-searchform input { border-color: rgba(255,255,255,0.1); }';
	$dynamic_css .= '.theme-is-light .responsive-mobile-menu #mobile-searchform input { border-color: rgba(0,0,0,0.1); }';
}
$mobilemenu_bgimage=of_get_option('mobilemenu_bgimage');
if ($mobilemenu_bgimage) {
	$dynamic_css .= 'body .responsive-mobile-menu,body.theme-is-light .responsive-mobile-menu { background-image: url('.$mobilemenu_bgimage.'); }';
}
$mobilemenu_texticons=of_get_option('mobilemenu_texticons');
$mobilemenu_texticons_rgb=mtheme_hex2RGB($mobilemenu_texticons,true);
if ($mobilemenu_bgcolor) {
	$dynamic_css .= mtheme_change_class('
	.theme-is-light .responsive-mobile-menu #mobile-searchform input,
	.theme-is-dark .responsive-mobile-menu #mobile-searchform input,
	.theme-is-light .responsive-mobile-menu ul.mtree li li a,
	.theme-is-light .responsive-mobile-menu ul.mtree li a,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li li a,
	.theme-is-dark .responsive-mobile-menu ul.mtree li li a,
	.theme-is-dark .responsive-mobile-menu ul.mtree li a,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li li a,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li a,
	.theme-is-light .responsive-mobile-menu ul.mtree a,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree a,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree a,
	.theme-is-dark .mobile-social-header .social-header-wrap ul li.social-icon i,
	.theme-is-dark .mobile-social-header .social-header-wrap ul li.contact-text a,
	.theme-is-light .mobile-social-header .social-header-wrap ul li.social-icon i,
	.theme-is-light .mobile-social-header .social-header-wrap ul li.contact-text a,
	.mobile-social-header .social-header-wrap ul li.social-icon i,
	.mobile-social-header .social-header-wrap ul li.contact-text a,
	.mobile-social-header .social-header-wrap ul li.contact-text i,
	.theme-is-light .responsive-mobile-menu #mobile-searchform i,
	.theme-is-dark .responsive-mobile-menu #mobile-searchform i',"color",$mobilemenu_texticons,'');
}
$mobilemenu_linecolors=of_get_option('mobilemenu_linecolors');
$mobilemenu_linecolors_rgb=mtheme_hex2RGB($mobilemenu_linecolors,true);
if ($mobilemenu_linecolors) {
	$dynamic_css .= mtheme_change_class('ul.mtree li.mtree-node > ul > li:last-child,.theme-is-light ul.mtree a,.theme-is-dark ul.mtree a,.theme-is-light .responsive-mobile-menu #mobile-searchform input,.theme-is-dark .responsive-mobile-menu #mobile-searchform input',"border-color",$mobilemenu_linecolors,'');
	$dynamic_css .= mtheme_change_class('.theme-is-light ul.mtree li.mtree-node > a::before,.theme-is-dark ul.mtree li.mtree-node > a::before',"color",$mobilemenu_linecolors,'');
}
$mobilemenu_hover=of_get_option('mobilemenu_hover');
if ($mobilemenu_hover) {
	$dynamic_css .= mtheme_change_class('
	.theme-is-light .responsive-mobile-menu ul.mtree li li a:hover,
	.theme-is-dark .responsive-mobile-menu ul.mtree li li a:hover,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a:hover,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li.mtree-open > a:hover,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree a:hover,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree a:hover,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li li a:hover,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li li a:hover,
	.theme-is-light ul.mtree li > a:hover,
	.theme-is-light ul.mtree a:hover,
	.theme-is-dark ul.mtree li > a:hover,
	.theme-is-dark ul.mtree a:hover',"color",$mobilemenu_hover,'');
}
$mobilemenu_active=of_get_option('mobilemenu_active');
if ($mobilemenu_active) {
	$dynamic_css .= mtheme_change_class('
		.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a,
		.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li.mtree-open > a,
		.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a,
		.theme-is-dark .responsive-mobile-menu ul.mtree li.mtree-open > a',"color",$mobilemenu_active,'');
}
$rcm_size=of_get_option('rcm_size');
if ($rcm_size<>"") {
	$dynamic_css .= '.dimmer-text { font-size:'.$rcm_size.'px; line-height:'.$rcm_size.'px; }';
}
$rcm_letterspacing=of_get_option('rcm_letterspacing');
if ($rcm_letterspacing<>"") {
	$dynamic_css .= '.dimmer-text { letter-spacing:'.$rcm_letterspacing.'px; }';
}
$rcm_weight=of_get_option('rcm_weight');
if ($rcm_weight<>"") {
	$dynamic_css .= '.dimmer-text { font-weight:'.$rcm_weight.'; }';
}
$rcm_textcolor=of_get_option('rcm_textcolor');
if ($rcm_textcolor) {
	$dynamic_css .= " .dimmer-text { color:".$rcm_textcolor."; }";
}
$rcm_bgcolor=of_get_option('rcm_bgcolor');
if ($rcm_bgcolor) {
	$dynamic_css .= " .dimmer-text { background:".$rcm_bgcolor."; }";
}
?>