<?php
/*
Plugin Name: iMaginem Photo Proofing
Plugin URI: http://www.imaginemthemes.com/plugins/proofing
Description: Imaginem Photo Proofing.
Version: 1.0
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

class mtheme_Proofing_Posts {

    function __construct() 
    {	
    	//require_once ( plugin_dir_path( __FILE__ ) . 'proofing-post-sorter.php');
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));

        add_filter("manage_edit-mtheme_proofing_columns", array(&$this, 'mtheme_proofing_edit_columns'));
		add_filter('manage_posts_custom_column' , array(&$this, 'mtheme_proofing_custom_columns'));
	}

	// Kbase lister
	function mtheme_proofing_edit_columns($columns){
	    $new_columns = array(
	        "mproofing_section" => __('Section','mthemelocal'),
	        "proofing_image" => __('Image','mthemelocal')
	    );
	 
	    return array_merge($columns, $new_columns);
	}
	function mtheme_proofing_custom_columns($columns) {
		global $post;
	    $custom = get_post_custom();
		$image_url=wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
		
		$full_image_id = get_post_thumbnail_id(($post->ID), 'thumbnail'); 
		$full_image_url = wp_get_attachment_image_src($full_image_id,'thumbnail');  
		$full_image_url = $full_image_url[0];

	    switch ($columns)
	    {
	        case "proofing_image":
				if ( iSset($image_url) && $image_url<>"") {
	            echo '<a class="thickbox" href="'.$full_image_url.'"><img src="'.$image_url.'" width="60px" height="60px" alt="featured" /></a>';
				}
	            break;
	        case "mproofing_section":
	            echo get_the_term_list( get_the_id(), 'proofingsection', '', ', ','' );
	            break;
	    } 
	}
	/*
	* kbase Admin columns
	*/
	
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
		//add_action('init', 'mtheme_kbase_register');//Always use a shortname like "mtheme_" not to see any 404 errors
		/*
		* Register kbase Post Manager
		*/


	    $args = array(
            'labels' => array(
                'name' => 'Photo Proofing',
                'menu_name' => 'Photo Proofing',
                'singular_name' => 'Photo Proofing',
                'all_items' => 'All Proofings'
            ),
	        'singular_label' => __('mproofing','mthemelocal'),
	        'public' => true,
	        'publicly_queryable' => true,
	        'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
	        'capability_type' => 'post',
	        'hierarchical' => false,
	        'has_archive' =>true,
			'menu_position' => 6,
	    	'menu_icon' => plugin_dir_url( __FILE__ ) . 'images/kbase.png',
	        'rewrite' => array('slug' => 'proofing'),//Use a slug like "work" or "project" that shouldnt be same with your page name
	        'supports' => array('title', 'author','excerpt','editor', 'comments', 'thumbnail','revisions')//Boxes will be shown in the panel
	       );
	 
	    register_post_type( 'mtheme_proofing' , $args );
		/*
		* Add Taxonomy for kbase 'Type'
		*/
	    register_taxonomy( 'proofingsection', array( 'mtheme_proofing' ),
	        array(
	            'labels' => array(
	                'name' => 'Sections',
	                'menu_name' => 'Sections',
	                'singular_name' => 'Section',
	                'all_items' => 'All Sections'
	            ),
	            'public' => true,
	            'hierarchical' => true,
	            'show_ui' => true,
	            'rewrite' => array( 'slug' => 'mtheme_proofing-section', 'hierarchical' => true, 'with_front' => false ),
	        )
	    );

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
				//wp_enqueue_style( 'mtheme-proofing-sorter-CSS',  plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0', 'all' );
				if ( isSet($_GET["page"]) ) {
					if ( $_GET["page"] == "proofing-post-sorter.php" ) {
						//wp_enqueue_script("post-sorter-JS", plugin_dir_url( __FILE__ ) . "js/post-sorter.js", array( 'jquery' ), "1.0");
					}
				}
			}
		}
	}
    
}
$mtheme_proofing_post_type = new mtheme_Proofing_Posts();
?>