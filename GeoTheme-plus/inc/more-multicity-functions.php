<?php
function get_area_selector_options($selected='',$default_option='',$att='', $city_id, $sortby='')
{
	$category = $_GET['placecategory'];
	global $wpdb, $multihood_db_table_name;
	/*$hood_info = $wpdb->get_results("select hood_id,hoodname from $multihood_db_table_name where cities = $city_id  order by $sortby, sortorder asc, is_default desc");*/
	$hood_info = $wpdb->get_results("
	select hood_id,hoodname 
	from $multihood_db_table_name 
	where cities = $city_id AND `hood_id` 
	IN(
		SELECT DISTINCT meta.meta_value FROM wp_postmeta meta 
			INNER JOIN wp_term_relationships ON wp_term_relationships.object_id = meta.post_id 
			INNER JOIN wp_term_taxonomy ON wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id 
			INNER JOIN wp_terms ON wp_terms.term_id = wp_term_taxonomy.term_id AND wp_terms.slug= '".$category."' 
			INNER JOIN `wp_posts` post ON post.ID= meta.post_id AND post.post_type='place'
			WHERE meta.meta_key = 'post_hood_id'
	)
	order by $sortby, sortorder asc, is_default desc");
	$return_str = '';
//echo '<!-- select SQL="'."select hood_id,hoodname from $multihood_db_table_name where cities = $city_id  order by $sortby, sortorder asc, is_default desc".'"'.PHP_EOL.'city_id='.$city_id.PHP_EOL.'hood_info="'; print_r($hood_info); echo '" -->'.PHP_EOL;
	if($hood_info)
	{ 	$return_str .= '<option value="" >'.__('Selecione').'</option>';

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
	}else{$return_str .= '<option value="" >'.__('Nenhum Bairro').'</option>';}
	return $return_str;
}
?>