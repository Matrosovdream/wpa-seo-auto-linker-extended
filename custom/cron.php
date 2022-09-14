<?php
function update_chunk_posts() {
	
	global $wpdb;
	$table_name = $wpdb->get_blog_prefix() . 'wpa_cache_temp';
	
	$posts = $wpdb->get_results("SELECT * FROM $table_name LIMIT 30");

	foreach ( $posts as $post ) {
		
		cachePostContent( $post->post_id );
		$wpdb->delete( $table_name, [ 'post_id' => $post->post_id ] );
		
	}
	
}
add_action('update_chunk_posts', 'update_chunk_posts');


add_action( 'admin_head', 'update_chunk_posts_activation' );
function update_chunk_posts_activation() {
	if( ! wp_next_scheduled( 'update_chunk_posts' ) ) {
		wp_schedule_event( time(), 'five_min', 'update_chunk_posts');
	}
}


add_filter( 'cron_schedules', 'cron_add_five_min' );
function cron_add_five_min( $schedules ) {
	
	$minutes = 5;
	
	$schedules['five_min'] = array(
		'interval' => 60 * $minutes,
		'display' => 'Once in a '.$minutes.' minutes'
	);
	return $schedules;
}