
<?php
function demo_importer_plugin_let_to_num( $v ) {
	$l   = substr( $v, -1 );
	$ret = substr( $v, 0, -1 );

	switch ( strtoupper( $l ) ) {
		case 'P': // fall-through
		case 'T': // fall-through
		case 'G': // fall-through
		case 'M': // fall-through
		case 'K': // fall-through
			$ret *= 1024;
			break;
		default:
			break;
	}

	return $ret;
}
/**
 * Get user host
 *
 * Returns the webhost this site is using if possible
 *
 * @since 2.0
 * @return mixed string $host if detected, false otherwise
 */
function demo_importer_plugin_sss_get_host() {
	$host = false;

	if( defined( 'WPE_APIKEY' ) ) {
		$host = 'WP Engine';
	} elseif( defined( 'PAGELYBIN' ) ) {
		$host = 'Pagely';
	} elseif( DB_HOST == 'localhost:/tmp/mysql5.sock' ) {
		$host = 'ICDSoft';
	} elseif( DB_HOST == 'mysqlv5' ) {
		$host = 'NetworkSolutions';
	} elseif( strpos( DB_HOST, 'ipagemysql.com' ) !== false ) {
		$host = 'iPage';
	} elseif( strpos( DB_HOST, 'ipowermysql.com' ) !== false ) {
		$host = 'IPower';
	} elseif( strpos( DB_HOST, '.gridserver.com' ) !== false ) {
		$host = 'MediaTemple Grid';
	} elseif( strpos( DB_HOST, '.pair.com' ) !== false ) {
		$host = 'pair Networks';
	} elseif( strpos( DB_HOST, '.stabletransit.com' ) !== false ) {
		$host = 'Rackspace Cloud';
	} elseif( strpos( DB_HOST, '.sysfix.eu' ) !== false ) {
		$host = 'SysFix.eu Power Hosting';
	} elseif( strpos( $_SERVER['SERVER_NAME'], 'Flywheel' ) !== false ) {
		$host = 'Flywheel';
	} else {
		// Adding a general fallback for data gathering
		$host = 'DBH: ' . DB_HOST . ', SRV: ' . $_SERVER['SERVER_NAME'];
	}

	return $host;
} ?>
<div class="demo-theme-impoter-plugins">
	<h1><?php _e( 'System Status', 'mtheme_demo' ); ?></h1>
