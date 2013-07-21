<?php
global $wpdb,$table_prefix;
$custom_post_meta_db_table_name = $table_prefix . "geotheme_custom_post_fields";
function get_post_custom_fields_templ($package_pid)
{
	global $wpdb,$custom_post_meta_db_table_name;
	$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where is_active=1 order by sort_order asc,admin_title asc");
	$return_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){
				$options = explode(',',$post_meta_info_obj->option_values);
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values"      => $post_meta_info_obj->option_values,
					"site_title"      => $post_meta_info_obj->site_title,
					);
			if($options)
			{
				$custom_fields["options"]=$options;
			}
			//echo $package_pid;
			$pricearr =array(); 
			$pricearr = explode(',',$post_meta_info_obj->extrafield1);  
			if (in_array($package_pid, $pricearr)){
			$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
			}
		}
	}
	return $return_arr;
}
//$custom_metaboxes = get_post_custom_fields_templ();

function get_post_custom_listing_single_page_preview($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_post_meta_db_table_name;
	$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}','{#HTMLVAR#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->ctype=='checkbox'){ $val_arr =  $post_meta_info_obj->default_value;}
			elseif($post_meta_info_obj->ctype=='multiselect'){ $val_arr =  implode(',',$_POST["$post_meta_info_obj->htmlvar_name"]);}
			else{$val_arr = $_POST["$post_meta_info_obj->htmlvar_name"]; }
			if($post_meta_info_obj->ctype=='select'){ $val_arr = str_replace(array('/1', '/0'), '', $val_arr);}
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
					
			}
			$replace_arr = array($post_meta_info_obj->site_title,$val_arr,$post_meta_info_obj->htmlvar_name);
			if($_POST["$post_meta_info_obj->htmlvar_name"])
			{
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}
		}	
	}
	
	return $return_str;
}

function get_post_custom_listing_single_page($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_post_meta_db_table_name;
	$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}','{#HTMLVAR#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->ctype=='checkbox'){ $val_arr =  $post_meta_info_obj->default_value;}
			elseif($post_meta_info_obj->ctype=='multiselect'){ $val_arr =  implode(',',get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));}
			elseif($post_meta_info_obj->ctype=='link'){ 
					if($post_meta_info_obj->default_value){$val_arr = '<a href="'.get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true).'" target="_blank">'.$post_meta_info_obj->default_value.'</a>';}
					else{$val_arr = '<a href="'.get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true).'" target="_blank">'.get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true).'</a>';}					
					}
			else{$val_arr = get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true);}
			if($post_meta_info_obj->ctype=='select'){ $val_arr = str_replace(array('/1', '/0'), '', $val_arr);}
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
					
			}
			$replace_arr = array($post_meta_info_obj->site_title,$val_arr,$post_meta_info_obj->htmlvar_name);
			if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
			{
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}
		}	
	}
	
	return $return_str;
}

function get_post_custom_for_listing_page($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_post_meta_db_table_name;
	$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_listing=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}','{#HTMLVAR#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->ctype=='checkbox'){ $val_arr =  $post_meta_info_obj->default_value;}
			elseif($post_meta_info_obj->ctype=='multiselect'){ $val_arr =  implode(',',get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));}
			elseif($post_meta_info_obj->ctype=='link'){ 
					if($post_meta_info_obj->default_value){$val_arr = '<a href="'.get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true).'" target="_blank">'.$post_meta_info_obj->default_value.'</a>';}
					else{$val_arr = '<a href="'.get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true).'" target="_blank">'.get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true).'</a>';}					
					}
			else{$val_arr = get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true);}
			if($post_meta_info_obj->ctype=='select'){ $val_arr = str_replace(array('/1', '/0'), '', $val_arr);}
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
			}
			$replace_arr = array($post_meta_info_obj->site_title,$val_arr,$post_meta_info_obj->htmlvar_name);
			if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
			{
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}
		}	
	}
	return $return_str;
}


######################## FUNCTION FOR API -VGET CUSTOM FIELDS #######################
function get_post_custom_fields_api($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_post_meta_db_table_name;
	$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}','{#HTMLVAR#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->ctype=='checkbox'){ $val_arr =  $post_meta_info_obj->default_value;}
			elseif($post_meta_info_obj->ctype=='multiselect'){ $val_arr =  implode(',',get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));}
			else{$val_arr = get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true);}
			if($post_meta_info_obj->ctype=='select'){ $val_arr = str_replace(array('/1', '/0'), '', $val_arr);}
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
					
			}
			$replace_arr = array($post_meta_info_obj->site_title,$val_arr,$post_meta_info_obj->htmlvar_name);
			if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
			{
				$return_str[] = str_replace($search_arr,$replace_arr,$paten_str);
			}
		}	
	}
	
	return $return_str;
}
?>