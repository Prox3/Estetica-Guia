<?php
global $wp_query;

// place permilink structure
global $wp_rewrite;
$place_structure = '/city/%city%/%placecategory%/%place%';
$place_structure = get_option('place_link');
//$event_structure = '/city/%city%/%eventcategory%/%event%';
//$wp_rewrite->add_rewrite_tag("%event%", '([^/]+)', "event=");
$wp_rewrite->add_rewrite_tag("%place%", '([^/]+)', "place=");
//$wp_rewrite->add_permastruct('event', $event_structure, false);
$wp_rewrite->add_permastruct('place', $place_structure, false);


// Add filter to plugin init function
//add_filter('post_link', 'place_permalink', 10, 3);
//add_filter('post_type_link', 'event_permalink', 10, 3);	
add_filter('post_type_link', 'place_permalink', 10, 3);	

// Adapted from get_permalink function in wp-includes/link-template.php
function place_permalink($permalink, $post_id, $leavename) {
	$post = get_post($post_id);
	$rewritecode = array(
		'%year%',
		'%monthnum%',
		'%day%',
		'%hour%',
		'%minute%',
		'%second%',
		$leavename? '' : '%postname%',
		'%post_id%',
		'%placecategory%',
		'%author%',
		'%city%',
		$leavename? '' : '%pagename%',
	);
 
	if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
		$unixtime = strtotime($post->post_date);
 
		$category = '';
		if ( strpos($permalink, '%placecategory%') !== false ) {
			//$cats = get_the_category($post->ID);
			$terms = get_the_terms($post->ID, 'placecategory');
//print_r($terms);foreach ($terms as $taxindex => $taxitem) {
foreach ($terms as $taxindex => $taxitem) {
$cat = $taxitem->slug;

}
$category = $cat;
			//print_r ($cats);
			/*if ( $cats ) {
				usort($cats, '_usort_terms_by_ID'); // order by ID
				$category = $cats[0]->slug;
				if ( $parent = $cats[0]->parent )
					$category = get_category_parents($parent, false, '/', true) . $category;
			}*/
			// show default category in permalinks, without
			// having to assign it explicitly
			if ( empty($category) ) {
				$category = 'category';
			}
			//$category ='';
			
		} 
		
		$author = '';
		if ( strpos($permalink, '%author%') !== false ) {
			$authordata = get_userdata($post->post_author);
			$author = $authordata->user_nicename;
		}
		
		$city = '';
		if ( strpos($permalink, '%city%') !== false ) {
			global $wpdb,$city_info;
			$multicity_db_table_name = $wpdb->base_prefix . "multicity"; // DATABASE TABLE  MULTY CITY
			$pcity_id = get_post_meta($post->ID,'post_city_id',true);
			if($pcity_id){
		//$city = strtolower($wpdb->get_var("SELECT cityname FROM $multicity_db_table_name WHERE city_id =\"$pcity_id\""));
		
		$city = city_name_url($pcity_id); 
		

			}else{$city = 'na';}
		}
 
		$date = explode(" ",date('Y m d H i s', $unixtime));
		$rewritereplace =
		array(
			$date[0],
			$date[1],
			$date[2],
			$date[3],
			$date[4],
			$date[5],
			$post->post_name,
			$post->ID,
			$category,
			$author,
			$city,
			$post->post_name,
		);
		$permalink = str_replace($rewritecode, $rewritereplace, $permalink);
	} else { // if they're not using the fancy permalink option
	}
	return $permalink;
}
##################
function event_permalink($permalink, $post_id, $leavename) {
	$post = get_post($post_id);
	$rewritecode = array(
		'%year%',
		'%monthnum%',
		'%day%',
		'%hour%',
		'%minute%',
		'%second%',
		$leavename? '' : '%postname%',
		'%post_id%',
		'%eventcategory%',
		'%author%',
		'%city%',
		$leavename? '' : '%pagename%',
	);
 
	if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
		$unixtime = strtotime($post->post_date);
 
		$category = '';
		if ( strpos($permalink, '%eventcategory%') !== false ) {
			//$cats = get_the_category($post->ID);
			$terms = get_the_terms($post->ID, 'eventcategory');
//print_r($terms);foreach ($terms as $taxindex => $taxitem) {
foreach ($terms as $taxindex => $taxitem) {
$cat = $taxitem->slug;

}
$category = $cat;
			//print_r ($cats);
			/*if ( $cats ) {
				usort($cats, '_usort_terms_by_ID'); // order by ID
				$category = $cats[0]->slug;
				if ( $parent = $cats[0]->parent )
					$category = get_category_parents($parent, false, '/', true) . $category;
			}*/
			// show default category in permalinks, without
			// having to assign it explicitly
			if ( empty($category) ) {
				$category = 'category';
			}
			//$category ='';
			
		} 
		
		$author = '';
		if ( strpos($permalink, '%author%') !== false ) {
			$authordata = get_userdata($post->post_author);
			$author = $authordata->user_nicename;
		}
		
		$city = '';
		if ( strpos($permalink, '%city%') !== false ) {
			global $wpdb,$city_info;
			$multicity_db_table_name = $wpdb->base_prefix . "multicity"; // DATABASE TABLE  MULTY CITY
			$pcity_id = get_post_meta($post->ID,'post_city_id',true);
			if($pcity_id!=''){
		//$city = strtolower($wpdb->get_var("SELECT cityname FROM $multicity_db_table_name WHERE city_id =\"$pcity_id\""));
		$city = city_name_url($pcity_id);
			}else{$city = 'na';}
		}
 
		$date = explode(" ",date('Y m d H i s', $unixtime));
		$rewritereplace =
		array(
			$date[0],
			$date[1],
			$date[2],
			$date[3],
			$date[4],
			$date[5],
			$post->post_name,
			$post->ID,
			$category,
			$author,
			$city,
			$post->post_name,
		);
		$permalink = str_replace($rewritecode, $rewritereplace, $permalink);
	} else { // if they're not using the fancy permalink option
	}
	return $permalink;
}

