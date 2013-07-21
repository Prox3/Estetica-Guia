<?php
define('POSTRATINGS_MAX',5);
$rating_path = get_bloginfo( 'template_directory', 'display' ).'/library/rating/';
$rating_image_on = $rating_path.'images/rating_on.png';
$rating_image_off = $rating_path.'images/rating_off.png';
$rating_image_half = $rating_path.'images/rating_half_small.png';

add_action('wp_footer', 'footer_rating_off');
function footer_rating_off()
{
	if(get_option('ptthemes_disable_rating'))
	{
		echo '<style type="text/css">#content .category_list_view li .content .rating{border-bottom:none; padding:0;}
		#sidebar .company_info2 p{padding:0; border-bottom:none;}
		#sidebar .company_info2 p span.i_rating{display:none;}
		</style>';
	}
}

global $wpdb; $rating_table_name;


for($i=1;$i<=POSTRATINGS_MAX;$i++)
{
	$postratings_ratingsvalue[] = $i;
}

function save_comment_rating( $comment_id = 0) {
	global $wpdb,$rating_table_name, $post, $user_ID;
	$rate_user = $user_ID;
	$rate_userid = $user_ID;
	$post_id = $_REQUEST['post_id'];
	$post_title = $post->post_title;
	$rating_var = "post_".$post_id."_rating";
	$rating_val = $_REQUEST["$rating_var"];
	if(!$rating_val){$rating_val=0;}
	$rating_ip = getenv("REMOTE_ADDR");
	$wpdb->query("INSERT INTO $rating_table_name (rating_postid,rating_rating,comment_id,rating_ip,rating_posttitle,rating_timestamp,rating_host,rating_username) VALUES ( \"$post_id\", \"$rating_val\",\"$comment_id\",\"$rating_ip\",\"\",\"\",\"\",\"\")");
}

add_action( 'wp_insert_comment', 'save_comment_rating' );

function delete_comment_rating($comment_id = 0)
{
	global $wpdb,$rating_table_name, $post, $user_ID;
	if($comment_id)
	{
		$wpdb->query("delete from $rating_table_name where comment_id=\"$comment_id\"");
	}
	
}
add_action( 'wp_delete_comment', 'delete_comment_rating' );

function get_post_average_rating($pid)
{
	global $wpdb,$rating_table_name;
	$avg_rating = 0;
	if($pid)
	{
		/*$comments = $wpdb->get_var("select group_concat(comment_ID) from $wpdb->comments where comment_post_ID=\"$pid\" and comment_approved=1");
		if($comments)
		{
			$avg_rating = $wpdb->get_var("select avg(rating_rating) from $rating_table_name where comment_id in ($comments)");
			
		}*/
		$avg_rating = $wpdb->get_var("select COALESCE(avg(rating_rating),0) from $rating_table_name where rating_rating > 0 and  comment_id in (select comment_ID from $wpdb->comments where comment_post_ID=\"$pid\" and comment_approved=1)");
		// $avg_rating = ceil($avg_rating);
	}
	return $avg_rating;
}

function get_post_rating_count($pid)
{
	global $wpdb,$rating_table_name;
	$avg_rating = 0;
	if($pid)
	{
		/*$comments = $wpdb->get_var("select group_concat(comment_ID) from $wpdb->comments where comment_post_ID=\"$pid\" and comment_approved=1");
		if($comments)
		{
			$avg_rating = $wpdb->get_var("select avg(rating_rating) from $rating_table_name where comment_id in ($comments)");
			
		}*/
		$avg_rating = $wpdb->get_var("select COUNT(rating_id) from $rating_table_name where rating_rating > 0 and  comment_id in (select comment_ID from $wpdb->comments where comment_post_ID=\"$pid\" and comment_approved=1)");
		// $avg_rating = ceil($avg_rating);
	}
	return $avg_rating;
}

function draw_rating_star($avg_rating)
{
	if(get_option('ptthemes_disable_rating'))
	{
	}else
	{
		global $rating_image_on,$rating_image_off,$rating_image_half;
		$rtn_str = '';
		$s_on 	='<img src="'.$rating_image_on.'" alt="" />';
		$s_half ='<img src="'.$rating_image_half.'" alt="" />';
		$s_off 	='<img src="'.$rating_image_off.'" alt="" />';

if($avg_rating==0)							{$rtn_str .= $s_off.$s_off.$s_off.$s_off.$s_off;}
if($avg_rating>=1 && $avg_rating<1.25 )		{$rtn_str .= $s_on.$s_off.$s_off.$s_off.$s_off;}
if($avg_rating>=1.25 && $avg_rating<1.75 )	{$rtn_str .= $s_on.$s_half.$s_off.$s_off.$s_off;}
if($avg_rating>=1.75 && $avg_rating<2.25 )	{$rtn_str .= $s_on.$s_on.$s_off.$s_off.$s_off;}
if($avg_rating>=2.25 && $avg_rating<2.75 )	{$rtn_str .= $s_on.$s_on.$s_half.$s_off.$s_off;}
if($avg_rating>=2.75 && $avg_rating<3.25 )	{$rtn_str .= $s_on.$s_on.$s_on.$s_off.$s_off;}
if($avg_rating>=3.25 && $avg_rating<3.75 )	{$rtn_str .= $s_on.$s_on.$s_on.$s_half.$s_off;}
if($avg_rating>=3.75 && $avg_rating<4.25 )	{$rtn_str .= $s_on.$s_on.$s_on.$s_on.$s_off;}
if($avg_rating>=4.25 && $avg_rating<4.75 )	{$rtn_str .= $s_on.$s_on.$s_on.$s_on.$s_half;}
if($avg_rating>=4.75 && $avg_rating<=5 )	{$rtn_str .= $s_on.$s_on.$s_on.$s_on.$s_on;}
		
	}
	return $rtn_str;
}
function get_post_rating_star($pid='')
{
	$rtn_str = '';
	$avg_rating = get_post_average_rating($pid);
	$rtn_str =draw_rating_star($avg_rating);
	return $rtn_str;
}
function get_comment_rating_star($cid='')
{
	global $rating_table_name, $wpdb;
	$rtn_str = '';
	$avg_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$cid\"");
	$avg_rating = ceil($avg_rating);
	$rtn_str =draw_rating_star($avg_rating);
	return $rtn_str;
}

function get_comment_rating_num($cid='')
{
	global $rating_table_name, $wpdb;
	$rtn_str = '';
	$avg_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$cid\"");
	$avg_rating = ceil($avg_rating);
	return $avg_rating;
}

function is_user_can_add_comment($pid)
{

	global $rating_table_name, $wpdb;
	$rating_ip = getenv("REMOTE_ADDR");
	$avg_rating = $wpdb->get_var("select rating_id from $rating_table_name where rating_postid=\"$pid\" and rating_ip=\"$rating_ip\"");
	
	if(get_option('ptthemes_disable_rating_limit'))
	{
		return '';	
	}
	return $avg_rating;

}//REVIEW RATING SHORTING -- filters are from library/functions/listing_filters.php file.
?>