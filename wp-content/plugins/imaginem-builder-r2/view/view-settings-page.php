<?php
/**
 * Builder Page
 *
 * @description Main admin UI settings page
 * @package Aqua Page Builder
 *
 */
// Debugging
if(isset($_POST) && $this->args['debug'] == true) {
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}

// Permissions Check
global $post;
if ( ! current_user_can( 'edit_post', $post->ID ) )
	wp_die( __( 'Cheatin&#8217; uh?','theme' ) );

$messages = array();

// Get selected template id
$selected_template_id = isset($_REQUEST['template']) ? (int) $_REQUEST['template'] : 0;

// Actions
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'edit';
$template = isset($_REQUEST['template']) ? $_REQUEST['template'] : 0;


// Template title & layout
$template_name = isset($_REQUEST['template-name']) && !empty($_REQUEST['template-name']) ? htmlspecialchars($_REQUEST['template-name']) : 'No Title';

// Get all templates
$templates = $this->get_templates();

// Get recently edited template
$recently_edited_template = (int) get_user_option( 'recently_edited_template' );

if( ! isset( $_REQUEST['template'] ) && $recently_edited_template && $this->is_template( $recently_edited_template )) {
	$selected_template_id = $recently_edited_template;
} elseif ( ! isset( $_REQUEST['template'] ) && $selected_template_id == 0 && !empty($templates)) {
	$selected_template_id = $templates[0]->ID;
}


//define selected template object
$selected_template_object = get_post($selected_template_id);

// saving action
switch($action) {

	case 'create' :
		$new_id = $this->create_template($template_name);

		if(!is_wp_error($new_id)) {
			$selected_template_id = $new_id;

			//refresh templates var
			$templates = $this->get_templates();
			$selected_template_object = get_post($selected_template_id);

			$messages[] = '<div id="message" class="updated"><p>' . __('The ', 'mthemelocal') . '<strong>' . $template_name . '</strong>' . __(' page template has been successfully created', 'mthemelocal') . '</p></div>';
		} else {
			$errors = '<ul>';
			foreach( $new_id->get_error_messages() as $error ) {
				$errors .= '<li><strong>'. $error . '</strong></li>';
			}
			$errors .= '</ul>';

			$messages[] = '<div id="message" class="error"><p>' . __('Sorry, the operation was unsuccessful for the following reason(s): ', 'mthemelocal') . '</p>' . $errors . '</div>';
		}

		break;

	case 'update' :
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		die();
		$blocks = isset($_REQUEST['aq_blocks']) ? $_REQUEST['aq_blocks'] : '';

		$this->update_template($selected_template_id, $blocks, $template_name);

		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_object = get_post($selected_template_id);

		$messages[] = '<div id="message" class="updated"><p>' . __('The ', 'mthemelocal') . '<strong>' . $template_name . '</strong>' . __(' page template has been updated', 'mthemelocal') . '</p></div>';
		break;

	case 'delete' :

		$this->delete_template($selected_template_id);

		//refresh templates var
		$templates = $this->get_templates();
		$selected_template_id =	!empty($templates) ? $templates[0]->ID : 0;
		$selected_template_object = get_post($selected_template_id);

		$messages[] = '<div id="message" class="updated"><p>' . __('The template has been successfully deleted', 'mthemelocal') . '</p></div>';
		break;
}

global $current_user;
update_user_option($current_user->ID, 'recently_edited_template', $selected_template_id);

//display admin notices & messages
if(!empty($messages)) foreach($messages as $message) { echo $message; }

//disable blocks archive if no template
$disabled = $selected_template_id === 0 ? 'metabox-holder-disabled' : '';

?>

