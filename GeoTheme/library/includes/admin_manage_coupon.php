<?php
global $wpdb,$Cart,$General;
if($_REQUEST['pagetype'] == 'delete' && $_REQUEST['code'] != '')
{
	$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
	$couponinfo = $wpdb->get_results($couponsql);
	if($couponinfo)
	{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = unserialize($couponinfoObj->option_value);
			unset($option_value[$_REQUEST['code']]);
			$option_value_str = serialize($option_value);
			$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_name='discount_coupons'";
			$wpdb->query($updatestatus);
		}
	}
	//wp_redirect($location);
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="coupon_success">
	<input type=hidden name="page" value="managecoupon"><input type=hidden name="msg" value="delsuccess"></form>';
	echo '<script>document.coupon_success.submit();</script>';
	exit;
}
?>
<style>
h2 {
	color:#464646;
	font-family:Georgia, "Times New Roman", "Bitstream Charter", Times, serif;
	font-size:24px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;
}
</style>
<h2><?php _e('Manage Coupons'); ?></h2>
<?php 
if($_POST['save_allow_coupon_opt'])
{
	update_option('is_allow_coupon_code',$_REQUEST['is_allow_coupon_code']);
}
?>
<form method="post" action="" name="allow_coupon_frm">
<input type="hidden" name="save_allow_coupon_opt" value="1" />
<p><?php _e('Allow coupon option on submit Add Listing page');?>&nbsp;:&nbsp;&nbsp;
<input type="radio" name="is_allow_coupon_code" id="is_allow_coupon_code" <?php if(get_option('is_allow_coupon_code')==1){ echo 'checked="checked"';}?>  value="1" /> <?php _e('Yes');?>
<input type="radio" name="is_allow_coupon_code" id="is_allow_coupon_code" value="0" <?php if(get_option('is_allow_coupon_code')==0){ echo 'checked="checked"';}?> /> <?php _e('No');?>
&nbsp;&nbsp;<input type="submit" name="submit" value="<?php _e("Save"); ?>"  />

</p>
</form>
<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Coupon updated successfully.'); ?></p>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='delsuccess'){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Coupon deleted successfully.'); ?></p>
</div>
<?php }?>
<p><a href="<?php echo site_url().'/wp-admin/admin.php?page=managecoupon&pagetype=addedit'?>"><strong><?php _e('Add Coupon'); ?></strong></a> </p>
<table style=" width:60%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
      <th width="150" align="left"><strong><?php _e('Coupon Code'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('Discount Type'); ?></strong></th>
      <th width="150" align="left"><strong><?php _e('Discount Amount'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Edit'); ?></strong></th>
      <th width="85" align="left"><strong><?php _e('Delete'); ?></strong></th>
      <th align="left">&nbsp;</th>
    </tr>
    <?php
$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
$couponinfo = $wpdb->get_results($couponsql);
if($couponinfo)
{
	foreach($couponinfo as $couponinfoObj)
	{
		$option_value = unserialize($couponinfoObj->option_value);
		foreach($option_value as $key=>$value)
		{
?>
    <tr>
      <td><?php echo $value['couponcode'];?></td>
      <td><?php echo $value['dis_per'];?></td>
      <td><?php echo $value['dis_amt'];?></td>
      <td><a href="<?php echo site_url().'/wp-admin/admin.php?page=managecoupon&pagetype=addedit&code='.$key;?>"><?php _e('Edit'); ?></a> </td>
      <td><a href="<?php echo site_url().'/wp-admin/admin.php?page=managecoupon&pagetype=delete&code='.$key;?>"><?php _e('Delete'); ?></a></td>
      <td>&nbsp;</td>
    </tr>
    <?php
		}
	}
}
?>
  </thead>
</table>
