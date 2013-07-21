<?php
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
$merchantid = $paymentOpts['merchantid'];
$returnUrl = $paymentOpts['returnUrl'];
$cancel_return = $paymentOpts['cancel_return'];
$notify_url = $paymentOpts['notify_url'];
$currency_code = get_currency_type();
global $payable_amount,$post_title,$last_postid,$sub_active,$sub_units,$sub_units_num;
$sub_action='';
?>
<form name="frm_payment_method" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<?php 
########### PAYPAL RECURRING CODE ##########
if($sub_active){
$sub_action='-subscriptions';	
	?>
<input type="hidden" value="<?php echo $payable_amount;?>" name="a3">
<input type="hidden" value="<?php echo $sub_units;?>" name="t3">
<input type="hidden" value="<?php echo $sub_units_num;?>" name="p3">
<input type="hidden" value="1" name="src">
<input type="hidden" value="2" name="rm">
<?php }?>
<input type="hidden" value="<?php echo $payable_amount;?>" name="amount"/>
<input type="hidden" value="<?php echo $returnUrl;?>&pid=<?php echo $last_postid;?>" name="return"/>
<input type="hidden" value="<?php echo $cancel_return;?>&pid=<?php echo $last_postid;?>" name="cancel_return"/>
<input type="hidden" value="<?php echo $notify_url;?>" name="notify_url"/>
<input type="hidden" value="_xclick<?php echo $sub_action;?>" name="cmd"/>
<input type="hidden" value="<?php echo $post_title;?>" name="item_name"/>
<input type="hidden" value="<?php echo $merchantid;?>" name="business"/>
<input type="hidden" value="<?php echo $currency_code;?>" name="currency_code"/>
<input type="hidden" value="<?php echo $last_postid;?>" name="custom" />
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="no_shipping" value="1">
</form>

<div class="wrapper" >
		<div class="clearfix container_message">
            	<center><h1 class="head2"><?php echo PAYPAL_MSG;?></h1></center>
         </div>
</div>
<script>
setTimeout("document.frm_payment_method.submit()",50); 
</script> 