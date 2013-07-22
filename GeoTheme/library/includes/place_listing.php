<?php get_header(); 
global $wp_query, $post, $wpdb;
$current_term = $wp_query->get_queried_object();
$category_link = get_term_link($current_term, 'placecategory');
?>
<?php dynamic_sidebar('Place Listing Top Section'); ?>
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
                     <?php } elseif ($current_term->name) { ?>
                    <h1><?php echo $current_term->name; ?> </h1>
                    <?php } ?>
    
   
                <div class="breadcrumb clearfix">
				<?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
                	<div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
            <?php } ?>
            </div>
    
    <div class="clearfix"></div>
    <div id="content" class="content_index clearfix c_list">
   <div id="cat_top_desc">
  <?php 
 $term_desc = term_description( $current_term->term_id, 'place_tags' ) ;
$saved_data = stripslashes(get_tax_meta($current_term->term_id,'ct_cat_top_desc'));
if($term_desc && !$saved_data){ $saved_data = $term_desc;}
 $cat_description =  apply_filters( 'the_content', $saved_data );
if($cat_description){echo str_replace('%location_name%', $_SESSION['location_name'], $cat_description);}?>
  </div>
        <div class="clearfix"></div>
       
     
		<div class="sort_by sort_by_dd"   <?php if(get_option('ptthemes_cat_sort_dd')){}else{ echo 'style="display:none;"';}?>><?php _e('Sort by');?> :
        
        <select name="sort_by_dd" id="sort_by_dd" onchange="set_selected_city(this.value)">
         <?php if(get_tax_meta($current_term->term_id,'ct_cat_sort')){		
		$default_sort = get_tax_meta($current_term->term_id,'ct_cat_sort');
		if($default_sort=='random'){$default_sn= __('Random');}elseif($default_sort=='az'){$default_sn= __('A-Z');}elseif($default_sort=='new'){$default_sn= __('Newest');}elseif($default_sort=='rating'){$default_sn= __('Rating');}elseif($default_sort=='review'){$default_sn= __('Reviews');}?>
        <option value="<?php echo $category_link;?>" <?php if($_REQUEST['sort']==''){ echo 'selected="selected"';}?>><?php echo $default_sn;?></option>         
		<?php }else{?>
        <option value="<?php echo $category_link;?>" <?php if($_REQUEST['sort']==''){ echo 'selected="selected"';}?>><?php _e('All');?></option>         
        <?php }$hide_review = get_tax_meta($current_term->term_id,'ct_cat_exclude_reviews'); if(!$hide_review){ ?>
        <option value="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=review";}else{ echo $cat_url = $category_link."?sort=review";}?>" <?php if($_REQUEST['sort']=='review'){ echo 'selected="selected"';}?>><?php _e('Reviews');?></option>         
        <?php }$hide_rating = get_tax_meta($current_term->term_id,'ct_cat_exclude_rating'); if(!$hide_rating){ ?>
        <option value="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=rating";}else{ echo $cat_url = $category_link."?sort=rating";}?>" <?php if($_REQUEST['sort']=='rating'){ echo 'selected="selected"';}?>> <?php _e('Rating');?></option>         
          <?php }?>
        
         <?php get_category_sort_terms_dd($current_term->term_id,$category_link); ?>

		<?php if(get_tax_meta($current_term->term_id,'ct_cat_include_random')){ ?>
        <option value="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=random";}else{ echo $cat_url = $category_link."?sort=random";}?>" <?php if($_REQUEST['sort']=='random'){ echo 'selected="selected"';}?>><?php _e('Random');?></option>         
          <?php }?> 
          
         <?php if(get_tax_meta($current_term->term_id,'ct_cat_include_newest')){ ?>
         <option value="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=newest";}else{ echo $cat_url = $category_link."?sort=newest";}?>" <?php if($_REQUEST['sort']=='newest'){ echo 'selected="selected"';}?>><?php _e('Newest');?></option>         

          <li class="<?php if($_REQUEST['sort']=='newest'){ echo 'current';}?> rating"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=newest";}else{ echo $cat_url = $category_link."?sort=newest";}?>">  <?php _e('Newest');?> </a></li>
          <?php }?>
          
          <?php if(get_tax_meta($current_term->term_id,'ct_cat_include_az')){ ?>
          <option value="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=az";}else{ echo $cat_url = $category_link."?sort=az";}?>" <?php if($_REQUEST['sort']=='az'){ echo 'selected="selected"';}?>><?php _e('A-Z');?></option>         
          <?php }?>  
    </select>	
			</div>
