<?php if(!$preview){get_header();}?>
<!--in GeoThemes-2-the-max place-detail.php -->
<div id="wrapper" class="clearfix">
         	<div id="inner_pages" class="clearfix singlePlace" >
            	
                		
                         
                       <div class="likethis">
                     <?php if ( get_option('ptthemes_tweet_button') ) { ?>
                       <a href="http://twitter.com/share" class="twitter-share-button"><?php _e('Tweet');?></a>
					 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> 
  					<?php } ?>
                     <?php if ( get_option('ptthemes_facebook_button') ) { ?>
        			<iframe <?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){echo 'allowtransparency="true"'; }?> class="facebook" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0"  style="border:none; overflow:hidden; width:100px; height:20px"></iframe> 
                    <?php } ?>
                    
					<?php if ( get_option('ptthemes_google_button') ) { ?>
<div id="plusone-div"></div>
<script type="text/javascript">gapi.plusone.render('plusone-div', {"size": "medium", "count": "true" });</script>                    
					<?php } ?>
                      </div>
                      
                <div class="breadcrumb clearfix">
                <?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
                
                	<div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
                
            <?php } ?></div>
<div class="clearfix"></div>

<div id="mobile-shortcuts"><a href="#sidebar"><button><?php _e('Contact Info');?></button></a> <a href="#comments"><button><?php _e('Reviews/Comments');?></button></a></div>

  		<div id="content" class="content_inner" >
        <div class="single_post">
        
        <div id='bg_map_single'></div>
        <h1 class="main_title"><a href="<?php if($preview){echo '#';}else{the_permalink();} ?>" rel="bookmark" title="Permanent Link to <?php if($preview){echo $proprty_name;}else{the_title_attribute();} ?>">
                      <?php if($preview){echo $proprty_name;}else{the_title();} ?>
                      </a></h1>
                      <div id="placeAddress"></div>
                      <div id="body_info_place"></div>
                      <hr id="hr_single" />
                      
                      <div id="body_additional_place">
                      	<div class="info_addtional_place">
                        	<span class="title_additional">Preço por pessoa:</span>
                          <span class="text_additional">$$ (De R$26 até R$50)</span>
                        </div>
                        <div class="info_addtional_place">
                        	<span class="title_additional">Categoria:</span>
                          <span class="text_additional">Studio de Dança</span>
                        </div>
                        <div class="info_addtional_place">
                        	<span class="title_additional">Formas de pagamento:</span>
                          <span class="text_additional">Crédito, Débito, Outras formas</span>
                        </div>
                        <div class="info_addtional_place">
                        	<span class="title_additional">Horário de Funcionamento:</span>
                          <span class="text_additional">Qua. a Sab.: 12h às 15:30 e 19h às 23:30 Dom.: 12h às 18h</span>
                        </div>
                      </div>
                      
                      <div id="full_banner"> Full Banner 468x60</div>
        
        
      <?php if(have_posts() || $preview) : 
	   if($preview && !$_REQUEST['alook'] && $_SESSION['property_info']['price_select']){$pkg_limit = get_property_price_info_listing('',$_SESSION['property_info']['price_select']);}
	   elseif(($preview && $_REQUEST['alook'] )||($preview && !$_SESSION['property_info']['price_select']) ){$pkg_limit = get_property_price_info_listing($_REQUEST['pid']);}
	   else{$pkg_limit = get_property_price_info_listing($post->ID);} ?>
         <?php if($preview){
		 $thumb_img_counter = 0;
		if(isset($_SESSION["file_info"]) && !$_REQUEST['alook'])
		{	$post_images = array();
			$image_src = array();
			$tmpimgArr = explode(",", $_SESSION["file_info"]);
			foreach($tmpimgArr as $image)
			{		 
				if($image){
				 $post_images[][0] =  $image;
				}
			}
			
		}elseif($_REQUEST['pid']){ $post_images = bdw_get_images($_REQUEST['pid'],'gallery');}
		}else{ $post_images = bdw_get_images($post->ID,'gallery');}
		//print_r($post_images);

		 global $thumb_url; /// get the mutiuser id
		$img_p = get_img_p(get_option('ptthemes_image_x_cut'));### added image crop position
		$img_zc = get_img_zc(get_option('ptthemes_image_zc'));### added image zoom or crop option
		$img_q = '&amp;q='.get_option('ptthemes_image_q');### added image quality option
		 ?>
		  <?php  if(!$preview){the_post();} ?>
              <div id="post-<?php if($preview){echo 'preview';}else{the_ID();} ?>" class="posts post_spacer">
              
   <?php  if(count($post_images)>0 && $pkg_limit['image_limit']!='0'  ){  ?>        
   <section class="slider">
        <div id="slider" class="flexslider">
          <ul class="slides">
          <?php
		  
		if(count($post_images)>0){
			if($pkg_limit['image_limit']=='' || count($post_images)<$pkg_limit['image_limit']){$img_count = count($post_images);}else{$img_count =$pkg_limit['image_limit'];}
				for($im=0;$im<$img_count;$im++){?>
				<li>
  	    	    <img src="<?php echo $post_images[$im][0]; ?>" style="max-height:400px;margin:0 auto;<?php 
				if($post_images[$im][1]){if($post_images[$im][2]>=$post_images[$im][1]){echo 'max-width:'.round(((($post_images[$im][1]*(400/$post_images[$im][2]))/588)*100),2).'%';}
				elseif($post_images[$im][1]<480){echo 'max-width:'.round((($post_images[$im][1]/588)*100),2).'%';}}?>" alt="<?php echo $post_images[$im][4];?>" title="<?php echo $post_images[$im][4];?>" />
                <?php if($post_images[$im][5]){?><p class="flex-caption"><?php echo $post_images[$im][5];?></p><?php }?>
  	    		</li>
           <?php }}?>
          </ul>
        </div>
        
        <?php if(count($post_images)>1 && $pkg_limit['image_limit']!='0' && ($pkg_limit['image_limit']>1 ||  $pkg_limit['image_limit']=='') ){ ?> 
        <div id="carousel" class="flexslider">
          <ul class="slides">
          <?php
		if(count($post_images)>0){
			if($pkg_limit['image_limit']=='' || count($post_images)<$pkg_limit['image_limit']){$img_count = count($post_images);}else{$img_count =$pkg_limit['image_limit'];}
				for($im=0;$im<$img_count;$im++){?>
				<li>
  	    	    <img src="<?php  echo $post_images[$im][0] ?>" style="max-height:48px;margin:0 auto;<?php 
				if($post_images[$im][1]){if($post_images[$im][2]>=$post_images[$im][1]){echo 'max-width:'.round(((($post_images[$im][1]*(400/$post_images[$im][2]))/588)*100),2).'%';}
				elseif($post_images[$im][1]<480){echo 'max-width:'.round((($post_images[$im][1]/588)*100),2).'%';}}?>" alt="<?php echo $post_images[$im][4];?>" title="<?php echo $post_images[$im][4];?>" />
  	    		</li>
           <?php }}?>
          </ul>
        </div>
        <?php }?>
      </section>
      
    
  <script type="text/javascript">
   <?php if(count($post_images)>1 && $pkg_limit['image_limit']!='0'  ){ ?> 
      jQuery('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
		directionNav: true,
        animationLoop: false,
        slideshow: false,
        itemWidth: 75,
        itemMargin: 5,
        asNavFor: '#slider'
      });
      <?php }?>
      jQuery('#slider').flexslider({
        animation: "slide",
        controlNav: true,
        animationLoop: true, 
		randomize: false,
		directionNav: true,
        slideshow: true,
        sync: "#carousel",
        start: function(slider){
          //$('body').removeClass('loading');
        }
      });
   
  </script>
