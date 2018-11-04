<?php
/* Pricing */
if(!class_exists('em_pricingservice')) {
	class em_pricingservice extends AQ_Block {

		protected $the_options;

		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-calculator',
				'pb_block_icon_color' => '#FF851B',
				'name' => __('Pricing Service','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Pricing Service','mthemelocal')
			);
			//create the widget

			/*-----------------------------------------------------------------------------------*/
			/*	Pricing Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['pricing_table'] = array(
			    'params' => array(),
			    'no_preview' => true,
			    'shortcode_desc' => __('Add Pricing shortcode. You can configure the shortcode after adding them.', 'mthemelocal'),
			    'shortcode' => '[pricing_table service="true" columns="1"][pricing_column animated="{{animated}}" title="{{title}}" title_bgcolor="{{title_bgcolor}}" featured="{{featured}}"][pricing_price currency="{{currency}}" price="{{price}}" duration="{{duration}}"] [pricing_service] {{content_richtext}} [/pricing_service] [pricing_footer][button button_color="{{title_bgcolor}}" link="{{link}}" align="center"]{{button_text}}[/button][/pricing_footer][/pricing_column][/pricing_table]',
			    'popup_title' => __('Add Pricing Table', 'mthemelocal'),
			 	'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
		            'title' => array(
		                'std' => __('Standard','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Column Title', 'mthemelocal'),
		                'desc' => __('Column title', 'mthemelocal'),
		            ),
					'title_bgcolor' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Pricing title color', 'mthemelocal'),
						'desc' => __('Pricing title color', 'mthemelocal'),
					),
					'featured' => array(
						'type' => 'select',
						'label' => __('Make Featured', 'mthemelocal'),
						'desc' => __('Make Featured', 'mthemelocal'),
						'options' => array(
							'true' => 'Yes',
							'false' => 'No'
						)
					),
		            'currency' => array(
		                'std' => '$',
		                'type' => 'text',
		                'label' => __('Currency Symbol', 'mthemelocal'),
		                'desc' => __('Enter currency symbol.', 'mthemelocal'),
		            ),
		            'price' => array(
		                'std' => '29.99',
		                'type' => 'text',
		                'label' => __('Price value', 'mthemelocal'),
		                'desc' => __('Enter price value.', 'mthemelocal'),
		            ),
		            'duration' => array(
		                'std' => __('monthly','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Enter duration', 'mthemelocal'),
		                'desc' => __('Enter duration.', 'mthemelocal'),
		            ),
		            'link' => array(
		                'std' => __('Button link','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Button link', 'mthemelocal'),
		                'desc' => __('Button link', 'mthemelocal'),
		            ),
		            'button_text' => array(
		                'std' => __('Button Text','mthemelocal'),
		                'type' => 'text',
		                'label' => __('Button text', 'mthemelocal'),
		                'desc' => __('Button text', 'mthemelocal'),
		            ),
					'content_richtext' => array(
						'std' => __('Content','mthemelocal'),
						'textformat' => 'textarea',
						'type' => 'editor',
						'label' => __('Rich Text', 'mthemelocal'),
						'desc' => __('Add the content', 'mthemelocal'),
					)
				)
			);
			$this->the_options = $mtheme_shortcodes['pricing_table'];

			parent::__construct('em_pricingservice', $block_options);
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
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
