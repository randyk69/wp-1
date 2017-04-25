<?php

/* Template Name: Classes Page */

?>


<?php get_header(); ?>

<div class="classes-wrapper">
   <div class="classes-entry">
     <h1>Classes</h1>  
     <p>Below you can find upcoming classes at Glass Eye.  Classes are listed 3 months in advance and are limited to 15 students per class.  We believe in smaller class sizes so that instructors have more one-on-one time to spend with students.  Space fills up quickly so snag your spot today!</p>    
   </div>
    <?php
        $args = array( 'post_type' => 'glasseye_classes', 'posts_per_page' => 10 );
        $loop = new WP_Query( $args );
    
        while ( $loop->have_posts() ) : $loop->the_post();
          the_content();
              
              $meta_box_fields = $meta_box['fields'];
              
              // returns the key for the Name field for each Class
              $class_name_key = $meta_box_fields[0]['id'];
              $class_name_value = get_post_meta($post->ID, $class_name_key, true);
    
              //echo $class_name_value.'<br>';              
    
              // returns the key for the Instructor field
              $class_instructor_key = $meta_box_fields[1]['id'];
              $class_instructor_value = get_post_meta ($post->ID, $class_instructor_key, true);
              //echo $class_instructor_value.'<br>';
              
              $class_instructor_thumbnail_key = $meta_box_fields[2]['id'];
              $class_instructor_thumbnail_value = get_post_meta ($post->ID, $class_instructor_thumbnail_key, true);
              //echo $class_instructor_thumbnail_value.'<br>';
              
              $class_skill_key = $meta_box_fields[3]['id'];
              $class_skill_value = get_post_meta ($post->ID, $class_skill_key, true);
                  
              $class_length_key = $meta_box_fields[4]['id'];
              $class_length_value = get_post_meta ($post->ID, $class_length_key, true);      
              
              $class_description_key = $meta_box_fields[5]['id'];
              $class_description_value = get_post_meta ($post->ID, $class_description_key, true);
              
              $class_theme_key = $meta_box_fields[6]['id'];
              $class_theme_value = get_post_meta ($post->ID, $class_theme_key, true);
              
              ?>
          <div class="class-container class-container-<?php echo strtolower($class_theme_value) ?>">    

              <style>
                .thumb-container {width:100%;height:150px;}
                .thumb-container img {width:100%;height:170px!important;}
              </style>
            
              <?php if( has_post_thumbnail() ): ?>
                        <div class="thumb-container">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </div>
              <?php endif; ?>
                
                <div class="class-container-content" style="text-align:left;padding-top:20px;">
                    <h3 style="color:#333;font-weight:900;"><?php echo $class_name_value ?></h3>    
                    <div class="class-instructor-section" style="display:block;width:100%;text-align:left;">
                        <h3>Ingredients</h3>
                        <p style="margin-bottom:0;"><?php echo $class_instructor_thumbnail_value ?></p> 
                        <!--
                        <img src="< ?php echo $class_instructor_thumbnail_value ?>" class="instructor-headshot" alt="< ?php echo $class_instructor_value ?> Headshot">
                        -->
                        
                    </div>
                        <!--
                        <div class="class-skill-section">
                           <h3>Skill Level</h3>
                           <p class="skill-level"><?php echo $class_skill_value?></p> 
                        </div>
                        -->
                        <div class="class-length-section" style="display:block;width:100%;text-align:left;margin-left:0;">
                          <h3>Price</h3>
                          <p class="instructor-name"><?php echo $class_instructor_value?></p>
                          <!--    
                          <p class="length"><?php echo $class_length_value?></p>  
                            -->
                        </div>
                        <!--<p class="class-description"><?php echo $class_description_value?></p>-->
                        <button class="button enroll-button" style="background-color:#00b8b8;"><a href="">Submit Order</a></button>
                 </div>   
              
          </div>
        
         <?php
     
    
            
        endwhile;
     ?>  
   
   
   </div>    



<?php get_footer(); ?>