</div>
<div class="system-table-wrap">
<table class="system-table">
<tbody>
<tr><th colspan="2">WordPress Environment</th></tr>
<tr><td>Home URL:                 </td><td><?php echo home_url() . "\n"; ?></td></tr>
<tr><td>Site URL:                 </td><td><?php echo site_url() . "\n"; ?></td></tr>
<tr><td>WP Version:               </td><td><?php echo get_bloginfo( 'version' ) . "\n"; ?></td></tr>
<tr><td>WP_DEBUG:                 </td><td><?php echo defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' . "\n" : 'Disabled' . "\n" : 'Not set' . "\n" ?></td></tr>
<tr><td>WP Language:              </td><td><?php echo ( defined( 'WPLANG' ) && WPLANG ? WPLANG : 'en_US' ) . "\n"; ?></td></tr>
<tr><td>Multisite:                </td><td><?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?></td></tr>
<tr><td>WP Memory Limit:          </td><td><?php echo ( demo_importer_plugin_let_to_num( WP_MEMORY_LIMIT )/( 1024 ) )."MB"; ?><?php echo "\n"; ?></td></tr>
<tr><td>WP Table Prefix:          </td><td><?php echo $wpdb->prefix. "\n"; ?></td></tr>
<tr><td>WP Table Prefix Length:	  </td><td><?php echo strlen( $wpdb->prefix ). "\n"; ?></td></tr>
<tr><td>Permalink Structure:      </td><td><?php echo get_option( 'permalink_structure' ) . "\n"; ?></td></tr>
</tbody>
</table>
<table class="system-table">
<tbody>
<tr><th colspan="2">Theme Information</th></tr>
<?php $active_theme = wp_get_theme(); ?>
<tr><td>Theme Name:               </td><td><?php echo $active_theme->Name . "\n"; ?></td></tr>
<tr><td>Theme Version:            </td><td><?php echo $active_theme->Version . "\n"; ?></td></tr>
<tr><td>Theme Author:             </td><td><?php echo $active_theme->get('Author') . "\n"; ?></td></tr>
<tr><td>Theme Author URI:         </td><td><?php echo $active_theme->get('AuthorURI') . "\n"; ?></td></tr>
<tr><td>Is Child Theme:           </td><td><?php echo is_child_theme() ? 'Yes' . "\n" : 'No' . "</td></tr>";
if( is_child_theme() ) { 
	$parent_theme = wp_get_theme( $active_theme->Template ); ?>
	<tr><td>Parent Theme:             </td><td><?php echo $parent_theme->Name ?></td></tr>     
	<tr><td>Parent Theme Version:     </td><td><?php echo $parent_theme->Version . "\n"; ?></td></tr>
	<tr><td>Parent Theme URI:         </td><td><?php echo $parent_theme->get('ThemeURI') . "\n"; ?></td></tr>
	<tr><td>Parent Theme Author URI:  </td><td><?php echo $parent_theme->{'Author URI'} . "\n"; ?></td></tr>
<?php } ?>
</tbody>
</table>
<table class="system-table">
<tbody>
<tr><th colspan="4">Plugins Information</th></tr>
<?php
	// WordPress active plugins
	echo "<tr><th colspan='4'>WordPress Active Plugins</th></tr>";
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins = get_plugins();
	$active_plugins = get_option( 'active_plugins', array() );
	foreach( $plugins as $plugin_path => $plugin ) {
		if( !in_array( $plugin_path, $active_plugins ) )
			continue;

		echo '<tr><td>' . $plugin['Name'] . ': </td><td>' . $plugin['Version'] . '</td><td>' .$plugin['Author'] .'</td><td>' .$plugin['PluginURI'] . "</td></tr>";
	}
echo '</tbody>';
echo '<tbody>';	
	// WordPress inactive plugins
	echo "<tr><th colspan='4'>WordPress Inactive Plugins</th></tr>";

	foreach( $plugins as $plugin_path => $plugin ) {
		if( in_array( $plugin_path, $active_plugins ) )
			continue;

		echo '<tr><td>' . $plugin['Name'] . ': </td><td>' . $plugin['Version'] . '</td><td>' .$plugin['Author'] .'</td><td>' .$plugin['PluginURI'] . "</td></tr>";
	}
echo '</tbody>';
if( is_multisite() ) {
		// WordPress Multisite active plugins
echo '<tbody>';	
		echo "<tr><th colspan='4'>Network Active Plugins";
		$plugins = wp_get_active_network_plugins();
		$active_plugins = get_site_option( 'active_sitewide_plugins', array() );

		foreach( $plugins as $plugin_path ) {
			$plugin_base = plugin_basename( $plugin_path );

			if( !array_key_exists( $plugin_base, $active_plugins ) )
				continue;

			$plugin  = get_plugin_data( $plugin_path );
			echo '<tr><td>' . $plugin['Name'] . ': </td><td>' . $plugin['Version'] . '</td><td>' .$plugin['Author'] .'</td><td>' .$plugin['PluginURI'] . "</td></tr>";
		}
	}
