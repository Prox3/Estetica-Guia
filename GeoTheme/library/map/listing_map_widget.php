<?php
function get_search_listing()
{
	global $wpdb,$wp_query, $post;
	$category_info_arr = array();
	$post_content_info = array();
	if ( have_posts() ) 
	{
		$srch_posts = array();
		while ( have_posts() ){ the_post();
			$srch_posts[] = $post->ID;
			$args = wp_parse_args( $args, array('fields' => 'ids') );
			if( $post->post_type=='place')
			{
				$category_arr = wp_get_object_terms($post->ID,'placecategory',$args);
				$category_info_arr[$category_arr[count($category_arr)-1]][]=$post;
			}else
			{
				$category_arr = wp_get_object_terms($post->ID,'eventcategory',$args);
				$category_info_arr[$category_arr[count($category_arr)-1]][]=$post;
			}
		}
		
	}
	if($category_arr)
	{
		//return $category_arr[0];
		return $srch_posts;
	}
}
####################################################################

// =============================== Google Map V3 Listing page======================================
class googlemmap_listingpage extends WP_Widget {
	function googlemmap_listingpage() {
	//Constructor
		$widget_ops = array('classname' => 'widget Google Map for Listing page', 'description' => __('Google Map for Listing page. It will show you google map V3 for Listing page.') );		
		$this->WP_Widget('googlemmapwidget_listing', __('PT &rarr; Google Map V3 - Listing page'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
	extract($args, EXTR_SKIP);
	$width = empty($instance['width']) ? '294' : apply_filters('widget_width', $instance['width']);
	$heigh = empty($instance['heigh']) ? '370' : apply_filters('widget_heigh', $instance['heigh']);
	$zoom = empty($instance['zoom']) ? '13' : apply_filters('widget_zoom', $instance['zoom']);
	$autozoom = empty($instance['autozoom']) ? '' : apply_filters('widget_autozoom', $instance['autozoom']);
	$sticky = empty($instance['sticky']) ? '' : apply_filters('widget_sticky', $instance['sticky']);
	$catarr = get_search_listing();
	//$catinfo = $catarr[0];
	//$postinfo = $catarr[1];
	//print_r ($catarr);
	$listarr =  implode(',',$catarr);
	if($listarr==''){$listarr=01;} // if blank send a false post id number to return no listings
	//echo $catarr;
	global $wp_query;
	$current_term = $wp_query->get_queried_object();
	//print_r($current_term);
	if($current_term->taxonomy=='placecategory' || $current_term->taxonomy=='eventcategory' ){$map_cat_id = $current_term->term_id;}else{$map_cat_id ='';}
	
	?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/map.js"></script>
<script type="text/javascript"> 
var ajaxSearch, openMarker;
var langText = new Array(); 
langText['tprop']='Results'; 
langText['pid']='Property ID'; 
langText['inputText']='<?php _e('Title or Keyword');?>'; 
langText['noRecords']='<?php _e('Sorry, no records were found. Please try again.');?>'; 
langText['previous']='Previous'; 
langText['next']='Next'; 
langText['of']='of';
options = {
'gtbaseurl': '<?php bloginfo('url'); ?>',						
'latitude': '<?php echo get_current_city_lat();?>', 
'longitude': '<?php echo get_current_city_lng();?>', 
'zoom': <?php if($zoom){echo $zoom;}else{echo 13;} ?>,
'scrollzoom': <?php if(get_option('ptthemes_map_scrollwheel')){echo 'true';}else{echo 'false';}?>, 
'streetview': <?php if(get_option('ptthemes_map_streetview')){echo 'true';}else{echo 'false';}?>,
'maptype': 'ROADMAP',  
'showPreview': '0', 
'maxZoom': 21, 
'autozoom': '<?php if($autozoom){echo 'Yes';}else{echo 'No';}?>',
'post_ids': '<?php echo $listarr;?>',
'cat_id': '<?php echo $map_cat_id;?>',
'bubble_size': 'small',
'etype': '<?php global $wpdb,$wp_query; $current_term = $wp_query->get_queried_object(); if($current_term->taxonomy!='placecategory'){ echo $_REQUEST['etype']; }?>' 
}
function ajaxPage(limitstart)
{
ajaxSearch();
}
function limitReset()
{
document.slider_search.limitstart.value = '';
}		
google.maps.event.addDomListener(window, 'load', home_map_go);
</script>	
<?php if($sticky){?>
<script>
jQuery(document).ready(function() {
if(jQuery(window).width() > 800){
jQuery.fn.scrollBottom = function() { 
  return this.scrollTop() + this.height(); 
};			

var content = jQuery("#content").scrollBottom();
var contentHeight = jQuery("#content").height();
var sidebarHeight = jQuery("#sidebar").height();
var stickymap = jQuery("#sticky_map").scrollBottom();


        function isScrolledTo(elem) {
            var docViewTop = jQuery(window).scrollTop(); //num of pixels hidden above current screen
            var docViewBottom = docViewTop + jQuery(window).height();
            var elemTop = jQuery(elem).offset().top; //num of pixels above the elem
            var elemBottom = elemTop + jQuery(elem).height();
            return ((elemTop <= docViewTop));

        }
		
        var catcher = jQuery('#catcher');
        var bottom = jQuery('#bottom_in');
        var sticky = jQuery('#sticky_map');		

if(contentHeight > sidebarHeight){
        jQuery(window).scroll(function() {
					//alert(contentHeight);				   
					//alert(sidebarHeight);				   
           // if(isScrolledTo(sticky)) {
            if(jQuery(window).scrollTop() > catcher.offset().top && content > stickymap ) {
				//alert('test');
                sticky.css('position','fixed');
                sticky.css('top','0px');		
            } 
///////////////////////////////////////////////////////////////////////////
			var stopHeight = catcher.offset().top + catcher.height();
			var stopBottom = bottom.offset().top;
			var stickyTop = sticky.offset().top;
			var topHeight = jQuery(window).scrollTop();
var hammerTime = bottom.offset().top - sticky.height() -30;

			if ( stopBottom < (stickyTop  + sticky.height() +30 ) ) {
                sticky.css('position','absolute');
                sticky.css('top',hammerTime);

            }

			if ( stopHeight > sticky.offset().top) {
                sticky.css('position','absolute');
                sticky.css('top',stopHeight);
				//alert(1);
            }


        });
		
									   }

}});

</script>
<?php }?>
<div id="catcher"></div>
<div class="top_banner_section" id="sticky_map">
<div class="map_background">
<div class="top_banner_section_in clearfix" style="width: <?php echo $width;?>px;">
<div class="TopLeft"><span id="triggermap"></span></div>
<div class="TopRight"></div>
<div id="map_canvas" style="width: <?php echo $width;?>px; height:<?php echo $heigh;?>px">
<!-- new map start -->
<div class="iprelative">     
<div id="advmap_canvas" style="width: <?php echo $width;?>px; height:<?php echo $heigh;?>px"></div>     
<div id="loading_div" style="width: <?php echo $width;?>px; height:<?php echo $heigh;?>px"></div> 
<div id="advmap_counter"></div>        
<div id="advmap_nofound" style="left:0px;width:0px;height:0px;padding:0px"></div>     
</div>   
<!-- new map end -->
</div>
<div class="BottomLeft"></div>
<div class="BottomRight"></div>
</div></div></div>	
	
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['heigh'] = ($new_instance['heigh']);
		$instance['zoom'] = ($new_instance['zoom']);
		$instance['autozoom'] = ($new_instance['autozoom']);
		$instance['sticky'] = ($new_instance['sticky']);

		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'width' => '', 'heigh' => '', 'zoom' => '', 'autozoom' => '', 'sticky' => '') );		
		$width = strip_tags($instance['width']);
		$heigh = strip_tags($instance['heigh']);
		$zoom = strip_tags($instance['zoom']);
		$autozoom = strip_tags($instance['autozoom']);
		$sticky = strip_tags($instance['sticky']);
	?>
    <p>
      <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Map Width <small>(Default is : 294)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" />
      </label>
    </p>
     <p>
      <label for="<?php echo $this->get_field_id('heigh'); ?>"><?php _e('Map Heigh <small>(Default is : 370)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('heigh'); ?>" name="<?php echo $this->get_field_name('heigh'); ?>" type="text" value="<?php echo attribute_escape($heigh); ?>" />
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('zoom'); ?>"><?php _e('Map Zoom level(1-19) <small>(Default is : 13)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" type="text" value="<?php echo attribute_escape($zoom); ?>" />
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('autozoom'); ?>"><?php _e('Map Auto Zoom ?');?>:
<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('autozoom'); ?>" name="<?php echo $this->get_field_name('autozoom'); ?>"<?php if($autozoom){echo 'checked="checked"';}?> />      </label>
    </p>
     <p>
      <label for="<?php echo $this->get_field_id('sticky'); ?>"><?php _e('Map Sticky(should be bottom of sidebar) ?');?>:
<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('sticky'); ?>" name="<?php echo $this->get_field_name('sticky'); ?>"<?php if($sticky){echo 'checked="checked"';}?> />      </label>
    </p>
    <?php
	}}
register_widget('googlemmap_listingpage');


?>