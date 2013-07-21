<?php
global $wpdb;
$blog_cat = get_option('ptthemes_blogcategory');
if(is_array($blog_cat) && $blog_cat[0]!='')
{
	$blog_cat = get_blog_sub_cats_str($type='string');
}else
{
	$blog_cat = '';	
}
if($blog_cat)
{
	$blog_cat .= ",1";
}else
{
	$blog_cat .= "1";
}
global $price_db_table_name;
$package_cats = $wpdb->get_var("select group_concat(cat) from $price_db_table_name where cat>0 and amount>0");
if($package_cats)
{
	if($blog_cat){
	$blog_cat .= ",".$package_cats;
	}else
	{
	$blog_cat .= $package_cats;
	}
}
if($blog_cat)
{
	$substr = " and c.term_id not in ($blog_cat)";	
}
$catsql = "select c.term_id, c.name from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy='category' $substr order by c.name";
$catinfo = $wpdb->get_results($catsql);
global $cat_array;
if($catinfo)
{
	$cat_display=get_option('ptthemes_category_dislay');
	if($cat_display==''){$cat_display='checkbox';}
	$counter = 0;
	if($cat_display=='select'){?>
	<div class="form_cat" >
    <select name="category[]" id="category_<?php echo $counter;?>" class="textfield" >
	<?php }
	foreach($catinfo as $catinfo_obj)
	{
		$counter++;
		$termid = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		if($cat_display=='checkbox'){
		?>
        <div class="form_cat" ><label><input type="checkbox" name="category[]" id="category_<?php echo $counter;?>" value="<?php echo $termid; ?>" class="checkbox" <?php if(isset($cat_array) && in_array($termid,$cat_array)){echo 'checked="checked"'; }?> />&nbsp;<?php echo $name; ?></label></div>
		<?php
		}elseif($cat_display=='radio')
		{
		?>
        <div class="form_cat" ><label><input type="radio" name="category[]" id="category_<?php echo $counter;?>" value="<?php echo $termid; ?>" class="checkbox" <?php if(isset($cat_array) && in_array($termid,$cat_array)){echo 'checked="checked"'; }?> />&nbsp;<?php echo $name; ?></label></div>
		<?php
		}elseif($cat_display=='select')
		{
		?>
        <option <?php if(isset($cat_array) && in_array($termid,$cat_array)){echo 'selected="selected"'; }?> value="<?php echo $termid; ?>"><?php echo $name; ?></option>
       <?php
		}
	}
	if($cat_display=='select'){?>
	 </select></div>
	<?php }
}
?>