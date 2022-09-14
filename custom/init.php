<?php
add_action('init', 'init_wpa_seo_ext', 1);
function init_wpa_seo_ext() {
	
	// Tables
	tempTableCreate();
	
	/*
	4 options:
	- with elementor
	- without elementor
	- with revision
	- wihout revisions
	
	Elementor checking:
	https://klbtheme.com/elementor-if-the-page-is_elementor/
	
	Echoing Elementor content
	https://wordpress.stackexchange.com/questions/307783/echoing-elementor-page-content-in-template-but-it-doesnt-get-styles-and-some-w
	*/
	
	if( $_GET['test'] ) {
		
		$post_id = 8769;
		cachePostContent( $post_id );

		die();
	
	}
	
	if( $_GET['update'] ) {
		
		do_action('update_chunk_posts');
		die();
		
	}	
	
}
