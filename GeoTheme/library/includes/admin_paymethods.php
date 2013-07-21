<?php
global $wpdb;

if($_GET['pay_fix']=='run'){
	delete_option( 'payment_method_googlechkout' );
	delete_option( 'payment_method_worldpay' );
	delete_option( 'payment_method_2co' );
	delete_option( 'payment_method_prebanktransfer' );
	delete_option( 'payment_method_payondelevary' );
	delete_option( 'payment_method_authorizenet' );
	delete_option( 'payment_method_paypal' );
	$message = __('Payment options reset');
}


if($_GET['status']!='' && $_GET['id']!='')
{
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$option_value['isactive'] = $_GET['status'];
			$option_value_str = serialize($option_value);
			$message = "Status Updated Successfully.";
		}
	}
	
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$_GET['id']."'";
	$wpdb->query($updatestatus);
}

///////////update options start//////
if($_GET['payact']=='setting' && $_GET['id']!='')
{
	include_once(TEMPLATEPATH . '/library/includes/admin_paymet_settings.php');
	//exit;
}else{
//////////update options end////////

/*$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id asc";
$paymentinfo = $wpdb->get_results($paymentsql);
if(count($paymentinfo)==0)
{*/
//////////pay settings start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Merchant Id"),
					"fieldname"		=>	"merchantid",
					"value"			=>	"myaccount@paypal.com",
					"description"	=>	__("Example : myaccount@paypal.com"),
					);
	$payOpts[] = array(
					"title"			=>	__("Cancel Url"),
					"fieldname"		=>	"cancel_return",
					"value"			=>	home_url()."/?ptype=cancel_return&pmethod=paypal",
					"description"	=>	__("Example : http://mydomain.com/cancel_return.php"),
					);
	$payOpts[] = array(
					"title"			=>	__("Return Url"),
					"fieldname"		=>	"returnUrl",
					"value"			=>	home_url()."/?ptype=return&pmethod=paypal",
					"description"	=>	__("Example : http://mydomain.com/return.php"),
					);
	$payOpts[] = array(
					"title"			=>	__("Notify Url"),
					"fieldname"		=>	"notify_url",
					"value"			=>	home_url()."/?ptype=notifyurl&pmethod=paypal",
					"description"	=>	__("Example : http://mydomain.com/notifyurl.php"),
					);
								
	$paymethodinfo[] = array(
						"name" 		=> __('Paypal'),
						"key" 		=> 'paypal',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'1',
						"payOpts"	=>	$payOpts,
						);
	//////////pay settings end////////
	
	//////////google checkout start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Merchant Id"),
					"fieldname"		=>	"merchantid",
					"value"			=>	"1234567890",
					"description"	=>	__("Example : 1234567890")
					);
												
	$paymethodinfo[] = array(
						"name" 		=> __('Google Checkout'),
						"key" 		=> 'googlechkout',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'2',
						"payOpts"	=>	$payOpts,
						);

//////////google checkout end////////
//////////authorize.net start////////

$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Login ID"),
					"fieldname"		=>	"loginid",
					"value"			=>	"yourname@domain.com",
					"description"	=>	__("Example : yourname@domain.com")
					);
	$payOpts[] = array(
					"title"			=>	__("Transaction Key"),
					"fieldname"		=>	"transkey",
					"value"			=>	"1234567890",
					"description"	=>	__("Example : 1234567890"),
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('Authorize.net'),
						"key" 		=> 'authorizenet',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'3',
						"payOpts"	=>	$payOpts,
						);

//////////authorize.net end////////
//////////worldpay start////////

	$payOpts = array();	
	$payOpts[] = array(
					"title"			=>	__("Instant Id"),
					"fieldname"		=>	"instId",
					"value"			=>	"123456",
					"description"	=>	__("Example : 123456")
					);
	$payOpts[] = array(
					"title"			=>	__("Account Id"),
					"fieldname"		=>	"accId1",
					"value"			=>	"12345",
					"description"	=>	__("Example : 12345")
					);
											
	$paymethodinfo[] = array(
						"name" 		=> __('Worldpay'),
						"key" 		=> 'worldpay',
						"isactive"	=>	'1', // 1->display,0->hide\
						"display_order"=>'4',
						"payOpts"	=>	$payOpts,
						);
//////////worldpay end////////
//////////2co start////////

	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Vendor ID"),
					"fieldname"		=>	"vendorid",
					"value"			=>	"1303908",
					"description"	=>	__("Enter Vendor ID Example : 1303908")
					);
	$payOpts[] = array(
					"title"			=>	__("Notify Url"),
					"fieldname"		=>	"ipnfilepath",
					"value"			=>	home_url()."/?ptype=notifyurl&pmethod=2co",
					"description"	=>	__("Example : http://mydomain.com/2co_notifyurl.php"),
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('2CO (2Checkout)'),
						"key" 		=> '2co',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'5',
						"payOpts"	=>	$payOpts,
						);
	
								
