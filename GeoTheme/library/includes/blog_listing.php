<?php get_header(); ?>
<div id="wrapper" class="clearfix">
  <div id="inner_pages" class="clearfix" >
            	 <?php if (is_category()) { ?>
                    <h1> <?php echo BROWSING_CATEGORY; ?> <?php echo single_cat_title(); ?> </h1>
                    <?php } elseif (is_day()) { ?>
                    <h1><?php echo BROWSING_DAY; ?> <?php the_time('F jS, Y'); ?> </h1>
                    <?php } elseif (is_month()) { ?>
                    <h1><?php echo BROWSING_MONTH; ?>
                      <?php the_time('F, Y'); ?>
                    </h1>
                    <?php } elseif (is_year()) { ?>
                    <h1><?php echo BROWSING_YEAR; ?>
                      <?php the_time('Y'); ?>
                    </h1>
                    <?php } elseif (is_author()) { ?>
                    <h1> <?php echo BROWSING_AUTHOR; ?> <?php echo $curauth->nickname; ?>  </h1>
                    <?php } elseif (is_tag()) { ?>
                    <h1> <?php echo BROWSING_TAG; ?> <?php echo single_tag_title('', true); ?> </h1>
                    <?php } ?>
                <div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
               
                	<div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
               
            <?php } ?> </div>
    <div id="content" class="content_index clearfix">
    			 <?php if(have_posts()) : ?>
      <?php while(have_posts()) : the_post() ?>
      <?php $post_images = bdw_get_images($post->ID,'large');  ?>
      
      <div id="post-<?php the_ID(); ?>" class="posts">
              
            
              		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                      <?php the_title(); ?>
                      </a></h2>
                      <p class="date"> <?php _e('By');?> <?php the_author_posts_link(); ?> <?php _e('at');?>  <?php the_time('F j, Y') ?>  |   <?php the_time( $d ); ?>  | <a href="<?php the_permalink(); ?>#comments"><?php comments_number(__('0 Comment'),__('1 Comments'), __('% Comments')); ?> </a>   </p>
                      
                        
                        
                         <?php if ( get_option( 'ptthemes_postcontent_full' )) { ?>
                 
                            <div class="post_content">
                            	
                  <?php 
				  if(get_the_post_thumbnail( $post->ID, array(100,100))){
				  $position='left';
				 echo get_the_post_thumbnail( $post->ID, array(180,120),array('class'	=> "alignleft",));
				 ?>
				  <?php
			   }
       ?>
                                <?php if(get_post_meta($post->ID,'video',true)){?>
                                    <div class="video_main">
                                    <?php echo get_post_meta($post->ID,'video',true);?>
                                    </div>
                                 <?php }?>
                              <?php the_content(); ?>
                            </div>
                            
                            
                            <?php } else { ?>
                          
                               <?php if(get_the_post_thumbnail( $post->ID, array(150,150),array('class'	=> "$clss",))){
								   $position='left';
								   if(get_post_meta($post->ID,'position',true)){$position = get_post_meta($post->ID,'position',true);}
								   if($position=='left') $clss =  'alignleft';else $clss =  'alignright';
								   echo get_the_post_thumbnail( $post->ID, array(180,120),array('class'	=> "$clss",));
							   }
							   ?>
                            <p> <?php echo bm_better_excerpt(375, ''); ?></p>
                            <p> <a href="<?php the_permalink(); ?>"><?php _e('Read more &raquo;');?> </a></p>
                            <?php } ?>
                 <p class="post_bottom clearfix"> <span class="category"> <?php the_category(" , "); ?> </span>   <?php the_tags('<span class="tags">', ', ', '<br /> </span>'); ?>   </p>
              </div>
      <?php endwhile; ?>
       <div class="pagination">
       <span class="i_previous" > <?php previous_posts_link(__('Previous')) ?> </span>
       <span class="i_next" ><?php next_posts_link(__('Next')) ?> </span>
        <?php if (function_exists('wp_pagenavi')) { ?>
        <?php wp_pagenavi(); ?>
        <?php } ?>
      </div>
      <?php endif; ?>
    </div> <!-- content #end -->
    <div id="sidebar">
	<?php dynamic_sidebar(9);  ?>
</div> <!-- sidebar right--> 
</div><!-- wrapper --> 
<?php get_footer(); ?>