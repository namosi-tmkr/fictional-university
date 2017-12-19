<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
	register_rest_route('university/v1', 'search', [
		'methods'  => WP_REST_SERVER::READABLE, //i.e 'get'
		'callback' => 'universitySearchResults'
	]);
}


function universitySearchResults($data) 
{
	$professors = new WP_Query([
		'post_type' => 'professor',
		's'			=> sanitize_text_field($data['term']),  //s = search data is used to use url as search?term=barksalot
	]);

	$professorResults = [];

	while($professors->have_posts()) {
		$professors->the_post();
		array_push($professorResults, [
			'title' => get_the_title(),
			'permalink'	=> get_the_permalink(),
		]);
	}

	return $professorResults;
}