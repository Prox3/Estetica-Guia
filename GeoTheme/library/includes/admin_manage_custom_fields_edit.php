<?php
global $wpdb,$custom_post_meta_db_table_name;
add_column_if_not_exist($custom_post_meta_db_table_name, 'cat_sort', 'text NOT NULL');
add_column_if_not_exist($custom_post_meta_db_table_name, 'cat_filter', 'text NOT NULL');

$cf = $_REQUEST['cf'];
$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where cid= \"$cf\"");
if($post_meta_info){
	$post_val = $post_meta_info[0];
}else
{
	$post_val->sort_order = $wpdb->get_var("select max(sort_order)+1 from  $custom_post_meta_db_table_name");
}
if($_POST)
{
	$admin_title = $_POST['admin_title'];
	$site_title = $_POST['site_title'];
	$ctype = $_POST['ctype'];
	$htmlvar_name = $_POST['htmlvar_name'];
	$admin_desc = $_POST['admin_desc'];
	$clabels = $_POST['clabels'];
	$default_value = $_POST['default_value'];
	$sort_order = $_POST['sort_order'];
	$is_active = $_POST['is_active'];
	$show_on_listing = $_POST['show_on_listing'];
	$show_on_detail = $_POST['show_on_detail'];
	$option_values = $_POST['option_values'];
	$price_pkg = $_POST['show_on_pkg'];
	$cat_sort = $_POST['cat_sort'];
	$cat_filter = $_POST['cat_filter'];
	if($price_pkg )
	{
		$price_pkg  = implode(',',$price_pkg );
	}
	if($cat_sort)
	{
		$cat_sort = implode(',',$cat_sort);
	}
	if($cat_filter)
	{
		$cat_filter = implode(',',$cat_filter);
	}
	if($_REQUEST['cf'])
	{
		$cf = $_REQUEST['cf'];
		$sql = "update $custom_post_meta_db_table_name set admin_title=\"$admin_title\" ,site_title=\"$site_title\" ,ctype=\"$ctype\" ,htmlvar_name=\"$htmlvar_name\",admin_desc=\"$admin_desc\" ,clabels=\"$clabels\" ,default_value=\"$default_value\" ,sort_order=\"$sort_order\",is_active=\"$is_active\",show_on_listing=\"$show_on_listing\",show_on_detail=\"$show_on_detail\", option_values=\"$option_values\" , extrafield1=\"$price_pkg\", cat_sort=\"$cat_sort\", cat_filter=\"$cat_filter\" where cid=\"$cf\"";
		$wpdb->query($sql);
	}else
	{
		$sql = "insert into $custom_post_meta_db_table_name (admin_title,site_title,ctype,htmlvar_name,admin_desc,clabels,default_value,sort_order,is_active,show_on_listing,show_on_detail,option_values,extrafield1,cat_sort,cat_filter) values (\"$admin_title\",\"$site_title\",\"$ctype\",\"$htmlvar_name\",\"$admin_desc\",\"$clabels\",\"$default_value\",\"$sort_order\",\"$is_active\",\"$show_on_listing\",\"$show_on_detail\",\"$option_values\",\"$price_pkg\",\"$cat_sort\",\"$cat_filter\")";
		$wpdb->query($sql);
		$cf = $wpdb->get_var("select max(cid) from $custom_post_meta_db_table_name");
	}
	
	$url = site_url().'/wp-admin/admin.php';
	echo '<form action="'.$url.'" method="get" id="frm_edit_custom_fields" name="frm_edit_custom_fields">
	<input type="hidden" value="custom" name="page"><input type="hidden" value="addedit" name="act"><input type="hidden" value="success" name="msg"><input type="hidden" value="'.$cf.'" name="cf">
	</form>
	<script>document.frm_edit_custom_fields.submit();</script>
	';exit;
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
<h2><?php
if($_REQUEST['cf'])
{
	 _e('Edit Custom Fields');	
}else
{
	 _e('Add Custom Fields');
}
?></h2>
<p>&nbsp;</p>
<?php
if($_REQUEST['msg']=='success')
{
	$message = __('Information Saved successfully.');	
}
?>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
  <p><?php _e($message);?> </p>
</div>
<br />
<?php }?>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=custom&act=addedit" method="post" name="custom_fields_frm">
<input type="hidden" name="save" value="1" />
<?php if($_REQUEST['cf']){?>
<input type="hidden" name="cf" value="<?php echo $_REQUEST['cf'];?>" />
<?php }?>
<table  class="widefat post fixed" style="width:50%;">
  <tr>
  <td width="30%"><strong><?php _e('Admin Title : ');?></strong></td>
  <td align="left"><input type="text" name="admin_title" id="admin_title" value="<?php echo $post_val->admin_title;?>" size="50" />
