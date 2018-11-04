<?php
$display_fullscreen_toggle=true;
$disable_fullscreentoggle = of_get_option('disable_fullscreentoggle');
$fullscreen_fullscreentoggle = of_get_option('fullscreen_fullscreentoggle');
$fullscreen_homepagetoggle = of_get_option('fullscreen_homepagetoggle');
if ($fullscreen_fullscreentoggle) {
	if (mtheme_is_fullscreen_post() ) {
		$display_fullscreen_toggle=true;
	} else {
		$display_fullscreen_toggle=false;
	}
}
if ($fullscreen_homepagetoggle) {
	if ( is_home() ) {
		$display_fullscreen_toggle=true;
	} else {
		$display_fullscreen_toggle=false;
	}
}
if ($disable_fullscreentoggle) {
	$display_fullscreen_toggle=false;
}
if ( is_singular() ) {
	if( get_post_meta(get_the_id(), MTHEME . '_page_fullscreentoggle', true) ) {
		$page_fullscreentoggle = get_post_meta(get_the_id(), MTHEME . '_page_fullscreentoggle', true);
		if (isSet($page_fullscreentoggle)) {
			if ( $page_fullscreentoggle == "show" ) {
				$display_fullscreen_toggle=true;
			}
			if ( $page_fullscreentoggle == "hide" ) {
				$display_fullscreen_toggle=false;
			}
		}
	}
}

if ( $display_fullscreen_toggle ) {
	if ( !is_404() ) {
		do_action('mtheme_fullscreen_toggle');
	}
}
function mtheme_menu_logo($header_menu_type="header-middle") {
	if (MTHEME_DEMO_STATUS) {
		if (isSet($_GET['menu_type'])) {
			$header_menu_type = mtheme_demo_data_fetch($_GET['menu_type']);
		}
	} else {
		$header_menu_type = of_get_option('header_menu_type');
	}
	$logo_element = '';
	if ( $header_menu_type == "header-middle" && has_nav_menu( "main_menu" ) ) {
		//$logo_element .= '<li id="header-logo">';
	}
	$sticky_main_logo=of_get_option('sticky_main_logo');
	$sticky_logo_class='';
	if ($sticky_main_logo<>"") {
		$sticky_logo_class = " sticky-alt-logo-present";
	}
	$logo_element .= '<div class="header-logo-section">';
		$logo_element .= '<div class="logo'.$sticky_logo_class.'">';
			if (MTHEME_DEMO_STATUS) {
				$home_url_path = esc_url( add_query_arg($_GET ,home_url()) );
			} else {
				$home_url_path = home_url('/');
			}
			$logo_element .= '<a href="'.esc_url($home_url_path).'">';

				$theme_style=of_get_option('theme_style');
				$main_logo=of_get_option('main_logo');
				if (MTHEME_DEMO_STATUS) {
					if ( isSet($_GET['themeskin'] )) { 
						$demo_skin = $_GET['themeskin'];
						if ($demo_skin == "light") {
							$theme_style = "light";
						}
						if ($demo_skin == "dark") {
							$theme_style = "dark";
						}
					}
				}
				if (! MTHEME_DEMO_STATUS && $main_logo <> "") {
					$logo_element .= '<img class="logo-theme-main" src="'.esc_url($main_logo).'" alt="logo" />';
				} else {
					if ($header_menu_type=="minimal-header") {
						$logo_element .= '<img class="logo-theme-main" src="'.esc_url(MTHEME_PATH.'/images/logo_simple.png').'" alt="logo" />';
					} else {
						if ($theme_style=="light") {
							$logo_element .= '<img class="logo-theme-main" src="'.esc_url(MTHEME_PATH.'/images/logo_dark.png').'" alt="logo" />';
						} else {
							$logo_element .= '<img class="logo-theme-main" src="'.esc_url(MTHEME_PATH.'/images/logo.png').'" alt="logo" />';
						}
					}
				}
				if ($sticky_main_logo<>"") {
					$logo_element .=  '<img class="logo-sticky-main" src="'.esc_url($sticky_main_logo).'" alt="stickylogo" />';
				}

			$logo_element .= '</a>';
		$logo_element .= '</div>';
	$logo_element .= '</div>';
	if ( $header_menu_type == "header-middle" && has_nav_menu( "main_menu" ) ) {
		//$logo_element .=  '</li>';
	}
	return $logo_element;
}
$theme_menu_type = of_get_option('header_menu_type');
if (MTHEME_DEMO_STATUS) {
	if (isSet($_GET['menu_type'])) {
		$theme_menu_type = mtheme_demo_data_fetch($_GET['menu_type']);
	}
}
if ($theme_menu_type=="vertical-menu") {
	get_template_part('/includes/menu/vertical','menu');
} else {
	?>
	<div class="stickymenu-zone outer-wrap">
		<div class="outer-header-wrap clearfix">
			<nav>
				<div class="mainmenu-navigation">
						<?php
						$header_menu_type = of_get_option('header_menu_type');
						if ($header_menu_type=="" || !isSet($header_menu_type) || $header_menu_type!="header-middle" || $header_menu_type!="header-center" || $header_menu_type!="header-left" ) {
							$header_menu_type="header-middle";
						}
						echo mtheme_menu_logo($header_menu_type);
						if ($theme_menu_type <> "minimal-header") {
							if ( has_nav_menu( "main_menu" ) ) {
							?>
								<div class="homemenu">
							<?php
								$custom_menu_call = '';
								$user_choice_of_menu = get_post_meta( get_the_id() , MTHEME . '_menu_choice', true);
								if ( mtheme_page_is_woo_shop() ) {
									$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
									$user_choice_of_menu = get_post_meta( $woo_shop_post_id , MTHEME . '_menu_choice', true);
								}
								if ( isSet($user_choice_of_menu) && $user_choice_of_menu <> "default") {
									$custom_menu_call = $user_choice_of_menu;
								}
								if (MTHEME_DEMO_STATUS) {
									if ( is_page('one-page') ) {
										$custom_menu_call = 'onepage';
									}
								}
								wp_nav_menu( array(
								 'container' =>false,
								 'menu' => $custom_menu_call,
								 'theme_location' => 'main_menu',
								 'menu_class' => 'sf-menu mtheme-left-menu',
								 'echo' => true,
								 'before' => '',
								 'after' => '',
								 'link_before' => '',
								 'link_after' => '',
								 'depth' => 0,
								 'fallback_cb' => 'mtheme_nav_fallback'
								 )
								);
								if ( !of_get_option('mtheme_woocart_menu') ) {
									if ( class_exists( 'woocommerce' ) ) {
										echo '<span class="header-cart header-cart-toggle"><i class="feather-icon-bag"></i></span>';
									}
									do_action('mtheme_header_woocommerce_shopping_cart_counter');
								}
							?>
							</div>
							<?php
							}
						}
						?>
				</div>
			</nav>
		</div>
	</div>
	<?php
	// WPML
	$wpml_lang_selector_disable= of_get_option('wpml_lang_selector_disable');
	if (!$wpml_lang_selector_disable) {
	?>
	<div class="wpml-lang-selector-wrap">
		<?php do_action('icl_language_selector'); ?>
	</div>
	<?php
	}
}
?>
