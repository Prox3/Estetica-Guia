<?php get_header(); $new_days = get_option('ptthemes_new_days'); $img_zc = get_img_zc(get_option('ptthemes_image_zc'));### added image zoom or crop option ?>
<div id="wrapper" class="clearfix">
         	<div id="inner_pages" class="clearfix" >
              <?php if (is_paged()) $is_paged = true; ?>
            	 <?php if (is_search()) { ?>
                   <?php if($_REQUEST['s']=='cal_event'){
					   global $wpdb,$wp_query;
						$m = $wp_query->query_vars['m'];
						$py = substr($m,0,4);
						$pm = substr($m,4,2);
						$pd = substr($m,6,2);
						$the_req_date = "$py-$pm-$pd";
					   ?>
                   <h1 class="cat_head" ><?php _e('Browsing Day');?> "<?php echo  date_i18n(get_option('date_format'),strtotime($the_req_date)); ?>"</h1>
                   <?php }else{
					   $srchparam[0] = trim($_REQUEST['s']);
					   $srchparam[1] = $_REQUEST['sn'];
					   $str = implode(', ',$srchparam);
					   ?>
                    <h1 class="cat_head" ><?php _e('Search Result');?> "<?php echo stripslashes($srchparam[0]); ?>"  <?php if($srchparam[1]){ _e(', Near');?> "<?php echo stripslashes($srchparam[1]).'"';}?>  </h1>              
                    <?php }
					if($_REQUEST['Sgeo_lat']!=''){
						$startLat = $_REQUEST['Sgeo_lat'];
						$startLon = $_REQUEST['Sgeo_lon'];
						$startPoint = array( 'latitude'	=> $startLat,		
											 'longitude'	=> $startLon);
						}					
					?>
                    <?php } ?>
                    
                     <?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
                     <div class="breadcrumb clearfix">
                	<div class="breadcrumb_in"><?php 
					if($_REQUEST['s']=='cal_event'){
						//yoast_breadcrumb('',' &raquo; '.date('F jS, Y',strtotime($the_req_date)));<br />
					if(function_exists('bcn_display')){bcn_display();} 
					}else {
					if(function_exists('bcn_display')){bcn_display();}					}
					?></div></div>
            <?php } ?>
            <div class="clearfix"></div>
     		<div id="content" class="content_index clearfix">
    		<ul class="category_list_view"  >
			<?php if(have_posts()) : ?>
 			<?php while(have_posts()) : the_post() ?>
              <?php 
$post_images = bdw_get_images($post->ID,'large');
$term_list = '';
$cat_default_img = get_post_default_img($post->ID,$post->post_type);// Set the default category image
$no_image = get_bloginfo('template_url').'/images/no-image.jpg';
if($post_images[0]){}
else if($cat_default_img){$post_images[0] = $cat_default_img;}
else{$post_images[0] =$no_image;}

?>
        		
                <li class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
" >
                  <?php if(round(abs(strtotime($post->post_date)-strtotime(date('Y-m-d')))/86400)<$new_days) {?> <span class="<?php echo 'new';?>">new</span> <?php }?>
                   <?php if(get_post_meta($post->ID,'is_featured',true)) {?> <span class="<?php echo 'featured_img';?>">featured</span> <?php }?>
        
      <?php 
            if(get_the_post_thumbnail( $post->ID, array())){?>
<a class="post_img" href="<?php the_permalink(); ?>">
<?php $post_thumb =  get_the_post_thumbnail_src(get_the_post_thumbnail( $post->ID,'large'));?>
<img src="<?php echo $post_thumb;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
</a><?php
}else if($post_images[0]){ global $thumb_url;
             
                $thumb_url1 = $thumb_url.get_image_cutting_edge($args);
            ?>
             <a class="post_img" href="<?php the_permalink(); ?>">
             <img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
            <?php
            } else { ?> 
               <a  href="<?php the_permalink(); ?>"> <span class="img_not_available"> <b> <?php _e('Image Not Available ');?></b> </span> </a>
            <?php }?> 
                  
         <div class="content">
         <h3 class="no_percentage">  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  </h3> 
         <!-- GET DISTANCE ######################################################### -->
         <?php if($_REQUEST['Sgeo_lat']!=''){ ?>
         <h3 class="no_percentage"><?php
		$endLat = get_post_meta($post->ID,'geo_latitude',true);
		$endLon = get_post_meta($post->ID,'geo_longitude',true);
		 $endPoint = array( 'latitude'	=> $endLat,
							'longitude'	=> $endLon);
		 $uom = get_option('search_dist_1');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
if (round($distance,2) == 0){
$uom = get_option('search_dist_2');
$distance = calculateDistanceFromLatLong ($startPoint,$endPoint,$uom);
echo round($distance).' '.$uom.'<br />';
}else{
echo round($distance,2).' '.$uom.'<br />';
}
		 }
?>
          </h3> 
          <div class="content_right">
            <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0 '.__('reviews'), '1 '.__('review'), '% '.__('reviews')); ?> </a> 
            <span class="rating"><?php echo get_post_rating_star($post->ID);?></span>
           
                        <a href="#sticky_map"  onclick="openMarker('<?php echo $post->ID; ?>')" class="ping" id="pinpoint_<?php echo $post->ID; ?>"><?php _e('Pinpoint');?></a>

            
			<?php favourite_html($post->post_author,$post->ID); ?>
           
        </div>
                 
         <!-- GET DISTANCE ######################################################### -->
        <?php if($post->post_type=='event'){?>
         <p class="address"> <span><?php _e('Location')?> :</span> <?php echo get_post_meta($post->ID,'address',true);?></p>
         <p class="timing"> <span><?php _e('Date :');?></span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true)).__(' to ').get_formated_date(get_post_meta($post->ID,'end_date',true));?> <br /> <span><?php _e('Timing :');?></span> <?php echo get_formated_time(get_post_meta($post->ID,'st_time',true)) . __(' to ') .get_formated_time(get_post_meta($post->ID,'end_time',true));?> </p>
         <?php }else{?>
         <p class="address"> <span><?php _e('Location')?> :</span> <?php echo get_post_meta($post->ID,'address',true);?></p>
         <p class=""><?php echo excerpt(15); ?> </p>
         <?php }?>
        <span class="readmore" ><a href="<?php the_permalink(); ?>" > <?php _e('read more');?>  </a> </span>
        </div> 
                  </li>
      <?php endwhile; ?>
      </ul>
      
      <div class="pagination">
       <span class="i_previous" > <?php previous_posts_link(__('Previous')) ?> </span>
       <span class="i_next" ><?php next_posts_link(__('Next')) ?> </span>
        <?php if (function_exists('wp_pagenavi')) { ?>
        <?php wp_pagenavi(); ?>
        <?php } ?>
      </div>
      <?php else: ?>
      <p class="notice_msg"><?php _e( 'Sorry, but nothing matched your search criteria.'); ?></p>
      <?php endif; ?>
			 
      </div> <!-- content #end -->
        
       
		 <?php // get_sidebar(); ?>
         
         
         <div id="sidebar">
	<?php  
	if($_REQUEST['s']=='cal_event'){dynamic_sidebar(12);}
	else{dynamic_sidebar(5);}
	?>
</div> <!-- sidebar right--> 
 </div><!-- wrapper -->  
<?php get_footer(); ?>
