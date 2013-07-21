<?php
global $wpdb;
if($_POST['couponact'] == 'addcoupon')
{
	$couponcode = $_POST['couponcode'];
	$coupondisc = $_POST['coupondisc'];
	$couponamt = $_POST['couponamt'];
	if($couponcode)
	{
		$discount_coupons['couponcode'] = $couponcode;
		$discount_coupons['dis_per'] = $coupondisc;
		$discount_coupons['dis_amt'] = $couponamt;
		
		$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
		$couponinfo = $wpdb->get_results($couponsql);
		if($couponinfo)
		{
			foreach($couponinfo as $couponinfoObj)
			{
				$option_value = unserialize($couponinfoObj->option_value);
			}
			if($_POST['code'] != '')
			{
				$option_value[$_POST['code']]  = $discount_coupons;
			}else
			{
				for($i=0;$i<count($option_value);$i++)
				{
					if($option_value[$i]['couponcode'] == $couponcode)
					{
						echo $location = site_url()."/wp-admin/admin.php";
						echo '<form action="'.$location.'" method=get name="coupon_success">
						<input type=hidden name="page" value="managecoupon"><input type=hidden name="msg" value="exist"><input type=hidden name="pagetype" value="addedit"></form>';
						echo '<script>document.coupon_success.submit();</script>';
						//wp_redirect($location);
						exit;
					}
				}
				$option_value[count($option_value)+1]  = $discount_coupons;
				
			}			
			$option_value_str = serialize($option_value);
			//echo '###'.count($option_value); exit;
			$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_name='discount_coupons'";
			$wpdb->query($updatestatus);
		}else
		{
			$option_value[] = $discount_coupons;
			$option_value_str = serialize($option_value);
			$insertcoupon = "insert into $wpdb->options (option_name,option_value) values ('discount_coupons','$option_value_str')";
			$wpdb->query($insertcoupon);
		}
		$location = site_url()."/wp-admin/admin.php";
		echo '<form action="'.$location.'" method=get name="coupon_success">
		<input type=hidden name="page" value="managecoupon"><input type=hidden name="msg" value="success"></form>';
		echo '<script>document.coupon_success.submit();</script>';
		//wp_redirect($location);
		exit;
	}
}
if($_REQUEST['code']!='')
{
	$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
	$couponinfo = $wpdb->get_results($couponsql);
	if($couponinfo)
	{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = unserialize($couponinfoObj->option_value);
		}
		$coupon = $option_value[$_REQUEST['code']];
	}	
}
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=managecoupon&pagetype=addedit&code=<?php echo $_REQUEST['code'];?>" method="post" name="coupon_frm">
  <input type="hidden" name="couponact" value="addcoupon">
  <input type="hidden" name="code" value="<?php echo $_REQUEST['code'];?>">
  <style>
h2 { color:#464646;font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
font-size:24px;
font-size-adjust:none;
font-stretch:normal;
font-style:italic;
font-variant:normal;
font-weight:normal;
line-height:35px;
margin:0;
padding:14px 15px 3px 0;
text-shadow:0 1px 0 #FFFFFF;  }
</style>
  <h2>
    <?php
if($_REQUEST['code']!='')
{
	_e('Edit Coupon');
}else
{
	_e('Add Coupon');
}
?>
  </h2>
  <?php if($_REQUEST['msg']=='exist'){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php _e('Coupon code already exists, Please user different one.');?></p>
  </div>
  <?php }?>
  <table style=" width:30%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="24%"><?php _e('Coupon Code');?></td>
      <td width="86%">:
        <input type="text" name="couponcode" value="<?php echo $coupon['couponcode']?>"></td>
    </tr>
    <tr>
      <td><?php _e('Discount Type');?></td>
      <td>:
        <input type="radio" id="coupondiscper" name="coupondisc" value="per" <?php if($coupon['dis_per'] == 'per' || $coupon['dis_per']==''){?>checked="checked"<?php }?> />
        <?php _e('Percentage');?>(%)&nbsp;&nbsp;
      
        <input type="radio" id="coupondiscamt" name="coupondisc" <?php if($coupon['dis_per'] == 'amt'){?> checked="checked"<?php }?> value="amt" />
        <?php _e('Amount');?>&nbsp;&nbsp;</td>
    <tr>
      <td><?php _e('Discount Amount');?></td>
      <td>:
        <input type="text" name="couponamt" id="couponamt" value="<?php echo $coupon['dis_amt']?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php _e('Submit');?>" onclick="return check_frm();" class="button-secondary action" >
        &nbsp;
        <input type="button" name="cancel" value="<?php _e('Cancel');?>" onClick="window.location.href='<?php echo site_url()?>/wp-admin/admin.php?page=managecoupon'" class="button-secondary action" ></td>
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	if(document.getElementById('coupondiscper').checked)
	{
		if(document.getElementById('couponamt').value > 100)
		{
			alert("<?php _e('Percentage should be less than or equal to 100');?>");
			return false;
		}
	}
	return true;
}
</script>