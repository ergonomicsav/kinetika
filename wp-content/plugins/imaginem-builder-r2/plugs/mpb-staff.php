<?php
/* Staff */
if(!class_exists('em_staff')) {
	class em_staff extends AQ_Block {

		protected $the_options;
		protected $the_child_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-user-follow',
				'pb_block_icon_color' => '#FF851B',
				'name' => __('Staff','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Staff Block','mthemelocal')
			);
			//create the widget

			/*-----------------------------------------------------------------------------------*/
			/*	Staff Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['staff'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add a Staff with multiple social links.', 'mthemelocal'),
			    'shortcode' => '[staff animated="{{animated}}" title="{{title}}" name="{{name}}" image="{{image}}" imageid="{{imageid}}" desc="{{description}}"] {{child_shortcode}} [/staff]',
			    'popup_title' => __('Insert Staff Shortcode', 'mthemelocal'),
			 	'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'title' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Staff title', 'mthemelocal'),
						'desc' => __('Staff title', 'mthemelocal')
					),
					'name' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Staff name', 'mthemelocal'),
						'desc' => __('Staff name', 'mthemelocal')
					),
					'image' => array(
						'std' => '',
						'type' => 'uploader',
						'label' => __('Staff image', 'mthemelocal'),
						'desc' => __('Staff image', 'mthemelocal')
					),
			        'imageid' => array(
			            'std' => '',
			            'type' => 'sleeper',
			            'label' => __('Add image', 'mthemelocal'),
			            'desc' => __('Upload image', 'mthemelocal'),
			        ),
					'description' => array(
						'std' => '',
						'textformat' => 'richtext',
						'type' => 'editor',
						'label' => __('Staff Description', 'mthemelocal'),
						'desc' => __('Staff Description', 'mthemelocal')
					)
				),
			    'child_shortcode' => array(
			        'params' => array(
			            'social_icon' => array(
			                'std' => 'fa fa-facebook',
				            'type' => 'fontawesome-iconpicker',
				            'label' => __('Choose a Fontawesome icon', 'mthemelocal'),
				            'desc' => __('Pick a fontawesome icon', 'mthemelocal'),
				            'options' => ''
			            ),
			            'social_text' => array(
			                'std' => 'Facebook',
			                'type' => 'text',
			                'label' => __('Social Text', 'mthemelocal'),
			                'desc' => __('Social Text', 'mthemelocal'),
			            ),
			            'social_link' => array(
			                'std' => 'http://www.facebook.com/',
			                'type' => 'text',
			                'label' => __('Link', 'mthemelocal'),
			                'desc' => __('Social Link', 'mthemelocal'),
			            )
			        ),
			        'title_field' => 'social_text',
					'shortcode' => '[socials social_icon="{{social_icon}}" social_link="{{social_link}}" social_text="{{social_text}}"]',
			        'clone_button' => __('+ Add Another Social Link', 'mthemelocal')
			    )
			);
			$this->the_options = $mtheme_shortcodes['staff'];
			$this->the_child_options = $mtheme_shortcodes['staff']['child_shortcode'];

			parent::__construct('em_staff', $block_options);

			//add ajax functions
			add_action('wp_ajax_aq_block_staff_add_new', array($this, 'add_staff_tab'));
		}

		function form($instance) {

			$defaults = array(
				'tabs' => array(
					0 => array(
						'social_text' => __('Social Site Name','mthemelocal'),
						'social_icon' => '',
						'social_link' => ''
					)
				),
				'title' => __('Social Tab','mthemelocal'),
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
				<a href="#" rel="staff" class="aq-sortable-add-new button"><?php _e('Add New','mthemelocal'); ?></a>
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
		function add_staff_tab() {

			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'mtheme-block-9999';

			//default key/value for the tab
			$tab = array(
				'social_text' => __('Social Site Name','mthemelocal'),
				'social_icon' => '',
				'social_link' => ''
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
