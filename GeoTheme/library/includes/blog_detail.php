<?php get_header(); ?>
 <div id="wrapper" class="clearfix">
         	<div id="inner_pages" class="clearfix" >
            	<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                      <?php the_title(); ?>
                      </a></h1>   
                 <div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
               
                	<div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
               
            <?php } ?> </div>
  		<div id="content" class="content_inner" >
        <div class="single_post_blog">
      <?php if(have_posts()) : ?>
         <?php $post_images = bdw_get_images($post->ID,'large');?>
		  <?php while(have_posts()) : the_post() ?>
              <div id="post-<?php the_ID(); ?>" class="posts post_spacer">
              
 
		<?php if(get_post_meta($post->ID,'video',true)){?>
            <div class="video_main">
            <?php echo get_post_meta($post->ID,'video',true);?>
            </div>
         <?php }?>
         
         
         
          <?php 
		  if(get_the_post_thumbnail( $post->ID, 'large')){
		  $position='left';
		 echo get_the_post_thumbnail( $post->ID, 'large',array('class'	=> "alignleft",));
		 ?>
        <?php /*?> <img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo get_post_meta($post->ID,'image',true);?>&amp;w=575&amp; h=400&amp; zc=1&amp;q=80<?php echo $thumb_url;?>" alt="<?php the_title(); ?>"  class="align<?php if($position=='left')echo 'left';else echo 'right';?>" /><?php */?>
	   <?php
       }
       ?>
         
         
         
                      <?php the_content(); ?>
                   <p class="post_bottom clearfix"> <span class="category"> <?php the_category(" "); ?> </span>   <?php the_tags('<span class="tags">', ', ', '<br /> </span>'); ?>   </p>
              </div> <!-- post #end -->
              
               
<div class="pos_navigation clearfix">
			<div class="post_left fl"><?php previous_post_link('%link',''.__('Previous')) ?></div>
			<div class="post_right fr"><?php next_post_link('%link',__('Next').'') ?></div>
	</div>
              </div> <!-- single post content #end -->
              
              
              
              <div class="single_post_advt"><?php dynamic_sidebar(11);  ?> </div>
              
              
              
              
              
              
          		 
                
                		
      <?php endwhile; ?>
 <?php endif; ?>
 
          <div id="comments" class="clearfix"> <?php comments_template(); ?></div>
          
          
  </div> <!-- content #end -->
           
      
      <div id="sidebar">
       
      	<?php dynamic_sidebar(10);  ?>
     
      </div>
  </div>    
      
 <?php get_footer(); ?>