//////////2co end////////
//////////pre bank transfer start////////

	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	__("Account Name"),
					"fieldname"		=>	"bankinfo",
					"value"			=>	"ICICI Bank",
					"description"	=>	__("Enter the bank name to which you want to transfer payment")
					);
	$payOpts[] = array(
					"title"			=>	__("Account SC"),
					"fieldname"		=>	"bank_accountsc",
					"value"			=>	"11-22-33",
					"description"	=>	__("Enter your bank Account Sort Code"),
					);
	$payOpts[] = array(
					"title"			=>	__("Account No"),
					"fieldname"		=>	"bank_accountid",
					"value"			=>	"AB1234567890",
					"description"	=>	__("Enter your bank Account Number"),
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('Pre Bank Transfer'),
						"key" 		=> 'prebanktransfer',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'6',
						"payOpts"	=>	$payOpts,
						);
											
//////////pre bank transfer end////////
//////////pay cash on devivery start////////
	$payOpts = array();
	$paymethodinfo[] = array(
						"name" 		=> __('Pay Cash On Delivery'),
						"key" 		=> 'payondelevary',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'7',
						"payOpts"	=>	$payOpts,
						);

//////////pay cash on devivery end////////
///////////////////////////////////////


	
	

						
/*	for($i=0;$i<count($paymethodinfo);$i++)
	{
		$paymethodArray = array(
							"option_name"	=>	'payment_method_'.$paymethodinfo[$i]['key'],
							"option_value"	=>	serialize($paymethodinfo[$i]),
							);
		$wpdb->insert( $wpdb->options, $paymethodArray );
		//print_r(unserialize(serialize($paymethodArray)));
	}*/
//}
for($i=0;$i<count($paymethodinfo);$i++)
{
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_".$paymethodinfo[$i]['key']."' order by option_id asc";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if(count($paymentinfo)==0)
	{
		$paymethodArray = array(
						"option_name"	=>	'payment_method_'.$paymethodinfo[$i]['key'],
						"option_value"	=>	serialize($paymethodinfo[$i]),
						);
		$wpdb->insert( $wpdb->options, $paymethodArray );
	}
}


$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%'";
$paymentinfo = $wpdb->get_results($paymentsql);
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
<h2><?php _e('Manage Payment Options')?></h2>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e($message);?> </p>
</div>
<?php }?>
<table style=" width:50%"  class="widefat post fixed" >
  <thead>
    <tr>
      <th width="180"><strong><?php _e('Method Name');?></strong></th>
      <th width="85"><strong><?php _e('Is Active');?></strong></th>
      <th width="85" align="center"><strong><?php _e('Sort Order');?></strong></th>
      <th width="85" align="center"><strong><?php _e('Action');?></strong></th>
      <th width="85" align="center"><strong><?php _e('Settings');?></strong></th>
      <th>&nbsp;</th>
    </tr>
    <?php
if($paymentinfo)
{
	foreach($paymentinfo as $paymentinfoObj)
	{
		$paymentInfo = unserialize($paymentinfoObj->option_value);
		$option_id = $paymentinfoObj->option_id;
		$paymentInfo['option_id'] = $option_id;
		$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
	}
	ksort($paymentOptionArray);
	foreach($paymentOptionArray as $key=>$paymentInfoval)
	{
		for($i=0;$i<count($paymentInfoval);$i++)
		{
			$paymentInfo = $paymentInfoval[$i];
			$option_id = $paymentInfo['option_id'];
		?>
    <tr>
      <td><?php echo $paymentInfo['name'];?></td>
      <td><?php if($paymentInfo['isactive']){ _e("Yes");}else{	_e("No");}?></td>
      <td><?php echo $paymentInfo['display_order'];?></td>
      <td><?php if($paymentInfo['isactive']==1)
	{
		echo '<a href="'.site_url().'/wp-admin/admin.php?page=paymentoptions&status=0&id='.$option_id.'">'.__('Deactivate').'</a>';
	}else
	{
		echo '<a href="'.site_url().'/wp-admin/admin.php?page=paymentoptions&status=1&id='.$option_id.'">'.__('Activate').'</a>';
	}
	?></td>
      <td><?php
    echo '<a href="'.site_url().'/wp-admin/admin.php?page=paymentoptions&payact=setting&id='.$option_id.'">'.__('Settings').'</a>';
	?></td>
      <td>&nbsp;</td>
    </tr>
    <?php
		}
	}
}
?>
  </thead>
</table>
<?php }?>