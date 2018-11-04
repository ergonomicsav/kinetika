<?php
/**
*  Sidebar
 */
?>
<?php
global $mtheme_sidebar_choice,$mtheme_pagestyle;
if ( !is_singular() ) {
	if ( mtheme_page_is_woo_shop() ) {
	} else {
		unset($mtheme_sidebar_choice);
	}
}
if ( mtheme_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$mtheme_pagestyle = get_post_meta($woo_shop_post_id, MTHEME . '_pagestyle', true);
}
$sidebar_position="sidebar-float-right";
if ($mtheme_pagestyle=="rightsidebar") { $sidebar_position = 'sidebar-float-right'; }
if ($mtheme_pagestyle=="leftsidebar") { $sidebar_position = 'sidebar-float-left'; }
?>
<div id="sidebar" class="sidebar-wrap<?php if ( is_single() || is_page() ) { echo "-single"; } ?> <?php echo esc_attr($sidebar_position); ?>">
		<div class="sidebar clearfix">
			<!-- begin Dynamic Sidebar -->
			<?php
			if ( !isset($mtheme_sidebar_choice) || empty($mtheme_sidebar_choice) ) {
				$mtheme_sidebar_choice="default_sidebar";
			}
			if ( mtheme_page_is_woo_shop() ) {
				if (!isSet($mtheme_sidebar_choice)) {
					if ( class_exists( 'woocommerce' ) ) {
						if (is_woocommerce()) {
							$mtheme_sidebar_choice="woocommerce_sidebar";
						}
					}
				}
			}
			?>
			<?php
			if ( class_exists( 'woocommerce' ) ) {
				if ( is_woocommerce() ) {
					$mtheme_sidebar_choice="woocommerce_sidebar";
				}
			}
			if ( is_active_sidebar( $mtheme_sidebar_choice ) ) {
				dynamic_sidebar($mtheme_sidebar_choice);
			}
			?>
	</div>
</div>