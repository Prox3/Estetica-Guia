<?php get_header(); ?>
<?php dynamic_sidebar('Author Pages Top Section'); ?>
<?php
global $current_user, $wpdb;
if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
?>
  <div id="wrapper" class="clearfix">
    <div id="inner_pages" class="clearfix" >
       <?php if($_REQUEST['list']=='favourite'){?>
         <h1> <?php echo MY_FAVOURITE_TEXT; ?>  </h1>
        <?php }else
        {
        ?>
         <h1> <?php echo $curauth->display_name; ?>  </h1>
        <?php	
        }?>
        <div class="breadcrumb clearfix">
        <?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
        
            <div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
        
    <?php } ?></div>
    <div class="clearfix"></div>
        <div id="content" class="content_index clearfix">
 <!-- ####################################### top sort ############################## -->       
        <?php if($_REQUEST['etype']=='upcoming' || $_REQUEST['etype']=='past'){?>
     <ul class="sort_by"> 
    	<li class="title"> <?php echo EVENTS;?> :</li> 
                  <li class="listings"> <a href="?etype=0">  <?php echo LISTINGS;?>  </a></li> 
                <li class="<?php if($_REQUEST['etype']=='upcoming') echo 'current'; ?> upcoming2"> <a href="?etype=upcoming">  <?php echo UPCOMING;?> </a></li> 
          <li class="<?php if($_REQUEST['etype']=='past') echo 'current'; ?> past"> <a href="?etype=past">  <?php echo PAST;?> </a></li> 
         
           <li class="i_next">   </li> 
            <li class="i_previous"> </li> 
     </ul>
       
             <?php }elseif($_REQUEST['list']=='favourite'){}else{ ?>
         <ul class="sort_by"> 
    	<li class="title"> <?php echo VIEW_AUTHOR;?> :</li> 
                <li class="current listings"> <a href="#">  <?php echo LISTINGS;?> </a></li> 
          <li class=" events"> <a href="?etype=upcoming">  <?php echo EVENTS;?> </a></li> 
         
           <li class="i_next">   </li> 
            <li class="i_previous"> </li> 
     </ul> 
				<?php } ?>

 <!-- ####################################### end top sort ########################## -->       

     			 
