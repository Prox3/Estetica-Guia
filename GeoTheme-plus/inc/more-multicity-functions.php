<?php
function get_area_selector_options($selected='',$default_option='',$att='', $city_id, $sortby='')
{
	global $wpdb, $multihood_db_table_name;
	$hood_info = $wpdb->get_results("select hood_id,hoodname from $multihood_db_table_name where cities = $city_id  order by $sortby, sortorder asc, is_default desc");
	$return_str = '';
//echo '<!-- select SQL="'."select hood_id,hoodname from $multihood_db_table_name where cities = $city_id  order by $sortby, sortorder asc, is_default desc".'"'.PHP_EOL.'city_id='.$city_id.PHP_EOL.'hood_info="'; print_r($hood_info); echo '" -->'.PHP_EOL;
	if($hood_info)
	{ 	$return_str .= '<option value="" >'.__('Select Neighbourhood').'</option>';

		foreach($hood_info as $hood)
		{ if($hood){
			$return_str .= '<option ';
			if($selected==$hood->hoodname)
			{
				$return_str .= ' selected="selected" ';		
			}
			$return_str .= $att.'>';
			$return_str .= $hood->hoodname.'</option>';
		}
		}
	}else{$return_str .= '<option value="" >'.__('No Neighbourhoods').'</option>';}
	return $return_str;
}
?>