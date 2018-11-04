<?php
/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */                                                                                                
function imaginem_pagebuilder_hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}
function mtheme_generate_input_modal() {
	$the_block_type = $_POST['blockmodule'];
	$blocknumber = $_POST['blocknumber'];

	global $aq_registered_blocks;

	$block = $aq_registered_blocks[$the_block_type];

	$instance = $block->block_options;
	$instance['number']=$blocknumber;
	$block->form($instance);

	wp_die();
}
add_action( 'wp_ajax_mtheme_generate_input_modal', 'mtheme_generate_input_modal' );
add_action( 'wp_ajax_nopriv_mtheme_generate_input_modal', 'mtheme_generate_input_modal' );

function mtheme_create_tab($child_options,$tab,$child_count,$child_field_id,$child_field_name,$ajax = false) {
//print_r($child_options);
// echo '<pre>inside the create tab';
// print_r($tab);
// //print_r($child_options);
// echo '</pre>';
?>
			<li id="<?php echo $child_field_id ?>-sortable-item-<?php echo $child_count ?>" class="sortable-item" rel="<?php echo $child_count ?>">
				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong>
							<?php
							$sortable_title = '';
							$default_title_field='';
							if ( isSet($child_options['title_field']) ) {
								$default_title_field = $child_options['title_field'];
								if ( isSet($tab[$default_title_field]) ) {
									$sortable_title = $tab[$default_title_field];
								}
							}
							if ( !isSet($tab[$default_title_field]) ) {
								$sortable_title = $tab['title'];
							}
							echo mtheme_trim_text($sortable_title,30);
							?>
						</strong>
					</div>
					<div class="sortable-out-delete">
					</div>
					<div class="sortable-handle">
						<a href="#"></a>
					</div>
				</div>
				<div class="sortable-body cf">

			<?php
			$params = $child_options['params'];
				foreach ($params as $field_id => $param ) {

					if ($param['type']!="sleeper") {
						echo '<p class="tab-desc description">
						<div class="formview-leftside">
							<label for="'.$child_field_id.'-'.$child_count.'-'.$field_id.'">'.$param['label'].'</label>
						</div>
						<div class="formview-rightside">';

						if ( isSet($param['std']) ) {
							$stored_value=$param['std'];
						} else {
							$stored_value='';
						}
						if ( isSet($tab[$field_id]) && !empty($tab[$field_id]) ) {
							$stored_value = $tab[$field_id];
						}

						switch ( $param['type'] ) {

							case "text":
								//$output .= '<input type="text" id="'. $block_id .'_'.$field_id.'" class="input-" value="'.$selected.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
								echo '<input type="text" id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'" class="input-full" name="'.$child_field_name.'['.$child_count.']['.$field_id.']" value="'.esc_attr($stored_value).'" />';
								break;

							case "fontawesome-iconpicker":
								echo '<div class="pagebuilder-icon-picker">';
								echo '<a href="#pagebuilder-icon-picker-modal" data-toggle="stackablemodal">'.__('Choose icon','mthemelocal').'</a>';
								echo '<a class="mtheme-pb-remove-icon">'.__('Remove icon','mthemelocal').'</a>';
								echo '<input type="hidden" id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'" class="mtheme-pb-selected-icon" name="'.$child_field_name.'['.$child_count.']['.$field_id.']" value="'.$stored_value.'">';
								echo '<i class="fontawesome_icon preview '.$stored_value.'"></i>';
								echo '</div>';
								break;

							case "uploader":
								//echo '<input type="text" id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'" class="input-full" name="'.$child_field_name.'['.$child_count.']['.$field_id.']" value="'.$stored_value.'" />';
								$placeholder_url='';
								if (isSet($tab[$field_id.'id'])) {
									$image_id_value = $tab[$field_id.'id'];
									$placeholder = wp_get_attachment_image_src($image_id_value);
									$placeholder_url = $placeholder[0];
								} else {
									$image_id_value = '';
								}
								echo '<img class="screenshot" src="'.$placeholder_url.'" alt=""/>';
								echo '<input type="hidden" id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'id"
									   name="'.$child_field_name.'['.$child_count.']['.$field_id.'id]"
									   value="'.$image_id_value.'" />';
								echo '<input type="text" id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'" readonly
									   class="input-full imagefile-uploader" value="'.$stored_value.'"
									   name="'.$child_field_name.'['.$child_count.']['.$field_id.']" >';
								echo '<a href="#" class="aq_upload_button button" rel="image">'.__('Upload','mthemelocal').'</a>';
								echo '<a href="#" class="remove_image button" rel="image">'.__('Remove','mthemelocal').'</a>';
								break;

							case "color":
								echo '<span class="aqpb-color-picker">';
								echo '<input type="text" id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'" class="input-color-picker" value="'.$stored_value.'" name="'.$child_field_name.'['.$child_count.']['.$field_id.']" data-default-color="'. $stored_value .'"/>';
								echo '</span>';
								break;

							case "textarea":

								$richtextclass = '';
								if ( isSet($param['textformat'])) {
									if ($param['textformat']=='richtext') {
										$richtextclass = ' child-richtext-block';
									}
								}
								//$output .= '<input type="text" id="'. $block_id .'_'.$field_id.'" class="input-" value="'.$selected.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
								echo '<textarea rows="5" id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'" class="textarea-full'.$richtextclass.'" name="'.$child_field_name.'['.$child_count.']['.$field_id.']">'.$stored_value.'</textarea>';
								if ( !isSet($param['textformat'])) {
									echo __('Enter P tags for new lines. eg. <code>&lt;p&gt;Line 1&lt;/p&gt;&lt;p&gt;Line 2&lt;/p&gt;</code>','mthemelocal');
								}
								break;
							case "editor":
								//echo wp_editor($tab['content'], $child_field_id.'-'.$child_count.'-'.'content', array('textarea_name'=>$child_field_name.'['.$child_count.'][content]','editor_class'=>$child_field_id.'_editor_tabbed','quicktags'=>false));
								break;
							case "select":
								// echo '<pre>';
								// print_r($param['options']);
								// echo '</pre>';
								echo '<select id="'.$child_field_id.'-'.$child_count.'-'.$field_id.'" name="'.$child_field_name.'['.$child_count.']['.$field_id.']">';
								foreach($param['options'] as $value => $option ) {
									echo'<option value="'.$value.'" '.selected( $stored_value, $value, false ).'>'.htmlspecialchars($option).'</option>';
								}
								echo '</select>';
								break;

						}
						echo '</div></p>';
					}
				}
?>
			</div>
		</li>
<?php
}
function mtheme_dispay_build($options,$block_id,$instance) {
	// extract($instance);
	// 	echo '<pre>';
	// 	print_r($options);
	// 	echo '</pre>';
	// echo "----------------";
	// 	echo '<pre>';
	// 	print_r($instance);
	// 	echo '</pre>';

	// echo "------child----------";
	// 	echo '<pre>';
	// 	print_r($instance['tabs']);
	// 	echo '</pre>';

	$shortcode = $options['shortcode'];

	if (isSet($options['child_shortcode'])) {
		$child_options = $options['child_shortcode'];
	}
	// echo "-PARAMS---------------";
	// 	echo '<pre>';
	// 	print_r($params);
	// 	echo '</pre>';
	//echo $shortcode;
	//$data = explode('"' , $shortcode);
	// echo '<pre>';
	// print_r($result);
	// echo '</pre>';


	preg_match_all("/\{{(.*?)\}}/", $shortcode, $result);

	$params_with_braces = $result[0];
	$params_no_braces = $result[1];

	$values =array();

	//Build values to braces
	// Append new field values with prefixes and array with values
	foreach ($params_no_braces as $field_id ) {
		$new_field_id = 'mtheme_' . $field_id;
		//echo '**********' . $field_id;
		if ( isSet($instance[$new_field_id])) {
			$selected = $instance[$new_field_id];
			// if ($field_id=="content_richtext") {
			// 	echo $selected;
			// }
			$selected = esc_textarea($selected);
			//echo '----' . $selected . '-----';
			$values[$field_id] = $selected;
		}
	}

	$new_shortcode = $shortcode;
	foreach ($values as $field_id => $value ) {
		$new_shortcode = str_replace( '{{'.$field_id.'}}', $value, $new_shortcode);
	}

	if (isSet($options['child_shortcode']['shortcode'])) {

		$child_instance = $instance['tabs'];
		$child_shortcode = $options['child_shortcode']['shortcode'];

		// echo '<pre>instance and shortcode';
		// print_r($child_instance);
		// print_r($child_shortcode);
		// echo '</pre>';

		preg_match_all("/\{{(.*?)\}}/", $child_shortcode, $child_result);
		$params_child_with_braces = $child_result[0];
		$params_child_no_braces = $child_result[1];

		//Build values to braces in child shortcode
		// echo '<pre>--CHild pram no braces';
		// print_r( $params_child_no_braces );
		// echo '</pre>';

		$new_childshortcode = $child_shortcode;
		$stored_childshortcode = '';
		foreach ($child_instance as $child_data ) {
			//echo $instance_field_name;
			//print_r($child_data);
			foreach ($child_data as $child_field_name=>$child_field_value ) {
				//echo '</br>---------->' . $child_field_name,$child_field_value;
				if ($child_field_value=="" || !isSet($child_field_value) || empty($child_field_value)) {
					$child_field_value=" ";
				}

				$child_field_value = esc_textarea($child_field_value);

				$new_childshortcode = str_replace( '{{'.$child_field_name.'}}', $child_field_value, $new_childshortcode);
				// $new_childshortcode = $child_shortcode;
				// foreach ($child_values as $field_id => $value ) {
				// 	$new_childshortcode = str_replace( '{{'.$field_id.'}}', $child_field_value, $child_shortcode);
				// }
			}
			$stored_childshortcode .= $new_childshortcode;
			$new_childshortcode = $child_shortcode;
			// foreach ($params_child_no_braces as $field_id ) {
			// 	$new_field_id = $field_id;
			// 	echo $new_field_id;
			// 	//echo $new_field_id;
			// 	if ( isSet($child_instance[$new_field_id])) {
			// 		$child_selected = $child_instance[$new_field_id];
			// 		$child_values[$field_id] = $selected;
			// 	}
			// }

		}
		//echo $stored_childshortcode;
		
		$new_shortcode = str_replace( '{{child_shortcode}}', $stored_childshortcode, $new_shortcode);

		// echo '<pre>CHILD VALUES';
		// print_r($child_values);
		// echo '</pre>';

		// $new_childshortcode = $child_shortcode;
		// foreach ($child_values as $field_id => $value ) {
		// 	$new_childshortcode = str_replace( '{{'.$field_id.'}}', $value, $child_shortcode);
		// }

		// echo '<pre>CHILD SHORTCODE';
		// echo $new_childshortcode;
		// echo '</pre>';

	}

	//echo $new_shortcode;

	// echo '<pre>';
	// print_r($values);
	// echo $new_shortcode;
	// echo '</pre>';

	return $new_shortcode;
}
function mtheme_generate_builder_form($options,$instance) {
	extract($instance);
	// 	echo '<pre>';
	// 	print_r($options);
	// 	echo '</pre>';
	// echo "----------------";
	// 	echo '<pre>';
	// 	print_r($instance);
	// 	echo '</pre>';

	$params = $options['params'];
	// echo "-PARAMS---------------";
	// 	echo '<pre>';
	// 	print_r($params);
	// 	echo '</pre>';

	$output = '';
	foreach ($params as $field_id => $param ) {

		if ( $id_base=="em_column_block") {
			$block_id = "aq_block_".$number;
			$block_field_id = $block_id .'_'.$field_id;
		} else {
			$field_id = 'mtheme_' . $field_id;
			$block_field_id = $block_id .'_'.$field_id;
		}

		if ($param['type']!="sleeper") {
			$output .= '<div class="description mtheme-input-type-is-'.$param['type'].'">';
			$output .=  '<div class="formview-leftside">
							<label for="'. $block_field_id.'" >'. $param['label'].'</label>
							<span class="forminputdescription">
								'.$param['desc'].'
							</span>
						</div>';

						// echo '<pre>';
						// print_r ($param);
						// echo '</pre>';

					$the_value = $field_id;
					if ( isSet($instance[$the_value]) ) {
						$selected = $instance[$the_value];
					} else {
						if ( isSet($param['std']) ) {
							$selected = $param['std'];
						} else {
							$selected = '';
						}
					}

					if ($param['type']!="notice" && $param['type']!="sleeper" ) {
						$output .=  '<div class="formview-rightside '.$param['type'].'">';
					}

		}
		switch ( $param['type'] ) {

			case "fontawesome-iconpicker":
				$output .= '<div class="pagebuilder-icon-picker">';
				$output .= '<a href="#pagebuilder-icon-picker-modal" data-toggle="stackablemodal">'.__('Choose icon','mthemelocal').'</a>';
				$output .= '<a class="mtheme-pb-remove-icon">'.__('Remove icon','mthemelocal').'</a>';
				$output .= '<input type="hidden" id="'. $block_field_id.'" class="mtheme-pb-selected-icon" name="aq_blocks['.$block_id.']['.$field_id.']" value="'.$selected.'">';
				$output .= '<i class="fontawesome_icon preview '.$selected.'"></i>';
				$output .= '</div>';
				break;

			case "uploader":
				$image_id_field = $field_id.'id';
				$placeholder_url='';
				if (isSet($instance[$image_id_field])) {
					$the_image_id = $instance[$image_id_field];
					$placeholder = wp_get_attachment_image_src($the_image_id);
					$placeholder_url = $placeholder[0];
				} else {
					$the_image_id = '';
				}
				$output .= '<img class="screenshot" src="'.$placeholder_url.'" alt=""/>
						<input type="hidden" id="'.$block_field_id.'_imageid" name="aq_blocks['.$block_id.']['.$field_id.'id]" value="'.$the_image_id.'" />';
				$output  .= '<input type="text" readonly id="'. $block_field_id.'" class="input-full imagefile-uploader" value="'.$selected.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
				$output .= '<a href="#" class="aq_upload_button button" rel="image">'. __('Upload','mthemelocal') .'</a><a class="remove_image button" style="float:right;">'. __('Remove','mthemelocal') . '</a><p></p>';
				break;

			case "images":
				$output .= '<input type="hidden" class="mtheme-gallery-selector-ids" value="'.$selected.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
				$output .= '<button type="button" class="mtheme-gallery-selector">'.__('Select Images','mthemelocal').'</button>';
				
				$output .= '<div class="description">';
				$output .= '<ul class="mtheme-gallery-selector-list">';
				$output .= mtheme_gallery_list( $selected );
				$output .= '</ul>';
				$output .= '</div>';
				break;

			case "animated":
				$extra = '';
				$param['options'] = array(
						'none' => __('none','mthemelocal'),
						'fadeIn' => __('fadeIn','mthemelocal'),
						'fadeInDown' => __('fadeInDown','mthemelocal'),
						'fadeInDownBig' => __('fadeInDownBig','mthemelocal'),
						'fadeInLeft' => __('fadeInLeft','mthemelocal'),
						'fadeInLeftBig' => __('fadeInLeftBig','mthemelocal'),
						'fadeInRight' => __('fadeInRight','mthemelocal'),
						'fadeInRightBig' => __('fadeInRightBig','mthemelocal'),
						'fadeInUp' => __('fadeInUp','mthemelocal'),
						'fadeInUpBig' => __('fadeInUpBig','mthemelocal')
					);
				$output .= '<select id="' . $block_field_id . '" name="aq_blocks[' . $block_id . '][' . $field_id . ']">';
				foreach($param['options'] as $value => $option ) {
				$output .= '<option value="'.$value.'" '.selected( $selected, $value, false ).'>'.htmlspecialchars($option).'</option>';
				}
				$output .= '</select>';
				break;

			case "checkbox":
					$output .= '<input type="checkbox" id="'. $block_field_id.'" '.checked( $selected, 1 , false ).' class="input-checkbox-full" value="1" name="aq_blocks['.$block_id.']['.$field_id.']">';
				break;

			case "select":
				$extra = '';
				$output .= '<select id="' . $block_field_id . '" name="aq_blocks[' . $block_id . '][' . $field_id . ']">';
				foreach($param['options'] as $value => $option ) {
				$output .= '<option value="'.$value.'" '.selected( $selected, $value, false ).'>'.htmlspecialchars($option).'</option>';
				}
				$output .= '</select>';
				break;

			case "sidebar_list":
				$extra = '';
				$output .= '<select id="' . $block_field_id . '" name="aq_blocks[' . $block_id . '][' . $field_id . ']">';
				foreach($options['sidebar_list'] as $value => $option ) {
				$output .= '<option value="'.$value.'" '.selected( $selected, $value, false ).'>'.htmlspecialchars($option).'</option>';
				}
				$output .= '</select>';
				break;

			case 'category_list' :
				// prepare
				//$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="mtheme-form-select mtheme-input">' . "\n";
				$len = count($param['options']);

				//print_r($param['options']);

				$count=0;
				$output .= '<div class="mtheme-work-type-items">';
				foreach( $options['category_list'] as $value => $option )
				{
					$count++;	
					if ( $len == $count ) {
						$output .=  '<span>'.$value.'</span>';
					} else {
						$output .=  ',<span>'.$value . '</span>';
					}
				}
				$output .= '</div>';
				$output .= '<input type="text" id="'. $block_field_id.'" class="input-" value="'.$selected.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
				
				break;

			case "color":
				$output .= '<span class="aqpb-color-picker">';
					$output .= '<input type="text" id="'. $block_field_id.'" class="input-color-picker" value="'. $selected .'" name="aq_blocks['.$block_id.']['.$field_id.']" data-default-color="'. $param['std'] .'"/>';
				$output .= '</span>';
				break;

			case "notice":
				break;

			case "text":
				$output .= '<input type="text" id="'. $block_field_id.'" class="input-text-full" value="'.esc_attr($selected).'" name="aq_blocks['.$block_id.']['.$field_id.']">';
				break;

			case "editor":
				ob_start();
				wp_editor($selected, $block_field_id, array('textarea_name'=> 'aq_blocks['.$block_id.']['.$field_id.']' ,'wpautop'=> true,'media_buttons'=> false, 'quicktags'=>false,'tinymce'=>false) );
				$output .= ob_get_clean();
				break;

			case 'textarea':
				$richtextclass='';
				if ( isSet($param['textformat'])) {
					if ($param['textformat']=='richtext') {
						$richtextclass = ' main-richtext-block';
					}
				}
				$output .= '<textarea id="'. $block_field_id.'" class="textarea- '.$richtextclass.'" name="aq_blocks['.$block_id.']['.$field_id.']" rows="10">'.$selected.'</textarea>';
				if ( !isSet($param['textformat'])) {
					$output .= __('Enter P tags for new lines. eg. <code>&lt;p&gt;Line 1&lt;/p&gt;&lt;p&gt;Line 2&lt;/p&gt;</code>','mthemelocal');
				}
				break;

		}
		if ($param['type']!="notice" && $param['type']!="sleeper" ) {
					$output .=  '</div>';
			$output .=  '</div>';
		}

	}
	return $output;
}

