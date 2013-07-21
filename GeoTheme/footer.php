     </div> <!-- wrapper #end -->
 </div><!-- page #end -->
  
  
  <div id="bottom" class="clearfix">
  	<div id="bottom_in">
  		
      <div class="first_col">
      		<?php dynamic_sidebar(15);  ?>
      </div>
      
      <div class="second_col">
      		<?php dynamic_sidebar(16);  ?>
      </div>
      
      <div class="third_col fr">
      		<?php dynamic_sidebar(17);  ?>
      </div>
      
      
      <div class="fourth_col fr">
      		<?php dynamic_sidebar(18);  ?>
      </div>
        
        
        
        <div id="footer" class="clearfix">
  	  
          
          <?php if(	wp_nav_menu( array( 'theme_location' => 'footer_menu','fallback_cb' =>false,'echo' =>false))){wp_nav_menu( array( 'theme_location' => 'footer_menu','fallback_cb' =>false,'echo' =>true));} elseif ( get_option('ptthemes_footerpages') <> "" ) { ?>
             <ul>
             	<li class="hometab <?php if ( is_home() && !isset($_REQUEST['page']) ) { ?> current_page_item <?php } ?>"><a href="<?php echo get_option('home'); ?>/"><?php _e(Home); ?></a></li>
			<?php wp_list_pages('title_li=&depth=0&include=' . get_multiselect_val('ptthemes_footerpages') . '&sort_column=menu_order'); ?>
			</ul>
		<?php } ?>
          
          
          <p><?php if(get_option('ptthemes_copyright')!=''){echo stripslashes(get_option('ptthemes_copyright'));}else{echo '&copy; 2011 <a href="http://www.geotheme.com" title="geotheme.com">GeoTheme</a>, All right reserved';} ?></p>
         <?php /* <p> &copy; 2011 GeoPlaces, All right reserved </p> 

          <p class="copy"> Geo Places Theme by   <a href="http://templatic.com" title="templatic.com"><img src="<?php bloginfo('template_directory'); ?>/images/templatic.png" alt="" class="flogo" /></a> </p> */ ?>
          
        
          
  </div> <!-- footer #end -->
        
        
  </div> 
  </div>   <!-- bottom #end -->
  
  
  
  


<script type="text/javascript">
function addToFavourite(post_id,action)
{
 	//alert(post_id);
	<?php 
	global $current_user;
	if($current_user->data->ID==''){ 
	?>
	window.location.href="<?php echo home_url(); ?>/?ptype=login&amp;page1=sign_in";
	<?php 
	}else{
	?>
	var fav_url; 
	if(action == 'add')
	{
		fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=add&pid='+post_id;
	}
	else
	{
		fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=remove&pid='+post_id;
	}
	jQuery.ajax({
		url: fav_url ,
		type: 'GET',
		dataType: 'html',
		timeout: 20000,
		error: function(){
			alert('Error loading agent favorite property.');
		},
		success: function(html){	
		<?php 
		if(isset($_REQUEST['list']) && $_REQUEST['list']=='favourite')
		{ ?>
			document.getElementById('post-'+post_id).style.display='none';	
			<?php
		}
		?>	
			document.getElementById('favorite_property_'+post_id).innerHTML=html;								
		}
	});
	return false;
	<?php } ?>
}
</script>
  <?php wp_footer(); ?><?php if ( get_option('ptthemes_google_analytics') <> "" ) { echo stripslashes(get_option('ptthemes_google_analytics')); } ?>
 </body>
</html>