<?php if($_REQUEST['etype']=='upcoming' || $_REQUEST['etype']=='past') { ?>
<!-- ####################################################### list events ################################################ -->
<?php 
			$blog_cats = get_blog_sub_cats_str('string');
			
if($_REQUEST['etype']=='upcoming'){
$today = date('Y-m-d');
				$where .= " AND  pm.meta_key='end_date' and pm.meta_value>='".$today."' ";
if($curauth->ID==$current_user->ID){				
$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish','draft') and p.post_author='$curauth->ID' and p.post_type in ('event') $where ORDER BY (select pm.meta_value from $wpdb->postmeta pm where pm.post_id=p.ID and pm.meta_key like 'st_date') desc";
}else{
$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish') and p.post_author='$curauth->ID' and p.post_type in ('event') $where ORDER BY (select pm.meta_value from $wpdb->postmeta pm where pm.post_id=p.ID and pm.meta_key like 'st_date') desc";
}


}
if($_REQUEST['etype']=='past'){
	$today = date('Y-m-d');
				$where .= " AND pm.meta_key='end_date' and pm.meta_value<='".$today."' ";

if($curauth->ID==$current_user->ID){
$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish','draft') and p.post_author='$curauth->ID' and p.post_type in ('event') $where ORDER BY (select pm.meta_value from $wpdb->postmeta pm where pm.post_id=p.ID and pm.meta_key like 'st_date') desc";
}else{
$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status in ('publish') and p.post_author='$curauth->ID' and p.post_type in ('event') $where ORDER BY (select pm.meta_value from $wpdb->postmeta pm where pm.post_id=p.ID and pm.meta_key like 'st_date') desc";	
}
}
//echo  $sql;

			$Businesses_query = $wpdb->get_results($sql);


    if ($Businesses_query){

echo '<ul class="category_list_view">';
foreach($Businesses_query as $Businesses_query_obj){
	$post_images = bdw_get_images($Businesses_query_obj->ID,'large');
	$current_post_id = $Businesses_query_obj->ID;
	?> 
    <li id="post-<?php echo $Businesses_query_obj->ID; ?>" class="clearfix"> 
    <?php if($post_images[0]){ global $thumb_url;?>
   <a class="post_img" href="<?php echo get_permalink( $Businesses_query_obj->ID ); ?>"><img src="<?php echo $post_images[0];?>" alt="<?php echo $Businesses_query_obj->post_title; ?>" title="<?php echo $Businesses_query_obj->post_title; ?>"  /> </a>  
 <?php }else{?>
  <span class="img_not_available"> <b> <?php _e('image not available','geotheme');?> </b> </span>
                          <?php }?>
     <div class="content">
     <h3>  <a href="<?php echo get_permalink( $Businesses_query_obj->ID ); ?>"><?php echo $Businesses_query_obj->post_title; ?></a>  </h3> 
        <div class="content_right">
        <a href="<?php echo get_permalink( $Businesses_query_obj->ID ); ?>#comments" class="pcomments" ><?php $post->ID = $Businesses_query_obj->ID; comments_number('0 '.__('reviews'), '1 '.__('review'), '%'.__('reviews')); ?> </a> 
        <span class="rating"><?php echo get_post_rating_star($current_post_id);?></span>
        <?php if($current_user->data->ID == $curauth->ID || $current_user->data->ID==1){?>
        <span class="upgrade_link"><a href="<?php echo site_url();?>/?ptype=<?php if($Businesses_query_obj->post_type=='event'){echo 'post_event';}else{echo 'post_listing';}?>&amp;pid=<?php echo $current_post_id;?>&amp;upgrade=1"><?php echo UPGRADE_TEXT;?></a></span>
        <?php } ?>

       <?php
	   if($current_user->data->ID == $curauth->ID || $current_user->data->ID==1){?>
        <?php if($_REQUEST['list']=='favourite'){}else{ ?>
			        <span class="author_link"> <?php

	   // if(get_time_difference( $Businesses_query_obj->post_date, $Businesses_query_obj->ID ))
	  		$expire_date = get_post_meta($current_post_id,'expire_date',true);
			$d1 = $expire_date; // get expire_date
			$d2 = date('Y-m-d'); // get current date
			$state = __('days left');
			if($expire_date=='Never' || strtotime($d1) < strtotime($d2) )
		{
		?>
        <a href="<?php echo site_url();?>/?ptype=<?php if($Businesses_query_obj->post_type=='event'){echo 'post_event';}else{echo 'post_listing';}?>&amp;pid=<?php echo $current_post_id;?>"><?php echo EDIT_TEXT;?></a> | 
        <?php	
		}else
		{
		?>
        <a href="<?php echo site_url();?>/?ptype=<?php if($Businesses_query_obj->post_type=='event'){echo 'post_event';}else{echo 'post_listing';}?>&amp;renew=1&amp;pid=<?php echo $current_post_id;?>"><?php echo RENEW_TEXT;?></a> |
		<?php
		}
		?>
        <a href="<?php echo site_url();?>/?ptype=<?php if($Businesses_query_obj->post_type=='event'){echo 'preview_event';}else{echo 'preview';}?>&amp;pid=<?php echo $current_post_id;?>"><?php echo DELETE_TEXT;?></a> </span>  
        <?php }}?>
        <?php favourite_html($Businesses_query_obj->post_author,$post->ID); ?>
    </div>
    <p class="timing"> <span><?php _e('Start Date :');?></span> <?php echo get_formated_date(get_post_meta($Businesses_query_obj->ID,'st_date',true)).' '.get_formated_time(get_post_meta($Businesses_query_obj->ID,'st_time',true));?><br />
               <span><?php _e('End Date :');?></span> <?php echo  get_formated_date(get_post_meta($Businesses_query_obj->ID,'end_date',true)) . ' ' .get_formated_time(get_post_meta($Businesses_query_obj->ID,'end_time',true));?> </p>
     <p class="address"><?php echo get_post_meta($Businesses_query_obj->ID,'address',true);?></p>
    <span class="readmore" ><a href="<?php echo get_permalink( $Businesses_query_obj->ID ); ?>" > <?php _e('read more');?>  </a> </span>
    </div> 
 </li>
 
	 
 <?php } ?>
  </ul>

      <?php }else{ ?>
 
    <p class="message" ><?php if($_REQUEST['list']=='favourite'){echo FAVOURITE_NOT_AVAIL_MSG;}else{ echo LISTING_NOT_AVAIL_MSG;} ?> </p> 
<?php } 
 
?>
 <!-- ####################################################### list events ################################################ -->
    <?php }else{?>
<?php if(have_posts()) : ?>
<ul class="category_list_view">
    <?php while(have_posts()) : the_post();
	$post_images = bdw_get_images($post->ID,'large');
	$current_post_id = $post->ID;
	?> 
    <li id="post-<?php the_ID(); ?>" class="clearfix"> 
    <?php if($post_images[0]){ global $thumb_url;?>
   <a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>  
 <?php }else{?>
  <span class="img_not_available"> <b> <?php _e('image not available');?> </b> </span>
                          <?php }?>
     <div class="content">
     <h3>  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  </h3> 
        <div class="content_right">
        <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0 '.__('reviews'), '1 '.__('review'), '%'.__('reviews')); ?> </a> 
        <span class="rating"><?php echo get_post_rating_star($current_post_id);?></span>
        <?php if($current_user->data->ID == $curauth->ID || $current_user->data->ID==1){?>
        <?php if($_REQUEST['list']=='favourite'){}else{ ?><span class="upgrade_link"><a href="<?php echo site_url();?>/?ptype=<?php if($post->post_type=='event'){echo 'post_event';}else{echo 'post_listing';}?>&amp;pid=<?php echo $current_post_id;?>&amp;upgrade=1"><?php echo UPGRADE_TEXT;?></a></span>
        <?php } }?>

       <?php
	   if($current_user->data->ID == $curauth->ID || $current_user->data->ID==1){?>
        <?php if($_REQUEST['list']=='favourite'){}else{ ?>
			        <span class="author_link"> <?php

	    //if(get_time_difference( $post->post_date, $post->ID ))
			$expire_date = get_post_meta($current_post_id,'expire_date',true);
			$d1 = $expire_date; // get expire_date
			$d2 = date('Y-m-d'); // get current date
			$state = __('days left');
			if($expire_date=='Never' || strtotime($d1) > strtotime($d2) )
		{
		?>
        <a href="<?php echo site_url();?>/?ptype=<?php if($post->post_type=='event'){echo 'post_event';}else{echo 'post_listing';}?>&amp;pid=<?php echo $current_post_id;?>"><?php echo EDIT_TEXT;?></a> | 
        <?php	
		}else
		{
		?>
        <a href="<?php echo site_url();?>/?ptype=<?php if($post->post_type=='event'){echo 'post_event';}else{echo 'post_listing';}?>&amp;renew=1&amp;pid=<?php echo $current_post_id;?>"><?php echo RENEW_TEXT;?></a> |
		<?php
		}
		?>
        <a href="<?php echo site_url();?>/?ptype=<?php if($post->post_type=='event'){echo 'preview_event';}else{echo 'preview';}?>&amp;pid=<?php echo $current_post_id;?>"><?php echo DELETE_TEXT;?></a> </span>  
        <?php }}?>
        <?php favourite_html($post->post_author,$post->ID); ?>
    </div>
     <p class="address"><?php echo get_post_meta($post->ID,'address',true);?></p>
    <p><?php echo excerpt(20); ?> </p>
    <span class="readmore" ><a href="<?php the_permalink(); ?>" > <?php _e('read more');?>  </a> </span>
    </div> 
 </li>

 
    <?php endwhile;?>
</ul>
 <div class="pagination">       
       <span class="i_previous" > <?php previous_posts_link(__('Previous')) ?> </span>
       <span class="i_next" ><?php next_posts_link(__('Next')) ?> </span>
        <?php if (function_exists('wp_pagenavi')) { ?>
        <?php wp_pagenavi(); ?>
        <?php } ?>
      </div>
	<?php else : ?>
    <p class="message" ><?php if($_REQUEST['list']=='favourite'){echo FAVOURITE_NOT_AVAIL_MSG;}else{ echo LISTING_NOT_AVAIL_MSG;} ?> </p> 
<?php endif; ?> 
     <?php }?>

      
