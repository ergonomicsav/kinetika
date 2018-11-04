<?php
/** Shortcode **/
if(!class_exists('em_displayshortcode')) {
		class em_displayshortcode extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'block_slug' => 'displayshortcode',
				'pb_block_icon' => 'simpleicon-energy',
				'pb_block_icon_color' => '#0074D9',
				'name' => __('Shortcode','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Use to add shortcodes','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['displayshortcode'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Shortcode', 'mthemelocal'),
				'params' => array(
					'shortcode' => array(
						'std' => __('Content','mthemelocal'),
						'type' => 'textarea',
						'label' => __('Shortcode', 'mthemelocal'),
						'desc' => __('Shortcode to generate', 'mthemelocal'),
					),
					
				),
				'shortcode' => '[displayshortcode shortcode="{{shortcode}}"]',
				'popup_title' => __('Add Shortcode', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['displayshortcode'];

			//create the block
			parent::__construct('em_displayshortcode', $block_options);
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

			$the_shortcode = $instance['mtheme_shortcode'];
			
			mtheme_process_shortcode($the_shortcode,$encode=true);
			
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}