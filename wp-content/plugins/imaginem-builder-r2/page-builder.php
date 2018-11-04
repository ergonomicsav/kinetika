<?php
/*
Plugin Name: iMaginem Pagebuilder r2
Plugin URI: http://www.imaginemthemes.com
Description: Page builder for Imaginem Themes.
Version: 2.7
Author: iMaginem
Author URI: http://www.imaginemthemes.com

Page Builder based on Aqua Page builder by Syamil
https://github.com/syamilmj/aqua-page-builder/

* Released under the GPL license
* http://www.opensource.org/licenses/gpl-license.php
*/
//definitions
if(!defined('AQPB_PATH')) define( 'AQPB_PATH', plugin_dir_path(__FILE__) );
if(!defined('AQPB_DIR')) define( 'AQPB_DIR', plugin_dir_path(__FILE__) );
if(!defined('MTHEME_BUILDER_PRESETS')) define( 'MTHEME_BUILDER_PRESETS', plugin_dir_path(__FILE__) . '/builder-presets' );
define('mtheme_PLUGIN_URI', plugin_dir_url( __FILE__ ));
add_action('plugins_loaded', 'imaginem_builder_initialize');

function imaginem_builder_initialize() {
	load_plugin_textdomain( 'mthemelocal', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
//required functions & classes
require_once('functions/page-functions.php');
require_once('functions/aqpb_config.php');
require_once('classes/class-aq-page-builder.php');
require_once('classes/class-aq-block.php');
require_once('functions/aqpb_functions.php');

require_once('plugs/mpb-photocard.php');
	mtheme_register_block('em_photocard');
require_once('plugs/mpb-pageshare.php');
	mtheme_register_block('em_pageshare');
require_once('plugs/mpb-callout.php');
	mtheme_register_block('em_callout');
require_once('plugs/mpb-linkscarousel.php');
	mtheme_register_block('em_linkscarousel');
require_once('plugs/mpb-lightboxcarousel.php');
	mtheme_register_block('em_lightboxcarousel');
require_once('plugs/mpb-slideshowcarousel.php');
	mtheme_register_block('em_slideshowcarousel');
require_once('plugs/mpb-heroimage.php');
	mtheme_register_block('em_heroimage');
require_once('plugs/mpb-services.php');
	mtheme_register_block('em_serviceboxes');
require_once('plugs/mpb-service-list.php');
	mtheme_register_block('em_servicelist');
require_once('plugs/mpb-singleimage.php');
	mtheme_register_block('em_singleimage');
require_once('plugs/mpb-displayshortcode.php');
	mtheme_register_block('em_displayshortcode');
require_once('plugs/mpb-richtext.php');
	mtheme_register_block('em_displayrichtext');
require_once('plugs/mpb-fontawesome.php');
	mtheme_register_block('em_FontAwesome');
require_once('plugs/mpb-socialicons.php');
	mtheme_register_block('em_social');
require_once('plugs/mpb-accordions.php');
	mtheme_register_block('em_accordions');
require_once('plugs/mpb-tabs.php');
	mtheme_register_block('em_tabs');
require_once('plugs/mpb-worktype-albums.php');
	mtheme_register_block('em_worktype_albums');
require_once('plugs/mpb-thumbnail-grid.php');
	mtheme_register_block('em_thumbnails');
require_once('plugs/mpb-portfolio-grid.php');
	mtheme_register_block('em_portfolio_grid');
require_once('plugs/mpb-portfolio-slideshow.php');
	mtheme_register_block('em_portfolio_slideshow');
require_once('plugs/mpb-blog-slideshow.php');
	mtheme_register_block('em_blog_slideshow');
require_once('plugs/mpb-audio.php');
	mtheme_register_block('em_audio');
require_once('plugs/mpb-pullquote.php');
	mtheme_register_block('em_pullquote');
require_once('plugs/mpb-pricingtable.php');
	mtheme_register_block('em_pricingtable');
require_once('plugs/mpb-button.php');
	mtheme_register_block('em_button');
require_once('plugs/mpb-alerts.php');
	mtheme_register_block('em_alerts');
require_once('plugs/mpb-fromtocounter.php');
	mtheme_register_block('em_fromtocounter');
require_once('plugs/mpb-circularcounter.php');
	mtheme_register_block('em_circularcounter');
require_once('plugs/mpb-staff.php');
	mtheme_register_block('em_staff');
require_once('plugs/mpb-checklist.php');
	mtheme_register_block('em_checklist');
require_once('plugs/mpb-toggle.php');
	mtheme_register_block('em_toggle');
require_once('plugs/mpb-lightbox.php');
	mtheme_register_block('em_lightbox');
require_once('plugs/mpb-testimonials.php');
	mtheme_register_block('em_testimonials');
require_once('plugs/mpb-progressbar.php');
	mtheme_register_block('em_progressbar');
require_once('plugs/mpb-blog-grid.php');
	mtheme_register_block('em_blog_grid');
require_once('plugs/mpb-blog-timeline.php');
	mtheme_register_block('em_blog_timeline');
require_once('plugs/mpb-blog-list.php');
	mtheme_register_block('em_blog_list');
require_once('plugs/mpb-blog-carousel.php');
	mtheme_register_block('em_blog_carousel');
require_once('plugs/mpb-works-carousel.php');
	mtheme_register_block('em_works_carousel');
require_once('plugs/mpb-infoboxes.php');
	mtheme_register_block('em_infoboxes');
require_once('plugs/mpb-sectionheading.php');
	mtheme_register_block('em_sectionheading');
require_once('plugs/mpb-dividers.php');
	mtheme_register_block('em_dividers');
require_once('plugs/mpb-beforeafter.php');
	mtheme_register_block('em_beforeafter');
require_once('plugs/mpb-gmap.php');
	mtheme_register_block('em_googlemap');
require_once('plugs/mpb-portfolio-details.php');
	mtheme_register_block('em_portfolio_details');
// require_once('plugs/mpb-woobestseller.php');
// 	mtheme_register_block('em_woobestseller');
require_once('plugs/mpb-column-block.php');
	mtheme_register_block('em_column_block');
require_once('plugs/mpb-metro-grid.php');
	mtheme_register_block('em_metro');
require_once('plugs/mpb-pricing-service.php');
	mtheme_register_block('em_pricingservice');
require_once('plugs/mpb-hline.php');
	mtheme_register_block('em_hline');
require_once('plugs/mpb-youtubevideo.php');
	mtheme_register_block('em_youtubevideo');
require_once('plugs/mpb-vimeovideo.php');
	mtheme_register_block('em_vimeovideo');
require_once('plugs/mpb-blog-listsmall.php');
	mtheme_register_block('em_blog_list_small');
require_once('plugs/mpb-textbox.php');
	mtheme_register_block('em_textbox');
require_once('plugs/mpb-imagebox.php');
	mtheme_register_block('em_imageboxes');
require_once('plugs/mpb-modal.php');
	mtheme_register_block('em_modal');
require_once('plugs/mpb-photostory-grid.php');
	mtheme_register_block('em_photostory_grid');
//Page builder
$aqpb_config = mtheme_page_builder_config();
$aq_page_builder = new AQ_Page_Builder($aqpb_config);
if(!is_network_admin()) $aq_page_builder->init();
}

if ( !function_exists( 'mtheme_builder_button' ) ) {
	function mtheme_builder_button( $post ) {
		$post_type = ! empty($post) ? $post->post_type : get_current_screen()->post_type;
		if ( 'page' !== $post_type && 'post' !== $post_type && 'mtheme_portfolio' !== $post_type && 'mtheme_events' !== $post_type )
			return;
		?>
		<div class="mtheme-edit-pb-wrap clearfix">
			<div class="mtheme-edit-null">
				<?php _e('Use Pagebuilder for this page','mthemelocal'); ?> <span class="mtheme-pb-choice mtheme-pb-yes"><i class="fa fa-check"></i></span> <span class="mtheme-pb-choice mtheme-pb-no"><i class="fa fa-times"></i></span>
			</div>
			<div class="mtheme-edit-pb">
				<i class="fa fa-cubes"></i> <?php _e('Using Page Builder.','mthemelocal'); ?> <span class="mtheme-pb-change">( <?php _e('Change','mthemelocal'); ?> )</span>
			</div>
			<div class="mtheme-edit-visual">
				<i class="fa fa-pencil"></i> <?php _e('Using Editor.','mthemelocal'); ?>  <span class="mtheme-pb-change">( <?php _e('Change','mthemelocal'); ?> )</span>
			</div>
		</div>
		<?php
	}
}
add_action( 'edit_form_after_title', 'mtheme_builder_button' );
?>