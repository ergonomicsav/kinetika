<?php
/** Display Content **/
if(!class_exists('em_displaycontent')) {
		class em_displaycontent extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-pencil',
				'pb_block_icon_color' => '#AAAAAA',
				'name' => __('Page Content','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add Page Content','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['pagecontent'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Content', 'mthemelocal'),
				'params' => array(
					'content' => array(
						'std' => __('Content','mthemelocal'),
						'type' => 'notice',
						'label' => __('Add Content', 'mthemelocal'),
						'desc' => __('Displays current page contents. No settings required for this block.', 'mthemelocal'),
					),
					
				),
				'shortcode' => '[pagecontent]',
				'popup_title' => __('Add Content', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['pagecontent'];

			//create the block
			parent::__construct('em_displaycontent', $block_options);
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