</div> <!-- content #end -->
<div id="sidebar">
<!-- user profile #start -->
 <div class="widget profile_widget login_widget">
<h3><?php _e('User Profile'); ?> - <?php echo $curauth->display_name; ?> </h3>
<ul class="xoxo blogroll">
<li><?php echo get_avatar($curauth->ID, 60, get_bloginfo('template_directory').'/images/gravatar.png' ); ?></li>
<?php if($curauth->user_url){ ?><li><a href="<?php echo $curauth->user_url; ?>"><?php echo USER_PROFILE_WEBSITE; ?></a></li><?php }?>

<?php if(get_user_meta( $curauth->ID, 'aim', true )){?><li><span class="profile_aim"><?php echo USER_PROFILE_AIM; ?>:</span> <?php echo get_user_meta( $curauth->ID, 'aim', true ); ?></li><?php }?>

<?php if(get_user_meta( $curauth->ID, 'yim', true )){?><li><span class="profile_yim"><?php echo USER_PROFILE_YIM; ?>:</span> <?php echo get_user_meta( $curauth->ID, 'yim', true ); ?></li><?php }?>

<?php if(get_user_meta( $curauth->ID, 'jabber', true )){?><li><span class="profile_jabber"><?php echo USER_PROFILE_JABBER; ?>:</span> <?php echo get_user_meta( $curauth->ID, 'jabber', true ); ?></li><?php }?>

