<?php
/*
Plugin Name: iMaginem Demo Importer
Plugin URI: http://imaginem.co
Description: Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.
Author: iMaginem
Author URI: http://imaginem.co
Version: 1.4
Text Domain: imaginem-demo-importer
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );
function theme_demo_import_page(){
?>
<div id="demo-theme-impoter">
    <h1>Kinetika Demos</h1>
    <div class="theme-demo-notice">Import demo data includes sample placeholder graphics for classic demo and images for the others.<br/>To assign/replace images please follow <a target="_blank" href="http://support.imaginemthemes.co/help-guides/">Help Guides</a>. The Help Guides are also included with the download pack from Themeforest. We also have <a target="_blank" href="http://support.imaginemthemes.co/kinetika-video-tutorials/">Video tutorials</a> at the Support Forum.<br/><br/>Please <a target="_blank" href="http://support.imaginemthemes.co/wp-login.php?action=register">Register</a> at our <a target="_blank" href="http://support.imaginemthemes.co/">Support forum</a> if you need to contact support.<br/><br/><strong>Thank you for choosing Kinetika Theme!</strong></div>

    <div class="imagine-demo-notices">
		<div class="updated error importer-notice importer-notice-1" style="display: none;">
			<p><strong>We're sorry but the demo data could not be imported. It is most likely due to low PHP configurations on your server.</strong></p>
		</div>

		<div class="updated importer-notice importer-notice-2" style="display: none;"><p><strong>Demo data successfully imported.</strong></p></div>

		<div class="updated error importer-notice importer-notice-3" style="display: none;">
			<p><strong>We're sorry but the demo data could not be imported. Please contact support to clarify the problem.</strong></p>
		</div>
	</div>
<?php
	$demo_import_data = array();
	$demo_import_data['classic'] = array(
    	"id" => "classic",
    	"name" => "Classic",
    	"demo_url" => "http://kinetika.imaginem.co/",
    	"screenshot" => plugin_dir_url( __FILE__ ) . "images/demos/classic.jpg",
    	"title" => "Classic",
    	"preview" => "http://kinetika.imaginem.co/",
    	"modal_content" => "Memory Limit of 128 MB and max execution time (php time limit) of 180 seconds.\n\n• All required plugins must be active for import process."
	);
	$demo_import_data['onepage'] = array(
    	"id" => "onepage",
    	"name" => "Freelance",
    	"demo_url" => "http://kinetika-freelance.imaginem.co/",
    	"screenshot" => plugin_dir_url( __FILE__ ) . "images/demos/freelancer.jpg",
    	"title" => "One Page",
    	"preview" => "http://kinetika-freelance.imaginem.co/",
    	"modal_content" => "Memory Limit of 128 MB and max execution time (php time limit) of 180 seconds.\n\n• All required plugins must be active for import process."
	);
	$demo_import_data['journalist'] = array(
    	"id" => "journalist",
    	"name" => "Photo Journalist",
    	"demo_url" => "http://kinetika-photojournalist.imaginem.co/",
    	"screenshot" => plugin_dir_url( __FILE__ ) . "images/demos/journalist.jpg",
    	"title" => "Photo Journalist",
    	"preview" => "http://kinetika-photojournalist.imaginem.co/",
    	"modal_content" => "Memory Limit of 128 MB and max execution time (php time limit) of 180 seconds.\n\n• All required plugins must be active for import process."
	);
	$demo_import_data['wedding'] = array(
    	"id" => "wedding",
    	"name" => "Weddings",
    	"demo_url" => "http://kinetika-weddings.imaginem.co",
    	"screenshot" => plugin_dir_url( __FILE__ ) . "images/demos/wedding.jpg",
    	"title" => "Wedding Photographer",
    	"preview" => "http://kinetika-photojournalist.imaginem.co/",
    	"modal_content" => "Memory Limit of 128 MB and max execution time (php time limit) of 180 seconds.\n\n• All required plugins must be active for import process."
	);
?>

	<?php
		foreach($demo_import_data as $demo) {
			echo '
			<!-- Modal -->
			<div class="imaginem-demo-import-modal modal fade" id="'.$demo['id'].'-modal" tabindex="-1" role="dialog" aria-labelledby="'.$demo['id'].'-label">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h1 class="modal-title" id="'.$demo['id'].'-label">'.$demo['name'].' Demo Import</h1>
			      </div>
			      <div class="modal-body">
			      '.$demo['modal_content'].'
			      </div>
			      <div class="modal-footer">
			        
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn button-install-demo btn-primary" data-dismiss="modal" data-demo-id="'.$demo['id'].'" data-dismiss="modal">Import</button>
			      </div>
			    </div>
			  </div>
			</div>';
		}
	?>
	<div class="theme-demo-browser">
		<?php
			foreach($demo_import_data as $demo) {
				echo '<div id="'.$demo['id'].'-demo-tab" class="theme-demo selectable" aria-describedby="'.$demo['id'].'-action '.$demo['id'].'-name">';
						echo '<div class="overlay-demo-importing"><div class="demo-loading-status"><i class="fa fa-refresh fa-pulse fa-3x"></i> Importing in Progress, this may take a while.<br/>Please don\'t close this window.</div></div>';
						echo '<div class="theme-demo-screenshot">';
							echo '<img alt="" src="'.$demo['screenshot'].'">';
						echo '</div>';
					
						echo '<span id="'.$demo['id'].'-action" class="more-demo-details">'.$demo['name'].' Demo</span>';

						echo '<h2 id="'.$demo['id'].'-name" class="theme-demo-name">'.$demo['name'].'</h2>';

						echo '<div class="theme-demo-actions">';
							echo '<a class="button button-primary activate" data-demochoice="'.$demo['id'].'" data-toggle="modal" data-target="#'.$demo['id'].'-modal">Import Demo</a>';
							echo '<a href="'.$demo['demo_url'].'" target="_blank" class="button button-default load-customize hide-if-no-customize">Preview</a>';
						echo '</div>';
				echo '</div>';
			}
		?>
	</div>
</div>
<?php
}
function mtheme_plugins_info_page() {
	include( dirname( __FILE__ ) . '/plugins.php' );
}
function mtheme_system_info_page() {
	echo mtheme_system_info();
}
function mtheme_system_info() {
	global $wpdb;
	ob_start();
	include( dirname( __FILE__ ) . '/systemstatus/output.php' );
	return ob_get_clean();
}
add_action("admin_menu", "add_theme_menu_item");
function add_theme_menu_item()
{
	add_menu_page("Kinetika demos", "Kinetika", "manage_options", "demo-importer", "theme_demo_import_page", plugin_dir_url( __FILE__ ) . 'images/dashboard-icon.png', 60);
	add_submenu_page('demo-importer', 'Kinetika Demos', 'Kinetika Demos', 'manage_options', 'demo-importer','theme_demo_import_page' );
    add_submenu_page('demo-importer','Plugins','Theme Plugins','manage_options','mtheme-plugins','mtheme_plugins_info_page' );
	if ( !defined('ENVATO_HOSTED_SITE') ) {
	    add_submenu_page('demo-importer','System Status','System Status','manage_options','mtheme-system-info','mtheme_system_info_page' );
	}
}
function demo_importer_admin_init()
{
	if( is_admin() ) {
		if ('admin.php' == basename($_SERVER['PHP_SELF']) && $_GET['page']=="demo-importer" || 'admin.php' == basename($_SERVER['PHP_SELF']) && $_GET['page']=="mtheme-plugins") {
			wp_enqueue_script('jquery');
			wp_enqueue_script("theme-demoimporter", plugin_dir_url( __FILE__ ) . "js/admin.js", array( 'jquery' ), "1.0");
			wp_enqueue_style( 'theme-demoimporter',  plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0', 'all' );
			wp_enqueue_style( 'theme-demo-bootstrap',  plugin_dir_url( __FILE__ ) . '/css/bootstrap.min.css', false, '1.0', 'all' );
			wp_enqueue_script("theme-demo-bootstrap", plugin_dir_url( __FILE__ ) . "js/bootstrap.min.js", array( 'jquery' ), "1.0");
			wp_enqueue_style( 'fontAwesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome/css/font-awesome.min.css', false, '1.0', 'all' );
		}
		if ('admin.php' == basename($_SERVER['PHP_SELF']) && $_GET['page']=="mtheme-system-info") {
			wp_enqueue_script('jquery');
			wp_enqueue_script("theme-demoimporter", plugin_dir_url( __FILE__ ) . "js/admin.js", array( 'jquery' ), "1.0");
			wp_enqueue_style( 'theme-demoimporter',  plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0', 'all' );
		}
	}
}
add_action('admin_init', 'demo_importer_admin_init' );

function imaginem_filter_image_sizes( $sizes ) {
	return array();
}
// Hook importer into admin init
add_action( 'wp_ajax_imaginem_import_demo_data', 'imaginem_importer' );
function imaginem_importer() {
	global $wpdb;

	if ( current_user_can( 'manage_options' ) ) {
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true); // we are loading importers

		if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
			$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			include $wp_importer;
		}

		if ( ! class_exists('WP_Import') ) { // if WP importer doesn't exist
			$wp_import = dirname( __FILE__ ) . '/functions/wordpress-importer.php';
			include $wp_import;
		}

		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) { // check for main import class and wp import class
			if( ! isset($_POST['demo_type']) || trim($_POST['demo_type']) == '' ) {
				$demo_type = 'classic';
			} else {
				$demo_type = $_POST['demo_type'];
			}

			switch($demo_type) {
				case 'classic':

					$theme_xml_file = dirname( __FILE__ ) . '/demo/classic_demo/classic-demo-data.xml';
					$homepage_title = "";
					$theme_options_file = plugin_dir_path( __FILE__ ) . 'demo/classic_demo/theme_options.txt';
					$rev_file = plugin_dir_path( __FILE__ ) . 'demo/classic_demo/fullscreenrevslider.zip';
					$widgets_file = plugin_dir_path( __FILE__ ) . 'demo/classic_demo/widgets.json';
				break;
				case 'onepage':

					$theme_xml_file = plugin_dir_path( __FILE__ ) . 'demo/onepage/onepage-demo-data.xml';
					$homepage_title = "OnePage";
					$theme_options_file = plugin_dir_path( __FILE__ ) . 'demo/onepage/theme_options.txt';
					$rev_file = plugin_dir_path( __FILE__ ) . 'demo/onepage/fullscreenrevslider.zip';
					$widgets_file = plugin_dir_path( __FILE__ ) . 'demo/onepage/widgets.json';

				break;
				case 'journalist':

					$theme_xml_file = plugin_dir_path( __FILE__ ) . 'demo/photojournalist/photojournalist-demo-data.xml';
					$homepage_title = "";
					$theme_options_file = plugin_dir_path( __FILE__ ) . 'demo/photojournalist/theme_options.txt';
					$rev_file = '';
					$widgets_file = plugin_dir_path( __FILE__ ) . 'demo/photojournalist/widgets.json';

				break;
				case 'wedding':

					$theme_xml_file = plugin_dir_path( __FILE__ ) . 'demo/wedding/wedding.xml';
					$homepage_title = "Wedding Homepage";
					$theme_options_file = plugin_dir_path( __FILE__ ) . 'demo/wedding/theme_options.txt';
					$rev_file = '';
					$widgets_file = plugin_dir_path( __FILE__ ) . 'demo/wedding/widgets.json';

				break;
				default:

			}

			$importer = new WP_Import();
			/* Import Posts, Pages, Custom Post Types and Menus */
			$theme_xml = $theme_xml_file;
			$importer->fetch_attachments = true;
			ob_start();
			$importer->import($theme_xml);
			ob_end_clean();

			flush_rewrite_rules();

			// Set imported menus to registered theme locations
			$locations = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
			$menus = wp_get_nav_menus(); // registered menus

			if($menus) {
				foreach($menus as $menu) { // assign menus to theme locations
					if( $demo_type == 'classic' ) {
						if( $menu->name == 'mainmenu' ) {
							$locations['main_menu'] = $menu->term_id;
							$locations['mobile_menu'] = $menu->term_id;
						}
					}
					if( $demo_type == 'onepage' ) {
						if( $menu->name == 'onepage' ) {
							$locations['main_menu'] = $menu->term_id;
							$locations['mobile_menu'] = $menu->term_id;
						}
					}
					if( $demo_type == 'journalist' ) {
						if( $menu->name == 'Main Menu' ) {
							$locations['main_menu'] = $menu->term_id;
							$locations['mobile_menu'] = $menu->term_id;
						}
					}
					if( $demo_type == 'wedding' ) {
						if( $menu->name == 'mainmenu' ) {
							$locations['main_menu'] = $menu->term_id;
							$locations['mobile_menu'] = $menu->term_id;
						}
					}
				}
			}

			set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations

			// Set reading options
			if ( $homepage_title <> "" ) {
				$homepage = get_page_by_title( $homepage_title );
				if(isSet( $homepage ) && $homepage->ID) {
					update_option('show_on_front', 'page');
					update_option('page_on_front', $homepage->ID); // Front Page
				}
			} else {
				update_option('show_on_front', 'posts');
			}

			// Import Theme Options
			if ($theme_options_file<>"") {
				$theme_options_txt = $theme_options_file; // theme options data file
				$theme_options_txt = file_get_contents( $theme_options_txt );
				if ( $theme_options_txt<>"" && is_serialized($theme_options_txt) ) {
					$imported_values = unserialize( $theme_options_txt );
					foreach($imported_values as $key => $value) {

						foreach($value as $store_key => $store_value) {

							update_option('mtheme_' . $store_key, $store_value );

							if ( is_array($store_value) && $store_key=="header_section_order" ) {

								foreach($store_value as $home_key => $home_value) {

								}
							}
						}
					}
				}
			}
			// Import Revslider
			if( class_exists('UniteFunctionsRev') && $rev_file <> "" ) { // if revslider is activated
				$slider = new RevSlider();
				$filepath = $rev_file;
				ob_start();
				$slider->importSliderFromPost(true, false, $filepath);
				ob_clean();
				ob_end_clean();
			}

			// Add data to widgets
			if( isSet( $widgets_file ) && $widgets_file ) {
				$widgets_json = $widgets_file; // widgets data file
				//$widgets_json = wp_remote_fopen( $widgets_json );
				$widgets_json = file_get_contents( $widgets_json );
				$widget_data = $widgets_json;
				$data = json_decode( $widget_data );
				$import_widgets = mtheme_importer_import_data( $data );
			}

			update_option( 'imaginem_imported_demo', 'true' );

			echo 'imported';

			exit;
		}
	}
}

