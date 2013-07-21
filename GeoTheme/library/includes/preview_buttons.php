<?php
$property_price_info = get_property_price_info($_REQUEST['price_select']);
$payable_amount = $property_price_info[0]['price'];
$alive_days = $property_price_info[0]['alive_days'];
$type_title = $property_price_info[0]['title'];
$sub_active = $property_price_info[0]['sub_active'];
if($sub_active){
$sub_units_num_var = $property_price_info[0]['sub_units_num'];
$sub_units_var = $property_price_info[0]['sub_units'];
if($sub_units_var=='D'){$alive_days = $sub_units_num_var; }
if($sub_units_var=='W'){$alive_days = $sub_units_num_var * 7; }
if($sub_units_var=='M'){$alive_days = $sub_units_num_var * 30; }
if($sub_units_var=='Y'){$alive_days = $sub_units_num_var * 365; }
}
if($is_delet_property)
{		
}else
{
	if($_REQUEST['proprty_add_coupon']!='')
	{
		if(is_valid_coupon($_SESSION['property_info']['proprty_add_coupon']))
		{
			$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['property_info']['proprty_add_coupon']);
		}else
		{
			echo '<p class="error_msg_fix">'. WRONG_COUPON_MSG.'</p>';
		}
	}
}
if($_REQUEST['alook'])
{
}else
{
?>
<div class="preview_section" >
<?php
if($_REQUEST['pid'] || $_POST['renew'] || $_REQUEST['upgrade'])
{
	$form_action_url = home_url().'/?ptype=paynow';
}else
{
	$form_action_url = get_ssl_normal_url(home_url().'/?ptype=paynow');
}
?>
<form method="post" action="<?php echo $form_action_url; ?><?php if($_REQUEST['pid']){ echo '&pid='.$_REQUEST['pid'];}?><?php if($_REQUEST['renew']){echo '&renew=1';}?><?php if($_REQUEST['upgrade']){echo '&upgrade=1';}?>" name="paynow_frm" id="paynow_frm" >
<input type="hidden" name="price_select" value="<?php echo $_REQUEST['price_select'];?>" />
	<?php
	
	
	if($is_delet_property)
	{		
	}else
	{
	if(($_REQUEST['pid']=='' && $payable_amount>0) || ($_POST['renew'] && $payable_amount>0 && $_REQUEST['pid']!='') || ($_POST['upgrade'] && $payable_amount>0 && $_REQUEST['pid']!=''))
	{ if($alive_days==0){$alive_days= UNLIMITED;}
		echo '<h5 class="free_property">';
		printf(GOING_TO_PAY_MSG, get_currency_sym().$payable_amount,$alive_days,$type_title);
		echo '</h5>';
	}else
	{if($alive_days==0){$alive_days= UNLIMITED;}
		echo '<h5 class="free_property">';
		if($_REQUEST['pid']==''){
			printf(GOING_TO_FREE_MSG, $type_title,$alive_days);
			}else
		{
			printf(GOING_TO_UPDATE_MSG, get_currency_sym().$payable_amount,$alive_days,$type_title);
		}
		echo '</h5>';
	}
	?> 
	<?php
	}
	?>
	
	<?php
	if(($_REQUEST['pid']=='' && $payable_amount>0) || ($_POST['renew'] && $payable_amount>0 && $_REQUEST['pid']!='') || ($_POST['upgrade'] && $payable_amount>0 && $_REQUEST['pid']!=''))
	{
		if($sub_active){$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_paypal' order by option_id";}
		else{$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";}
		$paymentinfo = $wpdb->get_results($paymentsql);
		if($paymentinfo)
		{
		?>
  <h5 class="payment_head"> <?php echo SELECT_PAY_MEHTOD_TEXT; ?></h5>
    <ul class="payment_method">
	<?php
			$paymentOptionArray = array();
			$paymethodKeyarray = array();
			foreach($paymentinfo as $paymentinfoObj)
			{
				$paymentInfo = unserialize($paymentinfoObj->option_value);
				if($paymentInfo['isactive'])
				{
					$paymethodKeyarray[] = $paymentInfo['key'];
					$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
				}
			}
			ksort($paymentOptionArray);
			if($paymentOptionArray)
			{
				foreach($paymentOptionArray as $key=>$paymentInfoval)
				{
					for($i=0;$i<count($paymentInfoval);$i++)
					{
						$paymentInfo = $paymentInfoval[$i];
						$jsfunction = 'onclick="showoptions(this.value);"';
						$chked = '';
						if($key==1)
						{
							$chked = 'checked="checked"';
						}
					?>
		<li id="<?php echo $paymentInfo['key'];?>">
		  <input <?php echo $jsfunction;?>  type="radio" value="<?php echo $paymentInfo['key'];?>" id="<?php echo $paymentInfo['key'];?>_id" name="paymentmethod" <?php echo $chked;?> />  <?php echo $paymentInfo['name']?>
		 
		  <?php
						if(file_exists(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php'))
						{
						?>
		  <?php
							include_once(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php');
							?>
		  <?php
						} 
					 ?> </li>
		  <?php
					}
				}
			}else
			{
			?>
			<li><?php echo NO_PAYMENT_METHOD_MSG;?></li>
            			<?php
			}
			
		?>
 	  
  </ul>
  <?php
		}
	}
	?>
	
 <script type="application/x-javascript">
function showoptions(paymethod)
{
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
showoptvar = '<?php echo $paymethodKeyarray[$i]?>options';
if(eval(document.getElementById(showoptvar)))
{
	document.getElementById(showoptvar).style.display = 'none';
	if(paymethod=='<?php echo $paymethodKeyarray[$i]?>')
	{
		document.getElementById(showoptvar).style.display = '';
	}
}

<?php
}	
?>
}
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
if(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').checked)
{
showoptions(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').value);
}
<?php
}	
?>
</script>   
<?php
if($is_delet_property)
{
?>
	<h5 class="payment_head"><?php _e(PRO_DELETE_PRE_MSG);?></h5>
	<input type="button" name="Delete" value="<?php echo PRO_DELETE_BUTTON;?>" class="fr b_delete" onclick="window.location.href='<?php echo home_url();?>/?ptype=delete&pid=<?php echo $_REQUEST['pid']?>'" />
	<input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="fl b_cancel" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->data->ID);?>'" />
<?php
}else
{
?>
<input type="hidden" name="paynow" value="1">
<input type="hidden" name="pid" value="<?php echo $_POST['pid'];?>">
<?php
if($_REQUEST['pid'] and !$_REQUEST['renew'] and !$_REQUEST['upgrade'])
{
?> 
	<input type="submit" name="Submit and Pay" value="<?php echo PRO_UPDATE_BUTTON;?>" class="b_cancel fr" />
<?php
}elseif($_REQUEST['renew'])
{
?> 
	<input type="submit" name="Submit and Pay" value="<?php echo PRO_RENEW_BUTTON;?>" class="b_cancel fr" />
<?php
}elseif($_REQUEST['upgrade'] && $payable_amount>0)
{
?> 
	<input type="submit" name="Submit and Pay" value="<?php echo PRO_UPGRADE_BUTTON;?>" class="b_cancel fr" />
<?php
}elseif($_REQUEST['upgrade'] && ($payable_amount==0 || $payable_amount==''))
{
?> 
	<input type="submit" name="Submit and Pay" value="<?php echo PRO_UPDATE_BUTTON;?>" class="b_cancel fr" />
<?php
}else
{
	if($payable_amount>0)
	{
		?>
        <input type="submit" name="Submit and Pay" value="<?php echo PRO_SUBMIT_PAY_BUTTON;?>" class="fr b_cancel" />
        <?php		
	}else
	{
		?>
        <input type="submit" name="Submit and Pay" value="<?php echo PRO_SUBMIT_BUTTON;?>" class="fr b_cancel"  />
        <?php		
	}

}
?>

<script type="text/javascript">
jQuery('input:submit').click(function(){
	jQuery('input:submit').hide();	
	jQuery('input:submit').after('<input type="submit" name="Submit and Pay" value="<?php echo SUBMITTING;?>" class="fr b_cancel" disabled="true" />');
});
</script>


<a href="<?php echo home_url();?>/?ptype=post_listing&backandedit=1<?php if($_REQUEST['pid']){ echo '&pid='.$_REQUEST['pid'];} if($_SESSION['property_info']['price_select']){echo '&pkg='.$_SESSION['property_info']['price_select'];}?><?php if($_REQUEST['renew']){echo '&renew=1';}?><?php if($_REQUEST['upgrade']){echo '&upgrade=1';}?>" class="b_goback fl" ><?php _e(PRO_BACK_AND_EDIT_TEXT);?></a>
<input type="button" name="Cancel" value="<?php _e(PRO_CANCEL_BUTTON);?>" class="b_cancel fl" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->data->ID);?>'" />
 <?php }?>  
 </form></div>
<?php }?>