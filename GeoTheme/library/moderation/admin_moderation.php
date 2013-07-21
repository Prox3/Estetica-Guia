<?php
global $wpdb,$moderation_db_table_name;
if($_POST['claimact'] == 'updateclaim')
{
	$id = $_POST['id'];
	$pid = $_POST['pid'];
	$admin_com = $_POST['admin_com'];
	$status = $_POST['status'];
	$action = $_POST['action'];
	$author_id = $_POST['author_id'];
	
	$action_text ='';
	if($action==1){ $action_text = __("Take post offline while it is reviewed");}
	if($action==2){ $action_text = __("Delete user and there posts");}
  	if($action==3){ $action_text = __("Delete post");}
    if($action==4){ $action_text = __("Close comments for this post");}
	
	if($action){
		$admin_com .= "\r\n ==".$action_text."==";
		
		
	if($action==1){  $my_post = array(); $my_post['ID'] = $pid; $my_post['post_status']='pending'; wp_update_post( $my_post );}
	if($action==2 && $author_id!=1){ wp_delete_user( $author_id);}
  	if($action==3){ $my_post = array(); $my_post['ID'] = $pid; $my_post['post_status']='trash'; wp_update_post( $my_post );}
    if($action==4){  $my_post = array(); $my_post['ID'] = $pid; $my_post['comment_status']='closed'; wp_update_post( $my_post );}
	}

	if($id)
	{
		$wpdb->query("update $moderation_db_table_name set admin_comments=\"$admin_com\", status=\"$status\" WHERE pid=\"$id\" ");
	}
	$location = site_url()."/wp-admin/admin.php";
	/*echo '<form action="'.$location.'" method=get name="claim_success">
	<input type=hidden name="page" value="claimlistings"><input type=hidden name="msg" value="success"></form>';
	echo '<script>document.claim_success.submit();</script>';
	exit;*/
}
if($_REQUEST['id']!='')
{
	$pid = $_REQUEST['id'];
	$claimsql = "select * from $moderation_db_table_name where pid=\"$pid\"";
	$claiminfo = $wpdb->get_results($claimsql);
}
?>

<form action="<?php echo site_url()?>/wp-admin/admin.php?page=moderation&pagetype=addedit&id=<?php echo $_REQUEST['id'];?>" method="post" name="price_frm">
 <input type="hidden" name="claimact" value="updateclaim">  
 <input type="hidden" name="author_id" value="<?php echo $claiminfo[0]->authorid;?>"> 
  <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
  <input type="hidden" name="pid" value="<?php echo $claiminfo[0]->list_id;?>">
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
	_e('Moderation Claim Details');
}

//Get user info
		$user_info = get_userdata($claiminfo[0]->user_id);
		$author_info = get_userdata($claiminfo[0]->authorid);
?>
  </h2>
  <?php if($_POST){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e('Moderation calim updated.'); ?></p>
 <?php if($action==2 && $author_id==1){?> <p><?php _e("Can't delete admin."); ?></p><?php }?>
</div>
<?php }?>
  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="14%"><?php _e('Listing Title');?></td>
      <td width="86%"><a href="<?php echo home_url().'/?p='.$claiminfo[0]->list_id; ?>" target="_blank"><?php echo $claiminfo[0]->list_title;?></a></td>
    </tr>
    <tr>
      <td><?php _e('User Who Reported');?></td>
      <td><?php  echo "<a href='".get_admin_url()."user-edit.php?user_id=".$claiminfo[0]->user_id."'>$user_info->user_login</a>";   ?></td>
    </tr>
    <tr>
      <td><?php _e('User IP');?></td>
      <td><?php echo $claiminfo[0]->user_ip;?></td>
    </tr>
   <tr>
      <td><?php _e('Reason');?></td>
      <td><?php echo gt_moderation_reason($claiminfo[0]->moderation_reason);?></td>
    </tr>
      <td><?php _e('User Comments');?></td>
      <td><textarea name="user_com" cols="40" rows="5" id="user_com" disabled="disabled"><?php echo stripslashes($claiminfo[0]->user_comments);?></textarea></td>
    </tr>
   
      <td><?php _e('Claim Date');?></td>
      <td><?php echo date('F j, Y, g:i a',$claiminfo[0]->claim_date);?></td>
    </tr>
    
      <td><?php _e('Original Author');?></td>
      <td><?php echo "<a href='".get_admin_url()."user-edit.php?user_id=".$claiminfo[0]->authorid."'>$author_info->user_login</a>";?></td>
    </tr>
     <tr>
      <td><b><?php _e('Admin Comments');?></b></td>
      <td><textarea name="admin_com" cols="40" rows="5" id="admin_com"><?php echo stripslashes($claiminfo[0]->admin_comments);?></textarea>
      <br /><?php _e('Add comments about approval/rejection for future referance.');?>
      </td>
    </tr>
    <tr>
      <td><?php _e('Status');?></td>
      <td>
<select name="status">
  <option <?php if($claiminfo[0]->status==''){echo 'selected="selected"'; }?> value=""><?php _e("Open");?></option>
  <option <?php if($claiminfo[0]->status=='2'){echo 'selected="selected"'; }?> value="2"><?php _e("Closed");?></option>
  <option <?php if($claiminfo[0]->status=='1'){echo 'selected="selected"'; }?> value="1"><?php _e("Pending Review");?></option>
</select>
</td>
    </tr>
    <tr>
      <td><?php _e('Actions');?></td>
      <td>
<select name="action">
  <option value=""><?php _e("Select action");?></option>
  <option value="1"><?php _e("Take post offline while it is reviewed");?></option>
  <option value="2"><?php _e("Delete user and there posts");?></option>
  <option value="3"><?php _e("Delete post");?></option>
  <option value="4"><?php _e("Close comments for this post");?></option>
</select>
</td>
    </tr>
   <tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="<?php _e('Update');?>" onclick="return check_frm();" class="button-secondary action" >
        &nbsp;
        <input type="button" name="cancel" value="<?php _e('Cancel');?>" onClick="window.location.href='<?php echo site_url()?>/wp-admin/admin.php?page=moderation'" class="button-secondary action" ></td>
    </tr>
  </table>
</form>
<script>
function check_frm()
{
	
	return true;
}
</script>