<?php }?>

		<?php  if((get_post_meta($post->ID,'video',true) || $video) && $pkg_limit['video_pkg']==1){?>
            <div class="video_main">
            <?php if($preview){echo str_replace('\"', '', $video);}else{echo get_post_meta($post->ID,'video',true);}?>
            </div>
         <?php }?>
         <?php if($pkg_limit['property_desc_pkg']==1){if($preview){echo apply_filters( 'the_content', $proprty_desc );}else{the_content();}} ?>
           <?php if(($proprty_feature || get_post_meta($post->ID,'proprty_feature',true)) && $pkg_limit['property_feature_pkg']==1){?>
           	 <div class="register_info">     
            <?php if($preview){echo $proprty_feature;}else{echo get_post_meta($post->ID,'proprty_feature',true);}?> 
           </div>
           <?php }?>
             <p class="post_bottom clearfix">  <?php 
			 if($preview){echo '<span class="category">'.implode(",", $_SESSION['property_info']['category']).'</span>';
			 if($kw_tags){echo '<span class="tags">'.$kw_tags.'</span>';}
			 }else{the_taxonomies(array('before'=>'<span class="category">','sep'=>'</span><span class="tags">','after'=>'</span>')); }?> </p>
              </div> <!-- post #end -->
              
               
<!--<div class="pos_navigation clearfix">
    <div class="post_left fl"><?php GT_previous_post_link('%link',''.__('Previous'), true) ?></div>
    <div class="post_right fr"><?php GT_next_post_link('%link',__('Next').'', true) ?></div>
