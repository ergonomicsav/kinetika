<?php
/** Callout **/
if(!class_exists('em_callout')) {
		class em_callout extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-bell',
				'pb_block_icon_color' => '#F49AC2',
				'name' => __('Callout Box','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Display a call to action message','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Call Out
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['callout'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Callout box.', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
			        'title' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Title', 'mthemelocal'),
			            'desc' => __('Title for Callout box', 'mthemelocal'),
			        ),
			        'content' => array(
			            'std' => '',
			            'textformat' => 'richtext',
			            'type' => 'editor',
			            'label' => __('Text for Callout', 'mthemelocal'),
			            'desc' => __('Text for Callout', 'mthemelocal'),
			        ),
			        'button_icon' => array(
			            'std' => '',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Select icon', 'mthemelocal'),
			            'desc' => __('Select an icon', 'mthemelocal'),
			        ),
			        'button_color' => array(
			            'std' => '',
			            'type' => 'color',
			            'label' => __('Button color', 'mthemelocal'),
			            'desc' => __('Button color', 'mthemelocal'),
			        ),
			        'button_text' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button Text', 'mthemelocal'),
			            'desc' => __('Button Text', 'mthemelocal'),
			        ),
			        'button_link' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button Link', 'mthemelocal'),
			            'desc' => __('Button Link', 'mthemelocal'),
			        ),
				),
				'shortcode' => '[callout animated="{{animated}}" title="{{title}}" description="{{content}}" button_icon="{{button_icon}}" button_color="{{button_color}}" button_link="{{button_link}}" button_text="{{button_text}}" button_link="{{button_link}}"]',
				'popup_title' => __('Insert Callout Box', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['callout'];

			//create the block
			parent::__construct('em_callout', $block_options);
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