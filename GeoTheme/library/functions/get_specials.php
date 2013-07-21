<?php

/*
Plugin Name: Get Specials
Plugin URI: http://www.geotheme.com
Description: Pulls Specials from Place Detail Pages
Author: McMcGhee
Version: 1.0
Author URI: http://www.geotheme.com/memberlist.php?mode=viewprofile&u=86

*/

// =============================== Category wise Widget (particular category) ======================================

class get_specials extends WP_Widget {
	function get_specials() {
	//Constructor
		$widget_ops = array('classname' => 'widget Display Specials', 'description' => __('List of Specials Grid view in particular category - ( Front content )') );
		$this->WP_Widget('get_specials', __('PT &rarr; Display Specials Grid View'), $widget_ops);
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
	 ?>
         <?php 
			        global $post;
				     global $wpdb;
				   $post_type = 'post';
				   if($category)
				   {
				  	 $subsql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) ) ";
				   }
					if($_SESSION['multi_city'])
					{
						$multi_city_id =  get_multi_city_id();
						$meta_key = get_multi_city_meta();
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='".$post_type."' and p.post_status='publish' and (pm.meta_key=\"$meta_key\" and (pm.meta_value in ($multi_city_id))) $subsql  order by p.post_date desc,p.post_title asc limit $post_number";
					}else
					{
						$sql = "select p.* from $wpdb->posts p where p.post_type='".$post_type."' and p.post_status='publish' $subsql order by p.post_date desc,p.post_title asc limit $post_number ";
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
					foreach($latest_menus as $post) :
                    setup_postdata($post);
					$pcount++;
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'large');?>
           
           		<li class="clearfix <?php if(get_post_meta($post->ID,'is_featured',true)){ echo 'featured';}?> <?php echo FEATURED_IMG_CLASS;?>
"> 
                 <?php if(get_post_meta($post->ID,'is_featured',true)) {?> <span class="<?php echo 'featured_img';?>">featured</span> <?php }?>
               	
               	<?php 
if(get_the_post_thumbnail( $post->ID, array())){?>
<a class="post_img" href="<?php the_permalink(); ?>">
<?php echo get_the_post_thumbnail( $post->ID, array(160,153),array('class'	=> "",));?></a><?php
}else if($post_images[0]){ global $thumb_url;
	$thumb_url1 = $thumb_url.get_image_cutting_edge($args);
?>
 <a class="post_img" href="<?php the_permalink(); ?>"><img src="<?php echo bloginfo('template_url'); ?>/thumb.php?src=<?php echo $post_images[0];?>&amp;w=<?php echo TTIMG_MW;?>&amp;h=<?php echo TTIMG_MH;?>&amp;zc=1&amp;q=80<?php echo $thumb_url1;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
<?php
} else {?>
<a href="<?php the_permalink(); ?>"><span class="noimage"><?php _e('Image Not Available');?></span></a>
<?php }?> 
            
            		<h3> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                    <span class="rating"> <?php echo get_post_rating_star($post->ID);?><?php /*?><img src="<?php bloginfo('template_directory'); ?>/images/rating.png" alt=""  /><?php */?> </span>
                    
                    <p><?php echo excerpt($character_cout); ?> </p>
                
                 <p class="review clearfix">    
                 <a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number('0', '1', '%'); ?> </a>  
                 <span class="readmore"> <a href="<?php the_permalink(); ?>"><?php _e('read more');?> </a> </span>
                 </p>
                     
            	 </li>
                 
                 <?php if($pcount!=0 && ($pcount%3)==0){?>
                 <li class="hr"></li>
                 <?php }?>
    
           
<?php endforeach; ?>
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

<?php
	}

}

register_widget('categorylist');

?>