echo '</tbody>';
echo '</table>';
?>
<table class="system-table">
<tbody>
<tr><th colspan="2">Server Environment</th></tr>
<tr><td>Server Info:              </td><td><?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?></td></tr>
<tr><td>Host:                     </td><td><?php echo demo_importer_plugin_sss_get_host() . "\n"; ?></td></tr>
<tr><td>Default Timezone:         </td><td><?php echo date_default_timezone_get() . "\n"; ?></td></tr>
<?php
if ( $wpdb->use_mysqli ) {
	$mysql_ver = @mysqli_get_server_info( $wpdb->dbh );
} else {
	$mysql_ver = @mysql_get_server_info();
}
?>
<tr><td>MySQL Version:            </td><td><?php echo $mysql_ver . "\n"; ?></td></tr>
</tbody>
</table>
<table class="system-table">
<tbody>
<tr><th colspan="2">PHP Configuration</th></tr>
<tr><td>PHP Version:              </td><td><?php echo PHP_VERSION . "\n"; ?></td></tr>
<tr><td>PHP Post Max Size:        </td><td><?php echo ini_get( 'post_max_size' ) . "\n"; ?></td></tr>
<tr><td>PHP Time Limit:           </td><td><?php echo ini_get( 'max_execution_time' ) . "\n"; ?></td></tr>
<tr><td>PHP Max Input Vars:       </td><td><?php echo ini_get( 'max_input_vars' ) . "\n"; ?></td></tr>
<tr><td>PHP Safe Mode:            </td><td><?php echo ini_get( 'safe_mode' ) ? "Yes" : "No\n"; ?></td></tr>
<tr><td>PHP Memory Limit:         </td><td><?php echo ini_get( 'memory_limit' ) . "\n"; ?></td></tr>
<tr><td>PHP Upload Max Size:      </td><td><?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?></td></tr>
<tr><td>PHP Upload Max Filesize:  </td><td><?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?></td></tr>
<tr><td>PHP Arg Separator:        </td><td><?php echo ini_get( 'arg_separator.output' ) . "\n"; ?></td></tr>
<tr><td>PHP Allow URL File Open:  </td><td><?php echo ini_get( 'allow_url_fopen' ) ? "Yes". "\n" : "No" . "\n"; ?></td></tr>
</tbody>
</table>
<table class="system-table">
<tbody>
<tr><th colspan="2">PHP Extentions</th></tr>
<tr><td>DISPLAY ERRORS:           </td><td><?php echo ( ini_get( 'display_errors' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?></td></tr>
<tr><td>FSOCKOPEN:                </td><td><?php echo ( function_exists( 'fsockopen' ) ) ? 'Your server supports fsockopen.' : 'Your server does not support fsockopen.'; ?><?php echo "\n"; ?></td></tr>
<tr><td>cURL:                     </td><td><?php echo ( function_exists( 'curl_init' ) ) ? 'Your server supports cURL.' : 'Your server does not support cURL.'; ?><?php echo "\n"; ?></td></tr>
<tr><td>SOAP Client:              </td><td><?php echo ( class_exists( 'SoapClient' ) ) ? 'Your server has the SOAP Client enabled.' : 'Your server does not have the SOAP Client enabled.'; ?><?php echo "\n"; ?></td></tr>
<tr><td>SUHOSIN:                  </td><td><?php echo ( extension_loaded( 'suhosin' ) ) ? 'Your server has SUHOSIN installed.' : 'Your server does not have SUHOSIN installed.'; ?><?php echo "\n"; ?></td></tr>
</tbody>
</table>
<table class="system-table">
<tbody>
<tr><th colspan="2">Session Configuration</th></tr>
<tr><td>Session:                  </td><td><?php echo isset( $_SESSION ) ? 'Enabled' : 'Disabled'; ?><?php echo "\n"; ?></td></tr>
<tr><td>Session Name:             </td><td><?php echo esc_html( ini_get( 'session.name' ) ); ?><?php echo "\n"; ?></td></tr>
<tr><td>Cookie Path:              </td><td><?php echo esc_html( ini_get( 'session.cookie_path' ) ); ?><?php echo "\n"; ?></td></tr>
<tr><td>Save Path:                </td><td><?php echo esc_html( ini_get( 'session.save_path' ) ); ?><?php echo "\n"; ?></td></tr>
<tr><td>Use Cookies:              </td><td><?php echo ini_get( 'session.use_cookies' ) ? 'On' : 'Off'; ?><?php echo "\n"; ?></td></tr>
<tr><td>Use Only Cookies:         </td><td><?php echo ini_get( 'session.use_only_cookies' ) ? 'On' : 'Off'; ?><?php echo "\n"; ?></td></tr>
</tbody>
</table>
</div>
