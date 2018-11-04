<?php
/** FontAwesome **/
if(!class_exists('em_fontawesome')) {
		class em_fontawesome extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-flag',
				'pb_block_icon_color' => '#39CCCC',
				'name' => __('Icon Generator','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add an icon from a selectable set','mthemelocal')
			);

			$mtheme_shortcodes['fontawesome'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Fontawesome icons', 'mthemelocal'),
				'params' => array(
					'icon' => array(
						'std' => 'feather-icon-disc',
						'type' => 'fontawesome-iconpicker',
						'label' => __('Select Icon', 'mthemelocal'),
						'desc' => __('Click an icon to select', 'mthemelocal'),
						'options' => ''
					),
					'align' => array(
						'std' => 'no',
						'type' => 'select',
						'label' => __('Icon in Circle', 'mthemelocal'),
						'desc' => __('Choose to display the icon in a circle','mthemelocal'),
						'options' => array(
							'default' => __('default','mthemelocal'),
							'right' => __('Right','mthemelocal'),
							'center' => __('Center','mthemelocal')
						)
					),
					'size' => array(
						'std' => '24',
						'type' => 'text',
						'label' => __('Size of Icon', 'mthemelocal'),
						'desc' => __('Select the size of the icon','mthemelocal')
					),
					'iconcolor' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Icon Color', 'mthemelocal'),
						'desc' => __('Leave blank for default', 'mthemelocal')
					)
				),
				'shortcode' => '[icongenerator align="{{align}}" icon="{{icon}}" size="{{size}}" iconcolor="{{iconcolor}}"]',
				'popup_title' => __( 'icongenerator Shortcode', 'mthemelocal' )
			);

			$this->the_options = $mtheme_shortcodes['fontawesome'];

			//create the block
			parent::__construct('em_fontawesome', $block_options);
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

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_fontawesomeBlock(){
			//Any script registers go here
		}

	}
}