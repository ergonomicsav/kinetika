<?php
/* Pricing Table */
if(!class_exists('em_pricingtable')) {
	class em_pricingtable extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-usd',
				'pb_block_icon_color' => '#39CCCC',
				'name' => __('Pricing table','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Pricing Table','mthemelocal')
			);
			//create the widget

			/*-----------------------------------------------------------------------------------*/
			/*	Pricing Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['pricing_table'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add Pricing shortcode. You can configure the shortcode after adding them.', 'mthemelocal'),
			    'shortcode' => '[pricing_table columns="1"][pricing_column animated="{{animated}}" title="{{title}}" title_bgcolor="{{title_bgcolor}}" featured="{{featured}}"][pricing_price currency="{{currency}}" price="{{price}}" duration="{{duration}}"] {{child_shortcode}} [pricing_footer][button button_color="{{title_bgcolor}}" link="{{link}}" align="center"]{{button_text}}[/button][/pricing_footer][/pricing_column][/pricing_table]',
			    'popup_title' => __('Add Pricing Table', 'mthemelocal'),
			 	'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
		            'title' => array(
		                'std' => __('Standard','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Column Title', 'mthemelocal'),
		                'desc' => __('Column title', 'mthemelocal'),
		            ),
					'title_bgcolor' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Pricing title color', 'mthemelocal'),
						'desc' => __('Pricing title color', 'mthemelocal'),
					),
					'featured' => array(
						'type' => 'select',
						'label' => __('Make Featured', 'mthemelocal'),
						'desc' => __('Make Featured', 'mthemelocal'),
						'options' => array(
							'true' => 'Yes',
							'false' => 'No'
						)
					),
		            'currency' => array(
		                'std' => '$',
		                'type' => 'text',
		                'label' => __('Currency Symbol', 'mthemelocal'),
		                'desc' => __('Enter currency symbol.', 'mthemelocal'),
		            ),
		            'price' => array(
		                'std' => '29.99',
		                'type' => 'text',
		                'label' => __('Price value', 'mthemelocal'),
		                'desc' => __('Enter price value.', 'mthemelocal'),
		            ),
		            'duration' => array(
		                'std' => __('monthly','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Enter duration', 'mthemelocal'),
		                'desc' => __('Enter duration.', 'mthemelocal'),
		            ),
		            'link' => array(
		                'std' => __('Button link','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Button link', 'mthemelocal'),
		                'desc' => __('Button link', 'mthemelocal'),
		            ),
		            'button_text' => array(
		                'std' => __('Button Text','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Button text', 'mthemelocal'),
		                'desc' => __('Button text', 'mthemelocal'),
		            ),
				),
			    'child_shortcode' => array(
			        'params' => array(
			            'row_text' => array(
			                'std' => __('Row Text','mthemelocal'),
			                'type' => 'text',
			                'label' => __('Row text', 'mthemelocal'),
			                'desc' => __('Row text', 'mthemelocal'),
			            ),
						'type' => array(
							'type' => 'select',
							'label' => __('Tick or Cross', 'mthemelocal'),
							'desc' => __('Mark as a present or absent feature', 'mthemelocal'),
							'options' => array(
								'tick' => __('Tick','mthemelocal'),
								'cross' => __('Cross','mthemelocal')
							)
						),
			        ),
			        'title_field' => 'row_text',
			        'shortcode' => '[pricing_row type="{{type}}"] {{row_text}} [/pricing_row]',
			        'clone_button' => __('+ Add Another Column', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['pricing_table'];
			$this->the_child_options = $mtheme_shortcodes['pricing_table']['child_shortcode'];

			parent::__construct('em_pricingtable', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_pricing_table_add_new', array($this, 'add_pricing_table_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					0 => array(
						'title' => __('Pricing Tab','mthemelocal'),
						'featured' => '',
						'currency' => '',
						'price' => '',
						'duration' => '',
					)
				),
				'title' => __('Pricing Tab','mthemelocal'),
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
				<a href="#" rel="pricing_table" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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
		function add_pricing_table_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => __('Pricing Tab','mthemelocal'),
				'featured' => '',
				'currency' => '',
				'price' => '',
				'duration' => '',
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
