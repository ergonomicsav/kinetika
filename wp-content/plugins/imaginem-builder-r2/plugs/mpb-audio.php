<?php
/** Audio **/
if(!class_exists('em_audio')) {
		class em_audio extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-volume-2',
				'pb_block_icon_color' => '#FF851B',
				'name' => __('Audio','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Generate an HTML5 Audio player','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Audio Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['audioplayer'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add HTML5 Audio Player', 'mthemelocal'),
				'params' => array(
			        'title' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Title of Audio', 'mthemelocal'),
			            'desc' => __('Title of Audio', 'mthemelocal'),
			        ),
			        'mp3' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('MP3 url. File path', 'mthemelocal'),
			            'desc' => __('MP3 url. File path', 'mthemelocal'),
			        ),
			        'm4a' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('M4A url. File path', 'mthemelocal'),
			            'desc' => __('M4A url. File path', 'mthemelocal'),
			        ),
			        'oga' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('OGA url. File path', 'mthemelocal'),
			            'desc' => __('OGA url. File path', 'mthemelocal'),
			        )
				),
				'shortcode' => '[audioplayer mp3="{{mp3}}" m4a="{{m4a}}" oga="{{oga}}" title="{{title}}"]',
				'popup_title' => __('Insert Audio Player', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['audioplayer'];

			//create the block
			parent::__construct('em_audio', $block_options);
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

			wp_enqueue_script ('jPlayerJS');
			wp_enqueue_style ('css_jplayer');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_fontawesomeBlock(){
			//Any script registers go here
		}

	}
}