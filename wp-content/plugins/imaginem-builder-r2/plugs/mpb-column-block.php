<?php
/** Column **/
class em_column_block extends AQ_Block {
	/* PHP5 constructor */
	function __construct() {

		$block_options = array(
				'block_slug' => 'container',
				'pb_block_icon' => 'fa fa-bars',
				'pb_block_icon_color' => 'none',
				'name' => __('Column Container','mthemelocal'),
				'size' => 'span12',
				'tab' => __('Layout','mthemelocal'),
				'desc' => __('Add a Column','mthemelocal')
		);

		$mtheme_shortcodes['fullwidth_container'] = array(
			'no_preview' => true,
			'shortcode_desc' => __('Column Container', 'mthemelocal'),
			'params' => array(
			    'container_type' => array(
			      'type' => 'select',
			      'label' => __('Boxed or Fullwidth', 'mthemelocal'),
			      'desc' => __('Boxed or Fullwidth. For full columns', 'mthemelocal'),
			      'options' => array(
			        'boxed' => __('Boxed', 'mthemelocal'),
			        'fullwidth' => __('Fullwidth', 'mthemelocal')
			      )
			    ),
			    'text_intensity' => array(
			      'type' => 'select',
			      'label' => __('Text Intensity', 'mthemelocal'),
			      'desc' => __('Text Intensity for headings types', 'mthemelocal'),
			      'options' => array(
			        'default' => __('Default', 'mthemelocal'),
			        'dark' => __('Dark','mthemelocal'),
			        'bright' => __('Bright','mthemelocal')
			      )
			    ),
				'margin_top' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Margin top in pixels', 'mthemelocal'),
					'desc' => __('Margin top in pixels', 'mthemelocal')
				),
				'margin_bottom' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Margin bottom in pixels', 'mthemelocal'),
					'desc' => __('Margin bottom in pixels', 'mthemelocal')
				),
				'padding_top' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Padding top in pixels', 'mthemelocal'),
					'desc' => __('Padding top in pixels', 'mthemelocal')
				),
				'padding_bottom' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Padding bottom in pixels', 'mthemelocal'),
					'desc' => __('Padding bottom in pixels', 'mthemelocal')
				),
				'padding_sides' => array(
					'std' => '',
					'type' => 'text',
					'label' => __('Padding sides in pixels', 'mthemelocal'),
					'desc' => __('Padding sides in pixels', 'mthemelocal')
				),
				'background_color' => array(
					'std' => '',
					'type' => 'color',
					'label' => __('Background color', 'mthemelocal'),
					'desc' => __('Background color', 'mthemelocal'),
				),
				'gradient_color' => array(
					'std' => '',
					'type' => 'color',
					'label' => __('Combine with background color to create Gradients', 'mthemelocal'),
					'desc' => __('Apply Gradient color', 'mthemelocal'),
				),
			    'gradient_angle' => array(
			      'type' => 'select',
			      'label' => __('Gradient angle', 'mthemelocal'),
			      'desc' => __('Gradient angle', 'mthemelocal'),
			      'options' => array(
			        'none' => __('none','mthemelocal'),
			        'to_bottom' => __('to bottom','mthemelocal'),
			        'to_top' => __('to top','mthemelocal'),
			        'to_top_right' => __('to top right','mthemelocal'),
			        'to_top_left' => __('to top left','mthemelocal'),
			        'to_bottom_right' => __('to bottom right','mthemelocal'),
			        'to_bottom_left' => __('to bottom left','mthemelocal')
			      )
			    ),
				'background_image' => array(
					'std' => '',
					'type' => 'uploader',
					'label' => __('Background Image', 'mthemelocal'),
					'desc' => __('Background Image', 'mthemelocal')
				),
			    'background_scroll' => array(
			      'type' => 'select',
			      'label' => __('Scroll effect', 'mthemelocal'),
			      'desc' => __('Scroll effect', 'mthemelocal'),
			      'options' => array(
			        'parallax' => __('Parallax','mthemelocal'),
			        'static' => __('Static','mthemelocal')
			      )
			    )
			),
			'shortcode' => '',
			'popup_title' => __('Container', 'mthemelocal')
		);

		$this->the_options = $mtheme_shortcodes['fullwidth_container'];

		//create the widget
		parent::__construct('em_column_block', $block_options);

	}

	function form($instance) {
		echo '<p class="empty-column">',
		__('Drag block items into this box', 'mthemelocal'),
		'</p>';
		echo '<ul class="blocks column-blocks cf"></ul>';
	}

	function form_callback($instance = array(), $saved_blocks = array()) {
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		//insert the dynamic block_id & block_saving_id into the array
		$this->block_id = 'aq_block_' . $instance['number'];
		$instance['block_saving_id'] = 'aq_blocks[aq_block_'. $instance['number'] .']';
		extract($instance);
		//check if column has blocks inside it

				// echo '<pre>';
				// print_r($instance);
				// echo '</pre>';

		$col_order = $order;
		if ( !isSet($blockNote) ) {
			$blockNote = '';
		}
		//column block header
		if(isset($template_id)) {
			echo '<li id="template-block-'.$number.'" class="block block-em_column_block ui-resizable mtheme-columns '.$size.'">',
			'<dl class="block-bar">
				<ul class="block-controls">
					<li class="block-control-actions cf">
						<a href="#" class="delete" data-tooltip="tooltip" data-original-title="'. __('Remove','mthemelocal') .' '. $this->name .'"><i class="fa fa-trash"></i></a>
					</li>
					<li class="block-control-actions cf">
						<a href="#my-column-content-'.$number.'" class="block-edit" data-toggle="stackablemodal" data-tooltip="tooltip" data-original-title="'.__('Edit','mthemelocal'). ' '. $this->name .'"><i class="fa fa-pencil"></i></a>
					</li>
					<li class="block-control-actions cf">
						<a href="#mtheme-pb-export-a-block" class="export" data-tooltip="tooltip" data-original-title="'.__('Export Block','mthemelocal').'" data-toggle="modal"><i class="fa fa-upload"></i></a>
					</li>
				</ul>
				<dt class="block-handle">
	 				<div class="block-icon" style="color:'.$pb_block_icon_color.';">',
	 				'<i class="'.$pb_block_icon.'"></i>',
	 				'</div>
					<div class="block-title">'. $this->name .'</div>
					<div class="block-size">',
						substr($size, 4).'/12',		
					'</div><span class="user-control-id">'.sanitize_title_with_dashes($blockID).'</span>
					<div class="blocknote-self">'.esc_html($blockNote).'</div>
				</dt>
			</dl>',
			'<div class="block-settings-column cf" id="block-settings-'.$number.'">',
						'<p class="empty-column">',
							__('Drag block items into this container', 'mthemelocal'),
						'</p>',
						'<ul class="blocks column-blocks cf">';
						if (isSet($saved_template) && $saved_template==1) {
							$blocks = $saved_blocks;
						} else {
							$blocks = mtheme_get_blocks($template_id,$saved_blocks);
						}

				// echo '<pre>';
				// print_r($instance);
				// echo '</pre>';
			//outputs the blocks
			if($blocks) {
				foreach($blocks as $key => $child) {
					global $aq_registered_blocks;
					$child = unserialize($child[0]);
					if(is_array($child)) {
						extract($child);
						if(isset($aq_registered_blocks[$id_base])) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];
	
							if($parent == $col_order) {
								$block->form_callback($child);
							}
						}
					}
				}
			}
			echo 		'</ul>';

		} else {
			$this->before_form($instance);
			$this->form($instance);
		}

		//form footer
		$this->after_form($instance);
	}
 
	//form footer
	function after_form($instance) {
		extract($instance);
		$blockID = isset($blockID) ? $blockID : '';
		$blockNote = isset($blockNote) ? $blockNote : '';
		$block_saving_id = 'aq_blocks[aq_block_'.$number.']';
			echo '<div id="my-column-content-' . $number . '" class="modal fade" style="display: none;">';
			?>
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					  <div class="modal-header">
					  <div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
							<h4 class="modal-title"><?php echo $this->name ?></h4>
							<label for="blockID"><?php _e('Column ID','mthemelocal'); ?></label>
							<div class="description_text"><?php _e('Enter a unique ID for this column.','mthemelocal'); ?></div>
							<input class="blockID" type="text" name="<?php echo $block_saving_id ?>[blockID]" value="<?php echo sanitize_title_with_dashes($blockID) ?>" id="blockID"/>
							<label for="blockNote"><?php _e('Block Note','mthemelocal'); ?></label>
							<div class="description_text"><?php _e('Add a note for self - to identify this block.','mthemelocal'); ?></div>
							<input class="blockNote" type="text" name="<?php echo $block_saving_id ?>[blockNote]" value="<?php echo esc_attr($blockNote); ?>" id="blockNote"/>
					  </div>
					<div class="modal-body">
							  <?php
				$this->extra_column_fields( $instance );
			echo '</div><div class="modal-footer"><button class="button-primary" type="button" data-dismiss="modal">'.__('Done','mthemelocal').'</button></div></div></div></div>';
			echo '<input type="hidden" class="id_base" name="'.$this->get_field_name('id_base').'" value="'.$id_base.'" />';
			echo '<input type="hidden" class="name" name="'.$this->get_field_name('name').'" value="'.$name.'" />';
			echo '<input type="hidden" class="order" name="'.$this->get_field_name('order').'" value="'.$order.'" />';
			echo '<input type="hidden" class="size" name="'.$this->get_field_name('size').'" value="'.$size.'" />';
			echo '<input type="hidden" class="parent" name="'.$this->get_field_name('parent').'" value="'.$parent.'" />';
			echo '<input type="hidden" class="number" name="'.$this->get_field_name('number').'" value="'.$number.'" />';
		?>
				</div>
			</li>
		<?php
	}

	function extra_column_fields( $instance ) {
		extract( $instance );

		echo mtheme_generate_builder_form($this->the_options,$instance);
	}

	function block_callback($instance,$saved_blocks = array()) {
		global $aq_registered_blocks;
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		extract($instance);
		$col_order = $order;
		$col_size = absint(preg_replace("/[^0-9]/", '', $size));
		$this->column_enqueue();
		//column block header
		if(isset($template_id)) {
			if ( ! is_admin() ) {
				$this->before_block( $instance, $saved_blocks );
			}
			//define vars
			$overgrid = 0; $span = 0; $first = false;

			//check if column has blocks inside it
			$blocks = mtheme_get_blocks($template_id,$saved_blocks);
			//outputs the blocks
			?>
			<?php 
			//$image_cut = wp_get_attachment_image_src($image_uploadid,'full');
			?>
			<?php
			if($blocks) {
				$rows = $this->mtheme_array_children( $this->_get_children( $blocks, $instance ), $col_size );
				// echo '<pre>';
				// print_r($rows);
				// echo '</pre>';
				// echo '<pre>';
				// print_r($this->_get_children( $blocks, $instance ));
				// echo '</pre>';
				foreach($rows as $row) {
					if ( ! is_admin() ) {
						echo '<div class="row clearfix">';
					}
					foreach($row as $key => $child) {
//						$child = unserialize($child[0]);
						extract($child);

						if(class_exists($id_base)) {
							//get the block object
							$block = $aq_registered_blocks[$id_base];

							//insert template_id into $child
							$child['template_id'] = $template_id;

							//display the block
							if($parent == $col_order) {

								$child_col_size = absint(preg_replace("/[^0-9]/", '', $size));

								$overgrid = $span + $child_col_size;

								if($overgrid > $col_size || $span == $col_size || $span == 0) {
									$span = 0;
									$first = true;
								}

								if($first == true) {
									$child['first'] = true;
								}

								$block->block_callback($child,$saved_blocks);

								$span = $span + $child_col_size;

								$overgrid = 0; //reset $overgrid
								$first = false; //reset $first
							}
						}
					}
					if ( ! is_admin() ) {
						echo '</div>';
					}
				}
			}
			if ( ! is_admin() ) {
				$this->after_block($instance);
			}
			?>
	<?php
		} else {
			//show nothing
		}
	}
	
	public function update( $new_instance, $old_instance ) {
		// this check can be done for other cases where a "row-fluid" class is needed
		return parent::update( $new_instance, $old_instance );
	}
	public function mtheme_array_children( $blocks, $col_size = 12 ) {
		// Seperate array to different blocks
		$rows = array();
		$running_total = 0;
		$row = array();
		foreach ( $blocks as $block ) {
			$size = absint( preg_replace( '#[^\d]#', '', $block['size'] ) );
			//echo $size . " running:" . $running_total . " >>> ";
			if ( $col_size < ($running_total + $size ) ) {
				$rows[] = $row;
				$row = array();
				$running_total = 0;
			}
			$row[] = $block;
			$running_total += $size;
		}
		if ( ! empty( $row ) ) {
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function _get_children( $blocks, $instance ) {
		$blocks = array_map( 'maybe_unserialize', wp_list_pluck( $blocks, 0 ) );
		return wp_list_filter( $blocks, array( 'parent' => $instance['order'] ) );
	}

	public function column_enqueue(){
	}

}
