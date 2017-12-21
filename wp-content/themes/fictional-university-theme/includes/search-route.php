<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
	register_rest_route('university/v1', 'search', [
		'methods'  => WP_REST_SERVER::READABLE, //i.e 'GET'
		'callback' => 'universitySearchResults'
	]);
}


function universitySearchResults($data) 
{
	$mainQuery = new WP_Query([
		'post_type' => ['post', 'page', 'professor', 'program', 'event', 'campus'],
		's'			=> sanitize_text_field($data['term']),  //s = search data is used to use url as search?term=barksalot
	]);

	$results = [
		'generalInfo' 	=> [],
		'professors' 	=> [],
		'programs' 		=> [],
		'events' 		=> [],
		'campuses' 		=> [],
	];

	while($mainQuery->have_posts()) {
		$mainQuery->the_post();

		if(get_post_type() == 'post' || get_post_type() == 'page') {
			array_push($results['generalInfo'], [
			'title' 		=> get_the_title(),
			'permalink'		=> get_the_permalink(),
			'postType'		=> get_post_type(),
			'author_name' 	=> get_the_author(),
		]);
		}

		if(get_post_type() == 'professor') {
			array_push($results['professors'], [
			'title' 	=> get_the_title(),
			'permalink'	=> get_the_permalink(),
			'image'		=> get_the_post_thumbnail_url(0, 'professorLandscape'),
		]);
		}

		if(get_post_type() == 'program') {
			$relatedCampuses = get_field('related_campus');

			if($relatedCampuses) {
				foreach ($relatedCampuses as $campus) {
					array_push($results['campuses'], [
						'title' 	=> get_the_title($campus),
						'permalink' => get_the_permalink($campus)
					]);
				}
			}

			array_push($results['programs'], [
			'id' 		=> get_the_ID(),
			'title' 	=> get_the_title(),
			'permalink'	=> get_the_permalink(),
		]);
		}

		if(get_post_type() == 'event') {
			$eventDate = new DateTime(get_field('event_date'));
			$description = null;
			if(has_excerpt()) {
				$description = get_the_excerpt();
			} else {
				$description = wp_trim_words(get_the_content(), 18);
			}
			array_push($results['events'], [
			'title' 	=> get_the_title(),
			'permalink'	=> get_the_permalink(),
			'month'		=> $eventDate->format('M'),
			'day'		=> $eventDate->format('d'),
			'description' => $description,
		]);
		}


		if(get_post_type() == 'campus') {
			array_push($results['campuses'], [
			'title' 	=> get_the_title(),
			'permalink'	=> get_the_permalink(),
		]);
		}
		

	}

	if($results['programs']) {
		$programsMetaQuery = ['relation' => 'OR',]; //to make programRelationQuery dynamic for mutiple programs with similar name like math, opt.math

		foreach($results['programs'] as $item) {
			array_push($programsMetaQuery, [
				'key' 		=> 'related_programs',
				'compare' 	=> 'LIKE',
				'value' 	=> '"' . $item['id'] . '"', //compare with id of programs obtained from programs array above
		]);
		}

		$programRelationshipQuery = new WP_Query([
			'post_type'  => ['professor', 'event', ],
			'meta_query' => $programsMetaQuery, 
		]);

		while($programRelationshipQuery->have_posts()) {
			$programRelationshipQuery->the_post();

			if(get_post_type() == 'professor') {
				array_push($results['professors'], [
					'title' 	=> get_the_title(),
					'permalink'	=> get_the_permalink(),
					'image'		=> get_the_post_thumbnail_url(0, 'professorLandscape'),
				]);
			}

			if(get_post_type() == 'event') {
				$eventDate = new DateTime(get_field('event_date'));
				$description = null;
				if(has_excerpt()) {
					$description = get_the_excerpt();
				} else {
					$description = wp_trim_words(get_the_content(), 18);
				}
				array_push($results['events'], [
					'title' 	=> get_the_title(),
					'permalink'	=> get_the_permalink(),
					'month'		=> $eventDate->format('M'),
					'day'		=> $eventDate->format('d'),
					'description' => $description,
				]);
			}

		}

		$results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR)); //removes dublicate matched data due to two queries... i.e. if both queries find the same data then this will remove dublication of that data
		$results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
	}
	

	return $results;
}