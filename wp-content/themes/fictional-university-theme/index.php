<?php get_header(); 

pageBanner([
  'title' => 'Welcome to our blog!',
  'subtitle' => 'Keep up with our latest news'

]);

?>

<div class="container container--narrow page-section">
<?php 
  if(have_posts()) {
    while(have_posts()) {
      the_post(); 
    ?>
    <div class="post-item">
      <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>  

      <div class="metabox">
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n-j-Y'); ?> in <?php echo get_the_category_list(', '); ?></p>
      </div>

      <div class="generic-content">
        <?php if(has_excerpt()) {
         echo get_the_excerpt();
        } else {
        echo wp_trim_words(get_the_content(), 18);
        }
      ?>
        <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue Reading &raquo;</a></p>
      </div>

    </div>
    <?php
    } //while ends
  } //if ends

###pagination links

echo paginate_links();


?>  




</div>

<?php get_footer(); ?>