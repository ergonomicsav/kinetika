<?php
/**
 * AQ_Page_Builder class
 *
 * The core class that generates the functionalities for the
 * Aqua Page Builder. Almost nothing inside in the class should
 * be overridden by theme authors
 *
 * @since forever
 **/

if(!class_exists('AQ_Page_Builder')) {
	class AQ_Page_Builder {

		public $url;
		public $config = array();
		private $admin_notices;

		/**
		 * Stores public queryable vars
		 */
		function __construct( $config = array()) {
			$this->url = mtheme_PLUGIN_URI;
			add_action('admin_print_footer_scripts', array(&$this, 'js_wp_editor'));
			$defaults['menu_title'] = __('Page Builder', 'mthemelocal');
			$defaults['page_title'] = __('Page Builder', 'mthemelocal');
			$defaults['page_slug'] = __('aq-page-builder', 'mthemelocal');
			$defaults['debug'] = false;

			$this->args = wp_parse_args($config, $defaults);

			$this->args['page_url'] = esc_url(add_query_arg(
				array('page' => $this->args['page_slug']),
				admin_url( 'themes.php' )
			));

		}

		/**
		 * Initialise Page Builder page and its settings
		 *
		 * @since 1.0.0
		 */
		function init() {

			add_action('add_meta_boxes', array(&$this, 'builder_page'));
			add_action('init', array(&$this, 'register_template_post_type'));
			add_action('init', array(&$this, 'add_shortcode'));
			add_action('init', array(&$this, 'create_template'));
			add_action('template_redirect', array(&$this, 'preview_template'));
			add_filter('contextual_help', array(&$this, 'contextual_help'));
			if(!is_admin()) add_filter('init', array(&$this, 'view_enqueue'));
			add_action('admin_bar_menu', array(&$this, 'add_admin_bar'), 1000);

			add_action('admin_footer', array(&$this, 'add_media_display') );

		}

		/**
		 * Create Settings Page
		 *
		 * @since 1.0.0
		 */
		function builder_page() {
			add_action( 'admin_enqueue_scripts', array(&$this, 'admin_enqueue') );
			add_meta_box( 'aq-page-builder', __('iMaginem Page Builder','mthemelocal'), array($this, 'pagebuilder_metabox'), 'page', 'normal', 'high', NULL );
			add_meta_box( 'aq-page-builder', __('iMaginem Page Builder','mthemelocal'), array($this, 'pagebuilder_metabox'), 'post', 'normal', 'high', NULL );
			add_meta_box("aq-page-builder", __("iMaginem Page Builder",'mthemelocal'), array($this, 'pagebuilder_metabox'), "mtheme_portfolio", "normal", 'high', NULL );
			add_meta_box("aq-page-builder", __("iMaginem Page Builder",'mthemelocal'), array($this, 'pagebuilder_metabox'), "mtheme_events", "normal", 'high', NULL );

		}

		function pagebuilder_metabox( $post ) {
			$post_type = ! empty($post) ? $post->post_type : get_current_screen()->post_type;
			if ( 'page' !== $post_type && 'post' !== $post_type && 'mtheme_portfolio' !== $post_type && 'mtheme_events' !== $post_type )
				return;

			$box = array(
				'id'		 => $this->args['page_slug'],
				'title'		 => $this->args['page_title'],
				'callback'	 => array(&$this, 'builder_settings_show'),
			);
			$page = get_current_screen()->id;
			call_user_func( $box['callback'], $post, $box );
		}
		/**
		 * Add shortcut to Admin Bar menu
		 *
		 * @since 1.0.4
		 */
		function add_admin_bar(){
			global $wp_admin_bar;

		}

		/**
		 * Register and enqueueu styles/scripts
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function admin_enqueue( $post ) {
			
			$post_type = ! empty($hook) ? $post->post_type : get_current_screen()->post_type;
			if ( 'page' !== $post_type && 'post' !== $post_type && 'mtheme_portfolio' !== $post_type && 'mtheme_events' !== $post_type )
				return;

			$mthemebuilder_vars = array(
				'url' => get_home_url(),
				'includes_url' => includes_url()
			);

			// Register 'em
			wp_register_style( 'aqpb-css', $this->url.'assets/css/aqpb.css', array(), time(), 'all');
			wp_register_style( 'fontAwesome', $this->url. 'assets/fonts/font-awesome/css/font-awesome.min.css', array( 'aqpb-css' ), false, 'screen' );
			wp_register_style( 'etFonts', $this->url. 'assets/fonts/et-fonts/et-fonts.css', array( 'aqpb-css' ), false, 'screen' );
			wp_register_style( 'etFonts', $this->url. 'assets/fonts/line-10/line-10.css', array( 'aqpb-css' ), false, 'screen' );
			wp_register_style( 'featherFonts', $this->url. 'assets/fonts/feather-webfont/feather.css', array( 'aqpb-css' ), false, 'screen' );
			wp_register_style( 'fontelloFonts', $this->url. 'assets/fonts/fontello/css/fontello.css', array( 'aqpb-css' ), false, 'screen' );
			wp_register_style( 'simepleLineFont', $this->url. 'assets/fonts/simple-line-icons/simple-line-icons.css', array( 'aqpb-css' ), false, 'screen' );
			wp_register_style( 'bootstrap-3-modal', $this->url . 'assets/css/bootstrap.3.modal.css' );
			wp_register_style( 'bootstrap-3-tooltip', $this->url . 'assets/css/bootstrap-tooltip.css' );
			wp_register_style( 'bootstrap-3-popover', $this->url . 'assets/css/bootstrap-popover.css' );
			wp_register_script( 'bootstrap-3-modal', $this->url . 'assets/js/bootstrap.3.modal.js', array( 'jquery' ) );
			wp_register_script( 'builder-wp_editor', $this->url . 'assets/js/js-wp-editor.js', array( 'jquery' ) );
			wp_localize_script( 'builder-wp_editor', 'mthemebuilder_vars', $mthemebuilder_vars );
			wp_register_script( 'iconpicker', $this->url . 'assets/js/iconpicker/icon-picker.js', array( 'jquery' ) );
			wp_register_script('bootstrap-js-tooltip', $this->url . 'assets/js/tooltip.js', array('jquery'), time(), true);
			wp_register_script( 'bootstrap-3-popover', $this->url . 'assets/js/bootstrap.3.popover.js', array( 'jquery','bootstrap-js-tooltip' ) );

			wp_register_script( 'aqpb-js', $this->url . 'assets/js/aqpb.js', array( 'jquery', 'bootstrap-3-modal', 'bootstrap-3-popover' , 'underscore' ), time(), true );
			wp_localize_script('aqpb-js', 'aqjs_script_vars', array(
					'saving' => __('Saving...', 'mthemelocal'),
					'retrieving' => __('Retrieving...', 'mthemelocal'),
					'newtemplate' => __('New Template', 'mthemelocal')
				)
			);
			// Enqueue 'em
			wp_enqueue_style('aqpb-css');
			wp_enqueue_style('fontAwesome');
			wp_enqueue_style('etFonts');
			wp_enqueue_style('featherFonts');
			wp_enqueue_style('fontelloFonts');
			wp_enqueue_style('simepleLineFont');
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style('bootstrap-3-modal');
			wp_enqueue_style('bootstrap-3-tooltip');
			wp_enqueue_style('bootstrap-3-popover');
			wp_enqueue_script('jquery');
			wp_enqueue_script('builder-wp_editor');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-resizable');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('iconpicker');
			wp_enqueue_script('bootstrap-js-tooltip');
			wp_enqueue_script('bootstrap-3-popover');
			wp_enqueue_script('aqpb-js');


			// Get the max input var limit
	        $php_ini = array();
	        $php_ini[] = ini_get('max_input_vars');
	        $php_ini[] = ini_get('suhosin.post.max_vars');
	        $php_ini[] = ini_get('suhosin.request.max_vars');
	        // Strip out the blanks - ini options not set.
	        $php_ini = array_filter($php_ini, 'is_numeric');

	        // Find the smallest of them all.
	        if ( ! empty($php_ini)) {
	            $lowest_limit = min($php_ini);
	        } else {
	            $lowest_limit = 999;
	        }
	        if ( !isSet($lowest_limit) ) {
	        	$lowest_limit = 999;
	        }
	        if ( $lowest_limit<999) {
	        	$lowest_limit = 999;
	        }
	        $max_input_vars = $lowest_limit;

			wp_localize_script('aqpb-js', 'global_mtheme' , array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'template_dir' => mtheme_PLUGIN_URI,
				'max_input_vars' => $max_input_vars,
				'activate_revisions' => em_get_option('activate_revisions_history'),
			));

			wp_localize_script('em_undo', 'global_mtheme' , array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'template_dir' => mtheme_PLUGIN_URI
			));
	        wp_enqueue_media();

			// Hook to register custom style/scripts
			do_action('mtheme_aq-page-builder-admin-enqueue');

		}


		function js_wp_editor( $settings = array() ) {
				if ( ! class_exists( '_WP_Editors' ) ) {
					require( ABSPATH . WPINC . '/class-wp-editor.php' );
				}

				$set = _WP_Editors::parse_settings( 'mtheme_mce_id', array() );

				if ( !current_user_can( 'upload_files' ) ) {
					$set['media_buttons'] = false;
				}

				if ( $set['media_buttons'] ) {
					wp_enqueue_script( 'thickbox' );
					wp_enqueue_style( 'thickbox' );
					wp_enqueue_script('media-upload');

					$post = get_post();
					if ( ! $post && ! empty( $GLOBALS['post_ID'] ) )
						$post = $GLOBALS['post_ID'];

					wp_enqueue_media( array(
						'post' => $post
					) );
				}

				_WP_Editors::editor_settings( 'mtheme_mce_id', $set );
		}

		/**
		 * Register and enqueueu styles/scripts on front-end
		 *
		 * @since 1.0.0
		 * @todo min versions
		 */
		function view_enqueue() {

			// front-end css and
			//hook to register custom styles/scripts
			do_action('mtheme_aq-page-builder-view-enqueue');

		}

		/**
		 * Register template post type
		 *
		 * @uses register_post_type
		 * @since 1.0.0
		 */
		function register_template_post_type() {

			if(!post_type_exists('template')) {

				$template_args = array(
					'labels' => array(
						'name' => 'Templates',
					),
					'public' => false,
					'show_ui' => false,
					'capability_type' => 'page',
					'hierarchical' => false,
					'rewrite' => false,
					'supports' => array( 'title', 'editor' ),
					'query_var' => false,
					'can_export' => false,
					'show_in_nav_menus' => false
				);

				if($this->args['debug'] == true && WP_DEBUG == true) {
					$template_args['public'] = true;
					$template_args['show_ui'] = true;
				}

				register_post_type( 'template', $template_args);

			} else {
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Imaginem Page Builder notice: </strong>'. __('The \"template\" post type already exists, possibly added by the theme or other plugins. Please contact us with this issue.', 'mthemelocal') .'</p></div>';"));
			}

		}

		/**
		 * Checks if template with given id exists
		 *
		 * @since 1.0.0
		 */
		function is_template($template_id) {

			$template = get_post($template_id);

			if($template) {
				if($template->post_type != 'template' || $template->post_status != 'publish') return false;
			} else {
				return false;
			}

			return true;

		}

		/**
		 * Retrieve all blocks from on Save
		 *
		 * @return	array - $blocks
		 * @since	1.0.0
		 */
		function get_blocks($template_id) {
			//verify template
			//filter post meta to get only blocks data
			$blocks = array();
			// print_a($blocks);
			// die;
			if(isset($_POST['aq_blocks']) && !empty($_POST['aq_blocks'])) {
			$all = $_POST['aq_blocks'];//get_post_custom($template_id);
			// print_a($all);
			// die;
			foreach($all as $key => $block) {
				if(substr($key, 0, 9) == 'aq_block_' && substr($key, 8, 14) != '___i__') {
					$block_instance = $all[$key];//get_post_meta($template_id, $key);
					if(is_array($block_instance)) $blocks[$key] = $block_instance;
				}
			}
			
			//sort by order
			$sort = array();
			foreach($blocks as $block) {
				$sort[] = $block['order'];
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);
			}

			return $blocks;

		}

		/**
		 * Display template blocks
		 *
		 * @since	1.0.0
		 */
		function display_template_blocks( $blocks ) {
			$saved_blocks = $blocks;
			//verify template
			$blocks = is_array($blocks) ? $blocks : array();
			$blocks = unserialize($blocks[0]);

			//return early if no blocks
			if(empty($blocks)) {
				echo '<p class="empty-template">';
				echo __('Drag and Drop blocks area.', 'mthemelocal');
				echo '</p>';
				return;

			} else {
				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
					extract($instance);
						if(isset($aq_registered_blocks[$id_base])) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];
							//insert template_id into $instance
							$instance['template_id'] = $template_id;

							//display the block
							if($parent == 0) {
								$block->form_callback($instance,$saved_blocks);
							}
						}
					}
				}
			}
		}

		/**
		 * Retrieve all blocks for UI
		 *
		 * @return	array - $blocks
		 * @since	1.0.0
		 */
		function retrieve_blocks($post_id,$saved_blocks = array()) {


			// Get serialized data
			// $builder_key = 'aq_datakey_' . $post_id;
			// $template_serialized_data = get_post_meta($post_id, $builder_key);

			// $template_serialized_data=$template_serialized_data[0];

			// parse_str($template_serialized_data, $params);

			// $template_transient_data=$params;


			$new_build_data = get_post_meta($post_id);
			$multibuilder_key = 'aq_multidatakey_' . $post_id;
			$template_serialized_multidata = get_post_meta($post_id, $multibuilder_key);

			$final_dataset=array();
			if (isSet($template_serialized_multidata) && !empty($template_serialized_multidata)) {
				foreach ($template_serialized_multidata[0] as $key => $data_set ) {
					wp_parse_str($data_set, $multiparams);
					if (isSet($multiparams['aq_blocks'])) {
						foreach ($multiparams['aq_blocks'] as $mkey => $mdata_set ) {
							if (isSet($mdata_set)) {
								$final_dataset[$mkey] = $mdata_set;
							}
						}
					}
				}
			}

			$template_transient_data = $final_dataset;


			$jQserialized = $template_transient_data;

			// echo '<pre>';
			// print_r($jQserialized);
			// echo '</pre>';

			$blocks=array();
			if (isSet($jQserialized) ) {
				foreach($jQserialized as $jqkey => $jqblock) {
					$serialized_str = serialize($jqblock);
					//echo '------' . $jqkey . '-------';
					if (!empty($serialized_str) && isSet($serialized_str)) {
						$blocks[$jqkey][0]=$serialized_str;
					}
				}
			}
			// echo '<pre>*************';
			// print_r($blocks);
			// echo '</pre>';

			//sort by order
			$sort = array();
			$block_mod_array = array();

			foreach($blocks as $key => $block) {
				if(isset($block[0])) {
					$saving_template = false;
					$temp = unserialize($block[0]);
				} else {
					$saving_template = true;
					if(is_array($block)) {
						$temp = $block;
						$blocks[$key] = array(serialize($block));
					} else {
						$temp = unserialize($block);
					}
				}
				if(isset($temp['order']))
					$sort[] = $temp['order'];
				else
					$sort[] = '';
			}
			array_multisort($sort, SORT_NUMERIC, $blocks);

			// echo '<pre>';
			// print_r($blocks);
			// echo '</pre>';
			return $blocks;
		}
		/**
		 * Display blocks archive
		 *
		 * @since	1.0.0
		 */
		function blocks_archive() {

			global $aq_registered_blocks;
			$tabs = $this->group_by_tab( $aq_registered_blocks );
			echo "<ul>";
			foreach ( array_keys( $tabs ) as $tab_nav ) {
				echo "<li><a href='#aq-builder-{$tab_nav}-tab'>" . ucwords( str_replace( array('-', '_'), ' ', $tab_nav ) ) . "</a></li>";
			}
			echo "<li class='mtheme-builder-search'><input type='text' placeholder='".__('Live Search','mthemelocal') ."' id='mtheme-pb-live-search' /><i class='fa fa-search'></i></li>";
			echo "</ul>";
			foreach( $tabs as $tab => $blocks ) {
				echo "<ul id='aq-builder-{$tab}-tab'>";
				foreach ( $blocks as $block ) {
					$block->form_callback();
				}
				echo '</ul>';
			}
//			foreach($aq_registered_blocks as $block) {
//				$block->form_callback();
//			}

		}

		function group_by_tab( $blocks ) {
			$grouped = array('others' => '');
			foreach ( $blocks as $block ) {
				$tab = isset( $block->block_options['tab'] ) ? $block->block_options['tab'] : 'others';
				if ( ! isset( $grouped[ $tab ] ) ) {
					$grouped[ $tab ] = array();
				}
				$grouped[ $tab ][] = $block;
			}
                        if ( empty($grouped['others'])) {
                            unset($grouped['others']);
                        }
			if ( ! empty( $grouped['Layout'] ) ) {
				$layout = array( 'Layout' => $grouped['Layout'] );
				unset( $grouped['Layout'] );
				$grouped = $layout + $grouped;
			}
			uksort( $grouped, 'strnatcmp' );
                        foreach($grouped as $tab => $blocks ) {
                            usort($grouped[$tab], array($this, 'sort_by_name'));
                        }
			return $grouped;
		}

                function sort_by_name($a, $b) {
                    return strnatcmp($a->name, $b->name);
                }

		/**
		 * Display template blocks
		 *
		 * @since	1.0.0
		 */
		function display_blocks( $template_id ) {
			//verify template
			$blocks = $this->retrieve_blocks($template_id);
			$blocks = is_array($blocks) ? $blocks : array();
			$saved_blocks = $blocks;
			foreach ($blocks as $keys => $values) {
				foreach ($values as $key => $value) {
					$blocks[$keys] = unserialize($value);
				}
			}

			// echo '<pre>';
			// print_r($blocks);
			// echo '</pre>';
			//return early if no blocks
			if(empty($blocks)) {
				echo '<p class="empty-template">';
				echo __('Drag and Drop blocks area.', 'mthemelocal');
				echo '</p>';
				return;

			} else {
				//outputs the blocks
				foreach($blocks as $key => $instance) {
					global $aq_registered_blocks;
					if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
					extract($instance);
					if(isset($id_base) && isset($aq_registered_blocks[$id_base])) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];
						//insert template_id into $instance
						$instance['template_id'] = $template_id;

						//display the block
						if($parent == 0) {
			// echo '<pre>';
			// print_r($blocks);
			// echo '</pre>';
							$block->form_callback($instance,$saved_blocks);
						}
					}
					}
				}
			}

		}

		/**
		 * Get all saved templates
		 *
		 * @since	1.0.0
		 */
		function get_templates() {

			$args = array (
				'nopaging' => true,
				'post_type' => 'template',
				'status' => 'publish',
				'orderby' => 'title',
				'order' => 'ASC',
			);

			$templates = get_posts($args);

			return $templates;

		}
		/**
		 * Creates a new template
		 *
		 * @since	1.0.0
		 */
		function create_template() {

			//create new template only if title don't yet exist
			if(!get_page_by_title( 'pageTemplate', 'OBJECT', 'template' )) {
				//set up template name
				$template = array(
					'post_title' => wp_strip_all_tags('pageTemplate'),
					'post_type' => 'template',
					'post_status' => 'publish',
				);

				//create the template
				$template_id = wp_insert_post($template);

			} else {
				return new WP_Error('duplicate_template', 'Template names must be unique, try a different name');
			}

			//return the new id of the template
			return $template_id;

		}

		/**
		 * Function to update templates
		 *
		 * @since	1.0.0
		**/
		function update_template($template_id, $blocks, $title) {

			//first let's check if template id is valid
			if(!$this->is_template($template_id)) wp_die('Error : Template id is not valid');

			//wp security layer
			check_admin_referer( 'update-template', 'update-template-nonce' );

			//update the title
			$template = array('ID' => $template_id, 'post_title'=> $title);
			wp_update_post( $template );

			//now let's save our blocks & prepare haystack
			$blocks = is_array($blocks) ? $blocks : array();
			$haystack = array();
			$template_transient_data = array();
			$i = 1;

			foreach ($blocks as $new_instance) {
				global $aq_registered_blocks;global $post;

				$old_key = isset($new_instance['number']) ? 'aq_block_' . $new_instance['number'] : 'aq_block_0';
				$new_key = isset($new_instance['number']) ? 'aq_block_' . $i : 'aq_block_0';

				$old_instance = get_post_meta($template_id, $old_key, true);

				extract($new_instance);

				if(class_exists($id_base)) {
					//get the block object
					$block = $aq_registered_blocks[$id_base];

					//insert template_id into $instance
					$new_instance['template_id'] = $template_id;

					//sanitize instance with AQ_Block::update()
					$new_instance = $block->update($new_instance, $old_instance);
				}

				//update block
				update_post_meta($template_id, $new_key, $new_instance);

				//store instance into $template_transient_data
				$template_transient_data[$new_key] = $new_instance;

				//prepare haystack
				$haystack[] = $new_key;

				$i++;
			}

			//update transient
			$template_transient = 'aq_template_' . $template_id;
			add_post_meta( $post->ID, $template_transient, $template_transient_data );
			//use haystack to check for deleted blocks
			$curr_blocks = $this->get_blocks($post->ID);
			$curr_blocks = is_array($curr_blocks) ? $curr_blocks : array();
			foreach($curr_blocks as $key => $block){
				if(!in_array($key, $haystack))
					delete_post_meta($template_id, $key);
			}

		}

		/**
		 * Delete page template
		 *
		 * @since	1.0.0
		**/
		function delete_template($template_id) {

			//first let's check if template id is valid
			if(!$this->is_template($template_id)) return false;

			//wp security layer
			check_admin_referer( 'delete-template', '_wpnonce' );

			//delete template, hard!
			wp_delete_post( $template_id, true );

			//delete template transient
			$template_transient = 'aq_template_' . $template_id;
			delete_transient( $template_transient );

		}

		/**
		 * Preview template
		 *
		 * Theme authors should attempt to make the preview
		 * layout to be consistent with their themes by using
		 * the filter provided in the function
		 *
		 * @since	1.0.0
		 */
		function preview_template() {

			global $wp_query, $aq_page_builder;
			$post_type = $wp_query->query_vars['post_type'];
			if ( 'page' == $post_type && 'post' == $post_type && 'mtheme_portfolio' == $post_type && 'mtheme_events' == $post_type ) {
				get_header();
				?>
					<div id="main" class="cf">
						<div id="content" class="cf">
							<?php $this->display_template(get_the_ID()); ?>
							<?php if($this->args['debug'] == true) print_r(mtheme_get_blocks(get_the_ID())) //for debugging ?>
						</div>
					</div>
				<?php
				get_footer();
				exit;
			}
		}

		/**
		 * Display the template on the front end
		 *
		 * @since	1.0.0
		**/
		function display_template($template_id) {
			global $post;
			//get transient if available
			$template_transient = 'aq_template_' . $template_id;
			//$template_transient_data = get_transient($template_transient);

			//$template_transient_data = get_post_meta($post->ID, $template_transient);

			$new_build_data = get_post_meta($post->ID);
			$multibuilder_key = 'aq_multidatakey_' . $template_id;
			$template_serialized_multidata = get_post_meta($post->ID, $multibuilder_key);

			$final_dataset=array();

			if ( isSet($template_serialized_multidata) && !empty($template_serialized_multidata) ) {
				foreach ($template_serialized_multidata[0] as $key => $data_set ) {
					wp_parse_str($data_set, $multiparams);
					if (isSet($multiparams['aq_blocks'])) {
						foreach ($multiparams['aq_blocks'] as $mkey => $mdata_set ) {
							if (isSet($mdata_set)) {
								$final_dataset[$mkey] = $mdata_set;
							}
						}
					}
				}
			}

			$template_transient_data = $final_dataset;


			// echo '<pre>---------';
			// print_r ($template_transient_data);
			// echo '</pre>';

			if (isSet($template_transient_data) && !empty($template_transient_data)) {
				$blocks = $template_transient_data;
			}

			// echo '<pre>';
			// print_r ($template_transient_data);
			// echo '</pre>';
			if (!isSet($blocks)) {
				$blocks = array();
			}

			if(is_array($blocks) && !empty($blocks)) {
				//$blocks = $blocks[0];
				//$blocks = $blocks['aq_blocks'];
			} else {
				$blocks = array();
			}
			//return early if no blocks
			if(empty($blocks)) {

				/*
				echo '<p class="empty-template">';
								echo __('This template is empty', 'mthemelocal');
								echo '</p>';*/


			} else {
				$saved_blocks = $blocks;


				//template wrapper
				echo '<div id="mtheme-pagebuilder-wrapper-'.$template_id.'" class="mtheme-pagebuilder">';

				$overgrid = 0; $span = 0; $first = false;

				// 6,5,7,9,2,6
				$rows = array();
				$running_total = 0;
				$current_row = array();
				foreach ( $blocks as $key => $instance ) {
					//print_a($instance);
					if ( 0 != $instance['parent'] ) {
						continue;
					}
					// print_a($instance);
					$col_size = absint( preg_replace( "/[^0-9]/", '', $instance['size'] ) );
					$running_total += $col_size;
					if ( 12 < $running_total ) {
						$rows[] = $current_row;
						$current_row = array();
						$running_total = $col_size;
						$current_row[] = $instance;
					} else if ( 12 == $running_total ) {
						$current_row[] = $instance;
						$rows[] = $current_row;
						$running_total = 0;
						$current_row = array();
					} else {
						$current_row[] = $instance;
					}
				}
				if ( ! empty($current_row) ) {
					$rows[] = $current_row;
					$current_row = null;
				}
				global $aq_registered_blocks;
				// echo '<pre>';
				// print_r ($aq_registered_blocks);
				// echo '</pre>';
				//outputs the blocks
				$column_background_wrap = false;
				$column_class='';
				foreach( $rows as $row ) {
					$class = 'pagebuilder-container';
					$before = $after = '';
					
					$column_extra_class='';
					if( $row[0]['id_base'] == 'em_column_block' ) {
						// echo '<pre>';
						// print_r($row);
						// echo '</pre>';
						if (isSet($row[0]['container_type'])) {
							if ( $row[0]['container_type'] == "fullwidth" ) {
								$column_extra_class = ' fullwidth-column';
							}
							if ( $row[0]['container_type'] == "boxed" ) {
								$column_extra_class = ' boxed-column';
							}
							if (isSet($row[0]['text_intensity'])) {
								if ( $row[0]['text_intensity'] == "bright" ) {
									$column_extra_class .= ' text-is-bright';
								}
								if ( $row[0]['text_intensity'] == "dark" ) {
									$column_extra_class .= ' text-is-dark';
								}
							}
						}
						if ($row[0]['size']=="span12") {

						} else {
							$column_extra_class .= ' divided-column';
						}

						if($row[0]['id_base'] == 'em_column_block') {
							$column_blockID = $row[0]['blockID'];
							$backgroundColor = $row[0]['background_color'];
							if (isSet($row[0]['gradient_color'])) {
								$gradient_color = $row[0]['gradient_color'];
							}
							if (isSet($row[0]['gradient_angle'])) {
								$gradient_angle = $row[0]['gradient_angle'];
							}
							$backgroundImage = $row[0]['background_image'];
							$checkParallax = $row[0]['background_scroll'];
							$margin_bottom = $row[0]['margin_bottom'];
							$margin_top = $row[0]['margin_top'];
							$stellar_tag = '';

							if ( isSet($row[0]['padding_bottom'])) {
								$padding_bottom = $row[0]['padding_bottom'];
							}
							if ( isSet($row[0]['padding_top'])) {
								$padding_top = $row[0]['padding_top'];
							}
							if ( isSet($row[0]['padding_sides'])) {
								$padding_sides = $row[0]['padding_sides'];
							}

							$backgroundStyle = '';
							if(!empty($backgroundColor)){
								$backgroundStyle .= 'background-color:'.$backgroundColor.';';
							}
							if(!empty($gradient_color)){
								if ($gradient_angle<>"none") {
									switch ($gradient_angle) {
										case 'to_bottom':
											$gradient_direction = 'to bottom';
											break;
										case 'to_top':
											$gradient_direction = 'to top';
											break;
										case 'to_top_right':
											$gradient_direction = 'to top right';
											break;
										case 'to_top_left':
											$gradient_direction = 'to top left';
											break;
										case 'to_bottom_right':
											$gradient_direction = 'to bottom right';
											break;
										case 'to_bottom_left':
											$gradient_direction = 'to bottom left';
											break;
										
										default:
											$gradient_direction = 'to bottom';
											break;
									}
									$backgroundStyle .= 'background: linear-gradient('.$gradient_direction.', '.$backgroundColor.', '.$gradient_color.');';
								}
							}
							if(!empty($backgroundImage)){
								$backgroundStyle = 'background-image:url('.$backgroundImage.'); background-size : cover;';
								if($checkParallax == "parallax"){
									$backgroundStyle .= 'background-attachment : cover;';
									$column_class .= ' column-parallax';
									$stellar_tag = 'data-stellar-background-ratio="0.5"';
								}
							}
							$margin_style='';
							if (isSet($margin_bottom) && !empty($margin_bottom)) {
								$backgroundStyle .= 'margin-bottom:'.$margin_bottom.'px;';
							}
							if (isSet($margin_top) && !empty($margin_top)) {
								$backgroundStyle .= 'margin-top:'.$margin_top.'px;';
							}
							if (isSet($padding_bottom) && !empty($padding_bottom)) {
								$backgroundStyle .= 'padding-bottom:'.$padding_bottom.'px;';
							}
							if (isSet($padding_top) && !empty($padding_top)) {
								$backgroundStyle .= 'padding-top:'.$padding_top.'px;';
							}
							if (isSet($padding_sides) && !empty($padding_sides)) {
								$backgroundStyle .= 'padding-left:'.$padding_sides.'px;';
								$backgroundStyle .= 'padding-right:'.$padding_sides.'px;';
							}
							$cssStyle_tag='';
							if ( !empty($backgroundStyle) && isSet($backgroundStyle) ) {
								$cssStyle_tag = 'style="'.$backgroundStyle.' "';
							}
							if ( isSet($column_blockID) && $column_blockID<>'' ) {
								$column_blockID = 'id="'.$column_blockID.'"';
							} else {
								$column_blockID = '';
							}
							echo '<div '.$column_blockID.' class="mtheme-modular-column" '. $stellar_tag .' '.$cssStyle_tag.'>';
							$column_background_wrap = true;
						}
					}
					echo '<div class="mtheme-supercell clearfix '.$column_extra_class.'">';
					echo $before;
					foreach($row as $key => $instance) {
						extract($instance);

					// echo '<hr class="clearfix">';
					// echo '<pre>-key-----------------<br/>';
					// print_r($key);
					// echo '-instance-----------------<br/>';
					// print_r($instance);
					// echo '</pre>';

					if ($key==0) {
						$column_class= "first-column";
					} else {
						$column_class= "following-column";
					}

					if($instance['id_base'] == 'em_column_block') {
						$backgroundColor = $instance['background_color'];
						$backgroundImage = $instance['background_image'];
						$checkParallax = $instance['background_scroll'];
						$margin_bottom = $instance['margin_bottom'];
						$margin_top = $instance['margin_top'];

						if ( isSet($instance['padding_bottom'])) {
							$padding_bottom = $instance['padding_bottom'];
						}
						if ( isSet($instance['padding_top'])) {
							$padding_top = $instance['padding_top'];
						}
						if ( isSet($instance['padding_sides'])) {
							$padding_sides = $instance['padding_sides'];
						}

						$backgroundStyle = '';
						if(!empty($backgroundColor)){
							$backgroundStyle .= 'background-color:'.$backgroundColor.';';
						}
						if(!empty($backgroundImage)){
							$backgroundStyle = 'background-image:url('.$backgroundImage.'); background-size : cover;';
							if($checkParallax == "parallax"){
								$backgroundStyle .= 'background-attachment : cover;';
								$column_class .= ' column-parallax';
							}
						}
						$margin_style='';
						if (isSet($margin_bottom) && !empty($margin_bottom)) {
							$backgroundStyle .= 'margin-bottom:'.$margin_bottom.'px;';
						}
						if (isSet($margin_top) && !empty($margin_top)) {
							$backgroundStyle .= 'margin-top:'.$margin_top.'px;';
						}
						if (isSet($padding_bottom) && !empty($padding_bottom)) {
							$backgroundStyle .= 'padding-bottom:'.$padding_bottom.'px;';
						}
						if (isSet($padding_top) && !empty($padding_top)) {
							$backgroundStyle .= 'padding-top:'.$padding_top.'px;';
						}
						if (isSet($padding_sides) && !empty($padding_sides)) {
							$backgroundStyle .= 'margin-left:'.$padding_sides.'px;';
							$backgroundStyle .= 'margin-right:'.$padding_sides.'px;';
						}
						$cssStyle_tag='';
						if ( !empty($backgroundStyle) && isSet($backgroundStyle) ) {
							$cssStyle_tag = 'style="'.$backgroundStyle.' "';
						}
						echo '<div class="column-setter '.$column_class.' '.$instance['size'].'">';

					}

						if(class_exists($id_base)) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];

							//insert template_id into $instance
							$instance['template_id'] = $template_id;

							//display the block
							if($parent == 0) {

								$col_size = absint(preg_replace("/[^0-9]/", '', $size));

								$overgrid = $span + $col_size;

								if($overgrid > 12 || $span == 12 || $span == 0) {
									$span = 0;
									$first = true;
								}

								if($first == true) {
									$instance['first'] = true;
								}

								$block->block_callback($instance,$saved_blocks);

								$span = $span + $col_size;

								$overgrid = 0; //reset $overgrid
								$first = false; //reset $first
							}
						}
						if($instance['id_base'] == 'em_column_block') {
							// End of column inside
							echo '</div>';
						}
					}
					echo $after;
					// close supercell wrap
					echo '</div>';
					if ($column_background_wrap == true ) {
						echo '</div>';
						$column_background_wrap = false; 
					}
				}

				//close template wrapper
				echo '</div>';
			}

		}

		/**
		 * Add the [template] shortcode
		 *
		 * @since 1.0.0
		 */
		function add_shortcode() {

			global $shortcode_tags;
			if ( !array_key_exists( 'template', $shortcode_tags ) ) {
				add_shortcode( 'template', array(&$this, 'do_shortcode') );
			} else {
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>Aqua Page Builder notice: </strong>'. __('The \"[template]\" shortcode already exists, possibly added by the theme or other plugins. Please consult with the theme author to consult with this issue', 'mthemelocal') .'</p></div>';"));
			}

		}

		/**
		 * Shortcode function
		 *
		 * @since 1.0.0
		 */
		function do_shortcode($atts, $content = null) {

			$defaults = array('id' => 0);
			extract( shortcode_atts( $defaults, $atts ) );

			//capture template output into string
			ob_start();
				$this->display_template($id);
				$template = ob_get_contents();
			ob_end_clean();

			return $template;

		}

		/**
		 * Media button display
		 *
		 * @since 1.0.6
		 */
		function add_media_display() {

			global $pagenow;

			/** Only run in post/page new and edit */
			if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
				/** Get all published templates */
				$templates = get_posts( array(
					'post_type' 		=> 'template',
					'posts_per_page'	=> -1,
					'post_status' 		=> 'publish',
					'order'				=> 'ASC',
					'orderby'			=> 'title'
		    		)
				);

				?>
				<script type="text/javascript">
					function insertTemplate() {
						var id = jQuery( '#select-aqpb-template' ).val();

						/** Alert user if there is no template selected */
						if ( '' == id ) {
							alert("<?php echo esc_js( __( 'Please select your template first!', 'mthemelocal' ) ); ?>");
							return;
						}

						/** Send shortcode to editor */
						window.send_to_editor('[template id="' + id + '"]');
					}
				</script>

				<div id="aqpb-iframe-container" style="display: none;">
					<div class="wrap" style="padding: 1em">

						<?php do_action( 'mtheme_aqpb_before_iframe_display', $templates ); ?>

						<?php
						/** If there is no template created yet */
						if ( empty( $templates ) ) {
							echo sprintf( __( 'You don\'t have any template yet. Let\'s %s create %s one!', 'mthemelocal' ), '<a href="' .admin_url().'themes.php?page=aq-page-builder">', '</a>' );
							return;
						}
						?>

						<h3><?php _e( 'Choose Your Page Template', 'mthemelocal' ); ?></h3><br />
						<select id="select-aqpb-template" style="clear: both; min-width:200px; display: inline-block; margin-right: 3em;">
						<?php
							foreach ( $templates as $template )
								echo '<option value="' . absint( $template->ID ) . '">' . esc_attr( $template->post_title ) . '</option>';
						?>
						</select>

						<input type="button" id="aqpb-insert-template" class="button-primary" value="<?php echo esc_attr__( 'Insert Template', 'mthemelocal' ); ?>" onclick="insertTemplate();" />
						<a id="aqpb-cancel-template" class="button-secondary" onclick="tb_remove();" title="<?php echo esc_attr__( 'Cancel', 'mthemelocal' ); ?>"><?php echo esc_attr__( 'Cancel', 'mthemelocal' ); ?></a>

						<?php do_action( 'mtheme_aqpb_after_iframe_display', $templates ); ?>

					</div>
				</div>

				<?php
			} /** End Coditional Statement for post, page, new and edit post */

		}

		/**
		 * Contextual help tabs
		 *
		 * @since 1.0.0
		 */
		function contextual_help() {

			$screen = get_current_screen();
			$contextual_helps = apply_filters('mtheme_aqpb_contextual_helps', array());


		}

		/**
		 * Main page builder settings page display
		 *
		 * @since	1.0.0
		 */
		function builder_settings_show($post){
			echo '<input type="hidden" name="mtheme_builderblocks_nonce-page_builder" value="' . wp_create_nonce('mtheme_builderblocks_nonce-page_builder') . '" />';
			$activate_builder = get_post_meta($post->ID, 'page_builder');
			require_once(AQPB_PATH . 'view/view-settings-page.php');
		}

		function post_pagebuilder_builderblocks_save() {
			global $post;
			$template_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : '';
			$pagebuilder_saved = false;
			/*Security Check*/
		    if (!isset($_POST['mtheme_builderblocks_nonce-page_builder']) || !wp_verify_nonce($_POST['mtheme_builderblocks_nonce-page_builder'], 'mtheme_builderblocks_nonce-page_builder'))
				return $template_id;

		   //now let's save our blocks & prepare haystack
			$blocks = AQ_Page_Builder::get_blocks($template_id);
			
			$haystack = array();
			$template_transient_data = array();
			$i = 1;


			$msave_data=array();
			
			if ( isSet($_POST['mbuilder_datakeys']) ) {
				$mbuilder_serialized_multikeys = $_POST['mbuilder_datakeys'];
				$sep_keys = explode(",", $mbuilder_serialized_multikeys);
				//print_r($sep_keys);

				$builder_key = 'aq_multidatakey_' . $template_id;

				$the_key_data_array=array();
				foreach ($sep_keys as $the_keys) {
					//echo $the_keys;
					$the_key_data = isset($_POST['mbuild_data_' . $the_keys]) ? $_POST['mbuild_data_' . $the_keys] : '';
					//print_r($the_key_data);
					$the_key_data_array[] = $the_key_data; 

				}
				if ( isSet($the_key_data_array) && !empty($the_key_data_array) ) {
					update_post_meta( $template_id, $builder_key , $the_key_data_array );
				}
				// **********************************************
				// **********************************************
				// ********* Update serialized data *************
				// **********************************************
				$builder_key = 'aq_datakey_' . $template_id;
				$mbuilder_serialized_data = isset($_POST['mbuilder_serialized_data']) ? $_POST['mbuilder_serialized_data'] : '';
				// echo '<pre>';
				// print_r($mbuilder_serialized_data);
				// echo '</pre>';
				if ( isSet($mbuilder_serialized_data) && !empty($mbuilder_serialized_data) ) {
					update_post_meta( $template_id, $builder_key , $mbuilder_serialized_data );
				}
				$pagebuilder_saved = true;
			}

			$is_builder_active = $_POST['mtheme_pb_isactive'];
			if (isSet($is_builder_active)) {
				update_post_meta($template_id, 'mtheme_pb_isactive', $is_builder_active);
			}
			// **********************************************
			// ******* Yoast support for Pagebuilder ********
			// **********************************************
			$seoanalysishelper = false;
			if ( defined('WPSEO_VERSION') && $pagebuilder_saved && $template_id ) {
				$seoanalysishelper = true;
			}
			if ( defined('SQ_VERSION') && $pagebuilder_saved && $template_id ) {
				$seoanalysishelper = true;
			}
			if ( $seoanalysishelper ) {

		        $got_this_post = get_post( $template_id );

				$template_serialized_multidata = $the_key_data_array;

				if ( isSet($template_serialized_multidata) && !empty($template_serialized_multidata) ) {
					foreach ($template_serialized_multidata as $key => $data_set ) {
						wp_parse_str($data_set, $multiparams);
						if (isSet($multiparams['aq_blocks'])) {
							foreach ($multiparams['aq_blocks'] as $mkey => $mdata_set ) {
								if (isSet($mdata_set)) {
									$final_dataset[$mkey] = $mdata_set;
								}
							}
						}
					}
				}

				global $aq_registered_blocks;
				$blocks = $final_dataset;
				$saved_blocks = $blocks;

				$rows = array();
				$all_of_total = 0;
				$current_row = array();
				foreach ( $blocks as $key => $instance ) {
					//print_a($instance);
					if ( 0 != $instance['parent'] ) {
						continue;
					}
					// print_a($instance);
					$col_size = absint( preg_replace( "/[^0-9]/", '', $instance['size'] ) );
					$all_of_total += $col_size;
					if ( 12 < $all_of_total ) {
						$rows[] = $current_row;
						$current_row = array();
						$all_of_total = $col_size;
						$current_row[] = $instance;
					} else if ( 12 == $all_of_total ) {
						$current_row[] = $instance;
						$rows[] = $current_row;
						$all_of_total = 0;
						$current_row = array();
					} else {
						$current_row[] = $instance;
					}
				}
				if ( ! empty($current_row) ) {
					$rows[] = $current_row;
					$current_row = null;
				}

				$the_got_blocks = '';
			
				foreach( $rows as $row ) {

					foreach($row as $key => $instance) {
						extract($instance);

						if(class_exists($id_base)) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];

							//insert template_id into $instance
							$instance['template_id'] = $template_id;

							//display the block
							if($parent == 0) {
								ob_start();$block->block_callback($instance,$saved_blocks);$the_got_blocks .= ob_get_contents();ob_end_clean();
							}
						}
					}
				}

				$got_this_post->post_content = $the_got_blocks;

				if (isSet($got_this_post)) {
					if ( ! wp_is_post_revision( $template_id ) ){
						remove_action( 'save_post', 'mtheme_save_post_pagebuilder');
						wp_update_post( $got_this_post );
						add_action( 'save_post', 'mtheme_save_post_pagebuilder');
					}
				}

			}
		    return $template_id;
		}
	}
}