function mtheme_gallery_list( $delim_ids ) {
	$output='';
	$ids = explode(',',$delim_ids);
	foreach( $ids as $id ) {
		$thumbnail = wp_get_attachment_image_src( $id );
		$output .= '<li><img src="'.$thumbnail[0].'" width="'.$thumbnail[1].'" height="'.$thumbnail[2].'"alt="" /></li>';
	}
	return $output;
}

function em_get_option( $name, $default = false ) {
	$config = get_option( 'optionsframework' );

	if ( ! isset( $config['id'] ) ) {
		return $default;
	}

	$options = get_option( $config['id'] );

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
function mtheme_valid($validate) {
	if(isset($validate) && !empty($validate)) {
		return TRUE;
	} else {
		return FALSE;
	}
}
/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string
 */
function mtheme_trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
  
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
  
    return $trimmed_text;
}
function mtheme_builder_iconpicker() {

	$fontello_icons = array ('pack-name'=>'fontello icons','pack-slug'=>'pack-fontello-icons', 'icon-pack'=> array ('fontello-icon-music' => '\e800','fontello-icon-search' => '\e801','fontello-icon-mail' => '\e802','fontello-icon-heart' => '\e803','fontello-icon-star' => '\e804','fontello-icon-user' => '\e805','fontello-icon-videocam' => '\e806','fontello-icon-camera' => '\e807','fontello-icon-photo' => '\e808','fontello-icon-attach' => '\e809','fontello-icon-lock' => '\e80a','fontello-icon-eye' => '\e80b','fontello-icon-tag' => '\e80c','fontello-icon-thumbs-up' => '\e80d','fontello-icon-pencil' => '\e80e','fontello-icon-comment' => '\e80f','fontello-icon-location' => '\e810','fontello-icon-cup' => '\e811','fontello-icon-trash' => '\e812','fontello-icon-doc' => '\e813','fontello-icon-note' => '\e814','fontello-icon-cog' => '\e815','fontello-icon-params' => '\e816','fontello-icon-calendar' => '\e817','fontello-icon-sound' => '\e818','fontello-icon-clock' => '\e819','fontello-icon-lightbulb' => '\e81a','fontello-icon-tv' => '\e81b','fontello-icon-desktop' => '\e81c','fontello-icon-mobile' => '\e81d','fontello-icon-cd' => '\e81e','fontello-icon-inbox' => '\e81f','fontello-icon-globe' => '\e820','fontello-icon-cloud' => '\e821','fontello-icon-paper-plane' => '\e822','fontello-icon-fire' => '\e823','fontello-icon-graduation-cap' => '\e824','fontello-icon-megaphone' => '\e825','fontello-icon-database' => '\e826','fontello-icon-key' => '\e827','fontello-icon-beaker' => '\e828','fontello-icon-truck' => '\e829','fontello-icon-money' => '\e82a','fontello-icon-food' => '\e82b','fontello-icon-shop' => '\e82c','fontello-icon-diamond' => '\e82d','fontello-icon-t-shirt' => '\e82e','fontello-icon-wallet' => '\e82f'));
	$feather_icons = array ('pack-name'=>'feather icons','pack-slug'=>'pack-feather-icons', 'icon-pack'=> array ('feather-icon-eye'=> '\e000' , 'feather-icon-paper-clip'=> '\e001' , 'feather-icon-mail'=> '\e002' , 'feather-icon-mail'=> '\e002' , 'feather-icon-toggle'=> '\e003' , 'feather-icon-layout'=> '\e004' , 'feather-icon-link'=> '\e005' , 'feather-icon-bell'=> '\e006' , 'feather-icon-lock'=> '\e007' , 'feather-icon-unlock'=> '\e008' , 'feather-icon-ribbon'=> '\e009' , 'feather-icon-image'=> '\e010' , 'feather-icon-signal'=> '\e011' , 'feather-icon-target'=> '\e012' , 'feather-icon-clipboard'=> '\e013' , 'feather-icon-clock'=> '\e014' , 'feather-icon-clock'=> '\e014' , 'feather-icon-watch'=> '\e015' , 'feather-icon-air-play'=> '\e016' , 'feather-icon-camera'=> '\e017' , 'feather-icon-video'=> '\e018' , 'feather-icon-disc'=> '\e019' , 'feather-icon-printer'=> '\e020' , 'feather-icon-monitor'=> '\e021' , 'feather-icon-server'=> '\e022' , 'feather-icon-cog'=> '\e023' , 'feather-icon-heart'=> '\e024' , 'feather-icon-paragraph'=> '\e025' , 'feather-icon-align-justify'=> '\e026' , 'feather-icon-align-left'=> '\e027' , 'feather-icon-align-center'=> '\e028' , 'feather-icon-align-right'=> '\e029' , 'feather-icon-book'=> '\e030' , 'feather-icon-layers'=> '\e031' , 'feather-icon-stack'=> '\e032' , 'feather-icon-stack-2'=> '\e033' , 'feather-icon-paper'=> '\e034' , 'feather-icon-paper-stack'=> '\e035' , 'feather-icon-search'=> '\e036' , 'feather-icon-zoom-in'=> '\e037' , 'feather-icon-zoom-out'=> '\e038' , 'feather-icon-reply'=> '\e039' , 'feather-icon-circle-plus'=> '\e040' , 'feather-icon-circle-minus'=> '\e041' , 'feather-icon-circle-check'=> '\e042' , 'feather-icon-circle-cross'=> '\e043' , 'feather-icon-square-plus'=> '\e044' , 'feather-icon-square-minus'=> '\e045' , 'feather-icon-square-check'=> '\e046' , 'feather-icon-square-cross'=> '\e047' , 'feather-icon-microphone'=> '\e048' , 'feather-icon-record'=> '\e049' , 'feather-icon-skip-back'=> '\e050' , 'feather-icon-rewind'=> '\e051' , 'feather-icon-play'=> '\e052' , 'feather-icon-pause'=> '\e053' , 'feather-icon-stop'=> '\e054' , 'feather-icon-fast-forward'=> '\e055' , 'feather-icon-skip-forward'=> '\e056' , 'feather-icon-shuffle'=> '\e057' , 'feather-icon-repeat'=> '\e058' , 'feather-icon-folder'=> '\e059' , 'feather-icon-umbrella'=> '\e060' , 'feather-icon-moon'=> '\e061' , 'feather-icon-thermometer'=> '\e062' , 'feather-icon-drop'=> '\e063' , 'feather-icon-sun'=> '\e064' , 'feather-icon-cloud'=> '\e065' , 'feather-icon-cloud-upload'=> '\e066' , 'feather-icon-cloud-download'=> '\e067' , 'feather-icon-upload'=> '\e068' , 'feather-icon-download'=> '\e069' , 'feather-icon-location'=> '\e070' , 'feather-icon-location-2'=> '\e071' , 'feather-icon-map'=> '\e072' , 'feather-icon-battery'=> '\e073' , 'feather-icon-head'=> '\e074' , 'feather-icon-briefcase'=> '\e075' , 'feather-icon-speech-bubble'=> '\e076' , 'feather-icon-anchor'=> '\e077' , 'feather-icon-globe'=> '\e078' , 'feather-icon-box'=> '\e079' , 'feather-icon-reload'=> '\e080' , 'feather-icon-share'=> '\e081' , 'feather-icon-marquee'=> '\e082' , 'feather-icon-marquee-plus'=> '\e083' , 'feather-icon-marquee-minus'=> '\e084' , 'feather-icon-tag'=> '\e085' , 'feather-icon-power'=> '\e086' , 'feather-icon-command'=> '\e087' , 'feather-icon-alt'=> '\e088' , 'feather-icon-esc'=> '\e089' , 'feather-icon-bar-graph'=> '\e090' , 'feather-icon-bar-graph-2'=> '\e091' , 'feather-icon-pie-graph'=> '\e092' , 'feather-icon-star'=> '\e093' , 'feather-icon-arrow-left'=> '\e094' , 'feather-icon-arrow-right'=> '\e095' , 'feather-icon-arrow-up'=> '\e096' , 'feather-icon-arrow-down'=> '\e097' , 'feather-icon-volume'=> '\e098' , 'feather-icon-mute'=> '\e099' , 'feather-icon-content-right'=> '\e100' , 'feather-icon-content-left'=> '\e101' , 'feather-icon-grid'=> '\e102' , 'feather-icon-grid-2'=> '\e103' , 'feather-icon-columns'=> '\e104' , 'feather-icon-loader'=> '\e105' , 'feather-icon-bag'=> '\e106' , 'feather-icon-ban'=> '\e107' , 'feather-icon-flag'=> '\e108' , 'feather-icon-trash'=> '\e109' , 'feather-icon-expand'=> '\e110' , 'feather-icon-contract'=> '\e111' , 'feather-icon-maximize'=> '\e112' , 'feather-icon-minimize'=> '\e113' , 'feather-icon-plus'=> '\e114' , 'feather-icon-minus'=> '\e115' , 'feather-icon-check'=> '\e116' , 'feather-icon-cross'=> '\e117' , 'feather-icon-move'=> '\e118' , 'feather-icon-delete'=> '\e119' , 'feather-icon-menu'=> '\e120' , 'feather-icon-archive'=> '\e121' , 'feather-icon-inbox'=> '\e122' , 'feather-icon-outbox'=> '\e123' , 'feather-icon-file'=> '\e124' , 'feather-icon-file-add'=> '\e125' , 'feather-icon-file-subtract'=> '\e126' , 'feather-icon-help'=> '\e127' , 'feather-icon-open'=> '\e128' , 'feather-icon-ellipsis'=> '\e129'));
	$et_icons = array ('pack-name'=>'et icons','pack-slug'=>'pack-et-icons', 'icon-pack'=> array ('et-icon-mobile' => '\e000','et-icon-laptop' => '\e001','et-icon-desktop' => '\e002','et-icon-tablet' => '\e003','et-icon-phone' => '\e004','et-icon-document' => '\e005','et-icon-documents' => '\e006','et-icon-search' => '\e007','et-icon-clipboard' => '\e008','et-icon-newspaper' => '\e009','et-icon-notebook' => '\e00a','et-icon-book-open' => '\e00b','et-icon-browser' => '\e00c','et-icon-calendar' => '\e00d','et-icon-presentation' => '\e00e','et-icon-picture' => '\e00f','et-icon-pictures' => '\e010','et-icon-video' => '\e011','et-icon-camera' => '\e012','et-icon-printer' => '\e013','et-icon-toolbox' => '\e014','et-icon-briefcase' => '\e015','et-icon-wallet' => '\e016','et-icon-gift' => '\e017','et-icon-bargraph' => '\e018','et-icon-grid' => '\e019','et-icon-expand' => '\e01a','et-icon-focus' => '\e01b','et-icon-edit' => '\e01c','et-icon-adjustments' => '\e01d','et-icon-ribbon' => '\e01e','et-icon-hourglass' => '\e01f','et-icon-lock' => '\e020','et-icon-megaphone' => '\e021','et-icon-shield' => '\e022','et-icon-trophy' => '\e023','et-icon-flag' => '\e024','et-icon-map' => '\e025','et-icon-puzzle' => '\e026','et-icon-basket' => '\e027','et-icon-envelope' => '\e028','et-icon-streetsign' => '\e029','et-icon-telescope' => '\e02a','et-icon-gears' => '\e02b','et-icon-key' => '\e02c','et-icon-paperclip' => '\e02d','et-icon-attachment' => '\e02e','et-icon-pricetags' => '\e02f','et-icon-lightbulb' => '\e030','et-icon-layers' => '\e031','et-icon-pencil' => '\e032','et-icon-tools' => '\e033','et-icon-tools-2' => '\e034','et-icon-scissors' => '\e035','et-icon-paintbrush' => '\e036','et-icon-magnifying-glass' => '\e037','et-icon-circle-compass' => '\e038','et-icon-linegraph' => '\e039','et-icon-mic' => '\e03a','et-icon-strategy' => '\e03b','et-icon-beaker' => '\e03c','et-icon-caution' => '\e03d','et-icon-recycle' => '\e03e','et-icon-anchor' => '\e03f','et-icon-profile-male' => '\e040','et-icon-profile-female' => '\e041','et-icon-bike' => '\e042','et-icon-wine' => '\e043','et-icon-hotairballoon' => '\e044','et-icon-globe' => '\e045','et-icon-genius' => '\e046','et-icon-map-pin' => '\e047','et-icon-dial' => '\e048','et-icon-chat' => '\e049','et-icon-heart' => '\e04a','et-icon-cloud' => '\e04b','et-icon-upload' => '\e04c','et-icon-download' => '\e04d','et-icon-target' => '\e04e','et-icon-hazardous' => '\e04f','et-icon-piechart' => '\e050','et-icon-speedometer' => '\e051','et-icon-global' => '\e052','et-icon-compass' => '\e053','et-icon-lifesaver' => '\e054','et-icon-clock' => '\e055','et-icon-aperture' => '\e056','et-icon-quote' => '\e057','et-icon-scope' => '\e058','et-icon-alarmclock' => '\e059','et-icon-refresh' => '\e05a','et-icon-happy' => '\e05b','et-icon-sad' => '\e05c','et-icon-facebook' => '\e05d','et-icon-twitter' => '\e05e','et-icon-googleplus' => '\e05f','et-icon-rss' => '\e060','et-icon-tumblr' => '\e061','et-icon-linkedin' => '\e062','et-icon-dribbble' => '\e063'));
	$fontawesome_icons = array ( 'pack-name'=>'fontawesome icons','pack-slug'=>'pack-fontawesome-icons', 'icon-pack'=> array ('fa fa-500px' => '\f26e','fa fa-adjust' => '\f042','fa fa-adn' => '\f170','fa fa-align-center' => '\f037','fa fa-align-justify' => '\f039','fa fa-align-left' => '\f036','fa fa-align-right' => '\f038','fa fa-amazon' => '\f270','fa fa-ambulance' => '\f0f9','fa fa-anchor' => '\f13d','fa fa-android' => '\f17b','fa fa-angellist' => '\f209','fa fa-angle-double-down' => '\f103','fa fa-angle-double-left' => '\f100','fa fa-angle-double-right' => '\f101','fa fa-angle-double-up' => '\f102','fa fa-angle-down' => '\f107','fa fa-angle-left' => '\f104','fa fa-angle-right' => '\f105','fa fa-angle-up' => '\f106','fa fa-apple' => '\f179','fa fa-archive' => '\f187','fa fa-area-chart' => '\f1fe','fa fa-arrow-circle-down' => '\f0ab','fa fa-arrow-circle-left' => '\f0a8','fa fa-arrow-circle-o-down' => '\f01a','fa fa-arrow-circle-o-left' => '\f190','fa fa-arrow-circle-o-right' => '\f18e','fa fa-arrow-circle-o-up' => '\f01b','fa fa-arrow-circle-right' => '\f0a9','fa fa-arrow-circle-up' => '\f0aa','fa fa-arrow-down' => '\f063','fa fa-arrow-left' => '\f060','fa fa-arrow-right' => '\f061','fa fa-arrow-up' => '\f062','fa fa-arrows' => '\f047','fa fa-arrows-alt' => '\f0b2','fa fa-arrows-h' => '\f07e','fa fa-arrows-v' => '\f07d','fa fa-asterisk' => '\f069','fa fa-at' => '\f1fa','fa fa-backward' => '\f04a','fa fa-balance-scale' => '\f24e','fa fa-ban' => '\f05e','fa fa-bar-chart' => '\f080','fa fa-barcode' => '\f02a','fa fa-bars' => '\f0c9','fa fa-battery-empty' => '\f244','fa fa-battery-full' => '\f240','fa fa-battery-half' => '\f242','fa fa-battery-quarter' => '\f243','fa fa-battery-three-quarters' => '\f241','fa fa-bed' => '\f236','fa fa-beer' => '\f0fc','fa fa-behance' => '\f1b4','fa fa-behance-square' => '\f1b5','fa fa-bell' => '\f0f3','fa fa-bell-o' => '\f0a2','fa fa-bell-slash' => '\f1f6','fa fa-bell-slash-o' => '\f1f7','fa fa-bicycle' => '\f206','fa fa-binoculars' => '\f1e5','fa fa-birthday-cake' => '\f1fd','fa fa-bitbucket' => '\f171','fa fa-bitbucket-square' => '\f172','fa fa-black-tie' => '\f27e','fa fa-bold' => '\f032','fa fa-bolt' => '\f0e7','fa fa-bomb' => '\f1e2','fa fa-book' => '\f02d','fa fa-bookmark' => '\f02e','fa fa-bookmark-o' => '\f097','fa fa-briefcase' => '\f0b1','fa fa-btc' => '\f15a','fa fa-bug' => '\f188','fa fa-building' => '\f1ad','fa fa-building-o' => '\f0f7','fa fa-bullhorn' => '\f0a1','fa fa-bullseye' => '\f140','fa fa-bus' => '\f207','fa fa-buysellads' => '\f20d','fa fa-calculator' => '\f1ec','fa fa-calendar' => '\f073','fa fa-calendar-check-o' => '\f274','fa fa-calendar-minus-o' => '\f272','fa fa-calendar-o' => '\f133','fa fa-calendar-plus-o' => '\f271','fa fa-calendar-times-o' => '\f273','fa fa-camera' => '\f030','fa fa-camera-retro' => '\f083','fa fa-car' => '\f1b9','fa fa-caret-down' => '\f0d7','fa fa-caret-left' => '\f0d9','fa fa-caret-right' => '\f0da','fa fa-caret-square-o-down' => '\f150','fa fa-caret-square-o-left' => '\f191','fa fa-caret-square-o-right' => '\f152','fa fa-caret-square-o-up' => '\f151','fa fa-caret-up' => '\f0d8','fa fa-cart-arrow-down' => '\f218','fa fa-cart-plus' => '\f217','fa fa-cc' => '\f20a','fa fa-cc-amex' => '\f1f3','fa fa-cc-diners-club' => '\f24c','fa fa-cc-discover' => '\f1f2','fa fa-cc-jcb' => '\f24b','fa fa-cc-mastercard' => '\f1f1','fa fa-cc-paypal' => '\f1f4','fa fa-cc-stripe' => '\f1f5','fa fa-cc-visa' => '\f1f0','fa fa-certificate' => '\f0a3','fa fa-chain-broken' => '\f127','fa fa-check' => '\f00c','fa fa-check-circle' => '\f058','fa fa-check-circle-o' => '\f05d','fa fa-check-square' => '\f14a','fa fa-check-square-o' => '\f046','fa fa-chevron-circle-down' => '\f13a','fa fa-chevron-circle-left' => '\f137','fa fa-chevron-circle-right' => '\f138','fa fa-chevron-circle-up' => '\f139','fa fa-chevron-down' => '\f078','fa fa-chevron-left' => '\f053','fa fa-chevron-right' => '\f054','fa fa-chevron-up' => '\f077','fa fa-child' => '\f1ae','fa fa-chrome' => '\f268','fa fa-circle' => '\f111','fa fa-circle-o' => '\f10c','fa fa-circle-o-notch' => '\f1ce','fa fa-circle-thin' => '\f1db','fa fa-clipboard' => '\f0ea','fa fa-clock-o' => '\f017','fa fa-clone' => '\f24d','fa fa-cloud' => '\f0c2','fa fa-cloud-download' => '\f0ed','fa fa-cloud-upload' => '\f0ee','fa fa-code' => '\f121','fa fa-code-fork' => '\f126','fa fa-codepen' => '\f1cb','fa fa-coffee' => '\f0f4','fa fa-cog' => '\f013','fa fa-cogs' => '\f085','fa fa-columns' => '\f0db','fa fa-comment' => '\f075','fa fa-comment-o' => '\f0e5','fa fa-commenting' => '\f27a','fa fa-commenting-o' => '\f27b','fa fa-comments' => '\f086','fa fa-comments-o' => '\f0e6','fa fa-compass' => '\f14e','fa fa-compress' => '\f066','fa fa-connectdevelop' => '\f20e','fa fa-contao' => '\f26d','fa fa-copyright' => '\f1f9','fa fa-creative-commons' => '\f25e','fa fa-credit-card' => '\f09d','fa fa-crop' => '\f125','fa fa-crosshairs' => '\f05b','fa fa-css3' => '\f13c','fa fa-cube' => '\f1b2','fa fa-cubes' => '\f1b3','fa fa-cutlery' => '\f0f5','fa fa-dashcube' => '\f210','fa fa-database' => '\f1c0','fa fa-delicious' => '\f1a5','fa fa-desktop' => '\f108','fa fa-deviantart' => '\f1bd','fa fa-diamond' => '\f219','fa fa-digg' => '\f1a6','fa fa-dot-circle-o' => '\f192','fa fa-download' => '\f019','fa fa-dribbble' => '\f17d','fa fa-dropbox' => '\f16b','fa fa-drupal' => '\f1a9','fa fa-eject' => '\f052','fa fa-ellipsis-h' => '\f141','fa fa-ellipsis-v' => '\f142','fa fa-empire' => '\f1d1','fa fa-envelope' => '\f0e0','fa fa-envelope-o' => '\f003','fa fa-envelope-square' => '\f199','fa fa-eraser' => '\f12d','fa fa-eur' => '\f153','fa fa-exchange' => '\f0ec','fa fa-exclamation' => '\f12a','fa fa-exclamation-circle' => '\f06a','fa fa-exclamation-triangle' => '\f071','fa fa-expand' => '\f065','fa fa-expeditedssl' => '\f23e','fa fa-external-link' => '\f08e','fa fa-external-link-square' => '\f14c','fa fa-eye' => '\f06e','fa fa-eye-slash' => '\f070','fa fa-eyedropper' => '\f1fb','fa fa-facebook' => '\f09a','fa fa-facebook-official' => '\f230','fa fa-facebook-square' => '\f082','fa fa-fast-backward' => '\f049','fa fa-fast-forward' => '\f050','fa fa-fax' => '\f1ac','fa fa-female' => '\f182','fa fa-fighter-jet' => '\f0fb','fa fa-file' => '\f15b','fa fa-file-archive-o' => '\f1c6','fa fa-file-audio-o' => '\f1c7','fa fa-file-code-o' => '\f1c9','fa fa-file-excel-o' => '\f1c3','fa fa-file-image-o' => '\f1c5','fa fa-file-o' => '\f016','fa fa-file-pdf-o' => '\f1c1','fa fa-file-powerpoint-o' => '\f1c4','fa fa-file-text' => '\f15c','fa fa-file-text-o' => '\f0f6','fa fa-file-video-o' => '\f1c8','fa fa-file-word-o' => '\f1c2','fa fa-files-o' => '\f0c5','fa fa-film' => '\f008','fa fa-filter' => '\f0b0','fa fa-fire' => '\f06d','fa fa-fire-extinguisher' => '\f134','fa fa-firefox' => '\f269','fa fa-flag' => '\f024','fa fa-flag-checkered' => '\f11e','fa fa-flag-o' => '\f11d','fa fa-flask' => '\f0c3','fa fa-flickr' => '\f16e','fa fa-floppy-o' => '\f0c7','fa fa-folder' => '\f07b','fa fa-folder-o' => '\f114','fa fa-folder-open' => '\f07c','fa fa-folder-open-o' => '\f115','fa fa-font' => '\f031','fa fa-fonticons' => '\f280','fa fa-forumbee' => '\f211','fa fa-forward' => '\f04e','fa fa-foursquare' => '\f180','fa fa-frown-o' => '\f119','fa fa-futbol-o' => '\f1e3','fa fa-gamepad' => '\f11b','fa fa-gavel' => '\f0e3','fa fa-gbp' => '\f154','fa fa-genderless' => '\f22d','fa fa-get-pocket' => '\f265','fa fa-gg' => '\f260','fa fa-gg-circle' => '\f261','fa fa-gift' => '\f06b','fa fa-git' => '\f1d3','fa fa-git-square' => '\f1d2','fa fa-github' => '\f09b','fa fa-github-alt' => '\f113','fa fa-github-square' => '\f092','fa fa-glass' => '\f000','fa fa-globe' => '\f0ac','fa fa-google' => '\f1a0','fa fa-google-plus' => '\f0d5','fa fa-google-plus-square' => '\f0d4','fa fa-google-wallet' => '\f1ee','fa fa-graduation-cap' => '\f19d','fa fa-gratipay' => '\f184','fa fa-h-square' => '\f0fd','fa fa-hacker-news' => '\f1d4','fa fa-hand-lizard-o' => '\f258','fa fa-hand-o-down' => '\f0a7','fa fa-hand-o-left' => '\f0a5','fa fa-hand-o-right' => '\f0a4','fa fa-hand-o-up' => '\f0a6','fa fa-hand-paper-o' => '\f256','fa fa-hand-peace-o' => '\f25b','fa fa-hand-pointer-o' => '\f25a','fa fa-hand-rock-o' => '\f255','fa fa-hand-scissors-o' => '\f257','fa fa-hand-spock-o' => '\f259','fa fa-hdd-o' => '\f0a0','fa fa-header' => '\f1dc','fa fa-headphones' => '\f025','fa fa-heart' => '\f004','fa fa-heart-o' => '\f08a','fa fa-heartbeat' => '\f21e','fa fa-history' => '\f1da','fa fa-home' => '\f015','fa fa-hospital-o' => '\f0f8','fa fa-hourglass' => '\f254','fa fa-hourglass-end' => '\f253','fa fa-hourglass-half' => '\f252','fa fa-hourglass-o' => '\f250','fa fa-hourglass-start' => '\f251','fa fa-houzz' => '\f27c','fa fa-html5' => '\f13b','fa fa-i-cursor' => '\f246','fa fa-ils' => '\f20b','fa fa-inbox' => '\f01c','fa fa-indent' => '\f03c','fa fa-industry' => '\f275','fa fa-info' => '\f129','fa fa-info-circle' => '\f05a','fa fa-inr' => '\f156','fa fa-instagram' => '\f16d','fa fa-internet-explorer' => '\f26b','fa fa-ioxhost' => '\f208','fa fa-italic' => '\f033','fa fa-joomla' => '\f1aa','fa fa-jpy' => '\f157','fa fa-jsfiddle' => '\f1cc','fa fa-key' => '\f084','fa fa-keyboard-o' => '\f11c','fa fa-krw' => '\f159','fa fa-language' => '\f1ab','fa fa-laptop' => '\f109','fa fa-lastfm' => '\f202','fa fa-lastfm-square' => '\f203','fa fa-leaf' => '\f06c','fa fa-leanpub' => '\f212','fa fa-lemon-o' => '\f094','fa fa-level-down' => '\f149','fa fa-level-up' => '\f148','fa fa-life-ring' => '\f1cd','fa fa-lightbulb-o' => '\f0eb','fa fa-line-chart' => '\f201','fa fa-link' => '\f0c1','fa fa-linkedin' => '\f0e1','fa fa-linkedin-square' => '\f08c','fa fa-linux' => '\f17c','fa fa-list' => '\f03a','fa fa-list-alt' => '\f022','fa fa-list-ol' => '\f0cb','fa fa-list-ul' => '\f0ca','fa fa-location-arrow' => '\f124','fa fa-lock' => '\f023','fa fa-long-arrow-down' => '\f175','fa fa-long-arrow-left' => '\f177','fa fa-long-arrow-right' => '\f178','fa fa-long-arrow-up' => '\f176','fa fa-magic' => '\f0d0','fa fa-magnet' => '\f076','fa fa-male' => '\f183','fa fa-map' => '\f279','fa fa-map-marker' => '\f041','fa fa-map-o' => '\f278','fa fa-map-pin' => '\f276','fa fa-map-signs' => '\f277','fa fa-mars' => '\f222','fa fa-mars-double' => '\f227','fa fa-mars-stroke' => '\f229','fa fa-mars-stroke-h' => '\f22b','fa fa-mars-stroke-v' => '\f22a','fa fa-maxcdn' => '\f136','fa fa-meanpath' => '\f20c','fa fa-medium' => '\f23a','fa fa-medkit' => '\f0fa','fa fa-meh-o' => '\f11a','fa fa-mercury' => '\f223','fa fa-microphone' => '\f130','fa fa-microphone-slash' => '\f131','fa fa-minus' => '\f068','fa fa-minus-circle' => '\f056','fa fa-minus-square' => '\f146','fa fa-minus-square-o' => '\f147','fa fa-mobile' => '\f10b','fa fa-money' => '\f0d6','fa fa-moon-o' => '\f186','fa fa-motorcycle' => '\f21c','fa fa-mouse-pointer' => '\f245','fa fa-music' => '\f001','fa fa-neuter' => '\f22c','fa fa-newspaper-o' => '\f1ea','fa fa-object-group' => '\f247','fa fa-object-ungroup' => '\f248','fa fa-odnoklassniki' => '\f263','fa fa-odnoklassniki-square' => '\f264','fa fa-opencart' => '\f23d','fa fa-openid' => '\f19b','fa fa-opera' => '\f26a','fa fa-optin-monster' => '\f23c','fa fa-outdent' => '\f03b','fa fa-pagelines' => '\f18c','fa fa-paint-brush' => '\f1fc','fa fa-paper-plane' => '\f1d8','fa fa-paper-plane-o' => '\f1d9','fa fa-paperclip' => '\f0c6','fa fa-paragraph' => '\f1dd','fa fa-pause' => '\f04c','fa fa-paw' => '\f1b0','fa fa-paypal' => '\f1ed','fa fa-pencil' => '\f040','fa fa-pencil-square' => '\f14b','fa fa-pencil-square-o' => '\f044','fa fa-phone' => '\f095','fa fa-phone-square' => '\f098','fa fa-picture-o' => '\f03e','fa fa-pie-chart' => '\f200','fa fa-pied-piper' => '\f1a7','fa fa-pied-piper-alt' => '\f1a8','fa fa-pinterest' => '\f0d2','fa fa-pinterest-p' => '\f231','fa fa-pinterest-square' => '\f0d3','fa fa-plane' => '\f072','fa fa-play' => '\f04b','fa fa-play-circle' => '\f144','fa fa-play-circle-o' => '\f01d','fa fa-plug' => '\f1e6','fa fa-plus' => '\f067','fa fa-plus-circle' => '\f055','fa fa-plus-square' => '\f0fe','fa fa-plus-square-o' => '\f196','fa fa-power-off' => '\f011','fa fa-print' => '\f02f','fa fa-puzzle-piece' => '\f12e','fa fa-qq' => '\f1d6','fa fa-qrcode' => '\f029','fa fa-question' => '\f128','fa fa-question-circle' => '\f059','fa fa-quote-left' => '\f10d','fa fa-quote-right' => '\f10e','fa fa-random' => '\f074','fa fa-rebel' => '\f1d0','fa fa-recycle' => '\f1b8','fa fa-reddit' => '\f1a1','fa fa-reddit-square' => '\f1a2','fa fa-refresh' => '\f021','fa fa-registered' => '\f25d','fa fa-renren' => '\f18b','fa fa-repeat' => '\f01e','fa fa-reply' => '\f112','fa fa-reply-all' => '\f122','fa fa-retweet' => '\f079','fa fa-road' => '\f018','fa fa-rocket' => '\f135','fa fa-rss' => '\f09e','fa fa-rss-square' => '\f143','fa fa-rub' => '\f158','fa fa-safari' => '\f267','fa fa-scissors' => '\f0c4','fa fa-search' => '\f002','fa fa-search-minus' => '\f010','fa fa-search-plus' => '\f00e','fa fa-sellsy' => '\f213','fa fa-server' => '\f233','fa fa-share' => '\f064','fa fa-share-alt' => '\f1e0','fa fa-share-alt-square' => '\f1e1','fa fa-share-square' => '\f14d','fa fa-share-square-o' => '\f045','fa fa-shield' => '\f132','fa fa-ship' => '\f21a','fa fa-shirtsinbulk' => '\f214','fa fa-shopping-cart' => '\f07a','fa fa-sign-in' => '\f090','fa fa-sign-out' => '\f08b','fa fa-signal' => '\f012','fa fa-simplybuilt' => '\f215','fa fa-sitemap' => '\f0e8','fa fa-skyatlas' => '\f216','fa fa-skype' => '\f17e','fa fa-slack' => '\f198','fa fa-sliders' => '\f1de','fa fa-slideshare' => '\f1e7','fa fa-smile-o' => '\f118','fa fa-sort' => '\f0dc','fa fa-sort-alpha-asc' => '\f15d','fa fa-sort-alpha-desc' => '\f15e','fa fa-sort-amount-asc' => '\f160','fa fa-sort-amount-desc' => '\f161','fa fa-sort-asc' => '\f0de','fa fa-sort-desc' => '\f0dd','fa fa-sort-numeric-asc' => '\f162','fa fa-sort-numeric-desc' => '\f163','fa fa-soundcloud' => '\f1be','fa fa-space-shuttle' => '\f197','fa fa-spinner' => '\f110','fa fa-spoon' => '\f1b1','fa fa-spotify' => '\f1bc','fa fa-square' => '\f0c8','fa fa-square-o' => '\f096','fa fa-stack-exchange' => '\f18d','fa fa-stack-overflow' => '\f16c','fa fa-star' => '\f005','fa fa-star-half' => '\f089','fa fa-star-half-o' => '\f123','fa fa-star-o' => '\f006','fa fa-steam' => '\f1b6','fa fa-steam-square' => '\f1b7','fa fa-step-backward' => '\f048','fa fa-step-forward' => '\f051','fa fa-stethoscope' => '\f0f1','fa fa-sticky-note' => '\f249','fa fa-sticky-note-o' => '\f24a','fa fa-stop' => '\f04d','fa fa-street-view' => '\f21d','fa fa-strikethrough' => '\f0cc','fa fa-stumbleupon' => '\f1a4','fa fa-stumbleupon-circle' => '\f1a3','fa fa-subscript' => '\f12c','fa fa-subway' => '\f239','fa fa-suitcase' => '\f0f2','fa fa-sun-o' => '\f185','fa fa-superscript' => '\f12b','fa fa-table' => '\f0ce','fa fa-tablet' => '\f10a','fa fa-tachometer' => '\f0e4','fa fa-tag' => '\f02b','fa fa-tags' => '\f02c','fa fa-tasks' => '\f0ae','fa fa-taxi' => '\f1ba','fa fa-television' => '\f26c','fa fa-tencent-weibo' => '\f1d5','fa fa-terminal' => '\f120','fa fa-text-height' => '\f034','fa fa-text-width' => '\f035','fa fa-th' => '\f00a','fa fa-th-large' => '\f009','fa fa-th-list' => '\f00b','fa fa-thumb-tack' => '\f08d','fa fa-thumbs-down' => '\f165','fa fa-thumbs-o-down' => '\f088','fa fa-thumbs-o-up' => '\f087','fa fa-thumbs-up' => '\f164','fa fa-ticket' => '\f145','fa fa-times' => '\f00d','fa fa-times-circle' => '\f057','fa fa-times-circle-o' => '\f05c','fa fa-tint' => '\f043','fa fa-toggle-off' => '\f204','fa fa-toggle-on' => '\f205','fa fa-trademark' => '\f25c','fa fa-train' => '\f238','fa fa-transgender' => '\f224','fa fa-transgender-alt' => '\f225','fa fa-trash' => '\f1f8','fa fa-trash-o' => '\f014','fa fa-tree' => '\f1bb','fa fa-trello' => '\f181','fa fa-tripadvisor' => '\f262','fa fa-trophy' => '\f091','fa fa-truck' => '\f0d1','fa fa-try' => '\f195','fa fa-tty' => '\f1e4','fa fa-tumblr' => '\f173','fa fa-tumblr-square' => '\f174','fa fa-twitch' => '\f1e8','fa fa-twitter' => '\f099','fa fa-twitter-square' => '\f081','fa fa-umbrella' => '\f0e9','fa fa-underline' => '\f0cd','fa fa-undo' => '\f0e2','fa fa-university' => '\f19c','fa fa-unlock' => '\f09c','fa fa-unlock-alt' => '\f13e','fa fa-upload' => '\f093','fa fa-usd' => '\f155','fa fa-user' => '\f007','fa fa-user-md' => '\f0f0','fa fa-user-plus' => '\f234','fa fa-user-secret' => '\f21b','fa fa-user-times' => '\f235','fa fa-users' => '\f0c0','fa fa-venus' => '\f221','fa fa-venus-double' => '\f226','fa fa-venus-mars' => '\f228','fa fa-viacoin' => '\f237','fa fa-video-camera' => '\f03d','fa fa-vimeo' => '\f27d','fa fa-vimeo-square' => '\f194','fa fa-vine' => '\f1ca','fa fa-vk' => '\f189','fa fa-volume-down' => '\f027','fa fa-volume-off' => '\f026','fa fa-volume-up' => '\f028','fa fa-weibo' => '\f18a','fa fa-weixin' => '\f1d7','fa fa-whatsapp' => '\f232','fa fa-wheelchair' => '\f193','fa fa-wifi' => '\f1eb','fa fa-wikipedia-w' => '\f266','fa fa-windows' => '\f17a','fa fa-wordpress' => '\f19a','fa fa-wrench' => '\f0ad','fa fa-xing' => '\f168','fa fa-xing-square' => '\f169','fa fa-y-combinator' => '\f23b','fa fa-yahoo' => '\f19e','fa fa-yelp' => '\f1e9','fa fa-youtube' => '\f167','fa fa-youtube-play' => '\f16a','fa fa-youtube-square' => '\f166' ));
	$simpleicon_icons = array ( 'pack-name'=>'simple icons','pack-slug'=>'pack-simple-icons', 'icon-pack'=> array ('simpleicon-user-female' => '\e000' , 'simpleicon-user-follow' => '\e002' , 'simpleicon-user-following' => '\e003' , 'simpleicon-user-unfollow' => '\e004' , 'simpleicon-trophy' => '\e006' , 'simpleicon-screen-smartphone' => '\e010' , 'simpleicon-screen-desktop' => '\e011' , 'simpleicon-plane' => '\e012' , 'simpleicon-notebook' => '\e013' , 'simpleicon-moustache' => '\e014' , 'simpleicon-mouse' => '\e015' , 'simpleicon-magnet' => '\e016' , 'simpleicon-energy' => '\e020' , 'simpleicon-emoticon-smile' => '\e021' , 'simpleicon-disc' => '\e022' , 'simpleicon-cursor-move' => '\e023' , 'simpleicon-crop' => '\e024' , 'simpleicon-credit-card' => '\e025' , 'simpleicon-chemistry' => '\e026' , 'simpleicon-user' => '\e005' , 'simpleicon-speedometer' => '\e007' , 'simpleicon-social-youtube' => '\e008' , 'simpleicon-social-twitter' => '\e009' , 'simpleicon-social-tumblr' => '\e00a' , 'simpleicon-social-facebook' => '\e00b' , 'simpleicon-social-dropbox' => '\e00c' , 'simpleicon-social-dribbble' => '\e00d' , 'simpleicon-shield' => '\e00e' , 'simpleicon-screen-tablet' => '\e00f' , 'simpleicon-magic-wand' => '\e017' , 'simpleicon-hourglass' => '\e018' , 'simpleicon-graduation' => '\e019' , 'simpleicon-ghost' => '\e01a' , 'simpleicon-game-controller' => '\e01b' , 'simpleicon-fire' => '\e01c' , 'simpleicon-eyeglasses' => '\e01d' , 'simpleicon-envelope-open' => '\e01e' , 'simpleicon-envelope-letter' => '\e01f' , 'simpleicon-bell' => '\e027' , 'simpleicon-badge' => '\e028' , 'simpleicon-anchor' => '\e029' , 'simpleicon-wallet' => '\e02a' , 'simpleicon-vector' => '\e02b' , 'simpleicon-speech' => '\e02c' , 'simpleicon-puzzle' => '\e02d' , 'simpleicon-printer' => '\e02e' , 'simpleicon-present' => '\e02f' , 'simpleicon-playlist' => '\e030' , 'simpleicon-pin' => '\e031' , 'simpleicon-picture' => '\e032' , 'simpleicon-map' => '\e033' , 'simpleicon-layers' => '\e034' , 'simpleicon-handbag' => '\e035' , 'simpleicon-globe-alt' => '\e036' , 'simpleicon-globe' => '\e037' , 'simpleicon-frame' => '\e038' , 'simpleicon-folder-alt' => '\e039' , 'simpleicon-film' => '\e03a' , 'simpleicon-feed' => '\e03b' , 'simpleicon-earphones-alt' => '\e03c' , 'simpleicon-earphones' => '\e03d' , 'simpleicon-drop' => '\e03e' , 'simpleicon-drawer' => '\e03f' , 'simpleicon-docs' => '\e040' , 'simpleicon-directions' => '\e041' , 'simpleicon-direction' => '\e042' , 'simpleicon-diamond' => '\e043' , 'simpleicon-cup' => '\e044' , 'simpleicon-compass' => '\e045' , 'simpleicon-call-out' => '\e046' , 'simpleicon-call-in' => '\e047' , 'simpleicon-call-end' => '\e048' , 'simpleicon-calculator' => '\e049' , 'simpleicon-bubbles' => '\e04a' , 'simpleicon-briefcase' => '\e04b' , 'simpleicon-book-open' => '\e04c' , 'simpleicon-basket-loaded' => '\e04d' , 'simpleicon-basket' => '\e04e' , 'simpleicon-bag' => '\e04f' , 'simpleicon-action-undo' => '\e050' , 'simpleicon-action-redo' => '\e051' , 'simpleicon-wrench' => '\e052' , 'simpleicon-umbrella' => '\e053' , 'simpleicon-trash' => '\e054' , 'simpleicon-tag' => '\e055' , 'simpleicon-support' => '\e056' , 'simpleicon-size-fullscreen' => '\e057' , 'simpleicon-size-actual' => '\e058' , 'simpleicon-shuffle' => '\e059' , 'simpleicon-share-alt' => '\e05a' , 'simpleicon-share' => '\e05b' , 'simpleicon-rocket' => '\e05c' , 'simpleicon-question' => '\e05d' , 'simpleicon-pie-chart' => '\e05e' , 'simpleicon-pencil' => '\e05f' , 'simpleicon-note' => '\e060' , 'simpleicon-music-tone-alt' => '\e061' , 'simpleicon-music-tone' => '\e062' , 'simpleicon-microphone' => '\e063' , 'simpleicon-loop' => '\e064' , 'simpleicon-logout' => '\e065' , 'simpleicon-login' => '\e066' , 'simpleicon-list' => '\e067' , 'simpleicon-like' => '\e068' , 'simpleicon-home' => '\e069' , 'simpleicon-grid' => '\e06a' , 'simpleicon-graph' => '\e06b' , 'simpleicon-equalizer' => '\e06c' , 'simpleicon-dislike' => '\e06d' , 'simpleicon-cursor' => '\e06e' , 'simpleicon-control-start' => '\e06f' , 'simpleicon-control-rewind' => '\e070' , 'simpleicon-control-play' => '\e071' , 'simpleicon-control-pause' => '\e072' , 'simpleicon-control-forward' => '\e073' , 'simpleicon-control-end' => '\e074' , 'simpleicon-calendar' => '\e075' , 'simpleicon-bulb' => '\e076' , 'simpleicon-bar-chart' => '\e077' , 'simpleicon-arrow-up' => '\e078' , 'simpleicon-arrow-right' => '\e079' , 'simpleicon-arrow-left' => '\e07a' , 'simpleicon-arrow-down' => '\e07b' , 'simpleicon-ban' => '\e07c' , 'simpleicon-bubble' => '\e07d' , 'simpleicon-camcorder' => '\e07e' , 'simpleicon-camera' => '\e07f' , 'simpleicon-check' => '\e080' , 'simpleicon-clock' => '\e081' , 'simpleicon-close' => '\e082' , 'simpleicon-cloud-download' => '\e083' , 'simpleicon-cloud-upload' => '\e084' , 'simpleicon-doc' => '\e085' , 'simpleicon-envelope' => '\e086' , 'simpleicon-eye' => '\e087' , 'simpleicon-flag' => '\e088' , 'simpleicon-folder' => '\e089' , 'simpleicon-heart' => '\e08a' , 'simpleicon-info' => '\e08b' , 'simpleicon-key' => '\e08c' , 'simpleicon-link' => '\e08d' , 'simpleicon-lock' => '\e08e' , 'simpleicon-lock-open' => '\e08f' , 'simpleicon-magnifier' => '\e090' , 'simpleicon-magnifier-add' => '\e091' , 'simpleicon-magnifier-remove' => '\e092' , 'simpleicon-paper-clip' => '\e093' , 'simpleicon-paper-plane' => '\e094' , 'simpleicon-plus' => '\e095' , 'simpleicon-pointer' => '\e096' , 'simpleicon-power' => '\e097' , 'simpleicon-refresh' => '\e098' , 'simpleicon-reload' => '\e099' , 'simpleicon-settings' => '\e09a' , 'simpleicon-star' => '\e09b' , 'simpleicon-symbol-female' => '\e09c' , 'simpleicon-symbol-male' => '\e09d' , 'simpleicon-target' => '\e09e' , 'simpleicon-volume-1' => '\e09f' , 'simpleicon-volume-2' => '\e0a0' , 'simpleicon-volume-off' => '\e0a1' , 'simpleicon-users' => '\e001' ));

	$all_fonts = array($et_icons, $feather_icons, $fontello_icons, $simpleicon_icons , $fontawesome_icons );
	
	return $all_fonts;
}
function mtheme_get_categories() {
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	return $options_categories;
}
function mtheme_get_posts() {
	$allPosts = get_posts(array('numberposts'=>-1));
	$postNames = array();
	foreach ($allPosts as $key => $post) {
		$postNames[$post->ID]= $post->post_title . " on " . date("F j, Y g:i a",strtotime($post->post_date)). " by " . (get_user_by('id', $post->post_author)->display_name) ;
	}
	return $postNames;
}
add_action('save_post', 'mtheme_save_post_pagebuilder');
function mtheme_save_post_pagebuilder() {
	$aqpb_config = mtheme_page_builder_config();
	$aq_page_builder = new AQ_Page_Builder($aqpb_config);
	$blocks = $aq_page_builder->post_pagebuilder_builderblocks_save();
};
function mtheme_process_shortcode( $shortcode , $encode ) {
	if ( ! is_admin() ) {
	     echo do_shortcode($shortcode);
	} else {
		if ( $encode ) {
			echo '<p>'.html_entity_decode($shortcode).'</p>';
		} else {
			echo $shortcode;
		}

	     
	}
}
// ***************************************
// SAVE BLOCKS
// ***************************************
function pagebuilder_save_template() {

	$msave_data=array();
	
	if ( isSet($_POST['mbuilder_datakeys']) ) {
		$mbuilder_serialized_multikeys = $_POST['mbuilder_datakeys'];
		$sep_keys = explode(",", $mbuilder_serialized_multikeys);
		//print_r($sep_keys);

		//$builder_key = 'aq_multidatakey_' . $template_id;

		$the_key_data_array=array();
		foreach ($sep_keys as $the_keys) {
			//echo $the_keys;
			$the_key_data = isset($_POST['mbuild_data_' . $the_keys]) ? $_POST['mbuild_data_' . $the_keys] : '';
			//print_r($the_key_data);
			$the_key_data_array[] = stripslashes($the_key_data);
		}

		// **********************************************
		// **********************************************
		// ********* Update serialized data *************
		// **********************************************
		//$builder_key = 'aq_datakey_' . $template_id;
		$mbuilder_serialized_data = isset($_POST['mbuilder_serialized_data']) ? $_POST['mbuilder_serialized_data'] : '';
		// echo '<pre>';
		// print_r($mbuilder_serialized_data);
		// echo '</pre>';
		if ( isSet($mbuilder_serialized_data) && !empty($mbuilder_serialized_data) ) {
			//update_post_meta( $template_id, $builder_key , $mbuilder_serialized_data );
		}
	}

	//print_r($_POST['mbuilder_datakeys']);
	//print_r($_POST['mbuilder_serialized_data']);
	//print_r($mbuilder_serialized_multikeys);
	//print_r($mbuilder_serialized_data);

	if(mtheme_valid($_POST['saveTempName'])) {

		$templatename = $_POST['saveTempName'];

		$saveoption = array();

		$saveoption['keys'] = $mbuilder_serialized_multikeys;
		$saveoption['data'] = $the_key_data_array;

		$opt = get_option( 'mtheme_pagebuilder_templates' );

		if ( is_array($opt) ) {
			if (array_key_exists($templatename, $opt)) {
			    $templatename = $templatename . '-' . uniqid();
			}
		}

		$opt[$templatename] = $saveoption;
		update_option('mtheme_pagebuilder_templates', $opt);
	}
	echo $templatename;
	die;
}
add_action('wp_ajax_pagebuilder_save_templates','pagebuilder_save_template');

