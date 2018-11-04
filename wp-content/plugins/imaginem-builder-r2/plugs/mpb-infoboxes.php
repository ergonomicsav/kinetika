<?php
/** Info Boxes **/
if(!class_exists('em_infoboxes')) {
		class em_infoboxes extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-frame',
				'pb_block_icon_color' => '#3D9970',
				'name' => __('Info Boxes','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add an information box with text,image and link','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Lightbox Image/Video
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['infoboxes'] = array(
			    'no_preview' => true,
			    'shortcode_desc' => __('Add Information columns. You can add multiple information items from this generator as well as sort them before adding to contents editor.', 'mthemelocal'),
			    'shortcode' => '[infobox_item image="{{image}}" title="{{title}}" link="{{link}}" linktext="{{linktext}}" last_item="builder"] {{content}} [/infobox_item]',
			    'popup_title' => __('Generate Info boxes Shortcode', 'mthemelocal'),
		        'params' => array(
		            'title' => array(
		                'std' => __('Title of the info box','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Service Title', 'mthemelocal'),
		                'desc' => __('Title of the info box', 'mthemelocal'),
		            ),
		            'image' => array(
		                'std' => '',
		                'type' => 'uploader',
		                'label' => __('Image URL', 'mthemelocal'),
		                'desc' => __('Image URL', 'mthemelocal'),
		            ),
		            'link' => array(
		                'std' => '',
		                'type' => 'text',
		                'label' => __('Link', 'mthemelocal'),
		                'desc' => __('Link to title', 'mthemelocal'),
		            ),
		            'linktext' => array(
		                'std' => '',
		                'type' => 'text',
		                'label' => __('Text for link', 'mthemelocal'),
		                'desc' => __('Text for link', 'mthemelocal'),
		            ),
		            'content' => array(
		                'std' => __('Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.','mthemelocal'),
		                'type' => 'editor',
		                'label' => __('Service Content', 'mthemelocal'),
		                'desc' => __('Add the service content', 'mthemelocal')
		            )
		        )
			);

			$this->the_options = $mtheme_shortcodes['infoboxes'];

			//create the block
			parent::__construct('em_infoboxes', $block_options);
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