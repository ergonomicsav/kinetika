<?php
/** Section Heading **/
if(!class_exists('em_sectionheading')) {
		class em_sectionheading extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-header',
				'pb_block_icon_color' => '#FF6961',
				'title' => __('Section Heading','mthemelocal'),
				'name' => __('Section Heading','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Display Section Heading','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Heading
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['heading'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display Section Headings', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'title' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Section Heading text', 'mthemelocal'),
						'desc' => __('Section Heading text', 'mthemelocal'),
					),
					'subtitle' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Section subtitle (optional)', 'mthemelocal'),
						'desc' => __('Section Heading text', 'mthemelocal'),
					),
					'align' => array(
						'type' => 'select',
						'label' => __('Align text', 'mthemelocal'),
						'desc' => __('Align text', 'mthemelocal'),
						'options' => array(
							'left' => __('Left','mthemelocal'),
							'center' => __('Center','mthemelocal'),
							'right' => __('Right','mthemelocal')
						)
					),
					'size' => array(
						'type' => 'select',
						'label' => __('Heading size', 'mthemelocal'),
						'desc' => __('Heading size', 'mthemelocal'),
						'options' => array(
							'1' => 'h1',
							'2' => 'h2',
							'3' => 'h3',
							'4' => 'h4',
							'5' => 'h5',
							'6' => 'h6'
						)
					),
					'content_richtext' => array(
						'std' => '',
						'textformat' => 'richtext',
						'type' => 'editor',
						'label' => __('Content', 'mthemelocal'),
						'desc' => __('Add content', 'mthemelocal'),
					),
			        'button' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button Text', 'mthemelocal'),
			            'desc' => __('Button Text', 'mthemelocal'),
			        ),
			        'button_link' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button link', 'mthemelocal'),
			            'desc' => __('Button link', 'mthemelocal'),
			        ),
			        'width' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Width in percent', 'mthemelocal'),
			            'desc' => __('Width in percent', 'mthemelocal'),
			        ),
			        'top' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Padding Top in pixels', 'mthemelocal'),
			            'desc' => __('Top Spacing', 'mthemelocal'),
			        ),
			        'bottom' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Padding bottom pixels', 'mthemelocal'),
			            'desc' => __('Bottom Spacing', 'mthemelocal'),
			        ),
			        'marginbottom' => array(
			            'std' => '60',
			            'type' => 'text',
			            'label' => __('Margin bottom pixels', 'mthemelocal'),
			            'desc' => __('Margin Bottom Spacing', 'mthemelocal'),
			        )
				),
				'shortcode' => '[heading animated={{animated}} marginbottom="{{marginbottom}}" width="{{width}}" content_richtext="{{content_richtext}}" button="{{button}}" button_link="{{button_link}}" top="{{top}}" bottom="{{bottom}}" size="{{size}}" title="{{title}}" subtitle="{{subtitle}}" align="{{align}}"]',
				'popup_title' => __('Insert Section Heading', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['heading'];

			//create the block
			parent::__construct('em_sectionheading', $block_options);
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