function mtheme_importer_available_widgets() {

	global $wp_registered_widget_controls;

	$widget_controls = $wp_registered_widget_controls;

	$available_widgets = array();

	foreach ( $widget_controls as $widget ) {

		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

		}

	}

	return apply_filters( 'mtheme_importer_available_widgets', $available_widgets );

}
/**
 * Import widget JSON data
 *
 * @since 0.4
 * @global array $wp_registered_sidebars
 * @param object $data JSON widget data from .wie file
 * @return array Results array
 */
function mtheme_importer_import_data( $data ) {

	global $wp_registered_sidebars;

	// Have valid data?
	// If no data or could not decode
	if ( empty( $data ) || ! is_object( $data ) ) {
		wp_die(
			__( 'Import data could not be read. Please try a different file.', 'widget-importer-exporter' ),
			'',
			array( 'back_link' => true )
		);
	}

	// Hook before import
	do_action( 'mtheme_importer_before_import' );
	$data = apply_filters( 'mtheme_importer_import_data', $data );

	// Get all available widgets site supports
	$available_widgets = mtheme_importer_available_widgets();

	// Get all existing widget instances
	$widget_instances = array();
	foreach ( $available_widgets as $widget_data ) {
		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	}

	// Begin results
	$results = array();

	// Loop import data's sidebars
	foreach ( $data as $sidebar_id => $widgets ) {

		// Skip inactive widgets
		// (should not be in export file)
		if ( 'wp_inactive_widgets' == $sidebar_id ) {
			continue;
		}

		// Check if sidebar is available on this site
		// Otherwise add widgets to inactive, and say so
		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
			$sidebar_available = true;
			$use_sidebar_id = $sidebar_id;
			$sidebar_message_type = 'success';
			$sidebar_message = '';
		} else {
			$sidebar_available = false;
			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
			$sidebar_message_type = 'error';
			$sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'widget-importer-exporter' );
		}

		// Result for sidebar
		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
		$results[$sidebar_id]['message'] = $sidebar_message;
		$results[$sidebar_id]['widgets'] = array();

		// Loop widgets
		foreach ( $widgets as $widget_instance_id => $widget ) {

			$fail = false;

			// Get id_base (remove -# from end) and instance ID number
			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

			// Does site support this widget?
			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
				$fail = true;
				$widget_message_type = 'error';
				$widget_message = __( 'Site does not support widget', 'widget-importer-exporter' ); // explain why widget not imported
			}

			// Filter to modify settings object before conversion to array and import
			// Leave this filter here for backwards compatibility with manipulating objects (before conversion to array below)
			// Ideally the newer wie_widget_settings_array below will be used instead of this
			$widget = apply_filters( 'mtheme_importer_widget_settings', $widget ); // object

			// Convert multidimensional objects to multidimensional arrays
			// Some plugins like Jetpack Widget Visibility store settings as multidimensional arrays
			// Without this, they are imported as objects and cause fatal error on Widgets page
			// If this creates problems for plugins that do actually intend settings in objects then may need to consider other approach: https://wordpress.org/support/topic/problem-with-array-of-arrays
			// It is probably much more likely that arrays are used than objects, however
			$widget = json_decode( json_encode( $widget ), true );

			// Filter to modify settings array
			// This is preferred over the older wie_widget_settings filter above
			// Do before identical check because changes may make it identical to end result (such as URL replacements)
			$widget = apply_filters( 'mtheme_importer_widget_settings_array', $widget );

			// Does widget with identical settings already exist in same sidebar?
			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

				// Get existing widgets in this sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' );
				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

				// Loop widgets with ID base
				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				foreach ( $single_widget_instances as $check_id => $check_widget ) {

					// Is widget in same sidebar and has identical settings?
					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

						$fail = true;
						$widget_message_type = 'warning';
						$widget_message = __( 'Widget already exists', 'widget-importer-exporter' ); // explain why widget not imported

						break;

					}

				}

			}

			// No failure
			if ( ! $fail ) {

				// Add widget instance
				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				$single_widget_instances[] = $widget; // add it

					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );

				// Assign widget instance to sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

				// After widget import action
				$after_widget_import = array(
					'sidebar'           => $use_sidebar_id,
					'sidebar_old'       => $sidebar_id,
					'widget'            => $widget,
					'widget_type'       => $id_base,
					'widget_id'         => $new_instance_id,
					'widget_id_old'     => $widget_instance_id,
					'widget_id_num'     => $new_instance_id_number,
					'widget_id_num_old' => $instance_id_number
				);
				do_action( 'mtheme_importer_after_widget_import', $after_widget_import );

				// Success message
				if ( $sidebar_available ) {
					$widget_message_type = 'success';
					$widget_message = __( 'Imported', 'widget-importer-exporter' );
				} else {
					$widget_message_type = 'warning';
					$widget_message = __( 'Imported to Inactive', 'widget-importer-exporter' );
				}

			}

			// Result for widget instance
			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = ! empty( $widget['title'] ) ? $widget['title'] : __( 'No Title', 'widget-importer-exporter' ); // show "No Title" if widget instance is untitled
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

		}

	}

	// Hook after import
	do_action( 'mtheme_importer_after_import' );

	// Return results
	return apply_filters( 'mtheme_importer_import_results', $results );

}