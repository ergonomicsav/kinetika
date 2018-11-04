<?php
/** Single Image **/
if(!class_exists('em_singleimage')) {
		class em_singleimage extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-picture',
				'pb_block_icon_color' => '#966FD6',
				'name' => __('Single Image','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Add an Image','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Drop Caps
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['singleimage'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display an image', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
		            'paddingtop' => array(
		                'std' => '0',
		                'type' => 'text',
		                'label' => __('Top Space', 'mthemelocal'),
		                'desc' => __('Top Space', 'mthemelocal'),
		            ),
		            'paddingbottom' => array(
		                'std' => '0',
		                'type' => 'text',
		                'label' => __('Bottom Space', 'mthemelocal'),
		                'desc' => __('Bottom Space', 'mthemelocal'),
		            ),
		            'link_url' => array(
		                'std' => '',
		                'type' => 'text',
		                'label' => __('Link', 'mthemelocal'),
		                'desc' => __('Link', 'mthemelocal'),
		            ),
					'link_type' => array(
						'type' => 'select',
						'label' => __('Open link in', 'mthemelocal'),
						'desc' => __('Open link in', 'mthemelocal'),
						'options' => array(
							'_self' => __('Same Tab', 'mthemelocal'),
							'_blank' => __('New Tab', 'mthemelocal')
						)
					),
		            'image' => array(
		                'std' => '',
		                'type' => 'uploader',
		                'label' => __('Image URL', 'mthemelocal'),
		                'desc' => __('Image URL', 'mthemelocal'),
		            ),
			        'imageid' => array(
			            'std' => '',
			            'type' => 'sleeper',
			            'label' => __('Image ID', 'mthemelocal'),
			            'desc' => __('Image ID', 'mthemelocal'),
			        ),
					'align' => array(
						'type' => 'select',
						'label' => __('Align image', 'mthemelocal'),
						'desc' => __('Align image', 'mthemelocal'),
						'options' => array(
							'left' => __('Left','mthemelocal'),
							'center' => __('Center','mthemelocal'),
							'right' => __('Right','mthemelocal'),
							'fullwidth' => __('Fullwidth','mthemelocal')
						)
					)
					
				),
				'shortcode' => '[singleimage animated={{animated}} link_url="{{link_url}}" link_type="{{link_type}}" paddingtop="{{paddingtop}}" paddingbottom={{paddingbottom}} imageid="{{imageid}}" align="{{align}}" image="{{image}}"]',
				'popup_title' => __('Insert an image', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['singleimage'];

			//create the block
			parent::__construct('em_singleimage', $block_options);
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