<?php
if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
{
	remove_filter('posts_where', 'search_cal_event_where');
	remove_filter('posts_orderby', 'searching_filter_orderby');
	remove_filter('posts_join', 'searching_filter_join');
	remove_filter('posts_join', 'cat_join_meta');
	remove_filter('posts_where', 'searching_filter_where');
	remove_filter('posts_orderby', 'review_highest_orderby');
	remove_filter('posts_orderby', 'ratings_most_orderby');
	remove_filter('posts_orderby', 'archive_filter_orderby');
	remove_filter('posts_where', 'author_filter');
	remove_filter('posts_where', 'api_filter');


}
add_action('pre_get_posts', 'search_filter');
if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
{
function search_filter($local_wp_query) {
	
	$blog_cat = get_blog_sub_cats_str($type='array');
	if(isset( $_REQUEST['sn'])){$sn = trim(mysql_real_escape_string($_REQUEST['sn']));}
	if(isset( $_REQUEST['s'])){$s = trim(mysql_real_escape_string($_REQUEST['s']));}
	if(isset( $_REQUEST['api'])){$api = mysql_real_escape_string($_REQUEST['api']);}else{$api='';}
	if(isset( $_REQUEST['city_id'])){$city_id = mysql_real_escape_string($_REQUEST['city_id']);}
	if(is_search() && $_REQUEST['s']=='cal_event')
	{
		add_filter('posts_where', 'search_cal_event_where');		
	}else
	if(is_search() && $_REQUEST['t'])
	{		add_filter('posts_orderby', 'searching_filter_orderby');
		if($sn!=NEAR_TEXT){ 
			add_filter('posts_fields_request', 'distinct');// better-search.php plugin code used
			add_filter('posts_join', 'searching_filter_join');
			add_filter('posts_where', 'searching_filter_where');
		}else{
			remove_filter('posts_join', 'searching_filter_join');
			remove_filter('posts_where', 'searching_filter_where');	
		}
	}elseif(is_author())
	{
		global $current_user,$wp_query;
		$qvar = $wp_query->query_vars;
		$authname = $qvar['author_name'];
		$nicename = $current_user->data->user_nicename;
		//if($authname == $nicename)
		if($_REQUEST['list']=='favourite') // ################################# FIx for user favourites 
		{			
			add_filter('posts_where', 'author_filter_where');
		}else
		{			
			//remove_filter('posts_where', 'author_filter_where');
			add_filter('posts_where', 'author_filter');

		}
	}
############################################# FIX FOR BLOG CATS IN MULTICITY ##############################	
	elseif(is_category($blog_cat)){
			add_filter('posts_where', 'blog_filter_where');
			add_filter('posts_orderby', 'blog_filter_orderby');			

		}
############################################# END FIX FOR BLOG CATS IN MULTICITY ##########################			
############################################# API CODE##############################	
	elseif($api){
		if($_REQUEST['sort']=='rating' || $_REQUEST['sort']=='review'){
					ratings_sorting($local_wp_query);
					add_filter('posts_where', 'api_filter_where');
			}elseif($_REQUEST['sort']=='near'){	
			add_filter('posts_join', 'api_sort_filter_join');
			add_filter('posts_where', 'api_sort_filter_where');
			add_filter('posts_orderby', 'api_sort_filter_orderby');
			
			
			//add_filter('posts_where', 'api_filter_where');
			//add_filter('posts_orderby', 'blog_filter_orderby');	
		}else{			
			add_filter('posts_where', 'api_filter_where');
			add_filter('posts_orderby', 'blog_filter_orderby');	
		}
			

		}
############################################# END API CODE ##########################			
		else
	{	
		ratings_sorting($local_wp_query);
		add_filter('posts_join', 'cat_join_meta');
		add_filter('posts_groupby', 'posts_group_by');
	}
}

//================REVIEW RATING SHORTING START==========================//
function distinct($fields){
	global $wpdb;
	$s = trim(mysql_real_escape_string($_REQUEST['s']));
	return $fields." , CASE WHEN $wpdb->posts.post_title='$s' THEN 1 ELSE 0 END AS exactterm,CASE WHEN $wpdb->posts.post_title='$s' THEN 1 ELSE 0 END AS exacttitle ,CASE WHEN (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") THEN 1 ELSE 0 END AS is_featured, CASE WHEN $wpdb->posts.post_title LIKE '%$s%' THEN 1 ELSE 0 END AS titlematch,
CASE WHEN  $wpdb->posts.post_content='$s' THEN 2 ELSE 0 END AS score ";

//return $fields." , CASE WHEN $wpdb->posts.post_title='$s' THEN 1 ELSE 0 END AS exactterm,CASE WHEN $wpdb->posts.post_title='$s' THEN 1 ELSE 0 END AS exacttitle ,CASE WHEN (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") THEN 1 ELSE 0 END AS is_featured, CASE WHEN $wpdb->posts.post_title LIKE '%$s%' THEN 1 ELSE 0 END AS titlematch, MATCH ($wpdb->posts.post_title, $wpdb->posts.post_content) AGAINST ('$s') AS score ";
	}
	//$wpdb->terms.name LIKE\"%$s%\"
	//CASE WHEN (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") THEN 1 ELSE 0 END AS is_featured,
