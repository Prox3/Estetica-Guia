<?php
global $wpdb,$claim_db_table_name;
if($_POST['claimact'] == 'addclaim')
{
	$id = $_POST['id'];
	$admin_com = $_POST['admin_com'];

	if($id)
	{
		$wpdb->query("update $claim_db_table_name set admin_comments=\"$admin_com\"");
	}
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="claimlistings"><input type=hidden name="msg" value="success"></form>';
	echo '<script>document.claim_success.submit();</script>';
	exit;
}
if($_REQUEST['id']!='')
{
	$pid = $_REQUEST['id'];
	$claimsql = "select * from $claim_db_table_name where pid=\"$pid\"";
	$claiminfo = $wpdb->get_results($claimsql);
}
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=claimlistings&pagetype=addedit&pid=<?php echo $_REQUEST['id'];?>" method="post" name="price_frm">
  <input type="hidden" name="claimact" value="addclaim">
  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
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
if($_REQUEST['id']!='')
{
	_e('Listing Claim Details');
}else
{
	_e('Add Price');
}
?>
  </h2>
  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="14%"><?php _e('Listing Title');?></td>
      <td width="86%"><a href="<?php echo home_url().'/?p='.$claiminfo[0]->list_id; ?>" target="_blank"><?php echo $claiminfo[0]->list_title;?></a></td>
    </tr>
    <tr>
      <td><?php _e('Username');?></td>
      <td><?php echo $claiminfo[0]->user_name;?></td>
    </tr>
    <tr>
      <td><?php _e('Full Name');?></td>
      <td><?php echo $claiminfo[0]->user_fullname;?></td>
    </tr>
   <tr>
      <td><?php _e('User Email');?></td>
      <td><?php echo $claiminfo[0]->user_email;?></td>
    </tr>
   <tr>
      <td><?php _e('Number');?></td>
      <td><?php echo $claiminfo[0]->user_number;?></td>
    </tr>
   <tr>
      <td><?php _e('Position');?></td>
      <td><?php echo $claiminfo[0]->user_position;?></td>
    </tr>
    <tr>
      <td><?php _e('User Comments');?></td>
      <td><textarea name="user_com" cols="40" rows="5" id="user_com" disabled="disabled"><?php echo stripslashes($claiminfo[0]->user_comments);?></textarea></td>
    </tr>
   <tr>
      <td><?php _e('Status');?></td>
      <td><?php if($claiminfo[0]->status==1) _e("Approved"); elseif($claiminfo[0]->status==2) _e("Rejected"); else _e("No Desicion");?></td>
    </tr>
   <tr>
      <td><?php _e('Claim Date');?></td>
      <td><?php echo $claiminfo[0]->claim_date;?></td>
    </tr>
   <tr>
      <td><?php _e('User IP');?></td>
      <td><?php echo $claiminfo[0]->user_ip;?></td>
    </tr>
   <tr>
      <td><?php _e('Original Author');?></td>
      <td><?php echo $claiminfo[0]->org_author;?></td>
    </tr>
     <tr>
      <td><b><?php _e('Admin Comments');?></b></td>
      <td><textarea name="admin_com" cols="40" rows="5" id="admin_com"><?php echo stripslashes($claiminfo[0]->admin_comments);?></textarea>
      <br /><?php _e('Add comments about approval/rejection for future referance.');?>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php _e('Add Comment');?>" onclick="return check_frm();" class="button-secondary action" >
        &nbsp;
        <input type="button" name="cancel" value="<?php _e('Cancel');?>" onClick="window.location.href='<?php echo site_url()?>/wp-admin/admin.php?page=claimlistings'" class="button-secondary action" ></td>
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	if(document.getElementById('title').value=='')
	{
		alert("<?php _e('Please enter Title');?>");
		return false;
	}
	return true;
}
</script>