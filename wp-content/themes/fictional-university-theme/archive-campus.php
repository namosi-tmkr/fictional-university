<?php get_header(); 

pageBanner([
  'title' => 'Affiliated Campuses',
  'subtitle' => 'These are our affiliated campuses.' 
]);

?>

<div class="container container--narrow page-section">

<div class='acf-map'>

<?php 
  if(have_posts()) {
    while(have_posts()) {
      the_post(); 

      $mapLocation = get_field('map_location');
    ?>
    <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      <?php echo $mapLocation['address']; ?>
    </div>
    <?php
    } //while ends
  } //if ends
?>


</div>


</div>

<?php get_footer(); ?>