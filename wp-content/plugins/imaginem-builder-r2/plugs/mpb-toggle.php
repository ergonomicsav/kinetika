<?php
/** Toggle **/
if(!class_exists('em_toggle')) {
		class em_toggle extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-toggle-off',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Toggle','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Toggle','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['toggle'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add toggle shortcode.', 'mthemelocal'),
				'params' => array(
					'title' => array(
						'type' => 'text',
						'label' => __('Toggle Content Title', 'mthemelocal'),
						'desc' => __('Add the title that will go above the toggle content', 'mthemelocal'),
						'std' => __('Title','mthemelocal')
					),
					'content' => array(
						'std' => 'Content',
						'type' => 'editor',
						'label' => __('Toggle Content', 'mthemelocal'),
						'desc' => __('Add the toggle content.', 'mthemelocal'),
					),
					'state' => array(
						'type' => 'select',
						'label' => __('Toggle State', 'mthemelocal'),
						'desc' => __('Select the state of the toggle on page load', 'mthemelocal'),
						'options' => array(
							'open' => __('Open','mthemelocal'),
							'closed' => __('Closed','mthemelocal')
						)
					),
					
				),
				'shortcode' => '[toggle title="{{title}}" state="{{state}}"] {{content}} [/toggle]',
				'popup_title' => __('Insert Toggle Content Shortcode', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['toggle'];

			//create the block
			parent::__construct('em_toggle', $block_options);
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