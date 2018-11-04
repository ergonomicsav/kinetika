<?php
/** Counter **/
if(!class_exists('em_fromtocounter')) {
		class em_fromtocounter extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-reload',
				'pb_block_icon_color' => '#3D9970',
				'name' => __('From-To Counter','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add From to Counter','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	From to Counter
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['count'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add From-To Count blocks', 'mthemelocal'),
				'params' => array(
			        'title' => array(
			            'std' => __('Fusce Magna Elit','mthemelocal'),
			            'type' => 'text',
			            'label' => __('Title', 'mthemelocal'),
			            'desc' => __('Title', 'mthemelocal'),
			        ),
			        'description' => array(
			            'std' => __('Count description text','mthemelocal'),
			            'type' => 'text',
			            'label' => __('Description', 'mthemelocal'),
			            'desc' => __('Description', 'mthemelocal'),
			        ),
			        'to' => array(
			            'std' => '9',
			            'type' => 'text',
			            'label' => __('Count to', 'mthemelocal'),
			            'desc' => __('Count to', 'mthemelocal'),
			        ),
					'icon' => array(
						'std' => 'et-icon-alarmclockr',
						'type' => 'fontawesome-iconpicker',
						'label' => __('Select Icon', 'mthemelocal'),
						'desc' => __('Click an icon to select, click again to deselect', 'mthemelocal'),
						'options' => ''
					),
					'iconcolor' => array(
						'std' => '',
						'type' => 'color',
						'label' => __('Icon Color', 'mthemelocal'),
						'desc' => __('Leave blank for default', 'mthemelocal')
					)
				),
				'shortcode' => '[count title="{{title}}" icon="{{icon}}" iconcolor="{{iconcolor}}" from="{{from}}" to="{{to}}" decimal_places="{{decimal_places}}"]{{description}}[/count]',
				'popup_title' => __( 'From-To Count Shortcode', 'mthemelocal' )
			);


			$this->the_options = $mtheme_shortcodes['count'];

			//create the block
			parent::__construct('em_fromtocounter', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_em_fromtocounter'));
			add_action('wp_enqueue_scripts', array($this, 'mtheme_enqueue_em_fromtocounter'));
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('counter');
			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function mtheme_enqueue_em_fromtocounter(){
			//Any script registers go here
		}

	}
}