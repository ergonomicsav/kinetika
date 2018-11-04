<?php
class mTheme_Events_List_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'mtheme_events_widget', 'description' => __( 'Displays list of event posts', 'mthemelocal') );
		parent::__construct('events_list',MTHEME_WIDGET_PREFIX .' - '. __('Events List', 'mthemelocal'), $widget_ops);
		
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Events', 'mthemelocal') : $instance['title'], $instance, $this->id_base);
		$text = $instance['text'];
		$limit = $instance['limit'];
		
		echo $before_widget;		
		?>
<?php
	//echo $tag->slug;
	if (!isSet($limit) && $limit=="") {
		$limit="-1";
	}
    $args=array(
      'post_type' => 'mtheme_events',
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'showposts'=>$limit,
      'ignore_sticky_posts'=>1
    );
    $r = null;
    $r = new WP_Query($args);
	
    if( $r->have_posts() ) :
	
		if ( $title) echo $before_title . $title . $after_title;
		if(!empty($text)):?><p class="portfoliorelated_widget_about"><?php echo $text;?></p><?php endif;		
		?>
		
		<ul id="recentposts_list">
<?php while ($r->have_posts()) : $r->the_post();
	
	$custom = get_post_custom(get_the_ID());
	$description="";
	if ( isset($custom[MTHEME . '_thumbnail_desc'][0]) ) {
		$description=$custom[MTHEME . '_thumbnail_desc'][0];
		$description = mtheme_trim_sentence($description,60);
	}
?>
			<li>

				
<?php if (has_post_thumbnail() ): ?>
		<a class="recent_thumbnail" href="<?php echo get_permalink() ?>" title="<?php the_title();?>">
		<?php
		// Show Image
		echo mtheme_display_post_image (
			$postid = get_the_ID(),
			$have_image_url=false,
			$link=false,
			$type="gridblock-tiny",
			$thetitle=get_the_title(),
			$class="" 
		);
		?>

				</a>
<?php endif;//disable_thumbnail ?>
				<div class="recentpost_info">
					<a class="recentpost_title" href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>

					<p><?php echo $description; ?></p>

				</div>
				<div class="clear"></div>
			</li>
<?php endwhile; ?>
		</ul>
<?php
endif;
//$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
?>
		
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$text = isset($instance['text']) ? esc_attr($instance['text']) : '';
		$limit = isset($instance['limit']) ? esc_attr($instance['limit']) : '';
	?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Intro text:', 'mthemelocal'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" ><?php echo $text; ?></textarea></p>

		<p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit ( -1 for all ):', 'mthemelocal'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></p>
		
<?php
	}

}
add_action('widgets_init', create_function('', 'return register_widget("mTheme_Events_List_Widget");'));