<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new mtheme_shortcodes( $popup );

$mtheme_plugin_shortcodes_list = array(
		array(
			"id" => "fullpageblock",
			"title" => "Fullpage Block",
			"icon" => "arrows-h",
			"active" => false
			),
		array(
			"id" => "heroimage",
			"title" => "Generate Hero image",
			"icon" => "star",
			"active" => false
			),
		array(
			"id" => "photocard",
			"title" => "Generate Photocard",
			"icon" => "star",
			"active" => false
			),
		array(
			"id" => "fontawesome",
			"title" => "Icons",
			"help" => "Add an icon",
			"icon" => "flag",
			"active" => true
			),
		array(
			"id" => "socials",
			"icon" => "group",
			"title" => "Social",
			"active" => true
			),
		array(
			"id" => "clients",
			"icon" => "asterisk",
			"title" => "Clients",
			"active" => false
			),
		array(
			"id" => "callout",
			"icon" => "info",
			"title" => "Callout Box",
			"active" => true
			),
		array(
			"id" => "map",
			"icon" => "map-marker",
			"title" => "Google Maps",
			"active" => true
			),
		array(
			"id" => "recent_portfolio_slideshow",
			"icon" => "desktop",
			"title" => "Portfolio Slideshow",
			"active" => true
			),
		array(
			"id" => "recent_blog_slideshow",
			"icon" => "desktop",
			"title" => "Blog Slideshow",
			"active" => true
			),
		array(
			"id" => "slideshowcarousel",
			"icon" => "desktop",
			"title" => "Slideshow",
			"active" => true
			),
		array(
			"id" => "audioplayer",
			"icon" => "music",
			"title" => "Audio Player",
			"active" => true
			),
		array(
			"id" => "pullquote",
			"icon" => "quote-left",
			"title" => "Pullquote",
			"active" => true
			),
		array(
			"id" => "highlight",
			"icon" => "eye",
			"title" => "Highlight",
			"active" => true
			),
		array(
			"id" => "dropcap",
			"icon" => "circle-o",
			"title" => "Dropcap",
			"active" => true
			),
		array(
			"id" => "pricing_table",
			"icon" => "usd",
			"title" => "Pricing Table",
			"active" => false
			),
		array(
			"id" => "columns",
			"icon" => "align-justify",
			"title" => "Columns",
			"active" => true
			),
		array(
			"id" => "button",
			"icon" => "hand-o-up",
			"title" => "Buttons",
			"active" => true
			),
		array(
			"id" => "alert",
			"icon" => "warning",
			"title" => "Alerts",
			"active" => true
			),
		array(
			"id" => "count",
			"icon" => "clock-o",
			"title" => "From-To Counter",
			"active" => true
			),
		array(
			"id" => "counter",
			"icon" => "circle-o",
			"title" => "Circular Counter",
			"active" => true
			),
		array(
			"id" => "staff",
			"icon" => "user",
			"title" => "Staff",
			"active" => false
			),
		array(
			"id" => "accordions",
			"icon" => "tasks",
			"title" => "Accordion",
			"active" => true
			),
		array(
			"id" => "checklist",
			"icon" => "check",
			"title" => "Checklist",
			"active" => true
			),
		array(
			"id" => "toggle",
			"icon" => "plus",
			"title" => "Toggle",
			"active" => true
			),
		array(
			"id" => "tabs",
			"icon" => "folder",
			"title" => "Tabs",
			"active" => true
			),
		array(
			"id" => "lightbox",
			"icon" => "search-plus",
			"title" => "Lightbox",
			"active" => true
			),
		array(
			"id" => "thumbnails",
			"icon" => "th-large",
			"title" => "Thumbnails",
			"active" => true
			),
		array(
			"id" => "testimonials",
			"icon" => "comment",
			"title" => "Testimonials",
			"active" => false
			),
		array(
			"id" => "progressbar",
			"icon" => "ellipsis-h",
			"title" => "Progress Bar",
			"active" => true
			),
		array(
			"id" => "recent_blog_listbox",
			"icon" => "list",
			"title" => "Column Blog list",
			"active" => false
			),
		array(
			"id" => "recentblog",
			"icon" => "list-ul",
			"title" => "Recent Blog",
			"active" => true
			),
		array(
			"id" => "workscarousel",
			"icon" => "heart",
			"title" => "Works Carousel",
			"active" => true
			),
		array(
			"id" => "portfoliogrid",
			"icon" => "th",
			"title" => "Portfolio Grid",
			"active" => true
			),
		array(
			"id" => "infoboxes",
			"icon" => "lightbulbo",
			"title" => "Information Boxes",
			"active" => true
			),
		array(
			"id" => "serviceboxes",
			"icon" => "gear",
			"title" => "Service Boxes",
			"active" => true
			),
		array(
			"id" => "heading",
			"icon" => "bolt",
			"title" => "Section Heading",
			"active" => true
			),
		array(
			"id" => "divider",
			"icon" => "minus",
			"title" => "Divider",
			"active" => true
			),
		array(
			"id" => "anchor",
			"icon" => "anchor",
			"title" => "Anchor",
			"active" => true
			),
		array(
			"id" => "worktype_albums",
			"icon" => "bookmark",
			"title" => "Work type albums",
			"active" => true
			),
		array(
			"id" => "woobestselling",
			"icon" => "shopping-cart",
			"title" => "WooCommerce Best Selling",
			"active" => false
			)
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="mtheme-popup">

	<div id="mtheme-shortcode-wrap">

		<div id="mtheme-sc-form-wrap">
			<div>
			<form method="post" id="mtheme-sc-form">

				<table id="mtheme-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody class="mtheme-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="mtheme-insert"><i class="fa fa-bolt"></i> <?php _e('Generate Shortcode','mthemelocal'); ?></a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#mtheme-sc-form-table -->

			</form>
			</div>

			<div class="mtheme-shortcode-choice-wrap">
				<div class="mtheme_shortcode_choice_toggle"><i class="fa fa-bolt"></i> <span><?php _e('Choose a Shortcode','mthemelocal'); ?></span></div>
				<div class="mtheme-form-select-field clearfix">
					<div id="mtheme_shortcode_choices">
					<?php

					foreach ($mtheme_plugin_shortcodes_list as $mtheme_plugin_shortcode) {
						if ($mtheme_plugin_shortcode["active"]) {
								//echo $shortcode_container["title"];
							$mtheme_curr_active_shortcode="";
							if ($popup==$mtheme_plugin_shortcode["id"]) {
								$mtheme_curr_active_shortcode="mtheme-shortcode-active";
							}
							echo '<div class="mtheme_shortcode_choice_box '.$mtheme_curr_active_shortcode.'" data-id="'.$mtheme_plugin_shortcode["id"].'" data-title="'.$mtheme_plugin_shortcode["title"].'">';
							$icon_badge="flag";
							if (isSet($mtheme_plugin_shortcode["icon"])) {
								$icon_badge = $mtheme_plugin_shortcode["icon"];
							} 
							echo '<i class="fa fa-'.$icon_badge.'"></i><span>'.$mtheme_plugin_shortcode["title"].'</span></div>';
						}
					}
					?>
					</div>
				</div>
			</div>
			<!-- /#mtheme-sc-form -->

		</div>
		<!-- /#mtheme-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#mtheme-shortcode-wrap -->

</div>
<!-- /#mtheme-popup -->

</body>
</html>