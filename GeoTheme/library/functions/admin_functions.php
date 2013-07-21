<?php

// Options panel stylesheet
function mytheme_admin_head() { 
  if ('admin.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/library/functions/admin_style.css" media="screen" />';
	echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/library/js/ptthemes.js"></script>';
	/*echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/library/js/jquery-ui.js"></script>';*/
  } //end of theme accesibility mode
}


$options = array();
global $options;

$GLOBALS['template_path'] = get_bloginfo('template_directory');

$layout_path = TEMPLATEPATH . '/layouts/'; 
$layouts = array();

$alt_stylesheet_path = TEMPLATEPATH . '/skins/';
$alt_stylesheets = array();

    global $wpdb;
								
	/*$pn_categories_obj = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy  in ('category')
								AND $wpdb->term_taxonomy.parent = '0'
								ORDER BY name"); */
$pn_categories = array();
//$pne_categories_obj = get_categories('hide_empty=0');
$pne_categories = array();
//$pne_pages_obj = get_pages('sort_order=ASC');
$pne_pages = array();

if ( is_dir($layout_path) ) {
	if ($layout_dir = opendir($layout_path) ) { 
		while ( ($layout_file = readdir($layout_dir)) !== false ) {
			if(stristr($layout_file, ".php") !== false) {
				$layouts[] = $layout_file;
			}
		}	
	}
}	

if ( is_dir($alt_stylesheet_path) ) {
	if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
		while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
			if(stristr($alt_stylesheet_file, ".css") !== false) {
				$alt_stylesheets[] = $alt_stylesheet_file;
			}
		}	
		$alt_stylesheets[] = 'none'; // add none so this css call can be removed
	}
}
/*
// Categories Name Load
foreach ($pn_categories_obj as $pn_cat) {
	$pn_categories[$pn_cat->cat_ID] = $pn_cat->name;
}
$categories_tmp = array_unshift($pn_categories, "Select a category:");

// Pages Exclude Load
foreach ($pne_pages_obj as $pne_pag) {
	$pne_pages[$pne_pag->ID] = $pne_pag->post_title;
}
*/
// Exclude Categories by Name
function category_exclude($options) {
	$options[] = array(	"type" => "wraptop");						
	
	global $wpdb;
								
	$cats = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy  in ('category')
								ORDER BY name");

	
	foreach ($cats as $cat) {	
	    if ($cat->cat_ID == '1') { $disabled = "disabled"; } else { $disabled = ""; };
			$options[] = array(	"name" => "",
						"desc" => "",
						"label" => $cat->name . " (" . $cat->count . ") &nbsp;<small style='color:#aaaaaa'>id=" . $cat->cat_ID . "</small>",
						"id" => "cat_exclude_".$cat->cat_ID,
						"std" => "",
						"disabled" => "".$disabled."",
						"type" => "checkbox");						
	}	
	$options[] = array(	"type" => "wrapbottom");		
	return $options;
}

// Exclude Pages by Name
function pages_exclude($options) {
	$options[] = array(	"type" => "wraptop");						
	$pags = get_posts('showposts=1000&post_type=page&sort_order=ASC');	
	foreach ($pags as $pag) {	
			$options[] = array(	"name" => "",
						"desc" => "",
						"label" => $pag->post_title . " &nbsp;<small style='color:#aaaaaa'>id=" . $pag->ID . "</small>",
						"id" => "pag_exclude_".$pag->ID,
						"std" => "",
						"type" => "checkbox");					
	}	
	$options[] = array(	"type" => "wrapbottom");		
	return $options;
}

// Custom Category List
function get_inc_categories($label) {	
	$include = '';
	$counter = 0;
	$catsx = get_categories('hide_empty=0');	
	foreach ($catsx as $cat) {		
		$counter++;		
		if ( get_option( $label.$cat->cat_ID ) ) {
			if ( $counter >= 1 ) { $include .= ','; }
			$include .= $cat->cat_ID;
			}	
	}	
	return $include;
}

