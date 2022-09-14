<?php
function cachePostContent( $post_id ) {
	
	$elementor_page = get_post_meta( $post_id, '_elementor_edit_mode', true );
	if ( $elementor_page ) {
		
		if (class_exists("\\Elementor\\Plugin")) {
			//$pluginElementor = \Elementor\Plugin::instance();
			//$content = $pluginElementor->frontend->get_builder_content($post_id);
		}
		
		$frontend = new \Elementor\Frontend();
		$content = $frontend->get_builder_content_for_display( $post_id, $with_css = true );
		
		//$content = apply_filters( 'the_content', $content );
		
		$seo = new SEOAutoLinks;
		$content = $seo->SEOAutoLinks_process_text($content, 1);
		
		echo $content;
		
		update_post_meta( $post_id, 'new_content', $content );
		
	} else {
		
		$content = apply_filters('the_content', get_post_field('post_content', $post_id));
		
		$seo = new SEOAutoLinks;
		$content = $seo->SEOAutoLinks_process_text($content, 0);
		
		update_post_meta( $post_id, 'new_content', $content );
		
	}
	
	return $content;
	
}



function updatePostLinks( $post_id ) {
	
	$elementor_page = get_post_meta( $post_id, '_elementor_edit_mode', true );
	if ( $elementor_page ) {
		updateLinksElementor( $post_id );
	} else {
		updateLinksEditor( $post_id );
	}
	
}


function updateLinksElementor( $post_id ) {
	
	$post = get_post( $post_id );
	
	$seo = new SEOAutoLinks;
	$text = $seo->SEOAutoLinks_process_text($post->post_content, 0);
	
	// Main post content
	$my_post = [
		'ID' => $post_id,
		'post_content' => $text,
	];

	// Обновляем данные в БД
	wp_update_post( $my_post );
	
}


function updateLinksEditor( $post_id ) {
	
	$post = get_post( $post_id );
	
	$seo = new SEOAutoLinks;
	$text = $seo->SEOAutoLinks_process_text($post->post_content, 0);
	
	$my_post = [
		'ID' => $post_id,
		'post_content' => $text,
	];

	// Обновляем данные в БД
	wp_update_post( $my_post );
	
}


function addTempPosts() {
	
	global $wpdb;
	$table_name = $wpdb->get_blog_prefix() . 'wpa_cache_temp';
	
	$posts = get_posts( [
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'post_type' => array('post','page'),
	] );
	
	foreach( $posts as $post ) {
		$wpdb->insert( $table_name, [ 'post_id' => $post->ID ] );
	}
	
}