<?php
/**
 * Lightbox Carousel
 *
 */
class em_lightboxcarousel extends AQ_Block {
	public function __construct() {
		$block_options = array(
			'pb_block_icon' => 'simpleicon-eye',
			'pb_block_icon_color' => '#E1A43C',
			'name' => __('Lightbox Carousel','mthemelocal'),
			'size' => 'span12',
			'tab' => __('Media','mthemelocal'),
			'desc' => __('Display Carousel with lightboxes','mthemelocal')
		);

		$mtheme_shortcodes['lightboxcarousel'] = array(
			'no_preview' => true,
			'shortcode_desc' => __('Generate a Thumbnail grid using image attachments', 'mthemelocal'),
			'params' => array(
				'columns' => array(
					'type' => 'select',
					'label' => __('Grid Columns', 'mthemelocal'),
					'desc' => __('No. of Grid Columns', 'mthemelocal'),
					'options' => array(
						'4' => '4',
						'3' => '3',
						'2' => '2',
						'1' => '1'
					)
				),
				'boxtitle' => array(
					'type' => 'select',
					'label' => __('Box Title', 'mthemelocal'),
					'desc' => __('Display title inside box on hover', 'mthemelocal'),
					'options' => array(
						'true' => __('Yes','mthemelocal'),
						'false' => __('No','mthemelocal')
					)
				),
				'format' => array(
					'type' => 'select',
					'label' => __('Image orientation format', 'mthemelocal'),
					'desc' => __('Image orientation format', 'mthemelocal'),
					'options' => array(
						'landscape' => __('Landscape','mthemelocal'),
						'portrait' => __('Portrait','mthemelocal')
					)
				),
				'pb_image_ids' => array(
					'type' => 'images',
					'label' => __('Add images', 'mthemelocal'),
					'desc' => __('Add images', 'mthemelocal'),
				),
			),
			'shortcode' => '[lightboxcarousel pb_image_ids="{{pb_image_ids}}" columns="{{columns}}" format="{{format}}" boxtitle="{{boxtitle}}"]',
			'popup_title' => __('Insert Lightbox carousel', 'mthemelocal')
		);

		$this->the_options = $mtheme_shortcodes['lightboxcarousel'];

		parent::__construct('em_lightboxcarousel', $block_options);
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
		wp_enqueue_script ('owlcarousel');
		$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
		//echo $shortcode;
		mtheme_process_shortcode($shortcode,$encode=true);
	}

	protected function set_defaults($instance) {
		return wp_parse_args( $instance, array('ids' => array(), 'layout' => 'layout1') );
	}
}