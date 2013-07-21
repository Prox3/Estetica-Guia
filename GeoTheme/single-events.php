<?php get_header(); ?>
<div id="wrapper" class="clearfix">
         	<div id="inner_pages" class="clearfix" >
                
                <h1 class="main_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                      <?php the_title(); ?>
                      </a></h1>   
                      
                       <div class="likethis">
                     <?php if ( get_option('ptthemes_tweet_button') ) { ?>
                       <a href="http://twitter.com/share" class="twitter-share-button"><?php _e('Tweet');?></a>
					 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> 
					<?php } ?>
                     <?php if ( get_option('ptthemes_facebook_button') ) { ?>
 					<iframe class="facebook" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=standard&amp;show_faces=false&amp;width=290&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0"  style="border:none; overflow:hidden; width:290px; height:24px"></iframe> 
                      <?php } ?>
                      </div>
  		<div id="content" class="content_inner" >
        <div class="single_post">
      <?php if(have_posts()) : ?>
         <?php $post_images = bdw_get_images($post->ID,'large');?>
		  <?php while(have_posts()) : the_post() ?>
              <div id="post-<?php the_ID(); ?>" class="posts post_spacer">
 <script src="<?php bloginfo('template_directory'); ?>/library/js/jquery-1.4.2.js" type="text/javascript" ></script>
        <script src="<?php bloginfo('template_directory'); ?>/library/js/galleria.js" type="text/javascript" ></script>