</div>-->
              </div> 
              	<div class="body_comments_detail"><?php dynamic_sidebar(28);  ?></div>
              <!-- single post content #end -->
              <div class="single_post_advt"><?php dynamic_sidebar(7);  ?> </div>
            		<?php if(get_option('ptthemes_related_on_detailpage')!='No'){ get_related_posts($post);} ?>

 <?php endif; ?>
         <div id="comments" class="clearfix"> <?php comments_template(); ?></div>
<?php if(get_option('ptthemes_moderation')=='Yes'){?>
<script type="text/javascript">
/* <![CDATA[ */
function reportThis(post_id){
jQuery("#report_this_ajax").load("<?php echo get_bloginfo('url').'/?ajax=report_form&post_id='; ?>"+post_id,function() {
jQuery('#report_this_ajax').slideToggle("200");
});
}
/* ]]> */
</script>
<div id="report_this" class="clearfix" onclick="reportThis(<?php echo $post->ID;?>)"><?php echo REPORT_THIS;?></div>
<div id="report_this_ajax" class="clearfix" style="display:none"></div>
<?php }?>
  </div> <!-- content #end -->
      <div id="sidebar">
      	<div id="body_opiniao">
        	<a></a>
        </div>
      <div class="company_info">
     <?php  
############################################# Fix for "Edit this Post" link taking user to backend ########################################	 
	 //edit_post_link( __( 'Edit this Post' ), "\n\t\t\t\t\t\t<p class=\"edit-link\">", "</p>\n\t\t\t\t\t" );
	if(get_edit_post_link() && !$preview){
			$var1 = array('wp-admin/post.php?post', '&amp;action=edit');
			$var2  = array('?ptype=post_listing&pid', '');
			$link    = get_edit_post_link();
			$output  = str_replace($var1, $var2, $link);
			echo '<p class="edit-link"><a href="'.$output.'">'.__('Edit this Post').'</a><a href="'.$output.'&upgrade=1" style="float:right;">'.__('Upgrade Listing').'</a></p>';
}
############################################# Fix for "Edit this Post" link taking user to backend ########################################
#######################OWNER VERIFIED FUNCTION ################
$post_id = get_post($post->ID); 
$author_id = $post_id->post_author;
$user = new WP_User( $author_id );
$author_role = $user->roles[0];
if($preview){$is_owned = $claimed;}else{$is_owned = get_post_meta($post->ID,'claimed',true);}

if(get_option('show_owner_verified')==1){ 
if ($author_role =='author' && $is_owned!='0' ){?>

		<p> <span class="i_verified"> <?php echo OWNER_VERIFIED_PLACE;?> </span></p>


<?php }}
###############################################################
#################### claim listing function#######################################
if(get_option('claim_listing')==1){
if ($author_role =='administrator' || $is_owned=='0' ){	
	if ( is_user_logged_in() ) { ?>
	<p class="edit-link"><a href="#" class="b_claim_listing"><?php echo CLAIM_LISTING_OWNER;?></a></p>
<?php } else { ?>
	<p class="edit-link"><a href="<?php echo home_url().'/?ptype=login&amp;msg=claim'; ?>" ><?php echo CLAIM_LISTING_OWNER;?></a></p>
<?php }} }?> 
     <?php if(isset($_REQUEST['claim_request']) && $_REQUEST['claim_request']=='success'){?>
        <p class="sucess_msg"><?php echo CLAIM_LISTING_SUCCESS;?></p>
         <?php }elseif(isset($_REQUEST['emsg']) && $_REQUEST['emsg']=='captch'){?>
        <p class="error_msg_fix"><?php echo WRONG_CAPTCH_MSG;?></p>
        <?php }
########################### end claim listing function ############################
########################### author link function       ############################
if ($is_owned=='1' && get_option('author_link')==1 && !$preview ){	
	 ?>
	<p class="author-link"><?php _e('Author : '); the_author_posts_link(); ?></p>
<?php } 

