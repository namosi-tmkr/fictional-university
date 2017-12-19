<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
	register_rest_route('university/v1', 'search', [
		'methods'  => WP_REST_SERVER::READABLE, //i.e 'get'
		'callback' => 'universitySearchResults'
	]);
}


function universitySearchResults() 
{
	return 'route created';
}