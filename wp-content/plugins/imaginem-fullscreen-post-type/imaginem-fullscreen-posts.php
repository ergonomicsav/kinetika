<?php
/*
Plugin Name: iMaginem Fullscreen Post Creater
Plugin URI: http://www.imaginemthemes.com/plugins/mthemeshortcodes
Description: Imaginem Themes Fullscreen Custom Post Types.
Version: 1.2
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

class mtheme_Fullscreen_Posts {

    function __construct() 
    {
		
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_filter("manage_edit-mtheme_fullscreen_columns", array(&$this, 'mtheme_fullscreen_edit_columns'));
		add_action("manage_posts_custom_column",  array(&$this, 'mtheme_fullscreen_custom_columns'));
	}

	/*
	* Portfolio Admin columns
	*/
	function mtheme_fullscreen_custom_columns($column){
	    global $post;
	    $custom = get_post_custom();
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
	        case "featured_image":
	            if ( isset($image_url) ) {
	            echo '<a class="thickbox" href="'.$full_image_url.'"><img src="'.$image_url.'" width="40px" height="40px" alt="featured" /></a>';
	            } else {
	            echo 'Image not found';
	            }
	            break;
	        case "featured_description":
	            if ( isset($custom["featured_description"][0]) ) {echo $custom["featured_description"][0]; }
	            break;
	        case "fullscreen_type":
	            if ( isset($custom["fullscreen_type"][0]) ) { echo $custom["fullscreen_type"][0]; }
	            break;
	    }
	}

	function mtheme_fullscreen_edit_columns($columns){
	    $columns = array(
	        "cb" => "<input type=\"checkbox\" />",
	        "title" => __('Featured Title','mthemelocal'),
	        "fullscreen_type" => __('Fullscreen Type','mthemelocal')
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
		
	    $args = array(
	        'label' => __('Fullscreen Pages','mthemelocal'),
	        'description' => __('Manage your Fullscreen posts','mthemelocal'),
	        'singular_label' => __('Fullscreen','mthemelocal'),
	        'public' => true,
	        'show_ui' => true,
	        'capability_type' => 'post',
	        'hierarchical' => false,
	        'menu_position' => 5,
	        'menu_icon' => plugin_dir_url( __FILE__ ) . 'images/fullscreen.png',
	        'rewrite' => array('slug' => 'fullscreen'),//Use a slug like "work" or "project" that shouldnt be same with your page name
	        'supports' => array('title', 'editor', 'thumbnail','revisions')//Boxes will be shown in the panel
	       );
	 
	    register_post_type( 'mtheme_featured' , $args );
		 
		/*
		* Hooks for the Portfolio and Featured viewables
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
		}
	}
    
}
$mtheme_fullscreen_post_type = new mtheme_Fullscreen_Posts();

?>