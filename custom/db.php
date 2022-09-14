<?php
function tempTableCreate() {
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	global $wpdb;
	$table_name = $wpdb->get_blog_prefix() . 'wpa_cache_temp';
	$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
	
	$sql = "CREATE TABLE {$table_name} (
		id int(11) unsigned NOT NULL auto_increment,
		post_id int(11) NOT NULL,
		PRIMARY KEY  (id)
	) {$charset_collate};";

	// Create/update table
	dbDelta( $sql );
	
}