function pagebuilder_retrieve_blocks() {
	echo base64_encode($_POST['pageBlocks']);
	die;
}
add_action('wp_ajax_pagebuilder_retrieve_blocks', 'pagebuilder_retrieve_blocks');

function pagebuilder_get_template() {
	$template_id = $_POST['postID'];
	$saved_templates = get_option( 'mtheme_pagebuilder_templates');
	$template_to_get = $_POST['getTemp'];



	//$new_build_data = get_post_meta($post_id);
	//$multibuilder_key = 'aq_multidatakey_' . $post_id;
	if (isSet($saved_templates)) {
		$template_serialized_multidata = $saved_templates[$template_to_get]['data'];
	}
	// echo '<pre>';
	// print_r($template_serialized_multidata);
	// echo '</pre>';

	$final_dataset=array();
	if (isSet($template_serialized_multidata) && !empty($template_serialized_multidata)) {
		foreach ($template_serialized_multidata as $key => $data_set ) {
			wp_parse_str($data_set, $multiparams);
			if (isSet($multiparams['aq_blocks'])) {
				foreach ($multiparams['aq_blocks'] as $mkey => $mdata_set ) {
					if (isSet($mdata_set)) {
						$final_dataset[$mkey] = $mdata_set;
					}
				}
			}
		}
	}

	$template_transient_data = $final_dataset;


	$jQserialized = $template_transient_data;

	$blocks=array();
	if (isSet($jQserialized) ) {
		foreach($jQserialized as $jqkey => $jqblock) {
			$serialized_str = serialize($jqblock);
			//echo '------' . $jqkey . '-------';
			if (!empty($serialized_str) && isSet($serialized_str)) {
				$blocks[$jqkey][0]=$serialized_str;
			}
		}
	}

	//$blocks = $final_dataset;
	$saved_blocks = $blocks;
	// echo '<pre>--Finale';
	// print_r($blocks);
	// echo '</pre>';


	// if(array_key_exists($_POST['getTemp'],$blocks)) {
	// 	$blocks = $blocks[$_POST['getTemp']];
	// }
	// else {
	// 	$blocks = array();
	// }
	// $saved_blocks = $blocks;



	if(empty($blocks)) {
		echo '<p class="empty-template">';
		echo __('Drag block items from the left into this area to begin building your template.', 'mthemelocal');
		echo '</p>';
		return;

	} else {
		// //sort by order
	$sort = array();
	$block_mod_array = array();

	foreach($blocks as $key => $block) {
		if(isset($block[0])) {
			$saving_template = false;
			$temp = unserialize($block[0]);
		} else {
			$saving_template = true;
			if(is_array($block)) {
				$temp = $block;
				$blocks[$key] = array(serialize($block));
			} else {
				$temp = unserialize($block);
			}
		}
		if(isset($temp['order']))
			$sort[] = $temp['order'];
		else
			$sort[] = '';
	}
	array_multisort($sort, SORT_NUMERIC, $blocks);

	// echo '<pre>--Sorted';
	// print_r($blocks);
	// echo '</pre>';

	$saved_blocks=$blocks;
	foreach ($blocks as $keys => $values) {
		foreach ($values as $key => $value) {
			$blocks[$keys] = unserialize($value);
		}
	}

	// echo '<pre>--Blocks';
	// print_r($blocks);
	// echo '</pre>';
		//outputs the blocks
		foreach($blocks as $key => $instance) {
			global $aq_registered_blocks;
			if(isset($instance) && !empty($instance) && $instance !=FALSE && is_array($instance)) {
			extract($instance);
			if(isset($id_base) && isset($aq_registered_blocks[$id_base])) {
				//get the block object
				$block = $aq_registered_blocks[$id_base];
				//insert template_id into $instance
				$instance['template_id'] = $template_id;
				$instance['saved_template'] = 1;

				//display the block
				if($parent == 0) {
			// echo '<pre>';
			// print_r($instance);
			// echo '</pre>';
					$block->form_callback($instance,$saved_blocks);
				}
			}
			}
		}
	}
	die;
}
add_action('wp_ajax_pagebuilder_get_templates','pagebuilder_get_template');

