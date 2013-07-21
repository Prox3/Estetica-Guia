<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php echo PASSWORD_PROTECTED; ?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->
<div id="comments_wrap">
<?php 
	global $post,$wpdb;
	$post_id = $post->ID;
	$pingback_count = $wpdb->get_var("SELECT COUNT( comment_ID ) AS ccount FROM $wpdb->posts LEFT JOIN $wpdb->comments ON ( comment_post_ID = ID AND comment_approved = '1' AND comment_type='pingback' )							WHERE post_status = 'publish' AND ID IN ($post_id)	GROUP BY ID");
	 if($pingback_count>0) : 
	?>
    	<h3 id="pings"><?php echo COMMENT_TRACKBACKS; ?></h3>
            <ol class="ping_commentlist">
 			    <?php wp_list_comments('type=pings'); ?>
            </ol>
    <?php  endif; ?>
<?php if ( have_comments() ) : ?>
 <?php global $is_place_post; if($is_place_post){ $comment_count_text = REVIEW_TEXT;}else{$comment_count_text = COMMENT_TEXT;}
 if($is_place_post){ $comment_count_text2 = REVIEW_TEXT2;}else{$comment_count_text2 = COMMENT_TEXT2;}
 ?>
	<h3>  <?php
	 comments_number('0 '.__('reviews'), '1 '.__('review'), '% '.__('reviews'));
	?>   </h3>
	<ol class="commentlist">
	    <?php wp_list_comments('avatar_size=48&callback=custom_comment'); ?>
	</ol>    
	<div class="navigation">
		<div class="fl"><?php previous_comments_link() ?></div>
		<div class="fr"><?php next_comments_link() ?></div>
		<div class="fix"></div>
	</div>
	<br />
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php echo COMMENTS_CLOSED; ?></p>
	<?php endif; ?>
<?php endif; ?>
</div> <!-- end #comments_wrap -->
<?php 
global $post,$wp_query;
$post = $wp_query->post;
$comment_add_flag =  is_user_can_add_comment($post->ID);
if($comment_add_flag)
{
	_e('<h6>Review has already been inserted from this machine. So no other reviews are allowed from this machine on this post.</h6>');	
}
?>
<?php if ('open' == $post->comment_status && !$comment_add_flag) : ?>
<div id="respond">
    <h3><?php global $is_place_post,$is_event_post;

	if($post->post_type=='events' || $post->post_type=='event')
	{
		$is_event_post=1;
	}
	if($is_place_post||$is_event_post){	echo COMMENTS_TITLE_PLACE;}else{echo COMMENTS_TITLE_BLOG;}	
	?> </h3>
    <?php  if ( !$user_ID ){do_action( 'social_connect_form' );} ?>
    <div class="cancel-comment-reply">
		<small><?php cancel_comment_reply_link(); ?></small>
	</div>
    <script type="text/javascript">
	jQuery(".comment-reply-link").click( function() {
               jQuery(".replyhide").hide();
	});
		jQuery("#cancel-comment-reply-link").click( function() {
               jQuery(".replyhide").show();
	});
	</script>
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
        <p><?php echo COMMENT_MUSTBE; ?> <a href="<?php echo site_url(); ?>/?ptype=login&page1=sign_in"><?php echo COMMENT_LOGGED_IN; ?></a> <?php echo COMMENT_POST_REVIEW; ?></p>
    <?php else : ?>	
        <form action="<?php echo site_url(); ?>/wp-comments-post.php" method="post" id="commentform">
         <?php global $is_place_post,$is_event_post,$current_user; if(($is_place_post||$is_event_post)&&get_option('ptthemes_disable_rating')=='' ){if($post->post_author == $current_user->data->ID && get_post_meta($post->ID,'claimed',true)==1){}else{ ?> 
         <p class="commpadd"> <span class="replyhide"><?php echo RATING_MSG;?>  <br /> <span class="comments_rating"> <?php require_once (TEMPLATEPATH . '/library/rating/get_rating.php');?> </span> </span></p>
         
		 <?php do_action('below_star_rating', $post->ID); ?>

		<?php	}}?>
        
         <p class="commpadd clearfix">
         <label for="comment"><small>
         <?php global $is_place_post; if($is_place_post || $post->post_type=='event'){ echo REVIEW_TEXT;}else{echo COMMENT_TEXT;}?>
		 </small></label>
        <textarea name="comment" id="comment" rows="10" cols="10" tabindex="4"></textarea></p>
        <?php if ( $user_ID ) : ?>
                <p><?php echo COMMENT_LOGGED_IN; ?> &rarr; <a href="<?php echo site_url(); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo home_url(); ?>/?ptype=login&action=logout" title="Log out of this account"><?php echo COMMENT_LOGOUT; ?> &raquo;</a></p>
             <?php else : ?>
            <div id="comment-user-details">
<?php do_action('alt_comment_login'); ?>
                <p class="commpadd clearfix">
                <label for="author"><small><?php echo COMMENT_NAME; ?> <?php if ($req) _e('*'); ?></small></label>
                <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" class="name" />
				 </p>
                <p class="commpadd clearfix">
                <label for="email"><small><?php echo COMMENT_EMAIL; ?> <?php if ($req) _e('*'); ?></small></label>
                <input type="text" name="email" id="email" value="<?php echo $comment_auth_email; ?>" size="22" tabindex="2" class="email" />
				 </p>
				<p class="commpadd clearfix">
                <label for="url"><small><?php echo COMMENT_WEBSITE; ?></small></label>
                <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" class="website" />
			    </p>
                </div>
            <?php endif; ?>
         <div class="aleft" ><input name="submit" type="submit" id="submit" tabindex="5" value="<?php global $is_place_post; if($is_place_post || $post->post_type=='event'){echo REVIEW_SUBMIT_BTN;}else{echo COMMENT_ADD_COMMENT;}?>" onclick="return comment_validate();" />
		    <?php comment_id_fields(); ?>
		</div>
        
		<?php do_action('comment_form', $post->ID); ?>
        </form>
    <?php endif; // If logged in ?>
    <div class="fix"></div>
</div> <!-- end #respond -->
<?php endif; // if you delete this the sky will fall on your head ?>

<script type="text/javascript">
/* <![CDATA[ */
function comment_validate()
{

<?php if(($is_place_post||$is_event_post)&&get_option('ptthemes_disable_rating')=='' ){ if($post->post_author == $current_user->data->ID && get_post_meta($post->ID,'claimed',true)==1){}else{?>
if(document.getElementById('post_<?php echo $post->ID; ?>_rating').value=='0' && document.getElementById('comment_parent').value=='0')
{
	alert('<?php _e('Please enter your star rating');?>');
	document.getElementById('post_<?php echo $post->ID; ?>_rating').focus();
	return false;
}
<?php }} ?>
<?php if ($req){ ?>	
if(document.getElementById('comment').value=='')
{
	alert('<?php _e('Please enter your reviews');?>');
	document.getElementById('comment').focus();
	return false;
}
if(document.getElementById('author').value=='')
{
	alert('<?php _e('Please enter Name');?>');
	document.getElementById('author').focus();
	return false;
}
if(document.getElementById('email').value=='')
{
	alert('<?php _e('Please enter Mail');?>');
	document.getElementById('email').focus();
	return false;
}else
{
	var a = document.getElementById('email').value;
	var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(filter.test(a)){
	}else
	{
		alert('<?php _e('Please enter valid Mail');?>');
		document.getElementById('email').focus();
		return false;	
	}
}
<?php }?>
return true;
}
/* ]]> */
</script>