########################### end author link function   ############################
 
#################### Google Analytics function #######################################
if(get_option('ga_stats')==1 && get_edit_post_link() && !$preview && $post->post_status=='publish' && $pkg_limit['google_analytics']==1){
if(get_edit_post_link()){
	if ( is_user_logged_in() ) { 
	$page_url = $_SERVER['REQUEST_URI'];
	if(isset($_REQUEST['ga_start'])){$ga_start = $_REQUEST['ga_start'];}else{$ga_start = '';}
	if(isset($_REQUEST['ga_end'])){$ga_end = $_REQUEST['ga_end'];}else{$ga_end ='';}
	?>
<script type="text/javascript">
/* <![CDATA[ */
		jQuery(document).ready(function(){
			
				jQuery("#ga_stats p").load("<?php echo get_bloginfo('url').'/?ptype=ga&ga_page='.$page_url; ?>");
			
		});
		/* ]]> */
		</script>
        <div id="ga_stats"><p><img src="<?php echo get_bloginfo('template_directory').'/images/'; ?>ajax-loader.gif" /></p></div>
<?php }}}
########################### end Google Analytics function############################
?>
 
      	<p> <span class="i_location"><?php _e('Address :'); ?> </span> <?php if($preview){echo apply_filters('mrGT2max_address',$address);}else{echo apply_filters('mrGT2max_address',get_post_meta($post->ID,'address',true));} ?>   </p>
		 <?php if(get_post_meta($post->ID,'website',true) || $website){
			 if($preview){}else{$website = get_post_meta($post->ID,'website',true);}
			 if(!strstr($website,'http'))
			 {
				 $website = 'http://'.get_post_meta($post->ID,'website',true);
			 }
			 ?>
        <?php if($website && $pkg_limit['website_pkg']==1){?>
		<p>  <span class="i_website"><a href="<?php echo $website;?>" target="_blank" ><strong><?php _e('Website');?></strong></a>  </span> </p>
        <?php }?>
		<?php }?>
        
        <p>  <?php favourite_html($post->post_author,$post->ID); ?></p>
     
         <?php if(($timing || get_post_meta($post->ID,'timing',true)) && $pkg_limit['timing_pkg']==1){?>
		<p> <span class="i_time"> <?php echo EVENT_TIMING;?> : </span>  <?php if($preview){echo $timing;}else{echo get_post_meta($post->ID,'timing',true);}?>  </p>
		<?php }?>
         <?php if(($contact || get_post_meta($post->ID,'contact',true)) && $pkg_limit['contact_pkg']==1 && get_option('ptthemes_contact_on_detailpage')=='Yes' && get_post_meta($post->ID,'contact_show',true)!='No'){?>
		<p> <span class="i_contact"> <?php echo EVENT_CONTACT_INFO;?> :</span>  <?php if($preview){echo $contact;}else{echo get_post_meta($post->ID,'contact',true);}?>  </p>
		<?php }?>
        
         <?php if(($email || get_post_meta($post->ID,'email',true)) && $pkg_limit['email_pkg']==1 && get_option('ptthemes_email_on_detailpage')=='Yes' && get_post_meta($post->ID,'email_show',true)!='No'){?>
		<p> <span class="i_email2"><a href="#" class="b_send_inquiry" ><?php echo SEND_INQUIRY;?> </a> | <a href="#" class="b_sendtofriend"><?php echo SEND_TO_FRIEND;?></a></span></p>
         <?php if($_REQUEST['send_inquiry']=='success'){?>
        <p class="sucess_msg"><?php echo SEND_INQUIRY_SUCCESS;?></p>
        <?php }elseif($_REQUEST['sendtofrnd']=='success'){?>
        <p class="sucess_msg"><?php echo SEND_FRIEND_SUCCESS;?></p>
        <?php }elseif($_REQUEST['emsg']=='captch'){?>
        <p class="error_msg_fix"><?php echo WRONG_CAPTCH_MSG;?></p>
        <?php }?>
		<?php }?>
                 

           <?php if(!$preview){echo get_post_custom_listing_single_page($post->ID,'<p><span class="post_cus_field {#HTMLVAR#}">{#TITLE#} : </span>{#VALUE#}</p>');}
		   elseif($preview && $_REQUEST['alook']){echo get_post_custom_listing_single_page(mysql_real_escape_string($_REQUEST['pid']),'<p><span class="{#HTMLVAR#}">{#TITLE#}</span> : {#VALUE#}</p>');}else{echo get_post_custom_listing_single_page_preview($post->ID,'<p><span class="post_cus_field {#HTMLVAR#}">{#TITLE#} : </span>{#VALUE#}</p>');} ?>
        
        </div>
        
        <div class="company_info2">
        <?php if(!get_option('ptthemes_disable_rating')){ ?>
<div class="hreview-aggregate">
       <p> <span class="i_rating">
	   
   
	   <?php _e('Rating');?> :</span> <span class="single_rating"> <?php echo get_post_rating_star($post->ID);?></span><br /> 
       
       
       
      <span class="rating">
      <?php  if($preview){$avg_rating = 0;}else{$avg_rating = get_post_average_rating($post->ID);}
if($avg_rating==0)							{echo 0;}
if($avg_rating>=1 && $avg_rating<1.25 )		{echo 1;}
if($avg_rating>=1.25 && $avg_rating<1.75 )	{echo 1.5;}
if($avg_rating>=1.75 && $avg_rating<2.25 )	{echo 2;}
if($avg_rating>=2.25 && $avg_rating<2.75 )	{echo 2.5;}
if($avg_rating>=2.75 && $avg_rating<3.25 )	{echo 3;}
if($avg_rating>=3.25 && $avg_rating<3.75 )	{echo 3.5;}
if($avg_rating>=3.75 && $avg_rating<4.25 )	{echo 4;}
if($avg_rating>=4.25 && $avg_rating<4.75 )	{echo 4.5;}
if($avg_rating>=4.75 && $avg_rating<=5 )	{echo 5;}
 ?></span><?php _e('/5 based on');?> <span class="count"><?php  if($preview){$rating_count = 0;}else{$rating_count = get_post_rating_count($post->ID);} echo $rating_count; ?></span>  <?php _e('user');?> <?php if($rating_count == 1){_e('review.');}else{_e('reviews.');}?>
 <br />
   <span class="item">
      <span class="fn"><?php if($preview){echo $proprty_name;}else{the_title();} ?><br /> 
   <?php if($post_images[0][0]){ ?><img src="<?php echo $post_images[0][0]; ?>" height="50px" class="photo" alt="<?php if($preview){echo $proprty_name;}else{the_title();} ?>"/> <?php }?> </span></span>
        
     </p></div><?php }?> 
       <div class="share clearfix"> 
        <div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=<?php if(get_option('ptthemes_addthis_username')){echo get_option('ptthemes_addthis_username');}else{ echo 'ra-4facd1303678e5c0';}?>" class="addthis_button_compact sharethis"><?php _e('Share');?></a>
