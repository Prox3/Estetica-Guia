<?php
/*
Plugin Name: Most Popular Posts
Plugin URI: http://www.wesg.ca/2008/08/wordpress-widget-most-popular/
Description: Display a link to the most popular posts on your blog according to the number of comments.
Author: Wes Goodhoofd
Version: 1.4.1
Author URI: http://www.wesg.ca
*/

add_action("plugins_loaded", "init_popular");

function most_popular($arg) {
	global $wpdb;

	if ($arg == 1)
		$list = true;
	else
		$list = false;

$options = get_option("widget_mostpopular");
if (!is_array( $options ))
	{
		$options = array(
      'number' => '5', 'comment' => 'checked', 'title' => 'Most Popular Posts', 'only' => '1', 'exclude' => '1', 'zero' => 'checked', 'onlycheck' => 'checked', 'excludecheck' => 'checked'
      );
  }    

//check if zero comments are needed
if ($options['zero'] != 'checked')
	$zero = '&& comment_count > 0';

//get the post data from the database
if (($options['excludecheck'] == 'checked') && ($options['onlycheck'] == 'checked'))
	$posts = $wpdb->get_results("SELECT ID, post_title, comment_count FROM " . $wpdb->posts . " WHERE post_type = 'post' && post_status = 'publish' " . $zero . " ORDER BY comment_count DESC LIMIT " . $options['number'] . "");
else if (($options['excludecheck'] != 'checked') && ($options['onlycheck'] == 'checked')) {

	$query = 'SELECT DISTINCT p.ID, p.post_title, p.comment_count '
. 'FROM ' . $wpdb->posts . ' AS p '
. 'WHERE post_type=\'post\' AND post_status=\'publish\' AND p.ID NOT IN '
. ' (SELECT tr.object_id '
. ' FROM ' . $wpdb->term_relationships . ' AS tr INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON tr.term_taxonomy_id=tt.term_taxonomy_id '
. ' WHERE tt.term_id=' . $options['exclude'] . ') '
. 'ORDER BY p.comment_count DESC '
. 'LIMIT ' . $options['number'];
$posts = $wpdb->get_results($query); 
}
else if (($options['excludecheck'] == 'checked') && ($options['onlycheck'] != 'checked')) {

	//find terms that fit properly
	$taxonomy = $wpdb->get_var('SELECT term_taxonomy_id FROM ' . $wpdb->term_taxonomy . ' WHERE term_id = ' . $options['only']);
	//download database to cross check for categories
	$categories = $wpdb->get_results("SELECT object_id, term_taxonomy_id FROM " . $wpdb->term_relationships . " WHERE term_taxonomy_id = " . $taxonomy); 
	$post_download = $wpdb->get_results("SELECT ID, post_title, comment_count FROM " . $wpdb->posts . " WHERE post_type = 'post' && post_status = 'publish' " . $zero . " ORDER BY comment_count DESC");

	//check for conditions that exclude posts
	$i=0;
	$check = array();
	foreach ($post_download as $links) {
		foreach ($categories as $cats) {
		if (($cats->object_id == $links->ID) && ($i < $options['number']) && (!in_array($links->ID, $check))) {
			$posts[$i]->ID = $links->ID;
			$posts[$i]->post_title = $links->post_title;
			$posts[$i++]->comment_count = $links->comment_count;
			$check[] = $links->ID;
		} }
	}
}

//determine if used as a sidebar or function
if ($list == false)
	echo '<li class="widget widget_pages">';
?>


 

<?php  ?> 

<li>
<?php
//display each page as a link
global $thumb_url;
foreach ($posts as $links) {
	if ($options['comment'] == 'checked')
	
	echo  get_post_image (get_the_id(), '', '', '' .get_bloginfo('template_url') .'/thumb.php?zc=1&amp;w=62&amp;h=50&amp;src='.$thumb_url) ;
 
	echo '<p><a href="' . get_permalink($links->ID) . '   "> '  . $links->post_title . sadsad . ' </a>' . $comments .  ' </p> </li>' . "\n";
		

               
               	}
?>	

 
<?php
if ($list == false)
	echo '</li>';
?>

<?php
}

