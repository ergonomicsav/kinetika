<?php
function mtheme_display_user_index_query( $args = array() ) {

	global $mtheme_userdefined_topic_status;

	extract(shortcode_atts(array(
		"limit" => "-1",
		"status" => "",
		"assigned" => "",
		"replies" => ""
	), $mtheme_userdefined_topic_status));

		$args['author']			= 0;
		$args['post_type']      = bbp_get_topic_post_type();
		$args['post_status']    = array( bbp_get_public_status_id(), !bbp_get_closed_status_id() );
		$args['show_stickies']	= false;
		$args['order']			= 'DESC';
		$args['orderby']		= 'meta_value';
		$args['posts_per_page'] = '10';

		$looking_for='';
		if ( $replies != '' ) {
			$looking_for = "replies";
		}
		if ( $assigned != '' ) {
			$looking_for = "assigned";
		}
		if ( $status != '' ) {
			$looking_for = "status";
		}

		switch ($looking_for) {
			case 'replies':
				if ($replies=='none') {
					$args['meta_key']      = '_bbp_reply_count';
					$args['meta_value']    = 1;
					$args['meta_compare']  = '<';
					$args['orderby']       = '';
					$args['show_stickies'] = false;
				}
				if ($replies=='recent') {
					$args['meta_key']		= '_bbp_last_active_time';
					$args['orderby']		= 'meta_value';
					$args['no_found_rows']  = true;
					$args['order']			= 'DESC';
				}
				break;

			case 'assigned':
				$args['meta_key'] = '_mtheme_support_topic_lastmodified';
				$args['meta_query'] = array(
						array(
							'key' => '_mtheme_support_assigned_id',
							'value' => $assigned,
							'compare' => 'LIKE',
							),
						);
				break;

			case 'status':
				if ($status != -1) {
					$args['meta_key'] = '_mtheme_support_topic_lastmodified';
					$args['meta_query'] = array(
							array(
								'key' => '_mtheme_support_topic_status',
								'value' => $status,
								'compare' => 'LIKE',
								),
							);
				} else {
					$args['meta_query'] = array(
							array(
								'key' => '_mtheme_support_topic_status',
								'compare' => 'NOT EXISTS',
								),
							);
				}
				break;
			
			default:
				# code...
				break;
		}

		return $args;
	}

function mtheme_bbpress_user_index_withvalue_pagination( $args ) {
		if ( isSet($_GET['bbp_mtheme_support_status']) ) {
				$support_status = $_GET['bbp_mtheme_support_status'];
			    // append value to pagination
				$args['add_args'] = array( 'bbp_mtheme_support_status' => $support_status );
		}
		if ( isSet($_GET['bbp_mtheme_support_member_id']) ) {
				$support_member = $_GET['bbp_mtheme_support_member_id'];
			    // append value to pagination
				$args['add_args'] = array( 'bbp_mtheme_support_member_id' => $support_member );
		}
		if ( isSet($_GET['bbp_mtheme_support_reply']) ) {
				$support_replies = $_GET['bbp_mtheme_support_reply'];
			    // append value to pagination
				$args['add_args'] = array( 'bbp_mtheme_support_reply' => $support_replies );
		}
		return $args;
}

function mtheme_list_bbpress($atts, $content = null) {
	extract(shortcode_atts(array(
		"limit" => "-1",
		"status" => "",
		"assigned" => ""
	), $atts));

	global $mtheme_userdefined_topic_status;
	$mtheme_userdefined_topic_status = array();
	$mtheme_userdefined_topic_status = $atts;

	ob_start();
	// Unset globals
	//echo $mtheme_userdefined_topic_status;
	// Filter the query
	add_filter( 'bbp_topic_pagination', 'mtheme_bbpress_user_index_withvalue_pagination' );
	add_filter( 'bbp_before_has_topics_parse_args', 'mtheme_display_user_index_query' );

	// Start output buffer
	bbp_get_template_part( 'mtheme', 'archive-topic' );

	return ob_get_clean();

}
add_shortcode("list_bbpress", "mtheme_list_bbpress");
?>