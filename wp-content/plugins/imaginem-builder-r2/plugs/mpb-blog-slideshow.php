<?php
/** Blog Slideshow **/
if(!class_exists('em_blog_slideshow')) {
		class em_blog_slideshow extends AQ_Block {

		protected $the_options;
		protected $portfolio_tax;

		function init_reg() {

			$cat_slugs = array();
			$blog_cat_slugs_obj = get_categories();
			if ($blog_cat_slugs_obj) {
				foreach ($blog_cat_slugs_obj as $category) {
					$cat_slugs[$category->slug] = $category->slug;
				}
			} else {
				$cat_slugs[0]="Blog Categories not found.";
			}
			$this->category_store($cat_slugs);

		}

		function category_store($cat_slugs) {
			$this->the_options['category_list'] = $cat_slugs;
		}

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-screen-desktop',
				'pb_block_icon_color' => '#FF851B',
				'name' => __('Blog post Slideshow','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Posts','mthemelocal'),
				'desc' => __('Display a slideshow of blog posts','mthemelocal')
			);
			add_action('init', array(&$this, 'init_reg'));

			/*-----------------------------------------------------------------------------------*/
			/*	Recent Blog Slideshow
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['recent_blog_slideshow'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add a slideshow of blog posts', 'mthemelocal'),
				'params' => array(
			        'limit' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Limit posts', 'mthemelocal'),
			            'desc' => __('Limit the number of posts', 'mthemelocal'),
			        ),
					'cat_slugs' => array(
						'type' => 'category_list',
						'std' => '',
						'label' => __('Enter category slugs to list', 'mthemelocal'),
						'desc' => __('Leave blank to list all. Enter comma seperated blog categories. eg. artwork,photography,prints ', 'mthemelocal'),
						'options' => ''
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
					'transition' => array(
						'type' => 'select',
						'label' => __('Slideshow transition', 'mthemelocal'),
						'desc' => __('Slideshow transition', 'mthemelocal'),
						'options' => array(
							'fade' => __('fade','mthemelocal'),
							'slide' => __('slide','mthemelocal')
						)
					)
				),
				'shortcode' => '[recent_blog_slideshow autoplay="{{autoplay}}" limit="{{limit}}" cat_slugs="{{cat_slugs}}" transition="{{transition}}"]',
				'popup_title' => __('Add a slideshow of blog posts', 'mthemelocal')
			);
			$this->the_options = $mtheme_shortcodes['recent_blog_slideshow'];

			//create the block
			parent::__construct('em_blog_slideshow', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_Block'));
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);

			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel_css');

			$shortcode = mtheme_dispay_build($this->the_options,$block_id,$instance);

			mtheme_process_shortcode($shortcode,$encode=true);
			
		}
		public function admin_enqueue_Block(){
			//Any script registers go here
		}

	}
}