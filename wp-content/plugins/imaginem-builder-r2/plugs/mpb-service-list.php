<?php
/* Service List */
if(!class_exists('em_servicelist')) {
	class em_servicelist extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-list',
				'pb_block_icon_color' => '#FF851B',
				'name' => __('Service List','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Service list','mthemelocal')
			);
			//create the widget

			/*-----------------------------------------------------------------------------------*/
			/*	Service List Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['service_list'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add Service columns. You can add multiple service items from this generator as well as sort them before adding to contents editor.', 'mthemelocal'),
			    'shortcode' => '[servicebox animated="{{animated}}" column="1" iconplace="left" boxplace="vertical" iconborder={{iconborder}} iconbackground={{iconbackground}} iconcolor="{{iconcolor}}"] {{child_shortcode}} <br/>[/servicebox]',
			    'popup_title' => __('Generate Services', 'mthemelocal'),
			 	'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'iconborder' => array(
						'type' => 'select',
						'label' => __('iCon Border', 'mthemelocal'),
						'desc' => __('Placement of service boxes', 'mthemelocal'),
						'options' => array(
							'false' => __('Disable','mthemelocal'),
							'true' => __('Enable','mthemelocal')
						)
					),
					'iconcolor' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Icon color', 'mthemelocal'),
						'desc' => __('Color of icon in hex', 'mthemelocal'),
					),
					'iconbackground' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Icon background color', 'mthemelocal'),
						'desc' => __('Background color of icon', 'mthemelocal'),
					),
				),
			    'child_shortcode' => array(
			        'params' => array(
			            'icon' => array(
			                'std' => 'et-icon-strategy',
				            'type' => 'fontawesome-iconpicker',
				            'label' => __('Choose a Fontawesome icon', 'mthemelocal'),
				            'desc' => __('Pick a fontawesome icon', 'mthemelocal'),
				            'options' => ''
			            ),
			            'title' => array(
			                'std' => __('Fusce Magna Elit','mthemelocal'),
			                'type' => 'text',
			                'label' => __('Service Title', 'mthemelocal'),
			                'desc' => __('Title of the service', 'mthemelocal'),
			            ),
			            'link' => array(
			                'std' => '',
			                'type' => 'text',
			                'label' => __('Link', 'mthemelocal'),
			                'desc' => __('Link to title', 'mthemelocal'),
			            ),
			            'content' => array(
			                'std' => __('Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.','mthemelocal'),
			                'type' => 'textarea',
			                'label' => __('Service Content', 'mthemelocal'),
			                'desc' => __('Add the service content', 'mthemelocal')
			            )
			        ),
					'title_field' => 'title',
			        'shortcode' => '[servicebox_item icon="{{icon}}" title="{{title}}" link="{{link}}" last_item="no" pagebuilder="active"] {{content}} [/servicebox_item]',
			        'clone_button' => __('+ Add another Service Column', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['service_list'];
			$this->the_child_options = $mtheme_shortcodes['service_list']['child_shortcode'];

			parent::__construct('em_servicelist', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_servicelist_add_new', array($this, 'add_servicelist_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					0 => array(
						'icon' => '',
						'title' => __('New Service','mthemelocal'),
						'link' => '',
						'content' => ''
					)
				),
				'title' => __('New Service','mthemelocal'),
				'type'	=> 'tab',
				'entrance_animation' => ''
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			?>
			<div class="description cf">
			<?php
			echo mtheme_generate_builder_form($this->the_options,$instance);
			?>
			
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					// echo '<pre>THis is it';
					// print_r($instance);
					// echo '</pre>';
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					// echo '<pre>THis is it after';
					// print_r($tabs);
					// echo '</pre>';
					$count = 1;
					foreach($tabs as $tab) {
						$this->tab($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="servicelist" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
				<p></p>
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0) {

			$child_field_id = $this->get_field_id('tabs');
			$child_field_name = $this->get_field_name('tabs');
			$child_count = $count;

			mtheme_create_tab( $this->the_child_options, $tab, $child_count, $child_field_id, $child_field_name );

		}

		function block($instance) {
			extract($instance);

			// echo '<pre>';
			// print_r ($instance);
			// echo '</pre>';
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			mtheme_process_shortcode($shortcode,$encode=true);
		}
		function tabbed_method() {
		}
		/* AJAX add tab */
		function add_servicelist_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'icon' => '',
				'title' => __('New Service','mthemelocal'),
				'link' => '',
				'content' => ''
			);

			if($count) {
				$this->tab($tab, $count);
			} else {
				die(-1);
			}

			die();
		}

		function update($new_instance, $old_instance) {
			$new_instance = mtheme_recursive_sanitize($new_instance);
			return $new_instance;
		}
	}
}
