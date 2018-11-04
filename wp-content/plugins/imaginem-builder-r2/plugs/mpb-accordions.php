<?php
/* Accordions */
if(!class_exists('em_accordions')) {
	class em_accordions extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-layers',
				'pb_block_icon_color' => '#836953',
				'name' => __('Accordions','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add an accordion tab set','mthemelocal')
			);
			//create the widget

			$mtheme_shortcodes['accordions'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add accordions shortcode. You can add multiple accordion tab sections within this generator.', 'mthemelocal'),
			    'shortcode' => '[accordions active="{{active}}"] {{child_shortcode}}  [/accordions]',
			    'popup_title' => __('Insert Accordions Shortcode', 'mthemelocal'),
			 	'params' => array(
			        'active' => array(
			            'std' => '-1',
			            'type' => 'text',
			            'label' => __('Accordion Tab to activate', 'mthemelocal'),
			            'desc' => __('Set -1 to close all. 0 is the first, 1 for second and so on...', 'mthemelocal'),
			        ),
				),
			    'child_shortcode' => array(
			        'params' => array(
			            'title' => array(
			                'std' => 'Title',
			                'type' => 'text',
			                'label' => __('Title', 'mthemelocal'),
			                'desc' => __('Title', 'mthemelocal'),
			            ),
			            'content' => array(
			                'std' => 'Accordion Content',
			                'type' => 'textarea',
			                'label' => __('Content', 'mthemelocal'),
			                'desc' => __('Accordion Tab content', 'mthemelocal')
			            )
			        ),
			        'title_field' => 'title',
			        'shortcode' => '[accordion title="{{title}}"] {{content}} [/accordion]',
			        'clone_button' => __('+ Add Another Accordion Tab', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['accordions'];
			$this->the_child_options = $mtheme_shortcodes['accordions']['child_shortcode'];

			parent::__construct('em_accordions', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_accordion_add_new', array($this, 'add_accordion_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => __('New Accordion Tab','mthemelocal'),
						'content' => __('Accordion tab content','mthemelocal'),
					)
				),
				'type'	=> 'tab'
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
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {
						$this->tab($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="accordion" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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

		    wp_enqueue_script('jquery-ui-core');
		    wp_enqueue_script('jquery-ui-tabs');
		    wp_enqueue_script('jquery-ui-accordion');
			$this->tabbed_method();

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
		function add_accordion_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => __('New Accordion Tab','mthemelocal'),
				'content' => __('Accordion tab content','mthemelocal'),
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
