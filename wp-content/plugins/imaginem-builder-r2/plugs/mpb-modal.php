<?php
/** Button **/
if(!class_exists('em_modal')) {
		class em_modal extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'feather-icon-stack-2',
				'pb_block_icon_color' => '#FF6961',
				'name' => __('Modal','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Modal Popup window','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Button Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['modalwindow'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add button.', 'mthemelocal'),
				'params' => array(
					'modal_id' => array(
						'std' => 'modalid1',
						'type' => 'text',
						'label' => __('Modal ID ( unqiue )', 'mthemelocal'),
						'desc' => __('Modal ID - has to be a unique name.', 'mthemelocal')
					),
					'link' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Button URL', 'mthemelocal'),
						'desc' => __('Add the button\'s url eg http://example.com', 'mthemelocal')
					),
					'button_align' => array(
						'type' => 'select',
						'label' => __('Button Align', 'mthemelocal'),
						'desc' => __('Button alignment', 'mthemelocal'),
						'options' => array(
							'left' => __('Left','mthemelocal'),
							'center' => __('Center','mthemelocal'),
							'right' => __('Right','mthemelocal')
						)
					),
					'button_color' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Button color', 'mthemelocal'),
						'desc' => __('Button color', 'mthemelocal')
					),
					'button_icon' => array(
						'std' => '',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Select icon', 'mthemelocal'),
			            'desc' => __('Select an icon', 'mthemelocal'),
			            'options' => ''
					),
					'buttontext' => array(
						'std' => __('Button Text','mthemelocal'),
						'type' => 'text',
						'label' => __('Button\'s Text', 'mthemelocal'),
						'desc' => __('Add the button\'s text', 'mthemelocal'),
					),
			        'content_richtext' => array(
			            'std' => '',
			            'textformat' => 'richtext',
			            'type' => 'editor',
			            'label' => __('Modal contents', 'mthemelocal'),
			            'desc' => __('Modal contents', 'mthemelocal'),
			        )
				),
				'shortcode' => '[modalwindow modal_id="{{modal_id}}" link="{{link}}" buttontext="{{buttontext}}" button_align="{{button_align}}" button_color="{{button_color}}" button_icon="{{button_icon}}"] {{content_richtext}} [/modalwindow]',
				'popup_title' => __('Add Modal', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['modalwindow'];

			//create the block
			parent::__construct('em_modal', $block_options);
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			if( has_shortcode( $shortcode, 'accordion' ) ) {
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-accordion');
			}
			if( has_shortcode( $shortcode, 'tabs' ) ) {
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-tabs');
			}
			echo do_shortcode($shortcode);
			
		}
		public function admin_enqueue_fontawesomeBlock(){
			//Any script registers go here
		}

	}
}