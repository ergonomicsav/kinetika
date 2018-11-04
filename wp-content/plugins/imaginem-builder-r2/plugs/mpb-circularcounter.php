<?php
/** Circular Counter **/
if(!class_exists('em_circularcounter')) {
		class em_circularcounter extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-clock',
				'pb_block_icon_color' => '#836953',
				'name' => __('Circular Counter','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Generate Counters based on percentage','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Counter Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['counter'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Generate Counters based on percentage', 'mthemelocal'),
				'params' => array(
					'title' => array(
						'std' => 'Title',
						'type' => 'text',
						'label' => __('Title', 'mthemelocal'),
						'desc' => __('Add the alert\'s text', 'mthemelocal'),
					),
					'percentage' => array(
						'std' => '70',
						'type' => 'text',
						'label' => __('Percentage', 'mthemelocal'),
						'desc' => __('Percentage', 'mthemelocal'),
					),
					'size' => array(
						'std' => '150',
						'type' => 'text',
						'label' => __('Counter Size', 'mthemelocal'),
						'desc' => __('Counter size', 'mthemelocal'),
					),
					'donutwidth' => array(
						'std' => '10',
						'type' => 'text',
						'label' => __('Border Size', 'mthemelocal'),
						'desc' => __('Border size', 'mthemelocal'),
					),
					'textsize' => array(
						'std' => '32',
						'type' => 'text',
						'label' => __('Counter percent text size', 'mthemelocal'),
						'desc' => __('Counter percent text size', 'mthemelocal'),
					),
					'fgcolor' => array(
						'std' => '#EC3939',
						'type' => 'color',
						'label' => __('Foreground Color', 'mthemelocal'),
						'desc' => __('Foreground Color', 'mthemelocal'),
					),
					'bgcolor' => array(
						'std' => '#f0f0f0',
						'type' => 'color',
						'label' => __('Background Color', 'mthemelocal'),
						'desc' => __('Background color', 'mthemelocal'),
					),
					'content' => array(
						'std' => 'Counter Description',
						'type' => 'editor',
						'label' => __('Counter description', 'mthemelocal'),
						'desc' => __('Counter Description', 'mthemelocal'),
					)
					
				),
				'shortcode' => '[counter size="{{size}}" percentage="{{percentage}}" textsize="{{textsize}}" bgcolor="{{bgcolor}}" fgcolor="{{fgcolor}}" donutwidth="{{donutwidth}}" title="{{title}}"]{{content}}[/counter]',
				'popup_title' => __('Insert Counter', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['counter'];

			//create the block
			parent::__construct('em_circularcounter', $block_options);
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

			wp_enqueue_script ('DonutChart');
			
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_fontawesomeBlock(){
			//Any script registers go here
		}

	}
}