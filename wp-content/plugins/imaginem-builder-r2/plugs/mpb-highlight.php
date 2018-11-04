<?php
/** Highlight **/
if(!class_exists('em_highlight')) {
		class em_highlight extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-pencil',
				'pb_block_icon_color' => '#77DD77',
				'name' => __('Highlight','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add highlight','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Highlight Text
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['highlight'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Highlight texts', 'mthemelocal'),
				'params' => array(
					'content' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Text to hightlight', 'mthemelocal'),
						'desc' => __('Text to hightlight', 'mthemelocal'),
					)
					
				),
				'shortcode' => '[highlight]{{content}}[/highlight]',
				'popup_title' => __('Insert Highlighted text', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['highlight'];

			//create the block
			parent::__construct('em_highlight', $block_options);
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