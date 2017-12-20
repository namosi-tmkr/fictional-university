<?php

require get_theme_file_path('/includes/search-route.php');


function university_files()
{	
	wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyDT6Byg6DgZt7F4MWD68iswWpIYvMrJQ1Y', NULL, microtime(), TRUE);
	wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), TRUE);
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

	wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
	wp_localize_script('main-university-js', 'universityData', [
		'root_url' => get_site_url(),
		'nonce'	   => wp_create_nonce('wp_rest'), 	
	]); //to make js more dynamic
}

add_action('wp_enqueue_scripts', 'university_files');


//customize the wordpress rest API
function university_custom_rest() 
{
	register_rest_field('post', 'author_name', [
		'get_callback' => function() {
			return get_the_author();
		}
	]);
}

add_action('rest_api_init', 'university_custom_rest');
 
//adding features to dashboard
function university_features()
{
	add_theme_support('title-tag'); //generate title
	// register_nav_menu('headerMenuLocation', 'Header Menu Location'); //to generate nav menu
	// register_nav_menu('footerLocationOne', 'Footer Location One');
	// register_nav_menu('footerLocationTwo', 'Footer Location Two');
	add_theme_support('post-thumbnails'); //to enable featured images
	add_image_size('professorLandscape', 400, 260, TRUE);
	add_image_size('professorPortrait', 480, 650, TRUE);
	add_image_size('pageBanner', 1500, 350, TRUE);
}

add_action('after_setup_theme', 'university_features');



//to get required type of posts in particular page
function university_adjust_queries($query) 
{
	//query adjust for event post_type
	if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
		$today = date('Ymd');
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', 
			[
				[
					'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                      ]
                  ]
              );

	}

	//query adjust for program post_type
	if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', -1);
	}

	//query adjust for campus post_type
	if(!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
		$query->set('posts_per_page', -1);
	}
	
}

add_action('pre_get_posts', 'university_adjust_queries');



//dynamic page banner function
function pageBanner($args = NULL)
{
	if(!$args['title']) {
		$args['title'] = get_the_title();
	}

	if(!$args['subtitle']) {
		$args['subtitle'] = get_field('page_banner_subtitle');
	}

	if(!$args['photo']) {
		if(get_field('page_banner_background_image')) {
			$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
		} else {
			$args['photo'] = get_theme_file_uri('/images/ocean.jpg');
		}
	}
?>
<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php 
			// echo get_theme_file_uri('images/ocean.jpg') 
			// $pageBannerImage = get_field('page_banner_background_image');
			// echo $pageBannerImage['sizes']['pageBanner']; 
			echo $args['photo'];
			?>
			);"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $args['subtitle']; ?></p>
			</div>
		</div>  
	</div>
<?php

}


//API key for google map

function universityMapKey($api)
{
	$api['key'] = 'AIzaSyDT6Byg6DgZt7F4MWD68iswWpIYvMrJQ1Y';
	return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');



//Redirect subscriber accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() 
{	
	$ourCurrentUser = wp_get_current_user();

	if(count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
		wp_redirect(site_url('/'));
		exit;
	}
}


//remove wp dashboard for subscribers
add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() 
{	
	$ourCurrentUser = wp_get_current_user();

	if(count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
		show_admin_bar(false);
	}
}


//Customize Login Screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() 
{
	return esc_url(site_url('/'));
}


//customize login screen logo
add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS()
{
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle()
{
	return get_bloginfo('name');
}