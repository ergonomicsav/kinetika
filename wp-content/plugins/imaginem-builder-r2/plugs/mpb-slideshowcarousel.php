<?php
/**
 * Slideshowcarousel
 *
 */
if(!class_exists('em_slideshowcarousel')) {
	class em_slideshowcarousel extends AQ_Block {
		public function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-screen-desktop',
				'pb_block_icon_color' => '#836953',
				'name' => __('Slideshow','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Media','mthemelocal'),
				'desc' => __('Add a Slideshow Carousel','mthemelocal')
			);

			$mtheme_shortcodes['slideshowcarousel'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Generate a Slideshow', 'mthemelocal'),
				'params' => array(
					'pb_image_ids' => array(
						'type' => 'images',
						'label' => __('Add images', 'mthemelocal'),
						'desc' => __('Add images', 'mthemelocal'),
					),
					'thumbnails' => array(
						'type' => 'select',
						'label' => __('Dispay thumbnails', 'mthemelocal'),
						'desc' => __('Display thumbnails', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					),
					'autoplay' => array(
						'type' => 'select',
						'std' => 'false',
						'label' => __('Autoplay slideshow', 'mthemelocal'),
						'desc' => __('Autoplay slideshow', 'mthemelocal'),
						'options' => array(
							'false' => __('No','mthemelocal'),
							'true' => __('Yes','mthemelocal')
						)
					),
					'displaytitle' => array(
						'type' => 'select',
						'std' => 'false',
						'label' => __('Dispay title', 'mthemelocal'),
						'desc' => __('Display thumbnails', 'mthemelocal'),
						'options' => array(
							'true' => __('Yes','mthemelocal'),
							'false' => __('No','mthemelocal')
						)
					)
				),
				'shortcode' => '[slideshowcarousel lightbox="false" autoplay="{{autoplay}}" displaytitle="{{displaytitle}}" thumbnails="{{thumbnails}}" pb_image_ids="{{pb_image_ids}}"]',
				'popup_title' => __('Insert Slideshow', 'mthemelocal')
			);

			$this->the_options = $mtheme_shortcodes['slideshowcarousel'];

			parent::__construct('em_slideshowcarousel', $block_options);
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
			wp_enqueue_style ('owlcarousel_css');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);
			//echo $shortcode;
			mtheme_process_shortcode($shortcode,$encode=true);
		}

		protected function set_defaults($instance) {
			return wp_parse_args( $instance, array('ids' => array(), 'layout' => 'layout1') );
		}
	}
}