function init_popular(){
	//initialize the widget
    register_sidebar_widget("Most Popular Posts", "most_popular");     
	register_widget_control('Most Popular Posts', 'mostpopular_control', 200, 300 );
}

function mostpopular_control() {
	//load translations
//load_plugin_textdomain('most_popular_posts', "wp-content/plugins/most-popular-posts/");

	//update_option("widget_mostpopular-number", "5");
	$options = get_option("widget_mostpopular");

//if option is missing, insert defaults
if (!is_array( $options ))
	{
		$options = array(
      'number' => '5', 'comment' => 'checked', 'title' => 'Most Popular Posts', 'only' => '1', 'exclude' => '1', 'zero' => 'checked', 'onlycheck' => 'checked', 'excludecheck' => 'checked'
      );
  }    

//submit new data
if ($_POST['mostpopular-Submit'])
  {
	$options['title'] = htmlspecialchars($_POST['mostpopular-title']);
    $options['number'] = htmlspecialchars($_POST['mostpopular-number']);
	$options['comment'] = htmlspecialchars($_POST['mostpopular-comment']);
	$options['only'] = htmlspecialchars($_POST['mostpopular-only']);
	$options['exclude'] = htmlspecialchars($_POST['mostpopular-exclude']);
	$options['zero'] = htmlspecialchars($_POST['mostpopular-zero']);
	$options['excludecheck'] = htmlspecialchars($_POST['mostpopular-excludecheck']);
	$options['onlycheck'] = htmlspecialchars($_POST['mostpopular-onlycheck']);
	
    update_option("widget_mostpopular", $options);
  }
//create widget configuration panel
?>
	<p>
    <label for="mostpopular-title"><?php _e('Title: '); ?> </label>
    <input type="text" id="mostpopular-title" name="mostpopular-title" value="<?php echo $options['title'];?>" />
  </p>

	<p>
    <label for="mostpopular-number"><?php _e('Number of posts to display: '); ?></label>
    <input type="text" id="mostpopular-number" name="mostpopular-number" value="<?php echo $options['number'];?>" size="5" />
  </p>

<p>
	 <input type="checkbox" id="mostpopular-comment" name="mostpopular-comment" value="checked" <?php echo $options['comment'];?> />
    <label for="mostpopular-comment"><?php _e('Show comment count '); ?></label>
</p>

<p>
	 <input type="checkbox" id="mostpopular-zero" name="mostpopular-zero" value="checked" <?php echo $options['zero'];?> />
    <label for="mostpopular-zero"><?php _e('Include zero comment posts '); ?></label>

	<input type="hidden" id="mostpopular-Submit" name="mostpopular-Submit" value="1" />
  </p>

<p><?php _e('If both of the following options are enabled, the <em>only category</em> option is respected.'); ?></p>

<p> <input type="checkbox" id="mostpopular-onlycheck" name="mostpopular-onlycheck" value="checked" <?php echo $options['onlycheck'];?> />
    <label for="mostpopular-onlycheck"><?php _e('Show comments from all categories '); ?></label></p>

<p>
	<?php wp_dropdown_categories('hierarchical=1&selected=' . $options['only'] . '&orderby=name&name=mostpopular-only'); ?><br />
	<label for="only"><?php _e('Only show posts in this category.'); ?></label>
</p>

<p> <input type="checkbox" id="mostpopular-excludecheck" name="mostpopular-excludecheck" value="checked" <?php echo $options['excludecheck'];?> />
    <label for="mostpopular-excludecheck"><?php _e('Exclude posts from no categories '); ?></label></p>

<p>
	<?php wp_dropdown_categories('hierarchical=1&selected=' . $options['exclude'] . '&orderby=name&name=mostpopular-exclude'); ?><br />
	<label for="exclude"><?php _e('Exclude posts in this category.'); ?></label>
</p>

<?php
	}
?>