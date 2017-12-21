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
	//check if user is logged in or not
	if(is_user_logged_in()) { 
		$professor = sanitize_text_field($data['professorId']);

		$existQuery = new WP_Query([
			'author'	=> get_current_user_id(),
			'post_type' => 'like',
			'meta_query' => [
				[
					'key' => 'liked_professor_id',
					'compare' => '=',
					'value' => $professor,
				]
			],
		]);

		//check if already liked the professor or not
		if($existQuery->found_posts == 0 && get_post_type($professor) == 'professor') {
			return wp_insert_post([
				'post_type' => 'like',
				'post_status' => 'publish',
				'post_title' => 'Like Post',
				'meta_input' => [
					'liked_professor_id' => $professor,
				],
			]); // wp_insert_post returns the id of recently created post
		} else {
			die("Invalid Professor id");
		}

	} else {
		die("Only logged in users can like.");
	}
} 

	

function deleteLike()
{
	return 'Thanks for trying to delete a like';
}