<br />  <span><?php _e('Personal comment, it would not be displayed anywhere except in Custom field settings');?></span>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('Frontend Title : ');?></strong></td>
  <td align="left"><input type="text" name="site_title" id="site_title" value="<?php echo $post_val->site_title;?>" size="50" />
<br />    <span><?php _e('Title which you wish to display in frontend');?></span>
  </td>
  </tr>
   <tr>
  <td ><strong><?php _e('Frontend Description : ');?></strong></td>
  <td align="left"><input type="text" name="admin_desc" id="admin_desc" value="<?php echo $post_val->admin_desc;?>" size="50" />
  <br />    <span><?php _e('Description which will appear in frontend');?></span>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('Type : ');?></strong></td>
  <td align="left">
   <select name="ctype" id="ctype" onchange="show_option_add(this.value)">
  <option value="text" <?php if($post_val->ctype=='text'){ echo 'selected="selected"';}?>><?php _e('Text');?></option>
  <option value="checkbox" <?php if($post_val->ctype=='checkbox'){ echo 'selected="selected"';}?>><?php _e('Checkbox');?></option>
<?php /*?>  <option value="radio" <?php if($post_val->ctype=='radio'){ echo 'selected="selected"';}?>><?php _e('Radio');?></option><?php */?>
  <option value="select" <?php if($post_val->ctype=='select'){ echo 'selected="selected"';}?>><?php _e('Select');?></option>
 <?php ?> <option value="multiselect" <?php if($post_val->ctype=='multiselect'){ echo 'selected="selected"';}?>><?php _e('Multiselect');?></option><?php ?>
  <option value="textarea" <?php if($post_val->ctype=='textarea'){ echo 'selected="selected"';}?>><?php _e('Textarea');?></option>
  <option value="link" <?php if($post_val->ctype=='link'){ echo 'selected="selected"';}?>><?php _e('Link(new window)');?></option>
  </select>
