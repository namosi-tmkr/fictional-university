<?php get_header(); ?>

<?php

while(have_posts()) {
	the_post(); 
     pageBanner();
     ?>
	
	<div class="container container--narrow page-section">
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span></p>
		</div>
		<div class="generic-content">
	      <?php the_content(); ?>
	    </div>

     <div class='acf-map'>   
          <?php        
          $mapLocation = get_field('map_location');
          ?>
          <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
              <h3><?php the_title(); ?></h3>
              <?php echo $mapLocation['address']; ?>
         </div>                
     </div>


	    <?php 
         //relationship betn campuses and programs
         $relatedPrograms = new WP_Query([ //only use when different action is required in the given url else define in functions.php
               'posts_per_page'  => -1,
               'post_type'       => 'program',
               'orderby'         => 'title',
               'order'           => 'ASC',
               'meta_query'      => [
                    [
                         'key' => 'related_campus',
                         'compare' => 'LIKE',
                         'value' => '"' . get_the_ID() . '"', // search for "12" due to some php 
                    ],
               ],  
          ]);

          if($relatedPrograms->have_posts()) {

               echo '<hr class="section-break">';
               echo '<h2 class="headline headline--medium">Programs available at this campus</h2>';
               echo '<ul class="min-list link-list">';
               while($relatedPrograms->have_posts()) {
                    $relatedPrograms->the_post();
                    ?>
                    <li>
                         <a  href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>  
                         </a>
                    </li>
                    <?php
               } //while ends
               echo '</ul>';
          } //if ends

          wp_reset_postdata();
          ?> 



	</div>	

<?php 
}

?>


<?php get_footer(); ?>