<?php get_header(); 

pageBanner([
  'title' => 'All Events',
  'subtitle' => 'See our events!!!',
]);
?>

<div class="container container--narrow page-section">
<?php 
  if(have_posts()) {
    while(have_posts()) {
      the_post(); 

      get_template_part('template-parts/content-event');

    } //while ends
  } //if ends

###pagination links

echo paginate_links();


?>
<hr class="section-break">
<p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events!</a> </p>  




</div>

<?php get_footer(); ?>