</div>


  </div>
      
      <div class="links">
       <?php if(($twitter || get_post_meta($post->ID,'twitter',true)) && $pkg_limit['twitter_pkg']==1){?><a href="<?php if($preview){echo $twitter;}else{echo get_post_meta($post->ID,'twitter',true);}?>" class="i_twitter" target="_blank"> <?php _e('Twitter');?> </a> <?php }?>     
        <?php if(($facebook || get_post_meta($post->ID,'facebook',true)) && $pkg_limit['facebook_pkg']==1){?><a href="<?php if($preview){echo $facebook;}else{echo get_post_meta($post->ID,'facebook',true);}?>" class="i_facebook" target="_blank"><?php _e('Facebook');?> </a><?php }?>  
       </div> 
      

        
         
        </div>  <?php if($pkg_limit['link_business_pkg']==1 && get_business_events_new() && !$preview): ?>
        <div class="widget">
		<div class="links"><h3><?php _e('Events'); ?></h3>
    <?php echo get_business_events_new(); ?>
    </div></div>
	<?php endif; ?>

    <?php if($pkg_limit['link_business_pkg']==1 && get_business_events_old() && !$preview): ?>
        <div class="widget">
		<div class="links"><h3><?php _e('Past Events'); ?></h3>
    <?php echo get_business_events_old(); ?>
    </div></div>           
	<?php endif; ?>

    <!-- company info -->
 	<div class="sidebar_in"><?php  dynamic_sidebar(8);  ?> </div>
    </div> <!-- sidebar #end -->
    </div>
    <?php if(!$preview){require_once (TEMPLATEPATH . '/library/includes/popup_frms.php');}?>
 <?php get_footer(); ?>