//add_action('pre_get_posts', 'ratings_sorting');
function ratings_sorting($local_wp_query) {
global $wp_query, $post;
$current_term = $wp_query->get_queried_object();
$blog_cat = get_blog_sub_cats_str($type='array');
$default_sort = get_tax_meta($current_term->term_id,'ct_cat_sort');
if(isset($current_term->term_id) && in_array($current_term->term_id,$blog_cat))
{
	add_filter('posts_orderby', 'blog_filter_orderby');	
	remove_filter('posts_orderby', 'review_highest_orderby');
	remove_filter('posts_where', 'event_where');
}else
{
	add_filter('posts_where', 'event_where');
###################################################################################################################################################################################
	if(isset($_REQUEST['sort']) && $_REQUEST['sort']=='review' || ($default_sort=='review' && !isset($_REQUEST['sort']))) {
		add_filter('posts_orderby', 'review_highest_orderby');
		remove_filter('posts_orderby', 'ratings_most_orderby');
	} elseif(isset($_REQUEST['sort']) && $_REQUEST['sort']=='rating' || ($default_sort=='rating' && !isset($_REQUEST['sort']))) {
		add_filter('posts_orderby', 'ratings_most_orderby');
		remove_filter('posts_orderby', 'review_highest_orderby');	
	}elseif($_REQUEST['sort']=='term'){	
		add_filter('posts_orderby', 'term_sort_filter_orderby');
		}
	else
	{
		add_filter('posts_orderby', 'archive_filter_orderby');
		remove_filter('posts_orderby', 'ratings_most_orderby');
		remove_filter('posts_orderby', 'review_highest_orderby');
	}
}
}

function posts_group_by($group_by){
	global $wpdb;
	$group_by = "$wpdb->posts.ID ";
	return $group_by;
}

