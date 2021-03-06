<?php

### adding new post_type like we used custom UI 

function university_post_types()
{
	// Event Post Type
	register_post_type('event', [
		'public' 		=> TRUE,
		'has_archive' 	=> TRUE,
		'capability_type' => 'event',//by default its permissions is that of a blog post
		'map_meta_cap'  => true,
		'rewrite' 		=> ['slug' => 'events'],
		'supports'		=> ['title', 'editor', 'excerpt', ],
		'labels' => [
				'name' 			=> 'Events',
				'add_new_item' 	=> 'Add New Event',
				'edit_item' 	=> 'Edit Event',
				'all_items' 	=> 'All Events',
				'singular_name' => 'Event'
			],
		'menu_icon' => 'dashicons-calendar-alt'
	]);

	//Program Post Type
	register_post_type('program', [
		'public' 		=> TRUE,
		'has_archive' 	=> TRUE,
		'rewrite' 		=> ['slug' => 'programs'],
		'supports'		=> ['title', ], //removed editor to remove dublicity
		'labels' => [
				'name' 			=> 'Programs',
				'add_new_item' 	=> 'Add New Program',
				'edit_item' 	=> 'Edit Program',
				'all_items' 	=> 'All Programs',
				'singular_name' => 'Program'
			],
		'menu_icon' => 'dashicons-awards'
	]);


	//Professor Post Type
	register_post_type('professor', [
		'public' 		=> TRUE,
		'show_in_rest'  => TRUE,
		'supports'		=> ['title', 'editor', 'thumbnail'],
		'labels' => [
				'name' 			=> 'Professors',
				'add_new_item' 	=> 'Add New Professor',
				'edit_item' 	=> 'Edit Professor',
				'all_items' 	=> 'All Professors',
				'singular_name' => 'Professor'
			],
		'menu_icon' => 'dashicons-welcome-learn-more'
	]);


	// Campus Post Type
	register_post_type('campus', [
		'public' 		=> TRUE,
		'has_archive' 	=> TRUE,
		'capability_type' => 'campus',
		'map_meta_cap'	=> TRUE,
		'rewrite' 		=> ['slug' => 'campuses'],
		'supports'		=> ['title', 'editor', 'excerpt', ],
		'labels' => [
				'name' 			=> 'campuses',
				'add_new_item' 	=> 'Add New campus',
				'edit_item' 	=> 'Edit campus',
				'all_items' 	=> 'All campuses',
				'singular_name' => 'Event'
			],
		'menu_icon' => 'dashicons-location-alt'
	]);


	//Note post type
	register_post_type('note', [
		'capability_type' => 'note',
		'map_meta_cap'	=> TRUE,
		'public' 		=> FALSE,
		'show_ui'		=> TRUE, //shows in admin dashboard
		'show_in_rest'  => TRUE,
		'supports'		=> ['title', 'editor', ],
		'labels' => [
				'name' 			=> 'Notes',
				'add_new_item' 	=> 'Add New Note',
				'edit_item' 	=> 'Edit Note',
				'all_items' 	=> 'All Notes',
				'singular_name' => 'Note'
			],
		'menu_icon' => 'dashicons-welcome-write-blog'
	]);

	//Like post type
	register_post_type('like', [
		'public' 		=> FALSE,
		'show_ui'		=> TRUE, //shows in admin dashboard
		'supports'		=> ['title',],
		'labels' => [
				'name' 			=> 'Likes',
				'add_new_item' 	=> 'Add New Like',
				'edit_item' 	=> 'Edit Like',
				'all_items' 	=> 'All Likes',
				'singular_name' => 'Like'
			],
		'menu_icon' => 'dashicons-heart'
	]);

}

add_action('init', 'university_post_types');