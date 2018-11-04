<?php
/** Richtext **/
if(!class_exists('em_textbox')) {
		class em_textbox extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'feather-icon-marquee',
				'pb_block_icon_color' => '#E1A43C',
				'name' => __('Textbox Box','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Textbox','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['textbox'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Content', 'mthemelocal'),
				'params' => array(
					'background_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Background color', 'mthemelocal'),
						'desc' => __('Background color', 'mthemelocal'),
					),
					'text_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Text color', 'mthemelocal'),
						'desc' => __('Text color', 'mthemelocal'),
					),
					'border_style' => array(
						'type' => 'select',
						'label' => __('Choose Border style', 'mthemelocal'),
						'desc' => __('Choose Border style', 'mthemelocal'),
						'options' => array(
							'solid' => __('Solid','mthemelocal'),
							'double' => __('Double','mthemelocal'),
							'dotted' => __('Dotted','mthemelocal'),
							'dashed' => __('Dashed','mthemelocal')
						)
					),
					'border_size' => array(
						'std' => '1',
						'type' => 'text',
						'label' => __('Border size', 'mthemelocal'),
						'desc' => __('Note: Double style borders need size 3 onwards', 'mthemelocal'),
					),
					'border_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Border color', 'mthemelocal'),
						'desc' => __('Border color', 'mthemelocal'),
					),
					'margin_top' => array(
						'std' => '0',
						'type' => 'text',
						'label' => __('Margin top in pixels', 'mthemelocal'),
						'desc' => __('Margin top in pixels', 'mthemelocal')
					),
					'margin_bottom' => array(
						'std' => '0',
						'type' => 'text',
						'label' => __('Margin bottom in pixels', 'mthemelocal'),
						'desc' => __('Margin bottom in pixels', 'mthemelocal')
					),
					'margin_sides' => array(
						'std' => '0',
						'type' => 'text',
						'label' => __('Margin sides in pixels', 'mthemelocal'),
						'desc' => __('Margin sides in pixels', 'mthemelocal')
					),
					'padding_top' => array(
						'std' => '0',
						'type' => 'text',
						'label' => __('Padding top in pixels', 'mthemelocal'),
						'desc' => __('Padding top in pixels', 'mthemelocal')
					),
					'padding_bottom' => array(
						'std' => '0',
						'type' => 'text',
						'label' => __('Padding bottom in pixels', 'mthemelocal'),
						'desc' => __('Padding bottom in pixels', 'mthemelocal')
					),
					'padding_sides' => array(
						'std' => '0',
						'type' => 'text',
						'label' => __('Padding sides in pixels', 'mthemelocal'),
						'desc' => __('Padding sides in pixels', 'mthemelocal')
					),
					'content_richtext' => array(
						'std' => __('Content','mthemelocal'),
						'textformat' => 'textarea',
						'type' => 'editor',
						'label' => __('Rich Text', 'mthemelocal'),
						'desc' => __('Add the content', 'mthemelocal'),
					),
					
				),
				'shortcode' => '[textbox border_size={{border_size}} border_style={{border_style}} border_color={{border_color}} background_color="{{background_color}}" text_color="{{text_color}}" padding_sides="{{padding_sides}}" padding_top="{{padding_top}}" padding_bottom="{{padding_bottom}}" margin_sides="{{margin_sides}}" margin_top="{{margin_top}}" margin_bottom="{{margin_bottom}}"]{{content_richtext}}[/textbox]',
				'popup_title' => __('Add Textbox', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['textbox'];

			//create the block
			parent::__construct('em_textbox', $block_options);
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