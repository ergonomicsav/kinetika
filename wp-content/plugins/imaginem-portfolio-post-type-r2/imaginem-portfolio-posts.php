<?php
/*
Plugin Name: iMaginem Portfolio Creator r2
Plugin URI: http://www.imaginemthemes.com/
Description: Imaginem Themes Portfolio Custom Post Types r2
Version: 1.1
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

class mtheme_Portfolio_Posts {

    function __construct() 
    {
		require_once ( plugin_dir_path( __FILE__ ) . 'portfolio-post-sorter.php');
		
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_filter("manage_edit-mtheme_portfolio_columns", array(&$this, 'mtheme_portfolio_edit_columns'));
		add_action("manage_posts_custom_column",  array(&$this, 'mtheme_portfolio_custom_columns'));
	}

	/*
	* Portfolio Admin columns
	*/
	function mtheme_portfolio_custom_columns($column){
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
	        case "portfolio_image":
				if ( isset($image_url) && $image_url<>"" ) {
	            echo '<a class="thickbox" href="'.$full_image_url.'"><img src="'.$image_url.'" width="60px" height="60px" alt="featured" /></a>';
				}
	            break;
	        case "description":
	            if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) { echo $custom[MTHEME . '_thumbnail_desc'][0]; }
	            break;
	        case "video":
	            if ( isset($custom[MTHEME . '_lightbox_video'][0]) ) { echo $custom[MTHEME . '_lightbox_video'][0]; }
	            break;
	        case "types":
	            echo get_the_term_list($post->ID, 'types', '', ', ','');
	            break;
	    } 
	}

	function mtheme_portfolio_edit_columns($columns){
	    $columns = array(
	        "cb" => "<input type=\"checkbox\" />",
	        "title" => __('Portfolio Title','mthemelocal'),
	        "description" => __('Description','mthemelocal'),
			"video" => __('Video','mthemelocal'),
	        "types" => __('Types','mthemelocal'),
			"portfolio_image" => __('Image','mthemelocal')
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
		//add_action('init', 'mtheme_portfolio_register');//Always use a shortname like "mtheme_" not to see any 404 errors
		/*
		* Register Portfolio Post Manager
		*/
	    $mtheme_portfolio_slug="project";
	    if (function_exists('of_get_option')) {
	    	$mtheme_portfolio_slug = of_get_option('portfolio_permalink_slug');
		}
	    if ( $mtheme_portfolio_slug=="" || !isSet($mtheme_portfolio_slug) ) {
	        $mtheme_portfolio_slug="project";
	    }
	    $mtheme_portfolio_singular_refer = "Portfolio";
	    if (function_exists('of_get_option')) {
	    	$mtheme_portfolio_singular_refer = of_get_option('portfolio_singular_refer');
		}
	    $args = array(
	        'label' => $mtheme_portfolio_singular_refer . __(' Items','mthemelocal'),
	        'singular_label' => __('Portfolio','mthemelocal'),
	        'public' => true,
	        'show_ui' => true,
	        'capability_type' => 'post',
	        'hierarchical' => false,
	        'has_archive' =>true,
			'menu_position' => 6,
	    	'menu_icon' => plugin_dir_url( __FILE__ ) . 'images/portfolio.png',
	        'rewrite' => array('slug' => $mtheme_portfolio_slug),//Use a slug like "work" or "project" that shouldnt be same with your page name
	        'supports' => array('title', 'excerpt','editor', 'thumbnail','comments','revisions')//Boxes will be shown in the panel
	       );
	 
	    register_post_type( 'mtheme_portfolio' , $args );
		/*
		* Add Taxonomy for Portfolio 'Type'
		*/
		register_taxonomy("types", array("mtheme_portfolio"), array("hierarchical" => true, "label" => "Work Type", "singular_label" => "Types", "rewrite" => true));
		 
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
			// Load only if in a Post or Page Manager	
			if ('edit.php' == basename($_SERVER['PHP_SELF'])) {
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
				wp_enqueue_style( 'mtheme-portfolio-sorter-CSS',  plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0', 'all' );
				if ( isSet($_GET["page"]) ) {
					if ( $_GET["page"] == "portfolio-post-sorter.php" ) {
						wp_enqueue_script("post-sorter-JS", plugin_dir_url( __FILE__ ) . "js/post-sorter.js", array( 'jquery' ), "1.0");
					}
				}
			}
		}
	}
    
}
$mtheme_portfolio_post_type = new mtheme_Portfolio_Posts();


class mtheme_Worktype_add_image {

	function __construct() {
		add_action('admin_head', array(&$this,'mtheme_admin_head') );
		add_action('edit_term', array(&$this,'mtheme_save_tax_pic') );
		add_action('create_term', array(&$this,'mtheme_save_tax_pic') );
		add_filter("manage_edit-types_columns", array(&$this,'mtheme_worktype_columns') );
		add_action("manage_types_custom_column", array(&$this,'mtheme_manage_workype_columns'),10,3 );
	}

	// Add to admin_init function
	 
	function mtheme_worktype_columns($columns) {
	    $columns['worktype_image'] = 'Image';
	    return $columns;
	}

	// Add to admin_init function
	 
	function mtheme_manage_workype_columns($value,$columns,$term_id) {
		$mtheme_worktype_image_id = get_option('mtheme_worktype_image_id' . $term_id);
	    switch ($columns) {
	        case 'worktype_image':
	        		if ($mtheme_worktype_image_id) {
	        			$mtheme_worktype_image_url = wp_get_attachment_image_src( $mtheme_worktype_image_id, 'thumbnail', false );
	            		$value = '<img src="'.$mtheme_worktype_image_url[0].'" width="100px" height="auto" />';
	            	}
	            break;
	 
	        default:
	            break;
	    }
	    return $value;
	}

