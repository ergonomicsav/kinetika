<?php
/** Info Boxes **/
if(!class_exists('em_imageboxes')) {
		class em_imageboxes extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-picture',
				'pb_block_icon_color' => '#3D9970',
				'name' => __('Image Boxes','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add an information box with text,image and link','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Lightbox Image/Video
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['imageboxes'] = array(
			    'no_preview' => true,
			    'shortcode_desc' => __('Add image box columns. You can add multiple information items from this generator as well as sort them before adding to contents editor.', 'mthemelocal'),
			    'shortcode' => '[imagebox_item displaytype="{{displaytype}}" target="{{target}}" icon="{{icon}}" image="{{image}}" title="{{title}}" link="{{link}}" linktext="{{linktext}}" last_item="builder"] {{content}} [/imagebox_item]',
			    'popup_title' => __('Generate Info boxes Shortcode', 'mthemelocal'),
		        'params' => array(
		            'title' => array(
		                'std' => __('Title of the image box','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Service Title', 'mthemelocal'),
		                'desc' => __('Title of the info box', 'mthemelocal'),
		            ),
					'displaytype' => array(
						'type' => 'select',
						'label' => __('Display title and description', 'mthemelocal'),
						'desc' => __('Display title and description', 'mthemelocal'),
						'options' => array(
							'inside' => 'Inside Box',
							'above' => 'Above Box',
							'below' => 'Below Box',
							'none' => 'None'
						)
					),
		            'image' => array(
		                'std' => '',
		                'type' => 'uploader',
		                'label' => __('Image URL', 'mthemelocal'),
		                'desc' => __('Image URL', 'mthemelocal'),
		            ),
					'icon' => array(
						'std' => 'feather-icon-link',
						'type' => 'fontawesome-iconpicker',
						'label' => __('Select Icon', 'mthemelocal'),
						'desc' => __('Click an icon to select', 'mthemelocal'),
						'options' => ''
					),
		            'link' => array(
		                'std' => '',
		                'type' => 'text',
		                'label' => __('Link', 'mthemelocal'),
		                'desc' => __('Link', 'mthemelocal'),
		            ),
					'target' => array(
						'type' => 'select',
						'label' => __('Link Target', 'mthemelocal'),
						'desc' => __('_self = open in same window. _blank = open in new window', 'mthemelocal'),
						'options' => array(
							'_self' => '_self',
							'_blank' => '_blank'
						)
					),
		            'content' => array(
		                'std' => __('Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.','mthemelocal'),
		                'type' => 'editor',
		                'label' => __('Service Content', 'mthemelocal'),
		                'desc' => __('Add the service content', 'mthemelocal')
		            )
		        )
			);

			$this->the_options = $mtheme_shortcodes['imageboxes'];

			//create the block
			parent::__construct('em_imageboxes', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_scripts'));
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}