<script type="text/javascript">
jQuery(function(){
  jQuery("#sort_by_dd").change(function(){
    window.location=this.value
  });
});
</script>	
			<?php if(get_option('ptthemes_cat_sort_dd')){}else{?>
    <ul class="sort_by">
    	<li class="title"> <?php _e('Sort by');?> :</li>
         
        <?php if(get_tax_meta($current_term->term_id,'ct_cat_sort')){		
		$default_sort = get_tax_meta($current_term->term_id,'ct_cat_sort');
		if($default_sort=='random'){$default_sn= __('Random');}elseif($default_sort=='az'){$default_sn= __('A-Z');}elseif($default_sort=='new'){$default_sn= __('Newest');}elseif($default_sort=='rating'){$default_sn= __('Rating');}elseif($default_sort=='review'){$default_sn= __('Reviews');}?>
		 <li class="<?php if($_REQUEST['sort']==''){ echo 'current';}?> all"> <a href="<?php echo $category_link;?>">  <?php echo $default_sn;?> </a></li>
		<?php }else{?>
        <li class="<?php if($_REQUEST['sort']==''){ echo 'current';}?> all"> <a href="<?php echo $category_link;?>">  <?php _e('All');?> </a></li>
        <?php } $hide_review = get_tax_meta($current_term->term_id,'ct_cat_exclude_reviews'); if(!$hide_review){ ?>
		<li class="<?php if($_REQUEST['sort']=='review'){ echo 'current';}?> review"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=review";}else{ echo $cat_url = $category_link."?sort=review";}?>">  <?php _e('Reviews');?> </a></li>
        <?php }?>
          
		  <?php $hide_rating = get_tax_meta($current_term->term_id,'ct_cat_exclude_rating'); if(!$hide_rating){ ?>
          <li class="<?php if($_REQUEST['sort']=='rating'){ echo 'current';}?> rating"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=rating";}else{ echo $cat_url = $category_link."?sort=rating";}?>">  <?php _e('Rating');?> </a></li>
          <?php }?>

          <?php get_category_sort_terms($current_term->term_id,$category_link); ?>

<?php if(get_tax_meta($current_term->term_id,'ct_cat_include_random')){ ?>
          <li class="<?php if($_REQUEST['sort']=='random'){ echo 'current';}?> rating"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=random";}else{ echo $cat_url = $category_link."?sort=random";}?>">  <?php _e('Random');?> </a></li>
          <?php }?> 
          
          <?php if(get_tax_meta($current_term->term_id,'ct_cat_include_newest')){ ?>
          <li class="<?php if($_REQUEST['sort']=='newest'){ echo 'current';}?> rating"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=newest";}else{ echo $cat_url = $category_link."?sort=newest";}?>">  <?php _e('Newest');?> </a></li>
          <?php }?>
          
          <?php if(get_tax_meta($current_term->term_id,'ct_cat_include_az')){ ?>
          <li class="<?php if($_REQUEST['sort']=='az'){ echo 'current';}?> rating"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=az";}else{ echo $cat_url = $category_link."?sort=az";}?>">  <?php _e('A-Z');?> </a></li>
          <?php }      
         
		 if($default_sort=='random' || $_REQUEST['sort']=='random'){}else{?>
	    	<li class="i_next"> <?php next_posts_link(__('Next')) ?>  </li>
            <li class="i_previous"><?php previous_posts_link(__('Previous')) ?> </li>
    <?php }?>
               
     </ul>
    <?php }?>
    
    <div id="filter_boxes">
  <?php get_category_filter_terms($current_term->term_id,$category_link);?>
  </div>
    <ul class="<?php if(get_option('ptthemes_cat_listing')=='grid'){echo 'category_grid_view';}else{ echo 'category_list_view';}?> clearfix">
  
  
 
    
      <?php if(have_posts()) { $pcount=0; ?>
      <?php while(have_posts()) : the_post()  ?>
      <?php 
	  $category_link = get_category_link($current_term->term_id);
	 ?>
<?php $pcount++;
$post_images = bdw_get_images($post->ID,'medium');
$default_img = get_post_default_img($post->ID,  'place');
$current_post_id = $post->ID;
$new_days = get_option('ptthemes_new_days');
?>     
   	
        <?php
        if(get_option('ptthemes_cat_listing')=='grid')
		{
		?>
        	<li id="post-<?php the_ID(); ?>" class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
">
            <?php if(round(abs(strtotime($post->post_date)-strtotime(date('Y-m-d')))/86400)<$new_days) {?> <span class="<?php echo 'new';?>">new</span> <?php }?>
            <?php if(get_post_meta($post->ID,'is_featured',true)) {?><a class="featured_link" href="<?php the_permalink(); ?>"> <span class="<?php echo 'featured_img';?>">featured</span></a> <?php }?>
            
			<?php 
if(get_the_post_thumbnail( $post->ID, array())){?>
<a class="post_img" href="<?php the_permalink(); ?>">
<?php $post_thumb =  get_the_post_thumbnail_src(get_the_post_thumbnail( $post->ID,'medium'));?>
<img src="<?php echo $post_thumb;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
</a><?php
}else if($post_images[0]){ 
	
?>
 <a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo  $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
<?php
} else {?>
<a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo $default_img;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a><?php }?> 
            
                <h3> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                <span class="rating"><?php echo get_post_rating_star($current_post_id);?></span>
                
                <p class="grid-excerpt"><?php echo excerpt(15); ?> </p>
                <p class="timing">
                <?php
				 echo $attribute_desc = get_post_custom_for_listing_page($post->ID,' <span class="{#HTMLVAR#}">{#TITLE#}</span> : {#VALUE#}<br /> ');
				 ?>
                </p>
                
                <span class="ping"><a href="#sticky_map"  onclick="openMarker('<?php echo $post->ID; ?>')"><?php _e('Pinpoint');?></a></span>
                 <?php favourite_html($post->post_author,$post->ID); ?>
            
             <p class="review clearfix">    
             <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0', '1', '%'); ?> </a>  
             <span class="readmore"> <a href="<?php the_permalink(); ?>"><?php _e('read more');?> </a> </span>
             
             </p>
              
                 
             </li>
             
             <?php if($pcount!=0 && ($pcount%5)==0){?>
             <li class="hr"></li>
             <?php }?>
         <?php
		}else
		{
		?>
        <li id="post-<?php the_ID(); ?>" class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
">
        <?php if(round(abs(strtotime($post->post_date)-strtotime(date('Y-m-d')))/86400)<$new_days) {?> <span class="<?php echo 'new';?>">new</span> <?php }?> 
        <?php if(get_post_meta($post->ID,'is_featured',true)) {?> <span class="<?php echo 'featured_img';?>">featured</span> <?php }?>

        
		<?php 
            if(get_the_post_thumbnail( $post->ID, array())){?>
             <a class="post_img" href="<?php the_permalink(); ?>">
             <?php $post_thumb =  get_the_post_thumbnail_src(get_the_post_thumbnail( $post->ID,'medium'));?>
             <img src="<?php echo $post_thumb;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;
             
                $thumb_url1 = $thumb_url.get_image_cutting_edge();
            ?>
             <a class="post_img" href="<?php the_permalink(); ?>">
             <img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
            <?php
            } else { ?> 
<a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo $default_img;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a><?php }?> 
     
         <div class="content">
         <h3>  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  </h3> 
            <div class="content_right">
            <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0 '.__('reviews'), '1 '.__('review'), '% '.__('reviews')); ?> </a> 
            <span class="rating"><?php echo get_post_rating_star($current_post_id);?></span>
           
                        <a href="#sticky_map"  onclick="openMarker('<?php echo $post->ID; ?>')" class="ping" id="pinpoint_<?php echo $post->ID; ?>"><?php _e('Pinpoint');?></a>

            
			<?php favourite_html($post->post_author,$post->ID); ?>
           
        </div>
         <p class="address"><?php echo get_post_meta($post->ID,'address',true);?></p>
        <p><?php echo excerpt(20); ?> </p>
                 <p class="timing">
                <?php
				 echo $attribute_desc = get_post_custom_for_listing_page($post->ID,' <span class="{#HTMLVAR#}">{#TITLE#}</span> : {#VALUE#}<br /> ');
				 ?>
                </p>
        
        <span class="readmore" ><a href="<?php the_permalink(); ?>" > <?php _e('read more');?>  </a> </span>
        </div> 
     </li>
        <?php	
		}
		?>
      <?php endwhile; ?>
      </ul>
   <?php if($default_sort=='random' || $_REQUEST['sort']=='random'){
	   global $wp_query, $post, $wpdb;
$current_term = $wp_query->get_queried_object();
$category_link = get_term_link($current_term, 'placecategory');?>
	   <div class="pagination">       
      <span class="more_random" > <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;sort=random";}else{ echo $cat_url = $category_link."?sort=random";}?>" ><?php _e('More Random');?></a> </span>
       </div>
      <?php }else{
   if ($current_term->count > get_option('posts_per_page')) { ?>
      <div class="pagination">       
       <span class="i_previous" > <?php previous_posts_link(__('Previous')) ?> </span>
       <span class="i_next" ><?php next_posts_link(__('Next')) ?> </span>
       
        <?php if (function_exists('wp_pagenavi')) { ?>
        <?php wp_pagenavi(); ?>
        <?php } ?>
      </div>
      <?php }} ?>
      <?php }else{ echo NO_CATEGORY_LISTINGS;} ?>
    </div> <!-- content #end -->
    <div id="sidebar">
	<?php dynamic_sidebar(5);  ?>
</div> <!-- sidebar right--> 
  </div><!-- wrapper --> 
<?php get_footer(); ?>
