<?php 

/* 
Plugin Name: My First Amazing Plugin
Description: This plugin will change your life
*/

add_filter('the_content', 'amazingContentEdits');

function amazingContentEdits($content)
{
	$content = $content . '<p>All content belongs to fictional university. </p>';
	$content = str_replace('Lorem', '***', $content);
	return $content;
}


add_shortCode('programCount', 'programCountFunction');

function programCountFunction()
{
	$programCount = new WP_Query([
		'post_type' => 'program',
	]);

	return $programCount->found_posts;
}