//----------------------------------------------------------------------//
// Initiate the plugin to add custom post type of "places" and "events"
//----------------------------------------------------------------------//
add_action("init", "custom_posttype_menu_wp_admin");
function custom_posttype_menu_wp_admin()
{
//===============EVENT SECTION START================
register_post_type(	'event', 
				array(	'label' 			=> __('Events'),
						'labels' 			=> array(	'name' 					=> __('Events'),
														'singular_name' 		=> __('Event'),
														'add_new' 				=> __('Add Event'),
														'add_new_item' 			=> __('Add New Event'),
														'edit' 					=> __('Edit'),
														'edit_item' 			=> __('Edit Event'),
														'new_item' 				=> __('New Event'),
														'view_item'				=> __('View Event'),
														'search_items' 			=> __('Search Events'),
														'not_found' 			=> __('No Events found'),
														'not_found_in_trash' 	=> __('No Events found in trash')	),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array(	"slug" => "events"	), // Permalinks
						//'rewrite' 			=> false,
						'query_var' 		=> "event", // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array('eventcategory','event_tags')
					)
				);

// Register custom taxonomy
$ecat_name=get_option('event_cat_pre');
register_taxonomy(	"eventcategory", 
				array(	"event"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> "Event Category", 
						'labels' 			=> array(	'name' 				=> __('Event Categories'),
														'singular_name' 	=> __('Event Category'),
														'search_items' 		=> __('Search Events'),
														'popular_items' 	=> __('Popular Event Categories'),
														'all_items' 		=> __('All Event Categories'),
														'parent_item' 		=> __('Parent Event Category'),
														'parent_item_colon' => __('Parent Event Category:'),
														'edit_item' 		=> __('Edit Event Category'),
														'update_item'		=> __('Update Event Category'),
														'add_new_item' 		=> __('Add New Event Category'),
														'new_item_name' 	=> __('New Event Category Name')	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						//"rewrite" 			=> true
						'rewrite' => array('slug'=>"$ecat_name"),'with_front'=>false)
				);
register_taxonomy(	"event_tags", 
				array(	"event"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> "Event Tags", 
						'labels' 			=> array(	'name' 				=> __('Event Tags'),
														'singular_name' 	=> __('Event Tags'),
														'search_items' 		=> __('Search Event Tags'),
														'popular_items' 	=> __('Popular Event Tags'),
														'all_items' 		=> __('All Event Tags'),
														'parent_item' 		=> __('Parent Event Tags'),
														'parent_item_colon' => __('Parent Event Tags:'),
														'edit_item' 		=> __('Edit Event Tags'),
														'update_item'		=> __('Update Event Tags'),
														'add_new_item' 		=> __('Add New Event Tags'),
														'new_item_name' 	=> __('New Event Tags Name')	),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy( 'city', 
				   array( 	'hierarchical' => FALSE, 'label' => __('City'),  
						'public' => TRUE, 'show_ui' => TRUE,
						//'query_var' => 'city',
						'rewrite' => true ) );


}

//===============EVENT SECTION END================
add_action("init", "place_posttype_menu_wp_admin");
function place_posttype_menu_wp_admin()
{
//===============PLACE SECTION START================
register_post_type(	'place', 
				array(	'label' 			=> __('Places'),
						'labels' 			=> array(	'name' 					=> __('Places'),
														'singular_name' 		=> __('Place'),
														'add_new' 				=> __('Add Place'),
														'add_new_item' 			=> __('Add New Place'),
														'edit' 					=> __('Edit'),
														'edit_item' 			=> __('Edit Place'),
														'new_item' 				=> __('New Pace'),
														'view_item'				=> __('View Place'),
														'search_items' 			=> __('Search Places'),
														'not_found' 			=> __('No Places found'),
														'not_found_in_trash' 	=> __('No Places found in trash')	),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> false, // Permalinks
						'query_var' 		=> true, // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array('placecategory','place_tags')
					)
				);

// Register custom taxonomy
$pcat_name=get_option('place_cat_pre');
//$city_name = city_name_url($_SESSION['multi_city']);
//$pcat_name= $city_name.'/'.$pcat_name;
register_taxonomy(	"placecategory", 
				array(	"place"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> "Place Category", 
						'labels' 			=> array(	'name' 				=> __('Place Categories'),
														'singular_name' 	=> __('Place Category'),
														'search_items' 		=> __('Search Places'),
														'popular_items' 	=> __('Popular Place Categories'),
														'all_items' 		=> __('All Place Categories'),
														'parent_item' 		=> __('Parent Place Category'),
														'parent_item_colon' => __('Parent Place Category:'),
														'edit_item' 		=> __('Edit Place Category'),
														'update_item'		=> __('Update Place Category'),
														'add_new_item' 		=> __('Add New Place Category'),
														'new_item_name' 	=> __('New Place Category Name')	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						//"rewrite" 			=> true
						'rewrite' => array('slug'=>"$pcat_name",'with_front'=>false))
				);
register_taxonomy(	"place_tags", 
				array(	"place"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> "Pace Tags", 
						'labels' 			=> array(	'name' 				=> __('Place Tags'),
														'singular_name' 	=> __('Place Tags'),
														'search_items' 		=> __('Search Place Tags'),
														'popular_items' 	=> __('Popular Place Tags'),
														'all_items' 		=> __('All Place Tags'),
														'parent_item' 		=> __('Parent Place Tags'),
														'parent_item_colon' => __('Parent Place Tags:'),
														'edit_item' 		=> __('Edit Place Tags'),
														'update_item'		=> __('Update Place Tags'),
														'add_new_item' 		=> __('Add New Place Tags'),
														'new_item_name' 	=> __('New Place Tags Name')	),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy( 'city', 
				   array( 	'hierarchical' => FALSE, 'label' => __('City'),  
						'public' => TRUE, 'show_ui' => TRUE,
						//'query_var' => 'city',
						'rewrite' => true ) );



// add to our plugin init function



}

add_action('admin_init', 'flush_rewrites');
function flush_rewrites() {
flush_rewrite_rules( false ); ################## FIX BY USER mcmcghee 
}
//===============PLACE SECTION END================

/////The filter code to get the custom post type in the RSS feed
if (!function_exists('myfeed_request')) {
function myfeed_request($qv) {
	if (isset($qv['feed'])){ 
	if($_REQUEST['post_type']){$qv['post_type'] =  mysql_real_escape_string($_REQUEST['post_type']);}
	else{$qv['post_type'] = array('post', 'place', 'event');}}
	return $qv;
}
}
add_filter('request', 'myfeed_request');

###############################################
################ INVOICES START ###############
###############################################
$post_type = '';
	if($_REQUEST['post'])
	{
		global $wpdb;
		$pid=$_REQUEST['post'];
		$post_type = $wpdb->get_var("select post_type from $wpdb->posts where ID=\"$pid\"");
	}

if($_REQUEST['post_type']=='invoice' || $post_type=='invoice'){
//add_filter( 'display_post_states','custom_post_state');
add_action( 'post_submitbox_misc_actions', 'custom_status_metabox' );
}
function custom_post_state( $states ) {
	global $post;
	$show_custom_state = get_post_meta( $post->ID, '_status' );
	   if ( $show_custom_state ) {
		$states[] = __( '<span class="custom_state '.strtolower($show_custom_state[0]).'">'.$show_custom_state[0].'</span>' );
		}
	return $states;
}


function custom_status_metabox(){
	global $post;
	$custom  = get_post_custom($post->ID);
	$status  = $custom["_status"][0];
	$i   = 0;
	/* ----------------------------------- */
	/*   Array of custom status messages            */
	/* ----------------------------------- */
	$custom_status = array(
			'Paid',
			'Unpaid',
			'Overdue',
			'Free',
			'Canceled',
			'Subscription-Payment',
			'Subscription-Active',
			'Subscription-Canceled',
		);
	echo '<div class="misc-pub-section custom">';
	echo '<label>Invoice status: </label><select name="status">';
	echo '<option class="default">Invoice status</option>';
	echo '<option>-----------------</option>';
	for($i=0;$i<count($custom_status);$i++){
		if($status == $custom_status[$i]){
		    echo '<option value="'.$custom_status[$i].'" selected="true">'.$custom_status[$i].'</option>';
		  }else{
		    echo '<option value="'.$custom_status[$i].'">'.$custom_status[$i].'</option>';
		  }
		}
	echo '</select>';
	echo '<br /></div>';?>
    <?php if(get_post_status( $post->post_title )!='publish' ){?>
<div class="misc-pub-section curtime misc-pub-section-last">
<span id="publish_paid">
	<?php _e('Publish Related Post?');?>:  <input type="checkbox" name="publish_paid" id="publish_paid"  />
    </span>
</div> 
<?php }
}
add_action('save_post', 'save_status');
function save_status($post_id){
	global $post, $wpdb;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){ return $post->ID; }
	//verify post is not a revision
	if ( !wp_is_post_revision( $post_id ) ) {
	update_post_meta($post->ID, "_status", $_POST["status"]);
	if($_POST["publish_paid"]){$status = get_post_status( $post->post_title); if($status!='publish' && $status!='inherit'){$my_post = array(); $my_post['ID'] = $post->post_title; $my_post['post_status']='publish'; wp_update_post( $my_post );}}
	}

}

add_action("init", "invoice_posttype_menu_wp_admin");
function invoice_posttype_menu_wp_admin()
{
//===============PLACE SECTION START================
register_post_type(	'invoice', 
				array(	'label' 			=> __('Transactions'),
						'labels' 			=> array(	'name' 					=> __('Transactions'),
														'singular_name' 		=> __('Transaction'),
														'add_new' 				=> __('Add Transaction'),
														'add_new_item' 			=> __('Add New Transaction'),
														'edit' 					=> __('Edit'),
														'edit_item' 			=> __('Edit Transaction'),
														'new_item' 				=> __('New Transaction'),
														'view_item'				=> __('View Transaction'),
														'search_items' 			=> __('Search Transactions'),
														'not_found' 			=> __('No Transactions found'),
														'not_found_in_trash' 	=> __('No Transactions found in trash')	),
						'public' 			=> false,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> false, // Permalinks
						'query_var' 		=> true, // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														//'excerpt',
														//'thumbnail',
														//'comments',
														'editor'), 
														//'trackbacks',
														//'custom-fields',
														//'revisions') ,
						'show_in_nav_menus'	=> true 
						//'taxonomies'		=> array('invoicecategory','invoice_tags')
					)
				);





// add to our plugin init function



}
################# INVOICES END ##################

################# DISABLE WYSIWYG FOR INVOICES ##################
add_filter( 'user_can_richedit', 'disable_for_invoice' );
function disable_for_invoice( $default ) {
    global $post;
    if ( 'invoice' == get_post_type( $post ) )
        return false;
    return $default;
}



###############################################
################ EXPIRE DAE START #############
###############################################

if($_REQUEST['post_type']=='place' || $post_type=='place' || $_REQUEST['post_type']=='event' || $post_type=='event'){
add_action( 'post_submitbox_misc_actions', 'expire_date_metabox' );
}

function expire_date_metabox(){
	global $post;
	?>
<div class="misc-pub-section curtime misc-pub-section-last">

	<span id="timestamp">
	Expires on:  <input type="text" name="expire_date" id="expire_date" class="textfield_m at-date" rel='yy-mm-dd' value="<?php echo get_post_meta( $post->ID, 'expire_date', true );?>" size="25"  />
    </span>
    <?php _e('<small>Please enter expiry date eg: <b>2012-03-16</b></small>');?>
	</div> 
<?php
}
add_action('save_post', 'save_expire');
function save_expire(){
	global $post;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){ return $post->ID; }
	if($_POST["expire_date"]){update_post_meta($post->ID, "expire_date", $_POST["expire_date"]);}
	else{update_post_meta($post->ID, "expire_date", "Never");}
}



?>