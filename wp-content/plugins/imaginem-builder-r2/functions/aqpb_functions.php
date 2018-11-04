<?php
/**
 * Aqua Page Builder functions
 *
 * This holds the external functions which can be used by the theme
 * Requires the AQ_Page_Builder class
 *
 * @todo - multicheck, image checkbox, better colorpicker
**/

if(class_exists('AQ_Page_Builder')) {

	/**
	 * Core functions
	*******************/

	/* Register a block */
	function mtheme_register_block($block_class) {
		global $aq_registered_blocks;
		$aq_registered_blocks[strtolower($block_class)] = new $block_class;
	}

	/** Un-register a block **/
	function mtheme_unregister_block($block_class) {
		global $aq_registered_blocks;
		$block_class = strtolower($block_class);
		foreach($aq_registered_blocks as $block) {
			if($block->id_base == $block_class) unset($aq_registered_blocks[$block_class]);
		}
	}

	/** Get list of all blocks **/
	function mtheme_get_blocks($template_id,$saved_blocks) {
		global $aq_page_builder;
		$aqpb_config = mtheme_page_builder_config();
		$aq_page_builder = new AQ_Page_Builder($aqpb_config);
		$blocks = $aq_page_builder->retrieve_blocks($template_id,$saved_blocks);

		return $blocks;
	}

	/**
	 * Form Field Helper functions
	 *
	 * Provides some default fields for use in the blocks
	 *
	********************************************************/

	function mtheme_field_input($field_id, $block_id, $input, $size = 'full', $type = 'text') {
		$output = '<input type="'.$type.'" id="'. $block_id .'_'.$field_id.'" class="input-'.$size.'" value="'.$input.'" name="aq_blocks['.$block_id.']['.$field_id.']">';

		return $output;
	}

	/* Textarea field */
	function mtheme_field_textarea($field_id, $block_id, $text, $size = 'full') {
		$output = '<textarea id="'. $block_id .'_'.$field_id.'" class="textarea-'.$size.'" name="aq_blocks['.$block_id.']['.$field_id.']" rows="5">'.$text.'</textarea>';

		return $output;
	}


	/* Select field */
	function mtheme_field_select( $field_id, $block_id, $options, $selected, $extra = array() ) {
		$options = is_array($options) ? $options : array();
		$output = '<select id="' . $block_id . '_' . $field_id . '" name="aq_blocks[' . $block_id . '][' . $field_id . ']"' . implode( ' ', $extra ) . '>';
		foreach($options as $key=>$value) {
			$output .= '<option value="'.$key.'" '.selected( $selected, $key, false ).'>'.htmlspecialchars($value).'</option>';
		}
		$output .= '</select>';

		return $output;
	}

	/* Multiselect field */
	function mtheme_field_multiselect($field_id, $block_id, $options, $selected_keys = array()) {
		$output = '<select id="'. $block_id .'_'.$field_id.'" multiple="multiple" class="select of-input" name="aq_blocks['.$block_id.']['.$field_id.'][]">';
		foreach ($options as $key => $option) {
			$selected = (is_array($selected_keys) && in_array($key, $selected_keys)) ? $selected = 'selected="selected"' : '';
			$output .= '<option id="'. $block_id .'_'.$field_id.'_'. $key .'" value="'.$key.'" '. $selected .' />'.$option.'</option>';
		}
		$output .= '</select>';

		return $output;
	}

	/* Color picker field */
	function mtheme_field_color_picker($field_id, $block_id, $color, $default = '') {
		$output = '<span class="aqpb-color-picker">';
			$output .= '<input type="text" id="'. $block_id .'_'.$field_id.'" class="input-color-picker" value="'. $color .'" name="aq_blocks['.$block_id.']['.$field_id.']" data-default-color="'. $default .'"/>';
		$output .= '</span>';

		return $output;
	}

	/* Single Checkbox */
	function mtheme_field_checkbox( $field_id, $block_id, $check, $extra = array() ) {
		
		$output = '<input type="hidden" name="aq_blocks['.$block_id.']['.$field_id.']" value="0" />';
		$output .= '<input type="checkbox" id="'. $block_id .'_'.$field_id.'" class="input-checkbox" name="aq_blocks['.$block_id.']['.$field_id.']" '. checked( 1, $check, false ) 
				.' value="1"'
				. implode( ' ', $extra ) . '/>';
		return $output;
	}
	
	function mtheme_builder_icon_selector( $field_id, $block_id, $selected) {
		
		$output  = '<div class="pagebuilder-icon-picker">';
		$output .= '<a href="#pagebuilder-icon-picker-modal" data-toggle="stackablemodal">'.__('Choose icon','mthemelocal').'</a>';
		$output .= '<input type="hidden" id="'. $block_id .'_'.$field_id.'" class="mtheme-pb-selected-icon" name="aq_blocks['.$block_id.']['.$field_id.']" value="'.$selected.'">';
		$output .= '<i class="fontawesome_icon preview '.$selected.'"></i>';
		$output .= '</div>';
		return $output;
		
	}

	/* Media Uploader */
	function mtheme_field_upload($field_id, $block_id, $media, $media_type = 'image', $default = '') {
		if(!isset($media) || empty($media))
			$media = $default;
		$output  = '<input type="text" readonly id="'. $block_id .'_'.$field_id.'" class="input-full imagefile-uploader" value="'.$media.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
		$output .= '<a href="#" class="aq_upload_button button" rel="'.$media_type.'">Upload</a>';
		$output .= '<a class="remove_image button" style="float:right;">Remove</a>';

		return $output;
	}
	
	/**/
	function mtheme_field_upload_new($field_id, $block_id, $media, $image_id, $media_type = 'image', $default = '') {
		if(!isset($media) || empty($media))
			$media = $default;
		$output = '<img class="screenshot" src="'.$media.'" alt=""/>
				<input type="hidden" id="'.$block_id.'_'.$field_id.'_imageid" name="aq_blocks['.$block_id.']['.$field_id.'id]" value="'.$image_id.'" />';
		$output  .= '<input type="text" readonly id="'. $block_id .'_'.$field_id.'" class="input-full imagefile-uploader" value="'.$media.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
		$output .= '<a href="#" class="aq_upload_button button" rel="'.$media_type.'">Upload</a><a class="remove_image button" style="float:right;">Remove</a><p></p>';
	
		return $output;
	}
	
	function mtheme_get_column_width($size, $grid = 940, $margin = 20) {

		$columns = range(1,12);
		$widths = array();
		foreach($columns as $column) {
			$width = (( $grid + $margin ) / 12 * $column) - $margin;
			$width = round($width);
			$widths[$column] = $width;
		}

		$column_id = absint(preg_replace("/[^0-9]/", '', $size));
		$column_width = $widths[$column_id];
		return $column_width;
	}

	/** Recursive
	 */
	function mtheme_recursive_sanitize($value) {
		if(is_array($value)) {
			$value = array_map('mtheme_recursive_sanitize', $value);
		} else {
			$value = htmlspecialchars(stripslashes($value));
		}
		return $value;
	}

}