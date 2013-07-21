<?php get_header(); ?>
<?php $title = PAYMENT_SUCCESS_TITLE;?>
<div id="wrapper" class="clearfix">
<div id="inner_pages" class="clearfix" >
<h1><?php echo $title;?></h1>   
<div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>

    <div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>

<?php } ?></div>
<div id="content" class="content_inner" >
<?php 
$filecontent = stripslashes(get_option('post_payment_success_msg_content'));
if(!$filecontent)
{
	$filecontent = PAYMENT_SUCCESS_MSG;
}
$store_name = get_option('blogname');
$order_id = $_REQUEST['pid'];
if(get_post_type($order_id)=='event')
{
	$post_link = home_url().'/?ptype=preview_event&alook=1&pid='.$_REQUEST['pid'];
}else
{
$post_link = home_url().'/?ptype=preview&alook=1&pid='.$_REQUEST['pid'];	
}

$search_array = array('[#site_name#]','[#submited_information_link#]');
$replace_array = array($store_name,$post_link);

$filecontent = str_replace($search_array,$replace_array,$filecontent);
echo $filecontent;
?>
</div> <!-- content #end -->
<div id="sidebar">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>