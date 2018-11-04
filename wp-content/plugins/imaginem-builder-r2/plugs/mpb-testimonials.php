<?php
/* Testimonial */
if(!class_exists('em_testimonials')) {
	class em_testimonials extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-speech',
				'pb_block_icon_color' => '#3D9970',
				'name' => __('Testimonials','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Testimonial sets','mthemelocal')
			);
			//create the widget

			/*-----------------------------------------------------------------------------------*/
			/*	Testimonials
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['testimonials'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Generates testimonials slideshow using multiple testimonial items. You can add as many testimonial items as you prefer and multiple testimonial blocks on the same page.', 'mthemelocal'),
			    'shortcode' => '[testimonials] {{child_shortcode}} [/testimonials]',
			    'popup_title' => __('Insert Testimonial Shortcode', 'mthemelocal'),
			    
			    'child_shortcode' => array(
			        'params' => array(
			            'name' => array(
			                'std' => __('John Doe','mthemelocal'),
			                'type' => 'text',
			                'label' => __('Client Name', 'mthemelocal'),
			                'desc' => __('Client Name', 'mthemelocal'),
			            ),
			            'company' => array(
			                'std' => '',
			                'type' => 'text',
			                'label' => __('Company', 'mthemelocal'),
			                'desc' => __('Company', 'mthemelocal'),
			            ),
			            'link' => array(
			                'std' => '',
			                'type' => 'text',
			                'label' => __('Company link', 'mthemelocal'),
			                'desc' => __('Client link', 'mthemelocal'),
			            ),
			            'image' => array(
			                'std' => '',
			                'type' => 'uploader',
			                'label' => __('Image', 'mthemelocal'),
			                'desc' => __('Image', 'mthemelocal'),
			            ),
				        'imageid' => array(
				            'std' => '',
				            'type' => 'sleeper',
				            'label' => __('Add image', 'mthemelocal'),
				            'desc' => __('Upload image', 'mthemelocal'),
				        ),
			            'quote' => array(
			                'std' => __('Nullam id dolor id nibh ultricies vehicula ut id elit. Nulla vitae elit libero a pharetra augue. Nulla vitae elit libero, a pharetra augue.','mthemelocal'),
			                'type' => 'textarea',
			                'label' => __('Quote', 'mthemelocal'),
			                'desc' => __('Quote', 'mthemelocal'),
			            ),
			        ),
					'title_field' => 'name',
			        'shortcode' => '[testimonial imageid="{{imageid}}" image="{{image}}" link="{{link}}" name="{{name}}" company="{{company}}" quote="{{quote}}"]',
			        'clone_button' => __('+ Add Testimonial', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['testimonials'];
			$this->the_child_options = $mtheme_shortcodes['testimonials']['child_shortcode'];

			parent::__construct('em_testimonials', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_testimonial_add_new', array($this, 'add_testimonial_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					0 => array(
						'name' => __('John Doe','mthemelocal'),
						'company' => '',
						'position' => '',
						'link' => '',
						'image' => '',
						'quote' => '',
					)
				),
				'title' => __('Testimonial Tab','mthemelocal'),
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
				<a href="#" rel="testimonial" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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

			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel_css');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			mtheme_process_shortcode($shortcode,$encode=true);
		}
		function tabbed_method() {
		}
		/* AJAX add tab */
		function add_testimonial_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'name' => __('John Doe','mthemelocal'),
				'company' => '',
				'position' => '',
				'link' => '',
				'image' => '',
				'quote' => '',
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