<br />    <span><?php _e('Select type');?></span>
  </td>
  </tr>
  <tr id="ctype_option_tr_id" style="display:none;">
  <td ><strong><?php _e('Option Values : ');?></strong></td>
  <td align="left"><input type="text" name="option_values" id="option_values" value="<?php echo $post_val->option_values;?>" size="50" />
   <br />    <span><?php _e('Option Values should be separated by comma.');?></span>
   <br />    <span><?php _e('If using for a "tick filter" place a / and then either a 1 for true or 0 for false');?></span>
   <br />    <span><?php _e('eg: "No Dogs Allowed/0,Dogs Allowed/1" (Select only, not multiselect)');?></span>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('HTML Variable Name : ');?></strong></td>
  <td align="left"><input type="text" name="htmlvar_name" id="htmlvar_name" value="<?php echo $post_val->htmlvar_name;?>" size="50" />
  <br />    <span><?php _e('This should be a unique name');?></span>
  </td>
  </tr>

  <tr>
  <td ><strong><?php _e('Admin Label : ');?></strong></td>
  <td align="left"><input type="text" name="clabels" id="clabels" value="<?php echo $post_val->clabels;?>" size="50" />
    <br />    <span><?php _e('Title which will appear in backend');?></span>
  </td>
  </tr>
   
  <tr>
  <td ><strong><?php _e('Default Value : ');?></strong></td>
  <td align="left"><input type="text" name="default_value" id="default_value" value="<?php echo $post_val->default_value;?>" size="50" />
    <br />    <span><?php _e('Enter the default value (for "link" this will be used as the link text)');?></span>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('Display Order : ');?></strong></td>
  <td align="left"><input type="text" name="sort_order" id="sort_order"  value="<?php echo $post_val->sort_order;?>" size="50" />
      <br />    <span><?php _e('Enter the display order of this field in backend. e.g. 5 ');?></span>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('Is Active : ');?></strong></td>
  <td align="left">
  <select name="is_active" id="is_active">
  <option value="1" <?php if($post_val->is_active=='1'){ echo 'selected="selected"';}?>><?php _e('Yes');?></option>
  <option value="0" <?php if($post_val->is_active=='0'){ echo 'selected="selected"';}?>><?php _e('No');?></option>
  </select>
      <br />    <span><?php _e('Select Yes or No. If NO is selected then the field will not be displayed anywhere');?></span>
 </td>
  </tr>
  <tr>
  <td ><strong><?php _e('Show On Listing Page ? : ');?></strong></td>
  <td align="left">
  <select name="show_on_listing" id="show_on_listing">
  <option value="1" <?php if($post_val->show_on_listing=='1'){ echo 'selected="selected"';}?>><?php _e('Yes');?></option>
  <option value="0" <?php if($post_val->show_on_listing=='0'){ echo 'selected="selected"';}?>><?php _e('No');?></option>
  </select>
      <br />    <span><?php _e('Want to show this on Listing page ?');?></span>
  </td>
  </tr>
  <tr>
  <td ><strong><?php _e('Show On Detail Page ? : ');?></strong></td>
  <td align="left">
  <select name="show_on_detail" id="show_on_detail">
  <option value="1" <?php if($post_val->show_on_detail=='1'){ echo 'selected="selected"';}?>><?php _e('Yes');?></option>
  <option value="0" <?php if($post_val->show_on_detail=='0'){ echo 'selected="selected"';}?>><?php _e('No');?></option>
  </select>
      <br />    <span><?php _e('Want to show this on Detail page ?');?></span>
  </td>
  </tr>
   <tr>
  <td ><strong><?php _e('Show Only on These Price Packages ? : ');?></strong></td>
  <td align="left">
  <select name="show_on_pkg[]" id="show_on_pkg" multiple="multiple" style="height: 100px;">
  <?php $priceinfo = get_price_info_select();
  if($post_val->extrafield1)
	   {
			$pricearr = explode(',',$post_val->extrafield1);   
	   }
  foreach($priceinfo as $priceinfoObj){?>	  
	    <option value="<?php echo $priceinfoObj->pid; ?>" <?php if (in_array($priceinfoObj->pid, $pricearr)){ echo 'selected="selected"';}?>><?php echo '#'.$priceinfoObj->pid.': '.$priceinfoObj->title;?></option>
		<?php }  ?>
  </select>
      <br />    <span><?php _e('Want to show only on these price packages ? (Select multiple price packages by holding down "Ctrl" key.)');?></span>
  </td>
  </tr>
   <tr>
  <td >&nbsp;</td>
  <td align="left"><h3><?php echo __('Advanced Category Sort Options'); ?></h3></td>
  </tr>
  <tr>
      <td><?php _e('Add Category Sort');?></td>
      <td>:
      <select name="cat_sort[]" multiple="multiple" id="select1" style="height: 100px;" >
      <option value=""><?php _e('Select Category');?></option>
       <?php $cat_info = get_category_all_array();
	   if($post_val->cat_sort)
	   {
			$catarr = explode(',',$post_val->cat_sort);   
	   }
	  for($i=0;$i<count($cat_info);$i++){?>
      <option value="<?php echo $cat_info[$i]['id'];?>" <?php if($catarr && in_array($cat_info[$i]['id'],$catarr)){ echo 'selected="selected"';}?> ><?php echo $cat_info[$i]['title'];?>
      <?php }?>
      </option>
      </select>
      </td>
     </tr>
     
       <tr>
      <td><?php _e('Add Category Tick Filter');?></td>
      <td>:
      <select name="cat_filter[]" multiple="multiple" id="select2" style="height: 100px;" >
      <option value=""><?php _e('Select Category');?></option>
       <?php $cat_info = get_category_all_array();
	   if($post_val->cat_filter)
	   {
			$catarr_filter = explode(',',$post_val->cat_filter);   
	   }
	  for($i=0;$i<count($cat_info);$i++){?>
      <option value="<?php echo $cat_info[$i]['id'];?>" <?php if($catarr_filter && in_array($cat_info[$i]['id'],$catarr_filter)){ echo 'selected="selected"';}?> ><?php echo $cat_info[$i]['title'];?>
      <?php }?>
      </option>
      </select>
      </td>
     </tr>
  
  
    <tr>
  <td >&nbsp;</td>
  <td align="left"><input type="submit" class="button" name="save" id="save" value="<?php _e('Save');?>" /> <a href="<?php echo site_url();?>/wp-admin/admin.php?page=custom"><input type="button" name="cancel" value="<?php _e('Cancel');?>" class="button_n" /></a></td>
  </tr>
</table>
</form>
<script type="text/javascript">
function show_option_add(htmltype)
{
	if(htmltype=='select' || htmltype=='multiselect')
	{
		document.getElementById('ctype_option_tr_id').style.display='';		
	}else
	{
		document.getElementById('ctype_option_tr_id').style.display='none';	
	}
}
if(document.getElementById('ctype').value)
{
	show_option_add(document.getElementById('ctype').value)	;
}
</script>