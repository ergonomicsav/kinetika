<?php
/** Lightbox **/
if(!class_exists('em_lightbox')) {
		class em_lightbox extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-size-fullscreen',
				'pb_block_icon_color' => '#77DD77',
				'name' => __('Lightbox','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Add an Image Lightbox','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Lightbox Image/Video
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['lightbox'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display lightboxes', 'mthemelocal'),
				'params' => array(
					'title' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Lightbox image title', 'mthemelocal'),
						'desc' => __('Lightbox image title', 'mthemelocal'),
					),
					'lightbox_url' => array(
						'std' => '',
						'type' => 'uploader',
						'label' => __('Lightbox image', 'mthemelocal'),
						'desc' => __('Lightbox image. Entering a Video url will disable image lightbox and display video instead.', 'mthemelocal')
					),
					'lightbox_video_url' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Lightbox video url', 'mthemelocal'),
						'desc' => __('Lightbox video. Enter a youtube or vimeo video url here for videos. eg: <code>http://www.youtube.com/watch?v=D78TYCEG4 , http://vimeo.com/172881</code>', 'mthemelocal')
					),
					'thumbnail_url' => array(
						'std' => '',
						'type' => 'uploader',
						'label' => __('Thumbnail image', 'mthemelocal'),
						'desc' => __('Thumbnail image', 'mthemelocal')
					),
					'align' => array(
						'type' => 'select',
						'label' => __('Image Alignment', 'mthemelocal'),
						'desc' => __('Alignment of image', 'mthemelocal'),
						'options' => array(
							'left' => __('left','mthemelocal'),
							'right' => __('right','mthemelocal'),
							'center' => __('center','mthemelocal')
						)
					)
					
				),
				'shortcode' => '[lightbox title="{{title}}" lightbox_video_url={{lightbox_video_url}} lightbox_url="{{lightbox_url}}" thumbnail_url="{{thumbnail_url}}" align="{{align}}"]',
				'popup_title' => __('Insert Lightbox', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['lightbox'];

			//create the block
			parent::__construct('em_lightbox', $block_options);
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