<?php
/*
Plugin Name: iMaginem PhotoStories
Plugin URI: http://www.imaginemthemes.com/
Description: Imaginem Themes Photostory Custom Post Type
Version: 1.0
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

class mtheme_Photostory_Posts {

    function __construct() 
    {
		require_once ( plugin_dir_path( __FILE__ ) . 'photostory-post-sorter.php');
		
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_filter("manage_edit-mtheme_photostory_columns", array(&$this, 'mtheme_photostory_edit_columns'));
		//add_action("manage_posts_custom_column",  array(&$this, 'mtheme_photostory_custom_columns'));
		add_action("manage_mtheme_photostory_posts_custom_column",  array(&$this, 'mtheme_photostory_custom_columns'));
	}

	/*
	* Photostory Admin columns
	*/
	function mtheme_photostory_custom_columns($column){
		global $post;
		$image_url=wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
		
		$full_image_id = get_post_thumbnail_id(($post->ID), 'thumbnail'); 
		$full_image_url = wp_get_attachment_image_src($full_image_id,'thumbnail');  
		$full_image_url = $full_image_url[0];

		if (!defined('MTHEME')) {
			$mtheme_shortname = "mtheme_p2";
			define('MTHEME', $mtheme_shortname);
		}
	    switch ($column)
	    {
	        case "photostory_image":
				if ( isset($image_url) && $image_url<>"") {
	            echo '<a class="thickbox" href="'.esc_url($full_image_url).'"><img src="'.esc_url($image_url).'" width="60px" height="60px" alt="featured" /></a>';
				}
	            break;
	        case "photostories":
	            echo get_the_term_list($post->ID, 'photostories', '', ', ','');
	            break;
	    } 
	}

	function mtheme_photostory_edit_columns($columns){

	    $columns = array(
	        "cb" => "<input type=\"checkbox\" />",
	        "title" => __('Photostory Title','mthemelocal'),
	        "photostories" => __('Categories','mthemelocal'),
			"photostory_image" => __('Image','mthemelocal')
	    );
	 	
	    return $columns;
	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		/*
		* Register Featured Post Manager
		*/
		//add_action('init', 'mtheme_featured_register');
		//add_action('init', 'mtheme_photostory_register');//Always use a shortname like "mtheme_" not to see any 404 errors
		/*
		* Register Photostory Post Manager
		*/
	    $mtheme_photostory_slug="photostory";
	    if (function_exists('of_get_option')) {
	    	$mtheme_photostory_slug = of_get_option('photostory_permalink_slug');
		}
	    if ( $mtheme_photostory_slug=="" || !isSet($mtheme_photostory_slug) ) {
	        $mtheme_photostory_slug="photostory";
	    }
	    $mtheme_photostory_singular_refer = "Photostory";
	    if (function_exists('of_get_option')) {
	    	$mtheme_photostory_singular_refer = of_get_option('photostory_singular_refer');
		}
		if ( $mtheme_photostory_singular_refer == '' ) {
			$mtheme_photostory_singular_refer= 'Photostory';
		}
	    $args = array(
	        'label' => __('Photo Stories','mthemelocal'),
	        'singular_label' => __('Photo Story','mthemelocal'),
	        'public' => true,
	        'show_ui' => true,
	        'capability_type' => 'post',
	        'hierarchical' => true,
	        'has_archive' =>true,
			'menu_position' => 6,
	    	'menu_icon' => plugin_dir_url( __FILE__ ) . 'images/portfolio.png',
	        'rewrite' => array('slug' => $mtheme_photostory_slug),//Use a slug like "work" or "photostory" that shouldnt be same with your page name
	        'supports' => array('title','thumbnail','revisions')//Boxes will be shown in the panel
	       );
	 
	    register_post_type( 'mtheme_photostory' , $args );
		/*
		* Add Taxonomy for Photostory 'Type'
		*/
		register_taxonomy("photostories", array("mtheme_photostory"), array("hierarchical" => true, "label" => "Categories", "singular_label" => "Category", "rewrite" => true));
		 
		/*
		* Hooks for the Photostory and Featured viewables
		*/
	}
	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		if( is_admin() ) {
			// Load only if in a Post or Page Manager	
			if ('edit.php' == basename($_SERVER['PHP_SELF'])) {
				//wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
				wp_enqueue_style( 'mtheme-photostory-sorter-CSS',  plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0', 'all' );
				if ( isSet($_GET["page"]) ) {
					if ( $_GET["page"] == "photostory-post-sorter.php" ) {
						wp_enqueue_script("post-sorter-JS", plugin_dir_url( __FILE__ ) . "js/post-sorter.js", array( 'jquery' ), "1.0");
					}
				}
			}
		}
	}
    
}
$mtheme_photostory_post_type = new mtheme_Photostory_Posts();
?>