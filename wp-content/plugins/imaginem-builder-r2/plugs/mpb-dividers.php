<?php
/** Divider **/
if(!class_exists('em_dividers')) {
		class em_dividers extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-arrows-v',
				'pb_block_icon_color' => '#9c9c9c',
				'name' => __('Dividers','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Layout','mthemelocal'),
				'desc' => __('Add a divider','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Dividers
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['divider'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display Dividers. Blanks and minimal decorations.', 'mthemelocal'),
				'params' => array(
					'style' => array(
						'type' => 'select',
						'label' => __('Choose Divider', 'mthemelocal'),
						'desc' => __('Choose Divider', 'mthemelocal'),
						'options' => array(
							'blank' => __('blank','mthemelocal'),
							'line' => __('line','mthemelocal'),
							'double' => __('double','mthemelocal'),
							'stripes' => __('stripes','mthemelocal'),
							'thinfade' => __('thinfade','mthemelocal'),
							'threelines' => __('threelines','mthemelocal'),
							'circleline' => __('circleline','mthemelocal'),
							'stripedcenter' => __('stripedcenter','mthemelocal'),
							'linedcenter' => __('linedcenter','mthemelocal')
						)
					),
					'type' => array(
						'type' => 'select',
						'label' => __('Divider Type', 'mthemelocal'),
						'desc' => __('Divider Type', 'mthemelocal'),
						'options' => array(
							'default' => __('Default','mthemelocal'),
							'bright' => __('Bright','mthemelocal'),
							'dark' => __('Dark','mthemelocal'),
						)
					),
			        'top' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Top Space in pixels', 'mthemelocal'),
			            'desc' => __('Top Spacing', 'mthemelocal'),
			        ),
			        'bottom' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Bottom Space pixels', 'mthemelocal'),
			            'desc' => __('Bottom Spacing', 'mthemelocal'),
			        )
				),
				'shortcode' => '[divider top="{{top}}" type="{{type}}" bottom="{{bottom}}" style="{{style}}"]',
				'popup_title' => __('Insert Divider', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['divider'];

			//create the block
			parent::__construct('em_dividers', $block_options);
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