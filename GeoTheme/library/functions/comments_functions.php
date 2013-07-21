<?php
/*
URI: http://wphacks.com/log/how-to-add-spam-and-delete-buttons-to-your-blog/
*/ 
global $post;
function delete_comment_link($id) {
    if (current_user_can('edit_post')) {
        echo '&nbsp;-&nbsp; <a href="'.admin_url("comment.php?action=cdc&amp;c=$id").'">'.COMMENT_DELETE_NAME.'</a> ';
        echo '&nbsp;-&nbsp; <a href="'.admin_url("comment.php?action=cdc&amp;dt=spam&amp;c=$id").'">'.COMMENT_SPAM_NAME.'</a>';
    }
}

// Use legacy comments on versions before WP 2.7
add_filter('comments_template', 'old_comments');

function old_comments($file) {

	if(!function_exists('wp_list_comments')) : // WP 2.7-only check
		$file = TEMPLATEPATH . '/comments-old.php';
	endif;

	return $file;
}


// Custom comment loop
function custom_comment($comment, $args, $depth) {	

       $GLOBALS['comment'] = $comment; global $post,$author_role,$is_owned; $post_id = get_post();
	   global $wpdb, $post;

$user = new WP_User( $comment->user_id );
$author_role = $user->roles[0];
$is_owned = get_post_meta($post->ID,'claimed',true);

  
	   ?>
	

<li class="comment wrap threaded hreview" id="comment-<?php comment_ID() ?>">
    <div class="meta-left">
        <div class="meta-wrap">
        <span class="gravatar_bg"> </span>
            <?php 
			if($comment->user_id){echo get_avatar( $comment->user_id, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar.png' );} 
			elseif($comment->comment_author_email){echo get_avatar( $comment->comment_author_email, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar.png' );} 
			?> 
        </div>
    </div>
    <div class="text-right <?php if ($author_role =='administrator'){ echo "admin_comment ";} if ($post_id->post_author == $comment->user_id && $author_role =='author' && $is_owned!='0'){ echo "author_comment";} ?>">
        <p class="authorcomment "> <span class="fl" > <span class="reviewer"><?php  if($comment->user_id){echo '<a href="'.get_author_posts_url($comment->user_id).'" class="url">'.$comment->comment_author.'</a>';}else{comment_author_link();} echo'</span>'; global $is_place_post; if($is_place_post || $post->post_type=='event'){ if ($post_id->post_author == $comment->user_id && $author_role =='author' && $is_owned!='0'){ echo '<span class="owner_comment" > - '.OWNER_TEXT.'</span>';}elseif ($author_role =='administrator'){ echo '<span class="owner_comment" > - '.SITE_ADMIN.'</span>';} }?>,  
               <small><span class="dtreviewed"><?php if(!function_exists('how_long_ago')){comment_date('M d, Y'); } else { echo get_comment_time('M d, Y'); } ?></span></small> - </span> 
               
               <span class="item">
      <span class="fn"> <?php the_title(); ?></span>
   				</span>
               
               
<?php global $is_place_post,$is_event_post,$current_user; if(($is_place_post||$is_event_post)&&get_option('ptthemes_disable_rating')==''){if($post_id->post_author == $comment->user_id && $is_owned=='1'){}else{?> 
<br />
                <span class="comm-reply-rating"><?php echo get_comment_rating_star($comment->comment_ID);?></span>
                
                <?php if(get_comment_rating_num($comment->comment_ID)!=0){ echo '<span class="rating">'.get_comment_rating_num($comment->comment_ID).'</span>/5'; } ?>
                <?php }} ?>
                </p>
             <div class="description"><?php comment_text() ?></div>  
        <?php if ($comment->comment_approved == '0') : ?>
        <p><em><?php echo COMMENT_MODERATION; ?></em></p>
        <?php endif; ?>
    </div>
    <span class="comm-reply">		
    <span class="fr" >&nbsp;&nbsp; - &nbsp; 
	
	<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	
	<?php /*?><?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'reply_text' => __(''.COMMENT_REPLY_NAME.''), 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?> <?php */?></span> 
    <?php //edit_comment_link(''.COMMENT_EDIT_NAME.'', '&nbsp;&nbsp;&nbsp;', ''); ?>
    <?php //delete_comment_link(get_comment_ID()); ?>
    </span>
    <div class="clearfix"></div>
<?php } ?>