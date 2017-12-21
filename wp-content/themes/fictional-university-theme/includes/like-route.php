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


function createLike() 
{
	return 'Thanks for trying to create a like';
}

function deleteLike()
{
	return 'Thanks for trying to delete a like';
}