// Custom Page List
function get_inc_pages($label) {	
	$include = '';
	$counter = 0;
	$pagsx = get_pages('sort_order=ASC');	
	foreach ($pagsx as $pag) {		
		$counter++;		
		if ( get_option( $label.$pag->ID ) ) {
			if ( $counter <> 1 ) { $include .= ','; }
			$include .= $pag->ID;
			}	
	}	
	return $include;
}

$other_entries = array("Select a Number:","0","1","2","3","4","5","6","7","8","9","10");
$feed_server = array("","http://feeds.feedburner.com","http://feeds2.feedburner.com","http://feedproxy.google.com");


// OTHER FUNCTIONS

$bm_trackbacks = array();
$bm_comments = array();

function split_comments( $source ) {

    if ( $source ) foreach ( $source as $comment ) {

        global $bm_trackbacks;
        global $bm_comments;

        if ( $comment->comment_type == 'trackback' || $comment->comment_type == 'pingback' ) {
            $bm_trackbacks[] = $comment;
        } else {
            $bm_comments[] = $comment;
        }
    }
} 
 global $wpdb;
							
/* $parent_categories_obj = $wpdb->get_var("SELECT GROUP_CONCAT($wpdb->terms.name)
							FROM $wpdb->term_taxonomy,  $wpdb->terms
							WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
							AND $wpdb->term_taxonomy.taxonomy in ('category') and $wpdb->term_taxonomy.parent='0'
							ORDER BY name");
$parent_cat_arr = explode(',',$parent_categories_obj); */

function get_pages_array()
{
	$return_array = array();
	$pags = get_posts('showposts=1000&post_type=page&sort_order=ASC');	
	if($pags)
	{
	foreach ($pags as $pag) {	
			$return_array[] = array(	"id" => $pag->ID,
							   "title"=> $pag->post_title,);					
	}
	}	
	return $return_array;
}

function get_multiselect_val($variable)
{
	if(is_array(get_option($variable)))
	{
		return implode(',',get_option($variable));
	}else
	{
		return '1';	
	}
}
function get_category_array()
{
	global $wpdb;
	$return_array = array();
	$pn_categories = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy in ('placecategory','eventcategory')
								ORDER BY name");	
	foreach($pn_categories as $pn_categories_obj)
	{
		$return_array[] = array("id" => $pn_categories_obj->cat_ID,
							   "title"=> $pn_categories_obj->name,);
	}
	return $return_array;
}
function get_blogcategory_array()
{
	global $wpdb;
	$return_array = array();
	$pn_categories = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy in ('category')
								ORDER BY name");	
	foreach($pn_categories as $pn_categories_obj)
	{
		$return_array[] = array("id" => $pn_categories_obj->cat_ID,
							   "title"=> $pn_categories_obj->name,);
	}
	return $return_array;
}
function get_eventcategory_array()
{
	global $wpdb;
	$return_array = array();
	$pn_categories = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy in ('eventcategory')
								ORDER BY name");	
	foreach($pn_categories as $pn_categories_obj)
	{
		$return_array[] = array("id" => $pn_categories_obj->cat_ID,
							   "title"=> $pn_categories_obj->name,);
	}
	return $return_array;
}
function get_category_all_array()
{
	global $wpdb;
	$return_array = array();
	$pn_categories = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy in ('placecategory','eventcategory')
								ORDER BY name");	
	foreach($pn_categories as $pn_categories_obj)
	{
		$return_array[] = array("id" => $pn_categories_obj->cat_ID,
							   "title"=> $pn_categories_obj->name,);
	}
	return $return_array;
}






// ADD THE COMMENTS META FIELDS TO THE COMMENTS ADMIN PAGE

function geotheme_comment_meta_row_action( $a ) {
	global $comment;
	if(get_comment_rating_num($comment->comment_ID)!=0){
	echo '<br /><span class="single_rating">';
	echo get_comment_rating_star($comment->comment_ID);
	echo '</span>';
	}
	return $a;
}

add_filter( 'comment_row_actions', 'geotheme_comment_meta_row_action', 11, 1 );



