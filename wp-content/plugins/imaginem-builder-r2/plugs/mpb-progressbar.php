<?php
/** Progress bar **/
if(!class_exists('em_progressbar')) {
		class em_progressbar extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-clock',
				'pb_block_icon_color' => '#3D9970',
				'name' => __('Progress bar','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Display Progressbars','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Progress Bar
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['progressbar'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Generates a percentage based progress bar.', 'mthemelocal'),
				'shortcode' => '[progress_group unit="{{unit}}"]{{child_shortcode}}[/progress_group]',
				'popup_title' => __('Insert Progressbar', 'mthemelocal'),
				'params' => array(),
				'child_shortcode' => array(
					'params' => array(
						'title' => array(
							'std' => 'Title',
							'type' => 'text',
							'label' => __('Progress Bar title', 'mthemelocal'),
							'desc' => __('Progress bar title', 'mthemelocal'),
						),
						'unit' => array(
							'std' => '%',
							'type' => 'text',
							'label' => __('Display unit', 'mthemelocal'),
							'desc' => __('Display unit', 'mthemelocal'),
						),
						'color' => array(
							'std' => '#EC3939',
							'type' => 'color',
							'label' => __('Progress color', 'mthemelocal'),
							'desc' => __('Progress color in hex', 'mthemelocal'),
						),
						'percentage' => array(
							'std' => '55',
							'type' => 'text',
							'label' => __('Percent Value', 'mthemelocal'),
							'desc' => __('Percent Value', 'mthemelocal'),
						)
						
					),
			        'title_field' => 'title',
					'shortcode' => '[progressbar color="{{color}}" unit="{{unit}}" percentage="{{percentage}}" title="{{title}}"]',
			        'clone_button' => __('+ Add Another Progress Bar', 'mthemelocal')
			    )

			);
			$this->the_options = $mtheme_shortcodes['progressbar'];
			$this->the_child_options = $mtheme_shortcodes['progressbar']['child_shortcode'];

			parent::__construct('em_progressbar', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_progressbar_add_new', array($this, 'add_progressbar_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					0 => array(
						'title' => __('Progress Name','mthemelocal'),
						'color' => '#EC3939',
						'percentage' => '55'
					)
				),
				'title' => __('Progress Bar','mthemelocal'),
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
				<a href="#" rel="progressbar" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			mtheme_process_shortcode($shortcode,$encode=true);
		}
		function tabbed_method() {
			// wp_enqueue_script ('owlcarousel');
			// wp_enqueue_style ('owlcarousel_css');
		}
		/* AJAX add tab */
		function add_progressbar_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => __('Progress Name','mthemelocal'),
				'color' => '',
				'percentage' => '50'
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