function archive_filter_orderby($orderby) {
	global $wpdb,$wp_query;
	$current_term = $wp_query->get_queried_object();
	if(isset($current_term->taxonomy) && ($current_term->taxonomy=='eventcategory' || $current_term->taxonomy=='placecategory'))
	{
##########################################
###### CHECK FOR CHAGED DEFAULT SORT #####
##########################################
$default_sort = get_tax_meta($current_term->term_id,'ct_cat_sort');
$get_sort = mysql_real_escape_string($_REQUEST['sort']);
							   
		if($_REQUEST['etype']=='')
			{
				$_REQUEST['etype']='upcoming';
			}
			
			if($get_sort=='random' || ($default_sort=='random' && !$get_sort)){$orderby = " RAND()";}
			elseif($get_sort=='az' || ($default_sort=='az' && !$get_sort)){$orderby = "  $wpdb->posts.post_title ASC";}
			elseif($get_sort=='newest' || ($default_sort=='new' && !$get_sort)){$orderby = "  $wpdb->posts.post_date DESC";}
			elseif($_REQUEST['etype']=='upcoming')
			{
				if($current_term->taxonomy=='placecategory'){
				$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\")+0 desc, $wpdb->posts.post_date DESC";}else{
				$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\")+0 desc,(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc";
				}
			}else{
				$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\")+0 desc,(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") desc,$wpdb->posts.post_date desc";}
			}
	
	elseif(isset($current_term->taxonomy) && $current_term->taxonomy=='place_tags'){
		$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\")+0 desc,$wpdb->posts.post_title ASC";}
	return $orderby;	
}
function cat_join_meta($join)
{   global $wpdb;
	$join .= " join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID ";
	return $join;
}
function event_where($where)
{
	global $wpdb,$wp_query;
	$current_term = $wp_query->get_queried_object();
	if(is_archive())
	{
		global $wp_query, $post;
		$current_term = $wp_query->get_queried_object();
		$blog_cat = get_blog_sub_cats_str($type='array');
		if($_SESSION['multi_city'])
		{
			$multi_city_id =  get_multi_city_id();
			$meta_key = get_multi_city_meta();
			//$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key=\"$meta_key\"  and ($wpdb->postmeta.meta_value in ($multi_city_id)))) "; ## old very slow
			$where .= " AND  $wpdb->postmeta.meta_key=\"$meta_key\"  AND $wpdb->postmeta.meta_value in ($multi_city_id) ";
###################################################################################################################################################################################
		}
		if($current_term->taxonomy=='eventcategory')
		{
			if($_REQUEST['etype']=='')
			{
				$_REQUEST['etype']='upcoming';
			}
			if($_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value<='".$today."')) ";
			}
		}
	}
	
	if($_REQUEST['filters']){ 
		$filters = $_REQUEST['filters'];
		foreach($filters as $filter){
	$filter_term = mysql_real_escape_string($filter);
	$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key=\"$filter_term\" and ($wpdb->postmeta.meta_value>0 OR $wpdb->postmeta.meta_value LIKE '%/1'))) ";
		}
	}
	
	
	
	
	return $where;
}
function review_highest_orderby($content) {
	$orderby = 'desc';
	$content = " comment_count $orderby";
	return $content;
}
function ratings_most_orderby($content) {
	global $wpdb,$rating_table_name;
	$content = " (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=$wpdb->posts.ID and cm.comment_approved=1)) desc, comment_count desc ";
	return $content;	
}

function blog_filter_orderby($content)
{
	global $wpdb;
	return "$wpdb->posts.post_date DESC,$wpdb->posts.post_title ";
}
//================REVIEW RATING SHORTING END==========================//
function search_cal_event_where($where)
{
	global $wpdb,$wp_query;
	$m = $wp_query->query_vars['m'];
	$py = substr($m,0,4);
	$pm = substr($m,4,2);
	$pd = substr($m,6,2);
	$the_req_date = "$py-$pm-$pd";
	$event_of_month_sql = "select p.ID from $wpdb->posts p where p.post_type='event' and p.ID in (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'st_date' and pm.meta_value <= \"$the_req_date\" and pm.post_id in ((select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'end_date' and pm.meta_value>=\"$the_req_date\")))";
	$where = " AND $wpdb->posts.post_type='event' AND $wpdb->posts.ID in ($event_of_month_sql) and $wpdb->posts.post_status in ('publish','private') ";
	return $where;
}
function searching_filter_orderby($orderby) {
	global $wpdb, $sn;
	$orderby ='';
	if($sn!=''){$orderby .= "distance,";}
	$orderby .= "  (titlematch * 1.5 + is_featured * 5 + exacttitle * 10 + score) DESC, (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\")+0 desc,  $wpdb->posts.post_title ";
	return $orderby;	
}

