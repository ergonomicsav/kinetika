<?php
/* Hero Image */
if(!class_exists('em_heroimage')) {
	class em_heroimage extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-star',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Hero Image','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Add a Hero Image','mthemelocal')
			);
			//create the widget

			$mtheme_shortcodes['heroimage'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Display Hero image', 'mthemelocal'),
			    'shortcode' => '[heroimage image="{{image}}" text_location="{{text_location}}" intensity="{{intensity}}" text_decoration="{{text_decoration}}" text="{{text}}" link="{{link}}" icon="{{icon}}" text_slide="{{text_slide}}"] {{child_shortcode}} [/heroimage]',
			    'popup_title' => __('Generate a Hero image', 'mthemelocal'),
				'params' => array(
			        'image' => array(
			            'std' => '',
			            'type' => 'uploader',
			            'label' => __('Add image', 'mthemelocal'),
			            'desc' => __('Upload an image', 'mthemelocal'),
			        ),
					'intensity' => array(
						'type' => 'select',
						'std' => 'true',
						'label' => __('Intensity for Text and ui elements', 'mthemelocal'),
						'desc' => __('Intensity for Text and ui elements', 'mthemelocal'),
						'options' => array(
							'default' => __('Default','mthemelocal'),
							'bright' => __('Bright','mthemelocal'),
							'dark' => __('Dark','mthemelocal')
						)
					),
					'text' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Hero image assist text', 'mthemelocal'),
						'desc' => __('Text to display. Displays as a title on bottom of hero image', 'mthemelocal')
					),
					'link' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Link', 'mthemelocal'),
						'desc' => __('Link for hero image navigation', 'mthemelocal')
					),
					'icon' => array(
						'type' => 'select',
						'std' => 'true',
						'label' => __('Display icon', 'mthemelocal'),
						'desc' => __('Display icon', 'mthemelocal'),
						'options' => array(
							'true' => __('Enable','mthemelocal'),
							'false' => __('Disable','mthemelocal')
						)
					),
					'text_decoration' => array(
						'type' => 'select',
						'std' => 'true',
						'label' => __('Text decoration', 'mthemelocal'),
						'desc' => __('Text decoration', 'mthemelocal'),
						'options' => array(
							'none' => __('None','mthemelocal'),
							'border' => __('Border','mthemelocal'),
							'border-top-bottom' => __('Border Top Bottom','mthemelocal'),
						)
					),
					'text_location' => array(
						'type' => 'select',
						'std' => 'top',
						'label' => __('Text Location', 'mthemelocal'),
						'desc' => __('Text Location', 'mthemelocal'),
						'options' => array(
							'top' => __('Top','mthemelocal'),
							'middle' => __('Middle','mthemelocal'),
							'bottom' => __('Bottom','mthemelocal')
						)
					),
					'text_slide' => array(
						'type' => 'select',
						'std' => 'single',
						'label' => __('Text display.', 'mthemelocal'),
						'desc' => __('Display slideshow of text.', 'mthemelocal'),
						'options' => array(
							'single' => __('Single text','mthemelocal'),
							'slideshow' => __('Slideshow','mthemelocal'),
							'disable' => __('Disable','mthemelocal')
						)
					)
				),
			    'child_shortcode' => array(
			        'params' => array(
			            'title' => array(
			                'std' => '',
			                'type' => 'textarea',
			                'label' => __('Title', 'mthemelocal'),
			                'desc' => __('Title', 'mthemelocal'),
			            ),
			            'subtitle' => array(
			                'std' => '',
			                'type' => 'text',
			                'label' => __('Subtitle', 'mthemelocal'),
			                'desc' => __('Subtitle', 'mthemelocal'),
			            )
			        ),
			        'shortcode' => '[heroimage_text title="{{title}}" subtitle="{{subtitle}}"]',
			        'clone_button' => __('+ Add another hero title', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['heroimage'];
			$this->the_child_options = $mtheme_shortcodes['heroimage']['child_shortcode'];

			parent::__construct('em_heroimage', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_herotitle_add_new', array($this, 'add_herotitle_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					1 => array(
						'title' => __('Title','mthemelocal'),
						'subtitle' => __('Subtitle','mthemelocal'),
					)
				),
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
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {
						$this->tab($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="herotitle" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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
			$this->tabbed_method();
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			// echo '<pre>'.$shortcode.'</pre>';
			mtheme_process_shortcode($shortcode,$encode=true);

		}
		function tabbed_method() {
		}
		/* AJAX add tab */
		function add_herotitle_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'title' => 'Title',
				'subtitle' => 'Subtitle',
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
