<?php
global $wpdb;

if($_POST)
{
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$payment_method = trim($_POST['payment_method']);
			$display_order = trim($_POST['display_order']);
			$paymet_isactive = $_POST['paymet_isactive'];
			
			if($payment_method)
			{
				$option_value['name'] = $payment_method;
			}
			$option_value['display_order'] = $display_order;
			$option_value['isactive'] = $paymet_isactive;
			
			$paymentOpts = $option_value['payOpts'];
			for($o=0;$o<count($paymentOpts);$o++)
			{
				$paymentOpts[$o]['value'] = $_POST[$paymentOpts[$o]['fieldname']];
			}
			$option_value['payOpts'] = $paymentOpts;
			$option_value_str = serialize($option_value);
		}
	}
	
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$_GET['id']."'";
	$wpdb->query($updatestatus);
	echo '<form method=get name="payment_setting_frm" acton="'.site_url().'/wp-admin/admin.php">
	<input type="hidden" name="id" value="'.$_GET['id'].'"><input type="hidden" name="page" value="paymentoptions"><input type="hidden" name="payact" value="setting"><input type="hidden" name="msg" value="success"></form>
	<script>document.payment_setting_frm.submit();</script>
	';
	//wp_redirect(site_url()."/wp-admin/admin.php?page=paymentoptions&payact=setting&msg=success&id=".$_GET['id']);
	exit;
}
if($_GET['status']!= '')
{
	$option_value['isactive'] = $_GET['status'];
}
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
		}
	}
?>

<form action="<?php echo site_url();?>/wp-admin/admin.php?page=paymentoptions&payact=setting&poo=1&id=<?php echo $_GET['id'];?>" method="post" name="payoptsetting_frm">
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
  <h2><?php echo $option_value['name'];?> <?php _e('Settings'); ?></h2>
  <?php if($_GET['msg']){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php _e('Updated Succesfully'); ?></p>
  </div>
  <?php }?>
  <table  style=" width:70%" cellpadding="5" class="widefat post fixed" >
    <thead>
      <tr>
        <td width="102"><strong><?php _e('Payment Method'); ?> : </strong></td>
        <td width="907"><input type="text" name="payment_method" id="payment_method" value="<?php echo $option_value['name'];?>" size="50" /></td>
      </tr>
      <tr>
        <td><strong><?php _e('Is Active'); ?> : </strong></td>
        <td><select name="paymet_isactive" id="paymet_isactive">
            <option value="1" <?php if($option_value['isactive']==1){?> selected="selected" <?php }?>><?php _e('Activate');?></option>
            <option value="0" <?php if($option_value['isactive']=='0' || $option_value['isactive']==''){?> selected="selected" <?php }?>><?php _e('Deactivate');?></option>
          </select>
        </td>
      </tr>
      <tr>
        <td><strong><?php _e('Display Order'); ?> : </strong></td>
        <td><input type="text" name="display_order" id="display_order" value="<?php echo $option_value['display_order'];?>" size="50"  /></td>
      </tr>
      <tr>
        <td colspan="2" style="color:#FF0000;">&nbsp;</td>
      </tr>
      <?php
for($i=0;$i<count($paymentOpts);$i++)
{
	$payOpts = $paymentOpts[$i];
?>
      <tr>
        <td><strong><?php echo $payOpts['title'];?></strong> : </td>
        <td><input type="text" name="<?php echo $payOpts['fieldname'];?>" id="<?php echo $payOpts['fieldname'];?>" value="<?php echo $payOpts['value'];?>" size="50"  />
          <?php echo $payOpts['description'];?> </td>
      </tr>
      <?php
}
?>
      <tr>
        <td></td>
        <td><input type="submit" name="submit" value="<?php _e('Submit'); ?>" onclick="return chk_form();" class="button-secondary action" />
          &nbsp;
          <input type="button" name="cancel" value="<?php _e('Cancel'); ?>" onclick="window.location.href='<?php echo site_url()."/wp-admin/admin.php?page=paymentoptions"; ?>'" class="button-secondary action" /></td>
      </tr>
    </thead>
  </table>
</form>
<script>
function chk_form()
{
	if(document.getElementById('payment_method').value == '')
	{
		
		alert('<?php _e('Please enter Payment Method');?>');
		document.getElementById('payment_method').focus();
		return false;
	}
	return true;
}
</script>