add_action( 'add_meta_boxes_comment', 'gt_comment_add_meta_box' );
function gt_comment_add_meta_box($comment)
{ 
//if(get_comment_rating_num($comment->comment_ID)!='' || $_REQUEST['add_rating']){
    add_meta_box( 'pmg-comment-title', __( 'Comment Rating' ), 'geotheme_comment_custom_meta', 'comment', 'normal', 'high' );
//}
}
 
function geotheme_comment_custom_meta( $comment )
{
    if(get_comment_rating_num($comment->comment_ID)!='' || $_REQUEST['add_rating']){?>
    <span class="comments_rating"> <?php require_once (TEMPLATEPATH . '/library/rating/get_rating.php');?> </span>
   <script type="text/javascript">current_rating_star_on('',<?php echo get_comment_rating_num($comment->comment_ID);?>,'<?php echo get_comment_rating_num($comment->comment_ID);?> rating');</script>
    <?php
	}else{echo '<a href="http://' .$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'&add_rating=1">'; _e('Add Rating'); echo '</a>';}
}

add_action( 'edit_comment', 'gt_comment_edit_comment' );
function gt_comment_edit_comment( $comment_id )
{ global $wpdb,$rating_table_name;
    if( isset( $_POST['post__rating'] ) ){
	$rating_num =  $_POST['post__rating'];	
	$wpdb->query("UPDATE $rating_table_name SET rating_rating=$rating_num WHERE comment_id=$comment_id");
	}
}


add_action( 'delete_comment', 'gt_comment_delete_comment' );
function gt_comment_delete_comment( $comment_id )
{ global $wpdb,$rating_table_name;
	$wpdb->query("DELETE FROM $rating_table_name WHERE comment_id=$comment_id");
}
########################################################################################################################
################################# ADD PLACE SORT OPTIONS START #########################################################
########################################################################################################################
add_filter( 'manage_edit-place_columns', 'geothem_edit_place_columns' ) ;
if (!function_exists('geothem_edit_place_columns')) {
function geothem_edit_place_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Place' ),
		'city' => __( 'City ID' ),
		'package' => __( 'Package ID' ),
		'categorys' => __( 'Categories' ),
		'date' => __( 'Date' ),
		'expire' => __( 'Expires' )
	);

	return $columns;
}}

