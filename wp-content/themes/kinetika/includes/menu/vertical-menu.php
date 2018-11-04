<div class="vertical-menu clearfix">
	<div class="vertical-logo-wrap">
			<?php
			$vmain_logo=of_get_option('vmain_logo');
			$theme_style=of_get_option('theme_style');
			if (MTHEME_DEMO_STATUS) {
				$home_url_path = esc_url( add_query_arg($_GET ,home_url()) );
			} else {
				$home_url_path = home_url('/');
			}
			$menu_logo = '<a href="'.esc_url($home_url_path).'">';

			if ( !MTHEME_DEMO_STATUS ) {
				if ( $vmain_logo <> "" ) {
					$menu_logo .= '<img class="vertical-logoimage" src="'.esc_url($vmain_logo).'" alt="logo" />';
				} else {
					$menu_logo .= '<img class="vertical-logoimage" src="'.esc_url(MTHEME_PATH.'/images/logo_dark_v.png').'" alt="logo" />';
				}
			} else {
				$menu_logo .= '<img class="vertical-logoimage" src="'.esc_url(MTHEME_PATH.'/images/logo_dark_v.png').'" alt="logo" />';
			}
			$menu_logo .= '</a>';
			echo $menu_logo;
			?>
	</div>
	<?php
	$wpml_lang_selector_disable= of_get_option('wpml_lang_selector_disable');
	if (!$wpml_lang_selector_disable) {
		if ( function_exists('icl_object_id') ) {
	?>
	<div class="mobile-wpml-lang-selector-wrap">
		<?php do_action('icl_language_selector'); ?>
	</div>
	<?php
		}
	}
	?>
	<nav>
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
	// Responsive menu conversion to drop down list
	if ( function_exists('wp_nav_menu') ) { 
		wp_nav_menu( array(
		 'container' =>false,
		 'theme_location' => 'main_menu',
		 'menu' => $custom_menu_call,
		 'menu_class' => 'mtree',
		 'echo' => true,
		 'before' => '',
		 'after' => '',
		 'link_before' => '',
		 'link_after' => '',
		 'depth' => 0,
		 'fallback_cb' => 'mtheme_nav_fallback'
		 )
		);
	}
	?>
	</nav>
	<div class="vertical-footer-wrap">
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
		<div class="fullscreen-footer-info">
		<?php
		$footer_info = stripslashes_deep( of_get_option('footer_copyright') );
		echo do_shortcode( $footer_info );
		?>
		</div>
	</div>
</div>