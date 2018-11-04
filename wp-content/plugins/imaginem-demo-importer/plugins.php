<?php
check_plugin_request();
function check_plugin_request() {
	if ( isset( $_GET['mtheme-deactivate'] ) && 'deactivate-plugin' == $_GET['mtheme-deactivate'] ) {
		check_admin_referer( 'mtheme-deactivate', 'mtheme-deactivate-nonce' );

		$plugins = TGM_Plugin_Activation::$instance->plugins;

		foreach ( $plugins as $plugin ) {
			if ( $plugin['slug'] == $_GET['plugin'] ) {
				deactivate_plugins( $plugin['file_path'] );
			}
		}
	} if ( isset( $_GET['mtheme-activate'] ) && 'activate-plugin' == $_GET['mtheme-activate'] ) {
		check_admin_referer( 'mtheme-activate', 'mtheme-activate-nonce' );

		$plugins = TGM_Plugin_Activation::$instance->plugins;

		foreach ( $plugins as $plugin ) {
			if ( isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin'] ) {
				activate_plugin( $plugin['file_path'] );

				wp_redirect( admin_url( 'admin.php?page=mtheme-plugins' ) );
				exit;
			}
		}
	}
}
function mtheme_plugin_link( $item ) {
		$installed_plugins = get_plugins();

		$item['sanitized_plugin'] = $item['name'];

		$actions = array();

		// We have a repo plugin
		if ( ! $item['version'] ) {
			$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
		}

		/** We need to display the 'Install' hover link */
		if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
			$actions = array(
				'install' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Install %2$s">Install</a>',
					esc_url( wp_nonce_url(
						add_query_arg(
							array(
								'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
								'plugin'        => urlencode( $item['slug'] ),
								'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
								'plugin_source' => urlencode( $item['source'] ),
								'tgmpa-install' => 'install-plugin',
								'return_url'    => 'fusion_plugins',
							),
							TGM_Plugin_Activation::$instance->get_tgmpa_url()
						),
						'tgmpa-install',
						'tgmpa-nonce'
					) ),
					$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Activate' hover link */
		elseif ( is_plugin_inactive( $item['file_path'] ) ) {
			$actions = array(
				'activate' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Activate %2$s">Activate</a>',
					esc_url( add_query_arg(
						array(
							'plugin'               => urlencode( $item['slug'] ),
							'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
							'plugin_source'        => urlencode( $item['source'] ),
							'mtheme-activate'       => 'activate-plugin',
							'mtheme-activate-nonce' => wp_create_nonce( 'mtheme-activate' ),
						),
						admin_url( 'admin.php?page=mtheme-plugins' )
					) ),
					$item['sanitized_plugin']
				),
			);
		}
		/** We need to display the 'Update' hover link */
		elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
			$actions = array(
				'update' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Install %2$s">Update</a>',
					wp_nonce_url(
						add_query_arg(
							array(
								'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
								'plugin'        => urlencode( $item['slug'] ),

								'tgmpa-update'  => 'update-plugin',
								'plugin_source' => urlencode( $item['source'] ),
								'version'       => urlencode( $item['version'] ),
								'return_url'    => 'fusion_plugins',
							),
							TGM_Plugin_Activation::$instance->get_tgmpa_url()
						),
						'tgmpa-update',
						'tgmpa-nonce'
					),
					$item['sanitized_plugin']
				),
			);
		} elseif ( is_plugin_active( $item['file_path'] ) ) {
			$actions = array(
				'deactivate' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Deactivate %2$s">Deactivate</a>',
					esc_url( add_query_arg(
						array(
							'plugin'                 => urlencode( $item['slug'] ),
							'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
							'plugin_source'          => urlencode( $item['source'] ),
							'mtheme-deactivate'       => 'deactivate-plugin',
							'mtheme-deactivate-nonce' => wp_create_nonce( 'mtheme-deactivate' ),
						),
						admin_url( 'admin.php?page=mtheme-plugins' )
					) ),
					$item['sanitized_plugin']
				),
			);
		}

		return $actions;
}

