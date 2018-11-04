<?php
/* Checklist */
if(!class_exists('em_checklist')) {
	class em_checklist extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-check',
				'pb_block_icon_color' => '#966FD6',
				'name' => __('Checklist','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add check lists','mthemelocal')
			);
			//create the widget

			/*-----------------------------------------------------------------------------------*/
			/*	Checklist Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['checklist'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add Checklist.', 'mthemelocal'),
			    'shortcode' => '[checklist icon="{{icon}}" color="{{iconcolor}}"]<ul>{{child_shortcode}}</ul>[/checklist]',
			    'popup_title' => __('Insert Checklist', 'mthemelocal'),
			 	'params' => array(
			        'icon' => array(
			            'std' => 'fa fa-ok',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Select icon', 'mthemelocal'),
			            'desc' => __('Select an icon', 'mthemelocal'),
			            'options' => ''
			        ),
					'iconcolor' => array(
						'std' => '#EC3939',
						'type' => 'color',
						'label' => __('Icon color', 'mthemelocal'),
						'desc' => __('Icon color in hex', 'mthemelocal'),
					),
				),
			    'child_shortcode' => array(
			        'params' => array(
			            'content' => array(
			                'std' => 'Item.',
			                'type' => 'text',
			                'label' => __('List a line', 'mthemelocal'),
			                'desc' => __('You can add as many as you like.', 'mthemelocal')
			            )
			        ),
			        'title_field' => 'content',
			        'shortcode' => '<li>{{content}}</li>',
			        'clone_button' => __('+ Add Another Checklist Line', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['checklist'];
			$this->the_child_options = $mtheme_shortcodes['checklist']['child_shortcode'];

			parent::__construct('em_checklist', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_checklist_add_new', array($this, 'add_checklist_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					0 => array(
						'content' => __('Item','mthemelocal')
					)
				),
				'title' => __('Checklist Tab','mthemelocal'),
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
				<a href="#" rel="checklist" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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
			mtheme_process_shortcode($shortcode,$encode=true);
		}
		function tabbed_method() {
		}
		/* AJAX add tab */
		function add_checklist_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'content' => __('Item','mthemelocal')
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
