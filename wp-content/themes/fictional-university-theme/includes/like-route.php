<?php

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes() 
{
	register_rest_route('university/v1', 'manageLike', [
		'methods'  => 'POST', //i.e 'POST'
		'callback' => 'createLike'
	]);

	register_rest_route('university/v1', 'manageLike', [
		'methods'  => 'DELETE', //i.e 'DELETE'
		'callback' => 'deleteLike'
	]);
}


function createLike($data) 
{
	$professor = sanitize_text_field($data['professorId']);

	wp_insert_post([
		'post_type' => 'like',
		'post_status' => 'publish',
		'post_title' => '3rd Create Post Test',
		'meta_input' => [
				'liked_professor_id' => $professor,
			],
	]);
}

function deleteLike()
{
	return 'Thanks for trying to delete a like';
}