add_filter( 'manage_edit-event_columns', 'geothem_edit_event_columns' ) ;
if (!function_exists('geothem_edit_event_columns')) {
function geothem_edit_event_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Event' ),
		'city' => __( 'City ID' ),
		'package' => __( 'Package ID' ),
		'categorys' => __( 'Categories' ),
		'date' => __( 'Date' ),
		'expire' => __( 'Expires' )
	);

	return $columns;
}}
add_filter( 'manage_edit-invoice_columns', 'geothem_edit_invoice_columns' ) ;
if (!function_exists('geothem_edit_invoice_columns')) {
function geothem_edit_invoice_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Place/Event ID' ),
		'title2' => __( 'Title' ),
		'type' => __( 'Transaction Type' ),
		'city' => __( 'City ID' ),
		'package' => __( 'Package ID' ),
		'paid_amt' => __( 'Amount' ),
		'paid_type' => __( 'Payment Method' ),
		'author' => __( 'Author' ),
		'date' => __( 'Date' )
	);

	return $columns;
}}
####################################
add_action( 'manage_invoice_posts_custom_column', 'geotheme_manage_invoice_columns', 10, 2 );
if (!function_exists('geotheme_manage_invoice_columns')) {
function geotheme_manage_invoice_columns( $column, $post_id ) {
	global $post,$wpdb,$multicity_db_table_name,$price_db_table_name;

switch( $column ) {
/* If displaying the 'city' column. */
case 'city' :
			$pcity_id = get_post_meta($post->ID,'post_city_id',true);
			$city = $wpdb->get_var("SELECT cityname FROM $multicity_db_table_name WHERE city_id =\"$pcity_id\"");
			/* If no city is found, output a default message. */
			if ( empty( $city ) )
				echo __( 'Unknown' );
			/* If there is a city id, append 'city name' to the text string. */
			else
				echo $pcity_id.' ('.$city.')';
			break;

/* If displaying the 'package' column. */
case 'paid_type' :
			$paid_type = get_post_meta($post->ID,'paymentmethod',true);
			/* If no type is found, output a default message. */
			if ( empty( $paid_type ) )
				echo __( 'Unknown' );
			/* If there is a type */
			else
				echo $paid_type;
			break;

/* If displaying the 'package' column. */
case 'paid_amt' :
			$paid = get_post_meta($post->ID,'paid_amount',true);
			/* If no type is found, output a default message. */
			if ( empty( $paid ) )
				echo __( 'Na' );
			/* If there is a type */
			else
				echo  get_option('currencysym').$paid;
			break;
			
/* If displaying the 'package' column. */
case 'title2' :
			$title = get_the_title($post->post_title);
			/* If no type is found, output a default message. */
			if ( empty( $title ) )
				echo __( 'Unknown' );
			/* If there is a type */
			else
				edit_post_link($title, '', '',$post->ID);
			break;
	
/* If displaying the 'package' column. */
case 'type' :
			$type = get_post_meta($post->ID,'_status',true);
			/* If no type is found, output a default message. */
			if ( empty( $type ) )
				echo __( 'Unknown' );
			/* If there is a type */
			else
				echo __( '<span class="custom_state '.strtolower($type).'">'.$type.'</span>' );
			break;

/* If displaying the 'package' column. */

case 'package' :
			$package_id = get_post_meta($post->ID,'package_pid',true);
			$package_name = $wpdb->get_var("SELECT title FROM $price_db_table_name WHERE pid =\"$package_id\"");
			
			/* If no city is found, output a default message. */
			if ( empty( $package_id ) )
				echo __( 'Unknown' );
			/* If there is a city id, append 'city name' to the text string. */
			else
				echo $package_id.' ('.$package_name.')';
			break;
			
/* If displaying the 'expire' column. */
case 'expire' :
			$expire_date = get_post_meta($post->ID,'expire_date',true);
			$d1 = $expire_date; // get expire_date
			$d2 = date('Y-m-d'); // get current date
			$state = __('days left');
			$date_diff_text ='';
			$expire_class = 'expire_left';
			if($expire_date!='Never'){
			if(strtotime($d1) < strtotime($d2)){$state = __('days overdue'); $expire_class = 'expire_over';}
			$date_diff = round(abs(strtotime($d1)-strtotime($d2))/86400); // get the differance in days
			$date_diff_text = '<br /><span class="'.$expire_class.'">('.$date_diff.' '.$state.')</span';
			}
			/* If no expire_date is found, output a default message. */
			if ( empty( $expire_date ) )
				echo __( 'Unknown' );
			/* If there is a expire_date, append 'days left' to the text string. */
			else
			
				echo $expire_date.$date_diff_text;
			break;
			
/* If displaying the 'categorys' column. */
case 'categorys' :

			/* Get the categorys for the post. */
			$terms = get_the_terms( $post_id, 'placecategory' );
			/* If terms were found. */
			if ( !empty( $terms ) ) {
				$out = array();
				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'placecategory' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'placecategory', 'display' ) )
					);
				}
				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}
			/* If no terms were found, output a default message. */
			else {
				_e( 'No Categories' );
			}
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}}