<div id="galleria">
             <?php
                if(count($post_images)>0)
				{
					for($im=0;$im<count($post_images);$im++)
					{
					?>
            <div class="small"> 
                <a href="<?php echo $post_images[$im];?>">
                    <img src="<?php echo $post_images[$im];?>" alt=""  />
                </a>
            </div>
             <?php	
					}
				}
				?>
        </div>
        <script type="text/javascript">
    // Load theme
    Galleria.loadTheme('<?php bloginfo('template_directory'); ?>/library/js/galleria.classic.js');
    // run galleria and add some options
   jQuery('#galleria').galleria({
        image_crop: true, // crop all images to fit
        thumb_crop: true, // crop all thumbnails to fit
        transition: 'fade', // crossfade photos
        transition_speed: 700, // slow down the crossfade
		autoplay: <?php if(get_option('ptthemes_photo_gallery')){echo 'true';}else{echo 'false';}?>,
        data_config: function(img) {
            // will extract and return image captions from the source:
            return  {
                title:jQuery(img).parent().next('strong').html(),
                description:jQuery(img).parent().next('strong').next().html()
            };
        },
        extend: function() {
            this.bind(Galleria.IMAGE, function(e) {
                // bind a click event to the active image
               jQuery(e.imageTarget).css('cursor','pointer').click(this.proxy(function() {
                    // open the image in a lightbox
                    this.openLightbox();
                }));
            });
        }
    });
    </script>
	<?php favourite_html($post->post_author,$post->ID); ?>
    
    <?php echo get_post_custom_listing_single_page($post->ID,'<p><span>{#TITLE#}</span>{#VALUE#}</p>');?>
    
	  <?php if(get_post_meta($post->ID,'video',true)){?>
            <div class="video_main">
            <?php echo get_post_meta($post->ID,'video',true);?>
            </div>
         <?php }?>
                      <?php the_content(); ?>
                      
           <?php if(get_post_meta($post->ID,'proprty_feature',true)){?>
           <p><?php echo nl2br(get_post_meta($post->ID,'proprty_feature',true));?></p>
           <?php }?>
           
           
           
      <div class="register_info">     
           
      	<?php if(get_post_meta($post->ID,'reg_desc',true)){?>
      		<?php echo get_post_meta($post->ID,'reg_desc',true);?> 
      <?php }?> 
      <?php if(get_post_meta($post->ID,'reg_fees',true)){?>
     	 <p ><?php _e('Fees : ');?> <span class="fees"><?php echo get_post_meta($post->ID,'reg_fees',true);?> </span></p>   
      <?php }?>    
       </div>    
           
        <p class="post_bottom clearfix">  <?php the_taxonomies(array('before'=>'<span class="category">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?> </p>
</div> <!-- post #end -->
               
<div class="pos_navigation clearfix">
    <div class="post_left fl"><?php previous_post_link('%link',''.__('Previous')) ?></div>
    <div class="post_right fr"><?php next_post_link('%link',__('Next').'') ?></div>
</div>
              </div> <!-- single post content #end -->
              <div class="single_post_advt"><?php dynamic_sidebar(14);  ?> </div>
            		<?php get_related_posts($post); ?>
      <?php endwhile; ?>
 <?php endif; ?>
         <div id="comments" class="clearfix"> <?php comments_template(); ?></div>
  </div> <!-- content #end -->
      <div id="sidebar">
      <div class="company_info">
     <?php //edit_post_link( __( 'Edit this Post' ), "\n\t\t\t\t\t\t<p class=\"edit-link\">", "</p>\n\t\t\t\t\t" );
	 //echo '<p class="edit-link"><a href="'.home_url();.'?ptype=post_listing&renew=1&pid='.$post->ID.'">'.home_url();.'?ptype=post_listing&renew=1&pid='.$post->ID.'</a></p>';
	 ?> 
      	
        
         <?php if(get_post_meta($post->ID,'st_date',true)){?>
		<p>  <span class="i_date"> <?php echo EVENT_DATE;?> : </span>  <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true)).__(' to ').get_formated_date(get_post_meta($post->ID,'end_date',true));?>  </p>
		<?php }?>
         <?php if(get_post_meta($post->ID,'st_time',true)){?>
		<p><span class="i_time"> <?php echo EVENT_TIME;?> : </span>  <?php echo get_formated_time(get_post_meta($post->ID,'st_time',true)) . __(' to ') .get_formated_time(get_post_meta($post->ID,'end_time',true));?>  </p>
		<?php }?>
        
         <p> <span class="i_location"><?php _e('Address :');?> </span> <?php echo get_post_meta($post->ID,'address',true);?> </p>
        
         <?php if(get_post_meta($post->ID,'contact',true) && get_option('ptthemes_contact_on_detailpage')=='Yes' && get_post_meta($post->ID,'contact_show',true)!='No'){?>
		<p> <span class="i_contact"><?php echo EVENT_CONTACT_INFO;?> : </span>  <?php echo get_post_meta($post->ID,'contact',true);?>  </p>
		<?php }?>
		
         <?php if(get_post_meta($post->ID,'email',true) && get_option('ptthemes_email_on_detailpage')=='Yes' && get_post_meta($post->ID,'email_show',true)!='No'){?>
		<p> <span class="i_email2"> <?php echo EVENT_CONTACT_EMAIL;?> : <span> <a href="mailto:<?php echo get_post_meta($post->ID,'email',true);?>">  <?php echo get_post_meta($post->ID,'email',true);?> </a> </p>
		<?php }?>       
        </div>
      
      	<div class="company_info2">
		 <?php if(get_post_meta($post->ID,'website',true)){
			 $website = get_post_meta($post->ID,'website',true);
			 if(!strstr($website,'http'))
			 {
				 $website = 'http://'.get_post_meta($post->ID,'website',true);
			 }
			 ?>
        <?php if($website && get_post_meta($post->ID,'web_show',true)!='No'){?>
		<p > <span class="i_website"><a href="<?php echo $website;?>"><strong><?php _e('Website');?></strong></a> </span>  </p>
        <?php }?>
		<?php }?>
       
       <p> <span class="i_rating"><?php _e('Rating');?> :</span> <span class="single_rating"> <?php echo get_post_rating_star($post->ID);?> </span> </p>
       <div class="share clearfix"> 
        <div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=<?php if(get_option('ptthemes_addthis_username')){echo get_option('ptthemes_addthis_username');}else{ echo 'ra-4facd1303678e5c0';}?>" class="addthis_button_compact sharethis"><?php _e('Share');?></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=<?php if(get_option('ptthemes_addthis_username')){echo get_option('ptthemes_addthis_username');}else{ echo 'ra-4facd1303678e5c0';}?>"></script>
 			 	</div>

<div class="links">
<?php if(get_post_meta($post->ID,'twitter',true)){?><a href="<?php echo get_post_meta($post->ID,'twitter',true);?>" class="i_twitter"> <?php _e('Twitter');?> </a> <?php }?>     
<?php if(get_post_meta($post->ID,'facebook',true)){?><a href="<?php echo get_post_meta($post->ID,'facebook',true);?>" class="i_facebook"><?php _e('Facebook');?> </a><?php }?>  
</div> 
       
        </div>  <!-- company info -->
 	<div class="sidebar_in"><?php dynamic_sidebar(13);  ?> </div>
    </div> <!-- sidebar #end -->
    </div>
 <?php get_footer(); ?>