	function mtheme_admin_head() {
	    $taxonomies = get_taxonomies();
	    $taxonomies = array('types'); // uncomment and specify particular taxonomies you want to add image feature.
	    if (is_array($taxonomies)) {
	        foreach ($taxonomies as $z_taxonomy) {
	            add_action($z_taxonomy . '_add_form_fields', array(&$this,'mtheme_tax_field') );
	            add_action($z_taxonomy . '_edit_form_fields', array(&$this,'mtheme_tax_field') );
	        }
	    }
	}

	// add image field in add form
	function mtheme_tax_field($taxonomy) {
	    wp_enqueue_style('thickbox');
	    wp_enqueue_script('thickbox');
		wp_enqueue_media();

	    if(empty($taxonomy)) {
	        echo '<div class="form-field">
	                <label for="mtheme_worktype_input">Image</label>
	                <input size="40" type="text" name="mtheme_worktype_input" id="mtheme_worktype_input" value="" />
	                <input type="text" name="mtheme_worktype_image_id" id="mtheme_worktype_image_id" value="" />
	            </div>';
	    }
	    else{
	    	
	    	$mtheme_worktype_input_url='';
	    	$mtheme_worktype_image_id='';

	        if ( isSet($taxonomy->term_id) ) {
	        	//$mtheme_worktype_input_url = get_option('mtheme_worktype_input' . $taxonomy->term_id);
	        	$mtheme_worktype_image_id = get_option('mtheme_worktype_image_id' . $taxonomy->term_id);
	        }
	        
	        echo '<tr class="form-field">
			<th scope="row" valign="top"><label for="mtheme_worktype_input">Image</label></th>
			<td>
			<input type="hidden" name="mtheme_worktype_image_id" id="mtheme_worktype_image_id" value="' . $mtheme_worktype_image_id . '" />
			<a class="button" id="mtheme_upload_work_image">Set Worktype image</a>
			<div class="inside" id="featured_worktype_image_wrap">';
	        if(!empty($mtheme_worktype_image_id)) {
	            $mtheme_worktype_image_url = wp_get_attachment_image_src( $mtheme_worktype_image_id, 'thumbnail', false );
	            echo '<img id="featured_worktype_image" src="'.$mtheme_worktype_image_url[0].'" style="max-width:200px;border: 1px solid #ccc;padding: 5px;box-shadow: 5px 5px 10px #ccc;margin-top: 10px;" >';
	            echo '<a style="display:block;" id="remove_worktype_image" href="#">Remove Worktype Image</a>';
	        }
	        echo '</div>';
	        echo '</td></tr><br/>';
	    }
	?>
	<script>
	jQuery(document).ready(function($){
		// Get input target field
		var targetfield="mtheme_worktype_input";

		jQuery("#mtheme_upload_work_image").click( function( event ) {
			var jQueryel = jQuery(this);
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( typeof(custom_file_frame)!=="undefined" ) {
				custom_file_frame.open();
				return;
			}

			// Create the media frame.
			custom_file_frame = wp.media.frames.customHeader = wp.media({
				// Set the title of the modal.
				title: jQueryel.data("choose"),

				// Tell the modal to show only images. Ignore if want ALL
				library: {
					type: 'image'
				},
				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: jQueryel.data("update")
				}
			});

			custom_file_frame.on( "select", function() {
				// Grab the selected attachment.
				var attachment = custom_file_frame.state().get("selection").first();
				var active_image = jQuery('#featured_worktype_image');

				if (active_image.length > 0 ) {
					$(active_image).attr('src', attachment.attributes.sizes.thumbnail.url);
				} else {
	  				var worktypeImg = jQuery('<img/>');
	  					worktypeImg.attr('id','featured_worktype_image')
						worktypeImg.attr('src', attachment.attributes.sizes.thumbnail.url);
						worktypeImg.attr('style',"max-width:200px;border: 1px solid #ccc;padding: 5px;box-shadow: 5px 5px 10px #ccc;margin-top: 10px;")
						worktypeImg.appendTo('#featured_worktype_image_wrap');

					jQuery( '<a style="display:block;" id="remove_worktype_image" href="#">Remove Worktype Image</a>' ).appendTo( "#featured_worktype_image_wrap" );
				}
				
				jQuery("#mtheme_worktype_image_id").val(attachment.id);
			});

			custom_file_frame.open();
		});

		jQuery("#featured_worktype_image_wrap").on("click", "#remove_worktype_image", function(){
			jQuery('#remove_worktype_image,#featured_worktype_image').remove();
			jQuery('#mtheme_worktype_image_id').val("");
			return false;
		});
	});
	</script>
	<?php
	}

	// save our taxonomy image while edit or save term
	function mtheme_save_tax_pic($term_id) {
	    if (isset($_POST['mtheme_worktype_image_id'])) {
	    	update_option('mtheme_worktype_image_id' . $term_id, $_POST['mtheme_worktype_image_id']);
	    }
	}

	// output taxonomy image url for the given term_id (NULL by default)
	function mtheme_worktype_input_url($term_id = NULL) {
	    if ($term_id) {
	        $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	        return get_option('mtheme_worktype_input' . $current_term->term_id);
	    }
	}

}
$mtheme_Worktype_add_image = new mtheme_Worktype_add_image();
?>