add_action( 'manage_place_posts_custom_column', 'geotheme_manage_place_columns', 10, 2 );
if (!function_exists('geotheme_manage_place_columns')) {
function geotheme_manage_place_columns( $column, $post_id ) {
	global $post,$wpdb,$multicity_db_table_name,$price_db_table_name;

switch( $column ) {
/* If displaying the 'city' column. */
case 'city' :
			$pcity_id = get_post_meta($post->ID,'post_city_id',true);
			$city = $wpdb->get_var("SELECT cityname FROM $multicity_db_table_name WHERE city_id =\"$pcity_id\"");
			/* If no city is found, output a default message. */
			if ( empty( $city ) )
				echo __( 'Unknown' );
			/* If there is a city id, append 'city name' to the text string. */
			else
				echo $pcity_id.' ('.$city.')';
			break;

/* If displaying the 'package' column. */
case 'package' :
			$package_id = get_post_meta($post->ID,'package_pid',true);
			$package_name = $wpdb->get_var("SELECT title FROM $price_db_table_name WHERE pid =\"$package_id\"");
			
			/* If no city is found, output a default message. */
			if ( empty( $package_id ) )
				echo __( 'Unknown' );
			/* If there is a city id, append 'city name' to the text string. */
			else
				echo $package_id.' ('.$package_name.')';
			break;
			
/* If displaying the 'expire' column. */
case 'expire' :
			$expire_date = get_post_meta($post->ID,'expire_date',true);
			$d1 = $expire_date; // get expire_date
			$d2 = date('Y-m-d'); // get current date
			$state = __('days left');
			$date_diff_text ='';
			$expire_class = 'expire_left';
			if($expire_date!='Never'){
			if(strtotime($d1) < strtotime($d2)){$state = __('days overdue'); $expire_class = 'expire_over';}
			$date_diff = round(abs(strtotime($d1)-strtotime($d2))/86400); // get the differance in days
			$date_diff_text = '<br /><span class="'.$expire_class.'">('.$date_diff.' '.$state.')</span';
			}
			/* If no expire_date is found, output a default message. */
			if ( empty( $expire_date ) )
				echo __( 'Unknown' );
			/* If there is a expire_date, append 'days left' to the text string. */
			else
			
				echo $expire_date.$date_diff_text;
			break;
			
/* If displaying the 'categorys' column. */
case 'categorys' :

			/* Get the categorys for the post. */
			$terms = get_the_terms( $post_id, 'placecategory' );
			/* If terms were found. */
			if ( !empty( $terms ) ) {
				$out = array();
				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'placecategory' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'placecategory', 'display' ) )
					);
				}
				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}
			/* If no terms were found, output a default message. */
			else {
				_e( 'No Categories' );
			}
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}}