function author_filter_where($where)
{
	global $wpdb,$current_user,$curauth,$wp_query;
	$query_var = $wp_query->query_vars;
	$user_id = $query_var['author'];
	
	$post_ids = get_usermeta($current_user->data->ID,'user_favourite_post');
	if($_REQUEST['list']=='favourite' && $post_ids)
	{
		$post_ids = implode(',',$post_ids);
		$where = " AND ($wpdb->posts.ID in ($post_ids)) AND ($wpdb->posts.post_type = 'place' OR $wpdb->posts.post_type = 'event') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'draft') ";			
	}else
	{	
		$where = " AND ($wpdb->posts.post_author = $user_id) AND ($wpdb->posts.post_type = 'postxxx' OR $wpdb->posts.post_type = 'eventxxx') AND ($wpdb->posts.post_status = 'publishxxx' OR $wpdb->posts.post_status = 'privatexxx' OR $wpdb->posts.post_status = 'draftxxx') ";
		//$where = " AND ($wpdb->posts.post_author = $user_id) AND ($wpdb->posts.post_type = 'post' OR $wpdb->posts.post_type = 'event') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'draft') ";
	}
	return $where;
}
function author_filter($where)
{
	global $wpdb,$current_user,$curauth,$wp_query;
	$query_var = $wp_query->query_vars;
	$user_id = $query_var['author'];
	
	if($user_id==$current_user->ID){
		$where = "  AND ($wpdb->posts.post_author = $user_id) AND ($wpdb->posts.post_type = 'place') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'draft') ";	
	}else{
		$where = "  AND ($wpdb->posts.post_author = $user_id) AND ($wpdb->posts.post_type = 'place') AND ($wpdb->posts.post_status = 'publish') ";
	}
	
	return $where;
}

function blog_filter_where($where)
{
	global $wpdb,$current_user,$curauth,$wp_query;
	$query_var = $wp_query->query_vars;
if($_SESSION['multi_city'])
		{
			$multi_city_id =  get_multi_city_id();
			$meta_key = get_multi_city_meta();
			$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where ($wpdb->postmeta.meta_key=\"$meta_key\" and ($wpdb->postmeta.meta_value in ($multi_city_id) ) OR $wpdb->postmeta.meta_key=\"post_city_id\" and ($wpdb->postmeta.meta_value=0)))) ";
		}
	return $where;
}
function api_filter_where($where)
{
	global $wpdb,$current_user,$curauth,$wp_query;
	$query_var = $wp_query->query_vars;
$city_id = mysql_real_escape_string($_REQUEST['city_id']);
if($_REQUEST['city_id'])
		{
			$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value in ($city_id) ))) ";
		}
	return $where;
}
#################################################### SEARCH VARIABLES ######################################################
	//$dist=10; // Distance
	if(isset($_REQUEST['dist'])){$dist=mysql_real_escape_string($_REQUEST['dist']);}elseif(get_option('search_dist')!=''){$dist = get_option('search_dist');}else{$dist = 25000;} //  Distance 
	if(isset($_REQUEST['Sgeo_lat'])){$mylat=mysql_real_escape_string($_REQUEST['Sgeo_lat']);}else{$mylat= get_current_city_lat();} //  Latatude 
	if(isset($_REQUEST['Sgeo_lon'])){$mylon=mysql_real_escape_string($_REQUEST['Sgeo_lon']);}else{$mylon= get_current_city_lng();} //  Distance 
	if(isset($_REQUEST['sn'])){$sn = trim(mysql_real_escape_string(trim($_REQUEST['sn'])));}
	if(isset($_REQUEST['s'])){$s = trim(mysql_real_escape_string(trim($_REQUEST['s'])));}
	if(strstr($s,',')){$s_AA = str_replace(" ", "", $s); $s_A = explode(",", $s_AA); $s_A = implode('","', $s_A); $s_A = '"'.$s_A.'"';}else{$s_A = '"'.$s.'"';}
	
	if(strstr($s,' ')){$s_SA = explode(" ", $s); }else{$s_SA = '';}
	if(isset( $_REQUEST['city_id'])){$city_id = mysql_real_escape_string($_REQUEST['city_id']);}

	