<?php if(get_user_meta( $curauth->ID, 'description', true )){?><li><span class="profile_description"><?php echo USER_PROFILE_BIO; ?>:</span><br /> <?php echo get_user_meta( $curauth->ID, 'description', true ); ?></li><?php }?>

<?php if(get_user_meta( $curauth->ID, 'country', true )){?><li><span class="profile_country"><?php echo USER_PROFILE_COUNTRY; ?>:</span> <?php $user_country = get_user_meta( $curauth->ID, 'country', true ); $u_country = explode("->", $user_country);?>
  <div class="flag flag-<?php echo $u_country[0];?>" title="<?php echo $u_country[1];?>"><div class="city"><?php echo $u_country[1];?></div></div></li><?php }?>

<?php if(get_user_meta( $curauth->ID, 'user_city', true )){?><li><span class="profile_city"><?php echo USER_PROFILE_CITY; ?>:</span> <?php echo get_user_meta( $curauth->ID, 'user_city', true ); ?></li><?php }?>


<?php if(get_user_meta( $curauth->ID, 'facebook', true )){?>
<li><a href="<?php echo get_user_meta( $curauth->ID, 'facebook', true ); ?>"  class="profile_i_facebook" target="_blank"><?php _e('Facebook')?> </a> </li>
<?php }?>

<?php if(get_user_meta( $curauth->ID, 'twitter', true )){?>
<li><a href="<?php echo get_user_meta( $curauth->ID, 'twitter', true ); ?>"  class="profile_i_twitter" target="_blank"><?php _e('Twitter')?> </a> </li>
<?php }?>

<?php if(get_user_meta( $curauth->ID, 'gplus', true )){?>
<li><a href="<?php echo get_user_meta( $curauth->ID, 'gplus', true ); ?>"  class="profile_i_gplus" target="_blank"><?php _e('Google+')?> </a> </li>
<?php }?>

 


</ul>
</div>
<!-- user profile #end -->

<?php dynamic_sidebar('Author Pages Sidebar'); ?>
</div>
</div>
<?php get_footer(); ?>