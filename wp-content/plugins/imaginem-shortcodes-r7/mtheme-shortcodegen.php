<?php
/*
Plugin Name: iMaginem Shortcodes Generator r7
Plugin URI: http://www.imaginemthemes.com
Description: Imaginem Themes Shortcode Generator r7
Version: 3.2
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

class mthemeShortcodes {

    function __construct() 
    {
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/general.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/icons.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/slideshow.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/video.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/gmaps.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/audio.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/staff.php');
		//require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/twitter.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/portfolio-blocks.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/fullscreen-blocks.php');
		require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/proofing.php');
		//require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/knowledgebase.php');
		//require_once ( plugin_dir_path( __FILE__ ) . '/shortcodes/bbpress.php');
    	define('mtheme_TINYMCE_URI', plugin_dir_url( __FILE__ ) .'tinymce');
		define('mtheme_TINYMCE_DIR', plugin_dir_url( __FILE__ ) .'tinymce');
		define('mtheme_PLUGIN_JS_DIR', plugin_dir_url( __FILE__ ) . 'js' );

		
        add_action('init', array(&$this, 'init'));
        if ( 'post-new.php' == basename($_SERVER['PHP_SELF']) || 'post.php' == basename($_SERVER['PHP_SELF'])) {
        	add_action('admin_init', array(&$this, 'admin_init'));
    	}

		// Checks Theme shortcodes only mentioned in the array.
		add_filter('the_content', array(&$this, 'mtheme_shortcodes_format'));
		add_filter('widget_text', array(&$this, 'mtheme_shortcodes_format'));
	}

	// This function specifially checks theme shortcodes and removes empty P and BR tags from them.
	// It doesn't modify the_content as only the built in shortcodes are checked.
	function mtheme_shortcodes_format($content) {
		$block = join("|",array(
			"fullpageblock",
			"divider",
			"heading",
			"serviceboxes",
			"servicebox",
			"servicebox_item",
			"infoboxes",
			"infobox",
			"infobox_item",
			"portfoliogrid",
			"workscarousel",
			"recentblog",
			"recent_blog_listbox",
			"progressbar",
			"testimonials",
			"testimonial",
			"thumbnails",
			"lightbox",
			"tabs",
			"tab",
			"toggle",
			"faq_toggle",
			"checklist",
			"accordions",
			"accordion",
			"staff",
			"socials",
			"counter",
			"count",
			"alert",
			"button",
			"column1",
			"column2",
			"column3",
			"column32",
			"column4",
			"column43",
			"column5",
			"column52",
			"column53",
			"column6",
			"clients",
			"client",
			"pricing_table",
			"pricing_row",
			"pricing_column",
			"pricing_price",
			"pricing_footer",
			"dropcap",
			"highlight",
			"pullquote",
			"audioplayer",
			"flexislideshow",
			"recent_blog_slideshow",
			"recent_portfolio_slideshow",
			"callout",
			"rev_slider",
			"carousel_item",
			"carousel_group",
			"anchor",
			"woocommerce_carousel_bestselling",
			"worktype_albums",
			"list_bbpress",
			"heroimage_text",
			"heroimage",
			"photocard",
			"lightboxcarousel",
			"displayrichtext",
			"pagecontent",
			"singleimage",
			"blogtimeline",
			"beforeafter"
		 ));

		// opening tag
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

		// closing tag
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)/","[/$2]",$rep);

		return $rep;
	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		if( ! is_admin() )
		{
			//wp_enqueue_style( 'imaginem-shortcodes-CSS', plugin_dir_url( __FILE__ ) . '/css/shortcodes.css' );
			//wp_enqueue_script( array('jquery', 'jquery-ui-accordion', 'jquery-ui-tabs') );
		}
		
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array )
	{
		$plugin_array['mtheme_button'] = mtheme_TINYMCE_URI . '/plugin.js';
		return $plugin_array;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'mtheme_button' );
		return $buttons;
	}
	
	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		// css
		wp_enqueue_style( 'mtheme-popup', mtheme_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		wp_enqueue_style( 'fontAwesome', mtheme_TINYMCE_URI . '/css/fonts/font-awesome/css/font-awesome.css', false, '1.0', 'all' );
		wp_enqueue_style( 'etFonts', mtheme_TINYMCE_URI . '/css/fonts/et-fonts/et-fonts.css', false, '1.0', 'all' );
		wp_enqueue_style( 'featherFonts', mtheme_TINYMCE_URI . '/css/fonts/feather-webfont/feather.css', false, '1.0', 'all' );
		wp_enqueue_style( 'fontelloFonts', mtheme_TINYMCE_URI . '/css/fonts/fontello/css/fontello.css', false, '1.0', 'all' );
		wp_enqueue_style( 'wp-color-picker' );
		// WP_enqueue is already loaded - so no need to load it. Commented function is how it's loaded otherwise.
		//wp_enqueue_media();
		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-livequery', mtheme_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', mtheme_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', mtheme_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'mtheme-popup', mtheme_TINYMCE_URI . '/js/popup.js', false, '1.0', false );
		
		wp_localize_script( 'jquery', 'mtheme_shortcodegen_url', mtheme_TINYMCE_URI );
	}
    
}
$mtheme_shortcodes = new mthemeShortcodes();

?>