#################################################### END SEARCH VARIABLES ##################################################
function api_sort_filter_orderby($orderby) {
	global $wpdb, $sn, $mylon, $mylat;
	$orderby ='';
	if($_REQUEST['sort']=='near' && $mylon && $mylat ){$orderby .= "distance,";}
	$orderby .= "   $wpdb->posts.post_title ";
	return $orderby;	
}
function term_sort_filter_orderby($orderby) {
	global $wpdb;
	$orderby ='';
	if($_REQUEST['sort']=='term' ){
	$term = mysql_real_escape_string($_REQUEST['term']);
	//$orderby .= " ABS((select wp_postmeta.meta_value from wp_postmeta where wp_postmeta.post_id=wp_posts.ID and wp_postmeta.meta_key ='".$term."')) asc ";
	$orderby .= " (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id= $wpdb->posts.ID and $wpdb->postmeta.meta_key ='".$term."') asc ";
	//$orderby .= " (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key ='".$term."')+0 asc ";
	}
	//$orderby .= "   $wpdb->posts.post_title ";
	return $orderby;	
}
function searching_filter_join($join) {
	global $wpdb, $dist, $mylat, $mylon, $sn;
	
	$lon1 = $mylon- $dist/abs(cos(deg2rad($mylat))*69); 
	$lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
	$lat1 = $mylat-($dist/69);
	$lat2 = $mylat+($dist/69);

	$join .= " join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID ";
	//$join .= " join (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM wp_postmeta a, wp_postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) AS z ON (z.post_id = $wpdb->posts.ID) ";
	
	
		if($sn!=''){
			//$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN((ABS($mylat) - ABS(z.LAT)) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( ABS(z.LAT) * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = $wpdb->posts.ID)   ";
			$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN(($mylat - z.LAT) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( z.LAT * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = $wpdb->posts.ID)   ";
			//$join .= " join (SELECT *, (3963 * ACOS(SIN($mylat/57.2958) * SIN(z.LAT/57.2958) + COS($mylat/57.2958) * COS(z.LAT/57.2958) *  COS(z.LON/57.2958 - $mylon/57.2958)))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = $wpdb->posts.ID)   "; geoff
		}
	return $join;
}
function api_sort_filter_join($join) {
	global $wpdb, $dist, $mylat, $mylon, $sn;
	
	$lon1 = $mylon- $dist/abs(cos(deg2rad($mylat))*69); 
	$lon2 = $mylon+$dist/abs(cos(deg2rad($mylat))*69);
	$lat1 = $mylat-($dist/69);
	$lat2 = $mylat+($dist/69);

	$join .= " join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID ";
	//$join .= " join (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM wp_postmeta a, wp_postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) AS z ON (z.post_id = $wpdb->posts.ID) ";
	
	
		if($_REQUEST['sort']=='near' && $mylon && $mylat ){
			//$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN(($mylat - ABS(z.LAT)) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( ABS(z.LAT) * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = $wpdb->posts.ID)   ";
			
			$join .= " join (SELECT *, (3956 * 2 * ASIN(SQRT( POWER(SIN(($mylat - z.LAT) * pi()/180 / 2), 2) +COS($mylat * pi()/180) * COS( z.LAT * pi()/180) *POWER(SIN(($mylon - z.LON) * pi()/180 / 2), 2) )))as distance FROM (SELECT a.post_id , a.meta_key AS 'meta1', b.meta_key AS 'meta2' , a.meta_value AS 'LAT',b.meta_value AS 'LON' FROM $wpdb->postmeta a, $wpdb->postmeta b WHERE a.meta_key='geo_latitude' AND b.meta_key='geo_longitude' AND a.post_id=b.post_id AND b.meta_value between $lon1 and $lon2 AND a.meta_value between $lat1 and $lat2) z) AS z ON (z.post_id = $wpdb->posts.ID)   ";
		}
	return $join;
}
function api_sort_filter_where($where) {
	global $wpdb, $dist, $mylat, $mylon, $sn, $s, $city_id;
	
	if($_REQUEST['sort']=='near' && $mylon && $mylat){

		//$where = " AND $wpdb->posts.post_type in ('place','event') AND ($wpdb->posts.post_status = 'publish') AND ($wpdb->postmeta.meta_key like 'geo_latitude' and $wpdb->postmeta.meta_value = z.LAT)  ";
		$where = " AND $wpdb->posts.post_type in ('place','event') AND ($wpdb->posts.post_status = 'publish')   ";
	
}else{

$where = " AND $wpdb->posts.post_type in ('place','event') AND ($wpdb->posts.post_status = 'publish') and ($wpdb->postmeta.meta_key like 'address' and $wpdb->postmeta.meta_value like \"%$sn%\")  ";}
	
if($city_id)
	{
		$multi_city_id =  get_multi_city_id();
		$meta_key = get_multi_city_meta();
		//$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key=\"$meta_key\" and ($wpdb->postmeta.meta_value in ($multi_city_id) ))) ";
		$where .= " AND  $wpdb->postmeta.meta_key=\"$meta_key\"  AND $wpdb->postmeta.meta_value in ($multi_city_id) ";
	}
	
	return $where;
}
function searching_filter_where($where) {
	global $wpdb, $dist, $mylat, $mylon, $sn, $s,$s_A,$s_SA;
	$where ='';
if($_SESSION['multi_city'])
	{
		$multi_city_id =  get_multi_city_id();
		$meta_key = get_multi_city_meta();
		//$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key=\"$meta_key\"  and ($wpdb->postmeta.meta_value in ($multi_city_id)))) ";
		$where .= " AND  $wpdb->postmeta.meta_key=\"$meta_key\"  AND $wpdb->postmeta.meta_value in ($multi_city_id) ";

	}
	


	$better_search_terms ='';
	$better_search = array();
	foreach($s_SA as $s_term){
	$better_search[] = "OR $wpdb->posts.post_title LIKE\"%$s_term%\"";
	}
	//print_r($better_search);
	if(is_array($better_search)){$better_search_terms = implode(' ', $better_search);}
	
	if($sn!=''){
		$where .= " AND (($wpdb->posts.post_title LIKE \"%$s%\" $better_search_terms) OR ($wpdb->posts.post_content LIKE \"%$s%\") OR ($wpdb->posts.ID IN(SELECT $wpdb->term_relationships.object_id as post_id                      FROM $wpdb->term_taxonomy,  $wpdb->terms, $wpdb->term_relationships
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
								AND $wpdb->term_relationships.term_taxonomy_id =  $wpdb->term_taxonomy.term_taxonomy_id
                                AND $wpdb->term_taxonomy.taxonomy in ('placecategory','eventcategory','place_tags','event_tags')
								AND ($wpdb->terms.name LIKE\"%$s%\"  OR $wpdb->terms.name IN ($s_A))  )) ) AND $wpdb->posts.post_type in ('place','event') AND ($wpdb->posts.post_status = 'publish') GROUP BY $wpdb->posts.ID ";
		// AND ($wpdb->postmeta.meta_key like 'geo_latitude' and $wpdb->postmeta.meta_value = z.LAT) // removed
	
}else{
$where .= " AND (($wpdb->posts.post_title LIKE \"%$s%\" $better_search_terms) OR ($wpdb->posts.post_content LIKE \"%$s%\") OR ($wpdb->posts.ID IN(SELECT $wpdb->term_relationships.object_id as post_id                      FROM $wpdb->term_taxonomy,  $wpdb->terms, $wpdb->term_relationships
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
								AND $wpdb->term_relationships.term_taxonomy_id =  $wpdb->term_taxonomy.term_taxonomy_id
                                AND $wpdb->term_taxonomy.taxonomy in ('placecategory','eventcategory','place_tags','event_tags')
								AND ($wpdb->terms.name LIKE\"%$s%\" OR $wpdb->terms.name IN ($s_A)) )) ) AND $wpdb->posts.post_type in ('place','event') AND ($wpdb->posts.post_status = 'publish') GROUP BY $wpdb->posts.ID ";}
	

	return $where;
}
function searching_no_filter_where($where) {
	global $wpdb;
	$s = trim(mysql_real_escape_string(trim($_REQUEST['s'])));
	$where = " AND $wpdb->posts.post_type  in ('place','event') AND (($wpdb->posts.post_title LIKE \"%$s%\") OR ($wpdb->posts.post_content LIKE \"%$s%\") OR ($wpdb->postmeta.meta_key like 'address' and $wpdb->postmeta.meta_value like \"%$s%\"))) ";
	return $where;
}
}
?>