<?php
if($_REQUEST['act']=='del')
{
	$cid = $_REQUEST['cid'];
	$wpdb->query("delete from $custom_post_meta_db_table_name where cid=\"$cid\"");
	$url = site_url().'/wp-admin/admin.php';
	echo '<form action="'.$url.'" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
	<input type="hidden" value="custom" name="page"><input type="hidden" value="act" name="del"><input type="hidden" value="delsuccess" name="msg">
	</form>
	<script>document.frm_bulk_upload.submit();</script>
	';exit;	
}elseif($_REQUEST['act']=='edit')
{
	include_once(TEMPLATEPATH . '/library/includes/admin_manage_custom_fields_edit.php');
	exit;	
}
?>
<script>
function confirm_delete(c_id)
{
	if(!confirm('<?php _e('Are you sure, want to delete this information?');?>'))
	{
		return false;
	}else
	{
		window.location.href="<?php echo site_url();?>/wp-admin/admin.php?page=custom&act=del&cid="+c_id;	
	}
}
</script>
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

<h2><?php _e('Manage Post Custom Fields')?></h2>
<?php
if($_REQUEST['msg']=='delsuccess')
{
	$message = __('Information Deleted successfully.');	
}
?>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e($message);?> </p>
</div>
<?php }?>
<p><a href="<?php echo site_url();?>/wp-admin/admin.php?page=custom&act=addedit"><strong><?php _e('Add New');?></strong></a></p>
<table width="100%"  class="widefat post" >
  <thead>
    <tr>
      <th width="150"><strong><?php _e('Admin Title');?></strong></th>
      <th width="150"><strong><?php _e('Front Title');?></strong></th>
      <th width="100" align="center"><strong><?php _e('Type');?></strong></th>
      <th width="150" align="center"><strong><?php _e('HTML Variable Name');?></strong></th>
      <th width="130" align="center"><strong><?php _e('Default Value');?></strong></th>
      <th width="70" align="center"><strong><?php _e('Display Order');?></strong></th>
      <th width="60" align="center"><strong><?php _e('Is Active');?></strong></th>
      <th width="60" align="center"><strong><?php _e('Listing page');?></strong></th>
      <th width="60" align="center"><strong><?php _e('Detail page');?></strong></th>
      <th width="85"><?php _e('Action');?></th>
      <th  align="center"><strong><?php _e('Use at front end');?></strong></th>      
    </tr>
<?php
$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name order by sort_order asc,admin_title asc");
if($post_meta_info){
	foreach($post_meta_info as $post_meta_info_obj){
	?>
     <tr>
      <td><?php echo $post_meta_info_obj->admin_title;?></td>
      <td><?php echo $post_meta_info_obj->site_title;?></td>
      <td><?php echo $post_meta_info_obj->ctype;?></td>
      <td><?php echo $post_meta_info_obj->htmlvar_name;?></td>
      <td><?php echo $post_meta_info_obj->default_value;?></td>
      <td><?php echo $post_meta_info_obj->sort_order;?></td>
      <td><?php if($post_meta_info_obj->is_active) _e('Yes'); else _e('No');?></td>
      <td><?php if($post_meta_info_obj->show_on_listing) _e('Yes'); else _e('No');?></td>
      <td><?php if($post_meta_info_obj->show_on_detail) _e('Yes'); else _e('No');?></td>
      <td>
	  <a href="<?php echo site_url();?>/wp-admin/admin.php?page=custom&act=edit&cf=<?php echo $post_meta_info_obj->cid;?>"><?php _e('Edit');?></a> | 
	  <a href="javascript:void(0);" onclick="return confirm_delete('<?php echo $post_meta_info_obj->cid;?>');"><?php _e('Delete');?></a>
      </td>
       <td><?php echo 'get_post_meta($post->ID,"'.$post_meta_info_obj->htmlvar_name.'",true)';?></td>
      </tr>
    <?php	
	}
}else
{
?>
     <tr><td colspan="9"><?php _e('No Custom fields available.');?></td></tr>
<?php		
}
?>
  </thead>
</table>