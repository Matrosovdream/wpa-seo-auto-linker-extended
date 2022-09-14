<?php
function wpa_seo_plugin_updates( $value ) {
	if( isset( $value->response['wpa-seo-auto-linker/wpa-seo-auto-linker.php'] ) ) {        
		unset( $value->response['wpa-seo-auto-linker/wpa-seo-auto-linker.php'] );
	}
	return $value;
}
add_filter( 'site_transient_update_plugins', 'wpa_seo_plugin_updates' );