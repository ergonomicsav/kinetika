<?php
/** Pullquote **/
if(!class_exists('em_pullquote')) {
		class em_pullquote extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'fa fa-quote-left',
				'pb_block_icon_color' => '#77DD77',
				'name' => __('Pullquote','mthemelocal'),
				'size' => 'span6',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Add a Pullquote','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Pullquote
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['pullquote'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Display Pullquotes', 'mthemelocal'),
				'params' => array(
					'animated' => array(
						'type' => 'animated',
						'label' => __('Animation type', 'mthemelocal'),
						'desc' => __('Animation type', 'mthemelocal')
					),
					'content' => array(
						'std' => 'Nunc ligula risus, dignissim eget dolor sed, condimentum scelerisque quam. Nulla id lectus posuere, fermentum elit at, fringilla eros. Vivamus at facilisis leo, id convallis sem. Sed mauris urna, finibus ac lectus vel, condimentum aliquet velit. Donec laoreet rutrum ipsum a commodo. Aenean non venenatis dolor. Mauris in justo fringilla, suscipit lectus in, vehicula ex. Duis molestie quis quam ut sollicitudin. Cras placerat faucibus sapien, sed convallis turpis dapibus ultrices. Praesent porta metus odio, sed venenatis augue tincidunt at.',
						'type' => 'textarea',
						'type' => 'editor',
						'label' => __('Pullquote text', 'mthemelocal'),
						'desc' => __('Pullquote text', 'mthemelocal'),
					),
					'align' => array(
						'type' => 'select',
						'label' => __('Alignment', 'mthemelocal'),
						'desc' => __('Alignment', 'mthemelocal'),
						'options' => array(
							'left' => __('left','mthemelocal'),
							'right' => __('right','mthemelocal'),
							'center' => __('center','mthemelocal')
						)
					)
					
				),
				'shortcode' => '[pullquote animated="{{animated}}" align="{{align}}"]{{content}}[/pullquote]',
				'popup_title' => __('Insert Pullquote', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['pullquote'];

			//create the block
			parent::__construct('em_pullquote', $block_options);
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