<div class="wrap" style="clear: both;width:100%">
	<div id="page-builder-frame">
		<div id="page-builder-column" class="metabox-holder">
			<div id="page-builder-archive" class="postbox">
				<h3 class="hndle"><span><?php _e('Available Blocks', 'mthemelocal') ?></span><span id="removing-block"><?php _e('Deleting', 'mthemelocal') ?></span></h3>
				<div class="inside">
					<ul id="blocks-archive" class="cf">
						<?php $this->blocks_archive() ?>
					</ul>
					<div class="modal fade cf" id="pagebuilder-icon-picker-modal">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
									<div class="iconchoice-selected">
										<i class="fontawesome_icon"></i>
										<p class="iconofchoice-title"></p>
									</div>
									<div class="mtheme-icon-search">
										<input placeholder="icon Search" id="mtheme-icon-live-search" type="text"><i class="fa fa-search"></i>
										<div class="icon-pack-selector-wrap">
										<?php
										$icons = mtheme_builder_iconpicker();
										echo '<div data-iconpack="all" class="icon-filters icon-filter-all">All</div>';
										foreach($icons as $icono => $css_codeo) :
											echo '<div data-iconpack="'.$css_codeo['pack-slug'].'" class="icon-filters icon-filter-'.$css_codeo['pack-slug'].'">'.$css_codeo['pack-name'].'</div>';
 										endforeach;
 										?>
 										</div>
									</div>
									<div class="icon-choosable">
										<?php
										$icons = mtheme_builder_iconpicker();
										foreach($icons as $icono => $css_codeo) :
											foreach($css_codeo['icon-pack'] as $icon => $css_code) :
													if($icon == 'none'){
														echo '<span class="fontawesome_icon none" data-icon="none">none</span>';
													}else{
												 		echo '<div class="fontawesome-icon-wrap '.$css_codeo['pack-slug'].'">';
														echo '<i class="fontawesome_icon '.$icon.'" data-icon="'.$icon.'"></i>';
														echo '</div>';
													}
	 										endforeach;
 										endforeach;
 										?>
									</div>
								</div>
								<div class="modal-footer">
									<button class="pagebuilder-icon-picker-done button-primary" type="button"><?php _e('Done','mthemelocal'); ?></button>
									<button class="button-secondary"  type="button" data-dismiss="modal"><?php _e('Cancel','mthemelocal'); ?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="page-builder-fixed">
			<div id="page-builder">
				<div class="aqpb-wrap aqpbdiv">
						<div id="aqpb-header">

								<div id="history-cache" class="submitbox">
									<div class="major-publishing-actions cf">

										<a href="#" class="emptyTemplates"><i class="fa fa-times-circle-o"></i><span> <?php _e('Clear All','mthemelocal'); ?></span></a>					
										<a href="#" class="em_redo disabled" data-index="0"><i class="fa fa-undo fa-flip-horizontal"></i><span> <?php _e('Redo','mthemelocal'); ?></span></a>
										<a href="#" class="em_undo disabled" data-index="0"><i class="fa fa-undo"></i><span> <?php _e('Undo','mthemelocal'); ?></span></a>

										<div class="import-a-block">
											<a href="#mtheme-pb-import-a-block" id="import-a-block" data-toggle="modal"><i class="fa fa-download"></i> <?php _e('Import Blocks','mthemelocal'); ?></a>
										</div>
										<div class="export-all-blocks">
											<a href="#mtheme-pb-export-all-blocks" data-toggle="modal" id="retrievePosts"><i class="fa fa-upload"></i> <?php _e('Export Blocks','mthemelocal'); ?></a>
										</div>
										<div class="add-preset-templates">
											<span id="toggle-preset-buttons"><i class="presets-active fa fa-times"></i><i class="presets-inactive fa fa-plus"></i> <?php _e('Preset Templates','mthemelocal'); ?></span>
										</div>
									</div>
								</div>
								<div id="mtheme-preset-templates" data-theme="kinetika" data-path="<?php echo MTHEME_BUILDER_PRESETS; ?>">
									<div class="preset-template-msg"><?php _e('Choose a Preset Template','mthemelocal'); ?></div>
									<div class="preset-template-sub-msg"><?php _e('Selecting and confirming one will replace the pagebuilder blocks with the preset blocks.','mthemelocal'); ?></div>
									<?php
									require_once( MTHEME_BUILDER_PRESETS .'/preset-data.php');
									foreach ($presets as $preset) {
										//print_r($preset);
?>
									<div class="preset-template" data-template="<?php echo $preset['slug']; ?>" data-title="<?php echo $preset['name']; ?>">
										<a href="#mtheme-preset-template-confirm" data-toggle="modal" class="presetToggle"><i class="fa fa-plus"></i> <?php echo $preset['name']; ?></a>
									</div>
<?php
									}
									?>
								</div>

								<?php
								if($selected_template_id === 0) {
									wp_nonce_field( 'create-template', 'create-template-nonce' );
								} else {
									wp_nonce_field( 'update-template', 'update-template-nonce' );
								}
								?>
								<input type="hidden" name="template" id="template" value="<?php echo $post->ID ?>"/>
						</div>
						<div class="preloader hide">
						</div>
						<div id="aqpb-body">
							<ul class="blocks cf" id="blocks-to-edit">
								<?php
									AQ_Page_Builder::display_blocks($post->ID);
								?>
							</ul>
						</div>

						<div id="aqpb-footer">
							<div class="pagebuilderSavedTemplates">
								<select id="pagebuilderSavedTemplates" class="chosen-select">
									<option value=""><?php _e('Select Template','mthemelocal'); ?></option>
									<?php
										$blocks = get_option( 'mtheme_pagebuilder_templates');
										if ( isSet($blocks) && !empty($blocks) ) {
											foreach ($blocks as $key => $value) {
												if(mtheme_valid($value)) {
													?>
													<option value="<?php echo $key; ?>" class="custombuilderblocks"><?php echo $key?></option>
													<?php
												}
											}
										}
									?>
								</select>
							</div>
							<a href="#mtheme-pb-delete-template" data-toggle="modal" class="deleteTemplates" id="pagebuildertemplatedelete" data-postid="<?php echo $post->ID ?>"><i class="fa fa-trash-o"></i> <?php _e('Delete Template','mthemelocal'); ?></a>
							<div id="template-shortcode">
								<input type="text" readonly="readonly" value='[template id="<?php echo $post->ID ?>"]' onclick="select()"/>
							</div>
							<div class="blockskeep">
								<a href="#mtheme-pb-export-templates" data-toggle="modal" class="templates-export-button"><i class="fa fa-upload"></i> <?php _e('Export Templates','mthemelocal'); ?></a>
								<a href="#mtheme-pb-import-templates" data-toggle="modal" class="templates-import-button"><i class="fa fa-download"></i> <?php _e('Import Templates','mthemelocal'); ?></a>
							</div>
							<div style="float: right;" data-container="body" data-toggle="popover" data-placement="top" data-content='<input type="text" placeholder="<?php _e('Template Name','mthemelocal'); ?>" id="titleforTemplateStorage" /><a href="#" class="button button-primary button-small" id="pagebuildertemplatesave" data-postid="<?php echo $post->ID ?>"><?php _e('Save','mthemelocal'); ?></a> <a href="#" class="button button-primary button-small" id="closepagebuildertemplatesave" data-postid="<?php echo $post->ID ?>"><?php _e('Close','mthemelocal'); ?></a>'>
								<a id="templateSaver" class=""><i class="fa fa-save"></i> <?php _e('Save Template','mthemelocal'); ?></a>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<!-- Single Export block Modal -->
