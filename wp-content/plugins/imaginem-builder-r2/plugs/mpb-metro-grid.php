<?php
/**
 * Metro
 *
 */
class em_metro extends AQ_Block {
	public function __construct() {
		$block_options = array(
			'pb_block_icon' => 'simpleicon-grid',
			'pb_block_icon_color' => '#E1A43C',
			'name' => __('Metro Grid','mthemelocal'),
			'size' => 'span12',
			'tab' => __('Media','mthemelocal'),
			'desc' => __('Display Metro Grid','mthemelocal')
		);

		$mtheme_shortcodes['metrogrid'] = array(
			'no_preview' => true,
			'shortcode_desc' => __('Generate a Metro grid using image attachments', 'mthemelocal'),
			'params' => array(
				'animated' => array(
					'type' => 'select',
					'label' => __('On scroll animated', 'mthemelocal'),
					'desc' => __('Display animated images while scrolling', 'mthemelocal'),
					'options' => array(
						'false' => __('No','mthemelocal'),
						'true' => __('Yes','mthemelocal')
					)
				),
				'pb_image_ids' => array(
					'type' => 'images',
					'label' => __('Add images', 'mthemelocal'),
					'desc' => __('Add images', 'mthemelocal'),
				),
			),
			'shortcode' => '[metrogrid edgetoedge="true" animated="{{animated}}" pb_image_ids="{{pb_image_ids}}"]',
			'popup_title' => __('Insert Metro Shortcode', 'mthemelocal')
		);

		$this->the_options = $mtheme_shortcodes['metrogrid'];

		parent::__construct('em_metro', $block_options);
	}

	public function form( $instance ) {
		$instance = $this->set_defaults($instance);
		$this->admin_enqueue();

		echo mtheme_generate_builder_form($this->the_options,$instance);
		?>
		
		<?php
	}

	protected function admin_enqueue() {
	}

	protected function wp_enqueue() {

	}

	public function block( $instance ) {
		extract($instance);

		wp_enqueue_script ('isotope');

		$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
		//echo $shortcode;
		mtheme_process_shortcode($shortcode,$encode=true);
	}

	protected function set_defaults($instance) {
		return wp_parse_args( $instance, array('ids' => array(), 'layout' => 'layout1') );
	}
}