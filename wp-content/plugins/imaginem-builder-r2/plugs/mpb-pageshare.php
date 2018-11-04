<?php
if(!class_exists('em_pageshare')) {
		class em_pageshare extends AQ_Block {

		protected $the_options;

		//set and create block
		function __construct() {
			$block_options = array(
				'pb_block_icon' => 'simpleicon-share-alt',
				'pb_block_icon_color' => '#F49AC2',
				'name' => __('Page Share','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Elements','mthemelocal'),
				'desc' => __('Generate Pageshare social icons','mthemelocal')
			);

			/*-----------------------------------------------------------------------------------*/
			/*	Toggle Config
			/*-----------------------------------------------------------------------------------*/

			$mtheme_shortcodes['pageshare'] = array(
				'no_preview' => true,
				'shortcode_desc' => __('Add Content', 'mthemelocal'),
				'params' => array(
		            'facebook' => array(
		                'std' => 'facebook',
		                'type' => 'checkbox',
		                'label' => __('Facebook', 'mthemelocal'),
		                'desc' => '',
		            ),
		            'twitter' => array(
		                'std' => 'twitter',
		                'type' => 'checkbox',
		                'label' => __('Twitter', 'mthemelocal'),
		                'desc' => '',
		            ),
		            'linkedin' => array(
		                'std' => 'linkedin',
		                'type' => 'checkbox',
		                'label' => __('Linkedin', 'mthemelocal'),
		                'desc' => '',
		            ),
		            'googleplus' => array(
		                'std' => 'googleplus',
		                'type' => 'checkbox',
		                'label' => __('Google Plus', 'mthemelocal'),
		                'desc' => '',
		            ),
		            'reddit' => array(
		                'std' => 'reddit',
		                'type' => 'checkbox',
		                'label' => __('Reddit', 'mthemelocal'),
		                'desc' => '',
		            ),
		            'tumblr' => array(
		                'std' => 'tumblr',
		                'type' => 'checkbox',
		                'label' => __('Tumblr', 'mthemelocal'),
		                'desc' => '',
		            ),
		            'pinterest' => array(
		                'std' => 'pinterest',
		                'type' => 'checkbox',
		                'label' => __('Pinterest', 'mthemelocal'),
		                'desc' => '',
		            ),
		            'mailto' => array(
		                'std' => 'mailto',
		                'type' => 'checkbox',
		                'label' => __('Mailto', 'mthemelocal'),
		                'desc' => '',
		            ),
				),
				'shortcode' => '[pageshare content_richtext="{{content_richtext}}"]',
				'popup_title' => __('Add Richtext', 'mthemelocal')
			);


			$this->the_options = $mtheme_shortcodes['pageshare'];

			//create the block
			parent::__construct('em_pageshare', $block_options);
			// Any script registers need to uncomment following line
			//add_action('mtheme_aq-page-builder-admin-enqueue', array($this, 'admin_enqueue_scripts'));
		}

		function form($instance) {
			$instance = wp_parse_args($instance);

			echo mtheme_generate_builder_form($this->the_options,$instance);
			//extract($instance);
		}

		function block($instance) {
			extract($instance);
			$media = mtheme_featured_image_link( get_the_id() );

			$link = get_permalink();
			$title = get_the_title();

			if (isSet($instance['mtheme_facebook'])) {
				$socialshare['fa-facebook'] = 'http://www.facebook.com/sharer.php?u='. esc_url( $link ) .'&t='. esc_attr( $title );
			}
			if (isSet($instance['mtheme_twitter'])) {
				$socialshare['fa-twitter'] = 'http://twitter.com/home?status='.esc_attr( $title ).'+'. esc_url( $link );
			}
			if (isSet($instance['mtheme_linkedin'])) {
				$socialshare['fa-linkedin'] = 'http://linkedin.com/shareArticle?mini=true&amp;url='.esc_url( $link ).'&amp;title='.esc_attr( $title );
			}
			if (isSet($instance['mtheme_googleplus'])) {
				$socialshare['fa-google-plus'] = 'https://plus.google.com/share?url='. esc_url( $link );
			}
			if (isSet($instance['mtheme_reddit'])) {
				$socialshare['fa-reddit'] = 'http://reddit.com/submit?url='.esc_url( $link ).'&amp;title='.esc_attr( $title );
			}
			if (isSet($instance['mtheme_tumblr'])) {
				$socialshare['fa-tumblr'] = 'http://www.tumblr.com/share/link?url='.esc_url( $link ).'&amp;name='.esc_attr( $title ).'&amp;description='.esc_attr( $title );
			}
			if (isSet($instance['mtheme_pinterest'])) {
				$socialshare['fa-pinterest'] = 'http://pinterest.com/pin/create/bookmarklet/?media=' .esc_url( $media ) .'&url='. esc_url( $link ) .'&is_video=false&description='.esc_attr( $title );
			}
			if (isSet($instance['mtheme_mailto'])) {
				$socialshare['fa-envelope'] = 'mailto:email@address.com?subject=Interesting Link&body=' . esc_attr( $title ) . " " .  esc_url( $link );
			}
			?>
			<ul class="portfolio-share">
			<?php
			  foreach( $socialshare as $icon => $url){
			    echo '<li class="share-this-'.$icon.'"><a title="Share" target="_blank" href="'. esc_url( $url ).'"><i class="fa '.$icon.'"></i></a></li>';
			  }
			?>
			<li class="share-indicate"><?php _e('Share','mthemelocal'); ?></li>
			</ul>
			<?php
			
		}
		public function admin_enqueue_scripts(){
			//Any script registers go here
		}

	}
}