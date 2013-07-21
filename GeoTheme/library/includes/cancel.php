<?php get_header(); ?>
<?php $title = PAY_CANCELATION_TITLE;?>
<div id="wrapper" class="clearfix">
<div id="inner_pages" class="clearfix" >
<h1><?php echo $title;?></h1>   
<div class="breadcrumb clearfix"><?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>

    <div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>

<?php } ?></div>
<div id="content" class="content_inner" >
<?php 
$filecontent = stripslashes(get_option('post_payment_cancel_msg_content'));
if(!$filecontent)
{
	$filecontent = PAY_CANCEL_MSG;
}
$store_name = get_option('blogname');
$search_array = array('[#site_name#]');
$replace_array = array($store_name);
$filecontent = str_replace($search_array,$replace_array,$filecontent);
echo $filecontent;
?> 
</div> <!-- content #end -->
<div id="sidebar">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>