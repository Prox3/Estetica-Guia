<?php
if($_REQUEST['backandedit']){
$curImages = $_SESSION["file_info"];
$totImg = count(explode(",",$_SESSION["file_info"]));
}else
{
	$_SESSION["file_info"] = array();
	$curImages = implode(",",$thumb_img_arr);
	$totImg = count($thumb_img_arr);
}
?>
<script type="text/javascript">
jQuery.fn.exists = function () {
    return jQuery(this).length > 0;
}
jQuery(document).ready(function($) {
 
    if($(".plupload-upload-uic").exists()) {
        var pconfig=false;
        $(".plupload-upload-uic").each(function() {
            var $this=$(this);
            var id1=$this.attr("id");
            var imgId=id1.replace("plupload-upload-ui", "");
 
            plu_show_thumbs(imgId);
 
            pconfig=JSON.parse(JSON.stringify(base_plupload_config));
 
            pconfig["browse_button"] = imgId + pconfig["browse_button"];
            pconfig["container"] = imgId + pconfig["container"];
            pconfig["drop_element"] = imgId + pconfig["drop_element"];
            pconfig["file_data_name"] = imgId + pconfig["file_data_name"];
            pconfig["multipart_params"]["imgid"] = imgId;
            pconfig["multipart_params"]["_ajax_nonce"] = $this.find(".ajaxnonceplu").attr("id").replace("ajaxnonceplu", "");
 
            if($this.hasClass("plupload-upload-uic-multiple")) {
                pconfig["multi_selection"]=true;
            }
 
            if($this.find(".plupload-resize").exists()) {
                var w=parseInt($this.find(".plupload-width").attr("id").replace("plupload-width", ""));
                var h=parseInt($this.find(".plupload-height").attr("id").replace("plupload-height", ""));
                pconfig["resize"]={
                    width : w,
                    height : h,
                    quality : 90
                };
            }
 
            var uploader = new plupload.Uploader(pconfig);
 
            uploader.bind('Init', function(up){
 //alert(1);
                });
 
            uploader.init();
 
 
 
 			uploader.bind('Error', function(up, files){
			if(files.code == -600){	
			jQuery('#upload-error').addClass('upload-error');
			jQuery('#upload-error').html(files.message+ ' : You tried to upload a image over <?php echo gt_max_upload_size();?>');
			}
			else{
			jQuery('#upload-error').addClass('upload-error');
			jQuery('#upload-error').html(files.message);
			}
			});
			
            // a file was added in the queue
			totalImg = <?php if($totImg){echo $totImg;}else{echo 0;} ?>;
			limitImg = <?php if($image_limit){echo $image_limit;}else{echo '0';} ?>;
            uploader.bind('FilesAdded', function(up, files){
			jQuery('#upload-error').html('');
			jQuery('#upload-error').removeClass('upload-error');
			//totalImg = totalImg + up.files.length;
			
			if(limitImg){
				
				if(totalImg==limitImg){
				while(up.files.length > 0) {up.removeFile(up.files[0]);} // remove images
				jQuery('#upload-error').addClass('upload-error');
				jQuery('#upload-error').html('You have reached your upload limit of '+limitImg);
				return false;
				}
				
				if(up.files.length>limitImg){
				while(up.files.length > 0) {up.removeFile(up.files[0]);} // remove images
				jQuery('#upload-error').addClass('upload-error');
				jQuery('#upload-error').html('You may only upload '+limitImg+' with this package, please try again.');
				return false;
				}
				
				if(up.files.length+totalImg>limitImg){
				while(up.files.length > 0) {up.removeFile(up.files[0]);} // remove images
				jQuery('#upload-error').addClass('upload-error');
				jQuery('#upload-error').html('You may only upload another '+(limitImg-totalImg)+' with this package, please try again.');
				return false;
				}
				
				
				
				
			
			
			
			}
	
	
		 
                $.each(files, function(i, file) {
                    $this.find('.filelist').append(
                        '<div class="file" id="' + file.id + '"><b>' +
 
                        file.name + '</b> (<span>' + plupload.formatSize(0) + '</span>/' + plupload.formatSize(file.size) + ') ' +
                        '<div class="fileprogress"></div></div>');
                });
 
                up.refresh();
                up.start();
            });
 
            uploader.bind('UploadProgress', function(up, file) {
 
                $('#' + file.id + " .fileprogress").width(file.percent + "%");
                $('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
            });
 
            // a file was uploaded
            uploader.bind('FileUploaded', function(up, file, response) {
 
totalImg++;
up.removeFile(up.files[0]); // remove images

                $('#' + file.id).fadeOut();
                response=response["response"]
                // add url to the hidden field
                if($this.hasClass("plupload-upload-uic-multiple")) {
                    // multiple
                    var v1=$.trim($("#" + imgId).val());
                    if(v1) {
                        v1 = v1 + "," + response;
                    }
                    else {
                        v1 = response;
                    }
                    $("#" + imgId).val(v1);
                }
                else {
                    // single
                    $("#" + imgId).val(response + "");
                }
 
                // show thumbs 
                plu_show_thumbs(imgId);
            });
 
 
 
        });
    }
});
 
function plu_show_thumbs(imgId) {
    var $=jQuery;
    var thumbsC=$("#" + imgId + "plupload-thumbs");
    thumbsC.html("");
    // get urls
    var imagesS=$("#"+imgId).val();
    var images=imagesS.split(",");
    for(var i=0; i<images.length; i++) {
        if(images[i]) {
            var thumb=$('<div class="thumb" id="thumb' + imgId +  i + '"><img src="' + images[i] + '" alt="" /><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">Remove</a></div> <div class="clear"></div></div>');
            thumbsC.append(thumb);
            thumb.find("a").click(function() {
				totalImg--;// remove image from total
				jQuery('#upload-error').html('');
				jQuery('#upload-error').removeClass('upload-error');
                var ki=$(this).attr("id").replace("thumbremovelink" + imgId , "");
                ki=parseInt(ki);
                var kimages=[];
                imagesS=$("#"+imgId).val();
                images=imagesS.split(",");
                for(var j=0; j<images.length; j++) {
                    if(j != ki) {
                        kimages[kimages.length] = images[j];
                    }
                }
                $("#"+imgId).val(kimages.join());
                plu_show_thumbs(imgId);
                return false;
            });
        }
    }
    if(images.length > 1) {
        thumbsC.sortable({
            update: function(event, ui) {
                var kimages=[];
                thumbsC.find("img").each(function() {
                    kimages[kimages.length]=$(this).attr("src");
                    $("#"+imgId).val(kimages.join());
                    plu_show_thumbs(imgId);
                });
            }
        });
        thumbsC.disableSelection();
    }
}
</script>
<?php 

	

// adjust values here
$id = "file_info"; // this will be the name of form field. Image url(s) will be submitted in $_POST using this key. So if $id == “img1” then $_POST[“img1”] will have all the image urls
 
$svalue = $curImages; // this will be initial value of the above form field. Image urls.
 
$multiple = true; // allow multiple files upload
 
$width = 800; // If you want to automatically resize all uploaded images then provide width here (in pixels)
 
$height = 800; // If you want to automatically resize all uploaded images then provide height here (in pixels)
?>
 
<div class="form_row clearfix">
<label><?php echo PHOTOES_BUTTON;?></label>
<input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
<div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
    <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" />
    <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
    <?php if ($width && $height): ?>
            <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
            <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
    <?php endif; ?>
    <div class="filelist"></div>
</div>
<div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
</div>
<span id="upload-msg" ><?php _e('Please drag &amp; drop the images to rearrange the order');?></span>
<span id="upload-error" style="display:none"></span>
</div>

