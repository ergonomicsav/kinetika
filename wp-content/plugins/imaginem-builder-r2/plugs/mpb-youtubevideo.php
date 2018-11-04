<?php
/** Display a youtube video **/
if(!class_exists('em_youtubevideo')) {
		class em_youtubevideo extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-youtube-play',
				'pb_block_icon_color' => '#966FD6',
				'name' => __('Youtube Video','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Youtube video','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Display a video
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['pb_youtubevideo'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a Youtube video', 'mthemelocal'),
				'params' => array(
			        'id' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Youtube Video ID', 'mthemelocal'),
			            'desc' => __('eg: <code>MIreKV3QaGv</code> in http://www.youtube.com/MIreKV3QaGv', 'mthemelocal'),
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
					'rel' => array(
						'type' => 'select',
						'label' => __('Related videos', 'mthemelocal'),
						'desc' => __('Related videos', 'mthemelocal'),
						'options' => array(
							'1' => __('True','mthemelocal'),
							'0' => __('False','mthemelocal')
						)
					),
				),
				'shortcode' => '[pb_youtubevideo id="{{id}}" width="{{width}}" height="{{height}}" autoplay="{{autoplay}}" rel="{{rel}}"]',
				'popup_title' => __('Add a Youtube Video', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['pb_youtubevideo'];

			//create the block
			parent::__construct('em_youtubevideo', $block_options);
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