function pagebuilder_delete_template() {
	$blocks = get_option( 'mtheme_pagebuilder_templates' );
	// print_a($blocks);echo $_POST['getTemp'];
	if(array_key_exists($_POST['getTemp'],$blocks)) {
		// $blocks = $blocks[$_POST['getTemp']];
		$blocks[$_POST['getTemp']] = '';
		update_option('mtheme_pagebuilder_templates', $blocks);
	}
die;
}
add_action('wp_ajax_pagebuilder_delete_saved_template','pagebuilder_delete_template');
function pagebuilder_import_template() {
	$importing_templates_data = $_POST['importedData'];
	if(mtheme_valid($importing_templates_data)) {
		$importing_templates_data = base64_decode($importing_templates_data);
		if ( is_serialized($importing_templates_data) ) {
			$blocks = unserialize( $importing_templates_data );
			//echo $blocks
			if (is_array($blocks)) {

				if ( isSet($blocks['mtheme-page-builder-data']) ) {

					unset($blocks['mtheme-page-builder-data']);
					delete_option('mtheme_pagebuilder_templates');
					update_option('mtheme_pagebuilder_templates', $blocks);

					//$blocks = get_option( 'mtheme_pagebuilder_templates');
					if ( isSet($blocks) && !empty($blocks) ) {
						$template_selection='';
						$template_selection .= '<option value="">'.__('Select Template','mthemelocal').'</option>';
						foreach ($blocks as $key => $value) {
							if(mtheme_valid($value)) {
								$template_selection .= '<option value="'. $key.'" class="custombuilderblocks">'. $key .'</option>';
							}
						}
						echo $template_selection;
					}
				}
			}
		}
	}
die;
}
add_action('wp_ajax_pagebuilder_import_templates','pagebuilder_import_template');

