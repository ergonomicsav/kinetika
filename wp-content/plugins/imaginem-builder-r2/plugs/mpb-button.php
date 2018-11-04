<?php
/** Button **/
if(!class_exists('em_button')) {
		class em_button extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-hand-o-up',
				'pb_block_icon_color' => '#FF6961',
				'name' => __('Button','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Generate a button','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Button Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['button'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add button.', 'mthemelocal'),
				'params' => array(
					'link' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Button URL', 'mthemelocal'),
						'desc' => __('Add the button\'s url eg http://example.com', 'mthemelocal')
					),
					'button_align' => array(
						'type' => 'select',
						'label' => __('Button Align', 'mthemelocal'),
						'desc' => __('Button alignment', 'mthemelocal'),
						'options' => array(
							'left' => __('Left','mthemelocal'),
							'center' => __('Center','mthemelocal'),
							'right' => __('Right','mthemelocal')
						)
					),
					'button_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Button color', 'mthemelocal'),
						'desc' => __('Button color', 'mthemelocal')
					),
					'button_icon' => array(
						'std' => '',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Select icon', 'mthemelocal'),
			            'desc' => __('Select an icon', 'mthemelocal'),
			            'options' => ''
					),
					'target' => array(
						'type' => 'select',
						'label' => __('Button Target', 'mthemelocal'),
						'desc' => __('_self = open in same window. _blank = open in new window', 'mthemelocal'),
						'options' => array(
							'_self' => '_self',
							'_blank' => '_blank'
						)
					),
					'content' => array(
						'std' => __('Button Text','mthemelocal'),
						'type' => 'text',
						'label' => __('Button Text', 'mthemelocal'),
						'desc' => __('Add the button text', 'mthemelocal'),
					)
				),
				'shortcode' => '[button link="{{link}}" button_align="{{button_align}}" button_color="{{button_color}}" button_icon="{{button_icon}}" target="{{target}}"] {{content}} [/button]',
				'popup_title' => __('Insert Button', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['button'];

			//create the block
			parent::__construct('em_button', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_fontawesomeBlock'));
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
		public function admin_enqueue_fontawesomeBlock(){
			//Any script registers go here
		}

	}
}