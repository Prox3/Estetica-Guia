<?php
// Register widgetized areas
function do_sidebars(){
if ( function_exists('register_sidebar') ) {
	 register_sidebars(1,array('name' => 'Front Top Banner Section','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Front content','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Front Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Content Pages Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Place Listing -> Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Add Place Listing Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 
	 	register_sidebars(1,array('name' => 'Place Detail Page Content Banner','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Place Detail -> Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Blog Listing -> Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	   register_sidebars(1,array('name' => 'Blog Detail -> Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	   register_sidebars(1,array('name' => 'Blog Detail Page Content Banner','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	    register_sidebars(1,array('name' => 'Event Listing','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
		register_sidebars(1,array('name' => 'Event Details','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Event Detail Page Content Banner','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(4,array('name' => 'Footer content %d ','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Main Navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Header Navigation Right','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Top Navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Place Listing Top Section','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Event Listing Top Section','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Author Pages Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Author Pages Top Section','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Reg/Login Top Section','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Logo Section','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  register_sidebars(1,array('name' => 'Add Listing Top Section','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	  
}}

do_sidebars();

// Check for widgets in widget-ready areas http://wordpress.org/support/topic/190184?replies=7#post-808787
// Thanks to Chaos Kaizer http://blog.kaizeku.com/
function is_sidebar_active( $index = 1){
	$sidebars	= wp_get_sidebars_widgets();
	$key		= (string) 'sidebar-'.$index;
 
	return (isset($sidebars[$key]));
}


// =============================== Login Widget ======================================
class loginwidget extends WP_Widget {
	function loginwidget() {
	//Constructor
		$widget_ops = array('classname' => 'Loginbox', 'description' => 'Loginbox Widget' );		
		$this->WP_Widget('widget_loginwidget', 'PT &rarr; Loginbox', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '&nbsp;' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			
            <div class="widget login_widget">
       		
 	       
          <?php
			global $current_user;
			if($current_user->ID)
			{
			?>
			<h3><?php _e(MY_ACCOUNT_TEXT);?></h3>
			<ul class="xoxo blogroll">
				<li><a href="<?php echo get_author_link($echo = false, $current_user->data->ID);?>"><?php echo DASHBOARD_TEXT;?></a></li>
				<li><a href="<?php echo home_url();?>/?ptype=profile"><?php echo EDIT_PROFILE_PAGE_TITLE;?></a></li>
				<li><a href="<?php echo home_url();?>/?ptype=profile"><?php echo CHANGE_PW_TEXT;?></a></li>
                <?php
                $user_link = get_author_link($echo = false, $current_user->data->ID, $author_nicename = '');
				if(strstr($user_link,'?') ){$user_link = $user_link.'&list=favourite';}else{$user_link = $user_link.'?list=favourite';}
				?>
                <li><a href="<?php echo $user_link;?>"><?php echo MY_FAVOURITE_TEXT;?></a></li>
                <?php if(get_option('is_user_addevent')=='0'){}else{ ?>
                <li><a href="<?php echo home_url(); ?>/?ptype=post_listing"><?php echo ADD_LISTING;?></a></li>
                <?php }?>
                <?php if(get_option('is_user_eventlist')=='0'){}else{ ?>
                <li><a href="<?php echo home_url(); ?>/?ptype=post_event"><?php echo ADD_EVENT;?></a></li>
                <?php }?>
                <li><a href="<?php echo home_url();?>/?ptype=login&amp;action=logout" class="signin"><?php echo LOGOUT_TEXT;?></a></li>
                
			</ul>
			<?php
			}else
			{
			?>
			<h3><?php echo $title; ?> </h3>
		    <form name="loginform" id="loginform1" action="<?php echo get_settings('home').'/index.php?ptype=login'; ?>" method="post" >
           		<div class="form_row"><label><?php _e('Email');?>  <span>*</span></label>  <input name="log" id="user_login1" type="text" class="textfield" /> <span id="user_loginInfo"></span> </div>
                <div class="form_row"><label><?php _e('Password');?>  <span>*</span></label>  <input name="pwd" id="user_pass1" type="password" class="textfield" /><span id="user_passInfo"></span>  </div>
                
               	<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
				<input type="hidden" name="testcookie" value="1" />
                
                <input type="submit" name="submit" value="<?php _e(SIGN_IN_BUTTON);?>" class="b_signin" /> 
             </form> 
            <p class="forgot_link">   <a href="<?php echo home_url(); ?>/?ptype=login&amp;page1=sign_up"><?php _e(NEW_USER_TEXT);?></a>  <br /> <a href="<?php echo home_url(); ?>/?ptype=login&amp;page1=sign_in"><?php _e(FORGOT_PW_TEXT);?></a> </p>            
            <?php }?>
            </div>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
     
        <?php /*?><p><label for="<?php echo $this->get_field_id('desc1'); ?>">Description <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo attribute_escape($desc1); ?></textarea></label></p><?php */?>
       
<?php
	}}
register_widget('loginwidget');

// =============================== Login Widget ======================================
class welcome_loginwidget extends WP_Widget {
	function welcome_loginwidget() {
	//Constructor
		$widget_ops = array('classname' => 'Loginbox', 'description' => 'Welcome Login Widget' );		
		$this->WP_Widget('widget_welcome_loginwidget', 'PT &rarr; Welcome Login', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		 					
		global $current_user;
?><ul>	<?php			
if($current_user->data->ID) { $display_name = $current_user->data->display_name; ?>
<li class="welcome"> <span><?php echo WELCOME_TEXT;?>, </span>  <a href="<?php echo get_author_link($echo = false, $current_user->data->ID);?>" title="<?php echo $display_name;?>">  <?php echo gt_user_short($display_name);?></a></li>
<li class="userin"><a href="<?php echo home_url();?>/?ptype=login&amp;action=logout" class="signin"><?php echo LOGOUT_TEXT;?></a></li>
<?php }else{ ?>
<li class="welcome"><span><?php echo WELCOME_TEXT;?>, <strong><?php echo GUEST_TEXT;?></strong></span> </li>
<li class="userin"><a href="<?php echo home_url();?>/?ptype=login&amp;page1=sign_in" class="signin"><?php echo SIGN_IN_TEXT;?></a></li>
<?php }?>
</ul>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );		
		$title = strip_tags($instance['title']);
?>
		<p>No settings for this widget</p>
     
    
<?php
	}}
register_widget('welcome_loginwidget');

// =============================== Social Like Widget ======================================
class social_like_widget extends WP_Widget {
	function social_like_widget() {
	//Constructor
		$widget_ops = array('classname' => 'social_like_widget', 'description' => 'Twitter,Facebook and Google+ buttons' );		
		$this->WP_Widget('social_like_widget', 'PT &rarr; Social Like', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		 					
		global $current_user;
?><div class="likethis_widget">

                     <?php if ( get_option('ptthemes_tweet_button') ) { ?>

                       <a href="http://twitter.com/share" class="twitter-share-button"><?php _e('Tweet');?></a>

					 <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> 

  					<?php } ?>

                     <?php if ( get_option('ptthemes_facebook_button') ) { ?>

        			<iframe <?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){echo 'allowtransparency="true"'; }?> class="facebook" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(curPageURL()); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0"  style="border:none; overflow:hidden; width:100px; height:20px"></iframe> 
                    <?php } ?>
                    
					<?php if ( get_option('ptthemes_google_button') ) { ?>
<div id="plusone-div"></div>
<script type="text/javascript">gapi.plusone.render('plusone-div', {"size": "medium", "count": "true" });</script>                    
					<?php } ?>

                      </div>

        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );		
		$title = strip_tags($instance['title']);
?>
		<p>No settings for this widget</p>
     
    
<?php
	}}
register_widget('social_like_widget');


// =============================== Multi City ======================================
class multi_city extends WP_Widget {
	function multi_city() {
	//Constructor
		$widget_ops = array('classname' => 'Multi City Options', 'description' => __('Multi City Options. It should be once on the page.') );		
		$this->WP_Widget('widget_multi_city', __('PT &rarr; Multi City Options'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '&nbsp;' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			
        <div class="widget multi_city">
        	
            <h3><?php echo $title; ?> </h3>
        
          <?php if(get_option('ptthemes_enable_multicity_flag')){
			  
//print_r($_SESSION);

echo get_multicity_dl('multi_city','multi_city',$_SESSION['multi_city'],'onchange="set_selected_city(this.value)"',1);
	
	
	
	
}

?>
        </div>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
	}}
register_widget('multi_city');

// =============================== LOCATION SELECT ======================================
class location_select extends WP_Widget {
	function location_select() {
	//Constructor
		$widget_ops = array('classname' => 'Area Select', 'description' => __('Location Select Widget. It should be once on the page.') );		
		$this->WP_Widget('widget_area_select', __('PT &rarr; Location Select'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '&nbsp;' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>
         
      
        
  <script type='text/javascript'>

  jQuery(function() {
		
jQuery("#get_countrys").click(function(){					
jQuery("#location_select_list").load("<?php echo get_bloginfo('url').'?ajax=get_countrys'; ?>");
});
jQuery("#get_regions").click(function(){
jQuery("#location_select_list").load("<?php echo get_bloginfo('url').'?ajax=get_regions'; ?>");
});
jQuery("#get_cities").click(function(){
jQuery("#location_select_list").load("<?php echo get_bloginfo('url').'?ajax=get_cities'; ?>");
});
			  
				  
jQuery('#location_select_widget').click( function() {
jQuery('#location_select_wrapper').slideToggle("200");
jQuery('body,html').animate({scrollTop: 0}, 800);

});
});
  
  
</script>
        
        	
        <div class="widget multi_city">
        	
            <h3><?php echo $title; ?> </h3>
<div  id="location_select_widget"><span><?php if($_SESSION['location_name']){echo $_SESSION['location_name'];}else{echo __('Select Location');}?></span></div>

        </div>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
	}}
register_widget('location_select');
	
// =============================== Feedburner Subscribe widget ======================================
class subscribeWidget extends WP_Widget {
	function subscribeWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Subscribe', 'description' => 'Subscribe' );		
		$this->WP_Widget('widget_subscribeWidget', 'PT &rarr; Subscribe', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
		$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);
		$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
		$digg = empty($instance['digg']) ? '' : apply_filters('widget_digg', $instance['digg']);
		$myspace = empty($instance['myspace']) ? '' : apply_filters('widget_myspace', $instance['myspace']);
		$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
?>
	
     
		 
	 
    	<div class="subscribe clearfix" >
      <h3><?php echo $title; ?>  <a href="<?php if($id){echo 'http://feeds2.feedburner.com/'.$id;}else{bloginfo('rss_url');} ?>" ><img  src="<?php bloginfo('template_directory'); ?>/images/i_rss.png" alt="" class="i_rss"  /> </a> </h3>
      
      
          	<?php if ( $text <> "" ) { ?>	 
         		 <p><?php echo $text; ?> </p>
            <?php } ?>
        
		<form class="subscribe_form"  action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow"  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">    
     <input type="text" class="field" onfocus="if (this.value == '<?php _e('Your Email Address')?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Your Email Address')?>';}" name="email" value="<?php _e('Your Email Address')?>" />
     <input type="hidden" value="<?php echo $id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/>
     <input class="btn_submit" type="submit" name="submit" value="Submit" /> 
     </form>
		  </div>  <!-- #end -->

<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['title'] = ($new_instance['title']);
		$instance['text'] = ($new_instance['text']);
		$instance['twitter'] = ($new_instance['twitter']);
		$instance['facebook'] = ($new_instance['facebook']);
		$instance['digg'] = ($new_instance['digg']);
		$instance['myspace'] = ($new_instance['myspace']);
		
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advt1' => '','text' => '','twitter' => '','facebook' => '','digg' => '','myspace' => '' ) );		
		$id = strip_tags($instance['id']);
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);
		$twitter = strip_tags($instance['twitter']);
		$facebook = strip_tags($instance['facebook']);
		$digg = strip_tags($instance['digg']);
		$myspace = strip_tags($instance['myspace']);

 ?>
 <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Feedburner ID (ex :- geotheme)');?>: <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Short Description');?> <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo attribute_escape($text); ?></textarea></label></p>
<?php
	}}
register_widget('subscribeWidget');


// =============================== Sidebar Advt second  ======================================
class advtwidget extends WP_Widget {
	function advtwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advertise', 'description' => __('common advertise widget in sidebar, bottom section') );
		$this->WP_Widget('advtwidget', __('PT &rarr; Advertise'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '&nbsp;' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						

        <div class="advt_single">    
        <?php if ( $desc1 <> "" ) { ?>	
         <?php echo $desc1; ?> 
         <?php } ?>
        </div>
             
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
        <p><label for="<?php echo $this->get_field_id('desc1'); ?>"><?php _e('Your Advt code (ex.google adsense, etc.)');?> <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo attribute_escape($desc1); ?></textarea></label></p>
       
<?php
	}}
register_widget('advtwidget');


// =============================== Home Page Banner  Widget ======================================

class homebannerwidget extends WP_Widget {
	function homebannerwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Home Banner', 'description' => __('Home banner with slider') );		
		$this->WP_Widget('widget_homebannerwidget', __('PT &rarr; Home Banner'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$s1 = empty($instance['s1']) ? '' : apply_filters('widget_s1', $instance['s1']);
		$s1link = empty($instance['s1link']) ? '' : apply_filters('widget_s1', $instance['s1link']);
		$s2 = empty($instance['s2']) ? '' : apply_filters('widget_s2', $instance['s2']);
		$s2link = empty($instance['s2link']) ? '' : apply_filters('widget_s2link', $instance['s2link']);
		$s3 = empty($instance['s3']) ? '' : apply_filters('widget_s3', $instance['s3']);
		$s3link = empty($instance['s3link']) ? '' : apply_filters('widget_s3link', $instance['s3link']);
		$s4 = empty($instance['s4']) ? '' : apply_filters('widget_s4', $instance['s4']);
		$s4link = empty($instance['s4link']) ? '' : apply_filters('widget_s4link', $instance['s4link']);
		$s5 = empty($instance['s5']) ? '' : apply_filters('widget_s5', $instance['s5']);
		$s5link = empty($instance['s5link']) ? '' : apply_filters('widget_s5link', $instance['s5link']);
		$s6 = empty($instance['s6']) ? '' : apply_filters('widget_s6', $instance['s6']);
		$s6link = empty($instance['s6link']) ? '' : apply_filters('widget_s6link', $instance['s6link']);
		$s7 = empty($instance['s7']) ? '' : apply_filters('widget_s7', $instance['s7']);
		$s7link = empty($instance['s7link']) ? '' : apply_filters('widget_s7link', $instance['s7link']);
		$s8 = empty($instance['s8']) ? '' : apply_filters('widget_s8', $instance['s8']);
		$s8link = empty($instance['s8link']) ? '' : apply_filters('widget_s8link', $instance['s8link']);
		$s9 = empty($instance['s9']) ? '' : apply_filters('widget_s9', $instance['s9']);
		$s9link = empty($instance['s9link']) ? '' : apply_filters('widget_s9link', $instance['s9link']);
		$s10 = empty($instance['s10']) ? '' : apply_filters('widget_s10', $instance['s10']);
		$s10link = empty($instance['s10link']) ? '' : apply_filters('widget_s10link', $instance['s10link']);
		
		$width = empty($instance['width']) ? '940px' : apply_filters('widget_width', $instance['width']);
		$height = empty($instance['height']) ? '425px' : apply_filters('widget_height', $instance['height']);
		
		$effect = empty($instance['effect']) ? 'random' : apply_filters('widget_effect', $instance['effect']);
		$slices = empty($instance['slices']) ? '15' : apply_filters('widget_slices', $instance['slices']);
		$new_win = empty($instance['new_win']) ? '' : apply_filters('new_win', $instance['new_win']);
		$rand = empty($instance['rand']) ? '' : apply_filters('rand', $instance['rand']);
	 	$animSpeed = empty($instance['animSpeed']) ? '700' : apply_filters('widget_animSpeed', $instance['animSpeed']);
		$pauseTime = empty($instance['pauseTime']) ? '3000' : apply_filters('widget_pauseTime', $instance['pauseTime']);
		$startSlide = empty($instance['startSlide']) ? '' : apply_filters('widget_startSlide', $instance['startSlide']);
		$directionNavHide = empty($instance['directionNavHide']) ? '' : apply_filters('widget_directionNavHide', $instance['directionNavHide']);
		$slider_img = empty($instance['slider_img']) ? 'Yes' : apply_filters('widget_slider_img', $instance['slider_img']);
		
		$img_arr = array();
		
		$img_arr[] = array('url'=>$s1,'link'=>$s1link);
		$img_arr[] = array('url'=>$s2,'link'=>$s2link);
		$img_arr[] = array('url'=>$s3,'link'=>$s3link);
		$img_arr[] = array('url'=>$s4,'link'=>$s4link);
		$img_arr[] = array('url'=>$s5,'link'=>$s5link);
		$img_arr[] = array('url'=>$s6,'link'=>$s6link);
		$img_arr[] = array('url'=>$s7,'link'=>$s7link);
		$img_arr[] = array('url'=>$s8,'link'=>$s8link);
		$img_arr[] = array('url'=>$s9,'link'=>$s9link);
		$img_arr[] = array('url'=>$s10,'link'=>$s10link);
	
		if($rand){shuffle($img_arr);}
		?>						

<script type="text/javascript" language="javascript">
jQuery(function() {
	jQuery('#slider').nivoSlider({
		effect:'<?php if (($effect) <> "" ) { echo (($effect)); } else { echo 'random'; } ?>', //Specify sets like: 'random,fold,fade,sliceDown'
		slices:<?php if (($slices) <> "" ) { echo (($slices)); } else { echo '15'; } ?>,
		boxCols:8,
        boxRows:1,
		animSpeed:<?php if (($animSpeed) <> "" ) { echo (($animSpeed)); } else { echo '700'; } ?>,
		pauseTime:<?php if (($pauseTime) <> "" ) { echo (($pauseTime)); } else { echo '3000'; } ?>,
		startSlide:0, //Set starting Slide (0 index)
		directionNav:true, //Next and Prev
		directionNavHide:true, //Only show on hover
		controlNav:true, //1,2,3...
		controlNavThumbs:false, //Use thumbnails for Control Nav
     	controlNavThumbsFromRel:false, //Use image rel for thumbs
		keyboardNav:true, //Use left and right arrows
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		captionOpacity:0.8, //Universal caption opacity
		
	});
});
</script>

<div class="top_banner_section">
                <div class="top_banner_section_in top_banner_fix clearfix" style="max-width:<?php echo $width; ?>">
                
             	<div  id="slider" class="grid8 fr">
              <?php foreach( $img_arr as $img ) { if($img['url']){?>
              <a class="nivo-imageLink" href="<?php echo $img['link'] ?>" <?php if($new_win){echo 'target="_blank"';}?>><img src="<?php echo $img['url']; ?>"  alt=""  /></a>
         		<?php }} ?>
             	 </div>
            </div>
         </div> <!-- top_banner_section #end -->
      
            
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['s1'] = ($new_instance['s1']);
		$instance['s1link'] = ($new_instance['s1link']);
		$instance['s2'] = ($new_instance['s2']);
		$instance['s2link'] = ($new_instance['s2link']);
		$instance['s3'] = ($new_instance['s3']);
		$instance['s3link'] = ($new_instance['s3link']);
		$instance['s4'] = ($new_instance['s4']);
		$instance['s4link'] = ($new_instance['s4link']);
		$instance['s5'] = ($new_instance['s5']);
		$instance['s5link'] = ($new_instance['s5link']);
		$instance['s6'] = ($new_instance['s6']);
		$instance['s6link'] = ($new_instance['s6link']);
		$instance['s7'] = ($new_instance['s7']);
		$instance['s7link'] = ($new_instance['s7link']);
		$instance['s8'] = ($new_instance['s8']);
		$instance['s8link'] = ($new_instance['s8link']);
		$instance['s9'] = ($new_instance['s9']);
		$instance['s9link'] = ($new_instance['s9link']);
		$instance['s10'] = ($new_instance['s10']);
		$instance['s10link'] = ($new_instance['s10link']);
		
		$instance['width'] = ($new_instance['width']);
		$instance['height'] = ($new_instance['height']);
		$instance['effect'] = ($new_instance['effect']);
		$instance['new_win'] = ($new_instance['new_win']);
		$instance['rand'] = ($new_instance['rand']);
		$instance['slices'] = ($new_instance['slices']);
		$instance['animSpeed'] = ($new_instance['animSpeed']);
		$instance['pauseTime'] = ($new_instance['pauseTime']);
		$instance['startSlide'] = ($new_instance['startSlide']);
		$instance['directionNavHide'] = ($new_instance['directionNavHide']);
		$instance['slider_img'] = ($new_instance['slider_img']);
 		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'desc' => '','actionbtn' => '','actionlink' => '','s1' => '','s2' => '','s3' => '','s4' => '','s5' => '','s6' => '','s7' => '','s8' => '','s9' => '','s10' => '','s1link' => '','s2link' => '','s3link' => '','s4link' => '','s5link' => '','s6link' => '','s7link' => '','s8link' => '','s9link' => '','s10link' => '', 'effect' => '','slices' => '','new_win' => '','rand' => '','animSpeed' => '','pauseTime' => '','startSlide' => '','directionNavHide' => '', 'slider_img' => '','width' => '','height' => '' ) );		
		$title = strip_tags($instance['title']);
		$width = ($instance['width']);
		$height = ($instance['height']);
 		$s1 = ($instance['s1']);
		$s1link = ($instance['s1link']);
		$s2 = ($instance['s2']);
		$s2link = ($instance['s2link']);
		$s3 = ($instance['s3']);
		$s3link = ($instance['s3link']);
		$s4 = ($instance['s4']);
		$s4link = ($instance['s4link']);
		$s5 = ($instance['s5']);
		$s5link = ($instance['s5link']);
		$s6 = ($instance['s6']);
		$s6link = ($instance['s6link']);
		$s7 = ($instance['s7']);
		$s7link = ($instance['s7link']);
		$s8 = ($instance['s8']);
		$s8link = ($instance['s8link']);
		$s9 = ($instance['s9']);
		$s9link = ($instance['s9link']);
		$s10 = ($instance['s10']);
		$s10link = ($instance['s10link']);
		
		$effect = ($instance['effect']);
		$new_win = ($instance['new_win']);
		$rand = ($instance['rand']);
		$slices = ($instance['slices']);
		$animSpeed = ($instance['animSpeed']);
		$pauseTime = ($instance['pauseTime']);
		$startSlide = ($instance['startSlide']);
		$directionNavHide = ($instance['directionNavHide']);
		$slider_img = ($instance['slider_img']);
		 ?>

<p><label for="<?php echo $this->get_field_id('new_win'); ?>"><?php _e('Open links in new window:');?><input type="checkbox" id="<?php echo $this->get_field_id('new_win'); ?>" name="<?php echo $this->get_field_name('new_win'); ?>" <?php if(attribute_escape($new_win)){ echo'checked="checked"';} ?> value="1"></label>
</p>

<p><label for="<?php echo $this->get_field_id('rand'); ?>"><?php _e('Start on random image:');?><input type="checkbox" id="<?php echo $this->get_field_id('rand'); ?>" name="<?php echo $this->get_field_name('rand'); ?>" <?php if(attribute_escape($rand)){ echo'checked="checked"';} ?> value="1"></label>
</p> 

<p><label for="<?php echo $this->get_field_id('slices'); ?>"><?php _e('Banner Images slices (slider images slice effect)(ex: 15) :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('slices'); ?>" name="<?php echo $this->get_field_name('slices'); ?>" value="<?php echo attribute_escape($slices); ?>"></label>
</p> 

<p><label for="<?php echo $this->get_field_id('animSpeed'); ?>"><?php _e('Banner Slider image in time(ex: 700) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('animSpeed'); ?>" name="<?php echo $this->get_field_name('animSpeed'); ?>" value="<?php echo attribute_escape($animSpeed); ?>"></label>
</p>

<p><label for="<?php echo $this->get_field_id('pauseTime'); ?>"><?php _e('Banner Slider image out time(ex: 3000)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('pauseTime'); ?>" name="<?php echo $this->get_field_name('pauseTime'); ?>" value="<?php echo attribute_escape($pauseTime); ?>"></label>
</p>


<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Banner image Width (maximum 940px) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo attribute_escape($width); ?>"></label>
</p>

<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Banner image Height (minimum 100px) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo attribute_escape($height); ?>"></label>
</p>

<p>
  <label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Banner Effect:');?>
  <select id="<?php echo $this->get_field_id('effect'); ?>" name="<?php echo $this->get_field_name('effect'); ?>" style="width:50%;">
  <option <?php if(attribute_escape($effect)=='random'){ echo 'selected="selected"';}?>>random</option>
  <option <?php if(attribute_escape($effect)=='fold'){ echo 'selected="selected"';}?>>fold</option>
  <option <?php if(attribute_escape($effect)=='fade'){ echo 'selected="selected"';}?>>fade</option>
  <option <?php if(attribute_escape($effect)=='sliceDown'){ echo 'selected="selected"';}?>>sliceDown</option>
  </select>
  </label>
</p>
 
<p><label for="<?php echo $this->get_field_id('s1'); ?>"><?php _e('Banner Slider Image 1 full URL (size : w940xh425 pixel) (ex.http://geotheme.com/images/banner1.png)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1'); ?>" name="<?php echo $this->get_field_name('s1'); ?>" value="<?php echo attribute_escape($s1); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s1link'); ?>"><?php _e('Banner Slider Image 1 Link (ex.http://geotheme.com)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1link'); ?>" name="<?php echo $this->get_field_name('s1link'); ?>" value="<?php echo attribute_escape($s1link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s2'); ?>"><?php _e('Banner Slider Image 2 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2'); ?>" name="<?php echo $this->get_field_name('s2'); ?>" value="<?php echo attribute_escape($s2); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s2link'); ?>"><?php _e('Banner Slider Image 2 Link :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2link'); ?>" name="<?php echo $this->get_field_name('s2link'); ?>" value="<?php echo attribute_escape($s2link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s3'); ?>"><?php _e('Banner Slider Image 3 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3'); ?>" name="<?php echo $this->get_field_name('s3'); ?>" value="<?php echo attribute_escape($s3); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s3link'); ?>"><?php _e('Banner Slider Image 3 Link  :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3link'); ?>" name="<?php echo $this->get_field_name('s3link'); ?>" value="<?php echo attribute_escape($s3link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s4'); ?>"><?php _e('Banner Slider Image 4 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4'); ?>" name="<?php echo $this->get_field_name('s4'); ?>" value="<?php echo attribute_escape($s4); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s4link'); ?>"><?php _e('Banner Slider Image 4 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4link'); ?>" name="<?php echo $this->get_field_name('s4link'); ?>" value="<?php echo attribute_escape($s4link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s5'); ?>"><?php _e('Banner Slider Image 5 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5'); ?>" name="<?php echo $this->get_field_name('s5'); ?>" value="<?php echo attribute_escape($s5); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s5link'); ?>"><?php _e('Banner Slider Image 5 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5link'); ?>" name="<?php echo $this->get_field_name('s5link'); ?>" value="<?php echo attribute_escape($s5link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s6'); ?>"><?php _e('Banner Slider Image 6 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6'); ?>" name="<?php echo $this->get_field_name('s6'); ?>" value="<?php echo attribute_escape($s6); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s6link'); ?>"><?php _e('Banner Slider Image 6 Link  :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6link'); ?>" name="<?php echo $this->get_field_name('s6link'); ?>" value="<?php echo attribute_escape($s6link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s7'); ?>"><?php _e('Banner Slider Image 7 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7'); ?>" name="<?php echo $this->get_field_name('s7'); ?>" value="<?php echo attribute_escape($s7); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s7link'); ?>"><?php _e('Banner Slider Image 7 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7link'); ?>" name="<?php echo $this->get_field_name('s7link'); ?>" value="<?php echo attribute_escape($s7link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s8'); ?>"><?php _e('Banner Slider Image 8 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8'); ?>" name="<?php echo $this->get_field_name('s8'); ?>" value="<?php echo attribute_escape($s8); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s8link'); ?>"><?php _e('Banner Slider Image 8 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8link'); ?>" name="<?php echo $this->get_field_name('s8link'); ?>" value="<?php echo attribute_escape($s8link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s9'); ?>"><?php _e('Banner Slider Image 9 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9'); ?>" name="<?php echo $this->get_field_name('s9'); ?>" value="<?php echo attribute_escape($s9); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s9link'); ?>"><?php _e('Banner Slider Image 9 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9link'); ?>" name="<?php echo $this->get_field_name('s9link'); ?>" value="<?php echo attribute_escape($s9link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s10'); ?>"><?php _e('Banner Slider Image 10 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10'); ?>" name="<?php echo $this->get_field_name('s10'); ?>" value="<?php echo attribute_escape($s10); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s10link'); ?>"><?php _e('Banner Slider Image 10 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10link'); ?>" name="<?php echo $this->get_field_name('s10link'); ?>" value="<?php echo attribute_escape($s10link); ?>"></label>
</p>
<?php
	}}
register_widget('homebannerwidget');

// =============================== Logo Banner Section  Widget ======================================

class logobannerwidget extends WP_Widget {
	function logobannerwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Logo Banner', 'description' => __('Logo banner with slider') );		
		$this->WP_Widget('widget_logobannerwidget', __('PT &rarr; Logo Banner'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$s1 = empty($instance['s1']) ? '' : apply_filters('widget_s1', $instance['s1']);
		$s1link = empty($instance['s1link']) ? '' : apply_filters('widget_s1', $instance['s1link']);
		$s2 = empty($instance['s2']) ? '' : apply_filters('widget_s2', $instance['s2']);
		$s2link = empty($instance['s2link']) ? '' : apply_filters('widget_s2link', $instance['s2link']);
		$s3 = empty($instance['s3']) ? '' : apply_filters('widget_s3', $instance['s3']);
		$s3link = empty($instance['s3link']) ? '' : apply_filters('widget_s3link', $instance['s3link']);
		$s4 = empty($instance['s4']) ? '' : apply_filters('widget_s4', $instance['s4']);
		$s4link = empty($instance['s4link']) ? '' : apply_filters('widget_s4link', $instance['s4link']);
		$s5 = empty($instance['s5']) ? '' : apply_filters('widget_s5', $instance['s5']);
		$s5link = empty($instance['s5link']) ? '' : apply_filters('widget_s5link', $instance['s5link']);
		$s6 = empty($instance['s6']) ? '' : apply_filters('widget_s6', $instance['s6']);
		$s6link = empty($instance['s6link']) ? '' : apply_filters('widget_s6link', $instance['s6link']);
		$s7 = empty($instance['s7']) ? '' : apply_filters('widget_s7', $instance['s7']);
		$s7link = empty($instance['s7link']) ? '' : apply_filters('widget_s7link', $instance['s7link']);
		$s8 = empty($instance['s8']) ? '' : apply_filters('widget_s8', $instance['s8']);
		$s8link = empty($instance['s8link']) ? '' : apply_filters('widget_s8link', $instance['s8link']);
		$s9 = empty($instance['s9']) ? '' : apply_filters('widget_s9', $instance['s9']);
		$s9link = empty($instance['s9link']) ? '' : apply_filters('widget_s9link', $instance['s9link']);
		$s10 = empty($instance['s10']) ? '' : apply_filters('widget_s10', $instance['s10']);
		$s10link = empty($instance['s10link']) ? '' : apply_filters('widget_s10link', $instance['s10link']);
		
		$width = empty($instance['width']) ? '940' : apply_filters('widget_width', $instance['width']);
		$height = empty($instance['height']) ? '425' : apply_filters('widget_height', $instance['height']);
		
		$effect = empty($instance['effect']) ? 'random' : apply_filters('widget_effect', $instance['effect']);
		$slices = empty($instance['slices']) ? '15' : apply_filters('widget_slices', $instance['slices']);
		$new_win = empty($instance['new_win']) ? '' : apply_filters('new_win', $instance['new_win']);
		$rand = empty($instance['rand']) ? '' : apply_filters('rand', $instance['rand']);
	 	$animSpeed = empty($instance['animSpeed']) ? '700' : apply_filters('widget_animSpeed', $instance['animSpeed']);
		$pauseTime = empty($instance['pauseTime']) ? '3000' : apply_filters('widget_pauseTime', $instance['pauseTime']);
		$startSlide = empty($instance['startSlide']) ? '' : apply_filters('widget_startSlide', $instance['startSlide']);
		$directionNavHide = empty($instance['directionNavHide']) ? '' : apply_filters('widget_directionNavHide', $instance['directionNavHide']);
		$slider_img = empty($instance['slider_img']) ? 'Yes' : apply_filters('widget_slider_img', $instance['slider_img']);
		
		$img_arr = array();
		
		$img_arr[] = array('url'=>$s1,'link'=>$s1link);
		$img_arr[] = array('url'=>$s2,'link'=>$s2link);
		$img_arr[] = array('url'=>$s3,'link'=>$s3link);
		$img_arr[] = array('url'=>$s4,'link'=>$s4link);
		$img_arr[] = array('url'=>$s5,'link'=>$s5link);
		$img_arr[] = array('url'=>$s6,'link'=>$s6link);
		$img_arr[] = array('url'=>$s7,'link'=>$s7link);
		$img_arr[] = array('url'=>$s8,'link'=>$s8link);
		$img_arr[] = array('url'=>$s9,'link'=>$s9link);
		$img_arr[] = array('url'=>$s10,'link'=>$s10link);
	
		if($rand){shuffle($img_arr);}
		?>						

<script type="text/javascript" language="javascript">
jQuery(function() {
	jQuery('#slider3').nivoSlider({
		effect:'<?php if (($effect) <> "" ) { echo (($effect)); } else { echo 'random'; } ?>', //Specify sets like: 'random,fold,fade,sliceDown'
		slices:<?php if (($slices) <> "" ) { echo (($slices)); } else { echo '15'; } ?>,
		animSpeed:<?php if (($animSpeed) <> "" ) { echo (($animSpeed)); } else { echo '700'; } ?>,
		pauseTime:<?php if (($pauseTime) <> "" ) { echo (($pauseTime)); } else { echo '3000'; } ?>,
		startSlide:0, //Set starting Slide (0 index)
		directionNav:true, //Next and Prev
		directionNavHide:true, //Only show on hover
		controlNav:true, //1,2,3...
		controlNavThumbs:false, //Use thumbnails for Control Nav
     	controlNavThumbsFromRel:false, //Use image rel for thumbs
		controlNavThumbsSearch: '.jpg', //Replace this with...
		controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
		keyboardNav:true, //Use left and right arrows
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		captionOpacity:0.8, //Universal caption opacity
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){} //Triggers after all slides have been shown
	});
});
</script>

<style type="text/css">
#header .header_left .we_recommend{height:<?php echo $height; ?>px;}
#header .header_left .we_recommend .we_recommend_in{max-width:<?php echo $width; ?>px;  height:<?php echo $height+15; ?>px;width:100%}
#header .header_left .we_recommend .we_recommend_in #slider3{max-width:<?php echo $width; ?>px;  height:<?php echo $height; ?>px; width:100%}
</style>
				 <div class="we_recommend" style="">
                
		 			<h3> <?php echo $title; ?> </h3>
                    
 
                    <div class="we_recommend_in" style="" >
           
             	<div  id="slider3" style="" >
             	
                <?php foreach( $img_arr as $img ) { if($img['url']){?>	 
         			<a class="nivo-imageLink" href="<?php echo $img['link']; ?>" style="height:<?php echo $height; ?>px !important; overflow:hidden;"  <?php if($new_win){echo 'target="_blank"';}?>><img src="<?php echo $img['url']; ?>"  alt="" /></a>
         		<?php }} ?>
                               	
                </div>
                
                </div> 
            
            	</div>
         
      
            
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['s1'] = ($new_instance['s1']);
		$instance['s1link'] = ($new_instance['s1link']);
		$instance['s2'] = ($new_instance['s2']);
		$instance['s2link'] = ($new_instance['s2link']);
		$instance['s3'] = ($new_instance['s3']);
		$instance['s3link'] = ($new_instance['s3link']);
		$instance['s4'] = ($new_instance['s4']);
		$instance['s4link'] = ($new_instance['s4link']);
		$instance['s5'] = ($new_instance['s5']);
		$instance['s5link'] = ($new_instance['s5link']);
		$instance['s6'] = ($new_instance['s6']);
		$instance['s6link'] = ($new_instance['s6link']);
		$instance['s7'] = ($new_instance['s7']);
		$instance['s7link'] = ($new_instance['s7link']);
		$instance['s8'] = ($new_instance['s8']);
		$instance['s8link'] = ($new_instance['s8link']);
		$instance['s9'] = ($new_instance['s9']);
		$instance['s9link'] = ($new_instance['s9link']);
		$instance['s10'] = ($new_instance['s10']);
		$instance['s10link'] = ($new_instance['s10link']);
		
		$instance['width'] = ($new_instance['width']);
		$instance['height'] = ($new_instance['height']);
		$instance['effect'] = ($new_instance['effect']);
		$instance['new_win'] = ($new_instance['new_win']);
		$instance['rand'] = ($new_instance['rand']);
		$instance['slices'] = ($new_instance['slices']);
		$instance['animSpeed'] = ($new_instance['animSpeed']);
		$instance['pauseTime'] = ($new_instance['pauseTime']);
		$instance['startSlide'] = ($new_instance['startSlide']);
		$instance['directionNavHide'] = ($new_instance['directionNavHide']);
		$instance['slider_img'] = ($new_instance['slider_img']);
 		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'desc' => '','actionbtn' => '','actionlink' => '','s1' => '','s2' => '','s3' => '','s4' => '','s5' => '','s6' => '','s7' => '','s8' => '','s9' => '','s10' => '','s1link' => '','s2link' => '','s3link' => '','s4link' => '','s5link' => '','s6link' => '','s7link' => '','s8link' => '','s9link' => '','s10link' => '', 'effect' => '','slices' => '','new_win' => '','rand' => '','animSpeed' => '','pauseTime' => '','startSlide' => '','directionNavHide' => '', 'slider_img' => '','width' => '','height' => '' ) );		
		$title = strip_tags($instance['title']);
		$width = ($instance['width']);
		$height = ($instance['height']);
 		$s1 = ($instance['s1']);
		$s1link = ($instance['s1link']);
		$s2 = ($instance['s2']);
		$s2link = ($instance['s2link']);
		$s3 = ($instance['s3']);
		$s3link = ($instance['s3link']);
		$s4 = ($instance['s4']);
		$s4link = ($instance['s4link']);
		$s5 = ($instance['s5']);
		$s5link = ($instance['s5link']);
		$s6 = ($instance['s6']);
		$s6link = ($instance['s6link']);
		$s7 = ($instance['s7']);
		$s7link = ($instance['s7link']);
		$s8 = ($instance['s8']);
		$s8link = ($instance['s8link']);
		$s9 = ($instance['s9']);
		$s9link = ($instance['s9link']);
		$s10 = ($instance['s10']);
		$s10link = ($instance['s10link']);
		
		$effect = ($instance['effect']);
		$new_win = ($instance['new_win']);
		$rand = ($instance['rand']);
		$slices = ($instance['slices']);
		$animSpeed = ($instance['animSpeed']);
		$pauseTime = ($instance['pauseTime']);
		$startSlide = ($instance['startSlide']);
		$directionNavHide = ($instance['directionNavHide']);
		$slider_img = ($instance['slider_img']);
		 ?>

<p><label for="<?php echo $this->get_field_id('new_win'); ?>"><?php _e('Open links in new window:');?><input type="checkbox" id="<?php echo $this->get_field_id('new_win'); ?>" name="<?php echo $this->get_field_name('new_win'); ?>" <?php if(attribute_escape($new_win)){ echo'checked="checked"';} ?> value="1"></label>
</p>

<p><label for="<?php echo $this->get_field_id('rand'); ?>"><?php _e('Start on random image:');?><input type="checkbox" id="<?php echo $this->get_field_id('rand'); ?>" name="<?php echo $this->get_field_name('rand'); ?>" <?php if(attribute_escape($rand)){ echo'checked="checked"';} ?> value="1"></label>
</p> 

<p><label for="<?php echo $this->get_field_id('slices'); ?>"><?php _e('Banner Images slices (slider images slice effect)(ex: 15) :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('slices'); ?>" name="<?php echo $this->get_field_name('slices'); ?>" value="<?php echo attribute_escape($slices); ?>"></label>
</p> 

<p><label for="<?php echo $this->get_field_id('animSpeed'); ?>"><?php _e('Banner Slider image in time(ex: 700) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('animSpeed'); ?>" name="<?php echo $this->get_field_name('animSpeed'); ?>" value="<?php echo attribute_escape($animSpeed); ?>"></label>
</p>

<p><label for="<?php echo $this->get_field_id('pauseTime'); ?>"><?php _e('Banner Slider image out time(ex: 3000)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('pauseTime'); ?>" name="<?php echo $this->get_field_name('pauseTime'); ?>" value="<?php echo attribute_escape($pauseTime); ?>"></label>
</p>


<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Banner image Width (maximum 940px) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo attribute_escape($width); ?>"></label>
</p>

<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Banner image Height (minimum 100px) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo attribute_escape($height); ?>"></label>
</p>

<p>
  <label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Banner Effect:');?>
  <select id="<?php echo $this->get_field_id('effect'); ?>" name="<?php echo $this->get_field_name('effect'); ?>" style="width:50%;">
  <option <?php if(attribute_escape($effect)=='random'){ echo 'selected="selected"';}?>>random</option>
  <option <?php if(attribute_escape($effect)=='fold'){ echo 'selected="selected"';}?>>fold</option>
  <option <?php if(attribute_escape($effect)=='fade'){ echo 'selected="selected"';}?>>fade</option>
  <option <?php if(attribute_escape($effect)=='sliceDown'){ echo 'selected="selected"';}?>>sliceDown</option>
  </select>
  </label>
</p>
 
<p><label for="<?php echo $this->get_field_id('s1'); ?>"><?php _e('Banner Slider Image 1 full URL (size : w940xh425 pixel) (ex.http://geotheme.com/images/banner1.png)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1'); ?>" name="<?php echo $this->get_field_name('s1'); ?>" value="<?php echo attribute_escape($s1); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s1link'); ?>"><?php _e('Banner Slider Image 1 Link (ex.http://geotheme.com)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1link'); ?>" name="<?php echo $this->get_field_name('s1link'); ?>" value="<?php echo attribute_escape($s1link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s2'); ?>"><?php _e('Banner Slider Image 2 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2'); ?>" name="<?php echo $this->get_field_name('s2'); ?>" value="<?php echo attribute_escape($s2); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s2link'); ?>"><?php _e('Banner Slider Image 2 Link :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2link'); ?>" name="<?php echo $this->get_field_name('s2link'); ?>" value="<?php echo attribute_escape($s2link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s3'); ?>"><?php _e('Banner Slider Image 3 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3'); ?>" name="<?php echo $this->get_field_name('s3'); ?>" value="<?php echo attribute_escape($s3); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s3link'); ?>"><?php _e('Banner Slider Image 3 Link  :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3link'); ?>" name="<?php echo $this->get_field_name('s3link'); ?>" value="<?php echo attribute_escape($s3link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s4'); ?>"><?php _e('Banner Slider Image 4 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4'); ?>" name="<?php echo $this->get_field_name('s4'); ?>" value="<?php echo attribute_escape($s4); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s4link'); ?>"><?php _e('Banner Slider Image 4 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4link'); ?>" name="<?php echo $this->get_field_name('s4link'); ?>" value="<?php echo attribute_escape($s4link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s5'); ?>"><?php _e('Banner Slider Image 5 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5'); ?>" name="<?php echo $this->get_field_name('s5'); ?>" value="<?php echo attribute_escape($s5); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s5link'); ?>"><?php _e('Banner Slider Image 5 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5link'); ?>" name="<?php echo $this->get_field_name('s5link'); ?>" value="<?php echo attribute_escape($s5link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s6'); ?>"><?php _e('Banner Slider Image 6 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6'); ?>" name="<?php echo $this->get_field_name('s6'); ?>" value="<?php echo attribute_escape($s6); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s6link'); ?>"><?php _e('Banner Slider Image 6 Link  :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6link'); ?>" name="<?php echo $this->get_field_name('s6link'); ?>" value="<?php echo attribute_escape($s6link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s7'); ?>"><?php _e('Banner Slider Image 7 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7'); ?>" name="<?php echo $this->get_field_name('s7'); ?>" value="<?php echo attribute_escape($s7); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s7link'); ?>"><?php _e('Banner Slider Image 7 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7link'); ?>" name="<?php echo $this->get_field_name('s7link'); ?>" value="<?php echo attribute_escape($s7link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s8'); ?>"><?php _e('Banner Slider Image 8 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8'); ?>" name="<?php echo $this->get_field_name('s8'); ?>" value="<?php echo attribute_escape($s8); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s8link'); ?>"><?php _e('Banner Slider Image 8 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8link'); ?>" name="<?php echo $this->get_field_name('s8link'); ?>" value="<?php echo attribute_escape($s8link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s9'); ?>"><?php _e('Banner Slider Image 9 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9'); ?>" name="<?php echo $this->get_field_name('s9'); ?>" value="<?php echo attribute_escape($s9); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s9link'); ?>"><?php _e('Banner Slider Image 9 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9link'); ?>" name="<?php echo $this->get_field_name('s9link'); ?>" value="<?php echo attribute_escape($s9link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s10'); ?>"><?php _e('Banner Slider Image 10 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10'); ?>" name="<?php echo $this->get_field_name('s10'); ?>" value="<?php echo attribute_escape($s10); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s10link'); ?>"><?php _e('Banner Slider Image 10 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10link'); ?>" name="<?php echo $this->get_field_name('s10link'); ?>" value="<?php echo attribute_escape($s10link); ?>"></label>
</p>
<?php
	}}
register_widget('logobannerwidget');

// =============================== Siderbar Page Banner  Widget ======================================

class werecommend extends WP_Widget {
	function werecommend() {
	//Constructor
		$widget_ops = array('classname' => 'widget We Recommend', 'description' => __('We Recommend - slider') );		
		$this->WP_Widget('widget_werecommend', __('PT &rarr; We Recommend'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$s1 = empty($instance['s1']) ? '' : apply_filters('widget_s1', $instance['s1']);
		$s1link = empty($instance['s1link']) ? '' : apply_filters('widget_s1', $instance['s1link']);
		$s2 = empty($instance['s2']) ? '' : apply_filters('widget_s2', $instance['s2']);
		$s2link = empty($instance['s2link']) ? '' : apply_filters('widget_s2link', $instance['s2link']);
		$s3 = empty($instance['s3']) ? '' : apply_filters('widget_s3', $instance['s3']);
		$s3link = empty($instance['s3link']) ? '' : apply_filters('widget_s3link', $instance['s3link']);
		$s4 = empty($instance['s4']) ? '' : apply_filters('widget_s4', $instance['s4']);
		$s4link = empty($instance['s4link']) ? '' : apply_filters('widget_s4link', $instance['s4link']);
		$s5 = empty($instance['s5']) ? '' : apply_filters('widget_s5', $instance['s5']);
		$s5link = empty($instance['s5link']) ? '' : apply_filters('widget_s5link', $instance['s5link']);
		$s6 = empty($instance['s6']) ? '' : apply_filters('widget_s6', $instance['s6']);
		$s6link = empty($instance['s6link']) ? '' : apply_filters('widget_s6link', $instance['s6link']);
		$s7 = empty($instance['s7']) ? '' : apply_filters('widget_s7', $instance['s7']);
		$s7link = empty($instance['s7link']) ? '' : apply_filters('widget_s7link', $instance['s7link']);
		$s8 = empty($instance['s8']) ? '' : apply_filters('widget_s8', $instance['s8']);
		$s8link = empty($instance['s8link']) ? '' : apply_filters('widget_s8link', $instance['s8link']);
		$s9 = empty($instance['s9']) ? '' : apply_filters('widget_s9', $instance['s9']);
		$s9link = empty($instance['s9link']) ? '' : apply_filters('widget_s9link', $instance['s9link']);
		$s10 = empty($instance['s10']) ? '' : apply_filters('widget_s10', $instance['s10']);
		$s10link = empty($instance['s10link']) ? '' : apply_filters('widget_s10link', $instance['s10link']);
		
		$width = empty($instance['width']) ? '275' : apply_filters('widget_width', $instance['width']);
		$height = empty($instance['height']) ? '235' : apply_filters('widget_height', $instance['height']);
		
		$effect = empty($instance['effect']) ? 'random' : apply_filters('widget_effect', $instance['effect']);
		$new_win = empty($instance['new_win']) ? '' : apply_filters('new_win', $instance['new_win']);
		$rand = empty($instance['rand']) ? '' : apply_filters('rand', $instance['rand']);
		$slices = empty($instance['slices']) ? '15' : apply_filters('widget_slices', $instance['slices']);
		$animSpeed = empty($instance['animSpeed']) ? '700' : apply_filters('widget_animSpeed', $instance['animSpeed']);
		$pauseTime = empty($instance['pauseTime']) ? '3000' : apply_filters('widget_pauseTime', $instance['pauseTime']);
		$startSlide = empty($instance['startSlide']) ? '' : apply_filters('widget_startSlide', $instance['startSlide']);
		$directionNavHide = empty($instance['directionNavHide']) ? '' : apply_filters('widget_directionNavHide', $instance['directionNavHide']);
		$slider_img = empty($instance['slider_img']) ? 'Yes' : apply_filters('widget_slider_img', $instance['slider_img']);
		
		$img_arr = array();
		
		$img_arr[] = array('url'=>$s1,'link'=>$s1link);
		$img_arr[] = array('url'=>$s2,'link'=>$s2link);
		$img_arr[] = array('url'=>$s3,'link'=>$s3link);
		$img_arr[] = array('url'=>$s4,'link'=>$s4link);
		$img_arr[] = array('url'=>$s5,'link'=>$s5link);
		$img_arr[] = array('url'=>$s6,'link'=>$s6link);
		$img_arr[] = array('url'=>$s7,'link'=>$s7link);
		$img_arr[] = array('url'=>$s8,'link'=>$s8link);
		$img_arr[] = array('url'=>$s9,'link'=>$s9link);
		$img_arr[] = array('url'=>$s10,'link'=>$s10link);
		
		//print_r($img_arr);
		
		if($rand){shuffle($img_arr);}
		?>						

<script type="text/javascript" language="javascript">
jQuery(function() {
	jQuery('#slider2').nivoSlider({
		effect:'<?php if (($effect) <> "" ) { echo (($effect)); } else { echo 'random'; } ?>', //Specify sets like: 'random,fold,fade,sliceDown'
		slices:<?php if (($slices) <> "" ) { echo (($slices)); } else { echo '15'; } ?>,
		animSpeed:<?php if (($animSpeed) <> "" ) { echo (($animSpeed)); } else { echo '700'; } ?>,
		pauseTime:<?php if (($pauseTime) <> "" ) { echo (($pauseTime)); } else { echo '3000'; } ?>,
		startSlide:0, //Set starting Slide (0 index)
		directionNav:true, //Next and Prev
		directionNavHide:true, //Only show on hover
		controlNav:true, //1,2,3...
		controlNavThumbs:false, //Use thumbnails for Control Nav
     	controlNavThumbsFromRel:false, //Use image rel for thumbs
		controlNavThumbsSearch: '.jpg', //Replace this with...
		controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
		keyboardNav:true, //Use left and right arrows
		pauseOnHover:true, //Stop animation while hovering
		manualAdvance:false, //Force manual transitions
		captionOpacity:0.8, //Universal caption opacity
		beforeChange: function(){},
		afterChange: function(){},
		slideshowEnd: function(){} //Triggers after all slides have been shown
	});
});
</script>

				<div class="we_recommend">
                
		 			<h3> <?php echo $title; ?> </h3>
                    
 
                    <div class="we_recommend_in" style="max-width:<?php echo $width; ?>" >
           
             	<div  id="slider2" >
             	
                <?php foreach( $img_arr as $img ) { if($img['url']){?>	 
         			<a class="nivo-imageLink" href="<?php echo $img['link']; ?>"   <?php if($new_win){echo 'target="_blank"';}?>><img src="<?php echo $img['url']; ?>"  alt="" /></a>
         		<?php }} ?>
                               	
                </div>
                
                </div> 
            
            	</div> 
            
      
            
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['s1'] = ($new_instance['s1']);
		$instance['s1link'] = ($new_instance['s1link']);
		$instance['s2'] = ($new_instance['s2']);
		$instance['s2link'] = ($new_instance['s2link']);
		$instance['s3'] = ($new_instance['s3']);
		$instance['s3link'] = ($new_instance['s3link']);
		$instance['s4'] = ($new_instance['s4']);
		$instance['s4link'] = ($new_instance['s4link']);
		$instance['s5'] = ($new_instance['s5']);
		$instance['s5link'] = ($new_instance['s5link']);
		$instance['s6'] = ($new_instance['s6']);
		$instance['s6link'] = ($new_instance['s6link']);
		$instance['s7'] = ($new_instance['s7']);
		$instance['s7link'] = ($new_instance['s7link']);
		$instance['s8'] = ($new_instance['s8']);
		$instance['s8link'] = ($new_instance['s8link']);
		$instance['s9'] = ($new_instance['s9']);
		$instance['s9link'] = ($new_instance['s9link']);
		$instance['s10'] = ($new_instance['s10']);
		$instance['s10link'] = ($new_instance['s10link']);
		
		$instance['effect'] = ($new_instance['effect']);
		$instance['new_win'] = ($new_instance['new_win']);
		$instance['rand'] = ($new_instance['rand']);
		$instance['slices'] = ($new_instance['slices']);
		$instance['animSpeed'] = ($new_instance['animSpeed']);
		$instance['pauseTime'] = ($new_instance['pauseTime']);
		$instance['startSlide'] = ($new_instance['startSlide']);
		$instance['directionNavHide'] = ($new_instance['directionNavHide']);
		$instance['slider_img'] = ($new_instance['slider_img']);
		
		$instance['width'] = ($new_instance['width']);
		$instance['height'] = ($new_instance['height']);
 		return $instance;
		
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'desc' => '','actionbtn' => '','actionlink' => '','s1' => '','s2' => '','s3' => '','s4' => '','s5' => '','s6' => '','s7' => '','s8' => '','s9' => '','s10' => '','s1link' => '','s2link' => '','s3link' => '','s4link' => '','s5link' => '','s6link' => '','s7link' => '','s8link' => '','s9link' => '','s10link' => '', 'effect' => '','slices' => '','new_win' => '','rand' => '','animSpeed' => '','pauseTime' => '','startSlide' => '','directionNavHide' => '', 'slider_img' => '', 'width' => '', 'height' => '' ) );		
		$title = strip_tags($instance['title']);
 		$s1 = ($instance['s1']);
		$s1link = ($instance['s1link']);
		$s2 = ($instance['s2']);
		$s2link = ($instance['s2link']);
		$s3 = ($instance['s3']);
		$s3link = ($instance['s3link']);
		$s4 = ($instance['s4']);
		$s4link = ($instance['s4link']);
		$s5 = ($instance['s5']);
		$s5link = ($instance['s5link']);
		$s6 = ($instance['s6']);
		$s6link = ($instance['s6link']);
		$s7 = ($instance['s7']);
		$s7link = ($instance['s7link']);
		$s8 = ($instance['s8']);
		$s8link = ($instance['s8link']);
		$s9 = ($instance['s9']);
		$s9link = ($instance['s9link']);
		$s10 = ($instance['s10']);
		$s10link = ($instance['s10link']);
		
		$width = ($instance['width']);
		$height = ($instance['height']);
		
		$effect = ($instance['effect']);
		$new_win = ($instance['new_win']);
		$rand = ($instance['rand']);
		$slices = ($instance['slices']);
		$animSpeed = ($instance['animSpeed']);
		$pauseTime = ($instance['pauseTime']);
		$startSlide = ($instance['startSlide']);
		$directionNavHide = ($instance['directionNavHide']);
		$slider_img = ($instance['slider_img']);
		 ?>
         
<p><label for="<?php echo $this->get_field_id('new_win'); ?>"><?php _e('Open links in new window:');?><input type="checkbox" id="<?php echo $this->get_field_id('new_win'); ?>" name="<?php echo $this->get_field_name('new_win'); ?>" <?php if(attribute_escape($new_win)){ echo'checked="checked"';} ?> value="1"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('rand'); ?>"><?php _e('Start on random image:');?><input type="checkbox" id="<?php echo $this->get_field_id('rand'); ?>" name="<?php echo $this->get_field_name('rand'); ?>" <?php if(attribute_escape($rand)){ echo'checked="checked"';} ?> value="1"></label>
</p>         
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p><label for="<?php echo $this->get_field_id('slices'); ?>"><?php _e('Banner Images slices (slider images slice effect)(ex: 15):');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('slices'); ?>" name="<?php echo $this->get_field_name('slices'); ?>" value="<?php echo attribute_escape($slices); ?>"></label>
</p> 

<p><label for="<?php echo $this->get_field_id('animSpeed'); ?>"><?php _e('Banner Slider image in time(ex: 700) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('animSpeed'); ?>" name="<?php echo $this->get_field_name('animSpeed'); ?>" value="<?php echo attribute_escape($animSpeed); ?>"></label>
</p>

<p><label for="<?php echo $this->get_field_id('pauseTime'); ?>"><?php _e('Banner Slider image out time (ex: 3000):');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('pauseTime'); ?>" name="<?php echo $this->get_field_name('pauseTime'); ?>" value="<?php echo attribute_escape($pauseTime); ?>"></label>
</p>

<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Banner image width (maximum 295px) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo attribute_escape($width); ?>"></label>
</p>

<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Banner image height (minimum 100px) :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo attribute_escape($height); ?>"></label>
</p>

<p>
  <label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Banner Effect:');?>
  <select id="<?php echo $this->get_field_id('effect'); ?>" name="<?php echo $this->get_field_name('effect'); ?>" style="width:50%;">
  <option <?php if(attribute_escape($effect)=='random'){ echo 'selected="selected"';}?>>random</option>
  <option <?php if(attribute_escape($effect)=='fold'){ echo 'selected="selected"';}?>>fold</option>
  <option <?php if(attribute_escape($effect)=='fade'){ echo 'selected="selected"';}?>>fade</option>
  <option <?php if(attribute_escape($effect)=='sliceDown'){ echo 'selected="selected"';}?>>sliceDown</option>
  </select>
  </label>
</p>
 
<p><label for="<?php echo $this->get_field_id('s1'); ?>"><?php _e('Banner Slider Image 1 full URL (size : w295xh235 pixel) (ex.http://geotheme.com/images/banner1.png)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1'); ?>" name="<?php echo $this->get_field_name('s1'); ?>" value="<?php echo attribute_escape($s1); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s1link'); ?>"><?php _e('Banner Slider Image 1 Link (ex.http://geotheme.com)  :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1link'); ?>" name="<?php echo $this->get_field_name('s1link'); ?>" value="<?php echo attribute_escape($s1link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s2'); ?>"><?php _e('Banner Slider Image 2 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2'); ?>" name="<?php echo $this->get_field_name('s2'); ?>" value="<?php echo attribute_escape($s2); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s2link'); ?>"><?php _e('Banner Slider Image 2 Link :');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2link'); ?>" name="<?php echo $this->get_field_name('s2link'); ?>" value="<?php echo attribute_escape($s2link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s3'); ?>"><?php _e('Banner Slider Image 3 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3'); ?>" name="<?php echo $this->get_field_name('s3'); ?>" value="<?php echo attribute_escape($s3); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s3link'); ?>"><?php _e('Banner Slider Image 3 Link :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3link'); ?>" name="<?php echo $this->get_field_name('s3link'); ?>" value="<?php echo attribute_escape($s3link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s4'); ?>"><?php _e('Banner Slider Image 4 full URL :');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4'); ?>" name="<?php echo $this->get_field_name('s4'); ?>" value="<?php echo attribute_escape($s4); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s4link'); ?>"><?php _e('Banner Slider Image 4 Link');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4link'); ?>" name="<?php echo $this->get_field_name('s4link'); ?>" value="<?php echo attribute_escape($s4link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s5'); ?>"><?php _e('Banner Slider Image 5 full URL');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5'); ?>" name="<?php echo $this->get_field_name('s5'); ?>" value="<?php echo attribute_escape($s5); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s5link'); ?>"><?php _e('Banner Slider Image 5 Link');?>
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5link'); ?>" name="<?php echo $this->get_field_name('s5link'); ?>" value="<?php echo attribute_escape($s5link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s6'); ?>"><?php _e('Banner Slider Image 6 full URL');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6'); ?>" name="<?php echo $this->get_field_name('s6'); ?>" value="<?php echo attribute_escape($s6); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s6link'); ?>"><?php _e('Banner Slider Image 6 Link');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6link'); ?>" name="<?php echo $this->get_field_name('s6link'); ?>" value="<?php echo attribute_escape($s6link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s7'); ?>"><?php _e('Banner Slider Image 7 full URL');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7'); ?>" name="<?php echo $this->get_field_name('s7'); ?>" value="<?php echo attribute_escape($s7); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s7link'); ?>"><?php _e('Banner Slider Image 7 Link');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7link'); ?>" name="<?php echo $this->get_field_name('s7link'); ?>" value="<?php echo attribute_escape($s7link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s8'); ?>"><?php _e('Banner Slider Image 8 full URL');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8'); ?>" name="<?php echo $this->get_field_name('s8'); ?>" value="<?php echo attribute_escape($s8); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s8link'); ?>"><?php _e('Banner Slider Image 8 Link');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8link'); ?>" name="<?php echo $this->get_field_name('s8link'); ?>" value="<?php echo attribute_escape($s8link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s9'); ?>"><?php _e('Banner Slider Image 9 full URL');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9'); ?>" name="<?php echo $this->get_field_name('s9'); ?>" value="<?php echo attribute_escape($s9); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s9link'); ?>"><?php _e('Banner Slider Image 9 Link');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9link'); ?>" name="<?php echo $this->get_field_name('s9link'); ?>" value="<?php echo attribute_escape($s9link); ?>"></label>
</p>
<p><label for="<?php echo $this->get_field_id('s10'); ?>"><?php _e('Banner Slider Image 10 full URL');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10'); ?>" name="<?php echo $this->get_field_name('s10'); ?>" value="<?php echo attribute_escape($s10); ?>"></label>
</p> 
<p><label for="<?php echo $this->get_field_id('s10link'); ?>"><?php _e('Banner Slider Image 10 Link');?> 
<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10link'); ?>" name="<?php echo $this->get_field_name('s10link'); ?>" value="<?php echo attribute_escape($s10link); ?>"></label>
</p>
<?php
	}}
register_widget('werecommend');


// =============================== Latest news posts Widget (particular category) ======================================
class latest_place_listing extends WP_Widget {
	function latest_place_listing() {
	//Constructor
		$widget_ops = array('classname' => 'widget place_list_view', 'description' => __('Latest Places List View') );
		$this->WP_Widget('latest_place_listing', __('PT &rarr; Latest Places List View'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '#' : apply_filters('widget_post_link', $instance['post_link']);
		$character_cout = empty($instance['character_cout']) ? '15' : apply_filters('widget_character_cout', $instance['character_cout']);
		$sort = empty($instance['sort']) ? '' : apply_filters('widget_sort', $instance['sort']);

					global $post,$wpdb,$rating_table_name;
					$thumb_url1 = $thumb_url.get_image_cutting_edge($args);
					$img_zc = get_img_zc(get_option('ptthemes_image_zc'));

					$order_by = "order by p.post_date desc,p.post_title asc";
					if($sort){
						if($sort=='rand'){$order_by = "order by RAND()";}	
						if($sort=='az'){$order_by = "order by p.post_title asc,p.post_date desc";}	
						if($sort=='rating'){$order_by = "order by (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc, p.comment_count desc";}	
						if($sort=='reviews'){$order_by = "order by p.comment_count desc,(select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc";}	
						}
						
					$new_days = get_option('ptthemes_new_days');
				   $post_type = "place";
				   if($category)
				   {
				   	$subsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) )";
				   }
					if($_SESSION['multi_city'])
					{
						$multi_city_id =  get_multi_city_id();
						$meta_key = get_multi_city_meta();
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='".$post_type."' and p.post_status='publish' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $subsql $order_by  limit $post_number";
					}else
					{
						$sql = "select p.* from $wpdb->posts p where p.post_type='".$post_type."' and p.post_status='publish' $subsql $order_by limit $post_number ";
					}
					$latest_menus = $wpdb->get_results($sql);
					if($latest_menus)
					{
					?>
					<h3 class="titulo-estabelecimento-melhor-avaliado"> <?php echo $title; ?> </h3>
          			<ul class="category_list_view">
					<?php
                    foreach($latest_menus as $post) {
					if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					 $post = get_post(icl_object_id($post->ID, $post->post_type, false)); 
					 setup_postdata(icl_object_id($post->ID, $post->post_type, false));}
				   else{setup_postdata($post);} 
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'medium');?>
           		<li class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
" >
				<div style="display: table;float: left;height: auto;width: 183px;">
                 <?php if(round(abs(strtotime($post->post_date)-strtotime(date('Y-m-d')))/86400)<$new_days) {?> <span class="<?php echo 'new';?>">new</span> <?php }?> 
                <?php if(get_post_meta($post->ID,'is_featured',true)) {?>  <a class="featured_link" href="<?php the_permalink(); ?>"><span class="<?php echo 'featured_img';?>">featured</span></a> <?php }?>
            	<?php 
            if(get_the_post_thumbnail( $post->ID, array())){?>
              <a class="post_img" href="<?php the_permalink(); ?>">
             <?php $post_thumb =  get_the_post_thumbnail_src(get_the_post_thumbnail( $post->ID,'medium'));?>
             <img src="<?php echo $post_thumb;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;             
                
            ?>
             <a class="post_img" href="<?php the_permalink(); ?>">
             <img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
            <?php
            } else { ?> 
<a class="post_img" href="<?php the_permalink(); ?>">
             <img src="<?php echo get_post_default_img($post->ID,$post->post_type);?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
                         <?php }?>
                     <span class="rating rating-estabelecimento-melhor-avaliado"><center><?php echo get_post_rating_star($post->ID);?></center></span>
                     </div>
                     <div style="display: table;float: right;width: 375px;height: 172px;">
            		 <h3 style="float: none;display: table;width: inherit;"> 
                         <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>       
                          <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0', '1', '%'); ?> </a> 
                     </h3> 
                     <?php
                     if(get_post_meta($post->ID,'address',true))
					{
						$from_add = get_post_meta($post->ID,'address',true);
					}else
					{
						$from_add = get_post_meta($post->ID,'geo_address',true);
					}
					if($from_add){
						$rua = explode('-', $from_add);
						$complementos = "";
						for($i=1; $i < count($rua);$i++){
							if($i == (count($rua)-1))
							$complementos.= $rua[$i];
							else
							$complementos.= $rua[$i] . " - ";
						}
					 ?>
                     <p class="address" style="float: none;display: table;width: inherit;">
					 	<?php echo $rua[0];?>
                        <br/>
                        <?php echo $complementos;?>
                     </p>
                     <?php }?>
                    <p class="text-melhores-avaliados" style="float: none;width: inherit;display: table;">
                    <?php
					 	echo excerpt($character_cout); 
					?>
                     </p>
                     <script>
                     $(function(){
						$(".text-melhores-avaliados").each(function() {
							var $this = $(this);
							$this.html($this.html().replace(/&nbsp;/g, ' '));
						});
					 })
                     </script>
                    <span class="readmore" style="float: none;display: table;width: inherit !important;"><a href="<?php the_permalink(); ?>" > <?php _e('read more');?> >></a> </span>
                    </div>
            	 </li>
				<?php } ?>
                </ul>
                <?php }?>
	    
		<?php echo $after_widget;
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['character_cout'] = strip_tags($new_instance['character_cout']);
		$instance['sort'] = strip_tags($new_instance['sort']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '','sort' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$character_cout = strip_tags($instance['character_cout']);
		$sort = strip_tags($instance['sort']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>IDs</code> separated by commas):');?>
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts:');?>
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('character_cout'); ?>"><?php _e('Post Content expert character count :');?> 
  <input class="widefat" id="<?php echo $this->get_field_id('character_cout'); ?>" name="<?php echo $this->get_field_name('character_cout'); ?>" type="text" value="<?php echo attribute_escape($character_cout); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('sort'); ?>"><?php _e('Sort Order');?>
 <select id="<?php echo $this->get_field_id('sort'); ?>" name="<?php echo $this->get_field_name('sort'); ?>">
  <option value="" <?php if(attribute_escape($sort)==''){ echo 'selected="selected"';} ?>><?php _e('Default(newest)');?></option>
  <option value="rand" <?php if(attribute_escape($sort)=='rand'){ echo 'selected="selected"';} ?>><?php _e('Random');?></option>
  <option value="az" <?php if(attribute_escape($sort)=='az'){ echo 'selected="selected"';} ?>><?php _e('Alphabetical');?></option>
  <option value="rating" <?php if(attribute_escape($sort)=='rating'){ echo 'selected="selected"';} ?>><?php _e('Rating');?></option>
  <option value="reviews" <?php if(attribute_escape($sort)=='reviews'){ echo 'selected="selected"';} ?>><?php _e('Reviews');?></option>
  </select>
  </label>
</p>
<?php
	}
}
register_widget('latest_place_listing');


// =============================== neighborhood posts Widget (particular category) ======================================
class neighborhood extends WP_Widget {
	function neighborhood() {
	//Constructor
		$widget_ops = array('classname' => 'widget In the neighborhood', 'description' => __('In the neighborhood Post List ') );
		$this->WP_Widget('neighborhood', __('PT &rarr; In the neighborhood'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		//$closer_factor = empty($instance['closer_factor']) ? '2' : apply_filters('widget_closer_factor', $instance['closer_factor']);
		$closer_factor = $instance['closer_factor']; if($closer_factor==''){$closer_factor=2;}
		global $wpdb,$post,$thumb_url;
		$img_zc = get_img_zc(get_option('ptthemes_image_zc'));
		$current_post = $post->ID;
		$post_city = get_post_meta($post->ID,'post_city_id',true);
		if($category)
		{
			global $wpdb;
			
		   $post_type = "'place','event'";
		   if($category)
		   {
		   	$subsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) )";
		   }
			if($post_city)
			{
				$multi_city_id = mysql_real_escape_string ($post_city);
				$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.ID!=$current_post and p.post_type in (".$post_type.") and (pm.meta_key='post_city_id' and (pm.meta_value=\"$multi_city_id\")) and p.post_status='publish' $subsql order by p.post_date desc";
				
			}else
			{
				$sql = "select p.* from $wpdb->posts p where  p.ID!=$current_post and p.post_type in (".$post_type.") and p.post_status='publish' $subsql order by p.post_date desc";
			}
			$latest_menus = $wpdb->get_results($sql);
		}else
		{ 
			$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
			if($geo_latitude)
			{
				$geo_latitude_arr = explode('.',$geo_latitude);
				if($geo_latitude_arr[1])
				{
					$geo_latitude = $geo_latitude_arr[0].'.'.substr($geo_latitude_arr[1],0,$closer_factor);
				}else
				{
					$geo_latitude = $geo_latitude_arr[0];	
				}
			}
			$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
			if($geo_longitude)
			{
				$geo_latitude_arr = explode('.',$geo_longitude);
				if($geo_latitude_arr[1])
				{
					$geo_longitude = $geo_latitude_arr[0].'.'.substr($geo_latitude_arr[1],0,$closer_factor);
				}else
				{
					$geo_longitude = $geo_latitude_arr[0];	
				}
			}
			if($_SESSION['multi_city'])
			{	if($geo_latitude && $geo_longitude){
				$multi_city_id = mysql_real_escape_string ( get_post_meta($post->ID,'post_city_id',true));
					$post_lat = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_latitude\" and (meta_value like\"$geo_latitude%\") and post_id!=\"$current_post\" and post_id in (select post_id from $wpdb->postmeta where meta_key='post_city_id' and ($wpdb->postmeta.meta_value=\"$multi_city_id\"))");				
				$post_lng = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_longitude\" and (meta_value like\"$geo_longitude%\") and post_id!=\"$current_post\" and post_id in (select post_id from $wpdb->postmeta where meta_key='post_city_id' and (meta_value=\"$multi_city_id\"))");
			}
			}else
			{
				if($geo_latitude && $geo_longitude){
				$post_lat = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_latitude\" and (meta_value like\"$geo_latitude%\") and post_id!=\"$current_post\"");
				$post_lng = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_longitude\" and (meta_value like\"$geo_longitude%\") and post_id!=\"$current_post\"");
				}
			}
			
			if($post_lat && $post_lng)
			{
				$post_id_arr = array();
				if($post_lat && $post_lng)
				{
					$post_id_arr = array_intersect($post_lat,$post_lng);
				}
				$post_id_arr = array_slice($post_id_arr,0,$post_number);
				$post_ids = implode(',',$post_id_arr);
			}
			if($post_ids)
			{
				if($post_ids){$post_ids_include = "&include=$post_ids";}
				$current_post = $post->ID;
				$args = array(
				   'include' => $post_ids,
				   'numberposts' => $post_number,
				   'orderby' => 'rand',
				   'post_type' => 'place',
				   'post_status' => 'publish'
				);
				$latest_menus = get_posts( $args );
			}
		}
		$pcount=0;
		if($latest_menus)
		{
		 ?>
          <h3> <?php echo $title; ?> </h3>
          <ul class="recent_comments">                
				<?php $p_arr = array();
					foreach($latest_menus as $post) {
						
					if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					$post = get_post(icl_object_id($post->ID, $post->post_type, false)); 	
					
					if(in_array($post->ID, $p_arr)){continue;}
					if($current_post== $post->ID){continue;}
					
					$p_arr[] = 	$post->ID;
					}
					
					$pcount++;
                   $comment_info = get_comment_count($post->ID);
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'thumb');?>
           		<li class="clearfix">
            	 <?php if($post_images[0]){ global $thumb_url;?>
                   <a  href="<?php echo get_permalink($post->ID); ?>"><img src="<?php echo $post_images[0];?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" class="thumb" /> </a>
            <?php } else { ?> 
						 <a  href="<?php echo get_permalink($post->ID); ?>"><img src="<?php echo get_post_default_img($post->ID,$post->post_type);?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" class="thumb" /> </a>
				<?php }?>          
            
                <p>  <a href="<?php echo get_permalink($post->ID); ?>" class="title"><?php echo get_the_title($post->ID); ?></a>  
                
                <a href="<?php get_permalink($post->ID); ?>#comments" class="review" ><?php echo $comment_info['approved']; ?> </a>  
                </p>                 
                  
                    <span class="rating"> <?php echo get_post_rating_star($post->ID);?><?php ?> </span>
              <?php 
			  $text = $post->post_content;
			$text = strip_tags($text);
			$text = substr($text, 0, 100);
			$text = substr($text, 0, strrpos($text, " "));
			$excepts = $text;
			  if($excepts)
			  {
				  $excerts_arr = explode(' ',$excepts,30);
					$excepts = implode(' ',array_slice($excerts_arr,0,count($excerts_arr)-1));  
			  }
			  if($excepts){?><p> <?php echo $excepts; ?> </p> <?php }?>
         	 </li>
             <?php
             
			if($pcount==$post_number)
			{
				break;	
			}
			
			 ?>
<?php } ?>
<?php
	    echo '</ul>';
		
		}
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['closer_factor'] = strip_tags($new_instance['closer_factor']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '', 'closer_factor'=>'2' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$closer_factor = strip_tags($instance['closer_factor']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category (<code>IDs</code> separated by commas):');?>
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts:');?>
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('closer_factor'); ?>"><?php _e('Show Listings From<br>(leave category blank if using distance):');?>
 <select id="<?php echo $this->get_field_id('closer_factor'); ?>" name="<?php echo $this->get_field_name('closer_factor'); ?>">
  <option value="0" <?php if(attribute_escape($closer_factor)=='0'){ echo 'selected="selected"';} ?>><?php _e('So Far Away');?></option>
  <option value="1" <?php if(attribute_escape($closer_factor)=='1'){ echo 'selected="selected"';} ?>><?php _e('Far Away');?></option>
  <option value="2" <?php if(attribute_escape($closer_factor)=='2'){ echo 'selected="selected"';} ?>><?php _e('At Some Distant');?></option>
  <option value="3" <?php if(attribute_escape($closer_factor)=='3'){ echo 'selected="selected"';} ?>><?php _e('Nearer');?></option>
  <option value="4" <?php if(attribute_escape($closer_factor)=='4'){ echo 'selected="selected"';} ?>><?php _e('Very Near');?></option>
  </select>
  </label>
</p> 
<?php
	}

}

register_widget('neighborhood');


// =============================== Latest news posts Widget (particular category) ======================================

class eventwidget extends WP_Widget {
	function eventwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest News', 'description' => __('List of latest posts in particular category ( Sidebar or Footer content )') );
		$this->WP_Widget('eventwidget', __('PT &rarr; Latest News'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$show_images = empty($instance['show_images']) ? '' : apply_filters('widget_show_images', $instance['show_images']);
		 ?>
          	<?php 
			        global $post,$wpdb;
					$thumb_url1 = $thumb_url.get_image_cutting_edge($args);
					$img_zc = get_img_zc(get_option('ptthemes_image_zc'));
				   $post_type = 'post';
				   if($category)
				   {
				   	$subsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) )";
				   }
					if($_SESSION['multi_city'])
					{
						$multi_city_id =  get_multi_city_id();
						$meta_key = get_multi_city_meta();
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='".$post_type."' and p.post_status='publish' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id)) OR pm.meta_key=\"post_city_id\" and (pm.meta_value=0) ) $subsql  order by p.post_date desc limit $post_number";
					}else
					{
						$sql = "select p.* from $wpdb->posts p where p.post_type='".$post_type."' and p.post_status='publish' $subsql order by p.post_date desc limit $post_number";
					}
					$latest_menus = $wpdb->get_results($sql);
					if($latest_menus)
					{
					?>
                    <h3> <?php echo $title; ?> </h3>
			         <ul> 
                    <?php
                    foreach($latest_menus as $post) {
						if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					 $post = get_post(icl_object_id($post->ID, $post->post_type, false)); 
					 setup_postdata(icl_object_id($post->ID, $post->post_type, false));}
				   else{setup_postdata($post);} 
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'thumb');?>
                
           		<li class="clearfix" <?php if($show_images){echo 'style="background:none;padding:0px 0 9px 0px"';} ?>> 
                <?php  if($show_images){echo '<hr />';} ?>
                <?php
				if($show_images){
				if(get_the_post_thumbnail( $post->ID, array())){?>
             <a class="post_img_tiny" href="<?php the_permalink(); ?>">
             <?php echo get_the_post_thumbnail( $post->ID, array(35,35),array('class'	=> "",));?>
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;             
                
            ?>
             <a class="post_img_tiny" href="<?php the_permalink(); ?>">
             <img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
            <?php
            } else { ?> 
<a class="post_img_tiny" href="<?php the_permalink(); ?>">
             <img src="<?php echo get_post_default_img($post->ID,$post->post_type); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
                         <?php }} ?> 
                         
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  <br />
                   <span class="date"><?php the_time('j F Y') ?> <?php _e('at');?> <?php the_time('H:i A') ?>  </span> 
               </li>
    
			<?php } ?>
            </ul>
			<?php }?>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['show_images'] = strip_tags($new_instance['show_images']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '', 'show_images' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$show_images = strip_tags($instance['show_images']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>IDs</code> separated by commas):');?>
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts:');?>
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_images'); ?>" name="<?php echo $this->get_field_name('show_images'); ?>"<?php 
if($show_images){echo 'checked="checked"';} ?>  />
		<label for="<?php echo $this->get_field_id('show_images'); ?>"><?php _e( 'Display post images' ); ?></label>
</p>

<?php
	}

}
register_widget('eventwidget');


// =============================== Category wise Widget (particular category) ======================================

class categorylist extends WP_Widget {
	function categorylist() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest posts wise News', 'description' => __('List of Latest Places Grid view in particular category - ( Front content )') );
		$this->WP_Widget('categorylist', __('PT &rarr; Latest Places Grid View'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '3' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$more_link = empty($instance['more_link']) ? '' : apply_filters('widget_more_link', $instance['more_link']);
		$character_cout = empty($instance['character_cout']) ? '15' : apply_filters('widget_character_cout', $instance['character_cout']);
		$sort = empty($instance['sort']) ? '' : apply_filters('widget_sort', $instance['sort']);
	 ?>
         <?php 
			        global $post,$wpdb,$rating_table_name;
					$thumb_url1 = $thumb_url.get_image_cutting_edge($args);
					$img_zc = get_img_zc(get_option('ptthemes_image_zc'));
					$order_by = "order by p.post_date desc,p.post_title asc";
					if($sort){
						if($sort=='rand'){$order_by = "order by RAND()";}	
						if($sort=='az'){$order_by = "order by p.post_title asc,p.post_date desc";}	
						if($sort=='rating'){$order_by = "order by (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc, p.comment_count desc";}	
						if($sort=='reviews'){$order_by = "order by p.comment_count desc,(select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc";}	
						}
					
					$new_days = get_option('ptthemes_new_days');
				   $post_type = 'place';
				   if($category)
				   {
				  	 $subsql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) ) ";
				   }
					if($_SESSION['multi_city'])
					{
						$multi_city_id =  get_multi_city_id();
						$meta_key = get_multi_city_meta();
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='".$post_type."' and p.post_status='publish' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $subsql $order_by  limit $post_number";
					}else
					{
						$sql = "select p.* from $wpdb->posts p where p.post_type='".$post_type."' and p.post_status='publish' $subsql $order_by limit $post_number ";
					}
					
					$latest_menus = $wpdb->get_results($sql);
					if($latest_menus)
					{
					?>
                     <h3 class="clearfix"><span class="fl"><a href="<?php echo $more_link; ?>"><?php echo $title; ?></a></span>
           	<?php if ( $more_link <> "" ) { ?>	 
                   <span class="more"><a href="<?php echo $more_link; ?>"> <?php _e('View All');?></a> </span> 
          		<?php } ?>
                    </h3>
          <ul class="category_grid_view clearfix">
                   
                   <?php $pcount=0;
					foreach($latest_menus as $post) {
                   if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					 $post = get_post(icl_object_id($post->ID, $post->post_type, false)); 
					 setup_postdata(icl_object_id($post->ID, $post->post_type, false));}
				   else{setup_postdata($post);}  
				   
                    
					$pcount++;
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'medium');?>
           
           		<li class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
">
                <?php if(round(abs(strtotime($post->post_date)-strtotime(date('Y-m-d')))/86400)<$new_days) {?> <span class="<?php echo 'new';?>">new</span> <?php }?> 
                  <?php if(get_post_meta($post->ID,'is_featured',true)) {?> <a class="featured_link" href="<?php the_permalink(); ?>"><span class="<?php echo 'featured_img';?>">featured</span></a> <?php }?>
               	
               	<?php 
if(get_the_post_thumbnail( $post->ID, 'medium')){?>
<a class="post_img" href="<?php the_permalink(); ?>">
<?php $post_thumb =  get_the_post_thumbnail_src(get_the_post_thumbnail( $post->ID,'medium'));?>
<img src="<?php echo $post_thumb;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
</a><?php
}else if($post_images[0]){ global $thumb_url;
	
?>
 <a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
<?php
} else {?>
 <a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo get_post_default_img($post->ID,$post->post_type);?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a><?php }?> 
     
     				 <span class="rating"> <?php echo get_post_rating_star($post->ID);?><?php /*?><img src="<?php bloginfo('template_directory'); ?>/images/rating.png" alt=""  /><?php */?> </span>
            
            		<div class="widget_main_title estabelecimento-destaque"><h3> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php $post_title = the_title('','',false); echo (strlen($post_title) > 44) ? substr($post_title,0,43).'...' : $post_title; ?></a></h3></div> 
                    
                    <!-- <p><?php //echo excerpt($character_cout); ?> </p> -->
                
                 <p class="review clearfix">    
                 <a href="<?php the_permalink(); ?>#comments" class="pcomments"><?php comments_number('0 Avaliação', '1 Avaliação', '% Avaliações'); ?></a>  
                 <?php /*?><span class="readmore"> <a href="<?php the_permalink(); ?>"><?php _e('read more');?> </a> </span><?php */?>
                 </p>
                     
            	 </li>
                 
                 <?php if($pcount!=0 && ($pcount%5)==0){?>
                 <li class="hr"></li>
                 <?php }?>
    
           
<?php } ?>
</ul>
 <?php }?>
<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['more_link'] = strip_tags($new_instance['more_link']);
		$instance['character_cout'] = strip_tags($new_instance['character_cout']);
		$instance['sort'] = strip_tags($new_instance['sort']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '','more_link' => '','sort' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$more_link = strip_tags($instance['more_link']);
		$character_cout = strip_tags($instance['character_cout']);
		$sort = strip_tags($instance['sort']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>IDs</code> separated by commas):');?>
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts:');?>
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('character_cout'); ?>"><?php _e('Posts excerpt character count :');?> 
  <input class="widefat" id="<?php echo $this->get_field_id('character_cout'); ?>" name="<?php echo $this->get_field_name('character_cout'); ?>" type="text" value="<?php echo attribute_escape($character_cout); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('more_link'); ?>"><?php _e('Enter View All link full URL :');?> 
  <input class="widefat" id="<?php echo $this->get_field_id('more_link'); ?>" name="<?php echo $this->get_field_name('more_link'); ?>" type="text" value="<?php echo attribute_escape($more_link); ?>" />
  </label>
</p>
  <p>
  <label for="<?php echo $this->get_field_id('sort'); ?>"><?php _e('Sort Order');?>
 <select id="<?php echo $this->get_field_id('sort'); ?>" name="<?php echo $this->get_field_name('sort'); ?>">
  <option value="" <?php if(attribute_escape($sort)==''){ echo 'selected="selected"';} ?>><?php _e('Default(newest)');?></option>
  <option value="rand" <?php if(attribute_escape($sort)=='rand'){ echo 'selected="selected"';} ?>><?php _e('Random');?></option>
  <option value="az" <?php if(attribute_escape($sort)=='az'){ echo 'selected="selected"';} ?>><?php _e('Alphabetical');?></option>
  <option value="rating" <?php if(attribute_escape($sort)=='rating'){ echo 'selected="selected"';} ?>><?php _e('Rating');?></option>
  <option value="reviews" <?php if(attribute_escape($sort)=='reviews'){ echo 'selected="selected"';} ?>><?php _e('Reviews');?></option>
  </select>
  </label>
</p>
<?php
	}

}

register_widget('categorylist');


 // =============================== Videos Widget (particular category) ======================================

class spotlightpost extends WP_Widget {
	function spotlightpost() {
	//Constructor
		$widget_ops = array('classname' => 'widget Featured Video', 'description' => __('List of In Featured Video in particular category') );
		$this->WP_Widget('spotlight_post', __('PT &rarr; Featured Video'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '6' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$video_link = empty($instance['video_link']) ? '' : apply_filters('widget_video_link', $instance['video_link']);
		?>
				<?php 
			        global $post;
			        global $wpdb;
				   $post_type = "'place','event','post'";
				   if($category)
				   {
				   	$subsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) )";
				   }
					if($_SESSION['multi_city'])
					{
						$multi_city_id =  get_multi_city_id();
						$meta_key = get_multi_city_meta();
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type in (".$post_type.") and p.post_status='publish' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $subsql  order by p.post_date desc limit $post_number";
					}else
					{
						$sql = "select p.* from $wpdb->posts p where p.post_type in (".$post_type.") and p.post_status='publish' $subsql order by p.post_date desc limit $post_number";
					}
					$latest_menus = $wpdb->get_results($sql);
					if($latest_menus)
					{
					?>
                    <div class="featured_video">		
                    <h3 class="clearfix"> <span class="fl"><?php echo $title; ?> </span>                 
                      <?php if ( $video_link <> "" ) { ?>	 
                       <span class="more"><a href="<?php echo $video_link; ?>"> <?php _e('View All');?></a> </span> 
                    <?php } ?>                 
                     </h3>
                    
                    <?php
                    foreach($latest_menus as $post) {
					if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					 $post = get_post(icl_object_id($post->ID, $post->post_type, false)); 
					 setup_postdata(icl_object_id($post->ID, $post->post_type, false));}
				   else{setup_postdata($post);} 
 			    ?>
              		 
                <?php if(get_post_meta($post->ID,'video',true)){?>
                     <div class="video">
                    <?php echo get_post_meta($post->ID,'video',true);?>
                    	<h4><a class="widget-title" href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h4>
                    </div>
                    <?php }?>
                 <?php } ?>
                 </div>
                <?php	}?>
				<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['video_link'] = strip_tags($new_instance['video_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','video_link' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$video_link = strip_tags($instance['video_link']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
    <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
    <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('video_link'); ?>">View All link full URL :
    <input class="widefat" id="<?php echo $this->get_field_id('video_link'); ?>" name="<?php echo $this->get_field_name('video_link'); ?>" type="text" value="<?php echo attribute_escape($video_link); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('spotlightpost');








// =============================== Flickr widget ======================================

class flickrWidget extends WP_Widget {
	function flickrWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Flickr Photos ', 'description' => 'Flickr Photos' );
		$this->WP_Widget('widget_flickrwidget', 'PT &rarr; Flickr Photos', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$id = empty($instance['id']) ? '&nbsp;' : apply_filters('widget_id', $instance['id']);
		$number = empty($instance['number']) ? '&nbsp;' : apply_filters('widget_number', $instance['number']);

?>
		
        <h3 ><span><?php _e('Photo Gallery');?></span> </h3>
<div class="flickr clearfix">
			
 		  <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
 		 
</div>
</div>	

<?php
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('title' => '',  'id' => '', 'number' => '') );
		$id = strip_tags($instance['id']);
		$number = strip_tags($instance['number']);
?>

<p>
  <label for="<?php echo $this->get_field_id('id'); ?>">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
    <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('number'); ?>">Number of photos:
    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('flickrWidget');

 
// =============================== Popular Posts Widget ======================================

function PopularPostsSidebar()
{

    $settings_pop = get_option("widget_popularposts");

	$name = $settings_pop['name'];
	$number = $settings_pop['number'];
	$ptype = $settings_pop['post_type'];
	if ($name <> "") { $popname = $name; } else { $popname = 'Popular Posts'; }
	if ($number <> "") { $popnumber = $number; } else { $popnumber = '10'; }
	if ($ptype <> "") { $popptype = $ptype; } else { $popptype = 'post'; }

?>
 
	
 			<?php
			global $wpdb;
            $now = gmdate("Y-m-d H:i:s",time());
            $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
            $popularposts = "SELECT ID, post_title,post_type, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE post_type = \"$popptype\" and comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT $popnumber";
            $posts = $wpdb->get_results($popularposts);
            $popular = '';
            if($posts){
				?>
                <div  class="widget">
	<h3 class="popular_title" ><span><?php echo $popname; ?></span></h3>	
		<ul>
                <?php
				$e_arr = array();
                foreach($posts as $post){
					if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					 $post = get_post(icl_object_id($post->ID, $post->post_type, false)); 
					 setup_postdata(icl_object_id($post->ID, $post->post_type, false));
					 
					 if(in_array($post->ID, $e_arr)){continue;}
					 $e_arr[] = $post->ID;
			
					 }
				   else{setup_postdata($post);} 
				   
			
				   
	                $post_title = stripslashes($post->post_title);
		               $guid = get_permalink($post->ID);
					   
					      $first_post_title=substr($post_title,0,26);
            ?>
             <?php $post_images = bdw_get_images($post->ID,'large');?>
            
		        <li class="clearfix">
                    <a href="<?php echo $guid; ?>" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></a>  
                     </li>
            <?php }?>
			</ul></div>
			<?php } ?>

		

<?php
}
function PopularPostsAdmin() {

	$settings_pop = get_option("widget_popularposts");

	// check if anything's been sent
	if (isset($_POST['update_popular'])) {
		$settings_pop['name'] = strip_tags(stripslashes($_POST['popular_name']));
		$settings_pop['number'] = strip_tags(stripslashes($_POST['popular_number']));
		$settings_pop['post_type'] = strip_tags(stripslashes($_POST['post_type']));

		update_option("widget_popularposts",$settings_pop);
	}

	echo '<p>
			<label for="popular_name">Title:
			<input id="popular_name" name="popular_name" type="text" class="widefat" value="'.$settings_pop['name'].'" /></label></p>';
	echo '<p>
			<label for="popular_number">Number of popular posts:
			<input id="popular_number" name="popular_number" type="text" class="widefat" value="'.$settings_pop['number'].'" /></label></p>';
			
	?>
    <p>
  <label for="post_type"><?php _e('Post Type:');?><br />
 <select id="post_type" name="post_type">
  <option value="post" <?php if($settings_pop['post_type']=='post'){ echo 'selected="selected"';} ?>><?php _e('Blog');?></option>
  <option value="place" <?php if($settings_pop['post_type']=='place'){ echo 'selected="selected"';} ?>><?php _e('Place');?></option>
  <option value="event" <?php if($settings_pop['post_type']=='event'){ echo 'selected="selected"';} ?>><?php _e('Event');?></option>
  </select>
  </label>
</p> 
<?php		
			
			
	echo '<input type="hidden" id="update_popular" name="update_popular" value="1" />';

}

register_sidebar_widget('PT &rarr; Popular Posts', 'PopularPostsSidebar');
register_widget_control('PT &rarr; Popular Posts', 'PopularPostsAdmin', 250, 200);




// =============================== Recent Comments Widget ======================================
class CommentsWidget extends WP_Widget {
	function CommentsWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Recent Review', 'description' => 'Side Bar Comments' );		
		$this->WP_Widget('widget_comment', 'PT &rarr; Recent Review', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$count = empty($instance['count']) ? '5' : apply_filters('widget_count', $instance['count']);
 		 
		 
		 $comments_li = recent_comments(30, $count, 100, false);
		 if($comments_li ){
		 ?>				
		 <div class="widget recent_comments_section">
        
        <h3> <?php echo $title; ?> </h3>
       
       	<ul class="recent_comments">
		   <?php
			echo $comments_li;
		  
		?>
       </ul>
            
            </div> 
            
	<?php }
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
 		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'count' => '' ) );		
		$title = strip_tags($instance['title']);
		$count = strip_tags($instance['count']);
 ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('count'); ?>">Number of Reviews  <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo attribute_escape($count); ?>" /></label></p>
<?php
	}}
register_widget('CommentsWidget');

// =============================== Wide Recent Comments Widget ======================================
class WideCommentsWidget extends WP_Widget {
	function WideCommentsWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Wide Recent Review', 'description' => 'Front Page Comments' );		
		$this->WP_Widget('wide_widget_comment', 'PT &rarr; Wide Recent Review', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$excerpt = empty($instance['excerpt']) ? '220' : apply_filters('widget_excerpt', $instance['excerpt']);
		$count = empty($instance['count']) ? '5' : apply_filters('widget_count', $instance['count']);
		$visable = empty($instance['visable']) ? '2' : apply_filters('widget_visable', $instance['visable']);
		$auto = empty($instance['auto']) ? '1000' : apply_filters('widget_auto', $instance['auto']);
		$speed = empty($instance['speed']) ? '2000' : apply_filters('widget_speed', $instance['speed']);
 		 
		 
		 
		  
		  if(wide_recent_comments(30, $count, $excerpt, false, false)){
		 ?>						
<script type="text/javascript"> 
jQuery(function() {
	jQuery('ul.wide_recent_comments').css('display', 'block') ;
	jQuery(".newsticker-jcarousellite").jCarouselLite({
		vertical: true,
		hoverPause:true,
		//visible: <?php echo $visable; ?>,
		auto:<?php echo $auto; ?>,
		speed:<?php echo $speed; ?>
	});
});
</script>
        <div class="widget recent_comments_section">
        
        <h3 class="comentsJcarousellite"> <?php echo $title; ?> </h3>
           <div class="newsticker-jcarousellite"> 

       	<ul class="wide_recent_comments" style="display:none" >
		   <?php
			if(function_exists('wide_recent_comments')) {
			$reviews = wide_recent_comments(30, $count, $excerpt, false);
		  }		?>
       </ul>
       </div>
            
            </div> 
            
	<?php
	}}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['excerpt'] = strip_tags($new_instance['excerpt']);
		$instance['visable'] = strip_tags($new_instance['visable']);
		$instance['auto'] = strip_tags($new_instance['auto']);
		$instance['speed'] = strip_tags($new_instance['speed']);
 		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'excerpt' => '', 'count' => '', 'visable' => '', 'auto' => '', 'speed' => '' ) );		
		$title = strip_tags($instance['title']);
		$count = strip_tags($instance['count']);
		$excerpt = strip_tags($instance['excerpt']);
		$visable = strip_tags($instance['visable']);
		$auto = strip_tags($instance['auto']);
		$speed = strip_tags($instance['speed']);
 ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('count'); ?>">Number of Reviews  <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo attribute_escape($count); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('excerpt'); ?>">Excerpt length (default 220)  <input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo attribute_escape($excerpt); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('visable'); ?>">Number of Reviews Visable <input class="widefat" id="<?php echo $this->get_field_id('visable'); ?>" name="<?php echo $this->get_field_name('visable'); ?>" type="text" value="<?php echo attribute_escape($visable); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('auto'); ?>">Pause time ms(ie 1000) <input class="widefat" id="<?php echo $this->get_field_id('auto'); ?>" name="<?php echo $this->get_field_name('auto'); ?>" type="text" value="<?php echo attribute_escape($auto); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('speed'); ?>">Transition speed ms (ie 2000) <input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" type="text" value="<?php echo attribute_escape($speed); ?>" /></label></p>
<?php
	}}
register_widget('WideCommentsWidget');



 


// =============================== Twitter widget ======================================
// Plugin Name: Twitter Widget
// Plugin URI: http://seanys.com/2007/10/12/twitter-wordpress-widget/
// Description: Adds a sidebar widget to display Twitter updates (uses the Javascript <a href="http://twitter.com/badges/which_badge">Twitter 'badge'</a>)
// Version: 1.0.3
// Author: Sean Spalding
// Author URI: http://seanys.com/
// License: GPL
class twitter extends WP_Widget {
	function twitter() {
	//Constructor
		$widget_ops = array('classname' => 'Twitter', 'description' => 'Twitter' );
		$this->WP_Widget('widget_Twidget', 'PT &rarr; Twitter', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$account = empty($instance['account']) ? '&nbsp;' : apply_filters('widget_account', $instance['account']);
		$show = empty($instance['show']) ? '&nbsp;' : apply_filters('widget_show', $instance['show']);
		$follow = empty($instance['follow']) ? '&nbsp;' : apply_filters('widget_follow', $instance['follow']);
		if($show){$show = $show+1;}

		 // Output
		echo $before_widget ;

		// start
		echo '<div id="twitter"> <h3><a href="http://www.twitter.com/'.$account.'/" title="'.$follow.'">'.$title.' </a></h3>';              
		echo '<ul id="twitter_update_list"><li></li></ul>
		      <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>';
		echo '<script type="text/javascript" src="https://api.twitter.com/1/statuses/user_timeline.json?screen_name='.$account.'&amp;callback=twitterCallback2&amp;count='.$show.'"></script>';
		echo '</div> </div>';
			
				
		// echo widget closing tag
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['account'] = strip_tags($new_instance['account']);
		$instance['follow'] = strip_tags($new_instance['follow']);
		$instance['show'] = strip_tags($new_instance['show']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('account'=>'GeoTheme', 'title'=>'Twitter Updates', 'show'=>'3' ) );
		$title = strip_tags($instance['title']);
		$show = strip_tags($instance['show']);
		$follow = strip_tags($instance['follow']);
		$account = strip_tags($instance['account']);
?>
<p>
  <label for="<?php echo $this->get_field_id('account'); ?>"><?php  _e('Twitter Account ID')?>:
    <input class="widefat" id="<?php echo $this->get_field_id('account'); ?>" name="<?php echo $this->get_field_name('account'); ?>" type="text" value="<?php echo attribute_escape($account); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Title')?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>

<p>
  <label for="<?php echo $this->get_field_id('show'); ?>"><?php  _e('Show Twitter Posts')?>:
    <input class="widefat" id="<?php echo $this->get_field_id('show'); ?>" name="<?php echo $this->get_field_name('show'); ?>" type="text" value="<?php echo attribute_escape($show); ?>" />
  </label>
</p>

<?php
	}

}

register_widget('twitter');

// =============================== Event Calendar ======================================
class my_event_calender_widget extends WP_Widget {
	function my_event_calender_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Event Listing calender.', 'description' => 'Event Listing calendar' );		
		$this->WP_Widget('event_calendar', 'PT &rarr; Event Listing Calendar', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		global $post;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$day = empty($instance['day']) ? '' : apply_filters('widget_day', $instance['day']);
		//include_once (TEMPLATEPATH . '/library/calendar/calendar.php');
		if($title)
		{
		echo '<h3>'.$title.'</h3>';	
		} ?>
		<script type="text/javascript">
		function cal_go(){	
								var sday = '<?php echo $day; ?>';
							var myurl = "<?php echo get_bloginfo('url').'/?ptype=calendar'; ?>"+"&sday="+sday;								   
					    jQuery.ajax({
					   type: "GET",
					   url: myurl,
					   success: function(msg){						 
						 document.getElementById('cal_loading').style.display="none";
							jQuery("#calendar").html(msg);
					   }
					 });
					  
			var mnth = <?php echo date("n"); ?>;
			var year = <?php echo date("Y"); ?>;
	
				jQuery("#cal_next").click(function(){
						document.getElementById('cal_loading').style.display = 'block';
					 mnth++;
					if(mnth > 12){year++; mnth=1;}											  
						var nexturl = "<?php echo get_bloginfo('url').'/?ptype=calendar'; ?>&mnth="+mnth+"&yr="+year+"&sday="+sday;
					   jQuery.ajax({
					   type: "GET",
					   url: nexturl,
					   success: function(next){
						 document.getElementById('cal_loading').style.display="none";
							jQuery("#calendar").html(next);
					   }
					 });

			});
				
				jQuery("#cal_prev").click(function(){
						document.getElementById('cal_loading').style.display = 'block';
						 mnth--;
					if(mnth < 1){year--; mnth=12;}	
					var prevurl = "<?php echo get_bloginfo('url').'/?ptype=calendar'; ?>&mnth="+mnth+"&yr="+year+"&sday="+sday;
					   jQuery.ajax({
					   type: "GET",
					   url: prevurl,
					   success: function(prev){
						 document.getElementById('cal_loading').style.display="none";
							jQuery("#calendar").html(prev);
					   }
					 });			});
			
		};
		</script>
        <table width="100%">
            	<tr align="center" class="title">
    <td width="10%" class="title"><img id="cal_prev" style="cursor: pointer; cursor: hand" src="<?php bloginfo('template_directory'); ?>/images/previous2.png" alt=""  /></td>
	<td   class="title"><center><img id="cal_loading" style="margin-top:-10px" src="<?php echo get_bloginfo('template_directory').'/images/'; ?>ajax-loader.gif" /></strong></center></td>
    <td width="10%" class="title"><img  id="cal_next" style="cursor: pointer; cursor: hand" src="<?php bloginfo('template_directory'); ?>/images/next2.png" alt=""  /></td>
	</tr>
            </table>
        <div id="calendar"></div>
        
        <?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['day'] = strip_tags($new_instance['day']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','day' => '') );		
		$title = strip_tags($instance['title']);
		$day = strip_tags($instance['day']);
		?>
        
        
        
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Title')?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
    <p>
  <label for="<?php echo $this->get_field_id('day'); ?>"><?php _e('Start day?');?>
 <select id="<?php echo $this->get_field_id('day'); ?>" name="<?php echo $this->get_field_name('day'); ?>">
  <option value="1" <?php if(attribute_escape($day)=='1'){ echo 'selected="selected"';} ?>><?php _e('Monday');?></option>
  <option value="0" <?php if(attribute_escape($day)=='0'){ echo 'selected="selected"';} ?>><?php _e('Sunday');?></option>
  </select>
  </label>
</p> 
        <?php
	}}
register_widget('my_event_calender_widget');

// =============================== Event wise Widget (particular category) ======================================

class eventlist extends WP_Widget {
	function eventlist() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest posts wise Events', 'description' => 'List of latest events in particular category - ( Grid View )' );
		$this->WP_Widget('eventlist', 'PT &rarr; Latest Events Grid View', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '6' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$more_link = empty($instance['more_link']) ? '' : apply_filters('widget_more_link', $instance['more_link']);
		$character_cout = empty($instance['character_cout']) ? '15' : apply_filters('widget_character_cout', $instance['character_cout']);
		?>
         		<?php 
			        global $post,$wpdb;
					$thumb_url1 = $thumb_url.get_image_cutting_edge($args);
					$img_zc = get_img_zc(get_option('ptthemes_image_zc'));
					
					$sqlsql = '';
					if($category)
					{
						$category = "'".str_replace(",","','",$category)."'";
						$sqlsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  )";
					}
					
					if($_SESSION['multi_city'])
					{
						$multi_city_id =  get_multi_city_id();
						$meta_key = get_multi_city_meta();
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='event' and p.post_status='publish' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $sqlsql order by  p.post_date desc,p.post_title asc limit $post_number";
						}
					else{
				   $sql = "select p.* from $wpdb->posts p where p.post_type='event' and p.post_status='publish' $sqlsql order by  p.post_date desc,p.post_title asc limit $post_number";}
				   $latest_menus = $wpdb->get_results($sql);
					if($latest_menus)
					{
					?>
                     <h3 class="clearfix"><span class="fl"><a href="<?php echo $more_link; ?>"><?php echo $title; ?></a></span>
					<?php if ( $more_link <> "" ) { ?>	 
                           <span class="more"><a href="<?php echo $more_link; ?>"> <?php _e('View All');?></a> </span> 
                        <?php } ?>
                        </h3>
                  <ul class="category_grid_view clearfix">
                   <?php
                    $pcount=0;
					foreach($latest_menus as $post) {
					if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					 $post = get_post(icl_object_id($post->ID, $post->post_type, false)); 
					 setup_postdata(icl_object_id($post->ID, $post->post_type, false));}
				   else{setup_postdata($post);} 
					$pcount++;
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'medium');?>
           
           		<li class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
"> 
                 <?php if(get_post_meta($post->ID,'is_featured',true)) {?>  <a class="featured_link" href="<?php the_permalink(); ?>"><span class="<?php echo 'featured_img';?>">featured</span></a> <?php }?>
               	
               	<?php 
if(get_the_post_thumbnail( $post->ID, 'medium')){?>
<a class="post_img" href="<?php the_permalink(); ?>">
<?php $post_thumb =  get_the_post_thumbnail_src(get_the_post_thumbnail( $post->ID,'medium'));?>
<img src="<?php echo $post_thumb;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
</a><?php
}else if($post_images[0]){ global $thumb_url;
	
?>
 <a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); echo ' - '.get_formated_date(get_post_meta($post->ID,'st_date',true)); ?>"  /></a>
<?php
} else {?>
<a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo get_post_default_img($post->ID,$post->post_type);?>" alt="<?php the_title(); ?>" title="<?php the_title(); echo ' - '.get_formated_date(get_post_meta($post->ID,'st_date',true)); ?>"  /></a><?php }?> 
            		<div class="widget_main_title">
            		 <h3> <a href="<?php the_permalink(); ?>" title="<?php the_title(); echo ' - '.get_formated_date(get_post_meta($post->ID,'st_date',true)); ?>"><?php $post_title = the_title('','',false); echo (strlen($post_title) > 44) ? substr($post_title,0,43).'...' : $post_title; ?></a></h3> </div>
                    <span class="rating"> <?php echo get_post_rating_star($post->ID);?></span>
                    
                   <!-- <p><?php //echo excerpt($character_cout); ?> </p> -->
                <p class="event-time"><?php _e('From: ');?><?php echo get_formated_date(get_post_meta($post->ID,'st_date',true)).' '.get_formated_time(get_post_meta($post->ID,'st_time',true));
				echo '<br />'.__('To: ').get_formated_date(get_post_meta($post->ID,'end_date',true)).' '.get_formated_time(get_post_meta($post->ID,'end_time',true));?></p>
                 <p class="review clearfix">    
                 <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0', '1', '%'); ?> </a>  
                 <span class="readmore"> <a href="<?php the_permalink(); ?>"><?php _e('read more');?> </a> </span>
                 </p>
                     
            	 </li>
                 
                 <?php if($pcount!=0 && ($pcount%5)==0){?>
                 <li class="hr"></li>
                 <?php }?>
<?php } ?>
</ul>
<?php	}?>
<?php
	echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['more_link'] = strip_tags($new_instance['more_link']);
		$instance['character_cout'] = strip_tags($new_instance['character_cout']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '','more_link' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$more_link = strip_tags($instance['more_link']);
		$character_cout = strip_tags($instance['character_cout']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('character_cout'); ?>">Posts excerpt character count : 
  <input class="widefat" id="<?php echo $this->get_field_id('character_cout'); ?>" name="<?php echo $this->get_field_name('character_cout'); ?>" type="text" value="<?php echo attribute_escape($character_cout); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('more_link'); ?>">Enter View All link full URL : 
  <input class="widefat" id="<?php echo $this->get_field_id('more_link'); ?>" name="<?php echo $this->get_field_name('more_link'); ?>" type="text" value="<?php echo attribute_escape($more_link); ?>" />
  </label>
</p>

<?php
	}

}

register_widget('eventlist');

// =============================== Latest events posts Widget (particular category) ======================================
class events2columns extends WP_Widget {
	function events2columns() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest Events', 'description' => 'List of latest events in particular category - ( List View ) ' );
		$this->WP_Widget('news2columns', 'PT &rarr; Latest Events List View', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '6' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '#' : apply_filters('widget_post_link', $instance['post_link']);
		$character_cout = empty($instance['character_cout']) ? '15' : apply_filters('widget_character_cout', $instance['character_cout']);
		 ?>
          
				<?php 
			        global $post,$wpdb;
					$thumb_url1 = $thumb_url.get_image_cutting_edge($args);
					$img_zc = get_img_zc(get_option('ptthemes_image_zc'));
					$sqlsql ='';
			      if($category)
				   {
						$category = "'".str_replace(",","','",$category)."'";
						$sqlsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  )";   
				   }
				   
				   if($_SESSION['multi_city'])
					{
						$multi_city_id =  get_multi_city_id();
						$meta_key = get_multi_city_meta();
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='event' and p.post_status='publish' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $sqlsql order by  p.post_date desc,p.post_title asc limit $post_number";
						}
					else{
					$sql = "select p.* from $wpdb->posts p where p.post_type='event' and p.post_status='publish' $sqlsql order by  p.post_date desc,p.post_title asc limit $post_number";}
					
					$latest_menus = $wpdb->get_results($sql);
                    if($latest_menus)
					{
					?>
                    <h3> <?php echo $title; ?> </h3>
         	 <ul class="category_list_view">
                    <?php
					foreach($latest_menus as $post) {
					if(function_exists('icl_object_id') && icl_object_id($post->ID, $post->post_type, false)){
					 $post = get_post(icl_object_id($post->ID, $post->post_type, false)); 
					 setup_postdata(icl_object_id($post->ID, $post->post_type, false));}
				   else{setup_postdata($post);} 
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'medium');?>
           		<li class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
" > 
                <?php if(get_post_meta($post->ID,'is_featured',true)) {?> <a class="featured_link" href="<?php the_permalink(); ?>"> <span class="<?php echo 'featured_img';?>">featured</span></a> <?php }?>
            	<?php 
            if(get_the_post_thumbnail( $post->ID, 'medium')){?>
             <a class="post_img" href="<?php the_permalink(); ?>">
             <?php $post_thumb =  get_the_post_thumbnail_src(get_the_post_thumbnail( $post->ID,'medium'));?>
             <img src="<?php echo $post_thumb;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;             
                
            ?>
             <a class="post_img" href="<?php the_permalink(); ?>">
             <img src="<?php echo $post_images[0];?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
            <?php
            } else { ?> 
<a class="post_img" href="<?php the_permalink(); ?>">
             <img src="<?php echo get_post_default_img($post->ID,$post->post_type);?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>            <?php }?> 
            		 <h3> 
                         <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>       
                          <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0', '1', '%'); ?> </a> 
                     </h3> 
                     <p class="timing"> <span><?php _e('Start Date :');?></span> 
		 <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true)).' '. get_formated_time(get_post_meta($post->ID,'st_time',true));?> 
         <br /> 
         <span><?php _e('End Date :');?></span> <?php echo get_formated_date(get_post_meta($post->ID,'end_date',true)) . ' ' .get_formated_time(get_post_meta($post->ID,'end_time',true));?>
         </p>
                     <?php
                     if(get_post_meta($post->ID,'address',true))
					{
						$from_add = get_post_meta($post->ID,'address',true);
					}else
					{
						$from_add = get_post_meta($post->ID,'geo_address',true);
					}
					if($from_add){
					 ?>
                     <p class="address"><?php echo $from_add;?></p>
                     <?php }?>
                     <span class="rating"><?php echo get_post_rating_star($post->ID);?><?php /*?><img src="<?php bloginfo('template_directory'); ?>/images/rating.png" alt=""  /> <?php */?></span>
                    <p><?php echo excerpt($character_cout); ?> </p>
                    <span class="readmore" ><a href="<?php the_permalink(); ?>" > <?php _e('read more');?>  </a> </span>
            	 </li>
<?php } ?>
</ul>
<?php }?>
<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['character_cout'] = strip_tags($new_instance['character_cout']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$character_cout = strip_tags($instance['character_cout']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('character_cout'); ?>">Post content excerpt character count : 
  <input class="widefat" id="<?php echo $this->get_field_id('character_cout'); ?>" name="<?php echo $this->get_field_name('character_cout'); ?>" type="text" value="<?php echo attribute_escape($character_cout); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('events2columns');



// =============================== Top Rated Widget for sidebar and front page content ======================================

class top_rated_list extends WP_Widget {
	function top_rated_list() {
	//Constructor
		$widget_ops = array('classname' => 'widget Top Rated Listing', 'description' => 'List of Top Rated Listing' );
		$this->WP_Widget('top_rated_list', 'PT &rarr; Top Rated Listing', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$post_number = empty($instance['post_number']) ? '6' : apply_filters('widget_post_number', $instance['post_number']);
		?>
			<?php if($title){?>
            <h3 class="clearfix"><span class="fl"><?php echo $title; ?></span></h3>
            <?php }?>
           <ul class="recent_comments">
            <?php
            global $wpdb,$rating_table_name,$thumb_url;
			$img_zc = get_img_zc(get_option('ptthemes_image_zc'));
			$multi_city_id =  get_multi_city_id();
			$meta_key = get_multi_city_meta();
			if($_SESSION['multi_city']){
             $sql = "select p.ID,p.post_title, (select count(rt.rating_postid) as rating_counter from $rating_table_name as rt where rt.rating_rating>0 AND rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) as ccount from $wpdb->posts as p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status='publish' and p.post_type='place' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) and (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.rating_rating>0 AND rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1))>0 order by (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.rating_rating>0 AND rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=p.ID and cm.comment_approved=1)) desc,ccount desc,p.post_date desc limit $post_number";
			}
			else{
			$sql = " select $wpdb->posts.ID,$wpdb->posts.post_title, (select count(rt.rating_postid) as rating_counter from $rating_table_name as rt where rt.rating_rating>0 AND rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=$wpdb->posts.ID and cm.comment_approved=1)) as ccount from $wpdb->posts where $wpdb->posts.post_status='publish' and $wpdb->posts.post_type='place' and (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.rating_rating>0 AND rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=$wpdb->posts.ID and cm.comment_approved=1))>0 order by (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.rating_rating>0 AND rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=$wpdb->posts.ID and cm.comment_approved=1)) desc,ccount desc,$wpdb->posts.post_date desc limit $post_number";
           }
			
				//echo $sql;
			$e_arr = array();
            $res = $wpdb->get_results($sql);
            foreach($res as $res_obj)
            { 
			
			if(function_exists('icl_object_id') && icl_object_id($res_obj->ID, 'place', false)){
			$res_obj = get_post(icl_object_id($res_obj->ID, 'place', false)); 
			if(in_array($res_obj->ID, $e_arr)){continue;}
			$e_arr[] = 	$res_obj->ID;
			}
			
                $post_title = $res_obj->post_title;
                $post_id = $res_obj->ID;
				$comment_info = $res_obj->ccount;
                ?>
                 <?php $post_images = bdw_get_images($post_id,'thumb');?>
                <li class="clearfix">
                 <?php if($post_images[0]){ global $thumb_url;?>
                   <a  href="<?php echo get_permalink($post_id); ?>"><img src="<?php echo $post_images[0];?>" alt="<?php echo get_the_title($post_id); ?>" title="<?php echo get_the_title($post_id); ?>" class="thumb" /> </a>
            <?php }?>          
       <p>  <a href="<?php echo get_permalink($post_id); ?>" class="title"><?php echo get_the_title($post_id); ?></a>  
        <a href="<?php echo get_permalink($post_id); ?>#comments" class="review" ><?php echo $comment_info; ?> </a>  
        </p>                 
          <span class="rating"> <?php echo get_post_rating_star($post_id);?><?php ?> </span>
          </li>
                    <?php
				}
	?>
    </ul>
    <?php
	echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		return $instance;
	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$post_number = strip_tags($instance['post_number']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('top_rated_list');


/**
 * Tag cloud widget class
 *
 * @since 2.8.0
 */
class Custom_Tag_Cloud extends WP_Widget {

	function Custom_Tag_Cloud() {
		$widget_ops = array( 'description' => __( "Your most used tags in cloud format") );
		$this->WP_Widget('custom_tag_cloud', __('Custom Tag Cloud'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div class="tagcloud">';
		wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy) ) );
		echo "</div>\n";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		return $instance;
	}

	function form( $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:') ?></label>
	<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
	<?php foreach ( get_object_taxonomies(array('post','place','event')) as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
	?>
		<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
	<?php endforeach; ?>
	</select></p><?php
	}

	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}
register_widget('Custom_Tag_Cloud');

/**
 * Categories widget class // mod by stiofan for geotheme
 *
 * @since 2.8.0
 */
class WP_Widget_Custom_Categories extends WP_Widget {

	function WP_Widget_Custom_Categories() {
		$widget_ops = array( 'classname' => 'widget_custom_categories', 'description' => __( "A list or dropdown of categories for Places or events" ) );
		$this->WP_Widget('custom_categories', __('PT - Custom Categories'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base);
		$c = $instance['count'] ? '1' : '0';
		$h = $instance['hierarchical'] ? '1' : '0';
		$d = $instance['dropdown'] ? '1' : '0';
		$t = $instance['taxonomy'];

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h,'taxonomy' => $t);

		if ( $d ) {

?>
<form action="<?php bloginfo('url'); ?>" method="get">
<div>
<?php $cats = get_categories($cat_args); ?>
<select id="cat">
<?php foreach ($cats as $cat) : ?>
<option value="<?php echo get_term_link($cat, $cat->taxonomy) ?>"><?php if($cat->parent){echo '- ';} echo $cat->name ?></option>
<?php endforeach; ?>
</select>
</div>
</form>			

<script type='text/javascript'>
/* <![CDATA[ */
	var dropdown = document.getElementById("cat");
	
	function onCatChange() {
		
		if ( dropdown.options[dropdown.selectedIndex].value  ) {
			location.href = dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
	
	
/* ]]> */
</script>

<?php
		} else {
?>
		<ul>
<?php
		$cat_args['title_li'] = '';
		wp_list_categories(apply_filters('widget_categories_args', $cat_args));
?>
		</ul>
<?php
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);


		return $instance;
	}

	function form( $instance ) {
		
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		$taxonomy = esc_attr( $instance['taxonomy'] );

		
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

		<!--<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br /> -->

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
        <p><select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
			<option value="placecategory" <?php if($taxonomy=='placecategory'){echo 'selected="selected"';} ?>>Place</option>
			<option value="eventcategory" <?php if($taxonomy=='eventcategory'){echo 'selected="selected"';} ?>>Event</option>
	</select></p>
<?php
	}

}
register_widget('WP_Widget_Custom_Categories');

/**
 * 
 * GEOTHEME HOMEPAGE DESCRIPTION
 * 
 */
class GT_Home_Desc extends WP_Widget {

	function GT_Home_Desc() {
		$widget_ops = array( 'classname' => 'gt_home_text', 'description' => __( "Homepage Location description" ) );
		$this->WP_Widget('GT_Home_Desc', __('PT - Home Location Description'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		//$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$text = apply_filters( 'the_content', get_location_desc() );
		
		if($text){
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
		echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
		//$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>


<?php
	}
}
register_widget('GT_Home_Desc');


global $ct_on,$child_dir;

if($ct_on && file_exists($child_dir.'/library/map/home_map_widget.php')){include_once ($child_dir.'/library/map/home_map_widget.php');}
else{include_once (TEMPLATEPATH . '/library/map/home_map_widget.php');}

if($ct_on && file_exists($child_dir.'/library/map/place_listing_map_widget.php')){include_once ($child_dir.'/library/map/place_listing_map_widget.php');}
else{include_once (TEMPLATEPATH . '/library/map/place_listing_map_widget.php');}

if($ct_on && file_exists($child_dir.'/library/map/listing_map_widget.php')){include_once ($child_dir.'/library/map/listing_map_widget.php');}
else{include_once (TEMPLATEPATH . '/library/map/listing_map_widget.php');}

if($ct_on && file_exists($child_dir.'/library/map/single_map_widget.php')){include_once ($child_dir.'/library/map/single_map_widget.php');}
else{include_once (TEMPLATEPATH . '/library/map/single_map_widget.php');}

if($ct_on && file_exists($child_dir.'/library/functions/get_specials.php')){include_once ($child_dir.'/library/functions/get_specials.php');}
else{include_once (TEMPLATEPATH . '/library/functions/get_specials.php');}

if($ct_on && file_exists($child_dir.'/library/functions/child_widget_functions.php')){include_once ($child_dir.'/library/functions/child_widget_functions.php');}



?>