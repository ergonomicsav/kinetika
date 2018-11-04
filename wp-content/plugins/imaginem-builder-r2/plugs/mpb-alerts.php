<?php
/** Alerts **/
if(!class_exists('em_alerts')) {
		class em_alerts extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-info',
				'pb_block_icon_color' => '#FF6961',
				'name' => __('Alert','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add an alert message','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Alert Shortcode
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['alert'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Generate alert messages using presets icons or custom icon.', 'mthemelocal'),
				'params' => array(
					'style' => array(
						'type' => 'select',
						'label' => __('Alert Type', 'mthemelocal'),
						'desc' => __('Select alert type', 'mthemelocal'),
						'options' => array(
							'yellow' => __('Yellow','mthemelocal'),
							'red' => __('Red','mthemelocal'),
							'blue' => __('Blue','mthemelocal'),
							'green' => __('Green','mthemelocal')
						)
					),
					'content' => array(
						'std' => __('Alert Message', 'mthemelocal'),
						'textformat' => 'richtext',
						'type' => 'textarea',
						'type' => 'editor',
						'label' => __('Alert Text', 'mthemelocal'),
						'desc' => __('Add the alert\'s text', 'mthemelocal'),
					),
			        'icon' => array(
			            'std' => '',
			            'type' => 'fontawesome-iconpicker',
			            'label' => __('Select icon', 'mthemelocal'),
			            'desc' => __('Select an icon', 'mthemelocal'),
			            'options' => ''
			        )
					
				),
				'shortcode' => '[alert type="{{style}}" icon="{{icon}}"] {{content}} [/alert]',
				'popup_title' => __('Insert Alert', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['alert'];

			//create the block
			parent::__construct('em_alerts', $block_options);
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