function builder_import_preset_template() {
	$template_name = $_POST['templateName'];
	$file = MTHEME_BUILDER_PRESETS .'/presets/preset-'.$template_name.'.txt';
	if (file_exists($file)) {
		$preset_content = file_get_contents($file);
	}
	if(isSet($preset_content)) {
		echo stripslashes(base64_decode($preset_content));
	} else {
		echo '';
	}
die;
}
add_action('wp_ajax_builder_import_preset_template','builder_import_preset_template');

function pagebuilder_export_templates() {
	$export_templates = get_option('mtheme_pagebuilder_templates');
	$export_final_data=array();
	if ( isSet($export_templates) && !empty($export_templates)) {
		$export_final_data['mtheme-page-builder-data'] = 'exportstamp-'.current_time('timestamp');
		foreach ($export_templates as $key => $value) {
		    if (empty($value)) {
		        //echo "$key empty <br/>";
		    } else {
				$export_final_data[$key] = $value;
			}
		}
		//print_r($export_final_data);
		echo base64_encode(serialize($export_final_data));
	} else {
		echo '';
	}
	die;
}
add_action('wp_ajax_pagebuilder_export_templates','pagebuilder_export_templates');

function pagebuilder_save_block() {
	if(mtheme_valid($_POST['blocks'])) {
		echo stripslashes(base64_decode($_POST['blocks']));
	}
die;
}
add_action('wp_ajax_pagebuilder_save_blocks','pagebuilder_save_block');

function pagebuilder_export_selected_block() {
	echo base64_encode($_POST['exportedData']);
	die;	
}
add_action('wp_ajax_pagebuilder_export_selected_block','pagebuilder_export_selected_block');

function pagebuilder_import_selected_block() {
	echo stripslashes(base64_decode($_POST['importedData']));
	die;	
}
add_action('wp_ajax_pagebuilder_import_selected_block','pagebuilder_import_selected_block');
?>