add_action( 'manage_event_posts_custom_column', 'geotheme_manage_event_columns', 10, 2 );
if (!function_exists('geotheme_manage_event_columns')) {
function geotheme_manage_event_columns( $column, $post_id ) {
	global $post,$wpdb,$multicity_db_table_name,$price_db_table_name;

switch( $column ) {
/* If displaying the 'city' column. */
case 'city' :
			$pcity_id = get_post_meta($post->ID,'post_city_id',true);
			$city = $wpdb->get_var("SELECT cityname FROM $multicity_db_table_name WHERE city_id =\"$pcity_id\"");
			/* If no city is found, output a default message. */
			if ( empty( $city ) )
				echo __( 'Unknown' );
			/* If there is a city id, append 'city name' to the text string. */
			else
				echo $pcity_id.' ('.$city.')';
			break;

/* If displaying the 'package' column. */
case 'package' :
			$package_id = get_post_meta($post->ID,'package_pid',true);
			$package_name = $wpdb->get_var("SELECT title FROM $price_db_table_name WHERE pid =\"$package_id\"");
			
			/* If no city is found, output a default message. */
			if ( empty( $package_id ) )
				echo __( 'Unknown' );
			/* If there is a city id, append 'city name' to the text string. */
			else
				echo $package_id.' ('.$package_name.')';
			break;

/* If displaying the 'expire' column. */
case 'expire' :
			$expire_date = get_post_meta($post->ID,'expire_date',true);
			$d1 = $expire_date; // get expire_date
			$d2 = date('Y-m-d'); // get current date
			$state = __('days left');
			$date_diff_text ='';
			$expire_class = 'expire_left';
			if($expire_date!='Never'){
			if(strtotime($d1) < strtotime($d2)){$state = __('days overdue'); $expire_class = 'expire_over';}
			$date_diff = round(abs(strtotime($d1)-strtotime($d2))/86400); // get the differance in days
			$date_diff_text = '<br /><span class="'.$expire_class.'">('.$date_diff.' '.$state.')</span';
			}
			/* If no expire_date is found, output a default message. */
			if ( empty( $expire_date ) )
				echo __( 'Unknown' );
			/* If there is a expire_date, append 'days left' to the text string. */
			else
			
				echo $expire_date.$date_diff_text;
			break;
			
/* If displaying the 'categorys' column. */
case 'categorys' :

			/* Get the categorys for the post. */
			$terms = get_the_terms( $post_id, 'eventcategory' );
			/* If terms were found. */
			if ( !empty( $terms ) ) {
				$out = array();
				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'eventcategory' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'eventcategory', 'display' ) )
					);
				}
				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}
			/* If no terms were found, output a default message. */
			else {
				_e( 'No Categories' );
			}
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}}
#########################################
add_filter( 'manage_edit-place_sortable_columns', 'geothem_place_sortable_columns' );
if (!function_exists('geothem_place_sortable_columns')) {
function geothem_place_sortable_columns( $columns ) {

	$columns['city'] = 'city';
	$columns['package'] = 'package';
	//$columns['expire'] = 'expire';

	return $columns;
}}
add_filter( 'manage_edit-event_sortable_columns', 'geothem_event_sortable_columns' );
if (!function_exists('geothem_event_sortable_columns')) {
function geothem_event_sortable_columns( $columns ) {

	$columns['city'] = 'city';
	$columns['package'] = 'package';
//	$columns['expire'] = 'expire';

	return $columns;
}}
add_filter( 'manage_edit-invoice_sortable_columns', 'geothem_invoice_sortable_columns' );
if (!function_exists('geothem_invoice_sortable_columns')) {
function geothem_invoice_sortable_columns( $columns ) {

	$columns['city'] = 'city';
	$columns['package'] = 'package';
	//$columns['title2'] = 'title2';
	$columns['type'] = 'type';
	$columns['paid_type'] = 'paid_type';
	$columns['paid_amt'] = 'paid_amt';
//	$columns['expire'] = 'expire';

	return $columns;
}}
##########################################
/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'geotheme_edit_place_load' );
if (!function_exists('geotheme_edit_place_load')) {
function geotheme_edit_place_load() {
	add_filter( 'request', 'geotheme_sort_places' );
}}

/* Sorts the places. */
if (!function_exists('geotheme_sort_places')) {
function geotheme_sort_places( $vars ) {

	/* Check if we're viewing the 'place' post type. */
	if ( isset( $vars['post_type'] ) && 'invoice' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'city'. */
		if ( isset( $vars['orderby'] ) && 'paid_amt' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'paid_amount',
					'orderby' => 'meta_value_num',
					'order' => 'DESC'
				)
			);
		}
	}
	
	
	
	/* Check if we're viewing the 'place' post type. */
	if ( isset( $vars['post_type'] ) && 'invoice' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'city'. */
		if ( isset( $vars['orderby'] ) && 'paid_type' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'paymentmethod',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	
	/* Check if we're viewing the 'place' post type. */
	if ( isset( $vars['post_type'] ) && 'invoice' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'city'. */
		if ( isset( $vars['orderby'] ) && 'type' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_status',
					'orderby' => 'meta_value'
				)
			);
		}
	}
	
		/* Check if we're viewing the 'place' post type. */
	if ( isset( $vars['post_type'] ) && ('place' == $vars['post_type'] || 'event' == $vars['post_type'] || 'invoice' == $vars['post_type']) ) {

		/* Check if 'orderby' is set to 'city'. */
		if ( isset( $vars['orderby'] ) && 'city' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'post_city_id',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}
	
		/* Check if we're viewing the 'place' post type. */
	if ( isset( $vars['post_type'] ) && ('place' == $vars['post_type'] || 'event' == $vars['post_type']|| 'invoice' == $vars['post_type'])) {

		/* Check if 'orderby' is set to 'city'. */
		if ( isset( $vars['orderby'] ) && 'package' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'package_pid',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}
	
		/* Check if we're viewing the 'place' post type. 
	if ( isset( $vars['post_type'] ) && ('place' == $vars['post_type'] || 'event' == $vars['post_type'])) {

		// /* Check if 'orderby' is set to 'city'. 
		if ( isset( $vars['orderby'] ) && 'expire' == $vars['orderby'] ) {

		//	/* Merge the query vars with our custom variables. 
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'expire_date',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}*/

	return $vars;
}}
//add_filter('pre_get_posts', 'query_post_type');
########################################################################################################################
################################# ADD PLACE SORT OPTIONS END ###########################################################
########################################################################################################################





