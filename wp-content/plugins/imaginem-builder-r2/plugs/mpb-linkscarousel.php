<?php
/* Links Carousel */
if(!class_exists('em_linkscarousel')) {
	class em_linkscarousel extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-link',
				'pb_block_icon_color' => '#FF851B',
				'name' => __('Links Carousel','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Display a caroulse of linked images','mthemelocal')
			);
			//create the widget

			/*-----------------------------------------------------------------------------------*/
			/*	Testimonials
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['carousel_group'] = array(
			    'no_preview' => true,
			    'shortcode_desc' => __('Generates a carousel of images.', 'mthemelocal'),
			    'shortcode' => '[carousel_group columns="{{columns}}"] {{child_shortcode}} [/carousel_group]',
			    'popup_title' => __('Insert carousel Shortcode', 'mthemelocal'),
				'params' => array(
					'columns' => array(
						'type' => 'select',
						'label' => __('Columns', 'mthemelocal'),
						'desc' => __('No. of Columns', 'mthemelocal'),
						'options' => array(
							'6' => '6',
							'5' => '5',
							'4' => '4',
							'3' => '3',
							'2' => '2',
							'1' => '1'
						)
					)
				),			    
			    'child_shortcode' => array(
			        'params' => array(
			            'name' => array(
			                'std' => 'Name',
			                'type' => 'text',
			                'label' => __('Name', 'mthemelocal'),
			                'desc' => __('Name', 'mthemelocal'),
			            ),
			            'link' => array(
			                'std' => '',
			                'type' => 'text',
			                'label' => __('Link', 'mthemelocal'),
			                'desc' => __('Link', 'mthemelocal'),
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
			        ),
					'title_field' => 'name',
			        'shortcode' => '[carousel_item name="{{name}}" image="{{image}}" link="{{link}}"]',
			        'clone_button' => __('+ Add Carousel item', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['carousel_group'];
			$this->the_child_options = $mtheme_shortcodes['carousel_group']['child_shortcode'];

			parent::__construct('em_linkscarousel', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_linkscarousel_add_new', array($this, 'add_linkscarousel_tab'));

			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_Block'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					0 => array(
						'name' => __('Name','mthemelocal'),
						'link' => '',
						'image' => '',
					)
				),
				'title' => __('Carousel Tab','mthemelocal'),
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
				<a href="#" rel="linkscarousel" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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

			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel_css');
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			mtheme_process_shortcode($shortcode,$encode=true);
		}
		function tabbed_method() {
		}
		/* AJAX add tab */
		function add_linkscarousel_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'name' => __('Name','mthemelocal'),
				'link' => '',
				'image' => '',
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
