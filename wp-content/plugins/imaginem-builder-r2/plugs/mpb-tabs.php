<?php
/* Tabs */
if(!class_exists('em_tabs')) {
	class em_tabs extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-folder',
				'pb_block_icon_color' => '#39CCCC',
				'name' => __('Tabs','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Tab set','mthemelocal')
			);
			//create the widget

			$mtheme_shortcodes['tabs'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add tabs shortcode. You can add multiple tab sections within this generator.', 'mthemelocal'),
			    'shortcode' => '[tabs type="{{type}}"] {{child_shortcode}} [/tabs]',
			    'popup_title' => __('Insert Tab Shortcode', 'mthemelocal'),
			 	'params' => array(
					'type' => array(
						'type' => 'select',
						'label' => __('Tab function type', 'mthemelocal'),
						'desc' => __('Tab function type', 'mthemelocal'),
						'options' => array(
							'horizontal' => __('horizontal','mthemelocal'),
							'vertical' => __('vertical','mthemelocal')
						)
					)
				),
			    'child_shortcode' => array(
			        'params' => array(
			            'title' => array(
			                'std' => __('Title','mthemelocal'),
			                'type' => 'text',
			                'label' => __('Tab Title', 'mthemelocal'),
			                'desc' => __('Title of the tab', 'mthemelocal'),
			            ),
			            'content' => array(
			                'std' => __('Tab Content','mthemelocal'),
			                'type' => 'textarea',
			                'label' => __('Tab Content', 'mthemelocal'),
			                'desc' => __('Tab content', 'mthemelocal')
			            )
			        ),
			        'shortcode' => '[tab title="{{title}}"] {{content}} [/tab]',
			        'clone_button' => __('+ Add Another Tab', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['tabs'];
			$this->the_child_options = $mtheme_shortcodes['tabs']['child_shortcode'];

			parent::__construct('em_tabs', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_tab_add_new', array($this, 'add_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => __('My New Tab','mthemelocal'),
						'content' => __('My tab contents','mthemelocal'),
					)
				),
				'type'	=> 'tab'
			);

			$instance = wp_parse_args($instance, $defaults);
			extract($instance);

			$tab_types = array(
				'tab' => __('Tabs','mthemelocal'),
				'toggle' => __('Toggles','mthemelocal'),
				'accordion' => __('Accordion','mthemelocal')
			);
			
			echo mtheme_generate_builder_form($this->the_options,$instance);
			?>
			<div class="description cf">
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {
						$this->tab($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="tab" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
				<p></p>
			</div>
			<?php
		}

		function tab($tab = array(), $count = 0, $ajax = false) {
			$tab = wp_parse_args($tab, array(
				'title' => '',
				'text' => '',
				'content' => '',
				'image1' => '',
				'image_position' => '',
			));

			$child_field_id = $this->get_field_id('tabs');
			$child_field_name = $this->get_field_name('tabs');
			$child_count = $count;

			mtheme_create_tab( $this->the_child_options, $tab, $child_count, $child_field_id, $child_field_name, $ajax );

		}

		function block($instance) {
			extract($instance);

		    wp_enqueue_script('jquery-ui-core');
		    wp_enqueue_script('jquery-ui-tabs');
		    wp_enqueue_script('jquery-ui-accordion');

			// echo '<pre>';
			// print_r ($instance);
			// echo '</pre>';
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			// echo '<pre>'.$shortcode.'</pre>';
			mtheme_process_shortcode($shortcode,$encode=true);
		}
		function tabbed_method() {
		}
		/* AJAX add tab */
		function add_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => __('New Tab','mthemelocal'),
				'content' => __('My tab content','mthemelocal'),
			);

			if($count) {
				$this->tab($tab, $count,true);
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
