<?php
/** Divider **/
if(!class_exists('em_hline')) {
		class em_hline extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-arrows-h',
				'pb_block_icon_color' => '#9c9c9c',
				'name' => __('Horizontal Line','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Layout','mthemelocal'),
				'desc' => __('Add a horizontal line','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Horizontal Line
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['hline'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display a horizontal line.', 'mthemelocal'),
				'params' => array(
					'style' => array(
						'type' => 'select',
						'label' => __('Choose Line style', 'mthemelocal'),
						'desc' => __('Choose Line style', 'mthemelocal'),
						'options' => array(
							'single' => __('Single','mthemelocal'),
							'double' => __('Double','mthemelocal'),
							'dotted' => __('Dotted','mthemelocal'),
							'dashed' => __('Dashed','mthemelocal')
						)
					),
					'linecolor' => array(
						'std' => '#EC3939',
						'type' => 'color',
						'label' => __('Line color', 'mthemelocal'),
						'desc' => __('Line color', 'mthemelocal'),
					),
			        'height' => array(
			            'std' => '1',
			            'type' => 'text',
			            'label' => __('Height in pixels', 'mthemelocal'),
			            'desc' => __('Height in pixels', 'mthemelocal'),
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
				'shortcode' => '[hline top="{{top}}" linecolor="{{linecolor}}" height={{height}} bottom="{{bottom}}" style="{{style}}"]',
				'popup_title' => __('Add horizontal line', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['hline'];

			//create the block
			parent::__construct('em_hline', $block_options);
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