$mtheme_demo_theme = wp_get_theme();
if ( $mtheme_demo_theme->parent_theme ) {
	$template_dir = basename( get_template_directory() );
	$mtheme_demo_theme  = wp_get_theme( $template_dir );
}
$mtheme_demo_version = $mtheme_demo_theme->get( 'Version' );
$plugins           = TGM_Plugin_Activation::$instance->plugins;
$installed_plugins = get_plugins();
?>
<div class="demo-theme-impoter-plugins">
	<h1><?php _e( 'Kinetika Theme Plugins', 'mtheme_demo' ); ?></h1>
	<div class="mtheme-demo-version theme-demo-notice"><p><?php echo esc_html__( 'Please ensure the required plugins are active', 'mtheme_demo' ) ?></p><?php printf( __( 'Kinetika theme version %s', 'mtheme_demo'), $mtheme_demo_version ); ?></div>

	<div class="mtheme_demo-demo-themes mtheme_demo-install-plugins">
		<div class="theme-demo-browser theme-demo-plugins rendered">
			<?php foreach ( $plugins as $plugin ) : ?>
				<?php
				$class = '';
				$plugin_status = '';
				$file_path = $plugin['file_path'];
				$plugin_action = mtheme_plugin_link( $plugin );

				if ( is_plugin_active( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				} else {
					$class = 'inactive';
				}
				//echo '<pre>';print_r($plugin);echo '</pre>';
				?>
				<div class="theme theme-demo selectable <?php echo $class; ?>">
						<div class="theme-demo-screenshot">
							<?php
							$plugin_image_url = '';
							switch ($plugin['slug']) {
								case 'imaginem-widgets-r4':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-widget.png";
									break;
								case 'imaginem-shortcodes-r7':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-shortcodes.png";
									break;
								case 'imaginem-fullscreen-post-type':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-fullscreen.png";
									break;
								case 'imaginem-portfolio-post-type-r2':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-portfolio.png";
									break;
								case 'imaginem-events':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-event.png";
									break;
								case 'imaginem-photo-proofing':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-proofing.png";
									break;
								case 'imaginem-builder-r2':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-pagebuilder.png";
									break;
								case 'imaginem-photostories':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-stories.png";
									break;
								case 'imaginem-demo-importer':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/imaginem-demos.png";
									break;
								case 'revslider':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/plugin-slider-revolution.png";
									break;
								case 'contact-form-7':
									$plugin_image_url = plugin_dir_url( __FILE__ ) . "images/plugins/plugin-contactform7.png";
									break;
								
								default:
									# code...
									break;
							}
							//echo $plugin_image_url;
							?>
							<img src="<?php echo $plugin_image_url; ?>" alt="" />
							<span class="more-demo-details" id="info-<?php echo $plugin['slug']; ?>">
							<?php
							if ( $plugin_status == "active" ) {
								echo 'Plugin Active';
							} else {
								echo 'Plugin Inactive';
							}
							?>
							</span>
							<div class="mtheme-extra-info plugin-required">
							<?php
							if ( isset( $plugin['required'] ) && $plugin['required'] ) {
								esc_html_e( 'Required', 'mtheme_demo' );
							} else {
								esc_html_e( 'Recommended', 'mtheme_demo' );
							}
							if ( 'active' == $plugin_status ) {
								echo ' ( Active )';
							} else {
								echo ' ( InActive )';
							}
							?>
							</div>
						</div>
						<div class="plugin-info-wrap">
						<h2 class="theme-demo-name">
							<?php echo $plugin['name']; ?>
						</h2>
						<div class="mtheme-extra-info plugin-info">
							<?php if ( isset( $installed_plugins[ $plugin['file_path'] ] ) ) : ?>
								<?php printf( __( 'Version: %1s | <a href="%2s" target="_blank">%3s</a>', 'mtheme_demo' ), $installed_plugins[ $plugin['file_path'] ]['Version'], $installed_plugins[ $plugin['file_path'] ]['AuthorURI'], $installed_plugins[ $plugin['file_path'] ]['Author'] ); ?>
							<?php elseif ( 'bundled' == $plugin['source_type'] ) : ?>
								<?php printf( esc_attr__( 'Available Version: %s', 'mtheme_demo' ), $plugin['version'] ); ?>
							<?php endif; ?>
						</div>
						<div class="mtheme-extra-info theme-actions">
							<?php foreach ( $plugin_action as $action ) { echo $action; } ?>
						</div>
						<?php if ( isset( $plugin_action['update'] ) && $plugin_action['update'] ) : ?>
							<div class="mtheme-extra-info theme-update">
								<?php printf( __( 'Update Available: Version %s', 'mtheme_demo' ), $plugin['version'] ); ?>
							</div>
						<?php endif; ?>
						</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="mtheme_demo-thanks">
		<p class="description"><?php esc_html_e( 'Thank you for choosing Kinetika Theme!.', 'mtheme_demo' ); ?></p>
	</div>
</div>
<div class="clearfix" style="clear: both;"></div>