#########################################
######## DOCUMENTATION BUTTON ###########
#########################################
function show_docs_button(){
	global $wpdb;

$uri = $_SERVER["REQUEST_URI"];
$help_page = '';
//General settings
if(strpos($uri, 'admin.php?page=product_menu.php')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/general-settings-thread700/';}
//Design Settings
if(strpos($uri, 'admin.php?page=theme_settings')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/design-settings-thread701/';}
//Payment Options
if(strpos($uri, 'admin.php?page=paymentoptions')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/payment-options-thread702/';}
//Manage Coupons
if(strpos($uri, 'admin.php?page=managecoupon')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-coupons-thread703/';}
//Manage Price
if(strpos($uri, 'admin.php?page=price')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-price-thread704/';}
//Manage Country
if(strpos($uri, 'admin.php?page=country')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-country-thread705/';}
//Manage Region
if(strpos($uri, 'admin.php?page=region')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-region-thread706/';}
//Manage City
if(strpos($uri, 'admin.php?page=city')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-city-thread707/';}
//Manage Neighbourhood
if(strpos($uri, 'admin.php?page=hood')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-neighbourhood-thread708/';}
//Manage Post Custom Fields
if(strpos($uri, 'admin.php?page=custom')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-post-custom-fields-thread710/';}
//Manage Notifications
if(strpos($uri, 'admin.php?page=notification')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-notifications-thread711/';}
//Bulk Upload
if(strpos($uri, 'admin.php?page=bulk')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/bulk-upload-thread712/';}
//Manage Listing Claims
if(strpos($uri, 'admin.php?page=claimlistings')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/manage-listing-claims-thread713/';}
//Convert Listings
if(strpos($uri, 'admin.php?page=convertlistings')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/convert-listings-thread714/';}
//RSS Images Setting
if(strpos($uri, 'admin.php?page=wp-rss-image')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/rss-images-setting-thread715/';}
//Ajax Edit Comments
if(strpos($uri, 'admin.php?page=wp-ajax-edit-comments.php')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/ajax-edit-comments-thread716/';}
//Comment Uploads
if(strpos($uri, 'comment-uploads/main.php')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/comment-uploads-thread717/';}
//Breadcrumb NavXT Settings
if(strpos($uri, 'page=breadcrumb_navxt')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/breadcrumb-navxt-settings-thread718/';}
//Place Categories
if(strpos($uri, 'edit-tags.php?taxonomy=placecategory&post_type=place') || strpos($uri, 'edit-tags.php?taxonomy=eventcategory&post_type=event')|| strpos($uri, 'edit-tags.php?action=edit&taxonomy=placecategory')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/place-event-categories-thread719/';}
//Places
if(strpos($uri, 'edit.php?post_type=place')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/places-thread720/';}
//Transactions
if(strpos($uri, 'edit.php?post_type=invoice')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/transactions-thread721/';}
//Permalink Settings
if(strpos($uri, 'options-permalink.php')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/permalink-settings-thread722/';}
//Widgets
if(strpos($uri, 'widgets.php')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/widgets-thread723/';}
//Menus
if(strpos($uri, 'nav-menus.php')){$help_page = 'http://www.geotheme.com/support-forum/geotheme-support-forum-group1/v3-documentation-forum13/widgets-thread723/';}




if($help_page){
?>
<a href="<?php echo $help_page;?>" target="_blank" id="docs-button" style="background:url('<?php echo bloginfo('template_directory').'/images/docs.png'; ?>');">Feedback</a>
<?php
}

}
if(get_option('gt_docs')==1 || get_option('gt_docs')==''){add_action('admin_footer', 'show_docs_button');}
?>