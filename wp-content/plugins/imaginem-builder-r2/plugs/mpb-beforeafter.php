<?php
/** Before After **/
if(!class_exists('em_beforeafter')) {
		class em_beforeafter extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-hourglass',
				'pb_block_icon_color' => '#39CCCC',
				'name' => __('Before After Image','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Before and After block using two images','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Lightbox Image/Video
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['beforeafter'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display Before and After Image blcok', 'mthemelocal'),
				'params' => array(
					'url1' => array(
						'std' => '',
						'type' => 'uploader',
						'label' => __('Choose image to appear as before', 'mthemelocal'),
						'desc' => __('Before image', 'mthemelocal')
					),
					'url2' => array(
						'std' => '',
						'type' => 'uploader',
						'label' => __('Choose image to appear as after', 'mthemelocal'),
						'desc' => __('After image', 'mthemelocal')
					)
					
				),
				'shortcode' => '[beforeafter url1="{{url1}}" url2="{{url2}}"]',
				'popup_title' => __('Insert Before and After', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['beforeafter'];

			//create the block
			parent::__construct('em_beforeafter', $block_options);
			// Any script registers need to uncomment following line
			//add_action('wp_enqueue_scripts', array($this, 'beforeafter_enqueue_scripts'));
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('BeforeAfterMoveJS');
			wp_enqueue_script ('BeforeAfterJS');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function beforeafter_enqueue_scripts(){
			//Any script registers go here
		}

	}
}