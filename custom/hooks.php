<?php
add_action('save_post', 'save_post_wpa_cache', 5, 10);
function save_post_wpa_cache( $post_id ) {
	
	$post = get_post( $post_id );
	
	$allowed = array('post','page');
	if( in_array($post->post_type, $allowed) ) {
		cachePostContent( $post_id );
	}
	
}


add_filter( 'the_content', 'filter_function_name_11', 5 );
function filter_function_name_11( $content ) {
	
	if( get_option('wpa-ext-enabled') ) {
		$content_new = get_post_meta( $GLOBALS['post']->ID, 'new_content', true );

		if( $content_new ) {
			return $content_new;
		}
		
	}
	return $content;
}


