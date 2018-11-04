<?php
/** Display a youtube video **/
if(!class_exists('em_vimeovideo')) {
		class em_vimeovideo extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-vimeo-square',
				'pb_block_icon_color' => '#966FD6',
				'name' => __('Vimeo Video','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Vimeo video','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Display a video
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['pb_vimeovideo'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a Vimeo video', 'mthemelocal'),
				'params' => array(
			        'id' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Vimeo Video ID', 'mthemelocal'),
			            'desc' => __('eg: <code>123456789</code> in http://vimeo.com/123456789', 'mthemelocal'),
			        ),
			        'width' => array(
			            'std' => '1280',
			            'type' => 'text',
			            'label' => __('Width in pixels', 'mthemelocal'),
			            'desc' => __('Width in pixels', 'mthemelocal'),
			        ),
			        'height' => array(
			            'std' => '720',
			            'type' => 'text',
			            'label' => __('Height in pixels', 'mthemelocal'),
			            'desc' => __('Height in pixels', 'mthemelocal'),
			        ),
					'autoplay' => array(
						'type' => 'select',
						'label' => __('Enable Autoplay', 'mthemelocal'),
						'desc' => __('Enable Autoplay', 'mthemelocal'),
						'options' => array(
							'1' => __('True','mthemelocal'),
							'0' => __('False','mthemelocal')
						)
					),
				),
				'shortcode' => '[pb_vimeovideo id="{{id}}" width="{{width}}" height="{{height}}" autoplay="{{autoplay}}"]',
				'popup_title' => __('Add a Vimeo Video', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['pb_vimeovideo'];

			//create the block
			parent::__construct('em_vimeovideo', $block_options);
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