<div class="modal fade" id="mtheme-pb-export-a-block">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Single block import code','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Select All and copy export code.','mthemelocal'); ?></p>
				<textarea readonly id="exportedBlock" rows="8"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default button" data-dismiss="modal"><?php _e('Close','mthemelocal'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End of Modal -->
<!-- All blocks Export modal -->
<div class="modal fade" id="mtheme-pb-export-all-blocks">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Import code for all blocks','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Select All and copy export code.','mthemelocal'); ?></p>
				<textarea readonly id="retrieveBuilderTemplate" rows="8"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default button" data-dismiss="modal"><?php _e('Close','mthemelocal'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End of Modal -->
<!-- All Templates Export modal -->
<div class="modal fade" id="mtheme-pb-export-templates">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Import code for all Templates','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Click Retrieve button to populate import data. Select All and copy code.','mthemelocal'); ?></p>
				<textarea readonly id="exportBuilderTemplate" rows="8"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default button" data-dismiss="modal"><?php _e('Close','mthemelocal'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- Cant be Deleted Modal -->
<div class="modal fade" id="cantbedeleted">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Delete failed!','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Sorry, that template cant be deleted.','mthemelocal'); ?></p>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="mtheme-pb-delete-template">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Confirm delete','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Are you sure you want to delete the selected template','mthemelocal'); ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="button button-primary"><?php _e('Delete','mthemelocal'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End of Modal -->
<!-- All Templates Import modal -->
<div class="modal fade" id="mtheme-pb-import-templates">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Import Builder Templates','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Enter import data for all templates','mthemelocal'); ?></p>
				<textarea id="importBuilderTemplate" name="mtheme_pagebuilder_templates" rows="8" cols="40"></textarea>
				<div id="importdata-error"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="button button-primary"><?php _e('Import Templates','mthemelocal'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- Import Block Modal -->
<div class="modal fade" id="mtheme-pb-import-a-block">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Import Blocks','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Paste code for single or multiple blocks.','mthemelocal'); ?></p>
				<textarea></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="button button-primary"><?php _e('Import','mthemelocal'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End of Modal -->
<div class="modal fade" id="mtheme-preset-template-confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div type="button" class="tb-close-icon" data-dismiss="modal" aria-hidden="true"></div>
				<h2><?php _e('Import Preset Template','mthemelocal'); ?></h2>
			</div>
			<div class="modal-body">
				<p><?php _e('Replace all blocks with ','mthemelocal'); ?><strong><span class="preset-template-name"></span></strong></p>
				<input hidden type="text" readonly="readonly" value='' name="mtheme-preset-slug" id="mtheme-preset-slug" />
				<div id="preset-template-error"><?php _e('Import Failed!','mthemelocal'); ?></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="button button-primary"><?php _e('Add Preset','mthemelocal'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php
$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
if (!isSet($isactive)) {
	$isactive=0;
}
?>
<input type="hidden" id="mtheme_pb_isactive" name="mtheme_pb_isactive" value="<?php echo $isactive; ?>"/>

